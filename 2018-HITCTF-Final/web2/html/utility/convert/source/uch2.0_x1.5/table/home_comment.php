<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_comment.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'comment';
$table_target = $db_target->tablepre.'home_comment';

$limit = $setting['limit']['comment'] ? $setting['limit']['comment'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE cid>'$start' AND (idtype='blogid' OR idtype='uid' OR idtype='picid' OR idtype='sid') ORDER BY cid LIMIT $limit");
while ($comment = $db_source->fetch_array($query)) {

	$nextid = $comment['cid'];

	$comment  = daddslashes($comment, 1);

	$data = implode_field_value($comment, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." cid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>