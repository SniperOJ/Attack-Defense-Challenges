<?php
include("../inc/conn.php");
include("../inc/top.php");
include("../inc/bottom.php");
include("../label.php");
include("subbaojia.php");

if (isset($_REQUEST["id"])){
$dlid=trim($_REQUEST["id"]);
checkid($dlid);
}else{
$dlid=0;
}

$sql="select * from zzcms_baojia where id='$dlid'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo showmsg("不存在相关信息！");
}else{
query("update zzcms_baojia set hit=hit+1 where id='$dlid'");
$bigclasszm=$row["classzm"];
$cp=$row["cp"];
$province=$row["province"];
$city=$row["city"];
$xiancheng=$row["xiancheng"];
$sendtime=$row["sendtime"];
$price=$row["price"];
$danwei=$row["danwei"];
$truename=$row["truename"];
$address=$row["address"];
$tel=$row["tel"];


$rs=query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
$row=fetch_array($rs);
if ($row){
$bigclassname=$row["classname"];
}else{
$bigclassname="大类已删除";
}


$pagetitle=$cp."-".baojiashowtitle;
$pagekeywords=$cp."-".baojiashowkeyword;
$pagedescription=$cp."-".baojiashowdescription;
$station=getstation($bigclasszm,$bigclassname,0,"",$cp,"","baojia");

$showlx="<ul>";
$showlx=$showlx."<li>联系人：".$truename."</li>";
$showlx=$showlx."<li>地址：".$address."</li>";
$showlx=$showlx."<li>电话：".$tel."</li> ";
$showlx=$showlx." </ul> ";        

$fp="../template/".$siteskin."/baojia_show.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagekeywords,$strout);
$strout=str_replace("{#station}",$station,$strout);
$strout=str_replace("{#cp}",$cp,$strout);
$strout=str_replace("{#province}",$province,$strout);
$strout=str_replace("{#city}",$city,$strout);
$strout=str_replace("{#xiancheng}",$xiancheng,$strout);
$strout=str_replace("{#sendtime}",$sendtime,$strout);
$strout=str_replace("{#contact}",$showlx,$strout);
$strout=str_replace("{#price}",$price,$strout);
$strout=str_replace("{#danwei}",$danwei,$strout);
$strout=str_replace("{#sitebottom}",sitebottom(),$strout);
$strout=str_replace("{#sitetop}",sitetop(),$strout);
$strout=showlabel($strout);

echo  $strout;
}
?>