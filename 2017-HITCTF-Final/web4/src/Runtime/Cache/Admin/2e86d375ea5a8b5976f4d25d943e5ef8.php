<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>自定义菜单管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
</head>
<body class="body">

<div class="title">
	<div class="left">自定义快捷菜单</div>
</div>
<div class="add">
<form action="?s=Admin-Nav-Update" method="post" name="myform" id="myform"> 
<ul style="padding:10px 0px">
 <textarea name="content" style="width:98%;height:320px"><?php if(is_array($array_nav)): $i = 0; $__LIST__ = $array_nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i; echo (htmlspecialchars($key)); ?>|<?php echo (htmlspecialchars($ppting)); echo(chr(13)); endforeach; endif; else: echo "" ;endif; ?></textarea>
</ul>  
<ul class="footer"><input type="submit" name="submit" value="提交"> <input type="reset" name="reset" value="重置"></ul>
</form>
</div>
<?php if(($_GET['reload']) == "1"): ?><script>window.parent.left.location.reload();</script><?php endif; ?>

</body>
</html>