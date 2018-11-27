<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig(){
   if(confirm("确定要删除此用户组吗！"))
     return true;
   else
     return false;	 
}
</script>
</head>
<body>
<div class="admintitle">管理员分组信息管理</div>
<div class="border center"><input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='admingroupadd.php'" value="添加管理组"></div>
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if ($action=="del" ){
checkadminisdo("admingroup");
$groupname=trim($_GET["groupname"]);
$id=trim($_GET["id"]);
if  ($groupname<>""){
	$sql="delete from zzcms_admingroup where groupname='" . $groupname . "'";
	query($sql,$conn);
}
 
echo  "<script>location.href='admingroupmanage.php'</script>";
}

$sql="Select * From zzcms_admingroup";
$rs = query($sql,$conn); 
?>
<table width="100%" border="0" cellpadding="5" cellspacing="1" >
  <tr> 
    <td width="10%" align="center" class="border"><strong>ID</strong></td>
    <td width="29%" align="center" class="border"><strong><strong>管理组名称</strong></strong></td>
    <td width="51%" align="center" class="border">权限</td>
    <td width="10%" align="center" class="border"><strong>操作选项</strong></td>
  </tr>
  <?php
	while($row= fetch_array($rs)){
?>
   <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
    <td width="10%" align="center"><?php echo $row["id"] ?></td>
    <td align="center"><?php echo $row["groupname"]?></td>
    <td align="center"><?php echo $row["config"]?></td>
    <td align="center" class="docolor">
     
	  <a href="admingroupmodify.php?id=<?php echo $row["id"] ?>">修改</a> | 
	  <a href="admingroupmanage.php?groupname=<?php echo $row["groupname"] ?>&id=<?php echo $row["id"] ?>&action=del" onClick="return ConfirmDelBig();">删除</a>	  </td>
  </tr>
  <?php 
  }
    
   ?>
</table>

</body>
</html>