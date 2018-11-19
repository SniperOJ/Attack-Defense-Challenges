<?php

/**
 * DiscuzX Convert
 *
 * $Id: home_magic.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$op = getgpc('op', 'G');
$op = in_array($op, array('usermagic', 'magicinlog', 'magicuselog')) ? $op : 'magic';

$kept_magics = array(
	'attachsize',
	'call',
	'doodle',
	'downdateline',
	'flicker',
	'friendnum',
	'hot',
	'thunder',
	'updateline',
	'visit'
);
$query = $db_target->query('SELECT magicid, identifier FROM '.$db_target->table_name('common_magic')." WHERE identifier IN ('".implode("','", $kept_magics)."')");
while($value=$db_source->fetch_array($query)) {
	$x_magics[$value['identifier']] = intval($value['magicid']);
}

if($op=='magic') {

	$uch_magics = array();
	$query = $db_source->query('SELECT m.*, ms.storage, ms.sellcount FROM '.$db_source->table_name('magic')." m LEFT JOIN ".$db_source->table_name('magicstore')." ms ON m.mid = ms.mid WHERE m.mid IN ('".implode("','", $kept_magics)."')");
	while($value=$db_source->fetch_array($query)) {
		if(!isset($x_magics[$value['mid']])) {
			$uch_magics[$value['mid']] = $value;
		}
	}
	foreach($uch_magics as $mid=>$value) {
		$magic = array(
			'available' => !empty($value['close']) ? '0' : '1',
			'name' => $value['name'],
			'description' => $value['description'],
			'identifier' => $mid,
			'price' => $value['charge'],
			'num' => $value['storage'],
			'salevolume' => $value['sellcount'],
			'supplynum' => $value['providecount'],
			'usenum' => $value['usecount'],
			'magicperm' => $value['custom'],
			'useevent' => '0'
		);
		if($value['provideperoid']==604800) {
			$magic['supplytype'] = '2';
		} elseif($value['provideperoid']==86400) {
			$magic['supplytype'] = '1';
		} elseif($value['provideperoid'] == 3600) {
			$magic['supplytype'] = '1';
			$magic['supplynum'] = $magic['supplynum'] * 24;
		} else {
			$magic['supplytype'] = '1';
			$magic['supplynum'] = 9999;
		}
		if($value['useperoid']==604800) {
			$magic['useperoid'] = '2';
		} elseif($value['useperoid']==86400) {
			$magic['useperoid'] = '4';
		} elseif($value['useperoid'] == 3600) {
			$magic['useperoid'] = '4';
			$magic['usenum'] = $magic['usenum'] * 24;
		} else {
			$magic['useperoid'] = '0';
		}

		$magic = daddslashes($magic);
		$keys = '`'.implode('`, `', array_keys($magic)).'`';
		$values = "'".implode("', '", $magic)."'";
		$db_target->query('INSERT INTO '.$db_target->table_name('common_magic')."($keys) VALUES ($values)");
	}
	if(!$db_target->result_first("SELECT COUNT(*) FROM ".$db_target->table('common_magic')." WHERE credit>'0'")) {
		$settings_creditstrans = $db_target->result_first("SELECT svalue FROM ".$db_target->table('common_setting')." WHERE skey='creditstrans'");
		$creditstranssi = explode(',', $settings_creditstrans);
		$creditstran = $creditstranssi[3] ? $creditstranssi[3] : $creditstranssi[0];
		$db_target->query("UPDATE ".$db_target->table('common_magic')." SET credit='$creditstran'");
	}
	$db_target->query("UPDATE ".$db_target->table('common_magic')." SET name='变色卡', description='可以将帖子或日志的标题高亮，变更颜色' WHERE identifier='highlight'");
	$db_target->query("UPDATE ".$db_target->table('common_magic')." SET name='显身卡', description='可以查看一次匿名用户的真实身份。' WHERE identifier='namepost'");
	$db_target->query("UPDATE ".$db_target->table('common_magic')." SET name='匿名卡', description='在指定的地方，让自己的名字显示为匿名。' WHERE identifier='anonymouspost'");

	$table_source = $db_source->tablepre.'magic';
	showmessage("继续转换数据表 ".$table_source." 用户道具", "index.php?a=$action&source=$source&prg=$curprg&op=usermagic&start=0");

} elseif($op == 'usermagic') {

	$start = getgpc('start');
	$start = empty($start) ? 0 : intval($start);
	$limit = 1000;
	$nextid = $start + $limit;

	$uch_magics = array();
	$query = $db_source->query('SELECT m.* FROM '.$db_source->table_name('magic')." m WHERE m.mid IN ('".implode("','", $kept_magics)."')");
	while($value=$db_source->fetch_array($query)) {
		$uch_magics[$value['mid']] = $value;
	}

	$done = true;
	$inserts = $updates = array();
	$query = $db_source->query('SELECT  uid, mid, `count` as num FROM '.$db_source->table_name('usermagic')." WHERE `count` > 0 ORDER BY uid LIMIT $start, $limit");
	while($value=$db_source->fetch_array($query)) {
		$done = false;
		if(isset($x_magics[$value['mid']])) {
			$value['magicid'] = $x_magics[$value['mid']];
			$inserts[] = "('$value[uid]', '$value[magicid]', '$value[num]')";
		} else {
			$credit = intval($uch_magics[$value['mid']]['charge'] * $value['num']);
			$updates[$value['uid']] = empty($updates[$value['uid']]) ? $credit : $updates[$value['uid']] + $credit;
		}
	}
	if($inserts) {
		$db_target->query('REPLACE INTO '.$db_target->table_name('common_member_magic')."(uid, magicid, num) VALUES ".implode(', ', $inserts));
	}
	if($updates) {
		foreach($updates as $uid=>$credit) {
			$credit = intval($credit);
			$db_target->query('UPDATE '.$db_target->table_name('common_member')." SET credits = credits + $credit WHERE uid = '$uid'");
		}
	}

	$table_source = $db_source->tablepre.'usermagic';
	if($done == false) {
		showmessage("继续转换数据表 ".$table_source." 用户道具-> $nextid", "index.php?a=$action&source=$source&prg=$curprg&op=usermagic&start=$nextid");
	} else {
		showmessage("继续转换数据表 ".$table_source." 道具收入记录->0", "index.php?a=$action&source=$source&prg=$curprg&op=magicinlog&start=0");
	}

} elseif($op == 'magicinlog') {

	$start = getgpc('start');
	$start = empty($start) ? 0 : intval($start);
	$limit = 2000;
	$nextid = 0;

	$done = true;
	$inserts = array();
	$query = $db_source->query('SELECT * FROM '.$db_source->table_name('magicinlog')." WHERE logid > $start AND mid IN ('".implode("','", $kept_magics)."') LIMIT $limit");
	while($value=$db_source->fetch_array($query)) {
		$done = false;
		$nextid = intval($value['logid']);
		$value['magicid'] = $x_magics[$value['mid']];
		if($value['action']=='1') {
			$inserts[] = "('$value[uid]', '$value[magicid]', '1', '$value[dateline]', '$value[count]', '$value[credit]', '0', '', '0')";
		} elseif($value['action']=='2') {
			$inserts[] = "('$value[uid]', '$value[magicid]', '2', '$value[dateline]', '$value[count]', '$value[credit]', '$value[uid]', 'uid', '$value[uid]')";
		}
	}
	if($inserts) {
		$db_target->query('INSERT INTO '.$db_target->table_name('common_magiclog')."(uid, magicid, action, dateline, amount, price, targetid, idtype, targetuid) VALUES ".implode(', ', $inserts));
	}

	$table_source = $db_source->tablepre.'magicinlog';
	if($done == false) {
		showmessage("继续转换数据表 ".$table_source." 道具收入记录-> $nextid", "index.php?a=$action&source=$source&prg=$curprg&op=magicinlog&start=$nextid");
	} else {
		showmessage("继续转换数据表 ".$table_source." 道具使用记录->0", "index.php?a=$action&source=$source&prg=$curprg&op=magicuselog&start=0");
	}

} elseif($op == 'magicuselog') {

	$start = getgpc('start');
	$start = empty($start) ? 0 : intval($start);
	$limit = 2000;
	$nextid = 0;

	$done = true;
	$inserts = array();
	$query = $db_source->query('SELECT * FROM '.$db_source->table_name('magicuselog')." WHERE logid > $start AND mid IN ('".implode("','", $kept_magics)."') LIMIT $limit");
	while($value=$db_source->fetch_array($query)) {
		$done = false;
		$nextid = intval($value['logid']);
		$value['magicid'] = $x_magics[$value['mid']];
		$inserts[] = "('$value[uid]', '$value[magicid]', '2', '$value[dateline]', '$value[count]', '$value[credit]', '$value[id]', '$value[idtype]', '0')";
	}
	if($inserts) {
		$db_target->query('INSERT INTO '.$db_target->table_name('common_magiclog')."(uid, magicid, action, dateline, amount, price, targetid, idtype, targetuid) VALUES ".implode(', ', $inserts));
	}

	$table_source = $db_source->tablepre.'magicuselog';
	if($done == false) {
		showmessage("继续转换数据表 ".$table_source." 道具使用记录-> $nextid", "index.php?a=$action&source=$source&prg=$curprg&op=magicuselog&start=$nextid");
	}
}


?>