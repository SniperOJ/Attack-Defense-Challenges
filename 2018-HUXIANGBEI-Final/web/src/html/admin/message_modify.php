<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript">
function CheckForm(){
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.content.value==""){
    alert("内容不能为空！");
	document.myform.content.focus();
	return false;
  }
  return true;  
}    
	</script>
</head>
<body>
<div class="admintitle">修改短信息</div>
<?php
checkadminisdo("sendmessage");
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_message where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="message_save.php?action=modify" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr> 
            <td width="100" align="right" class="border">收信人：</td>
            <td class="border"><input name="sendto" type="text"  value="<?php echo $row["sendto"]?>" size="50"> 
            </td>
          </tr>
          <tr> 
            <td width="100" align="right" class="border">标题：</td>
            <td width="89%" class="border"> <input name="title" type="text"  value="<?php echo $row["title"]?>" size="50"></td>
          </tr>
          <tr> 
            <td width="100" align="right" class="border">内容：</td>
            <td class="border"> <textarea name="content" cols="50" rows="10" id="content"><?php echo $row["content"]?></textarea> 
            
              <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"><input type="submit" name="Submit" value="提交"></td>
          </tr>
        </table>
      </form>	  
</body>
</html>