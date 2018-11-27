<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/zxmanage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
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
<div class="content">
<div class="admintitle">
<span><form name="form1" method="post" action="?"><?php echo $f_array[1]?> <input name="keyword" type="text" id="keyword"> 
<input type="submit" name="Submit" value="<?php echo $f_array[2]?>"></form>
</span><?php echo $f_array[0]?></div>
<?php
if (isset($_GET["bigclassid"])){
$bigclassid=$_GET["bigclassid"];
}else{
$bigclassid="";
}

if (isset($_POST["keyword"])){ 
$keyword=trim($_POST["keyword"]);
}else{
$keyword="";
}	

if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_zx where editor='".$username."' ";
$sql2='';
if ($bigclassid!=""){
checkid($bigclassid);
$sql2=$sql2." and bigclassid='".$bigclassid."' ";
}

if ($keyword!=""){
$sql2=$sql2." and title like '%".$keyword."%' ";
}
$sql=$sql.$sql2;
$rs = query($sql); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,bigclassid,smallclassid,bigclassname,smallclassname,title,sendtime,passed,hit from zzcms_zx where editor='".$username."' ";	
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
echo $f_array[3];
}else{
?>
<form name="myform" method="post" action="del.php">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr> 
           <?php echo $f_array[4]?>
          </tr>
          <?php
while($row = fetch_array($rs)){
?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td><a href="<?php echo getpageurl("zx",$row["id"])?>" target="_blank"><?php echo $row["title"]?></a></td>
            <td align="center"> 
			<a href="?bigclassid=<?php echo $row["bigclassid"]?>"><?php echo $row["bigclassname"]?></a> 
              - <?php echo $row["smallclassname"]?>            </td>
            <td align="center"><?php echo $row["sendtime"]?></td>
            <td align="center"> 
              <?php 
	if ($row["passed"]==1 ){ echo $f_array[5];}else{ echo $f_array[6];}
	  ?>            </td>
            <td align="center"><?php echo $row["hit"]?></td>
            <td align="center"> 
			
              <a href="zxmodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>&bigclassid=<?php echo $bigclassid?>"><?php echo $f_array[7]?></a></td>
            <td align="center"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
          </tr>
          <?php
}
?>
        </table>

<div class="fenyei">
<?php echo showpage('yes')?> 
 <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll"><?php echo $f_array[8]?></label>
<input name="submit"  type="submit" class="buttons"  value="<?php echo $f_array[9]?>" onClick="return ConfirmDel()"> 
<input name="pagename" type="hidden" id="page2" value="zxmanage.php?page=<?php echo $page ?>"> 
<input name="tablename" type="hidden" id="tablename" value="zzcms_zx"> 
</div>
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