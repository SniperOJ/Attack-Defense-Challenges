<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/pay_manage.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<div class="main">
<?php
include ("top.php");
?>
<div class="pagebody">
<div class="left">
<?php
include ("left.php");
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

$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_pay where username='".$username."'";
$rs = query($sql,$conn); 
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);  

$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql,$conn); 
$row= num_rows($rs);//返回记录数
if(!$row){
echo $f_array[1];
}else{
?>
 
      <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
        <tr> 
          <?php echo $f_array[2]?> 
        </tr>
        <?php
$i=1;
while($row = fetch_array($rs)){
?>
         <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
          <td align="center"><?php echo $i?></td>
          <td><?php echo $row["dowhat"]?></td>
          <td><?php echo $row["RMB"]?></td>
          <td><?php echo $row["sendtime"]?></td>
          <td><?php echo $row["mark"]?></td>
        </tr>
        <?php
$i=$i+1;
}
?>
      </table>
<div class="fenyei">
<?php echo showpage()?> 
</div>
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