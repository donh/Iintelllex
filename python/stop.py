#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/stop.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk

"""
* @python name:		python/stop.py
* @description:		This file reads "pin_henry" table and writes to "dress" table.
* @related issues:	ITL-002
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:
"""

import re



"""
* @def name:		getTypesOfNullContent()
* @description:		This function prints Distinct "application_type" of records whose "content" is null.
* @related issues:	ITL-001
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/04/2015
* @last modified:	03/04/2015
* @called by:		main
*					 in python/stop.py
"""
def getTypesOfNullContent():
	dbName = 'intelllex'
	table = 'document_dump'
	fields = 'DISTINCT application_type'
	where = '`content` = ""'
	# where = '`Available` = "Y" OR `Available` = "R" OR `Available` = "N"'
	rows = don.queryDB(dbName, table, fields, where)
	print rows
	print len(rows)
	# return args





"""
* @def name:		parseContent(s)
* @description:		This function parses data to gets url, application_type, and content.
* @related issues:	ITL-001
* @param:			string s
* @return:			tuple args
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/04/2015
* @called by:		main
*					 in python/stop.py
"""
def parseContent(s):
	args = None
	if 'Content::' in s:
		s = s.split('Content::')[-1]
		header = s.split('Content:')[0].split('\n')
		url = ''
		application_type = ''
		for line in header:
			if 'url: http' in line:
				url = line.split('url: ')[-1].strip(', _\t\n\r')
			elif 'contentType: ' in line:
				application_type = line.split('contentType: ')[-1].strip(', _\t\n\r')
		# print url
		# print application_type
		types = ['image/jpeg', 'image/png', 'application/msword', 'application/pdf']
		if application_type in types:
			content = ''
		else:
			# body = s.split('Content:')[-1].lstrip()
			body = s.split('Content:')[-1].lstrip().decode('ascii', 'ignore')
			body = s.split('Content:')[-1]
			body = re.sub('\t+', ' ', body)
			body = re.sub(' +', ' ', body)
			body = re.sub('\n+', '\n', body)
			content = body.strip(', _\t\n\r')
			# content.decode('utf-8')
			# content = content.decode('ascii')
			# content = content.decode('ascii', 'ignore')
			# anchorText = anchorText.decode('ascii', 'ignore')
			# content = s.split('Content:')[-1].lstrip()
		dbName = 'intelllex'
		table = 'document_dump'
		fields = 'url, application_type, content'
		args = (url, application_type, content)
		# args = (url, application_type, content, now)
		# don.insertDB('intelllex', 'document_dump', fields, args)
		don.insertDB(dbName, table, fields, args)
	return args




import don

xls = '/var/www/intelllex/data/ITL-002_URL_20150314.xlsx'
rows = don.readXls(xls)
print rows
print len(rows)

print "Done"