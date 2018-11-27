<?php
if(@$step==6){
fopen("install.lock","w");
?>
<div class="body">
	恭喜！您已经成功安装zzcms网站管理系统<br/><br/>
	<fieldset>
	<legend>&nbsp;网站管理信息&nbsp;</legend>
  网站后台地址：<a href="/admin">/admin</a><br/>
	管理员户名：<?php echo $admin?><br/>
	管理员密码： <?php echo $adminpwdtrue?><br/>
	</fieldset>
	<br/>
	非常感谢选择zzcms产品<br/>
	更多产品相关信息，敬请关注 <a href="http://www.zzcms.net" target="_blank">www.zzcms.net</a>
<input type="button" value="登录后台" onclick="window.location='/admin';"/>
<input type="button" value="网站首页" onclick="window.location='../index.php';"/>
</div>
<?php
}
?>