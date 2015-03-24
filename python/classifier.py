#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/classifier.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk
#python -m nltk.downloader stopwords; python -m nltk.downloader punkt; python -m nltk.downloader wordnet
#python -m nltk.downloader names

"""
* @python name:		python/classifier.py
* @description:		This file reads "pin_henry" table and writes to "dress" table.
* @related issues:	ITL-002
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/18/2015
* @called by:
"""
# from nltk.collocations import BigramAssocMeasures, BigramCollocationFinder

"""
* @def name:		getBigram()
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/18/2015
* @called by:		main
*					 in python/classifier.py
"""
def getBigram():
	table = 'tokens'
	fields = 'id, content'
	# where = '`url` = "' + url + '" LIMIT 1'
	where = None
	rows = don.queryDB(dbName, table, fields, where)
	# print rows
	print len(rows)
	for row in rows:
		id = row[0]
		content = row[1]

		words = don.tokenize(content)
		print words
		print len(words)

		feature = don.getFeature(words, 50)
		print feature
		print len(feature)
		raise

		tokens = []
		for s in lst:
			if isinstance(s, (basestring, unicode)):
				s = s.strip(', _\t\n\r"()[]:/-.;`*')
				# if len(s) > 2 and '?' not in s and ')' not in s and '$' not in s:
				if len(s) > 2 and '?' not in s and ')' not in s and not don.isNumber(s):
					# s = snowball_stemmer.stem(s)
					# s = wordnet_lemmatizer.lemmatize(s)
					s = don.stemming(s)
					tokens.append(s)
		tokens = list(set(tokens))
		tokens.sort()
		tokens = ' '.join(tokens)
		tokens_len = len(tokens)

		fields = 'tokens, tokens_len, updatedAt'
		# args = (stop, token_len, don.getNow())
		lstArgs = [tokens, tokens_len, don.getNow()]
		where = '`id`="' + str(id) + '"'
		don.updateDB(dbName, table, fields, where, lstArgs)
		





"""
* @def name:		getNegativeFeatures()
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			void
* @return:			list negativeFeatures
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/classifier.py
"""
def getNegativeFeatures():
	dbName = 'intelllex'
	table = 'tokens'
	fields = 'id, useful, content'
	# where = None
	where = '`useful` = 0 AND `content_len` > 5'
	# where = '`useful` = 1'
	rows = don.queryDB(dbName, table, fields, where)
	# negids = []
	negativeFeatures = []
	# raise
	for row in rows:
		# negid = int(row[0])
		# negids.append(negid)

		content = row[2]
		words = don.tokenize(content)
		# words = words[:800]
		# words = words[:300]
		feature = don.getFeature(words, 'neg')
		negativeFeatures.append(feature)
	return negativeFeatures


"""
* @def name:		getPositiveFeatures()
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			void
* @return:			list positiveFeatures
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/classifier.py
"""
def getPositiveFeatures():
	dbName = 'intelllex'
	table = 'tokens'
	fields = 'id, useful, content'
	# where = None
	where = '`useful` = 1 AND `content_len` > 5'
	# where = '`useful` = 1'
	rows = don.queryDB(dbName, table, fields, where)
	# negids = []
	positiveFeatures = []
	# raise
	for row in rows:
		content = row[2]
		words = don.tokenize(content)
		# words = words[:800]
		# words = words[:300]
		feature = don.getFeature(words, 'pos')
		positiveFeatures.append(feature)
	return positiveFeatures





"""
* @def name:		getContent()
* @description:		This function gets content from "document2" table and writes to "classifier" table.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/23/2015
* @last modified:	03/23/2015
* @called by:		main
*					 in python/classifier.py
"""
def getContent():
	xls = '/var/www/intelllex/data/ITL-002_URL_20150321_Don-JX.xlsx'
	rows = don.readXls(xls)
	cases = []
	# for row in rows:
	args = None
	for key, row in enumerate(rows):
		# print row
		# if key > 3: raise
		url = row[0].strip()
		annotator = None
		# annotator = row[4].strip()
		isCase = None
		date = None
		# isCase = row[1]
		if row[4].strip() != 'Don':
			annotator = row[4].strip()
		# if isCase is not None:
			isCase = int(row[1])
			# print row[5]
			# date = row[5].strip()
			date = don.getXlrdDate(row[5])
		case = [url, isCase, annotator, date]
		cases.append(case)
	# print cases
	print cases[-1]
	print cases[0]
	print len(cases)
	# raise

	# dbName = 'intelllex'
	# table = 'document2'
	# fields = 'url, content, title, jurisdiction'

	# for case in cases:
	for i, case in enumerate(cases):
		url = case[0]
		if len(url) > 350:
			print url
			print len(url)
			# len(url) = 319
			# https://www.ato.gov.au/rates/schedule-11---tax-table-for-employment-termination-payments/?phttps:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.ato.gov.au/rates/schedule-11---tax-table-for-employment-termination-payments/=&page=2
319
			raise
		isCase = case[1]
		annotated = 0
		if isCase is not None: annotated = 1
		annotator = case[2]
		date = case[3]

		table = 'classifier'
		fields = 'url'
		where = '`url` = "' + url + '" LIMIT 1'
		rows = don.queryDB(dbName, table, fields, where)
		if len(rows) == 0:
			table = 'document2'
			fields = 'url, content, title, jurisdiction'
			where = '`url` = "' + url + '" LIMIT 1'
			rows = don.queryDB(dbName, table, fields, where)
			table = 'classifier'
			if len(rows) > 0:
				row = rows[0]
				# content = row[1]
				content_len = 0
				if isinstance(row[1], (basestring, unicode)):
					# content = row[1].encode('utf-8').strip().decode('ascii', 'ignore')
					content_len = len(row[1].encode('utf-8').strip().decode('ascii', 'ignore'))

				title = ''
				if isinstance(row[2], (basestring, unicode)):
					title = row[2].encode('utf-8').strip().decode('ascii', 'ignore')

				jurisdiction = ''
				if row[3] is not None:
					jurisdiction = row[3].encode('utf-8').strip().decode('ascii', 'ignore')
				now = don.getNow()
				fields = 'url, annotated, is_case, content_len, title, jurisdiction, annotator, date, createdAt'
				args = (url, annotated, isCase, content_len, title, jurisdiction, annotator, date, now)
			else:
				content_len = 0
				fields = 'url, annotated, is_case, content_len, annotator, date, createdAt'
				args = (url, annotated, isCase, content_len, annotator, date, now)
			# print args
			# raise
			don.insertDB(dbName, table, fields, args)
		if i % 500 == 0:
			# print str(i) + ' / ' + str(len(rows)) + '\t' + str(round(100.0 * i / len(rows), 2)) + '%' + '\t' + don.getNow()
			print str(i) + ' / ' + str(len(cases)) + '\t' + str(round(100.0 * i / len(cases), 2)) + '%' + '\t' + don.getNow()
			now = don.getNow()
			duration = don.timeDiff(timeStart, now)
			print now + '\t\t' + 'Elapsed: ' + str(duration)
			if args is not None: print args










import don


dbName = 'intelllex'
timeStart = don.getNow()
getContent()
# getBigram()

print "Start classifier: " + timeStart

# negativeFeatures = getNegativeFeatures()
# positiveFeatures = getPositiveFeatures()


# don.evaluate_classifier(negativeFeatures, positiveFeatures)


timeEnd = don.getNow()
duration = don.timeDiff(timeStart, timeEnd)
# print "Done"
print 'Done: ' + timeEnd
print 'Duration: ' + str(duration)
