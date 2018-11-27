<?php
include("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");
$sql = "select * from zzcms_usergroup";
$rs = query($sql,$conn); 
//$row= fetch_array($rs);
$row= num_rows($rs);//返回记录数
if(!$row){
showmsg ("尚未设置用户组，设好用户组后才能注册用户"); 
}

if (openuserreg=="No"){
showmsg (openuserregwhy); 
}

$file="../template/".$siteskin."/userreg.htm";
if (file_exists($file)==false){
WriteErrMsg($file.'模板文件不存在');
exit;
}
$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;

$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
echo  $strout;
?>