<?php

/**
 * DiscuzX Convert
 *
 * $Id: threadtype.php 18152 2010-11-15 09:52:23Z monkey $
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

$typetids = array();

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
		$name = strip_tags($name);
		$newtypeid = $db_target->insert('forum_threadclass', array('fid' => $nextid, 'name' => addslashes($name)), 1);
		$typenames[$newtypeid] = $name;
		$tquery = $db_target->query("SELECT tid FROM $table_target_thread WHERE fid='$nextid' AND typeid='$typeid'");
		while($trow = $db_target->fetch_array($tquery)) {
			$typetids[$newtypeid][] = $trow['tid'];
		}
	}
	unset($threadtypes['selectbox'], $threadtypes['flat']);
	$threadtypes['icons'] = array();
	$threadtypes['types'] = $typenames;
	$db_target->query("UPDATE $table_target_forumfield SET threadtypes='".serialize($threadtypes)."' WHERE fid='{$row['fid']}'");
}

if($typetids) {
	foreach($typetids as $newtypeid => $row) {
		for($i = 0; $i < count($row); $i += 200) {
			$db_target->query("UPDATE $table_target_thread SET typeid='$newtypeid' WHERE tid IN (".implode(',', array_slice($row, $i, 200)).")");
		}
	}
}

if($nextid) {
	showmessage("继续转换主题分类数据表，fid=$nextid", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>