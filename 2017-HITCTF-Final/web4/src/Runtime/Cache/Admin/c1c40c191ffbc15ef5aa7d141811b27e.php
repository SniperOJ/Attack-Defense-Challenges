<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script language="javascript">
var resizediv = function() { 
	$leftwidth = $(window).width()/2-150;
	$('.jqmWindow').css({ left: $leftwidth});
}
$(document).ready(function(){
	$gxlcms.show.table();
	$(window).resize(resizediv);
	resizediv();
});
function changeurl(cid,continu,player,stars,status){
	self.location.href='?s=Admin-News-Show-cid-'+cid+'-stars-'+stars+'-status-'+status+'-type-<?php echo ($type); ?>-order-<?php echo ($order); ?>';
}
$(document).ready(function(){
	$gxlcms.show.table();
	$('#selectcid').change(function(){
		changeurl($(this).val(),'','','','');
	});
	$('#selectstars').change(function(){
		changeurl('','','',$(this).val(),'');
	});		
});
function createhtml(id){
	var offset = $("#html_"+id).offset();
	var left = (offset.left/2)+50;
	var top = offset.top+15;
	var html = $.ajax({
		url: '?s=Admin-Create-newsid-id-'+id,
		async: false
	}).responseText;
	$("#htmltags").html(html);
	$("#htmltags").css({left:left,top:top,display:""});	
	window.setTimeout(function(){
		$("#htmltags").hide();
	},1000);
}
</script>
</head>
<body class="body">
<!--生成静态预览框-->
<div id="htmltags" style="position:absolute;display:none;" class="htmltags"></div>
<!--背景灰色变暗-->
<div id="showbg" style="position:absolute;left:0px;top:0px;filter:Alpha(Opacity=0);opacity:0.0;background-color:#fff;z-index:8;"></div>
<form action="?s=Admin-News-Show" method="post" name="myform" id="myform">
<table border="0" cellpadding="0" cellspacing="0" class="table">
<thead><tr><th class="r"><span style="float:left">新闻资讯管理</span><span class="right"><a href="?s=Admin-News-Add" style="float:right">添加文章资讯</a></span></th></tr></thead>
  <tr>
    <td class="tr ct" style="height:40px"><input type="button" value="所有" class="submit" onClick="changeurl('','','','','',2);"> <input type="button" value="未审核" class="submit" onClick="changeurl('','','','',2);"> <input type="button" value="已审核" class="submit" onClick="changeurl('','','','',1);"> <select name="selectcid" id="selectcid">
<option value="">按分类查看</option><?php if(is_array($list_news)): $i = 0; $__LIST__ = $list_news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select> <select name="selectstars" id="selectstars"><option value="0">按星级查看</option><option value="5" <?php if(($stars) == "5"): ?>selected<?php endif; ?>>五星</option><option value="4" <?php if(($stars) == "4"): ?>selected<?php endif; ?>>四星</option><option value="3" <?php if(($stars) == "3"): ?>selected<?php endif; ?>>三星</option><option value="2" <?php if(($stars) == "2"): ?>selected<?php endif; ?>>二星</option><option value="1" <?php if(($stars) == "1"): ?>selected<?php endif; ?>>一星</option></select> <input type="text" name="wd" id="wd" maxlength="20" value="<?php echo (urldecode((isset($wd) && ($wd !== ""))?($wd):'输入关键字搜索作品')); ?>" onClick="this.select();" style="color:#666666"> <input type="button" value="搜索" class="submit" onClick="post('?s=Admin-News-Show');"></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <thead>
    <tr class="ct">
      <th class="r" width="20">ID</th>
      <th class="l" ><span style="float:left; padding-top:7px"><?php if(($orders) == "news_id desc"): ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-id-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按ID升序排列"></a><?php else: ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-id-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按ID降序排列"></a><?php endif; ?></span>新闻标题</th>
      <th class="l" width="70">分类</th>
      <th class="l" width="60">人气<?php if(($orders) == "news_hits desc"): ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-hits-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按人气升序排列"></a><?php else: ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-hits-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按人气降序排列"></a><?php endif; ?></th>
      <th class="l" width="60">评分<?php if(($orders) == "news_gold desc"): ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-gold-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按评分升序排列"></a><?php else: ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-gold-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按评分降序排列"></a><?php endif; ?></th>
      <th class="l" width="80">关联作品</th>
      <th class="l" width="80">关联明星</th>
      <th class="l" width="80">文章权重<?php if(($orders) == "news_stars desc"): ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-stars-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按星级升序排列"></a><?php else: ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-stars-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按星级降序排列"></a><?php endif; ?></th>
      <th class="l" width="80">更新时间<?php if(($orders) == "news_addtime desc"): ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-addtime-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按时间升序排列"></a><?php else: ?><a href="?s=Admin-News-Show-cid-<?php echo ($cid); ?>-stars-<?php echo ($stars); ?>-status-<?php echo ($status); ?>-type-addtime-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按时间降序排列"></a><?php endif; ?></th>
      <th class="r" width="100">相关操作</th>
    </tr>
  </thead>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><tbody>
  <tr>
    <td class="r ct"><input name='ids[]' type='checkbox' value='<?php echo ($ppting["news_id"]); ?>' class="noborder" checked></td>
    <td class="l pd">
    <span style="float:left"><span style="color:#666666"><?php echo ($ppting["news_id"]); ?>、</span><?php if(C('url_html') > 0): ?><a href="javascript:createhtml('<?php echo ($ppting["news_id"]); ?>');" id="html_<?php echo ($ppting["news_id"]); ?>"><font color="green">生成</font></a><?php endif; ?> <a href="<?php echo ($ppting["news_url"]); ?>" target="_blank"><?php echo (msubstr($ppting["news_name"],0,40,'utf-8',true)); ?></a> <span id="ct_<?php echo ($ppting["news_id"]); ?>"><?php if(($ppting['news_continu']) != "0"): ?><sup onClick="setcontinu(<?php echo ($ppting["news_id"]); ?>,'<?php echo ($ppting["news_continu"]); ?>');" class="navpoint"><?php echo ($ppting["news_continu"]); ?></sup><?php else: ?><img src="/Public/images/admin/ct.gif" style="margin-top:10px" class="navpoint" onClick="setcontinu(<?php echo ($ppting["news_id"]); ?>,'<?php echo ($ppting["news_continu"]); ?>');"><?php endif; ?></span></span>
    </td>
    <td class="l ct"><a href="<?php echo ($ppting["list_url"]); ?>"><?php echo (getlistname($ppting["news_cid"])); ?></a></td>
    <td class="l ct"><?php echo ($ppting["news_hits"]); ?></td>
    <td class="l ct"><?php echo ($ppting["news_gold"]); ?></td>
        <td class="l ct"><a href="javascript:void(0)" onclick="divwindow('?s=Admin-Ting-Show-nid-<?php echo ($ppting["news_id"]); ?>','给资讯添加关联作品');">作品(<?php echo count($array_count['1-'.$ppting['news_id']]);?>)部</a></td>
    <td class="l ct"><a href="javascript:void(0)" onclick="divwindow('?s=Admin-Star-Show-nid-<?php echo ($ppting["news_id"]); ?>','给资讯添加关联明星');">明星(<?php echo count($array_count['2-'.$ppting['news_id']]);?>)位</a></td>
    <td class="l ct"><?php if(is_array($ppting['news_starsarr'])): $i = 0; $__LIST__ = $ppting['news_starsarr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxstar): $mod = ($i % 2 );++$i;?><img src="/Public/images/admin/star<?php echo ($ajaxstar); ?>.gif" onClick="setstars('News',<?php echo ($ppting["news_id"]); ?>,<?php echo ($i); ?>);" id="star_<?php echo ($ppting["news_id"]); ?>_<?php echo ($i); ?>" class="navpoint"><?php endforeach; endif; else: echo "" ;endif; ?></td>
    <td class="l ct"><?php echo (date('Y-m-d',$ppting["news_addtime"])); ?></td>
    <td class="r ct"><a href="?s=Admin-News-Add-id-<?php echo ($ppting["news_id"]); ?>" title="点击修改作品">编辑</a> <a href="?s=Admin-News-Del-id-<?php echo ($ppting["news_id"]); ?>" onClick="return confirm('确定删除该文章吗?')" title="点击删除作品">删除</a> <?php if(($ppting["news_status"]) == "1"): ?><a href="?s=Admin-News-Status-id-<?php echo ($ppting["news_id"]); ?>-value-0" title="点击隐藏文章">隐藏</a><?php else: ?><a href="?s=Admin-News-Status-id-<?php echo ($ppting["news_id"]); ?>-value-1" title="点击显示文章"><font color="red">显示</font></a><?php endif; ?></td>
  </tr>
  </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr>
      <td colspan="9" class="r pages"><?php echo ($pages); ?></td>
    </tr>   
  <tfoot>
    <tr>
      <td colspan="9" class="r"><input type="button" value="全选" class="submit" onClick="checkall('all');"> <input name="" type="button" value="反选" class="submit" onClick="checkall();"> <?php if((C("url_html")) == "1"): ?><input type="button" value="生成静态" name="createhtml" id="createhtml" class="submit" onClick="post('?s=Admin-News-Create');"/><?php endif; ?> <input type="button" value="批量删除" class="submit" onClick="if(confirm('删除后将无法还原,确定要删除吗?')){post('?s=Admin-News-Delall');}else{return false;}"> <input type="button" value="批量移动" class="submit" onClick="$('#psetcid').show();"> <span style="display:none" id="psetcid"><select name="pestcid"><option value="">选择目标分类</option><?php if(is_array($list_news)): $i = 0; $__LIST__ = $list_news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select> <input type="button" class="submit" value="确定转移" onClick="post('?s=Admin-News-Pestcid');"/></span></td>
    </tr>  
  </tfoot>
</table>
</form>

<style>
#dia_title{height:25px;line-height:25px}
.jqmWindow{height:500px;width:800px;top:10px;left:310px;overflow:hidden}
</style>

</body>
</html>