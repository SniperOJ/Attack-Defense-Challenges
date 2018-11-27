<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css"> 
</head>
<body>
<?php
checkadminisdo("userreg");
$pageurl=trim($_POST["pageurl"]);
?>
<div class="admintitle">删除用户执行结果如下</div>
<table width="100%" border="0" cellpadding="10" cellspacing="1" class="border">
  <tr> 
    <td bgcolor="#FFFFFF" class="px14"> 
<?php
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}
if ($id==""){
echo "<script>alert('操作失败！至少要选中一条信息。');location.href('usermanage.php')</script>";
}
if (strpos($id,",")>0){
$sql="select id,username from zzcms_user where id in (". $id .")";
}else{
$sql="select id,username from zzcms_user where id='$id'";
}
$rs=query($sql);
while($row=fetch_array($rs)){	
	$editor=$row["username"];
	if ($editor<>''){
	$sqln="select img,flv from zzcms_main where editor='".$editor."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	
	if ($rown){
	while($rown=fetch_array($rsn)){
	if ($rown["img"]<>"/image/nopic.gif" && substr($rown["img"],0,4)<>"http"){
		$f="../".$rown["img"]."";
		if (file_exists($f)){
		unlink($f);		
		}
		$fs="../".str_replace(".","_small.",$rown["img"])."";
		if (file_exists($fs)){
		unlink($fs);		
		}
	}	
	if ($rown["flv"]<>'' && substr($rown["flv"],0,4)<>"http"){
		$f="../".$rown["flv"]."";
		if (file_exists($f)){
		unlink($f);		
		}
	}
	
	}
	echo channelzs."信息中的上传图片及视频已删除<br>";
	}
	
	query("delete from zzcms_main where editor='".$editor."'");
	echo $editor."用户的".channelzs."信息已被删除<br>";
	
	$sqln="select img from zzcms_pp where editor='".$editor."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	
	if ($rown){
	while($rown=fetch_array($rsn)){
	if ($rown["img"]<>"/image/nopic.gif" && substr($rown["img"],0,4)<>"http"){
		$f="../".$rown["img"]."";
		if (file_exists($f)){
		unlink($f);		
		}
		$fs="../".str_replace(".","_small.",$rown["img"])."";
		if (file_exists($fs)){
		unlink($fs);		
		}
	}	
	}
	echo "品牌信息中的上传图片已删除<br>";
	}
	
	query("delete from zzcms_pp where editor='".$editor."'");
	echo "此用户的品牌信息已被删除<br>";
	
	query("delete from zzcms_job where editor='".$editor."'");
	echo "此用户的招聘信息已被删除<br>";
	
	query("delete from zzcms_dl where editor='".$editor."'");
	echo "此用户的".channeldl."信息已被删除<br>";			
	
	query("delete from zzcms_zh where editor='".$editor."'");
	echo "此用户的展会信息已被删除<br>";
	
	query("delete from zzcms_zx where editor='".$editor."'");
	echo "此用户的资讯信息已被删除<br>";	
	
	query("delete from zzcms_textadv where username='".$editor."'");
	echo "此用户审请的文字广告已被删除<br>";
	
	query("update zzcms_ad set nextuser='' where nextuser='".$editor."'");
	echo "此用户所占广告位已被删除<br>";


	$sqln="select img from zzcms_licence where editor='".$editor."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	if ($rown){
	while($rown=fetch_array($rsn)){
	
	if ($rown["img"]<>"/image/nopic.gif" && substr($rown["img"],0,4)<>"http"){
		$f="../".$rown["img"]."";
		if (file_exists($f)){
		unlink($f);		
		}
		$fs="../".str_replace(".","_small.",$rown["img"])."";
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
	
	}
	echo "公司证件信息中的上传图片已删除<br>";
	}

	query("delete from zzcms_licence where editor='".$editor."'");
	echo "此用户的公司证件信息已被删除<br>";
	
	query("delete from zzcms_looked_person where username='".$editor."'");
	echo "此用户的简历查看记录已被删除<br>";
	
	query("delete from zzcms_looked_dls where username='".$editor."'");
	echo "此用户的".channeldl."商查看记录已被删除<br>";
	
	query("delete from zzcms_pay where username='".$editor."'");
	echo "此用户的财务记录已被删除<br>";	
	
	query("delete from zzcms_usersetting where username='".$editor."'");
	echo "此用户的相关配置信息已被删除<br>";				
	
	$sqln="select img,flv from zzcms_user where username='".$editor."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	if ($rown){
	while($rown=fetch_array($rsn)){
	
	if ($rown["img"]<>"/image/nopic.gif" && substr($rown["img"],0,4)<>"http"){
		$f="../".$rown["img"]."";
		if (file_exists($f)){
		unlink($f);		
		}
		$fs="../".str_replace(".","_small.",$rown["img"])."";
		if (file_exists($fs)){
		unlink($fs);		
		}
	}
	
	if ($rown["flv"]<>'' && substr($rown["flv"],0,4)<>"http"){
		$f="../".$rown["flv"]."";
		if (file_exists($f)){
		unlink($f);		
		}
	}
	
	}
	echo "公司形象图片及视频已删除<br>";
	}

	}//end if($editor<>'')
	query("delete from zzcms_user where id=".$row['id']."");
	echo $editor."用户注册信息已被删除<br><br>";
}
//echo "<script>location.href=\"$pagename\"<//script>"; 
?>
    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="docolor"><a href="<?php echo $pageurl ?>">返回</a></td>
  </tr>
</table>
</body>
</html>