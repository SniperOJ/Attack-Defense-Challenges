<?php
set_time_limit(1800);
include("admin.php");
ob_end_clean();//终止缓冲。这样就不用等到有4096bytes的缓冲之后才被发送出去了。
echo str_pad(" ",256);//IE需要接受到256个字节之后才开始显示。
include ("../3/mobile_msg/inc.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"> <!--采用GB2312，否则返回信息出错，发信方网站应是BG2312-->
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="border" style="padding:10px"> 
<div style="padding:10px;background-color:#FFFFFF">
<?php
checkadminisdo("dl");
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $ids=$_POST['id'][$i];
	$ids=explode("|",$ids);
	//$id=$ids[0];
	$id=$id.($ids[0].',');
	}
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}else{
echo "<script lanage='javascript'>alert('操作失败！至少要选中一条信息。');window.opener=null;window.open('','_self');window.close()</script>";
exit;
}
if (strpos($id,",")>0){
$sql="select * from zzcms_dl where saver<>'' and id in (". $id .")";//没有接收人的，非留言类代理不用发提示邮件。
}else{
$sql="select * from zzcms_dl where saver<>'' and id=".$id."";
}
$rs=query($sql);
$row=num_rows($rs);
	while($row=fetch_array($rs)){
	$rsn=query("select username,sex,mobile,somane from zzcms_user where username='".$row["saver"]."'");
	$rown=num_rows($rsn);
	if (!$rown){	
		echo "没有这个用户";
	}else{
		$rown=fetch_array($rsn);
		$fbr_mobile=$rown["mobile"];
		$somane=$rown["somane"];
		$sex=$rown["sex"];
		if ($sex==1) {
			$sex="先生";
		}elseif ($sex==0) {
			$sex="女士";
		}
		$msg = $somane .$sex."您好：有人在".sitename."上给您留言想要".channeldl.$row["cp"]."请登录网站查看详情,网址：".siteurl."你在本站注册的用户名是：".$row["saver"];		$msg = iconv("UTF-8","GBK",$msg);
		//=============== 发 信 ================
		$result = sendSMS($smsusername,$smsuserpass,$fbr_mobile,$msg,$apikey);
		echo $result."<br>";	
	}
	flush();  //不在缓冲中的或者说是被释放出来的数据发送到浏览器  
	//sleep(5);不用设间隔		
}		      
?>
</div>
</div>
<div style="text-align:center;padding:10px" class="border">
    <input name="Submit" type="button" class="buttons" onClick="parent.window.opener=null;parent.window.open('','_self');parent.window.close();" value="close">
</div>
</body>
</html>