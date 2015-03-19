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
from nltk.classify import MaxentClassifier

"""
* @def name:		evaluate_classifier()
* @description:		This function returns bigrams.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/18/2015
* @called by:		def getBigram()
*					 in wd/python/bigram.py
"""
# http://streamhacker.com/2010/05/24/text-classification-sentiment-analysis-stopwords-collocations/
def evaluate_classifier():
	dbName = 'intelllex'
	table = 'tokens'
	fields = 'id, useful, content'
	# where = None
	where = '`useful` = 0 AND `content_len` > 5'
	# where = '`useful` = 1'
	rows = queryDB(dbName, table, fields, where)
	# print rows
	# print len(rows)
	negids = []
	negfeats = []
	# raise
	for row in rows:
		negid = int(row[0])
		negids.append(negid)

		content = row[2]
		words = tokenize(content)
		# words = words[:800]
		# words = words[:300]
		# feature = getFeature(words, 50, 0)
		# feature = getFeature(words, 50, 'neg')
		feature = getFeature(words, 'neg')
		negfeats.append(feature)
		

	posids = []
	posfeats = []
	where = '`useful` = 1 AND `content_len` > 5'
	rows = queryDB(dbName, table, fields, where)
	# print rows
	# print len(rows)
	for row in rows:
		posid = int(row[0])
		posids.append(posid)

		content = row[2]
		# words = tokenize(content)
		words = tokenize(content)
		# feature = getFeature(words, 50, 1)
		# feature = getFeature(words, 50, 'pos')
		feature = getFeature(words, 'pos')
		posfeats.append(feature)




	# print negids
	# print posids
	# print negfeats
	# print posfeats
	print len(negfeats)
	print len(posfeats)
	# raise


	# negids = movie_reviews.fileids('neg')
	# posids = movie_reviews.fileids('pos')

	# negfeats = [(feature(movie_reviews.words(fileids=[f])), 'neg') for f in negids]
	# posfeats = [(feature(movie_reviews.words(fileids=[f])), 'pos') for f in posids]

	# negcutoff = int(floor(len(negfeats)*3/4))
	# poscutoff = int(floor(len(posfeats)*3/4))
	negcutoff = int(len(negfeats)*3/4)
	poscutoff = int(len(posfeats)*3/4)
	print negcutoff
	print poscutoff

	trainfeats = negfeats[:negcutoff] + posfeats[:poscutoff]
	testfeats = negfeats[negcutoff:] + posfeats[poscutoff:]

	# print trainfeats[0]
	print trainfeats[-1]
	print len(trainfeats)
	print type(trainfeats)
	print trainfeats[0]

	print '\n\ntestfeats:'
	print testfeats[-1]
	print len(testfeats)
	print type(testfeats)
	print testfeats[0]

	# classifier = NaiveBayesClassifier.train(trainfeats)
	classifier = MaxentClassifier.train(trainfeats)
	# classifier = NaiveBayesClassifier.train(trainfeats, 5)
	refsets = collections.defaultdict(set)
	testsets = collections.defaultdict(set)
	
	for i, (feats, label) in enumerate(testfeats):
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

	print 'accuracy:', nltk.classify.util.accuracy(classifier, testfeats)
	print 'positive precision:', nltk.metrics.precision(refsets['pos'], testsets['pos'])
	print 'positive recall:', nltk.metrics.recall(refsets['pos'], testsets['pos'])
	print 'negative precision:', nltk.metrics.precision(refsets['neg'], testsets['neg'])
	print 'negative recall:', nltk.metrics.recall(refsets['neg'], testsets['neg'])
	classifier.show_most_informative_features()





"""
* @def name:		getBigrams(words, count)
* @description:		This function returns bigrams.
* @related issues:	ITL-002
* @param:			list words
* @param:			integer count
* @return:			list bigrams
* @author:			Don Hsieh
* @since:			03/18/2015
* @last modified:	03/19/2015
* @called by:		def getBigram()
*					 in wd/python/bigram.py
"""
# http://www.nltk.org/api/nltk.classify.html
# train_toks (list(tuple(dict, str))) – Training data, represented as a list of pairs,
# the first member of which is a feature dictionary, and the second of which is a classification label.
# def getFeature(words, count, label):
def getFeature(words, label):
	count = 100		# accuracy: 0.946859903382
	# count = 150	# accuracy: 0.937198067633
	# http://www.nltk.org/book/ch06.html
	features = {}
	# features = dict()
	bcf = BigramCollocationFinder.from_words(words)
	# print bcf.nbest(BigramAssocMeasures.likelihood_ratio, 10)
	# print bcf.nbest(BigramAssocMeasures.likelihood_ratio, 50)
	# print bcf.nbest(BigramAssocMeasures.chi_sq, 50)
	bigrams = bcf.nbest(BigramAssocMeasures.likelihood_ratio, count)	#accuracy: 0.946859903382
	# bigrams = bcf.nbest(BigramAssocMeasures.chi_sq, count)			#accuracy: 0.642512077295
	# print bigrams
	# print len(bigrams)
	
	for bigram in bigrams:
		# feature = {'bigram':bigram[0] + ' ' + bigram[1]}
		s = bigram[0] + ' ' + bigram[1]
		# features["has(%s)" % s] = True
		features[s] = True
	
	words = stopword(words)
	words = words[:10]
	for word in words:
		if not isNumber(word):
			# features["has(%s)" % word] = True
			features[word] = True

	features = (features, label)

	# http://stackoverflow.com/questions/1024847/add-to-a-dictionary-in-python
	# data = {'a':1,'b':2,'c':3}

	# features = list(set(features))
	# print features
	# raise
	# feature = dict([(ngram, True) for ngram in itertools.chain(words, bigrams)])
	return features





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
	s = s.encode('utf-8').strip().decode('ascii', 'ignore')
	text = s.lower()
	# s = don.neat(s)
	lst = []

	for sent in nltk.sent_tokenize(text):
		for word in nltk.word_tokenize(sent):
			# s = neat(word)
			s = word.strip(', _\t\n\r"()[]:/-.;`*')
			if isinstance(s, (basestring, unicode)) and len(s) > 1 and '?' not in s and ')' not in s:
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
	print sql
	print args
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