<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subjob.php");
include("../label.php");

$fp="../template/".$siteskin."/job.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_job",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_job"])){
	$page_size=$_COOKIE["page_size_job"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET["b"])){
$b=$_GET["b"];
}else{
$b="";
}

if (isset($_GET["s"])){
$s=$_GET["s"];
}else{
$s="";
}


$bigclassname='';
if ($b<>""){
$sql="select classname from zzcms_jobclass where classid='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$smallclassname='';
if ($s<>"") {
$sql="select classname from zzcms_jobclass where classid='".$s."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
	$smallclassname=$row["classname"];
	}
}

$pagetitle=joblisttitle;
$pagekeyword=joblistkeyword;
$pagedescription=joblistdescription;

$station=getstation($b,$bigclassname,$s,$smallclassname,"","","job");

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

if ($b=="") {
$class=bigclass($b);
}else{
$class= showjobsmallclass($b,$s,8,'');
}

$list=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_job where passed<>0 ";
$sql2='';
if ($b<>""){
$sql2=$sql2. "and bigclassid='".$b."' ";
}
if ($s<>"") {
$sql2=$sql2." and smallclassid ='".$s."'  ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_job where passed<>0 ";	
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{

$list2='';
$i=0;
while($row= fetch_array($rs)){

$list2 = $list2. str_replace("{#province}",$row['province'],$list) ;
$list2 =str_replace("{#city}",cutstr($row["city"],8),$list2) ;
$list2 =str_replace("{#title}",cutstr($row["jobname"],8),$list2) ;
$list2 =str_replace("{#url}",getpageurl("job",$row['id']),$list2) ;
$list2 =str_replace("{#comane}",$row["comane"],$list2) ;
$list2 =str_replace("{#companyurl}",getpageurlzt($row['editor'],$row['userid']),$list2) ;
$list2 =str_replace("{#sendtime}",$row["sendtime"],$list2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("job"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",$station,$strout) ;
$strout=str_replace("{#class}",$class,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>