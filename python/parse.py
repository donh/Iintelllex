#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/parse.py

"""
* @python name:		python/parse.py
* @description:		This file reads "pin_henry" table and writes to "dress" table.
* @related issues:	ITL-001
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:
"""



"""
* @def name:		insertDB(dbName, table, fields, args)
* @description:		This function inserts data into database.
* @related issues:	ITL-001
* @param:			string s
* @return:			void
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		main
*					 in python/parse.py
"""
def parseContent(s):
	s = s.split('Content::')[-1]
	header = s.split('Content:')[0].split('\n')
	# body = s.split('Content:')[-1].lstrip()
	body = s.split('Content:')[-1]
	body = re.sub('\t+', ' ', body)
	body = re.sub(' +', ' ', body)
	body = re.sub('\n+', '\n', body)
	content = body.strip(', _\t\n\r')
	# content = s.split('Content:')[-1].lstrip()

	url = ''
	application_type = ''
	for line in header:
		if 'url: http' in line:
			url = line.split('url: ')[-1]
		elif 'contentType: ' in line:
			application_type = line.split('contentType: ')[-1]
	print url
	print application_type

	dbName = 'intelllex'
	table = 'document_dump'
	fields = 'url, application_type, content'
	args = (url, application_type, content)
	# args = (url, application_type, content, now)
	# don.insertDB('intelllex', 'document_dump', fields, args)
	don.insertDB(dbName, table, fields, args)





import don


filepath = '/var/www/intelllex/data/dump2'
s = ''
block = ''
with open(filepath) as f:
	# content = f.readlines()
	lines = f.readlines()
	# print lines
	# print type(lines)
	# raise
	for line in lines:
		# line = line.strip()
		
		# print line
		# if line == 'Recno:: 2': raise
		if 'Recno:: ' in line:
			# block = s
			parseContent(s)
			s = ''
		else: s += line
parseContent(s)
print "Done"