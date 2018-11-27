<?php
//set_time_limit(1800) ;
include("admin.php");
checkadminisdo("zs");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="loading" class="left-title" style="display:block">正在保存，请稍候...</div>
<?php
$cpid=trim($_POST["cpid"]);
$bigclassid=trim($_POST["bigclassid"]);

if (zsclass_isradio=='Yes'){
$smallclassid=@trim($_POST["smallclassid"][0]);//加[]可同多选共用同一个JS判断函数uncheckall,加@有不加小类的情况
}else{
$smallclassid="";
	if(!empty($_POST['smallclassid'])){
    for($i=0; $i<count($_POST['smallclassid']);$i++){
    $smallclassid=$smallclassid.('"'.$_POST['smallclassid'][$i].'"'.',');
	//$smallclassid=$smallclassid.($_POST['smallclassid'][$i].',');
    }
	$smallclassid=substr($smallclassid,0,strlen($smallclassid)-1);//去除最后面的","
	}
}

$shuxing = isset($_POST['shuxing'])?$_POST['shuxing']:'0'; 

$shuxing_value="";
	if(!empty($_POST['sx'])){
    for($i=0; $i<count($_POST['sx']);$i++){
	$shuxing_value=$shuxing_value.($_POST['sx'][$i].'|||');
    }
	$shuxing_value=substr($shuxing_value,0,strlen($shuxing_value)-3);//去除最后面的"|||"
	}

$szm = isset($_POST['szm'])?$_POST['szm']:'';
$cpname=trim($_POST["cpname"]);
$prouse=trim($_POST["prouse"]);
$sm=str_replace("'","",stripfxg(trim($_POST["sm"])));
$img=trim($_POST["img"]);

//---保存内容中的远程图片，并替换内容中的图片地址
$msg='';
$imgs=getimgincontent($sm,2);
foreach ($imgs as $value) {
	if (substr($value,0,4) == "http"){
	$img_bendi=grabimg($value,"");//如果是远程图片保存到本地
	if($img_bendi):$msg=$msg.  "远程图片：".$value."已保存为本地图片：".$img_bendi."<br>";else:$msg=$msg.  "false";endif;
	$img_bendi=substr($img_bendi,strpos($img_bendi,"/uploadfiles"));//在grabimg函数中$img被加了zzcmsroo。这里要去掉
	$sm=str_replace($value,$img_bendi,$sm);//替换内容中的远程图片为本地图片
	}
}
//---end
if ($img==''){//放到内容下面，避免多保存一张远程图片
$img=getimgincontent($sm);
}

if ($img<>''){
	if (substr($img,0,4) == "http"){//$img=trim($_POST["img"])的情况下，这里有可能是远程图片地址
		$img=grabimg($img,"");//如果是远程图片保存到本地
		if($img):$msg=$msg.  "远程图片已保存到本地：".$img."<br>";else:$msg=$msg.  "false";endif; 
		$img=substr($img,strpos($img,"/uploadfiles"));//在grabimg函数中$img被加了zzcmsroo。这里要去掉 
	}
		
	$imgsmall=str_replace(siteurl,"",getsmallimg($img));
	if (file_exists(zzcmsroot.$imgsmall)===false && file_exists(zzcmsroot.$img)!==false){//小图不存在，且大图存在的情况下，生成缩略图
	makesmallimg($img);//同grabimg一样，函数里加了zzcmsroot
	}	
}

$flv=trim($_POST["flv"]);
$zc=trim($_POST["zc"]);
$yq=trim($_POST["yq"]);
$sendtime=$_POST["sendtime"];
$editor=trim($_POST["editor"]);
$oldeditor=trim($_POST["oldeditor"]);
$tag=trim($_POST["tag"]);

if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}
if(!empty($_POST['elite'])){
$elite=$_POST['elite'][0];
}else{
$elite=0;
}

$title=isset($_POST["title"])?$_POST["title"]:$cp_name;
$keyword=isset($_POST["keyword"])?$_POST["keyword"]:$cp_name;
$discription=isset($_POST["discription"])?$_POST["discription"]:$cp_name;

$elitestarttime=trim($_POST["elitestarttime"]);
if ($elitestarttime=="") {
$elitestarttime=date('Y-m-d H:i:s');
}
$eliteendtime=trim($_POST["eliteendtime"]);
if ($eliteendtime=="") {
$eliteendtime=date('Y-m-d H:i:s',time()+365*3600*24);
}

$isok=query("update zzcms_main set bigclasszm='$bigclassid',smallclasszm='$smallclassid',shuxing='$shuxing',szm='$szm',prouse='$prouse',proname='$cpname',sm='$sm',img='$img',flv='$flv',zc='$zc',yq='$yq',shuxing_value='$shuxing_value',title='$title',keywords='$keyword',description='$discription',sendtime='$sendtime',tag='$tag' where id='$cpid'");
if ($editor<>$oldeditor) {
$rs=query("select groupid,qq,comane,id,renzheng from zzcms_user where username='".$editor."'");
$row = num_rows($rs);
if ($row){
$row = fetch_array($rs);
$groupid=$row["groupid"];
$userid=$row["id"];
$qq=$row["qq"];
$comane=$row["comane"];
$renzheng=$row["renzheng"];
}else{
$groupid=0;
$userid=0;
$qq="";
$comane="";
$renzheng=0;
}
query("update zzcms_main set editor='$editor',userid='$userid',groupid='$groupid',qq='$qq',comane='$comane',renzheng='$renzheng' where id='$cpid'");
}
query("update zzcms_main set passed='$passed',elite='$elite',elitestarttime='$elitestarttime',eliteendtime='$eliteendtime' where id='$cpid'");

//echo "<script>location.href='zs_manage.php?keyword=".$_POST["editor"]."&page=".$_REQUEST["page"]."'<//script>";
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="left-title">
	<?php
	  if ($isok){
	  echo"成功";
	  }else{
	  echo "失败";
	  }
     ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr bgcolor="#FFFFFF">
        <td width="20%" align="right" bgcolor="#FFFFFF">名称：</td>
        <td width="80%"><?php echo $title?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="33%" align="center" class="border"><a href="<?php echo "zs_manage.php?keyword=".$_POST["editor"]."&page=".$_REQUEST["page"]?>">返回</a></td>
        <td width="33%" align="center" class="border"><a href="zs_modify.php?id=<?php echo $cpid?>">修改</a></td>
        <td width="33%" align="center" class="border"><a href="<?php echo getpageurl("zs",$cpid)?>" target="_blank">预览</a></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
  <?php 
if ($msg<>'' ){echo "<div class='border'>" .$msg."</div>";}
echo "<script language=javascript>document.getElementById('loading').style.display='none';</script>";
?>
</body>
</html>