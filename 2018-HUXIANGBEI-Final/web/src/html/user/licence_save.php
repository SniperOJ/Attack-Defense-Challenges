<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/licence_save.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") {$page=$_GET['page'];}else{$page=1;}
$title=trim($_POST["title"]);	
$img=trim($_POST["img"]);
if ($_GET["action"]=="add"){
query("Insert into zzcms_licence(title,img,editor,sendtime) values('$title','$img','$username','".date('Y-m-d H:i:s')."')") ; 
}elseif ($_GET["action"]=="modify"){
$oldimg=trim($_POST["oldimg"]);
	$id=$_POST["id"];
	if ($id=="" || is_numeric($id)==false){
		$FoundErr=1;
		$ErrMsg="<li>". $f_array[0]."</li>";
		WriteErrMsg($ErrMsg);
	}else{
	query("update zzcms_licence set title='$title',img='$img',sendtime='".date('Y-m-d H:i:s')."',passed=0 where id='$id'");
		if ($oldimg<>$img && $oldimg<>"/image/nopic.gif"){
			$f="../".$oldimg;
			if (file_exists($f)){
			unlink($f);
			}
			$fs="../".str_replace(".","_small.",$oldimg)."";
			if (file_exists($fs)){
			unlink($fs);		
			}
		}		
	}
}
passed("zzcms_licence");
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
    <td class="tstitle"><?php
	if ($_REQUEST["action"]=="add") {
      echo  $f_array[1];
	  }elseif ($_REQUEST["action"]=="modify"){
	  echo $f_array[2];
	  }else{
	  echo $f_array[3];
	  }
     ?>    </td>
  </tr>
  <tr>
    <td align="center" class="border3"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr bgcolor="#FFFFFF">
        <td width="25%" align="right" bgcolor="#FFFFFF"><strong><?php echo $f_array[4]?></strong></td>
        <td width="75%"><?php echo $title?></td>
      </tr>
    </table>      <a href="licence_add.php"><?php echo $f_array[5]?></a> | <a href="licence.php?page=<?php echo $page?>"><?php echo $f_array[6]?></a></td>
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