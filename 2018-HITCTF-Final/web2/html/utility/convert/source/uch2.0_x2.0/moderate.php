<?php

/**
 * DiscuzX Convert
 *
 * $Id: stamp.php 15786 2010-08-27 00:27:21Z monkey $
 */

$table_target = $db_target->tablepre.'common_moderate';
$table_target_home_blog = $db_target->tablepre.'home_blog';
$table_target_home_doing = $db_target->tablepre.'home_doing';
$table_target_home_pic = $db_target->tablepre.'home_pic';
$table_target_home_share = $db_target->tablepre.'home_share';
$table_target_home_comment = $db_target->tablepre.'home_comment';

$query = $db_target->query("SELECT blogid FROM $table_target_home_blog WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('blogid', $row['blogid']);
}

$query = $db_target->query("SELECT doid FROM $table_target_home_doing WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('doid', $row['doid']);
}

$query = $db_target->query("SELECT picid FROM $table_target_home_pic WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('picid', $row['picid']);
}

$query = $db_target->query("SELECT sid FROM $table_target_home_share WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('sid', $row['sid']);
}

$query = $db_target->query("SELECT idtype, cid FROM $table_target_home_comment WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate($row['idtype'].'_cid', $row['cid']);
}

function updatemoderate($idtype, $ids) {
	global $table_target, $db_target;
	$ids = is_array($ids) ? $ids : array($ids);
	if(!$ids) {
		return;
	}
	$time = time();
	foreach($ids as $id) {
		$db_target->query("INSERT INTO $table_target (id,idtype,status,dateline) VALUES ('$id','$idtype','0','$time')");
	}
}
?>