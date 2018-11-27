<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});  

var wait=60;
function time(o) {
	if (document.myform.tel.value ==""){
	alert("请先输入你的手机号码");
	document.myform.tel.focus();
	return false;
	}
	
	if (wait == 0) {
			o.removeAttribute("disabled");			
			o.value="获取验证码";
			wait = 60;
	} else {
			o.setAttribute("disabled", true);
			o.value="重新发送(" + wait + ")";
			wait--;
			setTimeout(function() {
				time(o)
			},
			1000)
		}
	}

function isNumber(String){ 
var Letters = "1234567890-";   //可以自己增加可输入值
var i;
var c;
if(String.charAt(0)=='-')
return   false;
if( String.charAt(String.length - 1) == '-' )
return   false;
for( i = 0; i<String.length;i ++ )
{ 
c=String.charAt( i );
if(Letters.indexOf( c )< 0)
return  false;
}
return  true;
}

function check_truename(){
if (document.myform.truename.value !=""){
	 //创建正则表达式
    var re=/^[\u4e00-\u9fa5]{2,10}$/; //只输入汉字的正则
    if(document.myform.truename.value.search(re)==-1)
    {
	
	alert("联系人只能为汉字，字符介于2到10个。");
	document.myform.truename.value="";
	document.myform.truename.focus();
	}
}
}

function check_tel(){
if (document.myform.tel.value !=""){
if(! isNumber(document.myform.tel.value))   { 
alert("您的电话号码不正确！");
document.myform.tel.value="";
document.myform.tel.focus();
}
}
}

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
if (document.myform.province.value=="请选择省份"){
    alert("请选择省份！");
	document.myform.province.focus();
	return false;
  }
  if (document.myform.price.value==""){
    alert("请填写价格！");
	document.myform.price.focus();
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
if (document.myform.yzm.value==""){
    alert("请输入验证问题的答案！");
	document.myform.yzm.focus();
	return false;
}

}
</SCRIPT>
</head>
<body>
<?php
include("../inc/top2.php");
echo sitetop();
?>
<div class="main">
<div class="pagebody">
<div class="titles">发布报价信息</div>
<div class="content">
<form action="?" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="8" cellspacing="1">
    <tr> 
      <td align="right" class="border">产品 <font color="#FF0000">*</font></td>
      <td class="border"> <input name="cp" type="text" id="cp" size="45" maxlength="45">      </td>
    </tr>
    <tr> 
      <td align="right" class="border2">产品类别 <font color="#FF0000">*</font></td>
      <td class="border2">
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
      <td width="130" align="right" class="border">区域 <font color="#FF0000">*</font></td>
            <td class="border">
                   
<select name="province" id="province"></select>
<select name="city" id="city"></select>
<select name="xiancheng" id="xiancheng"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION["city"]?>', '<?php echo @$_SESSION["xiangcheng"]?>');
</script>             </td>
    </tr>
    <tr> 
      <td width="130" align="right" class="border2"> 价格 <font color="#FF0000">*</font></td>
      <td class="border2"><span class="border">
        <input name="price" type="text" id="company" size="45" maxlength="255" />
        </span> </td>
    </tr>
	<?php
	if (isset($_COOKIE["UserName"])){
	$sql="select * from zzcms_user where username='".$_COOKIE["UserName"]."'";
	$rs=query($sql);
	$row= fetch_array($rs);
	?>
   
    <tr>
      <td align="right" class="border">公司名称：</td>
      <td class="border"><input name="companyname" type="text" value="<?php echo $row["comane"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border2">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border2">
<input name="truename" type="text" id="truename" value="<?php echo $row["somane"]?>" size="45" maxlength="255" onblur="check_truename"/></td>
    </tr>
    <tr> 
      <td align="right" class="border">手机 <font color="#FF0000">*</font></td>
      <td class="border"><input name="tel" type="text" id="tel" value="<?php echo $row["phone"]?>" size="45" maxlength="255" onblur="check_tel"/></td>
    </tr>
    <tr> 
      <td align="right" class="border2">地址：</td>
      <td class="border2">
<input name="address" type="text" id="address" value="<?php echo $row["address"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" value="<?php echo $row["email"]?>" size="45" maxlength="255" /></td>
    </tr>
	<?php }else{?>
	 
    <tr>
      <td align="right" class="border">公司名称：</td>
      <td class="border"><input name="companyname" type="text"  size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border2">真实姓名 <font color="#FF0000">*</font></td>
      <td class="border2">
<input name="truename" type="text" id="truename"  size="45" maxlength="255" onblur="check_truename()"/></td>
    </tr>
    <tr> 
      <td align="right" class="border">手机 <font color="#FF0000">*</font></td>
      <td class="border"><input name="tel" type="text" id="tel"  size="45" maxlength="255" onblur="check_tel()"/></td>
    </tr>
    <tr> 
      <td align="right" class="border2">地址：</td>
      <td class="border2">
<input name="address" type="text" id="address"  size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">E-mail：</td>
      <td class="border"><input name="email" type="text" id="email" size="45" maxlength="255" /></td>
    </tr>
	<?php 
	}
	?>
    <tr> 
    <td align="right" class="border2">答案 <font color="#FF0000">*</font></td>      
    <td class="border2">
	<input name="yzm" type="text" class="biaodan2" id="yzm" tabindex="10" value="" size="10" maxlength="50" style="width:60px"/>
    <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="看不清，点击换一张" /></td>
    </tr>
    <tr>
	<?php
	if (sendsms=="Yes"){
	?>
      <td align="right" class="border2">验证码<font color="#FF0000"> *</font> </td>
      <td class="border2">
        <input name="yzm_mobile" id="yzm_mobile"type="text" class="biaodan"  size="20" maxlength="50" style="width:60px"/>
<input name="yzm_mobile2" id="yzm_mobile2" style="display:none" />
<span id="ts_yzm_mobile"></span>
<input name="sendyzm" type="button" id="sendyzm" value="获取验证码"  onclick="time(this)"/>	  </td>
<?php
}
?>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="发 布">
        <input name="action" type="hidden" id="action3" value="add"></td>
    </tr>
  </table>
</form>
<?php
if (isset($_POST["action"])){
$classid=$_POST["classid"];
$cp=$_POST["cp"];
$province=$_POST["province"];
$city=$_POST["city"];
$xiancheng=$_POST["xiancheng"];
$price=$_POST["price"];
$companyname=$_POST["companyname"];
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];
checkyzm($_POST["yzm"]);

if (sendsms=="Yes"){
	$yzm_mobile=$_POST["yzm_mobile"];
	if(time()-intval(@$_SESSION['yzm_sendtime'])>60){showmsg('请重新获取验证码','back');}
	if($yzm_mobile!=@$_SESSION["yzm_mobile"]){showmsg('验证码错误！','back');}
}

if(!preg_match("/^[\x7f-\xff]+$/",$truename)){
showmsg('姓名只能用中文','back');
}

if(!preg_match("/1[3458]{1}\d{9}$/",$tel) && !preg_match('/^400(\d{3,4}){2}$/',$tel) && !preg_match('/^400(-\d{3,4}){2}$/',$tel) && !preg_match('/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',$tel)){//分别是手机，400电话(加-和不加两种情况都可以)，和普通电话
showmsg('电话号码不正确','back');
}

if ($cp<>'' && $truename<>'' && $tel<>''){
$isok=query("Insert into zzcms_baojia(classzm,cp,province,city,xiancheng,price,companyname,truename,tel,address,email,sendtime,editor) values('$classid','$cp','$province','$city','$xiancheng','$price','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."','".@$_COOKIE["UserName"]."')") ;
}  
if ($isok){
echo showmsg('发布成功，审核后显示。');
}else{
echo showmsg('发布失败！');
}
$_SESSION['bigclassid']=$classid;
$_SESSION['province']=$province;
$_SESSION['city']=$city;
$_SESSION['xiangcheng']=$xiangcheng;
session_write_close();
}	
?>
</div>
</div>
</div>
<?php
include("../inc/bottom.php");
echo sitebottom();
?>
</body>
</html>