<?php
include("../inc/conn.php");
include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/licence.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$pagetitle=$comane."-资质";
$pagekeywords=$comane."-资质";
$pagedescription=$comane."-资质";
$list=strbetween($strout,"{loop}","{/loop}");

$rs=query("select img,title,passed,editor from zzcms_licence where editor='" .$editor. "' and passed=1");
$row=num_rows($rs);
if ($row){
$n=0;
$list2='';
while ($row=fetch_array($rs)){
$list2 = $list2. str_replace("{#img}",getsmallimg($row["img"]),$list) ;
$list2 =str_replace("{#imgbig}",$row['img'],$list2) ;
$list2 =str_replace("{#link}",$row['img'],$list2) ;
$list2 =str_replace("{#title}",cutstr($row["title"],6),$list2) ;

$n=$n+1;
($n % 6==0)?$tr="<tr>":$tr="";
$list2 =str_replace("{tr}",$tr,$list2) ;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
}else{
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}
$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
echo  $strout;				
?>