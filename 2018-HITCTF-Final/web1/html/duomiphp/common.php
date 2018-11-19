<?php
/**
 * 
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
error_reporting(0);
define('duomi_INC', preg_replace("|[/\\\]{1,}|",'/',dirname(__FILE__) ) );
define('duomi_ROOT', preg_replace("|[/\\\]{1,}|",'/',substr(duomi_INC,0,-8) ) );
define('duomi_DATA', duomi_ROOT.'/data');
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}
$starttime = microtime();
require_once(duomi_INC.'/common.func.php');
//检查和注册外部提交的变量
foreach($_REQUEST as $_k=>$_v)
{
	if( strlen($_k)>0 && m_eregi('^(cfg_|GLOBALS)',$_k) && !isset($_COOKIE[$_k]) )
	{
		exit('Request var not allow!');
	}
}

function _RunMagicQuotes(&$svar)
{
	if(!get_magic_quotes_gpc())
	{
		if( is_array($svar) )
		{
			foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
		}
		else
		{
			$svar = addslashes($svar);
		}
	}
	return $svar;
}

foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}

//系统相关变量检测
if(!isset($needFilter))
{
	$needFilter = false;
}
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isSafeMode = @ini_get("safe_mode");
if( m_eregi('windows', @getenv('OS')) )
{
	$isSafeMode = false;
}

//Session保存路径
/*$sessSavePath = duomi_DATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
	session_save_path($sessSavePath);
}
*/
$timestamp = time();

//数据库配置文件
require_once(duomi_DATA.'/common.inc.php');

//系统配置参数
require_once(duomi_DATA."/config.cache.inc.php");

//php5.1版本以上时区设置
//由于这个函数对于是php5.1以下版本并无意义，因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
	$time51 = $cfg_cli_time * -1;
	@date_default_timezone_set('Etc/GMT'.$time51);
}
$cfg_isUrlOpen = @ini_get("allow_url_fopen");

//站点根目录
//$cfg_basedir = m_eregi_replace($cfg_cmspath.'duomiphp$','',duomi_INC);
$cfg_basedir = m_eregi_replace('duomiphp$','',duomi_INC);

//模板的存放目录
$cfg_duomiui_dir = 'duomiui';

$cfg_phpurl = '/'.$cfg_cmspath;

//附件目录
$cfg_medias_dir = '/'.$cfg_cmspath.$cfg_upload_dir;

//上传的普通图片的路径,建议按默认
$cfg_image_dir = $cfg_medias_dir.'/allimg';

//上传的缩略图
$ddcfg_image_dir = $cfg_medias_dir.'/litimg';

//系统摘要信息，****请不要删除本项**** 否则系统无法正确接收系统漏洞或升级信息
$cfg_version = 'V2.3.129_UTF-8_Build_2014.09.16';
$verLockFile = duomi_ROOT.'/data/admin/ver.txt';
$fp = fopen($verLockFile,'r');
$verLocal = trim(fread($fp,64));
fclose($fp);
$verLocal = substr($verLocal,8,strlen($verLocal)-8);
$cfg_version =$verLocal;
$cfg_soft_lang = 'utf-8';
$cfg_softname = 'DuomiCms影视管理系统';
$cfg_soft_enname = 'DuomiCms';
$cfg_soft_devteam = 'DuomiCms官方团队';

//新建目录的权限，如果你使用别的属性，本程不保证程序能顺利在Linux或Unix系统运行
$cfg_dir_purview = 0755;

/*if($cfg_sendmail_bysmtp=='Y' && !empty($cfg_smtp_usermail))
{
	$cfg_adminemail = $cfg_smtp_usermail;
}*/

if(!isset($cfg_NotPrintHead)) {
	header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

if($_FILES)
{
	require_once(duomi_INC.'/uploadsafe.inc.php');
}

//引入数据库类
require_once(duomi_INC.'/sql.class.php');
require_once(duomi_INC.'/updatesql.class.php');

require_once(duomi_INC.'/image.class.php');
require_once(duomi_INC.'/collection.class.php');
//全局常用函数
require_once(duomi_INC.'/link.func.php');
require_once(duomi_INC.'/mkhtml.func.php');

//引入语言包
require_once(duomi_INC.'/lang.php');
//计划任务
include duomi_DATA.'/cron.cache.php';
include duomi_INC.'/cron.func.php';
if($cronnextrun && $cronnextrun <= $timestamp) {
	if($cron = $dsql->GetOne("SELECT * FROM duomi_crons WHERE available>'0' AND nextrun<=$timestamp ORDER BY nextrun")) {
		$lockfile = duomi_DATA.'/runcron_'.$cron['cronid'].'.lock';
		$cron['filename'] = str_replace(array('..', '/', '\\'), '', $cron['filename']);
		$filename=$cron['filename'];
		if(strpos($filename,'$')!==false){$filenameArr=explode("$",$filename);$filename=$filenameArr[0];}
		if(strpos($filename,'#')!==false){$filenameArr=explode("#",$filename);$filename=$filenameArr[0];}
		$cronfile = duomi_INC.'/crons/'.$filename;
		if(is_writable($lockfile) && filemtime($lockfile) > $timestamp - 600) {
		} else {
			@touch($lockfile);
		}
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		cronnextrun($cron);
		if(!include_once $cronfile) {
		}
		@unlink($lockfile);
	}
	$nextrun = $dsql->GetOne("SELECT nextrun FROM duomi_crons WHERE available>'0' ORDER BY nextrun");
	if(!$nextrun === FALSE) {
		updatecronscache();
	}
}
?>