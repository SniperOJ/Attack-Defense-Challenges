<?php
include("admin.php");
include("../inc/fy.php");
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
$action=isset($_REQUEST["action"])?$_REQUEST["action"]:'';
$page=isset($_GET["page"])?$_GET["page"]:1;
$keyword=isset($_REQUEST["keyword"])?$_REQUEST["keyword"]:'';
$kind=isset($_REQUEST["kind"])?$_REQUEST["kind"]:'';
$b=isset($_REQUEST["b"])?$_REQUEST["b"]:'';
$s=isset($_REQUEST["s"])?$_REQUEST["s"]:'';
?>
<div class="admintitle">广告管理</div>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" class="border"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='ad_add.php'" value="添加广告"></td>
          <td align="right">
<form name="form1" method="post" action="?">
              <input name="kind" type="radio" id="kind_ggz" value="ggz"  <?php if ($kind=='ggz'){ echo 'checked';}?>>
              <label for="kind_ggz">按广告主</label>
              <input name="kind" type="radio" value="title" id="kind_title"  <?php if ($kind=='title'){ echo 'checked';}?>>
              <label for="kind_title">按标题</label>
              <input name="keyword" type="text" id="keyword" value="<?php echo $keyword?>">
              <input type="submit" name="Submit" value="查寻">
              <a href="?action=showendtime">到期的广告</a> </form></td>
        </tr>
      </table></td>
  </tr>
</table>
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
echo '';
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
  <tr> 
    <td bgcolor="#FFFFFF" class="border2"> <strong>前台调用代码示例：</strong> 
        <input name="js" type="text" id="js" style="width:240px" value="{#showad:b,s,40,198,117,12,yes}" size="40" maxlength="255">
    把这个代码放到网站模板页中，广告就可以在网页中显示了。<img src="../image/help.gif" alt="help" width="45" height="18" onMouseOver="showfilter2(help)" onMouseOut="showfilter2(help)">
	<div id="help">参数说明：<br>b：广告大类名<br>s：广告小类名<br>40：显示前40条数，0为不限制<br>198：图片宽度<br>117：图片高度<br>12：广告标题长度，设为0则不显示文字<br>yes：是否显示广告标题前的数字序号(yes,no)</div></td>
  </tr>
</table>
<?php
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select * from zzcms_ad where id<>0 ";
if ($b<>"") {  		
$sql=$sql." and bigclassname='".$b."' ";
}

if ($s<>"") {  		
$sql=$sql." and smallclassname='".$s."' ";
}

if ($keyword<>"") {
	switch ($kind){
	case "ggz";
	$sql=$sql. " and username like '%".$keyword."%' ";
	break;
	case "title";
	$sql=$sql. " and title like '%".$keyword."%'";
	break;		
	default:
	$sql=$sql. " and title like '%".$keyword."%'";
	}
}

if ($action=="showendtime") {
$sql="select * from zzcms_ad where endtime< '".date('Y-m-d')."' ";
}
$rs = query($sql,$conn); 
$totlenum= num_rows($rs);  
$totlepage=ceil($totlenum/$page_size);

$sql=$sql . " order by xuhao asc,id asc limit $offset,$page_size";
$rs = query($sql,$conn); 
if(!$totlenum){
echo "暂无信息";
}else{
?>
<form name="myform" id="myform" method="post" action="">
  <div class="border">
        <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
    <input name="pagename" type="hidden"  value="ad_manage.php?b=<?php echo $b?>&page=<?php echo $page ?>">
    <input name="tablename" type="hidden"  value="zzcms_ad">
  </div>
<table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr> 
      <td width="45" align="center" class="border">选择</td>
    <td width="156" class="border">所属类别</td>
    <td width="277" class="border">标题</td>
    <td width="243" class="border">图片</td>
    <td width="142" class="border">广告主用户名</td>
    <td width="96" class="border">是否可抢占</td>
    <td width="246" align="center" class="border">广告期限</td>
    <td width="141" align="center" class="border">操作</td>
  </tr>
<?php
$n=1;
while($row = fetch_array($rs)){
?>
  <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td width="45" align="center"><input name="id[]" type="checkbox"  value="<?php echo $row["id"]?>"></td>
    <td width="156"><a href=?b=<?php echo $row['bigclassname']?>> <?php echo $row["bigclassname"]?></a>
	- <a href=?b=<?php echo $row['bigclassname']?>&s=<?php echo $row['smallclassname']?>><?php echo $row["smallclassname"]?></a></td>
    <td width="277" style="color:#666666"><?php echo addzero($n,2)?>-<a href='<?php echo $row["link"]?>' target="_blank" style="color:<?php echo $row["titlecolor"]?>"><?php echo $row["title"]?></a>
	<?php if ($row["endtime"]<=date('Y-m-d H:i:s')) echo '<span style="color:red">(已到期)</span>';?>
	</td>
    <td width="243">
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
	?>
	</td>
    <td width="142"><a href="usermanage.php?keyword=<?php echo $row["username"]?>"><?php echo $row["username"]?></a></td>
    <td width="96"> 
	<?php
	if ($row["elite"]==0){
	echo "<font color=green>可抢占</font>"; 
	}elseif ($row["elite"]==1){
	echo  "<font color=red>不可抢占</font>" ;  
	}
	?> </td>
    <td width="246" align="center"><?php echo date("Y-m-d",strtotime($row["starttime"]))?>至<?php echo date("Y-m-d",strtotime($row["endtime"]))?></td>
      <td width="141" align="center" class="docolor"> <a href="ad_modify.php?b=<?php echo $b?>&page=<?php echo $page?>&id=<?php echo $row["id"]?>">修改</a> 
        | <a href="ad_px.php?b=<?php echo $row['bigclassname']?>&s=<?php echo $row['smallclassname']?>">排序</a> 
      </td>
  </tr>
<?php
$n++;
}
?>
</table>
<div class="border">
<input name="chkAll" type="checkbox" id="chkAll" onClick="CheckAll(this.form)" value="checkbox">
全选 <input type="submit" onClick="myform.action='del.php';myform.target='_self';return ConfirmDel()" value="删除选中的信息">
  </div>
</form>
<div class="border center"><?php echo showpage_admin()?></div>
<?php
}

?>
</body>
</html>