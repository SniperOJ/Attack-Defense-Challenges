<?php
include ("admin.php");
include ("../3/mobile_msg/inc.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("sendmail");
?>
<form name="f1" method="post" action="?action=send">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="24%" align="right" class="border" >手机:</td>
      <td width="76%" class="border"> <input name="mobile" type="text" size="80"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >内容:</td>
      <td class="border"> <textarea name="msg" cols="50" rows="5"></textarea></td>
    </tr>
    <tr> 
      <td class="border">&nbsp; </td>
      <td class="border"><input type="submit" name="send"  value="发送"></td>
    </tr>
  </table>
</form>
<?php
if (@$_REQUEST["action"]=="send"){
	//功能：发送短信
	$mobile  = $_POST["mobile"];
	$msg  = $_POST["msg"];
	$msg = iconv("UTF-8","GBK",$msg);
	$result = sendSMS(smsusername,smsuserpass,$mobile,$msg,apikey_mobile_msg);
}	
?>
</body>
</html>