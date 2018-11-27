<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/zsmanage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo channelzs.$f_array[1]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (str_is_inarr(usergr_power,'zs')=="no" && $usersf=='个人'){
echo $f_array[0];
exit;
}
?>
<script language="JavaScript" src="/js/gg.js"></script>
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
if (isset($_POST["cpmc"])){ 
$cpmc=$_POST["cpmc"];
}else{
$cpmc="";
}

if (isset($_REQUEST["bigclass"])){
$bigclass=$_REQUEST["bigclass"];
}else{
$bigclass="";
}
?>
<div class="content">
<div class="admintitle">
<span>
 <form name="form1" method="post" action="?">
<?php echo $f_array[2]?><input name="cpmc" type="text" id="cpmc" > 
<input name="Submit" type="submit" value="<?php echo $f_array[3]?>"> <input name="Submit2" type="button" class="buttons"  onClick="javascript:location.href='zsmanage.php?action=refresh'" value="<?php echo $f_array[4]?>" title='<?php echo $f_array[5]?>'>
</form>
</span>
<?php echo channelzs.$f_array[1]?></div>
<?php
$sql="select refresh_number,groupid from zzcms_usergroup where groupid=(select groupid from zzcms_user where username='".$username."')";
$rs = query($sql); 
if(empty($rs)){
$refresh_number=3;
}else{
$row = fetch_array($rs);
$refresh_number=$row["refresh_number"];
}

if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}

$sql="select refresh,sendtime from zzcms_main where editor='".$username."' ";
$rs = query($sql);
$row = fetch_array($rs);
if ($action=="refresh") {
    if ($row["refresh"]< $refresh_number){
	query("update zzcms_main set sendtime='".date('Y-m-d H:i:s')."',refresh=refresh+1 where editor='".$username."'");
	echo $f_array[6];
	exit;
    }else{
	echo str_replace("{#refresh_number}",$refresh_number,$f_array[7]);
	exit;
    }
}else{
	if (strtotime(date("Y-m-d H:i:s"))-strtotime($row['sendtime'])>12*3600){
	query("update zzcms_main set refresh=0 where editor='".$username."'");
  	}
}

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_main where editor='".$username."' ";
$sql2='';
if (isset($cpmc)){
$sql2=$sql2 . " and proname like '%".$cpmc."%' ";
}
if ($bigclass<>""){
$sql2=$sql2 . " and bigclasszm ='".$bigclass."'";
}
if (isset($_GET["id"])){
$sql2=$sql2 . " and id ='".$_GET["id"]."'"; 
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,bigclasszm,smallclasszm,proname,refresh,img,province,city,xiancheng,sendtime,elite,passed,elitestarttime,eliteendtime,tag from zzcms_main where editor='".$username."' ";
$sql=$sql.$sql2;		
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
echo $f_array[8];
}else{
?>
<form name="myform" method="post" action="del.php">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
    <tr> 
     <?php echo $f_array[9]?>
    </tr>
<?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td><a href="<?php echo getpageurl("zs",$row["id"])?>" target="_blank"><?php echo $row["proname"]?></a> </td>
      <td align="center">
	  <?php
	$sqln="select classname from zzcms_zsclass where classzm='".$row["bigclasszm"]."' ";
	$rsn = query($sqln); 
	$rown = fetch_array($rsn);
	echo $rown["classname"];
	
	if (strpos($row["smallclasszm"],",")>0){
	$sqln="select classname from zzcms_zsclass where parentid='".$row["bigclasszm"]."' and classzm in (".$row["smallclasszm"].") ";
	$rsn = query($sqln);
	echo "<br/> ";
	while($rown = fetch_array($rsn)){
	echo " [".$rown["classname"]."]";
	}
	}else{
	$sqln="select classname from zzcms_zsclass where classzm='".$row["smallclasszm"]."' ";
	$rsn = query($sqln); 
	$rown = fetch_array($rsn);
	echo "<br/>".$rown["classname"];
	}
	  ?>	  </td>
      <td align="center"><a href="<?php echo $row["img"] ?>" target='_blank'><img src="<?php echo $row["img"] ?>" width="60" height="60" border="0"></a></td>
      <td align="center" title='<?php echo $row["city"]?>'> 
	  <?php echo $row["province"].$row["city"]?>        </td>
      <td align="center"><?php echo $row["sendtime"]?></td>
      <td align="center"><?php echo $row["refresh"]?></td>
      <td align="center"> 
	  <?php 
	if ($row["passed"]==1 ){ echo  $f_array[10];}else{ echo  $f_array[11];}
	if ($row["elite"]<>0) { echo str_replace("{#eliteendtime}",$row["eliteendtime"],str_replace("{#elitestarttime}",$row["elitestarttime"],str_replace("{#tag}",$row["tag"],$f_array[12])));}
	  ?> </td>
            <td align="center" class="docolor"> 
              <a href="zsmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>"><?php echo $f_array[13]?></a> 
              | <a href="zspx.php" target="_self"><?php echo $f_array[14]?></a>| <a href="zs_elite.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>"><?php echo $f_array[15]?></a>		    </td>
            <td align="center" class="docolor"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
    </tr>
<?php
}
?>
  </table>

<div class="fenyei">
<?php echo showpage()?> 
          <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll"><?php echo $f_array[16]?></label>
          <input name="submit"  type="submit" class="buttons"  value="<?php echo $f_array[17]?>" onclick="return ConfirmDel()" />
          <input name="pagename" type="hidden" id="pagename" value="zsmanage.php?page=<?php echo $page ?>" />
          <input name="tablename" type="hidden" id="tablename" value="zzcms_main" />
        </div>
</form>
<?php
}
?>
</div>
</div>
</div>
</div>
</body>
</html>