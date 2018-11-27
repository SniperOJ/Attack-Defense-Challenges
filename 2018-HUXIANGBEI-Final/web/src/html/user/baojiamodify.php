<?php
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<title></title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});
</script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.cp.value==""){alert("请填写产品！");document.myform.cp.focus();return false;}
if (document.myform.classid.value==""){alert("请选择产品类别！");document.myform.classid.focus();return false;}  
if (document.myform.province.value=="请选择省份"){alert("请选择省份！");document.myform.province.focus();return false;}
if (document.myform.price.value==""){alert("请填写价格！");document.myform.price.focus();return false;}
if (document.myform.danwei.value==""){alert("请填写计价单位！");document.myform.danwei.focus();return false;}
//定义正则表达式部分
var strP=/^\d+(\.\d+)?$/;
if(!strP.test(document.myform.price.value)) {
alert("价格只能填数字！"); 
document.myform.price.focus(); 
return false; 
}
if (document.myform.truename.value==""){alert("请填写真实姓名！");document.myform.truename.focus();return false;}  
if (document.myform.tel.value==""){alert("请填写代联系电话！");document.myform.tel.focus();return false;}  
if (document.myform.yzm.value==""){alert("请输入验证问题的答案！");document.myform.yzm.focus();return false;} 
}
</script> 
</head>
<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<?php
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id=0;
}
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}

$sql="select * from zzcms_baojia where id='$id'";
$rs = query($sql); 
$row = fetch_array($rs);
if ($row["editor"]<>$username) {
markit();

showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
exit;
}
?>
<div class="content">
<div class="admintitle">报价修改</div>
<form action="baojiasave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="18%" align="right" class="border" >产品<font color="#FF0000">（必填）</font>：</td>
            <td width="82%" class="border" > <input name="cp" type="text" id="cp" class="biaodan" value="<?php echo $row["cp"]?>" size="60" maxlength="45" onBlur="CheckNum()">
			</td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border2" >类别<font color="#FF0000">（必填）</font>：</td>
            <td class="border2" ><select name="classid" class="biaodan">
                <option value="" selected="selected">请选择类别</option>
                <?php
		$sqln="select * from zzcms_zsclass where parentid='A'";
		$rsn=query($sqln);
		while($rown= fetch_array($rsn)){
		if ($rown["classzm"]==$row["classzm"]){
			echo "<option value='".$rown['classzm']."' selected>".$rown["classname"]."</option>";
			}else{
			echo "<option value='".$rown['classzm']."'>".$rown["classname"]."</option>";
			}
			
		  }
		  ?>
              </select></td>
          </tr>
          <tr> 
            <td align="right" class="border" >区域<font color="#FF0000">（必填）</font>：</td>
            <td class="border" >
			<select name="province" id="province" class="biaodan"></select>
<select name="city" id="city" class="biaodan"></select>
<select name="xiancheng" id="xiancheng" class="biaodan" onchange="addSrcToDestList()"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row['province']?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
</script> 
			</td>
          </tr>
          <tr>
            <td align="right" class="border">价格<font color="#FF0000">（必填）</font>：</td>
            <td class="border"><input name="price" type="text" id="price" value="<?php echo $row["price"]?>" size="10" maxlength="50" />
              (填数字) </td>
          </tr>
          <tr>
            <td align="right" class="border2">计价单位<font color="#FF0000">（必填）</font>：</td>
            <td class="border2"><input name="danwei" type="text" id="danwei" value="<?php echo $row["danwei"]?>" size="10" maxlength="50" />
              (如：元/瓶)</td>
          </tr>
          <tr> 
            <td align="right" class="border">公司名称：</td>
            <td class="border"><input name="company" type="text" id="company" class="biaodan" value="<?php echo $row["companyname"]?>" size="45" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border2">真实姓名<font color="#FF0000">（必填）</font>：</td>
            <td class="border2"> <input name="truename" type="text" id="truename" class="biaodan" value="<?php echo $row["dlsname"]?>" size="45" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border">电话<font color="#FF0000">（必填）</font>：</td>
            <td class="border"><input name="tel" type="text" id="tel" class="biaodan" value="<?php echo $row["tel"]?>" size="45" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border2">地址：</td>
            <td class="border2"> <input name="address" type="text" id="address" class="biaodan" value="<?php echo $row["address"]?>" size="45" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border">E-mail：</td>
            <td class="border"><input name="email" type="text" id="email" class="biaodan" value="<?php echo $row["email"]?>" size="45" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border2">答案<font color="#FF0000">（必填）</font>：</td>
            <td class="border2"><input name="yzm" type="text" id="yzm" class="biaodan" value="" size="10" maxlength="50" style="width:60px"/>
            <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="看不清，点击换一张" /></td>
          </tr>
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="dlid" type="hidden" value="<?php echo $row["id"] ?>"> 
			
              <input name="action" type="hidden" id="action2" value="modify"> 
              <input name="page" type="hidden" id="action" value="<?php echo $page ?>"> 
			  
              <input name="Submit" type="submit" class="buttons" value="修改"></td>
          </tr>
        </table>
		</form>
</div>
</div>
</div>

</div>
</body>
</html>