<?php

/**
 * DiscuzX Convert
 *
 * $Id: global.func.php 20661 2011-03-01 08:08:07Z shanzongjun $
 */

function remaintime($time) {
	$seconds 	= $time % 60;
	$minutes 	= $time % 3600 / 60;
	$hours 		= $time % 86400 / 3600;
	$days 		= $time / 86400;
	return array((int)$days, (int)$hours, (int)$minutes, (int)$seconds);
}

function daddslashes($string, $trim = '0') {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = daddslashes($val);
		}
	} else {
		$string = $trim ? trim(addslashes($string)) : addslashes($string);
	}
	return $string;
}

function cutstr($string, $length, $dot = '') {
	global $discuz_charset;

	if(strlen($string) <= $length) {
		return $string;
	}
	$strcut = '';
	if(strtolower($discuz_charset) == 'utf8') {

		$n = $tn = $noc = 0;
		while ($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if ($noc >= $length) {
				break;
			}

		}
		if ($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length - strlen($dot) - 1; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	return $strcut.$dot;
}

function parseqqicq($qqicq, $minlen = 5, $maxlen = 12) {// qq 转换
	return $qqicq ? (preg_match("/^([0-9]+)$/", $qqicq) && strlen($qqicq) >= $minlen && strlen($qqicq) <= $maxlen ? $qqicq : '') : '';
}

function parsesite($site) {
	if($site && strtolower($site) != 'http://') {
		$user_site = trim(preg_match("/^https?:\/\/.+/i", $site) ? $site : ($site ? 'http://'.$site : ''));
		return $user_site ? cutstr(htmlspecialchars($user_site), 75) : '';
	}
	return '';
}

function parsesign($sign) {

	$searcharray = array(
		'[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]',
		'[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
		'[list=A]', '[*]', '[/list]', '[indent]', '[/indent]'
	);

	$replacearray = array(
		'</font>', '</font>', '</font>', '</p>', '<b>', '</b>', '<i>',
		'</i>', '<u>', '</u>', '<ul>', '<ol type=1>', '<ol type=a>',
		'<ol type=A>', '<li>', '</ul></ol>', '<blockquote>', '</blockquote>'
	);

	$pregfind = array(
		"/\[url\]\s*(www.|https?:\/\/|ftp:\/\/|gopher:\/\/|news:\/\/|telnet:\/\/|rtsp:\/\/|mms:\/\/|callto:\/\/|ed2k:\/\/){1}([^\[\"']+?)\s*\[\/url\]/ie",
		"/\[url=www.([^\[\"']+?)\](.+?)\[\/url\]/is",
		"/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms|callto|ed2k){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/is",
		"/\[email\]\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*\[\/email\]/i",
		"/\[email=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\](.+?)\[\/email\]/is",
		"/\[color=([^\[\<]+?)\]/i",
		"/\[size=([^\[\<]+?)\]/i",
		"/\[font=([^\[\<]+?)\]/i",
		"/\[align=([^\[\<]+?)\]/i",
		"/\s*\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s*/is",
		"/\s*\[code\](.+?)\[\/code\]\s*/is",
		"/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies",
		"/\[img=(\d{1,3})[x|\,](\d{1,3})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies"
	);
	$pregreplace = array(
		"cuturl('\\1\\2')",
		"<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",
		"<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>",
		"<a href=\"mailto:\\1@\\2\">\\1@\\2</a>",
		"<a href=\"mailto:\\1@\\2\">\\3</a>",
		"<font color=\"\\1\">",
		"<font size=\"\\1\">",
		"<font face=\"\\1\">",
		"<p align=\"\\1\">",
		"<div class=\"altbg2\" style=\"margin: 2em; margin-top: 3px; padding: 10px; border: 0px solid #86B9D6; word-break: break-all\">\\1</div>",
		"<div class=\"altbg2\" style=\"margin: 2em; margin-top: 3px; clear: both; padding: 10px; padding-top: 5px; border: 0px solid #86B9D6; word-break: break-all\">\\1</div>",
		"bbcodeurl('\\1', '<img src=\"%s\" border=\"0\" onload=\"if(this.width>screen.width*0.7) {this.resized=true; this.width=screen.width*0.7; this.alt=\'Click here to open new window\\nCTRL+Mouse wheel to zoom in/out\';}\" onmouseover=\"if(this.width>screen.width*0.7) {this.resized=true; this.width=screen.width*0.7; this.style.cursor=\'hand\'; this.alt=\'Click here to open new window\\nCTRL+Mouse wheel to zoom in/out\';}\" onclick=\"if(!this.resized) {return true;} else {window.open(\'%s\');}\" onmousewheel=\"return imgzoom(this);\" alt=\"\" />')",
		"bbcodeurl('\\3', '<img width=\"\\1\" height=\"\\2\" src=\"%s\" border=\"0\" alt=\"\" />')"
	);

	return daddslashes(str_replace($searcharray, $replacearray, preg_replace($pregfind, $pregreplace, $sign)));
}

function bbcodeurl($url, $tags) {//url 转换
	if(!preg_match("/<.+?>/s", $url)) {
		if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'ftp://', 'rtsp:/', 'mms://'))) {
			$url = 'http://'.$url;
		}
		return str_replace(array('submit', 'logging.php'), array('', ''), sprintf($tags, $url, addslashes($url)));
	} else {
		return '&nbsp;'.$url;
	}
}

function cuturl($url) {
	$length = 65;
	$urllink = "<a href=\"".(substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url).'" target="_blank">';
	if(strlen($url) > $length) {
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	$urllink .= $url.'</a>';
	return $urllink;
}

function timetounix($time) {
	if($time > 100000000) {
		return $time;
	}
	$time = str_replace(array(' 一月 ',' 二月 ',' 三月 ',' 四月 ',' 五月 ',' 六月 ',' 七月 ',' 八月 ',' 九月 ',' 十月 ',' 十一月 ',' 十二月 ', ' 上午 '), array('-1-','-2-','-3-','-4-','-5-','-6-','-7-','-8-','-9-','-10-','-11-','-12-', ' '), $time);
	if(strrchr($time, '下午') !== false) {
		return strtotime(str_replace(' 下午 ', ' ', $time)) + 43200;
	} else {
		return strtotime($time);
	}
}

function convertcharset($msg) {
	global $source_charset, $discuz_charset, $db, $language;
	if($discuz_charset == $source_charset || ($db['source']->version() > 4.1 && $db['discuz']->version() > 4.1)){
		return $msg;
	} elseif (function_exists(iconv)) {
		$source_charset = str_replace('utf8', 'utf-8', $source_charset);
		$discuz_charset = str_replace('utf8', 'utf-8', $discuz_charset);
		return iconv($source_charset, $discuz_charset, $msg);
	} else {
		showmessage($language['convert_noiconv']);
	}
}

function xconvert_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(xconvert_key($tmp, $key));
}

function xconvert_decrypt($txt, $key) {
	$txt = xconvert_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
		$md5 = $txt[$i];
		$tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function xconvert_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}


function showmessage($message, $url_forward = '', $vars = array(), $timeout = 1) {
	showheader();
	$message = lang($message, $vars);
	$messageadd = '';
	$timeout = intval($timeout);
	if($url_forward) {
		$messageadd .= "<script>setTimeout(\"redirect('$url_forward');\", $timeout);</script>";
		$messageadd .= "&gt;&gt;<a href=\"index.php\"><strong>".lang('message_stop')."</strong></a>";
	} elseif(strpos($message, lang('return'))) {
		$messageadd .= "<a href=\"javascript:history.go(-1);\" class=\"mediumtxt\">".lang('message_return').'</a><br><br>';
	}

	echo <<<EOT
<table class="showtable">
	<tbody><tr class="title"><td style="color: white">系统提示</td></tr>
		<tr><td style="padding: 10px; background-color: #fefefe;font-size: 14px "><br>$message<br><br></td></tr>
		<tr><td>$messageadd</td></tr>
	</tbody>
</table>
EOT;
	showfooter();
	exit;
}

function showheader($action = '', $setting = array()) {
	static $isshow;
	if($isshow) {
		return true;
	}
	$class[$action] = 'class="current"';
	$titleadd = !empty($setting['program']['source']) ? " (<span style=\"color: #888888; padding: 4px\">{$setting['program']['source']} --&gt; {$setting['program']['target']}</span>)" : '';

echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Discuz! X 系列产品升级转换</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body,td { font-family: Tahoma; font-size: 12px; line-height: 150%;}
form {margin: 0px; padding: 0px;}
a:link,a:visited,a:active { color: #333333; text-decoration: none;}
a:hover {color: #FF0000;text-decoration: underline;}

.header {background-color: #ffffff; font-weight: bold; text-align: center}
.input, textarea {font-family: Tahoma;font-size: 12px;color: #333333;background-color: #ffffff;border: 1px solid #666666;padding-left:2px;}
.top {background-color: #cccccc}
.bg1 {background-color: #f8f8ff}
.bg2 {background-color: #fefeff}
.menu {background-color: #f5f5f5;}
.tableborder{background-color: #e5e5ff}

.title {background: #5086A5; font-weight: bold;color: #FFFFFF;}
.title td {background: #5086A5; font-weight: bold;color: #FFFFFF;}
.title, .title a:link, .title a:visited, .title a:active{color: #FFFFFF; text-decoration: none; font-weight: blod;}
.title a:hover{color: #00FF00;text-decoration: underline;}

.redbg {background: #FF0000; font-weight: bold; color: #FFFFFF;}
.redbg td {background: #FF0000; font-weight: bold; color: #FFFFFF;}

* {font-size:12px; font-family: Verdana, Arial, Helvetica, sans-serif; line-height: 1.5em; word-break: break-all; }
body { text-align:center; margin: 0; padding: 0; background: #F5FBFF; }
ul li { list-style: none; }
ul {margin: 0;}
.main{ margin: 40px auto 0; width:770px; text-align:left; border: solid #86B9D6; border-width: 5px 1px 1px; background: #FFF;}
.content{margin: 0pt auto; width: 95%;  min-height: 500px}

#ulist li {  float: left; margin-right: 5px; width: 30%; overflow: hidden; line-height: 2em; }

h1 { font-size: 18px; margin: 1px 0 0; line-height: 50px; height: 50px; background: #E8F7FC; color: #5086A5; padding-left: 10px; }
#menu {width: 100%; margin: 10px auto; text-align: center; }
#menu td { height: 30px; line-height: 30px; color: #999; border-bottom: 3px solid #EEE; }
.current { font-weight: bold; color: #090 !important; border-bottom-color: #F90 !important; }
.showtable { width:100%; border: solid; border-color:#86B9D6 #B2C9D3 #B2C9D3; border-width: 1px; margin: 10px auto; background: #F5FCFF; }
.showtable td { padding: 3px; color: #808080 }
.showtable strong { color: #5086A5; }
.datatable { width: 100%; margin: 10px auto 25px; }
.datatable td { padding: 5px 0; border-bottom: 1px solid #EEE; }
input { border: 1px solid #B2C9D3; padding: 2px; background: #F5FCFF; }
.button { margin: 10px auto 20px; width: 100%; }
.button td { text-align: center; }
.button input, .button button { border: solid; border-color:#F90; border-width: 1px 1px 3px; padding: 5px 40px; color: #090; background: #FFFAF0; cursor: pointer; }
#footer { font-size: 10px; line-height: 40px; background: #E8F7FC; text-align: center; height: 38px; overflow: hidden; color: #5086A5; margin-top: 20px; }

textarea, input, select{ padding:2px; border:1px solid; border-color:#666 #ccc #ccc #666; background:#F9F9F9; color:#333; }
.checkbox { border:0; background:none; }
</style>

<script type="text/javascript">
function redirect(url) {
	window.location.replace(url);
}

function checkAll(type, form, value, checkall, changestyle) {
	var checkall = checkall ? checkall : 'chkall';
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(type == 'option' && e.type == 'radio' && e.value == value && e.disabled != true) {
			e.checked = true;
		} else if(type == 'value' && e.type == 'checkbox' && e.getAttribute('chkvalue') == value) {
			e.checked = form.elements[checkall].checked;
		} else if(type == 'prefix' && e.name && e.name != checkall && (!value || (value && e.name.match(value)))) {
			e.checked = form.elements[checkall].checked;
			if(changestyle && e.parentNode && e.parentNode.tagName.toLowerCase() == 'li') {
				e.parentNode.className = e.checked ? 'checked' : '';
			}
		}
	}
}
</script>

</head>
<body style="table-layout:fixed; word-break:break-all; margin-top: 4px;">
<div class="main">
<h1>Discuz! X 系列产品升级/转换 向导 $titleadd</h1>
<div class="content">
<table id="menu">
	<tr>
	<td $class[source]>1.选择产品转换程序 </td>
	<td $class[config]>2.设置服务器信息 </td>
	<td $class[select]>3.配置转换过程 </td>
	<td $class[convert]>4.执行数据转换 </td>
	<td $class[finish]>5.转换完成 </td>
	</tr>
</table>

EOT;
	$isshow = true;
}

function getfiletype($filename = '') {
	$extnum	=	strrpos($filename, '.') + 1;
	$exts	=	strtolower(substr($filename, $extnum));
	switch ($exts) {
		case 'jpg':
			return 'image/pjpeg';
		break;
		case 'jpe':
			return 'image/pjpeg';
		break;
		case 'jpeg':
			return 'image/pjpeg';
		break;
		case 'pdf':
			return 'application/pdf';
		break;
		case 'gif':
			return 'image/gif';
		break;
		case 'bmp':
			return 'image/bmp';
		break;
		case 'png':
			return 'image/png';
		break;
		case 'rar':
			return 'x-rar-compressed';
		break;
		case 'txt':
			return 'text/plain';
		break;
		case 'swf':
			return 'application/x-shockwave-flash';
		break;
		case 'zip':
			return 'application/zip';
		break;
		case 'doc':
			return 'application/msword';
		break;
		default:
			return 'application/octet-stream';
		break;
	}
}

function convertucpw($password) {
	$salt = substr(uniqid(rand()), -6);
	$pass = md5(strtolower($password).$salt);
	return array('password'=>$pass, 'salt'=>$salt);
}

function getgpc($k, $type='GP') {
	$type = strtoupper($type);
	switch($type) {
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		default:
			if(isset($_GET[$k])) {
				$var = &$_GET;
			} else {
				$var = &$_POST;
			}
			break;
	}

	return isset($var[$k]) ? $var[$k] : NULL;

}

function show_table_header($show = true) {
	$s =  <<<EOT
<div class="tableborder" style="margin: auto;">
	<table width="100%" border="0" cellpadding="4" cellspacing="1" align="center">
EOT;
	$s .= "\n";
	return output($s, $show);
}

function show_table_footer($show = true) {
	$s = '	</table></div>'."\n";
	return output($s, $show);
}

function show_table_row($tds, $trclass = 'bg1', $show = true) {
	$s = '<tr class="'.$trclass.'">';
	foreach ($tds as $td) {
		if(is_array($td)) {
			$s .= '<td '.$td[0].'>'.$td[1].'</td>';
		} else {
			$s .= '<td>'.$td.'</td>';
		}
		$s .= "\n";
	}
	$s .= "</tr>\n";
	return output($s, $show);
}

function output(&$s, $show) {
	if($show) {
		echo $s;
	}
	return $s;
}

function showfooter($halt = false) {
	static $isshow;
	if(!$isshow) {
		echo <<<EOT
	</div>
	<div id="footer">&copy; Comsenz Inc. 2001-2010 www.discuz.net</div>
	</div>
</body>
</html>
EOT;
	}
	$isshow = true;
}

function submitcheck($var = 'submit', $allowget = false) {
	$check = getgpc($var);
	$ret = false;
	if(empty($check)) {

	} elseif($allowget) {
		$ret = true;
	} elseif($_REQUEST['method'] == 'post') {
		$ret = true;
	}
	return $ret;
}

function loadsetting($folder) {
	$folder = trim($folder);
	$ret = array();
	if($folder != '' && !preg_match('/(\/)|(\.\.)|(\\\)/', $folder) && file_exists(DISCUZ_ROOT.'/source/'.$folder.'/setting.ini')) {
		$ret = @parse_ini_file(DISCUZ_ROOT.'/source/'.$folder.'/setting.ini', true);
	}
	return $ret;
}

function loadconfig($file = 'config.inc.php') {
	$_config = array();
	@include DISCUZ_ROOT.'./data/'.$file;
	return $_config;
}

function showtips($tip) {
	$title = lang('tips');
	$msg = lang($tip);
	echo <<<EOT
<table class="showtable">
	<tbody><tr><td class="bg1"><strong>$title</strong></td></tr>
		<tr><td class="bg2"><ol>$msg</ol>
		</td></tr>
	</tbody>
</table>
EOT;
}

function lang($name, $vars = array()) {
	static $language;
	if($language === null) {
		@include DISCUZ_ROOT.'./language/lang.php';
		if(empty($language)) {
			$language = array();
		}
	}
	$ret = isset($language[$name]) ? $language[$name] : $name;
	if(!empty($vars)) {
		foreach ($vars as $key => $value) {
			$ret = str_replace('{'.$key.'}', $value);
		}
	}
	return $ret;
}

function show_hidden_field($name, $value) {
	echo '<input type="hidden" name="'.$name.'" value="'.$value.'">'."\n";
}

function show_form_header($method = 'post') {
	echo <<<EOT
<form method="$method" action="index.php">
<input type="hidden" name="a" value="$GLOBALS[action]">
<input type="hidden" name="source" value="$GLOBALS[source]">
<input type="hidden" name="submit" value="yes">
EOT;
}

function show_form_footer($submitname = '', $submitvalue = 'submit') {
	if($submitname != '') {
		$submitvalue = lang($submitvalue);
		echo <<<EOT
<table class="button">
	<tr><td><input type="submit" value="$submitvalue" name="$submitname"></td></tr>
</table>
EOT;
	}
	echo '</form>';
}

function show_config_input($type, $config, $error = array()) {
	$title = lang('config_type_'.$type);
	show_table_header();
	show_table_row(array(array('colspan="3"', $title)), 'header title');
	if($type == 'target') {
		show_table_row(array(array('colspan="3"', '<font color="red">'.lang('config_type_target_comment').'</font>')), 'bg2');
	}
	foreach ($config as $key => $value) {
		$addmsg = $error && $key == 'dbhost' ? lang($error) : '';
		$tip = $key == 'pconnect' ? lang('tips_pconnect') : '';
		show_table_row(	array(
		array('width="150"', lang('config_'.$key)),
		array('class="bg2"', '<input type="text" size="40" name="newconfig['.$type.']['.$key.']" value="'.htmlspecialchars($value).'">'),
		array('class="bg2"', '<font color="red">'.$tip.'</font><font color="red">'.$addmsg.'</font>')
		), 'bg1'
		);
	}

	show_table_footer();
	echo '<br>';
}

function getvars($data, $type = 'VAR') {
	$evaluate = '';
	foreach($data as $key => $val) {
		if(!preg_match("/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/", $key)) {
			continue;
		}
		if(is_array($val)) {
			$evaluate .= buildarray($val, 0, "\${$key}")."\r\n";
		} else {
			$val = addcslashes($val, '\'\\');
			$evaluate .= $type == 'VAR' ? "\$$key = '$val';\n" : "define('".strtoupper($key)."', '$val');\n";
		}
	}
	return $evaluate;
}

function buildarray($array, $level = 0, $pre = '$_config') {
	static $ks;
	if($level == 0) {
		$ks = array();
		$return = '';
	}

	foreach ($array as $key => $val) {

		if($level == 0) {
			$newline = str_pad('  CONFIG '.strtoupper($key).'  ', 50, '-', STR_PAD_BOTH);
			$return .= "\r\n// $newline //\r\n";
		}

		$ks[$level] = $ks[$level - 1]."['$key']";
		if(is_array($val)) {
			$ks[$level] = $ks[$level - 1]."['$key']";
			$return .= buildarray($val, $level + 1, $pre);
		} else {
			$val = !is_array($val) && (!preg_match("/^\-?[1-9]\d*$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
			$return .= $pre.$ks[$level - 1]."['$key']"." = $val;\r\n";
		}
	}
	return $return;
}

function save_config_file($filename, $config, $default) {
	$config = setdefault($config, $default);
	$date = gmdate("Y-m-d H:i:s", time() + 3600 * 8);
	$year = date('Y');
	$content = <<<EOT
<?php


\$_config = array();

EOT;
	$content .= getvars(array('_config' => $config));
	$content .= "\r\n// ".str_pad('  THE END  ', 50, '-', STR_PAD_BOTH)." //\r\n\r\n?>";
	file_put_contents($filename, $content);
}

function setdefault($var, $default) {
	foreach ($default as $k => $v) {
		if(!isset($var[$k])) {
			$var[$k] = $default[$k];
		} elseif(is_array($v)) {
			$var[$k] = setdefault($var[$k], $default[$k]);
		}
	}
	return $var;
}

function mysql_connect_test($config, $type) {
	global $setting;
	static $error_code = array('connect_error' => -1, 'table_error' => -2);
	static $db;
	$ret = true;
	if($db === null) {
		require_once(DISCUZ_ROOT.'./include/db.class.php');
		$db = new db_mysql();
	}
	$db->set_config($config);
	$check = $db->connect(false);
	if(!$check) {
		$ret = $error_code['connect_error'];
	} else {
		if(isset($setting['tablecheck'][$type])) {
			$find = $db->fetch_first("SHOW TABLES LIKE '{$config[tablepre]}{$setting['tablecheck'][$type]}'");
			if(!$find) {
				$ret = $error_code['table_error'];
			}
		}
	}
	$db->close();
	return $ret;
}

function tablepre(&$db) {
	$pre = $db->table_pre;
	if(strexists($pre, '.')) {
		$tablepre = substr($pre, strpos($pre, '.') + 1);
	} else {
		$tablepre = $pre;
	}
	return $tablepre;
}

function implode_field_value($array, $glue = ',', $fields = array()) {
	$sql = $comma = '';
	foreach ($array as $k => $v) {
		if(empty($fields) || isset($fields[$k])) {
			$sql .= $comma."`$k`='$v'";
			$comma = $glue;
		}
	}
	return $sql;
}

function load_process($key) {
	global $db_target;
	$table = $db_target->tablepre.CACHETABLE;
	$data = $db_target->fetch_first("SELECT cachevalue FROM $table WHERE cachekey='$key'");
	if($data) {
		$data = unserialize($data['cachevalue']);
	}
	return !is_array($data) ? array() : $data;
}

function delete_process($key) {
	global $db_target;
	$table = $db_target->tablepre.CACHETABLE;
	if(empty($key) || $key == 'all') {
		$db_target->query("DELETE FROM $table");
	} else {
		$db_target->query("DELETE FROM $table WHERE cachekey='$key'");
	}
}

function save_process($key, $data) {
	global $db_target;
	$table = $db_target->tablepre.CACHETABLE;
	$data = serialize($data);
	$db_target->query("REPLACE INTO $table SET cachekey='$key', cachevalue='$data'");
}

function dimplode($array) {
	if(!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}

function db_table_charset($dbobject, $tablename) {
	$tablestruct = $dbobject->fetch_first("show create table {$dbobject->tablepre}$tablename");
	preg_match("/CHARSET=(\w+)/", $tablestruct['Create Table'], $m);
	return $m[1];
}

function db_table_fields($db, $table) {
	static $tables = array();
	$table = str_replace($db->tablepre, '', $table);
	if(!isset($tables[$table])) {
		$tables[$table] = array();
		if($db->version() > '4.1') {
			$query = $db->query("SHOW FULL COLUMNS FROM {$db->tablepre}$table", 'SILENT');
		} else {
			$query = $db->query("SHOW COLUMNS FROM {$db->tablepre}$table", 'SILENT');
		}
		while($field = @$db->fetch_array($query)) {
			$tables[$table][$field['Field']] = $field;
		}
	}
	return $tables[$table];
}

function dstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}

if(!function_exists('file_put_contents')) {
	if(!defined('FILE_APPEND')) define('FILE_APPEND', 8);
	function file_put_contents($filename, $data, $flag = 0) {
		$return = false;
		if($fp = @fopen($filename, $flag != FILE_APPEND ? 'w' : 'a')) {
			if($flag == LOCK_EX) @flock($fp, LOCK_EX);
			$return = fwrite($fp, is_array($data) ? implode('', $data) : $data);
			fclose($fp);
		}
		return $return;
	}
}