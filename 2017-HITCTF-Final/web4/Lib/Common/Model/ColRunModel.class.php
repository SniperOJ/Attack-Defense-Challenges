<?php

namespace Common\Model;
use Think\Model\AdvModel;
class ColRunModel extends AdvModel
{
	private $DB;
	private $ContDB;
	private $UrlDB;
	private $CModel;
	private $QR;
	private $cu;

	public function __construct()
	{
		$this->DB = D("co_node");
		$this->ContDB = D("co_content");
		$this->UrlDB = D("co_urls");
		$this->CModel = D("CustomCollect");
		$this->QR = new \Org\Net\QireCaiji();
		$this->cu = new \Org\Net\Curl();
	}

	public function get_html($url, &$config)
	{
		if (!get_headers($url)) {
			return false;
		}

		if (!empty($url)) {
			$html = $this->cu->get($url);

			if ($html == false) {
				return $html;
			}

			if (($syscharset != $config["sourcecharset"]) && ($config["sourcetype"] != 4)) {
				$html = iconv($config["sourcecharset"], "utf-8", $html);
			}

			return $html;
		}
		else {
			return false;
		}
	}

	public function GetParam()
	{
		$Get = getReq($_REQUEST, array("action" => "string", "type" => "string", "nid" => "int", "page" => "int", "stime" => "int"));

		if ($Get["type"] == "content") {
			$Get = array_merge($Get, getReq($_REQUEST, array("total" => "int", "pagesize" => "int", "cmode" => "int", "action" => "string")));

			if (empty($Get["pagesize"])) {
				$Get["pagesize"] = 1;
			}
		}

		return $Get;
	}

	public function Check($Get)
	{
		if (empty($Get["nid"])) {
			$this->error = "参数错误";
			return false;
		}

		$where["id"] = intval($Get["nid"]);
		$Data = $this->DB->where($where)->find();

		if (!$Data) {
			$this->error = "该节点不存在或已删除";
			return false;
		}

		if (!empty($Get["action"])) {
			$Data["action"] = $Get["action"];
		}
		else {
			$this->error = "参数错误";
			return false;
		}

		if (isset($Get["total"])) {
			$Data["total"] = intval($Get["total"]);
		}

		if (isset($Get["page"])) {
			$Data["page"] = intval($Get["page"]);
		}

		if (isset($Get["stime"])) {
			$Data["stime"] = intval($Get["stime"]);
		}

		if (isset($Get["pagesize"])) {
			$Data["pagesize"] = intval($Get["pagesize"]);
		}

		if (isset($Get["cmode"])) {
			$Data["cmode"] = intval($Get["cmode"]);
		}

		return $Data;
	}

	public function ColVideoSearch()
	{
		if (!empty($_REQUEST["nid"])) {
			$Get["nid"] = trim($_REQUEST["nid"]);
		}

		if (!empty($_REQUEST["title"])) {
			$Get["title"] = trim($_REQUEST["title"]);
		}

		return $Get;
	}

	public function ColVideoList($where)
	{
		if (!empty($where["title"])) {
			$title = $where["title"];
			$where["title"] = array("like", "%" . $title . "%");
		}

		$order = (empty($_GET["order"]) ? "addtime" : $_GET["order"]);
		$sort = (empty($_GET["sort"]) ? "desc" : $_GET["sort"]);
		$order = $order . " " . $sort;
		$where["status"] = array("neq", 0);
		$video_count = $this->ContDB->where($where)->count();
		$video_page = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$video_page = get_cms_page_max($video_count, C("url_num_admin"), $video_page);
		$video_url = U("ColVideo", array("nid" => urlencode($where["nid"]), "title" => urlencode($title), "p" => ""), false, false);
		$video_url = str_replace("?s=/", "?s=", $video_url);
		$pagelist = get_cms_page($video_count, C("url_num_admin"), $video_page, $video_url, "条记录");
		$_SESSION["video_reurl"] = $video_url . $video_page;
		$Arr = $this->ContDB->field(C("db_prefix") . "co_content.id,nid,name,status,url,data,addtime")->join(C("db_prefix") . "co_node on " . C("db_prefix") . "co_node.id=nid")->where($where)->order(C("db_prefix") . "co_content." . $order)->limit(C("url_num_admin"))->page($video_page)->select();

		foreach ($Arr as $key => $val ) {
			if (!empty($val["data"])) {
				$Arr[$key]["data"] = string2array($val["data"]);
				unset($Arr[$key]["data"]["playurl"]);
				$Arr[$key]["base"] = $this->ConvShow($Arr[$key]["data"]);
			}
		}

		$ArrReturn = array("video" => $Arr, "pagelist" => $pagelist, "order" => $order, "title" => $title, "nid" => $where["nid"]);
		return $ArrReturn;
	}

	public function CoUrl(&$Data)
	{
		$ListUrls = $this->GetList($Data);
		$TotalPage = (count($ListUrls) + intval($Data["pagesize_start"])) - 1;

		if (0 < $TotalPage) {
			$Page = (!empty($Data["page"]) ? intval($Data["page"]) : intval($Data["pagesize_start"]) - 1);
			$CurList = $ListUrls[$Page];
			$ArtUrl = $this->GetArtlist($CurList, $Data);
			$ArtTotal = count($ArtUrl);
			$reNum = 0;
			$newNum = 0;
			if (is_array($ArtUrl) && !empty($ArtUrl)) {
				foreach ($ArtUrl as $v ) {
					if (empty($v["url"])) {
						continue;
					}

					if (empty($v["intro"])) {
						$v["intro"] = "";
					}

					$v = Doaddslashes($v);
					$v["title"] = strip_tags($v["title"]);

					if (true) {
						$where["md5"] = md5($v["url"]);

						if (!$this->UrlDB->where($where)->find()) {
							$where["nid"] = $Data["id"];
							$this->UrlDB->data($where)->add();
							$r = $this->ContDB->data(array("nid" => $where["nid"], "status" => 0, "intro" => $v["intro"], "url" => $v["url"], "title" => $v["title"], "addtime" => time()))->add();
							$newNum++;
						}
						else {
							$cwhere["nid"] = $Data["id"];
							$cwhere["url"] = $v["url"];

							if ($this->ContDB->where($cwhere)->find()) {
								$this->ContDB->where($cwhere)->setField("status", 0);
								$this->ContDB->where($cwhere)->setField("intro", $v["intro"]);
							}

							$reNum++;
						}
					}
				}

				if ($Data["action"] === "real") {
					if ($TotalPage <= $Page) {
						$this->DB->where("id=" . $Data["id"])->save(array("lastdate" => time()));
					}
				}

				$UrlArr = array("nid" => $Data["id"], "name" => $Data["name"], "url_list" => $CurList, "url" => $ArtUrl, "page" => $Page + 1, "total_page" => $TotalPage, "total" => $ArtTotal, "reNum" => $reNum, "newNum" => $newNum, "newAdd" => $ArtTotal - $reNum, "action" => $Data["action"], "stime" => $Data["stime"]);
				$this->DB->where("id=" . $Data["id"])->save(array("lastdate" => time()));
				return $UrlArr;
			}
			else {
				$this->error = "采集失败，获取作品列表失败";
				return false;
			}
		}
		else {
			$this->error = "采集失败，没有可采集的网址";
			return false;
		}
	}

	public function Contest($Url, &$Data)
	{
		$html = $this->GetCon($Url, $Data);
		$Arr = $this->ConvShow($html);
		return $Arr;
	}

	public function ConvShow(&$html)
	{
		$BaseArr = $this->CModel->BaseArr();

		foreach ($BaseArr as $k => $v ) {
			if (array_key_exists($k, $html)) {
				$arr[$v] = $html[$k];
			}
		}

		return $Return = array("base" => $arr, "playurl" => $html["playurl"]);
	}

	public function GentHtml($id)
	{
		$html = $this->ContDB->where("id=" . $id)->select();
	}

	public function Collecting(&$config)
	{
		$page = (!empty($config["page"]) ? intval($config["page"]) : 1);
		$all = (!empty($config["total"]) ? intval($config["total"]) : 0);
		$where = array("nid" => $config["id"], "status" => "0");
		$total = $this->ContDB->where($where)->count();

		if (empty($all)) {
			$all = $total;
		}

		$total_page = ceil($all / $config["pagesize"]);
		$maxpage = get_cms_page_max($total, $config["pagesize"], $page);
		$list = $this->ContDB->where($where)->order("id desc")->limit($config["pagesize"])->page($maxpage)->select();

		if ($page <= 1) {
			$this->DB->where("id=" . $config["id"])->save(array("lastdate" => time()));
		}

		if (!empty($list) && is_array($list)) {
			if ($total_page < $page) {
				F("_ppting/ColCache", NUll);
				$this->error = "采集完成！";
				return true;
			}

			foreach ($list as $v ) {
				$html = $this->GetCon($v, $config);
				$msg = "<strong>" . $html["title"] . "</strong> ";
				$html["cid"] = $config["cid"];
				$updata = array("status" => "1", "data" => array2string($html), "addtime" => time());

				if (!empty($html["title"])) {
					$updata["title"] = $html["title"];
				}

				$Update = $this->ContDB->where("id=" . $v["id"])->save($updata);

				if ($Update === "false") {
					$msg .= " 采集入库失败！";
					continue;
				}
				else {
					$msg .= " 采集成功.";
				}

				if (0 < $config["stime"]) {
					sleep($config["stime"]);
					$msg .= "暂停" . $config["stime"] . "秒继续采集...";
				}

				$result = array("con" => $this->ConvShow($html), "url" => $v["url"], "msg" => $msg);
			}

			$StrUrl = "?s=Admin-Customcollect-ColRun-action-real-type-content-nid-" . $config["id"] . "-page-" . ($page + 1) . "-total-" . $all . "-stime-" . $config["stime"];
			$result["StrUrl"] = $StrUrl;
			$result["total"] = $all;
			$result["already"] = $page * $config["pagesize"];
			$result["percent"] = ($result["already"] / $result["total"]) * 200;

			if ($page <= $total_page) {
				$CacheUrl = "?s=Admin-Customcollect-ColRun-action-real-type-content-nid-" . $config["id"] . "-page-" . $page . "-total-" . $all . "-stime-" . $config["stime"];
				F("_ppting/ColCache", $CacheUrl);
			}

			return $result;
		}
		else {
			if (F("_ppting/ColCache")) {
				F("_ppting/ColCache", NUll);
			}

			$this->error = "没有要采集的作品";
			return false;
		}
	}

	public function GetArtlist($url, &$config)
	{
		if ($html = $this->get_html($url, $config)) {
			if ($config["sourcetype"] == 4) {
				$html = xml::xml_unserialize($html);
				$data = array();

				if (is_array($html["rss"]["channel"]["item"])) {
					foreach ($html["rss"]["channel"]["item"] as $k => $v ) {
						$data[$k]["url"] = $v["link"];
						$data[$k]["title"] = $v["title"];
					}
				}
			}
			else if ($config["sourcetype"] == 3) {
				$data = array();
				$data[] = array("url" => $url, "intro" => "");
			}
			else {
				$html = json_decode($html);
				$html = $html->ajaxtxt;
				preg_match_all($config["intro_rule"], $html, $intro);

				if (!isset($intro[1][1])) {
					preg_match_all("|<p class=\"state\"><em>状态：</em>(.*)&nbsp;|U", $html, $intro);
				}

				if (isset($intro[1])) {
					foreach ($intro[1] as $k => $v ) {
						$data[$k]["intro"] = replace_item($v, $config["intro_filter"]);
					}
				}

				preg_match_all("|<h5>(.*)href=\"(.*)\">(.*)</a></h5>|U", $html, $title);

				if (isset($title[2])) {
					foreach ($title[2] as $k => $v ) {
						$data[$k]["url"] = $v;
						$data[$k]["title"] = $title[3][$k];
					}
				}
			}

			return $data;
		}
		else {
			return false;
		}
	}

	public function GetCon($source, &$config, $page = 0)
	{
		set_time_limit(300);
		$oldurl = &$oldurl;
		$page = (intval($page) ? intval($page) : 0);
		$url = $source["url"];

		if ($config["picmode"] == "1") {
			$data["picurl"] = $source["picurl"];
		}

		$data["intro"] = $source["intro"];

		if ($html = $this->get_html($url, $config)) {
			if (strlen($html) < 50) {
				exit("采集出错:" . date("Y-m-d H:i:s", time()));
			}

			if (empty($page)) {
				if (isset($config["fields"])) {
					$config["fields"] = string2array($config["fields"]);
				}

				if (is_array($config["fields"])) {
					foreach ($config["fields"] as $k => $v ) {
						if ($config[$v . "_rule"]) {
							if ($v == "intro") {
								continue;
							}

							$ArrRule = replace_sg($config[$v . "_rule"]);
							$data[$v] = replace_item(cut_html($html, $ArrRule[0], $ArrRule[1]), $config[$v . "_filter"]);
							$data[$v] = str_replace("\r\n", "", $data[$v]);
							$data[$v] = str_replace("\n", "", $data[$v]);
							$data[$v] = str_replace("\r", "", $data[$v]);
						}
					}
				}

				if ($config["menutype"] == "1") {
					$data["cname"] = getlistname(intval($config["cid"]));
				}

				if ($config["range"] == "1") {
					$plist = cut_html($html, $config["playlist_start"], $config["playlist_end"]);
				}
				else {
					$plist = &$html;
				}

				if ($config["playmode"] == "1") {
					if ($config["playlink_rule"]) {
						$out = $this->MatchAll($plist, $config["playlink_rule"]);

						foreach ($out as $key => $val ) {
							$playlink[$key] = replace_item($val, $config["playlink_filter"]);
							$playlink[$key] = url_check($playlink[$key], $url, $config);
							$phtml[$key] = $this->get_html($playlink[$key], $config);

							if ($config["purl_range"] == "1") {
								$phtml[$key] = cut_html($phtml[$key], $config["playurl_start"], $config["playurl_end"]);
							}

							if ($config["playurl_rule"]) {
								$ArrRule = replace_sg($config["playurl_rule"]);
								$data["playurl"][$key] = replace_item(cut_html($phtml[$key], $ArrRule[0], $ArrRule[1]), $config["playurl_filter"]);
							}
						}
					}
				}
				else {
					if ($config["playmode"] == "2") {
						if ($config["playlink_rule"]) {
							$ArrRule = replace_sg($config["playlink_rule"]);
							$playlink = replace_item(cut_html($plist, $ArrRule[0], $ArrRule[1]), $config["playlink_filter"]);
						}

						if ($playlink == "") {
							$plist = cut_html($plist, $config["url_start"], $config["url_end"]);
							$plist = str_replace(array("\r", "\n"), "", $plist);
							$plist = str_replace(array("</a>", "</A>"), "</a>\n", $plist);
							preg_match_all("|<a(.*)href=\"(.*)\">|U", $plist, $out);

							if (isset($out[2][0])) {
								$playlink = $out[2][0];
							}
						}

						$playlink = url_check($playlink, $url, $config);
						$phtml = $this->get_html($playlink, $config);

						if ($config["purl_range"] == "1") {
							$phtml = cut_html($phtml, $config["playurl_start"], $config["playurl_end"]);
						}
					}
					else {
						$phtml = &$plist;
					}

					if ($config["playurl_rule"]) {
						$tmp = substr_count($phtml, "gxl_play");

						if (0 < $tmp) {
							$data["playurl"] = $phtml;
						}
						else {
							$out = $this->MatchAll($phtml, $config["playurl_rule"]);

							foreach ($out as $key => $val ) {
								$data["playurl"][] = replace_item($val, $config["playurl_filter"]);
							}
						}
					}
					else {
						$data["playurl"] = $phtml;
					}

					if (!isset($data["playurl"])) {
						$data["playurl"] = $phtml;
					}

					$data["playurl"] = str_replace("'", "\"", $data["playurl"]);
				}

				if ($config["vnamemode"] == 2) {
					if ($config["vname_rule"]) {
						$vout = $this->MatchAll($phtml, $config["vname_rule"]);

						foreach ($vout as $key => $val ) {
							$data["vname"][] = replace_item($val, $config["vname_filter"]);
						}

						foreach ($data["playurl"] as $k => $v ) {
							$data["playurl"][$k] = $data["vname"][$k] . "\$" . $v;
						}
					}
				}

				$data["picurl"] = preg_replace("/<img[^>]*src=['\"]?([^>'\"\s]*)['\"]?[^>]*>/ie", "'\$1'", $data["picurl"]);

				if ($config["action"] == "real") {
					if (empty($page) && !empty($data["picurl"]) && (C("upload_http") == 1)) {
						$Down = D("Down");
						$data["picurl"] = $Down->down_img($data["picurl"]);
					}

					if (empty($data["time"])) {
						$data["time"] = time();
					}
				}
			}

			return $data;
		}
		else {
			exit("采集出错:" . date("Y-m-d H:i:s", time()));
		}
	}

	public function GetList(&$config, $num = "")
	{
		$url = array();

		switch ($config["sourcetype"]) {
		case $config["sourcetype"]:
			$num = (empty($num) ? $config["pagesize_end"] : $num);

			if ($config["pagesize_start"] <= 0) {
				$config["pagesize_start"] = 1;
			}

			for ($i = $config["pagesize_start"]; $i <= $num; $i = $i + $config["par_num"]) {
				$url[$i - 1] = str_replace("(*)", $i, $config["urlpage"]);
			}

			if ($config["colmode"] == "desc") {
				$url = get_collect_krsort($url);
			}

			break;

		case $config["sourcetype"]:
			$url = explode("\r\n", $config["urlpage"]);

			if ($config["colmode"] == "desc") {
				$url = get_collect_krsort($url);
			}

			break;

		case $config["sourcetype"]:
		case $config["sourcetype"]:
			$url[] = $config["urlpage"];
			break;
		}

		return $url;
	}

	public function MatchAll(&$html, $rule)
	{
		$ArrRule = replace_sg($rule);

		foreach ($ArrRule as $key => $val ) {
			$ArrRule[$key] = str_replace_all($val);
		}

		$str = "/" . $ArrRule[0] . "([\s\S]*?)" . $ArrRule[1] . "/";
		preg_match_all($str, $html, $out);

		if ($out) {
			return $out[1];
		}

		return false;
	}

	public function GetPlayUrl(&$html, $rule, $filter)
	{
		$out = $this->MatchAll($html, $rule);

		foreach ($out as $key => $val ) {
			$data["playurl"][] = replace_item($val, $filter);
		}

		return $data["playurl"];
	}

	public function Inflow($act)
	{
		if ($act == "inflow") {
			if (empty($_POST["ids"])) {
				$this->error = "请选择需入库作品!";
				return false;
			}

			$ArrID = $_POST["ids"];
		}
		else {
			$where["status"] = array("neq", 0);

			if ($act == "today") {
				$where["addtime"] = array("gt", getxtime(1));
			}

			if ($act == "allunused") {
				$where["status"] = 1;
			}

			if ($act == "allinflow") {
				$where = "";
			}

			$All = $this->ContDB->field("id")->limit(50)->where($where)->select();

			foreach ($All as $k => $v ) {
				$ArrID[$k] = $v["id"];
			}
		}

		foreach ($ArrID as $key => $val ) {
			$Cont = $this->ContDB->field("nid,url,data")->where("id=" . $val)->find();
			$data = string2array($Cont["data"]);

			if ($data["playurl"] == "") {
				$UpCont = array("status" => 0);
				$Update = $this->ContDB->where("id=" . $val)->save($UpCont);
			}

			$playurls = $this->QR->getPlayURL($data["playurl"]);
			preg_match_all("|/videos/(.*)ting-play-id-(.*)-|U", $data["playurl"], $id);

			if (isset($id[2])) {
				$data["reid"] = $id[2][0];
			}

			$data = $this->format_data($data);
			$data["ting_play"] = $playurls["players"];
			$data["ting_url"] = $playurls["urls"];

			if (!$this->CModel->videoImport($Cont["url"], $data, $Cont["nid"])) {
				$result .= "[" . $data["cname"] . "]<strong>" . $data["ting_name"] . "</strong>";
				$result .= "入库失败：" . $this->CModel->getError() . "\n\r";
				continue;
			}
			else {
				$UpCont = array("status" => 2);
				$Update = $this->ContDB->where("id=" . $val)->save($UpCont);
				$result .= "[" . $data["cname"] . "]<strong>" . $data["ting_name"] . "</strong>";
				$result .= $playurls["count"] . " 组播放地址入库成功!\n\r";
			}
		}

		$result = explode("\n\r", $result);
		return $result;
	}

	public function format_data($data)
	{
		$result = array();
		$arr = array("title" => "ting_name", "intro" => "ting_title", "time" => "ting_addtime", "mcid" => "ting_mcid", "director" => "ting_director", "actor" => "ting_actor", "content" => "ting_content", "picurl" => "ting_pic", "area" => "ting_area", "language" => "ting_language", "year" => "ting_year", "serial" => "ting_continu", "cid" => "ting_cid", "cname" => "cname", "reid" => "reid");

		foreach ($arr as $key => $row ) {
			if (isset($data[$key])) {
				$result[$row] = $data[$key];
			}
		}

		return $result;
	}

	public function Del($act)
	{
		if (($act == "delselect") || ($act == "delonly")) {
			if (!empty($_POST["ids"])) {
				$where["id"] = array("in", $_POST["ids"]);

				if ($act == "delselect") {
					$urls = $this->ContDB->field("url")->where($where)->select();

					foreach ($urls as $k => $v ) {
						$Arrmd5[] = md5($v["url"]);
					}

					$Wmd5["md5"] = array("in", $Arrmd5);

					if (!$this->UrlDB->where($Wmd5)->delete()) {
						echo $this->UrlDB->getDBError();
						$this->error = $this->UrlDB->getDBError();
						return false;
					}
				}

				$this->ContDB->where($where)->delete();
				return true;
			}
			else {
				$this->error = "请选择要删除的作品";
				return false;
			}
		}
		else if ($act == "delall") {
			$this->ContDB->delete();
			return true;
		}
		else if ($act == "del") {
			$this->ContDB->where("id=" . $_GET["vid"])->delete();
			return true;
		}

		return false;
	}

	public function MyCollecting(&$config)
	{
		$where = array("nid" => $config["id"], "status" => "0");
		$list = $this->ContDB->where($where)->order("id desc")->limit(2)->select();
		if (!empty($list) && is_array($list)) {
			foreach ($list as $v ) {
				$html = $this->MyGetCon($v, $config);

				if ($html == -1) {
					$UpCont = array("status" => 5);
					$Update = $this->ContDB->where("id=" . $v["id"])->save($UpCont);
					exit();
				}

				$html["cid"] = $config["cid"];
				$updata = array("status" => "1", "data" => array2string($html), "addtime" => time());

				if (!empty($html["title"])) {
					$updata["title"] = $html["title"];
				}

				$Update = $this->ContDB->where("id=" . $v["id"])->save($updata);
				$playurls = $this->QR->getPlayURL($html["playurl"]);
				preg_match_all("|/videos/(.*)ting-play-id-(.*)-|U", $html["playurl"], $id);

				if (isset($id[2])) {
					$html["reid"] = $id[2][0];
				}

				$html = $this->format_data($html);
				$html["ting_play"] = $playurls["players"];
				$html["ting_url"] = $playurls["urls"];

				if ($this->CModel->videoImport($v["url"], $html, $v["nid"])) {
					$UpCont = array("status" => 2);
					$Update = $this->ContDB->where("id=" . $v["id"])->save($UpCont);
				}
			}
		}
	}

	public function MyGetCon($source, &$config, $page = 0)
	{
		$oldurl = &$oldurl;
		$page = (intval($page) ? intval($page) : 0);
		$url = $source["url"];

		if ($config["picmode"] == "1") {
			$data["picurl"] = $source["picurl"];
		}

		$data["intro"] = $source["intro"];

		if ($html = $this->get_html($url, $config)) {
			if (strlen($html) < 50) {
				return -1;
			}

			if (empty($page)) {
				if (isset($config["fields"])) {
					$config["fields"] = string2array($config["fields"]);
				}

				if (is_array($config["fields"])) {
					foreach ($config["fields"] as $k => $v ) {
						if ($config[$v . "_rule"]) {
							if ($v == "intro") {
								continue;
							}

							$ArrRule = replace_sg($config[$v . "_rule"]);
							$data[$v] = replace_item(cut_html($html, $ArrRule[0], $ArrRule[1]), $config[$v . "_filter"]);
							$data[$v] = str_replace("\r\n", "", $data[$v]);
							$data[$v] = str_replace("\n", "", $data[$v]);
							$data[$v] = str_replace("\r", "", $data[$v]);
						}
					}
				}

				if ($config["menutype"] == "1") {
					$data["cname"] = getlistname(intval($config["cid"]));
				}

				if ($config["range"] == "1") {
					$plist = cut_html($html, $config["playlist_start"], $config["playlist_end"]);
				}
				else {
					$plist = &$html;
				}

				if ($config["playmode"] == "1") {
					if ($config["playlink_rule"]) {
						$out = $this->MatchAll($plist, $config["playlink_rule"]);

						foreach ($out as $key => $val ) {
							$playlink[$key] = replace_item($val, $config["playlink_filter"]);
							$playlink[$key] = url_check($playlink[$key], $url, $config);
							$phtml[$key] = $this->get_html($playlink[$key], $config);

							if ($config["purl_range"] == "1") {
								$phtml[$key] = cut_html($phtml[$key], $config["playurl_start"], $config["playurl_end"]);
							}

							if ($config["playurl_rule"]) {
								$ArrRule = replace_sg($config["playurl_rule"]);
								$data["playurl"][$key] = replace_item(cut_html($phtml[$key], $ArrRule[0], $ArrRule[1]), $config["playurl_filter"]);
							}
						}
					}
				}
				else {
					if ($config["playmode"] == "2") {
						if ($config["playlink_rule"]) {
							$ArrRule = replace_sg($config["playlink_rule"]);
							$playlink = replace_item(cut_html($plist, $ArrRule[0], $ArrRule[1]), $config["playlink_filter"]);
						}

						if ($playlink == "") {
							$plist = cut_html($plist, $config["url_start"], $config["url_end"]);
							$plist = str_replace(array("\r", "\n"), "", $plist);
							$plist = str_replace(array("</a>", "</A>"), "</a>\n", $plist);
							preg_match_all("|<a(.*)href=\"(.*)\">|U", $plist, $out);

							if (isset($out[2][0])) {
								$playlink = $out[2][0];
							}
						}

						$playlink = url_check($playlink, $url, $config);
						$phtml = $this->get_html($playlink, $config);

						if ($config["purl_range"] == "1") {
							$phtml = cut_html($phtml, $config["playurl_start"], $config["playurl_end"]);
						}
					}
					else {
						$phtml = &$plist;
					}

					if ($config["playurl_rule"]) {
						$tmp = substr_count($phtml, "gxl_play");

						if (0 < $tmp) {
							$data["playurl"] = $phtml;
						}
						else {
							$out = $this->MatchAll($phtml, $config["playurl_rule"]);

							foreach ($out as $key => $val ) {
								$data["playurl"][] = replace_item($val, $config["playurl_filter"]);
							}
						}
					}
					else {
						$data["playurl"] = $phtml;
					}

					if (!isset($data["playurl"])) {
						$data["playurl"] = $phtml;
					}

					$data["playurl"] = str_replace("'", "\"", $data["playurl"]);
				}

				if ($config["vnamemode"] == 2) {
					if ($config["vname_rule"]) {
						$vout = $this->MatchAll($phtml, $config["vname_rule"]);

						foreach ($vout as $key => $val ) {
							$data["vname"][] = replace_item($val, $config["vname_filter"]);
						}

						foreach ($data["playurl"] as $k => $v ) {
							$data["playurl"][$k] = $data["vname"][$k] . "\$" . $v;
						}
					}
				}

				$data["picurl"] = preg_replace("/<img[^>]*src=['\"]?([^>'\"\s]*)['\"]?[^>]*>/ie", "'\$1'", $data["picurl"]);

				if ($config["action"] == "real") {
					if (empty($page) && !empty($data["picurl"]) && (C("upload_http") == 1)) {
						$Down = D("Down");
						$data["picurl"] = $Down->down_img($data["picurl"]);
					}

					if (empty($data["time"])) {
						$data["time"] = time();
					}
				}
			}

			return $data;
		}
		else {
			return -1;
		}
	}
}


