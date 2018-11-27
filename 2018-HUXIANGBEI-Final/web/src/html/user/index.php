<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/index.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("\n",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<title><?php echo $f_array[0]?></title>
<?php
//接收通过此页跳转页的代码
$gotopage="";
$canshu="";
$b="";
$s="";
if (isset($_GET["gotopage"])){
$gotopage=$_GET["gotopage"];
$gotopage=substr($gotopage,0,strpos($gotopage,".php")+4);
}
if (isset($_GET["canshu"])){
$canshu=$_GET["canshu"];
}
if (isset($_GET["b"])){
$b=$_GET["b"];
}
if (isset($_GET["s"])){
$s=$_GET["s"];
}
?>
<form action="<?php echo $gotopage;?>" method='post' name='gotopage' target='_self' >
<input type='hidden' name='canshu' value='<?php echo $canshu;?>' />
<input type='hidden' name='b' value='<?php echo $b;?>' />
<input type='hidden' name='s' value='<?php echo $s;?>' />
</form>
<?php
$sql="select * from zzcms_user where username='".@$username."'";
$rs=query($sql);
$row=fetch_array($rs);
if ($row["usersf"]=="公司" ){
	if ($row["content"]=="" || $row["content"]=="&nbsp;"){
	 echo "<script>location.href='daohang_company.php'</script>";
	}
}
?>
<SCRIPT>
function gotopage(){
document.gotopage.submit();
}
</SCRIPT>
</head>
<body   <?php if ($gotopage<>""){echo "onLoad='gotopage()'";}?>  >
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
 <?php
$sql="select * from zzcms_message where sendto='' or  sendto='".@$username."'  order by id desc";
$rs=query($sql);
$row=num_rows($rs);
if($row){
$str="<div class='content' style='margin-bottom:10px'><div class='admintitle'>".$f_array[1]."</div>";
while ($row=fetch_array($rs)){
$str=$str."<div class='box' style='margin-bottom:5px'>";
$str=$str."<div style='font-weight:bold' title='".$f_array[2]."'>".$row["sendtime"]."</div>";
$str=$str.$row["content"];
$str=$str."</div>";
}
$str=$str."</div>";
echo $str;
}
?>
<div class="content">
<div class="admintitle"><?php echo $f_array[3]?></div>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
  <tr> 
    <td width="13%" height="50" align="right" bgcolor="#FFFFFF" class="border2"><?php echo $f_array[4]?></td>
    <td width="87%" bgcolor="#FFFFFF" class="border2"> 
	<?php
  $sql="select * from zzcms_user where username='".@$username."'";
  $rs=query($sql);
  $row=fetch_array($rs);
  echo "<b>".@$username ."</b><br>".$row["regdate"];
  ?> </td>
  </tr>
  <tr> 
    <td height="50" align="right" bgcolor="#FFFFFF" class="border"><?php echo $f_array[5]?></td>
    <td bgcolor="#FFFFFF" class="border"><b><?php echo $row["totleRMB"]?></b><br>
      <?php echo $f_array[6]?></td>
  </tr>
  <tr> 
    <td height="50" align="right" bgcolor="#FFFFFF" class="border2"><?php echo $f_array[7]?></td>
    <td bgcolor="#FFFFFF" class="border2"><b><?php echo $row["logins"]?></b><br>
      <?php echo $f_array[8]?></td>
  </tr>
  <tr> 
    <td height="50" align="right" bgcolor="#FFFFFF" class="border"><?php echo $f_array[9]?></td>
    <td bgcolor="#FFFFFF" class="border"><b>
      <?php if ($row["showloginip"]<>"") {echo $row['showloginip'] ;}else{ echo "空" ;}?>
      </b><br>
      <?php echo $f_array[10]?>
    </td>
  </tr>
  <tr> 
    <td height="50" align="right" bgcolor="#FFFFFF" class="border2"><?php echo $f_array[11]?></td>
    <td bgcolor="#FFFFFF" class="border2"><b><?php echo $row["showlogintime"]?></b><br>
      <?php echo $f_array[12]?></td>
  </tr>
</table>
<?php
$sql="select id from zzcms_dl where saver='".@$username."' and looked=0 and del=0 and passed=1";
$rs=query($sql);
$row=num_rows($rs);
if($row){
?>
<script>
<?php echo $f_array[13]?>	
</script>
	 <div class="box"> 
      <?php echo $f_array[14]?><b><?php echo $row ?></b>  <?php echo $f_array[15]?>[ <a href='dls_message_manage.php'><?php echo $f_array[16]?></a> ] 
      <embed src=/image/sound.swf loop=false hidden=true volume=50 autostart=true width=0 height=0  name=foobar mastersound=mastersound></embed> 
	  </div> 
<?php
}

?>
      <?php
$sql="select id from zzcms_guestbook where saver='".@$username."' and looked=0 and passed=1";
$rs=query($sql);
$row=num_rows($rs);
if($row){
?>
<script>
<?php echo $f_array[17]?>		
</script>
	 <div class="box"> 
       <?php echo $f_array[14]?> <b><?php echo $row ?></b>  <?php echo $f_array[18]?>[ <a href='ztliuyan.php'><?php echo $f_array[16]?></a> ] 
      <embed src=/image/sound.swf loop=false hidden=true volume=50 autostart=true width=0 height=0  name=foobar mastersound=mastersound></embed> 
	  </div> 
<?php
}
?>
</div>
</div>
</div>
</div>
</div>

</body>
</html>
</body>
</html>