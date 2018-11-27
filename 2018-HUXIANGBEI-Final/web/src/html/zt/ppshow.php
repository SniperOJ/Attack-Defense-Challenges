<?php
include("../inc/conn.php");
if(isset($_REQUEST['cpid'])){
$cpid=$_REQUEST['cpid'];
checkid($cpid);
}else{
$cpid=0;
}

$rs=query("select * from zzcms_pp where id='$cpid'");
$row=num_rows($rs);
if(!$row){
showmsg('无记录');
}else{
query("update zzcms_pp set hit=hit+1 where id='$cpid'");
$row=fetch_array($rs);
$editorinzsshow=$row["editor"];//供传值到top.php
$editor=$row["editor"];
$ppname=$row['ppname'];
$ppimg=$row["img"];
$bigclasszm=$row["bigclasszm"];
$smallclasszm=$row["smallclasszm"];
$sendtime=$row["sendtime"];
$hit=$row["hit"];
$sm=$row["sm"];

$smallclassname='';
$rsn=query("select classname from zzcms_zsclass where classzm='".$bigclasszm."'");
$rown=fetch_array($rsn);
$bigclassname=$rown["classname"];
if ($smallclasszm<>""){
$rsn=query("select classname from zzcms_zsclass where classzm='".$smallclasszm."'");
$rown=fetch_array($rsn);
$smallclassname=$rown["classname"];
}

include("top.php");
include("bottom.php");
include("left.php");

$fp="../skin/".$skin."/ppshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);


$pagetitle=$ppname.ppshowtitle;
$pagekeywords=$ppname.ppshowkeyword;
$pagedescription=$ppname.ppshowdescription;
//station
if(whtml=="Yes"){
	$station="<a href='".siteurl."'>网站首页</a> &gt; <a href='/pp/pp.htm'>品牌信息</a> ";
	if($smallclasszm<>''){ 
	$station=$station .  "&gt; <a href='/pp/".$bigclasszm."'>".$bigclassname."</a> &gt; <a href='/pp/".$bigclasszm."/".$smallclasszm."'>".$smallclassname."</a> &gt; ".$ppname;
	}else{
	$station=$station .  "&gt; <a href='/pp/".$bigclasszm."'>".$bigclassname."</a> &gt; " .$ppname;
	}
}else{
	$station="<a href='".siteurl."'>网站首页</a> &gt; <a href='/pp/pp.php'>品牌信息</a> ";
	if($smallclasszm<>''){ 
	$station=$station .  "&gt; <a href='/pp/pp.php?b=".$bigclasszm."'>".$bigclassname."</a> &gt; <a href='/pp/pp.php?b=".$bigclasszm."&s=".$smallclasszm."'>".$smallclassname."</a> &gt; ".$ppname;
	}else{
	$station=$station .  "&gt; <a href='/pp/pp.php?b=".$bigclasszm."'>".$bigclassname."</a> &gt; " .$ppname;
	}
}
$strout=str_replace("{#ppname}",$ppname,$strout) ;
$strout=str_replace("{#bigclass}",$bigclassname,$strout) ;
$strout=str_replace("{#smallclass}",$smallclassname,$strout) ;
//cp		 
$strout=str_replace("{#img}",$ppimg,$strout) ;
$strout=str_replace("{#comane}",$comane,$strout) ;
$strout=str_replace("{#hit}",$hit,$strout) ;
$strout=str_replace("{#sendtime}",$sendtime,$strout) ;
$strout=str_replace("{#sm}",nl2br($sm),$strout) ;


//dlform
if (isset($_COOKIE["UserName"])) {
$rsn=query("select * from zzcms_user where username='".trim($_COOKIE["UserName"])."'");
$rown=fetch_array($rsn);
$companyname=$rown["comane"];
$somane=$rown["somane"];
$phone=$rown["phone"];
$email=$rown["email"];
}else{
$companyname="";
$somane="";
$phone="";
$email="";
}
$strout=str_replace("{textarea}","<textarea id='contents' rows=6 cols=30 name='contents' onfocus='check_contents()' onblur='check_contents()'>愿加盟“".$ppname."”这个品牌，请与我联系。</textarea>",$strout) ;
$strout=str_replace("{#companyname}",$companyname,$strout) ;
$strout=str_replace("{#somane}",$somane,$strout) ;
$strout=str_replace("{#phone}",$phone,$strout);
$strout=str_replace("{#email}",$email,$strout);
$strout=str_replace("{#saver}",$editor,$strout);
//end

$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#station}",$station,$strout);

$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
echo  $strout;
}			  
?>