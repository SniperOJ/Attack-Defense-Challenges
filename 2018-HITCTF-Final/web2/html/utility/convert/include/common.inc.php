<?php

error_reporting(E_ALL ^ E_NOTICE);
set_time_limit(0);

if(phpversion() < '5.3.0') {
	set_magic_quotes_runtime(0);
}

define('CONVERT_VERSION', '1.0.0');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
define('DISCUZ_ROOT', substr(dirname(__FILE__), 0, -7));
define('TIMESTAMP', time());
define('CACHETABLE', 'common_cache');

require_once DISCUZ_ROOT.'./include/global.func.php';
require_once DISCUZ_ROOT.'./include/db.class.php';

$superglobal = array('superglobal' => 1, 'GLOBALS' => 1,'_GET' => 1,'_POST' => 1,'_REQUEST' => 1,'_COOKIE' => 1,'_SERVER' => 1,'_ENV' => 1,'_FILES' => 1);
foreach ($GLOBALS as $key => $value) {
	if (!isset($superglobal[$key])) {
		$GLOBALS[$key] = null; unset($GLOBALS[$key]);
	}
}

if (isset($_REQUEST['GLOBALS']) || isset($_FILES['GLOBALS'])) {
	error('request_tainting');
}

if(!MAGIC_QUOTES_GPC) {
	$_GET = daddslashes($_GET);
	$_POST = daddslashes($_POST);
	$_COOKIE = daddslashes($_COOKIE);
	$_FILES = daddslashes($_FILES);
}

$_REQUEST = array_merge($_POST, $_GET);
$_REQUEST['method'] = strtolower($_SERVER['REQUEST_METHOD']);
$_REQUEST['script'] = basename($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

$_config = array();
if(!file_exists(DISCUZ_ROOT.'./data/config.inc.php')) {
	define('CONFIG_EMPTY', true);
	include DISCUZ_ROOT.'./data/config.default.php';
} else {
	include DISCUZ_ROOT.'./data/config.inc.php';
}

if(!defined('CONFIG_EMPTY')) {
	if(empty($_config['source']['dbhost'])|| empty($_config['target']['dbhost'])) {
		define('CONFIG_EMPTY', true);
	} else {
		define('CONFIG_EMPTY', false);
	}
}

$timeoffset = 8;
if(function_exists('date_default_timezone_set')) {
	@date_default_timezone_set('Etc/GMT'.($timeoffset > 0 ? '-' : '+').(abs($timeoffset)));
}

function debug($var) {
	echo '<pre>';
	print_r($var);
	exit;
}

?>