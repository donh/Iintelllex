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


"""
* @def name:		readXls(xls)
* @description:		This function reads content of xls file.
* @related issues:	WD-001
* @related issues:	SEO-021
* @param:			string xls
* @return:			void
* @author:			Don Hsieh
* @since:			03/26/2014
* @last modified:	04/28/2014
* @called by:		main
*					 in python/sb.py
*					 in python/xls.py
"""
def readXls(xls):
	#print xls
	try:
		workbook = xlrd.open_workbook(xls)
		#print workbook
		worksheet = workbook.sheet_by_index(0)
		num_rows = worksheet.nrows - 1
		row = worksheet.row(0)
		#print row
		fields = []
		for col in range(len(row)):
			field = worksheet.cell_value(0, col)
			fields.append(field)
		#print fields

		key = 0
		strShow = ''
		row0 = worksheet.row(key)
		#print row0
		rows = []
		for key in xrange(1, num_rows+1):
			#if key % 50 == 0: print key
			args = []
			#print row
			for col in range(len(row0)):
				s = worksheet.cell_value(key, col)
				if isinstance(s, basestring):
					#s = s.strip()
					#s = don.neat(s)
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

