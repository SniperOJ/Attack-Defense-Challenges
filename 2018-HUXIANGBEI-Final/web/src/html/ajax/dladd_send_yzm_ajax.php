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
include("../inc/config.php");
include '../3/mobile_msg/inc.php';
//$mobile=13838064112;
$mobile=$_GET['id'];
$yzm=rand(100000,999999);
$_SESSION['yzm_mobile']=$yzm;
$_SESSION['yzm_sendtime'] = time();

$msg="您在".sitename."请求的验证码是：".$yzm;
$msg = iconv("UTF-8","GBK",$msg);
$result = sendSMS(smsusername,smsuserpass,$mobile,$msg,apikey_mobile_msg);//发手机短信
if (strpos($result,'success')!==false){
echo "验证码已发送至".$mobile."，请查收";
}else{
echo "验证码发送失败，请联系客服进行查找，客服QQ：".kfqq." 电话：".kftel."";
}	
?>
</body>
</html>