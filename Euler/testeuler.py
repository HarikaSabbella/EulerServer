#!/usr/bin/python
import sys
import cgi
import cgitb
import subprocess
python2_env = {"PYTHONPATH": "/var/www/html/Euler/euler-project/src-el/"}

arguments = cgi.FieldStorage()

fileName = arguments.getvalue('inputfile')
#com = "/var/www/html/Euler/euler-project/src-el/euler"
#com = "ls"
com = "/var/www/html/Euler/euler-project/src-el/euler -i " + fileName + "-o /tmp/Euler3/"
output = subprocess.check_output(com, env=python2_env, shell=True)
output_li = output.split("\n")

print "Content-type:text/html\n"
print '<html>'
print '<head>'
print '</head>'
print '<body>'
for e in output_li:
	print e, '</br>'
print '</body>'
print '</html>'
