<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subbaojia.php");
include("../label.php");
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}
if (isset($_GET["b"])){
$b=$_GET["b"];
}else{
$b="";
}


$fp="../template/".$siteskin."/baojia.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
if (isset($_GET["province"])){
$province=$_GET["province"];
}else{
$province="";
}

$page_size=strbetween($strout,"{#pagesize=","}");
if ($page_size<>''){
checkid($page_size);
}else{
$page_size=pagesize_qt;
}

$bigclassname="";
if ($b<>""){
$sql="select * from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$pagetitle=$province.$bigclassname.baojialisttitle."-".sitename;
$pagekeyword=$province.$bigclassname.baojialistkeyword."-".sitename;
$pagedescription=$province.$bigclassname.baojialistdescription."-".sitename;

$sql="select count(*) as total from zzcms_baojia where passed<>0 ";
$sql2='';
if ($province<>""){
$sql2=$sql2." and province ='".$province."' ";
}

if ($b<>""){
$sql2=$sql2." and classzm ='".$b."' ";
}

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;
$totlepage=ceil($totlenum/$page_size);

$sql="select id,cp,truename,province,city,xiancheng,price,danwei,tel,sendtime from zzcms_baojia where passed<>0 ";

$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
//echo $sql;
$baojia=strbetween($strout,"{baojia}","{/baojia}");
$baojialist=strbetween($strout,"{loop}","{/loop}");

if(!$totlenum){
$strout=str_replace("{baojia}".$baojia."{/baojia}","暂无信息",$strout) ;
}else{
$i=0;
$baojialist2='';
while($row= fetch_array($rs)){

$baojialist2 = $baojialist2. str_replace("{#id}" ,$row["id"],$baojialist) ;

if ($i % 2==0) {
$baojialist2=str_replace("{changebgcolor}" ,"class=bgcolor1",$baojialist2) ;
}else{
$baojialist2=str_replace("{changebgcolor}" ,"class=bgcolor2",$baojialist2) ;
}
$baojialist2 = str_replace("{#cp}" ,"<a href='".getpageurl("baojia",$row["id"])."'>".cutstr($row["cp"],8)."</a> ",$baojialist2) ;



$baojialist2 = str_replace("{#name}" ,$row["truename"],$baojialist2) ;
$baojialist2 = str_replace("{#province}" ,$row["province"],$baojialist2) ;
$baojialist2 = str_replace("{#city}" ,$row["city"],$baojialist2) ;
$baojialist2 = str_replace("{#xiancheng}" ,$row["xiancheng"],$baojialist2) ;
$baojialist2 = str_replace("{#tel}" ,$row["tel"],$baojialist2) ;
$baojialist2 = str_replace("{#price}" ,$row["price"],$baojialist2) ;
$baojialist2 = str_replace("{#danwei}" ,$row["danwei"],$baojialist2) ;
$baojialist2 = str_replace("{#sendtime}" ,date("Y-m-d",strtotime($row["sendtime"])),$baojialist2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$baojialist."{/loop}",$baojialist2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("baojia"),$strout) ;
$strout=str_replace("{baojia}","",$strout) ;
$strout=str_replace("{/baojia}","",$strout) ;
}//end if(!$totlenum)

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","baojia"),$strout) ;
$strout=str_replace("{#class}",bigclass($b),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#pagesize=".$page_size."}",'',$strout);//去页码大小标签
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
if (strpos($strout,"{@")!==false || strpos($strout,"{#")!==false) $strout=showlabel($strout);//先查一下，如是要没有的就不用再调用showlabel;
echo  $strout;
?>