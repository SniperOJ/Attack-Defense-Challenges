<?php

/**
 * DiscuzX Convert
 *
 * $Id: activities.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'activities';
$table_source_aa = $db_source->tablepre.'activityapplies';
$table_target = $db_target->tablepre.'forum_activity';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE tid>'$start' ORDER BY tid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['tid'];

	$row['applynumber'] = $db_source->result_first("SELECT COUNT(*) FROM $table_source_aa WHERE tid='$row[tid]' AND verified=1");
	$row = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." tid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>