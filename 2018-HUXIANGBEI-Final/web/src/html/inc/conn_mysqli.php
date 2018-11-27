<?php
error_reporting(0);
define('zzcmsroot', str_replace("\\", '/', substr(dirname(__FILE__), 0, -3)));//-3截除当前目录inc
ini_set("date.timezone","Asia/Chongqing");//设时区。php.ini里date.timezone选项，默认情况下是关闭的
include(zzcmsroot."/inc/config.php");
include(zzcmsroot."/inc/wjt.php");
include(zzcmsroot."/inc/function.php");
include(zzcmsroot."/inc/zsclass.php");//分类招商在里面
include(zzcmsroot."/inc/stopsqlin.php");
include(zzcmsroot."/inc/area.php");
if (opensite=='No') {
	if (@checkadminlogin<>1) {
	WriteErrMsg(showwordwhenclose);
	exit();
	}
}
$file=zzcmsroot."/install/install.lock";//是否存在安装标识文件
$installdir=zzcmsroot."install";
if (file_exists($file)==false && is_dir($installdir) ){
WriteErrMsg("未检测到安装标识文件，<a href='http://".$_SERVER['HTTP_HOST']."/install/index.php'>点击运行安装向导</a>");
exit();
}

$conn=mysqli_connect(sqlhost,sqluser,sqlpwd,sqldb) or showmsg ("数据库链接失败");
mysqli_real_query($conn,"SET NAMES 'utf8'"); //必不可少，用来设置客户端送给MySQL服务器的数据的字符集
mysqli_select_db($conn,sqldb) or showmsg ("没有".sqldb."这个数据库,或是被管理员断开了链接,请稍后再试");
//lockip();
//if (isset($_SESSION["admin"])){
//admindo();//如果管理员登录，记录管理员操作记录
//}

  
//执行语句   
function query($sql){   
global $conn;
return mysqli_query($conn,$sql);     
}  

function num_rows($rs) {
return mysqli_num_rows($rs);
} 

function fetch_array($rs) {
return mysqli_fetch_array($rs);
}

function insert_id() {
global $conn;
return mysqli_insert_id($conn);
?>