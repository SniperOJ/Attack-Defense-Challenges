<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_invite.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'invite';
$table_target = $db_target->tablepre.'common_invite';

$limit = $setting['limit']['invite'] ? $setting['limit']['invite'] : 1000;
$nextid = 0;

$start = getgpc('start');

$query = $db_source->query("SELECT  * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($rs = $db_source->fetch_array($query)) {

	$nextid = $rs['id'];

	unset($rs['id']);

	$rs  = daddslashes($rs, 1);

	$data = implode_field_value($rs, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>