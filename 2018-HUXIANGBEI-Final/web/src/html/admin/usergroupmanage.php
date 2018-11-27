<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if ($action=="del"){
checkadminisdo("siteconfig");
$groupid=trim($_REQUEST["groupid"]);
if  ($groupid<>"") {
	query("delete from zzcms_usergroup where groupid='$groupid'");
}
echo "<script>location.href='usergroupmanage.php'</script>";      
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig(){
   if(confirm("确定要删除此用户组吗！"))
     return true;
   else
     return false;	 
}
</script>
<div class="admintitle">用户组管理</div>
<div class="border center"><input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='usergroupadd.php'" value="添加用户组"></div>
<?php
$sql="select * from zzcms_usergroup";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo "暂无信息";
}else{
?>

<table width="100%" border="0" cellpadding="5" cellspacing="1" >
  <tr> 
    <td width="126" height="25" align="center" class="border"><strong>用户组名称</strong></td>
    <td width="93" align="center" class="border"><strong>等级图片</strong></td>
    <td width="84" align="center" class="border"><strong>用户组ID</strong></td>
    <td width="93" align="center" class="border"><strong>所需费用</strong></td>
    <td width="315" align="center" class="border"><strong>用户权限</strong><br>
      (注：没有相应权限的用户组，可用积分换得相应权限，关闭<a href="SiteConfig.php#userjf" target="_self">积分功能</a>后，则不再有此权限。)</td>
    <td width="241" height="25" align="center" class="border"><strong>操作选项</strong></td>
  </tr>
  <?php
while($row=fetch_array($rs)){
?>
   <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
    <td width="126" height="22" align="center"><?php echo $row["groupname"]?></td>
    <td width="93" height="22" align="center"><img src="../<?php echo $row["grouppic"]?>"></td>
    <td width="84" height="22" align="center"><?php echo $row["groupid"]?></td>
    <td width="93" height="22" align="center"><?php echo $row["RMB"]?>积分/年</td>
    <td width="315" height="22"> <table width="100%" border="0" cellpadding="3" cellspacing="0">
        <tr> 
          <td width="75%" align="right">查看<?php echo channeldl?>商信息库联系方式：</td>
          <td width="25%"> 
            <?php if (strpos($row["config"],'look_dls_data')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">查看<?php echo channeldl?>商留言联系方式：</td>
          <td> 
            <?php if (strpos($row["config"],'look_dls_liuyan')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">显示注册信息的联系方式：</td>
          <td> 
            <?php if (strpos($row["config"],'showcontact')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">打印<?php echo channeldl?>商留言：</td>
          <td> 
            <?php if (strpos($row["config"],'dls_print')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">下载<?php echo channeldl?>商留言：</td>
          <td> 
            <?php if (strpos($row["config"],'dls_download')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">绑定手机：</td>
          <td> 
            <?php if (strpos($row["config"],'set_mobile')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">抢占广告位：</td>
          <td> 
            <?php if (strpos($row["config"],'set_text_adv')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">置顶信息：</td>
          <td> 
            <?php if (strpos($row["config"],'set_elite')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr>
          <td align="right">信息免审：</td>
          <td><?php if (strpos($row["config"],'passed')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr>
          <td align="right">上传视频：</td>
          <td><?php if (strpos($row["config"],'uploadflv')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr>
          <td align="right">seo：</td>
          <td><?php if (strpos($row["config"],'seo')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr>
          <td align="right">装修展厅：</td>
          <td><?php if (strpos($row["config"],'set_zt')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr>
          <td align="right">在展厅内显网站上其它用户的广告：</td>
          <td><?php if (strpos($row["config"],'showad_inzt')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>          </td>
        </tr>
        <tr> 
          <td align="right">每天刷新次数：</td>
          <td><?php echo $row["refresh_number"]?></td>
        </tr>
        <tr> 
          <td align="right">每天发布信息数/栏目：</td>
          <td><?php echo $row["addinfo_number"]?></td>
        </tr>
        <tr> 
          <td align="right">发布信息总数/栏目：</td>
          <td><?php echo $row["addinfototle_number"]?></td>
        </tr>
        <tr>
          <td align="right">每天查看<?php echo channeldl?>商信息数：</td>
          <td><?php if ($row["looked_dls_number_oneday"]==999 ){echo  "不限制"; }else{ echo $row["looked_dls_number_oneday"];}?>          </td>
        </tr>
        <tr> 
          <td align="right">选择招商展示页模板：</td>
          <td> 
            <?php if (strpos($row["config"],'zsshow_template')!==false){echo "<font color=green>√</font>"; }else{ echo"<font color=red>×</font>"; }?>         </td>
        </tr>
      </table></td>
    <td align="center" class="docolor"> <a href="usergroupmodify.php?id=<?php echo $row["id"]?>">修改</a> 
      | 
     <a href="?groupid=<?php echo $row["groupid"]?>&action=del" onClick="return ConfirmDelBig();">删除</a></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php
  }
?>