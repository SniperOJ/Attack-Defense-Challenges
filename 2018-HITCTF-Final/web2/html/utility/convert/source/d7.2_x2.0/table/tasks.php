<?php

/**
 * DiscuzX Convert
 *
 * $Id: tasks.php 15475 2010-08-24 07:34:47Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'tasks';
$table_target = $db_target->tablepre.'common_task';

$limit = 100;
$nextid = 0;

$start = intval(getgpc('start'));
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE newbietask=0 AND taskid>$start ORDER BY taskid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['taskid'];

	unset($row['newbietask'], $row['type']);
	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." taskid > $nextid ", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>