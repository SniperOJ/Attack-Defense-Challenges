<?php
include("../inc/conn.php");
include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/zs.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

if (isset($_REQUEST['bigclass'])){
$bigclass=$_REQUEST['bigclass'];
}else{
$bigclass='A';//空参数web.config规则不支持，这里用了0
}

if (isset($_REQUEST['smallclass'])){
$smallclass=$_REQUEST['smallclass'];
}else{
$smallclass='A';
}

$pagetitle=$comane."—".channelzs."信息列表";
$pagekeywords=$comane."—".channelzs."信息列表";
$pagedescription=$comane."—".channelzs."信息列表";


if (isset($_REQUEST["page_size"])){
$page_size=$_REQUEST["page_size"];
checkid($page_size);
setcookie("page_size_zs",$page_size,time()+3600*24*360);
}else{
	if (isset($_COOKIE["page_size_zs"])){
	$page_size=$_COOKIE["page_size_zs"];
	}else{
	$page_size=10;
	}
}

if( isset($_GET["page"]) && $_GET["page"]!="") {$page=$_GET['page'];}else{$page=1;}
$list=strbetween($strout,"{loop}","{/loop}");

$sql="select count(*) as total from zzcms_main where editor='".$editor."' and passed=1 ";
$sql2='';
if ($bigclass!='A'){
$sql2=$sql2." and bigclasszm='".$bigclass."' ";
}
if ($smallclass<>'A'){
$sql2=$sql2." and smallclasszm like '%".$smallclass."%' ";
}
$rs = query($sql.$sql2);
$row = fetch_array($rs);
$totlenum = $row['total'];
$offset=($page-1)*$page_size;//$page_size在上面被设为COOKIESS
$totlepage=ceil($totlenum/$page_size);

$sql=" select * from zzcms_main where editor='".$editor."' and passed=1 ";
$sql=$sql.$sql2;
$sql=$sql." order by xuhao desc limit $offset,$page_size";
$rs = query($sql); 

//echo $sql;

if(!$totlenum){
$strout=str_replace("{#fenyei}","",$strout) ;
$strout=str_replace("{loop}".$list."{/loop}","暂无信息",$strout) ;
}else{
$list2='';
$i=1;
while ($row= fetch_array($rs)){

if (whtml=="Yes"){
$link="/sell/zsshow-".$row['id'].".htm";
}else{
$link="zsshow.php?cpid=".$row['id'] ;
}

$rsn=query("select classname from zzcms_zsclass where classzm='".$row["bigclasszm"]."'");
		$rown=num_rows($rsn);
		if ($rown){
		$rown=fetch_array($rsn);
		$bigclassname=$rown["classname"];
		}else{
		$bigclassname="大类已删除";
		}
		
$slb='';
if(strpos($row["smallclasszm"],',')!==false){ 		
$rsn=query("select classzm,classname from zzcms_zsclass where parentid='".$row["bigclasszm"]."' and classzm in(".$row['smallclasszm'].")");
		$rown=num_rows($rsn);
		if ($rown){
		$slb=" - ";
		while ($rown= fetch_array($rsn)){
			if (whtml=="Yes"){
			$slb=$slb." [ <a href='zs-".$id."-".$row["bigclasszm"]."-".$rown["classzm"].".htm'>".$rown["classname"]."</a> ] ";
			}else{
			$slb=$slb." [ <a href='/zt/zs.php?id=".$id."&bigclass=".$row["bigclasszm"]."&smallclass=".$rown["classzm"]."'>".$rown["classname"]."</a> ] ";
			}
		}
		}

}else{		
$rsn=query("select classname,classzm from zzcms_zsclass where classzm='".$row["smallclasszm"]."'");
		$rown=num_rows($rsn);
		if ($rown){
		$rown=fetch_array($rsn);
			if (whtml=="Yes"){
			$slb=" - <a href='zs-".$id."-".$row["bigclasszm"]."-".$rown["classzm"].".htm'>".$rown["classname"]."</a>";
			}else{
			$slb=" - <a href='/zt/zs.php?id=".$id."&bigclass=".$row["bigclasszm"]."&smallclass=".$rown["classzm"]."'>".$rown["classname"]."</a>";
			}
		}		
}
		
if (whtml=='Yes'){
$blb="<a href='zs-".$id."-".$row["bigclasszm"].".htm'>".$bigclassname."</a>";
}else{
$blb="<a href='/zt/zs.php?id=".$id."&bigclass=".$row["bigclasszm"]."'>".$bigclassname."</a>";
}

$lb=$blb.$slb;

$list2 = $list2. str_replace("{#link}" ,$link,$list) ;
$list2 =str_replace("{#img}",$row['img'],$list2) ;
$list2 =str_replace("{#proname}",cutstr($row["proname"],8),$list2) ;
$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($n=0; $n< count($shuxing_value);$n++){
	$list2=str_replace("{#shuxing".$n."}",$shuxing_value[$n],$list2);
	}
$list2 =str_replace("{#city}",$row["province"].$row["city"],$list2) ;

$prouse_long=strbetween($list2,"{#prouse:","}");
if ($prouse_long!=''){
$list2 =str_replace("{#prouse:".$prouse_long."}",cutstr($row['prouse'],$prouse_long),$list2) ;
}else{
$list2 =str_replace("{#prouse}",cutstr($row['prouse'],150),$list2) ;
}
$list2 =str_replace("{#lb}",$lb,$list2) ;				

$i=$i+1;
}
$fenyei='';
if ($page<>1) {
		if (whtml=="Yes") {
			$fenyei=$fenyei. "<a href='/sell/zs-".$id."-".$bigclass."-".$smallclass."-".($page-1).".htm'>上一页</a>";
			}else{
			$fenyei=$fenyei. "<a href='?id=".$id."&bigclass=".$bigclass."&smallclass=".$smallclass."&page=".($page-1)."'>上一页</a>";
		}
}
	for($a=1; $a<=$totlepage;$a++){
		if (whtml=="Yes") {
			if ($page==$a) {
			$fenyei=$fenyei. "<span>".$a."</span>";
			}else{
			$fenyei=$fenyei. "<a href='/sell/zs-".$id."-".$bigclass."-".$smallclass."-".$a.".htm'>".$a."</a>";
			}
		}else{
			if ($page==$a) {
			$fenyei=$fenyei. "<span>".$a."</span>";
			}else{
			$fenyei=$fenyei. "<a href='?id=".$id."&bigclass=".$bigclass."&smallclass=".$smallclass."&page=".$a."' >".$a."</a>";
			}
		}
	}
if ($page<>$totlepage) {
			if (whtml=="Yes") {
			$fenyei=$fenyei. "<a href='/sell/zs-".$id."-".$bigclass."-".$smallclass."-".($page+1).".htm'>下一页</a> ";
			}else{
			$fenyei=$fenyei. "<a href='?id=".$id."&bigclass=".$bigclass."&smallclass=".$smallclass."&page=".($page+1)."'>下一页</a> ";
			}
}
if ($totlepage>1){
$fenyei=$fenyei. "<select name='select' onChange=if(this.options[this.selectedIndex].value!=''){location=this.options[this.selectedIndex].value;}>";
for($a=1; $a<=$totlepage;$a++){
			if (whtml=="Yes") {
				if ($a==$page) {
				$fenyei=$fenyei. "<option value='/sell/zs-".$id."-".$bigclass."-".$smallclass."-".$a.".htm' selected>第".$a."页</option>";
				}else{
				$fenyei=$fenyei. "<option value='/sell/zs-".$id."-".$bigclass."-".$smallclass."-".$a.".htm'>第".$a."页</option>";
				}
			}else{
				if ($a==$page) {
				$fenyei=$fenyei. "<option value='?id=".$id."&bigclass=".$bigclass."&smallclass=".$smallclass."&page=".$a."' selected>第".$a."页</option>";
				}else{
				$fenyei=$fenyei. "<option value='?id=".$id."&bigclass=".$bigclass."&smallclass=".$smallclass."&page=".$a."' >第".$a."页</option>";
				}
			}
}
$fenyei=$fenyei. " </select>";
}
$strout=str_replace("{loop}".$list."{/loop}",$list2,$strout) ;
$strout=str_replace("{#fenyei}",$fenyei,$strout) ;
}

$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);

$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);

echo  $strout;
?>