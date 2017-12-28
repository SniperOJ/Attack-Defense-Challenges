<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/kindeditor-min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/editor/zh_CN.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#myform").submit(function(){
		if($gxlcms.form.empty('myform','news_name') == false){
			return false;
		}
		if($("#news_cid").val()==0){
			alert('请选择分类');
			return false;
		}
	});
	$("#tabs>a").click(function(){
		var no = $(this).attr('id');
		var n = $("#tabs>a").length;
		showtab('tabs',no,n);
		$("#tabs>a").removeClass("on");
		$(this).addClass("on");
		return false;
	});
});
</script>
</head>
<body class="body">
<!--图片预览框-->
<div id="showpic" class="showpic" style="display:none;"><img name="showpic_img" id="showpic_img" width="120" height="160"></div>

<?php if(($news_id) > "0"): ?><form name="update" action="?s=Admin-News-Update" method="post" name="myform" id="myform">
<input type="hidden" name="news_id" value="<?php echo ($news_id); ?>">
<?php else: ?>
<form name="add" action="?s=Admin-News-Insert" method="post" name="myform" id="myform"><?php endif; ?>
<div class="title">
	<div class="tabs" id="tabs"><a href="javascript:void(0)" class="on" id="1"><?php echo ($news_templatename); ?>文章</a><a href="javascript:void(0)" id="2">其它设置</a></div>
    <div class="right"><a href="?s=Admin-News-Show">返回文章资讯</a></div>
</div>
<div class="form">
<table border="0" cellpadding="0" cellspacing="0" class="table" id="tabs1">
  <tr>
    <td class="tl">新闻名称：</td>
    <td class="tr" style="position:relative"><ul><input type="text" name="news_name" id="news_name" value="<?php echo ($news_name); ?>" maxlength="255" error="* 名称不能为空" class="w400"><span id="news_name_error">*</span> <lable><select name="news_cid" id="news_cid" style="width:108px"><option value=0>选择分类</option> <?php if(is_array($list_news)): $i = 0; $__LIST__ = $list_news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $news_cid): ?>selected<?php endif; ?>><?php echo ($ppting["list_name"]); ?></option><?php if(is_array($ppting['son'])): $i = 0; $__LIST__ = $ppting['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ppting): $mod = ($i % 2 );++$i;?><option value="<?php echo ($ppting["list_id"]); ?>" <?php if(($ppting["list_id"]) == $news_cid): ?>selected<?php endif; ?>>├ <?php echo ($ppting["list_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?></select> </lable></ul>
 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;推送到百度<input name="insertseo" type="checkbox" style="border:none;width:auto; position:absolute; top:5px"  value="5" title="勾选推送到百度">   
    </td>
  </tr>
  <tr>
    <td class="tl">标签TAG：</td>
    <td class="tr"><input type="text" name="news_keywords" id="news_keywords" maxlength="255" value="<?php echo ($news_keywords); ?>" class="w400 xy_tag"> <img src="/Public/images/admin/edit.gif" onClick="javascript:showtags(2);" class="navpoint" alt="点击选择关键词"></td>
  </tr>
  <tr>
    <td class="tl">新闻图片：</td>
    <td class="tr"><label style="float:left; margin-top:4px; margin-right:5px"><input type="text" name="news_pic" id="news_pic" maxlength="255" value="<?php echo ($news_pic); ?>" class="w400" onMouseOver="if(this.value)showpic(event, this.value,'<?php echo (C("upload_path")); ?>/');" onMouseOut="hiddenpic();"></label><iframe src="?s=Admin-Upload-Show-sid-news-fileback-news_pic" scrolling="no" topmargin="0" width="290" height="28" marginwidth="0" marginheight="0" frameborder="0" align="left" style="margin-top:4px; float:left"></iframe></span></td>
  </tr>
  <tr>
    <td class="tl">新闻简介：</td>
    <td class="tr padding-5050"><textarea name="news_remark" id="news_remark" style="width:705px;height:50px;color:#666666" title="如果不填写简介则自动截取内容前100字"><?php echo ($news_remark); ?></textarea></td>
  </tr>  
  <tr>
    <td class="tl">新闻内容：</td>
    <td class="tr padding-5050"><textarea name="news_content" id="content" style="width:99%;height:300px;"><?php echo ($news_content); ?></textarea></td>
  </tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="table" id="tabs2" style="display:none">
  <tr>
    <td class="tl">推荐星级：</td>
    <td class="tr" id="abc"><input name="news_stars" id="news_stars" type="hidden" value="<?php echo ($news_stars); ?>"><?php if(is_array($news_starsarr)): $i = 0; $__LIST__ = $news_starsarr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ajaxstar): $mod = ($i % 2 );++$i;?><img src="/Public/images/admin/star<?php echo ($ajaxstar); ?>.gif" onClick="addstars('news',<?php echo ($i); ?>);" id="star_<?php echo ($i); ?>" class="navpoint"><?php endforeach; endif; else: echo "" ;endif; ?></td>
  </tr>
  <tr>
    <td class="tl">新闻状态：</td>
    <td class="tr"><select name="news_status" class="w70"><option value="1">显示</option><option value="0" <?php if(($news_status) == "0"): ?>selected<?php endif; ?>>隐藏</option></select></td>
  </tr>  
  <tr>
    <td class="tl">标题颜色：</td>
    <td class="tr" id="abc"><select name="news_color" id="news_color" class="w70"><option>颜色</option>                               
    <option value='#000000' style='background-color:#000000' <?php if(($news_color) == "#000000"): ?>selected<?php endif; ?>></option>
    <option value='#FFFFFF' style='background-color:#FFFFFF' <?php if(($news_color) == "#FFFFFF"): ?>selected<?php endif; ?>></option>
    <option value='#008000' style='background-color:#008000' <?php if(($news_color) == "#008000"): ?>selected<?php endif; ?>></option>
    <option value='#FFFF00' style='background-color:#FFFF00' <?php if(($news_color) == "#FFFF00"): ?>selected<?php endif; ?>></option>
    <option value='#FF0000' style='background-color:#FF0000' <?php if(($news_color) == "#FF0000"): ?>selected<?php endif; ?>></option>
    <option value='#0000FF' style='background-color:#0000FF' <?php if(($news_color) == "#0000FF"): ?>selected<?php endif; ?>></option>
    <option value=''>无色</option></select></td>
  </tr>
  <tr>
    <td class="tl">首字母：</td>
    <td class="tr"><input type="text" name="news_letter" id="news_letter" value="<?php echo ($news_letter); ?>" maxlength="1" class="w50"></td>
  </tr>       
  <tr>
    <td class="tl">总人气：</td>
    <td class="tr"><input type="text" name="news_hits" id="news_hits" maxlength="15" value="<?php echo ($news_hits); ?>" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">月人气：</td>
    <td class="tr"><input type="text" name="news_hits_month" id="news_hits_month" maxlength="15" value="<?php echo ($news_hits_month); ?>" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">周人气：</td>
    <td class="tr"><input type="text" name="news_hits_week" id="news_hits_week" maxlength="15" value="<?php echo ($news_hits_week); ?>" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">日人气：</td>
    <td class="tr"><input type="text" name="news_hits_day" id="news_hits_day" maxlength="15" value="<?php echo ($news_hits_day); ?>" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">评分值：</td>
    <td class="tr"><input type="text" name="news_gold" id="news_gold" value="<?php echo ($news_gold); ?>" maxlength="4" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">评分人数：</td>
    <td class="tr"><input type="text" name="news_golder" id="news_golder" value="<?php echo ($news_golder); ?>" maxlength="8" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">顶：</td>
    <td class="tr"><input type="text" name="news_up" id="news_up" value="<?php echo ($news_up); ?>" maxlength="8" class="w50"></td>
  </tr>
  <tr>
    <td class="tl">踩：</td>
    <td class="tr"><input type="text" name="news_down" id="news_down" value="<?php echo ($news_down); ?>" maxlength="8" class="w50"></td>
  </tr> 
  <tr>
    <td class="tl">时间：</td>
    <td class="tr"><input type="text" name="news_addtime" id="news_addtime" maxlength="15" value="<?php echo (date('Y-m-d H:i:s',$news_addtime)); ?>" class="w150"> <input name="checktime" type="checkbox" style="border:none;width:auto" value="1" <?php echo ($checktime); ?> title="勾选则使用系统当前时间"></td>
  </tr>
  <tr>
    <td class="tl">独立模板：</td>
    <td class="tr"><input type="text" name="news_skin" id="news_skin" value="<?php echo ($news_skin); ?>" maxlength="25" class="w150"></td>
  </tr>   
  <tr>
    <td class="tl">来源：</td>
    <td class="tr"><input type="text" name="news_reurl" id="news_reurl" value="<?php echo ($news_reurl); ?>" maxlength="150" class="w400"></td>
  </tr>              
  <tr>
    <td class="tl">跳转URL：</td>
    <td class="tr"><input type="text" name="news_jumpurl" id="news_jumpurl" value="<?php echo ($news_jumpurl); ?>" maxlength="150" class="w400"></td>
  </tr>    
</table>
<ul class="footer">
	<input type="submit" name="submit" value="提交"> <input type="reset" name="reset" value="重置">
</ul>
</div>
</form>


<style>
#dia_title{height:25px;line-height:25px}
.jqmWindow{height:500px;width:800px;top:10px;left:310px;overflow:hidden}
</style>

</body>
</html>