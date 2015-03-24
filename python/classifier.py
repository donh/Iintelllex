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
		# lst = url.split('http')
		# url = 'http' + lst[-1]
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
		# if len(url) > 50:
			print url
			print len(url)
			# len(url) = 319
			# https://www.ato.gov.au/rates/schedule-11---tax-table-for-employment-termination-payments/?phttps:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.https:/www.ato.gov.au/rates/schedule-11---tax-table-for-employment-termination-payments/=&page=2
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




"""
* @def name:		getFeatures(where, label)
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			string where
* @param:			string label
* @return:			list features
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/20/2015
* @called by:		def getPositiveAndNegativeFeatures()
*					 in python/classifier.py
"""
def getFeatures(where, label):
	dbName = 'intelllex'
	# table = 'label'
	table = 'classifier'
	# fields = 'id, useful, content'
	# fields = 'content, title, jurisdiction'
	# fields = 'url, content_len, title, jurisdiction'
	fields = 'url, title, jurisdiction'

	# where = '`useful` = 1 AND `content_len` > 5'
	rows = don.queryDB(dbName, table, fields, where)
	# negids = []
	# positiveFeatures = []
	features = []
	# raise
	for row in rows:
		# content = row[2]
		url = row[0]
		table = 'document2'
		fields = 'content'
		where = '`url` = "' + url + '" LIMIT 1'
		rows = don.queryDB(dbName, table, fields, where)
		if len(rows) > 0:
			row = rows[0]
			content = row[0]
			# content_len = row[1]
			words = don.tokenize(content)
			# words = words[:800]
			# words = words[:300]
			# feature = don.getFeature(words, label)
			feature = don.getFeature(words)
			# positiveFeatures.append(feature)
			# features.append(feature)
			features.append((feature, label))
	# return positiveFeatures
	return features


"""
* @def name:		getPositiveAndNegativeFeatures()
* @description:		This function gets annotated positive and negative features for training classifier.
* @related issues:	ITL-002
* @param:			void
* @return:			tuple (negativeFeatures, positiveFeatures)
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/classifier.py
"""
def getPositiveAndNegativeFeatures():
	where = '`annotated` = 1 AND `is_case` = 1 AND `content_len` > 5'
	label = 1
	positiveFeatures = getFeatures(where, label)

	where = '`annotated` = 1 AND `is_case` = 0 AND `content_len` > 5'
	label = 0
	negativeFeatures = getFeatures(where, label)
	return (negativeFeatures, positiveFeatures)






"""
* @def name:		classifyTestFeatures(classifier)
* @description:		This function gets unlabeled features for testing.
* @related issues:	ITL-002
* @param:			object classifier
* @return:			void
* @author:			Don Hsieh
* @since:			03/20/2015
* @last modified:	03/20/2015
* @called by:		main
*					 in python/classifier.py
"""
def classifyTestFeatures(classifier):
	dbName = 'intelllex'
	# table = 'label'
	table = 'classifier'
	# fields = 'id, content, title, jurisdiction'
	fields = 'id, url, title, jurisdiction'
	where = '`annotated` = 0 AND `is_case` IS NULL AND `content_len` > 5'
	rows = don.queryDB(dbName, table, fields, where)
	print len(rows)
	# for row in rows:
	for key, row in enumerate(rows):
		id = row[0]
		url = row[1]
		table = 'document2'
		fields = 'content'
		where = '`url` = "' + url + '" LIMIT 1'
		results = don.queryDB(dbName, table, fields, where)
		if len(results) > 0:
			result = results[0]
			content = result[0]
			words = don.tokenize(content)
			feature = don.getFeature(words)
			# print feature
			observed = classifier.classify(feature)
			# print observed
			# print(nltk.classify.accuracy(classifier, feature))
			# # 0.758
			# classifier.show_most_informative_features(5)
		
			lstArgs = [0, observed, don.getNow()]
			table = 'classifier'
			fields = 'annotated, is_case, updatedAt'
			where = '`id`="' + str(id) + '"'
			don.updateDB(dbName, table, fields, where, lstArgs)

			if key % 500 == 0:
				print str(key) + ' / ' + str(len(rows)) + '\t' + str(round(100.0 * key / len(rows), 2)) + '%'
				print feature
				print observed
				now = don.getNow()
				duration = don.timeDiff(timeStart, now)
				print now + '\t\t' + 'Elapsed: ' + str(duration)



import don


dbName = 'intelllex'
timeStart = don.getNow()
print "Start classifier: " + timeStart
# getContent()

negativeFeatures, positiveFeatures = getPositiveAndNegativeFeatures()
don.evaluate_classifier(negativeFeatures, positiveFeatures)
classifier = don.getClassifier(negativeFeatures, positiveFeatures)
now = don.getNow()
duration = don.timeDiff(timeStart, now)
print now + '\t\t' + 'Elapsed: ' + str(duration)

classifyTestFeatures(classifier)


timeEnd = don.getNow()
duration = don.timeDiff(timeStart, timeEnd)
# print "Done"
print 'Done: ' + timeEnd
print 'Duration: ' + str(duration)
