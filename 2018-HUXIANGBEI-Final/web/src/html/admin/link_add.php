<?php 
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (isset($_SESSION["bigclassid"])){
$sbigclassid=$_SESSION["bigclassid"];
}else{
$sbigclassid="";
}
?>
<script language = "JavaScript">	
function CheckForm(){	  
if (document.myform.sitename.value==""){
    alert("网站名称不能为空！");
	document.myform.sitename.focus();
	return false;
  }
  if (document.myform.url.value==""){
    alert("网址不能为空！");
	document.myform.url.focus();
	return false;
  }
  if (document.myform.content.value==""){
    alert("描述不能为空！");
	document.myform.content.focus();
	return false;
  }
  return true;  
} 
</script>
</head>
<body>
<div class="admintitle">添加友情链接信息</div>
<form action="link_save.php?action=add" method="post" name="myform" id="myform" onSubmit="return CheckForm();">    
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">所属类别：</td>
      <td class="border"> 
        <?php
		$sql = "select * from zzcms_linkclass order by xuhao asc";
	    $rs=query($sql);
        $row=num_rows($rs);
		if (!$row){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="0" selected="selected">请选择类别</option>
                <?php
		while($row= fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>" <?php if ($row["bigclassid"]==$sbigclassid) { echo "selected";}?>><?php echo $row["bigclassname"]?></option>
                <?php
		  }
		  ?>
              </select>
		<?php
		}
		?>  
        </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">网站名称：</td>
      <td class="border"><input name="sitename" type="text" id="sitename" size="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">网址：</td>
      <td class="border"> <input name="url" type="text" id="url" size="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">logo：</td>
      <td class="border"><input name="logo" type="text" id="logo" size="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">描述：</td>
      <td class="border"> <textarea name="content" cols="50" rows="3" id="content"></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"> <input name="passed" type="checkbox" id="passed" value="1" checked>
        （选中为通过审核） </td>
    </tr>
    <tr> 
      <td align="right" class="border">首页显示：</td>
      <td class="border"> <input name="elite" type="checkbox" id="elite" value="1" checked>
        （选中显示在首页） </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
      </form>
	
</body>
</html>