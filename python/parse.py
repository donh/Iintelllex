#!/usr/bin/env python
# -*- coding: utf-8 -*-
#python /var/www/intelllex/python/parse.py

"""
* @python name:		python/parse.py
* @description:		This file reads "pin_henry" table and writes to "dress" table.
* @related issues:	ITL-001
* @author:			Don Hsieh
* @since:			03/03/2015
* @last modified:	03/03/2015
* @called by:
"""



#import don
##ITL-001

filepath = '/var/www/intelllex/data/dump2'
s = ''
block = ''
with open(filepath) as f:
	# content = f.readlines()
	lines = f.readlines()
	# print lines
	print type(lines)
	# raise
	for line in lines:
		# line = line.strip()
		
		# print line
		# if line == 'Recno:: 2': raise
		if 'Recno:: ' in line:
			block = s
			s = ''
		else: s += line
		if len(block) > 1500:
			print block
			print len(block)
			block = block.split('Content::')[-1]
			print block
			header = block.split('Content:')[0].split('\n')
			# body = block.split('Content:')[-1].lstrip()
			content = block.split('Content:')[-1].lstrip()
			print content
			print header
			url = ''
			application_type = ''
			for string in header:
				if 'url: http' in string:
					url = string.split('url: ')[-1]
				elif 'contentType: ' in string:
					application_type = string.split('contentType: ')[-1]
			print url
			print application_type
			raise
		# Recno:: 1
		# s += line.strip()
		# print line
		# raise



print "Done"