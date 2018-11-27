<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../zs/subzs.php");
include("../label.php");
if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_zs",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zs"])){
	$page_size=$_COOKIE["page_size_zs"];
	}else{
	$page_size=pagesize_qt;
	}
}
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
$more="<a href='".getpageurl2("zs",$b,'')."'>更多...</a>";

$sql="select * from zzcms_ad where  id<>0 ";
		
if ($b<>""){
$sql=$sql . "and bigclassname='".$b."' and smallclassname='列表页'";
}

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}
$rs = query($sql); 
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
$row= num_rows($rs);//返回记录数
if(!$row){
$adlist="<div style='margin:50px 0'>暂无信息</div>";
}else{
//
$column=4;
$showborder=true;
$showtitle=true;
$i=1;
$adlist="<table border=0 cellpadding=0 cellspacing=0  style='color:#666666;'><tr>";
while($row= fetch_array($rs)){

if ($row["img"]<>"") {
if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false) {
	if ($column==1) {
	$adlist=$adlist."<td class='imgadS'> ";
	}else{
		if ($i==1 || ($i-1) % $column==0) {
    	$adlist=$adlist."<td class='imgadH' style='padding-left:0px;'> ";
		}else{
		$adlist=$adlist."<td class='imgadH'>" ;
		}
	}	
	if ($showborder==true) {
	$adlist=$adlist. "<div style='border:solid 1px #dddddd' align='center'>";
	}else{
	$adlist=$adlist. "<div align='center'>";
	}
	if ($row["endtime"]>= date('Y-m-d')) {
	$adlist=$adlist. "<a href='".$row["link"]."' target='_blank' style='font-weight:bold;font-size:14px'><img src='".siteurl."/".$row["img"]."' height='".$row["imgheight"]."' width='".$row["imgwidth"]."' border='0' alt='".$row["title"]."'/>";
    }else{
	$adlist=$adlist. "<a href='#' target='_blank'><img src='".siteurl."/image/noad.gif' height='".$row["imgheight"]."' width='".$row["imgwidth"]."' border='0' alt='".$row["title"]."'/>";
	}
	if ($showtitle==true){
	$adlist=$adlist.'<br/>'.$row["title"];
	}
	$adlist=$adlist.'</a>';
    $adlist=$adlist."</div>"  ;                   
    $adlist=$adlist."</td>";
}elseif (substr($row["img"],-3)=="swf"){                     
	if ($i==1 || ($i-1) % $column==0) { 
    $adlist=$adlist."<td class='imgadH' style='padding-left:0px;'> ";
	}else{
	$adlist=$adlist."<td class='imgadH'>" ;
	}
	if ($showborder==true) {
	$adlist=$adlist. "<div style='border:solid 1px #dddddd' align='center'>";
	}else{
	$adlist=$adlist. "<div align='center'>";
	}
	$adlist=$adlist."<a href='".$row["link"]."' target='_blank' style='font-weight:bold;font-size:14px'>";
	$adlist=$adlist."<button disabled='disabled' style='border-style: none; background-color: #FFFFFF; background-image: none;width:".$row["imgwidth"]."px' >" ;
	$adlist=$adlist."<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0 width=".$row["imgwidth"]." height=".$row["imgheight"].">";
    $adlist=$adlist."<param name='movie' value='".siteurl.$row["img"]."' />";
    $adlist=$adlist."<param name='quality' value='high' />" ;
	$adlist=$adlist."<param name='wmode' value='Opaque' />" ;//必要参数否则在SWF文件上无法点击链接
    if ($row["endtime"]>= date('Y-m-d')) {
		$adlist=$adlist."<embed src='".siteurl.$row["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='Opaque' width='".$row["imgwidth"]."' height='".$row["imgheight"]."'></embed>";
	}else{
    	$adlist=$adlist."<embed src='".siteurl."/image/noad.gif' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='Opaque' width='".$row["imgwidth"]."' height='".$row["imgheight"]."'></embed>";
	}
	$adlist=$adlist."</object>" ;
    $adlist=$adlist."</button>";
	if ($showtitle==true) {
    $adlist=$adlist."<br/>".substr($row["title"],0,16);
	}
	
	$adlist=$adlist."</a>" ; 
    $adlist=$adlist."</div></td>";
}
}
	if ($i % $column==0){
	$adlist=$adlist."</tr>";
	}
	$i=$i+1;
}
$adlist=$adlist." </table>";

//
$adlist=$adlist . "<div style='clear:both'></div>";
$adlist=$adlist . "<div class='fenyei'> ";
$adlist=$adlist . showpage2("zsclass");
$adlist=$adlist . "</div>";
}
$fp="../template/".$siteskin."/zs_class2.htm";
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
$strout=str_replace("{#more}",$more,$strout);
$zssmallclass_num=strbetween($strout,"{#zssmallclass:","}");
$strout=str_replace("{#zssmallclass:".$zssmallclass_num."}",showzssmallclass($b,"",$zssmallclass_num,$zssmallclass_num),$strout);
$strout=str_replace("{#adlist}",$adlist,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>