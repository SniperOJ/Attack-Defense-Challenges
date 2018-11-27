<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzh.php");
include("../label.php");
if (isset($_REQUEST["id"])){
$zhid=trim($_REQUEST["id"]);
checkid($zhid);
}else{
$zhid=0;
}

$sql="select * from zzcms_zh where id='$zhid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo showmsg("不存在相关信息！");
}else{
query("update zzcms_zh set hit=hit+1 where id='$zhid'");
$title=$row["title"];
$bigclassid=$row["bigclassid"];
$sendtime=date("Y-m-d",strtotime($row['sendtime']));
$editor=$row["editor"];
$hit=$row["hit"];
$id=$row["id"];
$address=$row["address"];
$timestart=date("Y-m-d",strtotime($row["timestart"]));
$timeend=date("Y-m-d",strtotime($row["timeend"]));
$content=$row["content"];


$rs=query("select bigclassname from zzcms_zhclass where bigclassid='".$bigclassid."'");
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["bigclassname"];
}else{
$bigclassname="大类已删除";
}

$pagetitle=$title.zhshowtitle;
$pagekeywords=$title.zhshowkeyword;
$pagedescription=$title.zhshowdescription;
$station=getstation($bigclassid,$bigclassname,0,"","","","zh");

$fp="../template/".$siteskin."/zhshow.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagekeywords,$strout);
$strout=str_replace("{#station}",$station,$strout);
$strout=str_replace("{#title}",$title,$strout);
$strout=str_replace("{#hit}",$hit,$strout);
$strout=str_replace("{#sendtime}",$sendtime,$strout);
$strout=str_replace("{#editor}",$editor,$strout);
$strout=str_replace("{#id}",$id,$strout);
$strout=str_replace("{#address}",$address,$strout);
$strout=str_replace("{#timestart}",$timestart,$strout);
$strout=str_replace("{#timeend}",$timeend,$strout);
$strout=str_replace("{#content}",$content,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;
}
?>
