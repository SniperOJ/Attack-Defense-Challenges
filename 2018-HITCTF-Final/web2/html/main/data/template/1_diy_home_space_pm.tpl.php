<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('space_pm');
0
|| checktplrefresh('./template/default/home/space_pm.htm', './template/default/home/space_pm_node.htm', 1540710683, 'diy', './data/template/1_diy_home_space_pm.tpl.php', './template/default', 'home/space_pm')
|| checktplrefresh('./template/default/home/space_pm.htm', './template/default/common/seditor.htm', 1540710683, 'diy', './data/template/1_diy_home_space_pm.tpl.php', './template/default', 'home/space_pm')
|| checktplrefresh('./template/default/home/space_pm.htm', './template/default/home/space_prompt_nav.htm', 1540710683, 'diy', './data/template/1_diy_home_space_pm.tpl.php', './template/default', 'home/space_pm')
;?>
<?php $_G['home_tpl_titles'] = array('短消息');?><?php include template('common/header'); ?><div id="pt" class="bm cl">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<span>通知</span> <em>&rsaquo;</em>
<a href="home.php?mod=space&amp;do=pm">消息</a>
</div>
</div>

<style id="diy_style" type="text/css"></style>
<div class="wp">
<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="ct2_a wp cl">
<div class="mn">
<div class="bm bw0">
<h1 class="mt"><img alt="pm" src="<?php echo STATICURL;?>image/feed/pm.gif" class="vm" /> 消息</h1>
<ul class="tb cl">
<li class="y"><a href="home.php?mod=space&amp;do=pm&amp;subop=setting" class="xi2">短消息设置</a></li>
<li<?php echo $actives['privatepm'];?> <?php echo $actives['newpm'];?>><a href="home.php?mod=space&amp;do=pm&amp;filter=privatepm">私人消息</a></li>
<li<?php echo $actives['announcepm'];?>><a href="home.php?mod=space&amp;do=pm&amp;filter=announcepm">公共消息</a></li>
<li class="o"><a href="home.php?mod=spacecp&amp;ac=pm">发送消息</a></li>
</ul>

<?php if(($filter == 'privatepm' && $newpm) || $filter == 'newpm') { ?>
<div class="tbms mtm mbm">
<?php if($filter != 'newpm') { ?>
<a href="home.php?mod=space&amp;do=pm&amp;filter=newpm" class="xi2">点击这里查看 <strong class="xi1"><?php echo $newpmcount;?></strong> 条未读消息</a>
<?php } else { ?>
<a href="home.php?mod=space&amp;do=pm&amp;filter=privatepm" class="xi2">查看全部私人消息</a>
<?php } ?>
</div>
<?php } if($_GET['subop'] == 'view') { if(!$type && $plid) { ?>
<div class="tbmu pml pm_op_r cl">
<div class="y pm_o">
<a href="javascript:;" id="pm_operation" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_operation_menu" class="p_pop" style="display: none;">
<ul>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;deletepm_delplid[]=<?php echo $plid;?>&amp;plid=<?php echo $plid;?>&amp;handlekey=pmdeletehk_<?php echo $plid;?>" id="a_pmdelete_<?php echo $plid;?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="删除与该用户的所有私人消息">全部删除</a></li>
</ul>
</div>
</div>
<a href="home.php?mod=spacecp&amp;ac=pm&amp;op=export&amp;plid=<?php echo $plid;?>" class="xw1">[导出]</a>
</div>
<?php } elseif($touid) { ?>
<div class="tbmu pml pm_op_r cl">
<div class="y pm_o">
<a href="javascript:;" id="pm_operation" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_operation_menu" class="p_pop" style="display: none;">
<ul>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;deletepm_deluid[]=<?php echo $touid;?>&amp;uid=<?php echo $touid;?>&amp;handlekey=pmdeletehk_<?php echo $plid;?>" id="a_pmdelete_<?php echo $plid;?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="删除与该用户的所有私人消息">全部删除</a></li>
</ul>
</div>
</div>
<div class="xw1">
共有 <span id="membernum" class="xi1"><?php echo $count;?></span> 条与 <a href="home.php?mod=space&amp;uid=<?php echo $touid;?>"><?php echo $tousername;?></a> 的交谈记录 &nbsp;
<a href="home.php?mod=spacecp&amp;ac=pm&amp;op=export&amp;touid=<?php echo $touid;?>">[导出]</a>
</div>
</div>
<?php } else { ?>
<div class="tbmu pml pm_op_r cl<?php if($list && $daterange && !$touid) { ?> bw0<?php } ?>">
<div class="y pm_o">
<a href="javascript:;" id="pm_operation" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_operation_menu" class="p_pop" style="display: none;">
<ul>
<?php if($founderuid == $_G['uid']) { ?>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;deletepm_delplid[]=<?php echo $plid;?>&amp;plid=<?php echo $plid;?>&amp;handlekey=pmdeletehk_<?php echo $plid;?>" id="a_pmdelete_<?php echo $plid;?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="删除该群聊话题">删除群聊</a></li>
<?php } else { ?>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;deletepm_quitplid[]=<?php echo $plid;?>&amp;plid=<?php echo $plid;?>&amp;handlekey=pmdeletehk_<?php echo $plid;?>" id="a_pmdelete_<?php echo $plid;?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="退出该群聊话题">退出群聊</a></li>
<?php } ?>
</ul>
</div>
</div>
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;plid=<?php echo $plid;?>&amp;type=1&amp;daterange=2"<?php if($list && $daterange && !$touid) { ?> class="a"<?php } ?>>群聊首页</a>
<span class="pipe">|</span>
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;plid=<?php echo $plid;?>&amp;type=1#last"<?php if($list && !$daterange) { ?> class="a"<?php } ?>>群聊记录</a>
<span class="pipe">|</span>
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;chatpmmember=1&amp;plid=<?php echo $plid;?>&amp;type=1" id="a_pmdelete_<?php echo $plid;?>"<?php if($chatpmmemberlist && !$daterange) { ?> class="a"<?php } ?> <?php echo $actives['chatpmmember'];?>><?php if($authorid == $_G['uid']) { ?>管理成员<?php } else { ?>成员列表<?php } ?></a>
<span class="pipe">|</span>
<a href="home.php?mod=spacecp&amp;ac=pm&amp;op=export&amp;plid=<?php echo $plid;?>&amp;type=1" class="xw1">[导出]</a>
</div>
<?php } if($list && $daterange && !$touid) { if(empty($lastanchor)) { ?><a name="last"></a><?php $lastanchor=1;?><?php } ?>
<div class="pm_g cl">
<h2 class="mbm xs2"><span class="xi1"><?php echo $membernum;?></span> 人话题 : <span class="xi2"><?php echo $subject;?></span></h2>
<div class="pm_sd">
<ul class="pm_mem_l<?php if($authorid == $_G['uid']) { ?> pm_admin<?php } ?>"><?php if(is_array($chatpmmemberlist)) foreach($chatpmmemberlist as $key => $value) { ?><li><a href="home.php?mod=space&amp;uid=<?php echo $value['uid'];?>" target="_blank" <?php if($ols[$value['uid']]) { ?> class="xi2" title="在线"<?php } else { ?> class="xg1"<?php } ?>><?php echo $value['username'];?></a></li>
<?php } ?>
</ul>
<?php if($authorid == $_G['uid']) { ?>
<div class="pm_add cl">
<input type="text" name="username" id="username" class="px z" value="" />
<span class="z">&nbsp;</span>
<a href="home.php?mod=spacecp&amp;ac=pm&amp;op=appendmember&amp;plid=<?php echo $plid;?>" id="a_appendmember" class="pn z" title="加入新的成员" onclick="getchatpmappendmember();"><span>+</span></a>
</div>
<?php } ?>
</div>
<div class="pm_mn">
<div id="msglist" class="pm_b"><?php if(is_array($list)) foreach($list as $key => $value) { ?><p class="xg1 mbn"><a href="home.php?mod=space&amp;uid=<?php echo $value['authorid'];?>" target="_blank" class="xi2"><?php echo $value['author'];?></a> &nbsp; <?php echo dgmdate($value[dateline], 'u');?></p>
<p class="mbm"><?php echo $value['message'];?></p>
<?php } ?>
</div>
<script type="text/javascript">
var refresh = true;
var refreshHandle = -1;
var autorefresh = <?php echo $refreshtime;?>;
</script>
<script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('<?php echo $_G['group']['allowsigbbcode'];?>'),allowimgcode = parseInt('<?php echo $_G['group']['allowsigimgcode'];?>');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
<script src="<?php echo $_G['setting']['jspath'];?>bbcode.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">
var msgListObj = $('msglist');
msgListObj.scrollTop = msgListObj.scrollHeight;
function succeedhandle_pmsend(url, msg, values) {
var pObj = document.createElement("p");
pObj.className = 'xg1 mbn';
pObj.innerHTML = '<a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" class="xi2"><?php echo $_G['username'];?></a> &nbsp;'+ "刚刚";
var pObjmsg = document.createElement("p");
pObjmsg.className = 'mbm';
var pmMsg = $('replymessage');
pObjmsg.innerHTML = bbcode2html(parseurl(pmMsg.value));
msgListObj.appendChild(pObj);
msgListObj.appendChild(pObjmsg);
msgListObj.scrollTop = msgListObj.scrollHeight;
pmMsg.value = "";
showCreditPrompt();
}

function refreshMsg(refreshnow) {
if(refresh) {
if(autorefresh <= 0 || refreshnow){
var x = new Ajax();
x.get('home.php?mod=spacecp&ac=pm&op=showchatmsg&inajax=1&daterange=<?php echo $daterange;?>&plid=<?php echo $plid;?>', function(s){
msgListObj.innerHTML = s;
msgListObj.scrollTop = msgListObj.scrollHeight;
});
autorefresh = <?php echo $refreshtime;?>;
}
<?php if($refreshtime) { ?>
$('refreshtip').innerHTML = autorefresh + ' 秒后刷新';
<?php } ?>
autorefresh -= 2;
} else {
window.clearInterval(refreshHandle);
}
}
<?php if($refreshtime) { ?>
refreshHandle = window.setInterval('refreshMsg(0);', 2000);
<?php } ?>
hideMenu();
</script>
<!--/div/div-->
<?php } elseif($list && !$daterange) { ?>
<div id="pm_ul" class="xld xlda mbm pml"><?php if(is_array($list)) foreach($list as $key => $value) { if(count($list)-1 == $key && empty($lastanchor)) { ?><a name="last"></a><?php $lastanchor=1;?><?php } ?>
<dl id="pmlist_<?php echo $value['pmid'];?>" class="bbda cl">
<?php if($value['pmtype'] == 1 || $value['authorid'] && $value['authorid'] != $_G['uid'] && $_G['setting']['pmreportuser']) { ?>
<dd class="y mtm pm_o">
<a href="javascript:;" id="pm_o_<?php echo $value['pmid'];?>" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_o_<?php echo $value['pmid'];?>_menu" class="p_pop" style="display: none;">
<ul>
<?php if($value['pmtype'] == 1) { ?>
<li><a href="javascript:;" id="a_pmdelete_<?php echo $value['pmid'];?>" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletepm_pmid[]=<?php echo $value['pmid'];?>&touid=<?php echo $touid;?>&deletesubmit=1&handlekey=pmdeletehk_<?php echo $value['pmid'];?>&formhash=<?php echo FORMHASH;?>', '', 'ajaxwaitid', '', 'none', 'changedeletedpm(<?php echo $value['pmid'];?>)');" title="删除">删除</a></li>
<?php } if($value['authorid'] && $value['authorid'] != $_G['uid'] && $_G['setting']['pmreportuser']) { ?>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=pm_report&amp;pmid=<?php echo $value['pmid'];?>&amp;handlekey=pmreporthk_<?php echo $value['pmid'];?>" id="a_pmreport_<?php echo $value['pmid'];?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="举报">举报</a></li>
<?php } ?>
</ul>
</div>
</dd>
<?php } ?>
<dd class="m avt" <?php if(count($list)-1 == $key) { ?>id="bottom"<?php } ?>>
<?php if($value['authorid']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $value['authorid'];?>" target="_blank"><?php echo avatar($value[authorid],small);?></a>
<?php } ?>
</dd>
<dd class="ptm">
<?php if($value['authorid']) { if($value['authorid'] == $_G['uid']) { ?>
<span class="xi2 xw1">您</span>
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $value['authorid'];?>" target="_blank" class="xw1"><?php echo $value['author'];?></a>
<?php } ?>
 &nbsp; 
<?php } ?><br />
<?php echo $value['message'];?><br />
<span class="xg1"><?php echo dgmdate($value[dateline], 'u');?></span>
</dd>

</dl><?php } ?>
<div id="pm_append" style="display: none"></div>
</div>
<?php if($multi) { ?><div class="pbm bbda cl"><?php echo $multi;?></div><?php } } elseif($chatpmmemberlist) { if($authorid == $_G['uid']) { ?>
<div class="tbmu mtn tfm pmform cl">
<script src="<?php echo $_G['setting']['jspath'];?>home_friendselector.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">
var fs;
var clearlist = 0;
</script>
<div class="cl">
<div class="un_selector px z cl" onclick="$('username').focus();">
<input type="text" name="username" id="username" autocomplete="off" />
</div>
<a href="home.php?mod=spacecp&amp;ac=pm&amp;op=appendmember&amp;plid=<?php echo $plid;?>" id="a_appendmember" class="pn appendmb z" title="加入新的成员" onclick="getchatpmappendmember();"><span class="z">加入新的成员</span></a>
<a href="javascript:;" id="showSelectBox" class="z mtn showmenu" onclick="showMenu({'showid':this.id, 'duration':3, 'pos':'34!'});fs.showPMFriend('showSelectBox_menu','selectorBox', this);" title="从好友列表中选择">选择好友</a>
</div>
<p class="d">多个用户使用逗号、分号或回车提示系统分开</p>
</div>
<div id="username_menu" style="display: none;">
<ul id="friends" class="pmfrndl"></ul>
</div>
<div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
<div class="pbm">
<select class="ps" onchange="clearlist=1;getUser(1, this.value)">
<option value="-1">全部好友</option><?php if(is_array($friendgrouplist)) foreach($friendgrouplist as $groupid => $group) { ?><option value="<?php echo $groupid;?>"><?php echo $group;?></option>
<?php } ?>
</select>
</div>
<div id="selBox" class="ptn pbn">
<ul id="selectorBox" class="xl xl2 cl"></ul>
</div>
<div class="cl">
<button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>关闭</span></button>
</div>
</div>

<script type="text/javascript">

var page = 1;
var gid = -1;
var showNum = 0;
var haveFriend = true;
function getUser(pageId, gid) {
page = parseInt(pageId);
gid = isUndefined(gid) ? -1 : parseInt(gid);
var x = new Ajax();
x.get('home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ page + '&gid=' + gid + '&' + Math.random(), function(s) {
var data = eval('('+s+')');
var singlenum = parseInt(data['singlenum']);
var maxfriendnum = parseInt(data['maxfriendnum']);
fs.addDataSource(data, clearlist);
haveFriend = singlenum && singlenum == 20 ? true : false;
if(singlenum && fs.allNumber < 20 && fs.allNumber < maxfriendnum && maxfriendnum > 20 && haveFriend) {
page++;
getUser(page);
}
});
}
function selector() {
var parameter = {'searchId':'username', 'showId':'friends', 'formId':'', 'showType':3, 'handleKey':'fs', 'selBox':'selectorBox', 'selBoxMenu':'showSelectBox_menu', 'maxSelectNumber':'20', 'selectTabId':'selectNum', 'unSelectTabId':'unSelectTab', 'maxSelectTabId':'remainNum'};
fs = new friendSelector(parameter);
var listObj = $('selBox');
listObj.onscroll = function() {
clearlist = 0;
if(this.scrollTop >= this.scrollHeight/5) {
page++;
gid = isUndefined(gid) ? 0 : parseInt(gid);
if(haveFriend) {
getUser(page, gid);
}
}
}
getUser(page);
}
selector();
</script>

<?php } ?>
<ul class="buddy cl">
<li>
<div class="avt"><a href="home.php?mod=space&amp;uid=<?php echo $authorid;?>" title="<?php echo $chatpmmemberlist[$authorid]['username'];?>" target="_blank" c="1"><em class="gm"></em><?php echo avatar($authorid,small);?></a></div>
<h4><a href="home.php?mod=space&amp;uid=<?php echo $authorid;?>" title="<?php echo $chatpmmemberlist[$authorid]['username'];?>"><?php echo $chatpmmemberlist[$authorid]['username'];?></a></h4>
<p class="maxh"><?php echo $chatpmmemberlist[$authorid]['recentnote'];?></p>
</li><?php unset($chatpmmemberlist[$authorid]);?><?php if(is_array($chatpmmemberlist)) foreach($chatpmmemberlist as $key => $value) { ?><li>
<div class="avt"><a href="home.php?mod=space&amp;uid=<?php echo $value['uid'];?>" title="<?php echo $value['username'];?>" target="_blank" c="1"><?php echo avatar($value[uid],small);?></a></div>
<h4><a href="home.php?mod=space&amp;uid=<?php echo $value['uid'];?>" title="<?php echo $value['username'];?>"><?php echo $value['username'];?></a></h4>
<p class="maxh"><?php echo $value['recentnote'];?></p>
<?php if($authorid == $_G['uid']) { ?>
<p class="xg1"><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=kickmember&amp;memberuid=<?php echo $key;?>&amp;plid=<?php echo $plid;?>" id="a_kickmmeber_<?php echo $key;?>" title="将 <?php echo $value['username'];?> 从该群聊中踢出" onclick="showWindow(this.id, this.href, 'get', 0);">踢出</a></p>
<?php } ?>
</li>
<?php } ?>
</ul>
<?php } else { ?>
<div class="emp">
当前没有相应的短消息
</div>
<?php } if(($touid || $plid) && $list) { if(empty($lastanchor)) { ?><a name="last"></a><?php } ?>
<div id="pm_ul_post" class="xld xlda pml">
<dl class="cl">
<dd class="m avt">
<a href="home.php?mod=space&amp;uid=<?php echo $space['uid'];?>"><?php echo avatar($space[uid],small);?></a>
</dd>
<dd class="ptm">
<form id="pmform" name="pmform" method="post" autocomplete="off" action="home.php?mod=spacecp&amp;ac=pm&amp;op=send&amp;pmid=<?php echo $pmid;?>&amp;daterange=<?php echo $daterange;?>&amp;handlekey=pmsend&amp;pmsubmit=yes" onsubmit="this.message.value = parseurl(this.message.value);ajaxpost('pmform', 'pmforum_return', 'pmforum_return');return false;">
<div class="tedt">
<div class="bar">
<?php if($list && $daterange && !$touid) { ?>
<span onclick="refreshMsg(1);" title="刷新" class="y xg1 cur1"><img src="static/image/common/pm-ico5.png" alt="刷新" class="vm" /> <span id="refreshtip">刷新</span></span>
<?php } $seditor = array('reply', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies'));?><script src="<?php echo $_G['setting']['jspath'];?>seditor.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<div class="fpd">
<?php if(in_array('bold', $seditor['1'])) { ?>
<a href="javascript:;" title="文字加粗" class="fbld"<?php if(empty($seditor['2'])) { ?> onclick="seditor_insertunit('<?php echo $seditor['0'];?>', '[b]', '[/b]');doane(event);"<?php } ?>>B</a>
<?php } if(in_array('color', $seditor['1'])) { ?>
<a href="javascript:;" title="设置文字颜色" class="fclr" id="<?php echo $seditor['0'];?>forecolor"<?php if(empty($seditor['2'])) { ?> onclick="showColorBox(this.id, 2, '<?php echo $seditor['0'];?>');doane(event);"<?php } ?>>Color</a>
<?php } if(in_array('img', $seditor['1'])) { ?>
<a id="<?php echo $seditor['0'];?>img" href="javascript:;" title="图片" class="fmg"<?php if(empty($seditor['2'])) { ?> onclick="seditor_menu('<?php echo $seditor['0'];?>', 'img');doane(event);"<?php } ?>>Image</a>
<?php } if(in_array('link', $seditor['1'])) { ?>
<a id="<?php echo $seditor['0'];?>url" href="javascript:;" title="添加链接" class="flnk"<?php if(empty($seditor['2'])) { ?> onclick="seditor_menu('<?php echo $seditor['0'];?>', 'url');doane(event);"<?php } ?>>Link</a>
<?php } if(in_array('quote', $seditor['1'])) { ?>
<a id="<?php echo $seditor['0'];?>quote" href="javascript:;" title="引用" class="fqt"<?php if(empty($seditor['2'])) { ?> onclick="seditor_menu('<?php echo $seditor['0'];?>', 'quote');doane(event);"<?php } ?>>Quote</a>
<?php } if(in_array('code', $seditor['1'])) { ?>
<a id="<?php echo $seditor['0'];?>code" href="javascript:;" title="代码" class="fcd"<?php if(empty($seditor['2'])) { ?> onclick="seditor_menu('<?php echo $seditor['0'];?>', 'code');doane(event);"<?php } ?>>Code</a>
<?php } if(in_array('smilies', $seditor['1'])) { ?>
<a href="javascript:;" class="fsml" id="<?php echo $seditor['0'];?>sml"<?php if(empty($seditor['2'])) { ?> onclick="showMenu({'ctrlid':this.id,'evt':'click','layer':2});return false;"<?php } ?>>Smilies</a>
<?php if(empty($seditor['2'])) { ?>
<script type="text/javascript" reload="1">smilies_show('<?php echo $seditor['0'];?>smiliesdiv', <?php echo $_G['setting']['smcols'];?>, '<?php echo $seditor['0'];?>');</script>
<?php } } if(in_array('at', $seditor['1']) && $_G['group']['allowat']) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>at.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<a id="<?php echo $seditor['0'];?>at" href="javascript:;" title="@朋友" class="fat"<?php if(empty($seditor['2'])) { ?> onclick="seditor_menu('<?php echo $seditor['0'];?>', 'at');doane(event);"<?php } ?>>@朋友</a>
<?php } ?>
<?php echo $seditor['3'];?>
</div></div>
<div class="area">
<textarea rows="3" cols="40" name="message" class="pt" id="replymessage" onkeydown="ctrlEnter(event, 'pmsubmit');"></textarea>
</div>
</div>
<p class="mtn">
<button type="submit" name="pmsubmit" id="pmsubmit" class="pn pnc" value="true"><strong>发送</strong></button>
<span id="pmforum_return"></span>
</p>
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="topmuid" value="<?php echo $touid;?>" />
</form>
</dd>
</dl>
</div>
<?php } if($list && $daterange && !$touid) { ?>
</div>
</div>
<?php } } elseif($_GET['subop'] == 'viewg') { if($grouppm) { ?>
<div id="pm_ul" class="xld xlda pml mbm">
<dl class="bbda cl">
<dd class="y mtm pm_o">
<a href="javascript:;" id="pm_o_<?php echo $grouppm['id'];?>" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_o_<?php echo $grouppm['id'];?>_menu" class="p_pop" style="display: none;">
<ul>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;deletepm_gpmid[]=<?php echo $grouppm['id'];?>&amp;pmid=<?php echo $grouppm['id'];?>&amp;handlekey=gpmdeletehk_<?php echo $grouppm['id'];?>" id="a_gpmdelete_<?php echo $grouppm['id'];?>" onclick="showWindow(this.id, this.href, 'get', 0);" title="删除">删除</a></li>
</ul>
</div>
</dd>
<dd class="m avt">
<?php if($grouppm['author']) { ?>
<img src="<?php echo IMGDIR;?>/annpm.png" alt="" />
<?php } else { ?>
<img src="<?php echo IMGDIR;?>/systempm.png" alt="" />
<?php } ?>
</dd>
<dd class="ptm">
<?php if($grouppm['author']) { ?>这是由 <a href="home.php?mod=space&amp;uid=<?php echo $grouppm['authorid'];?>" class="xi2" target="_blank"><?php echo $grouppm['author'];?></a> 发送的多人消息<?php } else { ?>这是由系统发送的多人消息<?php } ?>&nbsp; 
<span class="xg1"><?php echo dgmdate($grouppm[dateline], 'u');?></span>
</dd>
<dd>
<p class="pm_smry"><?php echo $grouppm['message'];?></p>
<?php if($grouppm['author']) { ?>
<p class="ptn xi2">
<a href="home.php?mod=spacecp&amp;ac=pm&amp;touid=<?php echo $grouppm['authorid'];?>">回复 <?php echo $grouppm['author'];?></a>
</p>
<?php } ?>
</dd>

</dl>
</div>
<?php } else { ?>
<div class="emp">
当前没有相应的短消息
</div>
<?php } } elseif($_GET['subop'] == 'setting') { ?>

<form id="pmsettingform" name="pmsettingform" method="post" autocomplete="off" action="home.php?mod=spacecp&amp;ac=pm&amp;op=setting">
<table cellspacing="0" cellpadding="0" class="tfm mtm">
<tr>
<th>只接收好友的短消息</th>
<td>
<label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="1"<?php if($acceptfriendpmstatus == 1) { ?> checked="checked"<?php } ?> />是</label>
<label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="2"<?php if($acceptfriendpmstatus == 2) { ?> checked="checked"<?php } ?> />否</label>
</td>
</tr>
<tr>
<th>忽略列表</th>
<td>
<textarea id="ignorelist" name="ignorelist" cols="40" rows="3" class="pt" onkeydown="ctrlEnter(event, 'ignoresubmit');"><?php echo htmlspecialchars($ignorelist); ?></textarea>
<div class="d"><p>添加到该列表中的用户给您发送短消息时将不予接收</p>
								<p>添加多个忽略人员名单时用逗号 "," 隔开，如“张三,李四,王五”</p>
								<p>如需禁止所有用户发来的短消息，请设置为 "&#123;ALL&#125;"</p></div>
</td>
</tr>
<tr>
<th></th>
<td><button type="submit" name="settingsubmit" value="true" class="pn"><strong>保存</strong></button></td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
</form>

<?php } else { if($count || $grouppms) { ?>
<form id="deletepmform" action="home.php?mod=spacecp&amp;ac=pm&amp;op=delete&amp;folder=<?php echo $folder;?>" method="post" autocomplete="off" name="deletepmform">
<div class="xld xlda pml mtm mbm">
<?php if($grouppms) { if(is_array($grouppms)) foreach($grouppms as $grouppm) { ?><dl id="gpmlist_<?php echo $grouppm['id'];?>" class="bbda cur1 cl<?php if(!$gpmstatus[$grouppm['id']]) { ?> newpm<?php } ?>">
<dd class="y mtm pm_o">
<a href="javascript:;" id="pm_o_<?php echo $grouppm['id'];?>" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
<div id="pm_o_<?php echo $grouppm['id'];?>_menu" class="p_pop" style="display: none;">
<ul>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_gpmid[]=<?php echo $grouppm['id'];?>', '', 'ajaxwaitid', '', 'none', '$(\'gpmlist_<?php echo $grouppm['id'];?>\').style.display=\'none\';');">删除</a></li>
</ul>
</div>
</dd>
<dd class="m avt">
<div class="newpm_avt" title="有未读消息"></div>
<a href="home.php?mod=space&amp;do=pm&amp;subop=viewg&amp;pmid=<?php echo $grouppm['id'];?>">
<?php if($grouppm['author']) { ?>
<img src="<?php echo IMGDIR;?>/annpm.png" alt="" />
<?php } else { ?>
<img src="<?php echo IMGDIR;?>/systempm.png" alt="" />
<?php } ?>
</a>
</dd>
<dd class="ptm pm_c">
<div class="o">
<input type="checkbox" name="deletepm_gpmid[]" id="a_deleteg_<?php echo $grouppm['id'];?>" class="pc" value="<?php echo $grouppm['id'];?>" />
</div>
<?php if($grouppm['author']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $grouppm['authorid'];?>" target="_blank"><?php echo $grouppm['author'];?></a> 说 :
<?php } ?>
<span id="p_gpmid_<?php echo $grouppm['id'];?>"><?php echo $grouppm['message'];?></span> &nbsp; 
<span class="xg1"><?php echo dgmdate($grouppm[dateline], 'u');?></span>&nbsp; 
<a href="home.php?mod=space&amp;do=pm&amp;subop=viewg&amp;pmid=<?php echo $grouppm['id'];?>" id="gpmlist_<?php echo $grouppm['id'];?>_a">查看</a>
</dd>
</dl>
<?php } } if(is_array($list)) foreach($list as $key => $value) { ?><dl id="pmlist_<?php echo $value['plid'];?>" class="bbda cur1 cl<?php if($value['isnew']) { ?> newpm<?php } ?>">									
<dd class="m avt">
<div class="newpm_avt" title="有未读消息"></div>
<?php if($value['pmtype'] == 1) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $value['touid'];?>" target="_blank"><?php echo avatar($value[touid],small);?></a>
<?php } elseif($value['pmtype'] == 2) { ?>
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;plid=<?php echo $value['plid'];?>&amp;type=1&amp;daterange=<?php echo $value['daterange'];?>"><img src="<?php echo IMGDIR;?>/grouppm.png" alt="" /></a>
<?php } ?>
</dd>
<dd class="ptm pm_c">
<div class="o">
<?php if($value['pmtype'] == 1) { ?>
<input type="checkbox" name="deletepm_deluid[]" id="a_delete_<?php echo $value['plid'];?>" class="pc" value="<?php echo $value['touid'];?>" />
<?php } elseif($value['pmtype'] == 2) { if($value['authorid'] == $_G['uid']) { ?>
<input type="checkbox" name="deletepm_delplid[]" id="a_delete_<?php echo $value['plid'];?>" class="pc" value="<?php echo $value['plid'];?>" />
<?php } else { ?>
<input type="checkbox" name="deletepm_quitplid[]" id="a_delete_<?php echo $value['plid'];?>" class="pc" value="<?php echo $value['plid'];?>" />
<?php } } ?>
</div>
<?php if($value['pmtype'] == 1) { if($value['lastauthorid'] == $_G['uid']) { ?>
<span class="xi2 xw1">您</span> 对 <a href="home.php?mod=space&amp;uid=<?php echo $value['touid'];?>" target="_blank"><?php echo $value['tousername'];?></a> 说 :<br />
<?php } else { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $value['touid'];?>" target="_blank" class="xw1"><?php echo $value['tousername'];?></a> 对 <span class="xi2">您</span> 说 :<br />
<?php } ?>
<?php echo $value['lastsummary'];?> &nbsp;  <br />
<span class="xg1"><?php echo dgmdate($value[lastdateline], 'u');?></span> &nbsp; 
<span class="pm_o y">
<div id="pm_o_<?php echo $value['plid'];?>_menu" class="p_pop" style="display: none;">
<ul>
<?php if($value['pmtype'] == 1) { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_deluid[]=<?php echo $value['touid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=pm_ignore&amp;username=<?php echo $value['tousername'];?>&amp;plid=<?php echo $value['plid'];?>&amp;handlekey=pmignorehk_<?php echo $value['plid'];?>" id="a_feed_menu_<?php echo $value['plid'];?>" onclick="showWindow(this.id, this.href, 'get', 0);doane(event);" title="忽略">忽略</a></li>
<?php } elseif($value['pmtype'] == 2) { if($value['authorid'] == $_G['uid']) { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_delplid[]=<?php echo $value['plid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<?php } else { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_quitplid[]=<?php echo $value['plid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<?php } } ?>
</ul>
</div>
<span class="xg1 z">共 <?php echo $value['pmnum'];?> 条</span>
<a href="javascript:;" id="pm_o_<?php echo $value['plid'];?>" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
 | 
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;touid=<?php echo $value['touid'];?>#last" id="pmlist_<?php echo $value['plid'];?>_a">回复</a>
</span>
<?php } elseif($value['pmtype'] == 2) { ?>
<table>
<tr>
<td valign="top" width="65"><?php echo $value['members'];?> 人话题 :</td>
</tr>
<tr>
<td>
<p><a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;plid=<?php echo $value['plid'];?>&amp;type=1&amp;daterange=<?php echo $value['daterange'];?>#last" id="pmlist_<?php echo $value['plid'];?>_a"><?php echo $value['subject'];?></a></p>
<?php if($value['lastauthorid']) { ?>
<p class="mbn">……</p>
<p>
<a href="home.php?mod=space&amp;uid=<?php echo $value['lastauthorid'];?>" target="_blank"><?php echo $value['lastauthor'];?></a> : 
<?php echo $value['lastsummary'];?> &nbsp; 
<span class="xg1"><?php echo dgmdate($value[lastdateline], 'u');?></span>
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;plid=<?php echo $value['plid'];?>&amp;type=1&amp;daterange=<?php echo $value['daterange'];?>#last">回复</a>
</p>
<?php } ?>
</td>
</tr>
<tr><td><span class="xg1"><?php echo dgmdate($value[lastdateline], 'u');?></span></td></tr>
</table>
<span class="pm_o y" style="margin-top: -20px; ">
<div id="pm_o_<?php echo $value['plid'];?>_menu" class="p_pop" style="display: none;">
<ul>
<?php if($value['pmtype'] == 1) { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_deluid[]=<?php echo $value['touid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<li><a href="home.php?mod=spacecp&amp;ac=pm&amp;op=pm_ignore&amp;username=<?php echo $value['tousername'];?>&amp;plid=<?php echo $value['plid'];?>&amp;handlekey=pmignorehk_<?php echo $value['plid'];?>" id="a_feed_menu_<?php echo $value['plid'];?>" onclick="showWindow(this.id, this.href, 'get', 0);doane(event);" title="忽略">忽略</a></li>
<?php } elseif($value['pmtype'] == 2) { if($value['authorid'] == $_G['uid']) { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_delplid[]=<?php echo $value['plid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<?php } else { ?>
<li><a href="javascript:;" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletesubmit=1&deletepm_quitplid[]=<?php echo $value['plid'];?>', '', 'ajaxwaitid', '', 'none', '$(\'pmlist_<?php echo $value['plid'];?>\').style.display=\'none\';');">删除</a></li>
<?php } } ?>
</ul>
</div>
<span class="xg1 z">共 <?php echo $value['pmnum'];?> 条</span>
<a href="javascript:;" id="pm_o_<?php echo $value['plid'];?>" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">菜单</a>
 | 
<a href="home.php?mod=space&amp;do=pm&amp;subop=view&amp;touid=<?php echo $value['touid'];?>#last" id="pmlist_<?php echo $value['plid'];?>_a">回复</a>
</span>
<?php } ?>
</dd>
</dl>
<?php } ?>
</div>
<div class="pgs pbm cl pm_op">
<?php if($multi) { ?><?php echo $multi;?><?php } if($count || $grouppms) { ?>
<label for="delete_all" onclick="checkall(this.form, 'deletepm_');"><input type="checkbox" name="chkall" id="delete_all" class="pc" />全选</label> &nbsp; 
<button class="pn" type="submit" name="deletepmsubmit_btn" value="true"><strong>删除</strong></button>
<button class="pn" type="button" name="markreadpm_btn" value="true" onclick="setpmstatus(this.form);"><strong>标记已读</strong></button>
<?php } ?>
</div>
<input type="hidden" name='deletesubmit' value="true" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
</form>
<script type="text/javascript">addBlockLink('deletepmform', 'dl');</script>
<?php } else { ?>
<div class="emp">
当前没有相应的短消息
</div>
<?php } } ?>

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