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
$str=$str."<li>";
	if($row['classzm']==$b){
	$str=$str."<a href='".getpageurl2("dl",$row["classzm"],"")."' class='current'>".$row["classname"]."</a>";
	}else{
	$str=$str."<a href='".getpageurl2("dl",$row["classzm"],"")."'>".$row["classname"]."</a>";
	}
	$str=$str."</li>";
$n=$n+1;		
}
}
return $str;
}

function showdl($style,$num,$strnum,$b,$editor,$saver,$keyword,$cpid){
	if ($b!='') {
	$sql="select * from `zzcms_dl_".$b."` where passed=1 ";
	}else{
	$sql="select * from zzcms_dl where passed=1 ";
	}
	if ($keyword!='') {$sql=$sql. " and cp like '%".$keyword."%' ";}
	if ($cpid!='') {$sql=$sql. " and id<>$cpid ";}
	if ($editor!='') {$sql=$sql. " and editor ='".$editor."' ";}
	if ($saver!='') {$sql=$sql. " and saver ='".$saver."' ";}	
	$sql=$sql."order by id desc ";
	$sql=$sql." limit 0,$num";
//echo $sql;
$rs=query($sql);
$row=num_rows($rs);
if ($row){	
switch ($style){
	case 1;	
	$str="<table width='100%' border='0' cellpadding='5' cellspacing='1' class='bgcolor1'>";
	$str=$str."<tr class='bgcolor3'> ";
	$str=$str."<td width='22%' height='25'><strong> 意向产品</strong></td>";
	$str=$str."<td width='10%' align='center' ><strong>联系人</strong></td>";
    $str=$str."<td width='10%' align='center' ><strong>意向区域</strong></td>";
    $str=$str."<td width='10%' align='center' ><strong>电话</strong></td>";
    $str=$str."<td width='28%' align='center' ><strong>详细内容</strong></td>";
    $str=$str."<td width='20%' align='center' ><strong>发布日期</strong></td>";
    $str=$str."</tr>";
    $n=1;
	while($row=fetch_array($rs)){
	$str=$str." <tr class='bgcolor2'>";
	$str=$str." <td height='25'>";
	$str=$str." <a href='".getpageurl("zs",$row["cpid"])."'>".cutstr($row["cp"],16)."</a>" ;
	$str=$str."</td>";
    $str=$str."<td align='center' >".$row["dlsname"]."</td>";
    $str=$str."<td align='center' >".$row["city"]."</td>";
    $str=$str."<td align='center' style='color:red'>";
	if (isshowcontact=="Yes"){
	$str=$str. $row["tel"]; }else {$str=$str."<a href='".getpageurl("dl",$row["id"])."' style=\"color:red\">VIP点击可查看</a>";}
    $str=$str."</td>";
	$str=$str."<td align='center'>".cutstr($row["content"],16)."</td>";
    $str=$str."<td align='center'>".date("Y-m-d",strtotime($row["sendtime"]))."</td>";
    $str=$str."</tr>\r\n";
	$n++;
	}
	$str=$str."</table>";
	break;
case 2;
	$str="<ul>";
	$n=1;
	while ($row=fetch_array($rs)){
	$str=$str."<li>";
	$str=$str."<span style='float:right' title=更新时间>".date("Y-m-d",strtotime($row["sendtime"]))."</span>";
	$str=$str."<a href='".siteurl.getpageurl("dl",$row["id"])."' target='_blank' title='".$row["cp"]."'>";
	$str=$str.cutstr($row["cp"],$strnum);
	$str=$str."</a>";
	$str=$str."</li>\r\n";	
	$n++;
	}        
	$str=$str. "</ul>";
	break;
}

}else{
$str="暂无信息";
}
return $str;
}
?>