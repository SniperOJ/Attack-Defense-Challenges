<?php
include ("admin.php");
checkadminisdo("wangkan");
if (isset($_POST["page"])){//只从修改页传来的值
$page=$_POST["page"];
}else{
$page=1;
}

$bigclassid=$_POST["bigclassid"];
$title=trim($_POST["title"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$img=getimgincontent($content);
if (isset($_POST["passed"])){
$passed=$_POST["passed"];
}else{
$passed=0;
}

if (isset($_POST["elite"])){
$elite=$_POST["elite"];
	if ($elite>255){
	$elite=255;
	}elseif ($elite<0){
	$elite=0;
	}
}else{
$elite=0;
}

if ($_REQUEST["action"]=="add" && $_SESSION["admin"]<>''){
query("INSERT INTO zzcms_wangkan (bigclassid,title,content,img,passed,elite,sendtime)VALUES('$bigclassid','$title','$content','$img','$passed','$elite','".date('Y-m-d H:i:s')."')");
}elseif ($_REQUEST["action"]=="modify") {
$id=$_POST["id"];
query("update zzcms_wangkan set bigclassid='$bigclassid',title='$title',content='$content',img='$img',passed='$passed',elite='$elite',sendtime='".date('Y-m-d H:i:s')."' where id='$id'");	
}
echo  "<script>location.href='wangkan_manage.php?page=".$page."'</script>";
?>