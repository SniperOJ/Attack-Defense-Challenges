<?php
$t2 = microtime(true);
function sitebottom(){
global $siteskin,$t1,$t2;
$file=zzcmsroot."/template/".$siteskin."/bottom.htm";
$fso = fopen($file,'r');
$strout = fread($fso,filesize($file));

$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#siteurl}",siteurl,$strout) ;
$strout=str_replace("{#zzcmsver}",zzcmsver,$strout) ;
$strout=str_replace("{#kftel}",kftel,$strout) ;
$strout=str_replace("{#kfmobile}",kfmobile,$strout);
$strout=str_replace("{#kfqq}",kfqq,$strout);
$strout=str_replace("{#icp}",icp,$strout);
$strout=str_replace("{#sitecount}",sitecount,$strout);
return $strout;
}
?>