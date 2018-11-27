<?php
ob_start();   //打开缓存区 
include("../inc/conn.php");
$founderr=0;
$ErrMsg="";
if (!isset($_COOKIE["UserName"])){
showmsg('请先登录','/user/login.php');
}

$username=$_COOKIE["UserName"];
$id="";
$i=0;
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');	
	}
}else{
	$founderr=1;
	$ErrMsg="<li>操作失败！请先选中要下载的信息</li>";
}
$id=substr($id,0,strlen($id)-1);//去除最后面的","

if (isset($_POST['FileExt'])){
$FileExt=$_POST['FileExt'];
}else{
$FileExt="xls";
}

if (check_user_power("dls_download")=="no"){
$founderr=1;
$ErrMsg=$ErrMsg."<li>您所在的用户组没有下载".channeldl."信息的权限！<br><input  type=button value=升级成VIP会员 onclick=\"location.href='/one/vipuser.php'\"/></li>";
}
//判断查看代理条数
$rslookedlsnumber=query( "select looked_dls_number_oneday from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')");
$rown=fetch_array($rslookedlsnumber);
$lookedlsnumber=$rown["looked_dls_number_oneday"];
$rslookedlsnumbers=query("select looked_dls_number_oneday from zzcms_looked_dls_number_oneday where username='".$username."' and  timestampdiff(day,sendtime,now()) < 3600*24 ");
$rown=num_rows($rslookedlsnumbers);
if ($rown){
	if ($rown["looked_dls_number_oneday"]+$i>$lookedlsnumber){
	$founderr=1;
	$ErrMsg="<li>您所在的用户组每天只能下载 ".$lookedlsnumber." 条".channeldl."信息<br><input  type=button value=升级为高级会员 onclick=location.href='/one/vipuser.php'/></li>";
	}
}
if ($founderr==1){
WriteErrMsg($ErrMsg);
}else{
$rslooked=query("select * from zzcms_looked_dls_number_oneday where username='".$username."'");
	$rown=num_rows($rslooked);
	if (!$rown){
	query("insert into zzcms_looked_dls_number_oneday (looked_dls_number_oneday,username,sendtime)values(1,'".$username."','".date('Y-m-d H:i:s')."') ");
	}else{
		if (time()-strtotime($rown["sendtime"])<3600*24){
		query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=looked_dls_number_oneday+".$i." where username='".$username."'");
		}else{
		query("update zzcms_looked_dls_number_oneday set looked_dls_number_oneday=".$i.",sendtime='".date('Y-m-d H:i:s')."' where username='".$username."'");
		}
	}
//echo "<script>location.href='dl_download2.php?file_ext=$FileExt&id=$id'<//script>";
if ($FileExt=="xls"){
header("Content-type:application/vnd.ms-excel;");
header("Content-Disposition:filename=dls_".date('Y-m-d H:i:s').".xls");
}elseif ($FileExt=="doc"){
header("Content-type:application/vnd.ms-word;");
header("Content-Disposition:filename=dls_".date('Y-m-d H:i:s').".doc");
}

if (strpos($id,",")>0){
$sql="select * from zzcms_dl where passed=1 and id in (". $id .") order by id desc";
}else{
$sql="select * from zzcms_dl where passed=1  and id='$id'";
}	

$rs=query($sql,$conn);
$table="<table width=100% cellspacing=0 cellpadding=0 border=1>";
$table=$table."<tr>";
$table=$table."<td align=center  bgcolor=#dddddd><b>ID</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>".channeldl."人</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>电话</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>Email</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>".channeldl."产品</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>".channeldl."区域</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>".channeldl."商介绍</b></td>";
$table=$table."<td align=center  bgcolor=#dddddd><b>发布时间</b></td>";
$table=$table."</tr>";
while ($row=fetch_array($rs)){
$table=$table."<tr>";
$table=$table."<td>".$row['id']."</td>";
$table=$table."<td>".$row['dlsname']."</td>";
$table=$table."<td>".$row['tel']."</td>";
$table=$table."<td>".$row['email']."</td>";
$table=$table."<td>".$row['cp']."</td>";
$table=$table."<td>".$row['province'].$row['city']."</td>";
$table=$table."<td>".$row['content']."</td>";
$table=$table."<td>".$row['sendtime']."</td>";
$table=$table."</tr>";
}
$table=$table."</table>";
echo $table;
}
?>