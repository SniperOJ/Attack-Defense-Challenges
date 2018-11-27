<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php
checkadminisdo("dl");
$id=$_REQUEST["id"];
if ($id<>""){
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_dl where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);

?>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.cp.value==""){
    alert("请填写您要<?php echo channeldl?>的产品名称！");
	document.myform.cp.focus();
	return false;
  }
  if (document.myform.classid.value==""){
    alert("请选择产品类别！");
	document.myform.classid.focus();
	return false;
  }  

  if (document.myform.content.value==""){
    alert("请填写<?php echo channeldl?>商介绍！");
	document.myform.content.focus();
	return false;
  }
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
  
var v = '';
for(var i = 0; i < document.myform.destList.length; i++){
	if(i==0){
	v = document.myform.destList.options[i].text;
	}else{
	v += ','+document.myform.destList.options[i].text;
	}
}
//alert(v);
document.myform.cityforadd.value=v ;   
}
function showsubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none"){
eval("submenu" + sid + ".style.display=\"\";");
}
}
function hidesubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == ""){
eval("submenu" + sid + ".style.display=\"none\";");
   }
}
</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="admintitle"> 修改<?php echo channeldl?>信息</div>
<form action="dl_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>产品 <font color="#FF0000">*</font></td>
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
      <td width="130" align="right" class="border"><?php echo channeldl?>区域：</td>
      <td class="border"><table border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td><script language="JavaScript" type="text/javascript">
function addSrcToDestList() {
destList = window.document.forms[0].destList;
city = window.document.forms[0].xiancheng;
var len = destList.length;
for(var i = 0; i < city.length; i++) {
if ((city.options[i] != null) && (city.options[i].selected)) {
var found = false;
for(var count = 0; count < len; count++) {
if (destList.options[count] != null) {
if (city.options[i].text == destList.options[count].text) {
found = true;
break;
}
}
}
if (found != true) {
destList.options[len] = new Option(city.options[i].text);
len++;
}
}
}
}
function deleteFromDestList() {
var destList = window.document.forms[0].destList;
var len = destList.options.length;
for(var i = (len-1); i >= 0; i--) {
if ((destList.options[i] != null) && (destList.options[i].selected == true)) {
destList.options[i] = null;
}
}
} 
              </script>
<select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng" onChange="addSrcToDestList()"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '');
</script>            
              
            <input name="oldprovince" type="hidden" id="oldprovince" value="<?php echo $row["province"]?>" /></td>
        
          <td width="100" align="center" valign="top">已选城市
            <select style='width:100px;font-size:13px' size="4" name="destList" multiple="multiple">
                <?php 
		if ($row["city"]!="" &&  $row["city"]!="全国") {
			  if (strpos($row["city"],",")==0) {?>
                <option value="<?php echo $row["city"]?>"><?php echo $row["city"]?></option>
                <?php }else{
			  	$selectedcity=explode(",",$row["city"]);
				for ($i=0;$i<count($selectedcity);$i++){    
				?>
                <option value="<?php echo $selectedcity[$i]?>"><?php echo $selectedcity[$i]?></option>
                <?php }
				}
		}
			?>
              </select>
              <input name="cityforadd" type="hidden" id="cityforadd" />
              <input name="button2" type="button" onClick="javascript:deleteFromDestList();" value="删除已选城市" /></td>
        </tr>
      </table></td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border">内容：</td>
      <td class="border"> 
        <textarea name="content" cols="45" rows="6" id="content"><?php echo $row["content"]?></textarea> 
        <input name="dlid" type="hidden" id="dlid" value="<?php echo $row["id"]?>">
        <input name="page" type="hidden" id="page" value="<?php echo $_REQUEST["page"]?>">      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>身份：</td>
      <td class="border"><input name="dlsf" id="dlsf_company" type="radio" value="公司" onClick="showsubmenu(1)" <?php if ($row["company"]=="公司") { echo "checked";}?>> 
        <label for="dlsf_company">公司 </label> <input type="radio" name="dlsf" id="dlsf_person" value="个人" onClick="hidesubmenu(1)" <?php if ($row["company"]=="个人"){ echo "checked";}?>> 
        <label for="dlsf_person">个人</label></td>
    </tr>
    <tr <?php if ($row["company"]=="个人"){ echo " style='display:none'";}?> id='submenu1'> 
      <td align="right" class="border">公司名称：</td>
      <td class="border"><input name="company" type="text" id="company" value="<?php echo $row["companyname"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border"> 
        <input name="truename" type="text" id="truename" value="<?php echo $row["dlsname"]?>" size="45" maxlength="255" /></td>
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