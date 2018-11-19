<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<?php include $this->gettpl('header');?>
<?php if($iframe) { ?>
<script type="text/javascript">
	var uc_menu_data = new Array();
	o = document.getElementById('header_menu_menu');
	elems = o.getElementsByTagName('A');
	for(i = 0; i<elems.length; i++) {
		uc_menu_data.push(elems[i].innerHTML);
		uc_menu_data.push(elems[i].href);
	}
	try {
		parent.uc_left_menu(uc_menu_data);
		parent.uc_modify_sid('<?php echo $sid;?>');
	} catch(e) {}
</script>
<?php } ?>
<div class="container">
	<h3>UCenter 统计信息</h3>
	<ul class="memlist fixwidth">
		<li><em><?php if($user['allowadminapp'] || $user['isfounder']) { ?><a href="admin.php?m=app&a=ls">应用总数</a><?php } else { ?>应用总数<?php } ?>:</em><?php echo $apps;?></li>
		<li><em><?php if($user['allowadminuser'] || $user['isfounder']) { ?><a href="admin.php?m=user&a=ls">用户总数</a><?php } else { ?>用户总数<?php } ?>:</em><?php echo $members;?></li>
		<li><em><?php if($user['allowadminpm'] || $user['isfounder']) { ?><a href="admin.php?m=pm&a=ls">短消息数</a><?php } else { ?>短消息数<?php } ?>:</em><?php echo $pms;?></li>
		<li><em>好友记录数:</em><?php echo $friends;?></li>
	</ul>
	
	<h3>通知状态</h3>
	<ul class="memlist fixwidth">
		<li><em><?php if($user['allowadminnote'] || $user['isfounder']) { ?><a href="admin.php?m=note&a=ls">未发送的通知数</a><?php } else { ?>未发送的通知数<?php } ?>:</em><?php echo $notes;?></li>
		<?php if($errornotes) { ?>
			<li><em><?php if($user['allowadminnote'] || $user['isfounder']) { ?><a href="admin.php?m=note&a=ls">通知失败的应用</a><?php } else { ?>通知失败的应用<?php } ?>:</em>		
			<?php foreach((array)$errornotes as $appid => $error) {?>
				<?php echo $applist[$appid]['name'];?>&nbsp;
			<?php }?>
		<?php } ?>
	</ul>
	
	<h3>系统信息</h3>
	<ul class="memlist fixwidth">
		<li><em>UCenter 程序版本:</em>UCenter <?php echo UC_SERVER_VERSION;?> Release <?php echo UC_SERVER_RELEASE;?> <a href="http://www.discuz.net/forum-151-1.html" target="_blank">查看最新版本</a> 
		<li><em>操作系统及 PHP:</em><?php echo $serverinfo;?></li>
		<li><em>服务器软件:</em><?php echo $_SERVER['SERVER_SOFTWARE'];?></li>
		<li><em>MySQL 版本:</em><?php echo $dbversion;?></li>
		<li><em>上传许可:</em><?php echo $fileupload;?></li>
		<li><em>当前数据库尺寸:</em><?php echo $dbsize;?></li>		
		<li><em>主机名:</em><?php echo $_SERVER['SERVER_NAME'];?> (<?php echo $_SERVER['SERVER_ADDR'];?>:<?php echo $_SERVER['SERVER_PORT'];?>)</li>
		<li><em>magic_quote_gpc:</em><?php echo $magic_quote_gpc;?></li>
		<li><em>allow_url_fopen:</em><?php echo $allow_url_fopen;?></li>		
	</ul>
	<h3>UCenter 开发团队</h3>
	<ul class="memlist fixwidth">
		<li>
			<em>版权所有:</em>
			<em class="memcont"><a href="http://www.comsenz.com" target="_blank">&#x5317;&#x4EAC;&#x5EB7;&#x76DB;&#x65B0;&#x521B;&#x79D1;&#x6280;&#x6709;&#x9650;&#x8D23;&#x4EFB;&#x516C;&#x53F8;</a></em>
		</li>
		<li>
			<em>总策划兼项目经理:</em>
			<em class="memcont"><a href="http://www.discuz.net/home.php?mod=space&uid=1" target="_blank">&#x6234;&#x5FD7;&#x5EB7; (Kevin 'Crossday' Day)</a></em>
		</li>
		<li>
			<em>开发团队:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/home.php?mod=space&uid=859" target="_blank">Hypo 'cnteacher' Wang</a>,
				<a href="http://www.discuz.net/home.php?mod=space&uid=80629" target="_blank">Ning 'Monkey' Hou</a>,				
				<a href="http://www.discuz.net/home.php?mod=space&uid=875919" target="_blank">Jie 'tom115701' Zhang</a>
			</em>
		</li>
		<li>
			<em>安全团队:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/home.php?mod=space&uid=859" target="_blank">Hypo 'cnteacher' Wang</a>,
				<a href="http://www.discuz.net/home.php?mod=space&uid=492114" target="_blank">Liang 'Metthew' Xu</a>,
				<a href="http://www.discuz.net/home.php?mod=space&uid=285706" target="_blank">Wei (Sniffer) Yu</a>
			</em>
		</li>
		<li>
			<em>界面与用户体验团队:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/home.php?mod=space&uid=294092" target="_blank">Fangming 'Lushnis' Li</a>,
				<a href="http://www.discuz.net/home.php?mod=space&uid=717854" target="_blank">Ruitao 'Pony.M' Ma</a>
			</em>
		</li>
		<li>
			<em>感谢贡献者:</em>
			<em class="memcont">
				<a href="http://www.discuz.net/home.php?mod=space&uid=122246" target="_blank">Heyond</a>
			</em>
		</li>
		<li>
			<em>公司网站:</em>
			<em class="memcont"><a href="http://www.comsenz.com" target="_blank">http://www.Comsenz.com</a></em>
		</li>
		<li>
			<em>产品官方网站:</em>
			<em class="memcont"><a href="http://www.discuz.com" target="_blank">http://www.Discuz.com</a></em>
		</li>
		<li>
			<em>产品官方论坛:</em>
			<em class="memcont"><a href="http://www.discuz.net" target="_blank">http://www.Discuz.net</a></em>
		</li>
	</ul>
</div>

<?php echo $ucinfo;?>

<?php include $this->gettpl('footer');?>