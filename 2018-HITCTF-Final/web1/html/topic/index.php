<?php
require_once(dirname(__FILE__)."/../duomiphp/common.php");
require_once(duomi_INC."/core.class.php");
checkIP();
//站点状态
if($cfg_website==0)
{
	ShowMsg('站点已关闭!','-1');
	exit();
}
$paras=str_replace(getfileSuffix(),'',$_SERVER['QUERY_STRING']);
$page=$paras;
$page = (isset($page) && is_numeric($page) ? $page : 0);
if($page<1)$page=1;
echoTopicIndex();
function echoTopicIndex()
{
	global $mainClassObj,$cfg_iscache,$t1,$cfg_filesuffix2,$dsql,$page;
	if($GLOBALS['cfg_runmode']=='0'){
		header("Location:/".$GLOBALS['cfg_cmspath'].$GLOBALS['cfg_album_name']."/index".$cfg_filesuffix2);
	}else{
		$cacheName="parse_topic_index";
		$templatePath="/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/topicindex.html";
		$content = parseTopicIndexPart($templatePath,$page);
	}
	$content=$mainClassObj->parseIf($content);
	$content=str_replace("{duomicms:member}",front_member(),$content);
	echo str_replace("{duomicms:runinfo}",getRunTime($t1),$content) ;
}

function parseTopicIndexPart($templatePath,$page)
{
	global $mainClassObj;
	$content=loadFile(duomi_ROOT.$templatePath);
	$content=$mainClassObj->parseTopAndFoot($content);
	$content=replaceCurrentTypeId($content,-444);
	$content=$mainClassObj->parseHistory($content);
	$content=$mainClassObj->parseSelf($content);
	$content=$mainClassObj->parseGlobal($content);
	$content=$mainClassObj->parseMenuList($content,"");
	$content=$mainClassObj->parduomireaList($content);
	$content=$mainClassObj->parseVideoList($content);
	$content=$mainClassObj->parseTopicIndexList($content,$page);
	$content=$mainClassObj->parseLinkList($content);
	$content=$mainClassObj->parseIf($content);
	return $content;
}
?>