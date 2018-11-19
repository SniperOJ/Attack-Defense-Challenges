<?php

/**
 * DiscuzX Convert
 *
 * $Id: stamp.php 15786 2010-08-27 00:27:21Z monkey $
 */

$table_target = $db_target->tablepre.'common_moderate';
$table_target_thread = $db_target->tablepre.'forum_thread';
$table_target_post = $db_target->tablepre.'forum_post';

$db_target->query("TRUNCATE $table_target");

$query = $db_target->query("SELECT tid FROM $table_target_thread WHERE displayorder='-2'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('tid', $row['tid']);
}

$query = $db_target->query("SELECT pid FROM $table_target_post WHERE invisible='-2' AND first='0'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('pid', $row['pid']);
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