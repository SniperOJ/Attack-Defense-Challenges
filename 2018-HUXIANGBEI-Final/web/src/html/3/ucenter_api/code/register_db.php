<?php
/**
 * UCenter 应用程序开发 Example
 *
 * 应用程序有自己的用户表，用户注册、激活的 Example 代码
 * 使用到的接口函数：
 * uc_get_user()	必须，获取用户的信息
 * uc_user_register()	必须，注册用户数据
 * uc_authcode()	可选，借用用户中心的函数加解密激活字串和 Cookie
 */

if(empty($_POST['submit'])) {
	//注册表单
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?example=register">';

	if($_GET['action'] == 'activation') {
		echo '激活:';
		list($activeuser) = explode("\t", uc_authcode($_GET['auth'], 'DECODE'));
		echo '<input type="hidden" name="activation" value="'.$activeuser.'">';
		echo '<dl><dt>用户名</dt><dd>'.$activeuser.'</dd></dl>';
	} else {
		echo '注册:';
		echo '<dl><dt>用户名</dt><dd><input name="username"></dd>';
		echo '<dt>密码</dt><dd><input name="password"></dd>';
		echo '<dt>Email</dt><dd><input name="email"></dd></dl>';
	}
	echo '<input name="submit" type="submit">';
	echo '</form>';
} else {
	//在UCenter注册用户信息
	$username = '';
	if(!empty($_POST['activation']) && ($activeuser = uc_get_user($_POST['activation']))) {
		list($uid, $username) = $activeuser;
	} else {
		if(uc_get_user($_POST['username']) && !$db->result_first("SELECT uid FROM {$tablepre}members WHERE username='$_POST[username]'")) {
			//判断需要注册的用户如果是需要激活的用户，则需跳转到登录页面验证
			echo '该用户无需注册，请激活该用户<br><a href="'.$_SERVER['PHP_SELF'].'?example=login">继续</a>';
			exit;
		}

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
			$username = $_POST['username'];
		}
	}
	if($username) {
		$db->query("INSERT INTO {$tablepre}members (uid,username,admin) VALUES ('$uid','$username','0')");
		//注册成功，设置 Cookie，加密直接用 uc_authcode 函数，用户使用自己的函数
		setcookie('Example_auth', uc_authcode($uid."\t".$username, 'ENCODE'));
		echo '注册成功<br><a href="'.$_SERVER['PHP_SELF'].'">继续</a>';
		exit;
	}
}

?>