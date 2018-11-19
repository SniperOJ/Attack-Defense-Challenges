<?php

/**
 * DiscuzX Convert
 *
 * $Id: myrepeats.php 15815 2010-08-27 02:56:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'myrepeats';
$table_target = $db_target->tablepre.'myrepeats';

$limit = 2000;
$nextid = 0;

$query1 = $db_source->result($db_source->query("SHOW FIELDS FROM $table_source", 'SILENT'), 0);
$query2 = $db_target->result($db_target->query("SHOW FIELDS FROM $table_target", 'SILENT'), 0);
$pass = $query1 && $query2;

if($pass) {
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
}

?>