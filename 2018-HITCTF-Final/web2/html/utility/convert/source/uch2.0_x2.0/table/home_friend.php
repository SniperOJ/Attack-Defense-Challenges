<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_friend.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'friend';

$limit = $setting['limit']['friend'] ? $setting['limit']['friend'] : 10000;

$nextid = 0;

$start = getgpc('start');
$start = empty($start) ? 0 : $start;

if($start == 0) {
	$db_target->query("TRUNCATE ".$db_target->tablepre.'home_friend_request');
}

$nextid = $start + $limit;
$done = true;

$query = $db_source->query("SELECT * FROM $table_source ORDER BY uid LIMIT $start, $limit");
while ($rs = $db_source->fetch_array($query)) {

	$done = false;

	$rs  = daddslashes($rs, 1);

	if($rs['status']) {
		$table_target = $db_target->tablepre.'home_friend';
		if(empty($rs['fusername'])) {
			$subquery = $db_source->query("SELECT username FROM ".$db_source->tablepre.'space'." WHERE uid='$rs[fuid]]'");
			$rs['fusername'] = $db_source->result($subquery, 0);
			$rs['fusername'] = addslashes($rs['fusername']);
		}
		$rs['note'] = '';
	} else {
		$_uid = $rs['uid'];
		$_fuid = $rs['fuid'];
		$rs['uid'] = $_fuid;
		$rs['fuid'] = $_uid;

		$subquery = $db_source->query("SELECT username FROM ".$db_source->tablepre.'space'." WHERE uid='$_uid'");
		$rs['fusername'] = $db_source->result($subquery, 0);
		$rs['fusername'] = addslashes($rs['fusername']);

		$table_target = $db_target->tablepre.'home_friend_request';
	}


	$data = implode_field_value($rs, ',', db_table_fields($db_target, $table_target));

	$db_target->query("REPLACE INTO $table_target SET $data");

}

if($done == false) {
	showmessage("继续转换数据表 ".$table_source." start> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>