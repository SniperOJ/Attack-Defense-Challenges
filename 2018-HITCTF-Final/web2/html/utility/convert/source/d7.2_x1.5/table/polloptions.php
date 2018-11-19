<?php

/**
 * DiscuzX Convert
 *
 * $Id: polloptions.php 19528 2011-01-05 09:12:03Z liulanbo $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'polloptions';
$table_target = $db_target->tablepre . 'forum_polloption';
$table_pollvoter = $db_target->tablepre . 'forum_pollvoter';

$limit = $setting['limit']['polloptions'] ? $setting['limit']['polloptions'] : 1000;

$nextid = 0;
$start = getgpc('start');
$continue = false;

if(!$start) {
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("TRUNCATE $table_pollvoter");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE polloptionid>'$start' LIMIT $limit");
while($row = $db_source->fetch_array($query)) {
	$nextid = $row['polloptionid'];
	$row = daddslashes($row, 1);
	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");

	$voterids = trim($row['voterids']);
	$voterids = explode("\t", $voterids);
	foreach($voterids as $voterid) {
		$count = $db_target->result_first("SELECT COUNT(*) FROM $table_pollvoter WHERE tid='{$row['tid']}' AND uid='$voterid' LIMIT 1");
		if(!$count) {
			$username = daddslashes($db_source->result_first("SELECT username FROM {$db_source->tablepre}members WHERE uid='$voterid'"), 1);
			$db_target->query("INSERT INTO $table_pollvoter SET tid='{$row['tid']}', uid='$voterid', username='$username', options='', dateline='0'");
		}
	}
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." polloptionid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}
?>