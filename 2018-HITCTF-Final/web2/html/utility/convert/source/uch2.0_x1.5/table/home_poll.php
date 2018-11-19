<?php
/**
 * DiscuzX Convert
 *
 * $Id: home_poll.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'poll';

include_once DISCUZ_ROOT.'./include/editor.func.php';
$limit = $setting['limit']['poll'] ? $setting['limit']['poll'] : 100;
$nextid = 0;

$start = intval(getgpc('start'));
$home = load_process('home');
$fid = intval(getgpc('fid')) ? intval(getgpc('fid')) : intval($home['forum']['poll']) ? intval($home['forum']['poll']) : 0;
if(!$fid) {
	$forumname = 'UCHome投票数据';

	$value = $db_target->fetch_first('SELECT fid FROM '.$db_target->table_name('forum_forum')." WHERE status IN('1','2') AND type='forum' AND `name`='$forumname'");
	if(!empty($value)) {
		$fid = intval($value['fid']);
	} else {
		$value = $db_target->fetch_first('SELECT fid FROM '.$db_target->table_name('forum_forum')." WHERE status IN('1','2') AND type='group' AND `name`='$forumname'");
		if($value) {
			$fup = intval($value['fid']);
		} else {
			$board = array(
					'name' => daddslashes($forumname),
					'type' => 'group',
					'status' => '1',
				);
			$fup = $db_target->insert('forum_forum', $board, true);
		}
		$forum = array(
			'name' => daddslashes($forumname),
			'fup' => $fup,
			'type' => 'forum',
			'allowsmilies' => 1,
			'allowbbcode' => 1,
			'allowimgcode' => 1,
			'status' => '1',
		);
		$fid = $db_target->insert('forum_forum', $forum, true);
		$forumfield = array(
			'fid' => $fid,
			'description' => '从 UCenter Home 转移过来的投票内容'
		);
		$db_target->insert('forum_forumfield', $forumfield);
	}
}
$pids = $polls = $pollpreview = $optionuser = array();
$pollquery = $db_source->query("SELECT pf.*, p.* FROM {$db_source->tablepre}poll p LEFT JOIN {$db_source->tablepre}pollfield pf ON pf.pid=p.pid WHERE p.pid>'$start' ORDER BY p.pid LIMIT $limit");
while($value = $db_source->fetch_array($pollquery)) {
	$optionuser = array();
	$postnum = 1;
	$nextid = $value['pid'];
	$value['summary'] = !empty($value['summary']) ? html2bbcode($value['summary']) : '';
	$value['message'] = html2bbcode($value['message']);
	$pollpreview = $value['option'] = unserialize($value['option']);
	$value = daddslashes($value);
	$threadarr = array(
		'fid' => $fid,
		'author' => $value['username'],
		'authorid' => $value['uid'],
		'subject' => $value['subject'],
		'dateline' => $value['dateline'],
		'lastpost' => $value['lastvote'],
		'lastposter' => $value['username'],
		'views' => $value['replynum'],
		'replies' => $value['replynum'],
		'special' => 1
	);
	$tid = $db_target->insert('forum_thread', $threadarr, true);
	$postarr = array(
		'fid' => $fid,
		'tid' => $tid,
		'first' => '1',
		'author' => $value['username'],
		'authorid' => $value['uid'],
		'subject' => $value['subject'],
		'dateline' => $value['dateline'],
		'message' => $value['message']
	);
	$db_target->insert('forum_post', $postarr);

	if(!empty($value['summary'])) {
		$postarr = array(
			'fid' => $fid,
			'tid' => $tid,
			'first' => '1',
			'author' => $value['username'],
			'authorid' => $value['uid'],
			'subject' => $value['subject'],
			'dateline' => ($value['dateline']+10),
			'message' => $value['summary']
		);
		$db_target->insert('forum_post', $postarr);
		$postnum++;
	}
	$pollarr  = array(
		'tid' => $tid,
		'overt' => 0,
		'multiple' => $value['maxchoice'] > 1 ? 1 : 0,
		'visible' => 0,
		'maxchoices' => $value['maxchoice'],
		'expiration' => $value['expiration'],
		'pollpreview' => daddslashes(implode("\t", $pollpreview)),
		'voters' => $value['voternum']
	);
	$db_target->insert('forum_poll', $pollarr);

	$query = $db_source->query("SELECT * FROM {$db_source->tablepre}polluser WHERE pid='$value[pid]'");
	while($puser = $db_source->fetch_array($query)) {
		$puser['option'] = str_replace('"', '', $puser['option']);
		$puser['option'] = explode('、', $puser['option']);
		$optionuser[$puser['uid']] = $puser;
	}
	$changeoid = array();
	$query = $db_source->query("SELECT * FROM {$db_source->tablepre}polloption WHERE pid='$value[pid]'");
	while($pollopt = $db_source->fetch_array($query)) {

		$pollopt = daddslashes($pollopt, 1);

		$votes = 0;
		$uids = '';
		foreach($optionuser as $uid => $polluser) {
			foreach($polluser['option'] as $id => $option) {
				if($option == str_replace('"', '', $pollopt['option'])) {
					$votes++;
					$uids .= $uid."\t";
					$optionuser[$uid]['oid'][$pollopt['oid']] = $pollopt['oid'];
				}
			}
		}
		$optionarr = array(
			'tid' => $tid,
			'votes' => $votes,
			'polloption' => $pollopt['option'],
			'voterids' => $uids
		);
		$changeoid[$pollopt['oid']] = $db_target->insert('forum_polloption', $optionarr, true);
		$option[$pollopt['pid']] = $pollopt;
	}
	if($optionuser) {
		foreach($optionuser as $uid => $polluser) {
			$oparr = array();
			if($polluser['oid']) {
				foreach($polluser['oid'] as $key => $id) {
					$oparr[$key] = $changeoid[$key];
				}
			}
			$userdate = array(
				'tid' => $tid,
				'uid' => intval($uid),
				'username' => daddslashes($polluser['username']),
				'options' => implode("\t", $oparr),
				'dateline' => $polluser['dateline']
			);
			$db_target->insert('forum_pollvoter', $userdate);
		}
	}

	$lastpost = array();
	$query = $db_source->query("SELECT * FROM ".$db_source->table('comment')." WHERE id='$value[pid]' AND idtype='pid' ORDER BY dateline");
	while($comment = $db_source->fetch_array($query)) {
		$comment['message'] = html2bbcode($comment['message']);
		$comment = daddslashes($comment);
		$postarr = array(
			'fid' => $fid,
			'tid' => $tid,
			'first' => '0',
			'author' => $comment['author'],
			'authorid' => $comment['authorid'],
			'useip' => $comment['ip'],
			'dateline' => $comment['dateline'],
			'message' => $comment['message']
		);
		$lastpost = array(
			'lastpost' => $comment['dateline'],
			'lastposter' => $comment['author'],
		);

		$db_target->insert('forum_post', $postarr);
		$db_target->insert('common_member_count', array('uid' => $comment['authorid']), 0, false, true);
		$db_target->query("UPDATE ".$db_target->table('common_member_count')." SET posts=posts+1 WHERE uid='$comment[authorid]'", 'UNBUFFERED');
	}
	if($lastpost) {
		$db_target->update('forum_thread', $lastpost, array('tid' => $tid));
	}
	$db_target->insert('common_member_count', array('uid' => $comment['authorid']), 0, false, true);
	$db_target->query("UPDATE ".$db_target->table('common_member_count')." SET threads=threads+1, posts=posts+$postnum WHERE uid='$value[uid]'", 'UNBUFFERED');
	$db_target->query("UPDATE ".$db_target->table('forum_forum')." SET lastpost='$lastpost[lastpost]', threads=threads+1, posts=posts+$value[replynum], todayposts=todayposts+$value[replynum] WHERE fid='$fid'", 'UNBUFFERED');
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." pid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid&fid=$fid");
}

$maxpid = $db_target->result_first("SELECT MAX(pid) FROM ".$db_target->table('forum_post'));
$maxpid = intval($maxpid) + 1;
$db_target->query("ALTER TABLE ".$db_target->table('forum_post_tableid')." AUTO_INCREMENT=$maxpid");
?>