<?php

/**
 * DiscuzX Convert
 *
 * $Id: threadtype.php 16404 2010-09-06 06:38:01Z wangjinbo $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'forumfields';
$table_target = $db_target->tablepre.'forum_threadclass';
$table_target_thread = $db_target->tablepre.'forum_thread';
$table_target_forumfield = $db_target->tablepre.'forum_forumfield';

$limit = 250;
$nextid = 0;
$start = intval(getgpc('start'));

if(empty($start)) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT fid, threadtypes FROM $table_source WHERE threadtypes!='' LIMIT $start, $limit");
while($row = $db_source->fetch_array($query)) {
	$nextid = $row['fid'];
	$threadtypes = (array)unserialize($row['threadtypes']);
	$typenames = array();
	if(!is_array($threadtypes['types'])) {
		$threadtypes['types'] = array();
	}
	$threadtypes_types = $threadtypes['types'];
	ksort($threadtypes_types);
	foreach($threadtypes_types as $typeid => $name) {
		$newtypeid = $db_target->insert('forum_threadclass', array('fid' => $nextid, 'name' => $name), 1);
		$typenames[$newtypeid] = $name;
		$db_target->query("UPDATE $table_target_thread SET typeid='$newtypeid' WHERE fid='$nextid' AND typeid='$typeid'");
	}
	unset($threadtypes['selectbox'], $threadtypes['flat']);
	$threadtypes['icons'] = array();
	$threadtypes['types'] = $typenames;
	$db_target->query("UPDATE $table_target_forumfield SET threadtypes='".serialize($threadtypes)."' WHERE fid='{$row['fid']}'");
}

if($nextid) {
	showmessage("继续转换主题分类数据表，fid=$nextid", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>