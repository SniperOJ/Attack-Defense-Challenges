<?php
/**
 * 引入文件
 *
 * @version        2015年7月12日Z by 海东青
 * @package        DuomiCms.Administrator
 * @copyright      Copyright (c) 2015, SamFea, Inc.
 * @link           http://www.duomicms.net
 */

require_once ("../duomiphp/common.php");
require_once duomi_INC."/core.class.php";
//手机开关判断
if($cfg_mobile==0)
{
	ShowMsg('手机版尚未开启!','-1');
	exit();
}
if($cfg_runmode=='0')
{
	header("Location:index".$cfg_filesuffix2);
}
    checkIP();
	echoIndex();
function echoIndex()
{
	global $cfg_iscache,$t1;;
	$cacheName="parsed_index";
	$templatePath="/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/"."mobile"."/index.html";
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
	$content=$mainClassObj->parseSelf($content);
	$content=$mainClassObj->parseHistory($content);
	$content=$mainClassObj->parseGlobal($content);
	$content=$mainClassObj->parduomireaList($content);
	$content=$mainClassObj->parseNewsAreaList($content);
	$content=$mainClassObj->parseMenuList($content,"",$currentTypeId);
	$content=$mainClassObj->parseVideoList($content,$currentTypeId);
	$content=$mainClassObj->parseNewsList($content,$currentTypeId);
	$content=$mainClassObj->parseTopicList($content);
	$content=$mainClassObj->parseLinkList($content);
	$content=$mainClassObj->parseIf($content);
	return $content;
}
?>