<?php
/**
 * 
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
if(empty($action))
{
	$action = '';
}

$id = empty($id) ? 0 : intval($id);

if($action=="edit")
{
	$row = $dsql->GetOne("Select * From `duomi_mytag` where aid='$id'");
	include(duomi_ADMIN.'/html/admin_selflabel.htm');
	exit;
}
elseif($action=="editsave")
{
	$query = "Update `duomi_mytag` set tagname='$tagname',tagdes='$tagdes',tagcontent='$tagcontent' where aid='$id' ";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功更改一个自定义标签！","admin_selflabel.php?page=".$page);
	exit();
}
elseif($action=="addsave")
{
	$tagname = trim($tagname);
	$row = $dsql->GetOne("Select aid From duomi_mytag where tagname='$tagname'");
	if(is_array($row))
	{
		ShowMsg("在相同栏目下已经存在同名的标签！","-1");
		exit();
	}
	$addtime = time();
	$inQuery = "Insert Into duomi_mytag(tagname,tagdes,tagcontent,addtime) Values('$tagname','$tagdes','$tagcontent','$addtime'); ";
	$dsql->ExecuteNoneQuery($inQuery);
	ShowMsg("成功增加一个自定义标签！","admin_selflabel.php");
	exit();
}
elseif($action=="add")
{
	include(duomi_ADMIN.'/html/admin_selflabel.htm');
	exit;
}
elseif($action=="del")
{
	$dsql->ExecuteNoneQuery("delete from duomi_mytag where aid='$id'");
	ShowMsg("成功删除一个自定义标签！","admin_selflabel.php");
	exit();
}
elseif($action=="delall")
{
	if(empty($e_id))
	{
		ShowMsg("没有选择标签，请返回选择！","admin_selflabel.php");
		exit();
	}
	$ids = implode(',',$e_id);
	$dsql->ExecuteNoneQuery("delete from duomi_mytag where aid in(".$ids.")");
	ShowMsg("成功删除所选自定义标签！","admin_selflabel.php");
	exit();
}
else
{
	include(duomi_ADMIN.'/html/admin_selflabel.htm');
	exit;
}
?>