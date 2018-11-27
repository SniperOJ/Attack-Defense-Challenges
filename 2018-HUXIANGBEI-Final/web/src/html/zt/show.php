<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("../inc/fly.php");
include("../zx/subzx.php");
include("../zs/subzs.php");
include("top.php");
include("bottom.php");
include("left.php");
include("../label.php");//red2s模板中有固定标签{#showzx:加盟优势,,{#editor},2}，需要label.php文件解析
include("adv.php");
$fp="../skin/".$skin."/show.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$flyad="";
if ($showad_inzt=="yes") {
	if (flyadisopen=="Yes"){
	$flyad= showflyad('首页',"漂浮广告");
	}
	if (duilianadisopen=="Yes"){
	$flyad=$flyad. showduilianad('首页',"对联广告左侧","对联广告右侧");
	}
}
$linkliuyan=siteurl."/zt/show.php?id=".$id."#dl_liuyan";//转为PHP页，解决二级域名无法直接留言，验证码无法跨域
$zslist=strbetween($strout,"{zsloop}","{/zsloop}");
$rs=query("select * from zzcms_main where editor='$editor' and passed=1 order by xuhao desc limit 0,12");
$row=num_rows($rs);
if ($row){
$n=0;
$zslist2='';
while($row=fetch_array($rs)){
if (sdomain=="Yes"){
	if (whtml=="Yes"){ 
	$link="/sell/zsshow-".$row["id"].".htm";
	}else{
	$link="/zt/zsshow.php?cpid=".$row["id"];
	}
}else{
	if (whtml=="Yes"){ 
	$link=siteurl."/sell/zsshow-".$row["id"].".htm";
	}else{
	$link=siteurl."/zt/zsshow.php?cpid=".$row["id"];
	}
}	
$zslist2 = $zslist2. str_replace("{#link}",$link,$zslist) ;
$zslist2 =str_replace("{#img}",getsmallimg($row['img']),$zslist2) ;
$zslist2 =str_replace("{#imgbig}",isaddsiteurl($row["img"]),$zslist2) ;
$zslist2 =str_replace("{#proname}",cutstr($row["proname"],8),$zslist2) ;
$zslist2 =str_replace("{#city}",$row["province"].$row["city"],$zslist2) ;

$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($n=0; $n< count($shuxing_value);$n++){
	$zslist2=str_replace("{#shuxing".$n."}",$shuxing_value[$n],$zslist2);
	}

$prouse_long=strbetween($zslist2,"{#prouse:","}");
if ($prouse_long!=''){
$zslist2 =str_replace("{#prouse:".$prouse_long."}",cutstr($row['prouse'],$prouse_long),$zslist2) ;
}else{
$zslist2 =str_replace("{#prouse}",cutstr($row['prouse'],150),$zslist2) ;
}
	
$zslist2 =str_replace("{#editor}",$row['editor'],$zslist2) ;	
$zslist2 =str_replace("{#linkliuyan}",$linkliuyan,$zslist2) ;

$n=$n+1;
($n % 6==0)?$tr="<tr>":$tr="";
$zslist2 =str_replace("{tr}",$tr,$zslist2) ;
}
$strout=str_replace("{zsloop}".$zslist."{/zsloop}",$zslist2,$strout) ;
}else{
$strout=str_replace("{zsloop}".$zslist."{/zsloop}","暂无信息",$strout) ;
}

$licence=strbetween($strout,"{licence}","{/licence}");

$rs=query("select img,title,passed,editor from zzcms_licence where editor='" .$editor. "' and passed=1");
$row=num_rows($rs);
if ($row){
$n=0;
$licence2='';
while ($row=fetch_array($rs)){
$licence2 = $licence2. str_replace("{#img}",getsmallimg($row['img']),$licence) ;
$licence2 =str_replace("{#imgbig}",siteurl.$row['img'],$licence2) ;
$licence2 =str_replace("{#link}",siteurl.$row['img'],$licence2) ;
$licence2 =str_replace("{#title}",cutstr($row["title"],6),$licence2) ;

$n=$n+1;
($n % 6==0)?$tr="<tr>":$tr="";
$licence2 =str_replace("{tr}",$tr,$licence2) ;
}
$strout=str_replace("{licence}".$licence."{/licence}",$licence2,$strout) ;
}else{
$strout=str_replace("{licence}".$licence."{/licence}","暂无信息",$strout) ;
}

function dlxx($editor){
$sql="select count(*) as total from zzcms_dl where saver='".$editor."' and del=0";
$rs = query($sql); 
$row = fetch_array($rs);
$totlenum = $row['total'];
if ($totlenum){
$rs=query("select cp,id,cpid,dlsname,sendtime,city,looked from zzcms_dl where saver='".$editor."' and del=0 order by id desc limit 0,10");
$str="<div style='font-size:9pt'>产品留言</div><table width='100%' border='0' cellpadding='5' cellspacing='1' class='bgcolor3'>";
$str=$str. "<tr class='bgcolor2'> ";
$str=$str. "<td width='25%'>产品名称</td>";
$str=$str. "<td width='25%'>代理区域</td>";
$str=$str. "<td width='13%'>联系人</td>";
$str=$str. "<td width='17%'>联系方式</td>";
$str=$str. "<td width='20%'>留言时间</td>";
$str=$str. "</tr>";
while ($row=fetch_array($rs)){
$str=$str. "<tr class='bgcolor1'> ";
$str=$str. "<td>";

if (sdomain=="Yes"){
	if (whtml=="Yes"){ 
	$str=$str. "<a href='/sell/zsshow-".$row["cpid"].".htm'>";
	}else{
	$str=$str. "<a href='/zt/zsshow.php?cpid=".$row["cpid"]."'>";
	}
}else{
	if (whtml=="Yes"){ 
	$str=$str. "<a href='/sell/zsshow-".$row["cpid"].".htm'>";
	}else{
	$str=$str. "<a href='/zt/zsshow.php?cpid=".$row["cpid"]."'>";
	}
}	

$str=$str. cutstr($row["cp"],8);
$str=$str."</a>";

if ($row["looked"]==0){ 
$str=$str. "(尚未被查看)";
}
$str=$str. "</td>";
$str=$str. " <td>".$row["city"]."</td>";
$str=$str. " <td>".$row["dlsname"]."</td>";
$str=$str. " <td><a style='color:red' href='".siteurl.getpageurl("dl",$row["id"])."'>VIP点击可查看</a></td>";
$str=$str. " <td>".$row["sendtime"]."</td>";
$str=$str. "</tr>";
}

$str=$str. " </table>";
}else{
$str= "暂无信息";
}
return $str;
}

//guestbook
$guestbook=strbetween($strout,"{guestbook}","{/guestbook}");
$list=strbetween($guestbook,"{loop}","{/loop}");
$rs=query("select title,content,linkmen,phone,email,looked,sendtime from zzcms_guestbook where saver='".$editor."'and passed=1 order by id desc limit 0,10");
$row=num_rows($rs);
if ($row){
$list2='';
while ($row=fetch_array($rs)){
$list2 = $list2. str_replace("{#content}",cutstr($row["content"],8),$list) ;
	if ($row["looked"]==0){ 
	$list2 =str_replace("{#looked}","(尚未被查看)",$list2) ;
	}else{
	$list2 =str_replace("{#looked}","",$list2) ;
	}
$list2 =str_replace("{#linkman}",$row["linkmen"],$list2) ;
$list2 =str_replace("{#tel}",str_replace(substr($row['phone'],3,4),"****",$row['phone']),$list2) ;
$list2 =str_replace("{#email}",str_replace(substr($row['email'],3,4),"****",$row['email']),$list2) ;
$list2 =str_replace("{#sendtime}",$row['sendtime'],$list2) ;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{guestbook}","",$strout) ;
$strout=str_replace("{/guestbook}","",$strout) ;
}else{
$strout=str_replace("{guestbook}".$guestbook."{/guestbook}","暂无信息",$strout) ;
}

$gsjj="<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
$gsjj=$gsjj. "<tr>";
$gsjj=$gsjj. "<td style='font-size:14px;line-height:25px'>";
if($flv<>""){//可以只给VIP会员传视频的权限
	if(substr($flv,-3)=="flv"){
	$gsjj=$gsjj. "<span id='container' style='float:left;display:inline;margin-right:10px'></span>";
	$gsjj=$gsjj. "<script src='".siteurl."/js/swfobject.js' type='text/javascript'></script>";
	$gsjj=$gsjj. "<script type='text/javascript'>";
	$gsjj=$gsjj. "var s1 = new SWFObject('".siteurl."/image/player.swf','ply','300','260','9','#FFFFFF');";
	$gsjj=$gsjj. "s1.addParam('allowfullscreen','true');";
	$gsjj=$gsjj. "s1.addParam('allowscriptaccess','always');";
	$gsjj=$gsjj . "s1.addParam('flashvars','file=".$flv."&backcolor=&frontcolor=&image=&logo=".logourl."&autostart=true');";
	$gsjj=$gsjj. "s1.write('container');";
	$gsjj=$gsjj. "</script>";
	}elseif(substr($flv,-3)=="swf"){
	$gsjj=$gsjj. "<span style='float:left;display:inline;margin-right:10px'>";
	$gsjj=$gsjj. "<embed src='".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='300' height='260'></embed>";		
	$gsjj=$gsjj. "</span>";	
	}
}elseif($img<>""){
//$gsjj=$gsjj. "<img id='gsjjimg' src='".getsmallimg($img)."' onload='javascript:if(this.width>300) this.width=300;' align='left' >" ;
//用户可以从编缉器中传了	
}	

$gsjj=$gsjj.  $content;
//$gsjj=$gsjj.  nl2br($content);//不用编缉器时
$gsjj=$gsjj. "</td>";
$gsjj=$gsjj. "</tr>";
$gsjj=$gsjj. "</table>";

$lxfs="<div class='lxfsbg'>";
if ($showcontact=="yes"  || $_SESSION["dlliuyan"]==$editor) {
$lxfs=$lxfs."<ul>";
$lxfs=$lxfs."<li><b>".$comane."</b></li>";
$lxfs=$lxfs."<li>地址：".$address."</li>";
$lxfs=$lxfs."<li>电话：".$phone."</li>";
$lxfs=$lxfs."<li>传真：".$fox."</li>";
$lxfs=$lxfs."<li>网址：" ;
if(sdomain=="Yes"){
$lxfs=$lxfs. "<a href='http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."'>http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."</a>";
}else{
$lxfs=$lxfs. "<a href='".addhttp($homepage)."' target='_blank'>".$homepage."</a>";
}
$lxfs=$lxfs."</li>" ;						
$lxfs=$lxfs."<li>";
$lxfs=$lxfs."手机：".$mobile.$somane."&nbsp; ";
if($sex==1){ 
$lxfs=$lxfs."(先生)" ;
}elseif($sex==0){ 
$lxfs=$lxfs."(女士)" ;
}else{ 
$lxfs=$lxfs."" ;
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li>E-mail：" ;
if($email<>""){
	$lxfs=$lxfs.  str_replace("@","<img src='".siteurl."/image/em.gif'>",$email);
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li>QQ：" ;
if($qq<>""){
$lxfs=$lxfs. "  <a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$qq."&Site=".sitename."&Menu=yes><img border='0' src=http://wpa.qq.com/pa?p=1:".$qq.":10></a> ";
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li style='color:red'>联系我时，请说是在".sitename."上看到的，谢谢！</li>";
			  
$lxfs=$lxfs."</ul>";
}else{
$lxfs=$lxfs."<ul>";
$lxfs=$lxfs."<li><b>".$comane."</b></li>";
$lxfs=$lxfs."<li>地址：".$address."</li>";
$lxfs=$lxfs."<li>电话：<a href='$linkliuyan' style='color:#FF3300'>填写代理信息，联系方式自动显示。</a> </li>";
$lxfs=$lxfs."<li>传真：<a href='$linkliuyan' style='color:#FF3300'>填写代理信息，联系方式自动显示。</a>  </li>";
$lxfs=$lxfs."<li>网址：" ;
if(sdomain=="Yes"){
$lxfs=$lxfs. "<a href='http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."'>http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."</a>";
}else{
$lxfs=$lxfs. "<a href='".addhttp($homepage)."' target='_blank'>".$homepage."</a>";
}
$lxfs=$lxfs."</li>" ;						
$lxfs=$lxfs."<li>手机：<a href='$linkliuyan' style='color:#FF3300'>填写代理信息，联系方式自动显示。</a></li>";
$lxfs=$lxfs."<li>email：<a href='$linkliuyan' style='color:#FF3300'>填写代理信息，联系方式自动显示。</a> </li>";
$lxfs=$lxfs."<li>QQ：<a href='$linkliuyan' style='color:#FF3300'>填写代理信息，联系方式自动显示。</a> </li>";		  
$lxfs=$lxfs."</ul>";
}
$lxfs=$lxfs."</div>";

//dlform
if (isset($_COOKIE["UserName"])) {
$rsn=query("select * from zzcms_user where username='".trim($_COOKIE["UserName"])."'");
$rown=fetch_array($rsn);
$companyname=$rown["comane"];
$somane=$rown["somane"];
$phone=$rown["phone"];
$email=$rown["email"];
}else{
$companyname="";
$somane=$rown="";
$phone=$rown="";
$email=$rown="";
}
$strout=str_replace("{textarea}","<textarea id='contents' rows=6 cols=44 name=\"contents\" onfocus='check_contents()' onblur='check_contents()'></textarea>",$strout) ;
$strout=str_replace("{#companyname}",$companyname,$strout) ;
$strout=str_replace("{#somane}",$somane,$strout) ;
$strout=str_replace("{#phone}",$phone,$strout);
$strout=str_replace("{#email}",$email,$strout);
$strout=str_replace("{#editor}",$editor,$strout);
//zxzs

if ($showad_inzt=="yes"){	
$zxzs="<div class='titleA' style='margin-top:10px'>最新招商信息</div>";
$zxzs=$zxzs. "<div class='ztcontent' >";
$zxzs=$zxzs. "<div class='boxshipin' >";
$zxzs=$zxzs.showzs(12,8,'no','yes','no','sendtime','no','no','no','no','no');
$zxzs=$zxzs. "</div></div>";
$zxzs=$zxzs. "<div class='ztcontentbottom'></div>";			
}else{
$zxzs="";
}

$kefu="<SCRIPT type=text/javascript>kfguin='$qq';ws='".sitename."'; companyname='".$comane."客服'; welcomeword='您好,欢迎光临！<brT>请问,有什么可以帮到您的吗?'; type='1';</SCRIPT><SCRIPT src='".siteurl."/3/kefu/js/kf.js' type=text/javascript></SCRIPT>";

$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
if ($showcontact=="yes") {//从top.php设的值
$strout=str_replace("{#kefu}",$kefu,$strout);
}else{
$strout=str_replace("{#kefu}",'',$strout);
}
$strout=str_replace("{#comane}",$comane,$strout);
$strout=str_replace("{#companyshowtitle}",companyshowtitle,$strout);
$strout=str_replace("{#companyshowkeyword}",companyshowkeyword,$strout);
$strout=str_replace("{#companyshowdescription}",companyshowdescription,$strout);

$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#showflyad}",$flyad,$strout);
if (strpos($strout,"{#dlly}")!==false) {
$strout=str_replace("{#dlly}",dlxx($editor),$strout);
}
$strout=str_replace("{#gsjj}",$gsjj,$strout);
$strout=str_replace("{#lxfs}",$lxfs,$strout);
$strout=str_replace("{#zxzs}",$zxzs,$strout);
$strout=str_replace("{#editor}",$editor,$strout);
$strout=str_replace("{#baidu_map}",$baidu_map,$strout);
$strout=str_replace("{#jdimg2}",adv($editor,"焦点图片广告"),$strout);
$strout=str_replace("{#phone}",$phone,$strout);
$strout=str_replace("{#mobile}",$mobile,$strout);
$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
$strout=showlabel($strout);
echo  $strout;
	
session_write_close();	  
?>