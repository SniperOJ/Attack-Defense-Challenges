<?php

/**
 * DiscuzX Convert
 *
 * $Id: addons.php 15808 2010-08-27 02:34:26Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'addons';
$table_target = $db_target->tablepre.'common_addon';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = 1;

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>