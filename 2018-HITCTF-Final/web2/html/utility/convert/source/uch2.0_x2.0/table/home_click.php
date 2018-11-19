<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_click.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'click';
$table_target = $db_target->tablepre.'home_click';

$limit = $setting['limit']['click'] ? $setting['limit']['click'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE clickid>'$start' AND idtype!='tid' ORDER BY clickid LIMIT $limit");
while ($click = $db_source->fetch_array($query)) {

	$nextid = $click['clickid'];

	$click  = daddslashes($click, 1);

	$data = implode_field_value($click, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." clickid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>