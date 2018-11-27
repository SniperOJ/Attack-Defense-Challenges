<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzx.php");
include("../label.php");
$b="";
if (isset($_GET['b'])){ 
$b=$_GET['b'];
checkid($b);
}
$skin='';
$bigclassname="";
if ($b<>"") {
$sql="select classname,title,keyword,discription,skin from zzcms_zxclass where classid='".$b."'";
$rs=query($sql);
$row=num_rows($rs);
	if ($row){
	$row=fetch_array($rs);
	$bigclassname=$row["classname"];
	$classtitle=$row["title"];
	$classkeyword=$row["keyword"];
	$classdiscription=$row["discription"];
	$skin=explode("|",$row["skin"]);
	$skin=$skin[0];
	}
}
if ($skin==''){$skin='zx_class.htm';}
$fp="../template/".$siteskin."/".$skin;
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
$strout=str_replace("{#bigclassname}",$bigclassname,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo $strout;
?>