<?php
#注册插件
RegisterPlugin("AppCentre", "ActivePlugin_AppCentre");

if(stripos($GLOBALS['bloghost'],'https://')!==false){
	define('APPCENTRE_URL', 'https://app.zblogcn.com/client/');
	define('APPCENTRE_SYSTEM_UPDATE', 'https://update.zblogcn.com/zblogphp/');
	define('APPCENTRE_API_URL', 'https://app.zblogcn.com/api/index.php?api=');	
}else{
	define('APPCENTRE_URL', 'http://app.zblogcn.com/client/');
	define('APPCENTRE_SYSTEM_UPDATE', 'http://update.zblogcn.com/zblogphp/');
	define('APPCENTRE_API_URL', 'http://app.zblogcn.com/api/index.php?api=');
}
define('APPCENTRE_API_APP_ISBUY', 'isbuy');
define('APPCENTRE_API_USER_INFO', 'userinfo');
define('APPCENTRE_API_ORDER_LIST', 'orderlist');
define('APPCENTRE_API_ORDER_DETAIL', 'orderdetail');

define('APPCENTRE_PUBLIC_KEY','-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3HYTjyOIzYnJtIl4M50l
aYgEQmRGeOQA+5H1Ze3Fgc7bbEc+DtJMAmwYaGR3+ULkL4c0m/KXXxujTgEfxGkk
fO7XI7Z0b1EWFm4M7IbXox6LaLU6mK4OK5nMWWyIyawYn0bdw6X/vaXEyzkDE8fP
ZGGPo5OydyZdTm47lXdCewyxk1CQ6nMs75u0mLjnDfsFXNiDx8hvXODnTSJKzb+C
154qg0uRXjaB2ylnhJKDcQCFAbg5uy0iRcrp7+CFG4qvk0c7d/xRRjqY/y3HI+o5
29/vvByD9KVXfWQQI6unfWfO1uEegXcgypHKHRmuyZoIDH7r56sleXKcN0OLesxp
zwIDAQAB
-----END PUBLIC KEY-----');

#定义版本号列
$zbpvers=array();
$zbpvers['130707']='1.0 Beta Build 130707';
$zbpvers['131111']='1.0 Beta2 Build 131111';
$zbpvers['131221']='1.1 Taichi Build 131221';
$zbpvers['140220']='1.2 Hippo Build 140220';
$zbpvers['140614']='1.3 Wonce Build 140614';
$zbpvers['150101']='1.4 Deeplue Build 150101';
$zbpvers['151626']='1.5 Zero Build 151626';
$zbpvers['151740']='1.5.1 Zero Build 151740';

if(!isset($zbpvers[$GLOBALS['blogversion']])){
    if(defined('ZC_VERSION_FULL'))
    	$zbpvers[$GLOBALS['blogversion']] = ZC_VERSION_FULL;
    else
    	$zbpvers[$GLOBALS['blogversion']] = ZC_BLOG_VERSION;
}

function ActivePlugin_AppCentre() {
	global $zbp;
	Add_Filter_Plugin('Filter_Plugin_Admin_LeftMenu', 'AppCentre_AddMenu');
	Add_Filter_Plugin('Filter_Plugin_Admin_ThemeMng_SubMenu', 'AppCentre_AddThemeMenu');
	Add_Filter_Plugin('Filter_Plugin_Admin_PluginMng_SubMenu', 'AppCentre_AddPluginMenu');
	Add_Filter_Plugin('Filter_Plugin_Admin_SiteInfo_SubMenu', 'AppCentre_AddSiteInfoMenu');

	if (method_exists('ZBlogPHP', 'LoadLanguage')) {
		$zbp->LoadLanguage('plugin', 'AppCentre');
	} else {
		if (is_readable($f = $zbp->path . 'zb_users/plugin/AppCentre/language/' . $zbp->option['ZC_BLOG_LANGUAGEPACK'] . '.php')) {
			$zbp->lang['AppCentre'] = require $f;
		} elseif (is_readable($f = $zbp->path . 'zb_users/plugin/AppCentre/language/' . 'zh-cn' . '.php')) {
			$zbp->lang['AppCentre'] = require $f;
		}

	}
}

function InstallPlugin_AppCentre() {
	global $zbp;
	$zbp->Config('AppCentre')->enabledcheck = 1;
	$zbp->Config('AppCentre')->checkbeta = 0;
	$zbp->Config('AppCentre')->enabledevelop = 0;
	$zbp->Config('AppCentre')->enablegzipapp = 0;
	$zbp->SaveConfig('AppCentre');
}

function AppCentre_AddMenu(&$m) {
	global $zbp;
	$m['nav_AppCentre'] = MakeLeftMenu("root", $zbp->lang['AppCentre']['name'], $zbp->host . "zb_users/plugin/AppCentre/main.php", "nav_AppCentre", "aAppCentre", $zbp->host . "zb_users/plugin/AppCentre/images/Cube1.png");
}

function AppCentre_AddSiteInfoMenu() {
	global $zbp;
	if ($zbp->Config('AppCentre')->enabledcheck) {
		$last = (int) $zbp->Config('AppCentre')->lastchecktime;
		if ((time() - $last) > 11 * 60 * 60) {
			echo "<script type='text/javascript'>$(document).ready(function(){  $.getScript('{$zbp->host}zb_users/plugin/AppCentre/main.php?method=checksilent&rnd='); });</script>";
			$zbp->Config('AppCentre')->lastchecktime = time();
			$zbp->SaveConfig('AppCentre');
		}
	}
	if ($zbp->version >= 150101 && (int) $zbp->option['ZC_LAST_VERSION'] < 150101) {
		echo "<script type='text/javascript'>$('.main').prepend('<div class=\"hint\"><p class=\"hint hint_tips\"><a href=\"{$zbp->host}zb_users/plugin/AppCentre/update.php?updatedb\">请点击该链接升级数据库结构</a></p></div>');</script>";
	}

}

function AppCentre_AddThemeMenu() {
	global $zbp;
	echo "<script type='text/javascript'>var app_enabledevelop=" . (int) $zbp->Config('AppCentre')->enabledevelop . ";</script>";
	echo "<script type='text/javascript'>var app_username='" . $zbp->Config('AppCentre')->username . "';</script>";
	echo "<script src='{$zbp->host}zb_users/plugin/AppCentre/theme.js' type='text/javascript'></script>";
}

function AppCentre_AddPluginMenu() {
	global $zbp;
	echo "<script type='text/javascript'>var app_enabledevelop=" . (int) $zbp->Config('AppCentre')->enabledevelop . ";</script>";
	echo "<script type='text/javascript'>var app_username='" . $zbp->Config('AppCentre')->username . "';</script>";
	echo "<script src='{$zbp->host}zb_users/plugin/AppCentre/plugin.js' type='text/javascript'></script>";
}

//$appid是App在应用中心的发布后的文章ID数字号，非App的ID名称。
function AppCentre_App_Check_ISBUY($appid) {
	global $zbp;
	$postdate = array(
		'email' => $zbp->Config('AppCentre')->shop_username,
		'password' => $zbp->Config('AppCentre')->shop_password,
		'appid' => $appid,
		    );
	$http_post = Network::Create();
	$http_post->open('POST', APPCENTRE_API_URL . APPCENTRE_API_APP_ISBUY);
	$http_post->setRequestHeader('Referer', substr($zbp->host, 0, -1) . $zbp->currenturl);

	$http_post->send($postdate);
	$result = json_decode($http_post->responseText, true);
	return $result;
}

function AppCentre_Get_Cookies(){
	global $zbp;
	$c = '';
	$un = $zbp->Config('AppCentre')->username;
	$ps = $zbp->Config('AppCentre')->password;
	$c .= ' apptype=' . urlencode($zbp->Config('AppCentre')->apptype) . '; ';
	$c .= ' app_guestver=' . urlencode('2.0') . '; ';
	$c .= ' app_host=' . urlencode($zbp->host) . '; ';
	$c .= ' app_email=' . urlencode($zbp->user->Email) . '; ';
	$c .= ' app_user=' . urlencode($zbp->user->Name) . '; ';
	if ($un && $ps) {
		$c .= "username=" . urlencode($un) . "; password=" . urlencode($ps);
	}

	$shopun = $zbp->Config('AppCentre')->shop_username;
	$shopps = $zbp->Config('AppCentre')->shop_password;
	if ($shopun && $shopps) {
		$c .= "; shop_username=" . urlencode($shopun) . "; shop_password=" . urlencode($shopps);
	}
	return $c;
}

function AppCentre_Get_UserAgent(){
	global $zbp;
    $app = $zbp->LoadApp('plugin', 'AppCentre');
    $pv = strpos(phpversion(), '-')===false? phpversion() : substr(phpversion(),0,strpos(phpversion(), '-'));
	if(isset($GLOBALS['blogversion'])) {
		$u = 'ZBlogPHP/' . $GLOBALS['blogversion'] . ' AppCentre/'. $app->modified . 'PhpVer/' . $pv . ' ' . GetGuestAgent();
	}
	else {
		$u = 'ZBlogPHP/' . substr(ZC_BLOG_VERSION, -6, 6) . ' AppCentre/'. $app->modified . 'PhpVer/' . $pv . ' ' . GetGuestAgent();
	}
	return $u;
}


function AppCentre_Check_App_IsBuy($appid,$throwerror=true){
	global $zbp;
	$ajax = Network::Create();

	$url = str_replace('http://','https://',APPCENTRE_URL) . '?checkbuy';
	$c = AppCentre_Get_Cookies();
	$u = AppCentre_Get_UserAgent();

	$appid = $appid;
	$username = $zbp->Config('AppCentre')->username;
	$password = $zbp->Config('AppCentre')->password;
	$host = $zbp->host;

	$data = array();

	$data['appid'] = $appid;
	$data['host'] = $zbp->host;

	$data['includefilehash'] = file_get_contents($zbp->path . 'zb_users/plugin/AppCentre/include.php');
	$data['includefilehash'] = md5(str_replace(array('\r','\n'), '', $data['includefilehash']));


	$pu_key = openssl_pkey_get_public(APPCENTRE_PUBLIC_KEY);

	$encrypted = '';
	openssl_public_encrypt(implode('|',$data),$encrypted,$pu_key);//公钥加密  
	$encrypted = base64_encode($encrypted);  
	$data = array();
	$data['info'] = $encrypted;

	$ajax->open('POST', $url);
	//$ajax->enableGzip();
	$ajax->setTimeOuts(120, 120, 0, 0);
	$ajax->setRequestHeader('User-Agent', $u);
	$ajax->setRequestHeader('Cookie', $c);
	$ajax->setRequestHeader('Website',$zbp->host);
	$ajax->send($data);


	$encrypted = $ajax->responseText;
	openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//公钥解密

	if(md5($zbp->Config('AppCentre')->username . 'ok') == $decrypted){
		return true;
	}else{
		if($throwerror == true){
			$zbp->ShowError($decrypted);
			die();
		}else{
			return false;
		}
	}

	return false;

}
