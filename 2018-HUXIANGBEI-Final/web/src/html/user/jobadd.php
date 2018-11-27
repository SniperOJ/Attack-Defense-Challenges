<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/jobadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
if (str_is_inarr(usergr_power,'job')=="no" && $usersf=='个人'){
echo $f_array[0];
exit;
}
?>
<title><?php echo $f_array[2]?></title>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[1]?>
}	
function doClick_E(o){
	 var id,e;
	id=0;
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
function addSrcToDestList() {
}	 
</script>
</head>
<link href="style/<?php echo siteskin_usercenter?>/style.css" rel="stylesheet" type="text/css">
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
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<form  action="jobsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" valign="top" class="border"><?php echo $f_array[3]?></td>
            <td valign="middle" class="border" > 
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td> <fieldset class="fieldsetstyle">
                    <legend><?php echo $f_array[4]?></legend>
                    <?php
        $sql = "select * from zzcms_jobclass where parentid='0' order by xuhao asc";
		$rs = query($sql,$conn); 
		$n=0;
		while($row= fetch_array($rs)){
		
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classid']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classid]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this)' value='$row[classid]'/><label for='E$n'>$row[classname]</label>";
		}
		
	}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sql="select * from zzcms_jobclass where parentid=0 order by xuhao asc";
$rs = query($sql,$conn); 
$n=0;
while($row= fetch_array($rs)){
$n ++;
if (@$_SESSION['bigclassid']==$row["classid"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset class='fieldsetstyle'><legend>".$f_array[5]."</legend>";

$sqln="select * from zzcms_jobclass where parentid='$row[classid]' order by xuhao asc";
$rsn = query($sqln,$conn); 
$nn=0;
while($rown= fetch_array($rsn)){
$nn ++;
echo "<input name='smallclassid' id='radio$nn$n' type='radio' value='$rown[classid]' />";
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
            <td align="right" class="border" ><?php echo $f_array[6]?></td>
            <td class="border" ><input name="jobname" type="text" id="jobname" class="biaodan" size="50" maxlength="255" /></td>
          </tr>
		
          <tr> 
            <td align="right" class="border" > <?php echo $f_array[7]?></td>
            <td class="border" > <textarea name="sm" cols="80%" rows="10" class="biaodan" style="height:auto"></textarea></td>
          </tr>
          <tr> 
            <td align="right" class="border2"><?php echo $f_array[8]?></td>
            <td class="border2">       
<select name="province" id="province" class="biaodan"></select>
<select name="city" id="city" class="biaodan"></select>
<select name="xiancheng" id="xiancheng" class="biaodan"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION['city']?>', '<?php echo @$_SESSION['xiancheng']?>');
</script>
</td>
          </tr>
		  	    
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="action" type="hidden" id="action2" value="add" /> 
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[9]?>" /></td>
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