<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zspx.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
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
<?php

if (@$_REQUEST["action"]=="px"){
$sql="select xuhao,id from zzcms_main where editor='".$username."'";
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
query("update zzcms_main set xuhao=$xuhao where id=".$row['id']."");
}
}
?>
<div class="content">
<div class="admintitle"><?php echo channelzs.$f_array[0]?></div>
 <?php
$sql="select * from zzcms_main where editor='".$username."' order by xuhao desc";
$rs = query($sql); 
?>
<form action="?action=px" method="post" name="form" id="form" >
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td> <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td class="border"> 
              <input name="submit2" type="submit" class="buttons" id="submit22"  value="<?php echo $f_array[1]?>">
              <?php echo $f_array[2]?>
              <input name="submit22" type="submit" class="buttons" id="submit23"  value="<?php echo $f_array[1]?>">
              </td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="bgcolor">
          <tr> 
            <?php echo $f_array[3]?>
          </tr>
         <?php
		 while($row = fetch_array($rs)){
		 ?>
          <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)"> 
            <td width="75" align="center"> <input name='<?php echo "xuhao".$row["id"]?>' type="text" value="<?php echo $row["xuhao"]?>" size="4" maxlength="4"> 
            </td>
            <td width="431"><a href="<?php echo getpageurl("zs",$row["id"])?>" target="_blank"><?php echo $row["proname"]?></a></td>
            <td width="479" align="center"><a href="<?php echo "/".$row["img"]?>" target="_blank"><img src="<?php echo $row["img"]?>" width="60" height="60" border="0"></a></td>
          </tr>
        <?php
		}
		?>
        </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="1" class="border">
          <tr > 
            <td> <input name="submit" type="submit" class="buttons" id="submit"  value="<?php echo $f_array[1]?>">
                    <?php echo $f_array[2]?>
<input name="submit23" type="submit" class="buttons" id="submit24"  value="<?php echo $f_array[1]?>">
              </td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</div>
</div>
</div>
</div>

</body>
</html>