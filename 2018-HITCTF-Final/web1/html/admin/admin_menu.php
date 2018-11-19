<?php
/**
 * 栏目
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
$defaultIcoFile = duomi_ROOT.'/data/admin/quickmenu.txt';
$myIcoFile = duomi_ROOT.'/data/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';
if(!file_exists($myIcoFile)) {
	$myIcoFile = $defaultIcoFile;
}
if(empty($dopost)) {
	$dopost = '';
}
if($dopost=='edit'){
	$menu = stripslashes($menu);
	$myIcoFileTrue = duomi_ROOT.'/data/admin/quickmenu-'.$cuserLogin->getUserID().'.txt';
	$fp = fopen($myIcoFileTrue,'w');
	fwrite($fp,$menu);
	fclose($fp);
	ShowMsg("成功修改快捷操作项目！","admin_menu.php");
	exit();
}
else
{
	$fp = fopen($myIcoFile,'r');
	$oldct = trim(fread($fp,filesize($myIcoFile)+1));
	fclose($fp);
	include(duomi_ADMIN.'/html/admin_menu.htm');
	exit();
}
?>