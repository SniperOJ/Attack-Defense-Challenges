<?php
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>
<body>
<?php
$action=$_GET['action'];
$id=$_GET['id'];
switch ($action){
case "checktel";
checktel($id);
break;
}

function checktel($id){
$founderr=0;
if ($id==''){
	$founderr=1;
	$msg= "请输入手机";
}else{
	if(!preg_match("/1[3458]{1}\d{9}$/",$id)){
	$founderr=1;
	$msg= "手机号码不正确";
	}
}	

if ($founderr==1){
echo "<span class='boxuserreg'>".$msg."</span>";
echo "<script>window.document.ly.tel2.value='no';</script>";
}else{
echo "<img src='/image/dui2.png'>";
echo "<script>window.document.ly.tel2.value='yes';</script>";
echo "<script>document.ly.tel.style.border = '1px solid #dddddd';</script>";
}
}
?>
</body>
</html>