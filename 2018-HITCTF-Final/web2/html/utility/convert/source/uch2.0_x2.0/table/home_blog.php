<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_blog.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'blog';
$table_target = $db_target->tablepre.'home_blog';

$limit = $setting['limit']['blog'] ? $setting['limit']['blog'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT dateline, blogid, uid, username, `subject`, classid, viewnum, replynum, hot, picflag, noreply, friend, `password`, click_1 as click1, click_2 as click2, click_3 as click3, click_4 as click4, click_5 as click5  FROM $table_source WHERE blogid>'$start' ORDER BY blogid LIMIT $limit");
while ($blog = $db_source->fetch_array($query)) {

	$nextid = intval($blog['blogid']);

	$blog  = daddslashes($blog, 1);

	$data = implode_field_value($blog, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET `blogid`='".$blog[blogid]."',`uid`='".$blog[uid]."',`username`='".$blog[username]."',`subject`='".$blog[subject]."',`classid`='".$blog[classid].
					"',`viewnum`='".$blog[viewnum]."',`replynum`='".$blog[replynum]."',`hot`='".$blog[hot]."',`dateline`='".$blog[dateline]."',`picflag`='".$blog[picflag]."',`noreply`='".$blog[noreply].
					"',`friend`='".$blog[friend]."',`password`='".$blog[password]."',`click1`='".$blog[click1]."',`click2`='".$blog[click5]."',`click3`='".$blog[click4]."',`click4`='".$blog[click3]."',`click5`='".$blog[click2]." '");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." blogid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>