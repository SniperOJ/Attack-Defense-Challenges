<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
/**
 * UCenter 应用程序开发 Example
 *
 * UCenter 简易应用程序，应用程序无数据库
 * 使用到的接口函数：
 * uc_authcode()	可选，借用用户中心的函数加解密 Cookie
 * uc_pm_checknew()	可选，用于全局判断是否有新短消息，返回 $newpm 变量
 */

include './config.inc.php';
include './uc_client/client.php';

/**
 * 获取当前用户的 UID 和 用户名
 * Cookie 解密直接用 uc_authcode 函数，用户使用自己的函数
 */
if(!empty($_COOKIE['Example_auth'])) {
	list($Example_uid, $Example_username) = explode("\t", uc_authcode($_COOKIE['Example_auth'], 'DECODE'));
} else {
	$Example_uid = $Example_username = '';
}

/**
 * 获取最新短消息
 */
$newpm = uc_pm_checknew($Example_uid);

/**
 * 各个功能的 Example 代码
 */
switch(@$_GET['example']) {
	case 'login':
		//UCenter 用户登录的 Example 代码
		include 'code/login_nodb.php';
	break;
	case 'logout':
		//UCenter 用户退出的 Example 代码
		include 'code/logout.php';
	break;
	case 'register':
		//UCenter 用户注册的 Example 代码
		include 'code/register_nodb.php';
	break;
	case 'pmlist':
		//UCenter 未读短消息列表的 Example 代码
		include 'code/pmlist.php';
	break;
	case 'pmwin':
		//UCenter 短消息中心的 Example 代码
		include 'code/pmwin.php';
	break;
	case 'friend':
		//UCenter 好友的 Example 代码
		include 'code/friend.php';
	break;
	case 'avatar':
		//UCenter 设置头像的 Example 代码
		include 'code/avatar.php';
	break;
}

echo '<hr />';
if(!$Example_username) {
	//用户未登录
	echo '<a href="'.$_SERVER['PHP_SELF'].'?example=login">登录</a> ';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?example=register">注册</a> ';
} else {
	//用户已登录
	echo '<script src="ucexample.js"></script><div id="append_parent"></div>';
	echo $Example_username.' <a href="'.$_SERVER['PHP_SELF'].'?example=logout">退出</a> ';
	echo ' <a href="'.$_SERVER['PHP_SELF'].'?example=pmlist">短消息列表</a> ';
	echo $newpm ? '<font color="red">New!('.$newpm.')</font> ' : NULL;
	echo '<a href="###" onclick="pmwin(\'open\')">进入短消息中心</a> ';
	echo ' <a href="'.$_SERVER['PHP_SELF'].'?example=friend">好友</a> ';
	echo ' <a href="'.$_SERVER['PHP_SELF'].'?example=avatar">头像</a> ';
}

?>