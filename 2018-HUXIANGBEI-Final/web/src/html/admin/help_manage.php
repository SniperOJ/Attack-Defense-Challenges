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
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';

if ($action=="elite"){
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$_POST['id'][$i];
	$sql="select elite from zzcms_help where id ='$id'";
	$rs = query($sql); 
	$row = fetch_array($rs);
		if ($row['elite']=='0'){
		query("update zzcms_help set elite=1 where id ='$id'");
		}else{
		query("update zzcms_help set elite=0 where id ='$id'");
		}
	}
}else{
echo "<script>alert('操作失败！至少要选中一条信息。');history.back()</script>";
}
echo "<script>location.href='?b=".$b."&keyword=".$keyword."&page=".$page."'</script>";	
}
?>
<div class="admintitle"><?php if ($b==1 ){echo"帮助"; }else{ echo"公告";}?>信息管理</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="border"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>
		  <?php if ($b==1) { ?>
		  <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='help_add.php?b=1'" value="发布帮助信息">
		  <?php }elseif ($b==2) { ?>
		  <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='help_add.php?b=2'" value="发布公告信息">
		  <?php
		  }
		  ?>
		  </td>
          <td align="right"> <form name="form1" method="post" action="?b=<?php echo $b?>">
              <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>">
              <input type="submit" name="Submit" value="查寻">
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_help where classid=".$b." ";
if ($keyword<>"") {  		
$sql=$sql." and  title like '%".$keyword."%' ";
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
<form name="myform" method="post" action="?action=del&b=<?php echo $b?>">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> 
		<input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="submit2" type="submit" onClick="myform.action='?action=elite&b=<?php echo $b?>'" value="【取消/首页显示】选中的信息">
        <input name="pagename" type="hidden"  value="help_manage.php?b=<?php echo $b?>&page=<?php echo $page ?>"> 
        <input name="tablename" type="hidden"  value="zzcms_help"> </td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border"><label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label></td>
      <td width="10%" class="border">标题</td>
      <td width="5%" align="center" class="border">首页显示</td>
      <td width="10%" align="center" class="border">发布时间</td>
      <td width="5%" align="center" class="border">操作</td>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" > <input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>"></td>
      <td ><a href="/one/announce_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo $row["title"]?></a></td>
      <td align="center" > <?php if ($row["elite"]==1) { echo"是";} else{ echo"<font color=red>否</font>";}?></td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center" class="docolor"><a href="help_modify.php?id=<?php echo $row["id"]?>&b=<?php echo $b?>&page=<?php echo $page ?>">修改</a></td>
    </tr>
<?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        <label for="chkAll" style="text-decoration: underline;cursor: hand;">全选</label> 
        <input name="submit" type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
        <input name="submit22" type="submit" onClick="myform.action='?action=elite&b=<?php echo $b?>'" value="【取消/首页显示】选中的信息"></td>
    </tr>
  </table>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}

?>
</body>
</html>