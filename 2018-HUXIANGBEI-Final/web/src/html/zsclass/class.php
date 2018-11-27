<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../zs/subzs.php");
include("../label.php");
if (isset($_GET["b"])){
$b=$_GET["b"];
}else{
$b="";
}

$descriptions="";
$keywords="";
$titles="";
$bigclassname="";

if ($b<>""){
$sql="select * from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$descriptions=$row["discription"];
$keywords=$row["keyword"];
$titles=$row["title"];
$bigclassname=$row["classname"];
}
}
$pagetitle=$titles."-".sitename;
$pagekeyword=$keywords;
$pagedescription=$descriptions;
$bigclass="<a href='".getpageurl2("zs",$b,"")."'>".$bigclassname."</a>";
//bigclass="<span><a href='"&getpageurl2("zs",b,"")&"'>更多...</a></span>"&bigclassname&""

$fp="../template/".$siteskin."/zs_class.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#bigclass}",$bigclass,$strout);
$strout=str_replace("{#bigclassname}",$bigclassname,$strout);
//$strout=str_replace("{#more}",$more,$strout);
$zssmallclass_num=strbetween($strout,"{#zssmallclass:","}");
$strout=str_replace("{#zssmallclass:".$zssmallclass_num."}",showzssmallclass($b,"",$zssmallclass_num,$zssmallclass_num),$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;

?>