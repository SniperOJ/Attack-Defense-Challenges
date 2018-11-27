<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("subbaojia.php");
include("../label.php");
$fp="../template/".$siteskin."/baojia_search.htm";
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
if (isset($_GET["page_size"])){
$page_size=$_GET["page_size"];
checkid($page_size);
setcookie("page_size_baojia",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_baojia"])){
	$page_size=$_COOKIE["page_size_baojia"];
	}else{
	$page_size=pagesize_qt;
	}
}

if (isset($_GET['keyword'])){
$keywordNew=trim($_GET['keyword']);
setcookie("keyword",$keywordNew,time()+3600*24);
setcookie("b","xxx",1);
setcookie("s","xxx",1);
setcookie("province","xxx",1);
setcookie("city","xxx",1);
setcookie("xiancheng","xxx",1);
setcookie("p_id","xxx",1);
setcookie("c_id","xxx",1);
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

if (isset($_GET['province'])){
$provinceNew=$_GET['province'];
setcookie("province",$provinceNew,time()+3600*24);
$province=$provinceNew;
	if  (@$_COOKIE['city']<>""){
	setcookie("city","xxx",1);
	setcookie("c_id","xxx",1);
	setcookie("xiancheng","xxx",1);
	echo "<script>location.href='search.php'</script>";
	}
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

if (isset($_GET['delb'])){
setcookie("b","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if (isset($_GET['delprovince'])){
setcookie("province","xxx",1);
setcookie("p_id","xxx",1);
setcookie("city","xxx",1);
setcookie("c_id","xxx",1);
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delcity'])){
setcookie("city","xxx",1);
setcookie("c_id","xxx",1);
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}
if (isset($_GET['delxiancheng'])){
setcookie("xiancheng","xxx",1);
echo "<script>location.href='search.php'</script>";
}

if ($b<>""){
$sql="select * from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
	if ($row){
	$bigclassname=$row["classname"];
	}
}else{
$bigclassname="";
}

$pagetitle=$province.$bigclassname.baojialisttitle."-".sitename;
$pagekeyword=$province.$bigclassname.baojialisttitle."-".sitename;
$pagedescription=$province.$bigclassname.baojialistdescription."-".sitename;

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
	checkid($page);
}else{
    $page=1;
}
function formbigclass(){
		$str="";
        $sql = "select * from zzcms_zsclass where parentid='A'";
        $rs=query($sql);
		$row=num_rows($rs);
		if (!$row){
		$str= "请先添加类别名称。";
		}else{
			while($row=fetch_array($rs)){
			$str=$str. "<a href=?b=".$row["classzm"].">".$row["classname"]."</a>&nbsp;&nbsp;";
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

	if ($b<>"" || $province<>"" || $city<>"" || $xiancheng<>"") {
		$selected="<tr>";
		$selected=$selected."<td align='right'>已选条件：</td>";
		$selected=$selected."<td class='a_selected'>";
			if ($b<>"") {
			$selected=$selected."<a href='?delb=Yes' title='删除已选'>".$bigclassname."×</a>&nbsp;";
			}
			if ($province<>""){
			$selected=$selected."<a href='?delprovince=Yes' title='删除已选'>".$province."×</a>&nbsp;";
			}
			if ($city<>""){
			$selected=$selected."<a href='?delcity=Yes' title='删除已选'>".$city."×</a>&nbsp;";
			}
			if ($xiancheng<>""){
			$selected=$selected."<a href='?delxiancheng=Yes' title='删除已选'>".$xiancheng."×</a>&nbsp;";
			}
		$selected=$selected."</td>";
		$selected=$selected."</tr>";
		}else{
		$selected="";
		}
		

$showselectpage="<select name='menu1' onchange=MM_jumpMenu('parent',this,0) class='biaodan' style='width:100px'>" ;
$cs="?b=".$b."&province=".$province."&city=".$city."&keyword=".$keyword."";
if ($page_size=="20"){
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=2' selected >20条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=2' >20条/页</option>";
}
if ($page_size=="50"){
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=50' selected >50条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=50' >50条/页</option>";
}
if ($page_size=="100"){
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=100' selected >100条/页</option>";
}else{
$showselectpage=$showselectpage . "<option value='".$cs."&page_size=100' >100条/页</option>";
}
$showselectpage=$showselectpage . "</select>";
$strout=str_replace("{#showselectpage}",$showselectpage,$strout) ;

$sql="select count(*) as total from zzcms_baojia where passed<>0 ";

$sql2='';
if ($keyword<>"" && $keyword<>"输入".channeldl."产品名称") {
$sql2=$sql2." and cp like '%".$keyword."%' ";
}
if ($province<>"") {
$sql2=$sql2." and province = '".$province."' ";
}
if ($city<>"" ){
$sql2=$sql2." and city ='".$city."' ";
}
if ($xiancheng<>"" ){
$sql2=$sql2." and xiancheng like '".$xiancheng."%' ";
}
//echo $sql;
$dl=strbetween($strout,"{baojia}","{/baojia}");
$dllist=strbetween($strout,"{loop}","{/loop}");

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql="select id,cp,truename,province,city,xiancheng,price,danwei,tel,sendtime from zzcms_baojia where passed=1 ";

$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
//echo $sql;
$rs = query($sql); 
if(!$totlenum){
$strout=str_replace("{baojia}".$dl."{/baojia}","暂无信息",$strout) ;
}else{
$i=0;
$dllist2='';
while($row= fetch_array($rs)){

$dllist2 = $dllist2. str_replace("{#id}" ,$row["id"],$dllist) ;

if ($i % 2==0) {
$dllist2=str_replace("{changebgcolor}" ,"class=bgcolor1",$dllist2) ;
}else{
$dllist2=str_replace("{changebgcolor}" ,"class=bgcolor2",$dllist2) ;
}

$dllist2 = str_replace("{#cp}" ,"<a href='".getpageurl("baojia",$row["id"])."'>".cutstr($row["cp"],8)."</a> ",$dllist2) ;

$dllist2 = str_replace("{#name}" ,$row["truename"],$dllist2) ;
$dllist2 = str_replace("{#province}" ,$row["province"],$dllist2) ;
$dllist2 = str_replace("{#city}" ,$row["city"],$dllist2) ;
$dllist2 = str_replace("{#xiancheng}" ,$row["xiancheng"],$dllist2) ;
$dllist2 = str_replace("{#tel}" ,$row["tel"],$dllist2) ;
$dllist2 = str_replace("{#price}" ,$row["price"],$dllist2) ;
$dllist2 = str_replace("{#danwei}" ,$row["danwei"],$dllist2) ;
$dllist2 = str_replace("{#sendtime}" ,date("Y-m-d",strtotime($row["sendtime"])),$dllist2) ;
$i=$i+1;
}
$strout=str_replace("{loop}".$dllist."{/loop}",$dllist2,$strout) ;
$strout=str_replace("{#fenyei}",showpage1("dl"),$strout) ;
$strout=str_replace("{baojia}","",$strout) ;
$strout=str_replace("{/baojia}","",$strout) ;
}

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#station}",getstation($b,$bigclassname,0,"","","","baojia"),$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout) ;
$strout=str_replace("{#pagekeywords}",$pagekeyword,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);

$strout=str_replace("{#formbigclass}",formbigclass(),$strout);

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
$strout=str_replace("{#formkeyword}",$keyword,$strout);
$strout=str_replace("{#selected}",$selected,$strout);
$strout=str_replace("{#dllist}",$dllist,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
?>