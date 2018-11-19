<?php

/*
	[UCenter] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: upgrade1.php 12117 2008-01-11 06:25:08Z heyond $
*/

define("IN_UC", TRUE);
define('UC_ROOT', realpath('..').'/');

$version_old = 'UCenter 1.0';
$version_new = 'UCenter 1.5';
$lock_file = UC_ROOT.'./data/upgrade.lock';

require UC_ROOT.'./data/config.inc.php';
if(function_exists("mysql_connect")) {
	require UC_ROOT.'./lib/db.class.php';
} else {
	require UC_ROOT.'./lib/dbi.class.php';
}
error_reporting(7);
@set_magic_quotes_runtime(0);
$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);

$action = getgpc('action');
$forward = getgpc('forward');

$sql = <<<EOT

DROP TABLE IF EXISTS uc_events;

ALTER TABLE uc_members ADD COLUMN secques CHAR(8) NOT NULL DEFAULT '';

ALTER TABLE uc_notelist ADD KEY dateline (dateline);

ALTER TABLE uc_applications ADD COLUMN viewprourl CHAR( 255 ) NOT NULL AFTER `ip` ;

ALTER TABLE uc_applications ADD COLUMN apifilename CHAR( 30 ) NOT NULL DEFAULT 'uc.php' AFTER `ip` ;

ALTER TABLE uc_pms ADD COLUMN fromappid SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE uc_applications CHANGE authkey authkey CHAR( 255 ) NOT NULL;

DROP TABLE IF EXISTS uc_mailqueue;
CREATE TABLE IF NOT EXISTS uc_mailqueue (
  mailid int(10) unsigned NOT NULL auto_increment,
  touid mediumint(8) unsigned NOT NULL default '0',
  tomail varchar(32) NOT NULL,
  frommail varchar(100) NOT NULL,
  subject varchar(255) NOT NULL,
  message text NOT NULL,
  charset varchar(15) NOT NULL,
  htmlon tinyint(1) NOT NULL default '0',
  level tinyint(1) NOT NULL default '1',
  dateline int(10) unsigned NOT NULL default '0',
  failures tinyint(3) unsigned NOT NULL default '0',
  appid smallint(6) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mailid`),
  KEY appid (appid),
  KEY level (level,failures)
) TYPE=MyISAM  AUTO_INCREMENT=1 ;

REPLACE INTO uc_settings (k, v) VALUES ('maildefault', 'username@21cn.com');
REPLACE INTO uc_settings (k, v) VALUES ('mailsend', '1');
REPLACE INTO uc_settings (k, v) VALUES ('mailserver', 'smtp.21cn.com');
REPLACE INTO uc_settings (k, v) VALUES ('mailport', '25');
REPLACE INTO uc_settings (k, v) VALUES ('mailauth', '1');
REPLACE INTO uc_settings (k, v) VALUES ('mailfrom', 'UCenter <username@21cn.com>');
REPLACE INTO uc_settings (k, v) VALUES ('mailauth_username', 'username@21cn.com');
REPLACE INTO uc_settings (k, v) VALUES ('mailauth_password', 'password');
REPLACE INTO uc_settings (k, v) VALUES ('maildelimiter', '0');
REPLACE INTO uc_settings (k, v) VALUES ('mailusername', '1');
REPLACE INTO uc_settings (k, v) VALUES ('mailsilent', '1');
REPLACE INTO uc_settings (k, v) VALUES ('pmlimit1day','100');
REPLACE INTO uc_settings (k, v) VALUES ('pmfloodctrl','15');
REPLACE INTO uc_settings (k, v) VALUES ('pmcenter','1');
REPLACE INTO uc_settings (k, v) VALUES ('sendpmseccode','1');
REPLACE INTO uc_settings (k, v) VALUES ('pmsendregdays','0');
EOT;

if(file_exists($lock_file) && $action != 'upgsecques') {
	showheader();
	showerror('升级被锁定，应该是已经升级过了，如果已经恢复数据请手动删除<br />'.str_replace(UC_ROOT, '', $lock_file).'<br />之后再来刷新页面');
	showfooter();
}

if(!$action) {

	showheader();

?>

	<p>本程序用于升级 UCenter 1.0 到 UCenter 1.5</p>
	<p>运行本升级程序之前，请确认已经上传 UCenter 1.5 的全部文件和目录</p>
	<p>强烈建议您升级之前备份数据库资料</p>
	<p><a href="<?php echo $PHP_SELF;?>?action=db">如果您已确认完成上面的步骤,请点这里升级</a></p>

<?php
	showfooter();

} elseif($action == 'db') {

	@touch(UC_ROOT.'./data/install.lock');
	@unlink(UC_ROOT.'./install/index.php');

	$db = new db;
	$db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBCHARSET);

	runquery($sql);
	dir_clear(UC_ROOT.'./data/view');
	dir_clear(UC_ROOT.'./data/cache');
	if(is_dir(UC_ROOT.'./plugin/setting')) {
		dir_clear(UC_ROOT.'./plugin/setting');
		@unlink(UC_ROOT.'./plugin/setting/index.htm');
		@rmdir(UC_ROOT.'./plugin/setting');
	}

	//note 升级uc_applications.viewprourl
	$db->query("UPDATE ".UC_DBTABLEPRE."applications SET viewprourl='/space.php?uid=%s'");
	$query = $db->query("SELECT * FROM ".UC_DBTABLEPRE."applications");
	while($app = $db->fetch_array($query)) {
		if(authcode($app['authkey'], 'DECODE', UC_MYKEY)) continue;
		$authkey = authcode($app['authkey'], 'ENCODE', UC_MYKEY);
		$appid = $app['appid'];
		$db->query("UPDATE ".UC_DBTABLEPRE."applications SET authkey='$authkey' WHERE appid='$appid'");
	}

	header("Location: upgrade2.php?action=pm&forward=".urlencode($forward));

} elseif($action == 'pm') {

	showheader();

	echo "<h4>处理短消息数据</h4>";

	$db = new db;
	$db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBCHARSET);

	$total = getgpc('total');
	$start = intval(getgpc('start'));
	$limit = 1000;
	if(!$total) {
		$total = $db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."pms WHERE related=0");
	}

	if(!$total || $total <= $start) {
		$db->query("REPLACE INTO ".UC_DBTABLEPRE."settings (k, v) VALUES('version', '1.5.0')");//note 记录数据库版本
		@touch($lock_file);
		if($forward) {
			echo "<br /><br /><br /><a href=\"$forward\">浏览器会自动跳转页面，无需人工干预。除非当您的浏览器长时间没有自动跳转时，请点击这里</a>";
			echo "<script>setTimeout(\"redirect('$forward');\", 1250);</script>";
		} else {
			echo "升级完成。";
		}
	} else {
		$query = $db->query("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE related=0 LIMIT $start, $limit");
		while($data = $db->fetch_array($query)) {
			$data['msgfrom'] = addslashes($data['msgfrom']);
			$data['subject'] = addslashes($data['subject']);
			$data['message'] = addslashes($data['message']);
			$db->query("REPLACE INTO ".UC_DBTABLEPRE."pms SET msgfrom='$data[msgfrom]',
				msgfromid='$data[msgfromid]',msgtoid='$data[msgtoid]',folder='$data[folder]',new='$data[new]',subject='$data[subject]',
				dateline='$data[dateline]',message='$data[message]',delstatus='$data[delstatus]',related='".time()."'", 'SILENT');
		}
	
		$end = $start + $limit;
		echo "短消息数据已处理 $start / $total ...";
		$url_forward = "upgrade2.php?action=pm&start=$end&total=$total&forward=".urlencode($forward);
		echo "<br /><br /><br /><a href=\"$url_forward\">浏览器会自动跳转页面，无需人工干预。除非当您的浏览器长时间没有自动跳转时，请点击这里</a>";
		echo "<script>setTimeout(\"redirect('$url_forward');\", 1250);</script>";
	}

	showfooter();

} elseif($action == 'upgsecques') {

	$lock_file = UC_ROOT.'./data/upgsecques.lock';
	if(file_exists($lock_file)) {
		showheader();
		showerror('升级被锁定，应该是已经升级过了安全提问，如果已经恢复数据请手动删除<br />'.str_replace(UC_ROOT, '', $lock_file).'<br />之后再来刷新页面');
	}
	$uc_authcode = getgpc('uc_authcode', 'C');

	if(empty($uc_authcode) || authcode($uc_authcode, 'DECODE', UC_KEY) != UC_FOUNDERPW) {
		$uc_founderpw = getgpc('uc_founderpw');
		if(empty($uc_founderpw) || UC_FOUNDERPW !=  md5(md5($uc_founderpw).UC_FOUNDERSALT)) {
			echo '<form method="post">';
			echo '请输入UCenter创始人密码:<input type="password" name="uc_founderpw" /> <input type="submit" value="提交" />';
			exit;
		} else {
			setcookie('uc_authcode', authcode(UC_FOUNDERPW, 'ENCODE', UC_KEY));
			header("Location: upgrade2.php?action=upgsecques");
			exit;
		}
	}

	if(!is_dir(UC_ROOT.'./data/upgsecques')) {
		showheader();
		showerror('请先将论坛下 ./forumdata/upgsecques 目录上传到UCenter 目录 ./data/ 下，之后<a href="javascript:location.reload();" target="_self">刷新此页面</a>');
	}
	$num = getgpc('num');
	$num = $num ? intval($num) : 1;
	$random = getgpc('random');
	if(empty($random)) {
		$dir = UC_ROOT.'./data/upgsecques';
		$directory = dir($dir);
		while($entry = $directory->read()) {
			if(preg_match('/^secques_(\w+)_\d+/', $entry, $match)) {
				break;
			}
		}
		$random = $match[1];
	};

	$dump_file = UC_ROOT.'./data/upgsecques/secques_'.$random.'_'.$num.'.sql';
	if(!file_exists($dump_file)) {//note 升级完毕
		@touch($lock_file);
		dir_clear(UC_ROOT.'./data/upgsecques');
		setcookie('uc_authcode', '');
		showheader();
		echo '安全提问升级完成，感谢您使用本程序';
	} else {
		showheader();
		$sql = file_get_contents($dump_file);
		$db = new db;
		$db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBCHARSET);
		runquery($sql);
		$num++;
		echo "安全提问正在导入";
		$url_forward = "upgrade2.php?action=upgsecques&num=$num&random=$random";
		echo "<br /><br /><br /><a href=\"$url_forward\">浏览器会自动跳转页面，无需人工干预。除非当您的浏览器长时间没有自动跳转时，请点击这里</a>";
		echo "<script>setTimeout(\"redirect('$url_forward');\", 1250);</script>";
	}

	showfooter();

}

function dir_clear($dir) {
	$directory = dir($dir);
	while($entry = $directory->read()) {
		$filename = $dir.'/'.$entry;
		if(is_file($filename)) {
			@unlink($filename);
		}
	}
	@touch($dir.'/index.htm');
	$directory->close();
}

function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
	if($numeric) {
		$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
	} else {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
	}
	return $hash;
}

function generate_key() {
	$random = random(32);
	$info = md5($_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_PORT'].$_SERVER['HTTP_USER_AGENT'].time());
	$return = '';
	for($i=0; $i<64; $i++) {
		$p = intval($i/2);
		$return[$i] = $i % 2 ? $random[$p] : $info[$p];
	}
	return implode('', $return);
}

function createtable($sql, $dbcharset) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	(mysql_get_server_info() > '4.1' ? " ENGINE=$type default CHARSET=".UC_DBCHARSET : " TYPE=$type");
}

function runquery($query) {
	global $db;

	$query = str_replace("\r", "\n", str_replace(' uc_', ' '.UC_DBTABLEPRE, $query));
	$expquery = explode(";\n", $query);

	foreach($expquery as $sql) {
		$sql = trim($sql);
		if($sql == '' || $sql[0] == '#') continue;

		if(strtoupper(substr($sql, 0, 12)) == 'CREATE TABLE') {
			$db->query(createtable($sql, UC_DBCHARSET));
		} elseif (strtoupper(substr($sql, 0, 11)) == 'ALTER TABLE') {
			runquery_altertable($sql);
		} else {
			$db->query($sql);
		}
	}
}

function getgpc($k, $var='R') {
	switch($var) {
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? $var[$k] : NULL;
}

function showheader() {
	global $version_old, $version_new;

	$charset = UC_CHARSET;
	print <<< EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=$charset" />
<title>UCenter 升级程序( $version_old &gt;&gt; $version_new)</title>
<meta name="MSSmartTagsPreventParsing" content="TRUE">
<meta http-equiv="MSThemeCompatible" content="Yes">
<style>
a:visited	{color: #FF0000; text-decoration: none}
a:link		{color: #FF0000; text-decoration: none}
a:hover		{color: #FF0000; text-decoration: underline}
body,table,td	{color: #3a4273; font-family: Tahoma, verdana, arial; font-size: 12px; line-height: 20px; scrollbar-base-color: #e3e3ea; scrollbar-arrow-color: #5c5c8d}
input		{color: #085878; font-family: Tahoma, verdana, arial; font-size: 12px; background-color: #3a4273; color: #ffffff; scrollbar-base-color: #e3e3ea; scrollbar-arrow-color: #5c5c8d}
.install	{font-family: Arial, Verdana; font-size: 14px; font-weight: bold; color: #000000}
.header		{font: 12px Tahoma, Verdana; font-weight: bold; background-color: #3a4273 }
.header	td	{color: #ffffff}
.red		{color: red; font-weight: bold}
.bg1		{background-color: #e3e3ea}
.bg2		{background-color: #eeeef6}
</style>
</head>

<body bgcolor="#3A4273" text="#000000">
<script type="text/javascript">
	function redirect(url) {
		window.location=url;
	}
</script>
<table width="95%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
<tr>
<td>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td class="install" height="30" valign="bottom"><font color="#FF0000">&gt;&gt;</font>
UCenter  升级程序( $version_old &gt;&gt; $version_new)</td>
</tr>
<tr>
<td>
<hr noshade align="center" width="100%" size="1">
</td>
</tr>
<tr>
<td align="center">
<b>本升级程序只能从 $version_old 升级到 $version_new ，运行之前，请确认已经上传所有文件，并做好数据备份<br />
升级当中有任何问题请访问技术支持站点 <a href="http://www.discuz.net" target="_blank">http://www.discuz.net</a></b>
</td>
</tr>
<tr>
<td>
<hr noshade align="center" width="100%" size="1">
</td>
</tr>
<tr><td>
EOT;
}

function showfooter() {
	echo <<< EOT
</td></tr></table></td></tr>
<tr><td height="100%">&nbsp;</td></tr>
</table>
</body>
</html>
EOT;
	exit();
}

function showerror($message, $break = 1) {
	echo '<br /><br />'.$message.'<br /><br />';
	if($break) showfooter();
}

function redirect($url) {

	$url = $url.(strstr($url, '&') ? '&' : '?').'t='.time();

	echo <<< EOT
<hr size=1>
<script language="JavaScript">
	function redirect() {
		window.location.replace('$url');
	}
	setTimeout('redirect();', 1000);
</script>
<br /><br />
&gt;&gt;<a href="$url">浏览器会自动跳转页面，无需人工干预。除非当您的浏览器长时间没有自动跳转时，请点击这里</a>
<br /><br />
EOT;
	showfooter();
}

function get_table_columns($table) {
	global $db;
	$tablecolumns = array();
	if($db->version() > '4.1') {
		$query = $db->query("SHOW FULL COLUMNS FROM $table", 'SILENT');
	} else {
		$query = $db->query("SHOW COLUMNS FROM $table", 'SILENT');
	}
	while($field = @$db->fetch_array($query)) {
		$tablecolumns[$field['Field']] = $field;
	}
	return $tablecolumns;
}

function parse_alter_table_sql($s) {
	$arr = array();
	preg_match("/ALTER TABLE (\w+)/i", $s, $m);
	$tablename = substr($m[1], strlen(UC_DBTABLEPRE));
	preg_match_all("/add column (\w+) ([^\n;]+)/is", $s, $add);
	preg_match_all("/drop column (\w+)([^\n;]*)/is", $s, $drop);
	preg_match_all("/change (\w+) ([^\n;]+)/is", $s, $change);
	preg_match_all("/add key ([^\n;]+)/is", $s, $keys);
	preg_match_all("/add unique ([^\n;]+)/is", $s, $uniques);
	foreach($add[1] as $k => $colname) {
		$attr = preg_replace("/(.+),$/", "\\1", trim($add[2][$k]));
		$arr[] = array($tablename, 'ADD', $colname, $attr);
	}
	foreach($drop[1] as $k => $colname) {
		$attr = preg_replace("/(.+),$/", "\\1", trim($drop[2][$k]));
		$arr[] = array($tablename, 'DROP', $colname, $attr);
	}
	foreach($change[1] as $k => $colname) {
		$attr = preg_replace("/(.+),$/", "\\1", trim($change[2][$k]));
		$arr[] = array($tablename, 'CHANGE', $colname, $attr);
	}
	foreach($keys[1] as $k => $colname) {
		$attr = preg_replace("/(.+),$/", "\\1", trim($keys[0][$k]));
		$arr[] = array($tablename, 'INDEX', '', $attr);
	}
	foreach($uniques[1] as $k => $colname) {
		$attr = preg_replace("/(.+),$/", "\\1", trim($uniques[0][$k]));
		$arr[] = array($tablename, 'INDEX', '', $attr);
	}
	return $arr;
}

function runquery_altertable($sql) {
	global $db;
	$tablepre = UC_DBTABLEPRE;
	$dbcharset = UC_DBCHARSET;

	$updatesqls = parse_alter_table_sql($sql);

	foreach($updatesqls as $updatesql) {
		$successed = TRUE;

		if(is_array($updatesql) && !empty($updatesql[0])) {

			list($table, $action, $field, $sql) = $updatesql;

			if(empty($field) && !empty($sql)) {

				$query = "ALTER TABLE {$tablepre}{$table} ";
				if($action == 'INDEX') {
					$successed = $db->query("$query $sql", "SILENT");
				} elseif ($action == 'UPDATE') {
					$successed = $db->query("UPDATE {$tablepre}{$table} SET $sql", 'SILENT');
				}

			} elseif($tableinfo = get_table_columns($tablepre.$table)) {

				$fieldexist = isset($tableinfo[$field]) ? 1 : 0;

				$query = "ALTER TABLE {$tablepre}{$table} ";

				if($action == 'MODIFY') {

					$query .= $fieldexist ? "MODIFY $field $sql" : "ADD $field $sql";
					$successed = $db->query($query, 'SILENT');

				} elseif($action == 'CHANGE') {

					$field2 = trim(substr($sql, 0, strpos($sql, ' ')));
					$field2exist = isset($tableinfo[$field2]);

					if($fieldexist && ($field == $field2 || !$field2exist)) {
						$query .= "CHANGE $field $sql";
					} elseif($fieldexist && $field2exist) {
						$db->query("ALTER TABLE {$tablepre}{$table} DROP $field2", 'SILENT');
						$query .= "CHANGE $field $sql";
					} elseif(!$fieldexist && $fieldexist2) {
						$db->query("ALTER TABLE {$tablepre}{$table} DROP $field2", 'SILENT');
						$query .= "ADD $sql";
					} elseif(!$fieldexist && !$field2exist) {
						$query .= "ADD $sql";
					}
					$successed = $db->query($query);

				} elseif($action == 'ADD') {

					$query .= $fieldexist ? "CHANGE $field $field $sql" :  "ADD $field $sql";
					$successed = $db->query($query);

				} elseif($action == 'DROP') {
					if($fieldexist) {
						$successed = $db->query("$query DROP $field", "SILENT");
					}
					$successed = TRUE;
				}

			} else {

				$successed = 'TABLE NOT EXISTS';

			}
		}
	}
	return $successed;
}

function upg_pms() {
	global $db;
	$query = $db->query("SELECT * FROM ".UC_DBTABLEPRE."pms WHERE related=0");
	while($data = $db->fetch_array($query)) {
		$data['msgfrom'] = addslashes($data['msgfrom']);
		$data['subject'] = addslashes($data['subject']);
		$data['message'] = addslashes($data['message']);
		$db->query("REPLACE INTO ".UC_DBTABLEPRE."pms SET msgfrom='$data[msgfrom]',
			msgfromid='$data[msgfromid]',msgtoid='$data[msgtoid]',folder='$data[folder]',new='$data[new]',subject='$data[subject]',
			dateline='$data[dateline]',message='$data[message]',delstatus='$data[delstatus]',related='".time()."'", 'SILENT');
	}
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
	// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

?>