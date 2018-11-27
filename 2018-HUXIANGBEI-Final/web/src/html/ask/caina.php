<?php
if(!isset($_SESSION)){session_start();} 
if ($_POST['token'] != $_SESSION['token'] || $_POST['token']=='' ){    
showmsg('非法提交','back');
}else{
unset($_SESSION['token']);
}
include("../inc/conn.php");
$answerid=$_POST['answerid'];
$askid=$_POST['askid'];
checkid($answerid);
checkid($askid);

$rs = query("select jifen from zzcms_ask where id='".$askid."'"); 
$row = fetch_array($rs);
$jifen=$row['jifen'];

$rs = query("select editor from zzcms_ask where id='".$askid."'"); 
$row = fetch_array($rs);
$ask_editor=$row['editor'];

$rs = query("select editor from zzcms_answer where id='".$answerid."'"); 
$row = fetch_array($rs);
$answer_editor=$row['editor'];

query("update zzcms_user set totleRMB=totleRMB+".$jifen." where username='$answer_editor'");
query("update zzcms_user set totleRMB=totleRMB-".$jifen." where username='$ask_editor'");

query("update zzcms_answer set caina=1 where id='$answerid'");
query("update zzcms_ask set typeid=1 where id='$askid'");

session_write_close();
showmsg('成功',$_SERVER['HTTP_REFERER']);
?>