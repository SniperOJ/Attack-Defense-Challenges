<?php

/**
 * DiscuzX Convert
 *
 * $Id: attachments.php 15777 2010-08-26 04:00:58Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'attachments';
$table_target = $db_target->tablepre.'portal_attachment';

$limit = 150;
$nextid = 0;

$start = getgpc('start');

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE aid>'$start' ORDER BY aid LIMIT $limit");
while ($rs = $db_source->fetch_array($query)) {

	$nextid = $rs['aid'];

	$setarr = array();
	$setarr['uid'] = $rs['uid'];
	$setarr['dateline'] = $rs['dateline'];
	$setarr['filename'] = $rs['filename'];
	$setarr['filetype'] = $rs['attachtype'];
	$setarr['filesize'] = $rs['size'];
	$setarr['attachment'] = $rs['filepath'];
	$setarr['isimage'] = $rs['isimage'];
	$setarr['thumb'] = empty($rs['thumbpath']) ? '0' : '2';
	$setarr['remote'] = '0';
	$setarr['aid'] = $rs['itemid'];

	$setarr  = daddslashes($setarr, 1);

	$data = implode_field_value($setarr, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>