<?php
if(!isset($_SESSION)){session_start();} 
set_time_limit(1800) ;
include("inc/config.php");
if (!isset($_COOKIE["UserName"]) && !isset($_SESSION["admin"])){
session_write_close();
echo "<script>alert('登录后才能上传');window.close();</script>";
}
//上传图片的类--------------------------------------------------------------
class upload{
//上传文件类型列表
private $uptypes = array ('image/jpg','image/jpeg','image/pjpeg','image/gif','image/png','image/x-png','image/bmp','application/x-shockwave-flash');
//只要不设定这种类型,php类的文件就无法上传'application/octet-stream'
private $max_file_size = maximgsize; //上传文件大小限制, 单位k
public $fileName; //文件名称
public $fdir ;//上传文件路径
private $watermark = shuiyin; //是否附加水印(yes为加水印,其他为不加水印);
private $waterstring = ''; //水印字符串
private $waterimg=syurl ; //水印图片 png
private $watertype = 2; //水印类型(1为文字,2为图片)
private $imgpreview=1; //是否生成缩略图(1为生成,其他为不生成);
private $sw=120; //缩略图宽度
public $bImg; //大图的全路径
public $sImg; //小图的全路径
public $datu; //大图的命名
function upfile() {
//是否存在文件
if (!is_uploaded_file(@$this->fileName[tmp_name])){
   echo "<script>alert('请点击“浏览”，先选择您要上传的文件！\\n\\n支持的图片类型为：jpg,gif,png,bmp');parent.window.close();</script>"; exit;
}
//检查文件大小
if ($this->max_file_size*1024 < $this->fileName["size"]){
   echo "<script>alert('文件大小超过了限制！最大只能上传 ".$this->max_file_size." K的文件');parent.window.close();</script>";exit;
}
//检查文件类型//这种通过在文件头加GIF89A，可骗过
if (!in_array($this->fileName["type"], $this->uptypes)) {
   echo "<script>alert('文件类型错误，支持的图片类型为：jpg,gif,png,bmp');parent.window.close();</script>";exit;
}
//检查文件后缀
$hzm=strtolower(substr($this->fileName["name"],strpos($this->fileName["name"],".")));//获取.后面的后缀，如可获取到.php.gif
if (strpos($hzm,"php")!==false || strpos($hzm,"asp")!==false ||strpos($hzm,"jsp")!==false){
echo "<script>alert('".$hzm."，这种文件不允许上传');parent.window.close();</script>";exit;
}
//创建文件目录
if (!file_exists($this->fdir)) {mkdir($this->fdir,0777,true);}
//上传文件
$tempName = $this->fileName["tmp_name"];
$fType = pathinfo($this->fileName["name"]);
$fType = $fType["extension"];

$newName =$this->fdir.$this->datu;
$sImgName =$this->fdir.str_replace('.','_small.',$this->datu); 
//echo $newName;
if (!move_uploaded_file($tempName, $newName)) {
   echo "<script>alert('移动文件出错');parent.window.close();</script>"; exit;
}else{
//检查图片属性，不是这几种类型的就不是图片文件,只能上传后才能获取到，代码放到上传前获取不到图片属性，所以放在这里
$data=GetImageSize($newName);//取得GIF、JPEG、PNG或SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
if($data[2]!=1 && $data[2]!=2 && $data[2]!=3 && $data[2]!=6){//4为swf格式
unlink($newName);
echo "<script>alert('经判断上传的文件不是图片文件，已删除。');parent.window.close();</script>";exit;
} 
//是否生成缩略图
$data=GetImageSize($newName);//取得GIF、JPEG、PNG或SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
if($this->imgpreview == 1 && $data[2]!=4){//文件类型不为4，4为swf格式
    switch ($data[2]) {
     case 1 :$sImg = imagecreatefromgif($newName);break;
     case 2 :$sImg = imagecreatefromjpeg($newName);break;
     case 3 :$sImg = imagecreatefrompng($newName);break;
     case 6 :$sImg = imagecreatefromwbmp($newName);break;
     default :echo "<script>alert('不支持的文件类型，无法生成缩略图');parent.window.close();</script>";exit;
    }
//生成小图
if ($data[1]>$data[0]){
$newwidth=$this->sw *($data[0]/$data[1]) ;
$newheight= $this->sw;
}else{
$newwidth=$this->sw;
$newheight=$this->sw*($data[1]/$data[0]) ;
}  
$sImgDate = imagecreatetruecolor($newwidth,$newheight);   
imagecopyresampled($sImgDate,$sImg, 0, 0, 0, 0, $newwidth, $newheight, $data[0],$data[1]);
    switch ($data[2]) {
     case 1 :imagegif($sImgDate, $sImgName);break;
     case 2 :imagejpeg($sImgDate, $sImgName);break;
     case 3 :imagepng($sImgDate, $sImgName);break;
     case 6 :imagewbmp($sImgDate, $sImgName);break;
    }
    imagedestroy($sImgDate);
       imagedestroy($sImg);
    $this->sImg=$sImgName;
}
//是否增加水印
$imginfo = GetImageSize($newName);
if ($this->watermark == 'Yes' && @$_REQUEST["noshuiyin"]!=1 && $imginfo[0]>200 && $imginfo[2]!=3 && $imginfo[2]!=4 && $imginfo[2]!=6) {
   //如上传广告页不能加水印，很小的不加水印,3.png无法加，4.swf不能加,6.bmp无法加
    $nimage = imagecreatetruecolor($imginfo[0], $imginfo[1]);
    $white = imagecolorallocate($nimage, 255, 255, 255);
    $black = imagecolorallocate($nimage, 0, 0, 0);
    $red = imagecolorallocate($nimage, 255, 0, 0);
    imagefill($nimage, 0, 0, $white);
    switch ($imginfo[2]) {
     case 1 :$simage = imagecreatefromgif($newName);break;
     case 2 :$simage = imagecreatefromjpeg($newName);break;
     case 3 :$simage = imagecreatefrompng($newName);break;
     case 6 :$simage = imagecreatefromwbmp($newName);break;
     default :echo "<script>alert('不支持的文件类型，无法加水印');window.close();</script>";exit;
    }
    imagecopy($nimage, $simage, 0, 0, 0, 0, $imginfo[0], $imginfo[1]);
	switch ($this->watertype) {
	case 1 : //加水印字符串
	imagefilledrectangle($nimage, 1, $imginfo[1] - 15, 80, $imginfo[1], $white);
	imagestring($nimage, 2, 3, $imginfo[1] - 15, $this->waterstring, $black);
	break;
	case 2 : //加水印图片
	if (file_exists($this->waterimg)==false){
	echo "<script>alert('水印图片不存在，请联系管理员先设水印图片或关闭水印功能');parent.window.close();</script>";
	exit;
	}
      $simage1 = imagecreatefrompng($this->waterimg);//这里决定水印图片为PNG图片
      $waterImg = getimagesize($this->waterimg);
      //imagecopy($nimage, $simage1, $data[0]-150, $data[1]-50, 0, 0, $waterImg[0], $waterImg[1]);
		if (addimgXY=="right"){
		imagecopy($nimage, $simage1, $data[0]-200, $data[1]-40, 0, 0, $waterImg[0], $waterImg[1]);
		}elseif (addimgXY=="center"){
		imagecopy($nimage, $simage1, $data[0]/2-50, $data[1]/2-20, 0, 0, $waterImg[0], $waterImg[1]); 
		}elseif (addimgXY=="left"){
		imagecopy($nimage, $simage1, 10, 10, 0, 0, $waterImg[0], $waterImg[1]); 
		}
      imagedestroy($simage1);
      break;
   }
    switch ($imginfo[2]) {
     case 1 :imagegif($nimage, $newName,98);break; //98 为打印水印后图片的质量
     case 2 :imagejpeg($nimage, $newName,98);break;
     case 3 :imagepng($nimage, $newName,98);break;
     case 6 :imagewbmp($nimage, $newName,98);break;  
    }
    //覆盖原上传文件
    imagedestroy($nimage);
    imagedestroy($simage);
   }
   $this->bImg=$newName;
}
}
}
//------------------------------------------------------------上传图片类结束--------------
$filename = array();   
for ($i = 0; $i < count($_FILES['g_fu_image']['name']); $i++){ 
$filename[$i]['name']=$_FILES['g_fu_image']['name'][$i];
$filename[$i]['type']=$_FILES['g_fu_image']['type'][$i];
$filename[$i]['tmp_name']=$_FILES['g_fu_image']['tmp_name'][$i];
$filename[$i]['error']=$_FILES['g_fu_image']['error'][$i];
$filename[$i]['size']=$_FILES['g_fu_image']['size'][$i];
}
for ($i = 0; $i < count($filename); $i++){  
$filetype=strtolower(strrchr($filename[$i]['name'],"."));//图片的类型,统一转为小写
$up = new upload();
$up->fileName = $filename[$i];
$up->fdir='uploadfiles/'.date("Y-m").'/';   //上传的路径
$up->datu=date("YmdHis").rand(100,999).$filetype;//大图的命名
$up->upfile();     //上传
$bigimg=$up->fdir.$up->datu;   //返回的大图文件名
	$js="<script language=javascript>";
	if (@$_REQUEST['imgid']==2){//同一页面中有两处上传的
	$js=$js."parent.window.opener.valueFormOpenwindow2('/" . $bigimg ."');";//读取父页面中的JS函数传回值
	}else{
	$js=$js."parent.window.opener.valueFormOpenwindow('/" . $bigimg ."');";//读取父页面中的JS函数传回值
	}
	$js=$js."parent.window.close();";
	$js=$js."</script>";
echo $js;	
} 
?>