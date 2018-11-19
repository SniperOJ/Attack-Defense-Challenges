<?php

/**
 * DiscuzX Convert
 *
 * $Id: taskvars.php 15475 2010-08-24 07:34:47Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'taskvars';
$table_target = $db_target->tablepre.'common_taskvar';

$limit = 100;
$nextid = 0;

$start = intval(getgpc('start'));
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$taskids = 0;
$query = $db_source->query("SELECT * FROM ".$db_source->tablepre.'tasks');
while($row = $db_source->fetch_array($query)) {
	$taskids .= ", $row[taskid]";
}

$query = $db_source->query("SELECT * FROM $table_source WHERE taskid IN ($taskids) AND taskvarid>$start ORDER BY taskvarid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['taskvarid'];

	unset($row['extra']);
	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source."  taskvarid > $nextid ", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>