<?php

/**
 * DiscuzX Convert
 *
 * $Id: do_config.inc.php 10469 2010-05-11 09:12:14Z monkey $
 */

if(!defined('DISCUZ_ROOT')) {
	exit('Access error');
}

$configfile = DISCUZ_ROOT.'./data/config.inc.php';
$configfile_default = DISCUZ_ROOT.'./data/config.default.php';

@touch($configfile);
if(!is_writable($configfile)) {
	showmessage('config_write_error');
}

$config_default = loadconfig('config.default.php');
$error = array();
if(submitcheck()) {
	$newconfig = getgpc('newconfig');
	if(is_array($newconfig)) {
		$checkarray = $setting['config']['ucenter'] ? array('source', 'target', 'ucenter') : array('source', 'target');
		foreach ($checkarray as $key) {
			if(!empty($newconfig[$key]['dbhost'])) {
				$check = mysql_connect_test($newconfig[$key], $key);
				if($check < 0) {
					$error[$key] = lang('mysql_connect_error_'.abs($check));
				}
			} else {
				$error[$key] = lang('mysql_config_error');
			}
		}
		save_config_file($configfile, $newconfig, $config_default);
		if(empty($error)) {
			$db_target = new db_mysql($newconfig['target']);
			$db_target->connect();
			delete_process('all');
			showmessage('config_success', 'index.php?a=select&source='.$source);
		}
	}
}

showtips('如果无法显示设置项目，请删除文件 data/config.inc.php');
$config = loadconfig('config.inc.php');
if(empty($config)) {
	$config = $config_default;
}
show_form_header();
show_config_input('source', $config['source'], $error['source']);
show_config_input('target', $config['target'], $error['target']);
if($setting['config']['ucenter']) {
	show_config_input('ucenter', $config['ucenter'], $error['ucenter']);
}
show_form_footer('submit', 'config_save');

?>