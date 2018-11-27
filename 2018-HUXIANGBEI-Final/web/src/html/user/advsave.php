<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/advsave.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (isset($_POST["page"])){//返回列表页用
$page=$_POST["page"];
}else{
$page=1;
}

$classname=trim($_POST["classname"]);
$title=trim($_POST["title"]);
$link=trim($_POST["link"]);
$img=trim($_POST["img"]);
$editor=trim($_POST["editor"]);

if ($_POST["action"]=="add"){
$isok=query("Insert into zzcms_ztad(classname,title,link,img,editor,passed) values('$classname','$title','$link','$img','$editor',1)");  
$id=insert_id();		
}elseif ($_POST["action"]=="modify"){
$id=$_POST["id"];
$isok=query("update zzcms_ztad set classname='$classname',title='$title',link='$link',img='$img',editor='$editor',passed=1 where id='$id'");	
}
passed("zzcms_ztad");	
?>
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
<table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="tstitle"> 
	<?php
	if ($isok) {echo $f_array[0];}else{echo $f_array[1];}
     ?>      </td>
  </tr>
  <tr> 
    <td class="border3"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr bgcolor="#FFFFFF">
        <td width="25%" align="right" bgcolor="#FFFFFF"><?php echo $f_array[2];?></td>
        <td width="75%"><?php echo $title?></td>
      </tr>
    </table>
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
<tr> 
<td width="33%" align="center" class="bgcolor1"><a href="advadd.php"><?php echo $f_array[3];?></a></td>
<td width="33%" align="center" class="bgcolor1"><a href="advmodify.php?id=<?php echo $id?>"><?php echo $f_array[4];?></a></td>
<td width="33%" align="center" class="bgcolor1"><a href="advmanage.php?classname=<?php echo $classname?>&page=<?php echo $page?>"><?php echo $f_array[5];?></a></td>
</tr>
</table></td>
</tr>
</table>
</div>
</div>
</div>
</div>
</body>
</html>
<?php
unset ($f_array);
?>