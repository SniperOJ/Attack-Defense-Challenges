<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE></TITLE>
<style type="text/css">
body { margin:0px; background:transparent; overflow:hidden; background:url("image/manage_leftbg.gif"); }
.left_color { text-align:right; }
.left_color a { color: #083772; text-decoration: none; font-size:12px; display:block !important; display:inline; width:175px !important; width:180px; text-align:right; background:url("image/manage_menubg.gif") right no-repeat; height:23px; line-height:23px; padding-right:10px; margin-bottom:2px;}
.left_color a:hover { color: #7B2E00;  background:url("image/manage_menubg_hover.gif") right no-repeat; }
img { float:none; vertical-align:middle; }
</style>
<script type="text/javascript">
<!--
	function disp(n){
		for (var i=0;i<12;i++)
		{
			if (!document.getElementById("left"+i)) return;			
			document.getElementById("left"+i).style.display="none";
		}
		document.getElementById("left"+n).style.display="";
	}	
//-->
</script>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 1px #FFFFFF">
  <tr>
    <td valign="top" style="padding-top:10px;" class="left_color" id="menubar">
	<div id="left0" style="display:"> 
	<a href="zs_manage.php" target="frmright"><?php echo channelzs?>信息管理</a>
	<a href="dl_manage.php" target="frmright"><?php echo channeldl?>信息管理</a>
     </div>	
     <div id="left1" style="display:none"> 
	  <a href="zs_manage.php" target="frmright"><?php echo channelzs?>信息管理</a> 
	  <a href="dl_manage.php" target="frmright" ><?php echo channeldl?>信息管理</a>
	  <a href="dl_data.php" target="frmright" ><?php echo channeldl?>信息导入</a>
	  <a href="tagmanage.php?tabletag=zzcms_tagzs" target="frmright"><?php echo channelzs.channeldl?>关键词管理</a>
	  <?php
	if (str_is_inarr(channel,'pp')=='yes'){
	?>
	  <a href="pp_manage.php" target="frmright">品牌信息管理</a> 
	<?php
	}
	if (str_is_inarr(channel,'job')=='yes'){
	?>  
	<a href="job_manage.php" target="frmright">招聘信息管理</a>
	<?php
	}
	if (str_is_inarr(channel,'zh')=='yes'){
	?>
	  <a href="zh_manage.php" target="frmright"  >展会信息管理</a> 
	<?php
	}
	if (str_is_inarr(channel,'zx')=='yes'){
	?>  
		<a href="zx_manage.php" target="frmright">资讯信息管理</a> 
         <a href="pinglun_manage.php" target="frmright">资讯评论管理</a> 
         <a href="tagmanage.php?tabletag=zzcms_tagzx" target="frmright">资讯关键词管理 </a> 
	<?php
	}
	if (str_is_inarr(channel,'wangkan')=='yes'){
	?>	 
		 <a href="wangkan_manage.php" target="frmright">网刊管理</a> 
	<?php
	}
	if (str_is_inarr(channel,'baojia')=='yes'){
	?>	 
		  <a href="baojia_manage.php" target="frmright" >报价管理</a>
	<?php
	}
	if (str_is_inarr(channel,'special')=='yes'){
	?>	  
		 <a href="special_manage.php" target="frmright">专题信息管理</a> 
	<?php
	}
	if (str_is_inarr(channel,'ask')=='yes'){
	?>
	 <a href="ask_manage.php" target="frmright">问答信息管理</a> 
	 <?php
	}
	?>
		<a href="ztliuyan_manage.php" target="frmright">展厅留言管理</a>
		<a href="usermessage.php" target="frmright">用户返馈管理</a> 
		<a href="licence.php" target="frmright">资质证书管理</a> 
		<a href="linkmanage.php" target="frmright">友情链接管理</a> 
		<a href="help_manage.php?b=2" target="frmright">公告信息管理</a>
		<a href="help_manage.php?b=1" target="frmright">帮助信息管理</a>
      </div>
	  
      <div id="left2" style="display:none"> 
	  <a href="zsclassmanage.php" target="frmright"><?php echo channelzs?>/<?php echo channeldl?>类别管理</a> 
	  <a href="classmanage.php?tablename=zzcms_zsclass_shuxing" target="frmright"><?php echo channelzs?>信息属性管理</a> 
	 
	 <?php
	if (str_is_inarr(channel,'zx')=='yes'){
	?>
	  <a href="zxclassmanage.php" target="frmright">资讯类别管理</a>
	  <?php
	}
	if (str_is_inarr(channel,'wangkan')=='yes'){
	?>
	  <a href="classmanage.php?tablename=zzcms_wangkanclass" target="frmright">网刊类别管理</a>  
	  <?php
	}
	if (str_is_inarr(channel,'special')=='yes'){
	?>
	   <a href="specialclassmanage.php" target="frmright">专题类别管理</a> 
	   <?php
	}
	if (str_is_inarr(channel,'job')=='yes'){
	?>
	  <a href="jobclassmanage.php" target="frmright">招聘类别管理</a>
	<?php
	}
	if (str_is_inarr(channel,'zh')=='yes'){
	?>  
      <a href="classmanage.php?tablename=zzcms_zhclass" target="frmright">展会类别管理</a> 
	  <?php
	}
	if (str_is_inarr(channel,'ask')=='yes'){
	?>
	  <a href="askclassmanage.php" target="frmright">问答类别管理</a> 
	    <?php
	}
	
	?>
      <a href="adclass.php" target="frmright">广告类别管理</a> 
	<a href="userclass.php" target="frmright">企业类别管理</a> 
	<a href="classmanage.php?tablename=zzcms_linkclass" target="frmright">友情链接类别管理</a> 
      </div>

      <div id="left3" style="display:none"> 
	   <a href="ad_add.php" target="frmright">添加广告</a>
        <a href="ad_manage.php" target="frmright">管理广告</a>
		<a href="adclass.php" target="frmright">类别设置</a>
		<a href="siteconfig.php?#qiangad" target="frmright">广告设置</a>
		 <a href="ad_user_manage.php" target="frmright">审请的广告</a>
		</div>

      <div id="left4" style="display:none"> 
		<a href="usermanage.php" target="frmright">用户管理</a>
		<a href="usergroupmanage.php" target="frmright">用户组管理</a>
		<a href="siteconfig.php#usergr_power" target="frmright">个人用户权限管理</a>
	 	<a href="usernotreg.php" target="frmright">未进行邮箱验证的用户管理</a>
		<a href="userclass.php" target="frmright">企业类别管理</a>
 		<a href="licence.php" target="frmright">用户资质证书管理</a>
		<a href="showbad.php" target="frmright">用户不良操作记录</a>
		
		<a href="usermessage.php" target="frmright">用户返馈信息管理</a>
        <a href="adminlist.php" target="frmright">管理员管理</a>
		<a href="admingroupmanage.php" target="frmright">管理员组管理</a>
	</div>
				
      <div id="left5" style="display:none"> 
        <a href="siteconfig.php#upfile" target="frmright">上传功能设置</a>
        <a href="siteconfig.php#addimage" target="frmright">添加水印功能设置</a>
        <a href="uploadfile_nouse.php" target="frmright"> 清理无用的上传文件</a>
		 </div>

			<div id="left6" style="display:none"> 
				<a href="message_add.php" target="frmright">发站内短消息</a> 
				<a href="message_manage.php" target="frmright">站内短消息管理</a>
				 <a href="sendmail.php" target="frmright">发E-mali</a> 
				  <a href="siteconfig.php#sendmail" target="frmright">E-mali设置</a>
				<a href="sendsms.php" target="frmright">发手机短信</a>
				<a href="siteconfig.php#sendSms" target="frmright">手机短信设置</a>
			</div>
			
			<div id="left7" style="display:none"> 
			<a href="siteconfig.php#siteskin" target="frmright">网站风格设置</a>
			<a href="siteconfig.php#SiteInfo" target="frmright">网站基本信息设置</a>
			<a href="siteconfig.php#SiteOpen" target="frmright">网站运行状态设置</a>
			<a href="siteconfig.php#SiteOption" target="frmright">网站功能参数设置</a>
            <a href="about_manage.php" target="frmright">网站底部链接管理</a> 
			<a href="siteconfig.php#stopwords" target="frmright">限制字符设置</a> 
			 <a href="showbad.php" target="frmright">限制来访IP管理</a>
            <a href="siteconfig.php#qiangad" target="frmright">广告设置</a>
			 <a href="siteconfig.php#userjf" target="frmright">积分功能设置</a>
			 <a href="siteconfig.php#UpFile" target="frmright">上传文件选项设置</a>
			 <a href="siteconfig.php#addimage" target="frmright">添加水印功能设置</a>	 
			 <a href="siteconfig.php#alipay_set" target="frmright">支付接口设置</a>	 
            <a href="siteconfig.php#sendmail" target="frmright">发邮件接口设置</a>
			 <a href="siteconfig.php#sendsms" target="frmright">发手机短信接口设置</a>
			 <a href="qqlogin_set.php" target="frmright">QQ互联接口设置</a> 
			<a href="ucenter_config.php" target="frmright">整合Discuz! Ucenter接口设置</a> 
			<a href="wjtset.php" target="frmright">文件头设置</a> 
			</div>
			
			<div id="left8" style="display:none">
			<a href="databaseclear.php" target="frmright">初始化数据库</a>
			<a href="data_back.htm" target="frmright">备份/还原数据库</a>
			</div>
			
			
			<div id="left9" style="display:none"> 
			<a href="labelzsshow.php" target="frmright"><?php echo channelzs?>内容标签</a>
			<a href="labelclass.php?classname=zsclass" target="frmright"><?php echo channelzs?>类别标签</a>			
			<a href="labeldlshow.php" target="frmright"><?php echo channeldl?>内容标签</a>
			<a href="labelclass.php?classname=dlclass" target="frmright"><?php echo channeldl?>类别标签</a>
			<?php
	if (str_is_inarr(channel,'pp')=='yes'){
	?>
			<a href="labelppshow.php" target="frmright">品牌内容标签</a>
			<a href="labelclass.php?classname=ppclass" target="frmright">品牌类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'job')=='yes'){
	?>		
			<a href="labeljobshow.php" target="frmright">招聘内容标签</a>
			<a href="labelclass.php?classname=jobclass" target="frmright">招聘类别标签</a>			
	<?php
	}
	if (str_is_inarr(channel,'zx')=='yes'){
	?>		
			<a href="labelzxshow.php" target="frmright">资讯内容标签</a>
			<a href="labelclass.php?classname=zxclass" target="frmright">资讯类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'wangkan')=='yes'){
	?>		
			<a href="labelwangkanshow.php" target="frmright">网刊内容标签</a>
			<a href="labelclass.php?classname=wangkanclass" target="frmright">网刊类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'baojia')=='yes'){
	?>		
			<a href="labelbaojiashow.php" target="frmright">报价内容标签</a>
			<a href="labelclass.php?classname=baojiaclass" target="frmright">报价类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'special')=='yes'){
	?>		
			<a href="labelztshow.php" target="frmright">专题内容标签</a>
			<a href="labelclass.php?classname=specialclass" target="frmright">专题类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'zh')=='yes'){
	?>		
			<a href="labelzhshow.php" target="frmright">展会内容标签</a>
			<a href="labelclass.php?classname=zhclass" target="frmright">展会类别标签</a>
	<?php
	}
	if (str_is_inarr(channel,'ask')=='yes'){
	?>
	<a href="labelaskshow.php" target="frmright">问答内容标签</a>
	<a href="labelclass.php?classname=askclass" target="frmright">问答类别标签</a>
	<?php
	}
	?>	
			<a href="labelcompanyshow.php" target="frmright">企业内容标签</a>
			<a href="labelclass.php?classname=companyclass" target="frmright">企业类别标签</a>
			<a href="labeladshow.php" target="frmright">广告内容标签</a>
			<a href="labeladclass.php" target="frmright">广告类别标签</a>
			<a href="labelhelpshow.php" target="frmright">帮助内容标签</a>
			<a href="labelaboutshow.php" target="frmright">单页内容标签</a>
			<a href="labellinkshow.php" target="frmright">友情链接内容标签</a>
			<a href="labelclass.php?classname=linkclass" target="frmright">友情链接类别标签</a>
			
			<a href="labelguestbookshow.php" target="frmright">留言本内容标签</a>
			</div>
			<div id="left10" style="display:none"> 
			<a href="template.php" target="frmright">网站模板管理</a>
			<a href="template_user.php" target="frmright">用户展厅模板管理</a>
			</div>
			<div id="left11" style="display:none"> 
			<a href="cachedel.php" target="frmright">清理网站缓存</a>
			<a href="htmldel.php" target="frmright">清理HTML页</a>
			</div>		
	</td>
 </tr>
</table>
</body>
</html>