<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/ztconfig_skin.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (str_is_inarr(usergr_power,'zt')=="no" && $usersf=='个人'){
echo $f_array[1];
exit;
}

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if($action=="modify"){
$skin=$_POST["skin"];

query("update zzcms_usersetting set skin='$skin' where username='".$username."'");			
echo $f_array[2];
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
<div class="admintitle"><?php echo $f_array[0]?></div>
<form name="myform" method="post" action="?action=modify"> 
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
                  <tr>        
                    <?php 
$rs=query("select skin from zzcms_usersetting where username='".$username."'");
$row=fetch_array($rs);					
$fp=zzcmsroot."skin";	
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板目录不存在');
exit;
}				
$dir = opendir($fp);
$i=0;
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && strpos($file,".zip")==false && strpos($file,".rar")==false && strpos($file,".txt")==false && $file!='mobile') { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。 
?>
                    <td align="center" bgcolor="#FFFFFF"><table width="120" border="0" cellpadding="5" cellspacing="1">
                        <tr> 
                          <td align="center" <?php if($row["skin"]==$file){ echo "bgcolor='#FF0000'";}else{echo "bgcolor='#FFFFFF'"; }?>>
						  <img src='../skin/<?php echo $file?>/image/mb.gif'  border='0' width="120"/>
						  </td>
                        </tr>
                        <tr> 
                          <td align="center" bgcolor="#FFFFFF"> <input name="skin" type="radio" id='<?php echo $file?>' value="<?php echo $file?>" <?php if($row["skin"]==$file){ echo"checked";}?>/> 
                            <label for='<?php echo $file?>'><?php echo $file?></label><br />
<input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[3]?>" />
</td>
                        </tr>
                    </table></td>
                    <?php 
				  $i=$i+1;
				  if($i % 6==0 ){
				  echo"<tr>";
				  }
				}
				}	
closedir($dir);
unset ($f_array);
				?>
           </table>  

</form>
</div>
</div>
</div>
</div>
</body>
</html>