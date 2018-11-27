<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/msg_manage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id="";
}

if ($action=="elite"){
	if ($id<>"" ){
	query("Update zzcms_msg set elite=0 ");//只有一条为1的
	query("update zzcms_msg set elite=1 where id='$id'");
}
echo "<script>location.href='msg_manage.php'</script>";	
}

if ($action=="del"){
	if ($id<>"" ){
	query("delete from zzcms_msg where id='$id'") ;
	}
	echo "<script>location.href='msg_manage.php'</script>";
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
<div class="content">
<div class="admintitle"><span><a href="msg.php?action=add" class="buttons"><?php echo $f_array[1]?></a></span><?php echo $f_array[0]?></div>
<?php
$sql="select * from zzcms_msg";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo $f_array[2];
}else{
?>
<table width="100%" border="0" cellpadding="3" cellspacing="1" class="bgcolor">
  <tr class="title"> 
    <?php echo $f_array[3]?>
  </tr>
  <?php
while($row = fetch_array($rs)){
?>
 <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
    <td height="22" align="center" ><?php echo $row["id"]?></td>
    <td height="22" align="center" ><?php echo $row["content"]?></td>
    <td height="22" align="center" ><?php
	if ($row["elite"]==1 ){ echo  $f_array[4];}
	?>
	
	</td>
    <td align="center"> 
	<a href="?action=elite&id=<?php echo $row["id"]?>"><?php echo $f_array[5]?></a> 
	| <a href="msg.php?action=modify&id=<?php echo $row["id"]?>"><?php echo $f_array[6]?></a> 
    | <a href="?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDel();"><?php echo $f_array[7]?></a></td>
  </tr>
<?php
}
?>
</table>
<?php
}
unset ($f_array);
?>
</div>
</div>
</div>
</div>
</body>
</html>