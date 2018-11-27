<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择网刊类别！");
	document.myform.bigclassid.focus();
	return false;
  }	 	  
if (document.myform.title.value==""){
    alert("网刊名称不能为空！");
	document.myform.title.focus();
	return false;
  }
}    
	</script>
</head>
<body>
<?php
checkadminisdo("wangkan");
if (isset($_SESSION["wkclassid"])){
$swkclassid=$_SESSION["wkclassid"];
}else{
$swkclassid="";
}
?>
<div class="admintitle">发布网刊信息</div>
<form action="wangkan_save.php?action=add" method="post" name="myform" target="_self" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">所属类别：</td>
      <td class="border"> 
	   
        <?php
		$sql = "select * from zzcms_wangkanclass order by xuhao asc";
	    $rs=query($sql);
        $row=num_rows($rs);
		if (!$row){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($row= fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>" <?php if ($row["bigclassid"]==$swkclassid) { echo "selected";}?>><?php echo $row["bigclassname"]?></option>
                <?php
		  }
		  ?>
              </select>
		<?php
		}
		?>       </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border" >名称：</td>
      <td class="border" > <input name="title" type="text" id="title" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border" >内容：</td>
      <td class="border" > <textarea  name="content" id="content"></textarea>
	  	<script type="text/javascript">CKEDITOR.replace('content');	</script>      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >置顶值：</td>
      <td class="border" ><input name="elite" type="text" id="elite" value="0" size="10" maxlength="3">
        (0-255之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" ><input type="submit" name="Submit" value="发 布" ></td>
    </tr>
  </table>
</form>
	  
</body>
</html>