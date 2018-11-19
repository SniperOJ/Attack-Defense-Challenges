<?php

/**
 * DiscuzX Convert
 *
 * $Id: threads.php 15719 2010-08-25 23:51:36Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'threads';
$table_target = $db_target->tablepre.'forum_thread';

$limit = $setting['limit']['threads'] ? $setting['limit']['threads'] : 2500;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE tid>'$start' ORDER BY tid LIMIT $limit");
while ($thread = $db_source->fetch_array($query)) {

	$nextid = $thread['tid'];

	unset($thread['iconid'], $thread['itemid'], $thread['supe_pushstatus']);

	$thread  = daddslashes($thread, 1);

	$data = implode_field_value($thread, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." tid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>