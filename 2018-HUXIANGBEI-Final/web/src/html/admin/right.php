<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>后前管理首页</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top"> 
      <table width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr> 
          <td class="border" style="font-size:14px;line-height:25px;"> 
<?php
echo  "请先看看下面是否有需要您处理的工作。<br>";			
function checkisendsever()
{
//到期的招商产品取消推荐
query("update zzcms_main set elite=0 where eliteendtime< '".date('Y-m-d H:i:s')."'");
//检查到期的vip用户
$sql="select groupid,enddate,username from zzcms_user where groupid>1 and enddate<'".date('Y-m-d H:i:s')."'";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
while($row=fetch_array($rs)){
		query("update zzcms_user set groupid=1 where username='".$row["username"]."'"); 
		query("Update zzcms_main set groupid=1 where editor='" . $row["username"] . "'");
		query("Update zzcms_main set elite=0 where editor='" . $row["username"] . "'");	
}
}
echo "已完成";
}

$sql="select id from zzcms_usermessage where reply is null";
$rs=query($sql);
$row=num_rows($rs);
echo "用户返馈信息 ".$row." 条 [ <a href='usermessage.php'>查看</a> ]<br>";

$sql="select id from zzcms_user where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审注册用户 ".$row." 条 [ <a href='usermanage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_userdomain where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审域名绑定 ".$row." 条 [ <a href='domain_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_main where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审".channelzs."信息 ".$row." 条 [ <a href='zs_manage.php?shenhe=no'>查看</a> ]<br>";


if (str_is_inarr(channel,'pp')=='yes'){
$sql="select id from zzcms_pp where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审品牌信息 ".$row." 条 [ <a href='pp_manage.php?shenhe=no'>查看</a> ]<br>";
}

$sql="select id from zzcms_dl where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审".channeldl."信息 ".$row." 条 [ <a href='dl_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_guestbook where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审展厅留言 ".$row." 条 [ <a href='ztliuyan_manage.php?shenhe=no'>查看</a> ]<br>";

if (str_is_inarr(channel,'zh')=='yes'){
$sql="select id from zzcms_zh where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审展会信息 ".$row." 条 [ <a href='zh_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'zx')=='yes'){
$sql="select id from zzcms_zx where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审资讯信息 ".$row." 条 [ <a href='zx_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'wangkan')=='yes'){
$sql="select id from zzcms_wangkan where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审网刊信息 ".$row." 条 [ <a href='wangkan_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'baojia')=='yes'){
$sql="select id from zzcms_baojia where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审报价信息 ".$row." 条 [ <a href='baojia_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'special')=='yes'){
$sql="select id from zzcms_special where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审专题信息 ".$row." 条 [ <a href='special_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'job')=='yes'){
$sql="select id from zzcms_job where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审招聘信息 ".$row." 条 [ <a href='job_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'ask')=='yes'){
$sql="select id from zzcms_ask where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审问答信息 ".$row." 条 [ <a href='ask_manage.php?shenhe=no'>查看</a> ]<br>";
}

if (str_is_inarr(channel,'zx')=='yes'){
$sql="select id from zzcms_pinglun where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审评论信息 ".$row." 条 [ <a href='pinglun_manage.php?shenhe=no'>查看</a> ]<br>";
}

$sql="select id from zzcms_link where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审友情链接 ".$row." 个 [ <a href='linkmanage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_textadv where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审文字广告 ".$row." 个 [ <a href='ad_user_manage.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_licence where passed=0";
$rs=query($sql);
$row=num_rows($rs);
echo "待审资质证书 ".$row." 个 [ <a href='licence.php?shenhe=no'>查看</a> ]<br>";

$sql="select id from zzcms_ad where endtime< '".date('Y-m-d')."'";
$rs=query($sql);
$row=num_rows($rs);
echo "已到期的广告 ".$row." 条 [ <a href='ad_manage.php?action=showendtime'>查看</a> ]<br>";

$sql="select id from zzcms_usermessage where reply is null";
$rs=query($sql);
$row=num_rows($rs);
echo "未回复的反馈 ".$row." 条 [ <a href='usermessage.php?reply=no'>查看</a> ]<br>";

$sql="select id from zzcms_bad";
$rs=query($sql);
$row=num_rows($rs);
echo "不良操作记录 ".$row." 条 [ <a href='showbad.php'>查看</a> ]<br>";
?> </td>
        </tr>
        <tr>
          <td class="border" style="font-size:14px;line-height:25px;">
<?php 
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if ($action=="check") {
checkisendsever();
}else{
?>
<a href="?action=check">检查处理到期的注册用户，到期的<?php echo channelzs?>产品取消推荐</a>
<?php
}

?>	 
		  </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>