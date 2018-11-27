<?php
function showcookieszs($cs){
$str="";
$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
$column=isset($cs[0])?$cs[0]:3;
$imgwidth=isset($cs[1])?$cs[1]:80;
$imgheight=isset($cs[2])?$cs[2]:80;
$title_num=isset($cs[3])?$cs[3]:6;
if (!isset($_COOKIE["zzcmscpid"])){
$str="暂无记录";
}else{
$cpid=$_COOKIE["zzcmscpid"];
	if (strpos($cpid,",")>0){
		$cpid=str_replace(" ","",$cpid);
		$cpid=str_replace("deleted","",$cpid);//cookie会出现deleted的情况
		$sql="select id,proname,img from zzcms_main where id in (".$cpid.")";
	}else{
	checkid($cpid);
	$sql="select id,proname,img from zzcms_main where id='$cpid' ";
	}
$n=1;
$str="<table width=100% border=0 cellspacing=0 cellpadding=5><tr>";	
$rs=query($sql);
while($row=fetch_array($rs)){
$str=$str. "<td align='center'>";
$str=$str. "<table  border='0' cellspacing='1' cellpadding='1' class='bgcolor2'>";
$str=$str. "<tr><td bgcolor='#FFFFFF' align='center' width='$imgwidth' height='$imgheight'>"  ;
$str=$str. "<a href='".getpageurl("zs",$row["id"])."' target='_blank'>";
$str=$str. "<img src=".getsmallimg($row["img"])." border='0' onload='resizeimg(".$imgwidth.",".$imgheight.",this)' alt='".$row["proname"]."'>";
$str=$str. "</a></td></tr>";
$str=$str. "<tr>";
$str=$str. "<td title='".$row["proname"]."'>".cutstr($row["proname"],$title_num)."</td>";
$str=$str. "<tr/>";
$str=$str. "</table>";
$str=$str. "</td>";
if ($n % $column==0 ){
$str=$str. "</tr>";
}
$n=$n+1;
}
$str=$str. "</table>";
$str=$str. "<div style='text-align:center;font-weight:bold'><a href='/zs/zs_list.php?action=ClearCookies'>清空查看记录</a></div>";
}
return $str;
}

function bigclass($b,$url=1){
$str="";
$n=1;
$sql="select classname,classid,classzm from zzcms_zsclass where parentid='A' order by xuhao";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str="暂无分类";
}else{
	while ($row=fetch_array($rs)){
	if($row['classzm']==$b){$str=$str."<li class='current'>";}else{$str=$str."<li>";}
	if ($url==2){
	$str=$str."<a href='".getpageurl2("zs",$row["classzm"],"")."'>".$row["classname"]."</a>";
	}else{
	$str=$str."<a href='".getpageurlzs("zsclass",$row["classzm"])."'>".$row["classname"]."</a>";
	}
	$str=$str."</li>\n";
	$n=$n+1;		
	}
}
return $str;
}

function showsx($sxid){
$str="";
$n=1;
$rs = query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
$row= num_rows($rs);
if (!$row){
$str="";//为空时不要输出内容
}else{
	while ($row=fetch_array($rs)){
	if($row['bigclassid']==$sxid){$str=$str."<li class='current'>";}else{$str=$str."<li>";}
	
	if (whtml=="Yes") {
	$str=$str."<a href='/zs/sx-".$row["bigclassid"].".htm'>".$row["bigclassname"]."</a>";
	}else{
	$str=$str."<a href='/zs/zs_list.php?sx=".$row["bigclassid"]."'>".$row["bigclassname"]."</a>";
	}
	
	$str=$str."</li>\n";
	$n=$n+1;		
	}
}
return $str;
}


function showzssmallclass($b,$s,$column,$num){
$str="";
$n=1;
if ($num<>""){
$sql="select classname,classid,classzm from zzcms_zsclass where parentid='". $b ."' order by xuhao limit 0,$num";
}else{
$sql="select classname,classid,classzm from zzcms_zsclass where parentid='". $b ."' order by xuhao";
}
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str="暂无分类";
}else{
while ($row=fetch_array($rs)){
	$str=$str."<li>";
	if($row['classzm']==$s){
	$str=$str. "<a href='".getpageurl2("zs",$b,$row["classzm"])."' class='current'>";	
	}else{
	$str=$str. "<a href='".getpageurl2("zs",$b,$row["classzm"])."'>";
	}
	$str=$str.$row["classname"]."</a>";
	$str=$str."</li>";
$n=$n+1;		
}
if ($num<>""){$str=$str. "<li><a href='".getpageurl2("zs",$b,"")."'>更多...</a></li>";}
}
return $str;
}

function showzsforsearch($num,$strnum,$order,$classname,$showtime,$keyword){
$n=1;
$str="";
	$sql="select id,proname,sendtime,passed,elite,hit,city,comane,userid from zzcms_main where passed=1 ";
	if ($classname<>"") {
	$sql=$sql. "and bigclasszm='$classname' ";
	}
		
	if ($keyword<>"") {
	$sql=$sql. "and proname like '%".$keyword."%' ";
	}
		
	switch ($order){
	case "id";
	$sql=$sql."order by id desc ";
	break;
	case "sendtime" ;
	$sql=$sql."order by sendtime desc ";
	break;
	case "hit" ;
	$sql=$sql."order by hit desc ";
	break;
	}
	$sql=$sql." limit 0,$num";

$rs=query($sql);
$row=num_rows($rs);
if ($row){				 	 
$str="<ul>";
while ($row=fetch_array($rs)){
$str=$str."<li onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\">";
if ($showtime==true) {
$str=$str."<span title=更新时间>".date("Y-m-d",strtotime($row["sendtime"]))."</span>";
}
if ($n<=3 ){
$str=$str."<font class='xuhao1'>".addzero($n)."</font>&nbsp;";
}else{
$str=$str."<font class='xuhao2'>".addzero($n)."</font>&nbsp;";
}
$str=$str."<a href='".getpageurl("zs",$row["id"])."' target='_blank' title='".$row["proname"]."'>".cutstr($row["proname"],$strnum)."</a>";
$str=$str."</li>";
$str=$str."<li id=zsLayer$n style='display:none;background:url(/image/k.gif) no-repeat 0px 0px;height:50px;padding:5px' onMouseOver=\"showfilter2(zsLayer$n)\" onMouseOut=\"showfilter2(zsLayer$n)\">".cutstr($row["comane"],10)."<br><a href='".getpageurl("zt",$row["userid"])."' target='_blank'><b>了解公司详请</b></a></li>";		
$n++;
}        
		 
$str=$str. "</ul>";
}else{
$str=$str. "暂无信息";
}
return $str;
}

function showzsorder($classid,$sj,$num,$strnum,$keyword){
$n=1;
$str="";
$sql="select cpid from zzcms_dl where passed=1 and cpid<>0 ";
if ($classid<>"") {
$sql=$sql. " and classzm='$classid' ";
}

if ($sj<>"") {
checkid($sj);
$sql=$sql. " and unix_timestamp()-unix_timestamp(sendtime) <".$sj." ";
}

if ($keyword<>false) {
$sql=$sql. "and cp like '%".$keyword."%' ";
}

$sql=$sql. "group by cpid order by count(*) desc";
$sql=$sql." limit 0,$num";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str= "暂无信息";
}else{
while ($row=fetch_array($rs)){
//if( $n<>1) {
//$str=$str. "<div class='boxxian'></div>"
//}
$str=$str. "<div>";
	$sqln="select proname,id,img,prouse from zzcms_main where id=".$row["cpid"]." ";
	$rsn=query($sqln);
	$r=num_rows($rsn);
	if ($r){
	$r=fetch_array($rsn);
	$str=$str. "<ul>";
	$str=$str. "<li onMouseOver=\"showfilter2(zs2Layer$n)\" onMouseOut=\"showfilter2(zs2Layer$n)\">";
	if ($n<=3 ){
	$str=$str."<font class='xuhao1'>".addzero($n)."</font>&nbsp;";
	}else{
	$str=$str."<font class='xuhao2'>".addzero($n)."</font>&nbsp;";
	}
	$str=$str. "<a href='".getpageurl("zs",$r['id'])."' target='_blank'>".cutstr($r['proname'],$strnum)."</a>";
	$str=$str. "</li>";
	$str=$str. "<li id=zs2Layer$n style='display:none;height:120px' onMouseOver=\"showfilter2(zs2Layer$n)\" onMouseOut=\"showfilter2(zs2Layer$n)\">";
	$str=$str. "<img src=".getsmallimg($r['img']).">";
	$str=$str. "</li>";
	$str=$str. "</ul>";	
	}else{
	$str=$str. "无该产品信息";
	}

$str=$str."</div>";	
$n++;
}
}
return $str;
}

function showzs($cs){
$n=1;
$str="";
$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
$num=isset($cs[0])?$cs[0]:10;checkid($num);
$strnum=isset($cs[1])?$cs[1]:10;checkid($strnum);
$time=isset($cs[2])?$cs[2]:'no';
$img=isset($cs[3])?$cs[3]:'no';
$xuhao=isset($cs[4])?$cs[4]:'no';
$order=isset($cs[5])?$cs[5]:'id';
$b=isset($cs[6])?$cs[6]:'no';
$s=isset($cs[7])?$cs[7]:'no';
$editor=isset($cs[8])?$cs[8]:'no';
$keyword=isset($cs[9])?$cs[9]:'no';
$cpid=isset($cs[10])?$cs[10]:'no';
//checkid($cpid);//非用户输入值，可以用不判断
	$sql="select id,proname,img,sendtime,passed,elite,hit,city,comane,userid from zzcms_main where passed=1 ";
	if ($b!='no') {$sql=$sql. "and bigclasszm='$b' ";}
	if ($s!='no') {$sql=$sql. "and bigclasszm='$s' ";}
	if ($keyword!='no') {$sql=$sql. " and proname like '%".$keyword."%' ";}
	if ($cpid!='no') {$sql=$sql. " and id<>$cpid ";}
	if ($editor!='no') {$sql=$sql. " and editor ='".$editor."' ";}	
	switch ($order){
	case "id";
	$sql=$sql."order by id desc ";
	break;
	case "sendtime" ;
	$sql=$sql."order by sendtime desc ";
	break;
	case "hit" ;
	$sql=$sql."order by hit desc ";
	break;
	}
	$sql=$sql." limit 0,$num";
//echo $sql."<br>";
$rs=query($sql);
$row=num_rows($rs);
if ($row){				 	 
$str="<ul>";
while ($row=fetch_array($rs)){
$str=$str."<li>";
if ($time=='yes') {
$str=$str."<span style='float:right' title=更新时间>".date("Y-m-d",strtotime($row["sendtime"]))."</span>";
}
if ($xuhao=='yes') {
	if ($n<=3 ){
	$str=$str."<font class='xuhao1'>".addzero($n)."</font>&nbsp;";
	}else{
	$str=$str."<font class='xuhao2'>".addzero($n)."</font>&nbsp;";
	}
}
if ($img=='yes') {
$str=$str."<table border='0' cellpadding='5' cellspacing='1' class='bgcolor2' height='140' width='140'><tr><td bgcolor='#ffffff' align='center'>";
$str=$str."<a href='".siteurl.getpageurl("zs",$row["id"])."' target='_blank' title='".$row["proname"]."'>";
$str=$str."<img src='".getsmallimg($row["img"])."' onload='resizeimg(120,120,this)'>";
$str=$str."</a>";
$str=$str."</td></tr></table>";
}

$str=$str."<a href='".siteurl.getpageurl("zs",$row["id"])."' target='_blank' title='".$row["proname"]."'>";
$str=$str.cutstr($row["proname"],$strnum);
$str=$str."</a>";

$str=$str."</li>\r\n";	
$n++;
}        
		 
$str=$str. "</ul>";
}else{
$str=$str. "暂无信息";
}
return $str;
}

function szm(){
global $szm;
$str="<div class='szm'>按产品音符检索: ";
for($i=ord( "a ");$i <=ord( "z ");$i++){

	if (chr($i)==$szm){
	$str=$str."<span>".strtoupper(chr($i))."</span>";
	}else{
	$str=$str. "<a href='/zs/search.php?szm=".chr($i)."'>".strtoupper(chr($i))."</a>";
	}
}
$str=$str."</div>";
return $str;
}
?>