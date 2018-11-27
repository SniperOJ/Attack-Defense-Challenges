<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../inc/fy.php");
include("subzh.php");
include("../label.php");
$fp="../template/".$siteskin."/zh_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_zh",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zh"])){
	$page_size=$_COOKIE["page_size_zh"];
	}else{
	$page_size=pagesize_qt;
	}
}
if (isset($_GET['keyword'])){
$keyword=trim($_GET['keyword']);
}else{
$keyword="";
}

if (isset($_GET['province'])){
$province=trim($_GET['province']);
}else{
$province="";
}

if (isset($_GET['sj'])){
$sj=trim($_GET['sj']);
}else{
$sj="";
}
if ($sj<>"") {
checkid($sj);
}

if (isset($_GET['b'])){
$b=trim($_GET['b']);
}else{
$b="";
}

if ($b<>""){
checkid($b);
$sql="select * from zzcms_zhclass where bigclassid=".$b." ";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["bigclassname"];
}
}else{
$bigclassname="";
}

$pagetitle=sitename.zhlisttitle;
$pagekeyword=sitename.zhlistkeyword;
$pagedescription=sitename.zhlistdescription;

function formbigclass($b){
$sql = "select * from zzcms_zhclass  ";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str= "请先添加类别名称。";
}else{
$str="<option value=''>不限类别</option>";
	while($row=fetch_array($rs)){
		if ($row["bigclassid"]==$b){
		$str=$str."<option value='".$row["bigclassid"]."' selected>".$row["bigclassname"]."</option>";
		}else{
		$str=$str."<option value='".$row["bigclassid"]."'>".$row["bigclassname"]."</option>";
		}
	}
}
return $str;
}

function formprovince($province){
	global $citys;
		$str="<option value='' selected>不限</option>";
		$city=explode("#",$citys);
		$c=count($city);//循环之前取值
	for ($i=0;$i<$c;$i++){ 
	$location_p=explode("*",$city[$i]);//取数组的第一个就是省份名，也就是*左边的
			if ($location_p[0]==$province){
			$str=$str."<option value='".$location_p[0]."'selected>".$location_p[0]."</option>";
			}else{
			$str=$str."<option value='".$location_p[0]."'>".$location_p[0]."</option>";
			}
	}
	return $str;
	}
//时间
$strsj="<option value='' selected>不限</option>";
for ($i=1;$i<=12;$i++){
	if ($sj==$i){
	$strsj=$strsj. "<option value=".$i." selected>".$i."月份</option>";
	}else{
	$strsj=$strsj. "<option value=".$i.">".$i."月份</option>";
	}
}

$sql="select count(*) as total from zzcms_zh where passed<>0 ";
$sql2='';
if ($keyword<>"") {
$sql2=$sql2." and title like '%".$keyword."%' ";
}	

if ($province<>""){
$sql2=$sql2." and address like '%".$province."%' ";
}	

if ($sj<>""){
$sql2=$sql2." and month(timestart) ='".$sj."' ";	
}	

if ($b<>""){
$sql2=$sql2." and bigclassid ='".$b."' ";
}

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}
$list=strbetween($strout,"{loop}","{/loop}");

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select id,title,address,timestart,timeend,elite from zzcms_zh where passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 

if(!$totlenum){
	$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
	$strout=str_replace("{#fenyei}","",$strout) ;
}else{
$i=0;
$list2="";
while($row= fetch_array($rs)){
$list2 = $list2. str_replace("{#zhurl}" ,getpageurl("zh",$row["id"]),$list) ;
$list2 =str_replace("{#title}" ,$row["title"],$list2) ;
$list2 =str_replace("{#timestart}" ,$row["timestart"],$list2) ;
$list2 =str_replace("{#timeend}" ,$row["timeend"],$list2) ;
$list2 =str_replace("{#address}" ,$row["address"],$list2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("zh"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#keyword}",$keyword,$strout);
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","zh"),$strout) ;
$strout=str_replace("{#sj}",showsj(4,$sj),$strout);
$strout=str_replace("{#formbigclass}",formbigclass($b),$strout);
$strout=str_replace("{#formprovince}",formprovince($province),$strout);
$strout=str_replace("{#formsj}",$strsj,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;	
?>