<?php
define('checkadminlogin',1);
include("admin.php");

if (opensite=='No' ){
echo "<script>location.href='siteconfig.php#SiteOpen'</script>";
}	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>管理员后台</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style>
body{OVERFLOW: hidden;}
/*
使不显示双滚动条
*/
</style>
<SCRIPT>
var status = 1;
function switchSysBar(){
     if (1 == window.status){
		  window.status = 0;
          switchPoint.innerHTML = '<img src="image/manage_left.gif">';
          document.all("frmTitle").style.display="none"
     }
     else{
		  window.status = 1;
          switchPoint.innerHTML = '<img src="image/manage_right.gif">';
          document.all("frmTitle").style.display=""
     }
}
</SCRIPT>

<body style="margin: 0px">

<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0 style="background:#C3DAF9;">
 <tr>
<td height="45" colspan="3">
<iframe frameborder="0" id="top" name="top" scrolling="no" src="top.php" style="height:45px;width: 100%;"></iframe>
</td>
</tr>
    <tr> 
      <td colspan="3" class="userbar"> 
        <?php $rs=query("select groupname from zzcms_admingroup where id=(select groupid from zzcms_admin where admin='".@$_SESSION["admin"]."')");
	  $row= fetch_array($rs);
	  echo "您好<b>".@$_SESSION["admin"]."</b>(" .$row["groupname"].")";
	  ?>
        [ <a href="/index.php" target="_top">返回首页</a> | <a href="loginout.php" target="_top">安全退出</a> 
        ] [ <a href="http://www.zzcms.net/help.asp" target="_blank">操作说明</a> ]</td>
</tr>
<tr>
	<td height="100%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="middle" id="frmTitle" valign="top" name="fmtitle" style="background:#c9defa;width:185px;">
	<iframe frameborder="0" id="frmleft" name="frmleft" src="left.php" style="height: 100%; visibility: inherit;width: 185px;" allowtransparency="true"></iframe>
	</td>
	  <td width="18"  valign="middle"> 
        <div onClick="switchSysBar()"> <span class="navpoint" id="switchPoint" title="关闭/打开左栏"><img src="image/manage_right.gif" alt="" /></span> 
        </div>
	</td>
	<td valign="top">
		<iframe frameborder="0" id="frmright" name="frmright" scrolling="yes" src="right.php" style="height:100%; visibility: inherit; width:100%; z-index: 1;"></iframe>
	</td>
  </tr>
</table>
	</td>
</tr>
</table>
	
</body>
</html>