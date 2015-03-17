#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/tokens.py

#sudo apt-get install python-dev; sudo pip install -U numpy; sudo pip install -U nltk
#python -m nltk.downloader stopwords; python -m nltk.downloader punkt; python -m nltk.downloader wordnet

"""
* @python name:		python/tokens.py
* @description:		This file reads "pin_henry" table and writes to "dress" table.
* @related issues:	ITL-002
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:
"""



"""
* @def name:		getContent()
* @description:		This function gets content from "document2" table and writes to "tokens" table.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/16/2015
* @last modified:	03/16/2015
* @called by:		main
*					 in python/tokens.py
"""
def getContent():
	xls = '/var/www/intelllex/data/ITL-002_URL_20150314.xlsx'
	rows = don.readXls(xls)
	cases = []
	for row in rows:
		isCase = row[1]
		if isCase is not None:
			url = row[0]
			cases.append([url.strip(), int(isCase)])
	# print cases
	print len(cases)

	dbName = 'intelllex'
	table = 'document2'
	fields = 'url, content, title'

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
		content = row[1]
		content_len = len(content)
		title = row[2]
		now = don.getNow()
		table = 'tokens'
		fields = 'url, content, content_len, useful, title, createdAt'
		args = (url, content, content_len, isCase, title, now)
		don.insertDB(dbName, table, fields, args)


"""
* @def name:		getTokens()
* @description:		This function removes stop words from content, handles stemming,
*					 and writes to "tokens" column.
* @related issues:	ITL-002
* @param:			void
* @return:			void
* @author:			Don Hsieh
* @since:			03/17/2015
* @last modified:	03/17/2015
* @called by:		main
*					 in python/tokens.py
"""
def getTokens():
	# snowball_stemmer = SnowballStemmer('english')
	# wordnet_lemmatizer = WordNetLemmatizer()

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
		# content = content.decode('ascii', 'ignore')
		content = content.encode('utf-8').strip().decode('ascii', 'ignore')
		content = content.lower()
		content = don.neat(content)
		# content = content.split(' ')
		# word_list = word_tokenize(content)
		# http://stackoverflow.com/questions/5499702/stop-words-nltk-python-problem
		# word_list2 = [w.strip() for w in word_list if w.strip() not in nltk.corpus.stopwords.words('english')]
		# lst = [w.strip() for w in content if w.strip() not in nltk.corpus.stopwords.words('english')]
		# lst = [w.strip() for w in word_list if w.strip() not in nltk.corpus.stopwords.words('english')]

		lst = don.stopword(content)

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
		









import don


dbName = 'intelllex'
# getContent()
getTokens()

# nltk.download()
# raise

print "Done"