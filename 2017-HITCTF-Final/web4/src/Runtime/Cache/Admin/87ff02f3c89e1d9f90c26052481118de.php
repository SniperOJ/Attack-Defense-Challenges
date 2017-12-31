<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台用户管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/admin-style.css' />
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/jquery/jquery-1.7.2.min.js"></script>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="/Public/js/admin.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#myform").submit(function(){
		if($gxlcms.form.empty('myform','admin_name') == false){
			return false;
		}
		<?php if(($admin_id) == "0"): ?>if($gxlcms.form.empty('myform','admin_pwd') == false){
			return false;
		}
		if($gxlcms.form.repwd('myform','admin_pwd','admin_repwd') == false){
			return false;
		}<?php endif; ?>		
	});
});
</script>
</head>
<body class="body">

<div class="title">
	<div class="left">添加后台用户管理</div>
    <div class="right"><a href="?s=Admin-Admin-Show">后台用户管理</a></div>
</div>
<div class="add">
	<?php if(($admin_id) > "0"): ?><form action="?s=Admin-Admin-Update" method="post" name="myform" id="myform">
    <input type="hidden" name="admin_id" value="<?php echo ($admin_id); ?>"><input type="hidden" name="admin_pwd2" value="<?php echo ($admin_pwd); ?>">
    <?php else: ?>
    <form action="?s=Admin-Admin-Insert" method="post" name="myform" id="myform"><?php endif; ?> 
    <ul><li class="left">用户名称：</li>
    	<li class="right"><input type="text" name="admin_name" id="admin_name" value="<?php echo ($admin_name); ?>" maxlength="12" error="* 用户名长度为2-12个字符!"><span id="admin_name_error">*</span></li>
    </ul>
    <ul><li class="left">用户密码：</li>
    	<li class="right"><input type="password" name="admin_pwd" id="admin_pwd" value="" maxlength="12" error="* 用户密码长度为2-12个字符!"><span id="admin_pwd_error">*</span></li>
    </ul>
    <ul><li class="left">确认密码：</li>
    	<li class="right"><input type="password" name="admin_repwd" id="admin_repwd" value="" maxlength="12" error="* 两次输入的密码不一样!"><span id="admin_repwd_error">*</span></li>
    </ul>
    <ul style="text-align:left;"><li class="left">管理权限：</li>
    	<li style="height:70px"><input name="ids[0]" type="checkbox" value="1" class="noborder" <?php if(($admin["0"]) == "1"): ?>checked<?php endif; ?>>后台设置
          <input name="ids[1]" type="checkbox" value="1" class="noborder" <?php if(($admin["1"]) == "1"): ?>checked<?php endif; ?>>分类管理
          <input name="ids[2]" type="checkbox" value="1" class="noborder" <?php if(($admin["2"]) == "1"): ?>checked<?php endif; ?>>作品管理
          <input name="ids[3]" type="checkbox" value="1" class="noborder" <?php if(($admin["3"]) == "1"): ?>checked<?php endif; ?>>新闻管理
          <input name="ids[4]" type="checkbox" value="1" class="noborder" <?php if(($admin["4"]) == "1"): ?>checked<?php endif; ?>>用户管理
          <input name="ids[5]" type="checkbox" value="1" class="noborder" <?php if(($admin["5"]) == "1"): ?>checked<?php endif; ?>>采集管理
          <input name="ids[6]" type="checkbox" value="1" class="noborder" <?php if(($admin["6"]) == "1"): ?>checked<?php endif; ?>>数据备份
          <input name="ids[7]" type="checkbox" value="1" class="noborder" <?php if(($admin["7"]) == "1"): ?>checked<?php endif; ?>>上传管理
          <input name="ids[8]" type="checkbox" value="1" class="noborder" <?php if(($admin["8"]) == "1"): ?>checked<?php endif; ?>>友链管理
          <input name="ids[9]" type="checkbox" value="1" class="noborder" <?php if(($admin["9"]) == "1"): ?>checked<?php endif; ?>>广告管理<br>
          <input name="ids[10]" type="checkbox" value="1" class="noborder" <?php if(($admin["10"]) == "1"): ?>checked<?php endif; ?>>缓存管理
          <input name="ids[11]" type="checkbox" value="1" class="noborder" <?php if(($admin["11"]) == "1"): ?>checked<?php endif; ?>>生成管理
          <input name="ids[12]" type="checkbox" value="1" class="noborder" <?php if(($admin["12"]) == "1"): ?>checked<?php endif; ?>>模板管理
          <input name="ids[13]" type="checkbox" value="1" class="noborder" <?php if(($admin["13"]) == "1"): ?>checked<?php endif; ?>>评论管理
          <input name="ids[14]" type="checkbox" value="1" class="noborder" <?php if(($admin["14"]) == "1"): ?>checked<?php endif; ?>>留言管理
          <input name="ids[15]" type="checkbox" value="1" class="noborder" <?php if(($admin["15"]) == "1"): ?>checked<?php endif; ?>>TAG管理
          <input name="ids[16]" type="checkbox" value="1" class="noborder" <?php if(($admin["16"]) == "1"): ?>checked<?php endif; ?>>专题管理
          <input name="ids[17]" type="checkbox" value="1" class="noborder" <?php if(($admin["17"]) == "1"): ?>checked<?php endif; ?>>自定义菜单
          <input name="ids[18]" type="checkbox" value="1" class="noborder" <?php if(($admin["18"]) == "1"): ?>checked<?php endif; ?>>幻灯管理
          <input name="ids[19]" type="checkbox" value="1" class="noborder" <?php if(($admin["19"]) == "1"): ?>checked<?php endif; ?>>图片清理<br>
    
         
        </li>
    </ul>
    <ul class="footer" style="clear:both;border-top:1px solid #cad9ea" ><input type="submit" name="submit" value="提交"> <input type="reset" name="reset" value="重置"> <?php if(($admin_id) > "0"): ?>注：不修改密码请留空<?php endif; ?></ul>
    </form>
</div>

</body>
</html>