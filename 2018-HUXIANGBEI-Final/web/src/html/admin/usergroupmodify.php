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
if (isset($_REQUEST['id'])){
$id=$_REQUEST['id'];
checkid($id);
}else{
$id=0;
}
$FoundErr=0;
$ErrMsg="";

$sql="Select * from zzcms_usergroup where id='$id'";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>此用户组不存在！</li>";
}else{
	if ($action=="modify"){
	checkadminisdo("usergroup");
	$groupname=trim($_POST["groupname"]);
	$grouppic=trim($_POST["grouppic"]);
	$groupid=trim($_POST["groupid"]);
	$oldgroupid=trim($_POST["oldgroupid"]);
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
	
	if ($FoundErr==0) {
	query("update zzcms_usergroup set groupname='$groupname',grouppic='$grouppic',groupid='$groupid',RMB='$RMB',config='$config',
	refresh_number='$refresh_number',addinfo_number='$addinfo_number',addinfototle_number='$addinfototle_number',
	looked_dls_number_oneday='$looked_dls_number_oneday' where id='$id'");
		if ($groupid<>$oldgroupid){
			query("Update zzcms_user set groupid=" . $groupid . " where groupid=" . $oldgroupid."");
			query("Update zzcms_main set groupid=" . $groupid . " where groupid=" . $oldgroupid."");
     	}		
		echo "<script>location.href='usergroupmanage.php'</script>";
	}
}
if ($FoundErr==1) {
	WriteErrMsg($ErrMsg);
}else{
$sql="Select * from zzcms_usergroup where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
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
<div class="admintitle">修改用户组</div>
<form name="form1" method="post" action="?" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="20%"  align="right" class="border">用户组名称</td>
      <td width="80%" class="border"> <input name="groupname" type="text" value="<?php echo $row["groupname"]?>" maxlength="30">      </td>
    </tr>
    <tr> 
      <td  align="right" class="border">等级图片</td>
      <td  class="border"> <input name="grouppic" type="text" id="grouppic" value="<?php echo $row["grouppic"]?>" maxlength="30">      </td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">用户组ID</td>
      <td height="11" class="border"><input name="groupid" type="text" id="groupid" value="<?php echo $row["groupid"]?>" size="4" maxlength="4">
        (为必免用户信息及产品信息排序混乱，不要随意改ID值) 
        <input name="oldgroupid" type="hidden" id="oldgroupid" value="<?php echo $row["groupid"]?>"></td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">所需费用</td>
      <td height="11" class="border"><input name="RMB" type="text" id="RMB" value="<?php echo $row["RMB"]?>" size="4" maxlength="30">
        (积分/年) </td>
    </tr>
    <tr>
      <td align="right" class="border">给权限
        <label for="chkAll"></label></td>
      <td class="border"><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
          <label for="chkAll">全选/取消全选</label>
          <br>
         <input type="checkbox" name="config[]" value="look_dls_data" id="look_dls_data" <?php if(str_is_inarr($row["config"],'look_dls_data')=='yes'){echo "checked";}?>>
        <label for="look_dls_data">查看<?php echo channeldl?>商数据库联系方式</label>
          <input type="checkbox" name="config[]" value="look_dls_liuyan" id="look_dls_liuyan" <?php if(str_is_inarr($row["config"],'look_dls_liuyan')=='yes'){echo "checked";}?>>
        <label for="look_dls_liuyan">查看<?php echo channeldl?>商留言联系方式</label>
          <input type="checkbox" name="config[]" value="look_jobaccept" id="look_jobaccept" <?php if(str_is_inarr($row["config"],'look_jobaccept')=='yes'){echo "checked";}?>>
        <label for="look_jobaccept">查看应聘者联系方式</label>
          <br>
          <input type="checkbox" name="config[]" value="dls_print" id="dls_print" <?php if(str_is_inarr($row["config"],'dls_print')=='yes'){echo "checked";}?>>
          <label for="dls_print">打印<?php echo channeldl?>留言</label>
          <input type="checkbox" name="config[]" value="dls_download" id="dls_download" <?php if(str_is_inarr($row["config"],'dls_download')=='yes'){echo "checked";}?>>
          <label for="dls_download">下载<?php echo channeldl?>留言</label>
          <input type="checkbox" name="config[]" value="set_mobile" id="set_mobile" <?php if(str_is_inarr($row["config"],'set_mobile')=='yes'){echo "checked";}?>>
          <label for="set_mobile">绑定手机</label>
          <input type="checkbox" name="config[]" value="set_text_adv" id="set_text_adv" <?php if(str_is_inarr($row["config"],'set_text_adv')=='yes'){echo "checked";}?>>
          <label for="set_text_adv">抢占广告位</label>
          <input type="checkbox" name="config[]" value="set_elite" id="set_elite" <?php if(str_is_inarr($row["config"],'set_elite')=='yes'){echo "checked";}?>>
          <label for="set_elite">置顶信息</label>
          <input type="checkbox" name="config[]" value="uploadflv" id="uploadflv" <?php if(str_is_inarr($row["config"],'uploadflv')=='yes'){echo "checked";}?>>
          <label for="uploadflv">上传视频</label>
          <input type="checkbox" name="config[]" value="set_zt" id="set_zt" <?php if(str_is_inarr($row["config"],'set_zt')=='yes'){echo "checked";}?>>
          <label for="set_zt">装修展厅</label>
          <input type="checkbox" name="config[]" value="passed" id="passed" <?php if(str_is_inarr($row["config"],'passed')=='yes'){echo "checked";}?>>
          <label for="passed">信息免审</label>
          <input type="checkbox" name="config[]" value="seo" id="seo" <?php if(str_is_inarr($row["config"],'seo')=='yes'){echo "checked";}?>>
          <label for="seo">SEO设置</label>
        <br/>
          <input type="checkbox" name="config[]" value="showcontact" id="showcontact" <?php if(str_is_inarr($row["config"],'showcontact')=='yes'){echo "checked";}?>>
          <label for="showcontact">显示注册信息的联系方式</label>
          <input type="checkbox" name="config[]" value="showad_inzt" id="showad_inzt" <?php if(str_is_inarr($row["config"],'showad_inzt')=='yes'){echo "checked";}?>>
          <label for="showad_inzt">在展厅内显网站上其它用户的广告(VIP会员建议不选)</label>
          <label for="zsshow_template">
          <input type="checkbox" name="config[]" value="zsshow_template" id="zsshow_template" <?php if(str_is_inarr($row["config"],'zsshow_template')=='yes'){echo "checked";}?>>
选择招商展示页模板 </label></td>
    </tr>
    <tr> 
      <td align="right"  class="border">每天刷新次数</td>
      <td  class="border"><input name="refresh_number" type="text" id="refresh_number" value="<?php echo $row["refresh_number"]?>" size="4" maxlength="30">      </td>
    </tr>
    <tr> 
      <td align="right"  class="border">每天发布信息数/栏目</td>
      <td  class="border"><input name="addinfo_number" type="text" id="addinfo_number" value="<?php echo $row["addinfo_number"]?>" size="4" maxlength="30"></td>
    </tr>
    <tr> 
      <td align="right"  class="border">发布信息总数/栏目</td>
      <td  class="border"><input name="addinfototle_number" type="text" id="addinfototle_number" value="<?php echo $row["addinfototle_number"]?>" size="4" maxlength="30"></td>
    </tr>
    <tr> 
      <td align="right"  class="border">每天查看<?php echo channeldl?>商信息数</td>
      <td  class="border"><input name="looked_dls_number_oneday" type="text" id="looked_dls_number_oneday" value="<?php echo $row["looked_dls_number_oneday"]?>" size="4" maxlength="30">
        (填999为不限制)</td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td class="border"> <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>"> 
        <input name="action" type="hidden" id="action" value="modify"> <input name="save" type="submit" id="Save" value="修改">      </td>
    </tr>
  </table>
</form>
<?php
}
}
?>
</body>
</html>