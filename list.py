import subprocess
output = open('list_snaps.txt', 'w')


process = subprocess.Popen(['snap', 'list'], stdout=subprocess.PIPE)
stdout = process.communicate()

print(stdout)
output.writelines(str(stdout))
output.close()
