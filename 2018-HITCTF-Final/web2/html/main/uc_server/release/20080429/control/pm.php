<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: pm.php 643 2008-09-25 10:20:59Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class pmcontrol extends base {

	function __construct() {
		$this->pmcontrol();
	}

	function pmcontrol() {
		parent::__construct();
		$this->load('user');
		$this->load('pm');
	}

	function oncheck_newpm() {
		$this->init_input();
		$this->user['uid'] = intval($this->input('uid'));
		$more = $this->input('more');
		$result = $_ENV['pm']->check_newpm($this->user['uid'], $more);
		if($more == 3) {
			require_once UC_ROOT.'lib/uccode.class.php';
			$this->uccode = new uccode();
			$result['lastmsg'] = $this->uccode->complie($result['lastmsg']);
		}
		return $result;
	}

	function onsendpm() {
		$this->init_input();
		$fromuid = $this->input('fromuid');
		$msgto = $this->input('msgto');
		$subject = $this->input('subject');
		$message = $this->input('message');
		$replypmid = $this->input('replypmid');
		$isusername = $this->input('isusername');
		if($fromuid) {
			$user = $_ENV['user']->get_user_by_uid($fromuid);
			$user = daddslashes($user, 1);
			if(!$user) {
				return 0;
			}
			$this->user['uid'] = $user['uid'];
			$this->user['username'] = $user['username'];
		} else {
			$this->user['uid'] = 0;
			$this->user['username'] = '';
		}
		if($replypmid) {
			$isusername = 1;
			$pms = $_ENV['pm']->get_pmnode_by_pmid($this->user['uid'], $replypmid, 3);
			if($pms['msgfromid'] == $this->user['uid']) {
				$user = $_ENV['user']->get_user_by_uid($pms['msgtoid']);
			} else {
				$user = $_ENV['user']->get_user_by_uid($pms['msgfromid']);
			}
			$msgto = $user['username'];
		}

		$msgto = array_unique(explode(',', $msgto));
		$isusername && $msgto = $_ENV['user']->name2id($msgto);
		$blackls = $_ENV['pm']->get_blackls($this->user['uid'], $msgto);
		$lastpmid = 0;
		foreach($msgto as $uid) {
			if(!$fromuid || !in_array('{ALL}', $blackls[$uid])) {
				$blackls[$uid] = $_ENV['user']->name2id($blackls[$uid]);
				if(!$fromuid || isset($blackls[$uid]) && !in_array($this->user['uid'], $blackls[$uid])) {
					$lastpmid = $_ENV['pm']->sendpm($subject, $message, $this->user, $uid, 0, $replypmid);
				}
			}
		}
		return $lastpmid;
	}

	function ondelete() {
		$this->init_input();
		$this->user['uid'] = intval($this->input('uid'));
		$id = $_ENV['pm']->deletepm($this->user['uid'], $this->input('pmids'));
		return $id;
	}

	function onignore() {
		$this->init_input();
		$this->user['uid'] = intval($this->input('uid'));
		return $_ENV['pm']->set_ignore($this->user['uid']);
	}

 	function onls() {
 		$this->init_input();
 		$pagesize = $this->input('pagesize');
 		$folder = $this->input('folder');
 		$filter = $this->input('filter');
 		$page = $this->input('page');
 		$folder = in_array($folder, array('newbox', 'inbox')) ? $folder : 'inbox';
 		$filter = $filter ? (in_array($filter, array('newpm', 'privatepm', 'systempm', 'announcepm')) ? $filter : '') : '';
 		$msglen = $this->input('msglen');
 		$this->user['uid'] = intval($this->input('uid'));
 		$pmnum = $_ENV['pm']->get_num($this->user['uid'], $folder, $filter);
 		if($pagesize > 0) {
	 		$pms = $_ENV['pm']->get_pm_list($this->user['uid'], $pmnum, $folder, $filter, $page, $pagesize);
	 		if(is_array($pms) && !empty($pms)) {
				foreach($pms as $key => $pm) {
					if($msglen) {
						$pms[$key]['message'] = $_ENV['pm']->removecode($pms[$key]['message'], $msglen);
					} else {
						unset($pms[$key]['message']);
					}
					$pms[$key]['dateline'] = $pms[$key]['dbdateline'];
					unset($pms[$key]['dbdateline'], $pms[$key]['folder']);
				}
			}
			$result['data'] = $pms;
		}
		$result['count'] = $pmnum;
 		return $result;
 	}

 	function onviewnode() {
  		$this->init_input();
  		$this->user['uid'] = intval($this->input('uid'));
 		$pmid = $_ENV['pm']->pmintval($this->input('pmid'));
 		$type = $this->input('type');
 		$pm = $_ENV['pm']->get_pmnode_by_pmid($this->user['uid'], $pmid, $type);
 		if($pm) {
	 	 	require_once UC_ROOT.'lib/uccode.class.php';
			$this->uccode = new uccode();
			$pm['message'] = $this->uccode->complie($pm['message']);
			return $pm;
		}
 	}

 	function onview() {
 		$this->init_input();
 		$this->user['uid'] = intval($this->input('uid'));
		$pmid = $_ENV['pm']->pmintval($this->input('pmid'));
		$pm = $_ENV['pm']->get_pmnode_by_pmid($this->user['uid'], $pmid, 3);
		$touid = $pm['msgfromid'] == $this->user['uid'] ? $pm['msgtoid'] : $pm['msgfromid'];
		$pmid = $touid ? '' : $pmid;
 		if(empty($pmid)) {
	 		$endtime = $this->time;
	 		$pms = $_ENV['pm']->get_pm_by_touid($this->user['uid'], $touid, 0, $endtime);
	 	} else {
	 		$pms = $_ENV['pm']->get_pm_by_pmid($this->user['uid'], $pmid);
	 	}

 	 	require_once UC_ROOT.'lib/uccode.class.php';
		$this->uccode = new uccode();
		$status = FALSE;
		foreach($pms as $key => $pm) {
			$pms[$key]['message'] = $this->uccode->complie($pms[$key]['message']);
			!$status && $status = $pm['msgtoid'] && $pm['new'];
		}
		$status && $_ENV['pm']->set_pm_status($this->user['uid'], $touid);
		return $pms;
 	}

  	function onblackls_get() {
  		$this->init_input();
 		$this->user['uid'] = intval($this->input('uid'));
 		return $_ENV['pm']->get_blackls($this->user['uid']);
 	}

 	function onblackls_set() {
 		$this->init_input();
 		$this->user['uid'] = intval($this->input('uid'));
 		$blackls = $this->input('blackls');
 		return $_ENV['pm']->set_blackls($this->user['uid'], $blackls);
 	}

	function onblackls_add() {
		$this->init_input();
 		$this->user['uid'] = intval($this->input('uid'));
 		$username = $this->input('username');
 		return $_ENV['pm']->update_blackls($this->user['uid'], $username, 1);
 	}

 	function onblackls_delete($arr) {
		$this->init_input();
 		$this->user['uid'] = intval($this->input('uid'));
 		$username = $this->input('username');
 		return $_ENV['pm']->update_blackls($this->user['uid'], $username, 2);
 	}

}

?>