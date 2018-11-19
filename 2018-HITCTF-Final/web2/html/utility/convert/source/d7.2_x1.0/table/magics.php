<?php

/**
 * DiscuzX Convert
 *
 * $Id: magics.php 9636 2010-04-30 08:19:12Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'magics';
$table_target = $db_target->tablepre.'common_magic';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$identifier = array(
	'CCK' => 'highlight',
	'MOK' => 'money',
	'SEK' => 'showip',
	'UPK' => 'bump',
	'TOK' => 'stick',
	'REK' => 'repent',
	'RTK' => 'checkonline',
	'CLK' => 'close',
	'OPK' => 'open',
	'YSK' => 'anonymouspost',
	'CBK' => 'namepost',
);

$query = $db_source->query("SELECT  * FROM $table_source WHERE magicid>'$start' ORDER BY magicid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['magicid'];
	if($row['identifier'] == 'MVK') {
		continue;
	}

	unset($row['type'], $row['recommend'], $row['filename']);
	$row['useevent'] = $row['identifier'] == 'MOK' ? 1 : 0;
	$row['identifier'] = $identifier[$row['identifier']];
	if(!$row['identifier']) {
		continue;
	}

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." magicid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>