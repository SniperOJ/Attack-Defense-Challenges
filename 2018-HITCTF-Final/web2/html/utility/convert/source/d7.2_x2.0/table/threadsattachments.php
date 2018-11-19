<?php

/**
 * DiscuzX Convert
 *
 * $Id: attachments.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'attachments';
$table_target = $db_target->tablepre.'forum_attachment';
$table_source_field = $db_source->tablepre.'attachmentfields';
$table_target_forum_threadimage = $db_target->tablepre.'forum_threadimage';
$table_target_forum_thread = $db_target->tablepre.'forum_thread';

$limit = $setting['limit']['attachments'] ? $setting['limit']['attachments'] : 2500;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("TRUNCATE $table_target_forum_threadimage");
	for($i = 0;$i < 10;$i++) {
		$table_target_attachment_i = $db_target->tablepre.'forum_attachment_'.$i;
		$db_target->query("TRUNCATE $table_target_attachment_i");
	}
}

$query = $db_source->query("SELECT a.*,af.description FROM $table_source a
				LEFT JOIN $table_source_field af USING(aid) WHERE a.aid>'$start'
				ORDER BY a.aid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['aid'];

	$row  = daddslashes($row, 1);

	$tid = (string)$row['tid'];
	$tableid = $tid{strlen($tid)-1};
	$table_target_attachment_tableid = $db_target->tablepre.'forum_attachment_'.$tableid;
	$db_target->query("REPLACE INTO $table_target SET aid='$row[aid]', tid='$row[tid]', pid='$row[pid]', uid='$row[uid]', tableid='$tableid', downloads='$row[downloads]'");
	$db_target->query("REPLACE INTO $table_target_attachment_tableid SET
						aid='$row[aid]',
						tid='$row[tid]',
						pid='$row[pid]',
						uid='$row[uid]',
						dateline='$row[dateline]',
						filename='$row[filename]',
						filesize='$row[filesize]',
						attachment='$row[attachment]',
						remote='$row[remote]',
						description='$row[description]',
						readperm='$row[readperm]',
						price='$row[price]',
						isimage='$row[isimage]',
						width='$row[width]',
						thumb='$row[thumb]',
						picid='$row[picid]'");
	if(($row['isimage'] == '1' || $row['isimage'] == '-1') && $row['attachment']) {
		$querythread = $db_target->query("SELECT * from $table_target_forum_thread WHERE tid='$row[tid]'");
		while ($rownew = $db_target->fetch_array($querythread)) {
			$tid_attachment = $rownew['attachment'];
			$tid_posttableid = $rownew['posttableid'];
			$tid_dateline = $rownew['dateline'];
		}
		$dateline = time() - 86400 * 10 * 30;
		if($tid_attachment == '2' && $tid_posttableid == '0' && $tid_dateline > $dateline) {
			if(!$db_target->result_first("SELECT COUNT(*) FROM $table_target_forum_threadimage WHERE tid='$row[tid]'")) {
				$db_target->query("INSERT INTO $table_target_forum_threadimage VALUES ('$row[tid]','$row[attachment]','$row[remote]')");
			}
		}
	}

}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." aid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>