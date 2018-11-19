<?php

/**
 * DiscuzX Convert
 *
 * $Id: bbcodes.php 15795 2010-08-27 01:27:04Z monkey $
 */

$curprg = basename(__FILE__);

$table_source_usergroup = $db_source->tablepre.'usergroups';
$table_source = $db_source->tablepre.'bbcodes';
$table_target = $db_target->tablepre.'forum_bbcode';
$table_target_usergroup_field = $db_target->tablepre.'common_usergroup_field';

$limit = 2000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$allowcusbbcodes = array();
$query = $db_source->query("SELECT * FROM $table_source_usergroup");
while($row = $db_source->fetch_array($query)) {
	if($row['allowcusbbcode']) {
		$allowcusbbcodes[] = $row['groupid'];
	}
}


$query = $db_source->query("SELECT * FROM $table_source WHERE id>'$start' ORDER BY id LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['id'];

	$row['perm'] = implode("\t", $allowcusbbcodes);

	$row  = daddslashes($row, 1);


	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." id > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
} else {
	$allowcusbbcodes = array();
	$query = $db_target->query("SELECT * FROM $table_target_usergroup_field");
	while ($row = $db_target->fetch_array($query)) {
		if($row['allowcusbbcode']) {
			$allowcusbbcodes[] = $row['groupid'];
		}
	}
	if($allowcusbbcodes) {
		$db_target->query("UPDATE $table_target SET perm='".implode("\t", $allowcusbbcodes)."' WHERE perm=''");
	}
}
?>