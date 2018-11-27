<?php
function zxbigclass($b,$url=1){
$n=1;
$str='';
$sql="select classid,classname from zzcms_zxclass where isshowininfo=1 and parentid=0 order by xuhao asc";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
while($row=fetch_array($rs)){
	$str=$str."<li>";
	if($url==2){
		if($row['classid']==$b){
		$str=$str."<a href='".getpageurl2("zx",$row["classid"],"")."' class='current'>".$row["classname"]."</a>";
		}else{
		$str=$str."<a href='".getpageurl2("zx",$row["classid"],"")."'>".$row["classname"]."</a>";
		}
	}else{
		if($row['classid']==$b){
		$str=$str."<a href='".getpageurlzx("zx",$row["classid"])."' class='current'>".$row["classname"]."</a>";
		}else{
		$str=$str."<a href='".getpageurlzx("zx",$row["classid"])."'>".$row["classname"]."</a>";
		}
	}
	$str=$str."</li>";
	$n=$n+1;	
	}
}else{
$str="暂无分类";
}
return $str;
}

function zxsmallclass($b,$s){
if ($b<>""){
$n=1;
$sql="select classid,classname from zzcms_zxclass where parentid=".$b." order by xuhao";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
$str="";
while($row=fetch_array($rs)){
$str=$str."<li>";
if ($row["classid"]==$s){
$str=$str. " <a href='".getpageurl2("zx",$b,$row["classid"])."' class='current'>".$row["classname"]."</a>";
}else{
$str=$str. " <a href='".getpageurl2("zx",$b,$row["classid"])."'>".$row["classname"]."</a>";
}
$str=$str."</li>";	
$n=$n+1;
}
return $str;
}
}
}

function showzx($cs){
$str="";
$cs=explode(",",$cs); //传入的$cs是一个整体字符串,转成数组
$b=isset($cs[0])?$cs[0]:0;checkid($b);
$s=isset($cs[1])?$cs[1]:0;checkid($s);
$editor=isset($cs[2])?$cs[2]:'';
$show=isset($cs[3])?$cs[3]:1;

$sql="select content,id,title,img from zzcms_zx where bigclassid='$b' ";
if ($s!=0){
$sql=$sql." and smallclassid='$s' ";
}
$sql=$sql." and editor ='".$editor."' and passed=1 order by id desc";
$rs=query($sql);
$row=num_rows($rs);
//echo $sql;
if ($row){
while ($row=fetch_array($rs)){
	if ($show==1){
	$str=$str ." <li><a href='".getpageurl("zx",$row["id"])."' target='_blank'><table border='0' cellpadding='5' cellspacing='1' class='bgcolor2' height='140' width='140'><tr><td bgcolor='#ffffff' align='center'><img src='".getsmallimg($row["img"])."'></td></tr></table>".cutstr($row["title"],9)."</a></li>";
	}elseif($show==2){
	$str=$str . $row["content"];
	}elseif($show==3){
	$str=$str ." <li><a href='".getpageurl("zx",$row["id"])."' target='_blank'>".$row["title"]."</a></li>";
	}
}
}else{
$str="暂无信息";
}
return $str;
}
?>