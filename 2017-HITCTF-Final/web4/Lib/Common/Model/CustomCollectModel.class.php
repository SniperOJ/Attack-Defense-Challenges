<?php
namespace Common\Model;
use Think\Model;
class CustomCollectModel extends Model
{
	private $DB;
	private $CDB;
	private $VdoDB;
	private $ContDB;

	public function __construct()
	{
		$this->DB = D("co_node");
		$this->CDB = D("co_channel");
		$this->VdoDB = D("ting");
		$this->ContDB = D("co_content");
	}

	public function GetParam()
	{
		$data = $_POST["data"];
		$data["__hash__"] = $_POST["__hash__"];
		$data["urlpage"] = $_POST["urlpage" . $data["sourcetype"]];

		if ($data["picmode"] == "1") {
			$data["picurl_rule"] = $data["picurl1_rule"];
			$data["picurl_filter"] = $data["picurl1_filter"];
		}

		if (empty($data["direct"])) {
			$data["direct"] = 0;
		}

		if (empty($data["colmode"])) {
			$data["colmode"] = "";
		}

		return $data;
	}

	public function CheckParam($data)
	{
		$data["name"] = trim($data["name"]);

		if (empty($data["name"])) {
			$this->error = "采集节点项目名称为空！";
			return false;
		}

		if (!get_channel_son($data["cid"])) {
			$this->error = "请选择当前分类下面的子类栏目！";
			return false;
		}

		if (($data["menutype"] == "1") && ($data["cid"] == "0")) {
			$this->error = "请选择栏目分类！";
			return false;
		}

		return true;
	}

	public function Save($data)
	{
		if (is_array($data["fields"])) {
			$data["fields"] = array2string($data["fields"]);
		}

		if (empty($data["nid"])) {
			$data["lastdate"] = time();
		}

		if ($this->DB->create($data)) {
			if (!empty($data["nid"])) {
				$id = $this->DB->where("id=" . $data["nid"])->data($data)->save();
				$LastID = $data["nid"];
			}
			else {
				$id = $this->DB->add($data);
				$LastID = $id;
			}

			if ($id === "false") {
				return false;
			}

			$this->ColMemcache();
			return $LastID;
		}
		else {
			return false;
		}
	}

	public function ActionCheck()
	{
		if (isset($_GET["nid"])) {
			$nid = intval($_GET["nid"]);
		}
		else {
			return false;
		}

		if ($ArrSour = $this->NodeData($nid)) {
			return $ArrSour;
		}

		return false;
	}

	public function Copy($data)
	{
		$data["name"] = $_POST["name"];

		if (empty($data["name"])) {
			$this->error = "请输入新采集项目名称";
			return false;
		}

		if ($data) {
			$data["__hash__"] = $_POST["__hash__"];
			unset($data["id"]);
			$Result = $this->Save($data);

			if ($Result) {
				$this->ColMemcache();
				return true;
			}

			return false;
		}
	}

	public function ExpCode()
	{
		$Data = $this->ActionCheck();

		if ($Data) {
			return "BASE64:" . base64_encode(json_encode($Data)) . ":END";
		}

		return false;
	}

	public function SaveImport()
	{
		if ($_POST["importmode"] == "txt") {
			$filename = $_FILES["file"]["tmp_name"];

			if (strtolower(substr($_FILES["file"]["name"], -3, 3)) != "txt") {
				$this->error = "只支持导入txt格式文件";
				return false;
			}

			$StrData = @file_get_contents($filename);
			@unlink($filename);
		}
		else {
			$StrData = $_POST["txtcode"];
		}

		if ($StrData) {
			$Arr = explode(":", $StrData);
			$ArrData = json_decode(base64_decode($Arr[1]), true);

			if (!$ArrData) {
				return false;
			}

			$ArrData["__hash__"] = $_POST["__hash__"];
			unset($ArrData["id"]);
			unset($ArrData["lastdate"]);
			$Result = $this->Save($ArrData);
			$this->ColMemcache();
			return $Result;
		}
		else {
			return false;
		}
	}

	public function Del()
	{
		if (!empty($_GET["nid"])) {
			$where["id"] = $_GET["nid"];
			$this->DB->where($where)->delete();
			$this->ColMemcache();
			return true;
		}

		return false;
	}

	public function DelAll()
	{
		if (!empty($_POST["ids"])) {
			$where["id"] = array("in", $_POST["ids"]);
			$this->DB->where($where)->delete();
			$this->ColMemcache();
			return true;
		}

		return false;
	}

	public function DataShow($nid)
	{
		$Data = $this->NodeData($nid);

		foreach ($Data as $key => $val ) {
			if ($key != "fields") {
				$Data[$key] = htmlspecialchars($val);
			}
		}

		return $Data;
	}

	public function NodeData($nid)
	{
		$NodeData = $this->DB->where("id=" . $nid)->find();

		foreach ($NodeData as $key => $val ) {
			$NodeData[$key] = stripslashes($val);
		}

		if (isset($NodeData["fields"])) {
			$NodeData["fields"] = string2array($NodeData["fields"]);
		}

		return $NodeData;
	}

	public function ShowList()
	{
		$node_count = $this->DB->where($where)->count("id");
		$node_page = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$node_page = get_cms_page_max($node_count, C("url_num_admin"), $node_page);
		$node_url = U("ListShow", array("keyword" => urlencode($keyword), "p" => ""), false, false);
		$node_url = str_replace("?s=/", "?s=", $node_url);
		$pagelist = get_cms_page($node_count, C("url_num_admin"), $node_page, $node_url, "条记录");
		$_SESSION["node_reurl"] = $node_url . $node_page;
		$Node = $this->DB->field("id,name,sourcetype,urlpage,lastdate")->order("id desc")->limit(C("url_num_admin"))->page($node_page)->select();

		foreach ($Node as $key => $val ) {
			if ($val["sourcetype"] == "2") {
				$Node[$key]["urlpage"] = str_replace("\r\n", "<br/>", $val["urlpage"]);
			}
		}

		$ArrNode = array("node" => $Node, "pagelist" => $pagelist);
		return $ArrNode;
	}

	public function GetUrl()
	{
		$sourcetype = (isset($_GET["sourcetype"]) && intval($_GET["sourcetype"]) ? intval($_GET["sourcetype"]) : $this->error = "参数错误");
		$pagesize_start = (isset($_GET["pagesize_start"]) && intval($_GET["pagesize_start"]) ? intval($_GET["pagesize_start"]) : 1);
		$pagesize_end = (isset($_GET["pagesize_end"]) && intval($_GET["pagesize_end"]) ? intval($_GET["pagesize_end"]) : 1);
		$par_num = (isset($_GET["par_num"]) && intval($_GET["par_num"]) ? intval($_GET["par_num"]) : 1);
		$urlpage = (isset($_GET["urlpage"]) && trim($_GET["urlpage"]) ? str_replace("@", "/", trim($_GET["urlpage"])) : $this->error = $_GET["urlpage"] . "采集失败");

		while ($pagesize_start <= $pagesize_end) {
			$ArrUrl[] = str_replace("(*)", $pagesize_start, $urlpage);
			$pagesize_start = $pagesize_start + $par_num;
		}

		if (!empty($this->error)) {
			return false;
		}

		return $ArrUrl;
	}

	public function BaseArr()
	{
		$data = array("title" => "作品名称", "cname" => "栏目分类", "intro" => "备注", "time" => "更新时间", "mcid" => "关键词", "director" => "导演", "actor" => "主演", "content" => "剧情介绍", "picurl" => "图片", "area" => "地区分类", "language" => "语言/对白", "year" => "上映时间", "serial" => "连载信息");
		return $data;
	}

	public function FilterRules()
	{
		$rule = array("&lt;p&gt;" => "&lt;p([^&gt;]*)&gt;(.*)&lt;/p&gt;[|]", "&lt;a&gt;" => "&lt;a([^&gt;]*)&gt;(.*)&lt;/a&gt;[|]", "&lt;script&gt;" => "&lt;script([^&gt;]*)&gt;(.*)&lt;/script&gt;[|]", "&lt;iframe&gt" => "&lt;iframe([^&gt;]*)&gt;(.*)&lt;/iframe&gt;[|]", "&lt;table&gt;" => "&lt;table([^&gt;]*)&gt;(.*)&lt;/table&gt;[|]", "&lt;span&gt;" => "&lt;span([^&gt;]*)&gt;(.*)&lt;/span&gt;[|]", "&lt;b&gt;" => "&lt;b([^&gt;]*)&gt;(.*)&lt;/b&gt;[|]", "&lt;img&gt;" => "&lt;img([^&gt;]*)&gt;[|]", "&lt;object&gt;" => "&lt;object([^&gt;]*)&gt;(.*)&lt;/object&gt;[|]", "&lt;embed&gt;" => "&lt;embed([^&gt;]*)&gt;(.*)&lt;/embed&gt;[|]", "&lt;param&gt;" => "&lt;param([^&gt;]*)&gt;(.*)&lt;/param&gt;[|]", "&lt;div&gt;" => "&lt;div([^&gt;]*)&gt;[|]", "&lt;/div&gt;" => "&lt;/div&gt;[|]", "&lt;!-- --&gt;" => "&lt;!--([^&gt;]*)--&gt;[|]");
		return $rule;
	}

	public function ColMemcache()
	{
		$list = $this->DB->field("id,name")->order("id asc")->select();
		F("_ppting/ColNode", $list);
	}

	public function ChanlMemcache()
	{
		$list = $this->CDB->order("id asc")->select();

		foreach ($list as $k => $v ) {
			$list[$k]["cname"] = $v["cname"] . "_" . $v["nid"];
			unset($list[$k]["nid"]);
		}

		F("_ppting/Autochannel", $list);
	}

	public function ColChannelFolow($cname, $nid, $reid)
	{
		$find = get_channel999_id($cname, $nid);
		$ArrF = F("_ppting/channel_999");

		if ($find) {
			foreach ($find as $k => $v ) {
				$Cont = $this->ContDB->field("data")->where("id=" . $v["id"])->find();
				$rename = get_channel_name($reid);
				$Out = str_replace(array("\'cid\' => \'999\',", "\'" . $cname . "\'"), array("", "\'" . $rename . "\'"), $Cont["data"]);
				$Update = $this->ContDB->where("id=" . $v["id"])->save(array("data" => $Out));

				if ($Update === "false") {
					return false;
				}

				unset($ArrF[$v["id"]]);
			}

			F("_ppting/channel_999", $ArrF);
			return true;
		}
		else {
			return false;
		}
	}

	public function ChannelManage($act)
	{
		$Get = getReq($_REQUEST, array("cname" => "string", "reid" => "int", "nid" => "int"));

		foreach ($Get as $k => $v ) {
			$Get[$k] = trim($v);
		}

		$Get["cname"] = urldecode($Get["cname"]);
		$where["id"] = $_GET["id"];
		if (!empty($Get["reid"]) && !get_channel_son($Get["reid"])) {
			$this->error = "请选择当前分类下面的子类栏目！";
			return false;
		}

		if (($act == "add") || ($act == "update")) {
			if (empty($Get["cname"])) {
				$this->error = "要转换的 栏目 为空";
				return false;
			}

			if (empty($Get["reid"])) {
				$this->error = "请选择对应的系统栏目";
				return false;
			}

			$id = $this->CDB->field("id")->where($Get)->find();
			if ($id && ($id["id"] != $_GET["id"])) {
				$this->error = "重复设置";
				return false;
			}
		}

		switch ($act) {
		case $act:
			$id = $this->CDB->add($Get);

			if (!id) {
				return false;
			}

			break;

		case $act:
			$id = $this->CDB->where($where)->data($Get)->save();

			if (!id) {
				return false;
			}

			break;

		case $act:
			$this->CDB->where($where)->delete();
			break;

		default:
			break;
		}

		$this->ChanlMemcache();
		if (($act == "add") || ($act == "update")) {
			$up = $this->ColChannelFolow($Get["cname"], $Get["nid"], $Get["reid"]);

			if ($up) {
				return true;
			}
		}

		return true;
	}

	public function ChannelSearch()
	{
		if (!empty($_POST["search"])) {
			$Get = getReq($_REQUEST, array("cname" => "string", "reid" => "int", "nid" => "int"));

			foreach ($Get as $k => $v ) {
				if (!empty($v)) {
					$Param[$k] = trim($v);
				}
			}

			return $Param;
		}
	}

	public function ChannelList($where)
	{
		$count = $this->CDB->where($where)->count("id");
		$page = (!empty($_GET["p"]) ? intval($_GET["p"]) : 1);
		$page = get_cms_page_max($count, C("url_num_admin"), $page);
		$url = U("AutoChannel", array("cname" => $where["cname"], "reid" => $where["reid"], "nid" => $where["nid"], "p" => ""), false, false);
		$url = str_replace("?s=/", "?s=", $url);
		$pagelist = get_cms_page($count, C("url_num_admin"), $page, $url, "条记录");
		$_SESSION["reurl"] = $url . $page;
		$Arr = $this->CDB->where($where)->order("id desc")->limit(C("url_num_admin"))->page($page)->select();
		$CacheData = F("_ppting/channel_999");

		if (!empty($CacheData)) {
			foreach ($CacheData as $key => $val ) {
				$Cache[] = explode("_", $val["cname"]);
			}

			$Cache = array_unique($Cache);

			foreach ($Cache as $k => $v ) {
				$Cache[$k][1] = get_node_name($v[1]);
			}
		}

		$Result = array("arr" => $Arr, "cache" => $Cache, "pagelist" => $pagelist, "search" => $where);
		return $Result;
	}

	public function GetCname($getname, $nid = "0")
	{
		$cname = getlistid($getname);

		if (!$cname) {
			$cid = getlistid($getname);

			if ($cid) {
				$cname = get_channel_name($cid);
			}
			else {
				$cname = getlistid($getname);
			}
		}

		return $cname;
	}

	public function videoImport($url, $html, $nid = "")
	{
		$check = $this->UpCheck($url, $html, $nid, $datatype);

		if (!$check) {
			$this->error = $this->getError();
			return false;
		}
		else {
			if (!empty($html["cname"]) && (empty($html["ting_cid"]) || ($html["ting_cid"] == 999))) {
				if ($html["ting_cid"] == 999) {
					$cid = getlistid($html["cname"]);

					if ($cid) {
						$html["ting_cid"] = $cid;
					}
				}
				else {
					$html["ting_cid"] = getlistid($html["cname"]);
				}

				if (!$html["ting_cid"] || ($html["ting_cid"] == 999)) {
					$this->error = "没找到对应栏目，入库失败！";
					return false;
				}

				unset($html["cname"]);
			}

			$html["ting_reurl"] = $url;
			if (($check != "add") && ($check != "status")) {
				return $this->VideoSave($html, $nid, $check);
			}
			else {
				if ($check === "status") {
					$html["ting_status"] = -1;
				}

				return $this->VideoSave($html, $nid);
			}
		}
	}

	public function VideoSave(&$html, $nid, $id = "")
	{
		C("TOKEN_ON", false);

		if (!empty($id)) {
			$data["ting_name"] = $html["ting_name"];
			$data["ting_title"] = $html["ting_title"];
			$data["ting_keywords"] = $html["ting_keywords"];
			$data["ting_cid"] = $html["ting_cid"];
			$data["ting_continu"] = $html["ting_continu"];
			$data["ting_play"] = $html["ting_play"];
			$data["ting_server"] = $html["ting_server"];
			$data["ting_url"] = $html["ting_url"];
			$data["ting_addtime"] = time();
			$data["ting_reurl"] = $html["ting_reurl"];
			$data["ting_letter"] = getfirstchar($html["ting_name"]);

			if ($this->VdoDB->create($data)) {
				$sid = $this->VdoDB->where("ting_id=" . $id)->data($data)->save();

				if ($sid) {
					return true;
				}

				$this->error = $this->VdoDB->getDBError();
				return false;
			}
			else {
				$this->error = $this->VdoDB->getError();
				return false;
			}
		}
		else {
			$html["ting_addtime"] = time();
			$html["ting_stars"] = 1;
			$html["ting_letter"] = getfirstchar($html["ting_name"]);
			$html["ting_hits"] = 0;
			$html["ting_gold"] = 0;
			$html["ting_golder"] = 0;
			$html["ting_up"] = 0;
			$html["ting_down"] = 0;
			$html["ting_inputer"] = "互联网采集";
			$html["ting_mcid"] = D("Mcat")->getmcid($html["ting_cid"], $html["ting_mcid"]);
			$html["ting_letters"] = $this->getletters($html);
			$html["cname"] = get_replace_nb($html["cname"]);
			unset($html["cname"]);

			if ($this->VdoDB->create($html)) {
				$sid = $this->VdoDB->add($html);

				if ($sid) {
					return true;
				}

				$this->error = $this->VdoDB->getDBError();
				return false;
			}
			else {
				$this->error = $this->VdoDB->getError();
				return false;
			}
		}
	}

	public function getletters($ting)
	{
		$where = array();
		$ting_letters = gxl_pinyin($ting["ting_name"]);
		$where["ting_letters"] = $ting_letters;

		if (0 < $this->VdoDB->where($where)->count()) {
			$ting_letters = gxl_pinyin($ting["ting_name"], 1);
			$where["ting_letters"] = ting_letters;
			$i = 1;

			while (0 < $this->VdoDB->where($where)->count()) {
				$ting_letters = gxl_pinyin($ting["ting_name"], 1) . $i;
				$where["ting_letters"] = $ting_letters;
				$i++;
			}
		}

		return $ting_letters;
	}

	public function UpCheck($url, &$html, $nid)
	{
		if (empty($html["ting_name"]) || empty($html["ting_url"])) {
			$this->error = "作品名称或播放地址为空!";
			return false;
		}

		$html["ting_name"] = str_replace(array("HD", "BD", "DVD", "VCD", "TS", "【完结】", "【】", "[]", "()"), "", $html["ting_name"]);
		$html["ting_actor"] = str_replace(array(",", "/", "，", "|", "、"), " ", $html["ting_actor"]);
		$html["ting_director"] = str_replace(array(",", "/", "，", "|", "、"), " ", $html["ting_director"]);
		$ArrUrl = $this->VdoDB->where("ting_reurl='" . $url . "'")->find();

		if (!$ArrUrl) {
			$ArrTitle = $this->VdoDB->where("ting_name='" . $html["ting_name"] . "'")->find();

			if ($ArrTitle) {
				if ($this->InfoCheck($html, $ArrTitle)) {
					if ($this->BaseCheck($ArrTitle, $html)) {
						return $ArrTitle["ting_id"];
					}

					return false;
				}
			}

			if (C("play_collect_name")) {
				$len = ceil(strlen($html["ting_name"]) / 3) - intval(C("play_collect_name"));

				if (2 <= $len) {
					$like = msubstr($html["ting_name"], 0, $len);
					$where["ting_name"] = array("like", "%" . $like . "%");
					$ArrLike = $this->VdoDB->where($where)->find();
					if (!empty($html["ting_actor"]) && !empty($ArrLike["ting_actor"])) {
						$arr_actor_1 = explode(" ", $html["ting_actor"]);
						$arr_actor_2 = explode(" ", str_replace(array(",", "/", "，", "|", "、"), " ", $ArrLike["ting_actor"]));
						if (!array_diff($arr_actor_1, $arr_actor_2) && !array_diff($arr_actor_2, $arr_actor_1)) {
							if ($this->BaseCheck($ArrLike, $html)) {
								return $ArrLike["ting_id"];
							}
						}
					}

					if ($ArrLike && ($ArrLike["ting_inputer"] != "互联网采集")) {
						return "status";
					}

					return "add";
				}
			}

			return "add";
		}
		else {
			if ($this->BaseCheck($ArrUrl, $html)) {
				return $ArrUrl["ting_id"];
			}

			return false;
		}
	}

	public function InfoCheck(&$html, &$Arr)
	{
		if (empty($html["ting_actor"])) {
			return true;
		}

		if ($Arr["ting_actor"] == $html["ting_actor"]) {
			return true;
		}

		$arr_actor_1 = explode(" ", $html["ting_actor"]);
		$arr_actor_2 = explode(" ", str_replace(array(",", "/", "，", "|", "、"), " ", $Arr["ting_actor"]));

		if (array_intersect($arr_actor_1, $arr_actor_2)) {
			return true;
		}

		return false;
	}

	public function BaseCheck($data, &$html)
	{
		return true;

		if ("gxcms" == $data["inputer"]) {
			$this->error = "站长手动锁定，不需要更新!";
			return false;
		}

		$old_line = count(explode(chr(13), $data[$playurl]));
		$new_line = count(explode(chr(13), trim($html[$playurl])));

		if ($new_line < $old_line) {
			$this->error = "小于数据库集数，不需要更新!";
			return false;
		}

		return true;
	}
}


