<?php
header('Content-Type:text/html;charset=utf-8');
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if($action=="set")
{
	$v= $_POST['v'];
	$ip = $_POST['ip'];
	$open=fopen("../data/admin/ip.php","w" );
	$str='<?php ';
	$str.='$v = "';
	$str.="$v";
	$str.='"; ';
	$str.='$ip = "';
	$str.="$ip";
	$str.='"; ';
	$str.=" ?>";
	fwrite($open,$str);
	fclose($open);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台IP安全设置</title>
<link  href="img/admin.css" rel="stylesheet" type="text/css" />
<link  href="img/style.css" rel="stylesheet" type="text/css" />
<script src="js/common.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
<script type="text/JavaScript">if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='后台首页&nbsp;&raquo;&nbsp;管理员&nbsp;&raquo;&nbsp;后台IP安全设置 ';</script>
<div class="r_main">
  <div class="r_content">
    <div class="r_content_1">
<form action="admin_ip.php?action=set" method="post">	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb_style">
<tbody><tr class="thead">
<td colspan="5">后台IP安全设置</td>
</tr>
<tr>
<td width="80%" align="left" height="30" class="td_btop3">
<?php require_once("../data/admin/ip.php"); ?>
功能开关：
<input type="radio" name="v" value="0" <?php if($v==0) echo 'checked';?>>关闭
&nbsp;&nbsp;
<input type="radio" name="v" value="1" <?php if($v==1) echo 'checked';?>>开启
 * 是否启用ip限制，启用后非登记ip无法访问网站后台 
</td>
</tr>

<tr>
<td width="80%" align="left" height="30" class="td_btop3">
允许IP：<textarea name="ip" style="width:500px; height:50px;"><?php echo $ip;?></textarea>
 * 允许设置多个ip，每行一个
</td>
</tr>

<tr>
<td width="10%" align="left" height="30" class="td_btop3">
<input type="submit" value="确认" class="btn" >
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td_btop3">
* 开启该功能后，将只允许已登记的ip地址访问后台，如上网ip不固定，请勿开启。
</td>
</tr>
<tr>
<td width="90%" align="left" height="30" class="td_btop3">
* 如果上网ip变化导致无法登陆后台，请手动修改/data/admin/ip.php文件内容，$v = "0"表示关闭该功能。
</td>
</tr>
</tbody></table>	
	

</form>
</div>
	</div>
</div>
<?php
viewFoot();
?>
</body>
</html>