<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_mailcron.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'mailcron';
$table_target = $db_target->tablepre.'common_mailcron';

$table_source_rel = $db_source->tablepre.'mailqueue';
$table_target_rel = $db_target->tablepre.'common_mailqueue';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("TRUNCATE $table_target_rel");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE cid>'$start' ORDER BY cid LIMIT $limit");
$mcids = array();
while ($rs = $db_source->fetch_array($query)) {

	$mcids[] = $rs['cid'];

	$nextid = $rs['cid'];

	$rs  = daddslashes($rs, 1);

	$data = implode_field_value($rs, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if (!empty($mcids)) {
	$query = $db_source->query("SELECT  * FROM $table_source_rel WHERE cid IN (".dimplode($mcids).")");
	while ($rs = $db_source->fetch_array($query)) {

		$rs  = daddslashes($rs, 1);

		$data = implode_field_value($rs, ',', db_table_fields($db_target, $table_target_rel));

		$db_target->query("INSERT INTO $table_target_rel SET $data");
	}
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." mcid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>