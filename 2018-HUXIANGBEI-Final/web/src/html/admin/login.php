<?php
include("../inc/config.php");
define ("checkadminlogin","1");//当关网站时，如果是管理员登录时使链接正常打开
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});
</script>
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="330" height="88" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td height="60" class="border" style="background:url('/image/zzcms-color.gif') 25px 0px no-repeat;background-color:#FFFFFF">&nbsp;</td>
  </tr>
  <tr> 
    <td align="right" class="border"> 
      <form action="logincheck.php" method="post" name="form1" target="_top">
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="19%" height="25" align="right">管理员:</td>
            <td width="81%"><input name="admin" type="text" id="admin" size="25" maxlength="255" style="width:200px;height:22px"></td>
          </tr>
          <tr> 
            <td height="25" align="right">密码:</td>
            <td height="25"><input name="pass" type="password" id="pass3" size="25" maxlength="255" style="width:200px;height:22px"></td>
          </tr>
          <tr> 
            <td height="25" align="right" valign="bottom">答案:</td>
            <td height="25" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><input name="yzm" type="text" id="yzm" value="" size="10" maxlength="50" style="width:60px"/><img src="/one/code_math.php" id="getcode_math" title="看不清，点击换一张" align="absmiddle"> </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="25">&nbsp;</td>
            <td height="25"><input type="submit" name="Submit" id="chk_math" value="登 录"></td>
          </tr>
          <tr align="right"> 
            <td height="25" colspan="2"><?php echo zzcmsver ?> </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</body>
</html>