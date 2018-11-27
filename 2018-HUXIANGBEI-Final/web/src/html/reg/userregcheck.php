<?php 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>
<body>
<?php
$action=$_GET['action'];
$id=$_GET['id'];
switch ($action){
case "checkusername";
checkusername($id);
break;
case "checkcomane";
checkcomane($id);
break;
case "checkphone";
checkphone($id);
break;
case "checkemail";
checkemail($id);
break;
}

function checkusername($id){
$founderr=0;
if ($id==''){
$founderr=1;
$msg= "请输入用户名";
}else{
	if(! preg_match("/^[a-zA-Z0-9_]{4,15}$/",$id)){//ereg()PHP5.3以后的版本不再支持
	$founderr=1;
	$msg= "用户名只能为字母和数字，字符介于4到15个。";
	}else{
	$sqlreg="select username from zzcms_usernoreg where username='".$id."'";
	$rs = query($sqlreg);
	$row= num_rows($rs);//返回记录数
		if($row){ 
		$founderr=1;
		$msg= "您填写的用户名已存在！请更换用户名！！！";
		}

	$sqlreg="select username from zzcms_user where username='".$id."'";
	$rs = query($sqlreg);
	$row= num_rows($rs);//返回记录数
		if($row){ 
		$founderr=1;
		$msg= "该用户名已存在！请更换一个！";
		}
	}
}	
	if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.username2.value='no';</script>";
	}else{
	echo "<img src=/image/dui2.png>";
	echo "<script>window.document.userreg.username2.value='yes';</script>";
	echo "<script>document.userreg.username.style.border = '1px solid #dddddd';</script>";
	}
}

function checkcomane($id){
$founderr=0;
if ($id==''){
	$founderr=1;
	$msg= "请输入公司名";
}else{
	$pass=0;
    if (wordsincomane<>""){
	   $word=explode("|",wordsincomane); //转换成数组,判断是不是相关行业       
	   for ($i=0;$i<count($word);$i++){ //count取得数组中的项目数  
			if(strpos($id,$word[$i])!==false && strpos(substr($id,0,4),$word[$i])==false){//汉字占两字符
			$pass=1;
			break;   
        	}
      	}
    }else{
	   $pass=1;//当wordsincomane=""时说明没有加任何限制,这时所有行业都可以注册,所以把PASS也设为true
    }	
	  
    if ($pass==0){
	  $founderr=1;
	  //如果还不能阻止群发软件注册，就不提示了，直接终止程序。
      $msg="不相关的企业不接受注册！请正确填写企业名称";  	  	
	}
	
	if (lastwordsincomane<>""){
	$istotlename=0;
	$word=explode("|",lastwordsincomane);//判断是不是全称       
	for ($i=0;$i<count($word);$i++){    
             if ((strpos(substr($id,-4),$word[$i])==0||strpos(substr($id,-4),$word[$i])==2) && count(explode($word[$i],$id))==2){  //关键词必须出现在最后面，且只能出现一次。 
             $istotlename=1;   
             break;    
             }
	}    
    }else{
	     $istotlename=1;//当lastwordsincomane=""时说明没有加任何限制,所以把istotlename也设为true
     } 	
	  
	 if ($istotlename==0){
	 $founderr=1;
     $msg="公司名称有误，请输入贵公司的全称" ;
	 }
	 
	 if (nowordsincomane<>""){
	 $word=explode("|",nowordsincomane);
	 for ($i=0;$i<count($word);$i++){ 
	 	if (strpos($id,$word[$i])>0){
		$founderr=1;
		$msg="公司名称有误，含有非法字符" ;
		break ; 
		}
	 }
	 }
}	
	if (allowrepeatreg=="No"){
	$sql="select comane from zzcms_user where comane='".$id."' ";
	$rs = query($sql); 
	$row= num_rows($rs);//返回记录数
	if($row){
	 	$founderr=1;
	 	$msg="此名称已存在，系统不允许重复注册用户！";
	 }
		
	$sql="select comane from zzcms_usernoreg where comane='".$id."'";
	$rs = query($sql); 
	$row= num_rows($rs);//返回记录数
	if($row){
	 		$founderr=1;
			$msg="此名称已存在，系统不允许重复注册用户！";	
	}
	}			

	if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.comane2.value='no';</script>";
	//echo "<script>window.document.userreg.comane.style.border = '1px solid #FA8072'; <//script>";
	}else{
	echo "<img src='/image/dui2.png'>";
	echo "<script>window.document.userreg.comane2.value='yes';</script>";
	echo "<script>document.userreg.comane.style.border = '1px solid #dddddd';</script>";
	}
}

function checkphone($id){
$founderr=0;
if ($id==''){
	$founderr=1;
	$msg= "请输入电话";
}else{
	if(!preg_match("/1[3458]{1}\d{9}$/",$id) && !preg_match('/^400(\d{3,4}){2}$/',$id) && !preg_match('/^400(-\d{3,4}){2}$/',$id) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$id)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
	$founderr=1;
	$msg= "电话号码不正确";
	}
	if (allowrepeatreg=="No"){
	$sql="select phone from zzcms_user where phone='".$id."'";
	$rs = query($sql); 
	$row= num_rows($rs);//返回记录数
		if($row){
	 	$founderr=1;
		$msg="此电话号码已存在，系统不允许重复注册用户！";	
		}
	}	
}	
if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.phone2.value='no';</script>";
	}else{
	echo "<img src='/image/dui2.png'>";
	echo "<script>window.document.userreg.phone2.value='yes';</script>";
	echo "<script>document.userreg.phone.style.border = '1px solid #dddddd';</script>";
	}
}

function checkemail($id){
$founderr=0; 
if ($id==''){
	$founderr=1;
	$msg= "请输入Email";
}else{
	if(! preg_match("/^[a-zA-Z0-9_.]+@([a-zA-Z0-9_]+.)+[a-zA-Z]{2,3}$/",$id)) {
	$founderr=1;
	$msg= "Email格式不正确";
	}

	if (allowrepeatreg=="No"){
	$sql="select email from zzcms_user where email='".$id."'";
	$rs = query($sql); 
	$row= num_rows($rs);//返回记录数
		if($row){
	 	$founderr=1;
		$msg="此Email已被使用，系统不允许重复注册用户！";	
		}
	}	
}
	
if ($founderr==1){
	echo "<span class='boxuserreg'>".$msg."</span>";
	echo "<script>window.document.userreg.email2.value='no';</script>";
	}else{
	echo "<img src='/image/dui2.png'>";
	echo "<script>window.document.userreg.email2.value='yes';</script>";
	echo "<script>document.userreg.email.style.border = '1px solid #dddddd';</script>";
	}
}
?>
</body>
</html>