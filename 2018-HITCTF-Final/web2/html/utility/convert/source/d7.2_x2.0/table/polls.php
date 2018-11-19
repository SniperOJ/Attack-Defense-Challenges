<?php

/**
 * DiscuzX Convert
 *
 * $Id: polls.php 18097 2010-11-12 00:44:54Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'polls';
$table_target = $db_target->tablepre . 'forum_poll';

$limit = $setting['limit']['polls'] ? $setting['limit']['polls'] : 1000;
$start = getgpc('start');

$nextid = 0;

if(!$start) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE tid>'$start' ORDER BY tid LIMIT $limit");
while($poll = $db_source->fetch_array($query)) {
	$nextid = $poll['tid'];
	$query_p = $db_source->query("SELECT voterids FROM {$db_source->tablepre}polloptions WHERE tid='{$poll['tid']}'");
	$voterids = array();
	while($option = $db_source->fetch_array($query_p)) {
		$voters_t = explode("\t", $option['voterids']);
		foreach($voters_t as $value) {
			if(!empty($value)) {
				$voterids[] = $value;
			}
		}
	}
	$voters = array_unique($voterids);
	$voterscount = count($voters);

	$poll['voters'] = $voterscount;

	$polloptionpreview = '';
	$query_p = $db_source->query("SELECT polloption FROM {$db_source->tablepre}polloptions WHERE tid='{$poll['tid']}' ORDER BY displayorder LIMIT 2");
	while($option = $db_source->fetch_array($query_p)) {
		$polloptvalue = preg_replace("/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/i", "<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>", $option['polloption']);
		$polloptionpreview .= $polloptvalue."\t";
	}

	$poll['pollpreview'] = $polloptionpreview;
	$poll = daddslashes($poll, 1);
	$data = implode_field_value($poll, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source."，tid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}
?>