<?php
if(!isset($_SESSION)){session_start();} 
ob_start();//打开缓冲区，这样输出内容后还可以setcookie 
include("../inc/conn.php");
include("../inc/mail_class.php");
include '../3/ucenter_api/config.inc.php';//集成ucenter
include '../3/ucenter_api/uc_client/client.php';//集成ucenter
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="../template/<?php echo siteskin; ?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main">
<?php
include("../inc/top2.php");
echo sitetop();
checkyzm($_POST["yzm"]);
$usersf=trim($_POST["usersf"]);
$kind=trim($_POST["kind"]);
$username=trim($_POST["username"]);
$password=trim($_POST["password"]);
$comane=trim($_POST["comane"]);
$somane=trim($_POST["somane"]);
$phone=trim($_POST["phone"]);
$email=trim($_POST["email"]);
$daohang="网站首页,招商信息,品牌信息,公司简介,资质证书,联系方式,在线留言,招聘信息";
$founderr=0;
if ($username!='' && $password!=''){

if(! preg_match("/^[a-zA-Z0-9_]{4,15}$/",$username)){//ereg()PHP5.3以后的版本不再支持
$founderr=1;
$msg= "<li>用户名只能为字母和数字，字符介于4到15个！</li>";
}
	
$sql="select count(*) as total from zzcms_user where where username='".$username."' ";
$rs = query($sql); 
$row = fetch_array($rs);
$totlenum = $row['total'];
	if($totlenum){ 
	$founderr=1;
	$msg= "<li>该用户名已存在！请更换一个！</li>";
	}
	
$sql="select count(*) as total from zzcms_usernoreg where username='".$username."'";
$rs = query($sql);
$row= fetch_array($rs);
$totlenum = $row['total'];
	if($totlenum){ 
	$founderr=1;
	$msg= "<li>您填写的用户名已存在！请更换用户名！</li>";
	}	

if ($somane!=''&& $phone!=''&& $email!=''){
	if(!preg_match("/^[\x7f-\xff]+$/",$somane)){
	$founderr=1;
	$msg='<li>姓名只能用中文</li>';
	}

	if(!preg_match("/1[3458]{1}\d{9}$/",$phone) && !preg_match('/^400(\d{3,4}){2}$/',$phone) && !preg_match('/^400(-\d{3,4}){2}$/',$phone) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$phone)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
	$founderr=1;
	$msg='<li>电话号码不正确！</li>';
	}

	if(! preg_match("/^[a-zA-Z0-9_.]+@([a-zA-Z0-9_]+.)+[a-zA-Z]{2,3}$/",$email)) {
	$founderr=1;
	$msg= "<li>Email格式不正确！</li>";
	}
}else{
$founderr=1;
$msg= "<li>联系人、电话、E-mail为必填项！</li>";
}	
	
if ($founderr==1){
WriteErrMsg($msg);
}else{

if (checkistrueemail=="Yes" ){
$emailsite="http://mail.".substr($email,strpos($email,"@")+1);
$checkcode=date("YmdHis").rand(100,999);

$sql="INSERT INTO zzcms_usernoreg (username,password,usersf,comane,somane,phone,email,checkcode,regdate)
VALUES('$username','$password','$usersf','$comane','$somane','$phone','$email','$checkcode','".date('Y-m-d H:i:s')."')";
query($sql);
//sendemail
$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
$to = $email; //收件人
$subject="成功注册".sitename."会员通知";

$body= "<table width='100%'><tr><td style='font-size:14px;line-height:25px'>亲爱的".$somane . "：<br>&nbsp;&nbsp;&nbsp;&nbsp;您好！<br>欢迎您注册成为<a href='".siteurl."' target='_blank'>".sitename."</a>会员，你的用户名：".$username." 密码：".$password." 请妥善保管。";
$body=$body."<br><br>点击下面的这段链接激活您的注册帐号<br><a href=".siteurl."/reg/userregcheckemail.php?username=".$username."&checkcode=".$checkcode.">".siteurl."/reg/userregcheckemail.php?username=".$username."&checkcode=".$checkcode."</a>";
$body=$body."<br>如果点击后没有任何反应，请把这段链接复制到地址栏里直接打开。";
$body=$body."<br><br>感谢您对本站的支持！</td></tr></table>";

$fp="../template/".$siteskin."/email.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#body}",$body,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$body=$strout;

$send=$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML 
if($send){
?>
<div class="box" style="font-size:14px;margin:10px 0;text-align:center">
<ul style="background-color:#FFFFFF;padding:10px">
<li><b>注册成功！</b></li>
<li><form name="form1" method="post" action="/reg/sendmailagain.php">帐号需要激活后才能使用，激活邮件已发送到
<input type=text name="newemail" value="<?php echo $email?>">
<input type=hidden name=username value="<?php echo $username?>">
<input type=submit name=submit value="重发"> 请登录到您的邮箱查收 。</form></li>
<li style="padding:10px 0"><input type="button" class="button_big" value="点击登录您的邮箱"  onclick="window.open('<?php echo $emailsite?>')"/></li>
</ul>
</div>
<?php
}else{
echo "验证邮件发送失败。";
}

}else{ //if(checkistrueemail=="Yes" )
query("INSERT INTO zzcms_user (username,password,passwordtrue,usersf,comane,content,somane,sex,phone,email,img,totleRMB,regdate,lastlogintime)VALUES('$username','".md5($password)."','$password','$usersf','$comane','&nbsp;','$somane','1','$phone','$email','/image/nopic.gif','".jf_reg."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
query("INSERT INTO zzcms_usersetting (username,skin,skin_mobile,swf,daohang)VALUES('$username','tongyong','1','6.swf','$daohang')");
setcookie("UserName",$username,time()+3600*24*365,"/");//直接登录
setcookie("PassWord",md5($password),time()+3600*24*365,"/");
session_write_close();
//集成ucenter
if (bbs_set=='Yes'){
$uid = uc_user_register($_POST['username'], $_POST['password'], $_POST['email']);
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
		setcookie('Example_auth', uc_authcode($uid."\t".$_POST['username'], 'ENCODE'));
		echo '同时注册论坛成功';
	}
}	
//end 
if (whenuserreg=="Yes"){
$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
$to = $email; //收件人
$subject="成功注册".sitename."会员通知";
$body= "<table width='100%'><tr><td style='font-size:14px;line-height:25px'>亲爱的".$somane . "：<br>&nbsp;&nbsp;&nbsp;&nbsp;您好！<br>欢迎您注册成为<a href='".siteurl."' target='_blank'>".sitename."</a>会员，你的用户名：".$username." 密码：".$password." 请妥善保管。";
$body=$body."<br><br>感谢您对本站的支持！</td></tr></table>";

$fp="../template/".$siteskin."/email.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#body}",$body,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$body=$strout;

$send=$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML 
	if($send){
	echo "<script>location.href='/user/login.php?username=".$username."&sendmail=ok'</script>";
	}else{
	echo "<script>location.href='/user/login.php?username=".$username."'</script>";
	}
}else{
echo "<script>location.href='/user/login.php?username=".$username."'</script>";
}

}//end if(checkistrueemail=="Yes" )
}//end if($founderr==1)
}//end if($username!='' && $password!='')

?>
</div>
</body>
</html>