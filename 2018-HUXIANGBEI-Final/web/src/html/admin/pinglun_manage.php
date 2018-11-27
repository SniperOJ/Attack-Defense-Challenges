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
</head>
<body>
<?php
checkadminisdo("zxpinglun");

$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$shenhe=isset($_REQUEST["shenhe"])?$_REQUEST["shenhe"]:'';

$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';

if ($action<>""){
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	switch ($action){
	case "pass";
	$sql="select passed from zzcms_pinglun where id ='$id'";
	$rs = query($sql); 
	$row = fetch_array($rs);
		if ($row['passed']=='0'){
		query("update zzcms_pinglun set passed=1 where id ='$id'");
		}else{
		query("update zzcms_pinglun set passed=0 where id ='$id'");
		}
	break;	
	case "del";
	query("delete from zzcms_pinglun where id ='$id'");
	break;	
	}	
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?keyword=".$keyword."&page=".$page."'</script>";	
}

?>
<div class="admintitle">评论管理</div>
<form name="form1" method="post" action="?">
<div class="border"> 内容： <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>"> <input type="submit" name="Submit" value="查寻"> </div>
</form>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_pinglun where id<>0 ";
if ($shenhe=="no") {  		
$sql=$sql." and passed=0 ";
}

if ($keyword<>"") {
	$sql=$sql. " and content like '%".$keyword."%' ";
}
$rs = query($sql,$conn); 
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);
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
        <input type="submit" onClick="pass(this.form)" value="【取消/审核】选中的信息"> 
        <input type="submit" onClick="del(this.form)" value="删除选中的信息">
      </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="10%" class="border">评论内容</td>
      <td width="5%" class="border">被评文章ID</td>
      <td width="5%" align="center" class="border">是否审核</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="10%" align="center" class="border">评论人</td>
      <td width="10%" align="center" class="border">评论人IP</td>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" class="docolor"> <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><?php echo $row["content"]?></td>
      <td ><a href="<?php echo getpageurl("zx",$row["about"])?>" target="_blank"><?php echo $row["about"]?></a></td>
      <td align="center" > <?php if ($row["passed"]==1) { echo"已审核";} else{ echo"<font color=red>未审核</font>";}?></td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center"><a href="usermanage.php?keyword=<?php echo $row["username"]?>"><?php echo $row["username"]?></a></td>
      <td align="center"><?php echo $row["ip"]?></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
        <input type="submit" onClick="pass(this.form)" value="【取消/审核】选中的信息"> 
        <input type="submit" onClick="del(this.form)" value="删除选中的信息"> 
        <input name="page" type="hidden" id="page" value="<%=CurrentPage%>"></td>
    </tr>
  </table>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}

?>
</body>
</html>