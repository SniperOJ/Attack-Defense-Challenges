<?php
include("admin.php");
include("../inc/fy.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
checkadminisdo("dl");

$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';
$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';
$showwhat=isset($_REQUEST["showwhat"])?$_REQUEST["showwhat"]:'';

$isread=isset($_REQUEST["isread"])?$_REQUEST["isread"]:'';

if ($action=="pass"){
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $ids=$_POST['id'][$i];
	$ids=explode("|",$ids);
	$id=$ids[0];
	$classzm=$ids[1];
	
	$sql="select passed from zzcms_dl where id ='$id'";
	$rs = query($sql); 
	$row = fetch_array($rs);
	if ($row['passed']=='0'){
	query("update zzcms_dl set passed=1 where id ='$id'");
	query("update zzcms_dl_".$classzm." set passed=1 where dlid ='$id'");
    }else{
	query("update zzcms_dl set passed=0 where id ='$id'");
	query("update zzcms_dl_".$classzm." set passed=0 where dlid ='$id'");
	}
	
	}	
}else{
echo "<script lanage='javascript'>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";
}
?>
</head>
<body>
<div class="admintitle"><?php echo channeldl?>商信息库管理</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
  <tr> 
      <td width="45%"><input name="submit32" type="submit" class="buttons" onClick="javascript:location.href='dl_add.php'" value="发布<?php echo channeldl?>信息">      </td>
    <td width="55%" align="right"> 
      <form name="form1" method="post" action="?">
	   <input type="radio" name="kind" value="cpmc" <?php if ($kind=="cpmc") { echo "checked";}?>>
        按产品名称 
        <input name="kind" type="radio" value="tel" <?php if ($kind=="tel") { echo "checked";}?> >
        按电话 
        <input type="radio" name="kind" value="editor" <?php if ($kind=="editor") { echo "checked";}?>>
        按发布人 
        <input type="radio" name="kind" value="saver" <?php if ($kind=="saver") { echo "checked";}?>>
        按接收人 
        <input name="keyword" type="text" id="keyword2" value="<?php echo $keyword?>"> 
        <input type="submit" name="Submit" value="查找">
        <a href="?isread=no">未查看的</a> 
      </form>		</td>
  </tr>
</table>
  <div class="border">
  <?php	
$sql="select * from zzcms_zsclass where parentid='A' order by xuhao";
$rs = query($sql); 
$row = num_rows($rs);
if (!$row){
echo '暂无分类';
}else{
while($row = fetch_array($rs)){
echo "<a href=?b=".$row['classzm'].">";  
	if ($row["classzm"]==$b) {
	echo "<b>".$row["classname"]."</b>";
	}else{
	echo $row["classname"];
	}
	echo "</a> | ";  
 }
} 
 ?>
  </div>
 
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_dl where id<>0 ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($b<>"") {
$sql2=$sql2." and classzm='".$b."' ";
}
if ($isread=="no") {
$sql2=$sql2." and saver<>'' and looked=0";
}
if ($keyword<>"") {
	switch ($kind){
	case "editor";
	$sql2=$sql2. " and editor like '%".$keyword."%' ";
	break;
	case "cpmc";
	$sql2=$sql2. " and cp like '%".$keyword."%'";
	break;
	case "saver";
	$sql2=$sql2. " and saver like '%".$keyword."%'";
	break;
	case "tel";
	$sql2=$sql2. " and tel like '%".$keyword."%'";
	break;		
	default:
	$sql2=$sql2. " and cp like '%".$keyword."%'";
	}
}

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_dl where id<>0 ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
//$sql=$sql." and id>=(select id from zzcms_dl order by id limit $offset,1) order by id desc limit $page_size";
$rs = query($sql,$conn); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input name="submit" type="submit" onClick="myform.action='dl_sendmail.php';myform.target='_blank' "  value="给接收者发邮件提醒">
        <input name="submit23" type="submit" onClick="myform.action='dl_sendsms.php';myform.target='_blank' "  value="给接收者发手机短信提醒">
        <input name="submit4" type="submit"  onClick="myform.action='?action=pass';myform.target='_self'" value="【取消/审核】选中的信息"> 
        <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="pagename" type="hidden"  value="dl_manage.php?b=<?php echo $b?>&shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_dl"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border"> <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="10%" class="border">类别</td>
      <td width="10%" class="border"><?php echo channeldl?>品种</td>
      <td width="10%" class="border"><?php echo channeldl?>区域</td>
      <td width="10%" class="border">联系人</td>
      <td width="10%" class="border">电话</td>
      <td width="10%" class="border">发布人</td>
      <td width="10%" align="center" class="border">接收者</td>
      <td width="10%" class="border">发布时间</td>
      <td width="10%" align="center" class="border">信息状态</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
    <?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center"> <input name="id[]" type="checkbox"  value="<?php echo $row["id"]?>|<?php echo $row["classzm"]?>">
     </td>
      <td><a href="?b=<?php echo $row["classzm"]?>" >
	  <?php
			$rsn=query("select classname from zzcms_zsclass where classzm='".$row['classzm']."'");
			$r=num_rows($rsn);
			if ($r){
			$r=fetch_array($rsn);
			echo $r["classname"];
			}
			 ?>
      </a></td>
      <td><a href="<?php echo getpageurl("dl",$row["id"])?>" target="_blank"><?php echo $row["cp"] ?></a></td>
      <td><?php echo $row["province"].$row["city"]?></td>
      <td><?php echo $row["dlsname"]?></td>
      <td><?php echo $row["tel"]?></td>
      <td><?php if ($row["editor"]<>''){ echo  $row["editor"];}else{ echo '未登录用户';}?></td>
      <td align="center">
        <?php if ($row["saver"]<>"") { echo"<a href='usermanage.php?keyword=".$row["saver"]."' target='_blank'>".$row["saver"]."</a>";}else{ echo"无";}?>      </td>
      <td><?php echo $row["sendtime"]?></td>
      <td align="center"> 
        <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?>
       |
        <?php
	if ($row["saver"]<>"") {
		if ($row["looked"]==0) { 
		echo"<font color='red'>未查看</font>" ;
		}else{
		echo "已查看" ;
		}
	}else{
	echo '非留言';
	}
		?>      </td>
      <td align="center" class="docolor"> <a href="dl_modify.php?id=<?php echo $row["id"]?>&page=<?php echo $page ?>">修改</a>      </td>
    </tr>
    <?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
         <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label>
        <input name="submit2" type="submit" onClick="myform.action='dl_sendmail.php';myform.target='_blank' "  value="给接收者发邮件提醒">
        <input name="submit232" type="submit" onClick="myform.action='dl_sendsms.php';myform.target='_blank' "  value="给接收者发手机短信提醒">
        <input name="submit5" type="submit"  onClick="myform.action='?action=pass';myform.target='_self'" value="【取消/审核】选中的信息"> 
        <input name="submit3" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
      </td>
    </tr>
  </table>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}

?>
</body>
</html>