<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_space.php 17194 2010-09-26 06:05:16Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$oldpre = $db_source->tablepre;
$newpre = $db_target->tablepre;

$limit = $setting['limit']['space'] ? $setting['limit']['space'] : 500;
$nextid = 0;

$start = getgpc('start');
$home = load_process('home');

$defaultgid = $db_target->result_first("SELECT groupid FROM ".$db_target->table('common_usergroup')." WHERE type='member' AND 0>=creditshigher AND 0<creditslower LIMIT 1");

$query = $db_source->query("SELECT s.*, sf.*
	FROM {$oldpre}space s
	LEFT JOIN {$oldpre}spacefield sf ON sf.uid=s.uid
	WHERE s.uid>'$start' ORDER BY s.uid
	LIMIT $limit");
while ($space = $db_source->fetch_array($query)) {

	$username = daddslashes($space['username']);
	foreach (array('member','member_count','member_field_forum','member_field_home','member_profile','member_status') as $value) {
		if($value == 'member') {
			$db_target->query("INSERT INTO {$newpre}common_{$value} (uid, username) VALUES ('$space[uid]', '$username')", 'SILENT');
		} else {
			$db_target->query("INSERT INTO {$newpre}common_{$value} (uid) VALUES ('$space[uid]')", 'SILENT');
		}
	}

	$nextid = $space['uid'];

	if(!empty($space['privacy'])) {
		$space['privacy'] = unserialize($space['privacy']);
		$space['privacy']['feed'] = array();
		$space['privacy'] = serialize($space['privacy']);
	} else {
		$space['privacy'] = '';
	}
	$space  = daddslashes($space, 1);

	$newquery = $db_target->query("SELECT * FROM {$newpre}common_member WHERE uid='$space[uid]'");
	if($newspace = $db_target->fetch_array($newquery)) {
		$newspace = daddslashes($newspace, 1);
	} else {
		$newspace = array();
	}

	$setarr = array();
	if(empty($newspace['email'])) $setarr['email'] = $space['email'];
	if(empty($newspace['username'])) $setarr['username'] = $space['username'];
	if(empty($newspace['password'])) $setarr['password'] = md5(microtime().mt_rand(0, 100000));
	if(empty($newspace['emailstatus'])) $setarr['emailstatus'] = $space['emailcheck'];
	if(empty($newspace['avatarstatus'])) $setarr['avatarstatus'] = $space['avatar'];
	if(empty($newspace['videophotostatus'])) $setarr['videophotostatus'] = $space['videostatus'];
	if(empty($newspace['regdate'])) $setarr['regdate'] = $space['dateline'];

	$setarr['newprompt'] = $space['notenum'] + $space['myinvitenum'] + $space['pokenum'] + $space['addfriendnum'];
	$set['newpm'] = $space['newpm'];

	if(empty($newspace['groupid'])) {
		if(empty($home['usergroup'][$space['groupid']])) {
			$setarr['groupid'] = $defaultgid;
		} else {
			$setarr['groupid'] = intval($home['usergroup'][$space['groupid']]);
		}

	}

	if($setarr) {
		$updatesql = getupdatesql($setarr);
		$db_target->query("UPDATE {$newpre}common_member SET $updatesql WHERE uid='$space[uid]'", "SILENT");
	}

	$setarr = array();
	$newquery = $db_target->query("SELECT * FROM {$newpre}common_member_count WHERE uid='$space[uid]'");
	if($newspace = $db_target->fetch_array($newquery)) {
		$newspace = daddslashes($newspace, 1);
	} else {
		$newspace = array();
	}

	if(empty($home['extcredits']['credit']) || empty($home['extcredits']['experience'])) {
		showmessage("发生错误，请配置积分对应关系信息");
	}

	$setarr[$home['extcredits']['credit']] = $space['credit'] + intval($newspace[$home['extcredits']['credit']]);
	$setarr[$home['extcredits']['experience']] = $space['experience'] + intval($newspace[$home['extcredits']['experience']]);

	$setarr['friends'] = $space['friendnum'];
	$setarr['doings'] = $space['doingnum'];
	$setarr['blogs'] = $space['blognum'];
	$setarr['albums'] = $space['albumnum'];
	$setarr['sharings'] = $space['sharenum'];
	$setarr['attachsize'] = $space['attachsize'];
	$setarr['views'] = $space['viewnum'];

	if($setarr) {
		$updatesql = getupdatesql($setarr);
		$db_target->query("UPDATE {$newpre}common_member_count SET $updatesql WHERE uid='$space[uid]'");
	}

	$setarr = array();
	$setarr['videophoto'] = $space['videopic'];
	$setarr['domain'] = $space['domain'];
	$setarr['addsize'] = $space['addsize']/(1024 * 1024);
	$setarr['addfriend'] = $space['addfriend'];
	$setarr['recentnote'] = $space['note'];
	$setarr['spacenote'] = $space['spacenote'];
	$setarr['privacy'] = $space['privacy'];
	$setarr['feedfriend'] = $space['feedfriend'];
	$setarr['acceptemail'] = $space['sendmail'];

	if($setarr) {
		$updatesql = getupdatesql($setarr);
		$db_target->query("UPDATE {$newpre}common_member_field_home SET $updatesql WHERE uid='$space[uid]'");
	}

	$newquery = $db_target->query("SELECT * FROM {$newpre}common_member_profile WHERE uid='$space[uid]'");
	if($newspace = $db_target->fetch_array($newquery)) {
		$newspace = daddslashes($newspace, 1);
	} else {
		$newspace = array();
	}

	$space['none'] = '';

	$setarr = array();
	if(empty($newspace['gender'])) $setarr['gender'] = $space['sex'];
	if(empty($newspace['birthyear'])) $setarr['birthyear'] = $space['birthyear'];
	if(empty($newspace['birthmonth'])) $setarr['birthmonth'] = $space['birthmonth'];
	if(empty($newspace['birthday'])) $setarr['birthday'] = $space['birthday'];
	if(empty($newspace['constellation'])) $setarr['constellation'] = $space['none'];
	if(empty($newspace['zodiac'])) $setarr['zodiac'] = $space['none'];
	if(empty($newspace['telephone'])) $setarr['telephone'] = $space['none'];
	if(empty($newspace['mobile'])) $setarr['mobile'] = $space['none'];
	if(empty($newspace['idcard'])) $setarr['idcard'] = $space['none'];
	if(empty($newspace['address'])) $setarr['address'] = $space['none'];
	if(empty($newspace['zipcode'])) $setarr['zipcode'] = $space['none'];
	if(empty($newspace['nationality'])) $setarr['nationality'] = $space['none'];
	if(empty($newspace['birthprovince'])) $setarr['birthprovince'] = $space['birthprovince'];
	if(empty($newspace['birthcity'])) $setarr['birthcity'] = $space['birthcity'];
	if(empty($newspace['resideprovince'])) $setarr['resideprovince'] = $space['resideprovince'];
	if(empty($newspace['residecity'])) $setarr['residecity'] = $space['residecity'];
	if(empty($newspace['residedist'])) $setarr['residedist'] = $space['none'];
	if(empty($newspace['residecommunity'])) $setarr['residecommunity'] = $space['none'];
	if(empty($newspace['residesuite'])) $setarr['residesuite'] = $space['none'];
	if(empty($newspace['graduateschool'])) $setarr['graduateschool'] = $space['none'];
	if(empty($newspace['education'])) $setarr['education'] = $space['none'];
	if(empty($newspace['occupation'])) $setarr['occupation'] = $space['none'];
	if(empty($newspace['revenue'])) $setarr['revenue'] = $space['none'];
	if(empty($newspace['affectivestatus'])) $setarr['affectivestatus'] = $space['none'];
	if(empty($newspace['lookingfor'])) $setarr['lookingfor'] = $space['none'];
	if(empty($newspace['bloodtype'])) $setarr['bloodtype'] = $space['blood'];
	if(empty($newspace['height'])) $setarr['height'] = $space['none'];
	if(empty($newspace['weight'])) $setarr['weight'] = $space['none'];
	if(empty($newspace['alipay'])) $setarr['alipay'] = $space['none'];
	if(empty($newspace['icq'])) $setarr['icq'] = $space['none'];
	if(empty($newspace['qq'])) $setarr['qq'] = $space['qq'];
	if(empty($newspace['yahoo'])) $setarr['yahoo'] = $space['none'];
	if(empty($newspace['msn'])) $setarr['msn'] = $space['msn'];
	if(empty($newspace['taobao'])) $setarr['taobao'] = $space['none'];
	if(empty($newspace['site'])) $setarr['site'] = $space['none'];
	if(empty($newspace['bio'])) $setarr['bio'] = $space['none'];
	if(empty($newspace['interest'])) $setarr['interest'] = $space['none'];
	if(empty($newspace['idcardtype'])) $setarr['idcardtype'] = $space['none'];
	if(empty($newspace['company'])) $setarr['company'] = $space['none'];
	if(empty($newspace['position'])) $setarr['position'] = $space['none'];
	if(empty($newspace['realname'])) $setarr['realname'] = $space['name'];

	if($setarr) {
		$updatesql = getupdatesql($setarr);
		$db_target->query("UPDATE {$newpre}common_member_profile SET $updatesql WHERE uid='$space[uid]'");
	}


	$newquery = $db_target->query("SELECT * FROM {$newpre}common_member_status WHERE uid='$space[uid]'");
	if($newspace = $db_target->fetch_array($newquery)) {
		$newspace = daddslashes($newspace, 1);
	} else {
		$newspace = array();
	}

	$setarr = array();
	if(empty($newspace['regip'])) $setarr['regip'] = $space['regip'];
	if(empty($newspace['lastip'])) $setarr['lastip'] = $space['regip'];
	if(empty($newspace['lastvisit'])) $setarr['lastvisit'] = $space['lastlogin'];
	if(empty($newspace['lastactivity'])) $setarr['lastactivity'] = $space['updatetime'];
	if(empty($newspace['lastpost'])) $setarr['lastpost'] = $space['lastpost'];
	if(empty($newspace['lastsendmail'])) $setarr['lastsendmail'] = $space['lastsend'];

	if($setarr) {
		$updatesql = getupdatesql($setarr);
		$db_target->query("UPDATE {$newpre}common_member_status SET $updatesql WHERE uid='$space[uid]'");
	}


}

if($nextid) {
	showmessage("继续转换数据表 {$oldpre}space uid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

function getupdatesql($setarr) {
	$updatearr = array();
	foreach ($setarr as $key => $value) {
		$updatearr[] = "`$key`='$value'";
	}
	return implode(',', $updatearr);
}

?>