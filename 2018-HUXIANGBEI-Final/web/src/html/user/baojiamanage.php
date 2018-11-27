<?php
include("../inc/conn.php");
include("../inc/fy.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>报价信息管理</title>
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
<div class="admintitle"><span><form name="form1" method="post" action="?">
产品名称：<input name="cpmc" type="text" id="cpmc2"> <input type="submit" name="Submit" value="查找">
</form></span>报价信息管理</div>
<?php
if( isset($_GET["page"]) && $_GET["page"]!="") {
    $page=$_GET['page'];
}else{
    $page=1;
}

$cpmc = isset($_POST['cpmc'])?trim($_POST['cpmc']):"";
$page_size=pagesize_ht;  //每页多少条数据
$offset=($page-1)*$page_size;
$sql="select count(*) as total from zzcms_baojia where editor='".$username."' ";
$sql2='';
if ($cpmc<>''){
$sql2=$sql2 . " and cp like '%".$cpmc."%' ";
}
$rs = query($sql.$sql2); 
$row = fetch_array($rs);
$totlenum = $row['total'];
$totlepage=ceil($totlenum/$page_size);

$sql="select id,cp,price,danwei,province,city,xiancheng,passed,sendtime from zzcms_baojia where editor='".$username."' ";
$sql=$sql.$sql2;
$sql=$sql . " order by id desc limit $offset,$page_size";
$rs = query($sql); 
if(!$totlenum){
echo '暂无信息';
}else{
?>
<form name="myform" method="post" action="del.php">
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr> 
            <td width="10%" height="25" class="border">产品名称或标题</td>
            <td width="5%" align="center" class="border">价格</td>
            <td width="5%" align="center" class="border">区域</td>
            <td width="5%" align="center" class="border">更新时间</td><td width="5%" align="center" class="border">信息状态</td><td width="5%" align="center" class="border">操作</td><td width="5%" align="center" class="border">删除</td>
          </tr>
          <?php
while($row = fetch_array($rs)){
?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td><a href="<?php echo getpageurl("baojia",$row["id"])?>" target="_blank"><?php echo $row["cp"]?></a></td>
            <td align="center" title='<?php echo $row["city"]?>'><?php echo $row["price"].$row["danwei"]?></td>
            <td align="center" title='<?php echo $row["city"]?>'> <?php echo $row["province"].$row["city"].$row["xiancheng"]?></td>
            <td align="center"><?php echo $row["sendtime"]?></td>
            <td align="center"> 
              <?php 
	if ($row["passed"]==1 ){ echo '已审核';}else{ echo '<font color=red>待审</font>';}
	
	  ?>            </td>
            <td align="center" > 
              <a href="baojiamodify.php?id=<?php echo $row["id"]?>&page=<?php echo $page?>">修改</a></td>
            <td align="center" ><input name="id[]" type="checkbox" id="id" value="<?php echo $row["id"]?>" /></td>
          </tr>
          <?php
}
?>
        </table>

<div class="fenyei">
<?php echo showpage()?>     
          <input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
          <label for="chkAll">全选</label>
         
        <input name="submit"  type="submit" class="buttons"  value="删除" onClick="return ConfirmDel()"> 
        <input name="pagename" type="hidden" id="page2" value="baojiamanage.php?page=<?php echo $page ?>"> 
		<input name="tablename" type="hidden" id="tablename" value="zzcms_baojia"> 
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