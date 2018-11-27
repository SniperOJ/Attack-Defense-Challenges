<?php
function bigclass($b){
$n=1;
$str='';
$rs=query("select classid,classname from zzcms_userclass where parentid=0 order by xuhao asc");
$row=num_rows($rs);
if ($row){
	while ($row=fetch_array($rs)){
	$str=$str."<li>";
	if($row['classid']==$b){
	$str=$str."<a href='".getpageurl2("company",$row["classid"],"")."' class='current'>".$row["classname"]."</a>";
	}else{
	$str=$str."<a href='".getpageurl2("company",$row["classid"],"")."'>".$row["classname"]."</a>";
	}
	$str=$str."</li>";
	$n=$n+1;		
	}
}else{
$str="暂无分类";
}
return $str;
}

function smallclass($b,$s,$num){
$str="";
$n=1;
if ($num<>""){
$sql="select classname,classid from zzcms_userclass where parentid='". $b ."' order by xuhao limit 0,$num";
}else{
$sql="select classname,classid from zzcms_userclass where parentid='". $b ."' order by xuhao";
}
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str="暂无分类";
}else{
while ($row=fetch_array($rs)){
	$str=$str."<li>";
	if($row['classid']==$s){
	$str=$str. "<a href='".getpageurl2("company",$b,$row["classid"])."' class='current'>".$row["classname"]."</a>";	
	}else{
	$str=$str. "<a href='".getpageurl2("company",$b,$row["classid"])."'>".$row["classname"]."</a>";	
	}
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}
?>