<?php
include("../inc/conn.php");
include("top.php");
include("bottom.php");
include("left.php");

$pagetitle=$comane."-留言板";
$pagekeywords=$comane."-留言板";
$pagedescription=$comane."-留言板";

$fromurl=$_GET["fromurl"];

if (isset($_COOKIE["UserName"])) {
$rs=query("select somane,phone,email from zzcms_user where username='".$_COOKIE["UserName"]."'");
$row=fetch_array($rs);

$somane=$row["somane"];
$phone=$row["phone"];
$email=$row["email"];
}else{
$somane='';
$phone='';
$email='';
}

$fp="../skin/".$skin."/liuyan.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$guestbook=strbetween($strout,"{guestbook}","{/guestbook}");
$list=strbetween($guestbook,"{loop}","{/loop}");
$rs=query("select title,content,linkmen,phone,email,looked,sendtime from zzcms_guestbook where saver='".$editor."'and passed=1 order by id desc limit 0,10");
$row=num_rows($rs);
if ($row){
$list2='';
while ($row=fetch_array($rs)){
$list2 = $list2. str_replace("{#content}",cutstr($row["content"],8),$list) ;
	if ($row["looked"]==0){ 
	$list2 =str_replace("{#looked}","(尚未被查看)",$list2) ;
	}else{
	$list2 =str_replace("{#looked}","",$list2) ;
	}
$list2 =str_replace("{#linkman}",$row["linkmen"],$list2) ;
$list2 =str_replace("{#tel}",str_replace(substr($row['phone'],3,4),"****",$row['phone']),$list2) ;
$list2 =str_replace("{#email}",str_replace(substr($row['email'],3,4),"****",$row['email']),$list2) ;
$list2 =str_replace("{#sendtime}",$row['sendtime'],$list2) ;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{guestbook}","",$strout) ;
$strout=str_replace("{/guestbook}","",$strout) ;
}else{
$strout=str_replace("{guestbook}".$guestbook."{/guestbook}","暂无信息",$strout) ;
}

$strout=str_replace("{textarea}","<textarea id='contents' rows=6 cols=30 name='contents' onfocus='check_contents()' onblur='check_contents()'></textarea>",$strout) ;
$strout=str_replace("{#somane}",$somane,$strout) ;
$strout=str_replace("{#phone}",$phone,$strout) ;
$strout=str_replace("{#email}",$email,$strout) ;
$strout=str_replace("{#saver}",$editor,$strout) ;
$strout=str_replace("{#fromurl}",$fromurl,$strout) ;

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