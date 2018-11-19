<?php

/**
 * DiscuzX Convert
 *
 * $Id: uc_pms.php 15815 2010-08-27 02:56:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'uc_pms';
$table_target = $db_target->tablepre.'ucenter_pms';
$limit = $setting['limit']['uc_pms'] ? $setting['limit']['uc_pms'] : 2500;
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
	$query = $db_source->query("SELECT * FROM $table_source WHERE pmid>'$start' ORDER BY pmid LIMIT $limit");
	while ($row = $db_source->fetch_array($query)) {
		$row['fromappid'] = 0;

		$nextid = $row['pmid'];
		$row  = daddslashes($row, 1);

		$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

		$db_target->query("INSERT INTO $table_target SET $data");
	}
}


if($nextid) {
	showmessage("继续转换数据表 ".$table_source." pmid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>