<?php
//echo $_SERVER['REQUEST_URI'];
if (isset($_REQUEST["editor"])<>"") {
$editor=$_REQUEST["editor"];
}else{
$editor='';
}

if (isset($_REQUEST["id"])) {
$id=$_REQUEST["id"];
checkid($id);
}else{
$id=0;
}

$editor=substr($_SERVER['HTTP_HOST'],0,strpos($_SERVER['HTTP_HOST'],'.'));//从二级域名中获取用户名
$sql="select * from zzcms_userdomain where domain='".$_SERVER['HTTP_HOST']."' and passed=1 and del=0";//从顶级级域名中获取用户名
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
	$row=fetch_array($rs);
	$editor=$row["username"];
}

$channel=strtolower($_SERVER['REQUEST_URI']);
//echo $channel;
if($id<>0){//ID放前面，EDITOR放后面
$sql="select * from zzcms_user where id='$id'";
}elseif ($editor<>"" && $editor<>"www" && $editor<>"demo" && $domain<>str_replace("http://","",siteurl)){//针对用二级域名的情况
$sql="select * from zzcms_user where username='$editor'";
}elseif(isset($editorinzsshow)) {
$sql="select * from zzcms_user where username='".$editorinzsshow."'";	//当两都为空时从zsshow接收值
}else{
showmsg ("参数不足!");
}
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
	showmsg ("不存在该用户信息!",siteurl);
}else{
	$row=fetch_array($rs);
	if ($row["lockuser"]==1){
	showmsg ("用户被锁定!展厅不于显示",siteurl);
	}
	$id=$row["id"];
	$editor=$row["username"];
	$somane=$row["somane"];
	$phone=$row["phone"];
	$mobile=$row["mobile"];
	$fox=$row["fox"];
	$qq=$row["qq"];
	$email=$row["email"];
	$sex=$row["sex"];
	$address=$row["address"];
	$homepage=$row["homepage"];
	$comane=$row["comane"];
	$renzheng=$row["renzheng"];
	$flv=$row["flv"];
	$img=$row["img"];
	$content=$row["content"];
	$groupid=$row["groupid"];
}	
$rs=query("select skin,skin_mobile,tongji,baidu_map from zzcms_usersetting where username='".$editor."'");
$row=num_rows($rs);
if ($row){
$row=fetch_array($rs);
$skin=$row["skin"];
$skin_mobile=$row["skin_mobile"];
$tongji=$row["tongji"];
$baidu_map=$row["baidu_map"];
}else{
$skin="blue1";
$tongji='';
$baidu_map='http://j.map.baidu.com/dYCQy';
}

//php判断客户端是否为手机,这暂不用，用JS判断的  
$agent = $_SERVER['HTTP_USER_AGENT']; 
if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")) {
$skin="mobile/".$skin_mobile;
}

if (isset($_REQUEST["skin"])){$skin=$_REQUEST["skin"];}//演示模板用
//showusergroup
$rs=query("select groupname,grouppic,groupid,config from zzcms_usergroup where groupid=$groupid");
$row=fetch_array($rs);
$showcontact=str_is_inarr($row["config"],'showcontact');
$showad_inzt=str_is_inarr($row["config"],'showad_inzt');//用于判断是否在展厅内显广告

	if($row["groupid"]>1 ){
	$showusergroup="<img src='".siteurl."/image/cxqy.png'/>";
	$rsviptime=query("select startdate from zzcms_user where username='".$editor."'");
	$rown=fetch_array($rsviptime);
	$startdate=$rown['startdate'];
	$showusergroup=$showusergroup . "<img src='".siteurl."/image/viptime/".(date('Y')-date('Y',strtotime($startdate))+1).".png'/>";
	}else{
	$showusergroup="<img src='".siteurl."/".$row["grouppic"]."'/>";
	$showusergroup=$showusergroup."&nbsp;".$row["groupname"];
	}
	if($renzheng==1){
	$showusergroup=$showusergroup."<img src='".siteurl."/image/ico_renzheng.png' alt='认证会员'>";
	}


//showbanner
$rs=query("select * from zzcms_usersetting where username='".$editor."'");
$row=num_rows($rs);
if(!$row){
query("INSERT INTO zzcms_usersetting (username,skin,swf,daohang)VALUES('".$editor."','red2','6.swf','网站首页, 招商信息, 公司简介, 资质证书, 联系方式, 在线留言')");
$showbanner="用户配置表中无此用户信息，已自动修复，刷新本页后，可正常显示";
}else{
$row=fetch_array($rs);
if($row["bannerbg"]<>"" ){
$showbanner="<div id='Layer1' style='position:absolute; width:100%; height:".$row["bannerheight"]."px; z-index:1'>";
	if (substr($skin,0,6)!="mobile"){
	$showbanner=$showbanner."<embed src='".siteurl."/flash/".$row["swf"]."' width='100%' height='".$row["bannerheight"]."'; quality='high' 		pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='transparent'></embed>";
	}
}else{
$showbanner="<div id='Layer1' style='position:absolute; width:100%; height:110px; z-index:1'>";
	if (substr($skin,0,6)!="mobile"){
	$showbanner=$showbanner."<embed src='".siteurl."/flash/".$row["swf"]."' width='100%' height='110'; quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' wmode='transparent'></embed>";
	}
}
	$showbanner=$showbanner."</div>";
	if($row["bannerbg"]<>"" ){
	$showbanner=$showbanner."<div class='banner' style='background:url(".siteurl.$row["bannerbg"].") repeat 0 0;color:".$row["comanecolor"].";text-align:".$row["comanestyle"].";height:".$row["bannerheight"]."px'>";
	}else{
	$showbanner=$showbanner."<div class='banner' style='color:".$row["comanecolor"].";text-align:".$row["comanestyle"]."'>";
	}
	if($row["comanestyle"]<>"no" ){
		if($comane<>"" ){
		$showbanner=$showbanner. $comane;
		}else{
		$showbanner=$showbanner."暂无公司名称";
		}
	}
	$showbanner=$showbanner."</div> ";
}
//showdaohang

function ztdaohangurl($daohangname,$ztdirname,$ztfilename){
global $editor,$id;
$str='';
if(whtml=="Yes" ){
	if (sdomain=="Yes"){//开启二级域名后，ID值由二级域名中的editor中能获取到
	$str=$str."<a href='".show2url($editor)."/".$ztdirname."' >$daohangname</a>";
	}else{
	$str=$str."<a href='".siteurl."/".$ztdirname."/".$ztfilename."-".$id.".htm' >$daohangname</a>";
	}	
}else{
	if (sdomain=="Yes"){//开启二级域名后，ID值由二级域名中的editor中能获取到
	$str=$str."<a href='".show2url($editor)."/zt/".$ztfilename.".php'>$daohangname</a>";
	}else{
	$str=$str."<a href='".siteurl."/zt/".$ztfilename.".php?id=".$id."'>$daohangname</a>";
	}
}
return $str;
}

$rs=query("select * from zzcms_usersetting where username='".$editor."'");
$row=num_rows($rs);
if(!$row ){
$showdaohang="用户配置表中无此用户信息";
}else{
$row=fetch_array($rs);
$showdaohang="<ul>";
if(strpos($row["daohang"],"网站首页")!==false ){
if(strpos($channel,"zt/show")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	if(sdomain=="Yes" ){
	$showdaohang=$showdaohang."<a href='".getpageurlzt($editor,$id)."'>展厅首页</a>";
	}else{
	$showdaohang=$showdaohang."<a href='".siteurl.getpageurl("zt",$id)."'>展厅首页</a>";
	}
	$showdaohang=$showdaohang."</li>";
}

if(strpos($row["daohang"],"招商信息")!==false){
	if(strpos($channel,"zt/zs")!==false||strpos($channel,"sell")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl(channelzs."信息","sell","zs");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"品牌信息")!==false ){
	if(strpos($channel,"zt/pp")!==false||strpos($channel,"brand")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("品牌信息","brand","pp");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"公司简介")!==false ){
if(strpos($channel,"companyshow")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("公司简介","introduce","companyshow");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"公司新闻")!==false ){
if(strpos($channel,"news")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("公司新闻","news","news");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"招聘信息")!==false ){
if(strpos($channel,"job")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("招聘信息","jobs","job");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"资质证书")!==false ){
if(strpos($channel,"licence")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("资质证书","licence","licence");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"联系方式")!==false ){
if(strpos($channel,"contact")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("联系方式","contact","contact");
	$showdaohang=$showdaohang."</li>";
}
if(strpos($row["daohang"],"在线留言")!==false ){
if(strpos($channel,"liuyan")!==false){$showdaohang=$showdaohang."<li class='current'>";}else{$showdaohang=$showdaohang."<li>";}
	$showdaohang=$showdaohang.ztdaohangurl("在线留言","guestbook","liuyan");
	$showdaohang=$showdaohang."</li>";
}
$showdaohang=$showdaohang."</ul>";
}

$fp="../skin/".$skin."/top.htm";
if (file_exists($fp)==false){
WriteErrMsg('../skin/'.$skin.'/top.htm 模板文件不存在');
}else{
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$sitetop=str_replace("{#siteskin}",siteskin,$strout) ;
$sitetop=str_replace("{#sitename}",sitename,$sitetop) ;
$sitetop=str_replace("{#kftel}",kftel,$sitetop);
$sitetop=str_replace("{#siteurl}",siteurl,$sitetop);
$sitetop=str_replace("{#logourl}",logourl,$sitetop);
$sitetop=str_replace("{#comane}",$comane,$sitetop);
$sitetop=str_replace("{#showusergroup}",$showusergroup,$sitetop);
$sitetop=str_replace("{#showbanner}",$showbanner,$sitetop);
$sitetop=str_replace("{#showdaohang}",$showdaohang,$sitetop);
}
?>