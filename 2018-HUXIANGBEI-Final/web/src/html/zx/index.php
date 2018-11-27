<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subzx.php");
$fp="../template/".$siteskin."/zx_index.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",zxlisttitle,$strout);
$strout=str_replace("{#pagekeywords}",zxlistkeyword,$strout);
$strout=str_replace("{#pagedescription}",zxlistdescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>