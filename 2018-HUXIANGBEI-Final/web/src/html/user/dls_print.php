<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/dls_print.txt";
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
<style type="text/css">
<!--
.x {
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #CCCCCC;
	background-color: #FFFFFF;
	border-left-style: solid;
	border-left-color: #CCCCCC;
	border-left-width: 1px;
}
-->
</style>
</head>
<body>
<div class="main">
<?php
if (check_user_power("dls_print")=="no"){
echo $f_array[0];
exit;
}
?>
<div class="box center"><a href="javascript:window.print()"><?php echo $f_array[1]?></a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"> 
      <?php
$id="";
if(!empty($_POST['id'])){
    for($i=0; $i<count($_POST['id']);$i++){
    $id=$id.($_POST['id'][$i].',');
    }
	$id=substr($id,0,strlen($id)-1);//去除最后面的","
}

if (!isset($id) || $id==""){
echo $f_array[2];

exit;
}
 	if (strpos($id,",")>0){
	//$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id in (". $id .") and id in(select max(id) from zzcms_dl group by tel)";
	$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id in (". $id .")";
	}else{
	$sql="select * from zzcms_dl where passed=1 and saver='".$username."' and id='$id' order by id desc";
	}
	
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo $f_array[3];
}else{
?>
      <table width="100%" border="0" cellpadding="2" cellspacing="0">
        <tr> 
         <?php echo $f_array[4]?>
        </tr>
        <?php
$i=1;		
while ($row=fetch_array($rs)){
?>
        <tr> 
          <td width="6%" height="30" align="center" class="x"><?php echo $i?> </td>
          <td width="6%" height="30" class="x"><?php echo $row['dlsname']?></td>
          <td width="14%" height="30" class="x"><?php echo $row['province'].$row['city']?></td>
          <td width="20%" height="30" class="x"><?php echo $row['cp']?></td>
          <td width="34%" height="30" class="x"><?php echo  $f_array[5].$row['tel'].$f_array[6].$row['email']?></td>
          <td width="20%" height="30" class="x"> <?php echo $row['sendtime']?></td>
        </tr>
        <?php
$i++;
}
?>
      </table>
      
      <?php
}	

 ?>
    </td>
  </tr>
</table>
</div>
</body>
</html>