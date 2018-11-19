<?php

/**
 * DiscuzX Convert
 *
 * $Id: typeoptions.php 15719 2010-08-25 23:51:36Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'typeoptions';
$table_target = $db_target->tablepre.'forum_typeoption';

$limit = 100;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE optionid>'$start' ORDER BY optionid LIMIT $limit");
while ($data = $db_source->fetch_array($query)) {

	$nextid = $data['optionid'];

	$threadtype  = daddslashes($data, 1);

	$datalist = implode_field_value($data, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $datalist");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." optionid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>