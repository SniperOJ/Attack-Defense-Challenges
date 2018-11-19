<?php
/**
 * 退出登录
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__).'/../duomiphp/common.php');
require_once(duomi_INC.'/check.admin.php');
$cuserLogin = new userLogin();
$cuserLogin->exitUser();
if(empty($needclose))
{
	header('location:index.php');
}
else
{
	$msg = "<script language='javascript'>
	if(document.all) window.opener=true;
	window.close();
	</script>";
	echo $msg;
}
?>