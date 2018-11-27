<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subdl.php");
$FoundErr=0;
$lookdlsnumber=0;
if (!isset($_COOKIE["UserName"])){
$_COOKIE["UserName"]='';
}

if ($_COOKIE["UserName"]<>''){
$rs=query("select looked_dls_number_oneday from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$_COOKIE["UserName"]."')");
$row=fetch_array($rs);
if ($row){
$lookdlsnumber=$row["looked_dls_number_oneday"];
}
}

$rs=query("select looked_dls_number_oneday from zzcms_looked_dls_number_oneday where username='".$_COOKIE["UserName"]."' and sendtime='".date('Y-m-d')."'");
$row=fetch_array($rs);
if ($row){
	if ($lookdlsnumber<>999 && $row["looked_dls_number_oneday"]>=$lookdlsnumber) {
	$FoundErr=1;
	$ErrMsg="<li>您所在的用户组每天只能查看 ".$lookdlsnumber." 条".channeldl."信息</li>";
	}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
if (isset($_REQUEST["id"])){
$dlid=trim($_REQUEST["id"]);
checkid($dlid);
}else{
$dlid=0;
}

$sql="select * from zzcms_dl where id='$dlid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo showmsg("不存在相关信息！");
}else{
query("update zzcms_dl set hit=hit+1 where id='$dlid'");
$saver=$row["saver"];
$cpid=$row["cpid"];
$bigclasszm=$row["classzm"];
$cp=$row["cp"];
$city=$row["city"];
$sendtime=$row["sendtime"];
$content=nl2br($row["content"]);
$name=$row["dlsname"];
$address=$row["address"];
$tel=$row["tel"];
if ($cpid<>0 ){
$woyaodl="<div><a href='".getpageurl("zs",$cpid)."#dl_liuyan' style='color:red'>我也要".channeldl."该公司产品</a></div>";
}else{
$woyaodl="";
}

$rs=query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}else{
$bigclassname="大类已删除";
}


$pagetitle=$cp."-".dlshowtitle;
$pagekeywords=$cp."-".dlshowkeyword;
$pagedescription=$cp."-".dlshowdescription;
$station=getstation($bigclasszm,$bigclassname,0,"",$cp,"","dl");

$showlx="<ul>";
$showlx=$showlx."<li>联系人：".$name."</li>";
$showlx=$showlx."<li>地址：".$address."</li>";
$showlx=$showlx."<li>电话：".$tel."</li> ";
$showlx=$showlx." </ul> ";        


function Payjf($dlid,$showlx){
$looked=0;
$str="";		       
$sql="select groupid,totleRMB from zzcms_user where username='".$_COOKIE["UserName"]."'";
$rs=query($sql);
$row=fetch_array($rs);				
$totleRMB=$row["totleRMB"];
$sqllooked="select * from zzcms_looked_dls where dlsid=".$dlid." and username='".$_COOKIE["UserName"]."'";
$rslooked=query($sqllooked);//打开已查看过的表，如果是已查看过的信息直接显示
$rowlooked=num_rows($rslooked);

	if ($rowlooked){
	$looked=1;
	$str=$showlx;
	}
	if (!isset($_POST["action"]) && $looked==0){
	$str="<div class='bgcolor1' >";
	$str=$str."<form name='form1' method='post' action=''>";
    $str=$str."<input type='submit' name='Submit2' style='height:30px' value='点击查看联系方式（注：需要".jf_look_dl."个金币,您有".$totleRMB." 个）'>";
    $str=$str."<input name='action' type='hidden' id='action' value='kan'>";
    $str=$str."</form>";
	$str=$str."</div>";	       
	}elseif ($_POST["action"]=="kan"  && $looked==0) {
		if( $totleRMB>=jf_look_dl) {
		query("update zzcms_user set totleRMB=totleRMB-".jf_look_dl." where username='".$_COOKIE["UserName"]."'");//查看时扣除积分
		query("Insert into zzcms_looked_dls(dlsid,username,) values('$dlid','".$_COOKIE["UserName"]."')") ; //付分查看的写入记录表中
		query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('".$_COOKIE['UserName']."','查看".channeldl."信息','-".jf_look_dl."','<a href=/dl/show.php?id=$dlid>$dlid</a>','".date('Y-m-d H:i:s')."')");//写入冲值记录 
		$str=$str.$showlx;
		}else{
		$str=$str."<div class='bgcolor1' >您的帐户中已不足 ".jf_look_dl." 金币，暂不能查看！ <br /><br />";
		$str=$str." <a href='/one/vipuser.php' target='_blank'>点击升级为VIP会员。联系方式随便查看！</a>";
		$str=$str."</div>";
		}
	}
return $str;
}

function contact($showlx,$dlid)
{	
$str="";
switch (isshowcontact){
case "Yes";
$str=$showlx;
break;
case "No";
	if (!isset($_COOKIE["UserName"]) || $_COOKIE["UserName"]=="") {
	$str=$str."<div class='boxin'>";	
	$str=$str."联系方式登录后才能查看！<br>";
	$str=$str."如果您是本站会员请 <a href='javascript:void(0)' onClick=\"MsgBox('用户登录','/user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',360,196,1)\"><strong>登录</strong></a>；";//不要设太宽，有手机用户
	$str=$str."如果不是可以 <a href=/reg/userreg.php target=_parent><strong>免费注册</strong></a> 成为本站会员。";
	$str=$str."</div>";
	}else{
			switch (check_user_power('look_dls_data')){
			case 'no' ;//没有查看代理权限的用户组
			if (jifen=="Yes"){
			$str=$str.Payjf($dlid,$showlx);
			}elseif (jifen=="No"){
			$str=$str."<div class='boxin'>提示：您所在的用户组没有查看".channeldl."商联系方式的权限。<br> ";
			$str=$str."<input name='Submit22' type='button' class='button_big'  value='升级成VIP会员' onClick=\"location.href='/one/vipuser.php'\"/>";
        	$str=$str."</div>";
       		}
			break;
			case 'yes';//有查看代理权限的用户组
			
			$sql="select * from zzcms_looked_dls_number_oneday where username='".$_COOKIE["UserName"]."'";
			$rs=query($sql);
			$row=fetch_array($rs);
			if (!$row){
			query("Insert into zzcms_looked_dls_number_oneday(looked_dls_number_oneday,username,sendtime) values(1,'".$_COOKIE["UserName"]."','".date('Y-m-d')."')") ; //如果没有记录，加入新记录 
			}else{//如果有记录更新记录
				if (date("Y-m-d",strtotime($row['sendtime']))==date('Y-m-d')){//如果当天查看过，查看数加一。
				query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=looked_dls_number_oneday+1 where username='".$_COOKIE["UserName"]."'");
				}else{//如果不是当天查看的查看数设为一，日期设为当天
				query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=1,sendtime='".date('Y-m-d')."' where username='".$_COOKIE["UserName"]."'");
				}
			}	
			$str=$str.$showlx;//更新表后显示联系方式
			break;
			}			
	}
}
return $str;
}

function company($saver,$cpid)
{
$str="";
if ($saver<>""){
	$rs=query("select img,comane,id from zzcms_user where username='".$saver."'");
	$row=fetch_array($rs);
	if ($row){
	$str=$str."<table width='100%' border='0' cellspacing='1' cellpadding='0' class='bgcolor2'>";
	$str=$str."<tr>";
	$str=$str."<td align='center' bgcolor='#FFFFFF' height='170'> ";
	$str=$str."<a href='".getpageurl("zt",$row["id"])."'>";
	$str=$str."<img src='".$row["img"]."' border=0 onload='resizeimg(180,180,this)'></a> ";
	$str=$str."</td>";
	$str=$str."</tr>";
	$str=$str."<tr>";
	$str=$str."<td align='center' >".cutstr($row["comane"],16)."</td>";
	$str=$str."</tr>";
	$str=$str."</table>";
	if ($cpid<>0 ){
	$str=$str."<div class='boxin'>";
	$str=$str."<b>联系方式</b><br/>";
	$str=$str."<a href='".getpageurl("zs",$cpid)."#dl_liuyan' style='color:red'>点击请按内容完整填写，提交后将自动显示该公司电话！</a>";
	$str=$str."</div>";
	}
	}else{
	$str=$str."公司信息已不存在";
	}	
}else{
$str=$str."无意向公司";
}
return $str;
}


$fp="../template/".$siteskin."/dl_show.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagekeywords,$strout);
$strout=str_replace("{#station}",$station,$strout);
$strout=str_replace("{#cp}",$cp,$strout);
$strout=str_replace("{#city}",$city,$strout);
$strout=str_replace("{#sendtime}",$sendtime,$strout);
$strout=str_replace("{#woyaodl}",$woyaodl,$strout);
$strout=str_replace("{#contact}",contact($showlx,$dlid),$strout);
$strout=str_replace("{#company}",company($saver,$cpid),$strout);
$strout=str_replace("{#content}",$content,$strout);
if ($saver!=''){
$strout=str_replace("{#dlmore}",showdl(1,10,16,"","",$saver,"",$dlid),$strout);
}else{
$strout=str_replace("{#dlmore}","暂无信息",$strout);
}
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
}
}
?>