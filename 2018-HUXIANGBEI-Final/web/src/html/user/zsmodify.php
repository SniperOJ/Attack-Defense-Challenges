<?php
include("../inc/conn.php");
include("check.php");
$fpath="text/zsmodify.txt";
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
if (str_is_inarr(usergr_power,'zs')=="no" && $usersf=='个人'){
echo $f_array[0];
exit;
}
?>
<title></title>
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
document.myform.cityforadd.value=v   
}
function showinfo(name, n){
	var chList=document.getElementsByName("ch"+name);
	var TextArea=document.getElementById(name);
	if(chList[n-1].checked) {//数组从0开始{
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

$sql="select * from zzcms_main where id='$id'";
$rs = query($sql); 
$row = fetch_array($rs);
if ($row["editor"]<>$username) {
markit();
showmsg('非法操作！警告：你的操作已被记录！小心封你的用户及IP！');
}
?>
<div class="content">
<div class="admintitle"><?php echo str_replace("{#channelzs}",channelzs,$f_array[4])?></div>
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
	$("#quote").load(encodeURI("/ajax/zstitlecheck_ajax.php?id="+$("#name").val()));
  });  
});  
</script> 
<form action="zssave.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[5]?></td>
            <td class="border" > <input name="name" type="text" id="name" class="biaodan" value="<?php echo $row["proname"]?>" size="60" maxlength="45" > 
             <span id="quote"></span> <span id="span_szm">  <input name="szm" type="hidden" value="<?php echo $row["szm"]?>"  />
             </span> <br>
               <?php echo $f_array[7]?></td>
          </tr>
          <tr> 
            <td width="18%" align="right" valign="top" class="border2" ><br>
             <?php echo $f_array[8]?></td>
            <td width="82%" class="border2" > 
			<table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset class="fieldsetstyle">
                    <legend><?php echo $f_array[9]?></legend>
                    <?php
        $sqlB = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rsB = query($sqlB,$conn); 
		$n=0;
		while($rowB= fetch_array($rsB)){
		$n ++;
		if ($row['bigclasszm']==$rowB['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' checked/><label for='E$n'>".$rowB['classname']."</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' /><label for='E$n'>".$rowB['classname']."</label>";
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
echo "<fieldset class='fieldsetstyle'><legend>".$f_array[10]."</legend>";
$sqlS="select * from zzcms_zsclass where parentid='".$rowB['classzm']."' order by xuhao asc";
$rsS = query($sqlS,$conn); 
$nn=0;
while($rowS= fetch_array($rsS)){
if (zsclass_isradio=='Yes'){
	if ($row['smallclasszm']==$rowS['classzm']){
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS[classzm]."' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS[classzm]."' />";
	}
}else{
	//if ($row['smallclasszm']==$rowS['classzm']){
	if (strpos($row['smallclasszm'],$rowS['classzm'])!==false && $row['bigclasszm']==$rowB['classzm']){//与招商产品中大类名相同的大类下的小类才会被勾选
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' onclick='javascript:ValidSelect(this)' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' onclick='javascript:ValidSelect(this)'/>";
	}
}
echo "<label for='radio$nn$n'>".$rowS['classname']."</label>";
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
		$rsn = query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
		$rown= num_rows($rsn);
		if ($rown){
		  ?>
          <tr>
            <td align="right" class="border2" ><?php echo $f_array[11]?></td>
            <td class="border2" >
			<?php
        $n=0;
		while($rown= fetch_array($rsn)){
		$n ++;
		if ($row['shuxing']==$rown['bigclassid']){
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."' checked/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}else{
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."'/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}
		
	}
			?>            </td>
          </tr>
		    <?php 
		 }
		  ?>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[12]?><font color="#FF0000">&nbsp;</font></td>
            <td class="border2" > <textarea name="gnzz" cols="60" rows="4" class="biaodan" style="height:auto" id="gnzz"><?php echo $row["prouse"]?></textarea>            </td>
          </tr>
		   <?php
	if (shuxing_name!=''){
	$shuxing_name = explode("|",shuxing_name);
	$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($i=0; $i< count($shuxing_name);$i++){
	?>
	<tr>
      <td align="right" class="border" ><?php echo $shuxing_name[$i]?>：</td>
      <td class="border" ><input name="sx[]" type="text" value="<?php echo @$shuxing_value[$i]?>" size="45" class="biaodan"></td>
    </tr>
	<?php
	}
	}
	?>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[15]?></td>
            <td class="border" > 
			<textarea name="sm" id="sm" class="biaodan" ><?php echo $row["sm"] ?></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>			</td>
          </tr>
          <tr> 
            <td align="right" class="border"><?php echo channelzs.$f_array[16]?></td>
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

<select name="province" id="province" class="biaodan" ></select>
<select name="city" id="city" class="biaodan" ></select>
<select name="xiancheng" id="xiancheng" onchange="addSrcToDestList()" class="biaodan" ></select>
<script src="/js/area.js"></script>
<script type="text/javascript">
new PCAS('province', 'city', 'xiancheng', '<?php echo $row["province"]?>', '<?php echo $row["city"]?>', '<?php echo $row["xiancheng"]?>');
</script>                 </td>
                 
                  <td width="100" align="center" valign="top"><?php echo $f_array[17]?>
                    <select style='width:100px;height:100px' class="biaodan"  size="4" name="destList" multiple="multiple">
                      <?php 
		if ($row["xiancheng"]!="") {
			  if (strpos($row["xiancheng"],",")==0) {?>
                      <option value="<?php echo $row["xiancheng"]?>"><?php echo $row["xiancheng"]?></option>
                      <?php }else{
			  	$selectedcity=explode(",",$row["xiancheng"]);
				for ($i=0;$i<count($selectedcity);$i++){    
				?>
                      <option value="<?php echo $selectedcity[$i]?>"><?php echo $selectedcity[$i]?></option>
                      <?php }
				}
		}
			?>
                    </select>
                      <input name="cityforadd" type="hidden" id="cityforadd" />
                      <input name="button2" type="button" onclick="javascript:deleteFromDestList();" value="<?php echo $f_array[18]?>" /></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo str_replace("{#maximgsize}",maximgsize,$f_array[19])?>
 <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"] ?>"> 
              <input name="img"type="hidden" id="img" value="<?php echo $row["img"] ?>"> 
                     </td>
            <td class="border" >
			 <table height="140" width="140" border="0" cellpadding="10" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td  align="center" bgcolor="#FFFFFF" id="showimg"> 
                    <?php
				 if($row["img"]<>"/image/nopic.gif"){
				 echo "<div style='padding:10px 0'><a href='".$row["img"]."' target='_blank'><img src='".$row["img"]."' border=0 width=120 /></a></div>";
				echo "<div onClick=\"openwindow('/uploadimg_form.php',400,300)\" style='width:50px' class='buttons'>".$f_array[45]."</div>";
				
				  }else{
				  echo "<input name='Submit2' type='button'  value='".$f_array[21]."' onClick=\"openwindow('/uploadimg_form.php',400,300)\"/>";
				  }
				  ?>                  </td>
				          
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[24]?>
              <input name="oldflv" type="hidden" id="oldflv2" value="<?php echo $row["flv"] ?>" /> 
              <input name="flv" type="hidden" id="flv" value="<?php echo $row["flv"] ?>" /></td>
            <td class="border" >
			<?php
if (check_user_power("uploadflv")=="yes"){
?>
			<table width="140" height="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
                <tr> 
                  <td align="center" bgcolor="#FFFFFF" id="container" onClick="openwindow('/uploadflv_form.php',400,300)"> 
                    <?php
		if($row["flv"]<>""){
				  if (substr($row["flv"],-3)=="flv") {
				  ?>
                    <script type="text/javascript">
          var s1 = new SWFObject("/image/player.swf","ply","200","200","9","#FFFFFF");
          s1.addParam("allowfullscreen","true");
          s1.addParam("allowscriptaccess","always");
          s1.addParam("flashvars","file=<?php echo $row["flv"] ?>&autostart=false");
          s1.write("container");
         </script> 
                    <?php 
				 }elseif (substr($row["flv"],-3)=="swf") {
				 echo "<embed src='".$row["flv"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width=200 height=200></embed>";
				 }
			echo "<br/>".$f_array[44];
			}else{
			echo "<input name='Submit2' type='button'  value='".$f_array[26]."'/>";
			}
				  ?>                  </td>
                </tr>
              </table>
			  <?php
		   }else{
		  ?>
		  <table width="140" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
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
            <td class="border2" > <textarea name="zc" cols="60" rows="4" id="zc" class="biaodan" style="height:auto" ><?php echo $row["zc"] ?></textarea> 
              <div>  <?php echo $f_array[28]?> </div></td>
          </tr>
          <tr> 
            <td align="right" valign="top" class="border" ><?php echo str_replace("{#channeldl}",channeldl,$f_array[29])?></td>
            <td class="border" > <textarea name="yq" cols="60" rows="4" id="yq" class="biaodan" style="height:auto"><?php echo $row["yq"] ?></textarea> 
              <div> <?php echo $f_array[30]?> </div></td>
          </tr>
          <tr> 
            <td colspan="2" class="admintitle" ><?php echo $f_array[31]?></td>
          </tr>
		    <?php
		 if (check_user_power("seo")=="yes"){
		 ?>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[32]?></td>
            <td class="border" ><input name="title" type="text" id="title" class="biaodan" onBlur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["title"] ?>" size="60" maxlength="255"></td>
          </tr>
          <tr> 
            <td align="right" class="border2" ><?php echo $f_array[33]?></td>
            <td class="border2" > <input name="keyword" type="text" id="keyword" class="biaodan" onBlur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["keywords"] ?>" size="60" maxlength="255">
              <?php echo $f_array[34]?></td>
          </tr>
          <tr> 
            <td align="right" class="border" ><?php echo $f_array[35]?></td>
            <td class="border" ><input name="discription" type="text" id="discription" class="biaodan" onBlur="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" onClick="javascript:if (this.value=='<?php echo $f_array[6]?>') {this.value=''};this.style.backgroundColor='';" value="<?php echo $row["description"] ?>" size="60" maxlength="255">
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
              <input type="radio" name="skin" value="cp" id="cp" <?php if ($row["skin"]=='cp'){ echo "checked";}  ?>/>
              <label for="cp"><?php echo $f_array[40]?></label>
              <input type="radio" name="skin" value="xm" id="xm" <?php if ($row["skin"]=='xm'){ echo "checked";}  ?>/>
              <label for="xm"><?php echo $f_array[41]?></label>            </td>
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
            <td class="border2" ><input name="ypid" type="hidden" id="ypid2" value="<?php echo $row["id"] ?>" />
              <input name="action" type="hidden" id="action2" value="modify" />
              <input name="page" type="hidden" id="action" value="<?php echo $page ?>" />
              <input name="Submit" type="submit" class="buttons" value="<?php echo $f_array[43]?>" /></td>
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