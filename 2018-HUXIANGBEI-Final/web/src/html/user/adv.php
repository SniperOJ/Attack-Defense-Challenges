<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/adv.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[1]?>
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
<div class="content">
<div class="admintitle"><?php echo $f_array[0]?></div>
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["adv"])){
$adv=$_REQUEST["adv"];
}else{
$adv="";
}
if (isset($_REQUEST["advlink"])){
$advlink=$_REQUEST["advlink"];
}else{
$advlink="";
}
if (isset($_REQUEST["company"])){
$company=$_REQUEST["company"];
}else{
$company="";
}
if (isset($_REQUEST["img"])){
$img=$_REQUEST["img"];
}else{
$img="";
}
if (isset($_REQUEST["oldimg"])){
$oldimg=$_REQUEST["oldimg"];
}else{
$oldimg="";
}

$rs=query("select usersf from zzcms_user where username='".$_COOKIE["UserName"]."' ");
$row=fetch_array($rs);
if ($row["usersf"]=="个人"){
echo  $f_array[2];

exit;
}

if ($action=="modify"){
query("update zzcms_textadv set adv='$adv',company='$company',advlink='$advlink',img='$img',passed=0 where username='".$_COOKIE["UserName"]."'");
//为了防止一个用户通过修改广告词功能长期霸占一个位置当用户修改广告词时只更新其内容不更新时间。
//deloldimg
if ($oldimg<>$img){
		$f="../".$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
}
	//修改广告词后验查一下此用户是否已抢占了广告位
	//$rs=query("select * from zzcms_ad where username='".$_COOKIE["UserName"]."'");
    //$row=num_rows($rs);
	//if ($row){
	//query("update zzcms_ad set title='<b>新的广告内容正在审核中...</b>',link='###' where username='".$_COOKIE["UserName"]."'");
	//}
	echo $f_array[3];
}
		
if ($action=="add"){
query("insert into zzcms_textadv (adv,company,advlink,img,username,passed,gxsj)values('$adv','$company','$advlink','$img','".$_COOKIE["UserName"]."',0,'".date('Y-m-d H:i:s')."') ");
if ($oldimg<>$img && $oldimg!=''){
		$f="../".$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
}
		echo $f_array[4];
}

$rs=query("select * from zzcms_textadv where username='".$_COOKIE["UserName"]."'");
$row=num_rows($rs);
if ($row){
$row=fetch_array($rs);
?> 
<form name="myform" method="post" action="?action=modify" onSubmit="return CheckForm();"> 
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border"><?php echo $f_array[5]?></td>
            <td width="80%" class="border"> <input name="adv" type="text" id="adv" class="biaodan" value="<?php echo $row["adv"]?>" size="40" maxlength="15"> 
              <?php
		$rsn=query("select id,comane from zzcms_user where username='".$_COOKIE["UserName"]."'");
        $rown=fetch_array($rsn);
			?>
              <input name="advlink" type="hidden" id="advlink4" value="<?php echo getpageurl("zt",$rown["id"])?>"> 
              <input name="company" type="hidden" id="company" value="<?php echo $rown["comane"]?>">            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong><?php echo $f_array[6]?></strong> 
              <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>" />
              <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>" size="50" />              </td>
            <td class="border"> <table width="120" height="120" border="0" cellpadding="5" cellspacing="0" class="borderforimg">
                <tr> 
                  <td align="center" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
                    <?php
				 if ($row["img"]<>""){
						if (substr($row["img"],-3)=="swf"){
						$str=$str."<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='120' height='120'>";
						$str=$str."<param name='wmode' value='transparent'>";
						$str=$str."<param name='movie' value='".$row["img"]."' />";
						$str=$str."<param name='quality' value='high' />";
						$str=$str."<embed src='".$row["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='120'  height='120' wmode='transparent'></embed>";
						$str=$str."</object>";
						echo $str;
						}elseif (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false ){
                    	echo "<img src='".$row["img"]."' width='120'  border='0'> ";
                    	}
						echo $f_array[7];
					}else{
                     echo "<input name='Submit2' type='button'  value='".$f_array[8]."'/>";
                    }	
				  ?>                  </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><strong><?php echo $f_array[9]?></strong></td>
            <td class="border2"> 
              <?php if ($row["adv"]<>""){ echo "<a href='".$row["advlink"]."' target='_blank'>".$row["adv"]."</a>";}?>            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong><?php echo $f_array[10]?></strong></td>
            <td class="border">
              <?php if ($row["passed"]==1){ echo $f_array[11]; }else{ echo $f_array[12];}?>            </td>
          </tr>
          <tr> 
            <td class="border2">&nbsp;</td>
            <td class="border2"><input name="Submit22" type="submit" class="buttons" value="<?php echo $f_array[13]?>" /></td>
          </tr>
        </table>
  </form>
<?php 
}else{
?>
    <form name="myform" method="post" action="?action=add" onSubmit="return CheckForm();">    
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border"><?php echo $f_array[5]?></td>
            <td width="80%" class="border"> <input name="adv" type="text" id="adv" class="biaodan" size="40" maxlength="15"> 
              <?php
			$rsn=query("select id,comane from zzcms_user where username='".$_COOKIE["UserName"]."'");
            $rown=fetch_array($rsn)
			?>
              <input name="advlink" type="hidden" id="advlink" value="<?php echo getpageurl("zt",$rown["id"])?>"> 
              <input name="company" type="hidden"  value="<?php echo $rown["comane"]?>">            </td>
          </tr>
          <tr> 
            <td align="right" class="border"><strong><?php echo $f_array[6]?></strong> 
              <input name="img" type="hidden" id="img3" size="50" />              </td>
            <td class="border"> <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onclick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
                    <input name='Submit2' type='button'  value='<?php echo $f_array[8]?>'/> </td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><strong><?php echo $f_array[9]?></strong></td>
            <td class="border2"> 
              <?php if ($adv<>""){ echo"<a href='".$advlink."' target='_blank'>".$adv."</a>";}?>            </td>
          </tr>
          <tr> 
            <td class="border">&nbsp;</td>
            <td class="border"><input name="Submit3" type="submit" class="buttons" value="<?php echo $f_array[14]?>" /></td>
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