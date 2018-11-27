<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
$b=$_REQUEST["b"];
if ($b<>"") {
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

function doChange(objText, pic){
	if (!pic) return;
	var str = objText.value;
	var arr = str.split("|");
	pic.length=0;
	for (var i=0; i<arr.length; i++){
		pic.options[i] = new Option(arr[i], arr[i]);
	}
}
	</script>
</head>
<body>
<div class="admintitle">发布<?php if ($b==1) { echo "帮助"; }else { echo "公告";}?>信息</div>
<form action="help_save.php?action=add" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="100" align="right" class="border" >标题： </td>
      <td class="border" > <input name="title" type="text" id="title2" size="50" maxlength="255"> 
      </td>
    </tr>
    <tr id="trcontent"> 
      <td width="100" align="right" class="border" >内容：</td>
      <td class="border" > <textarea name="content"  id="content"></textarea> 
        <script type="text/javascript">CKEDITOR.replace('content');	</script> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >首页显示：</td>
      <td class="border" ><input name="elite" type="checkbox" id="elite" value="1" checked> 
        <input name="b" type="hidden" id="b" value="<?php echo $b?>"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" ><input type="submit" name="Submit" value="发 布" ></td>
    </tr>
  </table>
      </form>  
</body>
</html>