<?php
namespace Common\Model;
use Think\Model;
class UserModel extends Model
{
	public function checkunique($where)
	{
		$rs = M("User");
		$list = $rs->where($where)->find();

		if (NULL == $list) {
			return true;
		}

		return false;
	}

	public function getmember($where)
	{
		$rs = M("User");
		$member = $rs->where($where)->find();

		if (NULL == $member) {
			return NULL;
		}

		return $member;
	}

	public function getmemberdetail($where)
	{
		$detail = M("User_detail");
		$member = $detail->where($where)->find();

		if (NULL == $member) {
			return NULL;
		}

		return $member;
	}

	public function updatetmemberlogin($logininfo, $userid)
	{
		$rs = D("User");
		$rs->where(array("userid" => $userid))->setInc("loginnum");
		return $rs->where(array("userid" => $userid))->save($logininfo);
	}

	public function updatetmemberdetailinfo($memberinfo, $userid)
	{
		$detail = M("User_detail");
		$where = array("userid" => $userid);
		unset($memberinfo["nickname"]);

		if (0 < $detail->where($where)->count()) {
			return $detail->where($where)->save($memberinfo);
		}
		else {
			$memberinfo["userid"] = $userid;
			return $detail->add($memberinfo);
		}
	}

	public function getVisitlove($userid, $pager)
	{
		$rs = D("Ting");
		$order = C("db_prefix") . "ting.ting_addtime desc";
		$join = C("db_prefix") . "favorite on " . C("db_prefix") . "favorite.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "favorite.user_id = " . $userid;
		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "favorite.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getRemindTotal($userid, $catalog)
	{
		$rs = D("Ting");
		$join = C("db_prefix") . "remind on " . C("db_prefix") . "remind.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "remind.user_id = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "remind.ting_cid = " . $catalog;
		}

		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "remind.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->count();
		return $list;
	}

	public function getRemindList($userid, $catalog, $pager)
	{
		$rs = D("Ting");
		$order = C("db_prefix") . "ting.ting_addtime desc";
		$join = C("db_prefix") . "remind on " . C("db_prefix") . "remind.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "remind.user_id = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "remind.ting_cid = " . $catalog;
		}

		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "remind.ting_cdate," . C("db_prefix") . "remind.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getVisitRemind($userid, $pager)
	{
		$rs = D("Ting");
		$order = C("db_prefix") . "remind.cdate desc";
		$join = C("db_prefix") . "remind on " . C("db_prefix") . "remind.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "remind.user_id = " . $userid;
		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "remind.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getCatalogs($userid)
	{
		$rs = D("List");
		$order = C("db_prefix") . "favorite.cdate desc";
		$join = " inner join " . C("db_prefix") . "favorite on " . C("db_prefix") . "favorite.ting_cid = " . C("db_prefix") . "list.list_id ";
		$where = C("db_prefix") . "favorite.user_id = " . $userid;
		$field = "list_name,list_id";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->select();
		$tingNumArray = array();

		foreach ($list as $key => $value ) {
			if (is_array($value)) {
				$key = $value["list_id"];

				if ($tingNumArray[$key]) {
					$tingNumArray[$key]["count"] += 1;
				}
				else {
					$tingNumArray[$key] = array("id" => $key, "name" => $value["list_name"], "count" => 1);
				}
			}
		}

		return $tingNumArray;
	}

	public function getRemindCatalogs($userid)
	{
		$rs = D("List");
		$order = C("db_prefix") . "remind.cdate desc";
		$join = " inner join " . C("db_prefix") . "remind on " . C("db_prefix") . "remind.ting_cid = " . C("db_prefix") . "list.list_id ";
		$where = C("db_prefix") . "remind.user_id = " . $userid;
		$field = "list_name,list_id";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->select();
		$tingNumArray = array();

		foreach ($list as $key => $value ) {
			if (is_array($value)) {
				$key = $value["list_id"];

				if ($tingNumArray[$key]) {
					$tingNumArray[$key]["count"] += 1;
				}
				else {
					$tingNumArray[$key] = array("id" => $key, "name" => $value["list_name"], "count" => 1);
				}
			}
		}

		return $tingNumArray;
	}

	public function getFavoritList($userid, $catalog, $pager)
	{
		$rs = D("Ting");
		$order = C("db_prefix") . "ting.ting_addtime desc";
		$join = C("db_prefix") . "favorite on " . C("db_prefix") . "favorite.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "favorite.user_id = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "favorite.ting_cid = " . $catalog;
		}

		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "favorite.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getFavoritTotal($userid, $catalog)
	{
		$rs = D("Ting");
		$join = C("db_prefix") . "favorite on " . C("db_prefix") . "favorite.ting_id = " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "favorite.user_id = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "favorite.ting_cid = " . $catalog;
		}

		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year," . C("db_prefix") . "favorite.ting_cid as pid";
		$list = $rs->field($field)->join($join)->where($where)->count();
		return $list;
	}

	public function getLoveDatas($userid)
	{
		$rs = D("Ting");
		$order = " a.fnum desc , " . C("db_prefix") . "ting.ting_addtime desc ";
		$join = " inner join ( select b.ting_id,count(b.ting_id) as fnum from " . C("db_prefix") . "favorite b where not exists(select ting_id from " . C("db_prefix") . "favorite c where user_id = " . $userid . " and b.ting_id = c.ting_id ) group by b.ting_id ) a  on " . C("db_prefix") . "ting.ting_id = a.ting_id";
		$where = C("db_prefix") . "favorite.user_id = " . $userid;
		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year";
		$list = $rs->field($field)->join($join)->order($order)->limit("10")->select();
		return $list;
	}

	public function getRemindDatas($userid)
	{
		$rs = D("Ting");
		$order = " a.fnum desc , " . C("db_prefix") . "ting.ting_addtime desc ";
		$join = " inner join ( select b.ting_id,count(b.ting_id) as fnum from " . C("db_prefix") . "remind b where not exists(select ting_id from " . C("db_prefix") . "remind c where user_id = " . $userid . " and b.ting_id = c.ting_id ) group by b.ting_id ) a  on " . C("db_prefix") . "ting.ting_id = a.ting_id";
		$where = C("db_prefix") . "remind.user_id = " . $userid;
		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year";
		$list = $rs->field($field)->join($join)->order($order)->limit("10")->select();
		return $list;
	}

	public function getcomms($where, $pager)
	{
		$rs = D("comment");
		$order = C("db_prefix") . "comment.creat_at desc ";
		$join = " inner join " . C("db_prefix") . "ting on  " . C("db_prefix") . "comment.ting_id= " . C("db_prefix") . "ting.ting_id ";
		$field = C("db_prefix") . "comment.comment_id," . C("db_prefix") . "comment.content," . C("db_prefix") . "comment.support," . C("db_prefix") . "comment.oppose," . C("db_prefix") . "comment.ispass," . C("db_prefix") . "comment.pid," . C("db_prefix") . "comment.reply," . C("db_prefix") . "comment.creat_at," . C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_pic," . C("db_prefix") . "ting.ting_title," . C("db_prefix") . "ting.ting_addtime," . C("db_prefix") . "ting.ting_continu," . C("db_prefix") . "ting.ting_gold," . C("db_prefix") . "ting.ting_actor," . C("db_prefix") . "ting.ting_year";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function Getvisitors($uid, $limit)
	{
		$rs = M("Visitors");
		$order = C("db_prefix") . "visitors.visitorsdate desc ";
		$join = " inner join " . C("db_prefix") . "user on  " . C("db_prefix") . "user.userid= " . C("db_prefix") . "visitors.userid";
		$where = C("db_prefix") . "visitors.user_id  = " . $uid;
		$field = C("db_prefix") . "visitors.*," . C("db_prefix") . "user.userid," . C("db_prefix") . "user.nickname," . C("db_prefix") . "user.username";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($limit)->page($pager["currentpage"])->select();
		return $list;
	}

	public function Getuserinfo($uid)
	{
		$rs = M("User");
		$join = " left join " . C("db_prefix") . "user_detail on  " . C("db_prefix") . "user.userid= " . C("db_prefix") . "user_detail.userid";
		$where = C("db_prefix") . "user.userid  = " . $uid;
		$field = C("db_prefix") . "user_detail.*," . C("db_prefix") . "user.userid," . C("db_prefix") . "user.username," . C("db_prefix") . "user.nickname," . C("db_prefix") . "user.regdate," . C("db_prefix") . "user.lastdate," . C("db_prefix") . "user.avatar," . C("db_prefix") . "user.avatar_img";
		$list = $rs->field($field)->join($join)->where($where)->find();
		return $list;
	}

	public function gettingid($id)
	{
		$rs = M("Ting");
		$where = C("db_prefix") . "ting.ting_id  = " . $id;
		$field = C("db_prefix") . "ting.ting_id," . C("db_prefix") . "ting.ting_letters," . C("db_prefix") . "ting.ting_play," . C("db_prefix") . "ting.ting_url," . C("db_prefix") . "ting.ting_name," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_jumpurl";
		$list = $rs->field($field)->where($where)->find();
		return $list;
	}

	public function getemail($ting_id)
	{
		$rs = M("Remind");
		$join = " left join " . C("db_prefix") . "user on  " . C("db_prefix") . "user.userid = " . C("db_prefix") . "remind.user_id ";
		$where = C("db_prefix") . "remind.ting_id = " . $ting_id . " and " . C("db_prefix") . "user.isRemind = 1 ";
		$field = C("db_prefix") . "user.nickname," . C("db_prefix") . "user.userid," . C("db_prefix") . "user.iemail," . C("db_prefix") . "user.email";
		$list = $rs->field($field)->join($join)->where($where)->select();
		return $list;
	}

	public function getstation($ting_id)
	{
		$rs = M("Remind");
		$join = " left join " . C("db_prefix") . "user on  " . C("db_prefix") . "user.userid = " . C("db_prefix") . "remind.user_id ";
		$where = C("db_prefix") . "remind.ting_id = " . $ting_id . " and " . C("db_prefix") . "user.isstation = 1 ";
		$field = C("db_prefix") . "remind.*," . C("db_prefix") . "user.userid";
		$list = $rs->field($field)->join($join)->where($where)->select();
		return $list;
	}

	public function getCommsTotal($where)
	{
		$rs = D("comment");
		$join = " inner join " . C("db_prefix") . "ting on  " . C("db_prefix") . "comment.ting_id= " . C("db_prefix") . "ting.ting_id ";
		return $rs->join($join)->where($where)->count();
	}

	public function saveComment($comment)
	{

		$rs = D("comment");
				//print_r($rs);die();
		$uid = $rs->add($comment);
		//print_r($comment);
		return 0 < $uid ? true : false;
	}

	public function getPublicComments($where, $pager)
	{
		$rs = D("comment");
		$field = C("db_prefix") . "comment.comment_id," . C("db_prefix") . "comment.content," . C("db_prefix") . "comment.creat_at," . C("db_prefix") . "comment.userid," . C("db_prefix") . "comment.support," . C("db_prefix") . "comment.oppose," . C("db_prefix") . "user.avatar," . C("db_prefix") . "user.nickname," . C("db_prefix") . "comment.pid," . C("db_prefix") . "comment.reply";
		$join = "left join " . C("db_prefix") . "user on  " . C("db_prefix") . "comment.userid= " . C("db_prefix") . "user.userid ";
		$list = $rs->field($field)->join($join)->where($where)->order("creat_at desc ")->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function gethComments($pid)
	{
		$rs = D("comment");
		$order = C("db_prefix") . "comment.creat_at  desc";
		$field = C("db_prefix") . "comment.comment_id," . C("db_prefix") . "comment.content," . C("db_prefix") . "comment.creat_at," . C("db_prefix") . "comment.userid," . C("db_prefix") . "comment.support," . C("db_prefix") . "comment.oppose," . C("db_prefix") . "user.avatar," . C("db_prefix") . "user.nickname," . C("db_prefix") . "comment.pid," . C("db_prefix") . "comment.reply";
		$join = " inner join " . C("db_prefix") . "user on  " . C("db_prefix") . "comment.userid= " . C("db_prefix") . "user.userid ";
		$where = C("db_prefix") . "comment.pid  = " . $pid;
		$listt = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $listt;
	}

	public function getPublicCommentTotal($where)
	{
		$rs = M("comment");
		return $rs->where($where)->count("comment_id");
	}

	public function getMark($ting_id)
	{
		$rs = M("Ting_mark");
		$field = "sum(F1) as F1 ,sum(F2) as F2 ,sum(F3) as F3 ,sum(F4) as F4 ,sum(F5) as F5";
		return $rs->field($field)->where(array("ting_id" => $ting_id))->find();
	}

	public function getMarkValue($ting_id, $ip)
	{
		$rs = M("Ting_mark");
		$data = $rs->field("F1,F2,F3,F4,F5")->where(array("ip" => $ip, "ting_id" => $ting_id))->find();
		$value = -1;

		if ($data != null) {
			if ($data["F1"] == 1) {
				$value = 1;
			}
			else if ($data["F2"] == 1) {
				$value = 2;
			}
			else if ($data["F3"] == 1) {
				$value = 3;
			}
			else if ($data["F4"] == 1) {
				$value = 4;
			}
			else if ($data["F5"] == 1) {
				$value = 5;
			}
		}

		return $value;
	}

	public function isFavoriteTing($where)
	{
		$rs = M("Favorite");
		$count = $rs->where($where)->count();
		return 0 < $count ? true : false;
	}

	public function isRemindTing($where)
	{
		$rs = M("Remind");
		$count = $rs->where($where)->count();
		return 0 < $count ? true : false;
	}

	public function getCommentById($comment_id)
	{
		$rs = M("comment");
		$join = " left join " . C("db_prefix") . "user on  " . C("db_prefix") . "comment.userid= " . C("db_prefix") . "user.userid";
		$where = C("db_prefix") . "comment.comment_id  = " . $comment_id;
		$field = C("db_prefix") . "user.nickname," . C("db_prefix") . "user.userid," . C("db_prefix") . "comment.content";
		$list = $rs->field($field)->join($join)->where($where)->find();
		return $list;
	}

	public function getPlayLogTotal($userid)
	{
		$rs = M("Playlog");
		$join = " inner join " . C("db_prefix") . "ting on  " . C("db_prefix") . "playlog.ting_id= " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "playlog.userid = " . $this->userid;
		$count = $rs->join($join)->where($where)->count();
		return $count;
	}

	public function getPlayLogs($where, $pager)
	{
		$rs = M("Playlog");
		$order = C("db_prefix") . "playlog.creat_time desc ";
		$join = " inner join " . C("db_prefix") . "ting on  " . C("db_prefix") . "playlog.ting_id= " . C("db_prefix") . "ting.ting_id ";
		$where = C("db_prefix") . "playlog.userid = " . $where;
		$field = C("db_prefix") . "playlog.*," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_jumpurl," . C("db_prefix") . "ting.ting_letters";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getmsgTotal($userid)
	{
		$rs = M("Private");
		$join = " inner join " . C("db_prefix") . "user on  " . C("db_prefix") . "private.user_id= " . C("db_prefix") . "user.userid ";
		$where = C("db_prefix") . "private.userid = " . $this->userid;
		$count = $rs->join($join)->where($where)->count();
		return $count;
	}

	public function getgbTotal($userid, $catalog)
	{
		$rs = M("Guestbook");
		$where = C("db_prefix") . "guestbook.gb_uid = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "guestbook.gb_cid= " . $catalog;
		}

		$list = $rs->where($where)->count();
		return $list;
	}

	public function getgbList($userid, $catalog, $pager)
	{
		$rs = M("Guestbook");
		$order = C("db_prefix") . "guestbook.gb_addtime desc";
		$where = C("db_prefix") . "guestbook.gb_uid  = " . $userid;

		if (!empty($catalog)) {
			$where = $where . " and " . C("db_prefix") . "guestbook.gb_cid= " . $catalog;
		}

		$list = $rs->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}

	public function getmsgs($userid, $pager)
	{
		$rs = M("Private");
		$order = C("db_prefix") . "private.time desc ";
		$join = " inner join " . C("db_prefix") . "user on  " . C("db_prefix") . "private.user_id= " . C("db_prefix") . "user.userid ";
		$where = C("db_prefix") . "private.userid = " . $userid;
		$field = C("db_prefix") . "private.*," . C("db_prefix") . "user.userid," . C("db_prefix") . "user.nickname";
		$list = $rs->field($field)->join($join)->where($where)->order($order)->limit($pager["limit"])->page($pager["currentpage"])->select();
		return $list;
	}
}


