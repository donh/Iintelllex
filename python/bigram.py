#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/bigram.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk
#python -m nltk.downloader stopwords; python -m nltk.downloader punkt; python -m nltk.downloader wordnet
#python -m nltk.downloader names

"""
* @python name:		python/bigram.py
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
*					 in python/bigram.py
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



import don


dbName = 'intelllex'
# getContent()
# getBigram()
timeStart = don.getNow()
print "Start classifier: " + timeStart


don.evaluate_classifier()


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
print 'Duration: ' + duration
