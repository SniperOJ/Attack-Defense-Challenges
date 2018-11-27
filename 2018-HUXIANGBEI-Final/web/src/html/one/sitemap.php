<?php
require("../inc/conn.php");
include("../inc/top2.php");
include("../inc/bottom.php");

$file="../template/".$siteskin."/sitemap.htm";
if (file_exists($file)==false){
WriteErrMsg($file.'模板文件不存在');
exit;
}

function bigclass($channel){
$str="";
$n=1;
switch ($channel){
	case "zh":$sql="select bigclassname,bigclassid from zzcms_zhclass  order by xuhao";
	break;
	case "zx":$sql="select classid,classname from zzcms_zxclass where isshowininfo=1 and parentid=0 order by xuhao asc";
	break;
	case "special":$sql="select classid,classname from zzcms_specialclass where isshowininfo=1 and parentid=0 order by xuhao asc";
	break;
	case "job":$sql="select classname,classid from zzcms_jobclass where parentid='0' order by xuhao";
	break;
	case "company":$sql="select classid,classname from zzcms_userclass order by xuhao asc";
	break;
	default:$sql="select classname,classid,classzm from zzcms_zsclass where parentid='A' order by xuhao";
	}
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
$str="暂无分类";
}else{
	while ($row=fetch_array($rs)){
	$str=$str."<li>";
	switch ($channel){
	case "zs":$str=$str."<a href='".getpageurlzs("zsclass",$row["classzm"])."'>".$row["classname"]."</a>";
	break;
	case "dl":$str=$str."<a href='".getpageurl2("dl",$row["classzm"],"")."'>".$row["classname"]."</a>";
	break;
	case "pp":$str=$str."<a href='".getpageurl2("pp",$row["classzm"],"")."'>".$row["classname"]."</a>";
	break;
	case "zh":$str=$str."<a href='".getpageurl2("zh",$row["bigclassid"],"")."'>".$row["bigclassname"]."</a>";
	break;
	case "zx":$str=$str."<a href='".getpageurlzx("zx",$row["classid"])."'>".$row["classname"]."</a>";
	break;
	case "job":$str=$str."<a href='".getpageurl2("job",$row["classid"],"")."'>".$row["classname"]."</a>";
	break;
	case "special":$str=$str."<a href='".getpageurlzx("special",$row["classid"])."'>".$row["classname"]."</a>";
	break;
	case "company":$str=$str."<a href='".getpageurl2("company",$row["classid"],"")."'>".$row["classname"]."</a>";
	break;
	}
	
	$str=$str."</li>\n";
	$n=$n+1;		
	}
}
return $str;
}

$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));
fclose($fso);
$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#pagetitle}",sitetitle,$strout);
$strout=str_replace("{#pagekeywords}",sitekeyword,$strout);
$strout=str_replace("{#pagedescription}",sitedescription,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=str_replace("{#zs}",bigclass("zs"),$strout);
$strout=str_replace("{#dl}",bigclass("dl"),$strout);
$strout=str_replace("{#pp}",bigclass("pp"),$strout);
$strout=str_replace("{#zh}",bigclass("zh"),$strout);
$strout=str_replace("{#zx}",bigclass("zx"),$strout);
$strout=str_replace("{#job}",bigclass("job"),$strout);
$strout=str_replace("{#special}",bigclass("special"),$strout);
$strout=str_replace("{#company}",bigclass("company"),$strout);
echo  $strout;
?>