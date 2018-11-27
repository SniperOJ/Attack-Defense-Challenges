<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php

checkadminisdo("sendmessage");
if (isset($_REQUEST["saver"])){
$saver=$_REQUEST["saver"];
}else{
$saver="";
}

?>
<script language = "JavaScript">
function CheckForm()
{
 if (document.myform.title.value=="")
  {
    alert("主题不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.content.value=="")
  {
    alert("内容不能为空！");
	document.myform.content.focus();
	return false;
  }
  return true;  
} 

	</script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">发送信息</td>
  </tr>
</table>
<form action="message_save.php?action=add" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
          <tr> 
            
      <td width="189" align="right" class="border">收件人(用户名)：</td>
            <td width="1226" class="border"><input name="sendto" type="text" value="<?php echo $saver?>"  size="50">
              (如果为空则发送给全部用户) </td>
          </tr>
          <tr> 
            <td width="189" align="right" class="border">标题：</td>
            <td class="border"> <input name="title"  type="text" size="50"></td>
          </tr>
          <tr> 
            <td width="189" align="right" class="border">内容：</td>
            <td class="border"> <textarea name="content" cols="50" rows="10" ></textarea> 
            
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input type="submit" name="Submit" value="发送"></td>
          </tr>
        </table>
      </form>
	  
</body>
</html>
