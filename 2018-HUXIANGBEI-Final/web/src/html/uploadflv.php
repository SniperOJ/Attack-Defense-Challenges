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
private $uptypes = array ('application/x-shockwave-flash');//上传文件类型列表，只让上传swf格式的，flv要上传需设'application/octet-stream'，这样PHP等文件通过改后缀就也可上传了。
private $max_file_size = maxflvsize; //上传文件大小限制, 单位k
public $fileName; //文件名称
public $fdir ;//上传文件路径
public $bImg; //大图的全路径
public $datu; //大图的命名
function upfile() {
//是否存在文件
if (!is_uploaded_file(@$this->fileName[tmp_name])){
   echo "<script>alert('请点击“浏览”，选择您要上传的文件！\\n\\n支持的图片类型为：swf,\\n\\n如果选择后还出此提示，可能是你的服务器只能上传2M以下的文件');parent.window.close();</script>";exit;
}
//检查文件大小
if ($this->max_file_size*1024*1024 < $this->fileName["size"]){
   echo "<script>alert('文件大小超过了限制！最大只能上传 ".$this->max_file_size." M的文件');parent.window.close();</script>";exit;
}
//检查文件类型
if (!in_array($this->fileName["type"], $this->uptypes)) {
   echo "<script>alert('文件类型错误，支持的类型为：swf');parent.window.close();</script>";exit;
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
if (!move_uploaded_file($tempName, $newName)) {
   echo "<script>alert('移动文件出错');parent.window.close();</script>";exit;
}else{
	$data=GetImageSize($newName);//取得SWF图片属性，返回数组，图形的宽度[0],图形的高度[1]，文件类型[2]
	if($data[2]!=4){//4为swf格式，同上传图片功能一样加了这一步判断，为防止程序文件通过改文件头伪装成swf文件，由此步FLV文件是上传不了的。
	unlink($newName);
	echo "<script>alert('".$data[2]."经判断上传的文件不是swf格式文件，已删除。');parent.window.close();</script>";exit;
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
$filetype=strtolower(strrchr($filename[$i]['name'],"."));//图片的类型
   $up = new upload();
   $up->fileName = $filename[$i];
   $up->fdir='uploadfiles/'.date("Y-m").'/';   //上传的路径
   $up->datu=date("YmdHis").rand(100,999).$filetype;//大图的命名
   $up->upfile();     //上传
   $bigimg=$up->fdir.$up->datu;   //返回的大图文件名

	$js="<script language=javascript>";
	$js=$js."parent.window.opener.valueFormOpenwindowForFlv('/" . $bigimg ."');";//读取父页面中的JS函数传回值
	$js=$js."parent.window.close();";
	$js=$js."</script>";
echo $js;
} 
?>