<?php 
include("admin.php"); 
?>
<html>
<head>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
checkadminisdo("adminmanage");
if (isset($_REQUEST["action"])) {
$action=trim($_REQUEST["action"]);
}else{
$action="";
}
$FoundErr=0;
$ErrMsg="";
$admins=trim($_REQUEST["admins"]);
if ($action=="modify"){
	$sql="select * from zzcms_admin where admin='" . $admins . "'";
	$rs = query($sql);
	$row= fetch_array($rs);
	$oldpassword=md5(trim($_POST["oldpassword"]));
	$password=md5(trim($_POST["password"]));
	$pwdconfirm=trim($_POST["pwdconfirm"]);
	if ($oldpassword!=$row["pass"]) {
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>你输入的旧密码不对，没有权限修改！</li>";
	}
	if ($FoundErr==1){
	WriteErrMsg($ErrMsg);
	}else{
	query("update zzcms_admin set pass='$password' where admin='".$admins."'");
	echo "<SCRIPT language=JavaScript>alert('修改成功！');history.go(-1)</SCRIPT>";
	}
}else{
?>
<script>
function CheckForm(){
if (document.form1.password.value !=""){
		//创建正则表达式
    	var re=/^[0-9a-zA-Z]{4,14}$/; //只输入数字和字母的正则
    	if(document.form1.password.value.search(re)==-1){
		alert("密码只能为字母和数字，字符介于4到14个。");
		document.form1.password.value="";
		document.form1.password.focus();
		return false;
    	}
	}	
if (document.form1.password.value !="" && document.form1.pwdconfirm.value !=""){
	if (document.form1.password.value!=document.form1.pwdconfirm.value){
	alert ("两次密码输入不一致，请重新输入。");
	//document.form1.pass.value='';
	document.form1.pwdconfirm.value='';
	document.form1.pwdconfirm.focus();
	return false;
	}	
	}
}
</script>
</head>
<body>
<div class="admintitle">修改管理员密码</div>
<FORM name="form1" action="?" method="post" onSubmit="return CheckForm()">     
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <TR> 
      <TD width="494" align="right" class="border">管理员：</TD>
      <TD width="921" class="border"><?php echo $admins?>
        <input name="admins" type="hidden" value="<?php echo $admins?>"></TD>
    </TR>
    <TR> 
      <TD width="494" align="right" class="border">旧密码：</TD>
      <TD class="border"> <INPUT  type="password" maxLength="16" size="30" name="oldpassword">
      </TD>
    </TR>
    <TR> 
      <TD width="494" align="right" class="border">新密码：</TD>
      <TD class="border"> <INPUT  type="password" maxLength="16" size="30" name="password">
      </TD>
    </TR>
    <TR> 
      <TD width="494" align="right" class="border">确认新密码：</TD>
      <TD class="border"> <INPUT name="pwdconfirm"   type="password" id="pwdconfirm" size="30" maxLength="16">
        <input name="action" type="hidden" id="action" value="modify"> </TD>
    </TR>
    <TR> 
      <TD align="center" class="border">&nbsp; </TD>
      <TD class="border"> <input name="Submit"   type="submit" id="Submit" value="保存"> 
      </TD>
    </TR>
  </TABLE>
</form>
</body>
</html>
<?php
}

?>