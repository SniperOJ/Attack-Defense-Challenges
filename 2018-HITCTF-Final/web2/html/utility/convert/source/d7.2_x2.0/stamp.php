<?php

/**
 * DiscuzX Convert
 *
 * $Id: stamp.php 15786 2010-08-27 00:27:21Z monkey $
 */

$curprg = basename(__FILE__);
$table_source = $db_source->tablepre.'threads';
$tablemod_source = $db_source->tablepre.'threadsmod';
$table_target = $db_target->tablepre.'forum_thread';

$stampnew = $db_target->result_first("SELECT COUNT(*) FROM $table_target WHERE stamp>'0'");
if(!$stampnew) {
	$query = $db_source->query("SELECT t.tid, tm.stamp FROM $table_source t
		INNER JOIN $tablemod_source tm ON t.tid=tm.tid AND tm.action='SPA'
		WHERE t.status|16=t.status");
	while($row = $db_source->fetch_array($query)) {
		$db_target->query("UPDATE $table_target SET stamp='$row[stamp]' WHERE tid='$row[tid]'");
	}
}

?>