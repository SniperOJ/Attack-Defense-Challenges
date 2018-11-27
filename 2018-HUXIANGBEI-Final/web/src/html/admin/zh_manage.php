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
checkadminisdo("zh");
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';

$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'title';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';

if ($action=="pass"){
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	$sql="select passed from zzcms_zh where id ='$id'";
	$rs = query($sql); 
	$row = fetch_array($rs);
		if ($row['passed']=='0'){
		query("update zzcms_zh set passed=1 where id ='$id'");
		}else{
		query("update zzcms_zh set passed=0 where id ='$id'");
		}
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";	
}
?>
</head>
<body>
<div class="admintitle">展会信息管理</div>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
<input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='zh_add.php'" value="发布展会信息"></td>
            <td align="right">
			<form name="form1" method="post" action="?">
			<input type="radio" name="kind" value="editor" <?php if ($kind=="editor") { echo "checked";}?>>
              按发布人 
              <input type="radio" name="kind" value="title" <?php if ($kind=="title") { echo "checked";}?>>
              按标题 
              <input name="keyword" type="text" id="keyword2" value="<?php echo $keyword?>"> 
              <input type="submit" name="Submit" value="查找"> 
			  </form>
			  </td>
          </tr>
        </table>  
      </td>
    </tr>
    <tr>
      
    <td class="border2"> 
      <?php	
$sql="select * from zzcms_zhclass order by xuhao";
$rs = query($sql); 
while($row = fetch_array($rs)){
echo "<a href=?b=".$row['bigclassid'].">";  
	if ($row["bigclassid"]==$b) {
	echo "<b>".$row["bigclassname"]."</b>";
	}else{
	echo $row["bigclassname"];
	}
	echo "</a> | ";  
 }
 ?>
    </td>
    </tr>
  </table>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_zh where id<>0 ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($keyword<>"") {
	switch ($kind){
	case "editor";
	$sql2=$sql2. " and editor like '%".$keyword."%' ";
	break;
	case "title";
	$sql2=$sql2. " and title like '%".$keyword."%'";
	break;
	default:
	$sql2=$sql2. " and title like '%".$keyword."%'";
	}
}
if ( $b<>"" ) {
   $sql2=$sql2." and bigclassid=".$b."";
}

$rs = query($sql.$sql2,$conn); 
$row = fetch_array($rs);
$totlenum = $row['total']; 
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_zh where id<>0 ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql,$conn); 
if(!$totlenum){
echo "暂无信息";
}else{
?>

<form name="myform" method="post" action="">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
        <input name="submit2" type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
        <input name="submit4" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
        <input name="pagename" type="hidden"  value="zh_manage.php?bigclass=<?php echo $bigclass?>&shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_zh"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="20%" class="border">标题</td>
      <td width="5%" align="center" class="border">类型</td>
      <td width="5%" align="center" class="border">信息状态</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="5%" align="center" class="border">发布人</td>
      <td width="5%" align="center" class="border">点击次数</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><a href="<?php echo getpageurl("zh",$row["id"])?>" target="_blank"><?php echo $row["title"]?></a> <br>
        展会时间：<?php echo date("Y-m-d",strtotime($row["timestart"]))?>至<?php echo date("Y-m-d",strtotime($row["timeend"]))?><br>
        展会地点：<?php echo $row["address"]?> </td>
      <td align="center" >
	  <?php
	  echo "<a href=?b=".$row['bigclassid'].">"; 
	  $rsn=query("select bigclassname from zzcms_zhclass where bigclassid='".$row["bigclassid"]."'");
$rown=fetch_array($rsn);
echo $rown["bigclassname"];
echo "</a>";
?></td>
      <td align="center" > <?php if ( $row["passed"]==0 ) { echo"<font color=red>未审核</font>";}else{ echo"已审核";}?> <br>
<?php if ( $row["elite"]<>0 ) { echo"<font color=red>置顶(".$row["elite"].")</font>";}?></td>
      <td align="center"><?php echo date("Y-m-d",strtotime($row["sendtime"]))?></td>
      <td align="center"><a href="usermanage.php?keyword_username=<?php echo $row["editor"]?>"><?php echo $row["editor"]?></a></td>
      <td align="center"><?php echo $row["hit"]?></td>
      <td align="center" class="docolor"><a href="zh_modify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>">修改</a></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
        <input type="submit" onClick="myform.action='?action=pass'" value="【取消/审核】选中的信息">
        <input name="submit42" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
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