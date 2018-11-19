<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_doing.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'doing';
$table_target = $db_target->tablepre.'home_doing';

$limit = $setting['limit']['doing'] ? $setting['limit']['doing'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT doid,uid,username,`from`,dateline,message,ip,replynum FROM $table_source WHERE doid>'$start' ORDER BY doid LIMIT $limit");
while ($doing = $db_source->fetch_array($query)) {

	$str = 'class="face"';
	$doing['message'] = str_replace($str, '', $doing[message]);
	$nextid = $doing['doid'];

	$doing  = daddslashes($doing, 1);

	$data = implode_field_value($doing, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." doid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>