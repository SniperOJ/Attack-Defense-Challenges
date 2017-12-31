<?php
namespace Common\Action;
use Think\Action;
class AllAction extends Action
{
	public function _initialize()
	{
		header("Content-Type:text/html; charset=utf-8");
	}

	public function Lable_Ting_Type($param, $array_list)
	{
		$array_list["sid"] = 1;
		$array_list["list_page"] = $param["page"];

		if (1 < $param["page"]) {
			$array_list["title"] = $array_list["list_name"] . "-第" . $param["page"] . "页-" . C("site_name");
			$array_list["page"] = "第" . $param["page"] . "页";
		}
		else {
			$array_list["title"] = $array_list["list_name"] . "-" . C("site_name");
		}

		$array_list["thisurl"] = str_replace(array("{!page!}", "addtime", "_0_", "-0-", "lz--", "mcid--", "letter--", "area--", "order--", "year--", "xb--", "id--", "-p-1"), array($param["page"], "", "__", "--", ""), UU("Home-ting/type", array("id" => $array_list["list_id"], "listdir" => $array_list["list_dir"], "mcid" => $param["mcid"], "lz" => $param["lz"], "year" => $param["year"], "letter" => $param["letter"], "order" => $param["order"], "area" => $param["area"], "picm" => $param["picm"], "p" => "{!page!}"), true, false));

		if (empty($array_list["list_skin_type"])) {
			$array_list["list_skin_type"] = "gxl_tingtype";
		}

		return $array_list;
	}

	public function Lable_Ting_List($param, $array_list)
	{
		$array_list["sid"] = 1;
		$array_list["list_page"] = $param["page"];

		if (1 < $param["page"]) {
			$array_list["title"] = $array_list["list_name"] . "-第" . $param["page"] . "页-" . C("site_name");
			$array_list["page"] = "第" . $param["page"] . "页";
		}
		else {
			$array_list["title"] = $array_list["list_name"] . "-" . C("site_name");
		}

		$array_list["thisurl"] = str_replace("{!page!}", $param["page"], gxl_list_url("ting", array("id" => $array_list["list_id"], "listdir" => $array_list["list_dir"]), $param["page"]));

		if (empty($array_list["list_skin"])) {
			$array_list["list_skin"] = "gxl_tinglist";
		}

		if (empty($array_list["list_skin_type"])) {
			$array_list["list_skin_type"] = "gxl_tingtype";
		}

		return $array_list;
	}

	
	public function formate_download($ftps)
	{
		$array = explode("\r\n", $ftps);

		foreach ($array as $val ) {
			$result[] = explode("\$", $val);
		}

		foreach ($result as $val ) {
			$res["ftp_name"] = $val[0];
			$res["ftp_url"] = $val[1];
			$arr_download[] = $res;
		}

		return $arr_download;
	}

	public function Lable_Ting_Read($array, $array_play = false)
	{
		$array_list = list_search(F("_ppting/list"), "list_id=" . $array["ting_cid"]);
		
		$array["sid"] = 1;
		$array["title"] = $array["ting_name"] . "-" . C("site_name");
		$array["ting_readurl"] = gxl_data_url("ting", $array["ting_id"], $array["ting_cid"], $array["ting_name"], 1, $array["ting_jumpurl"], $array["ting_letters"]);
		$array["thisurl"] = gxl_data_url("ting", $array["ting_id"], $array["ting_cid"], $array["ting_name"], 1, $array["ting_jumpurl"], $array["ting_letters"]);
		$array["ting_playurl"] = gxl_play_url($array["ting_id"], 0, 1, $array["ting_cid"], $array["ting_name"]);
		$array["ting_picurl"] = gxl_img_url($array["ting_pic"], $array["ting_content"]);
		$array["ting_picurl_small"] = gxl_img_url_small($array["ting_pic"], $array["ting_content"]);
		$array["ting_rssurl"] = UU("Home-map/rss", array("id" => $array["ting_id"]), true, false);
		$array["ting_hits_insert"] = gxl_get_hits("ting", "insert", $array);
		$array["ting_hits_month"] = gxl_get_hits("ting", "ting_hits_month", $array);
		$array["ting_hits_week"] = gxl_get_hits("ting", "ting_hits_week", $array);
		$array["ting_hits_day"] = gxl_get_hits("ting", "ting_hits_day", $array);
		$lastemplateayurl = gxl_play_url_end($array["ting_url"], $array["ting_play"], C("hideplayer"));
		$array["ting_content"] = gxl_news_img_array($array["ting_content"], 2);
		$array["ting_lastname"] = $lastemplateayurl[2];
		$array["ting_lasturl"] = gxl_play_url($array["ting_id"], $lastemplateayurl[0], $lastemplateayurl[1], $array["ting_cid"], $array["ting_name"]);
		$array["ting_hits_day"] = getlistname($array["ting_cid"], "list_skin_detail");

		if ($array["ting_skin"]) {
			$array["ting_skin_detail"] = "" . trim($array["ting_skin"]);
			$array["ting_skin_play"] = "" . trim($array["ting_skin"]) . "_play";
		}
		else {
			$array["ting_skin_detail"] = (!empty($array_list[0]["list_skin_detail"]) ? "" . $array_list[0]["list_skin_detail"] : "gxl_ting");
			$array["ting_skin_play"] = (!empty($array_list[0]["list_skin_play"]) ? "" . $array_list[0]["list_skin_play"] : "gxl_play");
		}

		$array["ting_playlist"] = $this->gxl_playlist_all($array);
		$array["ting_playcount"] = count($array["ting_playlist"]);
		$array["ting_player"] = "var gxl_urls='" . $this->gxl_playlist_json(array($array["ting_name"], $array_list[0]["list_name"], $array_list[0]["list_url"]), $array["ting_playlist"]) . "';";
		ksort($array["ting_playlist"]);
		$arrays["show"] = $array_list[0];
		$array["ting_url"] = "";
		$array["Story"] = "";
		$array["Actor"] = "";
		$arrays["read"] = $array;
		
		return $arrays;
	}

	

	public function Lable_Ting_Play($array, $array_play, $createplayone)
	{
		$player = C("play_player");
		$player_here = explode("$\$\$", $array["ting_play"]);
		$array["ting_sid"] = $array_play["sid"];
		$array["ting_pid"] = $array_play["pid"];
		$array["ting_playname"] = $player_here[$array_play["sid"]];
		$array["ting_playername"] = $player[$array["ting_playname"]][1];
		$array["ting_playerkey"] = $player[$array["ting_playname"]][0];
		$array["thisurl"] = gxl_play_url($array["ting_id"], $array["ting_sid"], $array["ting_pid"], $array["ting_cid"], $array["ting_name"]);
		$array["ting_jiname"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"] - 1]["playname"];
		$array["ting_playpath"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"] - 1]["playpath"];
		$array["ting_nextpath"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"]]["playpath"];
		$array["ting_count"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][0]["playcount"];
		$array["fen"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"] - 1]["fen"];
		$array["miao"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"] - 1]["miao"];
		$array["laiyuan"] = $array["ting_playlist"][$array["ting_playerkey"] . "-" . $array_play["sid"]]["son"][$array_play["pid"] - 1]["laiyuan"];
		$array["title"] = "正在播放 " . $array["ting_name"] . "-" . $array["ting_jiname"] . "-" . C("site_name");
		$array["ting_hits_month"] = gxl_get_hits("ting", "ting_hits_month", $array, C("url_html_play"));
		$array["ting_hits_week"] = gxl_get_hits("ting", "ting_hits_week", $array, C("url_html_play"));
		$array["ting_hits_day"] = gxl_get_hits("ting", "ting_hits_day", $array, C("url_html_play"));
		return $array;
	}

	public function gxl_playlist_all($array)
	{
		if (empty($array["ting_url"])) {
			return false;
		}

		$playlist = array();
		$array_server = explode("$\$\$", $array["ting_server"]);
		$array_player = explode("$\$\$", $array["ting_play"]);
		$array_urllist = explode("$\$\$", $array["ting_url"]);
		$player = C("play_player");
		$server = C("play_server");

		foreach ($array_player as $sid => $val ) {
			$playlist[$player[$val][0] . "-" . $sid] = array("servername" => $array_server[$sid], "serverurl" => $server[$array_server[$sid]], "playername" => $player[$val][1], "playname" => $val, "son" => $this->gxl_playlist_one($array_urllist[$sid], $array["ting_id"], $sid, $array["ting_cid"], $array["ting_name"]));
		}

		return $playlist;
	}

	public function gxl_playlist_one($urlone, $id, $sid, $cid, $name)
	{
		$urllist = array();
		$array_url = explode(chr(13), str_replace(array("\r\n", "\n", "\r"), chr(13), $urlone));

		foreach ($array_url as $key => $val ) {
			if (0 < strpos($val, "\$")) {
				$ji = explode("\$", $val);
				$urllist[$key]["playname"] = trim($ji[0]);
				$urllist[$key]["playpath"] = trim($ji[1]);
				$urllist[$key]["fen"] = trim($ji[2]);
				$urllist[$key]["miao"] = trim($ji[3]);
				$urllist[$key]["laiyuan"] = trim($ji[4]);
			}
			else {
				$urllist[$key]["playname"] = "第" . ($key + 1) . "集";
				$urllist[$key]["playpath"] = trim($val);
			}

			$urllist[$key]["playurl"] = gxl_play_url($id, $sid, $key + 1, $cid, $name);
			$urllist[$key]["playcount"] = count($array_url);
		}
		$this->assign("playson",$urllist);
		
		return $urllist;
	}

	public function gxl_playlist_json($ting_info_array, $ting_url_array)
	{
		$key = 0;

		foreach ($ting_url_array as $val ) {
			$array_urls[$key]["servername"] = $val["servername"];
			$array_urls[$key]["playname"] = $val["playname"];

			foreach ($val["son"] as $keysub => $valsub ) {
				$array_urls[$key]["playurls"][$keysub] = array($valsub["playname"], $valsub["playpath"], $valsub["playurl"]);
			}

			$key++;
		}

		return json_encode(array("Ting" => $ting_info_array, "Data" => $array_urls));
	}

	public function Lable_News_List($param, $array_list)
	{
		$array_list["sid"] = 2;
		$array_list["list_wd"] = $param["wd"];
		$array_list["list_page"] = $param["page"];
		$array_list["list_letter"] = $param["letter"];
		$array_list["list_order"] = $param["order"];
		$array_list["thisurl"] = str_replace("{!page!}", $param["page"], gxl_list_url("news", array("id" => $array_list["list_id"], "listdir" => $array_list["list_dir"]), $param["page"]));

		if (1 < $param["page"]) {
			$array_list["title"] = $array_list["list_name"] . "-第" . $param["page"] . "页";
		}
		else {
			$array_list["title"] = $array_list["list_name"];
		}

		$array_list["title"] = $array_list["title"] . "-" . C("site_name");

		if (empty($array_list["list_skin"])) {
			$array_list["list_skin"] = "gxl_newslist";
		}

		return $array_list;
	}
	
	public function Lable_News_Read($array, $array_play = false)
	{
		$array_list = list_search(F("_ppting/list"), "list_id=" . $array["news_cid"]);
		$rs = M("News");
		$count = $rs->field("news_id")->count("news_id");

		if (!$count) {
			return false;
		}

		$array["sid"] = 2;
		$array["title"] = $array["news_name"] . "-" . C("site_name");
		$array["news_readurl"] = gxl_data_url("news", $array["news_id"], $array["news_cid"], $array["news_name"], 1, $array["news_jumpurl"]);
		$array["thisurl"] = gxl_data_url("news", $array["news_id"], $array["news_cid"], $array["news_name"], 1, $array["news_jumpurl"]);
		$array["news_picurl"] = gxl_img_url($array["news_pic"], $array["news_content"]);
		$array["news_picurl_small"] = gxl_img_url_small($array["news_pic"], $array["news_content"]);
		$array["news_hits_insert"] = gxl_get_hits("news", "insert", $array);
		$array["news_hits_month"] = gxl_get_hits("news", "news_hits_month", $array);
		$array["news_hits_week"] = gxl_get_hits("news", "news_hits_week", $array);
		$array["news_hits_day"] = gxl_get_hits("news", "news_hits_day", $array);
		$array["news_content"] = gxl_news_img_array($array["news_content"], 2);
		$contimg = C("news_images");

		if (!empty($contimg)) {
			$array["news_imgarry"] = gxl_img_url_array($array["news_content"]);
			$array["news_imgcount"] = count($array["news_imgarry"]);

			if ($contimg < $array["news_imgcount"]) {
				$array["news_content"] = gxl_news_imgs_array($array["news_content"]);
			}
		}

		if ($array["news_id"] != $count) {
			$array["news_next"] = gxl_data_url("news", $array["news_id"] + 1, $array["news_cid"], $array["news_name"], 1, $array["news_jumpurl"]);
			$next = getnews($array["news_id"] + 1);
			$array["news_next_name"] =  $next["news_name"];
			$array["news_next_picurl"] = gxl_img_url($next["news_pic"]);
			$array["news_next_small"] = gxl_img_url_small($next["news_pic"]);
			//print_r();die();
			//$array["news_next_picurl"] = gxl_img_url(return getnews($array["news_id"] + 1)["news_pic"]);
			//$array["news_next_small"] = gxl_img_url_small(return getnews($array["news_id"] + 1)["news_pic"]);
		}
		if ($array["news_id"] != 1) {
			$array["news_prev"] = gxl_data_url("news", $array["news_id"] - 1, $array["news_cid"], $array["news_name"], 1, $array["news_jumpurl"]);
			$prev = getnews($array["news_id"] - 1);
			$array["news_prev_name"] =  $prev["news_name"];
			$array["news_prev_picurl"] = gxl_img_url($prev["news_pic"]);
			$array["news_prev_small"] = gxl_img_url_small($prev["news_pic"]);
			//$array["news_prev_picurl"] = gxl_img_url(getnews($array["news_id"] - 1)["news_pic"]);
			//$array["news_prev_small"] = gxl_img_url_small(getnews($array["news_id"] - 1)["news_pic"]);
		}

		if ($array["news_skin"]) {
			$array["news_skin_detail"] = "" . trim($array["news_skin"]);
		}
		else {
			$array["news_skin_detail"] = (!empty($array_list["list_skin_detail"]) ? "" . $array_list["list_skin_detail"] : "gxl_news");
		}

		$rss = D("Newsrel");
		$where["newsrel_nid"] = $array["news_id"];
		$list_newsid = $rss->where($where)->order("newsrel_oid desc,newsrel_did desc")->select();

		foreach ($list_newsid as $key => $val ) {
			if (!empty($list_newsid[$key]["newsrel_did"])) {
				$list_news_id[] = $list_newsid[$key]["newsrel_did"];
			}

			if (!empty($list_newsid[$key]["newsrel_name"])) {
				$list_ting_name[] = $list_newsid[$key]["newsrel_name"];
			}
		}

		$list_array_id = implode(",", array_unique($list_news_id));
		$list_array_name = implode(",", array_unique($list_ting_name));
		unset($where);

		if (!empty($list_array_id)) {
			$search["newsrel_did"] = array("in", $list_array_id);
		}

		if (!empty($list_array_name)) {
			$search["newsrel_name"] = array("in", $list_array_name);
		}

		$search["_logic"] = "or";
		$where["_complex"] = $search;
		$list_news = $rss->where($where)->order("newsrel_oid desc")->select();

		foreach ($list_news as $key => $val ) {
			$news_array_id[] = $list_news[$key]["newsrel_nid"];
		}

		if (1 < count(array_unique($news_array_id))) {
			$array["news_xg"] = implode(",", array_unique($news_array_id));
		}

		unset($where);
		$where["newsrel_sid"] = 1;
		$where["newsrel_nid"] = $array["news_id"];
		$list_vid = $rss->where($where)->order("newsrel_oid desc,newsrel_did desc")->find();
		$array["ting_info"] = gettinginfo($list_vid["newsrel_did"], "ting_id,ting_anchor,ting_name,ting_pic,ting_author,ting_content,ting_cid,ting_year,ting_addtime,ting_letters,ting_title");
		$array["ting_readurl"] = gxl_data_url("ting", $list_vid["newsrel_did"], $array["ting_info"]["ting_cid"], $array["ting_info"]["ting_name"], 1, $array["ting_info"]["ting_jumpurl"], $array["ting_info"]["ting_letters"]);
		$array["ting_picurl"] = gxl_img_url($array["ting_info"]["ting_pic"]);
		$arrays["show"] = $array_list[0];
		$arrays["read"] = $array;
		return $arrays;
	}

	public function Lable_Special_List($param)
	{
		$array_list = array();
		$array_list["sid"] = 3;
		$array_list["special_skin"] = "gxl_speciallist";
		$array_list["special_page"] = $param["page"];
		$array_list["special_order"] = "special_" . $param["order"];
		$array_list["thisurl"] = str_replace("{!page!}", $param["page"], gxl_special_url($param["page"]));

		if (1 < $param["page"]) {
			$array_list["title"] = "专题列表-第" . $param["page"] . "页-" . C("site_name");
			$array_list["page"] = "-第" . $param["page"] . "页";
		}
		else {
			$array_list["title"] = "专题列表-" . C("site_name");
		}

		return $array_list;
	}

	public function Lable_Special_Read($array, $array_play = false)
	{
		$array_ids = array();
		$where = array();
		$array["special_readurl"] = gxl_data_url("special", $array["special_id"], 0, $array["special_name"], 1, 0, $array["special_letters"]);
		$array["thisurl"] = gxl_data_url("special", $array["special_id"], 0, $array["special_name"], 1, 0, $array["special_letters"]);
		$array["special_logo"] = gxl_img_url($array["special_logo"], $array["special_content"]);
		$array["special_banner"] = gxl_img_url($array["special_banner"], $array["special_content"]);
		$array["special_hits_insert"] = gxl_get_hits("special", "insert", $array);
		$array["special_hits_month"] = gxl_get_hits("special", "special_hits_month", $array);
		$array["special_hits_week"] = gxl_get_hits("special", "special_hits_week", $array);
		$array["special_hits_day"] = gxl_get_hits("special", "special_hits_day", $array);
		$array["special_skin"] = (!empty($array["special_skin"]) ? "" . $array["special_skin"] : "gxl_special");
		$array["title"] = $array["special_name"] . "-专题-" . C("site_name");
		$array["sid"] = 3;
		$rs = D("TopictingView");
		$where["topic_sid"] = 1;
		$where["topic_tid"] = $array["special_id"];
		$list_ting = $rs->where($where)->order("topic_oid desc,topic_did desc")->select();

		foreach ($list_ting as $key => $val ) {
			$list_ting[$key]["list_id"] = $list_ting[$key]["ting_cid"];
			$list_ting[$key]["list_name"] = getlistname($list_ting[$key]["list_id"], "list_name");
			$list_ting[$key]["list_url"] = getlistname($list_ting[$key]["list_id"], "list_url");
			$list_ting[$key]["ting_readurl"] = gxl_data_url("ting", $list_ting[$key]["ting_id"], $list_ting[$key]["ting_cid"], $list_ting[$key]["ting_name"], 1, $list_ting[$key]["ting_jumpurl"], $list_ting[$key]["ting_letters"]);
			$list_ting[$key]["ting_playurl"] = gxl_play_url($list_ting[$key]["ting_id"], 0, 1, $list_ting[$key]["ting_cid"], $list_ting[$key]["ting_name"]);
			$list_ting[$key]["ting_picurl"] = gxl_img_url($list_ting[$key]["ting_pic"], $list_ting[$key]["ting_content"]);
			$list_ting[$key]["ting_picurl_small"] = gxl_img_url_small($list_ting[$key]["ting_pic"], $list_ting[$key]["ting_content"]);
		}

		$rs = D("TopicnewsView");
		$where["topic_sid"] = 2;
		$where["topic_tid"] = $array["special_id"];
		$list_news = $rs->where($where)->order("topic_oid desc,topic_did desc")->select();

		foreach ($list_news as $key => $val ) {
			$list_news[$key]["list_id"] = $list_news[$key]["news_cid"];
			$list_news[$key]["list_name"] = getlistname($list_news[$key]["list_id"], "list_name");
			$list_news[$key]["list_url"] = getlistname($list_news[$key]["list_id"], "list_url");
			$list_news[$key]["news_readurl"] = gxl_data_url("news", $list_news[$key]["news_id"], $list_news[$key]["news_cid"], $list_news[$key]["news_name"], 1, $list_news[$key]["news_jumpurl"]);
			$list_news[$key]["news_picurl"] = gxl_img_url($list_news[$key]["news_pic"], $list_news[$key]["news_content"]);
			$list_news[$key]["news_picurl_small"] = gxl_img_url_small($list_news[$key]["news_pic"], $list_news[$key]["news_content"]);
		}

		$arrays["read"] = $array;
		$arrays["list_ting"] = $list_ting;
		$arrays["list_news"] = $list_news;
		return $arrays;
	}

	public function Lable_Search($param, $sidname = "ting")
	{
		$array_search = array();

		if ($sidname == "ting") {
			$array_search["search_actor"] = $param["actor"];
			$array_search["search_director"] = $param["director"];
			$array_search["search_area"] = $param["area"];
			$array_search["search_langaue"] = $param["langaue"];
			$array_search["search_year"] = $param["year"];
			$array_search["sid"] = 1;
		}
		else {
			$array_search["sid"] = 2;
		}

		$array_search["search_wd"] = $param["wd"];
		$array_search["search_name"] = $param["name"];
		$array_search["search_title"] = $param["title"];
		$array_search["search_page"] = $param["page"];
		$array_search["search_letter"] = $param["letter"];
		$array_search["search_order"] = $param["order"];
		$array_search["search_skin"] = "gxl_" . $sidname . "search";

		if (1 < $param["page"]) {
			$array_search["title"] = $array_search["search_wd"] . "-第" . $param["page"] . "页";
		}
		else {
			$array_search["title"] = $array_search["search_wd"];
		}

		$array_search["title"] = $array_search["search_area"] . $array_search["search_langaue"] . $array_search["search_actor"] . $array_search["search_director"] . $array_search["title"] . "-" . C("site_name");
		$array_search["thisurl"] = str_replace(array("{!page!}", "addtime", "_0_", "-0-", "lz--", "mcid--", "letter--", "area--", "order--", "year--", "xb--", "id--", "-p-1"), array($param["page"], "", "__", "--", ""), UU("Home-ting/search", array("wd" => $param["wd"], "p" => "{!page!}"), true, false));
		return $array_search;
	}

	

	public function Lable_Tags($param)
	{
		$array_tag = array();
		$array_tag["tag_name"] = $param["wd"];
		$array_tag["tag_url"] = gxl_tag_url($param["wd"]);
		$array_tag["tag_page"] = $param["page"];

		if (1 < $param["page"]) {
			$array_tag["title"] = $array_tag["tag_name"] . "-第" . $param["page"] . "页-" . C("site_name");
		}
		else {
			$array_tag["title"] = $array_tag["tag_name"] . "-" . C("site_name");
		}

		return $array_tag;
	}

	public function Lable_Index()
	{
		$array = array();
		$array["title"] = C("site_name");
		$array["model"] = "index";
		return $array;
	}

	public function Lable_Maps($mapname, $limit, $page)
	{
		$rs = M("Ting");
		$list = $rs->order("ting_addtime desc")->limit($limit)->page($page)->select();

		if ($list) {
			foreach ($list as $key => $val ) {
				$list[$key]["ting_readurl"] = gxl_data_url("ting", $list[$key]["ting_id"], $list[$key]["ting_cid"], $list[$key]["ting_name"], 1, $list[$key]["ting_jumpurl"], $list[$key]["ting_letters"]);
				$list[$key]["ting_playurl"] = gxl_play_url($list[$key]["ting_id"], 0, 1, $list[$key]["ting_cid"], $list[$key]["ting_name"]);
			}

			return $list;
		}

		return false;
	}

	

	public function Lable_Style()
	{
		$array = array();
		$array["model"] = strtolower(CONTROLLER_NAME);
		$array["action"] = strtolower(ACTION_NAME);
		C("TOKEN_ON", false);
		$array["root"] = __ROOT__ . "/";
		$array["template"] = $array["root"] . str_replace("./", "", C("VIEW_PATH") . C("default_theme")) . "/";
		$array["css"] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $array["template"] . "style.css\">\n";
		$array["sitename"] = C("site_name");
		$array["siteurl"] = C("site_url");
		$array["sitepath"] = C("site_path");
		$array["playwidth"] = C("play_width");
		$array["playheight"] = C("play_height");
		$array["sitehot"] = gxl_hot_key(C("site_hot"));
		$array["keywords"] = C("site_keywords");
		$array["description"] = C("site_description");
		$array["email"] = C("site_email");
		$array["copyright"] = C("site_copyright");
		$array["tongji"] = C("site_tongji");
		$array["murl"] = rtrim(C("m_url"), "/");
		$array["icp"] = C("site_icp");
		$array["hotkey"] = gxl_hot_key(C("site_hot"));
		$array["url_tag"] = UU("Home-tag/show");
		$array["url_guestbook"] = UU("Home-gb/show");
		$array["url_special"] = gxl_special_url(1);
		$array["url_map_rss"] = gxl_map_url("rss");
		$array["url_map_baidu"] = gxl_map_url("baidu");
		$array["url_map_google"] = gxl_map_url("google");
		$array["url_map_soso"] = gxl_map_url("soso");
		$array["list_slide"] = F("_ppting/slide");
		$array["list_link"] = F("_ppting/link");
		$array["list_menu"] = F("_ppting/listtree");
		$array["url_gbshow"] = UU("User-gb/show", "", true, false);
		$array["s_area"] = explode(",", C("play_area"));
		$array["s_language"] = explode(",", C("play_language"));
		$array["s_year"] = explode(",", C("play_year"));
		$array["s_picm"] = array("1", "2");
		$array["s_letter"] = range(A, Z);
		$array["s_order"] = array("addtime", "hits", "gold");
		$mbid = explode(",", C("site_mbid"));
		$array["newss_id"] = $mbid[5];
		$array["newss_hx"] = $mbid[6];
		$array["geturl"] = geturl();
		$array["apicss"] = cssurl();
		$array["hideplayer"] = C("hideplayer");
		$array["mobile_status"] = C("mobile_status");
		return $array;
	}
}


