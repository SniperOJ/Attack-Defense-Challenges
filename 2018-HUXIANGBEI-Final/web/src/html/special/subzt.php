<?php
function bigclass($b,$url=1){
$n=1;
$str='';
$sql="select classid,classname from zzcms_specialclass where isshowininfo=1 and parentid=0 order by xuhao asc";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
while($row=fetch_array($rs)){
	if($row['classid']==$b){$str=$str."<li class='current'>";}else{$str=$str."<li>";}
	if($url==2){
	$str=$str."<a href='".getpageurl2("special",$row["classid"],"")."'>".$row["classname"]."</a>";
	}else{
	$str=$str."<a href='".getpageurlzx("special",$row["classid"])."'>".$row["classname"]."</a>";
	}
	$str=$str."</li>";
	$n=$n+1;	
	}
}else{
$str="暂无分类";
}
return $str;
}

function smallclass($column,$b,$s){
if ($b<>""){
$n=1;
$sql="select classid,classname from zzcms_specialclass where parentid=".$b." order by xuhao";
$rs=query($sql);
$row=num_rows($rs);
if ($row){

$str="<table width=100% border=0 cellspacing=1 cellpadding=0 class='bgcolor3'><tr>";
while($row=fetch_array($rs)){
$str=$str."<td height=23 align='center' class='infos'>";
if ($row["classid"]==$s){
$str=$str. " <a href='".getpageurl2("special",$b,$row["classid"])."'><b>".$row["classname"]."</b></a>";
}else{
$str=$str. " <a href='".getpageurl2("special",$b,$row["classid"])."'>".$row["classname"]."</a>";
}
$str=$str."</td>";
	if ($n % $column==0){
	$str=$str. "</tr>";
	}
$n=$n+1;
}
$str=$str."</table>";
return $str;
}
}
}

function showzt($b,$s,$editor,$show){
$str="";
$sql="select content,id,title,img from zzcms_special where bigclassid=$b ";
if ($s!=0){
$sql=$sql." and smallclassid=$s ";
}
$sql=$sql." and editor ='".$editor."' and passed=1 order by id desc";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
while ($row=fetch_array($rs)){
	if ($show==1){
	$str=$str ." <li><a href='".getpageurl("special",$row["id"])."' target='_blank'><table border='0' cellpadding='5' cellspacing='1' class='bgcolor2' height='140' width='140'><tr><td bgcolor='#ffffff' align='center'><img src='".getsmallimg($row["img"])."'></td></tr></table>".cutstr($row["title"],9)."</a></li>";
	}elseif($show==2){
	$str=$str . $row["content"];
	}elseif($show==3){
	$str=$str ." <li><a href='".getpageurl("special",$row["id"])."' target='_blank'>".$row["title"]."</a></li>";
	}
}
}else{
$str="暂无信息";
}
return $str;
}

function getstation_zt($bid,$bname,$sid,$sname,$title,$keyword,$channel){
$str="<li class='start'>";
	if (whtml=="Yes") {
		$str=$str."<a href='".siteurl."'>首页</a></li><li><a href='/".$channel."'>".getchannelname($channel)."</a> </li>" ;
      	if ($bid<>""){
		$str=$str. "<li><a href='/".$channel."/class/".$bid."'>".$bname."</a></li>";
		}		
		if ($sid<>"") {
		$str=$str. "<li><a href='/".$channel."/".$bid."/".$sid.".html'>".$sname."</a></li>";
		}
		if ($title<>"") {
		$str=$str. "<li>".$title."</li>";
		}
		if ($keyword<>"") {
		$str=$str. "<li>关键字中含有“".$keyword."”的".getchannelname($channel)."</li>";
		}
	}else{
		$str=$str."<a href='".siteurl."'>首页</a></li><li><a href='/".$channel."'>".getchannelname($channel)."</a></li>" ;
      	if ($bid<>"") {
		$str=$str. "<li><a href='/".$channel."/class.php?b=".$bid."'>".$bname."</a></li>";
		}		
		if ($sid<>"") {
		$str=$str. "<li><a href='".$channel.".php?b=".$bid."&s=".$sid."'>".$sname."</a></li>";
		}
		if ($title<>"") {
		$str=$str. "<li>".$title."</li>";
		}
		if ($keyword<>"") {
		$str=$str. "<li>关键字中含有“".$keyword."”的".getchannelname($channel)."</li>";
		}
	}
return $str;	
}
?>