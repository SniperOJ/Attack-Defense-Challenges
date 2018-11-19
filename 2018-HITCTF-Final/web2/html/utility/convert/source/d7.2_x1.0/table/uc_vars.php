<?php

/**
 * DiscuzX Convert
 *
 * $Id: uc_vars.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'uc_vars';
$table_target = $db_target->tablepre.'ucenter_vars';
$limit = 2000;
$nextid = 0;
$nexttable = 0;
$start = getgpc('start');
if(empty($start)) {
	$source_exist = $db_source->result_first("SHOW TABLES LIKE '".substr($table_source, strpos($table_source, '.') + 1)."'");
	$target_exist = $db_target->result_first("SHOW TABLES LIKE '".substr($table_target, strpos($table_target, '.') + 1)."'");
	if(empty($source_exist) || empty($target_exist)) {
		$nexttable = 1;
	} else {
		$start = 0;
		$db_target->query("TRUNCATE $table_target");
	}
}

if(empty($nexttable)) {
	$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
	while ($row = $db_source->fetch_array($query)) {

		$nextid = 1;

		$row  = daddslashes($row, 1);

		$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

		$db_target->query("INSERT INTO $table_target SET $data");
	}
}


if($nextid) {
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>