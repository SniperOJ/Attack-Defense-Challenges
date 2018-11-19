<?php
/**
 * DiscuzX Convert
 *
 * $Id: home_group.php 19554 2011-01-07 04:26:02Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->table('mtag');
require_once DISCUZ_ROOT.'./include/editor.func.php';


$fieldid = intval(getgpc('fieldid'));
$tagid = intval(getgpc('tagid'));

$gid = intval(getgpc('gid'));
$fid = intval(getgpc('fid'));
$sid = intval(getgpc('sid'));

$limit = $setting['limit']['mtag'] ? $setting['limit']['mtag'] : 100;
$nextid = 0;

$threadquery = $db_source->query("SELECT * FROM ".$db_source->table('thread')." WHERE tid > '$start' AND tagid='$tagid' ORDER BY tid LIMIT $limit");
while($value = $db_source->fetch_array($threadquery)) {

	$nextid = $value['tid'];
	$value = daddslashes($value);
	$value['replynum'] = intval($value['replynum']);
	$threadarr = array(
		'fid' => $sid,
		'author' => $value['username'],
		'authorid' => $value['uid'],
		'subject' => $value['subject'],
		'dateline' => $value['dateline'],
		'lastpost' => $value['lastpost'],
		'lastposter' => $value['lastauthor'],
		'views' => $value['viewnum'],
		'replies' => $value['replynum'],
		'digest' => $value['digest'],
		'displayorder' => $value['displayorder'] ? 1 : 0,
		'isgroup' => 1
	);
	$tid = $db_target->insert('forum_thread', $threadarr, true);

	$lastpost = array();

	$query = $db_source->query("SELECT * FROM ".$db_source->table('post')." WHERE tid='$value[tid]' ORDER BY dateline");
	while($post = $db_source->fetch_array($query)) {
		$post['message'] = html2bbcode($post['message']);
		$post = daddslashes($post);
		$postarr = array(
			'fid' => $sid,
			'tid' => $tid,
			'first' => $post['isthread'] ? 1 : 0,
			'author' => $post['username'],
			'authorid' => $post['uid'],
			'subject' => $post['isthread'] ? $value['subject'] : $post['subject'],
			'dateline' => $post['dateline'],
			'message' => $post['message'],
			'useip' => $post['ip']
		);
		$lastpost = array(
			'lastpost' => $post['dateline'],
			'lastposter' => $post['username'],
		);
		$db_target->insert('forum_post', $postarr);
		$db_target->insert('common_member_count', array('uid' => $value['uid']), 0, false, true);
		$db_target->query("UPDATE ".$db_target->table('common_member_count')." SET posts=posts+1 WHERE uid='$post[uid]'", 'UNBUFFERED');
		$db_target->query("UPDATE ".$db_target->table('forum_groupuser')." SET replies=replies+1 WHERE fid='$sid' AND uid='$post[uid]'", 'UNBUFFERED');
	}

	if($lastpost) {
		$db_target->update('forum_thread', $lastpost, array('tid' => $tid));
	} else {
		$lastpost['lastpost'] = $value['lastpost'];
	}
	$db_target->insert('common_member_count', array('uid' => $value['uid']), 0, false, true);
	$db_target->query("UPDATE ".$db_target->table('common_member_count')." SET threads=threads+1 WHERE uid='$value[uid]'", 'UNBUFFERED');
	$db_target->query("UPDATE ".$db_target->table('forum_groupuser')." SET threads=threads+1 WHERE fid='$sid' AND uid='$value[uid]'", 'UNBUFFERED');
	$db_target->query("UPDATE ".$db_target->table('forum_forum')." SET lastpost='$lastpost[lastpost]', threads=threads+1, posts=posts+$value[replynum] WHERE fid='$sid'", 'UNBUFFERED');

}
$force = false;
if(!$nextid) {
	if(!getmtag($tagid)) {
		if(!getprofield($fieldid)) {
			$nextid = 0;
		} else {
			$force = true;
		}
	} else {
		$force = true;
	}
	$nextid = $force ? 1 : 0;
}

if($nextid) {
	if($force) $nextid = 0;
	$mtag = array();
	if($tagid) {
		$mtag = $db_source->fetch_first("SELECT * FROM ".$db_source->table('mtag')." WHERE tagid='$tagid'");
	}
	$profield = $db_source->fetch_first("SELECT * FROM ".$db_source->table('profield')." WHERE fieldid='$fieldid'");
	showmessage("继续转换数据表 ".$table_source." : $profield[title] ".(!empty($mtag) ? "&rsaquo; $mtag[tagname] &rsaquo; tid > $nextid":""), "index.php?a=$action&source=$source&prg=$curprg&start=$nextid&gid=$gid&fid=$fid&sid=$sid&fieldid=$fieldid&tagid=$tagid");
}

$maxpid = $db_target->result_first("SELECT MAX(pid) FROM ".$db_target->table('forum_post'));
$maxpid = intval($maxpid) + 1;
$db_target->query("ALTER TABLE ".$db_target->table('forum_post_tableid')." AUTO_INCREMENT=$maxpid");
$db_target->query("UPDATE ".$db_target->table('forum_forumfield')." SET seodescription=description WHERE membernum='0'");

function getmtag($start) {
	global $db_source, $db_target, $fieldid, $gid, $fid, $sid, $tagid;

	if(empty($fieldid)) {
		getprofield($fieldid);
	}
	$mtag = $db_source->fetch_first("SELECT * FROM ".$db_source->table('mtag')." WHERE fieldid='$fieldid' AND tagid>'$start' ORDER BY tagid LIMIT 1");
	if(empty($mtag)) {
		$tagid = $sid = 0;
		return false;
	}
	$tagid = $mtag['tagid'];
	$founder = $groupuser = array();
	$query = $db_source->query("SELECT * FROM ".$db_source->table('tagspace')." WHERE tagid='$mtag[tagid]'");
	while($space = $db_source->fetch_array($query)) {
		$space['level'] = 4;
		if($space['grade'] == 9) {
			$space['level'] = 1;
			if(empty($founder)) {
				$founder = array('founderuid' => $space['uid'], 'foundername' => daddslashes($space['username']));
			}
		} elseif($space['grade'] == 8) {
			$space['level'] = 2;
		} elseif($space['grade'] == 1) {
			$space['level'] = 3;
		} elseif($space['grade'] == -2) {
			$space['level'] = 0;
		}
		$groupuser[$space['uid']] = $space;
	}
	if(empty($founder)) {
		$member = $db_target->fetch_first("SELECT uid,username FROM ".$db_target->table('common_member')." WHERE adminid='1' ORDER BY uid LIMIT 1");
		$founder = array('founderuid' => $member['uid'], 'foundername' => daddslashes($member['username']));
		$groupuser[$member['uid']] = array('uid' => $member['uid'], 'username' => $member['username'], 'level' => 1);
	}

	$levelid = $db_target->result_first("SELECT levelid FROM ".$db_target->table('forum_grouplevel')." WHERE creditshigher<='0' AND '0'<creditslower LIMIT 1");
	$forumarr = array(
			'fup' => $fid,
			'type' => 'sub',
			'name' => daddslashes($mtag['tagname']),
			'status' => 3,
			'allowsmilies' => 1,
			'allowbbcode' => 1,
			'allowimgcode' => 1,
			'level' => $levelid
		);
	$sid = $db_target->insert('forum_forum', $forumarr, true);
	$forumfieldarr = array(
			'fid' => $sid,
			'description' => daddslashes(html2bbcode($mtag['announcement'])),
			'jointype' => $mtag['joinperm'] ? ($mtag['joinperm'] == 1 ? 2 : 1) : 0,
			'gviewperm' => $mtag['viewperm'] ? 0 : 1,
			'dateline' => TIMESTAMP,
			'founderuid' => $founder['founderuid'],
			'foundername' => $founder['foundername'],
			'membernum' => $mtag['membernum']
		);
	$db_target->insert('forum_forumfield', $forumfieldarr);
	$db_target->query("UPDATE ".$db_target->table('forum_forumfield')." SET groupnum=groupnum+1 WHERE fid='$fid'");

	foreach($groupuser as $uid => $user) {
		$userarr = array(
			'fid' => $sid,
			'uid' => $uid,
			'username' => daddslashes($user['username']),
			'level' => $user['level'],
			'threads' => 0,
			'replies' => 0,
			'joindateline' => TIMESTAMP,
			'lastupdate' => TIMESTAMP,
			'privacy' => '',
		);
		$db_target->insert('forum_groupuser', $userarr, 0, true);
	}

	return true;

}

function getprofield($start) {
	global $db_source, $db_target, $fieldid, $gid, $fid, $tagid;

	if(!$gid) {
		$gid = $db_target->insert('forum_forum', array('type' => 'group', 'name' => '空间群组', 'status' => 3), 1);
		$db_target->insert('forum_forumfield', array('fid' => $gid));
	}

	$profield = $db_source->fetch_first("SELECT * FROM ".$db_source->table('profield')." WHERE fieldid>'$start' ORDER BY fieldid LIMIT 1");
	if(empty($profield)) {
		$fid = 0;
		$tagid = 0;
		return false;
	}

	$fieldid = $profield['fieldid'];

	$table_forum_columns = array('fup', 'type', 'name', 'status', 'displayorder', 'styleid', 'allowsmilies', 'allowhtml', 'allowbbcode', 'allowimgcode', 'allowanonymous', 'allowpostspecial', 'alloweditrules', 'alloweditpost', 'modnewposts', 'recyclebin', 'jammer', 'forumcolumns', 'threadcaches', 'disablewatermark', 'autoclose', 'simple');
	$table_forumfield_columns = array('fid', 'attachextensions', 'threadtypes', 'postcredits', 'replycredits', 'digestcredits', 'postattachcredits', 'getattachcredits', 'viewperm', 'postperm', 'replyperm', 'getattachperm', 'postattachperm');

	$forumfields = array(
			'allowsmilies' => 1,
			'allowbbcode' => 1,
			'allowimgcode' => 1,
			'allowpostspecial' => 127,
			'fup' => $gid,
			'type' => 'forum',
			'name' => daddslashes($profield['title']),
			'status' => 3
		);

	$data = array();
	foreach($table_forum_columns as $field) {
		if(isset($forumfields[$field])) {
			$data[$field] = $forumfields[$field];
		}
	}

	$forumfields['fid'] = $fid = $db_target->insert('forum_forum', $data, 1);
	$data = array();
	foreach($table_forumfield_columns as $field) {
		if(isset($forumfields[$field])) {
			$data[$field] = $forumfields[$field];
		}
	}
	$db_target->insert('forum_forumfield', $data);

	return true;
}
?>