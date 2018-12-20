#!/usr/bin/python3
import sys

# print(sys.argv)

try:
	x = int(sys.argv[1])
	y = int(sys.argv[2])
except:
	print("Hibás argumentumok")
	print("Példa: ")
	print("./createTable 3 3")
	sys.exit(2)

def mezo(x,y):
	return ((x,y), '-')

table = []

for k in range(x):
	for l in range(y):
		table.append(mezo(k,l))

print(table)