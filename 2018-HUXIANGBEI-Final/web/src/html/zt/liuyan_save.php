<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<?php
checkyzm($_POST["yzm"]);
	$contents = isset($_POST['contents'])?$_POST['contents']:"";
	$name = isset($_POST['name'])?$_POST['name']:"";
	$tel = isset($_POST['tel'])?$_POST['tel']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	$saver = isset($_POST['saver'])?$_POST['saver']:"";
	$fromurl = isset($_POST['fromurl'])?$_POST['fromurl']:"";

if (@$_SESSION['cuestip']==getip()){
	showmsg('此IP留过言了！');
}
if ($contents==''||$name==''||$tel==''){
	showmsg('请完整填写您的信息');
}
if(!preg_match("/^[\x7f-\xff]+$/",$name)){
showmsg('姓名只能用中文','back');
}
if(!preg_match("/1[3458]{1}\d{9}$/",$tel) && !preg_match('/^400(\d{3,4}){2}$/',$tel) && !preg_match('/^400(-\d{3,4}){2}$/',$tel) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$tel)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
showmsg('电话号码不正确','back');
}
	
$rs=query("select * from zzcms_guestbook where linkmen='$name' and phone='$tel' and saver='$saver'");
$row=num_rows($rs);
if ($row){
showmsg('您已留过言了！');
}else{	
$addok=query("insert into zzcms_guestbook (content,linkmen,phone,email,saver,sendtime)
values('$contents','$name','$tel','$email','$saver','".date('Y-m-d H:i:s')."')");
$_SESSION["dlliuyan"]=$saver;//供留言后显示联系方式处用
$_SESSION['cuestip']=getip();
$addok?showmsg('您的留言已成功提交！',$fromurl):showmsg('失败，您的留言没有被提交！');
}
session_write_close();
?>