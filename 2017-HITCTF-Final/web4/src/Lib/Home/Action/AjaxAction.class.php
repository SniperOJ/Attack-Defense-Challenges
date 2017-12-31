<?php
namespace Home\Action;
use Common\Action\HomeAction;
class AjaxAction extends HomeAction
{
	public function index()
	{
		$id = intval($_GET["id"]);
		$mcid = intval($_GET["mcid"]);
		$letter = trim($_GET["letter"]);
		$area = trim($_GET["area"]);
		$language = trim($_GET["language"]);
		$year = trim($_GET["year"]);
		$lz = trim($_GET["lz"]);
		$wd = trim($_GET["wd"]);
		$h = (0 < intval($_GET["h"]) ? intval($_GET["h"]) : 0);
		$play = trim($_GET["play"]);
		$p = (0 < intval($_GET["p"]) ? intval($_GET["p"]) : 1);
		$order = gxl_order_by($_GET["order"]);
		$order = (!empty($order) ? $order : "ting_addtime");
		$timestamp = time() - ($h * 60 * 60);
		$where = array();

		if ($id) {
			$cids = explode(",", trim($id));

			if (1 < count($cids)) {
				$where["ting_cid"] = array("in", getlistarr_tag($cids));
			}
			else {
				$where["ting_cid"] = getlistsqlin($id);
			}
		}

		if (0 < $tingids) {
			$where["ting_id"] = array("eq", $tingids);
		}

		if (0 < $mcid) {
			$where["FIND_IN_SET($mcid,ting_mcid)"] = array("gt", "0");
		}

		if ($letter != "") {
			$where["ting_letter"] = array("eq", $letter);
		}

		if ($area != "") {
			$where["ting_area"] = array("eq", $area);
		}

		if ($language != "") {
			$where["ting_language"] = array("eq", $language);
		}

		if ($year) {
			$yearr = explode(",", $year);

			if (1 < count($yearr)) {
				$where["ting_year"] = array("between", $yearr[0] . "," . $yearr[1]);
			}
			else {
				$where["ting_year"] = array("eq", $year);
			}
		}

		if ($lz == 1) {
			$where["ting_continu"] = array("neq", "0");
		}
		else if ($lz == 2) {
			$where["ting_continu"] = 0;
		}

		$rs = D("Ting");
		$total = $rs->where($where)->count();
		$limit = 20;
		$currentpage = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$totalpages = ceil($total / $limit);

		if ($totalpages < $currentpage) {
			$currentpage = $totalpages;
		}

		$order = "ting_" . $order . " desc";
		$list = $rs->where($where)->limit("$currentpage,$limit")->order($order)->select();
		$result["pages"] = "";

		if (1 < $totalpages) {
			$pagebox = "<strong>共" . $total . "部&nbsp;当前:" . $currentpage . "/" . $totalpages . "</strong>";

			if (1 < $currentpage) {
				$pagebox .= "<a href='" . posurl() . "User-Center-love-op-1-pid-" . $_GET["pid"] . "-p-1' class=\"pagegbk\">首页</a>";
				$pagebox .= "<a href='" . posurl() . "User-Center-love-op-1-pid-" . $_GET["pid"] . "-p-" . ($currentpage - 1) . "' class=\"prev pagegbk\">上一页</a>&nbsp;&nbsp";
			}
			else {
				$pagebox .= "<span class=\"prev disabled\">首页</span>";
				$pagebox .= "<span class=\"prev disabled\">上一页</span>;";
			}

			$halfPer = 4;
			$i = $currentpage - $halfPer;
			(1 < $i) || ($i = 1);
			$j = $currentpage + $halfPer;
			($j < $totalpages) || ($j = $totalpages);

			for (; $i < ($j + 1); $i++) {
				$pagebox .= ($i == $currentpage ? "<span class=\"current\">" . $i . "</span>" : "<a href='" . posurl() . "User-Center-love-op-1-pid-" . $_GET["pid"] . "-p-" . $i . "'>" . $i . "</a>");
			}

			if ($currentpage < $totalpages) {
				$pagebox .= "<a href='" . posurl() . "User-Center-love-op-1-pid-" . $_GET["pid"] . "-p-" . ($currentpage + 1) . "' class=\"next pagegbk\">下一页</a>";
				$pagebox .= "<a href='" . posurl() . "User-Center-love-op-1-pid-" . $_GET["pid"] . "-p-" . $totalpages . "' class=\"next pagegbk\">尾页</a>";
			}
			else {
				$pagebox .= "<span class=\"next disabled\">下一页</span>";
				$pagebox .= "<span class=\"disabled\">尾页</span>";
			}

			$result["pages"] = $pagebox;
			$result["ajaxtxt"] = $this->datalist($list);
		}

		exit(json_encode($result));
	}

	private function datalist($list)
	{
		$ajaxtxt = "";

		foreach ($list as $key => $value ) {
			if (is_array($value)) {
				$link = gxl_data_url("ting", $value["ting_id"], $value["ting_cid"], $value["ting_name"], 1, $value["ting_jumpurl"]);
				$playurl = gxl_data_url("ting", $value["ting_id"], $value["ting_cid"], $value["ting_name"], 1, $value["ting_jumpurl"]);
				$pic = gxl_img_url($value["ting_pic"]);
				$lastemplateayurl = gxl_play_url_end(trim($value["ting_url"]));
				$lastemplateay_name = $lastemplateayurl[2];
				$lastemplateay_url = gxl_play_url($value["ting_id"], $lastemplateayurl[0], $lastemplateayurl[1], $value["ting_cid"], $value["ting_name"]);
				$golder = $value["ting_gold"] * 10;
				$ajaxtxt .= "<li>";
				$ajaxtxt .= "<a class=\"ting-img\" target=\"_blank\" href=\"$link\">";
				$ajaxtxt .= "<img  class=\"loadimg\"  src=\"$pic\"/>";
				$ajaxtxt .= "<label class=\"mask\"></label><label class=\"text\"></label>";

				if ($value["ting_continu"] != 0) {
					$ajaxtxt .= "<label class=\"text\">$lastemplateay_name</label>";
				}
				else if (empty($value["ting_title"])) {
					$ajaxtxt .= "<label class=\"text\">完整高清</label>";
				}
				else {
					$ajaxtxt .= "<label class=\"text\">" . $value["ting_title"] . "</label>";
				}

				$ajaxtxt .= "<label class=\"score\">" . $value["ting_gold"] . "</label>";
				if (empty($value["ting_continu"]) && !empty($value["ting_tvcont"])) {
					$ajaxtxt .= "<span class=\"tv\"></span><span class=\"tvtime\">" . $value["ting_diantai"] . $value["ting_tvcont"] . "</span>";
				}

				$ajaxtxt .= "</a>";
				$ajaxtxt .= "<div class=\"play-txt\">";
				$ajaxtxt .= "<h3><a target=\"_blank\" href=\"$link\">" . $value["ting_name"] . "</a><span class=\"stitle\">" . $lastemplateay_name . "</span></h3>";
				$ajaxtxt .= "<p class=\"gold\"><span class=\"starbs\"><span class=\"starbb\" style=\"width:$golder%;\"></span></span>({$value["ting_golder"]}人评分)</p>";
				$ajaxtxt .= "<p class=\"director\"><em>导演:</em>" . gxl_search_url($value["ting_director"]) . "</p>";
				$ajaxtxt .= "<p class=\"actor\"><em>主演:</em>" . gxl_search_url($value["ting_actor"]) . "</p>";
				$ajaxtxt .= "<p class=\"type\"><em>类型：</em>" . gxl_mcat_url($value["ting_mcid"], $value["ting_cid"]) . "<em class=\"area\">地区：" . gxl_search_url($value["ting_area"]) . "</em></p>";
				$ajaxtxt .= "<p class=\"type\"><em class=\"showdata\">上映：" . $value["ting_year"] . "</em><em class=\"long\">更新时间：" . date("Y-m-d H:i", $value["ting_addtime"]) . "</em></p>";
				$ajaxtxt .= "<p class=\"plot\"><em>剧情：</em>" . msubstr($value["ting_content"], 0, 150, "utf-8", true) . "…</p>";
				$ajaxtxt .= "<p class=\"more-desc\"><a class=\"ak\" target=\"_blank\" href=\"$playurl\">在线观看</a><a class=\"as\" target=\"_blank\" href=\"$link#juqing\">作品详情</a><a class=\"av\" target=\"_blank\" href=\"$link#comment\">影评</a>";
			}
		}

		return $ajaxtxt;
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
		$array = $rs->where($where)->relation("Tag")->find();

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


