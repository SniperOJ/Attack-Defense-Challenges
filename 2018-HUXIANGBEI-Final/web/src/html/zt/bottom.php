<?php
$fp="../skin/".$skin."/bottom.htm";
if (file_exists($fp)==false){
WriteErrMsg('../skin/'.$skin.'/bottom.htm 模板文件不存在');
}else{
$f = fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$sitebottom=str_replace("{#siteskin}",siteskin,$strout) ;
$sitebottom=str_replace("{#sitename}",sitename,$sitebottom) ;
$sitebottom=str_replace("{#kftel}",kftel,$sitebottom);
$sitebottom=str_replace("{#siteurl}",siteurl,$sitebottom);
$sitebottom=str_replace("{#zzcmsver}",zzcmsver,$sitebottom);
$sitebottom=str_replace("{#tongji}",$tongji,$sitebottom);
$sitebottom=str_replace("{#companyname}",$comane,$sitebottom);
}
?>