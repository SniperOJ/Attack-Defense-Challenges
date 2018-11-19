<?php

/**
 * DiscuzX Convert
 *
 * $Id: common_member_log.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'userlog';
$table_target = $db_target->tablepre.'common_member_log';

$start = getgpc('start');
$start = empty($start) ? 0 : intval($start);
$limit = $setting['limit']['userlog'] ? $setting['limit']['userlog'] : 1000;
$nextid = $limit + $start;
$done = true;

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT uid, action, dateline FROM $table_source ORDER BY uid LIMIT $start, $limit");
while ($value = $db_source->fetch_array($query)) {

	$done = false;

	$value  = daddslashes($value, 1);

	$data = implode_field_value($value, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($done == false) {
	showmessage("继续转换数据表 ".$table_source." uid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>