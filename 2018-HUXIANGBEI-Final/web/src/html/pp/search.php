<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subpp.php");
include("../label.php");

$fp="../template/".$siteskin."/pp_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_GET['yiju'])){
$yiju=$_GET['yiju'];
}else{
$yiju="Pname";
}

if (isset($_GET['keyword'])){
$keywordNew=nostr(trim($_GET['keyword']));
setcookie("keyword",$keywordNew,time()+3600*24);
setcookie("b","xxx",1);
setcookie("s","xxx",1);
echo "<script>location.href='search.php'</script>";
$keyword=$keywordNew;
}else{
	if (isset($_COOKIE['keyword'])){
	$keyword=trim($_COOKIE['keyword']);
	}else{
	$keyword="";
	}
}

if (isset($_GET['b'])){
$bNew=$_GET['b'];
setcookie("b",$bNew,time()+3600*24);
setcookie("s","xxx",1);
echo "<script>location.href='search.php'</script>";
$b=$bNew;
}else{
	if (isset($_COOKIE['b'])){
	$b=$_COOKIE['b'];
	}else{
	$b="";
	}
}

if (isset($_GET['s'])){
$sNew=$_GET['s'];
setcookie("s",$sNew,time()+3600*24);
$s=$sNew;
}else{
	if (isset($_COOKIE['zss'])){
	$s=$_COOKIE['s'];
	}else{
	$s="";
	}
}

if (isset($_GET['delb'])){
setcookie("b","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
setcookie("s","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_pp",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_pp"])){
	$page_size=$_COOKIE["page_size_pp"];
	}else{
	$page_size=pagesize_qt;
	}
}

$bigclassname='';
if ($b<>""){
$sql="select classname from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$smallclassname='';
if ($s<>"") {
$sql="select classname from zzcms_zsclass where classzm='".$s."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
	$smallclassname=$row["classname"];
	}
}

function formbigclass(){
		$str="";
        $sql = "select * from zzcms_zsclass where parentid='A'";
        $rs=query($sql);
		$row=num_rows($rs);
		if (!$row){
		$str= "请先添加类别名称。";
		}else{
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classzm"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}
		return $str;
		}
		
		function formsmallclass($b){
		$str="";
        $sql="select * from zzcms_zsclass where parentid='" .$b. "' order by xuhao asc";
        $rs=query($sql);
		$row=num_rows($rs);
		if ($row){
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?s=".$row["classzm"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}	
		return $str;
		}
		
if ($b<>"" || $s<>"") {
		$selected="<tr>";
		$selected=$selected."<td align='right'>已选条件：</td>";
		$selected=$selected."<td class='a_selected'>";
			if ($b<>"") {
			$selected=$selected."<a href='?delb=Yes' >".$bigclassname."×</a>&nbsp;";
			}
			
			if ($s<>""){
			$selected=$selected."<a href='?dels=Yes' >".$smallclassname."×</a>&nbsp;";
			}

		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}
		
$pagetitle=pplisttitle;
$pagekeyword=pplistkeyword;
$pagedescription=pplistdescription;

$station=getstation($b,$bigclassname,$s,$smallclassname,"","","pp");

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

$list=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_pp where passed<>0 ";	
$sql2='';
switch ($yiju){
	case "Pname";
	$sql2=$sql2. " and ppname like '%".$keyword."%' ";//加括号,否则后面的条件无效
	break;
	case "Pcompany";
	$sql2=$sql2."and comane like '%".$keyword."%' " ; 
	break;
	}

if ($b<>""){
$sql2=$sql2. "and bigclasszm='".$b."' ";
}
if ($s<>"") {
$sql2=$sql2." and smallclasszm ='".$s."'  ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_pp where passed=1 ";
$sql=$sql.$sql2;	
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{

$list2='';
$i=0;
$title_num=strbetween($list,"{#title:","}");
$content_num=strbetween($list,"{#content:","}");
while($row= fetch_array($rs)){

$list2 = $list2. str_replace("{#img}",getsmallimg($row['img']),$list) ;
$list2 =str_replace("{#imgbig}",$row['img'],$list2) ;
$list2 =str_replace("{#title:".$title_num."}",cutstr($row["ppname"],$title_num),$list2) ;
$list2 =str_replace("{#title}",$row["ppname"],$list2) ;
$list2 =str_replace("{#content:".$content_num."}",cutstr($row["sm"],$content_num),$list2) ;
$list2 =str_replace("{#content}",$row["sm"],$list2) ;
$list2 =str_replace("{#url}",getpageurl("pp",$row['id']),$list2) ;
$list2 =str_replace("{#comane}",$row["comane"],$list2) ;
$list2 =str_replace("{#companyurl}",getpageurlzt($row['editor'],$row['userid']),$list2) ;
$list2 =str_replace("{#sendtime}",$row["sendtime"],$list2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("pp"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",$station,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);

if ($b=="") {//当小类为空显示大类，否则只显小类
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
}else{
$strout=str_replace("{#formbigclass}","",$strout);
}
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#formkeyword}",$keyword,$strout);


$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>