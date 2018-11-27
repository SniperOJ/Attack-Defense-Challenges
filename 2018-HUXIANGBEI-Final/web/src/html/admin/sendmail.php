<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("sendmail");
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">发送邮件</td>
  </tr>
</table>
<form name="myform" action="sendmailto.php" method="get">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr> 
      <?php
	  if (isset($_GET['tomail'])){
	  $tomail=$_GET['tomail'];
	  }else{
	  $tomail="";
	  }
	  ?>
      <td width="150" align="right" class="border"> 收信人地址：</td>
      <td class="border"><input name="tomail" type="text" value="<?php echo $tomail?>" size="40" maxlength="255">
      (收信人地址为空时，群发给选定的用户组) </td>
    </tr>
    <tr>
      <td align="right" class="border">对选定的用户组群发：</td>
      <td class="border"><select name="groupid">
        <?php
			$rsn=query("select * from zzcms_usergroup order by groupid asc");
			$r=num_rows($rsn);
			if ($r){
			while ($r=fetch_array($rsn)){
				if ($r["groupid"]==$row["groupid"]){
			 	echo "<option value='".$r["groupid"]."' selected>".$r["groupname"]."</option>";
				}else{
				echo "<option value='".$r["groupid"]."' >".$r["groupname"]."</option>";
				}
			}
			}
			?>
      </select></td>
    </tr>
    <tr> 
      <td align="right" class="border"> 标题：</td>
      <td class="border"> <input name="subject" type="text" size="40" maxlength="255"> </td>
    </tr>
    <tr> 
      <td align="right" class="border">内容：</td>
      <td class="border"> <textarea name="mailbody" id="mailbody"> </textarea>
       	<script type="text/javascript">CKEDITOR.replace('mailbody');	</script>
	    <br>
	    注：如果邮件中上传有本地图片，要在把图片地址改为绝对地址，即在形如src=&quot;/uploadfiles&quot;前面加上你的网址。如：src=&quot;<span class="STYLE2">http://demo.zzcms.net</span>/uploadfiles&quot;</td>
    </tr>
    <tr> 
      <td height="25" class="border">&nbsp;</td>
      <td height="22" class="border"> <input type="submit" name="Submit" value="发送">      </td>
    </tr>
  </table>
</form>

</body>
</html>