<?php
include ("admin.php");
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


checkadminisdo("sendmessage");
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id="";
}
if ($action=="del"){
query("delete from zzcms_message where id='$id'");
echo "<script>location.href='?page=".$page."'</script>";
}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">短信息管理</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" class="border"><a href="message_add.php">发短信息</a></td>
  </tr>
</table>
<?php
$sql="select * from zzcms_message order by ID desc"; 
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo "暂无信息";
}else{
?>
<table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
    <td width="71" align="center" class="border">ID</td>
    <td width="263" class="border">标题</td>
    <td width="237" align="center" class="border">发布时间</td>
    <td width="111" align="center" class="border">接收人</td>
    <td width="144" align="center" class="border">是否查看</td>
    <td width="150" align="center" class="border">操作</td>
  </tr>
<?php
while($row = fetch_array($rs)){
?>
   <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
    <td width="71" align="center"><?php echo $row["id"]?></td>
    <td width="263" ><?php echo $row["title"]?></td>
    <td width="237" align="center"><?php echo $row["sendtime"]?></td>
    <td width="111" align="center"><?php echo $row["sendto"]?></td>
    <td width="144" align="center"><?php if ($row["looked"]==1) { echo"已查看";} else{ echo"<font color=red>未查看</font>";}?></td>
    <td width="150" align="center" class="docolor"><a href="message_modify.php?id=<?php echo $row["id"]?>">修改</a> 
      | <a href="message_manage.php?action=del&id=<?php echo $row["id"]?>" onClick="return ConfirmDel();">删除</a></td>
  </tr>
<?php
}
?>
</table>
<?php
}

?>
</body>
</html>