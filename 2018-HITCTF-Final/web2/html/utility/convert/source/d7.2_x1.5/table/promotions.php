<?php

/**
 * DiscuzX Convert
 *
 * $Id: promotions.php 15398 2010-08-24 02:26:44Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'promotions';
$table_target = $db_target->tablepre . 'forum_promotion';

$limit = 1000;
$step = getgpc('step');
$step = intval($step);
$total = getgpc('total');
$total = intval($total);

$continue = false;

if(!$step) {
	$db_target->query("TRUNCATE $table_target");
}

$offset = $step * $limit;

$query = $db_source->query("SELECT * FROM $table_source LIMIT $offset, $limit");
while($row = $db_source->fetch_array($query)) {
	$continue = true;
	$row = daddslashes($row, 1);
	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
	$total ++;
}
$nextstep = $step + 1;
if($continue) {
	showmessage("继续转换数据表 ".$table_source."，已转换 $total 条记录。", "index.php?a=$action&source=$source&prg=$curprg&step=$nextstep&total=$total");
}
?>