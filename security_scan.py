from bs4 import BeautifulSoup

# This analyzes a manifest file that is OS-specific
# For each file, file has this info: package | version | snap
def analyzeManifestFile(filename, currentOS):
	snapDict = []
	with open(filename, 'r') as manifestFile:
		for entry in manifestFile.readlines():
			parts = entry.replace('\n','').split(' ')
			# Pattern is package | version | snap
			dictEntry = {"os":currentOS, "snap": parts[2], "package": parts[0], "version": parts[1], "description":"", "current_version":"", "component":None, "cve":[]}
			snapDict.append(dictEntry)
	return snapDict

# This returns a package map established from an OVAL pck file
def generatePackageMap(filename):
	packageMap = {}
	packFile = open(filename, 'r')
	contents = packFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definition')
	for definition in definitions:
		title = definition.find('title').text
		# If you have a space in the title, then it is likely not a package name. Continue
		if (' ' in title):
			print ('Cannot (should not) import %s as a valid package name' % definition.find('title').text)
			continue
		# Title is the name of the package
		# At the same level, there should be a description
		description = definition.find('description').text
		# Then a current version
		currentVersion = definition.find('current_version').text

		# It may be part of a component - main, universe, multiverse
		component = None
		if (definition.find('component')):
			component = definition.find('component').text

		# Then a bunch of CVE entries
		cves = []
		for cve in definition.find_all('cve'):
			# Name of the CVE is in the text
			name = cve.text
			# In the tag, we have additional info that may be useful
			# Namely severity and a date when it went public
			severity = cve['severity']
			release_date = cve['public']
			cves.append({"name":name, "severity":severity, "release_date":release_date})
			
		packageMap.update({title:{"description":description, "current_version":currentVersion, "component":component, "cve":cves}})
	return packageMap

# This analyzes the CVE oval file, which is poorly structured
def generateCVEFixMap(filename):
	CVEFixMap = {}
	cveFile = open(filename, 'r')
	contents = cveFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definition')
	for definition in definitions:
		title = definition.find('title').text
		# If you have a space in the title, then it is likely not a package name. Continue
		if (not title.startswith('CVE-')):
			print ('Cannot (should not) import %s as a valid package name' % definition.find('title').text)
			continue
		cve = title.split(' ')[0]
		version = None
		text = definition.find('description').text
		lines = text.split('\n')
		for i in range(0, len(lines)):
			if (lines[i].startswith('by updating your system to the following package versions:')):
				versionLine = lines[i+2]
				version = versionLine.split(' ')[2]
				break
		CVEFixMap.update({cve:version})
	return CVEFixMap

# This analyzes an oval file with USN numbers
def generateCVEMap(filename):
	CVEMap = {}
	USNMap = {}
	usnFile = open(filename, 'r')
	contents = usnFile.read()
	soup = BeautifulSoup(contents, 'xml')
	definitions = soup.find_all('definition')
	for definition in definitions:
		description = definition.find('description').text
		date = definition.find('issued')['date']
		usn = None
		cves = []
		for reference in definition('reference'):
			if (reference['source'] == 'USN'):
				usn = reference['ref_id']
			else:
				cves.append(reference['ref_id'])
		USNMap.update({usn:{"description":description, "date":date, "cve":cves}})
		for cve in cves:
			if (cve in CVEMap.keys()):
				CVEMap[cve].append(usn)
			else:
				CVEMap.update({cve:[usn]})
	return CVEMap, USNMap

# This compares two versions, or at least attempts to do so
def compareVersions(current, fixed):
	# Usually, 1.6-1ubuntu0.20.04.1 - compare from left to right
	def extractNumbers(version):
		numbers = []
		current = ''
		for i in range(len(version)):
			if (version[i] >= '0' and version[i] <= '9'):
				current += version[i]
			else:
				if (current):
					numbers.append(int(current))
					current = ''
		if (current):
			numbers.append(int(current))
		return numbers
	
	# Function returns True if current is newer than fixed, False if not, and None if cannot determine
	currentNumbers = extractNumbers(current)
	fixedNumbers = extractNumbers(fixed)
	
	i = 0
	while (i < len(currentNumbers) and i < len(fixedNumbers)):
		if (currentNumbers[i] > fixedNumbers[i]):
			return True
		elif (currentNumbers[i] < fixedNumbers[i]):
			return False
		i += 1
	
	# Here, if there is a same number of numbers OR if the number of numbers in current is superior, it is True
	if (len(currentNumbers) >= len(fixedNumbers)):
		return True

	return None

# First, load the manifest. These are PER core snap
# In the end, we should be able to have a table like this:
# OS | snap | version (currently) | package 
snapDict = analyzeManifestFile('manifest.core20', 'Core20')

'''print ('OS\t\tsnap\t\tversion\t\tpackage')
for snap in snapDict:
	print ('%s \t\t %s \t\t %s \t\t %s' % (snap['os'], snap['snap'], snap['package'], snap['version']))
'''

# Now that we have a list of packages that underpin snaps
# create a table of all these packages in one unique map
# Each map will ultimately point to a dictionary
packageMap = generatePackageMap('com.ubuntu.focal.pkg.oval.xml')

# This (hopefully) returns a map of CVE numbers vs versions that fix it 
CVEFixMap = generateCVEFixMap('com.ubuntu.focal.cve.oval.xml')


# We also need a map of CVEs to USNs to indicate when they were fixed
CVEMap, USNMap = generateCVEMap('oci.com.ubuntu.focal.usn.oval.xml')	

# By associating the snapDict to the packageMap, we can know how many CVEs are POTENTIALLY present
for snap in snapDict:
	if snap['snap'] in packageMap.keys():
		snap['description'] = packageMap[snap['snap']]['description']
		snap['current_version'] = packageMap[snap['snap']]['current_version']
		snap['component'] = packageMap[snap['snap']]['component']
		snap['cve'] = packageMap[snap['snap']]['cve']

# We also need a way to have a CVE centric way of seeing things
CVEWithSnapsInfo ={}
for snap in snapDict:
	for cve in snap['cve']:
		if (cve['name'] in CVEWithSnapsInfo.keys()):
			CVEWithSnapsInfo[cve['name']]['snaps'].append(snap)
		else:
			CVEWithSnapsInfo.update({cve['name']:{"severity":cve['severity'], "release_date":cve['release_date'], "snaps":[snap]}})

print ('CVEs present: %i' % len(CVEWithSnapsInfo.keys()))



# Generate a table levels (rows) vs components (cols)
CVEsAndAvailablePatches = {"critical":{"main":0, "universe":0, "multiverse": 0, "other":0},
			"high":{"main":0, "universe":0, "multiverse":0, "other":0},
			"medium":{"main":0, "universe":0, "multiverse":0, "other":0},
			"low":{"main":0, "universe":0, "multiverse":0, "other":0}}

print  ('CVE \t\tOS \tsnap \tcomp \tlevel \t#pck \t#usn \tcurver \tfixed')
print  ('---------------------------------------------------------------')
for cve in CVEWithSnapsInfo.keys():
	usn = '          '
	if (cve in CVEMap.keys()):
		usn = CVEMap[cve]
	packNum = len(CVEWithSnapsInfo[cve]['snaps'])
	OS = CVEWithSnapsInfo[cve]['snaps'][0]['os']
	snap = CVEWithSnapsInfo[cve]['snaps'][0]['snap']
	component = CVEWithSnapsInfo[cve]['snaps'][0]['component']
	severity = CVEWithSnapsInfo[cve]['severity']
	version = CVEWithSnapsInfo[cve]['snaps'][0]['version']
	fixedVersion = None
	fixed = False
	if (cve in CVEFixMap.keys()):
		fixedVersion = CVEFixMap[cve]
		fixed = compareVersions(version, fixedVersion)
	print ('%s \t%s \t%s \t%s \t%s \t%s \t%s \t%s \t%s \t%s' % 
		(cve, OS, snap, component, severity, packNum, len(usn), fixed, version, fixedVersion))


'''	for snap in CVEWithSnapsInfo[cve]['snaps']:
		print ('%s \t%s \t%s \t%s \t%s \t%s(%s) \t%s' % 
			(cve, snap['os'], snap['snap'], snap['component'], CVEWithSnapsInfo[cve]['severity'], 
			snap['package'], snap['version'], usn))
'''

# What are all the severity levels and components present?
components = []
severities = []

for snap in snapDict:
	if (not snap['component'] in components):
		components.append(snap['component'])
	for cve in snap['cve']:
		if (not cve['severity'] in severities):
			severities.append(cve['severity'])

print (components)
print (severities)
