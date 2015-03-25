#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/wd/python/don.py
"""
* @python name:		python/don.py
* @description:		This file has common def.
* @related issues:	ITL-001
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		python/parse.py
"""

from __future__ import division
import sys
import MySQLdb
from datetime import datetime
import xlrd
from xlrd import XLRDError
import xlwt
import re

import nltk
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import SnowballStemmer
from nltk.stem import WordNetLemmatizer
from nltk.collocations import BigramAssocMeasures, BigramCollocationFinder
import itertools

import collections
import nltk.classify.util, nltk.metrics
from nltk.classify import NaiveBayesClassifier
# from nltk.corpus import movie_reviews
# from nltk.classify import MaxentClassifier
# from nltk.classify import DecisionTreeClassifier
import random


"""
* @def name:		getClassifier(negativeFeatures, positiveFeatures)
* @description:		This function returns bigrams.
* @related issues:	ITL-002
* @param:			list negativeFeatures
* @param:			list positiveFeatures
* @return:			object classifier
* @author:			Don Hsieh
* @since:			03/24/2015
* @last modified:	03/24/2015
* @called by:		main
*					 in wd/python/classifier.py
"""
# http://streamhacker.com/2010/05/24/text-classification-sentiment-analysis-stopwords-collocations/
# def evaluate_classifier():
def getClassifier(negativeFeatures, positiveFeatures):
	# negCutoff = int(len(negativeFeatures)*3/4)
	# posCutoff = int(len(positiveFeatures)*3/4)
	# random.shuffle(negativeFeatures)
	# random.shuffle(positiveFeatures)
	# trainFeatures = negativeFeatures[:negCutoff] + positiveFeatures[:posCutoff]
	# testFeatures = negativeFeatures[negCutoff:] + positiveFeatures[posCutoff:]
	trainFeatures = negativeFeatures + positiveFeatures
	classifier = NaiveBayesClassifier.train(trainFeatures)
	return classifier


"""
* @def name:		evaluate_classifier(negativeFeatures, positiveFeatures)
* @description:		This function returns bigrams.
* @related issues:	ITL-002
* @param:			list negativeFeatures
* @param:			list positiveFeatures
* @return:			void
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/20/2015
* @called by:		def getBigram()
*					 in wd/python/bigram.py
"""
# http://streamhacker.com/2010/05/24/text-classification-sentiment-analysis-stopwords-collocations/
# def evaluate_classifier():
def evaluate_classifier(negativeFeatures, positiveFeatures):
	negCutoff = int(len(negativeFeatures)*3/4)
	posCutoff = int(len(positiveFeatures)*3/4)
	# print negCutoff
	# print posCutoff
	random.shuffle(negativeFeatures)
	random.shuffle(positiveFeatures)

	trainFeatures = negativeFeatures[:negCutoff] + positiveFeatures[:posCutoff]
	testFeatures = negativeFeatures[negCutoff:] + positiveFeatures[posCutoff:]

	# print trainFeatures[0]
	# print trainFeatures[-1]
	# print len(trainFeatures)
	# print type(trainFeatures)
	# print trainFeatures[0]

	# print '\n\ntestFeatures:'
	# print testFeatures[-1]
	# print len(testFeatures)
	# print type(testFeatures)
	# print testFeatures[0]

	classifier = NaiveBayesClassifier.train(trainFeatures)
	# classifier = MaxentClassifier.train(trainFeatures)
	# classifier = DecisionTreeClassifier.train(trainFeatures)

	refsets = collections.defaultdict(set)
	testsets = collections.defaultdict(set)
	
	for i, (feats, label) in enumerate(testFeatures):
			# print 'i = ' + str(i)
			# print 'label = ' + str(label)
			refsets[label].add(i)
			observed = classifier.classify(feats)
			# print observed
			testsets[observed].add(i)

	# print '\n\nrefsets:'
	# print refsets[-1]
	# print len(refsets)
	# print type(refsets)
	# print refsets[0]

	# print '\n\ntestsets:'
	# print testsets[-1]
	# print len(testsets)
	# print type(testsets)
	# print testsets[0]

	print 'accuracy:', nltk.classify.util.accuracy(classifier, testFeatures)
	# print 'positive precision:', nltk.metrics.precision(refsets['pos'], testsets['pos'])
	# print 'positive recall:', nltk.metrics.recall(refsets['pos'], testsets['pos'])
	# print 'negative precision:', nltk.metrics.precision(refsets['neg'], testsets['neg'])
	# print 'negative recall:', nltk.metrics.recall(refsets['neg'], testsets['neg'])
	print 'positive precision:', nltk.metrics.precision(refsets[1], testsets[1])
	print 'positive recall:', nltk.metrics.recall(refsets[1], testsets[1])
	print 'negative precision:', nltk.metrics.precision(refsets[0], testsets[0])
	print 'negative recall:', nltk.metrics.recall(refsets[0], testsets[0])
	classifier.show_most_informative_features()
	# return classifier


"""
* @def name:		getFeature(words)
* @description:		This function returns feature containing unigram and bigram.
* @related issues:	ITL-002
* @param:			list words
* @return:			dict features
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/20/2015
* @called by:		def getFeatures(where, label)
*					 in wd/python/bayes.py
"""
# http://www.nltk.org/api/nltk.classify.html
# train_toks (list(tuple(dict, str))) – Training data, represented as a list of pairs,
# the first member of which is a feature dictionary, and the second of which is a classification label.
# def getFeature(words, count, label):
# def getFeature(words, label):
def getFeature(words):
	# print len(words)
	if len(words) > 6000:
		print 'words count: ' + str(len(words))
		# words = words[:4000]
	# if len(words) > 3000:
	# 	print len(words)
	# 	words = words[:3000]
	# if len(words) > 10000:
	# 	words = words[:10000]

	count = 30		# accuracy: 0.966183574879
	# count = 50		# accuracy: 0.95652173913
	# count = 100		# accuracy: 0.946859903382
	# count = 150	# accuracy: 0.937198067633
	# http://www.nltk.org/book/ch06.html
	feature = {}
	# features = dict()
	bcf = BigramCollocationFinder.from_words(words)
	bigrams = bcf.nbest(BigramAssocMeasures.likelihood_ratio, count)	#accuracy: 0.946859903382
	# bigrams = bcf.nbest(BigramAssocMeasures.chi_sq, count)			#accuracy: 0.642512077295
	# print bigrams
	# print len(bigrams)

	for bigram in bigrams:
		s = bigram[0] + ' ' + bigram[1]
		feature[s] = True

	# not helpful
	# lst = ['facebook', 'vehicl', 'disclaim', 'cost', 'appli', 'direct', 'court']
	lst = ['facebook', 'vehicl', 'disclaim', 'cost', 'appli', 'direct', 'high court']
	for s in lst:
		feature["count(%s)" % s] = words.count(s)

	words = stopword(words)
	words = words[:50]	#accuracy: 0.966183574879
	# words = words[:100]	#accuracy: 0.966183574879
	# head = words[:50]		#accuracy: 0.80193236715
	# tail = words[-50:]
	# head = words[:30]		#accuracy: 0.80193236715
	# tail = words[-30:]
	# head.extend(tail)	#accuracy: 0.966183574879
	# words = list(set(head))	#accuracy: 0.966183574879
	# words = head	#accuracy: 0.966183574879
	# # head = words[:50]
	# # tail = words[-50:]
	# # print head
	# # print tail
	# # words = words[:50].extend(words[50:])	#accuracy: 0.966183574879
		
	# print len(words)
	# head = words[:50].extend(words[-50:])
	# print words
	# raise
	for word in words:
		if not isNumber(word):
			# features["has(%s)" % word] = True
			feature[word] = True

	# features = (features, label)
	return feature



"""
* @def name:		tokenize(s)
* @description:		This function tokenizes a string and stems it's tokens.
* @related issues:	ITL-002
* @param:			string s
* @return:			list lst
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/18/2015
* @called by:		def getBigram()
*					 in wd/python/bigram.py
"""
def tokenize(s):
	# if len(s) > 80000:
	# 	print len(s)
	# 	s = s[:80000]
	if len(s) > 100000:
		# print 'words count: ' + str(len(words))
		print 'string length: ' + str(len(s))
		# print len(s)
		s = s[:100000]
		print 'string length: ' + str(len(s))
	s = s.encode('utf-8').strip().decode('ascii', 'ignore')
	text = s.lower()
	# s = don.neat(s)
	lst = []

	for sent in nltk.sent_tokenize(text):
		for word in nltk.word_tokenize(sent):
			# s = neat(word)
			s = word.strip(', _\t\n\r"()[]:/-.;`*')
			if isinstance(s, (basestring, unicode)) and len(s) > 1 and len(s) < 30 and '?' not in s and ')' not in s:
				if s != "'s":
					s = stemming(s)
					lst.append(s)
	# words = words[:800]
	# lst = lst[:300]
	return lst


"""
* @def name:		stemming(s)
* @description:		This function stems a word.
* @related issues:	ITL-002
* @param:			string s
* @return:			string s
* @author:			Don Hsieh
* @since:			03/17/2015
* @last modified:	03/17/2015
* @called by:		def getTokens()
*					 in wd/python/tokens.py
*					def tokenize(s)
*					 in wd/python/don.py
"""
def stemming(s):
	snowball_stemmer = SnowballStemmer('english')
	wordnet_lemmatizer = WordNetLemmatizer()
	s = snowball_stemmer.stem(s)
	s = wordnet_lemmatizer.lemmatize(s)
	return s




"""
* @def name:		timeDiff(start, end, format)
* @description:		This function returns an object "duration" for time difference.
* @related issues:	ITL-002
* @param:			string start
* @param:			string end
* @param:			string format
* @return:			object duration
* @author:			Don Hsieh
* @since:			03/19/2015
* @last modified:	03/19/2015
* @called by:		main
*					 in python/bigram.py
"""
def timeDiff(start, end, format=None):
	if format is None: format = '%Y/%m/%d %a %H:%M:%S'
	startDateStruct = datetime.strptime(start, format)
	endDateStruct = datetime.strptime(end, format)
	duration = endDateStruct - startDateStruct
	return duration


"""
* @def name:		stopword(s)
* @description:		This function tokenizes a string and removes stop words from it.
* @related issues:	ITL-002
* @param:			string s
* @return:			list lst
* @author:			Don Hsieh
* @since:			03/17/2015
* @last modified:	03/17/2015
* @called by:		def getTokens()
*					 in wd/python/tokens.py
"""
# http://streamhacker.com/2010/05/24/text-classification-sentiment-analysis-stopwords-collocations/
# Accuracy went down .2%, and pos precision and neg recall dropped as well!
# Apparently stopwords add information to sentiment analysis classification.
def stopword(words):
	words = list(set(words))
	# word_list = word_tokenize(s)
	stopset = set(stopwords.words('english'))
	# lst = [w.strip() for w in word_list if w.strip() not in stopset]
	lst = [w.strip() for w in words if w.strip() not in stopset]
	return lst
# def stopword(s):
# 	word_list = word_tokenize(s)
# 	stopset = set(stopwords.words('english'))
# 	lst = [w.strip() for w in word_list if w.strip() not in stopset]
# 	return lst



"""
* @def name:		isNumber(s)
* @description:		This function returns True if s is numeric, False otherwise.
* @related issues:	ITL-002
* @param:			mixed s
* @return:			boolean
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		def getTokens()
*					 in wd/python/tokens.py
"""
# http://www.pythoncentral.io/how-to-check-if-a-string-is-a-number-in-python-including-unicode/
def isNumber(s):
	s = s.replace('-', '').replace(',', '').replace('$', '').replace('(', '').replace(')', '')
	try:
		float(s)
		return True
	# except ValueError:
		# return False
	except ValueError:
		pass
	try:
		import unicodedata
		unicodedata.numeric(s)
		return True
	except (TypeError, ValueError):
		pass
	return False





"""
* @def name:		neat(s)
* @description:		This function neats a string and removes unwatned characters.
* @related issues:	ITL-002
* @param:			mixed s
* @return:			string s
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		def readXls(xls)
*					 in python/don.py
"""
# http://stackoverflow.com/questions/18664712/split-function-add-xef-xbb-xbf-n-to-my-list
# data = data.decode("utf-8-sig").encode("utf-8")
# But better don't encode it back to utf-8, but work with unicoded text.
# There is a good rule - decode all your input text data to unicode as soon as possible, and work inside only with unicode, and encode the output data to required encoding as later as possible.
# This will save you from many headaches.
def neat(s):
	if isinstance(s, float): s = str(int(s))
	if isinstance(s, (basestring, unicode)) and s != '':
		#s = s.encode('utf-8')
		#http://stackoverflow.com/questions/1010961/string-slicing-python
		if s.endswith('.0'): s = s[:-2]		#remove trailing '.0' in s
		s = s.strip(', _\t\n\r')
		s = re.sub('\t+', ' ', s)
		s = re.sub(' +', ' ', s)
		#s = re.sub('\n+', '\n', s)
		#s = " ".join(s.split()) # same as s = re.sub(' +', ' ', s)
		s = s.replace('  ', ' ');
		s = s.replace('__', '_');
		s = s.replace('\n', '');
		s = s.replace('\r', '');
		#s = s.replace(u'\xa0', u' ');	#Remove \xa0
		#\xa0 is actually non-breaking space in Latin1 (ISO 8859-1), also chr(160).
		#http://stackoverflow.com/questions/10993612/python-removing-xa0-from-string
		s = s.strip(', _\t\n\r')
	return s

"""
* @def name:		setTimeFormat(time, formatOld, format)
* @description:		This function converts a data to new format.
* @related issues:	ITL-002
* @param:			string time
* @param:			string formatOld
* @param:			string format
* @return:			string date
* @author:			Don Hsieh
* @since:			03/20/2015
* @last modified:	03/23/2015
* @called by:		main
*					 in python/bayes.py
"""
# def getXlrdDate(dateXlrd, xls):
def getXlrdDate(dateXlrd):
	if isinstance(dateXlrd, (basestring, unicode)): date = dateXlrd.strip()
	else:
		# book = xlrd.open_workbook(xls)
		# date = xlrd.xldate_as_tuple(dateXlrd, book.datemode)
		# print book.datemode	#0
		# print xlrd.open_workbook('/var/www/intelllex/data/ITL-002_URL_20150319.xlsx').datemode
		# raise
		# date = xlrd.xldate_as_tuple(dateXlrd, book.datemode)
		date = xlrd.xldate_as_tuple(dateXlrd, 0)
		# print date
		date = datetime(*date)
		# print date
		date = setTimeFormat(str(date), '%Y-%m-%d %H:%M:%S', '%Y/%m/%d')
		# print date
		# raise
	return date


"""
* @def name:		setTimeFormat(time, formatOld, format)
* @description:		This function converts a data to new format.
* @related issues:	ITL-002
* @param:			string time
* @param:			string formatOld
* @param:			string format
* @return:			string date
* @author:			Don Hsieh
* @since:			03/20/2015
* @last modified:	03/20/2015
* @called by:		def getXlrdDate(dateXlrd, xls)
*					 in python/don.py
"""
def setTimeFormat(time, formatOld, format):
	dateStruct = datetime.strptime(time, formatOld)
	#print dateStruct
	date = dateStruct.strftime(format)
	return date


"""
* @def name:		writeXls(xls, table, fields, names=None)
* @description:		This function exports data from table to xls file.
* @related issues:	ITL-002
* @param:			string xls
* @param:			string table
* @param:			list fields
* @param:			list names		first row in Excel file (Display column names)
* @return:			void
* @author:			Don Hsieh
* @since:			03/20/2015
* @last modified:	03/25/2015
* @called by:		main
*					 in python/excel.py
"""
def writeXls(xls, rows, fields):
	if isinstance(fields, (basestring, unicode)): fields = fields.split(', ')

	workbook = xlwt.Workbook()
	sheet = workbook.add_sheet('case')
	# rows = queryDB('seo', table, fields)
	# cntInputSites = len(rows)
	#print rows

	col = 0
	for field in fields:
		sheet.write(0, col, field)
		col += 1

	key = 1
	for row in rows:
		col = 0
		for cell in row:
			#cell = cutString(cell, 3000)
			sheet.write(key, col, cell)
			col += 1
		key += 1


	# xlsName = xls.split('/')[-1]
	# inputName = xlsName.split('_')[-1]
	# print inputName
	# #xlsNameNew = xlsName.replace(inputName, table + '.xls')
	# #date = getNow('%Y-%m-%d')
	# date = getNow('%y%m%d')
	# # xlsNameNew = 'ITL-002_URL_' + str(cntInputSites) + '_cases_' + date + '.xls'
	# xlsNameNew = 'ITL-002_URL_' + date + '_Don.xls'
	# print xlsName
	# xls = xls.replace(xlsName, '[Don] ' + xlsNameNew)
	# #xls = xls.replace('.xlsx', '.xls')
	# print xls
	#raise
	workbook.save(xls)








"""
* @def name:		readXls(xls)
* @description:		This function reads content of xls file.
* @related issues:	ITL-002
* @param:			string xls
* @return:			list rows
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		def getContent()
*					 in python/tokens.py
"""
def readXls(xls):
	try:
		workbook = xlrd.open_workbook(xls)
		#print workbook
		worksheet = workbook.sheet_by_index(0)
		num_rows = worksheet.nrows - 1
		row = worksheet.row(0)

		fields = []
		for col in range(len(row)):
			field = worksheet.cell_value(0, col)
			fields.append(field)

		key = 0
		strShow = ''
		row0 = worksheet.row(key)
		#print row0
		rows = []
		for key in xrange(1, num_rows+1):
			#if key % 50 == 0: print key
			args = []
			for col in range(len(row0)):
				s = worksheet.cell_value(key, col)
				if isinstance(s, basestring):
					#s = s.strip()
					s = neat(s)
					if len(s) == 0: s = None
				args.append(s)
				#print args
			rows.append(args)
		return rows
	except xlrd.XLRDError as e: #<-- Qualified error here
		no_termina = False
		print 'Error occurs'
		print e



"""
* @def name:		updateDB(dbName, table, fields, where, args)
* @description:		This function updates data into database.
* @related issues:	ITL-002
* @param:			string dbName
* @param:			string table
* @param:			string fields
* @param:			string where
* @param:			list args
* @return:			void
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		def getTokens()
*					 in python/tokens.py
"""
def updateDB(dbName, table, fields, where, args):
	if args is None: return False
	if len(args) < 1: return False
	arr = fields.split(', ')
	#print len(arr)
	#print len(args)
	lst = []
	for s in arr:
		s = '`' + s + '`=%s'
		lst.append(s)
	fields = (', ').join(lst)

	#if where is not None: sql += ' WHERE ' + where

	fieldsCount = len(fields.split(', '))
	arr = []
	for i in range(fieldsCount):
		arr.append('%s')
	values = ', '.join(arr)
	values = '(' + values + ')'

	sql = 'UPDATE ' + table + ' SET ' + fields + ' WHERE ' + where
	# print sql
	# print args
	rows = doSQL(dbName, table, sql, args)



"""
* @def name:		queryDB(dbName, table, fields, where=None, args=None)
* @description:		This function returns query result of given SQL command.
* @related issues:	ITL-001
* @param:			string dbName
* @param:			string table
* @param:			string fields
* @param:			string where
* @param:			tuple args
* @return:			list rows
* @author:			Don Hsieh
* @since:			03/04/2015
* @last modified:	03/04/2015
* @called by:		main
*					 in python/parse.py
"""
def queryDB(dbName, table, fields, where=None, args=None):
	sql = 'SELECT ' + fields + ' FROM `' + table + '`'
	if where is not None: sql += ' WHERE ' + where
	rows = doSQL(dbName, table, sql, args)
	return rows



"""
* @def name:		timeDiff(start, end, format)
* @description:		This function returns an object "duration" for time difference.
* @related issues:	ITL-001
* @param:			string start
* @param:			string end
* @param:			string format
* @return:			object duration
* @author:			Don Hsieh
* @since:			03/04/2015
* @last modified:	03/04/2015
* @called by:		def getHeader(issueId, jiraAuth)
*					 in python/summary.py
"""
def timeDiff(start, end, format=None):
	# if format is None: format = '%Y/%m/%d %a %H:%M:%S'
	if format is None: format = '%Y-%m-%d %H:%M:%S'
	startDateStruct = datetime.strptime(start, format)
	endDateStruct = datetime.strptime(end, format)
	duration = endDateStruct - startDateStruct
	return duration


"""
* @def name:		getNow(format=None)
* @description:		This function returns a string of time of now.
* @related issues:	ITL-001
* @param:			string format=None
* @return:			string now
* @author:			Don Hsieh
* @since:			03/04/2015
* @last modified:	03/04/2015
* @called by:		main
*					 in python/parse.py
"""
def getNow(format=None):
	#if format is None: format = '%Y/%m/%d %a %H:%M:%S'
	if format is None: format = '%Y-%m-%d %H:%M:%S'
	now = datetime.now().strftime(format)
	return now


"""
* @def name:		getLength(s)
* @description:		This function gets length of input.
* @related issues:	ITL-001
* @param:			string s
* @return:			integer length
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		def setMaxLength(l, key, s)
*					 in python/don.py
"""
def getLength(s):
	length = -1
	if s is None: return 0
	if isinstance(s, (int, long, float)): s = str(s)
	length = len(s)
	return length


"""
* @def name:		setMaxLength(l, key, s)
* @description:		This function sets max length of a field in a list.
* @related issues:	ITL-001
* @param:			list l
* @param:			integer key
* @param:			string s
* @return:			list l
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		def getMaxLengthOfFields(row, lstLength)
*					 in python/don.py
"""
def setMaxLength(l, key, s):
	if key < len(l):
		length = l[key]
		if l[key] < getLength(s): l[key] = getLength(s)
	return l


"""
* @def name:		getMaxLengthOfFields(row, lstLength)
* @description:		This function gets max length of each fields in rows.
* @related issues:	ITL-001
* @param:			[list or tuple] row
* @param:			list lstLength
* @return:			void
* @author:			Don Hsieh
* @since:			03/04/2015
* @last modified:	03/04/2015
* @called by:		main
*					 in python/parse.py
"""
def getMaxLengthOfFields(row, lstLength):
	# print row
	# print lstLength
	if row is not None:
		for key, s in enumerate(row):
			lstLength = setMaxLength(lstLength, key, s)
	return lstLength


"""
* @def name:		getMaxLengthOfEachField(rows)
* @description:		This function gets max length of each fields in rows.
* @related issues:	ITL-001
* @param:			list rows
* @return:			void
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		main
*					 in python/parse.py
"""
def getMaxLengthOfEachField(rows):
	lstLength = []
	for col in range(len(rows[0])):
		lstLength.append(-1)
	# print rows
	# print lstLength

	for row in rows:
		key = 0
		for s in row:
			lstLength = setMaxLength(lstLength, key, s)
			key += 1
	print lstLength





"""
* @def name:		insertDB(dbName, table, fields, args)
* @description:		This function inserts data into database.
* @related issues:	ITL-001
* @param:			string dbName
* @param:			string table
* @param:			string fields
* @param:			tuple args
* @return:			void
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		def parseContent(s)
*					 in python/parse.py
"""
def insertDB(dbName, table, fields, args):
	if args is None: return False
	if len(args) < 1: return False
	fieldsCount = len(fields.split(', '))
	arr = []
	for i in range(fieldsCount):
		arr.append('%s')
	values = ', '.join(arr)
	values = '(' + values + ')'
	sql = 'INSERT INTO `' + table + '`(' + fields + ') VALUES ' + values
	rows = doSQL(dbName, table, sql, args)



"""
* @def name:		doSQL(dbName, table, sql, args)
* @description:		This function executes SQL command and returns result.
* @related issues:	ITL-001
* @param:			string dbName
* @param:			string table
* @param:			string sql
* @param:			[tuple, list, or None] args
* @return:			list rows
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:		def insertDB(dbName, table, fields, args)
*					def queryDB(dbName, table, fields, where=None, args=None)
*					 in python/don.py
"""
def doSQL(dbName, table, sql, args):
	f = open('/home/db.txt', 'r')
	line =  f.read().strip()
	#print line
	mydb = MySQLdb.connect(
		host='localhost',
		user='root',
		passwd=line,
		charset='utf8',
		db=dbName
	)
	cursor = mydb.cursor()
	multipleRowsOfArgs = False
	if args is not None:
		if args[0] is not None and isinstance(args[0], (list, tuple)):
			multipleRowsOfArgs = True
		for i in range(len(args)):
			if isinstance(args[i], list): args[i] = tuple(args[i])
		if isinstance(args, list): args = tuple(args)
	try:
		if multipleRowsOfArgs: cursor.executemany(sql, args)
		else: cursor.execute(sql, args)
		rows = cursor.fetchall()
		mydb.commit()
		cursor.close()
		return rows
	except IOError as e:
		print "I/O error({0}): {1}".format(e.errno, e.strerror)
		mydb.rollback()
		mydb.commit()
		cursor.close()
		print e
	except ValueError as valueErr:
		print "ValueError"
		print valueErr
		mydb.rollback()
		mydb.commit()
		cursor.close()
	except:
		print "Unexpected error:", sys.exc_info()[0]
		mydb.rollback()
		mydb.commit()
		cursor.close()
		raise