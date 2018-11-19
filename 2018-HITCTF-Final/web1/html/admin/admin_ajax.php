<?php
/**
 * ajax
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */
require_once(dirname(__FILE__)."/config.php");
require_once(duomi_INC."/charset.func.php");
AjaxHead();
if(empty($action))
{
	$action = '';
}
$id = empty($id) ? 0 : intval($id);

if($action=="gettopicdes")
{
	$query="select des from `duomi_topic` where id='$id'";
	$row=$dsql->GetOne($query);
	if(!$row)
	{
		echo "err";
	}else{
		echo htmlspecialchars(stripslashes(decodeHtml($row['des'])));
	}
}
elseif($action=="submittopicdes")
{
	$f_id = empty($f_id) ? 0 : intval($f_id);
	$f_des=gbutf8(UnicodeUrl2Gbk(TrimMsg($f_des)));
	$upquery="update `duomi_topic` set des='$f_des' where id='$f_id'";
	if(!$dsql->ExecuteNoneQuery($upquery))
	{
		echo "err";
	}else{
		echo "ok";
	}
}
elseif($action=="submitstate")
{
	$upquery="update `duomi_data` set v_state='$state' where v_id='$id'";
	if(!$dsql->ExecuteNoneQuery($upquery)){
		echo "err";
	}else{
		echo "submitok";
	}
}
elseif($action=="select")
{
	echo makeTopicSelect("topicselect","...请选择专题...",$topicid);
	echo "<input type=\"button\" value=\"确定\" onclick='submitVideoTopic($id)' /> <input type=\"button\" value=\"取消\" onclick='closeWin()' />";
}
elseif($action=="submittopic")
{
	$upquery="update `duomi_data` set v_topic='$topic' where v_id='$id'";
	if(!$dsql->ExecuteNoneQuery($upquery)){
		echo "err";
	}else{
		echo "submitok";
	}
}
elseif($action=='commend'){
	if($type)
	$upquery="update `duomi_news` set n_commend='$commendid' where n_id='$id'";
	else
	$upquery="update `duomi_data` set v_commend='$commendid' where v_id='$id'";
	if(!$dsql->ExecuteNoneQuery($upquery))
	{
		echo "err";
	}else{
		echo "submitok";
	}
}
elseif($action=="updatepic")
{
	require_once(duomi_DATA."/config.ftp.php");
	$row=$dsql->GetOne("select count(*) as dd from duomi_data where instr(v_pic,'#err')=0".($app_ftp==0?"":" and instr(v_pic,'$app_ftpurl')=0")." and instr(v_pic,'http')<>0");
	$num=$row['dd'];
	echo $num;
}
elseif($action=="checkrepeat")
{
	$v_name=iconv('utf-8','utf-8',$_GET["v_name"]); 
	$row=$dsql->GetOne("select count(*) as dd from duomi_data where v_name='$v_name'");
	$num=$row['dd'];
	if($num==0){echo "ok";}else{echo "err";}
}
elseif($action=="getselflabel")
{
	$query="select tagcontent from `duomi_mytag` where aid='$id'";
	$row=$dsql->GetOne($query);
	if(!$row)
	{
		echo "err";
	}else{
		echo htmlspecialchars($row['tagcontent']);
	}
}
elseif($action=="checkuser")
{
	if(m_ereg("[^0-9a-zA-Z_@!\.-]",$username)) exit('no');
	$row=$dsql->GetOne("select count(*) as dd from duomi_admin where name='$username'");
	$num=$row['dd'];
	if($num==0){echo "0";}else{echo "1";}
}
elseif($action=="updatecache")
{
	cache_clear(duomi_ROOT.'/data/cache');
	echo "ok";
}
elseif($action=="clearColHis")
{
	delFile(duomi_ROOT.'/data/cache/collect_xml.php');
	echo "ok";
}
else
{
echo "ok";
}
?>