<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zs_elite.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<title></title>
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>  
}
</script> 
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
<?php
$err=0;
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}

if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id=0;
}

if ($action=='modify'){

if (isset($_POST["eliteendtime"])){
$eliteendtime=$_POST["eliteendtime"];
}

if (strtotime($eliteendtime)<=time()){
$err=1;
$errmsg=$f_array[1];
}

if (isset($_POST["oldeliteendtime"])){
$oldeliteendtime=$_POST["oldeliteendtime"];
	if (strtotime($oldeliteendtime)<time()){//设过值，过期了
	$oldeliteendtime=date('Y-m-d');
	}
}else{
$oldeliteendtime=date('Y-m-d');//没有设过值的
}

if (isset($_POST["tag"])){
$tag=$_POST["tag"];
}

$sql="select id,proname,eliteendtime,tag from zzcms_main where tag='".$tag."' and id<>'$id'";
$rs = query($sql); 
$row=num_rows($rs);
if ($row){
$row = fetch_array($rs);
$err=1;
$errmsg=$f_array[2]."<a href='/zs/search.php?keyword=".$row['tag']."'>".$row['proname']."</a><br>".$f_array[3].$row['eliteendtime'];
}
if ($err==1){
WriteErrMsg($errmsg);
}else{
$day=floor((strtotime($eliteendtime)-strtotime($oldeliteendtime))/(24*3600));//按到期时间计费，这样改关键词可免费，续期只收续期的费用
$jfpay=$day*jf_set_elite;
if ($jfpay<0){ $jfpay=0; }
//echo $jfpay;
switch (check_user_power('set_elite')){
case 'yes':
if (jifen=="Yes"){
$sqln="select totleRMB from zzcms_user where username='".$username."'";
$rsn = query($sqln);
$rown = fetch_array($rsn);
	if ($rown["totleRMB"]>=$jfpay){
	query("update zzcms_user set totleRMB=totleRMB-$jfpay where username='".$username."'");
	query("update zzcms_main set elitestarttime='".date('Y-m-d')."',eliteendtime='$eliteendtime',tag='$tag',elite=1 where id='$id'");
	query("insert into zzcms_pay (username,dowhat,RMB,mark,sendtime) values('$username','".channelzs.$f_array[4]."','-$jfpay','".$f_array[5]."<a href=zsmanage.php?id=$id>$id</a>','".date('Y-m-d H:i:s')."')");
	echo str_replace("{#jfpay}",$jfpay,str_replace("{#jf_set_elite}",jf_set_elite,str_replace("{#day}",$day,str_replace("{#eliteendtime}",$eliteendtime,str_replace("{#oldeliteendtime}",$oldeliteendtime,$f_array[6])))));
	echo "<script>location.href='zsmanage.php?page=".$_REQUEST["page"]."'</script>";
	}else{
	echo str_replace("{#jfpay}",$jfpay,$f_array[7]);
	}			
}elseif (jifen=="No") {
echo $f_array[8];
}
break;
case 'no':
echo $f_array[9];
}

}
}else{

$sql="select id,editor,proname,eliteendtime,tag from zzcms_main where id='$id'";
$rs = query($sql); 
$row = fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
echo  $f_array[10];
exit;
}
?>
<div class="content">
<div class="admintitle"><?php echo $f_array[11]?></div>
<form action="?" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="18%" align="right" class="border" ><?php echo $f_array[12]?></td>
            <td width="82%" class="border" > <?php echo $row["proname"]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[13]?></td>
            <td class="border" > <input name="eliteendtime" type="text" id="eliteendtime"  class="biaodan" value="<?php echo $row["eliteendtime"]?>" size="30" maxlength="45" onFocus="JTC.setday(this)">
              <input name="oldeliteendtime" type="hidden"  value="<?php echo $row["eliteendtime"]?>" size="30" maxlength="45" />
              <?php echo jf_set_elite.$f_array[14]?></td>
          </tr>
          
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[15]?></td>
            <td class="border" > <input name="tag" type="text" id="tag" class="biaodan" value="<?php echo $row["tag"] ?>" size="10" maxlength="4">
              <?php echo $f_array[16]?></td>
          </tr>
          <tr> 
            <td align="center" class="border" >&nbsp;</td>
            <td class="border" > <input name="id" type="hidden" id="ypid2" value="<?php echo $row["id"] ?>"> 
              <input name="action" type="hidden" id="action2" value="modify">
              <span class="border">
              <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>" />
              </span>
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[17]?>"></td>
          </tr>
        </table>
	  </form>
<?php
}
unset ($f_array);
?>	  
</div>
</div>
</div>
</div>
</body>
</html>