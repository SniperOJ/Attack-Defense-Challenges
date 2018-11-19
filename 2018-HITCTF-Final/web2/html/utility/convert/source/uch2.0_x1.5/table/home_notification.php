<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_notification.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'notification';
$table_target = $db_target->tablepre.'home_notification';

$limit = $setting['limit']['notification'] ? $setting['limit']['notification'] : 1000;

$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($note = $db_source->fetch_array($query)) {

	$nextid = $note['id'];

	$note  = daddslashes($note, 1);

	$data = implode_field_value($note, ',', db_table_fields($db_target, $table_target));

	$db_target->query("REPLACE INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>