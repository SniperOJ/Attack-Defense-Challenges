<?php
require_once(dirname(__FILE__)."/config.php");
require_once(duomi_DATA."/config.user.inc.php");
CheckPurview();

if(empty($action))
{
	$action = '';
}
elseif($action=="add")
{
	$num=$_POST['num'];
	$limit=$_POST['limit'];
	for($i=0;$i<$num;$i++)
	{
		$key="DM".rand(1000000000,9999999999);
		$pwd="".rand(100000,999999);
		$addsql="INSERT INTO `duomi_card`(id,ckey,cpwd,climit,maketime,usetime,uname,status) VALUES (NULL, '$key' ,'$pwd', '$limit', NOW(), NULL, NULL, '0')";
		$dsql->ExecuteNoneQuery($addsql);
	}
	ShowMsg("充值卡生成成功","admin_card.php");
	exit;
}
include(duomi_ADMIN.'/html/admin_card.htm');
exit();

?>