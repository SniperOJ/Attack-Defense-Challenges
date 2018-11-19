<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('space_notice');
0
|| checktplrefresh('./template/default/home/space_notice.htm', './template/default/home/space_prompt_nav.htm', 1540710679, 'diy', './data/template/1_diy_home_space_notice.tpl.php', './template/default', 'home/space_notice')
;?>
<?php $_G['home_tpl_titles'] = array('提醒');?><?php include template('common/header'); ?><div id="pt" class="bm cl">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<span>通知</span> <em>&rsaquo;</em>
<a href="home.php?mod=space&amp;do=notice">提醒</a>
</div>
</div>

<style id="diy_style" type="text/css"></style>
<div class="wp">
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="ct2_a wp cl">
<div class="mn">
<div class="bm bw0">
<h1 class="mt"><img alt="pm" src="<?php echo STATICURL;?>image/feed/nts.gif" class="vm" /> 提醒</h1>
<ul class="tb cl">
<li class="y"><a href="home.php?mod=spacecp&amp;ac=privacy&amp;op=filter" target="_blank" class="xi2">筛选设置</a></li>
<?php if($_G['notice_structure'][$view] && ($view == 'mypost' || $view == 'interactive')) { if(is_array($_G['notice_structure'][$view])) foreach($_G['notice_structure'][$view] as $subtype) { ?><li<?php echo $readtag[$subtype];?>><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $view;?>&amp;type=<?php echo $subtype;?>"><?php echo lang('template', 'notice_'.$view.'_'.$subtype)?><?php if($_G['member']['newprompt_num'][$subtype]) { ?>(<?php echo $_G['member']['newprompt_num'][$subtype];?>)<?php } ?></a></li>
<?php } } else { ?>
<li class="a"><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $view;?>"><?php echo lang('template', 'notice_'.$view)?></a></li>
<?php } ?>
</ul>

<?php if(empty($list)) { ?>
<div class="emp mtw ptw hm xs2">
<?php if($new == 1) { ?>
暂时没有新提醒，<a href="home.php?mod=space&amp;do=notice&amp;isread=1">点此查看已读提醒</a>
<?php } else { ?>
暂时没有提醒内容
<?php } ?>
</div>
<?php } ?>

<script type="text/javascript">

function deleteQueryNotice(uid, type) {
var dlObj = $(type + '_' + uid);
if(dlObj != null) {
var id = dlObj.getAttribute('notice');
var x = new Ajax();
x.get('home.php?mod=misc&ac=ajax&op=delnotice&inajax=1&id='+id, function(s){
dlObj.parentNode.removeChild(dlObj);
});
}
}

function errorhandle_pokeignore(msg, values) {
deleteQueryNotice(values['uid'], 'pokeQuery');
}
</script>

<?php if($list) { ?>
<div class="xld xlda">
<div class="nts"><?php if(is_array($list)) foreach($list as $key => $value) { ?><dl class="cl <?php if($key==1) { ?>bw0<?php } ?>" <?php echo $value['rowid'];?> notice="<?php echo $value['id'];?>">
<dd class="m avt mbn">
<?php if($value['authorid']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $value['authorid'];?>"><?php echo avatar($value[authorid],small);?></a>
<?php } else { ?>
<img src="<?php echo IMGDIR;?>/systempm.png" alt="systempm" />
<?php } ?>
</dd>
<dt>
<a class="d b" href="home.php?mod=spacecp&amp;ac=common&amp;op=ignore&amp;authorid=<?php echo $value['authorid'];?>&amp;type=<?php echo $value['type'];?>&amp;handlekey=addfriendhk_<?php echo $value['authorid'];?>" id="a_note_<?php echo $value['id'];?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="屏蔽">屏蔽</a>
<span class="xg1 xw0"><?php echo dgmdate($value[dateline], 'u');?></span>
</dt>
<dd class="ntc_body" style="<?php echo $value['style'];?>">
<?php echo $value['note'];?>
</dd>

<?php if($value['from_num']) { ?>
<dd class="xg1 xw0">还有 <?php echo $value['from_num'];?> 个相同通知被忽略</dd>
<?php } ?>

</dl>
<?php } ?>
</div>
</div>

<?php if($view!='userapp' && $space['notifications']) { ?>
<div class="mtm mbm"><a href="home.php?mod=space&amp;do=notice&amp;ignore=all">还有 <?php echo $value['from_num'];?> 个相同通知被忽略 <em>&rsaquo;</em></a></div>
<?php } if($multi) { ?><div class="pgs cl"><?php echo $multi;?></div><?php } } ?>
</div>
</div>
<div class="appl"><div class="tbn">
<h2 class="mt bbda">通知</h2>
<ul>
<li <?php echo $opactives['pm'];?>><em class="notice_pm"></em><a href="home.php?mod=space&amp;do=pm">消息 <?php if($newpmcount) { ?><strong class="xi1">(<?php echo $newpmcount;?>)</strong><?php } ?></a></li><?php if(is_array($_G['notice_structure'])) foreach($_G['notice_structure'] as $key => $type) { ?><li <?php echo $opactives[$key];?>><em class="notice_<?php echo $key;?>"></em><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $key;?>"><?php echo lang('template', 'notice_'.$key)?><?php if($_G['member']['category_num'][$key]) { ?>(<?php echo $_G['member']['category_num'][$key];?>)<?php } ?></a></li>
<?php } ?>		
</ul>
</div><div class="drag">
<!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
</div>

</div>
</div>

<div class="wp mtn">
<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div><?php include template('common/footer'); ?>