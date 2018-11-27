<?php
//产品版
include("inc/fixed.php");
function showlabel($str){
global $b;//zsshow需要从zs/class.php获取$b；zxshow从s/class.php获取$b；
$str=fixed($str);//把显示固定标签代码分离出去了
if (strpos($str,"{@zsshow.")!==false) {
	$n=count(explode("{@zsshow.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zsshow.","}");
	$str=str_replace("{@zsshow.".$mylabel."}",zsshow($mylabel,$b),$str);
	}
}
if (strpos($str,"{@zsclass.")!==false) {
	$n=count(explode("{@zsclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zsclass.","}");
	$str=str_replace("{@zsclass.".$mylabel."}",zsclass($mylabel),$str);
	}
}
if (strpos($str,"{@ppshow.")!==false) {
	$n=count(explode("{@ppshow.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@ppshow.","}");
	$str=str_replace("{@ppshow.".$mylabel."}",ppshow($mylabel,$b),$str);
	}
}
if (strpos($str,"{@ppclass.")!==false) {
	$n=count(explode("{@ppclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@ppclass.","}");
	$str=str_replace("{@ppclass.".$mylabel."}",ppclass($mylabel),$str);
	}
}
if (strpos($str,"{@jobshow.")!==false) {
	$n=count(explode("{@jobshow.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@jobshow.","}");
	$str=str_replace("{@jobshow.".$mylabel."}",jobshow($mylabel,$b),$str);
	}
}
if (strpos($str,"{@jobclass.")!==false) {
	$n=count(explode("{@jobclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@jobclass.","}");
	$str=str_replace("{@jobclass.".$mylabel."}",jobclass($mylabel),$str);
	}
}
if (strpos($str,"{@dlclass.")!==false) {
	$n=count(explode("{@dlclass.",$str));//循环之前取值
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@dlclass.","}");
	$str= str_replace("{@dlclass.".$mylabel."}",dlclass($mylabel),$str);
	}
}
if (strpos($str,"{@dlshow.")!==false) {
	$n=count(explode("{@dlshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@dlshow.","}");
	$str= str_replace("{@dlshow.".$mylabel."}",dlshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@guestshow.")!==false) {
	$n=count(explode("{@guestshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@guestshow.","}");
	$str= str_replace("{@guestshow.".$mylabel."}",guestshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@zhshow.")!==false) {
	$n=count(explode("{@zhshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zhshow.","}");
	$str=str_replace("{@zhshow.".$mylabel."}",zhshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@zhclass.")!==false) {
	$n=count(explode("{@zhclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zhclass.","}");
	$str=str_replace("{@zhclass.".$mylabel."}",zhclass($mylabel),$str);
	}
}
if (strpos($str,"{@companyshow.")!==false) {
	$n=count(explode("{@companyshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@companyshow.","}");
	$str=str_replace("{@companyshow.".$mylabel."}",companyshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@companyclass.")!==false) {
	$n=count(explode("{@companyclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@companyclass.","}");
	$str=str_replace("{@companyclass.".$mylabel."}",companyclass($mylabel),$str);
	}
}
if (strpos($str,"{@zxshow.")!==false) {
	$n=count(explode("{@zxshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zxshow.","}");
	$str=str_replace("{@zxshow.".$mylabel."}",zxshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@zxclass.")!==false) {
	$n=count(explode("{@zxclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@zxclass.","}");
	$str=str_replace("{@zxclass.".$mylabel."}",zxclass($mylabel),$str);
	}
}
if (strpos($str,"{@wangkanshow.")!==false) {
	$n=count(explode("{@wangkanshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@wangkanshow.","}");
	$str=str_replace("{@wangkanshow.".$mylabel."}",wangkanshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@wangkanclass.")!==false) {
	$n=count(explode("{@wangkanclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@wangkanclass.","}");
	$str=str_replace("{@wangkanclass.".$mylabel."}",wangkanclass($mylabel),$str);
	}
}
if (strpos($str,"{@baojiashow.")!==false) {
	$n=count(explode("{@baojiashow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@baojiashow.","}");
	$str=str_replace("{@baojiashow.".$mylabel."}",baojiashow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@baojiaclass.")!==false) {
	$n=count(explode("{@baojiaclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@baojiaclass.","}");
	$str=str_replace("{@baojiaclass.".$mylabel."}",baojiaclass($mylabel),$str);
	}
}
if (strpos($str,"{@askshow.")!==false) {
	$n=count(explode("{@askshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@askshow.","}");
	$str=str_replace("{@askshow.".$mylabel."}",askshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@askclass.")!==false) {
	$n=count(explode("{@askclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@askclass.","}");
	$str=str_replace("{@askclass.".$mylabel."}",askclass($mylabel),$str);
	}
}
if (strpos($str,"{@specialshow.")!==false) {
	$n=count(explode("{@specialshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@specialshow.","}");
	$str=str_replace("{@specialshow.".$mylabel."}",specialshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@specialclass.")!==false) {
	$n=count(explode("{@specialclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@specialclass.","}");
	$str=str_replace("{@specialclass.".$mylabel."}",specialclass($mylabel),$str);
	}
}
if (strpos($str,"{@helpshow.")!==false) {
	$n=count(explode("{@helpshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@helpshow.","}");
	$str=str_replace("{@helpshow.".$mylabel."}",helpshow($mylabel),$str);
	}
}
if (strpos($str,"{@linkshow.")!==false) {
	$n=count(explode("{@linkshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@linkshow.","}");
	$str=str_replace("{@linkshow.".$mylabel."}",linkshow($mylabel,""),$str);
	}
}
if (strpos($str,"{@linkclass.")!==false) {
	$n=count(explode("{@linkclass.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@linkclass.","}");
	$str=str_replace("{@linkclass.".$mylabel."}",linkclass($mylabel),$str);
	}
}
if (strpos($str,"{@adshow.")!==false) {
	$n=count(explode("{@adshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@adshow.","}");
	$str=str_replace("{@adshow.".$mylabel."}",adshow($mylabel,$b,0),$str);
	}
}
if (strpos($str,"{@aboutshow.")!==false) {
	$n=count(explode("{@aboutshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@aboutshow.","}");
	$str=str_replace("{@aboutshow.".$mylabel."}",aboutshow($mylabel),$str);
	}
}
if (strpos($str,"{@guestbookshow.")!==false) {
	$n=count(explode("{@guestbookshow.",$str));
	for ($i=1;$i<$n;$i++){ 
	$mylabel=strbetween($str,"{@guestbookshow.","}");
	$str=str_replace("{@guestbookshow.".$mylabel."}",guestbookshow($mylabel),$str);
	}
}
return $str;
}

function zsclass($labelname){return labelclass($labelname,'zs');}
function dlclass($labelname){return labelclass($labelname,'dl');}
function ppclass($labelname){return labelclass($labelname,'pp');}
function jobclass($labelname){return labelclass($labelname,'job');}
function zhclass($labelname){return labelclass($labelname,'zh');}
function linkclass($labelname){return labelclass($labelname,'link');}
function companyclass($labelname){return labelclass($labelname,'company');}
function zxclass($labelname){return labelclass($labelname,'zx');}
function wangkanclass($labelname){return labelclass($labelname,'wangkan');}
function baojiaclass($labelname){return labelclass($labelname,'baojia');}
function askclass($labelname){return labelclass($labelname,'ask');}
function specialclass($labelname){return labelclass($labelname,'special');}

function writecache($channel,$classid,$labelname,$str){//$classid,$labelname 这两个参数在外部函数的参数里，没有在函数内部无法通过global获取到。
global $siteskin,$provincezm;
	if ($classid!='empty' && $classid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$classid."-".$labelname.".txt";
	}elseif($provincezm<>''){//area.php中调用zs,dl,company三个频道中用到这个条件。
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$provincezm."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/".$channel."/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/".$channel)) {mkdir(zzcmsroot."cache/".$siteskin."/".$channel,0777,true);}
	//echo zzcmsroot."cache/".$siteskin."/".$channel;
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);	
}

function labelclass($labelname,$channel){
global $siteskin,$b;//取外部值，供演示模板用,$b资讯和专题用到$b
if (!isset($siteskin)){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/".$channel."class/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/".$channel."class/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$startnumber = $f[1];$numbers = $f[2];$row = $f[3];$start = $f[4];$mids = $f[5];

if($channel=="zx" || $channel=="special" || $channel=="ask"){
	$mids = str_replace($channel.".php?b={#bigclassid}","/".$channel."/".$channel.".php?b={#bigclassid}",$mids);//后有小类的同样会被转换前面加/
	}

if ( whtml == "Yes"){
$mids = str_replace($channel.".php?b={#classid}", "{#classid}",$mids);
	if($channel=="zs"){
	$mids = str_replace("class.php?b={#classid}", "{#classid}.htm",$mids);
	}
	if($channel=="zx" || $channel=="special" || $channel=="ask"){
	$mids = str_replace("/".$channel."/".$channel.".php?b={#bigclassid}&s={#smallclassid}","/".$channel."/{#bigclassid}/{#smallclassid}",$mids);
	$mids = str_replace("/".$channel."/".$channel.".php?b={#bigclassid}","{#bigclassid}",$mids);
	}
	if($channel=="special"){
	$mids = str_replace("class.php?b={#bigclassid}","/special/class/{#bigclassid}",$mids);
	}
}
$ends = $f[6];
if ($channel=='zs' || $channel=='pp'|| $channel=='dl'|| $channel=='baojia'){
$sql ="select classid,classname,classzm from zzcms_zsclass where parentid='A' order by xuhao limit $startnumber,$numbers ";
}elseif($channel=='job'){
$sql ="select * from zzcms_jobclass where parentid='0' order by xuhao limit $startnumber,$numbers ";
}elseif($channel=="zh" || $channel=="link"|| $channel=="wangkan"){
$sql ="select * from zzcms_".$channel."class order by xuhao limit $startnumber,$numbers ";
}elseif($channel=="company"){
$sql ="select * from zzcms_userclass where  parentid='0' order by xuhao limit $startnumber,$numbers ";
}elseif($channel=="zx" || $channel=="special" || $channel=="ask"){
	if ($b<>""){
	$sql ="select * from zzcms_".$channel."class where  parentid=".$b." order by xuhao limit $startnumber,$numbers ";
	}else{
	$sql ="select * from zzcms_".$channel."class where  isshowininfo=1 and parentid=0 order by xuhao limit $startnumber,$numbers ";
	}
}
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$i = 1;
$mylabel1="";
$mids3='';
if (count(explode("{@".$channel."show.",$mids))==2) {
	$mylabel1=strbetween($mids,"{@".$channel."show.","}");
}
$mylabel2="";
if (count(explode("{@".$channel."show.",$mids))==3) {
	$mylabel1=strbetween($mids,"{@".$channel."show.","}");
	$mids2 = str_replace("{@".$channel."show." . $mylabel1 . "}", "",$mids); //把第一个标签换空,方可找出第二个标签
	$mylabel2=strbetween($mids2,"{@".$channel."show.","}");	
}
while($r=fetch_array($rs)){	

if ($channel=='zs'){
$zssmallclass_num=strbetween($mids,"{#zssmallclass:","}");
$mids3=$mids3.str_replace("{#zssmallclass:".$zssmallclass_num."}",showzssmallclass($r["classzm"],"",$zssmallclass_num,$zssmallclass_num),str_replace("{@zsshow." . $mylabel2 . "}", zsshow($mylabel2,$r["classzm"]),str_replace("{@zsshow." . $mylabel1 . "}", zsshow($mylabel1,$r["classzm"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classzm"],$mids)))));
if ($i==1){
$mids3=str_replace("{#title_style}","class=current1",$mids3);
$mids3=str_replace("{#content_style}","style=display:block",$mids3);
}else{
$mids3=str_replace("{#title_style}","",$mids3);
$mids3=str_replace("{#content_style}","style=display:none",$mids3);
}

}elseif($channel=='pp'){
$mids3=$mids3.str_replace("{@ppshow." . $mylabel2 . "}", ppshow($mylabel2,$r["classzm"]),str_replace("{@ppshow." . $mylabel1 . "}", ppshow($mylabel1,$r["classzm"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classzm"],$mids))));
}elseif($channel=='job'){
$mids3=$mids3.str_replace("{@jobshow." . $mylabel2 . "}", jobshow($mylabel2,$r["classid"]),str_replace("{@jobshow." . $mylabel1 . "}", jobshow($mylabel1,$r["classid"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classid"],$mids))));
}elseif($channel=="dl"){
$mids3=$mids3.str_replace("{@dlshow." . $mylabel2 . "}", dlshow($mylabel2,$r["classzm"]),str_replace("{@dlshow." . $mylabel1 . "}", dlshow($mylabel1,$r["classzm"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classzm"],$mids))));
}elseif($channel=="zh"){
$mids3=$mids3.str_replace("{@zhshow." . $mylabel2 . "}",zhshow($mylabel2,$r["bigclassid"]),str_replace("{@zhshow." . $mylabel1 . "}", zhshow($mylabel1,$r["bigclassid"]),str_replace("{#classname}",$r["bigclassname"],str_replace("{#classid}",$r["bigclassid"],$mids))));
}elseif($channel=="wangkan"){
$mids3=$mids3.str_replace("{@wangkanshow." . $mylabel2 . "}",wangkanshow($mylabel2,$r["bigclassid"]),str_replace("{@wangkanshow." . $mylabel1 . "}", wangkanshow($mylabel1,$r["bigclassid"]),str_replace("{#classname}",$r["bigclassname"],str_replace("{#classid}",$r["bigclassid"],$mids))));

}elseif($channel=="baojia"){
$mids3=$mids3.str_replace("{@baojiashow." . $mylabel2 . "}", baojiashow($mylabel2,$r["classzm"]),str_replace("{@baojiashow." . $mylabel1 . "}", baojiashow($mylabel1,$r["classzm"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classzm"],$mids))));

}elseif($channel=="link"){
$mids3=$mids3.str_replace("{@linkshow." . $mylabel2 . "}", linkshow($mylabel2,$r["bigclassid"]),str_replace("{@linkshow." . $mylabel1 . "}", linkshow($mylabel1,$r["bigclassid"]),str_replace("{#classname}",$r["bigclassname"],str_replace("{#classid}",$r["bigclassid"],$mids))));
}elseif($channel=="company"){
$mids3=$mids3.str_replace("{@companyshow." . $mylabel2 . "}", companyshow($mylabel2,$r["classid"]),str_replace("{@companyshow." . $mylabel1 . "}", companyshow($mylabel1,$r["classid"]),str_replace("{#classname}",$r["classname"],str_replace("{#classid}",$r["classid"],$mids))));
}elseif($channel=="zx"){
	if ($b<>""){//父类不为空，调出的classid为小类
	$mids3=$mids3.str_replace("{@zxshow." . $mylabel1 . "}", zxshow($mylabel1,$b,$r["classid"]),$mids);//注意这里用首次替换已把$mids赋值给$mids3了，	
	$mids3=str_replace("{@zxshow." . $mylabel2 . "}", zxshow($mylabel2,$b,$r["classid"]),$mids3);//这里替换$mids3里的内容
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$b,$mids3);
	$mids3=str_replace("{#smallclassid}",$r["classid"],$mids3);
	}else{//父类为空，只调出的为大类就行了
	$mids3=$mids3.str_replace("{@zxshow." . $mylabel1 . "}", zxshow($mylabel1,$r["classid"],0),$mids);	
	$mids3=str_replace("{@zxshow." . $mylabel2 . "}", zxshow($mylabel2,$r["classid"],0),$mids3);
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$r["classid"],$mids3);
	}
}elseif($channel=="special"){
	if ($b<>""){//父类不为空，调出的classid为小类
	$mids3=$mids3.str_replace("{@specialshow." . $mylabel1 . "}", specialshow($mylabel1,$b,$r["classname"]),$mids);//注意这里用首次替换已把$mids赋值给$mids3了，	
	$mids3=str_replace("{@specialshow." . $mylabel2 . "}", specialshow($mylabel2,$b,$r["classname"]),$mids3);//这里替换$mids3里的内容
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$b,$mids3);
	$mids3=str_replace("{#smallclassid}",$r["classid"],$mids3);
	}else{//父类为空，只调出的为大类就行了
	$mids3=$mids3.str_replace("{@specialshow." . $mylabel1 . "}", specialshow($mylabel1,$r["classid"],0),$mids);	
	$mids3=str_replace("{@specialshow." . $mylabel2 . "}", specialshow($mylabel2,$r["classid"],0),$mids3);
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$r["classid"],$mids3);
	}
}elseif($channel=="ask"){
	if ($b<>""){//父类不为空，调出的classid为小类
	$mids3=$mids3.str_replace("{@askshow." . $mylabel1 . "}", askshow($mylabel1,$b,$r["classname"]),$mids);//注意这里用首次替换已把$mids赋值给$mids3了，	
	$mids3=str_replace("{@askshow." . $mylabel2 . "}", askshow($mylabel2,$b,$r["classname"]),$mids3);//这里替换$mids3里的内容
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$b,$mids3);
	$mids3=str_replace("{#smallclassid}",$r["classid"],$mids3);
	}else{//父类为空，只调出的为大类就行了
	$mids3=$mids3.str_replace("{@askshow." . $mylabel1 . "}", askshow($mylabel1,$r["classid"],0),$mids);	
	$mids3=str_replace("{@askshow." . $mylabel2 . "}", askshow($mylabel2,$r["classid"],0),$mids3);
	$mids3=str_replace("{#classname}",$r["classname"],$mids3);
	$mids3=str_replace("{#bigclassid}",$r["classid"],$mids3);
	}
}
$mids3=str_replace("{#i}", $i,$mids3);//类别标签中序号用i，内容标签中用n,以区别开，这样在内容标签中可以调用i
	if ($row <> "" && $row >0){
		if ($i % $row == 0) {$mids3 = $mids3 . "</tr>";}
	}
$i = $i + 1;
}
$str = $start.$mids3 . $ends;
}
return $str;
}
}

function zsshow($labelname,$classid){
global $siteskin,$province,$provincezm;//取外部值，供演示模板，手机模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){$fpath=zzcmsroot."cache/".$siteskin."/zs/".$classid."-".$labelname.".txt";
}elseif($provincezm<>''){$fpath=zzcmsroot."cache/".$siteskin."/zs/".$provincezm."-".$labelname.".txt";
}else{$fpath=zzcmsroot."cache/".$siteskin."/zs/".$labelname.".txt";}

if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/zsshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zsshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
$bigclassid=$f[1];
	if ($classid <> "") {//不为空的情况是嵌套在zsclass中时，接收的大类值。
	$bigclassid = $classid; //使大类值等于接收到的值
	$smallclassid = "empty"; //以下有条件判断，此处必设值
	}else{
	$bigclassid =$f[1];$smallclassid = $f[2];
	}
$groupid =$f[3];$pic =$f[4];$flv =$f[5];$elite = $f[6];$numbers = $f[7];$orderby =$f[8];$titlenum = $f[9];$row = $f[10];$start =$f[11];$mids = $f[12];
$mids = str_replace("show.php?id={#id}", "/zs/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/zs/show.php?id={#id}", "/zs/show-{#id}.htm",$mids);}
$ends = $f[13];
$sql = "select id,proname,bigclasszm,prouse,shuxing_value,sendtime,img,flv,hit,city,editor from zzcms_main where passed=1 ";
	if ( $bigclassid <> "empty") {$sql = $sql . " and bigclasszm='" . $bigclassid . "'";}
	if ( $smallclassid <> "empty") {$sql = $sql . " and smallclasszm='" . $smallclassid . "'";}
	if ( $groupid <> 0) {$sql = $sql . " and groupid>=$groupid ";}    
	if ( $pic == 1) {$sql = $sql . " and img is not null and img<>'/image/nopic.gif'";}
	if ( $flv == 1) {$sql = $sql . " and flv is not null and flv<>'' ";} 	    
	if ( $elite == 1) {$sql = $sql . " and elite>0";}
	if ( $province != '') {$sql = $sql . " and province='$province'";}
	if ( $orderby == "hit") {$sql = $sql . " order by hit desc limit 0,$numbers ";
	}elseif ($orderby == "id") {$sql = $sql . " order by id desc limit 0,$numbers ";
	}elseif ($orderby == "sendtime") {$sql = $sql . " order by sendtime desc limit 0,$numbers ";
	}elseif ($orderby == "rand") {
	$sqln="select count(*) as total from zzcms_main where passed<>0 ";
	$rsn=query($sqln);
	$rown = fetch_array($rsn);
	$totlenum = $rown['total'];
		if (!$totlenum){
		$shuijishu=0;
		}else{
		$shuijishu=rand(1,$totlenum-$numbers);
		if ($shuijishu<0){$shuijishu=0;}
		}
	$sql = $sql . " limit $shuijishu,$numbers";
	}
//echo $sql;
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao=1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
$mids2 = $mids2 . str_replace("{#hit}", $r["hit"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#imgbig}",$r["img"],str_replace("{#img}",getsmallimg($r["img"]),str_replace("{#id}", $r["id"],str_replace("{#proname}",cutstr($r["proname"],$titlenum),$mids)))))));
	$mids2 =str_replace("{#prouse}", cutstr($r["prouse"],$titlenum*5),$mids2);
	$mids2 =str_replace("{#flv}", $r["flv"],$mids2);
	$mids2 =str_replace("{#city}", $r["city"],$mids2);
	
	$shuxing_value = explode("|||",$r["shuxing_value"]);
	for ($a=0; $a< count($shuxing_value);$a++){
	$mids2=str_replace("{#shuxing".$a."}",$shuxing_value[$a],$mids2);
	}
	
	$mids2 =str_replace("{#bigclasszm}", $r["bigclasszm"],$mids2);//如排行页用来区分不同类别
	//$mids2 =str_replace("{#tz}", $r["tz"],$mids2);
	if ($n==1){$mids2=str_replace("display:none","",$mids2);}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row >0) {//所有模板中以<ul>为布局的默认值都设为了1,最好还是设为0 ,即默认0时不分列，这里改为>0,布局table时1就能生效了。
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
writecache("zs",$classid,$labelname,$str);
}	
return $str;
}//end if file_exists($fpath)==true
}//end if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time)
}

function ppshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/pp/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/pp/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/ppshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/ppshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$bigclassid=$f[1];
	if ($classid <> "") {//不为空的情况是嵌套在zsclass中时，接收的大类值。
	$bigclassid = $classid; //使大类值等于接收到的值
	$smallclassid = "empty"; //以下有条件判断，此处必设值
	}else{
	$bigclassid =$f[1];
	$smallclassid = $f[2];
	}
$pic =$f[3];$numbers = $f[4];$orderby =$f[5];$titlenum = $f[6];$row = $f[7];$start =$f[8];$mids = $f[9];
$mids = str_replace("show.php?id={#id}", "/pp/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/pp/show.php?id={#id}", "/pp/show-{#id}.htm",$mids);}
$ends = $f[10];
$sql = "select id,ppname,sendtime,img,hit,editor from zzcms_pp where passed=1 ";
	if ( $bigclassid <> "empty") {$sql = $sql . " and bigclasszm='" . $bigclassid . "'";}
	if ( $smallclassid <> "empty") {$sql = $sql . " and smallclasszm='" . $smallclassid . "'";}
	if ( $pic == 1) {$sql = $sql . " and img is not null and img<>'/image/nopic.gif'";}
	if ( $orderby == "hit") {$sql = $sql . " order by hit desc limit 0,$numbers ";
	}elseif ($orderby == "id") {$sql = $sql . " order by id desc limit 0,$numbers ";
	}elseif ($orderby == "sendtime") {$sql = $sql . " order by sendtime desc limit 0,$numbers ";
	}elseif ($orderby == "rand") {
	$sqln="select count(*) as total from zzcms_pp where passed<>0 ";
	$rsn=query($sqln);
	$rown = fetch_array($rsn);
	$totlenum = $rown['total'];
	if (!$totlenum){$shuijishu=0;}else{$shuijishu=rand(1,$totlenum-$numbers);}
	$sql = $sql . " limit $shuijishu,$numbers";
	}
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao=1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#hit}", $r["hit"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#imgbig}",$r["img"],str_replace("{#img}",getsmallimg($r["img"]),str_replace("{#id}", $r["id"],str_replace("{#title}",cutstr($r["ppname"],$titlenum),$mids)))))));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row > 0) {//所有模板中以<ul>为布局的默认值都设为了1,最好还是设为0 ,即默认0时不分列，这里改为>0,布局table时1就能生效了。
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
writecache("pp",$classid,$labelname,$str);	
}	
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function jobshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/job/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/job/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/jobshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/jobshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$bigclassid=$f[1];
	if ($classid <> "") {//不为空的情况是嵌套在zsclass中时，接收的大类值。
	$bigclassid = $classid; //使大类值等于接收到的值
	$smallclassid = "empty"; //以下有条件判断，此处必设值
	}else{
	$bigclassid =$f[1];
	$smallclassid = $f[2];
	}
$numbers = $f[3];$orderby =$f[4];$titlenum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("show.php?id={#id}", "/job/show.php?id={#id}",$mids);
	if (whtml == "Yes") {
	$mids = str_replace("/job/show.php?id={#id}", "/job/show-{#id}.htm",$mids);
	}
$ends = $f[9];
$sql = "select * from zzcms_job where passed=1 ";
	if ( $bigclassid <> "empty") {$sql = $sql . " and bigclassid='" . $bigclassid . "'";}
	if ( $smallclassid <> "empty") {$sql = $sql . " and smallclassid='" . $smallclassid . "'";}
	if ( $orderby == "hit") {$sql = $sql . " order by hit desc limit 0,$numbers ";
	}elseif ($orderby == "id") {$sql = $sql . " order by id desc limit 0,$numbers ";
	}elseif ($orderby == "sendtime") {$sql = $sql . " order by sendtime desc limit 0,$numbers ";
	}elseif ($orderby == "rand") {
	$rs=query($sql);
	$r=num_rows($rs);
	if (!$r){$shuijishu=0;}else{$shuijishu=rand(1,$r-$numbers);}
	$sql = $sql . " limit $shuijishu,$numbers";
	}
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao=1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#province}", $r["province"],str_replace("{#city}", $r["city"],str_replace("{#hit}", $r["hit"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#comane}",$r["comane"],str_replace("{#id}", $r["id"],str_replace("{#title}",cutstr($r["jobname"],$titlenum),$mids))))))));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row > 0) {//所有模板中以<ul>为布局的默认值都设为了1,最好还是设为0 ,即默认0时不分列，这里改为>0,布局table时1就能生效了。
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
writecache("job",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function dlshow($labelname,$classid){
global $siteskin,$province,$provincezm;//取外部值，供演示模板用,$province在area/show.php中已被转成了汉字，所以加了$provincezm
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/dl/".$classid."-".$labelname.".txt";
}elseif($provincezm<>''){
$fpath=zzcmsroot."/cache/".$siteskin."/dl/".$provincezm."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/dl/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/dlshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/dlshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> "") {
$b = $classid;
}else{
$b = $f[1];
}
$saver = $f[2];$numbers = $f[3];$orderby =$f[4];$titlenum = $f[5];$column = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("show.php?id={#id}", "/dl/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/dl/show.php?id={#id}", "/dl/show-{#id}.htm",$mids);}
$ends = $f[9];

if ( $b <> "empty") {
$sql="select count(*) as total from zzcms_dl_".$b." where passed<>0 ";
}else{
$sql="select count(*) as total from zzcms_dl where passed<>0 ";	
}
$sql2='';
	if ($saver==1){$sql2 = $sql2 . " and saver is not null ";}
	if ( $province !='') {$sql2 = $sql2 . " and province='$province' ";}
	if ( $orderby == "hit") {$sql3 = " order by hit desc";
	}elseif ($orderby == "id") {$sql3 = " order by id desc";
	}elseif ($orderby == "sendtime") {$sql3 = " order by sendtime desc";}
	$sql4 = " limit 0,$numbers ";	

$rs = query($sql.$sql2.$sql4);
//echo  $sql.$sql2.$sql4;
$row = fetch_array($rs);
$totlenum = $row['total'];
if ( $b <> "empty") {
$sql = "select id,dlid,cp,sendtime,editor,dlsname,city,saver,tel from zzcms_dl_".$b." where passed<>0 ";
}else{
$sql = "select id,cp,sendtime,editor,dlsname,city,saver,tel from zzcms_dl where passed<>0 ";
}
$rs=query($sql.$sql2.$sql3.$sql4);
//echo $sql.$sql2.$sql3.$sql4;
if (!$totlenum){
$str="暂无信息";
}else{
$xuhao = 1;$n = 1;$mids2='';
while($row=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#name}", $row["dlsname"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($row['sendtime'])),str_replace("{#cp}",cutstr($row["cp"],$titlenum),$mids))));
	if ( $b <> "empty") {
	$mids2=str_replace("{#id}",$row['dlid'],$mids2);
	}else{
	$mids2=str_replace("{#id}",$row['id'],$mids2);
	}
	$mids2=str_replace("{#mobile}",str_replace(substr($row['tel'],3,4),"****",$row['tel']),$mids2);
	if (strpos($mids,'{#companyname}')!==false || strpos($mids,'{#companyimg}')!==false || strpos($mids,'{#companyimgbig}')!==false){
		$sqln = "select id,username,img,comane from zzcms_user where username='".$row['saver']."' ";
		$rsn=query($sqln);
		$rown= num_rows($rsn);//返回记录数
		if ($rown){
		$rown=fetch_array($rsn);
		if (sdomain=="Yes"){$mids2= str_replace("{#zturl}","http://".$rown['username'].".".substr(siteurl,strpos(siteurl,".")+1),$mids2);}
		if (whtml == "Yes") {$mids2 = str_replace("{#zturl}","/zt/show-".$rown['id'].".htm",$mids2);}//需要从company目录转到zt}
		$mids2 = str_replace("{#zturl}","/zt/show.php?id=".$rown['id'],$mids2);//需要从company目录转到zt
		
		$companyname_long=strbetween($mids2,"{#companyname:","}");
		if ($companyname_long!=''){
		$mids2 =str_replace("{#companyname:".$companyname_long."}",cutstr($rown['comane'],$companyname_long),$mids2) ;
		}else{
		$mids2=str_replace("{#companyname}",$rown['comane'],$mids2);
		}
		$mids2=str_replace("{#companyimg}", getsmallimg($rown['img']),$mids2);
		$mids2=str_replace("{#companyimgbig}", $rown['img'],$mids2);
		}else{
		$mids2=str_replace("{#companyname}",'意向公司用户已不存在',$mids2);//不存在时加提示
		}
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<a class=xuhao1>".addzero($xuhao,2)."</a>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<a class=xuhao2>".addzero($xuhao,2)."</a>",$mids2);
	}
	$mids2=str_replace("{#city}", cutstr($row["city"],$titlenum),$mids2);
	if ( $column <> "" && $column >0) {
		if ( $n % $column == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}//end if (!$totlenum)
if (cache_update_time!=0){
writecache("dl",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function baojiashow($labelname,$classid){
global $siteskin,$province,$provincezm;//取外部值，供演示模板用,$province在area/show.php中已被转成了汉字，所以加了$provincezm
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/baojia/".$classid."-".$labelname.".txt";
}elseif($provincezm<>''){
$fpath=zzcmsroot."/cache/".$siteskin."/baojia/".$provincezm."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/baojia/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/baojiashow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/baojiashow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> "") {
$b = $classid;
}else{
$b = $f[1];
}
$numbers = $f[2];$orderby =$f[3];$titlenum = $f[4];$column = $f[5];$start =$f[6];$mids = $f[7];
$mids = str_replace("show.php?id={#id}", "/baojia/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/baojia/show.php?id={#id}", "/baojia/show-{#id}.htm",$mids);}
$ends = $f[8];

$sql="select count(*) as total from zzcms_baojia where passed<>0 ";	
$sql2='';
	if ( $province !='') {$sql2 = $sql2 . " and province='$province' ";}
	if ( $b !='empty') {$sql2 = $sql2 . " and classzm='$b' ";}
	if ( $orderby == "hit") {$sql3 = " order by hit desc";
	}elseif ($orderby == "id") {$sql3 = " order by id desc";
	}elseif ($orderby == "sendtime") {$sql3 = " order by sendtime desc";}
	$sql4 = " limit 0,$numbers ";	

$rs = query($sql.$sql2.$sql4);
//echo  $sql.$sql2.$sql4."<br>";
$row = fetch_array($rs);
$totlenum = $row['total'];

$sql = "select id,cp,sendtime,editor,truename,city,price,danwei,tel from zzcms_baojia where passed<>0 ";
$rs=query($sql.$sql2.$sql3.$sql4);
//echo $sql.$sql2.$sql3.$sql4;
if (!$totlenum){
$str="暂无信息";
}else{
$xuhao = 1;$n = 1;$mids2='';
while($row=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#name}", $row["truename"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($row['sendtime'])),str_replace("{#cp}",cutstr($row["cp"],$titlenum),$mids))));
	$mids2=str_replace("{#id}",$row['id'],$mids2);
	$mids2=str_replace("{#price}",$row['price'],$mids2);
	$mids2=str_replace("{#danwei}",$row['danwei'],$mids2);
	$mids2=str_replace("{#mobile}",str_replace(substr($row['tel'],3,4),"****",$row['tel']),$mids2);
	
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<a class=xuhao1>".addzero($xuhao,2)."</a>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<a class=xuhao2>".addzero($xuhao,2)."</a>",$mids2);
	}
	$mids2=str_replace("{#city}", cutstr($row["city"],$titlenum),$mids2);
	if ( $column <> "" && $column >0) {
		if ( $n % $column == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}//end if (!$totlenum)
if (cache_update_time!=0){
writecache("baojia",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function guestbookshow($labelname){
global $siteskin;
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/cache/".$siteskin."/guestbook/".$labelname.".txt";
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/guestbookshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/guestbookshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
$numbers = $f[1];$titlenum = $f[2];$column = $f[3];$start =$f[4];$mids = $f[5];
$ends = $f[6];
$sql="select count(*) as total from zzcms_guestbook where passed<>0 ";	
$sql2 = " order by id desc";
$sql3 = " limit 0,$numbers ";	

$rs = query($sql); 
$row = fetch_array($rs);
$totlenum = $row['total'];

$sql = "select id,title,content,sendtime,linkmen,phone,email,saver from zzcms_guestbook where passed<>0 ";
$rs=query($sql.$sql2.$sql3);
//echo $sql.$sql2.$sql3;
if (!$totlenum){
$str="暂无信息";
}else{
$xuhao = 1;$n = 1;$mids2='';
while($row=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#name}", $row["linkmen"],str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($row['sendtime'])),str_replace("{#id}", $row["id"],str_replace("{#content}",cutstr($row["content"],$titlenum),$mids)))));
	$mids2=str_replace("{#mobile}",str_replace(substr($row['phone'],3,4),"****",$row['phone']),$mids2);
	if (strpos($mids,'{#companyname}')!==false || strpos($mids,'{#companyimg}')!==false){
	$sqln = "select id,username,img,comane from zzcms_user where username='".$row['saver']."' ";
	$rsn=query($sqln);
	$rown= num_rows($rsn);//返回记录数
	if ($rown){
	$rown=fetch_array($rsn);
	if (sdomain=="Yes"){$mids2= str_replace("{#zturl}","http://".$rown['username'].".".substr(siteurl,strpos(siteurl,".")+1),$mids2);}//
	if (whtml == "Yes") {$mids2 = str_replace("{#zturl}","/zt/show-".$rown['id'].".htm",$mids2);}//需要从company目录转到zt}
	$mids2 = str_replace("{#zturl}","/zt/show.php?id=".$rown['id'],$mids2);//需要从company目录转到zt
	
	$companyname_long=strbetween($mids2,"{#companyname:","}");
	if ($companyname_long!=''){
	$mids2 =str_replace("{#companyname:".$companyname_long."}",cutstr($rown['comane'],$companyname_long),$mids2) ;
	}else{
	$mids2=str_replace("{#companyname}",$rown['comane'],$mids2);
	}

	$mids2=str_replace("{#companyimg}", $rown['img'],$mids2);
	}
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<a class=xuhao1>".addzero($xuhao,2)."</a>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<a class=xuhao2>".addzero($xuhao,2)."</a>",$mids2);
	}
	
	if ( $column <> "" && $column >0) {
		if ( $n % $column == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}//end if (!$totlenum)
if (cache_update_time!=0){
writecache("guestbook",'',$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function companyshow($labelname,$classid){
global $siteskin,$province,$provincezm;//取外部值，供演示模板用;$province,目前就用在了area/show.php中
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."cache/".$siteskin."/company/".$classid."-".$labelname.".txt";
}elseif($provincezm<>''){
$fpath=zzcmsroot."cache/".$siteskin."/company/".$provincezm."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."cache/".$siteskin."/company/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/companyshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/companyshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> ""){$bigclassid = $classid;}else{$bigclassid =$f[1];}
$groupid = $f[2];$pic =$f[3];$flv =$f[4];$elite = $f[5];$numbers = $f[6];$orderby =$f[7];$titlenum = $f[8];$row = $f[9];$start =$f[10];$mids = $f[11];
	if (sdomain=="Yes"){$mids= str_replace("show.php?id={#id}","http://{#username}.".substr(siteurl,strpos(siteurl,".")+1),$mids);}
	$mids = str_replace("show.php?id={#id}", "/zt/show.php?id={#id}",$mids);//需要从company目录转到zt,注意顺序这个要放在上面
	if (whtml == "Yes") {$mids = str_replace("/zt/show.php?id={#id}", "/zt/show-{#id}.htm",$mids);}
$ends = $f[12];
$sql = "select id,comane,regdate,img,flv,content,username from zzcms_user  where passed=1 and usersf='公司' and comane<>'' and lockuser=0";
	if ($bigclassid<> 0){$sql =$sql . " and bigclassid=" . $bigclassid . "";}
    if ($groupid <> 0) {$sql = $sql . " and groupid=" . $groupid . "";}
    if ($pic == 1) {$sql = $sql . " and img is not null and img <>'' and img <> '/image/nopic.gif' ";}
	if ($flv == 1) {$sql = $sql . " and flv is not null and flv <>'' ";}
    if ($elite == 1){$sql = $sql . " and elite>0 ";}
    if ($province <>''){$sql = $sql . " and province='$province' ";}
	if ( $orderby == "id") {$sql = $sql . " order by id desc";
	}elseif ($orderby == "lastlogintime") {$sql = $sql . " order by lastlogintime desc";}
	$sql = $sql . " limit 0,$numbers ";
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao = 1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#sendtime}", $r["regdate"],str_replace("{#content}", cutstr(nohtml($r["content"]),$titlenum*4),str_replace("{#imgbig}",$r["img"],str_replace("{#img}",getsmallimg($r["img"]),str_replace("{#title}",cutstr($r["comane"],$titlenum),$mids)))));
	$mids2 =str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#username}", $r["username"],$mids2);
	$mids2=str_replace("{#flv}", $r["flv"],$mids2);
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
writecache("company",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function zhshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/zh/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/zh/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/zhshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zhshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> ""){$bigclassid = $classid;}else{$bigclassid = $f[1];}
$elite = $f[2];$numbers = $f[3];$orderby =$f[4];$titlenum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("show.php?id={#id}", "/zh/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/zh/show.php?id={#id}", "/zh/show-{#id}.htm",$mids);}
$ends = $f[9];
$sql = "select id,title,sendtime,timestart,timeend,address,editor,elite from zzcms_zh where passed=1 ";
	if ($bigclassid <> 0) {$sql = $sql . " and bigclassid=" . $bigclassid . "";}	
	$sql = $sql . " order by elite desc,";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "sendtime") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao =1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#address}", cutstr($r["address"],$titlenum),str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#timestart}", date("Y-m-d",strtotime($r["timestart"])),str_replace("{#timeend}",date("Y-m-d",strtotime($r["timeend"])) ,str_replace("{#id}", $r["id"],$mids))))));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($r["elite"]>0){
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum)."<img alt='置顶' src='/image/ding.gif' border='0'>",$mids2);
	}else{
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	}
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	writecache("zh",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function wangkanshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
if ($classid!='empty' && $classid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/wangkan/".$classid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/wangkan/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/wangkanshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/wangkanshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid <> ""){$bigclassid = $classid;}else{$bigclassid = $f[1];}
$elite = $f[2];$numbers = $f[3];$orderby =$f[4];$titlenum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("show.php?id={#id}", "/wangkan/show.php?id={#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/wangkan/show.php?id={#id}", "/wangkan/show-{#id}.htm",$mids);}
$ends = $f[9];
$sql = "select id,title,img,sendtime,hit,editor,elite from zzcms_wangkan where passed=1 ";
	if ($bigclassid <> 0) {$sql = $sql . " and bigclassid=" . $bigclassid . "";}	
	$sql = $sql . " order by elite desc,";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "sendtime") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$xuhao =1;$n = 1;$mids2='';
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#n}", $n,str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),str_replace("{#id}", $r["id"],$mids)));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($r["elite"]>0){
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum)."<img alt='置顶' src='/image/ding.gif' border='0'>",$mids2);
	}else{
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	}
	$mids2=str_replace("{#imgbig}",$r["img"],$mids2);
	$mids2=str_replace("{#img}",getsmallimg($r["img"]),$mids2);
	$mids2=str_replace("{#hit}",$r["hit"],$mids2);
	if ( $row <> "" && $row > 0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	writecache("wangkan",$classid,$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function zxshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用,这里的$b为了接收zsclass下大类值
if (!$siteskin){$siteskin=siteskin;}
if ($sid!=0){
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$bid."-".$sid."-".$labelname.".txt";
}elseif ($bid!='empty' && $bid!=''){
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$bid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/".$siteskin."/zx/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/zxshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/zxshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($bid <> "") {$bid = $bid;}else{$bid= $f[1];}
if ($sid <> 0) {$sid = $sid;}else{$sid = $f[2];}
$pic =$f[3];$elite = $f[4];$numbers = $f[5];$orderby =$f[6];$titlenum = $f[7];$cnum = $f[8];$row = $f[9];$start =$f[10];$mids = $f[11];
$mids = str_replace("show.php?id={#id}", "/zx/show.php?id={#id}",$mids);
	if (whtml == "Yes") {
	$mids = str_replace("/zx/show.php?id={#id}", "/zx/show-{#id}.htm",$mids);
	$mids = str_replace("/zx/zx.php?b={#bigclassid}&s={#smallclassid}","/zx/{#bigclassid}/{#smallclassid}",$mids);
	$mids = str_replace("/zx/zx.php?b={#bigclassid}","/zx/{#bigclassid}",$mids);
	}
$ends = $f[12];
$sql = "select id,bigclassid,bigclassname,smallclassid,smallclassname,title,link,sendtime,img,editor,hit,content,elite from zzcms_zx where passed=1 ";
if ($b<>'' && is_numeric($b)==false){//接收的zsclass大类值
	$sql2="select classname from zzcms_zsclass where classzm='".$b."'";
	$rs2=query($sql2);
	$row2=fetch_array($rs2);
	$classname='';
	if ($row2){
	$classname=$row2["classname"];
	}
	$bid = $classname;//大类用外部的值，把类别字母转换为类别名称
 	$sql = $sql . " and bigclassname='".$bid."' ";
	if ($sid<>'empty'){
	$sql = $sql . " and smallclassid='".$sid."' ";//小类不为空时，调用小类，用于zsclass下显示同名大类资讯下的小类资讯
	}
}else{
	if ($bid == 0) {//当大类为0时，取所有显示大类的信息
	$sql = $sql . "and bigclassid in (select classid from zzcms_zxclass where isshowininfo=1 and parentid=0) ";
	}else{
    	if ($bid <> 0) {$sql = $sql . " and bigclassid=".$bid."";}
    	if ($sid <> 0) {$sql = $sql . " and smallclassid=".$sid."";}
	}
}	
 	if ($pic == 1) {$sql = $sql . " and img is not null and img <>''";}
    if ($elite == 1){$sql = $sql . " and elite>0";}
	//$sql = $sql . " order by elite desc,";
	$sql = $sql . " order by ";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;$xuhao = 1;$mids2='';
while($r=fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids)); 
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($r["link"]<>''){//当为外链时
		if (whtml=="Yes"){
		$mids2=str_replace("/zx/show-{#id}.htm", addhttp($r["link"]),$mids2);
		}else{
		$mids2=str_replace("/zx/show.php?id={#id}",addhttp($r["link"]),$mids2);
		}
	}
	$mids2=str_replace("{#bigclassname}", $r["bigclassname"],str_replace("{#bigclassid}", $r["bigclassid"],$mids2));
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	$mids2=str_replace("{#smallclassid}", $r["smallclassid"],$mids2);
	$mids2=str_replace("{#smallclassname}", $r["smallclassname"],$mids2);
	$mids2=str_replace("{#hit}", $r["hit"],$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	//if ($r["elite"]>0){
	//$mids2 =str_replace("{#title}" ,cutstr($r["title"],$titlenum)."<img alt='置顶' src='/image/ding.gif' border='0'>",$mids2) ;
	//}else{
	//$mids2 =str_replace("{#title}" ,cutstr($r["title"],$titlenum),$mids2) ;
	//}
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	if ($sid!=0){
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$bid."-".$sid."-".$labelname.".txt";
	}elseif ($bid!='empty' && $bid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$bid."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/zx/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/zx")) {mkdir(zzcmsroot."cache/".$siteskin."/zx",0777,true);}
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function specialshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用,这里的$b为了接收zsclass下大类值
if (!$siteskin){$siteskin=siteskin;}
if ($sid!=0){
$fpath=zzcmsroot."/cache/special/".$bid."-".$sid."-".$labelname.".txt";
}elseif ($bid!='empty' && $bid!=''){
$fpath=zzcmsroot."/cache/special/".$bid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/special/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/specialshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/specialshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($b){//自动获取外部大类值的情况
$bid = $b;//大类用外部的值
if ($sid<>''){$sid = $sid;}else{$sid = $f[2];}//小类用指定的类别名，自动根据大类参数调用相应大类下的小类，小类名要相同
}elseif($bid<>0){//嵌套在ztclass内的情况
$bid=$bid;
}else{//直接使用标签内的值
$bid = $f[1];$sid = $f[2];
}
$pic =$f[3];$elite = $f[4];$numbers = $f[5];$orderby =$f[6];$titlenum = $f[7];$cnum = $f[8];$row = $f[9];$start =$f[10];$mids = $f[11];
$mids = str_replace("show.php?id={#id}", "/special/show.php?id={#id}",$mids);
	if (whtml == "Yes") {
	$mids = str_replace("/special/show.php?id={#id}", "/special/show-{#id}.htm",$mids);
	$mids = str_replace("class.php?b={#bigclassid}","/special/class/{#bigclassid}",$mids);
	$mids = str_replace("special.php?b={#bigclassid}&s={#smallclassid}","/special/{#bigclassid}/{#smallclassid}",$mids);
	$mids = str_replace("special.php?b={#bigclassid}","/special/{#bigclassid}",$mids);
	}
$ends = $f[12];
$sql = "select id,bigclassid,bigclassname,smallclassid,smallclassname,title,link,sendtime,img,editor,hit,content,elite from zzcms_special where passed=1 ";
	if ($bid == 0) {//当大类为0时，取所有显示大类,小类的信息
	$sql = $sql . "and bigclassid in (select classid from zzcms_specialclass where isshowininfo=1)  ";
	}else{
    	if ($bid <> 0) {$sql = $sql . " and bigclassid=".$bid."";}
    	if ($sid <> '' && $sid <>'empty') {//这里是按小类名取值的，显示不同大类，但小类名相同的信息，如按ID不能达到这种效果，原理同广告调用。
    	$sql = $sql . " and smallclassname='".$sid."'";
		}
	}
 	if ($pic == 1) {$sql = $sql . " and img is not null and img <>''";}
    if ($elite == 1){$sql = $sql . " and elite>0";}
	$sql = $sql . " order by ";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;$xuhao = 1;$mids2='';
while($r=fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids));  
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ($r["link"]<>''){//当为外链时
		if (whtml=="Yes"){
		$mids2=str_replace("/special/show-{#id}.htm",$r["link"],$mids2);
		}else{
		$mids2=str_replace("/special/show.php?id={#id}",$r["link"],$mids2);
		}
	}
	$mids2=str_replace("{#bigclassname}", $r["bigclassname"],str_replace("{#bigclassid}", $r["bigclassid"],$mids2));
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	$mids2=str_replace("{#smallclassid}", $r["smallclassid"],$mids2);
	$mids2=str_replace("{#smallclassname}", $r["smallclassname"],$mids2);
	$mids2=str_replace("{#hit}", $r["hit"],$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	if ($sid!=0){
	$fpath=zzcmsroot."cache/".$siteskin."/special/".$bid."-".$sid."-".$labelname.".txt";
	}elseif ($bid!='empty' && $bid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/special/".$bid."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/special/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/special")) {mkdir(zzcmsroot."cache/".$siteskin."/special",0777,true);}
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function askshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用,这里的$b为了接收zsclass下大类值
if (!$siteskin){$siteskin=siteskin;}
if ($sid!=0){
$fpath=zzcmsroot."/cache/ask/".$bid."-".$sid."-".$labelname.".txt";
}elseif ($bid!='empty' && $bid!=''){
$fpath=zzcmsroot."/cache/ask/".$bid."-".$labelname.".txt";
}else{
$fpath=zzcmsroot."/cache/ask/".$labelname.".txt";
}
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."/template/".$siteskin."/label/askshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/askshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($b){//自动获取外部大类值的情况
$bid = $b;//大类用外部的值
if ($sid<>''){$sid = $sid;}else{$sid = $f[2];}//小类用指定的类别名，自动根据大类参数调用相应大类下的小类，小类名要相同
}elseif($bid<>0){//嵌套在ztclass内的情况
$bid=$bid;
}else{//直接使用标签内的值
$bid = $f[1];$sid = $f[2];
}
$pic =$f[3];$elite = $f[4];$typeid = $f[5];$numbers = $f[6];$orderby =$f[7];$titlenum = $f[8];$cnum = $f[9];$row = $f[10];$start =$f[11];$mids = $f[12];
$mids = str_replace("show.php?id={#id}", "/ask/show.php?id={#id}",$mids);
	if (whtml == "Yes") {
	$mids = str_replace("/ask/show.php?id={#id}", "/ask/show-{#id}.htm",$mids);
	$mids = str_replace("class.php?b={#bigclassid}","/ask/class/{#bigclassid}",$mids);
	$mids = str_replace("ask.php?b={#bigclassid}&s={#smallclassid}","/ask/{#bigclassid}/{#smallclassid}",$mids);
	$mids = str_replace("ask.php?b={#bigclassid}","/ask/{#bigclassid}",$mids);
	}
$ends = $f[13];
$sql = "select * from zzcms_ask where passed=1 ";
	if ($bid == 0) {//当大类为0时，取所有显示大类,小类的信息
	$sql = $sql . "and bigclassid in (select classid from zzcms_askclass where isshowininfo=1)  ";
	}else{
    	if ($bid <> 0) {$sql = $sql . " and bigclassid=".$bid."";}
    	if ($sid <> '' && $sid <>'empty') {//这里是按小类名取值的，显示不同大类，但小类名相同的信息，如按ID不能达到这种效果，原理同广告调用。
    	$sql = $sql . " and smallclassname='".$sid."'";
		}
	}
 	if ($pic == 1) {$sql = $sql . " and img is not null and img <>''";}
    if ($elite == 1){$sql = $sql . " and elite>0";}
	if ($typeid != 999){$sql = $sql . " and typeid='".$typeid."' ";}
	$sql = $sql . " order by ";
	if ( $orderby == "hit") {$sql = $sql . "hit desc";
	}elseif ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;$xuhao = 1;$mids2='';
while($r=fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids));  
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	
	$mids2=str_replace("{#bigclassname}", $r["bigclassname"],str_replace("{#bigclassid}", $r["bigclassid"],$mids2));
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	$mids2=str_replace("{#smallclassid}", $r["smallclassid"],$mids2);
	$mids2=str_replace("{#smallclassname}", $r["smallclassname"],$mids2);
	$mids2=str_replace("{#hit}", $r["hit"],$mids2);
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	
	$rs_answer_num = query("select count(*) as total from zzcms_answer where about='".$r["id"]."' "); 
	$row_answer_num = fetch_array($rs_answer_num);
	$answer_num = $row_answer_num['total'];
	$mids2=str_replace("{#answer_num}", $answer_num,$mids2);
	
	$zhuangtai_biaozhi='';
	if ($r["typeid"]==1){
	$zhuangtai_biaozhi="<img src='/image/dui2.png' title='已解决'>";
	}elseif ($r["typeid"]==0){
	$zhuangtai_biaozhi="<img src='/image/wenhao.png' title='待解决'>";
	}
	
	$mids2=str_replace("{#zhuangtai}", $zhuangtai_biaozhi,$mids2);
	
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	if ($sid!=0){
	$fpath=zzcmsroot."cache/".$siteskin."/ask/".$bid."-".$sid."-".$labelname.".txt";
	}elseif ($bid!='empty' && $bid!=''){
	$fpath=zzcmsroot."cache/".$siteskin."/ask/".$bid."-".$labelname.".txt";
	}else{
	$fpath=zzcmsroot."cache/".$siteskin."/ask/".$labelname.".txt";
	}
	if (!file_exists(zzcmsroot."cache/".$siteskin."/ask")) {mkdir(zzcmsroot."cache/".$siteskin."/ask",0777,true);}
	$fp=fopen($fpath,"w+");//fopen()的其它开关请参看相关函数
	fputs($fp,stripfxg($str));//写入文件
	fclose($fp);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (file_exists($fpath)!==false)
}

function helpshow($labelname){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/helpshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/helpshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$elite = $f[1];$numbers = $f[2];$orderby =$f[3];$titlenum = $f[4];$cnum = $f[5];$row = $f[6];$start =$f[7];$mids = $f[8];
$mids = str_replace("help.php#{#id}", "/one/help.php#{#id}",$mids);
if (whtml == "Yes") {$mids = str_replace("/one/help.php#{#id}", "/help.htm#{#id}",$mids);}
$ends = $f[9];
$sql = "select id,title,sendtime,img,content,elite from zzcms_help where classid=1";
    if ($elite == 1){$sql = $sql . " and elite>0";}
	$sql = $sql . " order by ";
	if ($orderby == "id") {$sql = $sql . "id desc";
	}elseif ($orderby = "timefororder") {$sql = $sql . "sendtime desc";}
	$sql = $sql . " limit 0,$numbers ";
//echo $sql ."<br>"; 
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$n = 1;$xuhao = 1;$mids2='';
while($r=fetch_array($rs)){
	if ($r["img"] <> ""){
    $mids2=$mids2.str_replace('{#img}',getsmallimg($r["img"]),str_replace("{#imgbig}", $r["img"],$mids)); 
    }else{
    $mids2=$mids2.str_replace("{#img}","",str_replace("{#imgbig}", "",$mids));
	}
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	$mids2=str_replace("{#sendtime}", date("Y-m-d",strtotime($r['sendtime'])),$mids2);
	if ($cnum==0){
	$mids2=str_replace("{#content}",$r["content"],$mids2);
	}else{
	$mids2=str_replace("{#content}", cutstr(nohtml($r["content"]),$cnum),$mids2);
	}
	$mids2=str_replace("{#id}", $r["id"],$mids2);
	$mids2=str_replace("{#n}", $n,$mids2);
	$mids2=str_replace("{#title}",cutstr($r["title"],$titlenum),$mids2);
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function linkshow($labelname,$classid){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/linkshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/linkshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($classid<>""){$bigclassid=$classid;}else{$bigclassid=$f[1];}
$pic =$f[2];$elite = $f[3];$numbers = $f[4];$titlenum = $f[5];$row = $f[6];$start=$f[7];$mids = $f[8];$ends = $f[9];
$sql = "select * from zzcms_link where passed=1 ";
if ($bigclassid <> 0 ){$sql = $sql ." and bigclassid=" . $bigclassid . "";}
if ($pic == 1) {$sql = $sql . " and logo is not null and logo <>''";}
if ($elite == 1){$sql = $sql . " and elite>0";}
$sql = $sql . " limit 0,$numbers ";
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2 ='';$n = 1;$xuhao=1;
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#url}",$r["url"],str_replace("{#logo}", $r["logo"],str_replace("{#sitename}",cutstr($r["sitename"],$titlenum),$mids)));
	if ($n<=3){
	$mids2=str_replace("{#xuhao}", "<font class=xuhao1>".addzero($xuhao,2)."</font>",$mids2);
	}else{
	$mids2=str_replace("{#xuhao}", "<font class=xuhao2>".addzero($xuhao,2)."</font>",$mids2);
	}
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
$xuhao++;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function adclass($labelname){
global $siteskin;
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/adclass/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/adclass/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$b = $f[1];$numbers = $f[2];$row = $f[3];$start = $f[4];$mids = $f[5];$ends = $f[6];
$sql ="select * from zzcms_adclass where  parentid='".$b."' order by xuhao limit 0,$numbers ";
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$i = 1;$mids3='';$mylabel1="";$mylabel2="";
if (count(explode("{@adshow.",$mids))==2) {
	$mylabel1=strbetween($mids,"{@adshow.","}");
}
if (count(explode("{@adshow.",$mids))==3) {
	$mylabel1=strbetween($mids,"{@adshow.","}");
	$mids2 = str_replace("{@adshow." . $mylabel1 . "}", "",$mids); //把第一个标签换空,方可找出第二个标签
	$mylabel2=strbetween($mids2,"{@adshow.","}");
}
//echo $mylabel2;
while($r=fetch_array($rs)){
if ($b<>""){//父类不为空，调出的classid为小类
$mids3=$mids3.str_replace("{@adshow." . $mylabel1 . "}", adshow($mylabel1,$b,$r["classname"]),$mids);//注意这里用首次替换已把$mids赋值给$mids3了，	
$mids3=str_replace("{@adshow." . $mylabel2 . "}", adshow($mylabel2,$b,$r["classname"]),$mids3);//这里替换$mids3里的内容
$mids3=str_replace("{#classname}",$r["classname"],$mids3);
}
//$str=$str . $mids;
	if ($row <> "" && $row > 0){
		if ($i % $row == 0) {$mids3 = $mids3 . "</tr>";}
	}
$i = $i + 1;
}
$str = $start .$mids3. $ends;
}
return $str;
}
}

function adshow($labelname,$bid,$sid){
global $siteskin,$b;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."/template/".$siteskin."/label/adshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/adshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];
if ($b){//自动获取外部大类值的情况
$sql="select classname from zzcms_zsclass where classzm='".$b."'";
$rs=query($sql);
$row=fetch_array($rs);
$classname='';	
	if ($row){
	$classname=$row["classname"];
	}
if ($f[1]=='首页'){
$bid = '首页';//当大类为首页时在所有内页中都显示
}else{
$bid = $classname;//大类用外部的值，把类别字母转换为类别名称
}
$sid = $f[2];//小类用指定的类别名，用户招商分类页，自动根据大类参数调用相应大类下的小类，小类名要相同
}elseif ($bid <> "" && $sid<>""){//套在adclass里面使用时
$bid = $bid;$sid = $sid;
}else{
$bid = $f[1];$sid = $f[2];
}
$numbers = $f[3];$titlenum = $f[4];$row = $f[5];$start =$f[6];$mids = $f[7];$ends = $f[8];
$sql= "select * from zzcms_ad where bigclassname='".$bid."' and smallclassname='".$sid."' ";
if (isshowad_when_timeend=="No"){
$sql=$sql. "and endtime>= '".date('Y-m-d H:i:s')."' ";
}
$sql=$sql. "order by xuhao asc,id asc";
//echo $sql;
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2='';$n = 1;
while($r=fetch_array($rs)){
$mids2 =$mids2 .str_replace("{#link}", $r["link"],str_replace("{#n}", addzero($n,2),str_replace("{#title}",cutstr($r["title"],$titlenum),$mids)));
	$mids2 =str_replace("{#width}",$r["imgwidth"],$mids2);
	$mids2 =str_replace("{#height}",$r["imgheight"],$mids2);
	$mids2 =str_replace("{#titlecolor}",$r["titlecolor"],$mids2);
	if (($n + 4) % 8 == 0 || ($n + 5) % 8 == 0 ||  ($n + 6) % 8 == 0 ||  ($n + 7) % 8 == 0){
	$mids2 =str_replace("{#style}","textad1",$mids2);
	}else{
	$mids2 =str_replace("{#style}","textad2",$mids2);
	}
	if (strpos($labelname,"flash")!==false || strpos($labelname,"Flash")!==false){//没有加新参数，命名时焦点广告名里要有flash
	//焦点flash不支持远程，只能用相对路经，这样才能同时在www.或是没有www.两种域名下显示
	$mids2 = str_replace("{#img}",$r["img"],$mids2);
	}else{
	$mids2 = str_replace("{#img}",siteurl.$r["img"],$mids2);//当展厅开二级域名的情况下，前面必须得加网址
	}
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
}
$str = $start.$mids2.$ends;
}
return $str;
}
}

function aboutshow($labelname){
global $siteskin;//取外部值，供演示模板用
if (!$siteskin){$siteskin=siteskin;}
$fpath=zzcmsroot."cache/".$siteskin."/about/".$labelname.".txt";
if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time){
	return file_get_contents($fpath);
}else{
$fpath=zzcmsroot."template/".$siteskin."/label/aboutshow/".$labelname.".txt";
if (file_exists($fpath)==true){
if (filesize($fpath)<10){ showmsg(zzcmsroot."template/".$siteskin."/label/aboutshow/".$labelname.".txt 内容为空");}//utf-8有文件头，空文件大小为3字节
$fcontent=file_get_contents($fpath);
$f=explode("|||",$fcontent) ;
$title=$f[0];$id=$f[1];$titlenum = $f[2];$contentnum = $f[3];$row = $f[4];$start =$f[5];$mids = $f[6];$ends = $f[7];
$sql = "select * from zzcms_about  ";
if ($id <> 0 ){$sql = $sql ."where id='" . $id . "'";}
$sql = $sql ." order by id asc";
//echo $sql;
$rs=query($sql);
$r=num_rows($rs);
if (!$r){
$str="暂无信息";
}else{
$mids2 ='';
$n = 1;
while($r=fetch_array($rs)){
	$mids2 = $mids2 . str_replace("{#title}",cutstr($r["title"],$titlenum),$mids);
	$mids2=str_replace("{#content}", cutstr($r["content"],$contentnum),$mids2);
	if ( $row <> "" && $row >0) {
		if ( $n % $row == 0) {$mids2 = $mids2 . "</tr>";}
	}
	$mids2 = $mids2 . "\r\n";
$n = $n + 1;
}
$str = $start.$mids2.$ends;
}
if (cache_update_time!=0){
	writecache("about",'',$labelname,$str);
}
return $str;
}//end if file_exists($fpath)==true
}//end if (cache_update_time!=0 && file_exists($fpath)!==false && time()-filemtime($fpath)<3600*24*cache_update_time)
}
?>