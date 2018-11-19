<?php
/**
 * 配置
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($dopost))
{
	$dopost = "";
}
$configfile = duomi_DATA.'/config.ucenter.php';
require_once($configfile);
//保存配置的改动
if($dopost=="save")
{
	$fp = fopen($configfile,'r');
	$configstr = fread($fp,filesize($configfile));
	$configstr = trim($configstr);
	$configstr = substr($configstr, -2) == '?>' ? substr($configstr, 0, -2) : $configstr;
	fclose($fp);
	$connect = 'mysql';
	$ucdbpassnew = $edit___UC_DBPW == '********' ? addslashes(UC_DBPW) : $edit___UC_DBPW;
	$configstr = str_replace("define('UC_DBHOST', '".addslashes(UC_DBHOST)."')", "define('UC_DBHOST', '".$edit___UC_DBHOST."')", $configstr);
	$configstr = str_replace("define('UC_DBUSER', '".addslashes(UC_DBUSER)."')", "define('UC_DBUSER', '".$edit___UC_DBUSER."')", $configstr);
	$configstr = str_replace("define('UC_DBPW', '".addslashes(UC_DBPW)."')", "define('UC_DBPW', '".$ucdbpassnew."')", $configstr);
	$configstr = str_replace("define('UC_DBNAME', '".addslashes(UC_DBNAME)."')", "define('UC_DBNAME', '".$edit___UC_DBNAME."')", $configstr);
	$configstr = str_replace("define('UC_DBTABLEPRE', '".addslashes(UC_DBTABLEPRE)."')", "define('UC_DBTABLEPRE', '`".$edit___UC_DBNAME.'`.'.$edit___UC_DBTABLEPRE."')", $configstr);

	$configstr = str_replace("define('UC_CONNECT', '".addslashes(UC_CONNECT)."')", "define('UC_CONNECT', '".$connect."')", $configstr);
	$configstr = str_replace("define('UC_KEY', '".addslashes(UC_KEY)."')", "define('UC_KEY', '".$edit___UC_KEY."')", $configstr);
	$configstr = str_replace("define('UC_API', '".addslashes(UC_API)."')", "define('UC_API', '".$edit___UC_API."')", $configstr);
	$configstr = str_replace("define('UC_IP', '".addslashes(UC_IP)."')", "define('UC_IP', '".$edit___UC_IP."')", $configstr);
	$configstr = str_replace("define('UC_APPID', '".addslashes(UC_APPID)."')", "define('UC_APPID', '".$edit___UC_APPID."')", $configstr);
	$configstr = str_replace("define('INTEG_UC', ".addslashes(INTEG_UC).")", "define('INTEG_UC', ".$edit___INTEG_UC.")", $configstr);
	if(!is_writeable($configfile))
	{
		echo "配置文件'{$configfile}'不支持写入，无法修改会员参数设置！";
		exit();
	}
	$fp = fopen($configfile,'w');
	flock($fp,3);
	fwrite($fp,$configstr);
	fclose($fp);
	ShowMsg("成功更改会员参数设置！","admin_config_ucenter.php");
	exit();
}
include(duomi_ADMIN.'/html/admin_config_ucenter.htm');
exit();
?>