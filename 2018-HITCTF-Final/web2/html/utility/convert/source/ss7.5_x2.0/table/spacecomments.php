<?php

/**
 * DiscuzX Convert
 *
 * $Id: spacecomments.php 15777 2010-08-26 04:00:58Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'spacecomments';
$table_target = $db_target->tablepre.'portal_comment';

$limit = 150;
$nextid = 0;

$start = getgpc('start');

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE cid>'$start' ORDER BY cid LIMIT $limit");
while ($rs = $db_source->fetch_array($query)) {

	$nextid = $rs['cid'];

	$setarr = array();
	$setarr['cid'] = $rs['cid'];
	$setarr['uid'] = $rs['authorid'];
	$setarr['username'] = $rs['author'];
	$setarr['id'] = $rs['itemid'];
	$setarr['idtype'] = 'aid';
	$setarr['postip'] = $rs['ip'];
	$setarr['dateline'] = $rs['dateline'];
	$setarr['message'] = $rs['message'];

	$setarr  = daddslashes($setarr, 1);

	$data = implode_field_value($setarr, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." cid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>