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
import MySQLdb


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
* @called by:		main
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

