<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("top.php");
include("bottom.php");
include("left.php");

$pagetitle=$comane.companyshowtitle;
$pagekeywords=$comane.companyshowkeyword;
$pagedescription=$comane.companyshowdescription;

$lxfs="<div class='lxfsbg'>";
if ($showcontact=='yes'  || $_SESSION["dlliuyan"]==$editor) {
$lxfs=$lxfs."<ul>";
$lxfs=$lxfs."<li><b>".$comane."</b></li>";
$lxfs=$lxfs."<li>地址：".$address."</li>";
$lxfs=$lxfs."<li>电话：".$phone."</li>";
$lxfs=$lxfs."<li>传真：".$fox."</li>";
$lxfs=$lxfs."<li>网址：" ;
if(sdomain=="Yes"){
$lxfs=$lxfs. "<a href='http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."'>http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."</a>";
}else{
$lxfs=$lxfs. "<a href='".addhttp($homepage)."' target='_blank'>".$homepage."</a>";
}
$lxfs=$lxfs."</li>" ;						
$lxfs=$lxfs."<li>";
$lxfs=$lxfs."手机：".$mobile.$somane."&nbsp; ";
if($sex==1){ 
$lxfs=$lxfs."(先生)" ;
}elseif($sex==0){ 
$lxfs=$lxfs."(女士)" ;
}else{ 
$lxfs=$lxfs."" ;
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li>E-mail：" ;
if($email<>""){
	$lxfs=$lxfs.  str_replace("@","<img src='".siteurl."/image/em.gif'>",$email);
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li>QQ：" ;
if($qq<>""){
$lxfs=$lxfs. "<a target=blank href=http://wpa.qq.com/msgrd?v=1&uin=".$qq."&Site=".sitename."&Menu=yes><img border='0' src=http://wpa.qq.com/pa?p=1:".$qq.":10></a> ";
}
$lxfs=$lxfs."</li>";
$lxfs=$lxfs."<li style='color:red'>联系我时，请说是在".sitename."上看到的，谢谢！</li>";
			  
$lxfs=$lxfs."</ul>";
}else{
$lxfs=$lxfs."<ul>";
$lxfs=$lxfs."<li><b>".$comane."</b></li>";
$lxfs=$lxfs."<li>地址：".$address."</li>";
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$lxfs=$lxfs."<li>电话：<a href='/zt/liuyan.php?id=$id&fromurl=".$url."#liuyan' style='color:#FF3300'>填写".channeldl."信息，联系方式自动显示。</a> </li>";
$lxfs=$lxfs."<li>传真：<a href='/zt/liuyan.php?id=$id&fromurl=".$url."#liuyan' style='color:#FF3300'>填写".channeldl."信息，联系方式自动显示。</a>  </li>";
$lxfs=$lxfs."<li>网址：" ;
if(sdomain=="Yes"){
$lxfs=$lxfs. "<a href='http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."'>http://".$editor.".".substr(siteurl,strpos(siteurl,".")+1)."</a>";
}else{
$lxfs=$lxfs. "<a href='".addhttp($homepage)."' target='_blank'>".$homepage."</a>";
}
$lxfs=$lxfs."</li>" ;						
$lxfs=$lxfs."<li>手机：<a href='/zt/liuyan.php?id=$id&fromurl=".$url."#liuyan' style='color:#FF3300'>填写".channeldl."信息，联系方式自动显示。</a></li>";
$lxfs=$lxfs."<li>email：<a href='/zt/liuyan.php?id=$id&fromurl=".$url."#liuyan' style='color:#FF3300'>填写".channeldl."信息，联系方式自动显示。</a> </li>";
$lxfs=$lxfs."<li>QQ：<a href='/zt/liuyan.php?id=$id&fromurl=".$url."#liuyan' style='color:#FF3300'>填写".channeldl."信息，联系方式自动显示。</a> </li>";		  
$lxfs=$lxfs."</ul>";
}
$lxfs=$lxfs."</div>";


$fp="../skin/".$skin."/contact.htm";
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
$strout=str_replace("{#sitebottom}",$sitebottom,$strout);
$strout=str_replace("{#sitetop}",$sitetop,$strout);
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);
$strout=str_replace("{#ztleft}",$siteleft,$strout);
$strout=str_replace("{#showdaohang}",$showdaohang,$strout);
$strout=str_replace("{#skin}",$skin,$strout);
$strout=str_replace("{#lxfs}",$lxfs,$strout);
$strout=str_replace("{#baidu_map}",$baidu_map,$strout);

session_write_close();
echo  $strout;
?>