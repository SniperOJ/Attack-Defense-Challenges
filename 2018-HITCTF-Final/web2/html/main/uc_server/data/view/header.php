<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo UC_CHARSET;?>" />
<title>UCenter Administrator's Control Panel</title>
<link rel="stylesheet" href="images/admincp.css" type="text/css" media="all" />
<meta content="Comsenz Inc." name="Copyright" />
</head>
<body><div id="append"></div>
<?php if(!empty($iframe) && !empty($user)) { ?>
	<a class="othersoff" style="float:right;text-align:center" id="header_menu" onclick="headermenu(this)">菜单</a>
	<ul id="header_menu_menu" style="display: none">
		<li><a href="admin.php?m=frame&a=main&iframe=1" target="main" class="tabon">首页</a></li>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=ls&iframe=1" target="main">基本设置</a></li><?php } ?>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=register&iframe=1" target="main">注册设置</a></li><?php } ?>
		<?php if($user['allowadminsetting'] || $user['isfounder']) { ?><li><a href="admin.php?m=setting&a=mail&iframe=1" target="main">邮件设置</a></li><?php } ?>
		<?php if($user['allowadminapp'] || $user['isfounder']) { ?><li><a href="admin.php?m=app&a=ls&iframe=1" target="main">应用管理</a></li><?php } ?>
		<?php if($user['allowadminuser'] || $user['isfounder']) { ?><li><a href="admin.php?m=user&a=ls&iframe=1" target="main">用户管理</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=admin&a=ls&iframe=1" target="main">管理员</a></li><?php } ?>
		<?php if($user['allowadminpm'] || $user['isfounder']) { ?><li><a href="admin.php?m=pm&a=ls&iframe=1" target="main">短消息</a></li><?php } ?>
		<?php if($user['allowadmincredits'] || $user['isfounder']) { ?><li><a href="admin.php?m=credit&a=ls&iframe=1" target="main">积分兑换</a></li><?php } ?>
		<?php if($user['allowadminbadword'] || $user['isfounder']) { ?><li><a href="admin.php?m=badword&a=ls&iframe=1" target="main">词语过滤</a></li><?php } ?>
		<?php if($user['allowadmindomain'] || $user['isfounder']) { ?><li><a href="admin.php?m=domain&a=ls&iframe=1" target="main">域名解析</a></li><?php } ?>
		<?php if($user['allowadmindb'] || $user['isfounder']) { ?><li><a href="admin.php?m=db&a=ls&iframe=1" target="main">数据备份</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=feed&a=ls&iframe=1" target="main">数据列表</a></li><?php } ?>
		<?php if($user['allowadmincache'] || $user['isfounder']) { ?><li><a href="admin.php?m=cache&a=update&iframe=1" target="main">更新缓存</a></li><?php } ?>
		<?php if($user['isfounder']) { ?><li><a href="admin.php?m=plugin&a=filecheck&iframe=1" target="main">校验文件</a></li><?php } ?>
		<a href="admin.php?m=user&a=logout" target="main">退出</a>
	</ul>
<?php } ?>
<script type="text/javascript">
	function headermenu(ctrl) {
		ctrl.className = ctrl.className == 'otherson' ? 'othersoff' : 'otherson';
		var menu = document.getElementById('header_menu_body');
		if(!menu) {
			menu = document.createElement('div');
			menu.id = 'header_menu_body';
			menu.innerHTML = '<ul>' + document.getElementById('header_menu_menu').innerHTML + '</ul>';
			var obj = ctrl;
			var x = ctrl.offsetLeft;
			var y = ctrl.offsetTop;
			while((obj = obj.offsetParent) != null) {
				x += obj.offsetLeft;
				y += obj.offsetTop;
			}
			menu.style.left = x + 'px';
			menu.style.top = y + ctrl.offsetHeight + 'px';
			menu.className = 'togglemenu';
			menu.style.display = '';
			document.body.appendChild(menu);
		} else {
			menu.style.display = menu.style.display == 'none' ? '' : 'none';
		}
	}
</script>
