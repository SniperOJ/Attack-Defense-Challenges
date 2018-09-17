<?php

function AppCentre_SubMenus($id) {
	//m-now
	global $zbp;

	echo '<a href="main.php"><span class="m-left ' . ($id == 1 ? 'm-now' : '') . '">浏览在线应用</span></a>';
	echo '<a href="main.php?method=check"><span class="m-left ' . ($id == 2 ? 'm-now' : '') . '">检查应用更新</span></a>';
	echo '<a href="update.php"><span class="m-left ' . ($id == 3 ? 'm-now' : '') . '">系统更新与校验</span></a>';

	if ($zbp->Config('AppCentre')->username && $zbp->Config('AppCentre')->password) {
		echo '<a href="client.php"><span class="m-left ' . ($id == 9 ? 'm-now' : '') . '">我的应用仓库</span></a>';
	} else {
		echo '<a href="client.php"><span class="m-left ' . ($id == 9 ? 'm-now' : '') . '">登录应用商城</span></a>';
	}

	echo '<a href="setting.php"><span class="m-right ' . ($id == 4 ? 'm-now' : '') . '">设置</span></a>';
	echo '<a href="plugin_edit.php"><span class="m-right ' . ($id == 5 ? 'm-now' : '') . '">新建插件</span></a>';
	echo '<a href="theme_edit.php"><span class="m-right ' . ($id == 6 ? 'm-now' : '') . '">新建主题</span></a>';
}

function AppCentre_GetCheckQueryString() {
	global $zbp;
	$check = '';
	$app = new app;
	if ($app->LoadInfoByXml('theme', $zbp->theme) == true) {
		$check .= $app->id . ':' . $app->modified . ';';
	}
	foreach (explode('|', $zbp->option['ZC_USING_PLUGIN_LIST']) as $id) {
		$app = new app;
		if ($app->LoadInfoByXml('plugin', $id) == true) {
			$check .= $app->id . ':' . $app->modified . ';';
		}
	}
	return $check;
}

function Server_Open($method) {
	global $zbp, $blogversion;

	switch ($method) {
	case 'down':
		Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError', 'ScriptError', PLUGIN_EXITSIGNAL_RETURN);
		header('Content-type: application/x-javascript; Charset=utf-8');
		ob_clean();
		$s = Server_SendRequest(APPCENTRE_URL . '?down=' . GetVars('id', 'GET'));
		if (App::UnPack($s)) {
			$zbp->SetHint('good', '下载APP并解压安装成功!');
		}
		;
		die();
		break;
	case 'search':
		if (trim(GetVars('q', 'GET')) == '') {
			continue;
		}

		$s = Server_SendRequest(APPCENTRE_URL . '?search=' . urlencode(GetVars('q', 'GET')));
		echo str_replace('%bloghost%', $zbp->host . 'zb_users/plugin/AppCentre/main.php', $s);
		break;
	case 'view':
		$s = Server_SendRequest(APPCENTRE_URL . '?' . GetVars('QUERY_STRING', 'SERVER'));
		if (strpos($s, '<!--developer-nologin-->') !== false) {
			if ($zbp->Config('AppCentre')->username || $zbp->Config('AppCentre')->password) {
				$zbp->Config('AppCentre')->username = '';
				$zbp->Config('AppCentre')->password = '';
				$zbp->SaveConfig('AppCentre');
			}
		}
		if (strpos($s, '<!--shop-nologin-->') !== false) {
			if ($zbp->Config('AppCentre')->shop_username || $zbp->Config('AppCentre')->shop_password) {
				$zbp->Config('AppCentre')->shop_username = '';
				$zbp->Config('AppCentre')->shop_password = '';
				$zbp->SaveConfig('AppCentre');
			}
		}
		if (strpos($s, 'app.zblogcn.com') === false) {
			$zbp->ShowHint('bad', '后台访问应用中心故障，不能登录和下载应用，请检查主机空间是否能远程访问app.zblogcn.com。');
		}

		echo str_replace('%bloghost%', $zbp->host . 'zb_users/plugin/AppCentre/main.php', $s);
		break;
	case 'check':
		$s = Server_SendRequest(APPCENTRE_URL . '?check=' . urlencode(AppCentre_GetCheckQueryString())) . '';
		echo str_replace('%bloghost%', $zbp->host . 'zb_users/plugin/AppCentre/main.php', $s);
		break;
	case 'checksilent':
		header('Content-type: application/x-javascript; Charset=utf-8');
		ob_clean();
		$s = Server_SendRequest(APPCENTRE_URL . '?blogsilent=1' . ($zbp->Config('AppCentre')->checkbeta ? '&betablog=1' : '') . '&check=' . urlencode(AppCentre_GetCheckQueryString())) . '';
		if (strpos($s, ';') !== false) {
			$newversion = substr($s, 0, 6);
			$s = str_replace(($newversion . ';'), '', $s);
			if ((int) $newversion > (int) $blogversion) {
				echo '$(".main").prepend("<div class=\'hint\'><p class=\'hint hint_tips\'>提示:Z-BlogPHP有新版本,请用APP应用中心插件的<a href=\'../../zb_users/plugin/AppCentre/update.php\'>“系统更新与校验”</a>升级' . $newversion . '版(' . ($zbp->Config('AppCentre')->checkbeta ? 'Beta' : '') . ').</p></div>");';
			}
		}
		if ($s != 0) {
			echo '$(".main").prepend("<div class=\'hint\'><p class=\'hint hint_tips\'>提示:有' . $s . '个应用需要更新,请在应用中心的<a href=\'../../zb_users/plugin/AppCentre/main.php?method=check\'>“检查应用更新”</a>页升级.</p></div>");';
		}
		die();
		break;
	case 'vaild':
		$data = array();
		$data["username"] = GetVars("app_username");
		$data["password"] = md5(GetVars("app_password"));
		$s = Server_SendRequest(APPCENTRE_URL . '?vaild', $data);
		return $s;
		break;
	case 'submitpre':
		$s = Server_SendRequest(APPCENTRE_URL . '?submitpre=' . urlencode(GetVars('id')));
		return $s;
	case 'submit':
		$app = new App;
		$app->LoadInfoByXml($_GET['type'], $_GET['id']);
		$data["zba"] = $app->Pack();
		$s = Server_SendRequest(APPCENTRE_URL . '?submit=' . urlencode(GetVars('id')), $data);
		return $s;
	case 'shopvaild':
		$data = array();
		$data["shop_username"] = GetVars("shop_username");
		$data["shop_password"] = md5(GetVars("shop_password"));
		$s = Server_SendRequest(APPCENTRE_URL . '?shopvaild', $data);
		return $s;
		break;
	case 'shoplist':
		$s = Server_SendRequest(APPCENTRE_URL . '?shoplist');
		echo str_replace('%bloghost%', $zbp->host . 'zb_users/plugin/AppCentre/main.php', $s);
		break;
	case 'apptype':
		$zbp->Config('AppCentre')->apptype = GetVars("type");
		$zbp->SaveConfig('AppCentre');
		Redirect('main.php');
		break;
	default:
		# code...
		break;
	}

}

function Server_SendRequest($url, $data = array(), $u = '', $c = '') {
	global $zbp;

	$c = AppCentre_Get_Cookies();
	$u = AppCentre_Get_UserAgent();

	if (class_exists('Network')) {
		return Server_SendRequest_Network($url, $data, $u, $c);
	}

	if (function_exists("curl_init") && function_exists('curl_exec')) {
		return Server_SendRequest_CUrl($url, $data, $u, $c);
	}

	if (!ini_get("allow_url_fopen")) {
		return "";
	}
	return "";
}

function Server_SendRequest_CUrl($url, $data = array(), $u, $c) {
	global $zbp;

	$ch = curl_init($url);
	if (extension_loaded('zlib')) {
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	if(isset($_SERVER['HTTP_ACCEPT'])){
		curl_setopt($ch,CURLOPT_HTTPHEADER,array (
	         'Accept: ' . $_SERVER['HTTP_ACCEPT']
	    ));
	}
	curl_setopt($ch, CURLOPT_USERAGENT, $u);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	if (ini_get("safe_mode") == false && ini_get("open_basedir") == false) {
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	}
	if ($c) {
		curl_setopt($ch, CURLOPT_COOKIE, $c);
	}

	if ($data) {
		//POST
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	} else {
		//GET
	}

	$r = curl_exec($ch);
	curl_close($ch);

	return $r;
}

function Server_SendRequest_Network($url, $data = array(), $u, $c) {
	global $zbp;

	$ajax = Network::Create();
	if (!$ajax) {
		throw new Exception('主机没有开启访问外部网络功能');
	}

	if ($data) {
//POST
		$ajax->open('POST', $url);
		$ajax->enableGzip();
		$ajax->setTimeOuts(120, 120, 0, 0);
		$ajax->setRequestHeader('User-Agent', $u);
		$ajax->setRequestHeader('Cookie', $c);
		$ajax->setRequestHeader('Website',$zbp->host);
		if(isset($_SERVER['HTTP_ACCEPT']))
			$ajax->setRequestHeader('Accept',$_SERVER['HTTP_ACCEPT']);
		$ajax->send($data);
	} else {
		$ajax->open('GET', $url);
		$ajax->enableGzip();
		$ajax->setTimeOuts(120, 120, 0, 0);
		$ajax->setRequestHeader('User-Agent', $u);
		$ajax->setRequestHeader('Cookie', $c);
		$ajax->setRequestHeader('Website',$zbp->host);
		if(isset($_SERVER['HTTP_ACCEPT']))
			$ajax->setRequestHeader('Accept',$_SERVER['HTTP_ACCEPT']);
		$ajax->send();
	}

	return $ajax->responseText;
}

function AppCentre_CreateOptionsOfVersion($default) {
	global $zbp;

	$s = null;
	$array = $GLOBALS['zbpvers'];
	krsort($array);
	$i = 0;
	foreach ($array as $key => $value) {
		$i += 1;
		if (($i == 1) or strpos($value, 'Beta') === false) {
			$s .= '<option value="' . $key . '" ' . ($default == $key ? 'selected="selected"' : '') . ' >' . $value . '</option>';
		}

	}
	return $s;
}

function AppCentre_GetHttpContent($url) {

	if (function_exists("GetHttpContent")) {
		return GetHttpContent($url);
	}

	$r = null;
	if (function_exists("curl_init")) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if (ini_get("safe_mode") == false && ini_get("open_basedir") == false) {
			curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		}
		$r = curl_exec($ch);
		curl_close($ch);
	} elseif (ini_get("allow_url_fopen")) {
		$r = file_get_contents($url);
	}

	return $r;
}

function AppCentre_crc32_signed($num) {
	$crc = crc32($num);
	if ($crc & 0x80000000) {
		$crc ^= 0xffffffff;
		$crc += 1;
		$crc = -$crc;
	}
	return $crc;
}

$AppCentre_dirs = array();
$AppCentre_files = array();

function AppCentre_GetAllFileDir($dir) {
	global $AppCentre_dirs;
	global $AppCentre_files;
	if (function_exists('scandir')) {
		foreach (scandir($dir) as $d) {
			if (is_dir($dir . $d)) {
				if (substr($d, 0, 1) != '.') {
					AppCentre_GetAllFileDir($dir . $d . '/');
					$AppCentre_dirs[] = $dir . $d . '/';
				}
			} else {
				$AppCentre_files[] = $dir . $d;
			}
		}
	} else {
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if (substr($file, 0, 1) != '.') {
					if (is_dir($dir . $file)) {
						$AppCentre_dirs[] = $dir . $file . '/';
						AppCentre_GetAllFileDir($dir . $file . '/');
					} else {
						$AppCentre_files[] = $dir . $file;
					}
				}
			}
			closedir($handle);
		}
	}

}

function AppCentre_Pack($app, $gzip) {

	$s = $app->Pack();

	if ($gzip) {
		return gzencode($s, 9, FORCE_GZIP);
	} else {
		return $s;
	}

}

function AppCentre_PHPVersion($default) {
	global $zbp;

	$s = null;
	$array = array(
		'5.2'=>'5.2',
		'5.3'=>'5.3',
		'5.4'=>'5.4',
		'5.5'=>'5.5',
		'5.6'=>'5.6',
		'7.0'=>'7.0',
		'7.1'=>'7.1',
		);
	$i = 0;
	foreach ($array as $key => $value) {
		$s .= '<option value="' . $key . '" ' . ($default == $key ? 'selected="selected"' : '') . ' >' . $value . '</option>';
	}
	return $s;
}