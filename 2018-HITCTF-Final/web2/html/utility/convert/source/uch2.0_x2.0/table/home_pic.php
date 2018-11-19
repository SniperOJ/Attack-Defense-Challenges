<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_pic.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'pic';
$table_target = $db_target->tablepre.'home_pic';

$limit = $setting['limit']['pic'] ? $setting['limit']['pic'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT picid,albumid,uid,username,dateline,postip,filename,title,type,size,filepath,thumb,remote,hot,click_6,click_7,click_8,click_9,click_10,magicframe".
						 " FROM $table_source WHERE picid>'$start' ORDER BY picid LIMIT $limit");
while ($pic = $db_source->fetch_array($query)) {

	$nextid = $pic['picid'];

	$pic  = daddslashes($pic, 1);

	$db_target->query("INSERT INTO $table_target SET `picid`='".$pic[picid]."',`albumid`='".$pic[albumid]."',`uid`='".$pic[uid]."',`username`='".$pic[username]."',`dateline`='".$pic[dateline].
			"',`postip`='".$pic[pistip]."',`filename`='".$pic[filename]."',`title`='".$pic[title]."',`type`='".$pic[type]."',`size`='".$pic[size]."',`filepath`='".$pic[filepath]."', `thumb`='".$pic[thumb].
			"',`remote`='".$pic[remote]."',`hot`='".$pic[hot]."',`click1`='".$pic[click_9]."',`click2`='".$pic[click_8]."',`click3`='".$pic[click_7]."',`click4`='".$pic[click_6]."',`click5`='".$pic[click_10]."'
			");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." picid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>