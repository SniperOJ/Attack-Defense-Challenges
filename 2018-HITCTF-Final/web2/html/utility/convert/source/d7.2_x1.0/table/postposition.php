<?php

/**
 * DiscuzX Convert
 *
 * $Id: postposition.php 8815 2010-04-23 02:05:15Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'postposition';
$table_target = $db_target->tablepre . 'forum_postposition';
$table_threads = $db_source->tablepre . 'threads';

$limit = 2500;
$step = getgpc('step');
$step = intval($step);
$total = getgpc('total');
$total = intval($total);

$continue = false;

if(!$step) {
	$db_target->query("TRUNCATE $table_target");
}

$offset = $step * $limit;

$query = $db_source->query("SELECT pp.*, t.fid FROM $table_source pp LEFT JOIN $table_threads t ON pp.tid=t.tid LIMIT $offset, $limit");
while($row = $db_source->fetch_array($query)) {
	$continue = true;
	$row = daddslashes($row, 1);
	$row['stick'] = 0;
	$row['dateline'] = 0;
	$row['expiration'] = 0;
	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
	$total ++;
}
$nextstep = $step + 1;
if($continue) {
	showmessage("继续转换数据表 ".$table_source."，已转换 $total 条记录。", "index.php?a=$action&source=$source&prg=$curprg&step=$nextstep&total=$total");
}
?>