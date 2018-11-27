<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
$id=$_REQUEST["id"];
if ($id<>""){
checkid($id);
}
$b=$_REQUEST["b"];
if ($b<>""){
checkid($b);
}
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  }
} 
</script>
</head>
<body>
<div class="admintitle">修改<?php if ($b==1) { echo "帮助"; }else { echo "公告";}?>信息</div>
<?php
$sql="select * from zzcms_help where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="help_save.php?action=modify" method="post" name="myform" id="myform" onSubmit="return CheckForm();">  
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td width="162" align="right" class="border">标题：</td>
      <td width="837" class="border"> <input name="title" type="text" id="title2" value="<?php echo $row["title"]?>" size="50" maxlength="255"> 
      </td>
    </tr>
    <tr id="trcontent"> 
      <td width="162" align="right" class="border">内容：</td>
      <td class="border"> <textarea name="content" id="content" ><?php echo $row["content"]?></textarea> 
        <script type="text/javascript">CKEDITOR.replace('content');	</script> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">首页显示：</td>
      <td class="border"> <input name="elite" type="checkbox" id="elite" value="1" <?php if ($row["elite"]==1) { echo "checked";}?>> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><input name="b" type="hidden" id="b" value="<?php echo $row["classid"]?>"> 
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_REQUEST["page"]?>"> 
      </td>
      <td class="border"><input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
      </form>
	  
</body>
</html>