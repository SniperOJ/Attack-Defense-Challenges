<?php
function UUU($model, $params, $redirect = true, $suffix = false)
{
	if (C("url_html")) {
		$reurl = str_replace("index.php?s=/", "index.php?s=", U($model, $params, $redirect, $suffix));
	}
	else {
		$reurl = str_replace("index.php?s=/", "?s=", U($model, $params, $redirect, $suffix));
	}

	return $reurl;
}

function baidutu($urls)
{
	if (is_array($urls)) {
		$urls = $urls;
	}
	else {
		$urls = array(rtrim(C("site_url"), "/") . $urls);
	}

	$api = C("baidu_tui");
	$ch = curl_init();
	$options = array(
		CURLOPT_URL            => $api,
		CURLOPT_POST           => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CONNECTTIMEOUT => 8,
		CURLOPT_TIMEOUT        => 6,
		CURLOPT_POSTFIELDS     => implode("\n", $urls),
		CURLOPT_HTTPHEADER     => array("Content-Type: text/plain")
		);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	$success = json_decode($result, true);
	curl_close($ch);

	if ($success["success"]) {
		return "百度数据推送<font color=red>" . $success["success"] . "</font>条，今日剩余<font color=red>" . $success["remain"] . "</font>条";
	}
	else {
		return "百度数据推送失败";
	}
}

function gxl_img_url_preg_news($file, $content, $number = 1)
{
	preg_match_all("/<img(.*?)src=\"(.*?)(?=\")/si", $content, $imgarr);
	preg_match_all("/(?<=src=\").*?(?=\")/si", implode("\" ", $imgarr[0]) . "\" ", $imgarr);
	$countimg = count($imgarr[0]);

	if ($countimg == 1) {
		return $imgarr[0][0];
	}

	foreach ($imgarr[0] as $key => $val ) {
		$pic = getimagesize($val);

		if ($pic[1] < $pic[0]) {
			return $val;
		}
	}

	return $imgarr[0][0];
}

function gxl_img_url_array($content)
{
	$contimg = C("news_images");
	preg_match_all("/<img(.*?)(?=>)/si", $content, $imgarr);

	foreach ($imgarr[0] as $key => $value ) {
		preg_match("/(?<=alt=\").*?(?=\")/si", $value, $title);
		preg_match("/(?<=src=\").*?(?=\")/si", $value, $imgurl);
		$array[$key]["img"] = $imgurl[0];
		$array[$key]["alt"] = $title[0];
	}

	$countarray = count($array);

	if ($contimg < $countarray) {
		return $array;
	}
}

function ThunderEncode($url)
{
	$thunderPrefix = "AA";
	$thunderPosix = "ZZ";
	$thunderTitle = "thunder://";
	$thunderUrl = $thunderTitle . base64_encode($thunderPrefix . $url . $thunderPosix);
	if ((strpos($url, "http://") !== false) || (strpos($url, "ftp://") !== false)) {
		return $thunderUrl;
	}
	else {
		return $url;
	}
}

function gxl_mcat_name($str, $cid)
{
	if (empty($str)) {
		return "未知";
	}

	$mcids = explode(",", $str);
	$html = "";

	foreach ($mcids as $v ) {
		$name = M("Mcat")->where("m_cid = $v")->getField("m_name");
		$html .= "$name ";
	}

	return $html;
}

function gxl_mcat_url($str, $cid, $k)
{
	if (empty($str)) {
		return "未知";
	}

	$mcids = explode(",", $str);
	$html = "";

	foreach ($mcids as $key => $v ) {
		if (!empty($k) && ($key == $k)) {
			break;
		}

		$url = UU("Home-ting/type", array("id" => $cid, "listdir" => getlistdir($cid), "mcid" => $v, "picm" => 1), true, false);
		$arr = list_search(F("_ppting/mcid"), "m_cid=" . $v);
		$html .= "<a href='" . $url . "' target='_blank'>{$arr[0]["m_name"]}</a> ";
	}

	return $html;
}

function gxl_mcat_title($str, $cid)
{
	if (empty($str)) {
		return "未知";
	}

	$mcids = explode(",", $str);
	$html = "";

	foreach ($mcids as $v ) {
		$name = M("Mcat")->where("m_cid = $v")->getField("m_name");
		$html .= "$name";
	}

	return $html;
}

function getlistmcat($cid)
{
	$tree = list_search(F("_ppting/mcat"), "list_id=" . $cid);

	if (!empty($tree[0]["son"])) {
		foreach ($tree[0]["son"] as $val ) {
			$param[] = $val;
		}

		return $param;
	}
	else {
		$catlist = D("Mcat")->list_cat($cid);
		return $catlist;
	}
}

function gxl_content_mcid_url($content, $array_tag = "", $cid, $Tag)
{
	$mcat = M("mcat");
	$list_mod = M("list");
	$arr = $list_mod->where("list_id='$cid'")->field("list_pid")->find();

	if ($arr["list_pid"] == "0") {
		$condition = $cid;
	}
	else {
		$condition = $arr["list_pid"];
	}

	if ($array_tag) {
		foreach ($array_tag as $key => $value ) {
			$mcid = $mcat->where("m_name='{$value["tag_name"]}' and m_list_id='$condition'")->getField("m_cid");
			$url = UU("Home-ting/type", array("id" => $cid, "listdir" => getlistdir($cid), "mcid" => $mcid, "picm" => 1), true, false);
			$content = str_replace($value["tag_name"], "<b><a target=\"_blank\" href=\"" . $url . "\">" . $value["tag_name"] . "</a></b>", $content);
		}
	}

	return $content;
}



function getactorurl($ting_cid, $ting_id, $ting_letters)
{
	$rs = M("Actor");
	$where["actor_vid"] = $ting_id;
	$list = $rs->field("actor_id")->where($where)->count("actor_id");

	if ($list) {
		return gxl_actor_url("actor", $ting_cid, $ting_id, $ting_letters, 1);
	}

	return false;
}

function get_id_by_tingid($id)
{
	$rs = M("Actor");
	$where["actor_id"] = $id;
	$list = $rs->field("actor_vid")->where($where)->limit(1)->select();

	if (isset($list[0])) {
		return $list[0]["actor_vid"];
	}

	return "";
}

function getnews($id, $field)
{
	$rs = M("News");
	$where["news_id"] = $id;
	$field = (!empty($field) ? $field : "*");
	$list = $rs->field($field)->where($where)->find();

	if ($list) {
		return $list;
	}

	return "";
}

function getactorinfo($id)
{
	$rs = M("Actor");
	$where["actor_vid"] = $id;
	$count = $rs->where($where)->count("actor_id");

	if ($count) {
		return 1;
	}
}

function getactorvid($name)
{
	$rs = M("Actor");
	$where["actor_star"] = $name;
	$list = $rs->where($where)->field("actor_vid")->limit(1)->select();

	foreach ($list as $val ) {
		$arr["actor_vid"][] = $val["actor_vid"];
	}

	$arrayvid = implode(",", $arr["actor_vid"]);

	if ($arrayvid) {
		return $arrayvid;
	}
}

function gettingmcid($id, $arry)
{
	$rs = M("Mcid");
	$where["mcid_tingid"] = $id;
	$mcid = $rs->field("mcid_mid")->where($where)->limit(1)->select();

	if (isset($mcid)) {
		foreach ($mcid as $key => $value ) {
			$mcid[$key] = $value["mcid_mid"];
		}

		if (!empty($arry)) {
			return $mcid;
		}
		else {
			$mcid = implode(",", $mcid);
			return $mcid;
		}
	}
	else {
		return "";
	}
}

function getlistdir($cid)
{
	$arr = list_search(F("_ppting/list"), "list_id=" . $cid);

	if (empty($arr)) {
		return 0;
	}
	else {
		return $arr[0]["list_dir"];
	}
}

function gettingpinyin($id)
{
	$rs = M("Ting");
	$where["ting_id"] = $id;
	$list = $rs->where($where)->getField("ting_letters");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function gettvpinyin($id)
{
	$rs = M("Tv");
	$where["tv_id"] = $id;
	$list = $rs->where($where)->getField("tv_letters");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function gettvid($pinyin)
{
	$rs = M("Tv");
	$where["tv_letters"] = $pinyin;
	$list = $rs->where($where)->getField("tv_id");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function get_id_ting_name($id)
{
	$rs = M("Ting");
	$where["ting_id"] = $id;
	$list = $rs->field("ting_name")->where($where)->limit(1)->select();

	if (!empty($list[0])) {
		return $list[0]["ting_name"];
	}

	return "";
}

function gettingid($id)
{
	$rs = M("Ting");
	$where["ting_letters"] = $id;
	$list = $rs->where($where)->getField("ting_id");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function gettingname($name)
{
	$rs = M("Ting");
	$where["ting_name"] = $name;
	$list = $rs->where($where)->getField("ting_id");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function getlistpid($id)
{
	$list_mod = M("list");
	$arr = $list_mod->where("list_id='$id'")->field("list_pid")->find();

	if ($arr["list_pid"] == "0") {
		$condition = $id;
	}
	else {
		$condition = $arr["list_pid"];
	}

	return $condition;
}

function gettingcid($id)
{
	$rs = M("Ting");
	$where["ting_id"] = $id;
	$list = $rs->where($where)->getField("ting_cid");

	if (isset($list)) {
		return $list;
	}

	return "";
}

function get_id_by_name($name)
{
	$rs = M("Ting");
	$where["ting_letters"] = $name;
	$list = $rs->field("ting_id")->where($where)->limit(1)->select();

	if (isset($list[0])) {
		return $list[0]["ting_id"];
	}

	return "";
}

function gettingidmd($id)
{
	$rs = M("Ting");
	$where["ting_letters"] = $id;
	$list = $rs->where($where)->getField("ting_id");
	if (!empty($list) && intval($list)) {
		$list = md5($list);
		return $list;
	}

	return "";
}

function getmd5($id)
{
	if (!empty($id) && intval($id)) {
		$id = md5($id);
		return $id;
	}

	return "";
}

function gediridmd($id)
{
	$rs = M("List");
	$where["list_dir"] = $id;
	$list = $rs->where($where)->getField("list_id");
	if (!empty($list) && intval($list)) {
		$list = md5($list);
		return $list;
	}

	return "";
}

function gelistdir_id($id)
{
	$rs = M("List");
	$where["list_id"] = $id;
	$list = $rs->where($where)->getField("list_dir");

	if (!empty($list)) {
		return $list;
	}

	return "";
}

function getsppinyin($id)
{
	$rs = M("Special");
	$where["special_id"] = $id;
	$list = $rs->where($where)->getField("special_letters");

	if (!empty($list)) {
		return $list;
	}

	return "";
}

function get_sp_id_by_name($name)
{
	$rs = M("Special");
	$where["special_letters"] = $name;
	$list = $rs->field("special_id")->where($where)->limit(1)->select();

	if (!empty($list[0])) {
		return $list[0]["special_id"];
	}

	return "";
}

function get_id_by_dir($dir)
{
	$arr = list_search(F("_ppting/list"), "list_dir=" . $dir);

	if (empty($arr)) {
		return 0;
	}
	else {
		return $arr[0]["list_id"];
	}
}


function gettinginfo($id, $field = "ting_name")
{
	$rs = M("Ting");
	$where["ting_id"] = $id;
	$list = $rs->field($field)->where($where)->find();

	if (!empty($list)) {
		return $list;
	}

	return "";
}

function getlistall($pid)
{
	$tree = list_search(F("_ppting/listtree"), "list_id=" . $pid);

	if (!empty($tree[0]["son"])) {
		foreach ($tree[0]["son"] as $val ) {
			$param[] = $val;
		}

		return $param;
	}
	else {
		$ting_type = M("list")->where(array("list_pid" => 2))->select();
		return $ting_type;
	}
}
function getall($pid)
{
	$tree = list_search(F("_ppting/listtree"), "list_id=" . $pid);

	if (!empty($tree[0]["son"])) {
		foreach ($tree[0]["son"] as $val ) {
			$param[] = $val;
		}

		return $param;
	}

}
function getweek($id, $type)
{
	$weekarray = array("1", "2", "3", "4", "5", "6", "7");
	$weekarraypy = array("zhouyi", "zhouer", "zhousan", "zhousi", "zhouwu", "zhouliu", "zhouri");

	if ($type) {
		foreach ($weekarraypy as $key => $value ) {
			if ($value == $id) {
				return $weekarray[$key];
			}
		}
	}
	else {
		foreach ($weekarray as $key => $value ) {
			if ($value == $id) {
				return $weekarraypy[$key];
			}
		}
	}
}

function gettvurl($name, $label = "span", $k)
{
	$rs = M("Tv");
	$names = explode(",", trim($name));

	if (1 < count($names)) {
		$where["tv_name"] = array("in", $name);
	}
	else {
		$where["tv_name"] = $name;
	}

	$week = str_replace("0", "7", date("w"));
	$list = $rs->field("tv_id,tv_cid,tv_name")->where($where)->select();
	$html = "";

	if (!empty($list)) {
		foreach ($list as $key => $value ) {
			$url = gxl_tv_url($list[$key]["tv_id"], $list[$key]["tv_cid"], $week);

			if ($label == "no") {
				$html .= "<a href='" . $url . "' target='_blank'>{$list[$key]["tv_name"]}</a>";
			}
			else {
				$html .= "<" . $label . "><a href='" . $url . "' target='_blank'>{$list[$key]["tv_name"]}</a></" . $label . ">";
			}
		}
	}

	return $html;
}

function gettingurl($name, $type)
{
	$rs = M("Ting");
	$where["ting_name"] = $name;
	$where["ting_status"] = array("eq", 1);
	$list = $rs->field("ting_id,ting_cid,ting_letters,ting_name,ting_jumpurl")->where($where)->limit(1)->order("ting_addtime desc")->select();
	if (empty($list[0]) && !empty($type)) {
		unset($where);
		$where["ting_name"] = array("like", $name . "%");
		$where["ting_status"] = array("eq", 1);
		$list = $rs->field("ting_id,ting_cid,ting_letters,ting_name,ting_jumpurl")->where($where)->limit(1)->order("ting_addtime desc")->select();
	}

	if (!empty($list[0])) {
		return gxl_data_url("ting", $list[0]["ting_id"], $list[0]["ting_cid"], $list[0]["ting_name"], 1, $list[0]["ting_jumpurl"], $list[0]["ting_letters"]);
	}

	return "";
}



function getcountting($cid)
{
	$where = array();
	$rs = M("Ting");
	$where["ting_cid"] = $cid;
	$where["ting_addtime"] = array("gt", getxtime(1));
	$count = $rs->where($where)->count("ting_id");
	return $count + 0;
}

function commentcount($ting_id)
{
	$rs = M("Comment");
	$where = array();
	$where["ting_id"] = $ting_id;
	$where["ispass"] = 1;
	$count = $rs->where($where)->count("comment_id");
	return $count;
}

function getarraypic($contents)
{
	if ($contents == NULL) {
		return false;
	}

	preg_match_all("/<img(.*?)src=\"(.*?)(?=\")/si", $contents, $imgarr);
	preg_match_all("/(?<=src=\").*?(?=\")/si", implode("\" ", $imgarr[0]) . "\" ", $imgarr);

	if (is_array($imgarr[0])) {
		return $imgarr[0];
	}

	return false;
}

function gxl_news_img_array($content, $type)
{
	$prefix = C("upload_http_prefix");

	if ($content == NULL) {
		return false;
	}

	preg_match_all("/<img(.*?)src=\"(.*?)(?=\")/si", $content, $imgarr);
	preg_match_all("/(?<=src=\").*?(?=\")/si", implode("\" ", $imgarr[0]) . "\" ", $imgarr);

	if (is_array($imgarr[0])) {
		$picarray = $imgarr[0];
	}

	$pathArr = array();

	foreach ($picarray as $key => $value ) {
		if (0 < strpos($value, "://")) {
			$pathArr[] = $value;
		}
		else if ($type == 1) {
			$pathArr[] = str_replace(C("site_path") . C("upload_path") . "/", "", $value);
		}
		else {
			if (($type == 2) && !empty($prefix)) {
				$pathArr[] = $prefix . $value;
			}
			else {
				$pathArr[] = C("site_path") . C("upload_path") . "/" . $value;
			}
		}
	}

	if (is_array($pathArr)) {
		return str_ireplace($picarray, $pathArr, $content);
	}

	return $content;
}

function gxl_news_imgs_array($content)
{
	$content = preg_replace("/<img(.*?)>/si", "", $content);
	return $content;
}



function gettimenew($type = "Y-m-d H:i:s", $time, $color = "red", $new = "<img src=\"/Public/images/new.gif\">")
{
	if (86400 < (time() - $time)) {
		return date($type, $time);
	}
	else {
		return "<i><font color=\"" . $color . "\">" . date($type, $time) . "</font></i>" . $new . "";
	}
}

function gettimetingnew($type = "Y-m-d H:i:s", $time, $color = "red", $new = "<span class=\"new\"></span>")
{
	if (86400 < (time() - $time)) {
		return NULL;
	}
	else {
		return "" . $new . "";
	}
}

function gxl_director_url($str, $type = "director", $sidname = "ting", $action = "search")
{
	$array = array();
	$str = str_replace(array("/", "|", ",", "，"), " ", $str);
	$arr = explode(" ", $str);

	foreach ($arr as $key => $val ) {
		$array[$key] = "<a href=\"" . UU("Home-" . $sidname . "/" . $action, array($type => urlencode($val)), true, false) . "\" target=\"_blank\">" . $val . "</a>";
	}

	return implode(" ", $array);
}

function cssurl()
{
	if (C("site_cssjsurl")) {
		$useurl = C("site_cssjsurl");
	}
	else {
		$useurl = C("site_path");
	}

	return $useurl;
}

function geturl()
{
	return rtrim(C("site_url"), "/") . C("site_path");
}

function quickSendMail($address, $title, $message)
{
	$mailsetting = F("_user/mailsetting");

	if ($mailsetting) {
		$setting = array("MAIL_ADDRESS" => $mailsetting["mail_from"], "MAIL_SMTP" => $mailsetting["mail_server"], "MAIL_LOGINNAME" => $mailsetting["mail_user"], "MAIL_PASSWORD" => $mailsetting["mail_password"], "MAIL_PORT" => $mailsetting["mail_port"]);
		return SendMail($address, $title, $message, $setting, $mailsetting["mail_user"]);
	}

	return "错误原因: 没有找到发送服务器";
}

function SendMail($address, $title, $message, $mailSetting, $sender = "")
{
	vendor("Email.class#phpmailer");
	$mail = new phpmailer();
	$mail->IsSMTP();
	$mail->CharSet = "UTF-8";
	$mail->AddAddress($address);
	$mail->Body = $message;
	$mail->From = $mailSetting["MAIL_ADDRESS"];
	$mail->FromName = $sender;
	$mail->Subject = $title;
	$mail->Host = $mailSetting["MAIL_SMTP"];
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "";
	$mail->Username = $mailSetting["MAIL_LOGINNAME"];
	$mail->Port = $mailSetting["MAIL_PORT"];
	$mail->IsHTML(true);
	$mail->Password = $mailSetting["MAIL_PASSWORD"];

	if ($mail->Send()) {
		return true;
	}
	else {
		return "错误原因: " . $mail->ErrorInfo;
	}
}

function safe_replace($string)
{
	$string = str_replace("%20", "", $string);
	$string = str_replace("%27", "", $string);
	$string = str_replace("%2527", "", $string);
	$string = str_replace("*", "", $string);
	$string = str_replace("\"", "&quot;", $string);
	$string = str_replace("'", "", $string);
	$string = str_replace("\"", "", $string);
	$string = str_replace(";", "", $string);
	$string = str_replace("<", "&lt;", $string);
	$string = str_replace(">", "&gt;", $string);
	$string = str_replace("{", "", $string);
	$string = str_replace("}", "", $string);
	$string = str_replace("\\", "", $string);
	return $string;
}

function get_replace_input($str, $rptype = 0)
{
	$str = stripslashes($str);
	$str = htmlspecialchars($str);
	$str = get_replace_nb($str);
	return addslashes($str);
}

function get_replace_nr($str)
{
	$str = str_replace(array("<nr/>", "<rr/>"), array("\n", "\r"), $str);
	return trim($str);
}

function get_replace_nb($str)
{
	$str = str_replace("&nbsp;", " ", $str);
	$str = str_replace("　", " ", $str);
	$str = ereg_replace("[\r\n\t ]{1,}", " ", $str);
	return trim($str);
}

function get_cms_page_max($count, $limit, $page)
{
	$totalPages = ceil($count / $limit);

	if ($totalPages < $page) {
		$page = $totalPages;
	}

	return $page;
}

function get_cms_page($totalrecords, $pagesize, $currentpage, $params, $filename = "条数据", $pagego = true, $halfPer = 5)
{
	$page["totalrecords"] = $totalrecords;
	$page["totalpages"] = ceil($page["totalrecords"] / $pagesize);
	$page["currentpage"] = $currentpage;
	$page["urlpage"] = $params . "{!page!}";
	$page["listpages"] = "";

	if ($pagego) {
		$pagego = "jumpurl('" . $page["urlpage"] . "'," . $page["totalpages"] . ")";
	}

	$page["listpages"] .= get_cms_page_css($page["currentpage"], $page["totalpages"], $halfPer, $page["urlpage"], $pagego);
	return $page;
}

function get_cms_page_css($currentPage, $totalPages, $halfPer = 5, $url, $pagego)
{
	$linkPage .= (1 < $currentPage ? "<a href=\"" . str_replace("{!page!}", 1, $url) . "\" class=\"pagegbk\" target=\"_self\">首页</a>&nbsp;<a href=\"" . str_replace("{!page!}", $currentPage - 1, $url) . "\" class=\"pagegbk\" target=\"_self\">上一页</a>&nbsp;" : "<em>首页</em>&nbsp;<em>上一页</em>&nbsp;");
	$i = $currentPage - $halfPer;
	(1 < $i) || ($i = 1);
	$j = $currentPage + $halfPer;
	($j < $totalPages) || ($j = $totalPages);

	for (; $i < ($j + 1); $i++) {
		$linkPage .= ($i == $currentPage ? "<span>" . $i . "</span>&nbsp;" : "<a href=\"" . str_replace("{!page!}", $i, $url) . "\" target=\"_self\">" . $i . "</a>&nbsp;");
	}

	$linkPage .= ($currentPage < $totalPages ? "<a href=\"" . str_replace("{!page!}", $currentPage + 1, $url) . "\" class=\"pagegbk\" target=\"_self\">下一页</a>&nbsp;<a href=\"" . str_replace("{!page!}", $totalPages, $url) . "\" class=\"pagegbk\" target=\"_self\">尾页</a>" : "<em>下一页</em>&nbsp;<em>尾页</em>");

	if (!empty($pagego)) {
		$linkPage .= "&nbsp;<input type=\"input\" name=\"page\" id=\"page\" class=\"pageinput\"/><input type=\"button\" value=\"跳 转\" onclick=\"" . $pagego . "\" class=\"pagebg\"/>";
	}

	return str_replace("_1" . C("html_file_suffix"), C("html_file_suffix"), str_replace("index1" . C("html_file_suffix"), "", $linkPage));
}

function checkbox($array = array(), $id = "", $str = "", $defaultvalue = "", $width = 0, $field = "")
{
	$string = "";
	$id = trim($id);

	if ($id != "") {
		$id = (strpos($id, ",") ? explode(",", $id) : array($id));
	}

	if ($defaultvalue) {
		$string .= "<input type=\"hidden\" " . $str . " value=\"-99\">";
	}

	$i = 1;

	foreach ($array as $key => $value ) {
		$key = trim($key);
		$checked = ($id && in_array($key, $id) ? "checked" : "");

		if ($width) {
			$string .= "<label class=\"ib\" style=\"width:" . $width . "px\">";
		}

		$string .= "<input type=\"checkbox\" " . $str . " id=\"" . $field . "_" . $i . "\" " . $checked . " value=\"" . htmlspecialchars($key) . "\"> " . htmlspecialchars($value);

		if ($width) {
			$string .= "</label>";
		}

		$i++;
	}

	return $string;
}

function url_check($url, $baseurl, $config)
{
	$urlinfo = parse_url($baseurl);
	$baseurl = $urlinfo["scheme"] . "://" . $urlinfo["host"] . (substr($urlinfo["path"], -1, 1) === "/" ? substr($urlinfo["path"], 0, -1) : str_replace("\\", "/", dirname($urlinfo["path"]))) . "/";

	if (strpos($url, "://") === false) {
		if ($url[0] == "/") {
			$url = $urlinfo["scheme"] . "://" . $urlinfo["host"] . $url;
		}
		else if ($config["page_base"]) {
			$url = $config["page_base"] . $url;
		}
		else {
			$url = $baseurl . $url;
		}
	}

	return $url;
}

function get_html($url, &$config)
{
	if (!get_headers($url)) {
		return false;
	}

	$ctx = stream_context_create(array(
	"http" => array("timeout" => 30)
	));
	if (!empty($url) && ($html = @file_get_contents($url, 0, $ctx))) {
		if (($syscharset != $config["sourcecharset"]) && ($config["sourcetype"] != 4)) {
			$html = iconv($config["sourcecharset"], "utf-8", $html);
		}

		return $html;
	}
	else {
		return false;
	}
}

function cut_html($html, $start, $end)
{
	if (empty($html)) {
		return false;
	}

	$html = str_replace(array("\r", "\n"), "", $html);
	$start = str_replace(array("\r", "\n"), "", $start);
	$end = str_replace(array("\r", "\n"), "", $end);
	$start = stripslashes($start);
	$end = stripslashes($end);

	if (!empty($start)) {
		$html = explode(trim($start), $html);
	}

	if (!empty($end) && is_array($html)) {
		$html = explode(trim($end), $html[1]);
		return $html[0];
	}
	else {
		return $html;
	}
}

function replace_sg($html)
{
	$list = explode("[内容]", $html);

	if (is_array($list)) {
		foreach ($list as $k => $v ) {
			$list[$k] = str_replace(array("\r", "\n"), "", trim($v));
		}
	}

	return $list;
}

function replace_item($html, $config)
{
	if (empty($config)) {
		return $html;
	}

	$config = explode("\n", $config);
	$patterns = $replace = array();
	$p = 0;

	foreach ($config as $k => $v ) {
		if (empty($v)) {
			continue;
		}

		$c = explode("[|]", $v);
		$patterns[$k] = "/" . str_replace("/", "\/", $c[0]) . "/i";
		$replace[$k] = $c[1];
		$p = 1;
	}

	return $p ? @preg_replace($patterns, $replace, $html) : false;
}

function Doaddslashes($str)
{
	if (!is_array($str)) {
		return addslashes($str);
	}

	foreach ($str as $key => $val ) {
		$str[$key] = Doaddslashes($val);
	}

	return $str;
}

function Dostripslashes($str)
{
	if (!is_array($str)) {
		return stripslashes($str);
	}

	foreach ($str as $key => $val ) {
		$str[$key] = Dostripslashes($val);
	}

	return $str;
}

function string2array($data)
{
	if (is_array($data)) {
		return $data;
	}

	if ($data == "") {
		return array();
	}

	$data = dostripslashes($data);
	@eval("\$array = $data;");
	return $array;
}

function array2string($data, $isformdata = 1)
{
	if ($data == "") {
		return "";
	}

	if ($isformdata) {
		$data = dostripslashes($data);
	}

	return addslashes(var_export($data, true));
}

function download_img($old, $out)
{
	if (!empty($old) && !empty($out) && (strpos($out, "://") === false)) {
		return str_replace($out, url_check($out, $url, $config), $old);
	}
	else {
		return $old;
	}
}

function str_replace_all($data)
{
	$out = str_replace(array("(", ")", "[", "]", ".", "*", "/", "?", "+", "\$"), array("\(", "\)", "\[", "\]", "\.", ".*?", "\/", "\?", "\+", "\\\$"), $data);
	return $out;
}

function get_syschannel_id($cname, $type = "list_id")
{
	$arr = list_search(F("_ppting/list"), "list_name=" . $cname);
	if (is_array($arr) && !empty($arr)) {
		return $arr[0][$type];
	}
	else {
		return false;
	}
}

function get_channel_id($cname, $type = "list_id")
{
	$arr = list_search(F("_ppting/list"), "list_name=" . $cname);
	if (is_array($arr) && !empty($arr)) {
		return $arr[0][$type];
	}
	else {
		$arr = list_search(F("_ppting/list"), "list_name=/" . mb_substr($cname, 0, 2, "utf-8") . "([\s\S]*?)/");
		if (is_array($arr) && !empty($arr)) {
			return $arr[0][$type];
		}
		else {
			return false;
		}
	}
}

function get_Autochannel_id($cname, $nid, $type = "reid")
{
	$arr = list_search(F("_ppting/Autochannel"), "cname=" . $cname . "_" . $nid);
	if (is_array($arr) && !empty($arr)) {
		return $arr[0][$type];
	}
	else {
		$arr = list_search(F("_ppting/Autochannel"), "cname=" . $cname . "_0");
		if (is_array($arr) && !empty($arr)) {
			return $arr[0][$type];
		}
		else {
			return false;
		}
	}
}

function get_channel999_id($cname, $nid = "0")
{
	if ($nid == "0") {
		$str = "cname=/" . $cname . "_([\s\S]*?)/";
	}
	else {
		$str = "cname=" . $cname . "_" . $nid;
	}

	$arr = list_search(F("_ppting/channel_999"), $str);
	if (is_array($arr) && !empty($arr)) {
		return $arr;
	}
	else {
		return false;
	}
}

function get_node_name($nid, $type = "name")
{
	$arr = list_search(F("_ppting/ColNode"), "id=" . $nid);

	if (is_array($arr)) {
		return $arr[0][$type];
	}
	else {
		return $nid;
	}
}

function get_channel_son($pid)
{
	$tree = list_search(F("_ppting/list"), "list_id=" . $pid);

	if (!empty($tree[0]["son"])) {
		return false;
	}
	else {
		return true;
	}
}

function getReq($a1, $a2)
{
	$a = array();

	foreach ($a2 as $key => $row ) {
		if (isset($a1[$key])) {
			if ($row == "string") {
				$a[$key] = $a1[$key];
			}
			else {
				$a[$key] = intval($a1[$key]);
			}
		}
		else if ($row == "string") {
			$a[$key] = "";
		}
		else {
			$a[$key] = 0;
		}
	}

	return $a;
}

function get_small_id($id)
{
	if ($id) {
		return floor($id / 1000);
	}
}

function get_small_id_by_name($name)
{
	$id = get_id_by_name($name);
	return get_small_id($id);
}

function get_star_id_by_name($name)
{
	$id = get_id_star_name($name);
	return get_small_id($id);
}

function get_replace_html($str, $start = 0, $length, $charset = "utf-8", $suffix = false)
{
	return msubstr(eregi_replace("<[^>]+>", "", ereg_replace("[\r\n\t ]{1,}", " ", get_replace_nb($str))), $start, $length, $charset, $suffix);
}

function gxl_ting_news_url($sid, $cid, $id, $pinyin, $page)
{
	if (C("url_html")) {
		$readurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_ting_news_url_dir($sid, $cid, $id, $pinyin, $page) . C("html_file_suffix"));
		return $readurl;
	}
	else {
		$arrurl["id"] = $id;
		$arrurl["pinyin"] = $pinyin;
		$arrurl["listid"] = $cid;
		$arrurl["listdir"] = getlistname($cid, "list_dir");
	}

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-ting/news", $arrurl, true, false);
}

function gxl_ting_news_url_dir($sid, $cid, $id, $pinyin, $page)
{
	if ("news" == $sid) {
		$datadir = str_storyred_dir(C("url_tingnewsdata"), $cid, $id, $pinyin, $page);
	}

	if (1 < $page) {
		$datadir .= "-{!page!}";
	}

	return $datadir;
}

function gxl_star_url($sid, $id, $pinyin, $page)
{
	if (C("url_html")) {
		if ("show" == $sid) {
			$readurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_star_url_dir($sid, $id, $pinyin, $page) . C("html_file_suffix"));
		}
		else {
			$readurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_star_url_dir($sid, $id, $pinyin, $page) . C("html_file_suffix"));
		}

		return $readurl;
	}

	if ("show" == $sid) {
	}
	else {
		$arrurl["id"] = $id;
		$arrurl["pinyin"] = $pinyin;
	}

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-star/" . $sid . "", $arrurl, true, false);
}

function gxl_star_url_dir($sid, $id, $pinyin, $page)
{
	if ("show" == $sid) {
		$datadir = str_star_dir(C("url_starlist"), $id, $pinyin, $page);
	}
	else if ("work" == $sid) {
		$datadir = str_star_dir(C("url_starwork"), $id, $pinyin, $page);
	}
	else {
		$datadir = str_star_dir(C("url_stardata"), $id, $pinyin, $page);
	}

	if (1 < $page) {
		$datadir .= "-{!page!}";
	}

	return $datadir;
}

function gxl_actor_url($sid, $cid, $tingid, $tingpinyin, $id, $page)
{
	if (C("url_html") && C("url_actordata") && in_array($sid, array("actor"))) {
		$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_actor_url_dir($sid, $cid, $tingid, $tingpinyin, "", $page) . C("html_file_suffix"));
		return $showurl;
	}
	else {
		if (C("url_html") && C("url_roledata") && in_array($sid, array("role"))) {
			$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_actor_url_dir($sid, $cid, $tingid, $tingpinyin, $id, $page) . C("html_file_suffix"));
			return $showurl;
		}
	}

	if ("actor" == $sid) {
		$arrurl["id"] = $tingid;
		$arrurl["listid"] = $cid;
		$arrurl["listdir"] = getlistdir($cid);
		$arrurl["tingpinyin"] = $tingpinyin;
	}
	else if ("role" == $sid) {
		$arrurl["listid"] = $cid;
		$arrurl["listdir"] = getlistdir($cid);
		$arrurl["tingpinyin"] = $tingpinyin;
		$arrurl["tingid"] = $tingid;
		$arrurl["id"] = $id;
	}

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-" . $sid . "/read", $arrurl, true, false);
}

function gxl_actor_list_url($sid, $page)
{
	if (C("url_html") && C("url_actorshow") && in_array($sid, array("actor"))) {
		$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_actor_list_dir($sid, $page) . C("html_file_suffix"));
		return $showurl;
	}
	else {
		if (C("url_html") && C("url_roleshow") && in_array($sid, array("role"))) {
			$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_actor_list_dir($sid, $page) . C("html_file_suffix"));
			return $showurl;
		}
	}

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-" . $sid . "/show", $arrurl, true, false);
}

function gxl_actor_url_dir($sid, $cid, $tingid, $tingpinyin, $id, $page)
{
	if ("actor" == $sid) {
		$datadir = str_actor_dir(C("url_actordata"), $cid, $tingid, $tingpinyin, "", $pinyin, $page);
	}
	else {
		$datadir = str_actor_dir(C("url_roledata"), $cid, $tingid, $tingpinyin, $id, $pinyin, $page);
	}

	if (1 < $page) {
		$datadir .= "-{!page!}";
	}

	return $datadir;
}

function gxl_actor_list_dir($sid, $page)
{
	if ("actor" == $sid) {
		$datadir = str_actor_dir(C("url_actorshow"), $page);
	}
	else if ("role" == $sid) {
		$datadir = str_actor_dir(C("url_roleshow"), $page);
	}

	if (1 < $page) {
		$datadir .= "-{!page!}";
	}

	return $datadir;
}

function gxl_story_url($sid, $cid, $id, $pinyin, $page)
{
	if (C("url_html") && C("url_story_list") && in_array($sid, array("show"))) {
		$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_story_url_dir($sid, $cid, "", "", $page) . C("html_file_suffix"));
		return $showurl;
	}
	else {
		if (C("url_html") && C("url_storydata") && in_array($sid, array("read"))) {
			$showurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_story_url_dir($sid, $cid, $id, $pinyin, $page) . C("html_file_suffix"));
			$newshowurl = str_replace("-" . C("url_html_suffix"), C("html_file_suffix"), $showurl);
			return $newshowurl;
		}
		else if ("show" == $sid) {
			$arrurl["id"] = $cid;
			$arrurl["listdir"] = getlistname($cid, "list_dir");
		}
		else {
			$arrurl["id"] = $id;
			$arrurl["pinyin"] = $pinyin;
			$arrurl["listid"] = $cid;
			$arrurl["listdir"] = getlistname($cid, "list_dir");
		}
	}

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-story/" . $sid . "", $arrurl, true, false);
}

function gxl_story_url_dir($sid, $cid, $id, $pinyin, $page)
{
	if ("read" == $sid) {
		if ($page == 1) {
			$page = "";
		}

		$datadir = str_storyred_dir(C("url_storydata"), $cid, $id, $pinyin, $page);
	}
	else {
		$datadir = str_story_dir(C("url_story_list"), $cid, $id, $page);

		if (1 < $page) {
			$datadir .= "-{!page!}";
		}
	}

	return $datadir;
}

function gxl_tv_url($id, $cid, $wid)
{
	if (C("url_html") && C("url_html_tv")) {
		$tvurl = C("site_path") . str_replace("index" . C("html_file_suffix"), "", gxl_play_url_dir($id, $cid, $wid) . C("html_file_suffix"));
	}
	else if (C("url_rewrite")) {
		if (empty($wid)) {
			$tvurl = UU("Home-tv/read", array("id" => $id, "pinyin" => gettvpinyin($id), "cid" => $cid, "listdir" => getlistdir($cid), "wid" => "index", "wpy" => "index"), true, false);
		}
		else {
			$tvurl = UU("Home-tv/read", array("id" => $id, "pinyin" => gettvpinyin($id), "cid" => $cid, "listdir" => getlistdir($cid), "wid" => $wid, "wpy" => getweek($wid)), true, false);
		}
	}
	else {
		$tvurl = UU("Home-tv/read", array("id" => $id, "wid" => $wid), true, false);
	}

	return $tvurl;
}

function gxl_ting_filmtime_url($sid, $cid, $id, $pinyin)
{
	$arrurl["id"] = $id;
	$arrurl["pinyin"] = $pinyin;
	$arrurl["listid"] = $cid;
	$arrurl["listdir"] = getlistname($cid, "list_dir");

	if (1 < $page) {
		$arrurl["p"] = "{!page!}";
	}

	return UU("Home-ting/filmtime", $arrurl, true, false);
}

function str_star_dir($urldir, $id, $pinyin, $page)
{
	$old = array("{id}", "{pinyin}", "{md5}", C("html_file_suffix"));
	$new = array($id, $pinyin, md5($id), "");
	return str_replace($old, $new, $urldir);
}

function str_story_dir($urldir, $cid, $id, $pinyin)
{
	$old = array("{listid}", "{listdir}", "{id}", "{pinyin}", C("html_file_suffix"));
	$new = array($cid, getlistname($cid, "list_dir"), $id, $pinyin, "");
	return str_replace($old, $new, $urldir);
}

function str_storyred_dir($urldir, $cid, $id, $pinyin, $page)
{
	$old = array("{listid}", "{listdir}", "{id}", "{pinyin}", "{page}", C("html_file_suffix"));
	$new = array($cid, getlistname($cid, "list_dir"), $id, $pinyin, $page, "");
	return str_replace($old, $new, $urldir);
}

function str_actor_dir($urldir, $cid, $tingid, $tingpinyin, $id, $pinyin)
{
	$old = array("{listid}", "{listdir}", "{tingid}", "{tingpinyin}", "{id}", "{pinyin}", "{md5}", C("html_file_suffix"));
	$new = array($cid, getlistname($cid, "list_dir"), $tingid, $tingpinyin, $id, $pinyin, md5($id), "");
	return str_replace($old, $new, $urldir);
}



function gxl_sql_news($tag)
{
	$search = array();
	$where = array();
	$tag = gxl_param_lable($tag);
	$field = (!empty($tag["field"]) ? $tag["field"] : "*");
	$limit = (!empty($tag["limit"]) ? $tag["limit"] : "10");
	$order = (!empty($tag["order"]) ? $tag["order"] : "news_addtime");
	if (C("data_cache_newsforeach") && (C("currentpage") < 2)) {
		$data_cache_name = md5(C("data_cache_foreach") . implode(",", $tag));
		$data_cache_content = S($data_cache_name);

		if ($data_cache_content) {
			return $data_cache_content;
		}
	}

	$where["news_status"] = array("eq", 1);

	if ($tag["ids"]) {
		$where["news_id"] = array("in", $tag["ids"]);
	}

	if ($tag["day"]) {
		$where["news_addtime"] = array("gt", getxtime($tag["day"]));
	}

	if ($tag["hits"]) {
		$hits = explode(",", $tag["hits"]);

		if (1 < count($hits)) {
			$where["news_hits"] = array("between", $hits[0] . "," . $hits[1]);
		}
		else {
			$where["news_hits"] = array("gt", $hits[0]);
		}
	}

	if ($tag["cid"]) {
		$cids = explode(",", trim($tag["cid"]));

		if (1 < count($cids)) {
			$where["news_cid"] = array("in", getlistarr_tag($cids));
		}
		else {
			$where["news_cid"] = getlistsqlin($tag["cid"]);
		}
	}

	if ($tag["stars"]) {
		$where["news_stars"] = array("in", $tag["stars"]);
	}

	if ($tag["letter"]) {
		$where["news_letter"] = array("in", $tag["letter"]);
	}

	if ($tag["name"]) {
		$where["news_name"] = array("like", "%" . $tag["name"] . "%");
	}

	if ($tag["title"]) {
		$where["news_title"] = array("like", "%" . $tag["title"] . "%");
	}

	if ($tag["no"]) {
		$where["news_id"] = array("neq", $tag["no"]);
	}

	if ($tag["wd"]) {
		$search["news_name"] = array("like", "%" . $tag["wd"] . "%");
		$search["news_inputer"] = array("like", "%" . $tag["wd"] . "%");
		$search["_logic"] = "or";
		$where["_complex"] = $search;
	}

	if ($tag["up"]) {
		$up = explode(",", $tag["up"]);

		if (1 < count($up)) {
			$where["news_up"] = array("between", $up[0] . "," . $up[1]);
		}
		else {
			$where["news_up"] = array("gt", $up[0]);
		}
	}

	if ($tag["down"]) {
		$down = explode(",", $tag["down"]);

		if (1 < count($down)) {
			$where["news_down"] = array("between", $down[0] . "," . $down[1]);
		}
		else {
			$where["news_down"] = array("gt", $down[0]);
		}
	}

	if ($tag["gold"]) {
		$gold = explode(",", $tag["gold"]);

		if (1 < count($gold)) {
			$where["news_gold"] = array("between", $gold[0] . "," . $gold[1]);
		}
		else {
			$where["news_gold"] = array("gt", $gold[0]);
		}
	}

	if ($tag["golder"]) {
		$golder = explode(",", $tag["golder"]);

		if (1 < count($golder)) {
			$where["news_golder"] = array("between", $golder[0] . "," . $golder[1]);
		}
		else {
			$where["news_golder"] = array("gt", $golder[0]);
		}
	}

	if ($tag["tag"]) {
		$where["tag_sid"] = 2;
		$where["tag_name"] = $tag["tag"];
		$rs = D("TagnewsView");
	}
	else if ($tag["news"]) {
		if ($tag["type"]) {
			$where["newsrel_sid"] = $tag["type"];
		}

		if (!empty($tag["did"])) {
			$search["newsrel_did"] = $tag["did"];
			$search["newsrel_name"] = $tag["news"];
			$search["_logic"] = "or";
			$where["_complex"] = $search;
		}
		else {
			$where["newsrel_name"] = $tag["news"];
		}

		
	}
	else {
		$rs = M("News");
	}

	if ($tag["page"]) {
		$count = $rs->where($where)->count("news_id");

		if (!$count) {
			return false;
		}

		$totalpages = ceil($count / $limit);
		$currentpage = get_maxpage(C("currentpage"), $totalpages);
		$pageurl = urldecode(C("jumpurl"));
		$pages = "<strong>共" . $count . "篇资讯&nbsp;当前:" . $currentpage . "/" . $totalpages . "页&nbsp;</strong>" . getpage($currentpage, $totalpages, C("home_pagenum"), $pageurl, "pagego('" . $pageurl . "'," . $totalpages . ")");
		$pagestop = "<strong>" . $currentpage . "/" . $totalpages . "</strong>" . getpagetop($currentpage, $totalpages, C("home_pagenum"), $pageurl, "pagego('" . $pageurl . "'," . $totalpages . ")");
		$list = $rs->field($field)->where($where)->order($order)->limit($limit)->page($currentpage)->select();
		$list[0]["count"] = count($list);
		$list[0]["page"] = $pages;
		$list[0]["pagecount"] = $count;
		$list[0]["pagetop"] = $pagestop;
	}
	else {
		$list = $rs->field($field)->where($where)->order($order)->limit($limit)->select();
		if ($tag["count"] && empty($tag["page"])) {
			$count = $rs->where($where)->count("news_id");

			if (!$count) {
				return false;
			}

			$list[0]["counts"] = $count;
		}
	}

	foreach ($list as $key => $val ) {
		$list[$key]["list_id"] = $list[$key]["news_cid"];
		$list[$key]["list_name"] = getlistname($list[$key]["list_id"], "list_name");
		$list[$key]["list_url"] = getlistname($list[$key]["list_id"], "list_url");
		$list[$key]["news_readurl"] = gxl_data_url("news", $list[$key]["news_id"], $list[$key]["news_cid"], $list[$key]["news_name"], 1, $list[$key]["news_jumpurl"]);
		$list[$key]["news_picurl"] = gxl_img_url($list[$key]["news_pic"], $list[$key]["news_content"]);
		$list[$key]["news_picurl_small"] = gxl_img_url_small($list[$key]["news_pic"], $list[$key]["news_content"]);
	}

	if (C("data_cache_newsforeach") && (C("currentpage") < 2)) {
		S($data_cache_name, $list, intval(C("data_cache_newsforeach")));
	}

	return $list;
}



function miaopuo_week($data, $tvweek, $zhibo)
{
	$week = str_replace("0", "7", date("w"));
	$date = date("Y年m月d日");
	$time = strtotime(date("H:i"));
	$data = json_decode($data, true);

	foreach ($data as $key => $value ) {
		$array_week["week"][] = str_replace(array("星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"), array("1", "2", "3", "4", "5", "6", "7"), $value["week"]);
	}

	$week = $array_week["week"];

	foreach ($data as $key => $value ) {
		$array["tv_datalist"][$week[$key]]["week"] = $value["week"];
		$array["tv_datalist"][$week[$key]]["date"] = $value["date"];
		$datas = explode(chr(13), trim($value["data"]));
		$len = count($datas);

		foreach ($datas as $k => $val ) {
			$datalist = explode("\$", $val);
			$ndatalist = explode("\$", $datas[$k + 1]);
			if ((($date == $value["date"]) && (strtotime($datalist[0]) <= $time) && ($time < strtotime($ndatalist[0]))) || (($date == $value["date"]) && (strtotime($datalist[0]) <= $time) && ($k == $len - 1))) {
				$array["tv_datalist"][$week[$key]]["live"] = $k;
				$array["tv_datalist"][$week[$key]]["data"][$k]["live"] = 1;
			}

			$array["tv_datalist"][$week[$key]]["data"][$k]["time"] = $datalist[0];
			$array["tv_datalist"][$week[$key]]["data"][$k]["name"] = $datalist[1];
			$array["tv_datalist"][$week[$key]]["data"][$k]["names"] = preg_replace(array("/.*?:/", "/(\(.*?)\)/", "/.*?：/", "/（(.*?)）/", "/\d*/"), "", $datalist[1]);
		}
	}

	$counts = count($array["tv_datalist"][$tvweek]["data"]) - 1;
	$live = $array["tv_datalist"][$tvweek]["live"];
	$arrays["tv_datalist"]["week"] = $array["tv_datalist"][$tvweek]["week"];
	$arrays["tv_datalist"]["date"] = $array["tv_datalist"][$tvweek]["date"];

	if ($zhibo) {
		$arrays = $array["tv_datalist"][$tvweek]["data"][$live];
	}
	else {
		foreach ($array["tv_datalist"][$tvweek]["data"] as $i => $v ) {
			if ((($live == $counts) && (($live - 3) < $i)) || (($live == 0) && ($i < 3)) || ((($live - 1) <= $i) && ($i <= $live + 1))) {
				$arrays["tv_datalist"]["data"][] = $v;
			}
		}
	}

	return $arrays["tv_datalist"];
}




function getname($cid, $type = 1, $field = "ting_name")
{
	if ($type == 1) {
		$rs = M("Ting");
		$where["ting_id"] = $cid;
		$list = $rs->field($field)->where($where)->select();

		if ($list) {
			return $list[0];
		}
	}
	else {
		$rs = M("News");
		$where["news_id"] = $cid;
		$field = "News_name";
		$list = $rs->field($field)->where($where)->select();

		if ($list) {
			return $list[0];
		}
	}
}

function getpy($name)
{
	if (C("letters")) {
		$str = $name;
		$str = preg_replace("/\s|\:|(|\~|\`|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\{|\}|\[|\]|\||\|\:|\;|\"|\'|\<|\,|\>|\.|\?|\/)/is", "", $str);

		for ($ascLen = strlen($str); $i < $ascLen; $i++) {
			$c = ord(substr($str, 0, 1));

			if (252 < $c) {
				$p = 5;
			}
			else if (248 < $c) {
				$p = 4;
			}
			else if (240 < $c) {
				$p = 3;
			}
			else if (224 < $c) {
				$p = 2;
			}
			else if (192 < $c) {
				$p = 1;
			}
			else {
				$p = 0;
			}

			$truekey = substr($str, 0, $p + 1);

			if ($truekey === false) {
				break;
			}

			$splikey[] = $truekey;
			$str = substr($str, $p + 1);
		}

		if ($splikey) {
			foreach ($splikey as $value ) {
				$pystr[] = strtolower(gxl_letter_first($value));
			}
		}

		return implode("", $pystr);
	}
	else {
		return gxl_pinyin($name);
	}
}

function seo($name, $key, $i, $l)
{
	$limit = (!empty($i) ? $i : "1");
	$rstt = M("Seo");
	$keywords = $name;
	$pipei = $key;
	$where["keywords"] = array(
		array("like", "%" . $keywords . "%" . $pipei . "%"),
		array("like", "%" . $keywords . "%"),
		"or"
		);
	$listseo = $rstt->field("keywords")->where($where)->order("search desc")->limit($limit)->select();
	$sum = 0;
	$count = count($listseo);

	for ($i = 0; $i < $count; $i++) {
		$sum .= $listseo[$i]["keywords"] . $l;
	}

	$sum = rtrim(substr($sum, 1), $l);

	if ($listseo) {
		return $sum;
	}
	else {
		return $name;
	}
}

function seono($name, $key)
{
	$rstt = M("Seo");
	$keywords = $name;
	$pipei = $key;
	$where["keywords"] = array("like", "%" . $keywords . "%" . $pipei . "%");
	$listseo = $rstt->field("keywords")->where($where)->order("search desc")->limit(1)->select();
	$sum = 0;
	$count = count($listseo);

	for ($i = 0; $i < $count; $i++) {
		$sum .= $listseo[$i]["keywords"] . $l;
	}

	$sum = rtrim(substr($sum, 1), $l);

	if ($listseo) {
		return $key;
	}
	else {
		return "";
	}
}

function delmulu($directory, $subdir = true)
{
	if (is_dir($directory) == false) {
		return "";
	}

	$handle = opendir($directory);

	while (($file = readdir($handle)) !== false) {
		if (($file != ".") && ($file != "..")) {
			is_dir("$directory/$file") ? Dir::delDir("$directory/$file") : @unlink("$directory/$file");
		}
	}

	if (readdir($handle) == false) {
		closedir($handle);
		rmdir($directory);
	}
}

function seoadd($name)
{
	$co = new \Org\Net\Curl();
	$k = C("keywords_p");
	$urlarray = explode(",", C("api_jiekou"));
	$c = count($urlarray) - 1;
	$i = rand(0, $c);
	$u = $urlarray[$i] . "/jiekou/seo.php";
	$data = $co->get($u, array("name" => $name, "k" => $k));
	$d = json_decode($data, true);
	$c = explode(",", $d["keywords"]);
	if (!empty($d) && (2 < count($c))) {
		return $d["keywords"];
	}
	else {
		return false;
	}
}
