#!/usr/bin/env python
# coding:utf-8

import requests
import sys
import numpy
import os
import hashlib
import sys
import glob
import fnmatch
import string
import random
import uuid

class ServiceNotWorkingCorrectly(Exception):
        def __init__(self, message):
            self.message = message
        def __str__(self):
            return repr("Service is not working correctly, %s" % (message))

class WafDetected(Exception):
        def __str__(self):
            return repr("Waf Detected")

def find(target, lines):
    for line in lines:
        if target in line:
            return line
    return None

def random_string(length):
    return "".join([random.choice(string.letters + string.digits) for i in range(length)])


class Checker(object):
    def __init__(self, host, port, username, password):
        self.session = requests.Session()
        self.host = host
        self.port = port
        self.username = username
        self.password = password

    def check_all(self):
        # Check common defense tools
        print "[CHECKING] check waf"
        if self.check_waf():
            raise WafDetected()
        print "[PASS] check waf"
        # Check default admin account
        print "[CHECKING] check login"
        if not self.check_login():
            raise ServiceNotWorkingCorrectly("Login failed")
        print "[PASS] check login"
        # Check add plugin
        print "[CHECKING] check plugin"
        if not self.check_plugin():
            raise ServiceNotWorkingCorrectly("Add plugin failed")
        print "[PASS] check plugin"
        # Check add comment
        print "[CHECKING] check comment"
        if not self.check_comment():
            raise ServiceNotWorkingCorrectly("Leave comment failed")
        print "[PASS] check comment"
        return "OK"

    def check_login(self):
        url = "http://%s:%d/zb_system/cmd.php?act=verify" % (self.host, self.port)
        data = {
            "username": self.username,
            "password": self.md5(self.password),
        }
        response = self.session.post(url, data=data)
        content = response.content
        return "后台首页" in content

    def check_comment(self):
        # varibles
        base_url = "http://%s:%d" % (self.host, self.port)
        comment_url = "%s/?id=2" % (base_url) 
        # fetch form action
        comment_page = self.session.get(comment_url).content
        action_url = find("frmSumbit", comment_page.split("\n")).split('action="')[1].split('" >')[0].replace("&amp;","&")
        if action_url == None:
            return False
        # Post payload
        token = str(uuid.uuid4())
        content = "你好，大神，我叫 Checker，可以留一个 /flag 交流一下吗？%s" % (token)
        data = {
                "action":action_url,
                "postid":0,
                "name":"checker",
                "email":"checker@chinaisg.org",
                "content":content,
                "homepage":"http://www.chinaisg.org",
                "replyid":0,
                "format":"json",
        }
        response = self.session.post(action_url, data=data)
        if token not in response.content:
            return False
        return True

    def check_plugin(self):
        url = "http://%s:%d/zb_users/plugin/AppCentre/plugin_edit.php" % (self.host, self.port)
        plugin_name = random_string(0x10)
        data = {
            "app_id": "%s" % (plugin_name),
            "app_path": "update.php",
        }
        response = self.session.post(url, data=data)
        if not response.headers['Set-Cookie'].startswith("hint_signal1=good"):
            return False
        if not response.headers['Location'] == "":
            return False
        if not response.content == "":
            return False
        # delete plugin
        url = "http://%s:%d/zb_users/plugin/AppCentre/app_del.php?type=plugin&id=%s" % (self.host, self.port, plugin_name)
        self.session.get(url)
        return True

    def check_waf(self):
	files = []
	for root, dirnames, filenames in os.walk('sources'):
	    for filename in fnmatch.filter(filenames, '*.php'):
                if "plugin" not in root:
		    files.append(os.path.join(root, filename))
        n = len(files)
        black_list = [
                "eval",
                "assert",
                "/flag",
                "system",
                "readfile",
                "shell_exec",
                "file_get_contents",
                "exec",
                "call_user_func",
                "passthru",
                "select","insert","update","delete","and","union","load_file","outfile","dumpfile","sub","hex","file_put_contents","fwrite","system","eval","assert","file://","passthru","exec","system","chroot","scandir","chgrp","chown","shell_exec","proc_open","proc_get_status","popen","ini_alter","ini_restore","`","dl","openlog","syslog","readlink","symlink","popepassthru","stream_socket_server","assert","pcntl_exec","base64_encode",
        ]
        result = []
        std_less_hit_times = 0
        for _ in range(3):
            not_ok_nu = 0
            for i in range(n):
                filename = random.choice(files)[len("sources/"):]
                url = "http://%s:%d/%s" % (self.host, self.port, filename)
                data = dict()
                for value in black_list:
                    key = random_string(0x10)
                    data[key] = value
                response = requests.post(url, params=data, data=data, cookies=data)
                if response.status_code != 200 and response.status_code != 500:
                    not_ok_nu += 1
                    continue
                else:
                    content = response.content
                    result.append(len(content))
            std = numpy.std(result)
            std_less_hit_times += std
            if not_ok_nu > (n / 2):
                return True
        if std_less_hit_times < 2000:
            return True
        return False

    def md5(self, content):
        return hashlib.md5(content).hexdigest()

def main():
    if len(sys.argv) != 5:
        print "Usage:"
        print "\tpython %s [HOST] [PORT] [USER] [PASSWORD]" % (sys.argv[0])
        print "Example:"
        print "\tpython %s 127.0.0.1 80 admin admin123" % (sys.argv[0])
        exit(0)
    host = sys.argv[1]
    port = int(sys.argv[2])
    username = sys.argv[3]
    password = sys.argv[4]
    checker = Checker(host, port, username, password)
    print checker.check_all()

if __name__ == '__main__':
    main()


