<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subcompany.php");

$fp="../template/".$siteskin."/company.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_REQUEST["page_size"])){
$page_size=$_REQUEST["page_size"];
checkid($page_size);
setcookie("page_size_company",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_company"])){
	$page_size=$_COOKIE["page_size_company"];
	}else{
	$page_size=pagesize_qt;
	}
}

$b=0;
if (isset($_REQUEST['b'])){
$b=$_REQUEST['b'];
checkid($b,1);
}

$s=0;
if (isset($_REQUEST['s'])){
$s=$_REQUEST['s'];
checkid($s,1);
}

$bigclassname="";
if ($b<>0){
$sql="select * from zzcms_userclass where classid='$b'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$smallclassname="";
if ($s<>0){
$sql="select * from zzcms_userclass where classid='$s'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$smallclassname=$row["classname"];
}
}

if (isset($_REQUEST["province"])){
$province=$_REQUEST["province"];
}else{
$province="";
}

$pagetitle=$province.companylisttitle.$bigclassname.sitename;
$pagekeyword=$province.$bigclassname.companylistkeyword;
$pagedescription=$province.$bigclassname.companylistdescription;
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
}else{
    $page=1;
}

if ($b=="") {
$class=bigclass($b);
}else{
$class= smallclass($b,$s,'');
}

$clist=strbetween($strout,"{loop}","{/loop}");
$sql="select count(*) as total from zzcms_user where  usersf='公司' and lockuser=0 and passed<>0  ";
$sql2='';
if ($b<>0){
$sql2=$sql2." and bigclassid=".$b." ";
}
if ($s<>0){
$sql2=$sql2." and smallclassid=".$s." ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_user where passed=1 and usersf='公司' and lockuser=0 ";
$sql=$sql.$sql2;
$sql=$sql." order by groupid desc,id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{loop}".$clist."{/loop}","暂无信息",$strout) ;
$strout=str_replace("{#fenyei}","",$strout) ;
}else{
$i=0;
$clist2="";
while($row= fetch_array($rs)){

if (sdomain=="Yes"){
$zturl="http://".$row["username"].".".substr(siteurl,strpos(siteurl,".")+1);
}else{
$zturl=getpageurl("zt",$row["id"]);
}


$rsn=query("select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."");
$rown=fetch_array($rsn);
$usergrouppic=$rown["grouppic"];
$usergroupname=$rown["groupname"];

$usergroup="<img src='".$usergrouppic."' alt='".$usergroupname."'>";
if ($row["renzheng"]==1) {
$usergroup=$usergroup."<img src='/image/ico_renzheng.png' alt='认证会员'>";
}

$rsn=query("select xuhao,proname,id from zzcms_main where editor='".$row["username"]."' and passed=1 order by xuhao asc limit 0,3");
$rown=num_rows($rsn);
$cp="";
if ($rown){
	while($rown=fetch_array($rsn)){
	$cp=$cp."<a href='".getpageurl("zs",$rown["id"])."'>".cutstr($rown["proname"],8)."</a>&nbsp;&nbsp;";
       } 
}else{
$cp="暂无产品";
}

$clist2 = $clist2. str_replace("{#comane}" ,$row["comane"],$clist) ;
$clist2 =str_replace("{#zturl}" ,$zturl,$clist2) ;
$clist2 =str_replace("{#usergroup}" ,$usergroup,$clist2) ;
$clist2 =str_replace("{#address}" ,$row["address"],$clist2) ;
$clist2 =str_replace("{#phone}" ,$row["phone"],$clist2) ;
$clist2 =str_replace("{#cp}" ,$cp,$clist2) ;
$clist2 =str_replace("{#imgbig}" ,$row["img"],$clist2) ;	
$clist2 =str_replace("{#img}" ,getsmallimg($row["img"]),$clist2) ;	
$i=$i+1;
}
$strout=str_replace("{loop}".$clist."{/loop}",$clist2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("company"),$strout) ;

}


$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",getstation($b,$bigclassname,$s,$smallclassname,"","","company"),$strout) ;
$strout=str_replace("{#class}",$class,$strout) ;
$strout=str_replace("{#numperpage}",showselectpage("company",$page_size,$b,"",$page),$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;
?>