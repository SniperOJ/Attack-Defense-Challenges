<?php

/**
 * DiscuzX Convert
 *
 * $Id: creditslog.php 15815 2010-08-27 02:56:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'creditslog';
$table_target = $db_target->tablepre.'common_credit_log';

$limit = 2000;
$nextid = 0;

$start = intval(getgpc('start'));
if(empty($start) && !$process['truncate_credit_log']) {
	$start = 0;
	$process['truncate_credit_log'] = 1;
	save_process('main', $process);
	$db_target->query("TRUNCATE $table_target");
}

$rowlist = $userarr = array();
$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {
	$nextid = 1;
	$rowlist[] = $row;
	$userarr[$row['fromto']] = $row['fromto'];
}

if($nextid) {
	$userarr = daddslashes($userarr, 1);
	$usernames = implode("', '", $userarr);
	$query = $db_source->query("SELECT * FROM ".$db_source->tablepre."members WHERE username IN('$usernames')");
	while($row = $db_source->fetch_array($query)) {
		$userarr[$row['username']] = $row['uid'];
	}

	foreach($rowlist as $row) {
		$rownew = array();
		if(in_array($row['operation'], array('AFD', 'TFR', 'RCV'))) {
			$rownew['uid'] = $row['uid'];
			if($row['operation'] == 'RCV' && $row['fromto'] == 'TASK REWARD') {
				$rownew['operation'] = 'TRC';
				$rownew['relatedid'] = 0;
			} else {
				$rownew['operation'] = $row['operation'];
				$rownew['relatedid'] = $userarr[$row['fromto']];
			}

			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		} elseif($row['operation'] == 'UGP') {
			$rownew['uid'] = $row['uid'];
			$rownew['operation'] = $row['operation'];
			$rownew['relatedid'] = 0;
			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		} elseif($row['operation'] == 'EXC') {
			$rownew['uid'] = $row['uid'];
			$rownew['operation'] = 'ECU';
			$rownew['relatedid'] = $row['uid'];
			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		}
		if($rownew) {
			$rownew  = daddslashes($rownew, 1);

			$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

			$db_target->query("INSERT INTO $table_target SET $data");
		}
	}
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>