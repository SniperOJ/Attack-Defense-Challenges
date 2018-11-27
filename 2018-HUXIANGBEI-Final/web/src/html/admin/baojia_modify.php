<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php
checkadminisdo("baojia");
$id=$_REQUEST["id"];
if ($id<>""){
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_baojia where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);

?>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.cp.value==""){
    alert("请填写产品名称！");
	document.myform.cp.focus();
	return false;
  }
  if (document.myform.classid.value==""){
    alert("请选择产品类别！");
	document.myform.classid.focus();
	return false;
  }  

  if (document.myform.price.value==""){alert("请填写价格！");document.myform.price.focus();return false; }
  if (document.myform.danwei.value==""){alert("请填写计价单位！");document.myform.danwei.focus();return false;}
    if (document.myform.truename.value==""){
    alert("请填写真实姓名！");
	document.myform.truename.focus();
	return false;
  }  
  if (document.myform.tel.value==""){
    alert("请填写代联系电话！");
	document.myform.tel.focus();
	return false;
  }
}
</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="admintitle"> 修改报价信息</div>
<form action="baojia_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr> 
      <td align="right" class="border">产品 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="cp" type="text" id="cp" value="<?php echo $row["cp"]?>" size="45" maxlength="45">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">产品类别 <font color="#FF0000">*</font></td>
      <td class="border"> 
	   <?php
		$sqln = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
	    $rsn=query($sqln);
        $rown=num_rows($rsn);
		if (!$rown){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="classid" id="classid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($rown= fetch_array($rsn)){
			?>
                <option value="<?php echo $rown["classzm"]?>" <?php if ($rown["classzm"]==$row["classzm"]) { echo "selected";}?>><?php echo $rown["classname"]?></option>
                <?php
		  }
		  ?>
              </select>
		<?php
		}
		?>         </td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border">区域：</td>
      <td class="border"><select name="province" id="province">
      </select>
        <select name="city" id="city">
        </select>
        <select name="xiancheng" id="xiancheng">
        </select>
        <script src="/js/area.js"></script>
        <script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '');
        </script>
        <input name="oldprovince" type="hidden" id="oldprovince" value="<?php echo $row["province"]?>" /></td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border">价格：</td>
      <td class="border"><input name="price" type="text" id="price" value="<?php echo $row["price"]?>" size="10" maxlength="45">
        <input name="dlid" type="hidden" id="dlid" value="<?php echo $row["id"]?>">
        <input name="page" type="hidden" id="page" value="<?php echo $_REQUEST["page"]?>">      </td>
    </tr>
    <tr>
      <td align="right" class="border">单位：</td>
      <td class="border"><input name="danwei" type="text" value="<?php echo $row["danwei"]?>" size="10" maxlength="45"></td>
    </tr>
    <tr> 
      <td align="right" class="border">公司名称：</td>
      <td class="border"><input name="companyname" type="text" id="companyname" value="<?php echo $row["companyname"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border"> 
        <input name="truename" type="text" id="truename" value="<?php echo $row["truename"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">电话 <font color="#FF0000">*</font></td>
      <td class="border"><input name="tel" type="text" id="tel" value="<?php echo $row["tel"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">地址：</td>
      <td class="border"> 
        <input name="address" type="text" id="address" value="<?php echo $row["address"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" value="<?php echo $row["email"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr>
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($row["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="修 改">
        <input name="action" type="hidden" id="action3" value="modify"></td>
    </tr>
  </table>
</form>
</body>
</html>