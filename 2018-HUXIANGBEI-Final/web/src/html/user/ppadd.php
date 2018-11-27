<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/ppadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<?php
if (str_is_inarr(usergr_power,'pp')=="no" && $usersf=='个人'){
echo $f_array[11];
exit;
}
?>
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>
} 

function doClick_E(o){
	 var id;
	 var e;
	id=0
	 for(var i=1;i<=document.myform.bigclassid.length;i++){
	   id ="E"+i;
	   e = document.getElementById("E_con"+i);
	   if(id != o.id){
	   	 e.style.display = "none";		
	   }else{
		e.style.display = "block";
	   }
	 }
	   if(id==0){
		document.getElementById("E_con1").style.display = "block";
	   }
	 //document.write(classnum)
	 }
</script>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
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
<div class="admintitle"><?php echo $f_array[1]?></div>
<?php
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<form  action="ppsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border2" ><?php echo $f_array[2]?></td>
            <td class="border2" > <input name="name" type="text" id="name" class="biaodan" onclick="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="45" /></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border"><?php echo $f_array[4]?></td>
            <td valign="middle" class="border" > 
			<table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset class="fieldsetstyle">
                    <legend><?php echo $f_array[5]?></legend>
                    <?php
        $sql = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rs = query($sql,$conn); 
		$n=0;
		while($row= fetch_array($rs)){
		
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classzm]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classzm]'/><label for='E$n'>$row[classname]</label>";
		}
		
	}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sql="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
$rs = query($sql,$conn); 
$n=0;
while($row= fetch_array($rs)){
$n ++;
if (@$_SESSION['bigclassid']==$row["classzm"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset class='fieldsetstyle'><legend>".$f_array[6]."</legend>";

$sqln="select * from zzcms_zsclass where parentid='$row[classzm]' order by xuhao asc";
$rsn = query($sqln,$conn); 
$nn=0;
while($rown= fetch_array($rsn)){
$nn ++;
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rown[classzm]' />";
echo "<label for='radio$nn$n'>$rown[classname]</label>";
	if ($nn % 6==0) {
	echo "<br/>";
	}
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table></td>
          </tr>
		  
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[7]?></td>
            <td class="border" > <textarea name="sm" cols="100%" rows="10" id="sm" class="biaodan" style="height:auto" onclick="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';"></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[8])?><br /> 
 <input name="img" type="hidden" id="img" value="/image/nopic.gif"/></td>
            <td class="border" >
			 <table width="140" height="140" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td width="120" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> <input name="Submit2" type="button"  value="<?php echo $f_array[9]?>" /></td>
                </tr>
              </table></td>
          </tr>
        
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="action" type="hidden" id="action2" value="add" /> 
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[10]?>" /></td>
          </tr>
        </table>
</form>
<?php
session_write_close();
unset ($f_array);
?>
</div>
</div>
</div>
</div>
</body>
</html>