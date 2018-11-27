<?php
/**
 * UCenter 应用程序开发 Example
 *
 * 应用程序无数据库，用户注册的 Example 代码
 * 使用到的接口函数：
 * uc_user_register()	必须，注册用户数据
 * uc_authcode()	可选，借用用户中心的函数加解密 Cookie
 */

if(empty($_POST['submit'])) {
	//注册表单
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?example=register">';
	echo '注册:';
	echo '<dl><dt>用户名</dt><dd><input name="username"></dd>';
	echo '<dt>密码</dt><dd><input name="password"></dd>';
	echo '<dt>Email</dt><dd><input name="email"></dd></dl>';
	echo '<input name="submit" type="submit">';
	echo '</form>';
} else {
	//在UCenter注册用户信息
	$uid = uc_user_register($_POST['username'], $_POST['password'], $_POST['email']);
	if($uid <= 0) {
		if($uid == -1) {
			echo '用户名不合法';
		} elseif($uid == -2) {
			echo '包含要允许注册的词语';
		} elseif($uid == -3) {
			echo '用户名已经存在';
		} elseif($uid == -4) {
			echo 'Email 格式有误';
		} elseif($uid == -5) {
			echo 'Email 不允许注册';
		} elseif($uid == -6) {
			echo '该 Email 已经被注册';
		} else {
			echo '未定义';
		}
	} else {
		//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('Example_auth', uc_authcode($uid."\t".$_POST['username'], 'ENCODE'));
		echo '注册成功<br><a href="'.$_SERVER['PHP_SELF'].'">继续</a>';
	}
}

?>