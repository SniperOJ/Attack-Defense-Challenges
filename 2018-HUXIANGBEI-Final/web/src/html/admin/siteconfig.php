<?php
error_reporting(0); //加新参数后配置文件中，不用加同名空参数了
define ("checkadminlogin",1);//当关网站时，如果是管理员登录时使链接正常打开。
include("admin.php");
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">	
function checkform(){
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.form1.showadvdate.value)) {
alert("只能填数字！"); 
document.form1.showadvdate.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_reg.value)) {
alert("只能填数字！"); 
document.form1.jf_reg.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_login.value)) {
alert("只能填数字！"); 
document.form1.jf_login.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_addreginfo.value)) {
alert("只能填数字！"); 
document.form1.jf_addreginfo.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_lookmessage.value)) {
alert("只能填数字！"); 
document.form1.jf_lookmessage.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_look_dl.value)) {
alert("只能填数字！"); 
document.form1.jf_look_dl.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_set_adv.value)) {
alert("只能填数字！"); 
document.form1.jf_set_adv.focus(); 
return false; 
} 
if(!strP.test(document.form1.jf_set_elite.value)) {
alert("只能填数字！"); 
document.form1.jf_set_elite.focus(); 
return false; 
} 
if(!strP.test(document.form1.maximgsize.value)) {
alert("只能填数字！"); 
document.form1.maximgsize.focus(); 
return false; 
} 
if(!strP.test(document.form1.maxflvsize.value)) {
alert("只能填数字！"); 
document.form1.maxflvsize.focus(); 
return false; 
} 
if(!strP.test(document.form1.pagesize_qt.value)) {
alert("只能填数字！"); 
document.form1.pagesize_qt.focus(); 
return false; 
} 
if(!strP.test(document.form1.pagesize_ht.value)) {
alert("只能填数字！"); 
document.form1.pagesize_ht.focus(); 
return false; 
} 
if(!strP.test(document.form1.liuyanysnum.value)) {
alert("只能填数字！"); 
document.form1.liuyanysnum.focus(); 
return false; 
} 
if(!strP.test(document.form1.cache_update_time.value)) {
alert("只能填数字！"); 
document.form1.cache_update_time.focus(); 
return false; 
}
if(!strP.test(document.form1.html_update_time.value)) {
alert("只能填数字！"); 
document.form1.html_update_time.focus(); 
return false; 
}  
}
</script>
</head>
<body>
<div class="admintitle">网站设置</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr> 
    <td bgcolor="#FFFFFF" style="color:#999999"><a href="#SiteInfo">基本信息</a> 
      | <a href="#siteskin">网站风格</a> | <a href="#SiteOption">功能参数</a> | <a href="#SiteOpen">运行状态</a> 
      | <a href="#stopwords">限制字符</a> |  <a href="wjtset.php">文 件 头</a> | <a href="#sendmail">邮件设置</a> 
      | <a href="#sendSms">手机短信</a>  <br> <a href="#qiangad">广告设置</a> | <a href="#userjf">积分功能</a> | <a href="#UpFile">上传文件</a> 
      | <a href="#addimage">添加水印</a> | <a href="#alipay_set">支付接口</a> 
      | <a href="#qqlogin_set">QQ登录</a> | <a href="#bbs_set">整合Discuz!论坛</a></td>
  </tr>
</table>
<?php
if (isset($_POST["action"])){
$action=$_POST["action"];
}else{
$action="";
}
if ($action=="saveconfig") {
checkadminisdo("siteconfig");
saveconfig();
}else{
showconfig();
}

function showconfig(){
?>
<form method="POST" action="?" id="form1" name="form1" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td colspan="2" class="admintitle2"><a name="SiteInfo" id="SiteInfo"></a>网站基本信息设置</td>
    </tr>
    <tr> 
      <td width="30%" align="right" class="border">网站名称</td>
      <td width="70%" class="border"> <input name="sitename" type="text" id="sitename" value="<?php echo sitename?>" size="50" maxlength="255"> 
        <input name="sqldb" type="hidden" id="sqldb" value="<?php echo sqldb?>"> 
        <input name="sqluser" type="hidden" id="sqluser" value="<?php echo sqluser?>"> 
        <input name="sqlpwd" type="hidden" id="sqlpwd" value="<?php echo sqlpwd?>"> 
        <input name="sqlhost" type="hidden" id="sqlhost" value="<?php echo sqlhost?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">网站地址</td>
      <td width="70%" class="border"> <input name="siteurl" type="text" id="siteurl" value="<?php echo addhttp(CutFenGeXian(siteurl,'/'))?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">网站Logo地址</td>
      <td width="70%" class="border"> <input name="img" type="text" id="img" value="<?php echo logourl?>" size="50" maxlength="255">
      (提示：Logo地址前面要加上网址) 
 <table border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
              <?php 
				  echo "<img src='".logourl."' border=0 width=200 /><br>点击可更换图片";
				  ?>            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">备案号</td>
      <td width="70%" class="border"><input name="icp" type="text" id="icp" value="<?php echo icp?>" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">网站联系E-mail</td>
      <td width="70%" class="border"> <input name="webmasteremail" type="text" id="webmasteremail" value="<?php echo webmasteremail?>" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">电话</td>
      <td class="border"> <input name="kftel" type="text" id="kftel" value="<?php echo kftel?>" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">手机</td>
      <td class="border"><input name="kfmobile" type="text" id="kfmobile" value="<?php echo kfmobile?>" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">客服QQ</td>
      <td class="border"><input name="kfqq" type="text" value="<?php echo kfqq?>" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">网站统计代码</td>
      <td class="border"><input name="sitecount" type="text" id="sitecount" value="<?php echo sitecount?>" size="70" maxlength="1000"></td>
    </tr>
    <tr>
      <td align="right" class="border">招商显示为</td>
      <td class="border"><input name="channelzs" type="text" id="channelzs" value="<?php echo channelzs?>" size="20" maxlength="20">
        (可设为供应)</td>
    </tr>
    <tr>
      <td align="right" class="border">代理显示为</td>
      <td class="border"><input name="channeldl" type="text" id="channeldl" value="<?php echo channeldl?>" size="20" maxlength="20">
(可设为求购)</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="submit2" type="submit" class="buttons" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="SiteOption"></a>网站功能参数设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">展厅二级域名</td>
      <td class="border"> <label><input type="radio" name="sdomain" id="sdomainY" value="Yes" <?php if ( sdomain=="Yes" ){ echo  "checked";}?>>
       开 </label>
         <label> <input type="radio" name="sdomain" id="sdomainN" value="No" <?php if ( sdomain=="No" ){ echo  "checked";}?>>
        关</label></td>
    </tr>
    <tr> 
      <td align="right" class="border">伪静态</td>
      <td class="border"> <label><input type="radio" name="whtml" value="Yes" <?php if ( whtml=="Yes" ){ echo  "checked";}?>>
        开  </label>
         <label><input type="radio" name="whtml" value="No" <?php if ( whtml=="No" ){ echo  "checked";}?>>
        关 </label></td>
    </tr>
    <tr>
      <td align="right" class="border">防SQL注入功能</td>
      <td class="border"> <label><input type="radio" name="checksqlin" value="Yes" <?php if ( checksqlin=="Yes" ){ echo  "checked";}?>>
        开 </label>
        <label> <input type="radio" name="checksqlin" value="No" <?php if ( checksqlin=="No" ){ echo  "checked";}?>>
        关 </label></td>
    </tr>
    <tr> 
      <td align="right" class="border">是否允许重复注册用户</td>
      <td class="border"> <label><input type="radio" name="allowrepeatreg" value="Yes" <?php if ( allowrepeatreg=="Yes" ){ echo  "checked";}?>>
        是  </label>
           <label><input type="radio" name="allowrepeatreg" value="No" <?php if ( allowrepeatreg=="No" ){ echo  "checked";}?>>
          否 </label></td>
    </tr>
    <tr> 
      <td align="right" class="border">让未审核的注册用户发布信息</td>
      <td class="border">  <label><input type="radio" name="isaddinfo" value="Yes" <?php if ( isaddinfo=="Yes" ){ echo  "checked";}?>>
        开 </label> 
         <label><input type="radio" name="isaddinfo" value="No" <?php if ( isaddinfo=="No" ){ echo  "checked";}?>>
        关 </label></td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channeldl?>商信息库的联系方式</td>
      <td class="border">  <label><input type="radio" name="isshowcontact" value="Yes" <?php if ( isshowcontact=="Yes" ){ echo  "checked";}?>>
        开（即非注册用户可看）  </label>
         <label><input type="radio" name="isshowcontact" value="No" <?php if ( isshowcontact=="No" ){ echo  "checked";}?>>
        关 </label></td>
    </tr>
    <tr>
      <td align="right" class="border"><?php echo channelzs?>小类别设为</td>
      <td class="border"> <label><input type="radio" name="zsclass_isradio" value="Yes" <?php if ( zsclass_isradio=="Yes" ){ echo  "checked";}?>>
        单选 </label>
        <label> <input type="radio" name="zsclass_isradio" value="No" <?php if ( zsclass_isradio=="No" ){ echo  "checked";}?>>
        多选 </label> </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channelzs?>产品信息内显示<?php echo channeldl?>留言条数</td>
      <td class="border"> <label><input type="radio" name="showdlinzs" value="Yes" <?php if ( showdlinzs=="Yes" ){ echo  "checked";}?>>
        开  </label>
        <label><input type="radio" name="showdlinzs" value="No" <?php if ( showdlinzs=="No" ){ echo  "checked";}?>>
        关（<span style="color:#FF0000"><?php echo channelzs.channeldl?>信息量大时建议关闭此功能，避免联表查寻导致<?php echo channelzs?>列表页打开太慢</span>）
		 </label></td>
    </tr>
    <tr>
      <td align="right" class="border">网站缓存更新时间</td>
      <td class="border"><input name="cache_update_time" type="text" id="cache_update_time" value="<?php echo cache_update_time?>" size="4" maxlength="4">
        天（关闭缓存功能设为0，<span style="color:#FF0000">信息量大时建议开启缓存功能，避免页面打开太慢。</span>）</td>
    </tr>
    <tr>
      <td align="right" class="border">静态页更新时间</td>
      <td class="border"><input name="html_update_time" type="text" id="html_update_time" value="<?php echo html_update_time?>" size="4" maxlength="4">
        天（关闭静态页功能设为0，<span style="color:#FF0000">信息量大时建议开启缓存功能，避免页面打开太慢。</span>）</td>
    </tr>
    <tr>
      <td align="right" class="border">发给VIP会员的<?php echo channeldl?>留言延时显示在代理库</td>
      <td class="border"><input name="liuyanysnum" type="text" id="liuyanysnum" value="<?php echo liuyanysnum?>" size="4" maxlength="4">
        天（如不延时设为0，<span style="color:#FF0000"><?php echo channeldl?>信息量大时建议设为0关闭此功能，避免<?php echo channeldl?>列表页打开太慢</span>）</td>
    </tr>
    <tr> 
      <td align="right" class="border">个人用户权限管理<a name="usergr_power"></a></td>
      <td class="border">
	  <input name="usergr_power[]" type="checkbox" id="zs" value="zs" <?php if(str_is_inarr(usergr_power,'zs')=='yes'){echo "checked";}?>>
        <label for="zs">发<?php echo channelzs?></label>
        <input name="usergr_power[]" type="checkbox" id="dl" value="dl" <?php if(str_is_inarr(usergr_power,'dl')=='yes'){ echo"checked";}?>>
<label for="dl">发<?php echo channeldl?></label>
        <input name="usergr_power[]" type="checkbox" id="zh" value="zh" <?php if(str_is_inarr(usergr_power,'zh')=='yes') { echo"checked";}?>>
        <label for="zh"> 发展会</label>
		 <input name="usergr_power[]" type="checkbox" id="wangkan" value="wangkan" <?php if(str_is_inarr(usergr_power,'wangkan')=='yes') { echo"checked";}?>>
        <label for="wangkan"> 发网刊</label>
        <input name="usergr_power[]" type="checkbox"  id="zx" value="zx" <?php if(str_is_inarr(usergr_power,'zx')=='yes') { echo"checked";}?>>
<label for="zx"> 发资讯</label>
<input name="usergr_power[]" type="checkbox" id="pp" value="pp" <?php if(str_is_inarr(usergr_power,'pp')=='yes') { echo"checked";}?>>
<label for="pp"> 发品牌 </label>
        <input name="usergr_power[]" type="checkbox" id="special" value="special" <?php if(str_is_inarr(usergr_power,'special')=='yes') { echo"checked";}?>>
        <label for="special">发专题 </label>
        <input name="usergr_power[]" type="checkbox" id="job" value="job"  <?php if(str_is_inarr(usergr_power,'job')=='yes') { echo"checked";}?>>
<label for="job"> 发招聘 
<input name="usergr_power[]" type="checkbox" id="zt" value="zt"  <?php if(str_is_inarr(usergr_power,'zt')=='yes') { echo"checked";}?>>
<label for="zt">显示展厅 </label></td>
    </tr>
    <tr>
      <td align="right" class="border">功能模块开关</td>
      <td class="border"><label> <input name="channel[]" type="checkbox" value="zh" <?php if(str_is_inarr(channel,'zh')=='yes') { echo"checked";}?>>
          展会</label>
         <label> <input name="channel[]" type="checkbox" value="wangkan" <?php if(str_is_inarr(channel,'wangkan')=='yes') { echo"checked";}?>>
           网刊</label>
          <label> <input name="channel[]" type="checkbox"  value="zx" <?php if(str_is_inarr(channel,'zx')=='yes') { echo"checked";}?>>
          资讯</label>
          <label><input name="channel[]" type="checkbox"  value="pp" <?php if(str_is_inarr(channel,'pp')=='yes') { echo"checked";}?>>
           品牌 </label>
          <label><input name="channel[]" type="checkbox" value="special" <?php if(str_is_inarr(channel,'special')=='yes') { echo"checked";}?>>
          专题</label>
          <label><input name="channel[]" type="checkbox" value="job"  <?php if(str_is_inarr(channel,'job')=='yes') { echo"checked";}?>>
          
        招聘</label>
        <label><input name="channel[]" type="checkbox"  value="baojia"  <?php if(str_is_inarr(channel,'baojia')=='yes') { echo"checked";}?>>
        行情 </label>
		 <label><input name="channel[]" type="checkbox"  value="ask"  <?php if(str_is_inarr(channel,'ask')=='yes') { echo"checked";}?>>
        问答 </label>
		</td>
    </tr>
    <tr>
      <td align="right" class="border">项目更多属性设置</td>
      <td class="border"><input name="shuxing_name" type="text" id="shuxing_name" value="<?php echo shuxing_name?>" size="50" maxlength="255">
        （以“|”分开，前台模板中以{#shuxing0}，{#shuxing1}，{#shuxing2}...，这样的标签做调用）</td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave34" type="submit" class="buttons" id="cmdSave34" value="保存设置"></td>
    </tr>
    <tr>
      <td colspan="2" class="admintitle2"><a name="SiteOpen" id="SiteOpen"></a>网站运行状态设置</td>
    </tr>
    <tr>
      <td align="right" class="border">网站运行状态</td>
      <td class="border"><input type="radio" name="opensite" value="Yes" <?php if ( opensite=="Yes" ){ echo  "checked";}?>>
        开
        <input type="radio" name="opensite" value="No" <?php if ( opensite=="No" ){ echo  "checked";}?>>
        关（站点关闭之后,后台管理员仍然可以登录）</td>
    </tr>
    <tr>
      <td align="right" class="border">关闭网站原因</td>
      <td class="border"><input name="showwordwhenclose" type="text" id="showwordwhenclose" value="<?php echo showwordwhenclose?>" size="50"></td>
    </tr>
    <tr>
      <td align="right" class="border">用户注册</td>
      <td class="border"><input type="radio" name="openuserreg" value="Yes" <?php if ( openuserreg=="Yes" ){ echo  "checked";}?>>
        开
        <input type="radio" name="openuserreg" value="No" <?php if ( openuserreg=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr>
      <td align="right" class="border">关闭用户注册原因</td>
      <td class="border"><input name="openuserregwhy" type="text" id="openuserregwhy" value="<?php echo openuserregwhy?>" size="50"></td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" class="buttons" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" align="right" class="admintitle2"><a name="siteskin" id="siteskin"></a>网站风格      </td>
    </tr>
    <tr> 
      <td align="right" class="border">网站电脑版模板</td>
      <td class="border"><select name="siteskin" id="siteskin">
          <?php
$dir = opendir("../template/");
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && $file!='test.txt' && strpos($file,".zip")==false && strpos($file,".rar")==false ) { //不读取. ..
	?>
	<option value="<?php echo $file?>" <?php if ( siteskin==$file){ echo  "selected";}?>><?php echo $file?></option>
          <?php
}
}
closedir($dir);
?>
        </select></td>
    </tr>
    <tr>
      <td align="right" class="border">网站手机版模板</td>
      <td class="border"><select name="siteskin_mobile" id="siteskin_mobile">
          <?php
$dir = opendir("../template/mobile");
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && $file!='test.txt' && strpos($file,".zip")==false && strpos($file,".rar")==false ) { //不读取. ..
	?>
          <option value="<?php echo $file?>" <?php if (siteskin_mobile==$file){ echo  "selected";}?>><?php echo $file?></option>
          <?php
}
}
closedir($dir);
?>
      </select></td>
    </tr>
    <tr>
      <td align="right" class="border">用户中心样式</td>
      <td class="border"><select name="siteskin_usercenter" id="siteskin_usercenter">
          <?php
$dir = opendir("../user/style");
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && $file!='test.txt' && strpos($file,".zip")==false && strpos($file,".rar")==false ) { //不读取. ..
	?>
          <option value="<?php echo $file?>" <?php if (siteskin_usercenter==$file){ echo  "selected";}?>><?php echo $file?></option>
          <?php
}
}
closedir($dir);
?>
      </select></td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo channelzs?>列表页默认显示格式</td>
      <td class="border"><select name="zsliststyle">
          <option value="list" <?php if ( zsliststyle=="list" ){ echo  "selected";}?>>图文显示</option>
          <option value="window" <?php if ( zsliststyle=="window" ){ echo  "selected";}?>>橱窗显示</option>
          <option value="text" <?php if ( zsliststyle=="text" ){ echo  "selected";}?>>文字显示</option>
        </select></td>
    </tr>
    <tr> 
      <td align="right" class="border">网站前台列表页每页显示信息数</td>
      <td class="border"><input name="pagesize_qt" type="text" id="pagesize_qt" value="<?php echo pagesize_qt?>" size="4" maxlength="10">
        条（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">管理员后台列表页每页显示信息数</td>
      <td class="border"><input name="pagesize_ht" type="text" id="pagesize_ht" value="<?php echo pagesize_ht?>" size="4" maxlength="10">
        条（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave342" type="submit" class="buttons" id="cmdSave342" value="保存设置"></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="stopwords" id="stopwords"></a>限制字符设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">公司名称中<strong>必填</strong>行业性关键字</td>
      <td class="border"><input name="wordsincomane" type="text" id="wordsincomane" value="<?php echo wordsincomane?>" size="30" maxlength="255"> 
        &nbsp;（用“|”分开，关键字最大长度为4个字符） </td>
    </tr>
    <tr> 
      <td align="right" class="border">公司名称中<strong>必填</strong>类型性关键字</td>
      <td class="border"><input name="lastwordsincomane" type="text" id="lastwordsincomane" value="<?php echo lastwordsincomane?>" size="30" maxlength="255"> 
        &nbsp;（用“|”分开） </td>
    </tr>
    <tr> 
      <td align="right" class="border">公司名称中<strong>禁用</strong>关键字</td>
      <td class="border"><input name="nowordsincomane" type="text" id="nowordsincomane" value="<?php echo nowordsincomane?>" size="30" maxlength="255"> 
        &nbsp;（用“|”分开） </td>
    </tr>
    <tr> 
      <td align="right" class="border">发布信息<strong>禁用</strong>关键字</td>
      <td class="border"><input name="stopwords" type="text" id="stopwords" value="<?php echo stopwords?>" size="30" maxlength="255">
        （用“|”分开） </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave3" type="submit" class="buttons" id="cmdSave3" value="保存设置"></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="qiangad" id="qiangad"></a>广告位设置</td>
    </tr>
	 <tr> 
      <td align="right" class="border">到期的广告是否还让显示</td>
      <td class="border"> <input type="radio" name="isshowad_when_timeend" value="Yes" <?php if ( isshowad_when_timeend=="Yes" ){ echo  "checked";}?>>
      显示
        <input type="radio" name="isshowad_when_timeend" value="No" <?php if ( isshowad_when_timeend=="No" ){ echo  "checked";}?>>
        不显示</td>
    </tr>
	 <tr> 
      <td align="right" class="border">到期的广告前台显示语为</td>
      <td class="border"><input name="showadtext" type="text" id="showadtext" value="<?php echo showadtext?>" size="30"></td>
    </tr>
    <tr> 
      <td align="right" class="border">抢占广告位功能</td>
      <td class="border"> <input type="radio" name="qiangad" value="Yes" <?php if ( qiangad=="Yes" ){ echo  "checked";}?>>
        开 
          <input type="radio" name="qiangad" value="No" <?php if ( qiangad=="No" ){ echo  "checked";}?>>
          关</td>
    </tr>
    <tr> 
      <td align="right" class="border">广告位置占用时间</td>
      <td class="border"> <input name="showadvdate" type="text" id="showadvdate" value="<?php echo showadvdate?>" size="4" maxlength="10">
        天（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">对联广告</td>
      <td class="border"> <input type="radio" name="duilianadisopen" value="Yes" <?php if ( duilianadisopen=="Yes" ){ echo  "checked";}?>>
        开 
        <input type="radio" name="duilianadisopen" value="No" <?php if ( duilianadisopen=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">漂浮广告</td>
      <td class="border"> <input type="radio" name="flyadisopen" value="Yes" <?php if ( flyadisopen=="Yes" ){ echo  "checked";}?>>
        开 
        <input type="radio" name="flyadisopen" value="No" <?php if ( flyadisopen=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave33" type="submit" class="buttons" id="cmdSave33" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="sendmail" id="sendmail"></a>在线发邮件设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">用来发送邮件的SMTP服务器</td>
      <td class="border"><input name="smtpserver" type="text"  value="<?php echo smtpserver?>" maxlength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">发件人Email</td>
      <td class="border"> <input name="sender" type="text" value="<?php echo sender?>" maxlength="50">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">发件人Email密码</td>
      <td class="border"> <input name="smtppwd" type="password" id="smtppwd" value="<?php echo smtppwd?>">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">有<?php echo channeldl?>留言时发提示邮件</td>
      <td class="border"><input type="radio" name="whendlsave" value="Yes" <?php if ( whendlsave=="Yes" ){ echo  "checked";}?>>
        开 
          <input type="radio" name="whendlsave" value="No" <?php if ( whendlsave=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">新用户注册时发提示邮件</td>
      <td class="border"><input type="radio" name="whenuserreg" value="Yes" <?php if ( whenuserreg=="Yes" ){ echo  "checked";}?>>
        开 
          <input type="radio" name="whenuserreg" value="No" <?php if ( whenuserreg=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">用户更改密码时发提示邮件</td>
      <td class="border"><input type="radio" name="whenmodifypassword" value="Yes" <?php if ( whenmodifypassword=="Yes" ){ echo  "checked";}?>>
        开 
          <input type="radio" name="whenmodifypassword" value="No" <?php if ( whenmodifypassword=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr>
      <td align="right" class="border">用户注册时邮箱验证功能</td>
      <td class="border"><input type="radio" name="checkistrueemail"  value="Yes" <?php if ( checkistrueemail=="Yes" ){ echo  "checked";}?>>
        开
        <input type="radio" name="checkistrueemail" value="No" <?php if ( checkistrueemail=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave5" type="submit" class="buttons" id="cmdSave5" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" align="right" class="admintitle2"><a name="sendSms" id="sendSms"></a>在线发手机短信设置</td>
    </tr>
    <tr>
      <td align="right" class="border">发手机短息功能</td>
      <td class="border"><input type="radio" name="sendsms" value="Yes" <?php if ( sendsms=="Yes" ){ echo  "checked";}?>>
        开
        <input type="radio" name="sendsms" value="No" <?php if ( sendsms=="No" ){ echo  "checked";}?>>
        关</td>
    </tr>
    <tr> 
      <td align="right" class="border">用户名：</td>
      <td class="border"><input name="smsusername" type="text" id="smsusername" value="<?php echo smsusername?>" maxlength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">密码：</td>
      <td class="border"><input name="smsuserpass" type="password" id="smsuserpass" value="<?php echo smsuserpass?>" maxlength="50">      </td>
    </tr>
    <tr>
      <td align="right" class="border">apikey：</td>
      <td class="border"><input name="apikey_mobile_msg" type="text" id="apikey_mobile_msg" value="<?php echo apikey_mobile_msg?>" maxlength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">帐号注册地址：</td>
      <td class="border"><a href="http://www.5c.com.cn" target="_blank">http://www.5c.com.cn</a></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave52" type="submit" class="buttons" id="cmdSave52" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="userjf" id="userjf"></a>积分功能设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">积分功能</td>
      <td class="border"><input type="radio" name="jifen" id="jifenY"  value="Yes" <?php if ( jifen=="Yes" ){ echo  "checked";}?>>
        <label for='jifenY'>开</label> 
          <input type="radio" name="jifen" id="jifenN"  value="No" <?php if ( jifen=="No" ){ echo  "checked";}?>>
        <label for='jifenN'>关</label></td>
    </tr>
    <tr>
      <td align="right" class="border">1元等于</td>
      <td class="border"><select name="jifen_bilu" id="jifen_bilu">
        <option value="1" <?php if ( jifen_bilu==1 ){ echo  "selected";}?>>1积分</option>
        <option value="10" <?php if ( jifen_bilu==10 ){ echo  "selected";}?>>10积分</option>
        <option value="100" <?php if ( jifen_bilu==100 ){ echo  "selected";}?>>100积分</option>
                        </select></td>
    </tr>
    <tr> 
      <td align="right" class="border">新用户注册时<strong>获取</strong></td>
      <td class="border"><input name="jf_reg" type="text" id="jf_reg" value="<?php echo jf_reg?>" size="10" maxlength="10">
        积分（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">登录网站<strong>获取</strong></td>
      <td class="border"> <input name="jf_login" type="text" id="jf_login" value="<?php echo jf_login?>" size="10" maxlength="10">
        积分（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">完善注册信息<strong>获取</strong></td>
      <td class="border"> <input name="jf_addreginfo" type="text" id="jf_addreginfo" value="<?php echo jf_addreginfo?>" size="10" maxlength="10">
        积分（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">查看<?php echo channeldl?>商留言<strong>扣除</strong></td>
      <td class="border"> <input name="jf_lookmessage" type="text" id="jf_lookmessage" value="<?php echo jf_lookmessage?>" size="10" maxlength="10">
      积分（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">查看<?php echo channeldl?>商信息库<strong>扣除</strong></td>
      <td class="border"><input name="jf_look_dl" type="text" id="jf_look_dl" value="<?php echo jf_look_dl?>" size="10" maxlength="10">
        积分（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">抢占首页广告位<strong>扣除</strong></td>
      <td class="border"><input name="jf_set_adv" type="text" id="jf_set_adv" value="<?php echo jf_set_adv?>" size="10" maxlength="10">
        积分（填数字）</td>
    </tr>
    <tr>
      <td align="right" class="border">中标的信息<strong>扣除</strong></td>
      <td class="border"><input name="jf_set_elite" type="text" id="jf_set_elite" value="<?php echo jf_set_elite?>" size="10" maxlength="10">
      积分/天（填数字）</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave2" type="submit" class="buttons" id="cmdSave2" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="UpFile" id="UpFile"></a>上传文件设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">图片文件大小限制<br> </td>
      <td class="border"> <input name="maximgsize" type="text" id="maximgsize" value="<?php echo maximgsize?>" size="6" maxlength="5">
        K　（建议不要超过1024K，以免影响服务器性能）</td>
    </tr>
    <tr> 
      <td align="right" class="border">视频文件大小限制<br> </td>
      <td class="border"> <input name="maxflvsize" type="text" id="maxflvsize" value="<?php echo maxflvsize?>" size="6" maxlength="5">
        M　（最大能传8M）</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave22" type="submit" class="buttons" id="cmdSave22" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" align="right" class="admintitle2"><a name="addimage" id="addimage"></a>添加水印功能设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">水印功能</td>
      <td class="border"> <input name="shuiyin" id="shuiyinY" type="radio" value="Yes"  <?php if ( shuiyin=="Yes" ){ echo  "checked";}?>>
        <label for='shuiyinY'>开</label> 
        <input type="radio" name="shuiyin"  id="shuiyinN" value="No" <?php if ( shuiyin=="No" ){ echo  "checked";}?>>
        <label for='shuiyinN'>关</label></td>
    </tr>
    <tr> 
      <td align="right" class="border">水印位置</td>
      <td class="border"> <select name="addimgXY" id="AddImgXY">
          <option value="left" <?php if ( addimgXY=="left" ){ echo  "selected";}?>>左上方</option>
          <option value="center" <?php if ( addimgXY=="center" ){ echo  "selected";}?>>中间</option>
          <option value="right" <?php if ( addimgXY=="right" ){ echo  "selected";}?>>右下方</option>
        </select></td>
    </tr>
    <tr> 
      <td align="right" class="border">水印图片地址</td>
      <td class="border"><a href="/image/sy.png"></a>
	  <input name="syurl" type="text" id="syurl" value="<?php echo syurl?>" size="50" maxlength="255">
	  （必须为png格式的图片，地址前不能加 /）
	   <script type="text/javascript">
function valueFormOpenwindow2(value){ //子页面引用此函数传回value值,上传图片用
//alert(value);
document.getElementById("syurl").value=value;
document.getElementById("syimg").innerHTML="<img src='"+value+"' width=120>";
}
</script>
        <table border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr>
            <td align="center" bgcolor="#FFFFFF" id="syimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1&imgid=2',400,300)">
			<?php echo "<img src='/".syurl."' border=0 width=200 /><br>点击可更换图片";?>			 </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave" type="submit" class="buttons" id="cmdSave6" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="alipay_set" id="alipay_set"></a>在线支付接口设置</td>
    </tr>
    <tr> 
      <td colspan="2" class="border2">支付宝 <a href="https://b.alipay.com/order/productDetail.htm?productId=2011060800327555" target="_blank">审请</a></td>
    </tr>
    <tr> 
      <td align="right" class="border">合作者身份ID</td>
      <td class="border"><input name="alipay_partner" type="text" id="alipay_partner" value="<?php echo alipay_partner?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">安全检验码</td>
      <td class="border"><input name="alipay_key" type="text" id="alipay_key" value="<?php echo alipay_key?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">签约支付宝账号或卖家支付宝帐户</td>
      <td class="border"><input name="alipay_seller_email" type="text" id="alipay_seller_email" value="<?php echo alipay_seller_email?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp; </td>
      <td class="border"> <input name="cmdSave4" type="submit" class="buttons" id="cmdSave" value="保存设置" ></td>
    </tr>
    <tr> 
      <td colspan="2" class="border2">财富通 <a href="http://mch.tenpay.com/market/opentrans_immediately.shtml" target="_blank">审请</a></td>
    </tr>
    <tr> 
      <td align="right" class="border">商户号</td>
      <td class="border"><input name="tenpay_bargainor_id" type="text" id="tenpay_bargainor_id" value="<?php echo tenpay_bargainor_id?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">密钥</td>
      <td class="border"><input name="tenpay_key" type="text" id="tenpay_key" value="<?php echo tenpay_key?>" size="40" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave42" type="submit" class="buttons" id="cmdSave42" value="保存设置" >      </td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><a name="qqlogin_set" id="qqlogin_set"></a>QQ登录设置</td>
    </tr>
    <tr> 
      <td colspan="2" class="border2">第一步：<a href="http://connect.opensns.qq.com/apply" target="_blank">审请接入</a>
          ；第二步：<a href="qqlogin_set.php">填写接入信息</a></td>
    </tr>
    <tr> 
      <td align="right" class="border">QQ登录</td>
      <td class="border"> <input type="radio" name="qqlogin" id="qqloginY" value="Yes" <?php if ( qqlogin=="Yes" ){ echo  "checked";}?>>
        <label for='qqloginY'>开</label> 
        <input type="radio" name="qqlogin" id="qqloginN" value="No" <?php if ( qqlogin=="No" ){ echo  "checked";}?>>
        <label for='qqloginN'>关</label>  </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave422" type="submit" class="buttons" id="cmdSave422" value="保存设置" ></td>
    </tr>
    <tr>
      <td colspan="2" class="admintitle2"><a name="bbs_set" id="bbs_set"></a>整合 Discuz! 论坛</td>
    </tr>
    <tr>
      <td colspan="2" class="border2">第一步：进入<a href="http://www.comsenz.com/products/ucenter" target="_blank">Ucenter</a> 管理后台，添加应用 ；第二步：<a href="ucenter_config.php">填写接入信息</a>；第三步：返回Ucenter管理后台查看通讯是否成功，如不成功，则重查所填信息是否正确。</td>
    </tr>
    <tr>
      <td align="right" class="border">论坛整合功能</td>
      <td class="border"><input type="radio" name="bbs_set" id="bbs_setY" value="Yes" <?php if ( bbs_set=="Yes" ){ echo  "checked";}?>>
<label for='bbs_setY'>开</label>
  <input type="radio" name="bbs_set" id="bbs_setN" value="No" <?php if ( bbs_set=="No" ){ echo  "checked";}?>>
<label for='bbs_setN'>关</label></td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="cmdSave4222" type="submit" class="buttons" id="cmdSave4222" value="保存设置" >
        <input name="action" type="hidden" id="action" value="saveconfig"></td>
    </tr>
  </table>
<?php
}
?>
</form>
</body>
</html>
<?php
function SaveConfig(){
$usergr_power="";
if (isset($_POST['usergr_power'])){
foreach($_POST['usergr_power'] as $i){$usergr_power .=$i."#";}
$usergr_power=substr($usergr_power,0,strlen($usergr_power)-1);//去除最后面的"#"
}
$channel="";
if (isset($_POST['channel'])){
foreach($_POST['channel'] as $i){$channel .=$i."#";}
$channel=substr($channel,0,strlen($channel)-1);//去除最后面的"#"
}
	$fpath="../inc/config.php";
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	$fcontent="<" . "?php\r\n";
	$fcontent=$fcontent. "define('sqldb','".trim($_POST['sqldb'])."');//数据库名\r\n";
	$fcontent=$fcontent. "define('sqluser','".trim($_POST['sqluser'])."');//用户名\r\n";
	$fcontent=$fcontent. "define('sqlpwd','".html_entity_decode(trim($_POST['sqlpwd']))."');//密码\r\n";//html_entity_decode针对&被转变成&amp;
	$fcontent=$fcontent. "define('sqlhost','".trim($_POST['sqlhost'])."');//连接服务器,本机填(local)，外地填IP地址\r\n";
	$fcontent=$fcontent. "define('zzcmsver','Powered By <a target=_blank style=font-weight:bold href=http://www.zzcms.net><font color=#FF6600 face=Arial>ZZ</font><font color=#025BAD face=Arial>CMS8.1</font></a>');//版本\r\n";
	$fcontent=$fcontent. "define('sitename','". trim($_POST['sitename'])."') ;//网站名称\r\n";
	$fcontent=$fcontent. "define('siteurl','". trim($_POST['siteurl'])."') ;//网站地址\r\n";
	$fcontent=$fcontent. "define('logourl','". trim($_POST['img'])."') ;//Logo地址\r\n";
	$fcontent=$fcontent. "define('icp','". trim($_POST['icp'])."') ;//icp备案号\r\n";
	$fcontent=$fcontent. "define('webmasteremail','". trim($_POST['webmasteremail'])."') ;//站长信箱\r\n";
	$fcontent=$fcontent. "define('kftel','". trim($_POST['kftel'])."') ;//联系电话\r\n";
	$fcontent=$fcontent. "define('kfmobile','". trim($_POST['kfmobile'])."') ;//手机\r\n";
	$fcontent=$fcontent. "define('kfqq','". trim($_POST['kfqq'])."') ;//QQ\r\n";
	$fcontent=$fcontent. "define('sitecount','". str_replace('"','',str_replace("'",'',stripfxg(trim($_POST['sitecount']))))."') ;//网站统计代码\r\n";
	//$fcontent=$fcontent. "define('sitecount','". htmlspecialchars_decode(trim($_POST['sitecount']))."') ;//网站统计代码\r\n";
	$fcontent=$fcontent. "define('channelzs','". trim($_POST['channelzs'])."') ;//招商显示为\r\n";
	$fcontent=$fcontent. "define('channeldl','". trim($_POST['channeldl'])."') ;//代理显示为\r\n";
	$fcontent=$fcontent. "define('opensite','". trim($_POST['opensite'])."') ;//网站运行状态\r\n";
	$fcontent=$fcontent. "define('showwordwhenclose','". trim($_POST['showwordwhenclose'])."') ;//关闭网站原因\r\n";
	$fcontent=$fcontent. "define('openuserreg','". trim($_POST['openuserreg'])."') ;//注册用户状态\r\n";
	$fcontent=$fcontent. "define('openuserregwhy','". trim($_POST['openuserregwhy'])."') ;//关闭注册用户原因\r\n";		
	$fcontent=$fcontent. "define('isaddinfo','". trim($_POST['isaddinfo'])."') ;//是否允许未审核的用户发布信息\r\n";		
	$fcontent=$fcontent. "define('pagesize_ht','" . trim($_POST['pagesize_ht']) ."');//管理员后台每页显示信息数\r\n";
	$fcontent=$fcontent. "define('pagesize_qt','". trim($_POST['pagesize_qt']) . "');//前台每页显示信息数\r\n";		
	$fcontent=$fcontent. "define('whendlsave','". trim($_POST['whendlsave'])."') ;//当有代理或求购留言是否打开在线发邮件功能\r\n";	
	$fcontent=$fcontent. "define('whenuserreg','". trim($_POST['whenuserreg'])."') ;//当新用户注册时是否打开在线发邮件功能\r\n";
	$fcontent=$fcontent. "define('whenmodifypassword','". trim($_POST['whenmodifypassword'])."') ;//当用户修改密码时是否开发在线发邮件功能\r\n";
	$fcontent=$fcontent. "define('smtpserver','". trim($_POST['smtpserver'])."') ;//邮件服务器\r\n";
	$fcontent=$fcontent. "define('sender','". trim($_POST['sender'])."') ;//发送邮件的地址\r\n";	
	$fcontent=$fcontent. "define('smtppwd','". trim($_POST['smtppwd'])."') ;//email密码\r\n";	
	$fcontent=$fcontent. "define('sendsms','". trim($_POST['sendsms'])."') ;//发手机短信开关\r\n";
	$fcontent=$fcontent. "define('smsusername','". trim($_POST['smsusername'])."') ;//SMS用户名\r\n";	
	$fcontent=$fcontent. "define('smsuserpass','". trim($_POST['smsuserpass'])."') ;//SMS密码\r\n";		
	$fcontent=$fcontent. "define('apikey_mobile_msg','". trim($_POST['apikey_mobile_msg'])."') ;//apikey_mobile_msg\r\n";		
	$fcontent=$fcontent. "define('isshowcontact','". trim($_POST['isshowcontact'])."') ;//是否公开代理商联系方式\r\n";	
	$fcontent=$fcontent. "define('liuyanysnum','". trim($_POST['liuyanysnum'])."'); //延时时间\r\n";	
	$fcontent=$fcontent. "define('channel','". $channel."') ;//功能模块开关\r\n";
	$fcontent=$fcontent. "define('usergr_power','". $usergr_power."') ;//个人用户权限\r\n";
	$fcontent=$fcontent. "define('shuxing_name','". CutFenGeXian(trim($_POST['shuxing_name']),"|")."') ;//产品更多属性设置\r\n";
	$fcontent=$fcontent. "define('wordsincomane','". CutFenGeXian(trim($_POST['wordsincomane']),"|")."') ;//公司名称中必填行业性关键字\r\n";	
	$fcontent=$fcontent. "define('lastwordsincomane','". CutFenGeXian(trim($_POST['lastwordsincomane']),"|")."') ;//公司名称中必填公司类型性关键字\r\n";
	$fcontent=$fcontent. "define('nowordsincomane','". CutFenGeXian(trim($_POST['nowordsincomane']),"|")."') ;//公司名称中禁用关键字\r\n";	
	$fcontent=$fcontent. "define('stopwords','". CutFenGeXian(trim($_POST['stopwords']),"|")."') ;//网站禁用关键字\r\n";
	$fcontent=$fcontent. "define('allowrepeatreg','". trim($_POST['allowrepeatreg'])."') ;//是否允许重复注册用户\r\n";
	$fcontent=$fcontent. "define('showdlinzs','". trim($_POST['showdlinzs'])."') ;//招商信息内是否显示代理留言数\r\n";
	$fcontent=$fcontent. "define('zsliststyle','". trim($_POST['zsliststyle'])."') ;//招商列表页默认显示格式\r\n";
	$fcontent=$fcontent. "define('siteskin','". trim($_POST['siteskin'])."') ;//网站电脑端模板\r\n";	
	$fcontent=$fcontent. "define('siteskin_mobile','". trim($_POST['siteskin_mobile'])."') ;//网站手机端模板\r\n";	
	$fcontent=$fcontent. "define('siteskin_usercenter','". trim($_POST['siteskin_usercenter'])."') ;//用户中心样式\r\n";
	$fcontent=$fcontent. "define('checksqlin','". trim($_POST['checksqlin'])."') ;//是否开启防SQL注入功能\r\n";	
	$fcontent=$fcontent. "define('cache_update_time','". trim($_POST['cache_update_time'])."') ;//缓存更新周期\r\n";
	$fcontent=$fcontent. "define('html_update_time','". trim($_POST['html_update_time'])."') ;//静态页更新周期\r\n";	
	$fcontent=$fcontent. "define('zsclass_isradio','". trim($_POST['zsclass_isradio'])."') ;//小类别是否设为单选（设为否时为多选）\r\n";		
	$fcontent=$fcontent. "define('checkistrueemail','". trim($_POST['checkistrueemail'])."') ;//用户注册时是否开启邮箱验证功能\r\n";
	$fcontent=$fcontent. "define('sdomain','". trim($_POST['sdomain'])."') ;//用户展厅页是否启用二级域名\r\n";
	$fcontent=$fcontent. "define('whtml','". trim($_POST['whtml'])."') ;//是否开启伪静态\r\n";
	$fcontent=$fcontent. "define('isshowad_when_timeend','". trim($_POST['isshowad_when_timeend'])."') ;//到期的广告是否还让显示\r\n";
	$fcontent=$fcontent. "define('showadtext','". trim($_POST['showadtext'])."') ;//到期的广告前台显示语\r\n";	
	$fcontent=$fcontent. "define('qiangad','". trim($_POST['qiangad'])."') ;//是否开通抢占广告位功能\r\n";
	$fcontent=$fcontent. "define('showadvdate','". trim($_POST['showadvdate'])."') ;//广告位置占用时间\r\n";	
	$fcontent=$fcontent. "define('duilianadisopen','". trim($_POST['duilianadisopen'])."') ;//是否打开对联广告\r\n";
	$fcontent=$fcontent. "define('flyadisopen','". trim($_POST['flyadisopen'])."') ;//是否打开漂浮广告\r\n";		
	$fcontent=$fcontent. "define('jifen','". trim($_POST['jifen'])."') ;//是否启用积分功能\r\n";
	$fcontent=$fcontent. "define('jifen_bilu','". trim($_POST['jifen_bilu'])."') ;//1元等于多少积分\r\n";
	$fcontent=$fcontent. "define('jf_reg','". trim($_POST['jf_reg'])."') ;//注册时获取积分值\r\n";
	$fcontent=$fcontent. "define('jf_login','". trim($_POST['jf_login'])."') ;//登录时获取积分值\r\n";
	$fcontent=$fcontent. "define('jf_addreginfo','". trim($_POST['jf_addreginfo']) ."') ;      //完善注册信息获取积分值\r\n";
	$fcontent=$fcontent. "define('jf_lookmessage','". trim($_POST['jf_lookmessage']) ."') ;  //查看代理留言时扣除的积分值\r\n";
	$fcontent=$fcontent. "define('jf_look_dl','". trim($_POST['jf_look_dl'])."') ;  //查看代理商信息库时扣除的积分值\r\n";
	$fcontent=$fcontent. "define('jf_set_adv','". trim($_POST['jf_set_adv']) ."') ; //抢占首页广告位扣除的积分值\r\n";	
	$fcontent=$fcontent. "define('jf_set_elite','". trim($_POST['jf_set_elite']) ."') ; //固顶信息扣除的积分值\r\n";	
	$fcontent=$fcontent. "define('maximgsize','". trim($_POST['maximgsize']) ."') ;  //图片文件大小限制,单位K\r\n";
	$fcontent=$fcontent. "define('maxflvsize','". trim($_POST['maxflvsize']) ."') ;  //视频文件大小限制,单位M\r\n";
	$fcontent=$fcontent. "define('shuiyin','". trim($_POST['shuiyin'])."') ;//是否启用水印功能\r\n";
	$fcontent=$fcontent. "define('addimgXY','". trim($_POST['addimgXY'])."') ;//水印位置\r\n";	
	$fcontent=$fcontent. "define('syurl','". str_replace('/uploadfiles','uploadfiles',trim($_POST['syurl']))."') ;//水印图片地址\r\n";	
	$fcontent=$fcontent. "define('alipay_partner','". trim($_POST['alipay_partner'])."') ;//合作者身份ID\r\n";
	$fcontent=$fcontent. "define('alipay_key','". trim($_POST['alipay_key'])."') ;//安全检验码\r\n";
	$fcontent=$fcontent. "define('alipay_seller_email','". trim($_POST['alipay_seller_email'])."') ;//签约支付宝账号或卖家支付宝帐户\r\n";	
	$fcontent=$fcontent. "define('tenpay_bargainor_id','". trim($_POST['tenpay_bargainor_id'])."') ;//财富通商户号\r\n";	
	$fcontent=$fcontent. "define('tenpay_key','". trim($_POST['tenpay_key'])."') ;//密钥\r\n";
	$fcontent=$fcontent. "define('qqlogin','". trim($_POST['qqlogin'])."') ;//是否开启QQ登录功能\r\n";	
	$fcontent=$fcontent. "define('bbs_set','". trim($_POST['bbs_set'])."') ;//是否开启同步论坛功能\r\n";	
	$fcontent=$fcontent. "?" . ">";
	fputs($fp,$fcontent);//把替换后的内容写入文件
	fclose($fp);
	echo  "<script>alert('设置成功');location.href='?'</script>";
}
?>