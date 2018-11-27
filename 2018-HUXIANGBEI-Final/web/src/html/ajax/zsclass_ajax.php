<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
</head>
<body>
<?php  
define('zzcmsroot', str_replace("\\", '/', substr(dirname(__FILE__), 0, -4)));//-4截除当前目录ajax
include("../inc/function.php");
$id=$_GET['id']; 
$classzm=pinyin($id);
$rt="<input name=classzm type=text id=classzm size=60 maxlength=30 value='".$classzm."'>";
echo $rt;  
?> 
 </body>
 </html>