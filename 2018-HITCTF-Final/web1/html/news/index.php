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
function echoIndex()
{
	global $cfg_iscache,$t1;;
	$cacheName="parsed_news";
	$templatePath="/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/newsindex.html";
	if($cfg_iscache){
		if(chkFileCache($cacheName)){
			$indexStr = getFileCache($cacheName);
		}else{
			$indexStr = parseIndexPart($templatePath);
			setFileCache($cacheName,$indexStr);
		}
	}else{
			$indexStr = parseIndexPart($templatePath);
	}
	$indexStr=str_replace("{duomicms:member}",front_member(),$indexStr);
	echo str_replace("{duomicms:runinfo}",getRunTime($t1),$indexStr) ;
}

function parseIndexPart($templatePath)
{
	global $mainClassObj;
	$content=loadFile(duomi_ROOT.$templatePath);
	$content=$mainClassObj->parseTopAndFoot($content);
	$content=replaceCurrentTypeId($content,-444);
	$content=$mainClassObj->parseHistory($content);
	$content=$mainClassObj->parseSelf($content);
	$content=$mainClassObj->parseGlobal($content);
	$content=$mainClassObj->parduomireaList($content);
	$content=$mainClassObj->parseNewsAreaList($content);
	$content=$mainClassObj->parseMenuList($content,"",$currentTypeId);
	$content=$mainClassObj->parseVideoList($content,$currentTypeId);
	$content=$mainClassObj->parseNewsList($content,$currentTypeId);
	$content=$mainClassObj->parseLinkList($content);
	$content=$mainClassObj->parseIf($content);
	return $content;
}
?>