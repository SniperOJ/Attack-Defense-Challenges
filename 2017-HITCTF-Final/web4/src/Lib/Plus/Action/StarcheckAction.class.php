<?php
namespace Plus\Action;
use Think\Action;
class StarcheckAction extends Action
{
	public function _initialize()
	{
		header("Content-Type:text/html; charset=utf-8");
		$Nav = F("_nav/list");

		if (in_array("index.php?s=Plus-Check-Starcheck-check_sub-ok", $Nav) === false) {
			$Nav["检测作品重名"] = "index.php?s=Plus-Starcheck-Starcheck-check_sub-ok";
			F("_nav/list", $Nav);
		}

		if (!$_SESSION[C("USER_AUTH_KEY")]) {
			$_SESSION["AdminLogin"] = 1;
			$this->assign("jumpUrl", C("cms_admin") . "?s=Admin-Login");
			$this->error("对不起，您还没有登录，请先登录！");
		}

		$domain = require "./Runtime/Conf/config.php";
		$domain = $domain["site_url"];

		if (C("site_url") != $domain) {
			echo "配置有误，请检查Runtime/Conf/config.php或清除Runtime/~app.php,~runtime.php";
			exit();
		}

		if ($_GET["mod"] == "1") {
			$_SESSION["CheckMod"] = 1;
		}
		else if ($_GET["mod"] == "2") {
			$_SESSION["CheckMod"] = 2;
		}
		else if (empty($_SESSION["CheckMod"])) {
			$_SESSION["CheckMod"] = 1;
		}

		$this->assign("mod", $_SESSION["CheckMod"]);
		C("TMPL_FILE_NAME", "./Public/plus/..");
	}

	public function Starcheck()
	{
		if ($_REQUEST["check_sub"]) {
			$Get = $this->GetParam();

			if (!empty($Get["len"])) {
				$result = $this->RepeatCheck($Get);
				$this->assign("result", $result);
				$this->assign("list_channel_video", F("_ppting/listting"));
			}
		}

		$this->display("./Public/plus/star_check.html");
	}

	public function RepeatCheck($Get)
	{
		$TingModel = D("Star");
		$len = $Get["len"];
		$arr = $TingModel->field("star_name")->Group("Left(star_name,$len)")->Having("count(*)>1")->select();

		foreach ($arr as $key => $val ) {
			if ($_SESSION["CheckMod"] == "1") {
				$arrTitle[] .= $val["star_name"];
			}
			else if ($_SESSION["CheckMod"] == "2") {
				$arrTitle[] .= mb_substr($val["star_name"], 0, $len, "utf-8");
			}
		}

		$where = $this->SearchCon($Get);
		$where["left(star_name,$len)"] = array("in", $arrTitle);
		$video_count = $TingModel->where($where)->count("star_id");
		$video_page = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$pagesize = 100;
		$totalPages = ceil($video_count / $pagesize);
		$video_page = get_maxpage($video_page, $totalPages);
		$video_url = U("Plus-Starcheck/Starcheck", array("check_sub" => "ok", "len" => urlencode($len), "cid" => $Get["cid"]), false, false) . "-p-{!page!}" . C("url_html_suffix");
		$pagelist = "总数" . $video_count . " " . getpage($video_page, $totalPages, 5, $video_url, "1");
		$_SESSION["video_repurl"] = $video_url . $video_page;
		$video["type"] = (!empty($_GET["type"]) ? $_GET["type"] : "star_name");
		$video["order"] = (!empty($_GET["order"]) ? $_GET["order"] : "desc");
		$order = $video["type"] . " " . $video["order"];
		$VResult = $TingModel->field("star_id,star_name,star_pyname,star_letter,star_pic,star_xb,star_sg,star_cstime,star_zy,star_xz,star_xx,star_area,star_csd,star_content,star_addtime")->where($where)->order($order)->limit($pagesize)->page($video_page)->select();

		foreach ($VResult as $key => $val ) {
			$VResult[$key]["star_pic"] = gxl_img_url($VResult[$key]["star_pic"]);
			$VResult[$key]["star_url"] = gxl_star_url("read", $VResult[$key]["star_id"], $VResult[$key]["star_pyname"], 1);
		}

		return array("vresult" => $VResult, "pagelist" => $pagelist, "len" => $len, "order" => $order, "keyword" => $Get["keyword"]);
	}

	private function admin_star_arr($stars)
	{
		for ($i = 1; $i <= 5; $i++) {
			if ($i <= $stars) {
				$ss[$i] = 1;
			}
			else {
				$ss[$i] = 0;
			}
		}

		return $ss;
	}

	private function SearchCon($Get)
	{
		if ($Get["keyword"]) {
			$search["star_name"] = array("like", "%" . $Get["keyword"] . "%");
			$search["_logic"] = "or";
			$where["_complex"] = $search;
		}

		return $where;
	}

	private function GetParam()
	{
		$Get = $this->GetReq($_REQUEST, array("len" => "int", "type" => "string", "order" => "string"));
		$Get["keyword"] = urldecode(trim($Get["keyword"]));
		return $Get;
	}

	private function GetReq($requests, $input)
	{
		if (!is_array($input) || !is_array($requests)) {
			return array();
		}

		$data = array();

		foreach ($input as $key => $type ) {
			$item = $requests[$key];

			if (strtolower($type) == "trim") {
				$item = trim($item);
			}
			else if (@!settype($item, $type)) {
				exit("Check the type of the item \"" . $key . "\" in input array");
			}

			$data[$key] = $item;
		}

		return $data;
	}
}


