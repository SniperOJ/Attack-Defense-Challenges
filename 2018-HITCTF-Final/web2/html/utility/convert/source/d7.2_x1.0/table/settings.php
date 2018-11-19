<?php

/**
 * DiscuzX Convert
 *
 * $Id: settings.php 11117 2010-05-24 08:30:29Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'settings';
$table_target = $db_target->tablepre.'common_setting';

$newsetting = array();
$query = $db_target->query("SELECT * FROM $table_target");
while($row = $db_source->fetch_array($query)) {
	$newsetting[$row['skey']] = $row['skey'];
}

$skips = array('attachdir', 'attachurl', 'cachethreaddir', 'jspath', 'my_status');

$query = $db_source->query("SELECT  * FROM $table_source");
while ($row = $db_source->fetch_array($query)) {
	if(in_array($row['variable'], $skips)) continue;
	if(isset($newsetting[$row['variable']])) {
		$rownew = array();
		if($row['variable'] == 'my_search_status' && $row['value'] != -1) {
			$row['value'] = 0;
		}
		$rownew['skey'] = $row['variable'];
		$rownew['svalue'] = $row['value'];
		$rownew  = daddslashes($rownew, 1);

		$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

		$db_target->query("REPLACE INTO $table_target SET $data");
	}
}

?>