<?php

namespace Home\Action;
use Common\Action\HomeAction;
class TingAction extends HomeAction
{
	public function search()
	{
		$type = I("get.type", "ting", "strip_tags,htmlspecialchars");
		$Url = gxl_param_url();
		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-ting/search", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$search = $this->Lable_Search($Url, "ting");
		if (($type == "news")) {
			$field = "";
		}
		else {
			$field = "ting_id,ting_cid,ting_name,ting_pic,ting_author,ting_gold,ting_title,ting_total,ting_anchor,ting_addtime,ting_content";
		}


		$this->assign($search);

		if (IS_AJAX) {
			$cid = I("get.cid", "0", "strip_tags,htmlspecialchars");
			$order = I("get.order", "", "strip_tags,htmlspecialchars");

			if ($order) {
				$s_order = $type . "_addtime desc";
			}
			else {
				$s_order = $type . "_addtime desc";
			}

			$condition = "wd:" . $search["search_wd"] . ";limit:5;filed:" . $field . ";page:true;order:" . $s_order . ";";

			if (0 < $cid) {
				$condition .= ";cid:" . $cid;
			}

			if ($type == "news") {
				$ting_list = gxl_sql_news($condition);
			}
			else {
				$ting_list = gxl_sql_ting($condition);
				
			}

			$page = $ting_list[0]["page"];
			$pagecount = $ting_list[0]["pagecount"];
			$pagetop = $ting_list[0]["pagetop"];
			$this->assign("page", $page);
			$this->assign("pagecount", $pagecount);
			$this->assign("pagetop", $pagetop);
			$this->assign("ting_list", $ting_list);

			 if ($type == "news") {
				$ajaxData["data"] = array("ajaxtxt" => $this->fetch("gxl_ajax_search_news"), "short_page" => $this->fetch("gxl_ajax_page_top"), "long_page" => $this->fetch("gxl_ajax_page_bottom"), "count" => $pagecount);
			}
			else {
				$ajaxData["data"] = array("ajaxtxt" => $this->fetch("gxl_ajax_search"), "short_page" => $this->fetch("gxl_ajax_page_top"), "long_page" => $this->fetch("gxl_ajax_page_bottom"), "count" => $pagecount);
			}

			$ajaxData["info"] = "ok";
			$ajaxData["status"] = 1;
			$this->ajaxReturn($ajaxData);
		}
		else {
			$this->display($search["search_skin"]);
		}
	}

	public function show()
	{
		$dir = I("get.dir", "none", "strip_tags,htmlspecialchars");
		$Url = gxl_param_url();

		if ($dir != "none") {
			$Url["id"] = get_id_by_dir($dir);
			$Url["dir"] = getlistdir($Url["id"]);
		}

		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-ting/show", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$List = list_search(F("_ppting/list"), "list_id=" . $Url["id"]);

		if ($List) {
			$channel = $this->Lable_Ting_List($Url, $List[0]);
			$this->assign($channel);

			if ($Url["letter"]) {
				$channel["list_skin"] = "gxl_letter";
			}

			$this->display($channel["list_skin"]);
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->error("没有找到该分类");
			exit();
		}
	}

	public function type()
	{
		$dir = I("get.dir", "none", "strip_tags,htmlspecialchars");
		$Url = gxl_param_url();

		if ($dir != "none") {
			$Url["id"] = get_id_by_dir($dir);
			$Url["dir"] = getlistdir($Url["id"]);
		}

		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-ting/type", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$List = list_search(F("_ppting/list"), "list_id=" . $Url["id"]);

		if ($List) {
			$channel = $this->Lable_Ting_Type($Url, $List[0]);
			$this->assign($channel);
			$this->display($channel["list_skin_type"]);
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->display("my_404");
			exit();
		}
	}

	public function read()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($id);

		if ($array_detail){
		
			$this->assign($array_detail["show"]);
			$this->assign($array_detail["read"]);
			$this->display($array_detail["read"]["ting_skin_detail"]);
			
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->error("没有该作品");
			exit();
		}
	}

	public function news()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$p = intval(I("get.p", "", "strip_tags,htmlspecialchars"));
		$Url = gxl_param_url();

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$Url["id"] = $id;
		$Url["pinyin"] = gettingpinyin($id);
		$JumpUrl = gxl_param_jump($Url);
		$JumpUrl["p"] = "{!page!}";
		C("jumpurl", UU("Home-ting/news", $JumpUrl, true, false));
		C("currentpage", $Url["page"]);
		$array_detail = $this->get_cache_detail($id);

		if ($array_detail) {
			$this->assign($array_detail["show"]);
			$this->assign($array_detail["read"]);
			$this->assign($array_detail["story"]);
			$this->assign($array_detail["actor"]);
			$this->assign("thisurl", str_replace("{!page!}", $p, gxl_ting_news_url("show", $array_detail["read"]["ting_cid"], $array_detail["read"]["ting_id"], $array_detail["read"]["ting_letters"], $p)));
			$this->display("gxl_tingnews");
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->error("没有该作品");
			exit();
		}
	}



	public function play()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$sid = intval(I("get.sid", "", "strip_tags,htmlspecialchars"));
		$pid = intval(I("get.pid", "", "strip_tags,htmlspecialchars"));

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($id);
		if ($array_detail) {
			$array_detail["read"] = $this->Lable_Ting_Play($array_detail["read"], array("id" => $id, "sid" => $sid, "pid" => $pid));
			$son=$array_detail["read"]["ting_playlist"]["01-0"]["son"];
			
				$this->assign("playson",$son);
			$this->assign($array_detail["read"]);
			$this->display($array_detail["read"]["ting_skin_play"]);
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->error("播放地址错误");
			exit();
		}
	}
	public function playlist()
	{
		$name = I("get.name", "none", "strip_tags,htmlspecialchars");
		$id = intval(I("get.id", "", "strip_tags,htmlspecialchars"));
		$sid = intval(I("get.sid", "", "strip_tags,htmlspecialchars"));
		$pid = intval(I("get.pid", "", "strip_tags,htmlspecialchars"));

		if ($name != "none") {
			$id = get_id_by_name($name);
		}

		$array_detail = $this->get_cache_detail($id);
		if ($array_detail) {
			$array_detail["read"] = $this->Lable_Ting_Play($array_detail["read"], array("id" => $id, "sid" => $sid, "pid" => $pid));
			$this->assign($array_detail["read"]);
			$this->display("gxl_playlist");
		}
		else {
			header("HTTP/1.0 404 Not Found");
			header("status: 404 not found");
			$this->error("播放地址错误");
			exit();
		}
	}
	
	private function get_cache_detail($ting_id)
	{
		if (!$ting_id) {
			return false;
		}

		if (C("data_cache_ting")) {
			$array_detail = S("data_cache_ting_" . $ting_id);

			if ($array_detail) {
				return $array_detail;
			}
		}

		$where = array();
		$where["ting_id"] = $ting_id;
		$where["ting_cid"] = array("gt", 0);
		$where["ting_status"] = array("eq", 1);
		$rs = D("Ting");
		$array = $rs->where($where)->relation(array("Tag"))->find();

		if ($array) {
			$array_detail = $this->Lable_Ting_Read($array);

			if (C("data_cache_ting")) {
				S("data_cache_ting_" . $ting_id, $array_detail, intval(C("data_cache_ting")));
			}

			return $array_detail;
		}

		return false;
	}
}


