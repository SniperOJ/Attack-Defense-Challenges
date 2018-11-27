<?php
ob_start();   //打开缓存区 
include("../inc/conn.php");
include("check.php");
$fpath="text/dls_download.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
//此页不能且不需要链接CSS文件，否则生成的下载文件打开时会提示少CSS文件。
$founderr=0;
$ErrMsg="";
if (check_user_power("dls_download")=="no"){
$founderr=1;
$ErrMsg=$ErrMsg.$f_array[0];
}

$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if (strpos($id,',')==0){
$founderr=1;
$ErrMsg=$f_array[1];
}

if ($founderr==1){
WriteErrMsg($ErrMsg);
}else{

if (isset($_POST['FileExt'])){
$FileExt=$_POST['FileExt'];
}else{
$FileExt="xls";
}
if ($FileExt=="xls"){
header("Content-type:application/vnd.ms-excel;");
header("Content-Disposition:filename=dls_".date('Y-m-d H:i:s').".xls");
}elseif ($FileExt=="doc"){
header("Content-type:application/vnd.ms-word;");
header("Content-Disposition:filename=dls_".date('Y-m-d H:i:s').".doc");
}

if (strpos($id,",")!==false){
$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id in (". $id .") order by id desc";
}else{
$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id='$id' ";
}	
$rs=query($sql);
$table="<table width=100% cellspacing=0 cellpadding=0 border=1>";
$table=$table."<tr>";
$table=$table.$f_array[2];
$table=$table."</tr>";
while ($row=fetch_array($rs)){
$table=$table."<tr>";
$table=$table."<td>".$row['tel']."</td>";
$table=$table."<td>".$row['cp']."</td>";
$table=$table."<td>".$row['dlsname']."</td>";
$table=$table."<td>".$row['province'].$row['city']."</td>";
$table=$table."<td>".$row['content']."</td>";
$table=$table."<td>".$row['sendtime']."</td>";
$table=$table."</tr>";
}
$table=$table."</table>";
echo $table;
}
?>