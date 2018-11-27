<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
$FoundErr=0;
$ErrMsg="";
if ($action=="add") {
checkadminisdo("usergroup");
$groupname=trim($_POST["groupname"]);
$grouppic=trim($_POST["grouppic"]);
$groupid=trim($_POST["groupid"]);
$RMB=trim($_POST["RMB"]);

$config="";
if (isset($_POST['config'])){
foreach( $_POST['config'] as $i){$config .=$i."#";}
$config=substr($config,0,strlen($config)-1);//去除最后面的"#"
}

$refresh_number=trim($_POST["refresh_number"]);
$addinfo_number=trim($_POST["addinfo_number"]);
$addinfototle_number=trim($_POST["addinfototle_number"]);
$looked_dls_number_oneday=trim($_POST["looked_dls_number_oneday"]);
	$sql="Select * From zzcms_usergroup Where groupid=".$groupid."";
		$rs=query($sql);
		$row=num_rows($rs);
		if ($row){
			$FoundErr=1;
			$ErrMsg="<li>用户组ID“" . $groupid . "”已经存在！</li>";
		}
	
	if ($FoundErr==0){
		$sql="select * from zzcms_usergroup where groupname='" . $groupname . "'";
		$rs=query($sql);
		$row=num_rows($rs);
		if ($row){
			$FoundErr=1;
			$ErrMsg=$ErrMsg . "<li>“" . $groupname . "”已经存在！</li>";
		}else{	
		query("insert into zzcms_usergroup (
		groupname,grouppic,groupid,RMB,config,
		refresh_number,addinfo_number,addinfototle_number,looked_dls_number_oneday
		)values(
		'$groupname','$grouppic','$groupid','$RMB','$config',
		'$refresh_number','$addinfo_number','$addinfototle_number','$looked_dls_number_oneday'
		)");
		echo "<script>location.href='usergroupmanage.php'</script>";  
		}
	}
}
if ($FoundErr==1) {
	WriteErrMsg($ErrMsg);
}else{
?>
<script language="JavaScript" type="text/JavaScript">
function checkform(){
  if (document.form1.groupname.value==""){
    alert("用户组名称不能为空！");
    document.form1.groupname.focus();
    return false;
  }

//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.form1.groupid.value)) {
alert("用户组ID只能填数字！"); 
document.form1.groupid.focus(); 
return false; 
}

if(!strP.test(document.form1.RMB.value)) {
alert("所需费用只能填数字！"); 
document.form1.RMB.focus(); 
return false; 
}  

if(!strP.test(document.form1.refresh_number.value)) {
alert("每天刷新次数需填写数字！"); 
document.form1.refresh_number.focus(); 
return false; 
} 

if(!strP.test(document.form1.addinfo_number.value)) {
alert("每天发布信息数需填写数字！"); 
document.form1.addinfo_number.focus(); 
return false; 
} 

if(!strP.test(document.form1.addinfototle_number.value)) {
alert("发布信息总数需填写数字！"); 
document.form1.addinfototle_number.focus(); 
return false; 
} 

if(!strP.test(document.form1.looked_dls_number_oneday.value)) {
alert("每天查看<?php echo channeldl?>商信息数需填写数字！"); 
document.form1.looked_dls_number_oneday.focus(); 
return false; 
} 
}

function CheckAll(form){
	for (var i=0;i<form.elements.length;i++){
    var e = form.elements[i];
    if (e.Name != "chkAll"){
	e.checked = form.chkAll.checked;
	}   
	}
}
</script>
<div class="admintitle">添加用户组</div>
<form name="form1" method="post" action="?action=add" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
      <td width="20%" align="right" class="border">用户组名称</td>
      <td width="80%" class="border"><input name="groupname" type="text" maxlength="30"></td>
    </tr>
    
	<tr>
      <td align="right" class="border">等级图片</td>
      <td class="border"><input name="grouppic" type="text" id="grouppic" maxlength="30"></td>
    </tr>
	
    <tr>
      <td align="right" class="border">用户组ID</td>
      <td class="border"><input name="groupid" type="text" id="groupid" maxlength="30">
        （填数字 ）</td>
    </tr>
	
    <tr>
      <td align="right" class="border">所需费用</td>
      <td class="border"><input name="RMB" type="text" id="RMB" maxlength="30">(积分/年，填数字) </td>
    </tr>
	
    <tr>
      <td align="right" class="border">给权限<label for="chkAll"></label></td>
      <td class="border"><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
          <label for="chkAll">全选/取消全选</label>
          <br>
          <label for="checkbox">
          <input type="checkbox" name="config[]" value="look_dls_data" id="look_dls_data">
        </label>
        <label for="look_dls_data">查看<?php echo channeldl?>商数据库联系方式</label>
          <input type="checkbox" name="config[]" value="look_dls_liuyan" id="look_dls_liuyan">
        <label for="look_dls_liuyan">查看<?php echo channeldl?>商留言联系方式</label>
          <input type="checkbox" name="config[]" value="look_jobaccept" id="look_jobaccept">
        <label for="look_jobaccept">查看应聘者联系方式</label>
          <br>
          <input type="checkbox" name="config[]" value="dls_print" id="dls_print">
          <label for="dls_print">打印<?php echo channeldl?>留言</label>
          <input type="checkbox" name="config[]" value="dls_download" id="dls_download">
          <label for="dls_download">下载<?php echo channeldl?>留言</label>
          <input type="checkbox" name="config[]" value="set_mobile" id="set_mobile">
          <label for="set_mobile">绑定手机</label>
          <input type="checkbox" name="config[]" value="set_text_adv" id="set_text_adv">
          <label for="set_text_adv">抢占广告位</label>
          <input type="checkbox" name="config[]" value="set_elite" id="set_elite">
          <label for="set_elite">置顶信息</label>
          <input type="checkbox" name="config[]" value="uploadflv" id="uploadflv">
          <label for="uploadflv">上传视频</label>
        
          <input type="checkbox" name="config[]" value="set_zt" id="set_zt">
          <label for="set_zt">装修展厅</label>
          <input type="checkbox" name="config[]" value="passed" id="passed">
          <label for="passed">信息免审</label>
          <input type="checkbox" name="config[]" value="seo" id="seo">
          <label for="seo">SEO设置</label>
        <br/>
          <input type="checkbox" name="config[]" value="showcontact" id="showcontact">
          <label for="showcontact">显示注册信息的联系方式</label>
          <input type="checkbox" name="config[]" value="showad_inzt" id="showad_inzt">
          <label for="showad_inzt">在展厅内显网站上其它用户的广告(VIP会员建议不选)</label>
		  <input type="checkbox" name="config[]" value="zsshow_template" id="zsshow_template">
          <label for="zsshow_template">选择招商展示页模板</label>
         </td>
    </tr>
	
    <tr>
      <td align="right"  class="border">每天刷新次数</td>
      <td class="border"><input name="refresh_number" type="text" id="refresh_number" maxlength="30"></td>
    </tr>
	
    <tr>
      <td align="right"  class="border">每天发布信息数/栏目</td>
      <td  class="border"><input name="addinfo_number" type="text" id="addinfo_number" maxlength="30"></td>
    </tr>
	
    <tr>
      <td align="right"  class="border">发布信息总数/栏目</td>
      <td  class="border"><input name="addinfototle_number" type="text" id="addinfototle_number" maxlength="30"></td>
    </tr>
	
    <tr>
      <td align="right"  class="border">每天查看<?php echo channeldl?>商信息数</td>
      <td  class="border"><input name="looked_dls_number_oneday" type="text" id="looked_dls_number_oneday" maxlength="30">(填999为不限制)</td>
    </tr>
	
    <tr>
      <td  class="border">&nbsp;</td>
      <td  class="border"><input name="add" type="submit" value=" 添 加 "></td>
    </tr>
  </table>
</form>
<?php
}

?>