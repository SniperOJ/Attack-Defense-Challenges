<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../zs/subzs.php");
include("../label.php");

if (isset($_GET["province"])){
$province=$_GET["province"];
}else{
$province="";
}
$provincezm=$province;
$province=trim(province_zm2hz($province));//省份名从记事本中的数组中读出的，得加trim去除去两端空白内容，否则无法从数据库中读取到内容
$fp="../template/".$siteskin."/area_show.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#pagetitle}",$province.sitetitle,$strout);
$strout=str_replace("{#pagekeywords}",$province.sitekeyword,$strout);
$strout=str_replace("{#pagedescription}",sitedescription,$strout);
$strout=str_replace("{#province}",$province,$strout) ;
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;
?>