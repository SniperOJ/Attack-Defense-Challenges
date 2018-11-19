<?php
session_start();
require_once("../duomiphp/common.php");
require_once(duomi_INC."/core.class.php");
if($cfg_user==0)
{
	ShowMsg('系统已关闭会员功能，正在转向网站首页','/',0,2000);
	exit();
}
$action = isset($action) ? trim($action) : '';
$pg = isset($pg) ? intval($pg) : 1;
$uid=$_SESSION['duomi_user_id'];
if(empty($_SESSION['duomi_user_id']))
{
	showMsg("请先登录","login.php");
	exit();
}

if($dm=='yq')
{
	$ccgid=$_SESSION['duomi_user_group'];
	$ccuid=$_SESSION['duomi_user_id'];
	$cc1=$dsql->GetOne("select * from duomi_member_group where gid=$ccgid");
	$ccgroup=$cc1['gname'];
	$cc2=$dsql->GetOne("select * from duomi_member where id=$ccuid");
	$ccjifen=$cc2['points'];
	$ccemail=$cc2['email'];
	$cclog=$cc2['logincount'];
	echo "
	<table>
        <tr>
          <td>注册地址一：</td>
          <td><input type=\"txt\" class=\"textInput\" style=\"width:300px;padding-left:10px;height: 30px; line-height: 30px; border: 1px solid #e3e3e3;\" size=\"20\" maxlength=\"30\" name=\"newpwd\" value=\"http://127.0.0.1/member/reg.php?".$_SESSION['duomi_user_id']."\" /></td>
        </tr>
        <tr>
          <td>注册地址二：</td>
          <td><input type=\"txt\" class=\"textInput\" style=\"width:300px;padding-left:10px;height: 30px; line-height: 30px; border: 1px solid #e3e3e3;\" size=\"20\" maxlength=\"30\" name=\"newpwd\" value=\"http://127.0.0.1/member/reg.php?".$_SESSION['duomi_user_name']."\" /></td>
        </tr>
      </table>";
	
}

else
{
	$tempfile = duomi_ROOT."/member/html/invitation.html";
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