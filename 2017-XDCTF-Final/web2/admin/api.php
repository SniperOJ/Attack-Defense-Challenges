<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源站一键采集接口</title>
<script src="js/common.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<script src="js/drag.js" type="text/javascript"></script>
<link type="text/css" href="img/alerts.css" rel="stylesheet" media="screen">
<script language="javascript">
</script>
<link  href="img/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.list td{ background-color: #fff; height:40px; line-height:40px;font-size: 12px; color: #333;border:1px solid #E7E8EA;text-align:center;}
.list .bi{text-align:left;padding-left:10px;}
.list .b2{text-align:left;padding-left:10px; color: #333;}
.list .der{border:1px solid #E7E8EA;}
</style>
</head>
<body>
<!--当前导航-->
<script type="text/JavaScript">if(parent.$('admincpnav')) parent.$('admincpnav').innerHTML='后台首页&nbsp;&raquo;&nbsp;采集&nbsp;&raquo;&nbsp;资源库列表 ';</script>
<?php
require_once(dirname(__FILE__)."/config.php");
require_once(sea_DATA."/mark/inc_photowatermark_config.php");
CheckPurview();
if(RWCache('collect_xml'))
echo "<script>openCollectWin(400,'auto','上次采集未完成，继续采集？','".RWCache('collect_xml')."')</script>";
?>
<div class="S_info">&nbsp;资源库列表</div>
<table width="98%"  align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff" style="margin-top:15px; margin-left:10px;" id="list" class="list">
<?php
$sqlStr="select * from `sea_zyk` order by zid ASC";
$dsql->SetQuery($sqlStr);
$dsql->Execute('flink_list');
while($row=$dsql->GetObject('flink_list'))
{
$aid=$row->id;
?>
  <tr>
    <td width="20"><?php echo $row->zid; ?></td>
    <td class="bi"><a href="admin_reslib.php?ac=list&rid=<?php echo $row->zid; ?>&url=<?php echo $row->zapi; ?>"><strong>【<?php echo $row->zname; ?>】</strong><?php echo $row->zinfo; ?></a></td>
    <td><a href="admin_reslib.php?ac=day&rid=<?php echo $row->zid; ?>&url=<?php echo $row->zapi; ?>">采集当天</a></td>
    <td><a href="admin_reslib.php?ac=week&rid=<?php echo $row->zid; ?>&url=<?php echo $row->zapi; ?>">采集本周</a></td>
    <td><a href="admin_reslib.php?ac=all&rid=<?php echo $row->zid; ?>&url=<?php echo $row->zapi; ?>">采集所有</a></td>
    <td><a href="admin_reslib.php?ac=list&rid=<?php echo $row->zid; ?>&url=<?php echo $row->zapi; ?>">分类绑定</a></td>
  </tr>
<?php
}
?>  
</table>
<script language="JavaScript" type="text/javascript" charset="utf-8" src="http://www.seacms.net/api/union.js"></script>
<div style="height:30px; clear:both;"> </div>
<?php
viewFoot();exit();	
?>
</body>
</html>
