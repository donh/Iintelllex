#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/bayes.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk
#python -m nltk.downloader stopwords; python -m nltk.downloader punkt; python -m nltk.downloader wordnet
#python -m nltk.downloader names


import nltk

"""
* @python name:		python/bayes.py
* @description:		This file reads "document2" table and writes to "label" table.
* @related issues:	ITL-002
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:
"""



def gender_features(word):
	return {'last_letter': word[-1]}
# gender_features('Shrek')
# {'last_letter': 'k'}


  	

def gender_features2(name):
	features = {}
	features["first_letter"] = name[0].lower()
	features["last_letter"] = name[-1].lower()
	for letter in 'abcdefghijklmnopqrstuvwxyz':
		features["count(%s)" % letter] = name.lower().count(letter)
		features["has(%s)" % letter] = (letter in name.lower())
	return features



"""
* @def name:		buildLabelTable()
* @description:		This function builds "label" table.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/bayes.py
"""
def buildLabelTable():
	dbName = 'intelllex'
	table = 'document2'
	fields = 'url, content, title, jurisdiction'
	where = None
	# where = '`useful` = 1 AND `content_len` > 5'
	# where = '`useful` = 1'
	rows = don.queryDB(dbName, table, fields, where)
	table = 'label'
	fields = 'url, annotated, content, content_len, title, jurisdiction, createdAt'
	# for row in rows:
	for i, row in enumerate(rows):
		url = row[0]
		content = row[1]
		content_len = len(content)
		title = row[2]
		jurisdiction = row[3]
		now = don.getNow()
		args = (url, 0, content, content_len, title, jurisdiction, now)
		don.insertDB(dbName, table, fields, args)
		if i % 500 == 0:
			print str(i) + ' / ' + str(len(rows)) + '\t' + str(round(100.0 * i / len(rows), 2)) + '%' + '\t' + don.getNow()



"""
* @def name:		annotateLabelTable()
* @description:		This function annotates "label" table.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/bayes.py
"""
def annotateLabelTable():
	xls = '/var/www/intelllex/data/ITL-002_URL_20150319.xlsx'
	rows = don.readXls(xls)
	cases = []
	for row in rows:
		isCase = row[1]
		if isCase is not None:
			url = row[0]
			cases.append([url.strip(), int(isCase)])

	dbName = 'intelllex'
	table = 'label'
	fields = 'id, url'

	# for case in cases:
	for i, case in enumerate(cases):
		url = case[0]
		if len(url) > 400:
			print url
			print len(url)
			raise
		isCase = case[1]
		# table = 'document2'
		# fields = 'url, content, title'
		fields = 'id, url'
		where = '`url` = "' + url + '" LIMIT 1'
		rows = don.queryDB(dbName, table, fields, where)
		row = rows[0]
		id = row[0]
		# print url
		# print rows
		if id > 0:
			fields = 'annotated, is_case, updatedAt'
			lstArgs = [1, isCase, don.getNow()]
			where = '`id`="' + str(id) + '"'
			don.updateDB(dbName, table, fields, where, lstArgs)
		if i % 25 == 0:
			print str(i) + ' / ' + str(len(cases)) + '\t' + str(round(100.0 * i / len(cases), 2)) + '%' + '\t' + don.getNow()



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
*					 in python/bayes.py
"""
def getFeatures(where, label):
	dbName = 'intelllex'
	table = 'label'
	# fields = 'id, useful, content'
	fields = 'content, title, jurisdiction'

	# where = '`useful` = 1 AND `content_len` > 5'
	rows = don.queryDB(dbName, table, fields, where)
	# negids = []
	# positiveFeatures = []
	features = []
	# raise
	for row in rows:
		# content = row[2]
		content = row[0]
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
*					 in python/bayes.py
"""
def getPositiveAndNegativeFeatures():
	where = '`annotated` = 1 AND `is_case` = 1 AND `content_len` > 5'
	# label = 'pos'
	label = 1
	positiveFeatures = getFeatures(where, label)

	where = '`annotated` = 1 AND `is_case` = 0 AND `content_len` > 5'
	# label = 'neg'
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
*					 in python/bayes.py
"""
def classifyTestFeatures(classifier):
	dbName = 'intelllex'
	table = 'label'
	fields = 'id, content, title, jurisdiction'
	where = '`annotated` = 0 AND `is_case` IS NULL AND `content_len` > 5'
	rows = don.queryDB(dbName, table, fields, where)
	print len(rows)
	# for row in rows:
	fields = 'annotated, is_case, updatedAt'
	for key, row in enumerate(rows):
		id = row[0]
		content = row[1]
		words = don.tokenize(content)
		feature = don.getFeature(words)
		# print feature
		observed = classifier.classify(feature)
		# print observed
		# print(nltk.classify.accuracy(classifier, feature))
		# # 0.758
		# classifier.show_most_informative_features(5)
	
		lstArgs = [0, observed, don.getNow()]
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


# dbName = 'intelllex'
timeStart = don.getNow()
print "Start classifier: " + timeStart



# buildLabelTable()
# annotateLabelTable()
negativeFeatures, positiveFeatures = getPositiveAndNegativeFeatures()
# print len(negativeFeatures)
# print len(positiveFeatures)

## don.evaluate_classifier()
# don.evaluate_classifier(negativeFeatures, positiveFeatures)
classifier = don.evaluate_classifier(negativeFeatures, positiveFeatures)
classifyTestFeatures(classifier)

timeEnd = don.getNow()
duration = don.timeDiff(timeStart, timeEnd)
print 'Done: ' + timeEnd
print 'Duration: ' + str(duration)