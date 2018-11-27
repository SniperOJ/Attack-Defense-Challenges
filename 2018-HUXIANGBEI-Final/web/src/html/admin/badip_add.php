<?php
include("admin.php");

checkadminisdo("badusermessage");
if (isset($_REQUEST['action'])){
$ip=trim($_REQUEST["ip"]);
$dose=trim($_REQUEST["dose"]);
query("insert into zzcms_bad (ip,dose,sendtime,lockip)values('$ip','$dose','".date('Y-m-d H:i:s')."','1')");

echo "<script>location.href='showbad.php'</script>";
}else{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
function checkform()
{
  if (document.form1.ip.value=="")
  {
    alert("IP不能为空！");
    document.form1.ip.focus();
    return false;
  }
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">添加拒访IP</td>
  </tr>
</table>
<form name="form1" method="post" action="badip_add.php?action=add" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td width="43%" align="right">IP：</td>
      <td width="57%"> <input name="ip" type="text" id="ip" size="25"></td>
    </tr>
    <tr> 
      <td align="right">备注：</td>
      <td> <textarea name="dose" cols="25" rows="5" id="dose"></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
}
?>