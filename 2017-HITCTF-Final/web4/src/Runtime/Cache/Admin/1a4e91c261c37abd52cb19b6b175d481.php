<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo (L("appname")); echo (L("ppting_version")); ?>-安装程式</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel='stylesheet' type='text/css' href='/Public/css/install.css'>
<style>span{color: #999999;}</style>
</head>
<body style="background:#FFFFFF;">
<?php $pass="<font color=green><strong>√</strong></font>";$error="<font color=red><strong>×</strong></font>"; ?>
<div class="install">
<?php if(strtolower(ACTION_NAME) == index ): ?><form method="post" action="index.php?s=Admin-Install-second">
<div class="title">
    <div class="left"></div>
    <div class="txt">服务器基本信息</div>
</div>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tbody>
  <tr>
    <td class="left">服务器 (IP/端口)：</td>
    <td class="right"><?php echo $_SERVER['SERVER_NAME'].' ('.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'].')' ?></td>
  </tr>
  <tr>
    <td class="left">服务器操作系统：</td>
    <td class="right"><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
  </tr>    
  <tr>
    <td class="left">PHP版本：</td>
    <td class="right"><?php echo PHP_VERSION;?>&nbsp;&nbsp;<span>>5.3</span>（注意：PHP5.3dev版本和PHP6均不支持）</td>
  </tr>
  <tr>
    <td class="left">PHP脚本解释引擎：</td>
    <td class="right"><?php echo PHP_SAPI;?></td>
  </tr>  
  <tr>
    <td class="left">PHP脚本超时时间：</td>
    <td class="right"><?php echo ini_get('max_execution_time');?> 秒 &nbsp;&nbsp;<span>可修改index.php第3行控制参数</span></td>
  </tr> 
  <tr>
    <td class="left">允许上传文件最大值：</td>
    <td class="right"><?php echo get_cfg_var("file_uploads") ? get_cfg_var("upload_max_filesize") : $error;?></td>
  </tr> 
</tbody>
</table>
<div class="title">
    <div class="left"></div>
    <div class="txt">系统环境要求</div>
</div>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tbody>
  <tr>
    <td class="left">Mysql数据库支持：</td>
    <td class="right"><?php echo function_exists(@mysql_close) ? mysql_get_client_info() : $error;?>&nbsp;&nbsp;<span>不支持或小于4.20版本则无法使用本系统</span></td>
  </tr>  
   <tr>
    <td class="left">PHP支持：</td>
    <td class="right"><?php echo PHP_VERSION ;?>&nbsp;&nbsp;<span>不支持或小于5.3版本则无法使用本系统</span></td>
  </tr> 
  <tr>
    <td class="left">allow_url_fopen支持：</td>
    <td class="right"><?php echo ini_get("allow_url_fopen") ? $pass : $error;?> &nbsp;&nbsp;<span>不符合要求将导致采集、远程资料本地化等功能无法应用</span></td>
  </tr>
  <tr>
    <td class="left">file_get_contents支持：</td>
    <td class="right"><?php echo function_exists(@file_get_contents) ? $pass : $error;?> &nbsp;&nbsp;<span>不符合要求将导致采集、远程资料本地化等功能无法应用</span></td>
  </tr>  
  <tr>
    <td class="left">GD图形处理扩展库版本：</td>
    <td class="right"><?php $gd = @gd_info(); echo $gd['GD Version'] ? $gd['GD Version'] : $error;?>&nbsp;&nbsp;<span>不支持或小于2.0.34版本将不能给图片添加水印</span></td>
  </tr> 
<tr>
    <td class="left">程序内核支持：</td>
    <td class="right">Thinkphp<?php echo THINK_VERSION ?></td>
  </tr>  
</tbody>
</table>
<div class="title">
    <div class="left"></div>
    <div class="txt">系统权限要求</div>
</div>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tbody>
  <tr class="tbtitle">
    <td width="20%">目录名称</td>
    <td>读取权限</td>
    <td>写入权限</td>
  </tr>
<?php $dirs=array('/','/Runtime/*','/flie/*'); ?>   
<?php foreach($dirs as $value){ ?>
  <tr class="tbtxt">
  <td class="pdl10"><?php echo $value; ?></td>
<?php
$fulld = '.'.str_replace('/*','',$value); $rsta = (is_readable($fulld) ? '<font color=green>[√]读</font>' : '<font color=red>[×]读</font>'); $wsta = (testwrite($fulld) ? '<font color=green>[√]写</font>' : '<font color=red>[×]写</font>'); echo "<td align='center'>$rsta</td><td align='center'>$wsta</td>"; ?> </tr><?php };?>  
</tbody>
</table>
<div class="next"><input name="second" type="submit" value="下一步"></div>
</form>
<?php else: ?> 
<form method="post" action="index.php?s=Admin-Install-Install">
<div class="title">
    <div class="left"></div>
    <div class="txt">数据库设置</div>
</div>
<table border="0" cellpadding="5" cellspacing="1" class="table">
  <tbody>
  <tr>
    <td class="left">系统安装目录：</td>
    <td class="right"><input type="text" name="data[site_path]" size="35" maxlength="50" value="<?php echo get_site_path('index.php');?>" id="data[site_path]" >&nbsp;&nbsp;<span>自动检测,结尾必需加斜杆 '/'</span></td>
  </tr>
  <tr>
    <td class="left">服务器地址：</td>
    <td class="right"><input type="text" name="data[db_host]" size="35" maxlength="50" value="127.0.0.1" id="data[db_host]" >&nbsp;&nbsp;<span>一般为localhost</span></td>
  </tr>
  <tr>
    <td class="left">数据库端口：</td>
    <td class="right"><input type="text" name="data[db_port]" id="data[db_port]" value="3306" size="35" maxlength="50" >&nbsp;&nbsp;<span>请填写MYSQL数据库使用的端口</span></td>
  </tr>
  <tr>
    <td class="left">数据库名称：</td>
    <td class="right"><input type="text" name="data[db_name]" id="data[db_name]" value="gxlcms" size="35" maxlength="50" >&nbsp;&nbsp;<span>请填写已存在的数据库名</span></td>
  </tr> 
  <tr>
    <td class="left">数据库用户名：</td>
    <td class="right"><input type="text" name="data[db_user]" id="data[db_user]" value="root" size="35" maxlength="50" >&nbsp;&nbsp;<span>请填写mysql用户名</span></td>
  </tr> 
  <tr>
    <td class="left">数据库密码：</td>
    <td class="right"><input type="text" name="data[db_pwd]" id="data[db_pwd]" size="35" maxlength="50" >&nbsp;&nbsp;<span>密码尽量不要设为空</span></td>
  </tr>
  <tr>
    <td class="left">系统表前缀：</td>
    <td class="right"><input type="text" name="data[db_prefix]" id="data[db_prefix]" value="gxl_" size="35" maxlength="50"  valid="required" errmsg="表前缀不能为空!">&nbsp;&nbsp;<span>密码尽量不要设为空</span></td>
  </tr> 
  <tr>
    <td class="left">后台账号：</td>
    <td class="right">admin&nbsp;&nbsp;</td>
  </tr> 
  <tr>
    <td class="left">后台密码：</td>
    <td class="right">admin&nbsp;&nbsp;</td>
  </tr>   
</tbody>
</table>
<div class="next"><input name="install" type="submit" <?php $write = testwrite('./Runtime/'); echo $write ? 'value=" 安装程序 "' : 'value="权限不足不能安装" disabled';?>></div>
</form><?php endif; ?>
</div>
</body>
</html>