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
$id=$_GET['id'];
checkusername($id);

function checkusername($id){
$founderr=0;
if ($id==''){
$founderr=1;
$msg= "请输入用户名";
}else{

	if(!ereg("^[a-zA-Z0-9_]{4,15}$",$id)){
	$founderr=1;
	$msg= "用户名只能为字母和数字，字符介于4到15个。";
	}else{ 

	$sqlreg="select username from zzcms_user where username='".$id."'";
	$rs = query($sqlreg);
	$row= num_rows($rs);//返回记录数
		if(!$row){ 
		$founderr=1;
		$msg= "该用户名不存在！";
		}
	}
}
	
	if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.username2.value='no';</script>";
	}else{
	echo "<img src=/image/dui2.png>";
	echo "<script>window.document.userreg.username2.value='yes';</script>";
	echo "<script>document.userreg.username.style.border = '1px solid #dddddd';</script>";
	}
}
?>
</body>
</html>