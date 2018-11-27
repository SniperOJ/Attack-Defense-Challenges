<?php
require_once '../inc/conn.php';  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php  
$id=$_GET['id'];
	$sql="select title from zzcms_zx where title='". $id ."'";
	$rs=query($sql);
	$row=num_rows($rs);
	if($row){
	$rt="<div style='background-color:#FFFF00;border:solid 1px #ffcc00;padding:5px;width:400px'>";
	$rt=$rt."此条信息已存在！请查看你发布的信息是否与此重复！";
	$rt=$rt."<li><a href='/zx/search.php?keyword=". $id ."' target='_blank'>".$id."</a></li>";
	$rt=$rt."</div>";
	echo $rt; 
	}
?> 
 </body>
 </html>