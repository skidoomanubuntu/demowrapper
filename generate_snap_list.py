import subprocess
output = open('/home/skidooman/output.txt', 'w')


process = subprocess.Popen(['snap', 'list'], stdout=subprocess.PIPE)
stdout = process.communicate()

print(stdout)
output.writelines(str(stdout))
output.close()
