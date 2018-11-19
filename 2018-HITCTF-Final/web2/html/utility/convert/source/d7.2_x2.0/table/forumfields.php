<?php

/**
 * DiscuzX Convert
 *
 * $Id: forumfields.php 10467 2010-05-11 09:05:58Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'forumfields';
$table_target = $db_target->tablepre.'forum_forumfield';
$table_targetcreditrule = $db_target->tablepre.'common_credit_rule';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("UPDATE $table_targetcreditrule SET fids=''");
}

$rules = $ruleaction = array();
$query = $db_target->query("SELECT * FROM $table_targetcreditrule WHERE action IN('reply', 'post', 'digest', 'postattach', 'getattach')");
while($value = $db_target->fetch_array($query)) {
	$rules[$value['rid']] = $value;
	$ruleaction[$value['action']] = $value['rid'];
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE fid>'$start' ORDER BY fid LIMIT $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = $row['fid'];

	$credits = array();
	$credits['post'] = unserialize($row['postcredits']);
	$credits['reply'] = unserialize($row['replycredits']);
	$credits['getattach'] = unserialize($row['getattachcredits']);
	$credits['postattach'] = unserialize($row['postattachcredits']);
	$credits['digest'] = unserialize($row['digestcredits']);
	$row['creditspolicy'] = array();
	foreach($credits as $caction => $credits) {
		if($credits) {
			$rid = $ruleaction[$caction];
			$row['creditspolicy'] = $rules[$rid];
			foreach($credits as $i => $v) {
				$row['creditspolicy']['extcredits'.$i] = $v;
			}
			$rules[$rid]['fids'] = $db_target->result_first("SELECT fids FROM $table_targetcreditrule WHERE rid='".$rid."'");
			$cpfids = explode(',', $rules[$rid]['fids']);
			$cpfidsnew = array();
			foreach($cpfids as $cpfid) {
				if(!$cpfid) {
					continue;
				}
				if($cpfid != $row['fid']) {
					$cpfidsnew[] = $cpfid;
				}
			}
			$cpfidsnew[] = $row['fid'];
			$db_target->query("UPDATE $table_targetcreditrule SET fids='".implode(',', $cpfidsnew)."' WHERE rid='".$rid."'");
		}
	}
	$row['creditspolicy'] = $row['creditspolicy'] ? serialize($row['creditspolicy']) : '';

	unset($row['tradetypes'], $row['typemodels'], $row['postcredits'], $row['replycredits'], $row['getattachcredits'], $row['postattachcredits'], $row['digestcredits']);

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." fid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

$db_target->query("UPDATE $table_target SET seodescription=description WHERE membernum='0'");

?>