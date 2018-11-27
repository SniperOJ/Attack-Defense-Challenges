<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
include("check.php");
$fpath="text/zsadd.txt";
$fcontent=file_get_contents($fpath);
$f_array=explode("|||",$fcontent) ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php
if (str_is_inarr(usergr_power,'zs')=="no" && $usersf=='个人'){
echo $f_array[0];//不返回到上一页，防止由user/index.php?goto='zsadd.php'过来的造成死循环提示
exit;
}
?>
<title><?php echo str_replace("{#channelzs}",channelzs,$f_array[4])?></title>
<script language = "JavaScript" src="/js/gg.js"></script>
<script src="/js/swfobject.js" type="text/javascript"></script> 
<script language = "JavaScript">
function CheckForm(){
<?php echo $f_array[1]?>
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

function showinfo(name, n){
	var chList=document.getElementsByName("ch"+name);
	var TextArea=document.getElementById(name);
	if(chList[n-1].checked) //数组从0开始
	{
		temp= TextArea.value; 
		TextArea.value = temp.replace(eval("document.getElementById(name+n).innerHTML"),"");
		TextArea.value+= eval("document.getElementById(name+n).innerHTML")
	}else{
		temp= TextArea.value; 
		TextArea.value = temp.replace(eval("document.getElementById(name+n).innerHTML"),"");
	}
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
 
function ValidSelect(checkboxselect){
<?php echo $f_array[2]?>	
}	

function isNumber(String){ 
var Letters = "1234567890";   //可以自己增加可输入值
var i;
var c;
for( i = 0; i<String.length;i ++ ){ 
c=String.charAt( i );
if(Letters.indexOf( c )> 0)
return  false;
}
return  true;
}
function  CheckNum(){ 
<?php echo $f_array[3]?>
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
<?php
$tablename="zzcms_main";
include("checkaddinfo.php");
?>
<script type="text/javascript" src="/js/jquery.js"></script>  
<script type="text/javascript" language="javascript">
$.ajaxSetup ({
cache: false //close AJAX cache
});
</script>
<script language="javascript">  
$(document).ready(function(){  
  $("#name").change(function() { //jquery 中change()函数  
	$("#span_szm").load(encodeURI("../ajax/zsadd_ajax.php?id="+$("#name").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
	$("#quote").load(encodeURI("/ajax/zstitlecheck_ajax.php?id="+$("#name").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});   
</script> 
<div class="content">
<div class="admintitle"><?php echo str_replace("{#channelzs}",channelzs,$f_array[4])?></div>
<form  action="zssave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td width="20%" align="right" class="border2" > <?php echo $f_array[5]?></td>
            <td class="border2" > <input name="name" type="text" id="name" class="biaodan" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="45" /><span id="quote"></span> 
             <span id="span_szm">  <input name="szm" type="hidden"  /></span>
              <?php echo $f_array[7]?></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border"><?php echo $f_array[8]?></td>
            <td valign="middle" class="border" > 
			<table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset class="fieldsetstyle">
                    <legend><?php echo $f_array[9]?></legend>
                    <?php
        $sql = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rs = query($sql,$conn); 
		$n=0;
		while($row= fetch_array($rs)){
		$n ++;
		if (@$_SESSION['bigclassid']==$row['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='$row[classzm]' checked/><label for='E$n'>$row[classname]</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='$row[classzm]'/><label for='E$n'>$row[classname]</label>";
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
echo "<fieldset class='fieldsetstyle'><legend>".$f_array[10]."</legend>";

$sqln="select * from zzcms_zsclass where parentid='$row[classzm]' order by xuhao asc";
$rsn = query($sqln,$conn); 
$nn=0;
while($rown= fetch_array($rsn)){
if (zsclass_isradio=='Yes'){
echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='$rown[classzm]' />";
}else{
echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='$rown[classzm]' onclick='javascript:ValidSelect(this)'/>";
}
echo "<label for='radio$nn$n'>$rown[classname]</label>";
$nn ++;	
if ($nn % 6==0) {echo "<br/>";}
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table></td>
          </tr>
		   <?php 
		  $rs = query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
		$row= num_rows($rs);
		if ($row){
		  ?>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[11]?></td>
            <td class="border2" > 
	<?php
	$n=0;
	while($row= fetch_array($rs)){
	$n ++;
	echo "<input name='shuxing' type='radio' id='shuxing$n' value='$row[bigclassid]'/><label for='shuxing$n'>$row[bigclassname]</label>";	
	}
	?>		</td>
          </tr>
		  <?php
		  }
		  ?>
          <tr>
            <td align="right" class="border2" ><?php echo $f_array[12]?></td>
            <td class="border2" ><textarea name="gnzz" cols="60" rows="4" id="gnzz" class="biaodan" style="height:auto" onclick="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='此处不能为空') {this.value=''};this.style.backgroundColor='';"></textarea></td>
          </tr>
         
		    <?php
	if (shuxing_name!=''){
	$shuxing_name = explode("|",shuxing_name);
	for ($i=0; $i< count($shuxing_name);$i++){
	?>
	<tr>
      <td align="right" class="border" ><?php echo $shuxing_name[$i]?>：</td>
      <td class="border" ><input name="sx[]" type="text" value="" size="45" class="biaodan"></td>
    </tr>
	<?php
	}
	}
	?>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[15]?></td>
            <td class="border" > 
			<textarea name="sm" id="sm" class="biaodan"></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>			</td>
          </tr>
          <tr> 
            <td align="right" class="border2"><?php echo channelzs.$f_array[16]?></td>
            <td class="border2"> <table border="0" cellpadding="3" cellspacing="0">
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

                  <td width="100" align="center" valign="top"><?php echo $f_array[17]?>
                    
                    <select name="destList" size="5" multiple="multiple" style="width:100px;height:100px" class="biaodan">
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
				  <input name="cityforadd" type="hidden" id="cityforadd" />                
				  <input name="button" type="button" onclick="javascript:deleteFromDestList();" value="<?php echo $f_array[18]?>" /></td>
                </tr>
                
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[19])?><br /> 
			 <input name="img" type="hidden" id="img" value="/image/nopic.gif"/> 
                       </td>
            <td class="border" > 
			<table height="140" width="140"  border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)" class="box"> 
				  <input name="Submit2" type="button"  value="<?php echo $f_array[21]?>" />
				  </td>  
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[24]?><br />
              <?php echo str_replace("{#maxflvsize}",maxflvsize,$f_array[25])?><input name="flv" type="hidden" id="flv" /></td>
            <td class="border2" >
			    <?php
if (check_user_power("uploadflv")=="yes"){
?>
			<table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#cccccc">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td id="container"  onClick="openwindow('/uploadflv_form.php',400,300)"> <input name="Submit24" type="button"  value="<?php echo $f_array[26]?>" /> </td>
                </tr>
              </table>
			    <?php
		   }else{
		  ?>
		  <table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#ccc">
                <tr align="center" bgcolor="#FFFFFF"> 
                  <td id="container" onClick="javascript:window.location.href='vip_add.php'"> <p><img src="../image/jx.gif" width="48" height="48" /><br />
                      <?php echo $f_array[22]?></p>
                    <p><span class='buttons'><?php echo $f_array[23]?></span><br />
                    </p></td>
                </tr>
              </table>
			  <?php
			  }
			  ?>			  </td>
          </tr>
        
          <tr> 
            <td align="right" valign="top" class="border2" ><?php echo $f_array[27]?></td>
            <td class="border2" > <textarea name="zc" class="biaodan"  style="height:60px" cols="60" rows="4" id="zc" onfocus="this.select()"><?php if (isset($_SESSION["zc"]))echo $_SESSION["zc"];?></textarea> 
              <div> <?php echo $f_array[28]?> </div></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border" ><?php echo str_replace("{#channeldl}",channeldl,$f_array[29])?></td>
            <td class="border" > <textarea name="yq" class="biaodan" style="height:60px" cols="60" rows="4" id="yq" onfocus="this.select()"><?php if (isset($_SESSION["yq"]))echo $_SESSION["yq"];?></textarea> 
              <div><?php echo $f_array[30]?> </div></td>
          </tr>
          <tr> 
            <td colspan="2" class="admintitle" ><strong><?php echo $f_array[31]?></strong></td>
          </tr>
		  	    <?php
if (check_user_power("seo")=="yes"){
?>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[32]?></td>
            <td class="border" ><input name="title" type="text" id="title" class="biaodan" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="255" /></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[33]?></td>
            <td class="border2" > <input name="keyword" type="text" id="keyword" class="biaodan" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" size="60" maxlength="255" />
              <?php echo $f_array[34]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[35]?></td>
            <td class="border" ><input name="discription" type="text" id="discription" class="biaodan" onblur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onclick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" value="" size="60" maxlength="255" />
              <?php echo $f_array[36]?></td>
          </tr>
		  <?php 
		  }else{
		  ?>
  <tr> 
            <td align="right" class="border" ><?php echo $f_array[32]?></td>
            <td class="border" ><input type="text" size="60" maxlength="255" disabled="disabled" value="<?php echo $f_array[37]?>"/></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[33]?></td>
            <td class="border2" > <input  type="text"  size="60" maxlength="255" value="<?php echo $f_array[37]?>" disabled="disabled"/>
              <?php echo $f_array[34]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[35]?></td>
            <td class="border" ><input type="text"  value="<?php echo $f_array[37]?>" size="60" maxlength="255" disabled="disabled"/>
             <?php echo $f_array[36]?></td>
          </tr>
		   <?php 
		  }
		  ?>	
          <tr>
            <td colspan="2" class="admintitle" ><strong><?php echo $f_array[38]?></strong></td>
          </tr>
		     <?php
if (check_user_power("zsshow_template")=="yes"){
?>
          <tr>
            <td align="right" class="border" ><?php echo $f_array[39]?></td>
            <td class="border" >
              <input name="skin" type="radio" id="cp" value="cp" checked="checked" />
            <label for="cp"><?php echo $f_array[40]?></label>
              <input type="radio" name="skin" value="xm" id="xm" />
            <label for="xm"><?php echo $f_array[41]?></label></td>
          </tr>
 <?php 
		  }else{
		  ?>		 
		 <tr>
            <td align="right" class="border" ><?php echo $f_array[42]?></td>
            <td class="border" >
              <input name="skin" type="radio" id="cp" value="cp" checked="checked" disabled="disabled"/>
            <label for="cp"><?php echo $f_array[40]?></label>
              <input type="radio" name="skin" value="xm" id="xm" disabled="disabled"/>
            <label for="xm"><?php echo $f_array[41]?></label></td>
          </tr> 
		 <?php 
		  }
		  ?>		  
          <tr> 
            <td align="center" class="border2" >&nbsp;</td>
            <td class="border2" > <input name="action" type="hidden" id="action2" value="add" /> 
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[43]?>" /></td>
          </tr>
        </table>
</form>
</div>

</div>	  
</div>
</div>
<?php

session_write_close();
unset ($f_array);
?>
</body>
</html>