<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: pm.php 643 2008-09-25 10:20:59Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class pmmodel {

	var $db;
	var $base;
	var $lang;

	function __construct(&$base) {
		$this->pmmodel($base);
	}

	function pmmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function pmintval($pmid) {
		return @is_numeric($pmid) ? $pmid : 0;
	}

	function get_pm_by_pmid($uid, $pmid) {
		$arr = array();
		$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE related='$pmid' AND (msgtoid='$uid' OR msgfromid='$uid') ORDER BY dateline");
		if(!$arr) {
			$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE pmid='$pmid' AND (msgtoid IN ('$uid','0') OR msgfromid='$uid')");
		}
		return $arr;
	}

	function get_pm_by_touid($uid, $touid, $starttime, $endtime) {
		$arr1 = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$uid' AND msgtoid='$touid' AND dateline>='$starttime' AND dateline<'$endtime' AND related>'0' AND delstatus IN (0,2) ORDER BY dateline");
		$arr2 = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$touid' AND msgtoid='$uid' AND dateline>='$starttime' AND dateline<'$endtime' AND related>'0' AND delstatus IN (0,1) ORDER BY dateline");
		$arr = array_merge($arr1, $arr2);
		uasort($arr, 'pm_datelinesort');
		return $arr;
	}

	function get_pmnode_by_pmid($uid, $pmid, $type = 0) {
		$arr = array();
		if($type == 1) {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$uid' and folder='inbox' ORDER BY dateline DESC LIMIT 1");
		} elseif($type == 2) {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE msgtoid='$uid' and folder='inbox' ORDER BY dateline DESC LIMIT 1");
		} else {
			$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE pmid='$pmid'");
		}
		return $arr;
	}

	function set_pm_status($uid, $touid) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET new='0' WHERE msgfromid='$touid' AND msgtoid='$uid' AND new='1'", 'UNBUFFERED');
	}

	function get_pm_num($uid, $folder, $filter, $a) {
		$folder = $folder;
		$get_pm_num = 0;
		$pm_num = isset($_COOKIE['uc_pmnum']) && ($pm_num = explode('|', $_COOKIE['uc_pmnum'])) && $pm_num[0] == $uid ? $pm_num : array(0,0,0,0);
		switch($folder) {
			case 'newbox':
				$get_pm_num = $this->get_num($uid, 'newbox');
				break;
			case 'inbox':
				if(!$filter && $a != 'view') {
					$get_pm_num = $this->get_num($uid, 'inbox');
				} else {
					$get_pm_num = $pm_num[1];
				}
				break;
		}
		if($a == 'ls') {
			$get_announcepm_num = $this->get_num($uid, 'inbox', 'announcepm');
			$get_systempm_num = $this->get_num($uid, 'inbox', 'systempm');
			$get_newinbox_num = $this->get_num($uid, 'inbox', 'newpm');
		} else {
			list(, $get_newinbox_num, $get_systempm_num, $get_announcepm_num) = $pm_num;
		}
		if($pm_num[2] != $get_newinbox_num || $pm_num[3] != $get_systempm_num || $pm_num[4] != $get_announcepm_num) {
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			$this->base->setcookie('uc_pmnum', $uid.'|'.$get_pm_num.'|'.$get_systempm_num.'|'.$get_announcepm_num, 3600);
		}
		return array($get_pm_num, $get_newinbox_num, 0, $get_systempm_num, $get_announcepm_num);
	}

	function get_num($uid, $folder, $filter = '') {
		switch($folder) {
			case 'newbox':
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE msgtoid='$uid' AND (related='0' AND msgfromid>'0' OR msgfromid='0') AND folder='inbox' AND new='1'";
				$num = $this->db->result_first($sql);
				return $num;
			case 'inbox':
				if($filter == 'newpm') {
					$filteradd = "msgtoid='$uid' AND (related='0' AND msgfromid>'0' OR msgfromid='0') AND folder='inbox' AND new='1'";
				} elseif($filter == 'systempm') {
					$filteradd = "msgtoid='$uid' AND msgfromid='0' AND folder='inbox'";
				} elseif($filter == 'privatepm') {
					$filteradd = "msgtoid='$uid' AND related='0' AND msgfromid>'0' AND folder='inbox'";
				} elseif($filter == 'announcepm') {
					$filteradd = "msgtoid='0' AND folder='inbox'";
				} else {
					$filteradd = "msgtoid='$uid' AND related='0' AND folder='inbox'";
				}
				$sql = "SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE $filteradd";
				break;
		}
		$num = $this->db->result_first($sql);
		return $num;
	}

	function get_pm_list($uid, $pmnum, $folder, $filter, $page, $ppp = 10, $new = 0) {
		$ppp = $ppp ? $ppp : 10;
 		$start_limit = $this->base->page_get_start($page, $ppp, $pmnum);
		switch($folder) {
			case 'newbox':
				$folder = 'inbox';
				$filter = 'newpm';
			case 'inbox':
				if($filter == 'newpm') {
					$filteradd = "pm.msgtoid='$uid' AND (pm.related='0' AND pm.msgfromid>'0' OR pm.msgfromid='0') AND pm.folder='inbox' AND pm.new='1'";
				} elseif($filter == 'systempm') {
					$filteradd = "pm.msgtoid='$uid' AND pm.msgfromid='0' AND pm.folder='inbox'";
				} elseif($filter == 'privatepm') {
					$filteradd = "pm.msgtoid='$uid' AND pm.related='0' AND pm.msgfromid>'0' AND pm.folder='inbox'";
				} elseif($filter == 'announcepm') {
					$filteradd = "pm.msgtoid='0' AND pm.folder='inbox'";
				} else {
					$filteradd = "pm.msgtoid='$uid' AND pm.related='0' AND pm.folder='inbox'";
				}
				$sql = "SELECT pm.*,m.username as msgfrom FROM ".UC_DBTABLEPRE."pms pm
					LEFT JOIN ".UC_DBTABLEPRE."members m ON pm.msgfromid = m.uid
					WHERE $filteradd ORDER BY pm.dateline DESC LIMIT $start_limit, $ppp";
				break;
		}
		$query = $this->db->query($sql);
		$array = array();
		$today = $this->base->time - ($this->base->time + $this->base->settings['timeoffset']) % 86400;
		while($data = $this->db->fetch_array($query)) {
			$daterange = 5;
			if($data['dateline'] >= $today) {
				$daterange = 1;
			} elseif($data['dateline'] >= $today - 86400) {
				$daterange = 2;
			} elseif($data['dateline'] >= $today - 172800) {
				$daterange = 3;
			} elseif($data['dateline'] >= $today - 604800) {
				$daterange = 4;
			}
			$data['daterange'] = $daterange;
			$data['daterangetext'] = !empty($this->lang['pm_daterange_'.$daterange]) ? $this->lang['pm_daterange_'.$daterange] : $daterange;
			$data['dbdateline'] = $data['dateline'];
			$data['datelinetime'] = $this->base->date($data['dateline'], 1);
			$data['dateline'] = $this->base->date($data['dateline']);
			$data['subject'] = $data['subject'] != '' ? htmlspecialchars($data['subject']) : $this->lang['pm_notitle'];
			$data['newstatus'] = $data['new'];
			$data['touid'] = $data['avataruid'] = $uid == $data['msgfromid'] ? $data['msgtoid'] : $data['msgfromid'];
			$data['message'] = $this->removecode($data['message'], 80);
			$array[] = $data;
		}
		if($folder == 'inbox') {
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'", 'UNBUFFERED');
		}
		return $array;
	}

	function sendpm($subject, $message, $msgfrom, $msgto, $pmid = 0, $related = 0) {
		//note 过滤关键词
		$_CACHE['badwords'] = $this->base->cache('badwords');
		if($_CACHE['badwords']['findpattern']) {
			$subject = @preg_replace($_CACHE['badwords']['findpattern'], $_CACHE['badwords']['replace'], $subject);
			$message = @preg_replace($_CACHE['badwords']['findpattern'], $_CACHE['badwords']['replace'], $message);
		}

		if($msgfrom['uid'] && $msgfrom['uid'] == $msgto) {
			return 0;
		}
		$box = 'inbox';
		$subject = trim($subject);
		if($subject == '' && !$related) {
			$subject = $this->removecode(trim($message), 75);
		} else {
			$subject = $this->base->cutstr(trim($subject), 75, '');
		}

		if($msgfrom['uid']) {
			if($msgto) {
				$sessionexist = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$msgfrom[uid]' AND msgtoid='$msgto' AND folder='inbox' AND related='0'");
			} else {
				$sessionexist = 0;
			}
			if(!$sessionexist || $sessionexist > 1) {
				if($sessionexist > 1) {
					$this->db->query("DELETE FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$msgfrom[uid]' AND msgtoid='$msgto' AND folder='inbox' AND related='0'");
				}
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message,fromappid) VALUES
					('".$msgfrom['username']."','".$msgfrom['uid']."','$msgto','$box','1','$subject','".$this->base->time."','0','$message','".$this->base->app['appid']."')");
				$lastpmid = $this->db->insert_id();
			} else {
				$this->db->query("UPDATE ".UC_DBTABLEPRE."pms SET subject='$subject', message='$message', dateline='".$this->base->time."', new='1', fromappid='".$this->base->app['appid']."'
					WHERE msgfromid='$msgfrom[uid]' AND msgtoid='$msgto' AND folder='inbox' AND related='0'");
			}
			if($msgto) {
				$sessionexist = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE msgfromid='$msgto' AND msgtoid='$msgfrom[uid]' AND folder='inbox' AND related='0'");
				if($msgfrom['uid'] && !$sessionexist) {
					$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message,fromappid) VALUES
						('".$msgfrom['username']."','$msgto','".$msgfrom['uid']."','$box','0','$subject','".$this->base->time."','0','$message','0')");
				}
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message,fromappid) VALUES
					('".$msgfrom['username']."','".$msgfrom['uid']."','$msgto','$box','1','$subject','".$this->base->time."','".($msgfrom['uid'] ? 1 : 0)."','$message','".$this->base->app['appid']."')");
				$lastpmid = $this->db->insert_id();
			}
			if($msgto) {
				$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."newpm (uid) VALUES ('$msgto')");
			}
		} else {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."pms (msgfrom,msgfromid,msgtoid,folder,new,subject,dateline,related,message,fromappid) VALUES
				('".$msgfrom['username']."','".$msgfrom['uid']."','$msgto','$box','1','$subject','".$this->base->time."','0','$message','".$this->base->app['appid']."')");
			$lastpmid = $this->db->insert_id();
		}
		return $lastpmid;
	}

	function set_ignore($uid) {
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'");
	}

	function check_newpm($uid, $more) {
		if($more < 2) {
			$newpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."newpm WHERE uid='$uid'");
			if($newpm) {
				$newpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE (related='0' AND msgfromid>'0' OR msgfromid='0') AND msgtoid='$uid' AND folder='inbox' AND new='1'");
				if($more) {
					$newprvpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND msgfromid>'0' AND msgtoid='$uid' AND folder='inbox' AND new='1'");
					return array('newpm' => $newpm, 'newprivatepm' => $newprvpm);
				} else {
					return $newpm;
				}
			}
		} else {
			$newpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE (related='0' AND msgfromid>'0' OR msgfromid='0') AND msgtoid='$uid' AND folder='inbox' AND new='1'");
			$newprvpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND msgfromid>'0' AND msgtoid='$uid' AND folder='inbox' AND new='1'");
			if($more == 2 || $more == 3) {
				$annpm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND msgtoid='0' AND folder='inbox'");
				$syspm = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."pms WHERE related='0' AND msgtoid='$uid' AND folder='inbox' AND msgfromid='0'");
			}
			if($more == 2) {
				return array('newpm' => $newpm, 'newprivatepm' => $newprvpm, 'announcepm' => $annpm, 'systempm' => $syspm);
			} if($more == 4) {
				return array('newpm' => $newpm, 'newprivatepm' => $newprvpm);
			} else {
				$pm = $this->db->fetch_first("SELECT pm.dateline,pm.msgfromid,m.username as msgfrom,pm.message FROM ".UC_DBTABLEPRE."pms pm LEFT JOIN ".UC_DBTABLEPRE."members m ON pm.msgfromid = m.uid WHERE (pm.related='0' OR pm.msgfromid='0') AND pm.msgtoid='$uid' AND pm.folder='inbox' ORDER BY pm.dateline DESC LIMIT 1");
				return array('newpm' => $newpm, 'newprivatepm' => $newprvpm, 'announcepm' => $annpm, 'systempm' => $syspm, 'lastdate' => $pm['dateline'], 'lastmsgfromid' => $pm['msgfromid'], 'lastmsgfrom' => $pm['msgfrom'], 'lastmsg' => $pm['message']);
			}
		}
	}

	function deletepm($uid, $pmids) {
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."pms WHERE msgtoid='$uid' AND pmid IN (".$this->base->implode($pmids).")");
		$delnum = $this->db->affected_rows();
		return $delnum;
	}

	function get_blackls($uid, $uids = array()) {
		if(!$uids) {
			$blackls = $this->db->result_first("SELECT blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid='$uid'");
		} else {
			$uids = $this->base->implode($uids);
			$blackls = array();
			$query = $this->db->query("SELECT uid, blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid IN ($uids)");
			while($data = $this->db->fetch_array($query)) {
				$blackls[$data['uid']] = explode(',', $data['blacklist']);
			}
		}
		return $blackls;
	}

	function set_blackls($uid, $blackls) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."memberfields SET blacklist='$blackls' WHERE uid='$uid'");
		return $this->db->affected_rows();
	}

	function update_blackls($uid, $username, $action = 1) {
		$username = !is_array($username) ? array($username) : $username;
		if($action == 1) {
			if(!in_array('{ALL}', $username)) {
				$usernames = $this->base->implode($username);
				$query = $this->db->query("SELECT username FROM ".UC_DBTABLEPRE."members WHERE username IN ($usernames)");
				$usernames = array();
				while($data = $this->db->fetch_array($query)) {
					$usernames[addslashes($data['username'])] = addslashes($data['username']);
				}
				if(!$usernames) {
					return 0;
				}
				$blackls = addslashes($this->db->result_first("SELECT blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid='$uid'"));
				if($blackls) {
					$list = explode(',', $blackls);
					foreach($list as $k => $v) {
						if(in_array($v, $usernames)) {
							unset($usernames[$v]);
						}
					}
				}
				if(!$usernames) {
					return 1;
				}
				$listnew = implode(',', $usernames);
				$blackls .= $blackls !== '' ? ','.$listnew : $listnew;
			} else {
				$blackls = addslashes($this->db->result_first("SELECT blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid='$uid'"));
				$blackls .= ',{ALL}';
			}
		} else {
			$blackls = addslashes($this->db->result_first("SELECT blacklist FROM ".UC_DBTABLEPRE."memberfields WHERE uid='$uid'"));
			$list = $blackls = explode(',', $blackls);
			foreach($list as $k => $v) {
				if(in_array($v, $username)) {
					unset($blackls[$k]);
				}
			}
			$blackls = implode(',', $blackls);
		}
		$this->db->query("UPDATE ".UC_DBTABLEPRE."memberfields SET blacklist='$blackls' WHERE uid='$uid'");
		return 1;
	}

	function removecode($str, $length) {
		return trim($this->base->cutstr(preg_replace(array(
				"/\[(email|code|quote|img)=?.*\].*?\[\/(email|code|quote|img)\]/siU",
				"/\[\/?(b|i|url|u|color|size|font|align|list|indent|float)=?.*\]/siU",
				"/\r\n/",
			), '', $str), $length));
	}

}

function pm_datelinesort($a, $b) {
	if ($a['dateline'] == $b['dateline']) {
		return 0;
	}
	return ($a['dateline'] < $b['dateline']) ? -1 : 1;
}

?>