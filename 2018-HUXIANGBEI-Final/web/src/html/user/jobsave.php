<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (str_is_inarr(usergr_power,'job')=="no" && $usersf=='个人'){
showmsg('个人用户没有此权限');
}
if (isset($_REQUEST["page"])){ 
$page=$_REQUEST["page"];
}else{
$page=1;
}
$bigclassid=trim($_POST["bigclassid"]);
$smallclassid = isset($_POST['smallclassid'])?$_POST['smallclassid']:'0';
$smallclassname="未指定小类";
if (isset($bigclassid)){
$rs = query("select * from zzcms_jobclass where classid='$bigclassid'"); 
$row= fetch_array($rs);
$bigclassname=$row["classname"];
}

if ($smallclassid !=0){
$rs = query("select * from zzcms_jobclass where classid='$smallclassid'"); 
$row= fetch_array($rs);
$smallclassname=$row["classname"];
}

$cp_name=$_POST["jobname"];
$sm=$_POST["sm"];
$province=$_POST["province"];
$city=$_POST["city"];
$xiancheng=$_POST["xiancheng"];
$rs=query("select comane,id from zzcms_user where username='".$username."'");
$row=fetch_array($rs);
$comane=$row["comane"];
$userid=$row["id"];

$cpid=isset($_POST["ypid"])?$_POST["ypid"]:0;
//判断大小类是否一致，修改产品时有用
if ($smallclassid<>0){ 
$sql="select * from zzcms_jobclass where parentid='".$bigclassid."' and  classid='".$smallclassid."'";
$rs=query($sql);
$row=fetch_array($rs);
if (!$row){
echo"<script>alert('请选择小类');location.href='jobmodify.php?id=".$cpid."'</script>";
}
}

//判断是不是重复信息
if ($_REQUEST["action"]=="add" ){
$sql="select * from zzcms_job where jobname='".$cp_name."' and editor='".$username."' ";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
showmsg('您已发布过这条信息，请不要发布重复的信息！','jobmanage.php');
}
}elseif($_REQUEST["action"]=="modify"){
$sql="select * from zzcms_job where jobname='".$cp_name."' and editor='".$username."' and id<>".$cpid." ";
$rs=query($sql);
$row=num_rows($rs);
if ($row){
showmsg('您已发布过这条信息，请不要发布重复的信息！','jobmanage.php');
}
}
  
if ($_POST["action"]=="add"){
$isok=query("Insert into zzcms_job(jobname,bigclassid,bigclassname,smallclassid,smallclassname,sm,province,city,xiancheng,sendtime,editor,userid,comane) values('$cp_name','$bigclassid','$bigclassname','$smallclassid','$smallclassname','$sm','$province','$city','$xiancheng','".date('Y-m-d H:i:s')."','$username','$userid','$comane')") ;  
$cpid=insert_id();		
}elseif ($_POST["action"]=="modify"){

$isok=query("update zzcms_job set jobname='$cp_name',bigclassid='$bigclassid',bigclassname='$bigclassname',smallclassid='$smallclassid',smallclassname='$smallclassname',sm='$sm',
province='$province',city='$city',xiancheng='$xiancheng',sendtime='".date('Y-m-d H:i:s')."',
editor='$username',userid='$userid',comane='$comane',passed=0 where id='$cpid'");
}
$_SESSION['bigclassid']=$bigclassid;
$_SESSION['province']=$province;
$_SESSION['city']=$city;
$_SESSION['xiancheng']=$xiancheng;
passed("zzcms_job");		
?>
</head>

<body>
<div class="main">
<?php
include("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include("left.php");
?>
</div>
<div class="right">
<div class="content">
<table width="400" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="tstitle"> <?php
	if ($isok) {
      echo "发布成功 ";
	  }else{
	  echo"发布失败";}
     ?>      </td>
  </tr>
  <tr> 
    <td  class="border3"><table width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr bgcolor="#FFFFFF">
        <td width="25%" align="right" bgcolor="#FFFFFF"><strong>名称：</strong></td>
        <td width="75%"><?php echo $cp_name?></td>
      </tr>
    </table>
      <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="bgcolor">
        <tr> 
          <td width="120" align="center" class="bgcolor1"><a href="jobadd.php">继续添加</a></td>
                <td width="120" align="center" class="bgcolor1"><a href="jobmodify.php?id=<?php echo $cpid?>">修改</a></td>
                <td width="120" align="center" class="bgcolor1"><a href="jobmanage.php?page=<?php echo $page?>">返回</a></td>
                <td width="120" align="center" class="bgcolor1"><a href="<?php echo getpageurl("job",$cpid)?>" target="_blank">预览</a></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
session_write_close();
unset ($f_array);
?>
</div>
</div>
</div>
</div>
</body>
</html>