<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script language="javascript">
function changeid(){
	var $pidval = $('#list_pid').val();
	if($pidval == 0){
		var $templatename = '_channel';
	}else{
		var $templatename = '_list';
	}
	var $midval = $('#list_sid').val();
	if($midval == 1){
		$('#list_skin').val('gxl_ting'+$templatename);
		showseo(1);
	}else if($midval == 2){
		$('#list_skin').val('gxl_news'+$templatename);
		showseo(1);
	}else{
		showseo(9);
	}
};
function showseo($val){
	if($val<3){
		$('#listseo').css({display:''});
		$('#listjumpurl').css({display:"none"});	
	}else{
		$('#listseo').css({display:"none"});
		$('#listjumpurl').css({display:''});	
	}
}
$(document).ready(function(){
	$('#list_pid').change(function(){
		changeid();
	});
	$('#list_sid').change(function(){
		changeid();
	});
	$("#myform").submit(function(){
		if($gxlcms.form.empty('myform','list_name') == false){
			return false;
		}
		if($gxlcms.form.empty('myform','list_skin') == false){
			return false;
		}				
	});
	<?php if(!empty($list_id)): ?>showseo(<?php echo ($list_sid); ?>);<?php endif; ?>
});
</script>
</head>
<body class="body">

<div class="title">
	<div class="left"><?php echo ($templatetitle); ?>栏目分类</div>
    <div class="right"><a href="?s=Admin-List-Show">返回栏目管理</a></div>
</div>
<div class="add"><?php if(($list_id) > "0"): ?><form action="?s=Admin-List-Update" method="post" name="myform" id="myform">
<input type="hidden" name="list_id" id="list_id" value="<?php echo ($list_id); ?>">
<?php else: ?>
<form action="?s=Admin-List-Insert" method="post" name="myform" id="myform"><?php endif; ?> 
<ul><li class="left">所属分类：</li>
    <li class="right"><select name="list_pid" id="list_pid" class="w120"><option value="0">现有分类</option><?php if(is_array($list_tree)): $i = 0; $__LIST__ = $list_tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $list_pid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select> * 不选择将成为一级分类</li>
</ul>
<ul><li class="left">所属模型与排序：</li>
    <li class="right"><select name="list_sid" id="list_sid" class="w120"><option value="1" <?php if(($list_sid) == "1"): ?>selected<?php endif; ?>>作品模型 | ting</option><option value="2" <?php if(($list_sid) == "2"): ?>selected<?php endif; ?>>新闻模块 | news</option><option value="9" <?php if(($list_sid) == "9"): ?>selected<?php endif; ?>>外部链接 | url</option></select>&nbsp;</li>
</ul>
<ul><li class="left">栏目排序：</li>
    <li class="right"><input type="text" name="list_oid" id="list_oid" value="<?php echo ($list_oid); ?>" maxlength="3" class="w120"><label>越小越前面</label></li>
</ul>
<ul><li class="left">栏目中文名称：</li>
    <li class="right"><input type="text" name="list_name" id="list_name" value="<?php echo ($list_name); ?>" maxlength="20" error="* 栏目名称不能为空!" class="w120"><span id="list_name_error">*</span></li>
</ul>
<ul><li class="left">栏目英文别名：</li>
     <li class="right"><input type="text" name="list_dir" id="list_dir" value="<?php echo ($list_dir); ?>" maxlength="40" class="w120"><label>留空则自动转为拼音</label></li>
</ul>
<ul><li class="left">本栏目使用的模板名：</li>
     <li class="right"><input type="text" name="list_skin" id="list_skin" value="<?php echo ((isset($list_skin) && ($list_skin !== ""))?($list_skin):'gxl_tinglist'); ?>" maxlength="40" error="* 使用模板名不能为空!" class="w120"><label><a href="javascript:" onClick="list_skin.value='gxl_tingchannel';">作品大类</a> <a href="javascript:" onClick="list_skin.value='gxl_tinglist';">作品小类</a> <a href="javascript:" onClick="list_skin.value='gxl_news_channel';">新闻大类</a> <a href="javascript:" onClick="list_skin.value='gxl_newslist';">新闻小类</a></label><span id="list_skin_error"></span></li>
</ul>
<ul><li class="left">本栏目详情页模板名：</li>
     <li class="right"><input type="text" name="list_skin_detail" id="list_skin_detail" value="<?php echo ((isset($list_skin_detail) && ($list_skin_detail !== ""))?($list_skin_detail):'gxl_ting'); ?>" maxlength="40" class="w120"></li>
</ul>
<div id="listemplateay">
<ul><li class="left">本栏目播放页模板名：</li>
     <li class="right"><input type="text" name="list_skin_play" id="list_skin_play" value="<?php echo ((isset($list_skin_play) && ($list_skin_play !== ""))?($list_skin_play):'gxl_play'); ?>" maxlength="40" class="w120"></li>
</ul>
</div>
<div id="listtype">
<ul><li class="left">本栏目筛选页模板名：</li>
     <li class="right"><input type="text" name="list_skin_type" id="list_skin_type" value="<?php echo ((isset($list_skin_type) && ($list_skin_type !== ""))?($list_skin_type):'gxl_type'); ?>" maxlength="40" class="w120"></li>
</ul></div>
<div id="listseo">
<ul><li class="left">栏目SEO标题：</li>
     <li class="right"><input type="text" name="list_title" id="list_title" value="<?php echo ($list_title); ?>" maxlength="80" class="w400">&nbsp;</li>
</ul>
<ul><li class="left">栏目SEO关键词：</li>
     <li class="right"><input type="text" name="list_keywords" id="list_keywords" value="<?php echo ($list_keywords); ?>" maxlength="150" class="w400">&nbsp;</li>
</ul>
<ul><li class="left" style="line-height:40px">栏目SEO描述：</li>
     <li class="right"><textarea name="list_description" id="list_description"><?php echo ($list_description); ?></textarea></li>
</ul>
</div>
<ul id="listjumpurl" style="display:none"><li class="left">外部链接地址：</li>
     <li class="right"><input type="text" name="list_jumpurl" id="list_jumpurl" value="<?php echo ((isset($list_jumpurl) && ($list_jumpurl !== ""))?($list_jumpurl):'http://'); ?>" maxlength="150" class="w400"></li>
</ul>
<ul class="footer">
<input type="submit" name="submit" value="提交"> <input type="reset" name="reset" value="重置"> <?php if(($admin_id) > "0"): ?>注：不修改密码请留空<?php endif; ?>
</ul>
</div>
</form>

</body>
</html>