<?php
if(!isset($_SESSION)){session_start();} 
set_time_limit(1800); 
include("../inc/conn.php");
include("../inc/mail_class.php");
ob_end_clean();//终止缓冲。这样就不用等到有4096bytes的缓冲之后才被发送出去了。
echo str_pad(" ",256);//IE需要接受到256个字节之后才开始显示。

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<title></title>
<script src="/js/msgbox.js" type="text/javascript" language="JavaScript"></script>
</head>
<body>
<?php
$founderr=0;
$ErrMsg="";
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if (!isset($_COOKIE["UserName"]) || $_COOKIE["UserName"]==""){
?>
<script>
MsgBox('用户登录','../user/login2.php?fromurl=<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>',500,196,1);
</script>
<?php
exit;
}
$username="";
if (isset($_COOKIE["UserName"])){
$username=$_COOKIE["UserName"];
}

if (!empty($_POST["sql"])){//从模板中获取SQL内容,为发送对像
$_SESSION['sql']=stripfxg($_POST["sql"]);
}
$sql=$_SESSION['sql'];
session_write_close();
?>
<div class="main">
<?php
if (check_user_power("dls_print")=="no"){
$founderr=1;
$ErrMsg=$ErrMsg."<li>您所在的用户组没有权限！<br><input  type=button value=升级成VIP会员 onclick=\"location.href='/one/vipuser.php'\"/></li>";
}

$size=5;//每轮群发个数
$sleeps=1;//每个间隔时间

$sql_n="select content from zzcms_msg where elite=1";
$rs_n=query($sql_n);
$row_n=num_rows($rs_n);
if (!$row_n){
showmsg('未设邮件内容，请先设邮件内容','/user/index.php?gotopage=msg_manage.php');
}else{
$row_n=fetch_array($rs_n);
}
$subject=$row_n['content'];
$mailbody=$row_n['content'];
$smtp  =   new smtp(smtpserver,25,true,sender,smtppwd,sender);//25:smtp服务器的端口一般是25
if (!empty($_GET['n'])){
$n=$_GET['n'];
}else{
$n=0;
}
$sql2=$sql." order by id asc limit $n,$size";
	$rs=query($sql2); 
	$row=num_rows($rs); 
	//echo $sql2;
	if ($row){
		while ($row=fetch_array($rs)){
		$to=$row['email']; //收件人
		$send=$smtp->sendmail($to,sender,$subject,$mailbody,"HTML");//邮件的类型可选值是 TXT 或 HTML 
		if($send){echo "<li>".$n."发送到".$to."成功</li>";}else{echo "<li>".$n."发送到".$to."失败</li>";}
		flush();  //不在缓冲中的或者说是被释放出来的数据发送到浏览器    
		sleep($sleeps);
		$n=$n+1;

		}
		echo '<br><b>本轮群发'.$size.'个完成，正在转入下一轮</b><br/>';
		echo"<meta http-equiv=\"refresh\" content=\"1;url=dl_sendmail.php?n=$n\">";   
	}else{
	echo '完成';
	}
?>