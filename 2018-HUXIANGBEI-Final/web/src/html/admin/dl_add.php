<?php
include("admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<script language = "JavaScript">
function CheckForm()
{
if (document.myform.cp.value=="")
  {
    alert("请填写您要求<?php echo channeldl?>的产品名称！");
	document.myform.cp.focus();
	return false;
  }
if (document.myform.classid.value=="")
  {
    alert("请选择产品类别！");
	document.myform.classid.focus();
	return false;
  }  
  if (document.myform.province.value=="请选择省份")
  {
    alert("请选择要<?php echo channeldl?>的省份！");
	document.myform.province.focus();
	return false;
  }
  
  
  if (document.myform.truename.value=="")
  {
    alert("请填写真实姓名！");
	document.myform.truename.focus();
	return false;
  }  
 
  if (document.myform.tel.value=="")
  {
    alert("请填写代联系电话！");
	document.myform.tel.focus();
	return false;
  }  
  
   if (document.myform.yzm.value=="")
  {
    alert("请输入验证问题的答案！");
	document.myform.yzm.focus();
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
document.myform.cityforadd.value=v;
 
}

function showsubmenu(sid)
{
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none")
{
eval("submenu" + sid + ".style.display=\"\";");
}
}
function hidesubmenu(sid)
{
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "")
  {
eval("submenu" + sid + ".style.display=\"none\";");
   }
}
</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="pagebody">
<div class="admintitle">发布<?php echo channeldl?>信息</div>

<form action="dl_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
    <tr> 
      <td align="right" class="border">想要<?php echo channeldl?>的产品 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="cp" type="text" id="cp" size="45" maxlength="45">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">产品类别 <font color="#FF0000">*</font></td>
      <td class="border">
	   <select name="classid">
          <option value="" selected>请选择类别</option>
          <?php
		$sql="select * from zzcms_zsclass where parentid='A'";
		$rs=query($sql);
		while($row= fetch_array($rs)){
			?>
          <option value="<?php echo $row["classzm"]?>"<?php if (@$_SESSION['bigclassid']==$row["classzm"]){echo 'selected';}?>><?php echo $row["classname"]?></option>
          <?php
		  }
		  ?>
        </select> </td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border"><?php echo channeldl?>区域 <font color="#FF0000">*</font></td>
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
                    <script type="text/javascript" src="/js/jquery.js"></script>
                    <script type="text/javascript" language="JavaScript">
$.ajaxSetup ({
cache: false //close AJAX cache
});
              </script>
                    <script language="JavaScript" type="text/javascript">  
$(document).ready(function(){  
	$("#tel").change(function() { //jquery 中change()函数  
	$("#telcheck").load(encodeURI("/ajax/dltelcheck_ajax.php?id="+$("#tel").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
	});  
});  
</script>
                   <select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng" onchange="addSrcToDestList()"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION["city"]?>', '');
</script>
                </td>
               
                <td width="100" align="center" valign="top">已选城市
                  <select name="destList" size="5" multiple="multiple" style='width:100px;font-size:13px'>
                      <?php if (isset($_SESSION['city'])){?>
                      <option value="<?php echo $_SESSION['city']?>" ><?php echo $_SESSION['city']?></option>
                      <?php
				  }
				  ?>
                  </select>
                    <input name="cityforadd" type="hidden" id="cityforadd" />
                    <input name="button" type="button" onclick="javascript:deleteFromDestList();" value="删除已选城市" /></td>
              </tr>
            </table></td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border"><?php echo channeldl?>商介绍 <font color="#FF0000">*</font></td>
      <td class="border"> <textarea name="content" cols="45" rows="6" id="content"><?php echo @$_SESSION["content"]?></textarea>      </td>
    </tr>
	
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>身份：</td>
      <td class="border"><input name="dlsf" id="dlsf_company" type="radio" value="公司" onclick="showsubmenu(1)">
         <label for="dlsf_company">公司 </label>
        <input name="dlsf" type="radio" id="dlsf_person" onclick="hidesubmenu(1)" value="个人" checked>
          <label for="dlsf_person">个人</label></td>
    </tr>
    <tr style="display:none" id='submenu1'>
      <td align="right" class="border">公司名称：</td>
      <td class="border"><input name="company" type="text" id="yzm2" value="" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border">
<input name="truename" type="text" id="truename" value="" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">电话 <font color="#FF0000">*</font></td>
      <td class="border">
	  <input name="tel" type="text" id="tel" value="" size="45" maxlength="255" />
	  <span id="telcheck"></span>
	  </td>
    </tr>
    <tr> 
      <td align="right" class="border">地址：</td>
      <td class="border">
<input name="address" type="text" id="address" value="" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" value="" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="发 布">
        <input name="action" type="hidden" id="action3" value="add"></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>