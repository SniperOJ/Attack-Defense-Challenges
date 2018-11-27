<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzt.php");
include("../label.php");
$b="";
if (isset($_GET['b'])){ 
$b=$_GET['b'];
checkid($b);
}
$bigclassname="";
if ($b<>"") {
$sql="select classname,title,keyword,discription from zzcms_specialclass where classid='".$b."'";
$rs=query($sql);
$row=num_rows($rs);
	if ($row){
	$row=fetch_array($rs);
	$bigclassname=$row["classname"];
	$classtitle=$row["title"];
	$classkeyword=$row["keyword"];
	$classdiscription=$row["discription"];
	}
}

$fp="../template/".$siteskin."/special_class.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",ztlisttitle,$strout);
$strout=str_replace("{#pagekeywords}",ztlistkeyword,$strout);
$strout=str_replace("{#pagedescription}",ztlistdescription,$strout);
$strout=str_replace("{#bigclassname}",$bigclassname,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo $strout;
?>