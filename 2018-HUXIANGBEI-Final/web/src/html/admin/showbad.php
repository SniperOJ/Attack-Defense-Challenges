<?php include("admin.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<?php
checkadminisdo("badusermessage");
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if ($action<>""){
	$id="";
	if(!empty($_POST['id'])){
    	for($i=0; $i<count($_POST['id']);$i++){
    	$id=$id.($_POST['id'][$i].',');
    	}
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
	}

	if ($id==""){
	echo "<script>alert('操作失败！至少要选中一条信息。');history.back();</script>";
	}
}
if ($action=="del"){
	 if (strpos($id,",")>0){
		$sql="delete from zzcms_bad where id in (". $id .")";
	}else{
		$sql="delete from zzcms_bad where id='$id'";
	}

query($sql);
echo "<script>location.href='showbad.php'</script>";
}
if ($action=="lockip"){
	 if (strpos($id,",")>0){
		$sql="update  zzcms_bad set lockip=1 where id in (". $id .")";
	}else{
		$sql="update  zzcms_bad set lockip=1 where id='$id'";
	}
query($sql);
echo "<script>location.href='showbad.php'</script>";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="admintitle">不良操作记录</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
  <tr>
    <td align="center"><a href="badip_add.php">添加IP</a></td>
  </tr>
</table>
<?php
$sql="select * from zzcms_bad order by id desc";
$rs=query($sql);
$row=num_rows($rs);	 
if (!$row){
echo "暂无信息";
}else{
?>
<form name="myform" method="post" action="">

  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="5%" align="center" class="border">ID</td>
      <td width="10%" class="border">用户名</td>
      <td width="10%" class="border">IP</td>
      <td width="10%" class="border">IP状态</td>
      <td width="10%" class="border">备注</td>
      <td width="10%" class="border">时间</td>
      <td width="5%" align="center"class="border">操作</td>
    </tr>
  <?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center" > 
        <input name="id[]" type="checkbox" value="<?php echo $row["id"]?>">
      </td>
      <td><?php echo $row["username"]?></td>
      <td><?php echo $row["ip"]?></td>
      <td>
<?php if ($row["lockip"]==1) { echo"被封";} else{ echo"正常";}?>
</td>
      <td><?php echo $row["dose"]?></td>
      <td><?php echo $row["sendtime"]?></td>
      <td align="center" class="docolor"><a href="ShowBad.php?action=lockip&ID=<?php echo $row["id"]?>"> 
        </a><a href="usermanage.php?keyword=<?php echo $row["username"]?>">锁定该用户</a></td>
    </tr>
    <?php
}
?>
  </table>
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
    <td> <input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
        选中所有 
        <input name="del" type="submit" value="删除选中的信息" onClick="myform.action='?action=del';myform.target='_self'">
        <input name="lockip" type="submit" value="封选中的IP" onClick="myform.action='?action=lockip';myform.target='_self'"></td>
  </tr>
</table>
</form>
<?php
}

?>
</body>
</html>