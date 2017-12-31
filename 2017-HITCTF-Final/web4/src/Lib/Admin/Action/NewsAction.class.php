<?php
namespace Admin\Action;
use Common\Action\BaseAction;
class NewsAction extends BaseAction
{
	public function show()
	{
		$admin = array();
		$admin["cid"] = $_REQUEST["cid"];
		$admin["status"] = intval($_REQUEST["status"]);
		$admin["stars"] = intval($_REQUEST["stars"]);
		$admin["type"] = (!empty($_GET["type"]) ? $_GET["type"] : C("admin_order_type"));
		$admin["order"] = (!empty($_GET["order"]) ? $_GET["order"] : "desc");
		$admin["orders"] = "news_" . $admin["type"] . " " . $admin["order"];
		$admin["wd"] = urldecode(trim($_REQUEST["wd"]));
		$admin["tag"] = urldecode(trim($_REQUEST["tag"]));
		$admin["tid"] = $_REQUEST["tid"];
		$admin["nid"] = $_REQUEST["nid"];
		$admin["did"] = $_REQUEST["did"];
		$admin["vid"] = $_REQUEST["vid"];
		$admin["p"] = "";
		$limit = C("url_num_admin");
		$order = "news_" . $admin["type"] . " " . $admin["order"];

		if ($admin["cid"]) {
			$where["news_cid"] = getlistsqlin($admin["cid"]);
		}

		if ($admin["status"] == 2) {
			$where["news_status"] = array("neq", 1);
		}
		else if ($admin["status"] == 1) {
			$where["news_status"] = array("eq", 1);
		}

		if ($admin["stars"]) {
			$where["news_stars"] = $admin["stars"];
		}

		if ($admin["wd"]) {
			$where["news_name"] = array("like", "%" . $admin["wd"] . "%");
			$admin["wd"] = urlencode($admin["wd"]);
		}

		if ($admin["tag"]) {
			$where["tag_sid"] = 2;
			$where["tag_name"] = $admin["tag"];
			$rs = D("TagnewsView");
			$admin["tag"] = urlencode($_REQUEST["tag"]);
		}
		else {
			$rs = D("News");
		}

		$count = $rs->where($where)->count("news_id");
		$totalpages = ceil($count / $limit);
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$currentpage = get_maxpage($currentpage, $totalpages);
		$pageurl = U("Admin-News/Show", $admin, false, false) . "-p-{!page!}" . C("url_html_suffix");
		$admin["p"] = $currentpage;
		$_SESSION["news_jumpurl"] = U("Admin-News/Show", $admin) . C("url_html_suffix");
		$pages = "共" . $count . "篇文章&nbsp;当前:" . $currentpage . "/" . $totalpages . "页&nbsp;" . getpage($currentpage, $totalpages, 8, $pageurl, "pagego('" . $pageurl . "'," . $totalpages . ")");
		$admin["pages"] = $pages;
		$list = $rs->where($where)->order($order)->limit($limit)->page($currentpage)->select();

		foreach ($list as $key => $val ) {
			$list[$key]["list_url"] = "?s=Admin-News-Show-cid-" . $list[$key]["news_cid"];
			$list[$key]["news_url"] = gxl_data_url("news", $list[$key]["news_id"], $list[$key]["news_cid"], $list[$key]["news_name"], 1, $list[$key]["news_jumpurl"]);
			$list[$key]["news_starsarr"] = admin_star_arr($list[$key]["news_stars"]);
		}

		$rs = D("Newsrel");
		$list_topic = $rs->select();

		foreach ($list_topic as $key => $value ) {
			$array_topic[$value["newsrel_sid"] . "-" . $value["newsrel_nid"]][$key] = $value["newsrel_nid"];
		}

		$this->assign($admin);
		$this->assign("list", $list);
		$this->assign("array_count", $array_topic);
		$this->assign("list_news", F("_ppting/listnews"));

		if ($admin["tid"]) {
			$this->display("./Public/admin/special_news.html");
		}
		else if ($admin["did"]) {
			$this->display("./Public/admin/star_news.html");
		}
		else if ($admin["vid"]) {
			$this->display("./Public/admin/ting_news.html");
		}
		else {
			$this->display("./Public/admin/news_show.html");
		}
	}

	public function add()
	{
		$rs = D("News");
		$news_id = intval($_GET["id"]);

		if (0 < $news_id) {
			$where["news_id"] = $news_id;
			$array = $rs->where($where)->relation("Tag")->find();
			$array["news_templatename"] = "编辑";

			foreach ($array["Tag"] as $key => $value ) {
				$tag[$key] = $value["tag_name"];
			}

			$array["news_starsarr"] = admin_star_arr($array["news_stars"]);

			if (C("admin_time_edit")) {
				$array["checktime"] = "checked";
			}

			unset($where);
			$rs = D("Newsrel");
			$where["newsrel_nid"] = $array["news_id"];
			$where["newsrel_sid"] = 1;
			$arrayting = $rs->where($where)->select();

			foreach ($arrayting as $key => $value ) {
				$ting[$key] = $value["newsrel_name"] . "#" . $value["newsrel_did"];
			}

			$array["news_ting"] = implode(",", $ting);
			unset($where);
			$where["newsrel_nid"] = $array["news_id"];
			$where["newsrel_sid"] = 2;
			$arraystar = $rs->where($where)->select();

			foreach ($arraystar as $key => $value ) {
				$star[$key] = $value["newsrel_name"] . "#" . $value["newsrel_did"];
			}

			$array["news_star"] = implode(",", $star);
			$array["news_content"] = gxl_news_img_array($array["news_content"]);
			$_SESSION["ting_jumpurl"] = $_SERVER["HTTP_REFERER"];
			unset($where);
			$where["newsrel_nid"] = $array["news_id"];
			$where["newsrel_sid"] = 1;
			$array["countting"] = $rs->where($where)->count();
			$where["newsrel_sid"] = 2;
			$array["countstar"] = $rs->where($where)->count();
		}
		else {
			$array["news_cid"] = cookie("news_cid");
			$array["news_stars"] = 0;
			$array["news_del"] = 0;
			$array["news_hits"] = 0;
			$array["news_inputer"] = $_SESSION["admin_name"];
			$array["news_addtime"] = time();
			$array["news_starsarr"] = admin_star_arr(1);
			$array["checktime"] = "checked";
			$array["news_templatename"] = "添加";
			$array["countting"] = 0;
			$array["countstar"] = 0;
		}

		$this->assign($array);
		$this->assign("list_news", F("_ppting/listnews"));
		$this->display("./Public/admin/news_add.html");
	}

	public function _before_insert()
	{
		if (empty($_POST["news_keywords"]) && C("rand_tag")) {
			$_POST["news_keywords"] = gxl_tag_auto($_POST["news_name"], $_POST["news_content"]);
		}
	}

	public function insert()
	{
		$rs = D("News");
		$newsrel = D("Newsrel");

		if ($rs->create()) {
			$id = $rs->add();

			if (false !== $id) {
				if ($_POST["news_ting"]) {
					$newsrel->newsrel_update($id, $_POST["news_ting"], 1);
				}

				if ($_POST["news_star"]) {
					$newsrel->newsrel_update($id, $_POST["news_star"], 2);
				}

				$this->assign("jumpUrl", "?s=Admin-News-Add");
			}
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function _after_insert()
	{
		cookie("news_cid", intval($_POST["news_cid"]));

		if (C("baidu_tui")) {
			$newsurl = gxl_data_url("news", $id, $_POST["news_cid"], $_POST["news_name"], 1, $_POST["news_jumpurl"]);
			$baidutui = baidutu($newsurl);
		}

		$this->success("文章添加成功" . $baidutui . "继续添加新文章！");
	}

	public function update()
	{
		$this->_before_insert();
		$tag = D("Tag");
		$rs = D("News");
		$newsrel = D("Newsrel");

		if ($rs->create()) {
			if (false !== $rs->save()) {
				if ($_POST["news_keywords"]) {
					$tag->tag_update($_POST["news_id"], $_POST["news_keywords"], 2);
				}

				if ($_POST["news_ting"]) {
					$newsrel->newsrel_update($_POST["news_id"], $_POST["news_ting"], 1);
				}

				if ($_POST["news_star"]) {
					$newsrel->newsrel_update($_POST["news_id"], $_POST["news_star"], 2);
				}

				$rs->$news_id = $_POST["news_id"];
			}
			else {
				$this->error("修改新闻信息失败！");
			}
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function _after_update()
	{
		$rs = D("News");
		$news_id = $rs->$news_id;

		if ($news_id) {
			$this->_after_add_update($news_id);
			$this->assign("jumpUrl", $_SESSION["news_jumpurl"]);
			if (C("baidu_tui") && ($_POST["insertseo"] == 5)) {
				$newsurl = gxl_data_url("news", $news_id, $_POST["news_cid"], $_POST["news_name"], 1, $_POST["news_jumpurl"]);
				$baidutui = baidutu($newsurl);
			}

			$this->success("修改新闻信息成功" . $baidutui . "！");
		}
		else {
			$this->error("修改新闻信息失败！");
		}
	}

	public function _after_add_update($news_id)
	{
		if (C("data_cache_news")) {
			S("data_cache_news_" . $news_id, NULL);
		}

		if (C("html_cache_on")) {
			@unlink(HTML_PATH . "index" . C("html_file_suffix"));
			$list_url = md5(getlistname($_POST["news_cid"], "list_url"));
			$big_url = md5(getlistname($_POST["news_cid"], "list_url_big"));
			$news_url = md5(gxl_data_url("news", $news_id, $_POST["news_cid"], $_POST["news_name"], 1, $_POST["news_jumpurl"]));
			@unlink(HTML_PATH . "/Ting_show/" . $list_url . C("html_file_suffix"));
			@unlink(HTML_PATH . "/Ting_show/" . $big_url . C("html_file_suffix"));
			@unlink(HTML_PATH . "/News_read/" . $news_url . C("html_file_suffix"));
		}

		if (C("url_html")) {
			echo "<iframe scrolling=\"no\" src=\"?s=Admin-Create-newsid-id-" . $news_id . "\" frameborder=\"0\" style=\"display:none\"></iframe>";
		}
	}

	public function ajax()
	{
		$data = array();
		$where = array();
		$did = intval($_GET["did"]);
		$nid = intval($_GET["nid"]);
		$sid = (!empty($_GET["sid"]) ? $_GET["sid"] : 1);
		$type = trim($_GET["type"]);
		$lastdid = intval($_GET["lastdid"]);

		if ($sid == 1) {
			$name = get_id_ting_name($did);
		}

		if ($sid == 2) {
			$name = get_name_star_id($did);
		}

		if ($did && $nid) {
			$rs = D("Newsrel");

			if ($type == "add") {
				$rsid = $rs->where("newsrel_sid = " . $sid . " and newsrel_did = " . $did . " and newsrel_nid = " . $nid)->getField("newsrel_did");

				if (!$rsid) {
					$count = $rs->where("newsrel_sid = " . $sid . " and newsrel_nid = " . $nid)->max("newsrel_oid");
					$data["newsrel_did"] = $did;
					$data["newsrel_nid"] = $nid;
					$data["newsrel_name"] = $name;
					$data["newsrel_sid"] = $sid;
					$data["newsrel_oid"] = $count + 1;
					$rs->data($data)->add();
				}
			}
			else if ($type == "del") {
				$where["newsrel_did"] = $did;
				$where["newsrel_nid"] = $nid;
				$where["newsrel_sid"] = $sid;
				$rs->where($where)->delete();
			}
			else if ($type == "up") {
				$where["newsrel_did"] = $did;
				$where["newsrel_nid"] = $nid;
				$where["newsrel_sid"] = $sid;
				$rs->where($where)->setInc("newsrel_oid");
				$where["newsrel_did"] = $lastdid;
				$rs->where($where)->setDec("newsrel_oid");
			}
			else if ($type == "down") {
				$where["newsrel_did"] = $did;
				$where["newsrel_nid"] = $nid;
				$where["newsrel_sid"] = $sid;
				$rs->where($where)->setDec("newsrel_oid");
				$where["newsrel_did"] = $lastdid;
				$rs->where($where)->setInc("newsrel_oid");
			}
		}

		if ($nid && ($sid == 1)) {
			$this->showting($did, $nid);
		}
		else {
			if ($nid && ($sid == 2)) {
				$this->showstar($did, $nid);
			}
			else {
				echo "请先添加新闻！";
			}
		}
	}

	public function showting($did, $nid)
	{
		$where = array();
		$where["newsrel_sid"] = 1;
		$where["newsrel_nid"] = $nid;
		$rs = D("Newsrel");
		$maxoid = $rs->where($where)->max("newsrel_oid");
		$minoid = $rs->where($where)->min("newsrel_oid");
		$rs = D("NewstingView");
		$list = $rs->field("ting_id,ting_name,ting_actor,newsrel_oid")->where($where)->order("newsrel_oid desc,newsrel_did desc")->select();

		if (!$list) {
			echo "该新闻暂未收录任何作品数据！";
		}
		else {
			$this->assign("max_oid", $maxoid);
			$this->assign("min_oid", $minoid);
			$this->assign("list_ting", $list);
			$this->assign("count", count($list));
			$this->display("./Public/admin/news_ting_ids.html");
		}
	}

	public function showstar($did, $nid)
	{
		$where = array();
		$where["newsrel_sid"] = 2;
		$where["newsrel_nid"] = $nid;
		$rs = D("Newsrel");
		$maxoid = $rs->where($where)->max("newsrel_oid");
		$minoid = $rs->where($where)->min("newsrel_oid");
		$rs = D("NewsstarView");
		$list = $rs->field("star_id,star_name,star_pyname,newsrel_oid")->where($where)->order("newsrel_oid desc,newsrel_did desc")->select();

		if (!$list) {
			echo "该新闻暂未收录任何明星数据！";
		}
		else {
			$this->assign("max_oid", $maxoid);
			$this->assign("min_oid", $minoid);
			$this->assign("list_star", $list);
			$this->assign("count", count($list));
			$this->display("./Public/admin/news_star_ids.html");
		}
	}

	public function ajaxstars()
	{
		$where["news_id"] = $_GET["id"];
		$data["news_stars"] = intval($_GET["stars"]);
		$rs = D("News");
		$rs->where($where)->save($data);
		exit("ok");
	}

	public function status()
	{
		$where["news_id"] = $_GET["id"];
		$rs = D("News");

		if ($_GET["value"]) {
			$rs->where($where)->setField("news_status", 1);
		}
		else {
			$rs->where($where)->setField("news_status", 0);
		}

		redirect($_SESSION["news_jumpurl"]);
	}

	public function del()
	{
		$this->delfile($_GET["id"]);
		redirect($_SESSION["news_jumpurl"]);
	}

	public function delall()
	{
		if (empty($_POST["ids"])) {
			$this->error("请选择需要删除的文章！");
		}

		$array = $_POST["ids"];

		foreach ($array as $val ) {
			$this->delfile($val);
		}

		redirect($_SESSION["news_jumpurl"]);
	}

	public function delfile($id)
	{
		$rs = D("Topic");
		$where["topic_sid"] = 1;
		$where["topic_did"] = $id;
		$rs->where($where)->delete();
		unset($where);
		unset($where);
		$rs = D("Cm");
		$where["cm_cid"] = $id;
		$where["cm_sid"] = 2;
		$rs->where($where)->delete();
		$rs = D("Tag");
		$where["tag_id"] = $id;
		$where["tag_sid"] = 2;
		$rs->where($where)->delete();
		unset($where);
		$rs = D("Newsrel");
		$where["newsrel_nid"] = $id;
		$rs->where($where)->delete();
		unset($where);
		$rs = D("News");
		$where["news_id"] = $id;
		$array = $rs->field("news_id,news_cid,news_pic,news_name")->where($where)->find();
		@unlink(gxl_img_url($arr["news_pic"]));

		if (0 < C("url_html")) {
			@unlink(gxl_data_url("news", $array["news_id"], $array["news_cid"], $array["news_name"], 1));
		}

		unset($where);
		$where["news_id"] = $id;
		$rs = D("News");
		$rs->where($where)->delete();
		unset($where);
	}

	public function pestcid()
	{
		if (empty($_POST["ids"])) {
			$this->error("请选择需要转移的新闻！");
		}

		$cid = intval($_POST["pestcid"]);

		if (getlistson($cid)) {
			$rs = D("News");
			$data["news_cid"] = $cid;
			$where["news_id"] = array("in", $_POST["ids"]);
			$rs->where($where)->save($data);
			redirect($_SESSION["news_jumpurl"]);
		}
		else {
			$this->error("请选择当前大类下面的子分类！");
		}
	}

	public function create()
	{
		echo "<iframe scrolling=\"no\" src=\"?s=Admin-Create-newsid-id-" . implode(",", $_POST["ids"]) . "\" frameborder=\"0\" style=\"display:none\"></iframe>";
		$this->assign("jumpUrl", $_SESSION["news_jumpurl"]);
		$this->success("批量生成新闻成功！");
	}
}


