<?php 
include("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");

if (isset($_REQUEST["id"])){
$info_id=$_REQUEST["id"];
checkid($info_id);
}else{
$info_id=0;
}

$rs=query("Select * From zzcms_about where id='$info_id'" ) ;
$row=num_rows($rs);
if ($row){
$row=fetch_array($rs);
$content=$row["content"];
$title=$row["title"];
}else{
$content="暂无信息";
$title="暂无信息";
}

$fp="../template/".$siteskin."/siteinfo.htm";
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
$strout=str_replace("{#title}",$title,$strout) ;
$strout=str_replace("{#content}",$content,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout) ;
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
//$strout=showlabel($strout);
echo  $strout;
?>