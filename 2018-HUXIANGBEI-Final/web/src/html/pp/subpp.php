<?php
function bigclass($b){
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
	$str=$str."<a href='".getpageurl2("pp",$row["classzm"],"")."'>".$row["classname"]."</a>";
	//$rsnumb=query("select id from zzcms_pp where bigclasszm='".$row["classzm"]."' ");//统计所属大类下的信息数
	//$str=$str. " <span>(共" .num_rows($rsnumb). "条)</span>" ;
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}

function showppsmallclass($b,$s,$column,$num){
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
	$str=$str. "<a href='".getpageurl2("pp",$b,$row["classzm"])."' class='current'>".$row["classname"]."</a>";	
	}else{
	$str=$str. "<a href='".getpageurl2("pp",$b,$row["classzm"])."'>".$row["classname"]."</a>";
	}
	$str=$str. "</li>";	
$n=$n+1;		
}
}
return $str;
}

function showpp($cs){
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
	$sql="select id,ppname,img,sendtime,passed,hit from zzcms_pp where passed=1 ";
	if ($b!='no') {$sql=$sql. "and bigclasszm='$b' ";}
	if ($s!='no') {$sql=$sql. "and bigclasszm='$s' ";}
	if ($keyword!='no') {$sql=$sql. " and ppname like '%".$keyword."%' ";}
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
//echo $sql;
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
$str=$str."<a href='".getpageurl("pp",$row["id"])."' target='_blank' title='".$row["ppname"]."'>";
if ($img=='yes') {
$str=$str."<table border='0' cellpadding='5' cellspacing='1' class='bgcolor2' height='140' width='140'><tr><td bgcolor='#ffffff' align='center'><img src='".getsmallimg($row["img"])."'></td></tr></table>";
}
$str=$str.cutstr($row["ppname"],$strnum);
$str=$str."</a>";

$str=$str."</li>";	
$n++;
}        
		 
$str=$str. "</ul>";
}else{
$str=$str. "暂无信息";
}
return $str;
}
?>