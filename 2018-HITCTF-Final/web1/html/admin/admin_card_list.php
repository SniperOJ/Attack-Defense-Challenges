<?php
require_once(dirname(__FILE__)."/config.php");
require_once(duomi_DATA."/config.user.inc.php");
CheckPurview();

if(empty($action))
{
	$action = '';
}
elseif($action=="del")
{
		
		$delsql="DELETE FROM `duomi_card` WHERE id = '$id'";
		$dsql->ExecuteNoneQuery($delsql);
		ShowMsg("删除成功","-1");
		exit;
}
elseif($action=="delall")
{
	if(empty($e_id))
	{
		ShowMsg("请选择需要删除的卡号","-1");
		exit();
	}
	$ids = implode(',',$e_id);
	$dsql->ExecuteNoneQuery("delete from duomi_card where id in(".$ids.")");
	ShowMsg("批量删除成功","admin_card_list.php");
	exit();
}


include(duomi_ADMIN.'/html/admin_card_list.htm');
exit();

?>