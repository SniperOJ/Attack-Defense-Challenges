<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("../zx/subzx.php");
include("subzs.php");

$token = md5(uniqid(rand(), true));    
$_SESSION['token']= $token;  

if (isset($_REQUEST["id"])){
$cpid=trim($_REQUEST["id"]);
checkid($cpid);
}else{
$cpid=0;
}
if (isset($_COOKIE["zzcmscpid"])){
	if ($cpid<>$_COOKIE["zzcmscpid"]){
	setcookie("zzcmscpid",$cpid.",".$_COOKIE["zzcmscpid"],time()+3600*24*360);
	}else{
	setcookie("zzcmscpid",$cpid,time()+3600*24*360);
	}
}else{
setcookie("zzcmscpid",$cpid,time()+3600*24*360);
}

$sql="select * from zzcms_main where id='$cpid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo showmsg("不存在相关信息！");
}else{
query("update zzcms_main set hit=hit+1 where id='$cpid'");
$editor=$row["editor"];
$cpmc=$row["proname"];
$imgbig=$row["img"];
$img=getsmallimg($row["img"]);
$array_img=getimgincontent($row["sm"],2);
//print_r ($array_img);
$img2=isset($array_img[0])?$array_img[0]:'/image/nopic.gif';
$img3=isset($array_img[1])?$array_img[1]:'/image/nopic.gif';

$flv=$row["flv"];
$bigclasszm=$row["bigclasszm"];
$smallclasszm=$row["smallclasszm"];
if(strpos($smallclasszm,',')!==false){
$smallclasszm=explode(",",$smallclasszm); //转换成数组
$smallclasszm=$smallclasszm[0];//只取第一个小类，供显示在station中
} 
$smallclasszm=str_replace('"',"",$smallclasszm);//开启多选后小类两边都加了""
$sendtime=$row["sendtime"];
$hit=$row["hit"];
$title=$row["title"];
$keywords=$row["keywords"];
$description=$row["description"];
$prouse=$row["prouse"];
$sm=$row["sm"];
$yq=$row["yq"];
$zc=$row["zc"];
$province=$row["province"];
$city=$row["city"];
$xiancheng=$row["xiancheng"];
$groupid=$row["groupid"];
$skin=$row["skin"];

$shuxing_value = explode("|||",$row["shuxing_value"]);

$rs=query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}else{
$bigclassname="大类已删除";
}

$smallclassname='';
if ($smallclasszm<>""){
$rs=query("select classname from zzcms_zsclass where classzm='".$smallclasszm."'");
$row=fetch_array($rs);
if ($row){
$smallclassname=$row["classname"];
}else{
$smallclassname="小类已删除";
}
}
$sql="select * from zzcms_user where username='".$editor."'";
$rs=query($sql);
$row=fetch_array($rs);
$startdate=$row["startdate"];
$comane=$row["comane"];
$gsjj=$row["content"];
$kind=$row["bigclassid"];
$province_company=$row["province"];
$city_company=$row["city"];
$xiancheng_company=$row["xiancheng"];
$somane=$row["somane"];
$userid=$row["id"];
$sex=$row["sex"];
$phone=$row["phone"];
$tel=$row["phone"];//项目单页中有用，避免被下面产品留言中的$phone覆盖这里另取名$tel
$fox=$row["fox"];
$mobile=$row["mobile"];
$qq=$row["qq"];
$email=$row["email"];
//显示公司联系方式
$contact=showcontact("zs",$cpid,$startdate,$comane,$kind,$editor,$userid,$groupid,$somane,$sex,$phone,$qq,$email,$mobile,$fox);

function liuyannum($cpid){
if (showdlinzs=="Yes") {
$rsdl=query("select id from zzcms_dl where cpid=$cpid and passed=1");
$rowdl=num_rows($rsdl);
return "<b>".$rowdl."</b> 条";
}
}

function showflv($flv){
global $img1;
if ($flv!=""){
	$str="<div class='box' style='text-align:center'>";
	if (substr($flv,-3)=="flv") {
		$str=$str . "<span id='container'></span>";
		$str=$str . "<script src='/js/swfobject.js' type='text/javascript'></script>";
		$str=$str . "<script type='text/javascript'>";
		$str=$str . "var s1 = new SWFObject('/image/player.swf','ply','500','360','9','#FFFFFF');";
		$str=$str . "s1.addParam('allowfullscreen','true');";
		$str=$str . "s1.addParam('allowscriptaccess','always');";
		//$str=$str . "s1.addParam('flashvars','file=".$flv."&backcolor=&frontcolor=&image=".$img1."&logo=".logourl."&autostart=false');";	//可显示LOGO的
		$str=$str . "s1.addParam('flashvars','file=".$flv."&backcolor=&frontcolor=&image=".$img1."&autostart=false');";	
		$str=$str . "s1.write('container');";
		$str=$str . "</script>";
	}elseif (substr($flv,-3)=="swf"){
		$str=$str . "<embed src='".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=500 height=360></embed>";
	}
$str=$str . "</div>" ;
return  $str;
}
}
if ($skin=='cp'){
$fp="../template/".$siteskin."/zsshow.htm";
}elseif ($skin=='xm'){
$fp="../template/".$siteskin."/zsshow2.htm";
}else{
$fp="../template/".$siteskin."/zsshow.htm";
}

if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}

$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

//liuyan
$liuyan=strbetween($strout,"{liuyan}","{/liuyan}");
$list=strbetween($liuyan,"{loop}","{/loop}");

if ($bigclasszm!=''){
$rs=query("select * from zzcms_dl_".$bigclasszm." where cpid=$cpid and passed=1 order by id desc");
}else{
$rs=query("select * from zzcms_dl where cpid=$cpid and passed=1 order by id desc");
}
$row=num_rows($rs);
if ($row){
$list2='';
while ($row=fetch_array($rs)){
$list2 = $list2. str_replace("{#content}",cutstr($row["content"],8),$list) ;
$list2 =str_replace("{#dlsname}",$row["dlsname"],$list2) ;
$list2 =str_replace("{#tel}",str_replace(substr($row['tel'],3,4),"****",$row['tel']),$list2) ;
$list2 =str_replace("{#city}",$row['city'],$list2) ;
$list2 =str_replace("{#sendtime}",$row['sendtime'],$list2) ;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{liuyan}","",$strout) ;
$strout=str_replace("{/liuyan}","",$strout) ;
}else{
$strout=str_replace("{liuyan}".$liuyan."{/liuyan}","暂无信息",$strout) ;
}
//代理表单

$strout=str_replace("{textarea}","<textarea rows=5 cols=30 name='contents' id='contents' onfocus='check_contents()' onblur='check_contents()'>我对这个产品感兴趣，请与我联系。</textarea>",$strout);
$strout=str_replace("{#proname}",str_replace(',','',$cpmc),$strout);
$strout=str_replace("{#cpid}",$cpid,$strout);
$strout=str_replace("{#fbr}",$editor,$strout);
$strout=str_replace("{#bigclassid}",$bigclasszm,$strout);
$strout=str_replace("{#token}",$token,$strout);

$companyname="";
$somane=$rown="";
$phone=$rown="";
$email=$rown="";
if (isset($_COOKIE["UserName"])) {
if (trim($_COOKIE["UserName"])!=$editor){//产品发布人登录时不显示自己的联系方式在表单
$rsn=query("select comane,somane,phone,email from zzcms_user where username='".trim($_COOKIE["UserName"])."'");
$rown=fetch_array($rsn);
$companyname=$rown["comane"];

$somane=$rown["somane"];
$phone=$rown["phone"];
$email=$rown["email"];
}
}
$strout=str_replace("{#companyname}",$companyname,$strout) ;
$strout=str_replace("{#somane}",$somane,$strout) ;
$strout=str_replace("{#phone}",$phone,$strout);
$strout=str_replace("{#email}",$email,$strout);
//end

//访客地理位置
$cuestip=getip(); 
$cuest_city=getIPLoc_sina($cuestip); 
$cuest_city=str_replace('联通','',str_replace('网通','',str_replace('电信','',$cuest_city)));

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
//$strout=str_replace("{#station}",getstation($bigclasszm,$bigclassname,$smallclasszm,$smallclassname,$cpmc,"","zs"),$strout) ;
$strout=str_replace("{#station}",getstation($bigclasszm,$bigclassname,$smallclasszm,$smallclassname,"","","zs"),$strout) ;//把产品名设为空，导航里不再显示产品名
if ($title<>"") {
$strout=str_replace("{#pagetitle}",$title.zsshowtitle,$strout);
}else{
$strout=str_replace("{#pagetitle}",$cpmc,$strout);
}
$strout=str_replace("{#pagekeywords}",$keywords.zsshowkeyword,$strout);
$strout=str_replace("{#pagedescription}",$description.zsshowdescription,$strout);
$strout=str_replace("{#img}",$img,$strout);
$strout=str_replace("{#img2}",$img2,$strout);
$strout=str_replace("{#img3}",$img3,$strout);
$strout=str_replace("{#imgbig}",$imgbig,$strout);
$strout=str_replace("{#proname}",str_replace(',','',$cpmc),$strout);
$strout=str_replace("{#cpid}",$cpid,$strout);
$strout=str_replace("{#prouse}",nl2br($prouse),$strout);
$strout=str_replace("{#comane}",$comane,$strout);
$strout=str_replace("{#gsjj}",$gsjj,$strout);
$strout=str_replace("{#sendtime}",$sendtime,$strout);
$strout=str_replace("{#hit}",$hit,$strout);
$strout=str_replace("{#liuyannum}",liuyannum($cpid),$strout);
$strout=str_replace("{#flv}",showflv($flv),$strout);
$strout=str_replace("{#cuest_city}",$cuest_city,$strout);
$strout=str_replace("{#province_company}",$province_company,$strout);
$strout=str_replace("{#city_company}",$city_company,$strout);
$strout=str_replace("{#xiancheng_company}",$xiancheng_company,$strout);
$strout=str_replace("{#province}",$province,$strout);
$strout=str_replace("{#city}",$city,$strout);
$strout=str_replace("{#xiancheng}",$xiancheng,$strout);
$strout=str_replace("{#sm}",$sm,$strout);
$strout=str_replace("{#zc}",nl2br($zc),$strout);
$strout=str_replace("{#yq}",nl2br($yq),$strout);
$strout=str_replace("{#contact}",$contact,$strout);
$strout=str_replace("{#editor}",$editor,$strout);
$strout=str_replace("{#tel}",$tel,$strout);

for ($i=0; $i< count($shuxing_value);$i++){
$strout=str_replace("{#shuxing".$i."}",$shuxing_value[$i],$strout);
}

$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
//if (strpos($strout,"{@")!==false) $strout=showlabel($strout);//先查一下，如是要没有的就不用再调用showlabel
$strout=showlabel($strout);
echo  $strout;
}
session_write_close();
?>