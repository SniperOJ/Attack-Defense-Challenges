<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
$fpath="text/dls_message_manage.txt";
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<title><?php echo channeldl.$f_array[0]?></title>
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
if (isset($_POST["lxr"])){ 
$lxr=trim($_POST["lxr"]);
}else{
$lxr="";
}
?>
<div class="content">
<div class="admintitle">
<span>
<form name="form1" method="post" action="?">
<?php echo $f_array[1]?> <input name="lxr" type="text" id="lxr2" value="<?php echo $lxr?>"> 
<input type="submit" name="Submit" value="<?php echo $f_array[2]?>">
</form>
</span>
<?php echo channeldl.$f_array[0]?></div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}
if (isset($_GET['page_size'])){
$page_size=$_GET['page_size'];
}else{
$page_size=pagesize_ht;  //每页多少条数据
}
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_dl where passed=1 and del=0 and saver='".$username."' ";
$sql2='';
if ($lxr<>"") {
$sql2=$sql2."and name like '%".$lxr."%' ";
}

$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select * from zzcms_dl where passed=1 and del=0 and saver='".$username."' ";
$sql=$sql.$sql2;
$sql=$sql." order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
echo  $f_array[3];
}else{
?>
<form action="" method="post" name="myform" id="myform">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
    <tr> 
     <?php echo $f_array[4]?>    </tr>
          <?php
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td><?php echo $row["dlsname"]?></td>
      <td><?php echo $row["province"].$row["city"]?></td>
      <td><?php echo $row["cp"]?></td>
      <td><?php echo $row["sendtime"]?></td>
      <td align="center"><?php if($row["looked"]==0) { echo  $f_array[5];}else{echo  $f_array[15];}?></td>
      <td align="center"><a href="dls_show.php?id=<?php echo $row["id"]?>" target="_blank"><?php echo $f_array[6]?></a></td>
      <td align="center"><input name="id[]" type="checkbox" id="id[]" value="<?php echo $row["id"]?>" /></td>
    </tr>
    <?php
}
?>
</table>
<div class="fenyei"  >
<?php echo showpage()?> 
          <select name="FileExt" id="FileExt">
          <option selected="selected" value="xls"><?php echo $f_array[7]?></option>
          <option value="xls"><?php echo $f_array[8]?></option>
          <option value="doc"><?php echo $f_array[9]?></option>
        </select> <select name="page_size" id="page_size" onChange="MM_jumpMenu('self',this,0)">
          <option value="?page_size=10" <?php if ($page_size==10) { echo "selected";}?>>10<?php echo $f_array[10]?></option>
          <option value="?page_size=20" <?php if ($page_size==20) { echo "selected";}?>>20<?php echo $f_array[10]?></option>
          <option value="?page_size=50" <?php if ($page_size==50) { echo "selected";}?>>50<?php echo $f_array[10]?></option>
          <option value="?page_size=100" <?php if ($page_size==100) { echo "selected";}?>>100<?php echo $f_array[10]?></option>
          <option value="?page_size=200" <?php if ($page_size==200) { echo "selected";}?>>200<?php echo $f_array[10]?></option>
        </select>
<input name="submit2"  type="submit" class="buttons"  value="<?php echo $f_array[11]?>" onclick="myform.action='dls_print.php';myform.target='_blank'" />
<input name="submit22"  type="submit" class="buttons"  value="<?php echo $f_array[12]?>" onclick="myform.action='dls_download.php';myform.target='_blank'" />
<input name="submit"  type="submit" class="buttons" value="<?php echo $f_array[13]?>" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" > 
              <input name="pagename" type="hidden" id="page2" value="dls_message_manage.php?page=<?php echo $page ?>" /> 
              <input name="tablename" type="hidden" id="tablename" value="zzcms_dlly" />
              <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
              <label for="chkAll"><?php echo $f_array[14]?></label> 
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