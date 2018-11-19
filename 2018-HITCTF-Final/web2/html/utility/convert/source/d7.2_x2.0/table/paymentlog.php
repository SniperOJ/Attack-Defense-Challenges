<?php

/**
 * DiscuzX Convert
 *
 * $Id: paymentlog.php 15815 2010-08-27 02:56:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'paymentlog';
$table_target = $db_target->tablepre . 'common_credit_log';

$limit = $setting['limit']['paymentlog'] ? $setting['limit']['paymentlog'] : 2500;
$step = getgpc('step');
$step = intval($step);
$total = getgpc('total');
$total = intval($total);

$continue = false;
if(!$step && !$process['truncate_credit_log']) {
	$process['truncate_credit_log'] = 1;
	save_process('main', $process);
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM ".$db_source->tablepre."settings WHERE variable IN ('creditstax', 'creditstrans')");
while($setting = $db_source->fetch_array($query)) {
	if($setting['variable'] == 'creditstrans') {
		$creditstrans = explode(',', $setting['value']);
		$ext = $creditstrans[1] ? $creditstrans[1] : $creditstrans[0];
		if(!$ext) {
			$ext = 1;
		}
	}
	if($setting['variable'] == 'creditstax') {
		$creditstax = $setting['value'];
	}
}

$offset = $step * $limit;

$query = $db_source->query("SELECT * FROM $table_source LIMIT $offset, $limit");
while($row = $db_source->fetch_array($query)) {
	$continue = true;

	$rownew = array();
	$rownew['uid'] = $row['uid'];
	$rownew['operation'] = 'BTC';
	$rownew['relatedid'] = $row['tid'];
	$rownew['dateline'] = $row['dateline'];
	$rownew['extcredits'.$ext] = -$row['amount'];

	$rownew  = daddslashes($rownew, 1);

	$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");

	$rownew = array();
	$rownew['uid'] = $row['authorid'];
	$rownew['operation'] = 'STC';
	$rownew['relatedid'] = $row['tid'];
	$rownew['dateline'] = $row['dateline'];
	$rownew['extcredits'.$ext] = $row['netamount'];

	$rownew  = daddslashes($rownew, 1);

	$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");

	$total ++;
}
$nextstep = $step + 1;
if($continue) {
	showmessage("继续转换数据表 ".$table_source."，已转换 $total 条记录。", "index.php?a=$action&source=$source&prg=$curprg&step=$nextstep&total=$total");
}
?>