<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
</head>
<body>
<?php
checkadminisdo("admingroup");
$action=$_POST["action"];
$FoundErr=0;
$groupname=trim($_POST["groupname"]);

$config="";
if (isset($_POST['config'])){
foreach($_POST['config'] as $i){$config .=$i."#";}
$config=substr($config,0,strlen($config)-1);//去除最后面的"#"
}

if ($action=="add"){	
	$sql="Select * From zzcms_admingroup where groupname='".$groupname."'";	
	$rs = query($sql,$conn);
	$row= num_rows($rs);//返回记录数
	if($row){ 
			$FoundErr=1;
			$ErrMsg="<li>用户组名称“" . $groupname . "”已经存在！</li>";
			WriteErrMsg($ErrMsg);
	}else{
	$sql="insert into zzcms_admingroup (groupname,config)values('$groupname','$config')";
	query($sql,$conn);
	echo "<script>location.href='admingroupmanage.php'</script>";
	}
}elseif($action=="modify"){
$id=$_POST["id"];
$sql="update zzcms_admingroup set groupname='$groupname',config='$config' where id='$id'";
$isok=query($sql);

if ($isok){
echo "<script>alert('修改成功');location.href='admingroupmanage.php'</script>";
}else{
echo "<script>alert('修改失败');location.href='admingroupmanage.php'</script>";
}

}
mysql_close($conn)
?>
</body>
</html>