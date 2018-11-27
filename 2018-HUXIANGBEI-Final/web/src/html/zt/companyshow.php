<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("top.php");
include("bottom.php");
include("left.php");

$pagetitle=$comane.companyshowtitle;
$pagekeywords=$comane.companyshowkeyword;
$pagedescription=$comane.companyshowdescription;

$gsjj="<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
$gsjj=$gsjj. "<tr>";
$gsjj=$gsjj. "<td style='font-size:14px;line-height:25px'>";
if($flv<>""){
	if(substr($flv,-3)=="flv"){
	$gsjj=$gsjj. "<span id='container' style='float:left;display:inline;margin-right:10px'></span>";
	$gsjj=$gsjj. "<script src='/js/swfobject.js' type='text/javascript'></script>";
	$gsjj=$gsjj. "<script type='text/javascript'>";
	$gsjj=$gsjj. "var s1 = new SWFObject('/image/player.swf','ply','300','260','9','#FFFFFF');";
	$gsjj=$gsjj. "s1.addParam('allowfullscreen','true');";
	$gsjj=$gsjj. "s1.addParam('allowscriptaccess','always');";
	$gsjj=$gsjj. "s1.addParam('flashvars','file=".$flv."&backcolor=&frontcolor=&image=&logo=".logourl."&autostart=false');";
	$gsjj=$gsjj. "s1.write('container');";
	$gsjj=$gsjj. "</script>";
	}elseif (substr($flv,-3)=="swf"){
	$gsjj=$gsjj. "<span style='float:left;display:inline;margin-right:10px'>";		
	$gsjj=$gsjj. "<embed src='".$flv."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='300' height='260'></embed>";
	$gsjj=$gsjj. "</span>";
	}
}elseif($img<>""){
	//$gsjj=$gsjj. "<img id='gsjjimg' src='".siteurl.$img."' onload='javascript:if(this.width>300) this.width=300;' align='left'>" ;		
}

$gsjj=$gsjj. $content;
//$gsjj=$gsjj. nl2br($content);//不用编缉器时
$gsjj=$gsjj. "</td>";
$gsjj=$gsjj. "</tr>";
$gsjj=$gsjj. "</table>";

$fp="../skin/".$skin."/companyshow.htm";
if (file_exists($fp)==false){
WriteErrMsg($fp.'模板文件不存在');
exit;
}
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#gsjj}",$gsjj,$strout);
$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);

session_write_close();
echo  $strout;
?>