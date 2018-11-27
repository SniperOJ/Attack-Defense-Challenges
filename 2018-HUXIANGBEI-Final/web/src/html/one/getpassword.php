<?php
if(!isset($_SESSION)){session_start();}
include("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");

$action = isset($_POST['action'])?$_POST['action']:"";

$file="../template/".$siteskin."/getpassword.htm";
if (file_exists($file)==false){
WriteErrMsg($file.'模板文件不存在');
exit;
}
$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));

$stepall=strbetween($strout,"{step1}","{/step4}");
$step1=strbetween($strout,"{step1}","{/step1}");
$step2=strbetween($strout,"{step2}","{/step2}");
$step3=strbetween($strout,"{step3}","{/step3}");
$step4=strbetween($strout,"{step4}","{/step4}");

if ($action==""){
$strout=str_replace("{step1}","",$strout) ;
$strout=str_replace("{/step1}","",$strout) ;
$strout=str_replace("{step2}".$step2."{/step2}","",$strout) ;
$strout=str_replace("{step3}".$step3."{/step3}","",$strout) ;
$strout=str_replace("{step4}".$step4."{/step4}","",$strout) ;
}

if ($action=="step1"){
$username = isset($_POST['username'])?$_POST['username']:"";
$_SESSION['username']=$username;
checkyzm($_POST["yzm"]);
$rs=query("select mobile,email from zzcms_user where username='" . $username . "' ");
$row=fetch_array($rs);
$regmobile=$row['mobile'];
$regmobile_show=str_replace(substr($regmobile,3,4),"****",$regmobile);
$regemail=$row['email'];
$regemail_show=str_replace(substr($regemail,1,2),"**",$regemail);

if ($regmobile==''){
$regmobile_show='无手机号信息，无法用手机找回密码';
}

if (sendsms=="Yes"){
$getpass_method="<select name='getpass_method' id='getpass_method'  class='biaodan'>";
$getpass_method=$getpass_method."    <option value=''>请选择验证方式</option>";
$getpass_method=$getpass_method."    <option value='".$regmobile."'>手机：".$regmobile_show."</option>";
$getpass_method=$getpass_method."    <option value='".$regemail."'>邮箱：".$regemail_show."</option>";
$getpass_method=$getpass_method."  </select>";
}else{
$getpass_method="发验证码到注册时所填邮箱：".$regemail_show;
$_SESSION['getpass_method']=$regemail;//只为email时，AJAX不传值，直接把值设到这里
}	

$strout=str_replace("{step2}","",$strout) ;
$strout=str_replace("{/step2}","",$strout) ;
$strout=str_replace("{step1}".$step1."{/step1}","",$strout) ;
$strout=str_replace("{step3}".$step3."{/step3}","",$strout) ;
$strout=str_replace("{step4}".$step4."{/step4}","",$strout) ;
$strout=str_replace("{#getpass_method}",$getpass_method,$strout) ;
$strout=str_replace("{#username}",$_SESSION['username'],$strout) ;

}elseif($action=="step2"){

$strout=str_replace("{step3}","",$strout) ;
$strout=str_replace("{/step3}","",$strout) ;	
$strout=str_replace("{step1}".$step1."{/step1}","",$strout) ;
$strout=str_replace("{step2}".$step2."{/step2}","",$strout) ;
$strout=str_replace("{step4}".$step4."{/step4}","",$strout) ;

}elseif($action=="step3" && @$_SESSION['username']!=''){
	
$passwordtrue = isset($_POST['password'])?$_POST['password']:"";
$password=md5(trim($passwordtrue));
query("update zzcms_user set password='$password',passwordtrue='$passwordtrue' where username='".@$_SESSION['username']."'");
	
$strout=str_replace("{step4}","",$strout) ;
$strout=str_replace("{/step4}","",$strout) ;	
$strout=str_replace("{step1}".$step1."{/step1}","",$strout) ;
$strout=str_replace("{step2}".$step2."{/step2}","",$strout) ;
$strout=str_replace("{step3}".$step3."{/step3}","",$strout) ;
$strout=str_replace("{#username}",@$_SESSION['username'],$strout) ;
}else{
$strout=str_replace("{step1}".$stepall."{/step4}","错误",$strout) ;
}
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
echo  $strout;
session_write_close();
?>