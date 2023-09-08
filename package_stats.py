# This builds a json file that is our snap database
import glob, json, collections

manifestFiles = glob.glob('manifest.*')


# snap -> package -> [version]
snapDict = collections.OrderedDict()

def addInfo(parts, snapDict):
	if parts[2] in snapDict.keys():
		snapDict[parts[2]][parts[0]] = parts[1]
	else:
		snapDict[parts[2]] = {parts[0]: parts[1]}
		print ('new snap: %s' % parts[2])

	return snapDict

for filename in manifestFiles:
	print ('analyzing %s' % filename)
	with open(filename, 'r') as file:
		lines = file.readlines()
		for line in lines:
			parts = line.replace('\n', '').split(' ')
			snapDict = addInfo(parts, snapDict)
#print (snapDict)
for entry in snapDict.keys():
	print ("%s->%s" % (entry, len(snapDict[entry].keys())))

with open('snap_data.json', 'w') as outputFile:
	json.dump(snapDict, outputFile)
