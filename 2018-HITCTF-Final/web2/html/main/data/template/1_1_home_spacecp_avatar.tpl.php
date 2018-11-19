<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('spacecp_avatar');
0
|| checktplrefresh('./template/default/home/spacecp_avatar.htm', './template/default/home/spacecp_header.htm', 1540711688, '1', './data/template/1_1_home_spacecp_avatar.tpl.php', './template/default', 'home/spacecp_avatar')
|| checktplrefresh('./template/default/home/spacecp_avatar.htm', './template/default/home/spacecp_footer.htm', 1540711688, '1', './data/template/1_1_home_spacecp_avatar.tpl.php', './template/default', 'home/spacecp_avatar')
|| checktplrefresh('./template/default/home/spacecp_avatar.htm', './template/default/home/spacecp_header_name.htm', 1540711688, '1', './data/template/1_1_home_spacecp_avatar.tpl.php', './template/default', 'home/spacecp_avatar')
|| checktplrefresh('./template/default/home/spacecp_avatar.htm', './template/default/home/spacecp_header_name.htm', 1540711688, '1', './data/template/1_1_home_spacecp_avatar.tpl.php', './template/default', 'home/spacecp_avatar')
;?><?php include template('common/header'); ?><div id="pt" class="bm cl">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<a href="home.php?mod=spacecp">设置</a> <em>&rsaquo;</em><?php if($actives['profile']) { ?>
个人资料
<?php } elseif($actives['verify']) { ?>
认证
<?php } elseif($actives['avatar']) { ?>
修改头像
<?php } elseif($actives['credit']) { ?>
积分
<?php } elseif($actives['usergroup']) { ?>
用户组
<?php } elseif($actives['privacy']) { ?>
隐私筛选
<?php } elseif($actives['sendmail']) { ?>
邮件提醒
<?php } elseif($actives['password']) { ?>
密码安全
<?php } elseif($actives['promotion']) { ?>
访问推广
<?php } elseif($actives['plugin']) { ?>
<?php echo $_G['setting']['plugins'][$pluginkey][$_GET['id']]['name'];?>
<?php } ?></div>
</div>
<div id="ct" class="ct2_a wp cl">
<div class="mn">
<div class="bm bw0">
<h1 class="mt"><?php if($actives['profile']) { ?>
个人资料
<?php } elseif($actives['verify']) { ?>
认证
<?php } elseif($actives['avatar']) { ?>
修改头像
<?php } elseif($actives['credit']) { ?>
积分
<?php } elseif($actives['usergroup']) { ?>
用户组
<?php } elseif($actives['privacy']) { ?>
隐私筛选
<?php } elseif($actives['sendmail']) { ?>
邮件提醒
<?php } elseif($actives['password']) { ?>
密码安全
<?php } elseif($actives['promotion']) { ?>
访问推广
<?php } elseif($actives['plugin']) { ?>
<?php echo $_G['setting']['plugins'][$pluginkey][$_GET['id']]['name'];?>
<?php } ?></h1>
<!--don't close the div here--><?php if(!empty($_G['setting']['pluginhooks']['spacecp_avatar_top'])) echo $_G['setting']['pluginhooks']['spacecp_avatar_top'];?>
<script type="text/javascript">
function updateavatar() {
window.location.href = document.location.href.replace('&reload=1', '') + '&reload=1';
}
<?php if(!$reload) { ?>
saveUserdata('avatar_redirect', document.referrer);
<?php } ?>
</script>
<form id="avatarform" enctype="multipart/form-data" method="post" autocomplete="off" action="home.php?mod=spacecp&amp;ac=avatar&amp;ref">
<table cellspacing="0" cellpadding="0" class="tfm">
<caption>
<span id="retpre" class="y xi2"></span>
<h2 class="xs2">当前我的头像</h2>
<p>如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传一张新照片来作为自己的个人头像 </p>
</caption>
<tr>
<td><?php echo avatar($space[uid],big);?></td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" class="tfm">
<caption>
<h2 class="xs2">设置我的新头像</h2>
<p>请选择一个新照片进行上传编辑。<br />头像保存后，您可能需要刷新一下本页面(按F5键)，才能查看最新的头像效果 </p>
</caption>
<tr>
<td>
<?php if(!empty($_GET['old'])) { ?>
<script type="text/javascript">document.write(AC_FL_RunContent('<?php echo implode("','", $uc_avatarflash);; ?>'));</script>
<?php } else { include template('home/spacecp_avatar_body'); } ?>							
</td>
</tr>
</table>
<?php if(empty($_GET['old'])) { ?>
    <a href="home.php?mod=spacecp&amp;ac=avatar&amp;old=1" class="xg1">如无法正常上传头像，请点此处切换为 Flash 方式上传</a>				
<?php } ?>
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
</form>
<?php if(!empty($_G['setting']['pluginhooks']['spacecp_avatar_bottom'])) echo $_G['setting']['pluginhooks']['spacecp_avatar_bottom'];?>
</div>
</div>
<script type="text/javascript">
var redirecturl = loadUserdata('avatar_redirect');
if(redirecturl) {
jQuery('retpre').innerHTML = '<a href="' + redirecturl + '">返回上一页</a>';
}
</script>
<div class="appl"><div class="tbn">
<h2 class="mt bbda">设置</h2>
<ul>
<li<?php echo $actives['avatar'];?>><a href="home.php?mod=spacecp&amp;ac=avatar">修改头像</a></li>
<li<?php echo $actives['profile'];?>><a href="home.php?mod=spacecp&amp;ac=profile">个人资料</a></li>
<?php if($_G['setting']['verify']['enabled'] && allowverify()) { ?>
<li<?php echo $actives['verify'];?>><a href="<?php if($_G['setting']['verify']['enabled']) { ?>home.php?mod=spacecp&ac=profile&op=verify<?php } else { ?>home.php?mod=spacecp&ac=videophoto<?php } ?>">认证</a></li>
<?php } ?>
<li<?php echo $actives['credit'];?>><a href="home.php?mod=spacecp&amp;ac=credit">积分</a></li>
<li<?php echo $actives['usergroup'];?>><a href="home.php?mod=spacecp&amp;ac=usergroup">用户组</a></li>
<li<?php echo $actives['privacy'];?>><a href="home.php?mod=spacecp&amp;ac=privacy">隐私筛选</a></li>

<?php if($_G['setting']['sendmailday']) { ?><li<?php echo $actives['sendmail'];?>><a href="home.php?mod=spacecp&amp;ac=sendmail">邮件提醒</a></li><?php } ?>
<li<?php echo $actives['password'];?>><a href="home.php?mod=spacecp&amp;ac=profile&amp;op=password">密码安全</a></li>

<?php if($_G['setting']['creditspolicy']['promotion_visit'] || $_G['setting']['creditspolicy']['promotion_register']) { ?>
<li<?php echo $actives['promotion'];?>><a href="home.php?mod=spacecp&amp;ac=promotion">访问推广</a></li>
<?php } if(!empty($_G['setting']['plugins']['spacecp'])) { if(is_array($_G['setting']['plugins']['spacecp'])) foreach($_G['setting']['plugins']['spacecp'] as $id => $module) { if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?><li<?php if($_GET['id'] == $id) { ?> class="a"<?php } ?>><a href="home.php?mod=spacecp&amp;ac=plugin&amp;id=<?php echo $id;?>"><?php echo $module['name'];?></a></li><?php } } } ?>
</ul>
</div></div>
</div><?php include template('common/footer'); ?>