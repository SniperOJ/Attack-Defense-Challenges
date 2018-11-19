<?php

/**
 * DiscuzX Convert
 *
 * $Id: index.php 10469 2010-05-11 09:12:14Z monkey $
 */

require './include/common.inc.php';

$action = getgpc('a');
$action = empty($action) ? getgpc('action') : $action;
$source = getgpc('source') ? getgpc('source') : getgpc('s');
$step = getgpc('step');
$start = getgpc('start');

$setting = array();
if($source) {
	if(!$setting = loadsetting($source)) {
		showmessage('load_setting_error');
	}
}

$action = empty($action) || empty($source) ? 'source' : $action;
showheader($action, $setting);

if($action == 'source') {
	require DISCUZ_ROOT.'./include/do_source.inc.php';
} elseif($action == 'config' || CONFIG_EMPTY) {
	require DISCUZ_ROOT.'./include/do_config.inc.php';
} elseif($action == 'setting') {
	require DISCUZ_ROOT.'./include/do_setting.inc.php';
} elseif($action == 'select') {
	require DISCUZ_ROOT.'./include/do_select.inc.php';
} elseif($action == 'convert') {
	require DISCUZ_ROOT.'./include/do_convert.inc.php';
} elseif($action == 'finish') {
	require DISCUZ_ROOT.'./include/do_finish.inc.php';
} else {
	showmessage('非法请求');
}

showfooter();
?>