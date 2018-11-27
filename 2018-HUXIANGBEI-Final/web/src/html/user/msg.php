<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/msg.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
$go=0;
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if (isset($_REQUEST['id'])){
$id=$_REQUEST['id'];
}else{
$id=1;
}
checkid($id);

if ($action=="savedata" ){
	$saveas=trim($_REQUEST["saveas"]);
	$content=stripfxg(rtrim($_POST["info_content"]));
	if ($saveas=="add"){
	query("insert into zzcms_msg (content)VALUES('$content') ");
	$go=1;
	}elseif ($saveas=="modify"){
	query("update zzcms_msg set content='$content' where id=". $_POST['id']." ");
	$go=1;
	}
}
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
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
<div class="content">
<?php 
if ($action=="add") {
?>
<div class="admintitle"><?php echo $f_array[0]?></div>
<form action="?action=savedata&saveas=add" method="POST" name="myform" id="myform">
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="10%" align="right" class="border"><?php echo $f_array[1]?></td>
      <td class="border"> <textarea name="info_content" id="info_content" ></textarea> 
       	<script type="text/javascript">CKEDITOR.replace('info_content');	</script>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input type="submit" name="Submit" class="buttons" value="<?php echo $f_array[2]?>" ></td>
    </tr>
</table>
 </form>
<?php
}
if ($action=="modify") {
$sql="select * from zzcms_msg where id=".$_REQUEST["id"]."";
$rs=query($sql);
$row=fetch_array($rs);
?>
<div class="admintitle"><?php echo $f_array[3]?></div>  
<form action="?action=savedata&saveas=modify" method="POST" name="myform" id="myform">
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="10%" align="right" class="border"><?php echo $f_array[4]?></td>
      <td class="border"> <textarea name="info_content" id="info_content" ><?php echo $row["content"]?></textarea> 
	  	<script type="text/javascript">CKEDITOR.replace('info_content');	</script>        </td>
    </tr>
    <tr>
      <td align="right" class="border"><input name="id" type="hidden" id="id2" value="<?php echo $row["id"]?>"></td>
      <td class="border">
<input type="submit" name="Submit2" class="buttons" value="<?php echo $f_array[5]?>"></td>
    </tr>
</table>
  </form>
<?php
}
if ($go==1){
echo "<script>location.href='msg_manage.php'</script>";
}
unset ($f_array);
?>
</div>
</div>
</div>
</div>
</body>
</html>