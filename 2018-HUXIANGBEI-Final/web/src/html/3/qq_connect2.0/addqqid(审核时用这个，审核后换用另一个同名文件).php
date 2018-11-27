<?php
ob_start();//打开缓冲区，可以setcookie
include("../../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>QQ登陆</title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="main">
<?php
include("../../inc/top2.php");
$username=$_POST["username"];
$pwd=$_POST["pwd"];
$qqid=$_POST["qqid"];
if ($qqid==""){
$errmsg=$errmsg . "参数不足";
WriteErrMsg($errmsg);
}else{
	$rs=query("select qqid from zzcms_user where qqid='".$qqid."'");
	$row=num_rows($rs);
	if (!$row){
	$username=date("YmdHis").rand(100,999);
	$password=md5(123456);
	$passwordtrue='123456';
	$daohang="网站首页, 招商信息, 公司简介, 资质证书, 联系方式, 在线留言";
	query("insert into zzcms_user (username,password,passwordtrue,qqid,usersf,img,totleRMB,regdate,lastlogintime) value 
	('$username','$password','$passwordtrue','$qqid','公司','/image/nopic.gif','".jf_reg."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
	query("insert into zzcms_usersetting (username,skin,swf,daohang)VALUES('$username','1','6.swf','$daohang')");		
	}
	
//直接登陆
query("UPDATE zzcms_user SET showlogintime = lastlogintime where qqid='".$qqid."'");//更新上次登陆时间
query("UPDATE zzcms_user SET showloginip = loginip where qqid='".$qqid."'");//更新上次登陆IP
query("UPDATE zzcms_user SET logins = logins+1 where qqid='".$qqid."'");
query("UPDATE zzcms_user SET loginip = '".getip()."' where qqid='".$qqid."'");//更新最后登陆IP
	if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['lastlogintime'])>86400){
	query("UPDATE zzcms_user SET totleRMB = totleRMB+".jf_login." WHERE qqid='".$qqid."'");//登陆时加积分
	}
query("UPDATE zzcms_user SET lastlogintime = '".date('Y-m-d H:i:s')."' WHERE qqid='".$qqid."'");//更新最后登陆时间

		
$rs=query("select username,password from zzcms_user where qqid='".$qqid."'");
$row=fetch_array($rs);
if ($CookieDate==1){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
}elseif($CookieDate==0){
setcookie("UserName",$row['username'],time()+3600*24,"/");
setcookie("PassWord",$row['password'],time()+3600*24,"/");
}
//echo "<script>location.href='/index.php'<//script>";
echo "<script>parent.location.href='/index.php'</script>";
}

include("../../inc/bottom_company.htm");
?>
</div>
</body>
</html>