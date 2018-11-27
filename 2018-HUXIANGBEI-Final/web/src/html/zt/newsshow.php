<?php
include("../inc/conn.php");
if(isset($_REQUEST['newsid'])){
$newsid=$_REQUEST['newsid'];
checkid($newsid);
}else{
$newsid=0;
}

$rs=query("select * from zzcms_zx where id='$newsid'");
$row=num_rows($rs);
if(!$row){
showmsg('无记录');
}else{
query("update zzcms_zx set hit=hit+1 where id='$newsid'");
$row=fetch_array($rs);
$editorinzsshow=$row["editor"];//供传值到top.php
$title=$row['title'];
$sendtime=date("Y-m-d",strtotime($row['sendtime']));
$hit=$row["hit"];
$sm=$row["content"];

include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/newsshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$pagetitle=$comane.zxshowtitle.$title;
$pagekeywords=$comane.zxshowkeyword.$title;
$pagedescription=$comane.zxshowdescription.$title;

$strout=str_replace("{#title}",$title,$strout) ;
$strout=str_replace("{#comane}",$comane,$strout) ;
$strout=str_replace("{#hit}",$hit,$strout) ;
$strout=str_replace("{#sendtime}",$sendtime,$strout) ;
$strout=str_replace("{#content}",$sm,$strout) ;
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
}			  
?>