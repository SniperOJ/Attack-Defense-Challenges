<?php
session_start();
require_once("../duomiphp/common.php");
require_once(duomi_INC."/core.class.php");
if($cfg_user==0)
{
	ShowMsg('系统已关闭会员功能，正在转向网站首页','/',0,2000);
	exit();
}
$svali = $_SESSION['duomi_ckstr'];
if($dopost=='login')
{
	$validate = empty($validate) ? '' : strtolower(trim($validate));
	if($validate=='' || $validate != $svali)
	{
		ResetVdValue();
		ShowMsg('验证码不正确!','login.php');
		exit();
	}
	if($userid=='')
	{
		ShowMsg('请输入用户名!','login.php');
		exit();
	}
	if($pwd=='')
	{
		ShowMsg('请输入密码!','login.php');
		exit();
	}


$pwd = substr(md5($pwd),5,20);
$row1=$dsql->GetOne("select * from duomi_member where username='$userid'");
if($row1['username']==$userid AND $row1['password']==$pwd)
		{
					$_SESSION['duomi_user_id'] = $row1['id'];
					$_SESSION['duomi_user_name'] = $row1['username'];
					$_SESSION['duomi_user_group'] = $row1['gid'];
					$dsql->ExecuteNoneQuery("UPDATE `duomi_member` set logincount=logincount+1");
					ShowMsg("成功登录，正在转向首页！","/",0,3000);
					exit();

		}
		else
		{
			ShowMsg("账号或密码错误","../member/login.php",0,3000);
			exit();
		}
}
else
{
	$tempfile = duomi_ROOT."/member/html/login.html";
	$content=loadFile($tempfile);
	$t=$content;
	$t=$mainClassObj->parseTopAndFoot($t);
	$t=$mainClassObj->parseHistory($t);
	$t=$mainClassObj->parseSelf($t);
	$t=$mainClassObj->parseGlobal($t);
	$t=$mainClassObj->parduomireaList($t);
	$t=$mainClassObj->parseMenuList($t,"");
	$t=$mainClassObj->parseVideoList($t,-444);
	$t=$mainClassObj->parseNewsList($t,-444);
	$t=$mainClassObj->parseTopicList($t);
	$t=replaceCurrentTypeId($t,-444);
	$t=$mainClassObj->parseIf($t);
	$t=str_replace("{duomicms:member}",front_member(),$t);
	echo $t;
	exit();
}