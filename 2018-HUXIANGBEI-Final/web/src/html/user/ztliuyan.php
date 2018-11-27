<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/ztliuyan.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
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
<div class="admintitle"><?php echo $f_array[0]?></div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}
$page_size=pagesize_ht;  
if(isset($_GET["show"])) {
$show=$_GET['show'];
}else{
$show="";
}
$sql="select * from zzcms_guestbook where passed=1 and saver='".$username."' ";
if ($show=="new") {
$sql=$sql." and looked=0 ";
}

$offset=($page-1)*$page_size;
$rs = query($sql,$conn); 
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql,$conn); 
$row= num_rows($rs);//返回记录数
if(!$row){
echo $f_array[1];
}else{
?>
<form name="myform" method="post" action="del.php">
  <table width="100%" border="0" cellpadding="5" cellspacing="1"  class="bgcolor">
    <tr> 
     <?php echo $f_array[2]?>
    </tr>
          <?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td><a href="ztliuyan_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo cutstr($row["content"],10)?></a></td>
      <td><?php echo $row["sendtime"]?></td>
      <td align="center"><?php if ($row["looked"]==0){ echo $f_array[3];} else {echo $f_array[4];}?></td>
      <td align="center"><a href="ztliuyan_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo $f_array[5]?></a></td>
      <td align="center"><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
    </tr>
<?php
}
?>
  </table>

<div class="fenyei" >
<?php echo showpage()?> 
 <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll"><?php echo $f_array[6]?></label>
<input name="submit"  type="submit" class="buttons"  value="<?php echo $f_array[7]?>" onClick="return ConfirmDel()">
<input name="pagename" type="hidden" id="page2" value="ztliuyan.php?page=<?php echo $page ?>" /> 
<input name="tablename" type="hidden" id="tablename" value="zzcms_guestbook" /> 
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