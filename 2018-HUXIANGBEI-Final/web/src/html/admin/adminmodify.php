<?php
include("admin.php");
?>
<html>
<head>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
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
$groupid=$_POST["groupid"];
query("update zzcms_admin set groupid='$groupid' where admin='".$admins."'");
echo "<SCRIPT language=JavaScript>alert('修改成功！');history.go(-1)</SCRIPT>";	
}else{
$sql="select * from zzcms_admin where admin='" . $admins . "'";
$rs = query($sql);
$row= fetch_array($rs);
?>
<div class="admintitle">修改管理员信息</div>
<FORM name="form1" action="?" method="post" onSubmit="return CheckForm()">
          
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <TR> 
      <TD width="20%" align="right" class="border">管理员：</TD>
      <TD width="80%" class="border"><?php echo $admins?>
        <input name="admins" type="hidden" value="<?php echo $admins?>"></TD>
    </TR>
    <tr> 
      <td align="right" class="border">所属用户组：</td>
      <td class="border"> <select name="groupid">
          <?php
	$sqln="Select * from zzcms_admingroup order by id asc";
	$rsn = query($sqln,$conn);
	$rown= num_rows($rsn);
	if ($rown){
		while($rown=fetch_array($rsn)){
			if  ($rown["id"]==$row["groupid"]) {
	 		echo "<option value='".$rown["id"]."' selected>".$rown["groupname"]."</option>";
			}else{
			echo "<option value='".$rown["id"]."'>".$rown["groupname"]."</option>";
			}
		}
	}
		 ?>
        </select> </td>
    </tr>
    <TR> 
      <TD align="center" class="border">&nbsp; </TD>
      <TD class="border"> <input name="Submit"   type="submit" id="Submit" value="保存"> 
        <input name="action" type="hidden" id="action" value="modify"> </TD>
    </TR>
  </TABLE>
</form>
</body>
</html>
<?php
}
?>