<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<?php
checkadminisdo("admingroup");
?>
</head>
<script language="JavaScript" type="text/JavaScript">
function checkform(){
	if (document.form1.groupname.value==""){
    alert("用户组名称不能为空！");
    document.form1.groupname.focus();
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
<link href="style.css" rel="stylesheet" type="text/css">
<body>
<div class="admintitle">添加管理组</div>
<form name="form1" method="post" action="admingroupsave.php" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="25%" height="22" align="right" class="border" >管理组名称</td>
      <td width="75%" class="border" > <input name="groupname" type="text" maxlength="30">      </td>
    </tr>
    <tr>
      <td align="right" class="border" ><?php echo channelzs?></td>
      <td class="border" ><input name="config[]" id="zs" type="checkbox" value="zs">
        <label for="zs"><?php echo channelzs?>信息管理</label>
        <input name="config[]" id="zsclass" type="checkbox"  value="zsclass">
        <label for="zsclass"><?php echo channelzs?>/ <?php echo channeldl?>类别管理</label>
        <input name="config[]" id="zskeyword" type="checkbox" value="zskeyword">
        <label for="zskeyword"><?php echo channelzs?>/ <?php echo channeldl?>关键字管理 </label></td>
    </tr>
    <tr>
      <td align="right" class="border" ><?php echo channeldl?></td>
      <td class="border" ><input name="config[]" id="dl" type="checkbox"  value="dl">
        <label for="dl"><?php echo channeldl?>信息管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >展会</td>
      <td class="border" ><input name="config[]" id="zh" type="checkbox"  value="zh">
        <label for="zh"> 展会信息管理 </label>
        <input name="config[]" type="checkbox" id="zhclass"  value="zhclass">
        <label for="zhclass">展会类别管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >资讯</td>
      <td class="border" ><input name="config[]" type="checkbox" id="zx" value="zx">
        <label for="zx">资讯信息管理 </label>
        <input name="config[]" id="zxclass" type="checkbox" value="zxclass">
        <label for="zxclass">资讯类别管理 </label>
        <input name="config[]" id="zxpinglun" type="checkbox" value="zxpinglun">
        <label for="zxpinglun">资讯信息评论管理 </label>
        <input name="config[]" id="zxtag" type="checkbox"  value="zxtag">
        <label for="zxtag">资讯信息广告标签管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >品牌</td>
      <td class="border" ><input name="config[]" type="checkbox" id="pp" value="pp">
          <label for="pp">品牌管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >招聘</td>
      <td class="border" ><input name="config[]" type="checkbox" id="job" value="job">
          <label for="job">招聘管理 </label>
          <input name="config[]" id="jobclass" type="checkbox" value="jobclass">
          <label for="jobclass">招聘类别管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >专题</td>
      <td class="border" ><input name="config[]" type="checkbox" id="special" value="special">
          <label for="special">专题管理 </label>
          <input name="config[]" id="special" type="checkbox" value="special">
          <label for="special">专题类别管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >网刊</td>
      <td class="border" ><input name="config[]" type="checkbox" id="wangkan" value="wangkan">
          <label for="wangkan">网刊管理 </label>
          <input name="config[]" id="special" type="checkbox" value="wangkan">
          <label for="wangkan">网刊类别管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >报价</td>
      <td class="border" ><label><input name="config[]" type="checkbox" value="baojia">
          报价管理 </label></td>
    </tr>
    <tr>
      <td align="right" class="border" >问答</td>
      <td class="border" ><label><input name="config[]" type="checkbox" value="ask">
          问答管理 </label>
       <label> <input name="config[]"  type="checkbox" value="ask">
        问答类别管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >广告</td>
      <td class="border" ><input name="config[]" id="adv" type="checkbox" value="adv">
        <label for="adv">广告管理 </label>
        <input name="config[]" id="advclass" type="checkbox"  value="advclass">
        <label for="advclass">广告类别管理</label>
        <input name="config[]" id="advtext" type="checkbox"  value="advtext">
        <label for="advtext">用户审请的文字广告管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >用户</td>
      <td class="border" ><input name="config[]" id="userreg" type="checkbox" value="userreg">
        <label for="userreg">注册用户管理</label>
        <input name="config[]" id="usernoreg" type="checkbox"  value="usernoreg">
        <label for="usernoreg">未注册用户管理 </label>
        <input name="config[]" type="checkbox" id="userclass" value="userclass">
        <label for="userclass">用户类别管理</label>
        <input name="config[]" id="usergroup" type="checkbox"  value="usergroup">
        <label for="usergroup">用户组管理</label>
        <input name="config[]" id="guestbook" type="checkbox" value="guestbook">
        <label for="guestbook">用户留言本管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >用户信息</td>
      <td class="border" ><input name="config[]" id="badusermessage" type="checkbox" value="badusermessage">
        <label for="badusermessage">不良用户操作记录管理</label>
        <input name="config[]" id="fankui" type="checkbox" value="fankui">
        <label for="fankui">用户反馈信息管理</label>
        <input name="config[]" id="licence" type="checkbox" value="licence">
        <label for="licence">用户资质信息管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >文件</td>
      <td class="border" ><input name="config[]" id="uploadfiles"  type="checkbox"  value="uploadfiles">
        <label for="uploadfiles">上传文件管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >发信功能</td>
      <td class="border" ><input name="config[]" id="sendmessage" type="checkbox"  value="sendmessage">
        <label for="sendmessage">在线发信息管理 </label>
        <input name="config[]" id="sendmail" type="checkbox"  value="sendmail">
        <label for="sendmail">在线发邮件管理</label>
        <input name="config[]" id="sendsms" type="checkbox"  value="sendsms">
        <label for="sendsms">在线发手机短信管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >网站信息</td>
      <td class="border" ><input name="config[]" id="announcement"  type="checkbox" value="announcement">
        <label for="announcement">网站公告管理</label>
        <input name="config[]" id="helps" type="checkbox" value="helps">
        <label for="helps">网站使用帮助信息管理</label>
        <input name="config[]" type="checkbox" id="bottomlink"  value="bottomlink">
        <label for="bottomlink">网站底部链接信息管理</label>
        <input name="config[]" id="friendlink" type="checkbox" value="friendlink">
        <label for="friendlink">友情链接管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >网站配置</td>
      <td class="border" ><input name="config[]" type="checkbox"  id="siteconfig" value="siteconfig">
<label for="siteconfig">网站配置管理</label>
  <input name="config[]" type="checkbox" id="label"  value="label">
<label for="label">网站模板/标签管理</label></td>
    </tr>
    <tr>
      <td align="right" class="border" >管理员</td>
      <td class="border" ><input name="config[]" type="checkbox" id="adminmanage"  value="adminmanage">
        <label for="adminmanage">管理员管理</label>
        <input name="config[]" type="checkbox" id="admingroup"  value="admingroup">
        <label for="admingroup">管理员分组管理</label></td>
    </tr>
    <tr> 
      <td align="right" class="border"  ><input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll">全部选择</label>
        <br>
(再次点击可以取消全选) </td>
      <td class="border"  > <input name="action" type="hidden" id="action" value="add"> 
        <input name="Add" type="submit" class="buttons" value=" 添 加 "> </td>
    </tr>
  </table>
</form>
</body>
</html>