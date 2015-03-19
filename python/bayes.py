#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/bayes.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk
#python -m nltk.downloader stopwords; python -m nltk.downloader punkt; python -m nltk.downloader wordnet
#python -m nltk.downloader names

"""
* @python name:		python/bayes.py
* @description:		This file reads "document2" table and writes to "label" table.
* @related issues:	ITL-002
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:
"""


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
*					 in python/bayes.py
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
	# print cases
	# print len(cases)

	dbName = 'intelllex'
	table = 'label'
	# fields = 'id, annotated, content, content_len, title, jurisdiction, createdAt'
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
* @last modified:	03/19/2015
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
		# feature = don.getFeature(words, 'pos')
		feature = don.getFeature(words, label)
		# positiveFeatures.append(feature)
		features.append(feature)
	# return positiveFeatures
	return features


"""
* @def name:		getPositiveFeatures()
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			string where
* @param:			string label
* @return:			list features
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/bayes.py
"""
def getPositiveAndNegativeFeatures():
	where = '`annotated` = 1 AND `is_case` = 1 AND `content_len` > 5'
	label = 'pos'
	positiveFeatures = getFeatures(where, label)

	where = '`annotated` = 1 AND `is_case` = 0 AND `content_len` > 5'
	label = 'neg'
	negativeFeatures = getFeatures(where, label)
	return (negativeFeatures, positiveFeatures)
	# return (positiveFeatures, negativeFeatures)



import don


# dbName = 'intelllex'
timeStart = don.getNow()
print "Start classifier: " + timeStart



# buildLabelTable()
# annotateLabelTable()
# positiveFeatures, negativeFeatures = getPositiveAndNegativeFeatures()
negativeFeatures, positiveFeatures = getPositiveAndNegativeFeatures()
print len(positiveFeatures)
print len(negativeFeatures)


# negativeFeatures = getNegativeFeatures()
# positiveFeatures = getPositiveFeatures()

## don.evaluate_classifier()
# don.evaluate_classifier(negativeFeatures, positiveFeatures)
classifier = don.evaluate_classifier(negativeFeatures, positiveFeatures)


'''
import nltk
from nltk.corpus import names
labeled_names = ([(name, 'male') for name in names.words('male.txt')] + [(name, 'female') for name in names.words('female.txt')])
# print labeled_names
import random
random.shuffle(labeled_names)
# print labeled_names

# featuresets = [(gender_features(n), gender) for (n, gender) in labeled_names]
featuresets = [(gender_features2(n), gender) for (n, gender) in labeled_names]
print featuresets
train_set, test_set = featuresets[500:], featuresets[:500]
classifier = nltk.NaiveBayesClassifier.train(train_set)
classifier.classify(gender_features('Neo'))
print(nltk.classify.accuracy(classifier, test_set))
# 0.758
classifier.show_most_informative_features(5)
'''

# nltk.download()
# raise

timeEnd = don.getNow()
duration = don.timeDiff(timeStart, timeEnd)
# print "Done"
print 'Done: ' + timeEnd
print 'Duration: ' + str(duration)
