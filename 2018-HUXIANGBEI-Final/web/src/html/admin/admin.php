<?php
if(!isset($_SESSION)){session_start();}
include("../inc/conn.php");
if (isset($_SESSION["admin"]) && isset($_SESSION["pass"])){
	$sql="select * from zzcms_admin where admin='".$_SESSION["admin"]."'";
	$rs=query($sql) or showmsg('查寻管理员信息出错');
	$ok=is_array($row=fetch_array($rs));
	if($ok){
		if ($_SESSION["pass"]!=$row['pass']){
		showmsg('管理员密码不正确，你无权进入该页面','/admin/login.php');
		}
	}else{
	showmsg('管理员已不存在，你无权进入该页面','/admin/login.php');
	}
}else{
session_write_close();
echo("<script>top.location.href = '/admin/login.php';</script>");
}
?>