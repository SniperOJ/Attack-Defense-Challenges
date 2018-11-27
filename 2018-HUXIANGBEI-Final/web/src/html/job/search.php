<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subjob.php");
include("../label.php");

$fp="../template/".$siteskin."/job_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_job",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_job"])){
	$page_size=$_COOKIE["page_size_job"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET['yiju'])){
$yiju=$_GET['yiju'];
}else{
$yiju="Pname";
}

if (isset($_GET['keyword'])){
$keywordNew=nostr(trim($_GET['keyword']));
setcookie("keyword",$keywordNew,time()+3600*24);
setcookie("b","xxx",1);
setcookie("s","xxx",1);
setcookie("province","xxx",1);
setcookie("city","xxx",1);
setcookie("xiancheng","xxx",1);
setcookie("p_id","xxx",1);
setcookie("c_id","xxx",1);
setcookie("sj","xxx",1);
echo "<script>location.href='search.php'</script>";
$keyword=$keywordNew;
}else{
	if (isset($_COOKIE['keyword'])){
	$keyword=trim($_COOKIE['keyword']);
	}else{
	$keyword="";
	}
}

if (isset($_GET['b'])){
$bNew=$_GET['b'];
setcookie("b",$bNew,time()+3600*24);
setcookie("s","xxx",1);
echo "<script>location.href='search.php'</script>";
$b=$bNew;
}else{
	if (isset($_COOKIE['b'])){
	$b=$_COOKIE['b'];
	}else{
	$b="";
	}
}

if (isset($_GET['s'])){
$sNew=$_GET['s'];
setcookie("s",$sNew,time()+3600*24);
$s=$sNew;
}else{
	if (isset($_COOKIE['s'])){
	$s=$_COOKIE['s'];
	}else{
	$s="";
	}
}
if (isset($_GET['province'])){
$provinceNew=$_GET['province'];
setcookie("province",$provinceNew,time()+3600*24);
$province=$provinceNew;
}else{
	if (isset($_COOKIE['province'])){
	$province=$_COOKIE['province'];
	}else{
	$province="";
	}
}

if (isset($_GET['p_id'])){
$p_idNew=$_GET['p_id'];
setcookie("p_id",$p_idNew,time()+3600*24);
$p_id=$p_idNew;
}else{
	if (isset($_COOKIE['p_id'])){
	$p_id=$_COOKIE['p_id'];
	}else{
	$p_id="";
	}
}

if (isset($_GET['city'])){
$cityNew=$_GET['city'];
setcookie("city",$cityNew,time()+3600*24);
$city=$cityNew;
}else{
	if (isset($_COOKIE['city'])){
	$city=$_COOKIE['city'];
	}else{
	$city="";
	}
}

if (isset($_GET['c_id'])){
$c_idNew=$_GET['c_id'];
setcookie("c_id",$c_idNew,time()+3600*24);
$c_id=$c_idNew;
}else{
	if (isset($_COOKIE['c_id'])){
	$c_id=$_COOKIE['c_id'];
	}else{
	$c_id="";
	}
}

if (isset($_GET['xiancheng'])){
$xianchengNew=$_GET['xiancheng'];
setcookie("xiancheng",$xianchengNew,time()+3600*24);
$xiancheng=$xianchengNew;
}else{
	if (isset($_COOKIE['xiancheng'])){
	$xiancheng=$_COOKIE['xiancheng'];
	}else{
	$xiancheng="";
	}
}

if (isset($_GET['sj'])){
$sjNew=$_GET['sj'];
setcookie("sj",$sjNew,time()+3600*24);
$sj=$sjNew;
}else{
	if (isset($_COOKIE['sj'])){
	$sj=$_COOKIE['sj'];
	}else{
	$sj="";
	}
}

if ($sj<>"") {
checkid($sj);
}

if (isset($_GET['delb'])){
setcookie("b","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['dels'])){
setcookie("s","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delprovince'])){
setcookie("province","xxx",1);
setcookie("city","xxx",1);
setcookie("p_id","xxx",1);
setcookie("c_id","xxx",1);
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delcity'])){
setcookie("city","xxx",1);
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delxiancheng'])){
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delsj'])){
setcookie("sj","xxx",1);
echo "<script>location.href='search.php'</script>";
}


$bigclassname='';
if ($b<>""){
$sql="select classname from zzcms_jobclass where classid='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}
}

$smallclassname='';
if ($s<>"") {
$sql="select classname from zzcms_jobclass where classid='".$s."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row){
	$smallclassname=$row["classname"];
	}
}

$pagetitle=joblisttitle;
$pagekeyword=joblistkeyword;
$pagedescription=joblistdescription;

$station=getstation($b,$bigclassname,$s,$smallclassname,"","","job");

if( isset($_GET["page"]) && $_GET["page"]!="") 
{
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}


		function formbigclass()
		{
		$str="";
        $sql = "select * from zzcms_jobclass where parentid='0'";
        $rs=query($sql);
		$row=num_rows($rs);
		if (!$row){
		$str= "请先添加类别名称。";
		}else{
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classid"].">".$row["classname"]."</a>&nbsp;&nbsp;";
			}
		}
		return $str;
		}
		
		function formsmallclass($b){
		$str="";
        $sql="select * from zzcms_jobclass where parentid='" .$b. "' order by xuhao asc";
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
		
		if ($b<>"" || $s<>"" || $province<>"" || $city<>"" || $xiancheng<>"" || $sj<>"") {
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
			
			if ($sj<>"") {
			$selected=$selected."<a href='?delsj=Yes' >".$sj."天内的×</a>&nbsp;";
			}

		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}

$list=strbetween($strout,"{loop}","{/loop}");

$sql="select count(*) as total from zzcms_job where passed<>0 ";
$sql2='';
switch ($yiju){
	case "Pname";
	$sql2=$sql2. " and jobname like '%".$keyword."%' ";//加括号,否则后面的条件无效
	break;
	case "Pcompany";
	$sql2=$sql2."and comane like '%".$keyword."%' " ; 
	break;
	}
if ($b<>""){
$sql2=$sql2. "and bigclassid='".$b."' ";
}
if ($s<>"") {
$sql2=$sql2." and smallclassid ='".$s."'  ";
}

if ($xiancheng<>"") {
$sql2=$sql2."and xiancheng like '%".$xiancheng."%' ";
}elseif ($city<>"") {
$sql2=$sql2."and city like '%".$city."%' ";
}elseif ($province<>"") {
$sql2=$sql2."and province like '%".$province."%' ";
}
if ($sj<>""){
$sql2=$sql2." and  timestampdiff(day,sendtime,now()) < ". $sj ." " ;
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_job where passed=1 ";	
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{

$list2='';
$i=0;
while($row= fetch_array($rs)){

$list2 = $list2. str_replace("{#province}",$row['province'],$list) ;
$list2 =str_replace("{#city}",cutstr($row["city"],8),$list2) ;
$list2 =str_replace("{#title}",cutstr($row["jobname"],8),$list2) ;
$list2 =str_replace("{#url}",getpageurl("job",$row['id']),$list2) ;
$list2 =str_replace("{#comane}",$row["comane"],$list2) ;
$list2 =str_replace("{#companyurl}",getpageurlzt($row['editor'],$row['userid']),$list2) ;
$list2 =str_replace("{#sendtime}",$row["sendtime"],$list2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("job"),$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",$station,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);

if ($b=="") {//当小类为空显示大类，否则只显小类
$strout=str_replace("{#formbigclass}",formbigclass(),$strout);
}else{
$strout=str_replace("{#formbigclass}","",$strout);
}
$strout=str_replace("{#formsmallclass}",formsmallclass($b),$strout);
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

if ($yiju=="Pname") {
$strout=str_replace("{#Pname}","checked",$strout);
$strout=str_replace("{#Pcompany}","",$strout);
}else{
$strout=str_replace("{#Pcompany}","checked",$strout);
$strout=str_replace("{#Pname}","",$strout);
}

$strout=str_replace("{#formxiancheng}",formxiancheng(),$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#formkeyword}",$keyword,$strout);

$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);

$strout=showlabel($strout);

echo  $strout;
?>