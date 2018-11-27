<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subcompany.php");

$file="../template/".$siteskin."/company_search.htm";
$fp = fopen($file,'r');
$strout = fread($fp,filesize($file));
fclose($fp);

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_company",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_company"])){
	$page_size=$_COOKIE["page_size_company"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET['b'])){
$bNew=$_GET['b'];
setcookie("companyb",$bNew,time()+3600*24);
$b=$bNew;
}else{
	if (isset($_COOKIE['companyb'])){
	$b=$_COOKIE['companyb'];
	}else{
	$b="";
	}
}

if (isset($_GET['s'])){
$sNew=$_GET['s'];
setcookie("companys",$sNew,time()+3600*24);
$s=$sNew;
}else{
	if (isset($_COOKIE['companys'])){
	$s=$_COOKIE['companys'];
	}else{
	$s="";
	}
}

if (isset($_GET['province'])){
$provinceNew=$_GET['province'];
setcookie("companyprovince",$provinceNew,time()+3600*24);
$province=$provinceNew;
}else{
	if (isset($_COOKIE['companyprovince'])){
	$province=$_COOKIE['companyprovince'];
	}else{
	$province="";
	}
}

if (isset($_GET['p_id'])){
$p_idNew=$_GET['p_id'];
setcookie("companyp_id",$p_idNew,time()+3600*24);
$p_id=$p_idNew;
}else{
	if (isset($_COOKIE['companyp_id'])){
	$p_id=$_COOKIE['companyp_id'];
	}else{
	$p_id="";
	}
}

if (isset($_GET['city'])){
$cityNew=$_GET['city'];
setcookie("companycity",$cityNew,time()+3600*24);
$city=$cityNew;
}else{
	if (isset($_COOKIE['companycity'])){
	$city=$_COOKIE['companycity'];
	}else{
	$city="";
	}
}

if (isset($_GET['c_id'])){
$c_idNew=$_GET['c_id'];
setcookie("companyc_id",$c_idNew,time()+3600*24);
$c_id=$c_idNew;
}else{
	if (isset($_COOKIE['companyc_id'])){
	$c_id=$_COOKIE['companyc_id'];
	}else{
	$c_id="";
	}
}

if (isset($_GET['xiancheng'])){
$xianchengNew=$_GET['xiancheng'];
setcookie("companyxiancheng",$xianchengNew,time()+3600*24);
$xiancheng=$xianchengNew;
}else{
	if (isset($_COOKIE['companyxiancheng'])){
	$xiancheng=$_COOKIE['companyxiancheng'];
	}else{
	$xiancheng="";
	}
}

if (isset($_GET['delb'])){
setcookie("companyb","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
setcookie("companys","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delprovince'])){
setcookie("companyprovince","xxx",1);
setcookie("companycity","xxx",1);
setcookie("companyp_id","xxx",1);
setcookie("companyc_id","xxx",1);
setcookie("companyxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delcity'])){
setcookie("companycity","xxx",1);
setcookie("companyxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delxiancheng'])){
setcookie("companyxiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if ($b<>0){
$sql="select * from zzcms_userclass where classid='$b'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}else{
$bigclassname="";
}

if ($s<>0){
$sql="select * from zzcms_userclass where classid='$s'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$smallclassname=$row["classname"];
}
}else{
$smallclassname="";
}

	function formbigclass()
		{
		$str="";
        $sql = "select * from zzcms_userclass where parentid='0'";
        $rs=query($sql);
		$row=num_rows($rs);
		if (!$row){
		$str= "请先添加大类";
		}else{
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classid"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}
		return $str;
		}
		
		function formsmallclass($b){
		$str="";
        $sql="select * from zzcms_userclass where parentid='" .$b. "' order by xuhao asc";
        $rs=query($sql);
		$row=num_rows($rs);
		if ($row){
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?s=".$row["classid"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}	
		return $str;
		}
		
function formprovince(){
		$str="";
		global $citys;
		$city=explode("#",$citys);
		$c=count($city);//循环之前取值
	for ($i=0;$i<$c;$i++){ 
		$location_p=explode("*",$city[$i]);//取数组的第一个就是省份名，也就是*左边的
		$str=$str . "<a href=?province=".$location_p[0]."&p_id=".$i.">".$location_p[0]."</a>&nbsp;&nbsp;";
	}
	return $str;
	}	
		
	function formcity(){
	global $citys,$p_id;
	$str="";
	if ($p_id<>"") {
	$city=explode("#",$citys);
	$location_cs=explode("*",$city[$p_id]);//取指定省份下的
	$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
	$c=count($location_cs2);//循环之前取值
		for ($i=0;$i<$c;$i++){ 
		$location_cs3=explode(",",$location_cs2[$i]);//取指定省份下的
		$str=$str . "<a href=?city=".$location_cs3[0]."&c_id=".$i.">".$location_cs3[0]."</a>&nbsp;&nbsp;";
		}
	}else{
	$city="";
	}
	return $str;
}

function formxiancheng(){
	global $citys,$p_id,$c_id;
	$str="";
	if ($p_id<>"" && $c_id<>"") {
	$city=explode("#",$citys);
	$location_cs=explode("*",$city[$p_id]);//取指定省份下的
	$location_cs2=explode("|",$location_cs[1]);//要*右边的市和县
	$location_cs3=explode(",",$location_cs2[$c_id]);//取指定市和县下的
	$c=count($location_cs3);//循环之前取值
		for ($i=1;$i<$c;$i++){ //从1开始，0对应的是，前面的市名，市名不要，这里只显示县名。
		$str=$str . "<a href=?xiancheng=".$location_cs3[$i].">".$location_cs3[$i]."</a>&nbsp;&nbsp;";
		}
	}else{
	$xiancheng="";
	}
	return $str;
}

if ($b<>"" || $s<>"" || $province<>"" || $city<>"" || $xiancheng<>"" ) {
		$selected="<tr>";
		$selected=$selected."<td align='right'>已选条件：</td>";
		$selected=$selected."<td class='a_selected'>";
			if ($b<>"") {
			$selected=$selected."<a href='?delb=Yes' >".$bigclassname."×</a>&nbsp;";
			}
			
			if ($s<>""){
			$selected=$selected."<a href='?dels=Yes' >".$smallclassname."×</a>&nbsp;";
			}
		
			if ($province<>""){
			$selected=$selected."<a href='?delprovince=Yes'  >".$province."×</a>&nbsp;";
			}
		
			if ($city<>""){
			$selected=$selected."<a href='?delcity=Yes'>".$city."×</a>&nbsp;";
			}
			
			if ($xiancheng<>""){
			$selected=$selected."<a href='?delxiancheng=Yes' title='删除已选'>".$xiancheng."×</a>&nbsp;";
			}
		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}
		
$keyword = isset($_GET['keyword'])?trim($_GET['keyword']):"";

$pagetitle=$province.companylisttitle.$bigclassname.sitename;
$pagekeyword=$province.$bigclassname.companylistkeyword;
$pagedescription=$province.$bigclassname.companylistdescription;
if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}

$list=strbetween($strout,"{loop}","{/loop}");		
$sql="select count(*) as total from zzcms_user where  usersf='公司' and lockuser=0 and passed<>0  ";
$sql2='';
if ($keyword<>""){
$sql2=$sql2." and comane like '%".$keyword."%' ";
}
if ($province<>""){
$sql2=$sql2." and province='".$province."'";
}
if ($city<>""){
$sql2=$sql2." and city='".$city."'";
}
if ($xiancheng<>""){
$sql2=$sql2." and xiancheng='".$xiancheng."'";
}
if ($b<>"" && $b<>0) {
$sql2=$sql2." and bigclassid='".$b."' ";
}

if ($s<>"" && $s<>0) {
$sql2=$sql2." and smallclassid='".$s."' ";
}

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);
$sql="select * from zzcms_user where passed=1 and usersf='公司' and lockuser=0 ";
$sql=$sql.$sql2;
$sql=$sql." order by groupid desc,id desc limit $offset,$page_size";
//echo $sql;
$rs = query($sql); 
if(!$totlenum){
	$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
	$strout=str_replace("{#fenyei}","",$strout) ;
}else{
$list2="";
$i=0;
while($row= fetch_array($rs)){
if (sdomain=="Yes"){
$zturl="http://".$row["username"].".".substr(siteurl,strpos(siteurl,".")+1);
}else{
$zturl=getpageurl("zt",$row["id"]);
}

$rsn=query("select grouppic,groupname from zzcms_usergroup where groupid=".$row["groupid"]."");
$rown=fetch_array($rsn);
$usergrouppic=$rown["grouppic"];
$usergroupname=$rown["groupname"];

$usergroup="<img src='".$usergrouppic."' alt='".$usergroupname."'>";
if ($row["renzheng"]==1) {
$usergroup=$usergroup."<img src='/image/ico_renzheng.png' alt='认证会员'>";
}

$rsn=query("select xuhao,proname,id from zzcms_main where editor='".$row["username"]."' and passed=1 order by xuhao asc limit 0,3");
$rown=num_rows($rsn);
$cp="";
if ($rown){
	while($rown=fetch_array($rsn)){
	$cp=$cp."<a href='".getpageurl("zs",$rown["id"])."'>".cutstr($rown["proname"],8)."</a>&nbsp;&nbsp;";
       } 
}else{
$cp="暂无产品";
}

$list2 = $list2. str_replace("{#comane}" ,$row["comane"],$list) ;
$list2 =str_replace("{#zturl}" ,$zturl,$list2) ;
$list2 =str_replace("{#usergroup}" ,$usergroup,$list2) ;
$list2 =str_replace("{#address}" ,$row["address"],$list2) ;
$list2 =str_replace("{#phone}" ,$row["phone"],$list2) ;
$list2 =str_replace("{#cp}" ,$cp,$list2) ;
$list2 =str_replace("{#imgbig}" ,$row["img"],$list2) ;		
$list2 =str_replace("{#img}" ,getsmallimg($row["img"]),$list2) ;	
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("company"),$strout) ;
}
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","company"),$strout) ;
if ($b=="") {//当小类为空显示大类，否则只显小类
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
$strout=str_replace("{#formsmallclass}","",$strout);
}else{
$strout=str_replace("{#formbigclass}","",$strout);
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);
}
if ($province=="") {
$strout=str_replace("{#formprovince}",formprovince(),$strout);
}else{
$strout=str_replace("{#formprovince}","",$strout);
}
if ($city=="") {
$strout=str_replace("{#formcity}",formcity(),$strout);
}else{
$strout=str_replace("{#formcity}","",$strout);
}
$strout=str_replace("{#formxiancheng}",formxiancheng(),$strout);
$strout=str_replace("{#selected}",$selected,$strout);

$strout=str_replace("{#numperpage}",showselectpage("company",$page_size,$b,"",$page),$strout);
$strout=str_replace("{#form_keyword}",$keyword,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);
echo  $strout;
?>