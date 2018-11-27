<?php
$t1 = microtime(true);
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subdl.php");
$fp="../template/".$siteskin."/dl_index.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",dllisttitle,$strout);
$strout=str_replace("{#pagekeywords}",dllistkeyword,$strout);
$strout=str_replace("{#pagedescription}",dllistdescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒';
?>