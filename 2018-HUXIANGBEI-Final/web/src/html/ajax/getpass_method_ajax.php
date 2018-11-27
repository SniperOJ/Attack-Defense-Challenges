<?php
if(!isset($_SESSION)){session_start();} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>
<body>
<?php
$id=$_GET['id'];
$_SESSION['getpass_method']=$id;
//echo $_SESSION['getpass_method'];
session_write_close();
?>
</body>
</html>