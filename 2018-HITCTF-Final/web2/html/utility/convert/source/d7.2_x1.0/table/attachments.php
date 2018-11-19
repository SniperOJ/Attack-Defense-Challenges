<?php

/**
 * DiscuzX Convert
 *
 * $Id: attachments.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'attachments';
$table_target = $db_target->tablepre.'forum_attachment';

$limit = $setting['limit']['attachments'] ? $setting['limit']['attachments'] : 2500;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE aid>'$start' ORDER BY aid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['aid'];

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." aid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>