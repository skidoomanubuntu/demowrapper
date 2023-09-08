from bs4 import BeautifulSoup
import shutil, subprocess, os, requests, bz2, time

# This updates files if necessary
def updateFiles(version):
	def downloadFile(url, file):
		# Can I download it?
		try:
			response = requests.get(url)
			if os.path.isfile(file):
				os.remove(file)
			print ("file %s retrieved" % url)
			open("%s" % file, 'wb').write(bz2.decompress(response.content))
			if not os.path.isfile(file):
				return False
			return True
		except Exception as e:
			print (e)
			return False


	def getFile(filename):
		# Is the file present?
		if (os.path.isfile(filename)):
			# Has it been updated within the last 24 hours?
			if (time.time() - os.path.getmtime(filename) < 86400):
				print ("%s exists and has been updated during last 24 hours" % filename)
				return True
			else:
				if not downloadFile('https://security-metadata.canonical.com/oval/%s.bz2' % filename, filename):
					print ("%s could not be retrieved, but there is an old copy locally, analysis will still proceed" % filename)
		else:
			if not downloadFile('https://security-metadata.canonical.com/oval/%s' % filename, filename):
				print ("%s could not be retrieved, and there is no local copy, analysis will stop" % filename)
				return False
		return True
				
	# We have two files to update
	# oci.com.ubuntu.[version].pkg.oval.xml
	# oci.com.ubuntu.[version].usn.oval.xml
	pkgFile = "oci.com.ubuntu.%s.pkg.oval.xml" % version
	usnFile = "oci.com.ubuntu.%s.usn.oval.xml" % version
	return (getFile(pkgFile) and getFile(usnFile)) 

# Analyze the output from command
# oscap oval eval --results report.xml oci.com.ubuntu.[version].usn.oval.xml
# in presence of the proper manifest file
def analyzeOscapOciReport(filename):
	usnMap = {}
	resultMap = {}
	xmlFile = open(filename, 'r')
	contents = xmlFile.read()
	soup = BeautifulSoup(contents, 'xml')
	results = soup.find('results')
	definitions = soup.find('definitions')
	defs = definitions.find_all('definition')

	resultDefs = results.find_all('definition')
	for result in resultDefs:
		resultMap[result['definition_id']] = result['result']

	for definition in defs:
		title = definition.find('title').text
		parts = title.split(' -- ')
		severity = definition.find('severity').text
		cves = []
		for cve in definition.find_all('cve'):
			cves.append(cve.text)
		usnMap[parts[0]]= {'id':definition['id'], 
			'result': resultMap[definition['id']],
			'severity': severity, 'cve':cves}

	return usnMap


# This function takes the dictionary we generated from an oscap report
# and then compiles the stats according to severity
def generateData(dict):
	results = { 'Critical': {'fixed':0, 'present':0},
			'High': {'fixed':0, 'present':0},
			'Medium': {'fixed':0, 'present':0},
			'Low': {'fixed':0, 'present': 0},
			'Other': {'fixed':0, 'present': 0} }
	for data in dict.values():
		key = 'Other'
		if data['severity'] in results.keys():
			key = data['severity']
		if data['result'] == 'true':
			results[key]['present'] += 1
		else:
			results[key]['fixed'] +=1
	#print (results)
	return results

# This function takes all the individual oscap dictionaries and ensures that all the usn entries
# are compressed to one, independently of the kernel they compare to
# We want to keep only one USN entry
def getTotals(dicts):
	total = {}
	for dict in dicts.values():
		for usn in dict.keys():
			if usn in total.keys():
				# Duplicate, do we need to update the values? Do so only if result==true
				# This way, if some of these entries are fixed and others not, we want to be
				# biased toward "not fixed"
				if dict[usn]['result'] == 'true':
					total[usn] = dict[usn]
			else:
				total[usn] = dict[usn]
	return total

# This function generates an HTML report that is essentially a table
# showing the vulnerabilities + fixed metrics
def generateUSNStats(dicts, filename, totals):
	def printResultLine(dict):
		myString = ""
		for key in dict.keys():
			total = int(dict[key]['fixed']) + int(dict[key]['present'])
			fixed = int(dict[key]['fixed'])
			percentage = 0
			try:
				percentage = '%.1f%%' % (100 * fixed/total)
			except ZeroDivisionError:
				percentage = '-'
			myString += "<td><font color='grey'><b>%s</b></font><br>%s fixed (%s)</td>" % (total, fixed, percentage)
		return myString

	with open(filename, 'w') as htmlFile:
		htmlFile.write('<table border="0" width="100%" padding="3" spacing="10">\n')
		htmlFile.write('   <tr>\n')
		htmlFile.write("       <th style='background-color: #111;' width='100%' colspan='6'><h2>USN on the system & fixes</h2></th>\n")
		htmlFile.write('   </tr><tr>\n')
		htmlFile.write('      <th>Source</th><th>Critical</th><th>High</th><th>Medium</th><th>Low</th><th>Other</th>\n')
		htmlFile.write('   </tr><tr>\n')
		htmlFile.write('      <td><b>Total</b></td>%s\n' % printResultLine(totals))
		htmlFile.write('   </tr>\n')
		for version in dicts.keys():
			htmlFile.write('   <tr>\n')
			htmlFile.write('      <td><b>%s</b></td>%s\n' % (version, printResultLine(dicts[version])))
			htmlFile.write('   </tr>\n')
		htmlFile.write('</table>')

'''# This takes an OCI PCK file and returns a dictionary as follows:
# Package -> {{usn->[cve]}, component}
def analyzePkgFile(filename):
	# At this point in time, the file manifest should be relative to the version we selected
	# This file lists all packages used (last column)
	# We need that info to limit the size of our pkgMap to what is relevant to us
	relevantPkg = []
	with open('manifest', 'r') as manifestFile:
		lines = manifestFile.readlines()
		for line in lines:
			columns = line.replace('\n','').split(' ')
			relevantPkg.append(columns[0])
	pkgMap = {}
	xmlFile = open(filename, 'r')
	contents = xmlFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definitions')
	for definition in definitions:
		package = definition.find('title').text
		if not package in relevantPkg:
			continue
		component = definition.find('component').text
		usn = {}
		for cve in definition.find_all('cve'):
			if 'usns' in cve.attrs.keys():
				for usnEntry in cve['usns'].replace(' ','').split(','):
					if usnEntry in usn.keys():
						usn[usnEntry].append(cve.text)
					else:
						usn[usnEntry] = [cve.text]

		pkgMap[package] = {'usn':usn, 'component':component}

	return pkgMap

# This takes a pkg file and turns it into the following dict:
# usn -> component
def analyzePkgFileFromUsn(filename):	
	pkgMap = {}
	xmlFile = open(filename, 'r')
	contents = xmlFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definitions')
	for definition in definitions:
		package = definition.find('title').text
		component = definition.find('component').text
		for cve in definition.find_all('cve'):
			if 'usns' in cve.attrs.keys():
				for usnEntry in cve['usns'].replace(' ','').split(','):
					if usnEntry in pkgMap.keys() and pkgMap[usnEntry] != component:
						print ('%s is affecting two components: %s, %s' % (usnEntry, pkgMap[usnEntry], component))
					else:
						pkgMap[usnEntry] = component

	return pkgMap


# This takes a pkg file and turns it into the following dict:
# cve -> [{package, [component]}]
def analyzeComponents(filename):	
	cveMap = {}
	xmlFile = open(filename, 'r')
	contents = xmlFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definitions')
	for definition in definitions:
		package = definition.find('title').text
		component = definition.find('component').text
		for cve in definition.find_all('cve'):
			if cve.text in cveMap.keys():
				found = False
				for entry in cveMap[cve.text]:
					if entry['package'] == package:
						if not component in entry['component']:
							entry['component'].append(component)
						found = True
						break
				if not found:
					cveMap[cve.text].append({'package':package, 'component':[component]})
			else:
				cveMap[cve.text] = [{'package':package, 'component':[component]}]

	return cveMap

# This cross-references two maps to associate fixes and components:
def crossReferenceUsnComponents(oscap, pkg):
	resultMap = {'main':{'fixed':0, 'present':0}, 
			'universe':{'fixed':0, 'present':0}, 
			'multiverse':{'fixed':0, 'present':0},
			'other':{'fixed':0, 'present':0}}

	for entry in oscap.keys():
		# Entry is USN- prefixed. Our pkg file does not have this prefix
		# Adjust
		entry = entry[4:]
		if not entry in pkg.keys():
			print ("%s could not be found in pkg map" % entry)
		else:
			dict = None
			if pkg[entry] == 'main':
				dict = resultMap['main']
			elif pkg[entry] == 'universe':
				dict = resultMap['universe']
			elif pkg[entry] == 'multiverse':
				dict = resultMap['multiverse']
			else:
				dict = resultMap['other']
			if oscap['USN-%s' % entry]['result'] == 'true':
				dict['present'] += 1
			else:
				dict['fixed'] += 1
	return resultMap

# This cross-references two maps to associate fixes and components:
def crossReferenceComponents(oscap, pkg):
	resultMap = {'main':{'fixed':0, 'present':0}, 
			'universe':{'fixed':0, 'present':0}, 
			'multiverse':{'fixed':0, 'present':0},
			'other':{'fixed':0, 'present':0}}

	# Interim map: cve-> {component-> result}
	interimMap = {}

	for entry in oscap.values():
		result = entry['result']
		for cve in entry['cve']:
			if not cve in pkg.keys():
				#print ("ERROR: %s not found in pkg keys" % (cve))
				# Shove them straight to Others
				if result == 'true':
					resultMap['other']['fixed'] += 1
				else:
					resultMap['other']['fixed'] += 1
				continue
			# If 1 result is true, then bug is still present
			if cve in interimMap.keys():
				for package in pkg[cve]:
					for component in package['component']:
						if component in interimMap[cve].keys():
							if result == 'true':
								interimMap[cve][component] = True
							else:
								pass # Should ensure 1 CVE answer, and True by default
						else:
							# New component
							if result == 'true':
								interimMap[cve][component] = True
							else:
								interimMap[cve][component] = False
			else:
				# New CVE
				interimMap[cve] = {}
				for package in pkg[cve]:
					for component in package['component']:
						if result == 'true':
							interimMap[cve][component] = True
						else:
							interimMap[cve][component] = False
		
	# Now that we have an interim map, score the results
	for entry in interimMap.values():
		for component in entry.keys():
			if entry[component]:
				resultMap[component]['present'] += 1
			else:
				resultMap[component]['fixed'] += 1

	return resultMap
'''

versions = {'core18':'bionic', 'core20':'focal', 'core22':'jammy', 'snapd':'xenial', 'pc-kernel': 'jammy'}
maps = {}
results = {}
components = {}
for version in versions.keys():
	# Ensure we have the files we need
	if not updateFiles(versions[version]):
		print ("Could not update files for version %s, analysis for this version will be skipped" % version)
		continue

	# First, make sure that the right manifest file gets copied as manifest
	shutil.copy('manifest.%s' % version, 'manifest')
	
	# Run the oscap tool
	subprocess.run(['oscap', 'oval', 'eval', '--results', 'report_%s.xml' % version, 'oci.com.ubuntu.%s.usn.oval.xml' % versions[version]])	

	# You should now have a report_[version].xml report to send for analysis
	if os.path.exists('report_%s.xml' % version):
		maps[version] = analyzeOscapOciReport('report_%s.xml' % version)
		results[version] = generateData(maps[version])
		''' Reactivate when (if) we can (or should) resume work on components (main, universe, etc).
		Code works but doesn't tell us something particularly helpful - probably the wrong analysis
		components[version] = crossReferenceComponents(maps[version], analyzeComponents('oci.com.ubuntu.%s.pkg.oval.xml' % versions[version]))
		print (components[version])'''
		

		#componentsMap = crossReferenceUsnComponents(maps[version], analyzePkgFileFromUsn('oci.com.ubuntu.%s.pkg.oval.xml' % versions[version]))
		#print (componentsMap)
	else:
		print ('File report_%s.xml was not created by the oscap tool, analysis incomplete')
		break

# Generate totals
totals = generateData(getTotals(maps))
generateUSNStats(results, 'usn_stats.php', totals)
#for entry in components.keys():
#	print ("%s: %s" % (entry, components[entry]))
