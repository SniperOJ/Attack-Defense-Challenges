<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subcompany.php");
$file="../template/".$siteskin."/company_index.htm";
if (file_exists($file)==false){
WriteErrMsg($file.'模板文件不存在');
exit;
}
$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",companylisttitle,$strout);
$strout=str_replace("{#pagekeywords}",companylistkeyword,$strout);
$strout=str_replace("{#pagedescription}",companylistdescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;
?>