<?php

/**
 * DiscuzX Convert
 *
 * $Id: tags.php 20881 2011-03-07 07:09:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'tags';
$table_target = $db_target->tablepre.'common_tag';

$table_thread_source = $db_source->tablepre.'threadtags';
$table_thread_target = $db_target->tablepre.'common_tagitem';
$table_post_target = $db_target->tablepre.'forum_post';

$limit = 100;
$nextid = 0;

$start = intval(getgpc('start'));

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("TRUNCATE $table_thread_target");
}

$query = $db_source->query("SELECT  * FROM $table_source ORDER BY tagname LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $start + $limit;

	$row['status'] = $row['closed'];
	unset($row['closed'], $row['total']);

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
	$tagid = $db_target->insert_id();

	$query_thread = $db_source->query("SELECT tid FROM $table_thread_source WHERE tagname='$row[tagname]'");
	while ($rowthread = $db_source->fetch_array($query_thread)) {
		$db_target->query("INSERT INTO $table_thread_target SET tagid='$tagid', tagname='$row[tagname]', itemid='$rowthread[tid]', idtype='tid'");
		$db_target->query("UPDATE $table_post_target SET tags=CONCAT(tags, '$tagid,$row[tagname]\t') WHERE tid='$rowthread[tid]' AND first='1'");
	}

}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." tag > $nextid ", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>