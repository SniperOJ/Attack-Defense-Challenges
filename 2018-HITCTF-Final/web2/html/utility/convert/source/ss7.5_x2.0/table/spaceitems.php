<?php

/**
 * DiscuzX Convert
 *
 * $Id: spaceitems.php 15777 2010-08-26 04:00:58Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'spaceitems';
$table_target = $db_target->tablepre.'portal_article_title';
$table_target_count = $db_target->tablepre.'portal_article_count';
$table_target_content = $db_target->tablepre.'portal_article_content';

$table_source_content = $db_source->tablepre.'spacenews';

$limit = 300;
$nextid = 0;

$start = getgpc('start');

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
	$db_target->query("TRUNCATE $table_target_count");
	$db_target->query("TRUNCATE $table_target_content");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE itemid>'$start' ORDER BY itemid LIMIT $limit");
while ($rs = $db_source->fetch_array($query)) {

	$nextid = $rs['itemid'];
	$settitle = array();
	$rs['none'] = '';
	$settitle['aid'] = $rs['itemid'];
	$settitle['catid'] = $rs['catid'];
	$settitle['bid'] = $rs['none'];
	$settitle['uid'] = $rs['uid'];
	$settitle['username'] = $rs['username'];
	$settitle['title'] = $rs['subject'];
	$settitle['shorttitle'] = $rs['none'];
	$settitle['summary'] = $rs['none'];
	$settitle['pic'] = $rs['none'];
	$settitle['thumb'] = $rs['none'];
	$settitle['remote'] = $rs['none'];
	$settitle['id'] = $rs['none'];
	$settitle['idtype'] = $rs['none'];
	$settitle['allowcomment'] = $rs['allowreply'];
	$settitle['dateline'] = $rs['dateline'];

	$settitle['author'] = '';
	$settitle['from'] = '';
	$settitle['fromurl'] = '';
	$settitle['url'] = '';

	$count = 0;
	$cquery = $db_source->query("SELECT * FROM $table_source_content WHERE itemid='$rs[itemid]'");
	while($crs = $db_source->fetch_array($cquery)) {
		$setcontent = array();
		$setcontent['cid'] = $crs['nid'];
		$setcontent['aid'] = $crs['itemid'];
		$setcontent['content'] = $crs['message'];
		$setcontent['pageorder'] = $crs['pageorder'];
		$setcontent['dateline'] = $crs['dateline'];

		$setcontent  = daddslashes($setcontent, 1);

		$data = implode_field_value($setcontent, ',', db_table_fields($db_target, $table_target_content));

		$db_target->query("INSERT INTO $table_target_content SET $data");

		$settitle['author'] = $crs['newsauthor'] ? $crs['newsauthor'] : $settitle['author'];
		$settitle['from'] = $crs['newsfrom'] ? $crs['newsfrom'] : $settitle['from'];
		$settitle['fromurl'] = $crs['newsfromurl'] ? $crs['newsfromurl'] : $settitle['fromurl'];
		$settitle['url'] = $crs['newsurl'] ? $crs['newsurl'] : $settitle['url'];
		$count ++;
	}

	$settitle['contents'] = $count;

	$settitle  = daddslashes($settitle, 1);

	$data = implode_field_value($settitle, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");


	$setcount = array();
	$setcount['aid'] = $rs['itemid'];
	$setcount['viewnum'] = $rs['viewnum'];
	$setcount['commentnum'] = $rs['replynum'];
	$setcount['catid'] = $rs['catid'];
	$setcount['dateline'] = $rs['dateline'];

	$setcount  = daddslashes($setcount, 1);

	$data = implode_field_value($setcount, ',', db_table_fields($db_target, $table_target_count));

	$db_target->query("INSERT INTO $table_target_count SET $data");

}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." itemid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>