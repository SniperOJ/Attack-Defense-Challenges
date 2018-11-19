<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_event.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'event';

$start = getgpc('start');
$start = empty($start) ? 0 : intval($start);
$limit = $setting['limit']['event'] ? $setting['limit']['event'] : 100;
$nextid = 0;
$home = load_process('home');
$eventfid = intval($home['forum']['event']);

if(!empty($eventfid)) {
	$value = $db_target->fetch_first('SELECT * FROM '.$db_target->table_name('forum_forum')." WHERE fid='$eventfid' AND status!='3'");
	if(empty($value)) {
		$eventfid = 0;
	}
}
if(empty($eventfid)) {
	$board_name = 'UCHome数据';
	$forum_name = 'UCHome活动';
	$value = $db_target->fetch_first('SELECT fid FROM '.$db_target->table_name('forum_forum')." WHERE type='forum' AND status='1' AND `name`='$forum_name'");
	if(!empty($value)) {
		$eventfid = intval($value['fid']);
	} else {
		$value = $db_target->fetch_first('SELECT fid FROM '.$db_target->table_name('forum_forum')." WHERE type='group' AND status='1' AND `name`='$board_name'");
		if($value) {
			$fup = intval($value['fid']);
		} else {
			$board = array(
				'name' => $board_name,
				'type' => 'group',
				'status' => '1',
			);
			$fup = $db_target->insert('forum_forum', $board, true);
		}
		$forum = array(
			'name' => $forum_name,
			'fup' => $fup,
			'type' => 'forum',
			'allowsmilies' => 1,
			'allowbbcode' => 1,
			'allowimgcode' => 1,
			'status' => '1',
		);
		$eventfid = $db_target->insert('forum_forum', $forum, true);
		$forumfield = array(
			'fid' => $eventfid,
			'description' => '从 UCenter Home 转移过来的活动内容'
		);
		$db_target->insert('forum_forumfield', $forumfield);
	}
}

$eventclass = array();
$query = $db_source->query('SELECT classid, classname FROM '.$db_source->table_name('eventclass'));
while($value=$db_source->fetch_array($query)) {
	$eventclass[$value['classid']] = $value['classname'];
}

include_once DISCUZ_ROOT.'./include/editor.func.php';

$event_query = $db_source->query("SELECT e.*, ef.detail, ef.limitnum FROM $table_source e LEFT JOIN ".$db_source->table_name('eventfield')." ef ON e.eventid = ef.eventid WHERE e.eventid > $start ORDER BY e.eventid LIMIT $limit");
while ($event = $db_source->fetch_array($event_query)) {

	$nextid = intval($event['eventid']);

	$commentnum = $db_source->result_first('SELECT count(*) FROM '.$db_source->table_name('comment')." WHERE id='$event[eventid]' AND idtype='eventid'");
	$lastcomment = array();
	if($commentnum) {
		$lastcomment = $db_source->fetch_first('SELECT author, dateline FROM '.$db_source->table_name('comment')." WHERE id='$event[eventid]' AND idtype='eventid' ORDER BY cid DESC LIMIT 1");
	}
	$threadarr = array(
		'fid' => $eventfid,
		'author' => $event['username'],
		'authorid' => $event['uid'],
		'subject' => $event['title'],
		'dateline' => $event['dateline'],
		'lastpost' => !empty($lastcomment) ? $lastcomment['dateline'] : $event['updatetime'],
		'lastposter' => !empty($lastcomment) ? $lastcomment['author'] : $event['username'],
		'views' => $event['viewnum'],
		'replies' => $commentnum,
		'special' => 4
	);
	$tid = $db_target->insert('forum_thread', daddslashes($threadarr), true);
	$event['detail'] = html2bbcode($event['detail']);
	$postarr = array(
		'fid' => $eventfid,
		'tid' => $tid,
		'first' => '1',
		'author' => $event['username'],
		'authorid' => $event['uid'],
		'subject' => $event['subject'],
		'dateline' => $event['dateline'],
		'message' => $event['detail']
	);
	$pid = $db_target->insert('forum_post', daddslashes($postarr), true);
	$aid = 0;
	$activityarr = array(
		'tid' => $tid,
		'uid' => $event['uid'],
		'aid' => $aid,
		'cost' => '',
		'starttimefrom' => $event['starttime'],
		'starttimeto' => $event['endtime'],
		'place' => '['.$event['province'].$event['city'].'] '.$event['location'],
		'class' => $eventclass[$event['classid']],
		'number' => $event['limitnum'],
		'applynumber' => $event['membernum'] - 1,// Home 里的活动成员包括创建者
		'expiration' => $event['deadline']
	);
	$db_target->insert('forum_activity', daddslashes($activityarr));

	$inserts = array();
	$query = $db_source->query('SELECT * FROM '.$db_source->table_name('userevent')." WHERE eventid = '$event[eventid]' AND status IN ('1', '2')");
	while($value=$db_source->fetch_array($query)) {
		$value['verified'] = $value['status'] == 1 ? 0 : 1;
		$value['username'] = addslashes($value['username']);
		$inserts[] = "('$tid', '$value[username]', '$value[uid]', '$value[verified]', '$value[dateline]', '-1')";
	}
	if($inserts) {
		$db_target->query('INSERT INTO '.$db_target->table_name('forum_activityapply').'(tid, username ,uid, verified, dateline, payment) VALUES '.implode(', ', $inserts));
	}

	if($commentnum) {
		$inserts = array();
		$query = $db_source->query('SELECT * FROM '.$db_source->table_name('comment')." WHERE id='$event[eventid]' AND idtype='eventid' ORDER BY cid");
		while($value=$db_source->fetch_array($query)) {
			$value['message'] = addslashes(html2bbcode($value['message']));
			$value['author'] = addslashes($value['author']);
			$inserts[] = "('$fid', '$tid', '$value[author]', '$value[authorid]', '$value[dateline]', '$value[message]')";
		}
		$db_target->query('INSERT INTO '.$db_target->table_name('forum_post')."(fid, tid, author, authorid, dateline, message) VALUES ".implode(', ',$inserts));
	}

	$posts = $commentnum + 1;
	$db_target->query("UPDATE ".$db_target->table_name('common_member_count')." SET threads=threads+1 WHERE uid='$event[uid]'");
	$db_target->query("UPDATE ".$db_target->table_name('forum_forum')." SET threads=threads+1, posts=posts+$posts WHERE fid='$eventfid'");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." eventid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

$maxpid = $db_target->result_first("SELECT MAX(pid) FROM ".$db_target->table('forum_post'));
$maxpid = intval($maxpid) + 1;
$db_target->query("ALTER TABLE ".$db_target->table('forum_post_tableid')." AUTO_INCREMENT=$maxpid");
$db_target->query("UPDATE ".$db_target->table_name('forum_forum')." SET status=1 WHERE status=2");
?>