<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script type="text/javascript" src="/Public/artDialog/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/Public/artDialog/plugins/iframeTools.js"></script>
<script language="javascript">
function changeurl(cid,continu,player,stars,status){
	self.location.href='?s=Admin-Ting-Show-cid-'+cid+'-continu-'+continu+'-player-'+player+'-stars-'+stars+'-status-'+status+'-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-<?php echo ($type); ?>-order-<?php echo ($order); ?>';
}
$(document).ready(function(){
	$gxlcms.show.table();
	$('#continu').click(function(){
		changeurl('',1,'','','');
	});	
	$('#selectcid').change(function(){
		changeurl($(this).val(),'','','','');
	});
	$('#selectemplateayer').change(function(){
		changeurl('','',$(this).val(),'','');
	});
	$('#selectstars').change(function(){
		changeurl('','','',$(this).val(),'');
	});	
    //弹出式修改栏目

    $(".J_mcid").click(function(){

        var _this = $(this);
        art.dialog.load(_this.data('url'),false);
    })
	 $(".J_actor").click(function(){
        var _this = $(this);
        art.dialog.load(_this.data('url'),false);
    })
});
function createhtml(id){
	var offset = $("#html_"+id).offset();
	var left = (offset.left/2)+50;
	var top = offset.top+15;
	var html = $.ajax({
		url: '?s=Admin-Create-tingid-id-'+id,
		async: false
	}).responseText;
	$("#htmltags").html(html);
	$("#htmltags").css({left:left,top:top,display:""});	
	window.setTimeout(function(){
		$("#htmltags").hide();
	},1000);
}
</script>
<style>
label.ting_input_show{ position:relative;margin-top:5px}
label.ting_ids{ margin:0px 5px;}
label.ting_play {float:right;color:#666;margin-right:5px}
label sup {color:#990000;font-size:13px;}
</style>
</head>
<body class="body">
<!--生成静态预览框-->
<div id="htmltags" style="position:absolute;display:none;" class="htmltags"></div>
<!--图片预览框-->
<div id="showpic" class="showpic" style="display:none;z-index:9;"><img name="showpic_img" id="showpic_img" width="75" height="75"></div>
<!--背景灰色变暗-->
<div id="showbg" style="position:absolute;left:0px;top:0px;filter:Alpha(Opacity=0);opacity:0.0;background-color:#fff;z-index:8;"></div>

<table border="0" cellpadding="0" cellspacing="0" class="table">
<form action="?s=Admin-Ting-Show" method="post" name="myform" id="myform">
<thead><tr><th class="r"><span style="float:left">作品管理(<a href="#" onClick="if(confirm('请勿在高峰期执行该操作!')){divwindow('?s=Admin-Pic-Down','下载网络图片');}else{return false}" style="color:#990000;">下载网络图片</a>)</span><span class="right"><a href="?s=Admin-Ting-Add" style="float:right">添加作品</a></span></th></tr></thead>
  <tr>
    <td class="tr ct" style="height:40px"><input type="button" value="所有" class="submit" onClick="changeurl('','','','','');"> <input type="button" name="continu" id="continu" value="连载中" class="submit"> <input type="button" value="未审核" class="submit" onClick="changeurl('','','','',2);"> <input type="button" value="已审核" class="submit" onClick="changeurl('','','','',1);"> <select name="selectcid" id="selectcid">
<option value="">按分类查看</option><?php if(is_array($list_ting)): $i = 0; $__LIST__ = $list_ting;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select> <select name="selectemplateayer" id="selectemplateayer"><option value="0">按来源查看</option><?php if(is_array($playtree)): $i = 0; $__LIST__ = $playtree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value='<?php echo ($key); ?>' <?php if(($key) == $player): ?>selected<?php endif; ?>><?php echo ($ppting[1]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> <select name="selectstars" id="selectstars"><option value="0">按星级查看</option><option value="5" <?php if(($stars) == "5"): ?>selected<?php endif; ?>>五星</option><option value="4" <?php if(($stars) == "4"): ?>selected<?php endif; ?>>四星</option><option value="3" <?php if(($stars) == "3"): ?>selected<?php endif; ?>>三星</option><option value="2" <?php if(($stars) == "2"): ?>selected<?php endif; ?>>二星</option><option value="1" <?php if(($stars) == "1"): ?>selected<?php endif; ?>>一星</option></select> <input type="text" name="wd" id="wd" maxlength="20" value="<?php echo (urldecode((isset($wd) && ($wd !== ""))?($wd):'输入关键字搜索作品')); ?>" onClick="this.select();" style="color:#666666"> <input type="button" value="搜索" class="submit" onClick="post('?s=Admin-Ting-Show');"></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <thead>
    <tr class="ct">
      <th class="l"><span style="float:left">ID <?php if(($orders) == "ting_id desc"): ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-id-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按ID升序排列"></a><?php else: ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-id-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按ID降序排列"></a><?php endif; ?></span>作品名称</th>
   
  <th class="l" width="120">分类</th>
      <th class="l" width="120">人气<?php if(($orders) == "ting_hits desc"): ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-hits-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按人气升序排列"></a><?php else: ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-hits-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按人气降序排列"></a><?php endif; ?></th>
      <th class="l" width="120">评分<?php if(($orders) == "ting_gold desc"): ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-gold-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按评分升序排列"></a><?php else: ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-gold-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按评分降序排列"></a><?php endif; ?></th>
      <th class="l" width="130">作品权重<?php if(($orders) == "ting_stars desc"): ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-stars-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按星级升序排列"></a><?php else: ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-stars-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按星级降序排列"></a><?php endif; ?></th>
      <th class="l" width="90">更新时间<?php if(($orders) == "ting_addtime desc"): ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-addtime-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按时间升序排列"></a><?php else: ?><a href="?s=Admin-Ting-Show-cid-<?php echo ($cid); ?>-continu-<?php echo ($continu); ?>-player-<?php echo ($player); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-iffilm-<?php echo ($isfilm); ?>-url-<?php echo ($url); ?>-type-addtime-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按时间降序排列"></a><?php endif; ?></th>
      <th class="r" width="100">相关操作</th>
    </tr>
  </thead>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><tbody style="position:relative">
  <tr>
    <td class="l pd">
    <label class="ting_input_show fl"><input name='ids[]' type='checkbox' value='<?php echo ($ppting["ting_id"]); ?>' class="noborder" checked></label>
    <label class="fl">作品[<?php echo ($ppting["ting_id"]); ?>] ：</label>
    <label class="fl ting_ids"><?php if(C('url_html') > 0): ?><a href="javascript:createhtml('<?php echo ($ppting["ting_id"]); ?>');" id="html_<?php echo ($ppting["ting_id"]); ?>"><font color="green">生成</font></a><?php endif; ?><a href="<?php echo ($ppting["ting_url"]); ?>" onMouseOver="showpic(event,'<?php echo ($ppting["ting_pic"]); ?>','<?php echo (C("upload_path")); ?>/');" onMouseOut="hiddenpic();" target="_blank"><?php echo ($ppting["ting_name"]); ?></a></label>
  
 
    </td>
 <td class="l ct J_mcid" data-url="<?php echo ($ppting["list_url"]); ?>"><a href="<?php echo ($ppting["list_url"]); ?>"><?php echo (getlistname($ppting["ting_cid"])); ?></a></td>
    <td class="l ct"><?php echo ($ppting["ting_hits"]); ?></td>
    <td class="l ct"><?php echo ($ppting["ting_gold"]); ?></td>
    <td class="l ct"><?php if(is_array($ppting['ting_starsarr'])): $i = 0; $__LIST__ = $ppting['ting_starsarr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxstar): $mod = ($i % 2 );++$i;?><img src="/Public/images/admin/star<?php echo ($ajaxstar); ?>.gif" onClick="setstars('Ting',<?php echo ($ppting["ting_id"]); ?>,<?php echo ($i); ?>);" id="star_<?php echo ($ppting["ting_id"]); ?>_<?php echo ($i); ?>" class="navpoint"><?php endforeach; endif; else: echo "" ;endif; ?></td>
    <td class="l ct"><?php echo (date('Y-m-d',$ppting["ting_addtime"])); ?></td>
    <td class="r ct"><a href="?s=Admin-Ting-Add-id-<?php echo ($ppting["ting_id"]); ?>" title="点击修改作品">编辑</a> <a href="?s=Admin-Ting-Del-id-<?php echo ($ppting["ting_id"]); ?>" onClick="return confirm('确定删除该作品吗?')" title="点击删除作品">删除</a>  <?php if(($ppting["ting_status"]) == "1"): ?><a href="?s=Admin-Ting-Status-id-<?php echo ($ppting["ting_id"]); ?>-value-0" title="点击隐藏作品">隐藏</a><?php else: ?><a href="?s=Admin-Ting-Status-id-<?php echo ($ppting["ting_id"]); ?>-value-1" title="点击显示作品"><font color="red">显示</font></a><?php endif; ?></td>
  </tr>
  </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr>
      <td colspan="9" class="r pages"><?php echo ($pages); ?></td>
    </tr>   
  <tfoot>
    <tr>
    <?php print_r($ppting['son']) ; ?>
      <td colspan="9" class="r"><input type="button" value="全选" class="submit" onClick="checkall('all');"> <input name="" type="button" value="反选" class="submit" onClick="checkall();"> <?php if((C("url_html")) == "1"): ?><input type="button" value="生成静态" name="createhtml" id="createhtml" class="submit" onClick="post('?s=Admin-Ting-Create');"/><?php endif; ?> <input type="button" value="批量删除" class="submit" onClick="if(confirm('删除后将无法还原,确定要删除吗?')){post('?s=Admin-Ting-Delall');}else{return false;}"> <input type="button" value="批量移动" class="submit" onClick="$('#psetcid').show();"> <span style="display:none" id="psetcid"><select name="pestcid"><option value="">选择目标分类</option><?php if(is_array($list_ting)): $i = 0; $__LIST__ = $list_ting;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select> <input type="button" class="submit" value="确定转移" onClick="post('?s=Admin-Ting-Pestcid');"/></span><input type="button" value="批量审核" class="submit" onClick="if(confirm('确定要批量审核吗?')){post('?s=Plus-My-Statusall');}else{return false;}"></td>
    </tr>  
  </tfoot>
  </form>
</table>

<style>
#dia_title{height:25px;line-height:25px}
.jqmWindow{height:500px;width:850px;top:5px;left:310px;overflow:hidden}
</style>

</body>
</html>