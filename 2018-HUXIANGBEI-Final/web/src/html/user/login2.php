<?php
include("../inc/conn.php");
$fpath="text/login2.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
$fromurl="";
if (isset($_GET['fromurl'])){
$fromurl=$_GET['fromurl'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $f_array[0]?></title>
<style type="text/css">
<!--
body{margin:0;padding:0;font-size:12px}
.biaodan{height:18px;border:solid 1px #DDDDDD;width:150px;background-color:#FFFFFF}
-->
</style>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});
</script>
<script language=javascript>
	function CheckUserForm(){
	<?php echo $f_array[1]?>	
	}	
</script>
</head>
<body>

<form action='logincheck.php' method='post' name='UserLogin' onSubmit='return CheckUserForm();' target='_parent'>
<table width="100%" height="100" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td width="100" align="right"><label for="username"><?php echo $f_array[2]?></label></td>
        <td><input name="username" type="text" class="biaodan" id="username" tabindex="1" value="<?php  if (isset($_GET["username"])){ echo $_GET["username"];}?>" size="14" maxlength="255" />
        <a href="/reg/<?php echo getpageurl3("userreg")?>" target="_parent"><?php echo $f_array[3]?>	</a></td>
      </tr>
      <tr>
        <td width="100" align="right"><label for="password"><?php echo $f_array[4]?>	</label></td>
        <td><input name="password" type="password" class="biaodan" id="password" tabindex="2" size="14" maxlength="255" />
          <a href="/one/getpassword.php" target="_parent"><?php echo $f_array[5]?>	</a></td>
      </tr>
      <tr>
        <td width="100" align="right"><label for="yzm"><?php echo $f_array[6]?>	</label>        </td>
        <td><input name="yzm" type="text" id="yzm" value="" tabindex="3" size="10" maxlength="50" style="width:40px" class="biaodan"/>
        <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="<?php echo $f_array[7]?>	" /></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td><input name="CookieDate[]" type="checkbox" id="CookieDate2" value="1">
          <?php echo $f_array[8]?>
          <input name="fromurl" type="hidden" value="<?php echo $fromurl//这里是由上页JS跳转来的，无法用$_SERVER['HTTP_REFERER']?>" /></td>
      </tr>
      <tr>
        <td width="100" align="right">&nbsp;</td>
        <td><input type="submit" name="Submit" value="<?php echo $f_array[9]?>	" tabindex="4" /></td>
      </tr>
    </table>
</form>
 			  
</body>
</html>