<?php
namespace Home\Action;
use Common\Action\HomeAction;
class CommAction extends HomeAction
{
	public $userid;
	public $isLogin = false;

	public function _initialize()
	{
		$userid = cookie("_userid");

		if (!empty($userid)) {
			$this->userid = cookie_decode($userid);
			$this->isLogin = true;
		}
	}
private function outputPublicCommns($list)
	{
		$ajaxtxt = "";

		foreach ($list as $key => $value ) {
			$avatar = ps_getavatar($value["userid"]);
			$image = $avatar["small"];
			preg_match("/\#\#\#([\s\S]*?)\@\@\@/", $value["content"], $huid);
			$content = preg_replace("/\#\#\#.*?\@\@\@/", UU("User-Home/index", array("id" => $huid[1]), true, false), $value["content"]);
			$rs = D("User");
			$listt = $rs->gethComments($value["comment_id"]);
			$ajaxtxt .= "<li id='li" . $value["comment_id"] . "' class='comment-item fn-clear'>";
			$ajaxtxt .= "<div class='comment-time'><p class='date-time'><strong>" . date("m-d H:i", $value["creat_at"]) . "</strong></p></div>";
			$ajaxtxt .= "<div class='comment-post'>";
			$ajaxtxt .= "<div class='comment-post-arrow'></div>";
			$ajaxtxt .= "<div class='comment-post-cnt'>";
			$ajaxtxt .= "<div class='comment-avatar'><a href='" . UU("User-Home/index", array("id" => $value["userid"]), true, false) . "' target='_blank'><img src='" . $image . "' alt='" . $value["nickname"] . "'></a></div>";
			$ajaxtxt .= "<div class='comment-body'>";
			$ajaxtxt .= "<div class='comment-text'><span class='user'><a href='" . UU("User-Home/index", array("id" => $value["userid"]), true, false) . "' target='_blank'>" . $value["nickname"] . "</a></span>：<em><em>" . $content . "</em>";
			$ajaxtxt .= "</em>";
			$ajaxtxt .= "</div>";
			$ajaxtxt .= "<div class='comment-assist fn-clear'>";
			$ajaxtxt .= "<p class='fn-left'><span class='digg'><a href='javascript:void(0)' class='sup' data='" . UUU("Home-Comm/digg", array("id" => $value["comment_id"], "type" => "sup"), true, false) . "'>支持(<strong>" . $value["support"] . "</strong>)</a></span><span class='digg'><a href='javascript:void(0)' class='opp' data='" . UUU("Home-Comm/digg", array("id" => $value["comment_id"], "type" => "opp"), true, false) . "'>反对(<strong>" . $value["oppose"] . "</strong>)</a></span></p>";
			$ajaxtxt .= "<p class='fn-right'><a href='javascript:void(0)' data='" . $value["comment_id"] . "' class='reply'>回复</a></p>";
			$ajaxtxt .= "</div>";
			$ajaxtxt .= "<div id='rep" . $value["comment_id"] . "' class='comms'></div>";
			$ajaxtxt .= "</div>";
			$ajaxtxt .= "</div>";
			$ajaxtxt .= "<div class='fn-clear'></div>";
			$ajaxtxt .= "</div>";
			$ajaxtxt .= "</li>";
		}

		return $ajaxtxt;
	}
	
	public function getcomm()
	{
		$ting_id = $_GET["id"];
		$result = array("ajaxtxt" => "");
		$total = 0;

		if (!empty($ting_id)) {
			$rs = D("User");
			$where = array("ting_id" => $ting_id, "ispass" => 1);
			$total = $rs->getPublicCommentTotal($where);

			if (0 < $total) {
				$limit = 8;
				$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
				$totalpages = ceil($total / $limit);

				if ($totalpages < $currentpage) {
					$currentpage = $totalpages;
				}

				$pager = array("limit" => $limit, "currentpage" => $currentpage);
				$list = $rs->getPublicComments($where, $pager);
				$result["ajaxtxt"] = $this->outputPublicCommns($list);

				if (1 < $totalpages) {
					$pagebox = "<label>" . $currentpage . "/" . $totalpages . "</label>";
					$pagesx = "";

					if ($currentpage <= 1) {
						$pagebox .= "<span class='prev disabled'>上一页</span>";
						$pagesx .= "<span class=' disabled'>首页</span>";
						$pagesx .= "<span class='prev disabled'>上一页</span>";
					}
					else {
						$pagebox .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $currentpage - 1), true, false) . "' class='prev'>上一页</a>";
						$pagesx .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => 1), true, false) . "' class=' pagegbk'>首页</a>";
						$pagesx .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $currentpage - 1), true, false) . "' class='prev pagegbk'>上一页</a>";
					}

					$halfPer = 4;
					$i = $currentpage - $halfPer;
					(1 < $i) || ($i = 1);
					$j = $currentpage + $halfPer;
					($j < $totalpages) || ($j = $totalpages);

					for (; $i < ($j + 1); $i++) {
						$pagesx .= ($i == $currentpage ? "<span class='current'>" . $i . "</span>&nbsp;" : "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $i), true, false) . "'>" . $i . "</a>&nbsp;");
					}

					if ($totalpages <= $currentpage) {
						$pagebox .= "<span class='next disabled'>下一页</span>";
						$pagesx .= "<span class='next disabled'>下一页</span>";
						$pagesx .= "<span class=' disabled'>尾页</span>";
					}
					else {
						$pagebox .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $currentpage + 1), true, false) . "' class='next'>下一页</a>";
						$pagesx .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $currentpage + 1), true, false) . "' class='next pagegbk'>下一页</a>";
						$pagesx .= "<a href='" . UUU("Home-Comm/getcomm", array("id" => $ting_id, "p" => $totalpages), true, false) . "' class=' pagegbk'>尾页</a>";
					}

					$result["pages"] = $pagebox;
					$result["pagesx"] = $pagesx;
				}
			}

			$data = $rs->getMark($ting_id);
			$start = array();
			$value = $rs->getMarkValue($ting_id, get_client_ip());

			if (0 < $value) {
				$start["hadpingfen"] = 1;
				$start["mystars"] = $value;
			}
			else {
				$start["mystars"] = 0;
			}

			$start["curpingfen"] = array();
			$mod = M("Ting");
			$ting_gold = $mod->where("ting_id='$ting_id'")->getField("ting_gold");
			dump($data);
			exit;
			if ($data != null) {
				$start["curpingfen"]["a"] = $data["F5"];
				$start["curpingfen"]["b"] = $data["F4"];
				$start["curpingfen"]["c"] = $data["F3"];
				$start["curpingfen"]["d"] = $data["F2"];
				$start["curpingfen"]["e"] = $data["F1"];
				$rate = $this->getPingfen($data);

				if (0 < count($rate)) {
					$start["curpingfen"]["pinfenb"] = $rate["R2"];
					$start["curpingfen"]["pinfen"] = $rate["R1"];
				}
				else {
					$start["curpingfen"]["a"] = 0;
					$start["curpingfen"]["b"] = 0;
					$start["curpingfen"]["c"] = 0;
					$start["curpingfen"]["d"] = 0;
					$start["curpingfen"]["e"] = 0;
					$start["curpingfen"]["pinfenb"] = $ting_gold * 10;
					$start["curpingfen"]["pinfen"] = $ting_gold;
				}
			}

			

			$result["star"] = $start;
		}

		exit(json_encode($result));
	}

	public function getPingfen($data)
	{
		$f1 = $data["F1"];
		$f2 = $data["F2"];
		$f3 = $data["F3"];
		$f4 = $data["F4"];
		$f5 = $data["F5"];
		$pftotal = $f1 + $f2 + $f3 + $f4 + $f5;
		$array = array();

		if (0 < $pftotal) {
			$rating = (($f1 / $pftotal) * 1) + (($f2 / $pftotal) * 2) + (($f3 / $pftotal) * 3) + (($f4 / $pftotal) * 4) + (($f5 / $pftotal) * 5);
			$r1 = round($rating * 2, 1);
			$array["R1"] = number_format($r1, 1);
			$array["R2"] = $r1 * 10;
		}

		return $array;
	}

	
	public function digg()
	{
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");
		$comment_id = $_GET["id"];
		$type = $_GET["type"];
		$success = false;
		if (!empty($comment_id) && !empty($type)) {
			$rs = M("Comment_opinion");
			$ip = get_client_ip();
			$count = $rs->where(array("comment_id" => $comment_id, "ip" => $ip))->count();

			if (0 < $count) {
				$result = array("msg" => "已经点评", "rcode" => "-1");
				$success = true;
			}
			else {
				$opinion = -1;
				$key = "";

				if ($type == "sup") {
					$opinion = 1;
					$key = "support";
				}
				else if ($type == "opp") {
					$opinion = 0;
					$key = "oppose";
				}

				if (0 <= $opinion) {
					$data["comment_id"] = $comment_id;
					$data["opinion"] = $opinion;
					$data["creat_date"] = time();
					$data["ip"] = $ip;
					$id = $rs->add($data);

					if (0 < $id) {
						$comment = M("Comment");
						$addValue = $comment->where(array("comment_id" => $comment_id))->getField($key);
						$addValue += 1;
						$comment->save(array($key => $addValue, "comment_id" => $comment_id));
						$result = array("msg" => "成功点评", "rcode" => "1");
						$success = true;
					}
				}
			}
		}

		if (!$success) {
			$result = array("msg" => "点评失败", "rcode" => "-1");
		}

		exit(json_encode($result));
	}

	public function getrecomm()
	{
		$_POST = I("post.", "", "strip_tags,htmlspecialchars");
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");

		if (0 < C("user_check")) {
			$user_check = 0;
		}
		else {
			$user_check = 1;
		}

		$comm_id = $_POST["comm_id"];
		$re_content = remove_xss($_POST["recomm_txt"]);
		$re_content = htmlspecialchars($re_content);

		if ($_POST["reting_id"]) {
			$ting_id = $_POST["reting_id"];
		}
		else {
			$mod = M("Comment");
			$ting_id = $mod->where("comment_id='{$_POST["comm_id"]}'")->getField("ting_id");
		}

		$cookie = "comment_" . intval($_POST["reting_id"]) . "_" . intval($_POST["comm_id"]);
		$member = null;
		$rs = D("User");

		if ($this->isLogin) {
			$member = $rs->getMember(array("userid" => $this->userid));
		}

		$result = null;

		if ($member) {
			if (strlen($re_content) == 0) {
				$result = array("msg" => "内容不能为空或带非法字符,请填写提交内容!", "rcode" => "-1");
			}
			else if (isset($_COOKIE[$cookie])) {
				$result = array("msg" => "您已回复过了，请先休息一会！", "rcode" => "-1");
			}
			else {
				$comment = array();
				$time = time();
				$comment["ting_id"] = $ting_id;
				$comment["userid"] = $member["userid"];
				$comment["creat_at"] = $time;
				$comment["ip"] = get_client_ip();
				$comment["status"] = $user_check;
				$comment["ispass"] = $user_check;
				$comment["reply"] = 1;
				$comment["pid"] = $comm_id;
				$list = $rs->getCommentById($comm_id);

				if ($list["content"]) {
					$content .= $list["content"];
				}

				$html = $re_content . " <a href=\"###" . $list["userid"] . "@@@\" target=\"_blank\">@" . $list["nickname"] . "</a>:" . $content;
				$comment["content"] = $html;
				$comment_id = $rs->saveComment($comment);
				cookie($cookie, "true", time() + intval(C("user_second")));

				if (0 < C("user_check")) {
					if (0 < $comment_id) {
						$result = array("msg" => "回复评论成功,我们会尽快审核你的留言！", "rcode" => "1");
					}
					else {
						$result = array("msg" => "回复评论失败", "rcode" => "-1");
					}
				}
				else {
					$result = array("msg" => "回复评论成功", "rcode" => "1");
				}
			}
		}
		else {
			$result = array("msg" => "请先登录", "rcode" => "-1");
		}

		exit(json_encode($result));
	}

	public function addcomm()
	{
		$_POST = I("post.", "", "strip_tags,htmlspecialchars");
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");

		if (0 < C("user_check")) {
			$user_check = 0;
		}
		else {
			$user_check = 1;
		}

		$member = null;
		$rs = D("User");

		if ($this->isLogin) {
			$member = $rs->getMember(array("userid" => $this->userid));
		}

		$result = null;

		if ($member) {
			$cookie = "comment_" . intval($_POST["comment_id"]) . "_" . intval($_POST["ting_id"]);
			$comm_txt = remove_xss($_POST["comm_txt"]);
			$comm_txt = htmlspecialchars($comm_txt);
			if (empty($comm_txt) || ($comm_txt == "请在这里发表您的个人看法，最多1000个字。")) {
				$result = array("msg" => "内容不能为空或带非法字符,请填写提交内容!", "rcode" => "-1");
			}
			else if (1000 < strlen($comm_txt)) {
				$result = array("msg" => "内容太长", "rcode" => "-1");
			}
			else {

				$ting_id = $_POST["ting_id"];
				$where = array("userid" => $this->userid, "pid" => 0, "ting_id" => $ting_id);
				$comm_txt = str_replace("'", "\'", $comm_txt);
				$array = explode("|", C("user_replace"));
				$comm_txt = trim(str_replace($array, "***", nb(nr($comm_txt))));
				
				if (isset($_COOKIE[$cookie])) {
					$result = array("msg" => "您已评论过，请先休息一会！", "rcode" => "-1");
				}
				else {
					$comment = array();
					$time = time();
					$comment["ting_id"] = $_POST["ting_id"];
					$comment["userid"] = $member["userid"];
					$comment["creat_at"] = $time;
					$comment["ip"] = get_client_ip();
					$comment["status"] = $user_check;
					$comment["content"] = $comm_txt;
					$comment["pid"] = 0;
					$comment["ispass"] = $user_check;
					//print_r($comment);die();
					$comment_id = $rs->saveComment($comment);
					//print_r($comment_id);die();
					cookie($cookie, "true", time() + intval(C("user_second")));

					if (0 < C("user_check")) {
						if (0 < $comment_id) {
							$result = array("msg" => "评论提交成功,我们会尽快审核你的留言！", "rcode" => "1");
						}
						else {
							$result = array("msg" => "评论提交失败", "rcode" => "-1");
						}
					}
					else {
						$result = array("msg" => "评论提交成功", "rcode" => "1");
					}
				}
			}
		}
		else {
			$result = array("msg" => "请先登录", "rcode" => "-1");
		}

		exit(json_encode($result));
	}

	public function mark()
	{
		$_POST = I("post.", "", "strip_tags,htmlspecialchars");
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");
		$ting_id = $_POST["id"];
		$value = $_POST["val"];
		$result = array("msg" => "提交评分失败", "rcode" => "-1");
		if (isset($ting_id) && isset($value)) {
			if (($value == "1") || ($value == "2") || ($value == "3") || ($value == "4") || ($value == "5")) {
				$rs = D("ting_mark");
				$ip = get_client_ip();
				$count = $rs->where(array("ip" => $ip, "ting_id" => $ting_id))->count();

				if (0 < $count) {
					$result["msg"] = "已经评分,请务重复评分";
					$result["rcode"] = -2;
				}
				else {
					$mark = array();
					$mark["ting_id"] = $ting_id;
					$mark["ip"] = $ip;
					$mark["creat_date"] = time();
					$mark["F" . $value] = 1;

					if (0 < $rs->add($mark)) {
						$result["msg"] = "提交评分成功";
						$result["rcode"] = 1;
						$member = D("User");
						$data = $member->getMark($ting_id);
						$rate = $this->getPingfen($data);

						if (0 < count($rate)) {
							$ting = M("Ting");
							$ting->save(array("ting_gold" => $rate["R1"], "ting_id" => $ting_id));
						}
					}
				}
			}
		}

		exit(json_encode($result));
	}

	public function addplaylog()
	{
		$_POST = I("post.", "", "strip_tags,htmlspecialchars");
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");
		$result = array("rcode" => "-1");

		if ($this->isLogin) {
			$ting_id = $_POST["ting_id"];
			$rs = M("Playlog");
			$rs->where(array("ting_id" => $ting_id, "userid" => $this->userid))->delete();
			$data = array();
			$data["ting_id"] = $ting_id;
			$data["ting_sid"] = $_POST["ting_sid"];
			$data["ting_pid"] = $_POST["ting_pid"];
			$data["ting_name"] = $_POST["ting_name"];
			$data["url_name"] = $_POST["url_name"];
			$data["ting_maxnum"] = $_POST["ting_maxnum"];
			$data["userid"] = $this->userid;
			$data["creat_time"] = time();
			$rs->add($data);
		}
	}

	public function getplaylog()
	{
		if ($this->isLogin) {
			$result = array("rcode" => "0");
			$result["r"] = $array;
			$rs = M("Playlog");
			$order = C("db_prefix") . "playlog.creat_time desc ";
			$join = " inner join " . C("db_prefix") . "ting on  " . C("db_prefix") . "playlog.ting_id= " . C("db_prefix") . "ting.ting_id ";
			$where = C("db_prefix") . "playlog.userid = " . $this->userid;
			$field = C("db_prefix") . "playlog.*," . C("db_prefix") . "ting.ting_cid," . C("db_prefix") . "ting.ting_jumpurl," . C("db_prefix") . "ting.ting_letters";
			$list = $rs->field($field)->join($join)->where($where)->order($order)->limit(10)->select();
			$count = count($list);

			if (0 < $count) {
				$array = array();

				foreach ($list as $key => $value ) {
					$data = array();
					$data["id"] = $value["log_id"];
					$data["ting_name"] = $value["ting_name"];
					$data["url_name"] = $value["url_name"];
					$data["ting_readurl"] = ff_data_url("ting", $value["ting_id"], $value["ting_cid"], $value["ting_name"], 1, $value["ting_jumpurl"], $value["ting_letters"]);
					$data["ting_palyurl"] = ff_play_url($value["ting_id"], $value["ting_sid"], $value["ting_pid"], $value["ting_cid"], $value["ting_name"]);
					$array[$key] = $data;
				}

				$result["r"] = $array;
				$result["rcode"] = $count;
			}
		}
		else {
			$result = array("rcode" => "-1");
			$result["r"] = $array;
		}

		exit(json_encode($result));
	}

	public function emptyhistory()
	{
		$result = array("rcode" => "-1");

		if ($this->isLogin) {
			$rs = M("Playlog");
			$rs->where(array("userid" => $this->userid))->delete();
			$result = array("rcode" => "1");
		}

		exit(json_encode($result));
	}

	public function delplaylog()
	{
		$_GET = I("get.", "", "strip_tags,htmlspecialchars");
		$result = array("rcode" => "-1");
		if ($this->isLogin && !empty($_GET["id"])) {
			$rs = M("Playlog");
			$rs->where(array("log_id" => $_GET["id"]))->delete();
			$result = array("rcode" => "1");
		}

		exit(json_encode($result));
	}
}


