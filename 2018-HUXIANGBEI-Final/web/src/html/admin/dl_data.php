<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<title></title>
<script language="JavaScript" src="/js/gg.js"></script>
</head>
<body>
<?php 
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if ($action=="del") {
$fp="../dl_excel/".$_GET["filename"];
	if (file_exists($fp)){
	unlink($fp);
	}else{
	echo "<script>alert('请选择要删除的标签');history.back()</script>";
	}	
}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">从excel导入<?php echo channeldl?>商信息</td>
  </tr>
</table>
<div class="border2" style="padding:10px"> <strong>第一步：调整列顺序,字段名可以不同，少字段也可以<br>
  </strong>列顺序为：ID，<?php echo channeldl?>商姓名，电话，Email，<?php echo channeldl?>产品，<?php echo channeldl?>区域，<?php echo channeldl?>商简介<br>
    <strong>第二步：上传调整过列顺序的Excel表格文件到/dl_excel目录</strong>
  </div>
<form action="" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="462" class="border" >文件名</td>
      <td width="687" class="border" > <div class="boxlink">文件大小</div></td>
      <td width="252" class="border" >操作</td>
    </tr>
	<?php
	$dir = opendir("../dl_excel");
while(($file = readdir($dir))!=false){
 if ($file!="." && $file!="..") { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。
	?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
      <td  > 
        <?php
		echo "<a>".$file."</a>";
		?>
      </td>
      <td ><?php 
	  $fp="../dl_excel/".$file;
	  echo filesize($fp)/1024 ?>K</td>
      <td  ><a href="dl_data_add.php?filename=<?php echo $file?>">导入到数据库</a> | <a href="?action=del&filename=<?php echo $file?>">删除</a></td>
    </tr>
	<?php
	}
	}
closedir($dir);	 	
	?>
  </table>
      </form>
		  				   	 
</body>
</html>
