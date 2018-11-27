<?php
require("inc/conn.php");
$domain=$_SERVER['HTTP_HOST']; //取得用户所访问的域名全称
$domain2=substr($domain,0,strpos($domain,'.'));
$domain_zhu=get_zhuyuming($domain);//针对www.为空的情况，判断$domain2<>$domainzhu

//echo $domain.'<br>'.str_replace("http://","",siteurl);

if ($domain<>str_replace("http://","",siteurl) && $domain<>'localhost:8080' && $domain<>'localhost' && $domain2<>$domain_zhu && check_isip($domain)==false){
header("Location: default.htm",TRUE,301);//show.php及其它页面中以二级域名值为$editor
exit;
}

include("inc/top_index.php");
include("inc/bottom.php");
include("label.php");
include("zs/subzs.php");
include("inc/fly.php");

$fp=dirname(__FILE__)."/template/".$siteskin."/index.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$fso = fopen($fp,'r');
$strout = fread($fso,filesize($fp));
fclose($fso);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#pagetitle}",sitetitle,$strout);
$strout=str_replace("{#pagekeywords}",sitekeyword,$strout);
$strout=str_replace("{#pagedescription}",sitedescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=str_replace("{#searchbyszm}",szm(),$strout);
if (strpos($strout,"{@")!==false) $strout=showlabel($strout);//先查一下，如是要没有的就不用再调用showlabel

if (flyadisopen=="Yes") {
$strout=str_replace("{#flyad}",Showflyad("首页","漂浮广告"),$strout);
}else{
$strout=str_replace("{#flyad}","",$strout);
}
if (duilianadisopen=="Yes"){
$strout=str_replace("{#duilianad}",showduilianad("首页","对联广告左侧","对联广告右侧"),$strout);
}else{
$strout=str_replace("{#duilianad}","",$strout);
}
echo  $strout;
?>