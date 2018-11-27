<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");

$token = md5(uniqid(rand(), true));    
$_SESSION['token']= $token; 

if(isset($_REQUEST['cpid'])){
$cpid=$_REQUEST['cpid'];
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

$rs=query("select * from zzcms_main where id='$cpid'");
$row=num_rows($rs);
if(!$row){
showmsg('无记录');
}else{
$row=fetch_array($rs);
$editorinzsshow=$row["editor"];//供传值到top.php
$fbr=$row["editor"];
$cpmc=$row['proname'];
$prouse=$row['prouse'];
$cpimg=$row["img"];
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
$sm=$row["sm"];
$yq=$row["yq"];
$zc=$row["zc"];
$province=$row["province"];
$city=$row["city"];
$shuxing_value = explode("|||",$row["shuxing_value"]);

$smallclassname='';
$rsn=query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
$rown=fetch_array($rsn);
$bigclassname=$rown["classname"];
if ($smallclasszm<>""){
$rsn=query("select classname from zzcms_zsclass where classzm='".$smallclasszm."'");
$rown=fetch_array($rsn);
$smallclassname=$rown["classname"];
}

include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/zsshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if($title<>''){
$pagetitle=$title;
}else{
$pagetitle=$cpmc.zsshowtitle."厂家:".$comane;
}
$pagekeywords=$cpmc.zsshowkeyword."厂家:".$comane;
if($description<>''){
$pagedescription=$description;
}else{
$pagedescription=$cpmc.zsshowdescription."产品特点：".cutstr($prouse,200);
}

//station
if(whtml=="Yes"){
	$station="<a href='".siteurl."'>网站首页</a> &gt; <a href='zs-".$id.".htm'>".channelzs."</a> ";
	$station=$station." &gt; <a href='zs-".$id."-".$bigclasszm.".htm'>".$bigclassname."</a>";
	if ($smallclasszm<>''){
	$station=$station." &gt; <a href='zs-".$id."-".$bigclasszm."-".$smallclasszm.".htm'>".$smallclassname."</a>";
	}
}else{
	$station="<a href='".siteurl."'>网站首页</a> &gt; <a href='zs.php?id=".$id."'>".channelzs."</a> ";
	$station=$station." &gt; <a href='zs.php?id=".$id."&bigclass=".$bigclasszm."'>".$bigclassname."</a>";
	if ($smallclasszm<>''){
	$station=$station." &gt; <a href='zs.php?id=".$id."&bigclass=".$bigclasszm."&smallclass=".$smallclasszm."'>".$smallclassname."</a>";
	}
}
//$station=$station . " &gt; ".$cpmc;

$strout=str_replace("{#proname}",$cpmc,$strout) ;
$strout=str_replace("{#bigclass}",$bigclassname,$strout) ;
$strout=str_replace("{#smallclass}",$smallclassname,$strout) ;
$strout=str_replace("{#prouse}",cutstr($prouse,500),$strout) ;
$strout=str_replace("{#city}",$province.$city,$strout) ;
//cp		 
if(showdlinzs=="Yes"){
$rsn=query("select id from zzcms_dl where cpid='".$cpid."' and passed=1");
$rown=num_rows($rsn);
$liuyan="<tr>";
$liuyan.$liuyan="<td class=\"bgcolor1\" align=\"middle\">".channeldl."留言</td>";
$liuyan.$liuyan="<td bgcolor=\"#ffffff\"><span style=\"font-weight: bold\">".$rown."</span>条 </td>";
$liuyan.$liuyan="</tr>";
}else{
$liuyan="";
}
$strout=str_replace("{#message}",$liuyan,$strout) ;
$strout=str_replace("{#img}",$cpimg,$strout) ;
$strout=str_replace("{#company}",$comane,$strout) ;

if($flv<>''){
$showflv=$showflv .  "<div class='box' style='text-align:center'>";
if(substr($flv,-3)=="flv"){
$showflv=$showflv .  "<span id='container'></span>";
$showflv=$showflv .  "<script src='/js/swfobject.js' type='text/javascript'></script>";
$showflv=$showflv .  " <script type='text/javascript'>";
$showflv=$showflv .  "  var s1 = new SWFObject('/image/player.swf','ply','500','360','9','#FFFFFF');";
$showflv=$showflv .  "  s1.addParam('allowfullscreen','true');";
$showflv=$showflv .  "  s1.addParam('allowscriptaccess','always');";
if(substr($flv,0,4)=="http"){
$showflv=$showflv .  "s1.addParam('flashvars','file=".$flv."&autostart=false');";
}else{
$showflv=$showflv .  "s1.addParam('flashvars','file=/".$flv."&autostart=false');";
}
$showflv=$showflv .  "s1.write('container');";
$showflv=$showflv .  "</script>";

}else{
	if(substr($flv,0,4)=="http"){
	$cp=$cp .  "<embed src='".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='500' height='360'></embed>";		
	}else{
	$cp=$cp .  "<embed src='/".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='500' height='360'></embed>";
	}
}
$showflv=$showflv .  "</div> ";
}else{
$showflv="";
}
$strout=str_replace("{#flv}",$showflv,$strout) ;
$strout=str_replace("{#sm}",nl2br($sm),$strout) ;
$strout=str_replace("{#zc}",nl2br($zc),$strout);
$strout=str_replace("{#yq}",nl2br($yq),$strout);

//代理表单	
$strout=str_replace("{#proname}",$cpmc,$strout);
$strout=str_replace("{#cpid}",$cpid,$strout);
$strout=str_replace("{#fbr}",$fbr,$strout);
$strout=str_replace("{#bigclassid}",$bigclasszm,$strout);
$strout=str_replace("{#token}",$token,$strout);

$companyname="";
$somane=$rown="";
$phone=$rown="";
$email=$rown="";
if (isset($_COOKIE["UserName"])) {
if (trim($_COOKIE["UserName"])!=$editor){//产品发布人登录时不显示自己的联系方式在表单
$rsn=query("select * from zzcms_user where username='".trim($_COOKIE["UserName"])."'");
$rown=fetch_array($rsn);
$companyname=$rown["comane"];
$somane=$rown["somane"];
$phone=$rown["phone"];
$email=$rown["email"];
}
}
//访客地理位置
$cuestip=getip(); 
$cuest_city=getIPLoc_sina($cuestip); 
$cuest_city=str_replace('联通','',str_replace('网通','',str_replace('电信','',$cuest_city)));

$strout=str_replace("{textarea}","<textarea id=\"contents\" rows=\"6\" cols=\"30\" name=\"contents\" onfocus='check_contents()' onblur='check_contents()'>我对这个产品感兴趣，请与我联系。</textarea>",$strout) ;
$strout=str_replace("{#companyname}",$companyname,$strout) ;
$strout=str_replace("{#somane}",$somane,$strout) ;
$strout=str_replace("{#phone}",$phone,$strout);
$strout=str_replace("{#email}",$email,$strout);

$strout=str_replace("{#cuest_city}",$cuest_city,$strout);

$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#station}",$station,$strout);

for ($i=0; $i< count($shuxing_value);$i++){
$strout=str_replace("{#shuxing".$i."}",$shuxing_value[$i],$strout);
}

$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
echo  $strout;
}	
session_write_close();		  
?>