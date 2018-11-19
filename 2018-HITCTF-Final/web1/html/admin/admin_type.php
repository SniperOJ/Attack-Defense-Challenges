<?php
/**
 * 影片栏目
 *
 * @version        2015年7月12日Z by 海东青
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
	if(empty($tname))
	{
		ShowMsg("分类名称没有填写，请返回检查","-1");
		exit();
	}
	if(empty($templist)) $templist='channel.html';
	if(empty($templist_1)) $templist_1='content.html';
	if(empty($tenname)) $tenname= Pinyin(stripslashes($tname));;
	if(empty($torder)) 
		{
		$trow = $dsql->GetOne("select max(torder)+1 as dd from duomi_type");
		$torder = $trow['dd'];
		}
	if (!is_numeric($torder)) $torder=1;
	$in_query = "insert into `duomi_type`(upid,torder,tname,tenname,templist,templist_1,title,keyword,description,tptype) Values('$upid','$torder','$tname','$tenname','$templist','$templist_1','$title','$keyword','$description',0)";
	if(!$dsql->ExecuteNoneQuery($in_query))
	{
		ShowMsg("增加分类失败，请检查您的输入是否存在问题！","-1");
		exit();
	}
	clearTypeCache();
	ShowMsg("成功创建一个分类！","admin_type.php");
	exit();
}
elseif($action=="hide")
{
	$typePath = getTypePath($id);
	$dsql->ExecuteNoneQuery("update duomi_type set ishidden=1 where tid=".$id);
	if (!empty($typePath))
	{
		delFolder("../".$typePath);
	}
	else
	{
		ShowMsg("分类别名丢失，以防程序删除根目录，此请求不允许操作！","admin_type.php");
		exit();
	}
	clearTypeCache();
	header("Location:admin_type.php");
	exit;
}
elseif($action=="nohide")
{
	$dsql->ExecuteNoneQuery("update duomi_type set ishidden=0 where tid=".$id);
	clearTypeCache();
	header("Location:admin_type.php");
	exit;
}
elseif($action=="del")
{
	delVideoTypeById($id);
	header("Location:admin_type.php");
	exit;
}
elseif($action=="delall")
{
	if(empty($e_id))
	{
		ShowMsg("没有选择分类，请返回选择！","admin_type.php");
		exit();
	}
	foreach($e_id as $id)
	{
		delVideoTypeById($id);
	}
	clearTypeCache();
	header("Location:admin_type.php");
	exit;
}
elseif($action=="move")
{
	$upid_to = empty($upid_to) ? 0 : intval($upid_to);
	if(empty($e_id))
	{
		ShowMsg("请选择需要移动的分类","admin_type.php");
		exit();
	}
	foreach($e_id as $id)
	{
		$subTypeList=",,".getTypeId($id).",,";
		if(strpos($subTypeList,",".$upid_to.",")<=0) $dsql->ExecuteNoneQuery("update duomi_type set upid=".$upid_to." where tid=".$id);
	}
	clearTypeCache();
	ShowMsg("已经成功移动分类！","admin_type.php");
	exit();
}
elseif($action=="edit")
{
	if(empty($e_id))
	{
		ShowMsg("请选择需要更改的分类","admin_type.php");
		exit();
	}
	foreach($e_id as $id)
	{
		$tname=$_POST["tname$id"];
		$templist=$_POST["templist$id"];
		$templist_1=$_POST["templist_1$id"];
		$title=$_POST["title$id"];
		$keyword=$_POST["keyword$id"];
		$description=$_POST["description$id"];
		$tenname=$_POST["tenname$id"];
		$torder=$_POST["torder$id"];
	if(empty($tname))
	{
		ShowMsg("分类名称没有填写，请返回检查","-1");
		exit();
	}
	if(empty($templist)) $templist='channel.html';
	if(empty($templist_1)) $templist_1='content.html';
	if(empty($tenname)) $tenname=Pinyin(stripslashes($tname));;
	if(empty($torder)) 
		{
		$trow = $dsql->GetOne("select max(torder)+1 as dd from duomi_type");
		$torder = $trow['dd'];
		}
	if (!is_numeric($torder)) $torder=1;
	$dsql->ExecuteNoneQuery("update duomi_type set tname='$tname',tenname='$tenname',templist='$templist',templist_1='$templist_1',keyword='$keyword',title='$title',description='$description',torder='$torder' where tid=".$id);
	clearTypeCache();
	}
	header("Location:admin_type.php");
	exit;
}
elseif($action=="movevideo")
{
	if(empty($leftSelect) || empty($rightSelect))
	{
		ShowMsg("请选择分类","-1");
		exit();
	}
	$typePath = getTypePath($leftSelect);
	$dsql->ExecuteNoneQuery("update duomi_data set tid='$rightSelect' where tid=".$leftSelect);
	if (!empty($typePath))
	{
		delFolder("../".$typePath);
	}
	else
	{
		ShowMsg("分类别名丢失，以防程序删除根目录，此请求不允许操作！","admin_type.php");
		exit();
	}
	clearTypeCache();
	header("Location:admin_type.php");
	exit;
}
else
{
include(duomi_ADMIN.'/html/admin_type.htm');
exit();
}

function clearTypeCache()
{
	global $cfg_iscache,$cfg_cachemark;
	if($cfg_iscache)
	{
		$TypeCacheFile=duomi_DATA."/cache/".$cfg_cachemark."obj_get_type_list_0.inc";
		if(is_file($TypeCacheFile)) unlink($TypeCacheFile);
	}
}

function delTypeFirstPage($typeid)
{
	$channelFirstPage=getChannelPagesLink($typeid,1);
	if (!empty($channelFirstPage)) delFile('..'.$channelFirstPage);
}

function delVideoTypeById($id)
{
	global $dsql;
	$typePath = getTypePath($id);
	if (isExistSub($id,"type"))
	{
		ShowMsg("请先删除该分类的子类","admin_type.php");
		exit();
	}else{
		if (isExistSub($id,"video"))
		{
			ShowMsg("请先删除该子类下的所有视频","admin_type.php");
			exit();
		}
		$dsql->ExecuteNoneQuery("delete from duomi_type where tid=".$id);
		clearTypeCache();
		if (!empty($typePath))
		{
			delFolder("../".$typePath);
		}
		else
		{
			ShowMsg("分类别名丢失，以防程序删除根目录，此请求不允许操作！","admin_type.php");
			exit();
		}
	}
}

function isExistSub($bigType,$operFlag)
{
	global $dsql;
	switch ($operFlag) 
	{
		case "type":
			$row = $dsql->GetOne("select count(*) as dd from duomi_type where upid=".$bigType);
		break;
		case "video":
			$row = $dsql->GetOne("select count(*) as dd from duomi_data where tid=".$bigType);
		break;
	}
	if($row[dd]>0)
	{
		return true;
	}else{
		return false;
	}
}

function typeList($topId,$separateStr,$span="")
{
	$tlist=getTypeListsOnCache();
	if ($topId!=0){$span.=$separateStr;}else{$span="";}
	foreach($tlist as $row)
	{
		if($row->upid==$topId)
		{
			if(!$row->tptype){
?>
	<tr>
            <td height="35" bgcolor="#FFFFFF" class="td_border"><?php echo $span;?>&nbsp;<input type="checkbox" name="e_id[]" id="E_ID"  value="<?php echo $row->tid;?>" class="checkbox"/><?php echo $row->tid;?>.<a href="admin_video.php?type=<?php echo $row->tid;?>"><?php echo $row->tname;?></a>(<font color="red"><?php echo getNumPerTypeOnCache($row->tid);?></font>)</td>
            <td height="35" align="left" bgcolor="#FFFFFF"  class="td_border"><input size="6" type="text" name="tname<?php echo $row->tid;?>" value="<?php echo $row->tname;?>"></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="tenname<?php echo $row->tid;?>" value="<?php echo $row->tenname;?>"  size="6" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="templist<?php echo $row->tid;?>" value="<?php echo $row->templist;?>"  size="10" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="templist_1<?php echo $row->tid;?>" value="<?php echo $row->templist_1;?>"  size="10" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="title<?php echo $row->tid;?>" value="<?php echo $row->title;?>"  size="14" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="keyword<?php echo $row->tid;?>" value="<?php echo $row->keyword;?>"  size="14" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="description<?php echo $row->tid;?>" value="<?php echo $row->description;?>"  size="14" /></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><input type="text" name="torder<?php echo $row->tid;?>" value="<?php echo $row->torder;?>" size="1" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"/></td>
            <td height="35" align="center" bgcolor="#FFFFFF" class="td_border"><?php if($row->ishidden==0){?><input type="button" value="隐"  onClick="location.href='?action=hide&id=<?php echo $row->tid;?>';" class="rb1"> <?php }else{?><input type="button" value="显"  onClick="location.href='?action=nohide&id=<?php echo $row->tid;?>';" class="rb1"><?php }?> <input type="button" value="删" onclick="del(<?php echo $row->tid;?>)" class="rb1"></td>
	</tr>
<?php
		typeList($row->tid,$separateStr,$span);
			}
		}
	}
    
if (!empty($span)){$span=substr($span,(strlen($span)-strlen($separateStr)));}
}

?>