<?php
include("admin.php");
include("../3/ucenter_api/config.inc.php");
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php

if (isset($_POST["action"])){
$action=$_POST["action"];
}else{
$action="";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">UCenter(v1.6)数据库链接设置</td>
  </tr>
</table>
<?php
if ($action=="saveconfig") {
checkadminisdo("siteconfig");
saveconfig();
}else{
showconfig();
}

function showconfig(){
?>
<form method="POST" action="?" id="form1" name="form1">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="30%" align="right" class="border">连接 UCenter 的方式: mysql/NULL</td>
      <td width="70%" class="border"><input name="UC_CONNECT" type="text" id="UC_CONNECT" value="<?php echo UC_CONNECT?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库主机</td>
      <td class="border"><input name="UC_DBHOST" type="text" id="UC_DBHOST" value="<?php echo UC_DBHOST?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库用户名</td>
      <td class="border"><input name="UC_DBUSER" type="text" id="UC_DBUSER" value="<?php echo UC_DBUSER?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库密码</td>
      <td class="border"><input name="UC_DBPW" type="text" id="dllisttitle2" value="<?php echo UC_DBPW?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库名称</td>
      <td class="border"><input name="UC_DBNAME" type="text" id="dlshowtitle2" value="<?php echo UC_DBNAME?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库字符集</td>
      <td class="border"><input name="UC_DBCHARSET" type="text" id="zhlisttitle2" value="<?php echo UC_DBCHARSET?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 数据库表前缀</td>
      <td class="border"><input name="UC_DBTABLEPRE" type="text" id="zhshowtitle2" value="<?php echo UC_DBTABLEPRE?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2">通信相关</td>
    </tr>
    <tr> 
      <td align="right" class="border">与 UCenter 的通信密钥, 要与 UCenter 保持一致</td>
      <td class="border"><input name="UC_KEY" type="text" id="zxshowtitle2" value="<?php echo UC_KEY?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border"> UCenter 的 URL 地址, 在调用头像时依赖此常量(必填，否则不能同步登录)</td>
      <td class="border"><input name="UC_API" type="text" id="companylisttitle2" value="<?php echo UC_API?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">UCenter 的字符集</td>
      <td class="border"><input name="UC_CHARSET" type="text" id="companyshowtitle2" value="<?php echo UC_CHARSET?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">UCenter 的 IP<br>
        当 UC_CONNECT 为非 mysql 方式时,
      并且当前应用服务器解析域名有问题时, 请设置此值</td>
      <td class="border"><input name="UC_IP" type="text" id="companyshowtitle2" value="<?php echo UC_IP?>" size="50" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border">当前应用的 ID</td>
      <td class="border"><input name="UC_APPID" type="text" id="companyshowtitle2" value="<?php echo UC_APPID?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input name="submit" type="submit" class="buttons" value=" 保存设置 " > 
        <input name="action" type="hidden" id="action" value="saveconfig"></td>
    </tr>
  </table>
<?php
}
?>
</form>
</body>
</html>
<?php
function SaveConfig(){
	$fpath="../3/ucenter_api/config.inc.php";
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	$fcontent="<" . "?php\r\n";
			
	$fcontent=$fcontent. "define('UC_CONNECT','".trim($_POST['UC_CONNECT'])."') ;//连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen(),为了效率, 建议采用 mysql\n";
	$fcontent=$fcontent. "define('UC_DBHOST','". trim($_POST['UC_DBHOST'])."') ;//UCenter 数据库主机\n";
	$fcontent=$fcontent. "define('UC_DBUSER','". trim($_POST['UC_DBUSER'])."') ;//UCenter 数据库用户名\n";
	$fcontent=$fcontent. "define('UC_DBPW','". trim($_POST['UC_DBPW'])."') ;//UCenter 数据库密码\n";
	$fcontent=$fcontent. "define('UC_DBNAME','". trim($_POST['UC_DBNAME'])."') ;//UCenter 数据库名称\n";
	$fcontent=$fcontent. "define('UC_DBCHARSET','". trim($_POST['UC_DBCHARSET'])."') ;//UCenter 数据库字符集\n";
	$fcontent=$fcontent. "define('UC_DBTABLEPRE','". trim($_POST['UC_DBTABLEPRE'])."') ;//UCenter 数据库表前缀\n";
	$fcontent=$fcontent. "define('UC_KEY','". trim($_POST['UC_KEY'])."') ;//与 UCenter 的通信密钥, 要与 UCenter 保持一致\n";
	$fcontent=$fcontent. "define('UC_API','". trim($_POST['UC_API'])."') ;// UCenter 的 URL 地址, 在调用头像时依赖此常量\n";
	$fcontent=$fcontent. "define('UC_CHARSET','". trim($_POST['UC_CHARSET'])."') ;//UCenter 的字符集\n";
	$fcontent=$fcontent. "define('UC_IP','". trim($_POST['UC_IP'])."') ;//UCenter的IP, 当UC_CONNECT为非mysql方式时, 并且当前应用服务器解析域名有问题时, 请设置此值\n";
	$fcontent=$fcontent. "define('UC_APPID','". trim($_POST['UC_APPID'])."') ;//当前应用的 ID\n";

$fcontent=$fcontent. "//ucexample_2.php 用到的应用程序数据库连接参数\n";
$fcontent=$fcontent. "$"."dbhost = '".sqlhost."';			// 数据库服务器\n";//注意变量写入的方法，用网站配置文件中的常量给变量赋值
$fcontent=$fcontent. "$"."dbuser = '".sqluser."';			// 数据库用户名\n";
$fcontent=$fcontent. "$"."dbpw = '".sqlpwd."';				// 数据库密码\n";
$fcontent=$fcontent. "$"."dbname = '';			// 数据库名\n";
$fcontent=$fcontent. "$"."pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开\n";
$fcontent=$fcontent. "$"."tablepre = '';   		// 表名前缀, 同一数据库安装多个论坛请修改此处\n";
$fcontent=$fcontent. "$"."dbcharset = '';			// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定\n";
$fcontent=$fcontent. "//同步登录 Cookie 设置\n";
$fcontent=$fcontent. "$"."cookiedomain = '".siteurl."'; 			// cookie 作用域\n";
$fcontent=$fcontent. "$"."cookiepath = '/';			// cookie 作用路径\n";

	$fcontent=$fcontent. "?" . ">";
	fputs($fp,$fcontent);//把替换后的内容写入文件
	fclose($fp);
	echo  "<script>alert('设置成功');location.href='?'</script>";
}
?>