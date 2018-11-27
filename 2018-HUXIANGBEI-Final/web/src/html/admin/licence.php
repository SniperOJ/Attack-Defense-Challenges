<?php
include("admin.php");
include("../inc/fy.php");
?>
<html>
<head>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" src="/js/gg.js"></script>
<?php
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';

$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
if ($action=="pass"){
checkadminisdo("licence");
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	$sql="select passed from zzcms_licence where id ='$id'";
	$rs = query($sql); 
	$row = fetch_array($rs);
		if ($row['passed']=='0'){
		query("update zzcms_licence set passed=1 where id ='$id'");
		}else{
		query("update zzcms_licence set passed=0 where id ='$id'");
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
<div class="admintitle">资质证书管理</div>
<div  class="border">
<form action="?" name="form1" method="post"> 
标题： <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> <input type="submit" name="Submit" value="查找">
</form> 
</div>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_licence where id<>0 ";
$sql2='';
if ($shenhe=="no") {  		
$sql2=$sql2." and passed=0 ";
}
if ($keyword<>"") {
	$sql2=$sql2. " and editor '%".$keyword."%'";
}
$rs = query($sql.$sql2,$conn); 
$row = fetch_array($rs);
$totlenum = $row['total']; 
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_licence where id<>0 ";
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
<input name="submit"  type="submit" onClick="pass(this.form)" value="【取消/审核】选中的信息">
        <input name="submit4" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息"> 
        <input name="pagename" type="hidden"  value="licence.php?shenhe=<?php echo $shenhe?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_licence"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border"> <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="20%" class="border">证件</td>
      <td width="20%" class="border">资质证书名称</td>
      <td width="5%" class="border">用户</td>
      <td width="5%" class="border">状态</td>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
   <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td><a href="<?php echo $row["img"]?>" target="_blank"><img src="<?php echo $row["img"]?>" border="0" width="100"></a>      </td>
      <td><?php echo $row["title"]?></td>
      <td><a href="usermanage.php?keyword=<?php echo $row["editor"]?>"><?php echo $row["editor"]?></a></td>
      <td><?php if ($row["passed"]==0) { echo "<font color=red>未审核</font>"; }else{ echo "已审核"; }?></td>
    </tr>
<?php
}
?>
  </table>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr> 
    <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
       <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
      <input name="submit2"  type="submit" onClick="pass(this.form)" value="【取消/审核】选中的信息">
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