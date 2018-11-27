<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zhadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[2]?></title>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (str_is_inarr(usergr_power,'zh')=="no" && $usersf=='个人'){
echo $f_array[0];
exit;
}
?>
<script language="javascript" src="/js/timer.js"></script>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[1]?>
}    
	</script>
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
<div class="admintitle"><?php echo $f_array[2]?></div>
<?php
$tablename="zzcms_zh";//checkaddinfo中用
include("checkaddinfo.php");
?>
<form action="zhsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
              
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="15%" align="right" class="border2"><?php echo $f_array[3]?> </td>
            <td width="85%" class="border2"> <select name="bigclassid" id="bigclassid" class="biaodan">
                <option value="" selected="selected"><?php echo $f_array[4]?></option>
                <?php  
		$sql="select * from zzcms_zhclass";
		$rs=query($sql);
		while($row= fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>" ><?php echo $row["bigclassname"]?></option>
                <?php
		  }
		  ?>
            </select></td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo $f_array[5]?> </td>
            <td class="border"> <input name="title" type="text" id="title" size="50" maxlength="255" class="biaodan"> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[6]?></td>
            <td class="border2" > <input name="address" type="text" id="address" size="50" maxlength="255" class="biaodan"/></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[7]?></td>
            <td class="border" > <input name="timestart" type="text" id="timestart" class="biaodan" value="<?php echo date('Y-m-d')?>" onfocus="JTC.setday(this)" />
              - 
              <input name="timeend" type="text" id="timeend" class="biaodan" value="<?php echo date('Y-m-d')?>" onfocus="JTC.setday(this)" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[8]?></td>
            <td class="border2" > <textarea    name="content" id="content"></textarea> 
              <script type="text/javascript">
				CKEDITOR.replace('content');	
			</script> <input name="editor" type="hidden" id="editor" value="<?php echo $username?>" /> 
            </td>
          </tr>
          <tr> 
            <td align="right" class="border">&nbsp;</td>
            <td class="border"> <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[9]?>"> 
              <input name="action" type="hidden" id="action3" value="add"></td>
          </tr>
        </table>
</form>
</div>
</div>
</div>
</div>
<?php

unset ($f_array);
?>
</body>
</html>