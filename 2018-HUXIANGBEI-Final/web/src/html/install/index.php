<?php 
if(!isset($_SESSION)){session_start();} 
error_reporting(0);
set_time_limit(0);
set_magic_quotes_runtime(0);

include '../inc/config.php';
if($_POST) extract($_POST, EXTR_SKIP);//把数组中的键名直接注册为了变量。就像把$_POST[ai]直接注册为了$ai。
if($_GET) extract($_GET, EXTR_SKIP);
$submit = isset($_POST['submit']) ? true : false;
$step = isset($_POST['step']) ? $_POST['step'] : 1;

function new_is_writeable($file) {  
if(is_dir($file)){  
	$dir=$file;  
	if ($fp = @fopen("$dir/test.txt",'w')) {//目录测试在window下不给写入权限也可写，所以在要求可写的目录下，放了test.txt变成测试文件是否可写
	@fclose($fp);  
	@unlink("$dir/test.txt");  
	$writeable = 1;  
	} else {  
	$writeable = 0;  
	}  
} else {  
	if ($fp = @fopen($file, 'a+')) { //注意用a+文件内容不被清理
	@fclose($fp);  
	$writeable = 1;  
	} else {  
	$writeable = 0;  
	}  
}
return $writeable;  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>zzcms安装向导</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="main"> 
  <div class="head">ZZCMS(产品招商)版安装向导 </div>
  <div class="jindu">
<li <?php if ($step==2){echo 'class=current';} ?>>检查系统运行环境 -></li>
<li <?php if ($step==3){echo 'class=current';} ?>>检查目录/文件属性 -></li>
<li <?php if ($step==4){echo 'class=current';} ?>>创建数据库 -></li>
<li <?php if ($step==5){echo 'class=current';} ?>>安装 -></li>
 </div> 
<?php
switch($step) {
	case '1'://协议
		include 'step_'.$step.'.php';
	break;
	case '2'://环境
		$pass = true;
		$PHP_VERSION = PHP_VERSION;
		if(version_compare($PHP_VERSION, '4.3.0', '<')) {
			$php_pass = $pass = false;
		} else {
			$php_pass = true;
		}
		$PHP_MYSQL = '';
		if(extension_loaded('mysql')) {
			$PHP_MYSQL = '支持';
			$mysql_pass = true;
		} else {
			$PHP_MYSQL = '不支持';
			$mysql_pass = $pass = false;
		}
        $PHP_GD = '';
        if(function_exists('imagejpeg')) $PHP_GD .= 'jpg';
        if(function_exists('imagegif')) $PHP_GD .= ' gif';
        if(function_exists('imagepng')) $PHP_GD .= ' png';
		if($PHP_GD) {
			$gd_pass = true;
		} else {
			$gd_pass = false;
		}
		$PHP_URL = @get_cfg_var("allow_url_fopen");//是否支持远程URL，采集有用
		$url_pass = $PHP_URL ? true : false;
		include 'step_'.$step.'.php';
	break;
	case '3'://查目录属性
		include 'step_'.$step.'.php';
	break;
	case '4'://建数据库
		include 'step_'.$step.'.php';
	break;
	case '5'://安装进度
		function dexit($msg) {
			echo '<script>alert("'.$msg.'");window.history.back();</script>';
			exit;
		}
		
		if(!mysql_connect($db_host, $db_user, $db_pass)) dexit('无法连接到数据库服务器，请检查配置');
		$db_name or dexit('请填写数据库名');
		if(!mysql_select_db($db_name)) {
			if(!mysql_query("CREATE DATABASE $db_name")) dexit('指定的数据库不存在\n\n系统尝试创建失败，请通过其他方式建立数据库');
		}
		
		//保存配置文件
		$fp="../inc/config.php";
		$f = fopen($fp,'r');
		$str = fread($f,filesize($fp));
		fclose($f);
		$str=str_replace("define('sqlhost','".sqlhost."')","define('sqlhost','$db_host')",$str) ;
		$str=str_replace("define('sqldb','".sqldb."')","define('sqldb','$db_name')",$str) ;
		$str=str_replace("define('sqluser','".sqluser."')","define('sqluser','$db_user')",$str) ;
		$str=str_replace("define('sqlpwd','".sqlpwd."')","define('sqlpwd','$db_pass')",$str) ;
		$str=str_replace("define('siteurl','".siteurl."')","define('siteurl','$url')",$str) ;
		$str=str_replace("define('logourl','".logourl."')","define('logourl','$url/image/logo.png')",$str) ;
		$f=fopen($fp,"w+");//fopen()的其它开关请参看相关函数
		fputs($f,$str);//把替换后的内容写入文件
		fclose($f);
		//创建数据
		include 'step_'.$step.'.php';
		break;
	case '6'://安装成功
		include 'step_'.$step.'.php';
	break;
}
session_write_close();
?>
</div>
</body>
</html>