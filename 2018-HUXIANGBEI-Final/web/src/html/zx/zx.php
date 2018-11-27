<?php
session_start();//为向AJAX/zx.php中传b,s值
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzx.php");
include("../label.php");

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_zx",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zx"])){
	$page_size=$_COOKIE["page_size_zx"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET['b'])){
$b=$_GET['b'];
checkid($b,1);
}else{
$b=0;
}
$_SESSION['zx_b']=$b;

if (isset($_GET['s'])){
$s=$_GET['s'];
checkid($s,1);
}else{
$s=0;
}
$_SESSION['zx_s']=$s;

$bigclassname="";
$classtitle="";
$classkeyword="";
$classdiscription="";
$smallclassname="";
if ($b<>0){
$sql="select * from zzcms_zxclass where classid='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){

$bigclassname=$row["classname"];
$classtitle=$row["title"];
$classkeyword=$row["keyword"];
$classdiscription=$row["discription"];
$skin=explode("|",$row["skin"]);
$skin=@$skin[1];//列表页是第二个参数
}
}
if (!isset($skin)){
$skin='zx_list.htm';
}

if ($s<>0){
$sql="select * from zzcms_zxclass where classid='".$s."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$smallclassname=$row["classname"];
}
}

$pagetitle=$classtitle.zxlisttitle;
$pagekeyword=$classkeyword.zxlistkeyword;
$pagedescription=$classdiscription.zxlistdescription;

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

if ($b=="") {
$zxclass=zxbigclass($b,2);
}else{
$zxclass=zxsmallclass($b,$s);
}

$fp="../template/".$siteskin."/".$skin;
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$list=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_zx where passed<>0 ";
$sql2='';
if ($b<>'') {
$sql2=$sql2." and bigclassid='".$b."' ";
}
if ($s<>'') {
$sql2=$sql2." and smallclassid='".$s."' ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select id,title,elite,sendtime,img,link,content,hit from zzcms_zx where passed=1"; 
$sql=$sql.$sql2;
$sql=$sql." order by elite desc,id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{
$list2="";
$shuxing="";
$i=0;

while($row= fetch_array($rs)){

if ($row["elite"]>0) {
$listimg="<font color=red>[置顶]</font>&nbsp;";
}elseif (time()-strtotime($row["sendtime"])<3600*24){
$listimg="[最新]&nbsp;" ;
}elseif ($row["hit"]>=1000) {
$listimg="[热门]&nbsp;";					
}else{
$listimg="";
}

if ($row["link"]<>""){
$link=$row["link"];
}else{
$link=getpageurl("zx",$row["id"]);	
}
if ($row["img"]<>"") {
	$shuxing="<font color='#FF6600'>(图)</font>";
}else{
	$shuxing='';
}	

$list2 = $list2. str_replace("{#link}",$link,$list) ;
$list2 =str_replace("{#id}",$row["id"],$list2) ;
$list2 =str_replace("{#title}",cutstr($row["title"],30),$list2) ;
$list2 =str_replace("{#imgbig}",$row["img"],$list2) ;
$list2 =str_replace("{#img}",getsmallimg($row["img"]),$list2) ;
$list2 =str_replace("{#content}",$row["content"],$list2) ;
$list2 =str_replace("{#sendtime}",date("Y-m-d",strtotime($row["sendtime"])),$list2) ;
$list2 =str_replace("{#listimg}" ,$listimg,$list2) ;
$list2 =str_replace("{#shuxing}" ,$shuxing,$list2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("zx"),$strout) ;
}
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",getstation($b,$bigclassname,$s,$smallclassname,"","","zx"),$strout) ;
$strout=str_replace("{#showselectpage}",showselectpage("zx",$page_size,$b,"",$page),$strout);
$strout=str_replace("{#zxclass}",$zxclass,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>