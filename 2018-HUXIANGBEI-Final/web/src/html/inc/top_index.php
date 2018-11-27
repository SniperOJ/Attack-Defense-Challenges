<?php
if (isset($_REQUEST["skin"])){
$siteskin=$_REQUEST["skin"];
}else{
$siteskin=siteskin;
//php判断客户端是否为手机 
$agent = $_SERVER['HTTP_USER_AGENT']; 
if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")) {
$siteskin='mobile/'.siteskin_mobile;
}

}
function sitetop(){
global $siteskin;
$channel=strtolower($_SERVER['REQUEST_URI']);
$channel=substr($channel,1,strpos($channel,'/',1)-1);
$fp=zzcmsroot."template/".$siteskin."/top_index.htm";

if (file_exists($fp)==false){
echo $fp.' no this template';
exit;
}

$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);

$strout=str_replace("{#siteskin}",$siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#kftel}",kftel,$strout) ;
$strout=str_replace("{#kfqq}",kfqq,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#logourl}",logourl,$strout);
$strout=str_replace("{#sitekeyword}",sitekeyword,$strout);

$strout=str_replace("{#linklogin}",siteurl."/user/".getpageurl3("login"),$strout);
$strout=str_replace("{#linkreg}",siteurl."/reg/".getpageurl3("userreg"),$strout);
$strout=str_replace("{#username}",@$_COOKIE["UserName"],$strout);

$case1=strbetween($strout,"{case1}","{/case1}");
$case2=strbetween($strout,"{case2}","{/case2}");//注意要放到{#linkreg}替换内容的下面

if (isset($_COOKIE["UserName"]) && isset($_COOKIE["PassWord"])){
$strout=str_replace("{case1}","",$strout) ;
$strout=str_replace("{/case1}","",$strout) ;
$strout=str_replace("{case2}".$case2."{/case2}","",$strout) ;
}else{
$strout=str_replace("{case2}","",$strout) ;
$strout=str_replace("{/case2}","",$strout) ;
$strout=str_replace("{case1}".$case1."{/case1}","",$strout) ;
}

if ($channel<>''){
if (strpos("zs,dl,zh,company,zx,wangkan,pp,job",$channel)!==false) {
$strout=str_replace("{#".$channel."_style}","class='current_search'",$strout);
$strout=str_replace("{#".$channel."_style2} style='display:none'","",$strout);
$strout=str_replace("{#nav".$channel."}","class='current'",$strout);//导航条换为当前样式
}else{	
$strout=str_replace("{#zs_style}","class='current_search'",$strout);
$strout=str_replace("{#zs_style2} style='display:none'","",$strout);
}
}else{
$strout=str_replace("{#zs_style}","class='current_search'",$strout);
$strout=str_replace("{#zs_style2} style='display:none'","",$strout);
}
return $strout;
}
?>