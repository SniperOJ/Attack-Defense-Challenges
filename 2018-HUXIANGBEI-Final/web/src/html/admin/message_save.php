<?php
include ("admin.php");
checkadminisdo("sendmessage");
$sendto=trim($_REQUEST["sendto"]);
$title=trim($_REQUEST["title"]);
$content=trim($_REQUEST["content"]);
if ($_REQUEST["action"]=="add"){
query("INSERT INTO zzcms_message (sendto,title,content,sendtime)VALUES('$sendto','$title','$content','".date('Y-m-d H:i:s')."')");
}elseif ($_REQUEST["action"]=="modify") {
$id=$_REQUEST["id"];
query("update zzcms_message set sendto='$sendto',title='$title',content='$content' where id='$id'");	
}

echo "<script>location.href='message_manage.php'</script>";
?>