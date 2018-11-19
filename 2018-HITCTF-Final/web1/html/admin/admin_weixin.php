<?php
/**
 * 
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
header('Content-Type:text/html;charset=utf-8');
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if($action=="set")
{	
	$isopen = $_POST['isopen'];
	$token = $_POST['token'];
	$title = htmlspecialchars($_POST['title']);
	$url = $_POST['url'];
	$ckmov_url = $_POST['ckmov_url'];
	$follow = htmlspecialchars($_POST['follow']);
	$noc = htmlspecialchars($_POST['noc']);
	$dpic = $_POST['dpic'];
	$help = htmlspecialchars($_POST['help']);
	$topage = $_POST['topage'];
	$sql_num = intval($_POST['sql_num']);
	
	$open=fopen("../data/admin/weixin.php","w" );
	$str='<?php ';
	
	$str.='define("isopen", "';
	$str.="$isopen";
	$str.='"); ';
	
	$str.='define("token", "';
	$str.="$token";
	$str.='"); ';
	
	$str.='define("title", "';
	$str.="$title";
	$str.='"); ';
	
	$str.='define("url", "';
	$str.="$url";
	$str.='"); ';
	
	$str.='define("ckmov_url", "';
	$str.="$ckmov_url";
	$str.='"); ';
	
	$str.='define("follow", "';
	$str.="$follow";
	$str.='"); ';
	
	$str.='define("noc", "';
	$str.="$noc";
	$str.='"); ';
	
	$str.='define("dpic", "';
	$str.="$dpic";
	$str.='"); ';
	
	$str.='define("help", "';
	$str.="$help";
	$str.='"); ';
	
	$str.='define("topage", "';
	$str.="$topage";
	$str.='"); ';
	
	$str.='define("sql_num", "';
	$str.="$sql_num";
	$str.='"); ';

	$str.=" ?>";
	fwrite($open,$str);
	fclose($open);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微信公众号设置</title>
<link  href="skin/css/admin.css" rel="stylesheet" type="text/css" />
<link  href="skin/css/style.css" rel="stylesheet" type="text/css" />
<script src="skin/js/common.js" type="text/javascript"></script>
<script src="skin/js/main.js" type="text/javascript"></script>
</head>
<body>
<script type="text/JavaScript">if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='后台首页&nbsp;&raquo;&nbsp;管理员&nbsp;&raquo;&nbsp;微信公众号设置 ';</script>
<div class="r_main">
  <div class="r_content">
    <div class="r_content_1">
<form action="admin_weixin.php?action=set" method="post">	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb_style">
<tbody><tr class="thead">
<td colspan="5">微信公众号设置</td>
</tr>
<tr>
<td width="80%" align="left" height="30" class="td">
<?php require_once("../data/admin/weixin.php"); ?>
功能开关：<input type="radio" name="isopen" value="y" <?php if(isopen=="y") echo 'checked';?>>开启
&nbsp;&nbsp;
<input type="radio" name="isopen" value="n" <?php if(isopen=="n") echo 'checked';?>>关闭
&nbsp;&nbsp;*  选择是否开启微信公共平台功能

</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">

token 值：<input  name="token" size="40" value="<?php echo token;?>">
 * 微信公众平台通讯的令牌(token)值
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">

微信域名：<input  name="url" size="40" value="<?php echo url;?>">
 * 网址结尾不要加 / 符号，如域名被微信屏蔽，修改此处即可
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
微信名称：<input name="title" size="40"  value="<?php echo title;?>">
 * 显示的公众号名称，可以自定义任意内容
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
解析接口：<input name="ckmov_url" size="40"  value="<?php echo ckmov_url;?>">
 * 注意此处非多米cms播放器，而是微信用户发送视频网址时调用的解析接口
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
默认封面：<input name="dpic"  size="40"  value="<?php echo dpic;?>">
 * 消息默认封面图片地址
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
关注回复：<input name="follow"  size="40"  value="<?php echo follow;?>">
 * 用户关注后自动回复内容
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
无内容时：<input name="noc"  size="40"  value="<?php echo noc;?>">
 * 无对应内容时回复内容
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td">
帮助信息：<input name="help"  size="40"  value="<?php echo help;?>">
 * 自定义帮助信息，输入g触发此回复
</td>
</tr>


<tr>
<td width="80%" align="left" height="30" class="td">
跳转页面：
<input type="radio" name="topage" value="d" <?php if(topage=="d") echo 'checked';?>>内容页
&nbsp;&nbsp;
<input type="radio" name="topage" value="v" <?php if(topage=="v") echo 'checked';?>>播放页
&nbsp;&nbsp;* 选择默认链接地址，播放页或者内容页
</td>
</tr>


<tr>
<td width="80%" align="left" height="30" class="td">
展示数目：<input name="sql_num" size="6"   value="<?php echo sql_num;?>">
 * 相关内容展示数量，建议为5，过多内容会严重影响系统效率
</td>
</tr>

<tr>
<td width="10%" align="left" height="30" class="td">
<input type="submit" value="确认" class="btn" >
</td>
</tr>

<tr>
<td width="90%" align="left" height="30" class="td">
* 微信公众平台说明：<a href="https://mp.weixin.qq.com" target="_blank">进入微信公众平台</a>，请在微信公众平台中正确填写开发者选项。
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td">
* 注意：token：<font color="red"><strong><?php echo token;?></strong></font>,token值与微信公众平台通讯的令牌(token)值必须一致，服务器地址：<font color="red"><strong>http://你的网址/weixin/　本站<a href="/<?php echo $cfg_cmspath;?>weixin/" target="_blank">地址</a></strong></font>，末尾有/。
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td">
* 当用户输入<font color="red"><strong>中文</strong></font>时搜索影片；<font color="red"><strong>纯数字</strong></font>时获取观看密码；输入<font color="red"><strong>英文</strong></font>时触发帮助。
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td">
* 默认的帮助触发关键词为<font color="red"><strong>h</strong></font>，留言板触发关键词为<strong><font color="red">g</strong></font>。
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td">
* 如果修改无效，请检查/data/admin/weixin.php文件权限是否可写。
</td>
</tr>
</tbody></table>	
	

</form>
</div>
	</div>
</div>
<?php
viewFoot();
?>
</body>
</html>