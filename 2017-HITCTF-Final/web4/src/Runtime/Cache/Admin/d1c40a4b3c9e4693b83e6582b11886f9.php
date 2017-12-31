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
function createhtml(id){
	var offset = $("#html_"+id).offset();
	var left = (offset.left/2)+50;
	var top = offset.top+15;
	var html = $.ajax({
		url: '?s=Admin-Create-specialid-id-'+id,
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
<form action="?s=Admin-Special-Show" method="post" name="myform" id="myform">
<table border="0" cellpadding="0" cellspacing="0" class="table">
  <thead>
    <tr class="ct">
      <th class="l" width="40">ID <?php if(($orders) == "special_id desc"): ?><a href="?s=Admin-Special-Show-type-id-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按ID升序排列"></a><?php else: ?><a href="?s=Admin-Special-Show-type-id-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按ID降序排列"></a><?php endif; ?></th>
      <th class="l" >专题名称</th>
      <th class="l" width="60">人气<?php if(($orders) == "special_hits desc"): ?><a href="?s=Admin-Special-Show-type-hits-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按人气升序排列"></a><?php else: ?><a href="?s=Admin-Special-Show-type-hits-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按人气降序排列"></a><?php endif; ?></th>
      <th class="l" width="90">更新时间<?php if(($orders) == "special_addtime desc"): ?><a href="?s=Admin-Special-Show-type-addtime-order-asc"><img src="/Public/images/admin/up.gif" border="0" alt="点击按时间升序排列"></a><?php else: ?><a href="?s=Admin-Special-Show-type-addtime-order-desc"><img src="/Public/images/admin/down.gif" border="0" alt="点击按时间降序排列"></a><?php endif; ?></th>
      <th class="l" width="80">专题权重</th>
      <th class="l" width="80">收录作品</th>
      <th class="l" width="80">收录资讯</th>
      <th class="r" width="100">相关操作</th>
    </tr>
  </thead>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><tbody>
  <tr>
    <td class="l pd"><input name='ids[]' type='checkbox' value='<?php echo ($ppting["special_id"]); ?>' class="noborder" checked><?php echo ($ppting["special_id"]); ?></td>
    <td class="l pd"><?php if(C('url_html') > 0): ?><a href="javascript:createhtml('<?php echo ($ppting["special_id"]); ?>');" id="html_<?php echo ($ppting["special_id"]); ?>"><font color="green">生成</font></a><?php endif; ?> <a href="<?php echo ($ppting["special_url"]); ?>" target="_blank"><?php echo ($ppting["special_name"]); ?></a></td>
    <td class="l ct"><?php echo ($ppting["special_hits"]); ?></td>
    <td class="l ct"><?php echo (date('Y-m-d',$ppting["special_addtime"])); ?></td>
    <td class="l ct"><?php if(is_array($ppting['special_starsarr'])): $i = 0; $__LIST__ = $ppting['special_starsarr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxstar): $mod = ($i % 2 );++$i;?><img src="/Public/images/admin/star<?php echo ($ajaxstar); ?>.gif" onClick="setstars('Special',<?php echo ($ppting["special_id"]); ?>,<?php echo ($i); ?>);" id="star_<?php echo ($ppting["special_id"]); ?>_<?php echo ($i); ?>" class="navpoint"><?php endforeach; endif; else: echo "" ;endif; ?></td>
    <td class="l ct"><a href="javascript:void(0)" onclick="divwindow('?s=Admin-Ting-Show-tid-<?php echo ($ppting["special_id"]); ?>','添加专题到专题');">作品(<?php echo count($array_count['1-'.$ppting['special_id']]);?>)部</a></td>
    <td class="l ct"><a href="javascript:void(0)" onclick="divwindow('?s=Admin-News-Show-tid-<?php echo ($ppting["special_id"]); ?>','添加专题到专题');">资讯(<?php echo count($array_count['2-'.$ppting['special_id']]);?>)篇</a></td>
    <td class="r ct"><a href="?s=Admin-Special-Add-id-<?php echo ($ppting["special_id"]); ?>" title="点击修改专题">编辑</a> <a href="?s=Admin-Special-Del-id-<?php echo ($ppting["special_id"]); ?>" onClick="return confirm('确定删除该专题吗?')" title="点击删除专题">删除</a>  <?php if(($ppting["special_status"]) == "1"): ?><a href="?s=Admin-Special-Status-id-<?php echo ($ppting["special_id"]); ?>-sid-0" title="点击隐藏专题">隐藏</a><?php else: ?><a href="?s=Admin-Special-Status-id-<?php echo ($ppting["special_id"]); ?>-sid-1" title="点击显示专题"><font color="red">显示</font></a><?php endif; ?></td>
  </tr>
  </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr>
      <td colspan="10" class="r pages"><?php echo ($pages); ?></td>
    </tr>  
  <tfoot>
    <tr>
      <td colspan="10" class="r"><input type="button" value="全选" class="submit" onClick="checkall('all');"> <input name="" type="button" value="反选" class="submit" onClick="checkall();"> <?php if((C("url_html")) == "1"): ?><input type="button" value="生成静态" name="createhtml" id="createhtml" class="submit" onClick="post('?s=Admin-Special-Create');"/><?php endif; ?> <input type="button" value="批量删除" class="submit" onClick="if(confirm('删除后将无法还原,确定要删除吗?')){post('?s=Admin-Special-Delall');}else{return false;}"></td>
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