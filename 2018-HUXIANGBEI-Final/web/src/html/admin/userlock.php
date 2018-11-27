<?php
include("admin.php");
checkadminisdo("userreg");
$id=trim($_REQUEST["id"]);
$action=trim($_REQUEST["action"]);
$page=trim($_REQUEST["page"]);
if ($id<>"") {
	if ($action=="lock") {
		query("Update zzcms_user set lockuser=1 where id='$id'");
		//锁定时审核此用户发布的信息（使之为0）
		query("Update zzcms_main set passed=0 where editor=(select username from zzcms_user where id='id')");
		query("Update zzcms_pp set passed=0 where editor=(select username from zzcms_user where id='id')");
		query("Update zzcms_job set passed=0 where editor=(select username from zzcms_user where id='id')");
		query("Update zzcms_zh set passed=0 where editor=(select username from zzcms_user where id='$id')");
		query("Update zzcms_zx set passed=0 where editor=(select username from zzcms_user where id='$id')");
		query("Update zzcms_special set passed=0 where editor=(select username from zzcms_user where id='id')");
	}else{
		query("Update zzcms_user set lockuser=0 where id='$id'");
		//解锁时审核此用户发布的信息（使之为1）
		query("Update zzcms_main set passed=1 where editor=(select username from zzcms_user where id='$id')");
		query("Update zzcms_pp set passed=1 where editor=(select username from zzcms_user where id='id')");
		query("Update zzcms_job set passed=1 where editor=(select username from zzcms_user where id='id')");
		query("Update zzcms_zh set passed=1 where editor=(select username from zzcms_user where id='$id')");
		query("Update zzcms_zx set passed=1 where editor=(select username from zzcms_user where id='$id')");
		query("Update zzcms_special set passed=1 where editor=(select username from zzcms_user where id='id')");
	}      
}

echo "<script>location.href='usermanage.php?usersf=lockuser&page=".$page."'</script>";
?>