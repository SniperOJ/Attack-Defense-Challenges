<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subwangkan.php");
$fp="../template/".$siteskin."/wangkan_index.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",wangkanlisttitle,$strout);
$strout=str_replace("{#pagekeywords}",wangkanlistkeyword,$strout);
$strout=str_replace("{#pagedescription}",wangkanlistdescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>