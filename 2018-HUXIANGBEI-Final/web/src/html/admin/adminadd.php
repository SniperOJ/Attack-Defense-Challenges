<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
$action=@$_GET["action"];
$founderr=0;
if ($action=="add"){
	$admins=trim($_POST["admins"]);
	$passs=md5(trim($_POST["passs"]));
	$groupid=$_POST["groupid"];
	
	$sql="select admin from zzcms_admin where admin='".$admins."'";
	$rs = query($sql,$conn);
	$row= num_rows($rs);//返回记录数
	if($row){ 
	$founderr=1;
	$ErrMsg="您填写的用户名已存在！请更换用户名！";
	}

	if ($founderr==1){
		WriteErrMsg($ErrMsg);
		}else{
		$sql="insert into zzcms_admin (admin,pass,groupid) values ('$admins','$passs','$groupid')";
		query($sql,$conn);
		echo "<script>location.href='adminlist.php'</script>";	
		}
}else{
?>
<script language="JavaScript" type="text/JavaScript">
function checkform(){
if (document.form1.admins.value==""){
    alert("管理员名称不能为空！");
    document.form1.admins.focus();
    return false;
}
if (document.form1.passs.value==""){
    alert("密码不能为空！");
    document.form1.passs.focus();
    return false;
}
if (document.form1.passs.value!=document.form1.passs2.value){
alert ("两次密码输入不一致，请重新输入。");
document.form1.passs.value='';
document.form1.passs2.value='';
document.form1.passs.focus();
return false;
}  
}
</script>
</head>
<body>
<div class="admintitle">添加管理员</div>
<form name="form1" method="post" action="?action=add" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">所属用户组：</td>
      <td class="border">
	   <select name="groupid" id="groupid">
          <?php
    $sql="Select * from zzcms_admingroup order by id asc";
    $rs = query($sql,$conn); 
	while($row= fetch_array($rs)){
	echo "<option value='".$row["id"]."'>".$row["groupname"]."</option>";
	}
	?>
        </select> </td>
    </tr>
    <tr> 
      <td width="46%" align="right" class="border">管理员：</td>
      <td width="54%" class="border"> <input name="admins" type="text" id="admins"></td>
    </tr>
    <tr> 
      <td align="right" class="border">密码：</td>
      <td class="border"> <input name="passs" type="password" id="passs"></td>
    </tr>
    <tr> 
      <td align="right" class="border">再次输入密码进行确认：</td>
      <td class="border"> <input name="passs2" type="password" id="passs2"></td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
}
?>
