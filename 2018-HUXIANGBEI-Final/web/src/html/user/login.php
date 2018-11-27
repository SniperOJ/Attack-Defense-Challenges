<?php
include("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");

$file="../template/".$siteskin."/login.htm";
$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));
$uname = isset($_GET['username'])?$_GET['username']:""; 
$case1=strbetween($strout,"{case1}","{/case1}");
$case2=strbetween($strout,"{case2}","{/case2}");
if (empty($_COOKIE["UserName"])){
$strout=str_replace("{case1}","",$strout) ;
$strout=str_replace("{/case1}","",$strout) ;
$strout=str_replace("{case2}".$case2."{/case2}","",$strout) ;
}else{
$strout=str_replace("{case2}","",$strout) ;
$strout=str_replace("{/case2}","",$strout) ;
$strout=str_replace("{case1}".$case1."{/case1}","",$strout) ;
}
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#fromurl}",@$_SERVER['HTTP_REFERER'],$strout) ;
$strout=str_replace("{#username}",@$_COOKIE["UserName"],$strout);
$strout=str_replace("{#uname}",$uname,$strout);

$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
echo  $strout;
?>
