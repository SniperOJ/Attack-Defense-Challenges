<?php 
include ("admin.php");
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
checkadminisdo("friendlink");
if (isset($_POST["page"])){//只从修改页传来的值
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["bigclassid"])){
$classid=$_POST["bigclassid"];
}else{
$classid=0;
}
$FriendSiteName=trim($_REQUEST["sitename"]);
$url=addhttp(trim($_REQUEST["url"]));
$logo=addhttp(trim($_REQUEST["logo"]));
$content=trim($_REQUEST["content"]);

if (isset($_POST["passed"])){
$passed=$_POST["passed"];
}else{
$passed=0;
}

if (isset($_POST["elite"])){
$elite=$_POST["elite"];
}else{
$elite=0;
}

if ($_REQUEST["action"]=="add"){
query("INSERT INTO zzcms_link (bigclassid,sitename,url,logo,content,passed,elite,sendtime)VALUES('$classid','$FriendSiteName','$url','$logo','$content','$passed','$elite','".date('Y-m-d H:i:s')."')");
}elseif ($_REQUEST["action"]=="modify") {
$id=$_POST["id"];
query("update zzcms_link set bigclassid='$classid',sitename='$FriendSiteName',url='$url',logo='$logo',content='$content',passed='$passed',elite='$elite',sendtime='".date('Y-m-d H:i:s')."' where id='$id'");	
}
$_SESSION["bigclassid"]=$classid;

echo  "<script>location.href='linkmanage.php?b=".$classid."&page=".$page."'</script>";
?>
</body>
</html>