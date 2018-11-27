<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");
include("../label.php");
if (isset($_REQUEST["action"])=="add"){
checkyzm($_POST["yzm"]);
session_write_close();
$sitename = isset($_POST['sitename'])?$_POST['sitename']:"";
$url = isset($_POST['url'])?addhttp($_POST['url']):"";
$logo = isset($_POST['logo'])?addhttp($_POST['logo']):"";
$content = isset($_POST['content'])?$_POST['content']:"";

if ($sitename==''||$url==''||$logo==''||$content==''){
	showmsg('请完整填写您的信息');
}

query("insert into zzcms_link (sitename,url,logo,content,sendtime)values('$sitename','$url','$logo','$content','".date('Y-m-d H:i:s')."')");
showmsg('操作成功！提示：提交申请后，请做好本站链接——如果没有增加本站的链接，那么你的申请是不会被通过的。','link.php') ;
}

$fp="../template/".$siteskin."/link.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>