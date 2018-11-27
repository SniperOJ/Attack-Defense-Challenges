<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("helps");
$b=trim($_POST["b"]);
$title=trim($_POST["title"]);
$content=stripfxg(rtrim($_POST["content"]));
$img=getimgincontent($content);
$page=isset($_POST["page"])?$_POST["page"]:1;//只从修改页传来的值
$elite=isset($_POST["elite"])?$_POST["elite"]:0;
if ($_REQUEST["action"]=="add"){
	query("INSERT INTO zzcms_help (classid,title,content,img,elite,sendtime)VALUES('$b','$title','$content','$img','$elite','".date('Y-m-d H:i:s')."')");
	}elseif ($_REQUEST["action"]=="modify"){
	$id=trim($_POST["id"]);
	query("update zzcms_help set classid='$b',title='$title',content='$content',img='$img',elite='$elite',sendtime='".date('Y-m-d H:i:s')."' where id='$id' ");
}

echo "<script>location.href='help_manage.php?b=".$b."&page=".$page."'</script>";
?>
</body>
</html>	