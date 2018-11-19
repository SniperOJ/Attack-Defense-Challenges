<?php

/**
 * DiscuzX Convert
 *
 * $Id: pollvoter.php 19528 2011-01-05 09:12:03Z liulanbo $
 */

$curprg = basename(__FILE__);
$table_source = $db_source->tablepre . 'polloptions';
$table_target = $db_target->tablepre . 'forum_pollvoter';

$limit = 1000;

$pstep = getgpc('pstep');
$pstep = intval($pstep);

$total = getgpc('total');
$total = intval($total);

$offset = $pstep * $limit;

$continue = false;

$query = $db_source->query("SELECT * FROM $table_source ORDER BY polloptionid LIMIT $offset, $limit");
while($row = $db_source->fetch_array($query)) {
	$voterids = trim($row['voterids']);
	$voterids = explode("\t", $voterids);
	foreach($voterids as $voterid) {
		$options = $db_target->result_first("SELECT options FROM $table_target WHERE tid='{$row['tid']}' AND uid='$voterid'");
		$options = explode("\t", $options);
		if(!in_array($row['polloptionid'], $options)) {
			$options[] = $row['polloptionid'];
		}
		$options_str = trim(implode("\t", $options));
		$db_target->query("UPDATE $table_target SET options='$options_str' WHERE tid='{$row['tid']}' AND uid='$voterid'");
	}
	$continue = true;
	$total ++;
}

$nextpstep = $pstep + 1;
if($continue) {
	showmessage("继续转换数据表 ".$table_source."，已转换 $total 条记录。", "index.php?a=$action&source=$source&prg=$curprg&pstep=$nextpstep&total=$total");
}
?>