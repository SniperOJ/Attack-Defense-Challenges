<?php

/**
 * DiscuzX Convert
 *
 * $Id: navs.php 8876 2010-04-23 07:17:36Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'navs';
$table_target = $db_target->tablepre . 'common_nav';

$limit = 250;
$step = getgpc('step');
$step = intval($step);
$total = getgpc('total');
$total = intval($total);

$continue = false;

if(!$step) {
	$db_target->query("DELETE FROM $table_target WHERE type<>'0'");
	$maxid = $db_target->result_first("SELECT MAX(id) FROM $table_target");
	$maxid = intval($maxid);
	$db_target->query("ALTER TABLE $table_target AUTO_INCREMENT=".($maxid+1));
}

$offset = $step * $limit;

$query = $db_source->query("SELECT * FROM $table_source WHERE type<>'0' ORDER BY parentid DESC LIMIT $offset, $limit");
while($row = $db_source->fetch_array($query)) {
	$continue = true;
	$row['available'] = '0';
	$row = daddslashes($row, 1);
	$orig_id = $row['id'];
	unset($row['id']);
	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
	$newid = $db_target->insert_id();
	$db_target->query("UPDATE $table_target SET parentid='$newid' WHERE parentid='$orig_id'");
	$total ++;
}
$nextstep = $step + 1;
if($continue) {
	showmessage("继续转换数据表 ".$table_source."，已转换 $total 条记录。", "index.php?a=$action&source=$source&prg=$curprg&step=$nextstep&total=$total");
}
?>