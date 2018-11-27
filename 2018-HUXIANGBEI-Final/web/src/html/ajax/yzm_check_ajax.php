<?php
if(!isset($_SESSION)){session_start();} 
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
$id=$_GET['id'];//ID值是传过来的$yzm_mobile
$founderr=0;
if ($id==''){
$founderr=1;
$msg= "请输入验证码";
}else{
	if(time()-intval(@$_SESSION['yzm_sendtime'])>120){
	$founderr=1;
	$msg="请重新获取验证码";
	}else{
		if ($id!=@$_SESSION['yzm_mobile']){
		$founderr=1;
		$msg="验证码不正确";
		}
	}
}
	
	if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.yzm_mobile2.value='no';</script>";
	}else{
	echo "<img src=/image/dui2.png>";
	echo "<script>window.document.userreg.yzm_mobile2.value='yes';</script>";
	echo "<script>document.userreg.yzm_mobile.style.border = '1px solid #dddddd';</script>";
	}
?>
</body>
</html>