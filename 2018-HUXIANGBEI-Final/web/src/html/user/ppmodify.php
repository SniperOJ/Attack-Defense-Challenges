<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/ppmodify.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
<?php
if (str_is_inarr(usergr_power,'pp')=="no" && $usersf=='个人'){
echo $f_array[11];
exit;
}
?>
<title></title>
<script language = "JavaScript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>
}

function doClick_E(o){
	 var id;
	 var e;
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
<?php
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}
if (isset($_REQUEST["id"])){
$id=$_REQUEST["id"];
}else{
$id=0;
}

$sql="select * from zzcms_pp where id='$id'";
$rs = query($sql); 
$row = fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<div class="content">
<div class="admintitle"><?php echo $f_array[1]?></div>
<form action="ppsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[2]?></td>
            <td class="border" > <input name="name" type="text" id="name" class="biaodan" value="<?php echo $row["ppname"]?>" size="60" maxlength="45" onclick="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';"></td>
          </tr>
          <tr> 
            <td width="18%" align="right" valign="top" class="border2" ><br>
              <?php echo $f_array[4]?></td>
            <td width="82%" class="border2" > <table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset class="fieldsetstyle">
                    <legend><?php echo $f_array[5]?></legend>
                    <?php
        $sqlB = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rsB = query($sqlB,$conn); 
		$n=0;
		while($rowB= fetch_array($rsB)){
		$n ++;
		if ($row['bigclasszm']==$rowB['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' checked/><label for='E$n'>$rowB[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$rowB[classzm]' /><label for='E$n'>$rowB[classname]</label>";
		}
		}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sqlB="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
$rsB = query($sqlB,$conn); 
$n=0;
while($rowB= fetch_array($rsB)){
$n ++;
if ($row["bigclasszm"]==$rowB["classzm"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset class='fieldsetstyle'><legend>".$f_array[6]."</legend>";
$sqlS="select * from zzcms_zsclass where parentid='$rowB[classzm]' order by xuhao asc";
$rsS = query($sqlS,$conn); 
$nn=0;
while($rowS= fetch_array($rsS)){
$nn ++;
if ($row['smallclasszm']==$rowS['classzm']){
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' checked/>";
}else{
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rowS[classzm]' />";
}
echo "<label for='radio$nn$n'>$rowS[classname]</label>";
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
            <td class="border" > <textarea name="sm" cols="100%" rows="10" id="sm" class="biaodan" style="height:auto" onclick="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[3]?>') {this.value=''};this.style.backgroundColor='';"><?php echo $row["sm"] ?></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[8])?> 
 <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"] ?>"> 
              <input name="img"type="hidden" id="img" value="<?php echo $row["img"] ?>"></td>
            <td class="border" > <table height="140"  width="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
                    <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>".$f_array[11];
				  }else{
				  echo "<input name='Submit2' type='button'  value='".$f_array[9]."'/>";
				  }
				  ?>                  </td>
                </tr>
              </table></td>
          </tr>
         
		   
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="ypid" type="hidden" id="ypid2" value="<?php echo $row["id"] ?>"> 
              <input name="action" type="hidden" id="action2" value="modify"> 
              <input name="page" type="hidden" id="action" value="<?php echo $page ?>"> 
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[10]?>"></td>
          </tr>
        </table>
	  </form>
<?php
unset ($f_array);
?>	  
</div>
</div>
</div>
</div>
</body>
</html>