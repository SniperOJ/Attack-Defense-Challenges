<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<?php
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';
$s=isset($_REQUEST["s"])?$_REQUEST["s"]:'';

if (@$_REQUEST["action"]=="px"){
checkadminisdo("adv");
if ($s==''){
echo "<script>alert('请先选择广告小类别，只能在某一个小类别下排序');history.back()</script>";
exit;
}
$sql="select xuhao,id from zzcms_ad where bigclassname='$b' and smallclassname='$s'";
$rs = query($sql); 
while($row = fetch_array($rs)){
$xuhao=$_POST["xuhao".$row["id"]];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhao) == "" || is_numeric($xuhao) == false) {
	       $xuhao = 0;
	   }elseif ($xuhao< 0){
	       $xuhao = 0;
	   }else{
	       $xuhao = $xuhao;
	   }
query("update zzcms_ad set xuhao=$xuhao where id=".$row['id']."");
}
}
?>
<div class="admintitle">广告排序</div>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td class="border"><table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td style="color:#999999"> 
            <?php	
$sql="select * from zzcms_adclass where parentid='A' order by xuhao";
$rs = query($sql); 
$row = num_rows($rs);
if (!$row){
echo '暂无分类';
}else{
echo "大类：";
while($row = fetch_array($rs)){
echo "<a href=?b=".$row['classname'].">";  
	if ($row["classname"]==$b) {
	echo "<b>".$row["classname"]."</b>";
	}else{
	echo $row["classname"];
	}
	echo "</a> | ";  
 }
} 
echo "<br>";

$sql="select * from zzcms_adclass where parentid='".$b."' order by xuhao";
$rs = query($sql); 
$row = num_rows($rs);
if (!$row){
echo '暂无分类';
}else{
echo "小类：";
while($row = fetch_array($rs)){
echo "<a href=?b=".$b."&s=".$row['classname'].">";  
	if ($row["classname"]==$s) {
	echo "<b>".$row["classname"]."</b>";
	}else{
	echo $row["classname"];
	}
	echo "</a> | ";  
 }
} 
 ?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$sql="select * from zzcms_ad where id<>0 ";
if ($b<>"") {  		
$sql=$sql." and bigclassname='".$b."' ";
}
if ($s<>"") {  		
$sql=$sql." and smallclassname='".$s."' ";
}
$sql=$sql . " order by xuhao asc, id asc ";
$rs = query($sql,$conn);
$row= num_rows($rs);  
if(!$row){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="?action=px">
  <div class="border"> 
    <input name="submit2" type="submit" class="buttons" id="submit22"  value="更新序号">
    <input name="b" type="hidden" id="b" value="<?php echo $b?>">
	<input name="s" type="hidden" id="s" value="<?php echo $s?>">
    提示：在表单内填上每条信息的序号（0-9999）广告将会按顺序排列，然后点击 
    <input name="submit22" type="submit" class="buttons" id="submit23"  value="更新序号">
  </div>
  <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <tr> 
      <td width="5%" align="center" class="border">序号</td>
      <td width="10%" class="border">所属类别</td>
      <td width="10%" class="border">标题</td>
      <td width="5%" class="border">图片</td>
      <td width="5%" class="border">&nbsp;</td>
    </tr>
    <?php
$n=1;
while($row = fetch_array($rs)){
?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td align="center"><input name='<?php echo "xuhao".$row["id"]?>' type="text" value="<?php echo $row["xuhao"]?>" size="4" maxlength="4"></td>
      <td><a href=?b=<?php echo $row['bigclassname']?>><?php echo $row["bigclassname"]?></a>
	  -
		<a href=?b=<?php echo $row['bigclassname']?>&s=<?php echo $row['smallclassname']?>> <?php echo $row["smallclassname"]?></a></td>
      <td style="color:#666666"><?php echo addzero($n,2)?>-<a href='<?php echo $row["link"]?>' target="_blank"><?php echo $row["title"]?></a></td>
      <td> 
        <?php
if ($row["img"]<>""){
	if (strpos("gif|jpg|png|bmp",substr($row["img"],-3))>=0) {
	$str="<img src='".$row["img"]."' width=100'  border='0'/>";
	}elseif (substr($row["img"],-3)=="swf"){
	$str="<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0'  width='".$row["imgwidth"]."' height='".$row["imgheight"]."'>";
	$str=$str."<param name='movie' value='".$row["img"]."'>";
	$str=$str."<param name='quality' value='high'>";
	$str=$str."<embed src='".$row["img"]."' width='".$row["imgwidth"]."' height='".$row["imgheight"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed></object>";
	}
	echo $str;
}else{
	echo "文字广告-无图片";
}	
	?>      </td>
      <td> <a href="ad_modify.php?b=<?php echo $b?>&id=<?php echo $row["id"]?>">修改</a></td>
    </tr>
    <?php
$n++;
}
?>
  </table>
  <div class="border"> 
    <input name="submit23" type="submit" class="buttons" id="submit2"  value="更新序号">
    提示：在表单内填上每条信息的序号（0-9999）广告将会按顺序排列，然后点击 
    <input name="submit222" type="submit" class="buttons" id="submit222"  value="更新序号">
  </div>
</form>
<?php
}
?>
</body>
</html>