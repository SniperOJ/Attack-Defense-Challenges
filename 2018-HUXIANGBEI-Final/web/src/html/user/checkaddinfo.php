<?php
$ErrMsg="";
$FoundErr=0;
$rs=query("select passed,usersf,username from zzcms_user where username='".$_COOKIE["UserName"]."' ");
$row=fetch_array($rs);
if ($row["passed"]==0 && isaddinfo=="No") {		
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>注册用户经审核后才可发布信息</li>";
}

//if ($tablename=="zzcms_main" || $tablename=="zzcms_licence") {
	//if ($row["usersf"]=="个人"){
		//$FoundErr=1;
		//$ErrMsg=$ErrMsg . "<li>个人用户不能发布此信息</li>";
	//}	
//}
$rs=query("select addinfo_number,addinfototle_number from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$_COOKIE["UserName"]."')");
$row=fetch_array($rs);
if ($row){
$addinfo_number=$row["addinfo_number"];
$addinfototle_number=$row["addinfototle_number"];
}else{
$addinfo_number=10;
$addinfototle_number=10;
}
if ($tablename=='zzcms_main'){
$sql="select id from ".$tablename." where editor='".$_COOKIE["UserName"]."' and  unix_timestamp(now())-unix_timestamp(sendtime)<=24*3600 and refresh=0";
}else{
$sql="select id from ".$tablename." where editor='".$_COOKIE["UserName"]."' and  unix_timestamp(now())-unix_timestamp(sendtime)<=24*3600";//刷新信息不计数
}
$rs=query($sql);
$row=num_rows($rs);
if ($row>=$addinfo_number && $addinfo_number<>999) {
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>您所在用户组一天限发布".$addinfo_number."条信息</li>";
}

$rs=query("select id from ".$tablename." where editor='".$_COOKIE["UserName"]."'");
$row=num_rows($rs);
if ($row>=$addinfototle_number && $addinfo_number<>999) {
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>您所在用户组总共能发布".$addinfototle_number."条信息，您的信息数已达到上限</li>";
}
if ($FoundErr==1){
WriteErrMsg($ErrMsg);

exit;
}
?>