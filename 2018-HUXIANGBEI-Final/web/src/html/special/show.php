<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subzt.php");
include("../label.php");

if (@$_REQUEST["action"]=="addpinglun"){
checkyzm($_POST["yzm"]);
session_write_close();
$about=trim($_POST["about"]);
$content=substr(trim($_POST["content"]),0,200);
$face=@$_POST["face"];
$user=trim($_POST["user"]);
if ($user==''){
$user='未登录用户';
}
$ip=trim($_POST["ip"]);
query("insert into zzcms_pinglun (about,content,face,username,ip,sendtime)values('$about','$content','$face','$user','$ip','".date('Y-m-d H:i:s')."')");
showmsg('您的评论提交成功，正在审核... 感谢参与');
}
if (isset($_REQUEST["id"])){
$zxid=trim($_REQUEST["id"]);
checkid($zxid);
}else{
$zxid=0;
}

$sql="select * from zzcms_special where id='$zxid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
showmsg('不存在相关信息！');
}else{
query("update zzcms_special set hit=hit+1 where id='$zxid'");
$bigclassid=$row["bigclassid"];
$smallclassid=$row["smallclassid"];
$title=$row["title"];
$content=$row["content"];
$keywords=$row["keywords"];
$description=$row["description"];
$laiyuan=$row["laiyuan"];
$sendtime=$row["sendtime"];
$editor=$row["editor"];
$hit=$row["hit"];
$groupid=$row["groupid"];//查看信息的用户组级别
$jifen=$row["jifen"];//查看信息所需积分
$smallclassname='';
$rs=query("select classname from zzcms_specialclass where classid='".$bigclassid."'");
$row=fetch_array($rs);
$bigclassname=$row["classname"];

if ($smallclassid<>""){
$rs=query("select classname from zzcms_specialclass where classid='".$smallclassid."'");
$row=fetch_array($rs);
$smallclassname=$row["classname"];
}
$station=getstation_zt($bigclassid,$bigclassname,$smallclassid,$smallclassname,"","","special");
$pagetitle=$title.ztshowtitle."-".sitename;
$pagekeywords=$keywords.ztshowkeyword;
$pagedescription=$description.ztshowdescription;
$zxsm="来源：".$laiyuan." 发布日期：".$sendtime." 发布者：".$editor." 共阅".$hit."次　字体：<a href='javascript:fontZoom(16)'>大</a> <a href='javascript:fontZoom(14)'>中</a> <a href='javascript:fontZoom(12)'>小</a>"; 

function Payjf(){
global $content,$zxid,$jifen,$editor;
$looked=0;
$str="";		       
$sql="select groupid,totleRMB from zzcms_user where username='".$_COOKIE["UserName"]."'";
$rs=query($sql);
$row=fetch_array($rs);				
$totleRMB=$row["totleRMB"];

	if (!isset($_POST["action"]) && $looked==0){
	$str="<div class='box' >";
	$str=$str."<form name='form1' method='post' action=''>";
    $str=$str."<input type='submit' name='Submit2' style='height:30px' value='点击查看（注：需要".$jifen."个金币,您目前有".$totleRMB." 个金币）'>";
    $str=$str."<input name='action' type='hidden' id='action' value='kan'>";
    $str=$str."</form>";
	$str=$str."</div>";	       
	}elseif ($_POST["action"]=="kan"  && $looked==0) {
		if( $totleRMB>=$jifen) {
		query("update zzcms_user set totleRMB=totleRMB-".$jifen." where username='".$_COOKIE["UserName"]."'");//查看时扣除积分
		query("update zzcms_user set totleRMB=totleRMB+".$jifen." where username='".$editor."'");//给发布者加积分
		query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".$_COOKIE['UserName']."','查看资讯信息','-".$jifen."','<a href=/zx/show.php?id=$zxid>$zxid</a>','".date('Y-m-d H:i:s')."')");//写入冲值记录
		query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".$editor."','资讯信息售出','+".$jifen."','<a href=/zx/show.php?id=$zxid>$zxid</a>','".date('Y-m-d H:i:s')."')");//写入冲值记录  
		$str=$str.showcontent($content,$zxid);
		}else{
		$str=$str."<div class='bgcolor1' >您的帐户中已不足 ".$jifen." 金币，暂不能查看！ <br /><br />";
		$str=$str."</div>";
		}
	}
return $str;
}

function showcontent(){	//分页显示资讯
global $content,$zxid ;
$sql="Select * From zzcms_tagzx";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str=$content;
}else{	
	$str=str_replace($row["keyword"],"<a href='".$row["url"]."' target='_blank' style='color:blue'>".$row["keyword"]."</a>",$content);	  
	while($row=fetch_array($rs)){
	$str=str_replace($row["keyword"],"<a href='".$row["url"]."' target='_blank' style='color:blue'>".$row["keyword"]."</a>",$str);	  
	}
}
//$str=replace($str,"<img","<img onload='this.width=resizeimg(650,650,this)'")'css定了宽度这里不起做用
//以下为分页显示
if (isset($_REQUEST["page"])){
$page=$_REQUEST["page"];
checkid($page);
}else{
$page=1;
}
//文章正文部分,利用explode得出共有多少页
$allpage = explode("#page#",$str);//如果 separator 所包含的值在 string 中找不到，那么 explode() 将返回包含 string 中单个元素的数组

if (count($allpage)==1 || $str=="") {//当str为空时直接输出
$str=$str;
}else{
if ($page>count($allpage) ){//当大于最大下标值时，使等于它
$page=count($allpage)+1;
}

$str=$allpage[$page-1];//分页显示正文
$str=$str. "<div style='text-align:center;padding:20px'>";
for ($i=1;$i<count($allpage)+1;$i++){
	if (whtml=="Yes"){
	$str=$str. "<a href='show-".$zxid."-".$i.".htm'>第".$i."页</a> ";
	}else{
	$str=$str. "<a href='?id=".$zxid."&page=".$i."'>第".$i."页</a> ";
	}
}
$str=$str. "</div>";
}
return $str;
}

if ($groupid==0){
$zxcontent=showcontent();
}else{
	if (!isset($_COOKIE["UserName"]) || $_COOKIE["UserName"]=="") {
	$zxcontent="<div class='box'>";	
	$zxcontent=$zxcontent."登录后才能查看！<br>";
	$zxcontent=$zxcontent."如果您是本站会员请 <a href='javascript:' onClick=\"MsgBox('用户登录','../user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',460,196,1)\"><strong>登录</strong></a>；";
	$zxcontent=$zxcontent."如果不是可以 <a href='/reg/userreg.php' target='_parent'><strong>免费注册</strong></a> 成为本站会员。";
	$zxcontent=$zxcontent."</div>";
	}else{ 
		if (jifen=="Yes"){
			if($jifen==0){//当用户设定为不让用积分查看时
			$zxcontent="<div class='box'>提示：您所在的用户组没有查看本条信息的权限。</div> ";
			}else{
			$zxcontent=Payjf();
			}
		}elseif (jifen=="No"){
		$zxcontent="<div class='box'>提示：您所在的用户组没有查看本条信息的权限。</div> ";
       	}		
	}
}


$sql="select * from zzcms_special where id < ".$zxid." and passed=1 and bigclassid in (select classid from zzcms_zxclass where isshowininfo=1 and parentid=0) order by id desc limit 0,1";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$nextid="上一篇文章：<a href=".getpageurl("zx",$row["id"]).">".$row["title"]."</a><br/> ";
}else{ 
$nextid="上一篇文章：没有了<br/>";
}
	
$sql="select * from zzcms_special where id > ".$zxid." and passed=1 and bigclassid in (select classid from zzcms_zxclass where isshowininfo=1 and parentid=0) order by id asc limit 0,1";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$nextid=$nextid . "下一篇文章：<a href=".getpageurl("zx",$row["id"]).">".$row["title"]."</a> ";
}else{ 
$nextid=$nextid . "下一篇文章：没有了";
}
	
$sql="select * from zzcms_pinglun where about=".$zxid." and passed=1 order by id desc";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
    $pinglun="<ul> ";
    while($row=fetch_array($rs)){	
	
	$pinglun=$pinglun . "<div class='box'>";
    $pinglun=$pinglun . "<div>评论人：".$row["username"]." IP：".$row["ip"]." 评论时间：".$row["sendtime"]."</div>";
    $pinglun=$pinglun . "<div>".$row["content"]."</div>";
	$pinglun=$pinglun . "</div>";
	}
	$pinglun=$pinglun ."</ul>";
    }else{
	$pinglun="&nbsp;暂无评论";
	}

$fp="../template/".$siteskin."/specialshow.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",$station,$strout);
$strout=str_replace("{#zxtitle}",$title,$strout);
$strout=str_replace("{#zxsm}",$zxsm,$strout);
$strout=str_replace("{#zxcontent}",$zxcontent,$strout);
$strout=str_replace("{#id}",$zxid,$strout);
$strout=str_replace("{#nextid}",$nextid,$strout);
$strout=str_replace("{#pinglun}",$pinglun,$strout);
$strout=str_replace("{#getuserip}",getip(),$strout);
$strout=str_replace("{#pinglunren}","",$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

session_write_close();
echo  $strout;
}
?>