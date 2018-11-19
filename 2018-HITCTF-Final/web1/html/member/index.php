<?php
session_start();
require_once("../duomiphp/common.php");
require_once(duomi_INC.'/core.class.php');
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

if($dm=='group')
{
	//获取会员组
	if(empty($gid))
	{showMsg("请选择要购买的会员组","member.php?action=cc");exit;}
	$sqlgroup1="SELECT * FROM duomi_member_group where gid='$gid'"; 
	$rowgroup1 = $dsql->GetOne($sqlgroup1);
    if(!is_array($rowgroup1)){
        showMsg("会员组不存在","-1");exit;
    }else{
		$groupjf=$rowgroup1['g_upgrade'];  
    }
	//获取会员
	$uname=$_SESSION['duomi_user_name'];
	$sqlgroup2="SELECT * FROM duomi_member where username='$uname'"; 
	$rowgroup2 = $dsql->GetOne($sqlgroup2);
    if(!is_array($rowgroup2)){
        showMsg("会员信息不存在","-1");exit;
    }else{
		$userjf=$rowgroup2['points'];
    }
	
	if($userjf<$groupjf)
	{
		showMsg("金币不足，请充值！","-1");exit;
	} 
	else
	{
		$dsql->executeNoneQuery("UPDATE duomi_member SET points=points-$groupjf,gid=$gid where username='$uname'");
		showMsg("恭喜！购买成功，重新登录后生效！","-1");exit;
	}
	
}

if($dm=='index')
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
	用户信息：
	<table width=\"100%\" style=\"border: 1px solid #E3E3E3;margin:20px 0\">
	<tr align=\"center\">
	<td width=\"180\" style=\"border-right:1px solid #E3E3E3;border-bottom:1px solid #E3E3E3;\">用户名</td>
	<td width=\"180\" style=\"border-right:1px solid #E3E3E3;border-bottom:1px solid #E3E3E3;\">注册邮箱</td>
	<td width=\"180\" style=\"border-right:1px solid #E3E3E3;border-bottom:1px solid #E3E3E3;\">登录次数</td>
	<td width=\"180\" style=\"border-right:1px solid #E3E3E3;border-bottom:1px solid #E3E3E3;\">用户组</td>
	<td width=\"180\" style=\"border-bottom:1px solid #E3E3E3;\">剩余金币</td>
	</tr>
	<tr align=\"center\">
	<td style=\"border-right:1px solid #E3E3E3;\">".$_SESSION['duomi_user_name']."</td>
	<td style=\"border-right:1px solid #E3E3E3;\">".$ccemail."</td>
	<td style=\"border-right:1px solid #E3E3E3;\">".$cclog."</td>
	<td style=\"border-right:1px solid #E3E3E3;\">".$ccgroup."</td>
	<td>".$ccjifen."</td>
	</tr>
	</table>";
	echo"会员组选择：<br/>";
	$sql="select * from duomi_member_group";
	$dsql->SetQuery($sql);
	$dsql->Execute('al');
	while($rowr=$dsql->GetObject('al'))
		{
		echo "<input style=\"background:f5f5f5;border:1px solid #ddd;height:25px;font-size:14px;margin:20px 10px 0 0;cursor: pointer;\" type=button value='".$rowr->gname."需要 ".$rowr->g_upgrade." 金币' onClick=\"self.location='?dm=group&gid=".$rowr->gid."';\">";
		}
}

else
{
$tempfile = duomi_ROOT."/member/html/index.html";
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