<?php
include("../inc/conn.php");

if (isset($_REQUEST["id"])){
$id=trim($_REQUEST["id"]);
checkid($id);
}else{
$id=0;
}

function getImgSrcFromStr($str,$isArray){
preg_match_all('/<img[^>]*src\s*=\s*([\'"]?)([^\'" >]*)\1/isu', $str, $src);
	if ($isArray==true){
	return $src[2];
	}else{
	return @$src[2][0];
	}
}
//在一条记录中上传多张图片建网刊
$sql="select id,title,img,content from zzcms_wangkan where id='$id' and passed=1"; 
$rs = query($sql); 
$row= fetch_array($rs);
if (!$row){
showmsg('不存在相关信息！');
}else{
query("update zzcms_wangkan set hit=hit+1 where id='$id'");
$content=$row["content"];
$title=$row["title"];
$str2=getImgSrcFromStr($row["content"],false);
$large_img_dir=strbetween($str2,"/uploadfiles/","/");//获取大图片所在目录，这里只设一张图，和上传图是同一个目录同一个图片

$pagetitle=$title.wangkanshowtitle;
$pagekeywords=$title.wangkanshowkeyword;
$pagedescription=$title.wangkanshowdescription;
 
//在小类下用多条记录建网刊
/*$str="";
$sql="select id,title,img,content from zzcms_zx where passed=1 and bigclassid=14  and smallclassid=17"; 
$sql=$sql." order by id desc";
$rs = query($sql); 
while($row= fetch_array($rs)){
$str=$str. '"'.$row['img'].'"'.',';
}
$str=substr($str,0,-1);//去最后一个,
echo $str;
*/

//在一条记录中上传多张图片建网刊
$str=getImgSrcFromStr($content,true);//得到的是一个数组
$size=count($str);//取得数组的长度值,在下面有用
$str2="";
foreach($str as $value){
$str2= $str2. '"'.$value.'"'.','. "\r\n";
}
$str2=substr($str2,0,-3);//去最后的  ，\r\n
$pages=$str2;


$str2="";
foreach($str as $key=>$value){
$key=$key+1;
	if ($key==1 || $key==$size){
	$str2= $str2. "[".'"'.$key."版".'"'.','.$key."]".','. "\r\n";
	}else{
		if($key%2==0){
		$str2= $str2. "[".'"'.$key." - ".($key+1)."版".'"'.','.$key."]".','. "\r\n";
		}
	}
}
$str2=substr($str2,0,-3);
$contents=$str2;

$fp="../template/".siteskin."/wkshow.htm";
$f= fopen($fp,'r');
$strout = fread($f,filesize($fp));
fclose($f);
$strout=str_replace("{#siteskin}",siteskin,$strout) ;
$strout=str_replace("{#sitename}",sitename,$strout) ;
$strout=str_replace("{#pagetitle}",$pagetitle,$strout);
$strout=str_replace("{#pagekeywords}",$pagekeywords,$strout);
$strout=str_replace("{#pagedescription}",$pagedescription,$strout);

$strout=str_replace("{#large_img_dir}",$large_img_dir,$strout);
$strout=str_replace("{#pages}",$pages,$strout);
$strout=str_replace("{#contents}",$contents,$strout);
echo  $strout;
}
?>			