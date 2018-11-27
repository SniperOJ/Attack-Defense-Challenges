<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzh.php");
include("../label.php");
$fp="../template/".$siteskin."/zh.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_REQUEST["page_size"])){
$page_size=$_REQUEST["page_size"];
checkid(page_size);
setcookie("page_size_zh",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zh"])){
	$page_size=$_COOKIE["page_size_zh"];
	}else{
	$page_size=pagesize_qt;
	}
}
$b='';
if (isset($_REQUEST['b'])){
$b=$_REQUEST['b'];
if ($b<>""){
checkid($b);
}
}
$bigclassname="";
if ($b<>""){
$sql="select * from zzcms_zhclass where bigclassid='$b'";
$rs=query($sql);
$row=fetch_array($rs);
$bigclassname=$row["bigclassname"];
}

$pagetitle=$bigclassname.zhlisttitle."-".sitename;
$pagekeyword=$bigclassname.zhlistkeyword."-".sitename;
$pagedescription=$bigclassname.zhlistdescription."-".sitename;

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}
$list=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_zh where passed<>0 ";
$sql2='';
if ($b<>""){
$sql2=$sql2." and bigclassid='".$b."' ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select id,title,address,timestart,timeend,elite from zzcms_zh where passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by elite desc,id desc limit $offset,$page_size";
$rs = query($sql); 

if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{
$i=0;
$list2='';
while($row= fetch_array($rs)){
$list2 = $list2. str_replace("{#zhurl}" ,getpageurl("zh",$row["id"]),$list) ;
if ($row["elite"]>0){
$list2 =str_replace("{#title}" ,$row["title"]."<img alt='置顶' src='/image/ding.gif' border='0'>",$list2) ;
}else{
$list2 =str_replace("{#title}" ,$row["title"],$list2) ;
}
$list2 =str_replace("{#timestart}" ,date("Y-m-d",strtotime($row["timestart"])),$list2) ;
$list2 =str_replace("{#timeend}" ,date("Y-m-d",strtotime($row["timeend"])),$list2) ;
$list2 =str_replace("{#address}" ,$row["address"],$list2) ;

$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("zh"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","zh"),$strout) ;
$strout=str_replace("{#zhclass}",bigclass($b),$strout) ;
$strout=str_replace("{#sj}",showsj(4,""),$strout) ;
$strout=str_replace("{#numperpage}",showselectpage("zh",$page_size,$b,"",$page),$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>