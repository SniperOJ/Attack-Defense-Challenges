<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<title></title>
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig()
{
   if(confirm("确定要删除此大类吗？删除此大类同时将删除所包含的小类，并且不能恢复！"))
     return true;
   else
     return false;
	 
}

function ConfirmDelSmall()
{
   if(confirm("确定要删除此小类吗？一旦删除将不能恢复！"))
     return true;
   else
     return false;
	 
}
</script>
</head>

<body>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if ($action=="px"){
checkadminisdo("zsclass");
$sqlb="Select * From zzcms_zsclass where parentid='A'";
$rsb=query($sqlb);
while($rowb= fetch_array($rsb)){

$xuhao=$_POST["xuhao".$rowb["classid"]];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhao) == "" ||  is_numeric($xuhao) == false){ 
	       $xuhao = 0;
		   }elseif ($xuhao < 0){
	       $xuhao = 0;
		   }else{
	       $xuhao = $xuhao;
	  		}
query("update zzcms_zsclass set xuhao='$xuhao' where classid='".$rowb['classid']."'");
$sqls="Select * From zzcms_zsclass where parentid='".$rowb['classzm']."'";
$rss=query($sqls);
while($rows= fetch_array($rss)){

$xuhaos=$_POST["xuhaos".$rows["classid"]];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhaos) == "" ||  is_numeric($xuhaos) == false){ 
	       $xuhaos = 0;
		   }elseif ($xuhaos < 0){
	       $xuhaos = 0;
		   }else{
	       $xuhaos = $xuhaos;
	   }
query("update zzcms_zsclass set xuhao='$xuhaos' where classid='".$rows['classid']."'");
}
}
}
if ($action=="delbig"){
checkadminisdo("zsclass");
$bigclassid=trim($_REQUEST["bigclassid"]);
if ($bigclassid<>""){
	query("delete from zzcms_zsclass where parentid='$bigclassid'");
	query("delete from zzcms_zsclass where classzm='$bigclassid'");
}
    
echo "<script>location.href='?'</script>";
}
if ($action=="delsmall"){
checkadminisdo("zsclass");
$SmallClassID=trim($_REQUEST["SmallClassID"]);
$bigclassid=trim($_REQUEST["bigclassid"]);//返回列表定位用
if ($SmallClassID<>""){
	query("delete from zzcms_zsclass where classid='$SmallClassID'");
}
echo "<script>location.href='?#B".$bigclassid."'</script>";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle"><?php echo channelzs?>信息类别设置</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" class="border"><input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='zsclassaddbig.php?dowhat=addbigclass'" value="添加大类"></td>
  </tr>
</table>
<?php
$sql="Select * From zzcms_zsclass where parentid='A' order by xuhao";
$rs=query($sql,$conn);
?>
<form name="form1" method="post" action="?action=px">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="18%" class="border" ><strong>类别名称</strong></td>
      <td width="18%" class="border" >拼音</td>
      <td width="18%" class="border" ><strong>排序</strong></td>
      <td width="19%" class="border" ><strong>大类属性</strong></td>
      <td width="27%" class="border" ><strong>操作</strong></td>
    </tr>
      <?php
	while($row= fetch_array($rs)){
?>
    <tr bgcolor="#F1F1F1"> 
      <td style="font-weight:bold"><a name="B<?php echo $row["classzm"]?>"></a><img src="image/icobig.gif" width="9" height="9"> 
        <?php echo $row["classname"]?></td>
      <td style="font-weight:bold"><?php echo $row["classzm"]?></td>
      <td width="18%" > <input name="<?php echo"xuhao".$row["classid"]?>" type="text"  value="<?php echo $row["xuhao"]?>" size="4"> 
        <input type="submit" name="Submit" value="更新序号"></td>
      <td width="19%" ><?php if ($row["isshow"]==1) { echo "首页显示";} else{echo "<font color=red>首页不显示</font>";}?></td>
      <td width="27%" >[ <a href="zsclassmodifybig.php?classid=<?php echo $row["classid"]?>">修改</a> 
        | <a href="?action=delbig&bigclassid=<?php echo $row["classzm"]?>" onClick="return ConfirmDelBig();">删除</a> 
        | <a href="zsclassaddsmall.php?bigclassid=<?php echo $row["classzm"]?>">添加子栏目</a> 
        ] </td>
    </tr>
    <?php
	$n=0;
	$sqln="Select * From zzcms_zsclass Where parentid='" .$row["classzm"]. "' order by xuhao";
	$rsn=query($sqln);	
	while($rown= fetch_array($rsn)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td ><a name="S<?php echo $rown["classid"]?>"></a><img src="image/icosmall.gif" width="23" height="11"> 
        <?php echo $rown["classname"]?></td>
      <td ><?php echo $rown["classzm"]?></td>
      <td colspan="2"><input name="<?php echo "xuhaos".$rown["classid"]?>" type="text"  value="<?php echo $rown["xuhao"]?>" size="4"> 
        <input name="checked" type="submit" id="checked" value="更新序号"></td>
      <td>[ <a href="zsclassmodifysmall.php?classid=<?php echo $rown["classid"]?>">修改</a> 
        | <a href="?action=delsmall&SmallClassID=<?php echo $rown["classid"]?>&bigclassid=<?php echo $row["classzm"]?>" onClick="return ConfirmDelSmall();">删除</a> 
        ] </td>
    </tr>
    <?php
		$n=$n+1;
	}
	}
	
	?>
  </table>
</form>
</body>
</html>
