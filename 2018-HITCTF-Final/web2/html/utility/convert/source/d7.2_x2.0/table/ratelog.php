<?php

/**
 * DiscuzX Convert
 *
 * $Id: ratelog.php 15398 2010-08-24 02:26:44Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'ratelog';
$table_target = $db_target->tablepre.'forum_ratelog';

$limit = 1000;
$nextid = 0;

$start = intval(getgpc('start'));
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source ORDER BY dateline LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = 1;

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	$next = $start + $limit;
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=$next");
}

?>