<?php

/**
 * DiscuzX Convert
 *
 * $Id: words.php 15815 2010-08-27 02:56:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'words';
$table_target = $db_target->tablepre.'common_word';

$limit = 100;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($data = $db_source->fetch_array($query)) {

	$nextid = $data['id'];

	$data  = daddslashes($data, 1);

	$datalist = implode_field_value($data, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $datalist");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>