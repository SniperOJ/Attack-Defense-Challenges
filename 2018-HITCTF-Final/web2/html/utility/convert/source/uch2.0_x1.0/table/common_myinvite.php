<?php

/**
 * DiscuzX Convert
 *
 * $Id: common_myinvite.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'myinvite';
$table_target = $db_target->tablepre.'common_myinvite';

$limit = $setting['limit']['myinvite'] ? $setting['limit']['myinvite'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($invite = $db_source->fetch_array($query)) {

	$nextid = $invite['id'];

	$invite  = daddslashes($invite, 1);

	$data = implode_field_value($invite, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>