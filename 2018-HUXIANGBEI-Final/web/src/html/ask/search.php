<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subask.php");
include("../label.php");

$fp="../template/".$siteskin."/ask_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_ask",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_ask"])){
	$page_size=$_COOKIE["page_size_ask"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_POST['keyword'])){
$keyword=trim($_POST['keyword']);
}else{
$keyword="";
}

if (isset($_GET['typeid'])){
$typeid=trim($_GET['typeid']);
checkid($typeid,1);
}else{
$typeid=999;
}

if (isset($_GET['elite'])){
$elite=trim($_GET['elite']);
checkid($elite);
}else{
$elite=0;
}

if (isset($_GET['b'])){
$bNew=$_GET['b'];
checkid($bNew,1);
setcookie("askb",$bNew,time()+3600*24);
$b=$bNew;
}else{
	if (isset($_COOKIE['askb'])){
	$b=$_COOKIE['askb'];
	}else{
	$b=0;
	}
}

if (isset($_GET['s'])){
$sNew=$_GET['s'];
checkid($sNew,1);
setcookie("asks",$sNew,time()+3600*24);
$s=$sNew;
}else{
	if (isset($_COOKIE['asks'])){
	$s=$_COOKIE['asks'];
	}else{
	$s=0;
	}
}
$bigclassname="";
$smallclassname="";
if ($b<>0){
$sql="select * from zzcms_askclass where classid='$b'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}
if ($s<>0) {
$sql="select * from zzcms_askclass where classid='$s'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
	$smallclassname=$row["classname"];
	}	
}
if (isset($_GET['delb'])){
setcookie("askb","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
setcookie("asks","xxx",1);
echo "<script>location.href='search.php'</script>";
}
$pagetitle=sitename.asklisttitle.$bigclassname;
$pagekeyword=sitename.asklisttitle.$bigclassname;
$pagedescription=sitename.asklisttitle.$bigclassname;

function formbigclass(){
		$str="";
        $sql = "select * from zzcms_askclass where parentid=0";
        $rs=query($sql);
		$row=num_rows($rs);
		if (!$row){
		$str= "请先添加类别名称。";
		}else{
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classid"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}
		return $str;
		}
		
		function formsmallclass($b){
		if ($b<>0){
		$str="";
        $sql="select * from zzcms_askclass where parentid='".$b."' order by xuhao asc";
        $rs=query($sql);
		$row=num_rows($rs);
		if ($row){
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?s=".$row["classid"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}	
		return $str;
		}
		}

if ($b<>0 || $s<>0 ) {
		$selected="<tr>";
		$selected=$selected."<td align='right'>已选条件：</td>";
		$selected=$selected."<td class='a_selected'>";
			if ($b<>0) {
			$selected=$selected."<a href='?delb=Yes'>".$bigclassname."×</a>&nbsp;";
			}
			if ($s<>0){
			$selected=$selected."<a href='?dels=Yes'>".$smallclassname."×</a>&nbsp;";
			}
		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

$list=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_ask where passed<>0 ";
$sql2='';
if ($b<>0){
$sql2=$sql2." and bigclassid='".$b."' ";
}

if ($s<>0 ) {
$sql2=$sql2." and smallclassid='".$s."' ";
}
if ($typeid != 999 && $typeid != 2){//为2时是高悬赏问题，按jifen排序
$sql2 = $sql2 . " and typeid='".$typeid."' ";
}

if ($elite != 0){
$sql2 = $sql2 . " and elite>0 ";
}

if ($typeid == 2){//为2时是高悬赏问题
$sql2 = $sql2 . " and jifen>0 ";
}

if ($keyword<>"") {
$sql2=$sql2." and title like '%".$keyword."%' ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS 
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_ask where passed=1";
$sql=$sql.$sql2;

//if ($typeid == 2){//为2时是高悬赏问题，按jifen排序
$sql = $sql . " order by jifen desc,id desc ";
//}

$sql=$sql." limit $offset,$page_size";
$rs = query($sql); 

if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{
$list2='';
$shuxing='';
$i=0;
while($row= fetch_array($rs)){
if ($row["elite"]>0) {
$listimg="<font color=red>[推荐]</font>&nbsp;";
}elseif (time()-strtotime($row["sendtime"])<3600*24){
$listimg="[最新]&nbsp;" ;
}elseif ($row["hit"]>=1000) {
$listimg="[热门]&nbsp;";					
}else{
$listimg="[普通]&nbsp;";
}

$link=getpageurl("ask",$row["id"]);

if ($row["img"]<>"") {
	$shuxing="<font color='#FF6600'>(图)</font>";
}	

$list2 = $list2. str_replace("{#link}",$link,$list) ;
$list2 =str_replace("{#title}",cutstr($row["title"],30),$list2) ;
$list2 =str_replace("{#sendtime}",date("y-m-d",strtotime($row["sendtime"])),$list2) ;
$list2 =str_replace("{#listimg}" ,$listimg,$list2) ;
$list2 =str_replace("{#shuxing}" ,$shuxing,$list2) ;
$list2 =str_replace("{#jifen}" ,$row["jifen"],$list2) ;

$rs_answer_num = query("select count(*) as total from zzcms_answer where about='".$row["id"]."' "); 
$row_answer_num = fetch_array($rs_answer_num);
$answer_num = $row_answer_num['total'];
$list2=str_replace("{#answer_num}", $answer_num,$list2);

if ($row["typeid"]==1){
$zhuangtai_biaozhi="<img src='/image/dui2.png' title='已解决'>";
}elseif ($row["typeid"]==0){
$zhuangtai_biaozhi="<img src='/image/wenhao.png' title='待解决'>";
}
$list2=str_replace("{#zhuangtai}", $zhuangtai_biaozhi,$list2);

$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("ask"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",getstation(0,"",0,"","",$keyword,"ask"),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
if ($b==0) {//当小类为空显示大类，否则只显小类
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
}else{
$strout=str_replace("{#formbigclass}","",$strout);
}

$strout=str_replace("{#typeid".$typeid."}","class=current1",$strout);//模板页typeid设定当前样式
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);
$strout=str_replace("{#keyword}",$keyword,$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo $strout;
?>