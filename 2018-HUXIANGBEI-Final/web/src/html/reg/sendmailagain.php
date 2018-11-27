<?php
include("../inc/conn.php");
include("../inc/mail_class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="../template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div class="main" >
<?php
include("../inc/top2.php");
echo sitetop();
?>
<div class="pagebody" style="text-align:center;height:300px">
<?php
$username=trim($_POST["username"]);
$email=trim($_POST["newemail"]);
$emailsite="http://mail.".substr($email,strpos($email,"@")+1);

	$sql="select * from zzcms_usernoreg where username='".$username."'";
	$rs=query($sql);	
	$row=num_rows($rs);
	if ($row){
	$row=fetch_array($rs);	
	$checkcode=$row["checkcode"];
	$password=$row["password"];
	$somane=$row["somane"];
	}
	
//sendemail
$smtp=new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
$to = $email; //收件人
$subject="成功注册".sitename."会员通知";
$body= "<table width='100%'><tr><td style='font-size:14px;line-height:25px'>亲爱的".$somane . "：<br>&nbsp;&nbsp;&nbsp;&nbsp;您好！<br>欢迎您注册成为<a href='".siteurl."' target='_blank'>".sitename."</a>会员，你的用户名：".$username." 密码：".$password." 请妥善保管。";
$body=$body."<br><br>点击下面的这段链接激活您的注册帐号<br><a href=".siteurl."/reg/userregcheckemail.php?username=".$username."&checkcode=".$checkcode.">".siteurl."/reg/userregcheckemail.php?username=".$username."&checkcode=".$checkcode."</a>";
$body=$body."<br>如果点击后没有任何反应，请把这段链接复制到地址栏里直接打开。";
$body=$body."<br><br>感谢您对本站的支持！</td></tr></table>";

$fp="../template/".siteskin."/email.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#body}",$body,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$body=$strout;

$send=$smtp->sendmail($to,sender,$subject,$body,"HTML");//邮件的类型可选值是 TXT 或 HTML 
echo"<div class=box style='font-size:14px;margin:50px 0'><ul style=background-color:#FFFFFF;padding:10px>";
if($send){
echo"<li><b>注册成功！</b></li>";
echo"<li>帐号需要激活后才能使用，激活邮件已发送到".$email."请登录到您的邮箱查收 </li>";
echo"<li style=padding:20px><input type=button class=button_big value=点击登录您的邮箱  onclick=\"window.open('".$emailsite."')\"/></li>";
}else{
echo"<li>邮件发送失败，请稍候直接登录网站！</li>";
}
echo"</ul></div>";
?>
</div>

</div>
</body>
</html>