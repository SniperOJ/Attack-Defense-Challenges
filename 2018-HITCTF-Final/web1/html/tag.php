<?php
require_once("duomiphp/common.php");
require_once(duomi_INC."/core.class.php");

$page = (isset($page) && is_numeric($page)) ? $page : 1;

if(!isset($tag)) $tag = '';

$tag = Filtersearch(stripslashes($tag));
$tag = addslashes(cn_substr($tag,20));

if($tag=='')
{
	ShowMsg('标签不能为空！','-1','0',$cfg_search_time);
	exit();
}

echoTagPage();

function echoTagPage()
{
	global $dsql,$cfg_iscache,$mainClassObj,$page,$t1,$cfg_search_time,$searchtype,$tag;
	if($cfg_search_time) checksearchTimes($cfg_search_time);
	$searchTemplatePath = "/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/tag.html";
	$pSize = getPageSizeOnCache($searchTemplatePath,"search","");
	if (empty($pSize)) $pSize=12;
	$whereStr=" where v_tag like '%$tag%'";
	$sql="select vids from duomi_tags where tag='$tag'";
	$row = $dsql->GetOne($sql);
	if(is_array($row))
	{
		$vids=$row['vids'];
		$TotalResult = count(explode(',', $row['vids']));
	}
	else
	{
		$TotalResult = 0;
	}
	$pCount = ceil($TotalResult/$pSize);
	$cacheName="parse_tag_";
	if($cfg_iscache){
		if(chkFileCache($cacheName)){
			$content = getFileCache($cacheName);
		}else{
			$content = parsesearchPart($searchTemplatePath);
			setFileCache($cacheName,$content);
		}
	}else{
			$content = parsesearchPart($searchTemplatePath);
	}
	$tempStr = $content;
	$tempStr = str_replace("{duomicms:tag}",$tag,$tempStr);
	$tempStr = str_replace("{duomicms:tagnum}",$TotalResult,$tempStr);
	$content=$tempStr;
	$content=$mainClassObj->parsePageList($content,$vids,$page,$pCount,$TotalResult,"tag");
	$content=replaceCurrentTypeId($content,-444);
	$content=$mainClassObj->parseIf($content);
	$content=str_replace("{duomicms:member}",front_member(),$content);
	$searchPageStr = $content;
	echo str_replace("{duomicms:runinfo}",getRunTime($t1),$searchPageStr) ;
}

function parsesearchPart($templatePath)
{
	global $mainClassObj;
	$content=loadFile(duomi_ROOT.$templatePath);
	$content=$mainClassObj->parseTopAndFoot($content);
	$content=$mainClassObj->parseSelf($content);
	$content=$mainClassObj->parseGlobal($content);
	$content=$mainClassObj->parseMenuList($content,"",$currentTypeId);
	$content=$mainClassObj->parseVideoList($content,$currentTypeId);
	$content=$mainClassObj->parseTopicList($content);
	return $content;
}

function checksearchTimes($searchtime)
{
	if(GetCookie("sduomi2_tag")=="ok")
	{
		ShowMsg('搜索限制为'.$searchtime.'秒一次','-1','0',$cfg_search_time);
		exit;
	}else{
		PutCookie("sduomi2_tag","ok",$searchtime);
	}
	
}
?>