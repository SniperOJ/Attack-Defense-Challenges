<?php include("admin.php"); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language = "JavaScript" src="/js/gg.js"></script>
</head>
<body>
<?php
checkadminisdo("advtext");
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
checkid($id);
}else{
$id=0;
}
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if (isset($_REQUEST["page"])){
$page=$_REQUEST["page"];
}else{
$page=1;
}
if ($action=="modify"){
$adv=trim($_POST["adv"]);
$advlink=trim($_POST["advlink"]);
$img=trim($_POST["img"]);
$oldimg=$_POST["oldimg"];

query("update zzcms_textadv set adv='$adv',advlink='$advlink',img='$img',passed=1 where id='$id'");
$rs=query("select * from zzcms_textadv where id='$id'");
$row=fetch_array($rs);
$advusername=$row["username"];
query("update zzcms_ad set title='$adv',link='$advlink',img='$img' where username=".$advusername."");//如果抢占了广告位了，同时更改
	if ($oldimg<>$img && $oldimg<>"/image/nopic.gif" ){
	$f="../".$oldimg;
		if (file_exists($f)){
		unlink($f);		
		}
	}
	echo "<script>alert('修改成功');window.location.href='adv_manage.php?page=".$page."'</script>";
}
?>
<div class="admintitle">修改用户审请的文字广告</div>
<form name="myform" method="post" action="?action=modify">
  <?php
$rs=query("select * from zzcms_textadv where id='$id'");
$row=fetch_array($rs);
?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="20%" align="right" class="border"> <p><strong>广告内容<br>
          </strong>最多18个字符 </p></td>
      <td class="border"> <input name="adv" type="text" id="adv" value="<?php echo $row["adv"]?>" size="40" maxlength="20"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><strong>链接地址</strong><br>
        链接地址为本站站内链接 </td>
      <td class="border"> <input name="advlink" type="text" id="advlink" value="<?php echo $row["advlink"]?>" size="40"></td>
    </tr>
    <tr> 
      <td align="right" class="border"><strong>图片地址</strong> <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>"> 
      </td>
      <td class="border"> <input name="img" type="text" id="img" value="<?php echo $row["img"]?>" size="50"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border"><strong>上传图片</strong></td>
      <td class="border">
	   <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
              <?php
				 if ($row["img"]<>""){
						if (substr($row["img"],-3)=="swf"){
						$str=$str."<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='120' height='120'>";
						$str=$str."<param name='wmode' value='transparent'>";
						$str=$str."<param name='movie' value='".$row["img"]."' />";
						$str=$str."<param name='quality' value='high' />";
						$str=$str."<embed src='".$row["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='120'  height='120' wmode='transparent'></embed>";
						$str=$str."</object>";
						echo $str;
						}elseif (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false ){
                    	echo "<img src='".$row["img"]."' width='120'  border='0'> ";
                    	}
					}else{
                     echo "<input name='Submit2' type='button'  value='上传图片'/>";
                    }	
				  ?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border"><strong>显示效果</strong></td>
      <td class="border"> 
        <?php if ($row["adv"]<>""){ echo "<a href='".$row["advlink"]."' target='_blank'>".$row["adv"]."</a>";}?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" align="center" class="border"><input name="page" type="hidden" id="page" value="<?php echo $page?>"> 
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>"> 
        <input type="submit" name="Submit2" value="修改"> </td>
    </tr>
  </table>
</form>
</body>
</html>