<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subjob.php");
if (isset($_REQUEST["id"])){
$cpid=trim($_REQUEST["id"]);
checkid($cpid);
}else{
$cpid=0;
}

$sql="select * from zzcms_job where id='$cpid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo showmsg("不存在相关信息！");
}else{
query("update zzcms_job set hit=hit+1 where id='$cpid'");
$editor=$row["editor"];
$jobname=$row["jobname"];

$bigclassid=$row["bigclassid"];
$smallclassid=$row["smallclassid"];
$sendtime=$row["sendtime"];
$hit=$row["hit"];
$sm=$row["sm"];
$province=$row["province"];
$city=$row["city"];

$rs=query("select classname from zzcms_jobclass where classid='".$bigclassid."'");
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}else{
$bigclassname="大类已删除";
}

if ($smallclassid<>""){
$rs=query("select classname from zzcms_jobclass where classid='".$smallclassid."'");
$row=fetch_array($rs);
if ($row){
$smallclassname=$row["classname"];
}else{
$smallclassname="小类已删除";
}
}

$sql="select * from zzcms_user where username='".$editor."'";
$rs=query($sql);
$row=fetch_array($rs);
$startdate=$row["startdate"];
$comane=$row["comane"];
$bigclassid=$row["bigclassid"];
$somane=$row["somane"];
$userid=$row["id"];
$groupid=$row["groupid"];
$sex=$row["sex"];
$phone=$row["phone"];
$fox=$row["fox"];
$mobile=$row["mobile"];
$qq=$row["qq"];
$email=$row["email"];

$contact=showcontact("job",$cpid,$startdate,$comane,$bigclassid,$editor,$userid,$groupid,$somane,$sex,$phone,$qq,$email,$mobile,$fox);

$fp="../template/".$siteskin."/jobshow.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);


$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",getstation($bigclassid,$bigclassname,$smallclassid,$smallclassname,"","","job"),$strout) ;

$strout=str_replace("{#pagetitle}",$jobname.jobshowtitle,$strout);
$strout=str_replace("{#pagekeywords}",$jobname.jobshowkeyword,$strout);
$strout=str_replace("{#pagedescription}",$jobname.jobshowdescription,$strout);

$strout=str_replace("{#title}",$jobname,$strout);
$strout=str_replace("{#comane}",$comane,$strout);
$strout=str_replace("{#sendtime}",$sendtime,$strout);
$strout=str_replace("{#hit}",$hit,$strout);

$strout=str_replace("{#province}",$province,$strout);
$strout=str_replace("{#city}",$city,$strout);
$strout=str_replace("{#email}",$email,$strout);
$strout=str_replace("{#sm}",nl2br($sm),$strout);
$strout=str_replace("{#contact}",$contact,$strout);
$strout=str_replace("{#editor}",$editor,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
//if (strpos($strout,"{@")!==false) $strout=showlabel($strout);//先查一下，如是要没有的就不用再调用showlabel
$strout=showlabel($strout);
echo  $strout;
}
?>