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
include "../inc/mail_class.php";

if (strpos($_SESSION['getpass_method'],'@')!==false){
$getpass_methed='email';
$email=$_SESSION['getpass_method'];
}else{
$getpass_methed='mobile';
$mobile=$_SESSION['getpass_method'];
}

$yzm=rand(100000,999999);
$_SESSION['yzm_mobile']=$yzm;
$_SESSION['yzm_sendtime'] = time();
$msg="您在".sitename."请求的验证码是：".$yzm;
if ($getpass_methed=='mobile'){
$msg = iconv("UTF-8","GBK",$msg);
	$result= sendSMS(smsusername,smsuserpass,$mobile,$msg,apikey_mobile_msg);//发手机短信
	//echo $result;
	if (strpos($result,'success')!==false){
	echo "验证码已发送，请查收";
	}else{
	echo "验证码发送失败，请联系客服进行查找，客服QQ：".kfqq." 电话：".kftel."";
	}
}else{
	$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
	//$smtp->debug = true; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
	$to = $email; //收件人
	$subject = $msg;//后加网站名称后发送不成功，或延迟，应是被屏蔽了。
	$mailbody= $msg;

	$fp="../template/".siteskin."/email.htm";
		if (file_exists($fp)==false){
		WriteErrMsg($fp.'模板文件不存在');
		exit;
		}
	$f= fopen($fp,'r');
	$strout_mail = fread($f,filesize($fp));
	fclose($f);
	$strout_mail=str_replace("{#body}",$mailbody,$strout_mail) ;
	$strout_mail=str_replace("{#siteurl}",siteurl,$strout_mail) ;
	$strout_mail=str_replace("{#logourl}",logourl,$strout_mail) ;
	$mailbody=$strout_mail;
	$isok=$smtp->sendmail($to,sender,$subject,$mailbody,"HTML");//邮件的类型可选值是 TXT 或 HTML 
	if($isok){
	echo "验证码已发送，请查收！<a href='http://mail.".substr($email,strpos($email,"@")+1)."' target='_blank'><b>登录邮箱</b></a>";
	}else{
	echo "验证码发送失败，请联系客服进行查找，客服QQ：".kfqq." 电话：".kftel."";
	//echo "发送失败原因：".$this->smtp->logs;
	}			
}
?>
</body>
</html>