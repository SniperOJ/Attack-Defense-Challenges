<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('register');
0
|| checktplrefresh('./template/default/member/register.htm', './template/default/common/seccheck.htm', 1540711634, '1', './data/template/1_1_member_register.tpl.php', './template/default', 'member/register')
;?><?php include template('common/header'); ?><script type="text/javascript">
var strongpw = new Array();
<?php if($_G['setting']['strongpw']) { if(is_array($_G['setting']['strongpw'])) foreach($_G['setting']['strongpw'] as $key => $val) { ?>strongpw[<?php echo $key;?>] = <?php echo $val;?>;
<?php } } ?>
var pwlength = <?php if($_G['setting']['pwlength']) { ?><?php echo $_G['setting']['pwlength'];?><?php } else { ?>0<?php } ?>;
</script>

<script src="<?php echo $this->setting['jspath'];?>register.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<div id="ct" class="ptm wp cl">
<div class="nfl" id="main_succeed" style="display: none">
<div class="f_c altw">
<div class="alert_right">
<p id="succeedmessage"></p>
<p id="succeedlocation" class="alert_btnleft"></p>
<p class="alert_btnleft"><a id="succeedmessage_href">如果您的浏览器没有自动跳转，请点击此链接</a></p>
</div>
</div>
</div>
<div class="mn">

<div class="bm" id="main_message">

<div class="bm_h bbs" id="main_hnav">
<span class="y">
<?php if(!empty($_G['setting']['pluginhooks']['register_side_top'])) echo $_G['setting']['pluginhooks']['register_side_top'];?>
<?php if($_GET['action'] == 'activation') { ?>
放弃激活，现在<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>"><?php echo $_G['setting']['reglinkname'];?></a>
<?php } else { ?>
<a href="member.php?mod=logging&amp;action=login&amp;referer=<?php echo rawurlencode($dreferer); ?>" onclick="showWindow('login', this.href);return false;" class="xi2">已有帐号？现在登录</a>
<?php } ?>
</span>
<h3 id="layer_reginfo_t" class="xs2">
<?php if($_GET['action'] != 'activation') { ?><?php echo $this->setting['reglinkname'];?><?php } else { ?>您的帐号需要激活<?php } ?>
</h3>
</div>

<p id="returnmessage4"></p>

<?php if($this->showregisterform) { ?>
<form method="post" autocomplete="off" name="register" id="registerform" enctype="multipart/form-data" onsubmit="checksubmit();return false;" action="member.php?mod=<?php echo $regname;?>">
<div id="layer_reg" class="bm_c">
<input type="hidden" name="regsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="referer" value="<?php echo $dreferer;?>" />
<input type="hidden" name="activationauth" value="<?php if($_GET['action'] == 'activation') { ?><?php echo $activationauth;?><?php } ?>" />
<?php if($_G['setting']['sendregisterurl']) { ?>
<input type="hidden" name="hash" value="<?php echo $_GET['hash'];?>" />
<?php } ?>
<div class="mtw">
<div id="reginfo_a">
<?php if(!empty($_G['setting']['pluginhooks']['register_top'])) echo $_G['setting']['pluginhooks']['register_top'];?>
<?php if($sendurl) { ?>
<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="<?php echo $this->setting['reginput']['email'];?>">Email:</label></th>
<td>
<input type="text" id="<?php echo $this->setting['reginput']['email'];?>" name="<?php echo $this->setting['reginput']['email'];?>" autocomplete="off" size="25" tabindex="1" class="px" required /><br /><em id="emailmore">&nbsp;</em>
<input type="hidden" name="handlekey" value="sendregister"/>
</td>
<td class="tipcol"><i id="tip_<?php echo $this->setting['reginput']['email'];?>" class="p_tip">请输入正确的邮箱地址</i><kbd id="chk_<?php echo $this->setting['reginput']['email'];?>" class="p_chk"></kbd></td>
</tr>
</table>
<table>
<tr>
<th>&nbsp;</th>
<td class="tipwide">
注册需要验证邮箱，请务必填写正确的邮箱，提交后请及时查收邮件。<br />您可能需要等待几分钟才能收到邮件，如果收件箱没有，请检查一下垃圾邮件箱。
</td>
</tr>
</table>
<script type="text/javascript">
function succeedhandle_sendregister(url, msg, values) {
showDialog(msg, 'notice');
}
</script>
</div>
<?php } else { if($invite) { if($invite['uid']) { ?>
<div class="rfm">
<table>
<tr>
<th>推荐人:</th>
<td><a href="home.php?mod=space&amp;uid=<?php echo $invite['uid'];?>" target="_blank"><?php echo $invite['username'];?></a></td>
</tr>
</table>
</div>
<?php } else { ?>
<div class="rfm">
<table>
<tr>
<th><label for="invitecode">邀请码:</label></th>
<td><?php echo $_GET['invitecode'];?><input type="hidden" id="invitecode" name="invitecode" value="<?php echo $_GET['invitecode'];?>" /></td>
</tr>
</table>
</div><?php $invitecode = 1;?><?php } } if(empty($invite) && $this->setting['regstatus'] == 2 && !$invitestatus) { ?>
<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="invitecode">邀请码:</label></th>
<td><input type="text" id="invitecode" name="invitecode" autocomplete="off" size="25" onblur="checkinvite()" tabindex="1" class="px" required /><?php if($this->setting['inviteconfig']['buyinvitecode'] && $this->setting['inviteconfig']['invitecodeprice'] && ($this->setting['ec_tenpay_bargainor'] || $this->setting['ec_tenpay_opentrans_chnid'] || $this->setting['ec_account'])) { ?><p><a href="misc.php?mod=buyinvitecode" target="_blank" class="xi2">还没有邀请码？点击此处获取</a></p><?php } ?></td>
<td class="tipcol"><i id="tip_invitecode" class="p_tip"><?php if($this->setting['inviteconfig']['invitecodeprompt']) { ?><?php echo $this->setting['inviteconfig']['invitecodeprompt'];?><?php } ?></i><kbd id="chk_invitecode" class="p_chk"></kbd></td>
</tr>
</table>
</div><?php $invitecode = 1;?><?php } if($_GET['action'] != 'activation') { ?>
<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="<?php echo $this->setting['reginput']['username'];?>">用户名:</label></th>
<td><input type="text" id="<?php echo $this->setting['reginput']['username'];?>" name="" class="px" tabindex="1" value="<?php echo dhtmlspecialchars($_GET['defaultusername']); ?>" autocomplete="off" size="25" maxlength="15" required /></td>
<td class="tipcol"><i id="tip_<?php echo $this->setting['reginput']['username'];?>" class="p_tip">用户名由 3 到 15 个字符组成</i><kbd id="chk_<?php echo $this->setting['reginput']['username'];?>" class="p_chk"></kbd></td>
</tr>
</table>
</div>

<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="<?php echo $this->setting['reginput']['password'];?>">密码:</label></th>
<td><input type="password" id="<?php echo $this->setting['reginput']['password'];?>" name="" size="25" tabindex="1" class="px" required /></td>
<td class="tipcol"><i id="tip_<?php echo $this->setting['reginput']['password'];?>" class="p_tip">请填写密码<?php if($_G['setting']['pwlength']) { ?>, 最小长度为 <?php echo $_G['setting']['pwlength'];?> 个字符<?php } ?></i><kbd id="chk_<?php echo $this->setting['reginput']['password'];?>" class="p_chk"></kbd></td>
</tr>
</table>
</div>

<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="<?php echo $this->setting['reginput']['password2'];?>">确认密码:</label></th>
<td><input type="password" id="<?php echo $this->setting['reginput']['password2'];?>" name="" size="25" tabindex="1" value="" class="px" required /></td>
<td class="tipcol"><i id="tip_<?php echo $this->setting['reginput']['password2'];?>" class="p_tip">请再次输入密码</i><kbd id="chk_<?php echo $this->setting['reginput']['password2'];?>" class="p_chk"></kbd></td>
</tr>
</table>
</div>

<div class="rfm">
<table>
<tr>
<th><?php if(!$_G['setting']['forgeemail']) { ?><span class="rq">*</span><?php } ?><label for="<?php echo $this->setting['reginput']['email'];?>">Email:</label></th>
<td><input type="text" id="<?php echo $this->setting['reginput']['email'];?>" name="" autocomplete="off" size="25" tabindex="1" class="px" value="<?php echo $hash['0'];?>" <?php if(!$_G['setting']['forgeemail']) { ?>required<?php } ?> /><br /><em id="emailmore">&nbsp;</em></td>
<td class="tipcol"><i id="tip_<?php echo $this->setting['reginput']['email'];?>" class="p_tip">请输入正确的邮箱地址</i><kbd id="chk_<?php echo $this->setting['reginput']['email'];?>" class="p_chk"></kbd></td>
</tr>
</table>
</div>
<?php } if($_GET['action'] == 'activation') { ?>
<div id="activation_user" class="rfm">
<table>
<tr>
<th>用户名:</th>
<td><strong><?php echo $username;?></strong></td>
</tr>
</table>
</div>
<?php } if($this->setting['regverify'] == 2) { ?>
<div class="rfm">
<table>
<tr>
<th><span class="rq">*</span><label for="regmessage">注册原因:</label></th>
<td><input id="regmessage" name="regmessage" class="px" autocomplete="off" size="25" tabindex="1" required /></td>
<td class="tipcol"><i id="tip_regmessage" class="p_tip">您填写的注册原因会被当作申请注册的重要参考依据，请认真填写。</i></td>
</tr>
</table>
</div>
<?php } if(empty($invite) && $this->setting['regstatus'] == 3) { ?>
<div class="rfm">
<table>
<tr>
<th><label for="invitecode">邀请码:</label></th>
<td><input type="text" name="invitecode" autocomplete="off" size="25" id="invitecode"<?php if($this->setting['regstatus'] == 2) { ?> onblur="checkinvite()"<?php } ?> tabindex="1" class="px" /></td>
</tr>
</table>
</div><?php $invitecode = 1;?><?php } if(is_array($_G['cache']['fields_register'])) foreach($_G['cache']['fields_register'] as $field) { if($htmls[$field['fieldid']]) { ?>
<div class="rfm">
<table>
<tr>
<th><?php if($field['required']) { ?><span class="rq">*</span><?php } ?><label for="<?php echo $field['fieldid'];?>"><?php echo $field['title'];?>:</label></th>
<td><?php echo $htmls[$field['fieldid']];?></td>
<td class="tipcol"><i id="tip_<?php echo $field['fieldid'];?>" class="p_tip"><?php if($field['description']) { echo dhtmlspecialchars($field['description']); } ?></i><kbd id="chk_<?php echo $field['fieldid'];?>" class="p_chk"></kbd></td>
</tr>
</table>
</div>
<?php } } } ?>
<?php if(!empty($_G['setting']['pluginhooks']['register_input'])) echo $_G['setting']['pluginhooks']['register_input'];?>

<?php if($secqaacheck || $seccodecheck) { ?><?php
$sectpl = <<<EOF
<div class="rfm"><table><tr><th><span class="rq">*</span><sec>: </th><td><sec><br /><sec></td></tr></table></div>
EOF;
?><?php $sechash = !isset($sechash) ? 'S'.($_G['inajax'] ? 'A' : '').$_G['sid'] : $sechash.random(3);
$sectpl = str_replace("'", "\'", $sectpl);?><?php if($secqaacheck) { ?>
<span id="secqaa_q<?php echo $sechash;?>"></span>		
<script type="text/javascript" reload="1">updatesecqaa('q<?php echo $sechash;?>', '<?php echo $sectpl;?>', '<?php echo $_G['basescript'];?>::<?php echo CURMODULE;?>');</script>
<?php } if($seccodecheck) { ?>
<span id="seccode_c<?php echo $sechash;?>"></span>		
<script type="text/javascript" reload="1">updateseccode('c<?php echo $sechash;?>', '<?php echo $sectpl;?>', '<?php echo $_G['basescript'];?>::<?php echo CURMODULE;?>');</script>
<?php } } ?>

</div>

</div>

</div>

<div id="layer_reginfo_b">
<div class="rfm mbw bw0">
<table width="100%">
<tr>
<th>&nbsp;</th>
<td>
<span id="reginfo_a_btn">
<?php if($_GET['action'] != 'activation') { ?><em>&nbsp;</em><?php } ?>
<button class="pn pnc" id="registerformsubmit" type="submit" name="regsubmit" value="true" tabindex="1"><strong><?php if($_GET['action'] == 'activation') { ?>激活<?php } else { ?>提交<?php } ?></strong></button>
<?php if($bbrules) { ?>
<input type="checkbox" class="pc" name="agreebbrule" value="<?php echo $bbrulehash;?>" id="agreebbrule" checked="checked" /> <label for="agreebbrule">同意<a href="javascript:;" onclick="showBBRule()">网站服务条款</a></label>
<?php } ?>
</span>
</td>
<td><?php if($this->setting['sitemessage']['register']) { ?><a href="javascript:;" id="custominfo_register" class="y"><img src="<?php echo IMGDIR;?>/info_small.gif" alt="帮助" /></a><?php } ?></td>
</tr>
</table>
</div>
<?php if(!empty($_G['setting']['pluginhooks']['register_logging_method'])) { ?>
<div class="rfm bw0 <?php if(empty($_GET['infloat'])) { ?> mbw<?php } ?>">
<hr class="l" />
<table>
<tr>
<th>快捷登录:</th>
<td><?php if(!empty($_G['setting']['pluginhooks']['register_logging_method'])) echo $_G['setting']['pluginhooks']['register_logging_method'];?></td>
</tr>
</table>
</div>
<?php } ?>
</div>
</form>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['register_bottom'])) echo $_G['setting']['pluginhooks']['register_bottom'];?>
</div>
<div id="layer_regmessage"class="f_c blr nfl" style="display: none">
<div class="c"><div class="alert_right">
<div id="messageleft1"></div>
<p class="alert_btnleft" id="messageright1"></p>
</div>
</div>

<div id="layer_bbrule" style="display: none">
<div class="c" style="width:700px;height:350px;overflow:auto"><?php echo $bbrulestxt;?></div>
<p class="fsb pns cl hm">
<button class="pn pnc" onclick="$('agreebbrule').checked = true;hideMenu('fwin_dialog', 'dialog');<?php if($this->setting['sitemessage']['register'] && ($bbrules && $bbrulesforce)) { ?>showRegprompt();<?php } ?>"><span>同意</span></button>
<button class="pn" onclick="location.href='<?php echo $_G['siteurl'];?>'"><span>不同意</span></button>
</p>
</div>

<script type="text/javascript">
var ignoreEmail = <?php if($_G['setting']['forgeemail']) { ?>true<?php } else { ?>false<?php } ?>;
<?php if($bbrules && $bbrulesforce) { ?>
showBBRule();
<?php } if($this->showregisterform) { if($sendurl) { ?>
addMailEvent($('<?php echo $this->setting['reginput']['email'];?>'));
<?php } else { ?>
addFormEvent('registerform', <?php if($_GET['action'] != 'activation' && !($bbrules && $bbrulesforce) && !empty($invitecode)) { ?>1<?php } else { ?>0<?php } ?>);
<?php } if($this->setting['sitemessage']['register']) { ?>
function showRegprompt() {
showPrompt('custominfo_register', 'mouseover', '<?php echo trim($this->setting['sitemessage']['register'][array_rand($this->setting['sitemessage']['register'])]); ?>', <?php echo $this->setting['sitemessage']['time'];?>);
}
<?php if(!($bbrules && $bbrulesforce)) { ?>
showRegprompt();
<?php } } ?>
function showBBRule() {
showDialog($('layer_bbrule').innerHTML, 'info', '<?php echo addslashes($this->setting['bbname']);; ?> 网站服务条款');
$('fwin_dialog_close').style.display = 'none';
}
<?php } ?>
</script>

</div></div>
</div><?php updatesession();?><?php include template('common/footer'); ?>