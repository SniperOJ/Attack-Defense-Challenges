<?php
/**
 * DiscuzX Convert
 *
 * $Id: home_config.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'config';
$table_target = $db_target->tablepre.'common_setting';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');

$newsetting = array();

$my_siteid = $my_sitekey = '';
$query = $db_target->query("SELECT * FROM $table_target WHERE skey IN('my_siteid', 'my_sitekey', 'my_search_status')");
while ($value = $db_target->fetch_array($query)) {
	if($value['skey'] == 'my_siteid') {
		$my_siteid = $value['svalue'];
	} elseif($value['skey'] == 'my_sitekey') {
		$my_sitekey = $value['svalue'];
	} elseif($value['skey'] == 'my_search_status') {
		$my_search_status = $value['svalue'];
	}

	$key = addslashes($value['skey'].'_old');
	$val = addslashes($value['svalue']);
	$newsetting[] = "('$key', '$val')";

}
if(isset($my_search_status) && in_array($my_search_status, array(0, 1))) {
	$key = addslashes('my_sitekey_sign_old');
	$val = addslashes(substr(md5(substr(md5($my_siteid.'|'.$my_sitekey), 0, 16)), 16, 16));
	$newsetting[] = "('$key', '$val')";
	$newsetting[] = "('my_search_status', '0')";
}

if(empty($my_siteid) || empty($my_sitekey)){
	$newsetting = array();
}

$validityconfig = array('adminemail', 'updatestat', 'timeoffset', 'maxpage', 'topcachetime', 'allowdomain', 'allowwatermark',
	'holddomain', 'feedday', 'feedmaxnum', 'groupnum', 'closeinvite', 'checkemail', 'networkpage','showallfriendnum',
	'sendmailday', 'feedtargetblank', 'feedread', 'feedhotnum', 'feedhotday', 'feedhotmin', 'privacy',
	'my_status', 'my_siteid', 'my_sitekey', 'my_closecheckupdate', 'my_ip', 'uniqueemail', 'updatestat', 'topcachetime');

$query = $db_source->query("SELECT * FROM $table_source");
while ($value = $db_source->fetch_array($query)) {
	$val = addslashes($value['datavalue']);
	$key = $value['var'];
	if(in_array($key, $validityconfig)) {
		if($key == 'my_status') {
			$val = 0;
			$key = 'my_app_status';
		}
		$newsetting[] = "('$key', '$val')";
	}
}
if(!empty($newsetting)) {
	$db_target->query("REPLACE INTO $table_target (`skey`, `svalue`) VALUES ".implode(',', $newsetting));
}

?>