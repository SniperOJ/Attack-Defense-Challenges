<?php

/**
 * DiscuzX Convert
 *
 * $Id: forums.php 15819 2010-08-27 03:50:24Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'forums';
$table_target = $db_target->tablepre.'forum_forum';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE fid>'$start' ORDER BY fid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['fid'];

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." fid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
} else {
	$db_target->query("UPDATE $table_target SET status=1 WHERE status=2");
}

?>