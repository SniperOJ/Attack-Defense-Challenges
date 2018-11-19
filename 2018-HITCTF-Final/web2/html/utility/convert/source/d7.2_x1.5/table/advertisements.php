<?php

/**
 * DiscuzX Convert
 *
 * $Id: advertisements.php 15808 2010-08-27 02:34:26Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'advertisements';
$table_target = $db_target->tablepre.'common_advertisement';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE advid>'$start' ORDER BY advid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['advid'];
	$row['targets'] = 'forum';

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." advid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>