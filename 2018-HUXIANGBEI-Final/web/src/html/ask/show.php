<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subask.php");
include("../label.php");

$token = md5(uniqid(rand(), true));    
$_SESSION['token']= $token; 

if (@$_REQUEST["action"]=="addpinglun"){
checkyzm($_POST["yzm"]);

$about=trim($_POST["about"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$face=@$_POST["face"];
$user=trim($_POST["user"]);
if ($user==''){
$user='未登录用户';
}
$ip=trim($_POST["ip"]);
query("insert into zzcms_answer (about,content,face,editor,ip,passed,sendtime)values('$about','$content','$face','$user','$ip',1,'".date('Y-m-d H:i:s')."')");
showmsg('您的提交成功，感谢参与');
}
if (isset($_REQUEST["id"])){
$zxid=trim($_REQUEST["id"]);
checkid($zxid);
}else{
$zxid=0;
}

$sql="select * from zzcms_ask where id='$zxid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
showmsg('不存在相关信息！');
}else{
query("update zzcms_ask set hit=hit+1 where id='$zxid'");
$bigclassid=$row["bigclassid"];
$smallclassid=$row["smallclassid"];
$title=$row["title"];
$content=$row["content"];
$sendtime=$row["sendtime"];
$editor=$row["editor"];
$hit=$row["hit"];
$typeid=$row["typeid"];
$jifen=$row["jifen"];
$smallclassname='';
$rs=query("select classname from zzcms_askclass where classid='".$bigclassid."'");
$row=fetch_array($rs);
$bigclassname=$row["classname"];

if ($smallclassid<>""){
$rs=query("select classname from zzcms_askclass where classid='".$smallclassid."'");
$row=fetch_array($rs);
$smallclassname=$row["classname"];
}


$station=getstation($bigclassid,$bigclassname,$smallclassid,$smallclassname,"","","ask");
$pagetitle=$title.askshowtitle;
$pagekeywords=askshowkeyword;
$pagedescription=askshowdescription;
$zxsm=" <img src='/image/ico_jinbi.gif'> 悬赏积分：".$jifen." 发布日期：".date('Y-m-d',strtotime($sendtime))."&nbsp;&nbsp;发布者：".$editor."&nbsp;&nbsp;共阅".$hit."次"; 


$sql="select * from zzcms_answer where about=".$zxid." and passed=1 order by caina desc,id desc";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
    $pinglun="<div> ";
    while($row=fetch_array($rs)){	
	if ($row["caina"]==1){
	$pinglun=$pinglun ."<div class='boxcaina'></div>";
	}
	$pinglun=$pinglun . "<div class='box'>";

    $pinglun=$pinglun . "<div>回答者：".$row["editor"]." IP：".$row["ip"]." 回答时间：".$row["sendtime"]."</div><hr/>";
    $pinglun=$pinglun . "<div style='padding:10px 0px'>".$row["content"]."</div>";
	if (@$_COOKIE["UserName"]==$editor && $typeid==0){
	$pinglun=$pinglun . "<div><form action='/ask/caina.php' method='post'><input type='hidden' name='answerid'  value='".$row["id"]."'/><input type='hidden' name='token' value='".$token."'/><input type='hidden' name='askid'  value='".$zxid."'/><input type='submit' value='采纳为最佳答案'/></form></div>";
	}
	$pinglun=$pinglun . "</div>";
	}
	$pinglun=$pinglun ."</div>";
    }else{
	$pinglun="&nbsp;暂无回答";
	}

$fp="../template/".$siteskin."/askshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$huida=strbetween($strout,"{huida}","{/huida}");
if ($typeid==1){
$strout=str_replace("{huida}".$huida."{/huida}","",$strout) ;
}else{
$strout=str_replace("{huida}","",$strout) ;
$strout=str_replace("{/huida}","",$strout) ;
}


$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",$station,$strout);
$strout=str_replace("{#zxtitle}",$title,$strout);
$strout=str_replace("{#zxsm}",$zxsm,$strout);
$strout=str_replace("{#zxcontent}",$content,$strout);
$strout=str_replace("{#id}",$zxid,$strout);
$strout=str_replace("{#pinglun}",$pinglun,$strout);
$strout=str_replace("{#getuserip}",getip(),$strout);
$strout=str_replace("{#pinglunren}",@$_COOKIE["UserName"],$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

session_write_close();
echo  $strout;
}
?>