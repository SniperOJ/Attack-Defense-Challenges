<?php

/**
 * DiscuzX Convert
 *
 * $Id: stamp.php 15786 2010-08-27 00:27:21Z monkey $
 */

$table_target = $db_target->tablepre.'common_moderate';
$table_target_portal_article_title = $db_target->tablepre.'portal_article_title';
$table_target_portal_comment = $db_target->tablepre.'portal_comment';

$query = $db_target->query("SELECT aid FROM $table_target_portal_article_title WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('aid', $row['aid']);
}

$query = $db_target->query("SELECT cid FROM $table_target_portal_comment WHERE idtype='aid' AND status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('aid_cid', $row['cid']);
}

$query = $db_target->query("SELECT cid FROM $table_target_portal_comment WHERE idtype='topic' AND status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('topicid_cid', $row['cid']);
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