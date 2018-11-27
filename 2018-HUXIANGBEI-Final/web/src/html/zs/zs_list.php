<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzs.php");
include("../label.php");
if (isset ($_GET["action"])){
setcookie("zzcmscpid","",time()-3600);
echo "<script>location.href='zs_list.php'</script>";
}
if (isset($_GET["px"])){
$px=$_GET["px"];
	if ($px!='hit' && $px!='id' && $px!='sendtime'){
	$px="sendtime";
	}
setcookie("pxzs",$px,time()+3600*24*360);
}else{
	if (isset($_COOKIE["pxzs"])){
	$px=$_COOKIE["pxzs"];
	}else{
	$px="sendtime";
	}
}
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

if (isset($_GET["ys"])){
$ys=$_GET["ys"];
setcookie("yszs",$ys,time()+3600*24*360);
}else{
	if (isset($_COOKIE["yszs"])){
	$ys=$_COOKIE["yszs"];
	}else{
	$ys="list";
	}
}

$b = isset($_GET['b'])?$_GET['b']:"";
$s = isset($_GET['s'])?$_GET['s']:"";

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

$descriptionsx="";
	$keywordsx="";
	$titlesx="";
	$smallclassname="";
if ($s<>"") {
$sql="select * from zzcms_zsclass where classzm='".$s."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
	$descriptionsx=$row["discription"];
	$keywordsx=$row["keyword"];
	$titlesx=$row["title"];
	$smallclassname=$row["classname"];
	}	
}

$sx = isset($_GET['sx'])?$_GET['sx']:"0";
$province = isset($_GET['province'])?$_GET['province']:"";
$tp = isset($_GET['tp'])?$_GET['tp']:"";
$vip = isset($_GET['vip'])?$_GET['vip']:"";

if (isset($_GET["sj"])){
$sj=$_GET["sj"];
checkid($sj);
}else{
$sj="";
}

if ($titlesx!=''){
$pagetitle=$titlesx;
}elseif($titles!=''){
$pagetitle=$titles;
}else{
$pagetitle=zslisttitle;
}
if ($keywordsx!=''){
$pagekeyword=$keywordsx;
}elseif($keywords!=''){
$pagekeyword=$keywords;
}else{
$pagekeyword=zslistkeyword;
}
if ($descriptionsx!=''){
$pagedescription=$descriptionsx;
}elseif($descriptions!=''){
$pagedescription=$descriptions;
}else{
$pagedescription=zslistdescription;
}
$station=getstation($b,$bigclassname,$s,$smallclassname,"","","zs");

if ($b=="") {
$zsclass=bigclass($b,2);
}else{
$zsclass= showzssmallclass($b,$s,8,'');
}

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

$form_sx='';
$rs = query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
$row= num_rows($rs);
if ($row){
$form_sx=$form_sx . "<select name='sx'>";
$form_sx=$form_sx . "<option value='0' selected >请选择属性</option>";
	$n=0;
	while($row= fetch_array($rs)){
	$n ++;
	if ($sx==$row['bigclassid']){
	$form_sx=$form_sx . "<option value=$row[bigclassid] selected >$row[bigclassname]</option>";
	}else{
	$form_sx=$form_sx . "<option value=$row[bigclassid] >$row[bigclassname]</option>";
	}
	}
$form_sx=$form_sx . "</select>&nbsp;";
}

$form_qy="<select name='province' id='province' >";
$form_qy=$form_qy."<option value='' selected>不限</option>";
$city=explode("#",$citys);
$c=count($city);//循环之前取值
for ($i=0;$i<$c;$i++){ 
$location_p=explode("*",$city[$i]);//取数组的第一个就是省份名，也就是*左边的
	if ($location_p[0]==$province){
	$form_qy=$form_qy."<option value='".$location_p[0]."'selected>".$location_p[0]."</option>";
	}else{
	$form_qy=$form_qy."<option value='".$location_p[0]."'>".$location_p[0]."</option>";
	}
}
$form_qy=$form_qy."</select>";

$form_sj="&nbsp;<select name='sj'>";
if ($sj==10){
$form_sj=$form_sj . "<option value=10 selected >更新时间</option>";
}else{
$form_sj=$form_sj . "<option value=10 >更新时间</option>";
}
if ($sj==1){
$form_sj=$form_sj . "<option value=1 selected >当天</option>";
}else{
$form_sj=$form_sj . "<option value=1 >当天</option>";
}
if ($sj==3){
$form_sj=$form_sj . "<option value=3 selected>3天内</option>";
}else{
$form_sj=$form_sj . "<option value=3 >3天内</option>";
}
if ($sj==7){
$form_sj=$form_sj . "<option value=7 selected>7天内</option>";
}else{
$form_sj=$form_sj . "<option value=7 >7天内</option>";
}
if ($sj==30){
$form_sj=$form_sj . "<option value=30 selected>30天内</option>";
}else{
$form_sj=$form_sj . "<option value=30 >30天内</option>";
}
if ($sj==90){
$form_sj=$form_sj . "<option value=90 selected>90天内</option>";
}else{
$form_sj=$form_sj . "<option value=90 >90天内</option>";
}
$form_sj=$form_sj . "</select>";


if ($tp<>'') {
$form_img="&nbsp;<input name='tp' type='checkbox' id='tp' value='yes' checked/>";
}else{
$form_img="&nbsp;<input name='tp' type='checkbox' id='tp' value='yes'/>";
}
$form_img=$form_img . "有图";

if ($vip<>'') {
$form_vip="&nbsp;<input name='vip' type='checkbox' id='vip' value='yes' checked/>";
}else{
$form_vip="&nbsp;<input name='vip' type='checkbox' id='vip' value='yes'/>";
}
$form_vip=$form_vip . "VIP";

$form_px="&nbsp;<select name='menu2' onChange=MM_jumpMenu('parent',this,0)>";
$cs="/zs/zs_list.php?b=".$b."&s=".$s."&sx=".$sx."&province=".$province."&sj=".$sj."&tp=".$tp."&vip=".$vip." ";
if ($px=="id") {
$form_px=$form_px . "<option value='".$cs."&px=id' selected>最近发布</option>";
}else{
$form_px=$form_px . "<option value='".$cs."&px=id' >最近发布</option>";
}
if( $px=="sendtime") {
$form_px=$form_px . "<option value='".$cs."&px=sendtime' selected>最近更新</option>";
}else{
$form_px=$form_px . "<option value='".$cs."&px=sendtime'>最近更新</option>";
}
if ($px=="hit") { 
$form_px=$form_px . "<option value='".$cs."&px=hit' selected>最热点击</option>";
}else{
$form_px=$form_px . "<option value='".$cs."&px=hit'>最热点击</option>";
}
$form_px=$form_px . "</select>&nbsp;";

$showselectpage="<select name='menu1' onchange=MM_jumpMenu('parent',this,0)>";
if ($page_size=="20"){
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=20' selected >20条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=20' >20条/页</option>";
}
if ($page_size=="50"){
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=50' selected >50条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=50' >50条/页</option>";
}
if ($page_size=="100"){
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=100' selected >100条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page=".$page."&page_size=100' >100条/页</option>";
}
$showselectpage=$showselectpage . "</select>";

$form_xs="&nbsp;<a href='".$cs."&page=".$page."&ys=list'>";
if ($ys=="list") {
$form_xs=$form_xs . "<img src='/image/showlist.gif' border='0' title='图文显示' style='filter:gray'/>";
}else{
$form_xs=$form_xs . "<img src='/image/showlist.gif' border='0' title='图文显示' />";
}
$form_xs=$form_xs . "</a> ";

$form_xs=$form_xs . "<a href='".$cs."&page=".$page."&ys=window'>";
if ($ys=="window") {
$form_xs=$form_xs . "<img src='/image/showwindow.gif' border='0' title='橱窗显示' style='filter:gray'/>";
}else{
$form_xs=$form_xs . "<img src='/image/showwindow.gif' border='0' title='橱窗显示' />";
}
$form_xs=$form_xs . "</a> ";

$fp="../template/".$siteskin."/zs.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$sql="select count(*) as total from zzcms_main where passed<>0 ";		
$sql2='';
if ($b<>"") {
$sql2=$sql2." and bigclasszm='".$b."' ";
}

if ($s<>"") {
	if (zsclass_isradio=='Yes'){
	$sql2=$sql2." and smallclasszm ='".$s."'  ";
	}else{
	$sql2=$sql2." and smallclasszm like '%".$s."%' ";
	}
}

if ($sx<>0) {
$sql2=$sql2." and shuxing ='".$sx."' ";
}

if ($province<>"") {
$sql2=$sql2." and province like '%".$province."%' ";
}

if ($sj<>10 && $sj<>"") {
$sql2=$sql2." and  timestampdiff(day,sendtime,now()) < ". $sj ." " ;
}

if ($tp=="yes") {
$sql2=$sql2." and img<>'/image/nopic.gif' ";
}

if ($vip=="yes") {
$sql2=$sql2." and editor in (select username from zzcms_user where groupid>1) ";
}
$sql=$sql.$sql2;
$rs = query($sql); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select id,proname,prouse,shuxing_value,img,province,city,xiancheng,sendtime,editor,elite,userid,comane,qq,groupid,renzheng from zzcms_main where passed=1 ";	
$sql=$sql.$sql2;
$sql=$sql." order by groupid desc,elite desc,".$px." desc limit $offset,$page_size";
$rs = query($sql); 
$zs=strbetween($strout,"{zs}","{/zs}");
$list_list=strbetween($strout,"{loop_list}","{/loop_list}");
$list_window=strbetween($strout,"{loop_window}","{/loop_window}");

if(!$totlenum){
$strout=str_replace("{zs}".$zs."{/zs}","暂无信息",$strout) ;
}else{

$i=0;
$city="";
$keyword="";
$list2='';

	while($row= fetch_array($rs)){
	if ($ys=="window"){
	$list2 = $list2. str_replace("{#id}",$row["id"],$list_window) ;
	}else{
	$list2 = $list2. str_replace("{#id}",$row["id"],$list_list) ;
	}
	$list2 =str_replace("{#i}",$i,$list2) ;
	$list2 =str_replace("{#url}" ,getpageurl("zs",$row["id"]),$list2) ;
	$proname_num=strbetween($list2,"{#proname:","}");
	$list2 =str_replace("{#proname:".$proname_num."}",cutstr($row["proname"],$proname_num),$list2) ;
	$list2 =str_replace("{#img}" ,getsmallimg($row["img"]),$list2) ;
	$list2 =str_replace("{#imgbig}" ,$row["img"],$list2) ;
	$list2 =str_replace("{#comane}" ,$row["comane"],$list2) ;
	$list2 =str_replace("{#province}" ,$row["province"],$list2) ;
	$list2 =str_replace("{#city}",$row["city"],$list2) ;
	$list2 =str_replace("{#groupid}" ,$row["groupid"],$list2) ;
	$list2 =str_replace("{#userid}" ,$row["userid"],$list2) ;
	$list2 =str_replace("{#zturl}",getpageurlzt($row["editor"],$row["userid"]),$list2) ;//展厅地址
	
	if ($row["renzheng"]==1) {
	$list2 =str_replace("{#renzheng}" ,"<img src='/image/ico_renzheng.png' alt='认证会员'>",$list2) ;
	}else{
	$list2 =str_replace("{#renzheng}" ,"",$list2) ;
	}
	
	if ($row["elite"]==1) { 
	$list2 =str_replace("{#elite}" ,"<img src='/image/ico_jian.png' alt='tag:".$row["elite"]."' >",$list2) ;
	}else{
	$list2 =str_replace("{#elite}" ,"",$list2) ;
	}
	
	if ($row["qq"]!=''){
	$showqq="<a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$row["qq"]."&Site=".sitename."&MMenu=yes><img border='0' src='http://wpa.qq.com/pa?p=1:".$row["qq"].":10' alt='QQ交流'></a> ";
	$list2 =str_replace("{#qq}",$showqq,$list2) ;
	}else{
	$list2 =str_replace("{#qq}","",$list2) ;
	}
	
	$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($n=0; $n< count($shuxing_value);$n++){
	$list2=str_replace("{#shuxing".$n."}",$shuxing_value[$n],$list2);
	}
	$list2 =str_replace("{#prouse}" ,cutstr($row["prouse"],20),$list2) ;
	$list2 =str_replace("{#sendtime}" ,$row["sendtime"],$list2) ;

	$rsn=query("select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."");
	$rown=fetch_array($rsn);
	if ($rown){
	$list2 =str_replace("{#grouppic}" ,"<img src=".$rown["grouppic"]." alt=".$rown["groupname"].">",$list2) ;
	}
	
	if (showdlinzs=="Yes") {
	$rsn=query("select id from zzcms_dl where cpid=".$row["id"]." and passed=1");
	$list2 =str_replace("{#dl_num}","(".channeldl."留言<font color='#FF6600'><b>".num_rows($rsn)."</b></font>条)",$list2) ;
	}else{
	$list2 =str_replace("{#dl_num}","",$list2) ;
	}
	
	$i=$i+1;
	}
if ($ys=="window"){	
$strout=str_replace("{loop_window}".$list_window."{/loop_window}",$list2,$strout) ;
$strout=str_replace("{loop_list}".$list_list."{/loop_list}","",$strout) ;
}else{
$strout=str_replace("{loop_list}".$list_list."{/loop_list}",$list2,$strout) ;
$strout=str_replace("{loop_window}".$list_window."{/loop_window}","",$strout) ;
}
$strout=str_replace("{#fenyei}",fenyei(),$strout) ;
$strout=str_replace("{zs}","",$strout) ;
$strout=str_replace("{/zs}","",$strout) ;	
}

function fenyei(){
global $sx,$province,$sj,$tp,$vip,$b,$s,$page,$totlepage;
$zslist='';
$cs="&sx=".$sx."&province=".$province."&sj=".$sj."&tp=".$tp."&vip=".$vip."";
	if ($page<>1){
		if ($s<>"") {
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=1&b=".$b."&s=".$s.$cs."'>1...</a>";
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".($page-1)."&b=".$b."&s=".$s.$cs."'>上一页</a>";
		}else{
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=1&b=".$b.$cs."'>1...</a>";
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".($page-1)."&b=".$b.$cs."'>上一页</a>";
		}
	}
	
	if ($page <10) {$StartNum = 1;}else{$StartNum = $page-5;}
    $EndNum = $StartNum+9;
    if ($EndNum > $totlepage) {$EndNum = $totlepage;}
   	for($a=$StartNum; $a<$EndNum;$a++){
        if ($a==$page) {
		$zslist=$zslist . "<span>".$a."</span>";
        }else{
			if ($s<>"") {
			$zslist=$zslist . "<a href='/zs/zs_list.php?page=".$a."&b=".$b."&s=".$s.$cs."'>".$a."</a>";
			}else{
        	$zslist=$zslist . "<a href='/zs/zs_list.php?page=".$a."&b=".$b.$cs."'>".$a."</a>";
			}
		}
	}
	if ($page<>$totlepage ){
		if ($s<>""){
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".($page+1)."&b=".$b."&s=".$s.$cs."'>下一页</a>";
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".$totlepage."&b=".$b."&s=".$s.$cs."'>...".$totlepage."</a>";
		}else{
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".($page+1)."&b=".$b.$cs."'>下一页</a>";
		$zslist=$zslist . "<a href='/zs/zs_list.php?page=".$totlepage."&b=".$b.$cs."'>...".$totlepage."</a>";
		}
	}
return $zslist;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#station}",$station,$strout) ;
$strout=str_replace("{#zsclass}",$zsclass,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);

$strout=str_replace("{#form_sx}",$form_sx,$strout);
$strout=str_replace("{#form_qy}",$form_qy,$strout);
$strout=str_replace("{#form_sj}",$form_sj,$strout);
$strout=str_replace("{#form_img}",$form_img,$strout);
$strout=str_replace("{#form_vip}",$form_vip,$strout);
$strout=str_replace("{#b}",$b,$strout);
$strout=str_replace("{#s}",$s,$strout);
$strout=str_replace("{#form_px}",$form_px,$strout);
$strout=str_replace("{#showselectpage}",$showselectpage,$strout);
$strout=str_replace("{#form_xs}",$form_xs,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

session_write_close();
echo  $strout;	
?>