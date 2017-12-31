<?php

namespace Admin\Action;
use Common\Action\BaseAction;
class TingAction extends BaseAction
{
	public function show()
	{
		$admin = array();
		$admin["cid"] = $_REQUEST["cid"];
		$admin["continu"] = $_REQUEST["continu"];
		$admin["status"] = intval($_REQUEST["status"]);
		$admin["isfilm"] = intval($_REQUEST["isfilm"]);
		$admin["player"] = trim($_REQUEST["player"]);
		$admin["stars"] = intval($_REQUEST["stars"]);
		$admin["url"] = intval($_REQUEST["url"]);
		$admin["type"] = (!empty($_GET["type"]) ? $_GET["type"] : C("admin_order_type"));
		$admin["order"] = (!empty($_GET["order"]) ? $_GET["order"] : "desc");
		$admin["orders"] = "ting_" . $admin["type"] . " " . $admin["order"];
		$admin["wd"] = urldecode(trim($_REQUEST["wd"]));
		$admin["tag"] = urldecode(trim($_REQUEST["tag"]));
		$admin["tid"] = $_REQUEST["tid"];
		$admin["nid"] = $_REQUEST["nid"];
		$admin["p"] = "";
		$limit = C("url_num_admin");
		$order = "ting_" . $admin["type"] . " " . $admin["order"];

		if ($admin["cid"]) {
			$where["ting_cid"] = getlistsqlin($admin["cid"]);
		}

		if ($admin["continu"] == 1) {
			$where["ting_continu"] = array("neq", "0");
		}

		if ($admin["status"] == 2) {
			$where["ting_status"] = array("eq", 0);
		}
		else if ($admin["status"] == 1) {
			$where["ting_status"] = array("eq", 1);
		}
		else if ($admin["status"] == 3) {
			$where["ting_status"] = array("eq", -1);
		}

		if ($admin["isfilm"]) {
			$where["ting_isfilm"] = array("eq", $admin["isfilm"]);
		}

		if ($admin["player"]) {
			$where["ting_play"] = array("like", "%" . trim($admin["player"]) . "%");
		}

		if ($admin["stars"]) {
			$where["ting_stars"] = $admin["stars"];
		}

		if ($admin["url"]) {
			$where["ting_url"] = array("eq", "");
		}

		if ($admin["wd"]) {
			$search["ting_name"] = array("like", "%" . $admin["wd"] . "%");
			$search["ting_title"] = array("like", "%" . $admin["wd"] . "%");
			$search["ting_actor"] = array("like", "%" . $admin["wd"] . "%");
			$search["ting_director"] = array("like", "%" . $admin["wd"] . "%");
			$search["_logic"] = "or";
			$where["_complex"] = $search;
			$admin["wd"] = urlencode($admin["wd"]);
		}

		if ($admin["tag"]) {
			$where["tag_sid"] = 1;
			$where["tag_name"] = $admin["tag"];
			$rs = D("TagView");
			$admin["tag"] = urlencode($_REQUEST["tag"]);
		}
		else {
			$rs = D("Ting");
		}

		$count = $rs->where($where)->count("ting_id");
		$totalpages = ceil($count / $limit);
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$currentpage = get_maxpage($currentpage, $totalpages);
		$pageurl = U("Admin-Ting/Show", $admin, false, false) . "-p-{!page!}" . C("url_html_suffix");
		$admin["p"] = $currentpage;
		$_SESSION["ting_jumpurl"] = U("Admin-Ting/Show", $admin) . C("url_html_suffix");
		$pages = "共" . $count . "部作品&nbsp;当前:" . $currentpage . "/" . $totalpages . "页&nbsp;" . getpage($currentpage, $totalpages, 8, $pageurl, "pagego('" . $pageurl . "'," . $totalpages . ")");
		$admin["pages"] = $pages;
		$list = $rs->field($field)->where($where)->order($order)->limit($limit)->page($currentpage)->select();

		foreach ($list as $key => $val ) {
			$list[$key]["list_url"] = "?s=Admin-Ting-Show-cid-" . $list[$key]["ting_cid"];
			$list[$key]["ting_url"] = gxl_data_url("ting", $list[$key]["ting_id"], $list[$key]["ting_cid"], $list[$key]["ting_name"], 1, $list[$key]["ting_jumpurl"], $list[$key]["ting_letters"]);
			$list[$key]["ting_starsarr"] = admin_star_arr($list[$key]["ting_stars"]);
			
		}

		$rs = D("Newsrel");
		$list_topic = $rs->select();

		foreach ($list_topic as $key => $value ) {
			$array_topic[$value["newsrel_sid"] . "-" . $value["newsrel_did"]][$key] = $value["newsrel_did"];
		}

		$this->assign("array_count", $array_topic);
		$this->ppting_play();
		$this->assign($admin);
		$this->assign("list", $list);
		$this->assign("list_ting", F("_ppting/listting"));

		if ($admin["tid"]) {
			$this->display("./Public/admin/special_ting.html");
		}
		else if ($admin["nid"]) {
			$this->display("./Public/admin/news_ting.html");
		}
		else {
			$this->display("./Public/admin/ting_show.html");
		}
	}

	public function add()
	{
		$rs = D("Ting");
		$ting_id = intval($_GET["id"]);

		if ($ting_id) {
			$where = array();
			$where["ting_id"] = $ting_id;
			$array = $rs->where($where)->relation(array("Tag"))->find();
			foreach ($array["Tag"] as $key => $value ) {
				$tag[$key] = $value["tag_name"];
			}

			foreach (explode("$\$\$", $array["ting_play"]) as $key => $val ) {
				$play[array_search($val, C("play_player"))] = $val;
			}

			$array["ting_reurl"] = implode(",", $url);
			$array["ting_play_list"] = C("play_player");
			$array["ting_server_list"] = C("play_server");
			$array["ting_play"] = explode("$$$", $array["ting_play"]);
			$array["ting_server"] = explode("$$$", $array["ting_server"]);
			$array["ting_url"] = explode("$$$", $array["ting_url"]);
			$array["ting_count"] = substr_count($array["ting_url"]["0"],"$");
			$array["ting_keywords"] = implode(",", $tag);
			$array["ting_content"] = gxl_news_img_array($array["ting_content"]);
			if (C("admin_time_edit")) {
				$array["checktime"] = "checked";
			}

			$array["ting_templatename"] = "编辑";
			$array["countting"] = $rs->where($where)->count();
			$_SESSION["ting_jumpurl"] = $_SERVER["HTTP_REFERER"];
		}
		else {
			$array["ting_cid"] = cookie("ting_cid");
			$array["ting_stars"] = 1;
			$array["ting_status"] = 1;
			$array["ting_hits"] = 0;
			$array["ting_addtime"] = time();
			$array["ting_continu"] = 0;
			$array["ting_inputer"] = $_SESSION["admin_name"];
			$array["ting_play_list"] = C("play_player");
			$array["ting_server_list"] = C("play_server");
			$array["ting_url"] = array("");
			$array["ting_starsarr"] = admin_star_arr(1);
			$array["checktime"] = "checked";
			$array["ting_templatename"] = "添加";
		}

		$array["ting_language_list"] = explode(",", C("play_language"));
		$array["ting_area_list"] = explode(",", C("play_area"));
		$array["ting_year_list"] = explode(",", C("play_year"));

		if ($array["ting_cid"]) {
			$array["ting_cat_list"] = D("Mcat")->list_cat($array["ting_cid"]);
		}

		$this->ppting_play();
		$this->assign($array);
		$this->assign("jumpUrl", $_SESSION["ting_jumpurl"]);
		$this->assign("listting", F("_ppting/listting"));
		$this->display("./Public/admin/ting_add.html");
	}

	public function _before_insert()
	{
		if (empty($_POST["ting_keywords"]) && C("rand_tag")) {
			$_POST["ting_keywords"] = gxl_tag_auto($_POST["ting_name"], $_POST["ting_content"]);
		}

		$play = $_POST["ting_play"];
		$server = $_POST["ting_server"];

		foreach ($_POST["ting_url"] as $key => $val ) {
			$val = trim($val);

			if ($val) {
				$ting_play[] = $play[$key];
				$ting_server[] = $server[$key];
				$ting_url[] = $val;
			}
		}
		$char = implode("\r\n", $_POST["ting_gxl"]);
		$_POST["ting_play"] = strval(implode("$\$\$", $ting_play));
		$_POST["ting_server"] = strval(implode("$\$\$", $ting_server));
		$_POST["ting_url"] = strval(implode("$\$\$", $ting_url)).$char;
		$_POST["ting_prty"] = (empty($_POST["ting_prty"]) ? 0 : implode(",", $_POST["ting_prty"]));
		
	}

	public function insert()
	{
		C("TOKEN_ON", false);
		$rs = D("Ting");
		
		$tag = D("Tag");
		$_POST["ting_letters"] = tingletters($_POST["ting_name"]);

		if ($rs->create()) {
			if ($_POST["ting_keywords"]) {
				$rs->Tag = $tag->tag_array($_POST["ting_keywords"], 1);
				$id = $rs->relation("Tag")->add();
			}
			else {
				$id = $rs->add();
			}

			$rs->$ting_id = $id;
			$_POST["ting_id"] = $id;
			

	

			if ($_POST["ting_reurl"]) {
				$urls_array = str_replace(array("|", " ", "，", "、"), ",", $_POST["ting_reurl"]);
				$urls->urls_update($id, $urls_array);
			}
			
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function _after_insert()
	{
		$rs = D("Ting");
		$ting_id = $rs->$ting_id;

		if ($ting_id) {
			cookie("ting_cid", $ting_id);
			$this->_after_add_update($ting_id);
			$this->assign("jumpUrl", "?s=Admin-Ting-Add");

			if (C("baidu_tui")) {
				$tingurl = gxl_data_url("ting", $ting_id, $_POST["ting_cid"], $_POST["ting_name"], 1, $_POST["ting_jumpurl"], $_POST["ting_letters"]);


				$baidutui = baidutu($tingurl);
			}

			$this->success("作品添加成功," . $baidutui . ",继续添加新作品！");
		}
		else {
			$this->error("作品添加失败。");
		}
	}

	public function update()
	{
		C("TOKEN_ON", false);
		$this->_before_insert();
		$rs = D("Ting");
		$tag = D("Tag");
		

		if ($rs->create()) {
			if (false !== $rs->save()) {
		

				if ($_POST["ting_director"]) {
					$directors_array = str_replace(array("/", "|", " ", "，", "、"), ",", $_POST["ting_director"]);
					$actors->actors_update($_POST["ting_id"], $directors_array, 2);
				}
				
				if ($_POST["ting_keywords"]) {
					$tag->tag_update($_POST["ting_id"], $_POST["ting_keywords"], 1);
				}
				if($_POST["ting_gxl"]){
					
					$_POST["ting_url"]=$_POST["ting_url"].$char;
					
				}
				
				$rs->$ting_id = $_POST["ting_id"];
				
			}
			else {
				$this->error("修改作品信息失败！");
			}
		}
		else {
			$this->error($rs->getError());
		}
	}

	public function _after_update()
	{
		$rs = D("Ting");
		$ting_id = $rs->$ting_id;

		if ($ting_id) {
			$this->_after_add_update($ting_id);
			send_remindset($ting_id);
			if (C("baidu_tui") && ($_POST["insertseo"] == 5)) {
				$tingurl = gxl_data_url("ting", $ting_id, $_POST["ting_cid"], $_POST["ting_name"], 1, $_POST["ting_jumpurl"], $_POST["ting_letters"]);

				if (!empty($_POST["story_juqing"])) {
					$storyurl = gxl_story_url("read", $_POST["ting_cid"], $ting_id, $_POST["ting_letters"], 1);
					$seourl = array(rtrim(C("site_url"), "/") . $tingurl, rtrim(C("site_url"), "/") . $storyurl);
				}
				else {
					$seourl = $tingurl;
				}

				$baidutui = baidutu($seourl);
			}

			$this->assign("jumpUrl", $_SESSION["ting_jumpurl"]);
			$this->success("作品更新成功," . $baidutui . "！");
		}
		else {
			$this->error("作品更新失败。");
		}
	}

	public function _after_add_update($ting_id)
	{
		if (C("data_cache_ting")) {
			S("data_cache_ting_" . $ting_id, NULL);
		}

		if (C("html_cache_on")) {
			@unlink(HTML_PATH . "index" . C("html_file_suffix"));
			$id = md5($ting_id) . C("html_file_suffix");
			@unlink(HTML_PATH . "/Ting_read/" . get_small_id($ting_id) . "/" . $id);
			delmulu(HTML_PATH . "/Story_read/" . get_small_id($ting_id) . "/" . $ting_id . "/");
			$list_url = md5(getlistname($_POST["ting_cid"], "list_url"));
			$big_url = md5(getlistname($_POST["ting_cid"], "list_url_big"));
			@unlink(HTML_PATH . "/Ting_show/" . $list_url . C("html_file_suffix"));
			@unlink(HTML_PATH . "/Ting_show/" . $big_url . C("html_file_suffix"));
			$new = md5("/new.html") . C("html_file_suffix");
			@unlink(HTML_PATH . "/Ting_play/" . $id);
			@unlink(HTML_PATH . "/My_show/" . $new);
		}

		if (C("url_html")) {
			echo "<iframe scrolling=\"no\" src=\"?s=Admin-Create-tingid-id-" . $ting_id . "\" frameborder=\"0\" style=\"display:none\"></iframe>";
		}
	}

	public function del()
	{
		$this->delfile($_GET["id"]);
		redirect($_SESSION["ting_jumpurl"]);
	}

	public function delall()
	{
		if (empty($_POST["ids"])) {
			$this->error("请选择需要删除的作品！");
		}

		$array = $_POST["ids"];

		foreach ($array as $val ) {
			$this->delfile($val);
		}

		redirect($_SESSION["ting_jumpurl"]);
	}

	public function delfile($id)
	{
		
		unset($where);
		$rs = D("Topic");
		$where["topic_sid"] = 1;
		$where["topic_did"] = $id;
		$rs->where($where)->delete();
		unset($where);
		$rs = D("Cm");
		$where["cm_cid"] = $id;
		$where["cm_sid"] = 1;
		$rs->where($where)->delete();
		unset($where);
		$rs = D("Tag");
		$where["tag_id"] = $id;
		$where["tag_sid"] = 1;
		$rs->where($where)->delete();
		unset($where);
		$rs = D("Ting");
		$where["ting_id"] = $id;
		$array = $rs->field("ting_id,ting_cid,ting_pic,ting_name")->where($where)->find();
		@unlink(C("upload_path") . "/" . $array["ting_pic"]);

		if (0 < C("url_html")) {
			@unlink(gxl_data_url_dir("ting", $array["ting_id"], $array["ting_cid"], $array["ting_name"], 1) . C("html_file_suffix"));
			@unlink(gxl_play_url_dir($array["ting_id"], 0, 1, $array["ting_cid"], $array["ting_name"]) . C("html_file_suffix"));
			@unlink(gxl_play_url_dir($array["ting_id"], 0, 1, $array["ting_cid"], $array["ting_name"]) . "js");
		}

		unset($where);
		$where["ting_id"] = $id;
		$rs->where($where)->delete();
		unset($where);
	}

	public function create()
	{
		echo "<iframe scrolling=\"no\" src=\"?s=Admin-Create-tingid-id-" . implode(",", $_POST["ids"]) . "\" frameborder=\"0\" style=\"display:none\"></iframe>";
		$this->assign("jumpUrl", $_SESSION["ting_jumpurl"]);
		$this->success("批量生成数据成功！");
	}

	public function pestcid()
	{
		if (empty($_POST["ids"])) {
			$this->error("请选择需要转移的作品！");
		}

		$cid = intval($_POST["pestcid"]);

		if (getlistson($cid)) {
			$rs = D("Ting");
			$data["ting_cid"] = $cid;
			$where["ting_id"] = array("in", $_POST["ids"]);
			$rs->where($where)->save($data);
			redirect($_SESSION["ting_jumpurl"]);
		}
		else {
			$this->error("请选择当前大类下面的子分类！");
		}
	}

	public function ajax()
	{
		$data = array();
		$where = array();
		$did = intval($_GET["vid"]);
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
					$count = $rs->where("newsrel_sid = " . $sid . " and newsrel_did = " . $did)->max("newsrel_oid");
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
				$where["newsrel_nid"] = $lastdid;
				$rs->where($where)->setDec("newsrel_oid");
			}
			else if ($type == "down") {
				$where["newsrel_did"] = $did;
				$where["newsrel_nid"] = $nid;
				$where["newsrel_sid"] = $sid;
				$rs->where($where)->setDec("newsrel_oid");
				$where["newsrel_nid"] = $lastdid;
				$rs->where($where)->setInc("newsrel_oid");
			}
		}

		if ($did && ($sid == 1)) {
			$this->shownews($did, $nid);
		}
		else {
			if ($did && ($sid == 2)) {
				$this->showting($did, $nid);
			}
			else {
				echo "请先添加作品！";
			}
		}
	}

	public function shownews($did, $nid)
	{
		$where = array();
		$where["newsrel_sid"] = 1;
		$where["newsrel_did"] = $did;
		$rs = D("Newsrel");
		$maxoid = $rs->where($where)->max("newsrel_oid");
		$minoid = $rs->where($where)->min("newsrel_oid");
		$rs = D("StarnewsView");
		$list = $rs->field("news_id,news_name,newsrel_oid")->where($where)->order("newsrel_oid desc")->select();

		if (!$list) {
			echo "该作品暂未收录任何资讯！";
		}
		else {
			$this->assign("max_oid", $maxoid);
			$this->assign("min_oid", $minoid);
			$this->assign("list_news", $list);
			$this->assign("count", count($list));
			$this->display("./Public/admin/ting_news_ids.html");
		}
	}

	
	public function status()
	{
		$where["ting_id"] = $_GET["id"];
		$rs = D("Ting");

		if ($_GET["value"]) {
			$rs->where($where)->setField("ting_status", 1);
		}
		else {
			$rs->where($where)->setField("ting_status", 0);
		}

		redirect($_SESSION["ting_jumpurl"]);
	}

	public function ajaxstars()
	{
		$where["ting_id"] = $_GET["id"];
		$data["ting_stars"] = intval($_GET["stars"]);
		$rs = D("Ting");
		$rs->where($where)->save($data);
		echo "ok";
	}

	public function ajaxcontinu()
	{
		$where["ting_id"] = $_GET["id"];
		$data["ting_continu"] = trim($_GET["continu"]);
		$rs = D("Ting");
		$rs->where($where)->save($data);
		echo "ok";
	}




	
}


