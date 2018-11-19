<?php
/**
 * 幻灯片
 *
 * @version        2015年11月1日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview();
if(empty($action))
{
	$action = '';
}
$id = empty($id) ? 0 : intval($id);

if($action=="add")
{
	if(empty($webname))
	{
		ShowMsg("标题不能为空，请返回检查","-1");
		exit();
	}
	if(empty($url))
	{
		ShowMsg("链接不能为空，请返回检查","-1");
		exit();
	}
	if(empty($v_pic))
	{
		ShowMsg("图片不能为空，请返回检查","-1");
		exit();
	}
	if(empty($sortrank)) 
		{
		$trow = $dsql->GetOne("select max(sortrank)+1 as dd from duomi_slide");
		$sortrank = $trow['dd'];
		}
	if (!is_numeric($sortrank)) $sortrank=1;
	$dtime = time();
	$query = "Insert Into `duomi_slide`(sortrank,url,webname,v_pic,msg,dtime,ischeck) Values('$sortrank','$url','$webname','$v_pic','$email','$dtime','1'); ";
	$rs = $dsql->ExecuteNoneQuery($query);
	if($rs)
	{
		ShowMsg("成功增加一个幻灯片!","admin_slide.php");
		exit();
	}
	else
	{
		ShowMsg("增加幻灯片时出错，请向官方反馈，原因：".$dsql->GetError(),"javascript:;");
		exit();
	}
}
elseif($action=="save")
{
	if(empty($webname))
	{
		ShowMsg("标题不能为空，请返回检查","-1");
		exit();
	}
	if(empty($url))
	{
		ShowMsg("链接不能为空，请返回检查","-1");
		exit();
	}
	if(empty($url))
	{
		ShowMsg("图片不能为空，请返回检查","-1");
		exit();
	}
	if(empty($sortrank)) 
		{
		$trow = $dsql->GetOne("select max(sortrank)+1 as dd from duomi_slide");
		$sortrank = $trow['dd'];
		}
	if (!is_numeric($sortrank)) $sortrank=1;
	$query = "Update `duomi_slide` set sortrank='$sortrank',url='$url',webname='$webname',v_pic='$v_pic',msg='$msg',ischeck='1' where id='$id' ";
	$dsql->ExecuteNoneQuery($query);
	ShowMsg("成功更改一个幻灯片！","admin_slide.php");
	exit();
}
elseif($action=="last")
{
	$row=$dsql->GetOne("select sortrank from `duomi_slide` where id='$id'");
	$cur=$row['sortrank'];
	$row=$dsql->GetOne("select count(*) as dd from `duomi_slide` where sortrank<'$cur'");
	$cou=$row['dd'];
	if($cou>0)
	{
		$row=$dsql->GetOne("select sortrank from `duomi_slide` where sortrank<'$cur' order by sortrank desc");
		$flag=$row['sortrank'];
		$dsql->ExecuteNoneQuery("update `duomi_slide` set sortrank='$flag' where id='$id'");
	}
	else
	{
		$dsql->ExecuteNoneQuery("update `duomi_slide` set sortrank=sortrank-1 where id='$id'");
	}
	header("Location:admin_slide.php?id=$id");
	exit;
}
elseif($action=="next")
{
	$row=$dsql->GetOne("select sortrank from `duomi_slide` where id='$id'");
	$cur=$row['sortrank'];
	$row=$dsql->GetOne("select count(*) as dd from `duomi_slide` where sortrank>'$cur'");
	$cou=$row['dd'];
	if($cou>0)
	{
		$row=$dsql->GetOne("select sortrank from `duomi_slide` where sortrank>'$cur' order by sortrank desc");
		$flag=$row['sortrank'];
		$dsql->ExecuteNoneQuery("update `duomi_slide` set sortrank='$flag' where id='$id'");
	}
	else
	{
		$dsql->ExecuteNoneQuery("update `duomi_slide` set sortrank=sortrank+1 where id='$id'");
	}
	header("Location:admin_slide.php?id=$id");
	exit;
}
elseif($action=="del")
{
	$dsql->ExecuteNoneQuery("delete from `duomi_slide` where id='$id'");
	header("Location:admin_slide.php?id=$id");
	exit;
}
elseif($action=="delall")
{
	if(empty($e_id))
	{
		ShowMsg("请选择需要删除的幻灯片","-1");
		exit();
	}
	$ids = implode(',',$e_id);
	$dsql->ExecuteNoneQuery("delete from `duomi_slide` where id in ($ids)");
	header("Location:admin_slide.php");
	exit;
}
elseif($action=="editall")
{
	if(empty($e_id))
	{
		ShowMsg("请选择需要修改的幻灯片","-1");
		exit();
	}
	foreach($e_id as $id)
	{
		$webname=$_POST["webname$id"];
		$url=$_POST["url$id"];
		$sortrank=$_POST["sortrank$id"];
	if(empty($webname))
	{
		ShowMsg("标题不能为空，请返回检查","-1");
		exit();
	}
	if(empty($url))
	{
		ShowMsg("链接不能为空，请返回检查","-1");
		exit();
	}
	if(empty($v_pic))
	{
		ShowMsg("链接不能为空，请返回检查","-1");
		exit();
	}
	if(empty($sortrank)) 
		{
		$trow = $dsql->GetOne("select max(sortrank)+1 as dd from duomi_slide");
		$sortrank = $trow['dd'];
		}
	if (!is_numeric($sortrank)) $sortrank=1;
	$dsql->ExecuteNoneQuery("update duomi_slide set webname='$webname',url='$url',sortrank='$sortrank' where id=".$id);
	}
	header("Location:admin_slide.php");
	exit;
}
else
{
	include(duomi_ADMIN.'/html/admin_slide.htm');
	exit();
}
?>