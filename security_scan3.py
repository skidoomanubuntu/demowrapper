from bs4 import BeautifulSoup
import shutil, subprocess, os

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
		usnMap[parts[0]]= {'id':definition['id'], 
			'result': resultMap[definition['id']],
			'severity': severity}

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

# This function generates an HTML report that is essentially a table
# showing the vulnerabilities + fixed metrics
def generateUSNStats(dicts, filename):
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

	total = { 'Critical': {'fixed':0, 'present':0},
			'High': {'fixed':0, 'present':0},
			'Medium': {'fixed':0, 'present':0},
			'Low': {'fixed':0, 'present': 0},
			'Other': {'fixed':0, 'present': 0} }

	for data in dicts.values():
		total['Critical']['fixed'] += data['Critical']['fixed']
		total['Critical']['present'] += data['Critical']['present']
		total['High']['fixed'] += data['High']['fixed']
		total['High']['present'] += data['High']['present']
		total['Medium']['fixed'] += data['Medium']['fixed']
		total['Medium']['present'] += data['Medium']['present']
		total['Low']['fixed'] += data['Low']['fixed']
		total['Low']['present'] += data['Low']['present']
		total['Other']['fixed'] += data['Other']['fixed']
		total['Other']['present'] += data['Other']['present']

	with open(filename, 'w') as htmlFile:
		htmlFile.write('<table border="0" width="100%" padding="3" spacing="10">\n')
		htmlFile.write('   <tr>\n')
		htmlFile.write("       <th style='background-color: #111;' width='100%' colspan='6'><h2>USN on the system & fixes</h2></th>\n")
		htmlFile.write('   </tr><tr>\n')
		htmlFile.write('      <th>Source</th><th>Critical</th><th>High</th><th>Medium</th><th>Low</th><th>Other</th>\n')
		htmlFile.write('   </tr><tr>\n')
		htmlFile.write('      <td><b>Total</b></td>%s\n' % printResultLine(total))
		htmlFile.write('   </tr>\n')
		for version in dicts.keys():
			htmlFile.write('   <tr>\n')
			htmlFile.write('      <td><b>%s</b></td>%s\n' % (version, printResultLine(dicts[version])))
			htmlFile.write('   </tr>\n')
		htmlFile.write('</table>')

versions = {'core18':'bionic', 'core20':'focal', 'core22':'jammy', 'snapd':'xenial', 'pc-kernel': 'jammy'}
maps = {}
results = {}
for version in versions.keys():
	# First, make sure that the right manifest file gets copied as manifest
	shutil.copy('manifest.%s' % version, 'manifest')

	# Run the oscap tool
	subprocess.run(['oscap', 'oval', 'eval', '--results', 'report_%s.xml' % version, 'oci.com.ubuntu.%s.usn.oval.xml' % versions[version]])	

	# You should now have a report_[version].xml report to send for analysis
	if os.path.exists('report_%s.xml' % version):
		maps[version] = analyzeOscapOciReport('report_%s.xml' % version)
		results[version] = generateData(maps[version])
	else:
		print ('File report_%s.xml was not created by the oscap tool, analysis incomplete')
		break

generateUSNStats(results, 'usn_stats.php')
#print (results)
#jammyMap = analyzeOscapOciReport('report.xml')
#print (jammyMap)
#generateData(jammyMap)
