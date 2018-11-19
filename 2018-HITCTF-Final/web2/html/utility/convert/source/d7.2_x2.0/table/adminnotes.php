<?php

/**
 * DiscuzX Convert
 *
 * $Id: adminnotes.php 15808 2010-08-27 02:34:26Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'adminnotes';
$table_target = $db_target->tablepre.'common_adminnote';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['id'];

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>