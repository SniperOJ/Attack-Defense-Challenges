<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
</head>
<body>
<?php
include'../inc/conn.php';
include("../inc/mail_class.php");
include '../3/ucenter_api/config.inc.php';//集成ucenter
include '../3/ucenter_api/uc_client/client.php';//集成ucenter

$checkcode=trim($_REQUEST["checkcode"]);
$username=nostr(trim($_REQUEST["username"]));
if ($username<>''){
	$sql="select * from zzcms_user where username='".$username."'";
	$rs=query($sql);
	$row=num_rows($rs);
	if ($row){
	echo "此帐号已被激活过！点击<a href='".siteurl."/user/login.php?username=".$username."'>登录网站</a>";
	}else{
	$sql="select * from zzcms_usernoreg where username='".$username."'";
	$rs=query($sql);
	$row=num_rows($rs);
	if (!$row){
		echo "激活失败！原因：此用户名不存在！";
		}else{
		$row=fetch_array($rs);
		$usersf=$row["usersf"];
		$passwordtrue=$row["password"];
		$password=md5($row["password"]);
		$passwordtrue=$row["password"];
		$comane=$row["comane"];
		$somane=$row["somane"];
		$phone=$row["phone"];
		$email=$row["email"];
		$checkcode2=$row["checkcode"];
		}
if ($checkcode==$checkcode2){
query("insert into zzcms_user (usersf,username,password,passwordtrue,comane,somane,phone,email,img,sex,regdate)values('$usersf','$username','$password','$passwordtrue','$comane','$somane','$phone','$email','/image/nopic.gif','1','".date('Y-m-d H:i:s')."')");		
//在用户配置表中增加新用户名记录
query("insert into zzcms_usersetting (username,skin,swf,daohang)values('$username','red2','6.swf','网站首页, 招商信息, 公司简介, 资质证书, 联系方式, 在线留言')");
//复制完后删除临时表中用户信息		
query("delete from zzcms_usernoreg where username='".$username."'");

//集成ucenter
if (bbs_set=='Yes'){
$uid = uc_user_register($username, $passwordtrue,$email);
	if($uid <= 0) {
		if($uid == -1) {
			echo '用户名不合法';
		} elseif($uid == -2) {
			echo '包含要允许注册的词语';
		} elseif($uid == -3) {
			echo '用户名已经存在';
		} elseif($uid == -4) {
			echo 'Email 格式有误';
		} elseif($uid == -5) {
			echo 'Email 不允许注册';
		} elseif($uid == -6) {
			echo '该 Email 已经被注册';
		} else {
			echo '未定义';
		}
	} else {
		//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('Example_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
		echo '同时注册论坛成功';
	}
}	
//end 
echo "<script>alert('激活成功，请登录！');location.href='/user/login.php?username=".$username."'</script>";
}else{
echo "激活失败！原因：链接中的验证码不正确！";
}
}
}else{
echo "激活失败！原因：用户名信息丢失！";
}
?>
</body>
</html>