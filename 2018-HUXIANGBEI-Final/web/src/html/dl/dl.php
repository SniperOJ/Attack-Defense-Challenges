<?php
$t1 = microtime(true);
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subdl.php");
include("../label.php");
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}
if (isset($_GET["b"])){
$b=$_GET["b"];
}else{
$b="";
}
if ($b!=''){
$f="../html/".$siteskin."/dl/".$b."/".$page.".html";
}else{
$f="../html/".$siteskin."/dl/".$page.".html";
}
if (html_update_time!=0 && file_exists($f) && time()-filemtime($f)<3600*24*html_update_time) {
echo file_get_contents($f);//第三种方法,这种比include("$f")打开速度要快很多
}else{
$fp="../template/".$siteskin."/dl.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
if (isset($_GET["province"])){
$province=$_GET["province"];
}else{
$province="";
}

$page_size=strbetween($strout,"{#pagesize=","}");
if ($page_size<>''){
checkid($page_size);
}else{
$page_size=pagesize_qt;
}

$bigclassname="";
if ($b<>""){
$sql="select * from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$pagetitle=$province.$bigclassname.dllisttitle."-".sitename;
$pagekeyword=$province.$bigclassname.dllistkeyword."-".sitename;
$pagedescription=$province.$bigclassname.dllistdescription."-".sitename;

//if (isset($_COOKIE["UserName"])){//开启静态页时，登陆地址会固定生成MsgBox登陆，所以交到下载页判断是否登陆
$dl_download_url="form1.action='/dl/dl_download.php'";
$dl_print_url="form1.action='/dl/dl_print.php'";
$dl_sendmail_url="form1.action='/dl/dl_sendmail.php'";
$dl_sendsms_url="form1.action='/dl/dl_sendsms.php'";
$buttontype="submit";
//}else{
//$dl_download_url="MsgBox('用户登录','/user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',460,196,1)";
//$dl_print_url="MsgBox('用户登录','/user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',460,196,1)";
//$dl_sendmail_url="MsgBox('用户登录','/user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',460,196,1)";
//$dl_sendsms_url="MsgBox('用户登录','/user/login2.php?fromurl=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."',460,196,1)";
//$buttontype="button";
//}
$strout=str_replace("{#dl_download_url}",$dl_download_url,$strout) ;
$strout=str_replace("{#dl_print_url}",$dl_print_url,$strout) ;
$strout=str_replace("{#dl_sendmail_url}",$dl_sendmail_url,$strout) ;
$strout=str_replace("{#dl_sendsms_url}",$dl_sendsms_url,$strout) ;
$strout=str_replace("{#buttontype}",$buttontype,$strout) ;

if ($b<>"") {
	$sql="select count(*) as total from `zzcms_dl_".$b."` where passed<>0 ";
	$sql2='';
	if (liuyanysnum!=0){//最好是设成0，当数据量大时，查寻会变慢
	$liuyanysnum=liuyanysnum*3600*24;
	$sql2=$sql2. " and  not exists (select id from `zzcms_dl_".$b."` where savergroupid>1 and unix_timestamp()-unix_timestamp(sendtime)<$liuyanysnum) ";
	}
}else{
	$sql="select count(*) as total from zzcms_dl where passed<>0 ";
	$sql2='';
	if (liuyanysnum!=0){//最好是设成0，当数据量大时，查寻会变慢
	$liuyanysnum=liuyanysnum*3600*24;
	$sql2=$sql2. " and  not exists (select id from zzcms_dl where savergroupid>1 and unix_timestamp()-unix_timestamp(sendtime)<$liuyanysnum) ";
	}
}
if ($province<>""){
$sql2=$sql2." and province ='".$province."' ";
}

$strout=str_replace("{#sql}",$sql.$sql2,$strout) ;
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;
$totlepage=ceil($totlenum/$page_size);
if ($b<>"") {
$sql="select id,dlid,cp,dlsname,province,city,xiancheng,content,tel,sendtime,saver from `zzcms_dl_".$b."` where passed<>0 ";
}else{
$sql="select id,cp,dlsname,province,city,xiancheng,content,tel,sendtime,saver from zzcms_dl where passed<>0 ";
}
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
//echo $sql;
$dl=strbetween($strout,"{dl}","{/dl}");
$dllist=strbetween($strout,"{loop}","{/loop}");

if(!$totlenum){
$strout=str_replace("{dl}".$dl."{/dl}","暂无信息",$strout) ;
}else{
$i=0;
$dllist2='';
while($row= fetch_array($rs)){
if ($b<>''){
$dllist2 = $dllist2. str_replace("{#id}" ,$row["dlid"],$dllist) ;
}else{
$dllist2 = $dllist2. str_replace("{#id}" ,$row["id"],$dllist) ;
}
if ($i % 2==0) {
$dllist2=str_replace("{changebgcolor}" ,"class=bgcolor1",$dllist2) ;
}else{
$dllist2=str_replace("{changebgcolor}" ,"class=bgcolor2",$dllist2) ;
}

if ($b<>''){
$dllist2 = str_replace("{#cp}" ,"<a href='".getpageurl("dl",$row["dlid"])."'>".cutstr($row["cp"],8)."</a> ",$dllist2) ;
}else{
$dllist2 = str_replace("{#cp}" ,"<a href='".getpageurl("dl",$row["id"])."'>".cutstr($row["cp"],8)."</a> ",$dllist2) ;
}

if ($row["saver"]<>"") {
	$rsn=query("select comane,id from zzcms_user where username='".$row["saver"]."'");
	$r=num_rows($rsn);
	if ($r){
	$r=fetch_array($rsn);
	$gs="<a href='".getpageurl("zt",$r["id"])."'>".cutstr($r["comane"],6)."</a> ";
	}else{
	$gs="不存在该公司信息";
	}		
}else{
$gs="无意向公司";
}

if (isshowcontact=="Yes"){
$tel= $row["tel"];
}else{
$tel="<a style='color:red' href='".getpageurl("dl",$row["id"])."'>VIP点击可查看</a>";
}

$dllist2 = str_replace("{#gs}" ,$gs,$dllist2) ;
$dllist2 = str_replace("{#dls}" ,$row["dlsname"],$dllist2) ;
$dllist2 = str_replace("{#qy}" ,$row["province"]."&nbsp;".$row["city"]."&nbsp;".$row["xiancheng"],$dllist2) ;
$dllist2 = str_replace("{#tel}" ,$tel,$dllist2) ;
$dllist2 = str_replace("{#content}" ,cutstr($row["content"],16),$dllist2) ;
$dllist2 = str_replace("{#sendtime}" ,date("Y-m-d",strtotime($row["sendtime"])),$dllist2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$dllist."{/loop}",$dllist2,$strout) ;
$strout=str_replace("{#fenyei}",showpage2("dl"),$strout) ;//采用showpage3倒显分页，可解决只生成新页，老页信息不变，缺点是当无大类不用缓存时大页码打开时慢，而到后面的小页码反页快。
$strout=str_replace("{dl}","",$strout) ;
$strout=str_replace("{/dl}","",$strout) ;
}//end if(!$totlenum)

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","dl"),$strout) ;
$strout=str_replace("{#dlclass}",bigclass($b),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#pagesize=".$page_size."}",'',$strout);//去页码大小标签
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
if (strpos($strout,"{@")!==false || strpos($strout,"{#")!==false) $strout=showlabel($strout);//先查一下，如是要没有的就不用再调用showlabel;
echo  $strout;
if (html_update_time!=0 ){
	if ($b<>''){
		$fpath=zzcmsroot."html/".$siteskin."/dl/".$b."/".$page.".html";
		if (!file_exists(zzcmsroot."html/".$siteskin."/dl/".$b)) {
		mkdir(zzcmsroot."html/".$siteskin."/dl/".$b,0777, true);
		}
	}else{
		if (!file_exists(zzcmsroot."html/".$siteskin."/dl")) {
		mkdir(zzcmsroot."html/".$siteskin."/dl",0777, true);
		}
		$fpath=zzcmsroot."html/".$siteskin."/dl/".$page.".html";
	}
	$fp=@fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($strout));//写入文件
	fclose($fp);
}

}//end if(html_update_time!=0 && file_exists($f) && time()-filemtime($f)<3600*24*30)
$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒';
?>