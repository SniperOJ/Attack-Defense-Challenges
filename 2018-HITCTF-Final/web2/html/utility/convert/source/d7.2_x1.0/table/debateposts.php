<?php

/**
 * DiscuzX Convert
 *
 * $Id: debateposts.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'debateposts';
$table_target = $db_target->tablepre.'forum_debatepost';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE pid>'$start' ORDER BY pid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['pid'];

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." pid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>