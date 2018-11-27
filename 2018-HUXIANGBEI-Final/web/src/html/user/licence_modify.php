<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/licence_modify.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>    
}
</script>
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
<div class="admintitle"><?php echo $f_array[1]?> </div>
<?php
if (isset($_GET["id"])){
$id=$_GET["id"];
checkid($id);
}else{
$id=0;
}

$sql="select * from zzcms_licence where id='$id'";
$rs = query($sql); 
$row = fetch_array($rs);
if ($row["editor"]<>$username) {
markit();

showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<FORM name="myform" action="licence_save.php?action=modify" method="post" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="15%" height="50" align="right" class="border"><?php echo $f_array[2]?> <br>
        <font color="#666666"> 
        <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>">
        <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>">
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
        </font></td>
      <td width="85%" height="50" class="border"> 
              <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> 
                    <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>" .$f_array[6];
				  }else{
				  echo "<input name='Submit2' type='button'  value='" .$f_array[3]."'/>";
				  }
				  ?>
                  </td>
                </tr>
              </table>
	        </td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[4]?></td>
      <td height="30" class="border2">
<input name="title" type="text" id="title" value="<?php echo $row["title"]?>" class="biaodan"> </td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td height="30" class="border"><input name=Submit   type=submit class="buttons" id="Submit" value="<?php echo $f_array[5]?>"></td>
    </tr>
  </table>
	
  </form>
</div>
</div>
</div>
</div>
<?php

unset ($f_array);
?> 
</body>
</html>