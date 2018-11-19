<?php
require_once("duomiphp/common.php");
require_once(duomi_INC."/core.class.php");
checkIP();
$schwhere = '';
foreach($_GET as $k=>$v)
{
	$area=str_replace("phpinfo()","",$area);
	$jq=str_replace("phpinfo()","",$jq);
	$order=str_replace("phpinfo()","",$order);
	$year=str_replace("phpinfo()","",$year);
	$area=str_replace("'","",$area);
	$jq=str_replace("'","",$jq);
	$order=str_replace("'","",$order);
	$year=str_replace("'","",$year);
	$$k=_RunMagicQuotes(gbutf8(RemoveXSS($v)));
	$schwhere.= "&$k=".urlencode($$k);

    $$k=str_ireplace(";","；",$v);
	$$k=str_ireplace("if","hitctf",$v);//you can't hack me with parseif any more!!!

    //emmmm……
}
$schwhere = ltrim($schwhere,'&');

$page = (isset($page) && is_numeric($page)) ? $page : 1;
$searchtype = (isset($searchtype) && is_numeric($searchtype)) ? $searchtype : -1;
$tid = (isset($tid) && is_numeric($tid)) ? intval($tid) : 0;
if(!isset($searchword)) $searchword = '';
$action = $_REQUEST['action'];
$searchword = RemoveXSS(stripslashes($searchword));
$searchword = addslashes(cn_substr($searchword,20));
if($cfg_notallowstr !='' && m_eregi($cfg_notallowstr,$searchword))
{
	ShowMsg("你的搜索关键字中存在非法内容，被系统禁止！","index.php","0",$cfg_search_time);
	exit();
}
if($searchword==''&&$searchtype!=5)
{
	ShowMsg('关键字不能为空！','index.php','0',$cfg_search_time);
	exit();
}

echosearchPage();

function echosearchPage()
{
	global $dsql,$cfg_iscache,$mainClassObj,$page,$t1,$cfg_search_time,$searchtype,$searchword,$tid,$year,$letter,$area,$yuyan,$state,$ver,$order,$jq,$cfg_basehost;
	$order = !empty($order)?$order:time;
	
	/*if(!empty($area)){
		$area=str_replace("phpinfo()","",$area);
		$area=str_replace("'","",$area);
		$area=str_replace('"',"",$area);
	}
	*/
	
	
	if(intval($searchtype)==5)
	{
		
	
		$searchTemplatePath = "/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/cascade.html";
		$typeStr = !empty($tid)?intval($tid).'_':'0_';
		$yearStr = !empty($year)?PinYin($year).'_':'0_';
		$letterStr = !empty($letter)?$letter.'_':'0_';
		$areaStr = !empty($area)?PinYin($area).'_':'0_';
		$orderStr = !empty($order)?$order.'_':'0_';
		$jqStr = !empty($jq)?$jq.'_':'0_';
		$cacheName="parse_cascade_".$typeStr.$yearStr.$letterStr.$areaStr.$orderStr;
		$pSize = getPageSizeOnCache($searchTemplatePath,"cascade","");
	}else
	{
		if($cfg_search_time&&$page==1) checksearchTimes($cfg_search_time);
		$searchTemplatePath = "/duomiui/".$GLOBALS['cfg_df_style']."/".$GLOBALS['cfg_df_html']."/search.html";
		$cacheName="parse_search_";
		$pSize = getPageSizeOnCache($searchTemplatePath,"search","");
	}
	if (empty($pSize)) $pSize=12;
	switch (intval($searchtype)) {
		case -1:
			$whereStr=" where v_recycled=0 and (v_name like '%$searchword%' or v_actor like '%$searchword%' or v_director like '%$searchword%' or v_publisharea like '%$searchword%'  or v_publishyear like '%$searchword%' or v_letter='$searchword' or v_tags='$searchword' or v_nickname like '%$searchword%')";
		break;
		case 0:
			$whereStr=" where v_recycled=0 and v_name like '%$searchword%'";	
		break;
		case 1:
			$whereStr=" where v_recycled=0 and v_actor like '%$searchword%'";
		break;
		case 2:
			$whereStr=" where v_recycled=0 and v_publisharea like '%$searchword%'";
		break;
		case 3:
			$whereStr=" where v_recycled=0 and v_publishyear like '%$searchword%'";
		break;
		case 4:
			$whereStr=" where v_recycled=0 and v_letter='".strtoupper($searchword)."'";
		break;
		case 5:
			$whereStr=" where v_recycled=0";
			if(!empty($tid)) $whereStr.=" and (tid in (".getTypeId($tid).") or FIND_IN_SET('".$tid."',v_extratype)<>0)";
			if($year=="more")
				{
				$publishyeartxt=duomi_DATA."/admin/publishyear.txt";
						$publishyear = array();
						if(filesize($publishyeartxt)>0)
						{
							$publishyear = file($publishyeartxt);
						}
						$yearArray=$publishyear;
						$yeartxt= implode(',',$yearArray);
						$whereStr.=" and v_publishyear not in ($yeartxt)";
				}
			if(!empty($year) AND $year!="more")
				{$whereStr.=" and v_publishyear='$year'";}
			if($letter=="0-9")
				{$whereStr.=" and v_letter in ('0','1','2','3','4','5','6','7','8','9')";}
			if(!empty($letter) AND $letter!="0-9")
				{$whereStr.=" and v_letter='$letter'";}
			if(!empty($area)) $whereStr.=" and v_publisharea='$area'";
			if(!empty($yuyan)) $whereStr.=" and v_lang='$yuyan'";
			if(!empty($jq)) $whereStr.=" and v_jq like'%$jq%'";
			if($state=='l') $whereStr.=" and v_state !=0";
			if($state=='w') $whereStr.=" and v_state=0";
			if(!empty($ver)) $whereStr.=" and v_ver='$ver'";
		break;
	}
	$sql="select count(*) as dd from duomi_data ".$whereStr;
	$row = $dsql->GetOne($sql);
	if(is_array($row))
	{
		$TotalResult = $row['dd'];
	}
	else
	{
		$TotalResult = 0;
	}
	$pCount = ceil($TotalResult/$pSize);
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
	$content = str_replace("{searchpage:page}",$page,$content);
	$content = str_replace("{duomicms:searchword}",$searchword,$content);
	$content = str_replace("{duomicms:searchnum}",$TotalResult,$content);
	$content = str_replace("{searchpage:ordername}",$order,$content);
	
	$content = str_replace("{searchpage:order-hit-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=hit&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	$content = str_replace("{searchpage:order-hitasc-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=hitasc&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	
	$content = str_replace("{searchpage:order-id-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=id&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	$content = str_replace("{searchpage:order-idasc-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=idasc&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	
	$content = str_replace("{searchpage:order-time-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=time&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	$content = str_replace("{searchpage:order-timeasc-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=timeasc&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	
	$content = str_replace("{searchpage:order-commend-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=commend&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	$content = str_replace("{searchpage:order-commendasc-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=commendasc&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	
	$content = str_replace("{searchpage:order-score-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=score&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	$content = str_replace("{searchpage:order-scoreasc-link}",$cfg_basehost."/search.php?page=".$page."&searchtype=5&order=scoreasc&tid=".$tid."&area=".$area."&year=".$year."&letter=".$letter."&yuyan=".$yuyan."&state=".$state."&ver=".$ver."&jq=".$jq,$content);
	if(intval($searchtype)==5)
	{
		$tname = !empty($tid)?getTypeNameOnCache($tid):'全部';
		$jq = !empty($jq)?$jq:'全部';
		$area = !empty($area)?$area:'全部';
		$year = !empty($year)?$year:'全部';
		$yuyan = !empty($yuyan)?$yuyan:'全部';
		$letter = !empty($letter)?$letter:'全部';
		$state = !empty($state)?$state:'全部';
		$ver = !empty($ver)?$ver:'全部';
		$content = str_replace("{searchpage:type}",$tid,$content);
		$content = str_replace("{searchpage:typename}",$tname ,$content);
		$content = str_replace("{searchpage:year}",$year,$content);
		$content = str_replace("{searchpage:area}",$area,$content);
		$content = str_replace("{searchpage:letter}",$letter,$content);
		$content = str_replace("{searchpage:lang}",$yuyan,$content);
		$content = str_replace("{searchpage:jq}",$jq,$content);
		if($state=='w'){$state2="完结";}elseif($state=='l'){$state2="连载中";}else{$state2="全部";}
		$content = str_replace("{searchpage:state}",$state2,$content);
		$content = str_replace("{searchpage:ver}",$ver,$content);
		$content=$mainClassObj->parsePageList($content,"",$page,$pCount,$TotalResult,"cascade");
		$content=$mainClassObj->parsesearchItemList($content,"type");
		$content=$mainClassObj->parsesearchItemList($content,"year");
		$content=$mainClassObj->parsesearchItemList($content,"area");
		$content=$mainClassObj->parsesearchItemList($content,"letter");
		$content=$mainClassObj->parsesearchItemList($content,"lang");
		$content=$mainClassObj->parsesearchItemList($content,"jq");
		$content=$mainClassObj->parsesearchItemList($content,"state");
		$content=$mainClassObj->parsesearchItemList($content,"ver");
	}else
	{
		$content=$mainClassObj->parsePageList($content,"",$page,$pCount,$TotalResult,"search");
	}
	$content=replaceCurrentTypeId($content,-444);
	$content=$mainClassObj->parseIf($content);
	$content=str_replace("{duomicms:member}",front_member(),$content);
	$searchPageStr = $content;
	echo str_replace("{duomicms:runinfo}",getRunTime($t1),$searchPageStr) ;
}

function parsesearchPart($templatePath)
{
	global $mainClassObj,$tid;
	$currentTypeId = empty($tid)?0:$tid;
	$content=loadFile(duomi_ROOT.$templatePath);
	$content=$mainClassObj->parseTopAndFoot($content);
	$content=$mainClassObj->parduomireaList($content);
	$content=$mainClassObj->parseHistory($content);
	$content=$mainClassObj->parseSelf($content);
	$content=$mainClassObj->parseGlobal($content);
	$content=$mainClassObj->parseMenuList($content,"",$currentTypeId);
	$content=$mainClassObj->parseVideoList($content,$currentTypeId);
	$content=$mainClassObj->parsenewsList($content,$currentTypeId);
	$content=$mainClassObj->parseTopicList($content);
	return $content;
}

function checksearchTimes($searchtime)
{
	if(GetCookie("sduomi2_search")=="ok")
	{
		ShowMsg('搜索限制为'.$searchtime.'秒一次','index.php','0',$cfg_search_time);
		//PutCookie("sduomi2_search","ok",$searchtime);
		exit;
	}else{
		PutCookie("sduomi2_search","ok",$searchtime);
	}
	
}
