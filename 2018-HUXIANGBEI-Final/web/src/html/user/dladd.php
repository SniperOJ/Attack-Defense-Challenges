<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/dladd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo str_replace("{#channeldl}",channeldl,$f_array[1])?></title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});
</script>
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[0]?>
var v = '';
for(var i = 0; i < document.myform.destList.length; i++){
if(i==0){
v = document.myform.destList.options[i].text;
}else{
v += ','+document.myform.destList.options[i].text;
}
}
//alert(v);
document.myform.cityforadd.value=v; 
}
function showsubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none"){
eval("submenu" + sid + ".style.display=\"\";");
}
}
function hidesubmenu(sid){
whichEl = eval("submenu" + sid);
if (whichEl.style.display == ""){
eval("submenu" + sid + ".style.display=\"none\";");
   }
}
</SCRIPT>
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
<div class="admintitle"><?php echo str_replace("{#channeldl}",channeldl,$f_array[1])?></div>
<?php
$tablename="zzcms_dl";//checkaddinfo中用
include("checkaddinfo.php");
?>
<form action="dlsave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="3" cellspacing="1">
    <tr> 
      <td width="18%" align="right" class="border"><?php echo $f_array[2]?></td>
      <td width="82%" class="border"> <input name="cp" type="text" id="cp" class="biaodan" size="60" maxlength="60">
	  <?php echo $f_array[20]?>      </td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[3]?></td>
      <td class="border2">
	   <select name="classid" class="biaodan">
          <option value="" selected><?php echo $f_array[4]?> </option>
          <?php
		$sql="select * from zzcms_zsclass where parentid='A'";
		$rs=query($sql);
		while($row= fetch_array($rs)){
			?>
          <option value="<?php echo $row["classzm"]?>"<?php if (@$_SESSION['bigclassid']==$row["classzm"]){echo 'selected';}?>><?php echo $row["classname"]?></option>
          <?php
		  }
		  ?>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo $f_array[5]?></td>
            <td class="border"><table border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td><script language="JavaScript" type="text/javascript">
function addSrcToDestList() {
destList = window.document.forms[0].destList;
city = window.document.forms[0].xiancheng;
var len = destList.length;
for(var i = 0; i < city.length; i++) {
if ((city.options[i] != null) && (city.options[i].selected)) {
var found = false;
for(var count = 0; count < len; count++) {
if (destList.options[count] != null) {
if (city.options[i].text == destList.options[count].text) {
found = true;
break;
}
}
}
if (found != true) {
destList.options[len] = new Option(city.options[i].text);
len++;
}
}
}
}
function deleteFromDestList() {
var destList = window.document.forms[0].destList;
var len = destList.options.length;
for(var i = (len-1); i >= 0; i--) {
if ((destList.options[i] != null) && (destList.options[i].selected == true)) {
destList.options[i] = null;
}
}
} 
            </script>
                   
<select name="province" id="province" class="biaodan"></select>
<select name="city" id="city" class="biaodan"></select>
<select name="xiancheng" id="xiancheng" class="biaodan" onchange="addSrcToDestList()"></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo @$_SESSION['province']?>', '<?php echo @$_SESSION["city"]?>', '<?php echo @$_SESSION["xiancheng"]?>');
</script>                
                  
                </td>
                <td align="center" valign="top"><?php echo $f_array[6]?><br/>
                  <select name="destList" size="4" multiple="multiple" style='width:100px;height:60px' class="biaodan">
                    <?php 
			  if (isset($_SESSION['xiancheng'])){
			  		if (strpos($_SESSION["xiancheng"],",")==0) {?>
                     <option value="<?php echo $_SESSION["xiancheng"]?>"><?php echo $_SESSION["xiancheng"]?></option>
                     <?php 
					 }else{
			  		$selectedcity=explode(",",$_SESSION["xiancheng"]);
						for ($i=0;$i<count($selectedcity);$i++){    ?>
                  		<option value="<?php echo $selectedcity[$i]?>"><?php echo $selectedcity[$i]?></option>
                      	<?php 
						}
					}
			}
			?>
                    </select>
                    <input name="cityforadd" type="hidden" id="cityforadd" /><br/>
                    <input name="button" type="button" onclick="javascript:deleteFromDestList();" value="<?php echo $f_array[7]?>" /></td>
              </tr>
            </table></td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[8]?></td>
      <td class="border2"> <textarea name="content" cols="60" rows="4" id="content" class="biaodan" style="height:auto"><?php echo @$_SESSION["content"]?></textarea>
      </td>
    </tr>
	<?php
	$sql="select * from zzcms_user where username='".$username."'";
	$rs=query($sql);
	$row= fetch_array($rs);
	?>
    <tr> 
      <td align="right" class="border"><?php echo $f_array[9]?></td>
      <td class="border"><input name="dlsf" id="dlsf_company" type="radio" value="<?php echo $f_array[10]?>" onclick="showsubmenu(1)">
         <label for="dlsf_company"><?php echo $f_array[10]?></label>
        <input name="dlsf" type="radio" id="dlsf_person" onclick="hidesubmenu(1)" value="<?php echo $f_array[11]?>" checked>
          <label for="dlsf_person"><?php echo $f_array[11]?></label></td>
    </tr>
    <tr style="display:none" id='submenu1'>
      <td align="right" class="border"><?php echo $f_array[12]?></td>
      <td class="border"><input name="company" type="text" class="biaodan" value="<?php echo $row["comane"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[13]?></td>
      <td class="border2">
<input name="truename" type="text" id="truename" class="biaodan" value="<?php echo $row["somane"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo $f_array[14]?></td>
      <td class="border"><input name="tel" type="text" id="tel" class="biaodan" value="<?php echo $row["phone"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[15]?></td>
      <td class="border2">
<input name="address" type="text" id="address" class="biaodan" value="<?php echo $row["address"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border"><?php echo $f_array[16]?></td>
      <td class="border"><input name="email" type="text" id="email" class="biaodan" value="<?php echo $row["email"]?>" size="45" maxlength="255" /></td>
    </tr>
    <tr> 
      <td align="right" class="border2"><?php echo $f_array[17]?></td>      
            <td class="border2"><input name="yzm" type="text" class="biaodan" id="yzm" tabindex="10" value="" size="10" maxlength="50" style="width:60px"/>
              <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="<?php echo $f_array[18]?>" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[19]?>">
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

session_write_close();
?>
</body>
</html>