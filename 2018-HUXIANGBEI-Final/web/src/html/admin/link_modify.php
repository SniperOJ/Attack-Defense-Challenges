<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (isset($_SESSION["linkclassid"])){
$slinkclassid=$_SESSION["linkclassid"];
}else{
$slinkclassid="";
}
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
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
<div class="admintitle">修改友情链接信息</div>
<?php
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_link where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="link_save.php?action=modify" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td align="right" class="border">所属类别：</td>
      <td class="border"> 
        <?php
		$sqln = "select * from zzcms_linkclass order by xuhao asc";
	    $rsn=query($sqln);
        $rown=num_rows($rsn);
		if (!$rown){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value=0 selected="selected">请选择类别</option>
                <?php
		while($rown= fetch_array($rsn)){
			?>
                <option value="<?php echo $rown["bigclassid"]?>" <?php if ($rown["bigclassid"]==$row["bigclassid"]) { echo "selected";}?>><?php echo $rown["bigclassname"]?></option>
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
      <td class="border"><input name="sitename" type="text" id="title" value="<?php echo $row["sitename"]?>" size="50"> 
      </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">网址：</td>
      <td class="border"> <input name="url" type="text" id="url" value="<?php echo $row["url"]?>" size="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">logo：</td>
      <td class="border"><input name="logo" type="text" id="logo" value="<?php echo $row["logo"]?>" size="50"></td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">描述：</td>
      <td class="border"> <textarea name="content" cols="50" rows="3" id="content"><?php echo $row["content"]?></textarea> 
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>"> <input name="page" type="hidden" id="page" value="<?php echo $page?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"> <input name="passed" type="checkbox" id="passed" value="1" checked>
        （选中为通过审核） </td>
    </tr>
    <tr> 
      <td align="right" class="border">首页显示：</td>
      <td class="border"> <input name="elite" type="checkbox" id="elite" value="1" <?php if ($row["elite"]==1){ echo "checked";}?>>
        （选中显示在首页） </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit" value="修 改"></td>
    </tr>
  </table>
      </form>
	  
</body>
</html>