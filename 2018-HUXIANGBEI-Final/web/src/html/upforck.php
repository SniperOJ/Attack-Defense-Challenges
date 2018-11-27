<?php
include("inc/config.php");
$config=array();
$config['type']=array("flash","img"); //上传允许type值
$config['img']=array("jpg","jpeg","bmp","gif","png"); //img允许后缀
$config['sw']=120; //小图片宽度
$config['flash_size']=200; //上传flash大小上限 单位：KB
$config['img_size']=maximgsize; //上传img大小上限 单位：KB
$config['message']=""; //上传成功后显示的消息，若为空则不显示
$config['name']=date("YmdHis").rand(100,999); //上传后的文件命名规则 这里以unix时间戳来命名
$config['flash_dir']='/uploadfiles/'.date("Y-m"); //上传文件地址 采用绝对地址 方便upload.php文件放在站内的任何位置 
$config['img_dir']='uploadfiles/'.date("Y-m"); //上传img文件地址 采用绝对地址 采用绝对地址 方便upload.php文件放在站内的任何位置 后面不加"/"
$config['site_url']=""; //网站的网址 这与图片上传后的地址有关 最后不加"/" 可留空

uploadfile();//文件上传

function uploadfile(){
global $config;
//创建文件目录
if (!file_exists($config["img_dir"])) {mkdir($config["img_dir"],0777,true);}
//判断是否是非法调用
if(empty($_GET['CKEditorFuncNum']))
mkhtml(1,"","错误的功能调用请求");
$fn=$_GET['CKEditorFuncNum'];
if(!in_array($_GET['type'],$config['type']))
mkhtml(1,"","错误的文件调用请求");
$type=$_GET['type'];
if(is_uploaded_file($_FILES['upload']['tmp_name'])){
   //判断上传文件是否允许
   $filearr=pathinfo($_FILES['upload']['name']);
   $filetype=strtolower($filearr["extension"]);//后缀统一转换成小写
   if(!in_array($filetype,$config[$type]))
    mkhtml($fn,"","错误的文件类型！");
   //判断文件大小是否符合要求
   if($_FILES['upload']['size']>$config[$type."_size"]*1024)
   mkhtml($fn,"","上传的文件不能超过".$config[$type."_size"]."KB！");
   
//检查文件后缀
$hzm=strtolower(substr($_FILES['upload']['name'],strpos($_FILES['upload']['name'],".")));//获取.后面的后缀，可获取到.php.gif
if (strpos($hzm,"php")!==false || strpos($hzm,"asp")!==false ||strpos($hzm,"jsp")!==false){
mkhtml($fn,"",$hzm.",这种文件不允许上传");
}
  
   $file_abso="/".$config[$type."_dir"]."/".$config['name'].".".$filetype;
   $file_host=$_SERVER['DOCUMENT_ROOT'].$file_abso;
   $sImgName =$_SERVER['DOCUMENT_ROOT'].str_replace('.','_small.',$file_abso); //生成的小图片地址

	if(move_uploaded_file($_FILES['upload']['tmp_name'],$file_host)){
	//检查图片属性，不是这几种类型的就不是图片文件
	@$data=GetImageSize($file_host);//取得GIF、JPEG、PNG或SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
	if($data[2]!=1 && $data[2]!=2 && $data[2]!=3 && $data[2]!=6){//4为swf格式
	unlink($file_host);
	mkhtml($fn,"",$data[2]."经判断上传的文件不是图片文件，已删除。"); 
	}
//生成缩略图
$data=GetImageSize($file_host);//取得GIF、JPEG、PNG或SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
	if($data[2]!=4){//文件类型不为4，4为swf格式
    	switch ($data[2]) {
     	case 1 :$sImg = imagecreatefromgif($file_host);break;
     	case 2 :$sImg = imagecreatefromjpeg($file_host);break;
     	case 3 :$sImg = imagecreatefrompng($file_host);break;
     	case 6 :$sImg = imagecreatefromwbmp($file_host);break;
     	default :mkhtml($fn,"","不支持的文件类型，无法生成缩略图");
    	}
		//生成小图
		if ($data[1]>$data[0]){
		$newwidth=$config['sw']*($data[0]/$data[1]) ;
		$newheight= $config['sw'];
		}else{
		$newwidth=$config['sw'];
		$newheight=$config['sw']*($data[1]/$data[0]) ;
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
   	}
	mkhtml($fn,$config['site_url'].$file_abso,$config['message']);
	}else{
    mkhtml($fn,"","文件上传失败，请检查上传目录设置和目录读写权限");
   }
}
}
//输出js调用
function mkhtml($fn,$fileurl,$message){
$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
//echo $str;
exit($str);
}
?>