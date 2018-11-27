<?php
include("admin.php");
set_time_limit(1800) ;
ob_end_clean();//终止缓冲。这样就不用等到有4096bytes的缓冲之后才被发送出去了。
echo str_pad(" ",256);//IE需要接受到256个字节之后才开始显示。
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="border" style="padding:10px"> 
<div style="padding:10px;background-color:#FFFFFF">
<?php
include("../inc/mail_class.php");
checkadminisdo("sendmail");

@$to=$_GET["tomail"];//收件人
$subject=$_GET["subject"];//邮件主题
$groupid=$_GET["groupid"];//用户组
if (!empty($_GET["mailbody"])){//首次提交信息时获得$_SESSION['mailbody']
$_SESSION['mailbody']=stripfxg($_GET["mailbody"]);//邮件内容
}
$mailbody=$_SESSION['mailbody'];
	$fp="../template/".siteskin."/email.htm";
	$f= fopen($fp,'r');
	$strout = fread($f,filesize($fp));
	fclose($f);
	$strout=str_replace("{#body}",$mailbody,$strout) ;
	$strout=str_replace("{#siteurl}",siteurl,$strout) ;
	$strout=str_replace("{#logourl}",logourl,$strout) ;
	$mailbody=$strout;
	
$smtp  =   new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
if ($to<>""){
//对于单一用户发信
	$send=$smtp->sendmail($to,sender,$subject,$mailbody,"HTML");//邮件的类型可选值是 TXT 或 HTML 
	if($send){
	echo "发送到".$to."成功";
	}else{
	echo "发送到".$to."失败，可能是邮件地址有误，或是发送邮件过多，请稍候再发。";
	}  
}else{

$size=10;//每轮群发个数
$sleeps=5;//每个间隔时间
if (!empty($_GET['n'])){
$n=$_GET['n'];
}else{
$n=0;
}
	$sql="select email from zzcms_user where groupid=$groupid order by id asc limit $n,$size";
	$rs=query($sql); 
	$row=num_rows($rs); 
	if ($row){
		while ($row=fetch_array($rs)){
		$to=$row['email']; //收件人
		
		$send=$smtp->sendmail($to,sender,$subject,$mailbody,"HTML");//邮件的类型可选值是 TXT 或 HTML 
		if($send){echo "<li>第".($n+1)."个，发送到".$to."成功</li>";}else{echo "<li>第".($n+1)."个，发送到".$to."失败</li>";}
		flush();  //不在缓冲中的或者说是被释放出来的数据发送到浏览器    
		sleep($sleeps);
		$n=$n+1;
		
		}
		echo "<br><b>本轮群发第".$n."个完成，正在转入下一轮</b><br/>";
		echo"<meta http-equiv=\"refresh\" content=\"1;url=sendmailto.php?n=$n&subject=$subject&groupid=$groupid\">";   
	}else{
	echo '完成';//当无记录时提示完成
	}
}
?>
</div>
</div>
</body>
</html>