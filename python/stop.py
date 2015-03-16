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
import nltk


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
* @def name:		getTrainingSet()
* @description:		This function parses data to gets url, application_type, and content.
* @related issues:	ITL-002
* @param:			string s
* @return:			tuple args
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		main
*					 in python/stop.py
"""
def getTrainingSet():
	xls = '/var/www/intelllex/data/ITL-002_URL_20150314.xlsx'
	rows = don.readXls(xls)
	# print rows
	# print len(rows)
	# print rows[0]
	# print rows[4]
	cases = []
	for row in rows:
		isCase = row[1]
		# if isCase > 0:
		if isCase is not None:
			url = row[0]
			cases.append([url.strip(), int(isCase)])
	# print cases
	print len(cases)

	dbName = 'intelllex'
	table = 'document2'
	fields = 'url, content, title'
	# where = '`url` = "' + url + '"'
	# where = '`Available` = "Y" OR `Available` = "R" OR `Available` = "N"'
	# rows = don.queryDB(dbName, table, fields, where)


	# dbName = 'intelllex'
	# table = 'document_dump'
	# fields = 'url, application_type, content'
	# args = (url, application_type, content)
	# # args = (url, application_type, content, now)
	# # don.insertDB('intelllex', 'document_dump', fields, args)
	# don.insertDB(dbName, table, fields, args)

	for case in cases:
		url = case[0]
		if len(url) > 400:
			print url
			print len(url)
			raise
		isCase = case[1]
		table = 'document2'
		fields = 'url, content, title'
		where = '`url` = "' + url + '" LIMIT 1'
		rows = don.queryDB(dbName, table, fields, where)
		row = rows[0]
		# print row
		content = row[1]
		content_len = len(content)
		title = row[2]
		now = don.getNow()
		# print row[2]
		table = 'train'
		fields = 'url, content, content_len, useful, title, createdAt'
		args = (url, content, content_len, isCase, title, now)
		don.insertDB(dbName, table, fields, args)




import don
dbName = 'intelllex'
# getTrainingSet()

# nltk.download()
# raise

table = 'train'
fields = 'id, content'
# where = '`url` = "' + url + '" LIMIT 1'
where = None
rows = don.queryDB(dbName, table, fields, where)
# print rows
print len(rows)
for row in rows:
	id = row[0]
	content = row[1]
	# content = content.decode('ascii', 'ignore')
	content = content.encode('utf-8').strip().decode('ascii', 'ignore')
	content = content.lower()
	content = don.neat(content)
	# http://stackoverflow.com/questions/5499702/stop-words-nltk-python-problem
	# word_list2 = [w.strip() for w in word_list if w.strip() not in nltk.corpus.stopwords.words('english')]
	stop = [w.strip() for w in content if w.strip() not in nltk.corpus.stopwords.words('english')]
	stop_len = len(stop)

	fields = 'stop, stop_len, updatedAt'
	args = (stop, stop_len, don.getNow())
	where = '`id`="' + str(id) + '"'
	don.updateDB(dbName, table, fields, where, args)

print "Done"