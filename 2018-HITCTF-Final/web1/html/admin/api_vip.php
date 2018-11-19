<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源站一键采集接口</title>
<script src="skin/js/common.js" type="text/javascript"></script>
<script src="skin/js/main.js" type="text/javascript"></script>
<script src="skin/js/drag.js" type="text/javascript"></script>
<link type="text/css" href="skin/images/alerts.css" rel="stylesheet" media="screen">

<link  href="skin/css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
tr a {
	font-size: 12px;
	color: #666;
}
tr a:link {
	text-decoration: none;
}
tr a:visited {
	text-decoration: none;
	color: #666;
}
tr a:hover {
	text-decoration: underline;
	color: #FF0000;
}
tr a:active {
	text-decoration: none;
	color: #f60;
}
tr{}
td{ background-color: #fff; height:30px; line-height:30px;font-size: 12px; color: #333;border:1px solid #E7E8EA;text-align:center;}
.bi{width:70%;text-align:left;padding-left:10px;}
.b2{text-align:left;padding-left:10px; color: #333;}
.der{border:1px solid #E7E8EA;}
</style>
</head>
<body oncontextmenu="return false" onselectstart="return false">
<!--当前导航-->
<script type="text/JavaScript">if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='后台首页&nbsp;&raquo;&nbsp;采集&nbsp;&raquo;&nbsp;第三方资源库 ';</script>
<?php
require_once(dirname(__FILE__)."/config.php");
require_once(duomi_DATA."/mark/inc_photowatermark_config.php");
CheckPurview();
if(RWCache('collect_xml'))
echo "<script>openCollectWin(400,'auto','上次采集未完成，继续采集？','".RWCache('collect_xml')."')</script>";
?>
<font style="margin-left:15px" color="red">友情提示：未授权用户无法获取资源，采集前请先绑定分类</font>
<style type="text/css">
tr a {
	font-size: 12px;
	color: #666;
}
tr a:link {
	text-decoration: none;
}
tr a:visited {
	text-decoration: none;
	color: #666;
}
tr a:hover {
	text-decoration: underline;
	color: #FF0000;
}
tr a:active {
	text-decoration: none;
	color: #f60;
}
tr{}
td{ background-color: #fff; height:30px; line-height:30px;font-size: 12px; color: #333;border:1px solid #E7E8EA;text-align:center;}
.bi{width:68%;text-align:left;padding-left:10px;}
.b2{text-align:left;padding-left:10px; color: #333;}
.der{border:1px solid #E7E8EA;}
</style>
<div class="S_info">&nbsp;【公告】<script language="javascript" type="text/javascript" src="http://duomicms.net/api/vip.js"></script> </div>
<div style="height:10px; clear:both;">&nbsp;</div>
<table width="99%"  align="center" cellpadding="0" cellspacing="0" border="0" class="tb_style">

  <tr>
    <td>1</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=youku&amp;url=http://api.bjfenlin.com/inc/api.php">【优酷资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=youku&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=youku&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=youku&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=youku&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>2</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=mgtv&amp;url=http://api.bjfenlin.com/inc/api.php">【芒果资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=mgtv&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=mgtv&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=mgtv&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=mgtv&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>3</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=tudou&amp;url=http://api.bjfenlin.com/inc/api.php">【土豆资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=tudou&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=tudou&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=tudou&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=tudou&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>4</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=qq&amp;url=http://api.bjfenlin.com/inc/api.php">【腾讯资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=qq&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=qq&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=qq&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=qq&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>5</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=letv&amp;url=http://api.bjfenlin.com/inc/api.php">【乐视资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=letv&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=letv&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=letv&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=letv&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>6</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=sohu&amp;url=http://api.bjfenlin.com/inc/api.php">【搜狐资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=sohu&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=sohu&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=sohu&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=sohu&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>7</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=qiyi&amp;url=http://api.bjfenlin.com/inc/api.php">【奇艺资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=qiyi&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=qiyi&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=qiyi&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=qiyi&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>8</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=pptv&amp;url=http://api.bjfenlin.com/inc/api.php">【PPTV资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=pptv&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=pptv&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=pptv&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=pptv&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>9</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=kankan&amp;url=http://api.bjfenlin.com/inc/api.php">【迅雷看看】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=kankan&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=kankan&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=kankan&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=kankan&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

    <tr>
    <td>10</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=m1905&amp;url=http://api.bjfenlin.com/inc/api.php">【电影网】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=m1905&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=m1905&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=m1905&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=m1905&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

      <tr>
    <td>11</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=funshion&amp;url=http://api.bjfenlin.com/inc/api.php">【风行视频】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=funshion&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=funshion&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=funshion&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=funshion&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

      <tr>
    <td>12</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=ykyun&amp;url=http://api.bjfenlin.com/inc/api.php">【优酷云资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=ykyun&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=ykyun&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=ykyun&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=ykyun&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>


        <tr>
    <td>13</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=xigua&amp;url=http://api.bjfenlin.com/inc/api.php">【西瓜资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=xigua&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=xigua&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=xigua&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=xigua&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

        <tr>
    <td>14</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=jjvod&amp;url=http://api.bjfenlin.com/inc/api.php">【吉吉资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=jjvod&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=jjvod&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=jjvod&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=jjvod&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

        <tr>
    <td>15</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=xfplay&amp;url=http://api.bjfenlin.com/inc/api.php">【先锋资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=xfplay&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=xfplay&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=xfplay&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=xfplay&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>

        <tr>
    <td>16</td>
    <td class="bi"><a href="admin_reslib.php?ac=list&amp;rid=ffhd&amp;url=http://api.bjfenlin.com/inc/api.php">【非凡资源】无毒、无广告、无弹窗、质量高、稳定、快速、更新快！</a></td>
    <td><a href="admin_reslib.php?ac=day&amp;rid=ffhd&amp;url=http://api.bjfenlin.com/inc/api.php">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&amp;rid=ffhd&amp;url=http://api.bjfenlin.com/inc/api.php">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&amp;rid=ffhd&amp;url=http://api.bjfenlin.com/inc/api.php">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&amp;rid=ffhd&amp;url=http://api.bjfenlin.com/inc/api.php">分类绑定</a></td>
  </tr>
</table>
<script language="javascript" type="text/javascript" src="http://js.users.51.la/18779617.js"></script>
<?php
exit();
?>
</body>
</html>