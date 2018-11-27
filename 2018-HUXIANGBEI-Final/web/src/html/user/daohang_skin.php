<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/daohang_skin.txt";
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
if (@$_REQUEST["action"]=="modify") { //这里action的值并没有通过常用的表单传。整个过程也没有用表单。

$skin=$_GET['skin'];
query("update zzcms_usersetting set skin='$skin' where username='".$username."'");	
echo $f_array[0];
}
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
<div class="admintitle"><?php echo $f_array[1]?></div>   
      <div id="Layer1" class="border" style="position:relative; width:100%; height:600px; z-index:1; overflow: scroll;"> 
                
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr> 
                    <?php 					
$dir = opendir(zzcmsroot."skin");
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && strpos($file,".zip")==false && strpos($file,".rar")==false && strpos($file,".txt")==false && $file!='mobile') { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td><table width="120" border="0" cellpadding="5" cellspacing="1">
                        <tr> 
                          <td height="100" align="center" bgcolor="#FFFFFF"><a href="?skin=<?php echo $file?>&action=modify"><img src='../skin/<?php echo $file?>/image/mb.gif' width="100"  border='0'/></a></td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"> <a href="?skin=<?php echo $file?>&action=modify"><?php echo $f_array[2]?></a></td>
                        </tr>
                      </table></td>
                    <?php 
				  $i=$i+1;
				  if($i % 5==0 ){
				  echo"<tr>";
				  }
				}
				}	
closedir($dir);
unset ($f_array);
				?>
                </table>
              </div>
   
</div>
</div>
</div>
</div>
</body>
</html>