<?php 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<?php
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
checkid($id);
}else{
$id=0;
}
$sql="Select * From zzcms_help where id='$id'";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo "不存在相关信息！";
}else{
$row=fetch_array($rs);
?>
<title>网站公告-<?php echo $row["title"]?></title>
<link href="../template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="box">
<div id="BoxInfoTitle" style="text-align:center"><?php echo $row["title"]?></div>
<div id="fontzoom"><?php echo $row["content"]?></div>
<div style="text-align:right"><?php echo date("Y-m-d",strtotime($row['sendtime']))?></div>
</div>
<div style="text-align:center">
  <input name="close" type="button" id="close" onClick="javascript:window.close()" value="关闭窗口"/>
</div>
</body>
</html>
<?php
}
?>