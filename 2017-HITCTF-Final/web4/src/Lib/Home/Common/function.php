<?php
function ps_getavatar($uid)
{
	if (!is_numeric($uid)) {
		$uid = cookie_decode(cookie("_userid"));

		if (empty($uid)) {
			return "";
		}
	}
	$z = (in_array(big, array("big", "middle", "small")) ? big : "big");
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$typeadd = ($type == "real" ? "_real" : "");
	$url = "avatar/customavatars/" . $dir1 . "/" . $dir2 . "/" . $dir3 . "/" . substr($uid, -2) . $typeadd . "_avatar_$z.jpg";
	$info = getimagesize($url);
	$fp = fopen($url, "rb");
	$rss = D("User");
	$url = geturl() . "avatar/avatar.php?uid=" . $uid;
	$memberinfo = $rss->getuserinfo($uid);
	if (!$fp && ($memberinfo["avatar"] == 1) && !empty($memberinfo["avatar_img"])) {
		$avatar = array("big" => $memberinfo["avatar_img"], "middle" => $memberinfo["avatar_img"], "small" => $memberinfo["avatar_img"]);
	}
	else {
		$avatar = array("big" => $url . "&&size=big", "middle" => $url . "&&size=middle", "small" => $url . "&&size=small");
	}
	return $avatar;
}
function get_hilight($string, $keyword, $classname = "kw-hilight")
{
	return str_replace($keyword, "<span>" . $keyword . "</span>", $string);
}
function get_hilight_ex($string, $keyword, $arr = "span", $color = "black")
{
	return str_replace($keyword, "<" . $arr . " color=\"" . $color . "\">" . $keyword . "</" . $arr . ">", $string);
}
function get_actor_url($str, $num, $keyword, $classname)
{
	$str = str_replace(" ", "/", str_replace(",", "/", $str));
	$arr = explode("/", $str);
	$rs = M("Star");
	foreach ($arr as $key => $val ) {
		$list = $rs->field("star_id,star_name,star_pyname")->where(array("star_name" => $val))->find();
		$value = $val;
		if ($keyword) {
			$value = get_hilight_ex($value, $keyword, "font", "red");
		}
		if (!empty($list["star_id"])) {
			$restr .= "<a  href=\"" . gxl_star_url("read", $list["star_id"], $list["star_pyname"], 1) . "\" target=\"_blank\">" . $value . "</a>";
		}
		else {
			$restr .= "<a href=\"" . UU("Home-ting/search", array("wd" => urlencode(trim($val))), true, false) . "\" target=\"_blank\">" . $value . "</a> ";
		}
		if (($key + 1) == $num) {
			break;
		}
	}
	return $restr;
}
function get_cmonth_lastday($date)
{
	$date_arr = explode("-", $date);
	$year = $date_arr[0];
	$month = $date_arr[1];
	$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	if (($month < 1) || (12 < $month)) {
		return 0;
	}
	if (($month == 2) || ($month == 2)) {
		if ((($year % 400) == 0) || ((($year % 4) == 0) && (($year % 100) != 0))) {
			return $year . "-" . $month . "-29";
		}
	}
	return $year . "-" . $month . "-" . $days_in_month[$month - 1];
}