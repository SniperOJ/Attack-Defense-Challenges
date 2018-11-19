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
CheckPurview('');

include(duomi_ADMIN.'/html/admin_labelguide.htm');
exit();

function makeTopicOptions($strSelect)
{
	global $dsql,$cfg_iscache;
	$sql="select id,name from duomi_topic order by sort asc";
	if($cfg_iscache){
	$mycachefile=md5('array_Topic_Lists_all');
	setCache($mycachefile,$sql);
	$rows=getCache($mycachefile);
	}else{
	$rows=array();
	$dsql->SetQuery($sql);
	$dsql->Execute('al');
	while($rowr=$dsql->GetObject('al'))
	{
	$rows[]=$rowr;
	}
	unset($rowr);
	}
	if(count($rows)==0) $str = "<option value='-1'>".$strSelect."</option>";
	foreach($rows as $row)
	{
		$str .= "<option value='".$row->id."'>$row->name</option>";
	}
	return $str;
}
?>