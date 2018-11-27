<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
//checkadminisdo("adv");
if (isset($_SESSION["link"])){
$slink=$_SESSION["link"];
}else{
$slink="javascript:void(0)";
}
if (isset($_SESSION["imgwidth"])){
$simgwidth=$_SESSION["imgwidth"];
}else{
$simgwidth=100;
}
if (isset($_SESSION["imgheight"])){
$simgheight=$_SESSION["imgheight"];
}else{
$simgheight=100;
}
?>
<script language="javascript" src="/js/timer.js"></script>	
<script language="javascript" src="/js/gg.js"></script>
<script language = "JavaScript">
function CheckForm(){	  
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
}
if (document.myform.link.value==""){
    alert("链接地址不能为空！");
	document.myform.link.focus();
	return false;
}
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.imgwidth.value)) {
alert("图片宽度只能填数字！"); 
document.myform.imgwidth.focus(); 
return false; 
}

if(!strP.test(document.myform.imgheight.value)) {
alert("图片高度只能填数字！"); 
document.myform.imgheight.focus(); 
return false; 
}
} 
</script>
</head>
<body>
<div class="admintitle">添加广告</div>
<form name="myform" method="post" action="ad_save.php" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="20%" align="right" class="border">所属类别：</td>
      <td width="80%" class="border"> 
<?php
$sql = "select * from zzcms_adclass where parentid<>'A' order by xuhao asc";
$rs=query($sql);
?>
        <script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($row = fetch_array($rs)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($row["classname"])?>","<?php echo trim($row["parentid"])?>","<?php echo trim($row["classname"])?>");
        <?php
        $count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;

function changelocation(locationid){
    document.myform.smallclassid.length = 1; 
    var locationid=locationid;
    var i;
    for (i=0;i < onecount; i++)
        {
            if (subcat[i][1] == locationid)
            { 
                document.myform.smallclassid.options[document.myform.smallclassid.length] = new Option(subcat[i][0], subcat[i][2]);
            }        
        }
    }</script> 
	<select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sql = "select * from zzcms_adclass where parentid='A' order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo trim($row["classname"])?>" <?php if ($row["classname"]==@$_SESSION["bigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php
if ($_SESSION["bigclassid"]!=""){
$sql="select * from zzcms_adclass where parentid='" .$_SESSION["bigclassid"]."' order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
	?>
          <option value="<?php echo $row["classname"]?>" <?php if ($row["classname"]==@$_SESSION["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php
			    }
				}
				?>
        </select>
		</td>
    </tr>
    <tr> 
      <td align="right" class="border">标题：</td>
      <td class="border"> <input name="title" type="text" id="title"  size="50">
        标题颜色： 
        <select name="titlecolor" id="titlecolor">
          <option value=""  style="background-color:FFFFFF;color:#000000" >默认</option>
          <option value="red"  style="background-color:red;color:#FFFFFF" >红色</option>
          <option value="green" style="background-color:green;color:#FFFFFF">绿色</option>
          <option value="blue" style="background-color:blue;color:#FFFFFF">蓝色</option>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border">链接地址：</td>
      <td class="border"> <input name="link" type="text" id="link2" value="<?php echo $slink?>" size="50"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit2" value="提交"></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2">以下内容为图片广告所填写</td>
    </tr>
    <tr> 
      <td align="right" class="border">上传图片： <input name="img" type="hidden" id="img" ></td>
      <td class="border"> 
 <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr align="center" bgcolor="#FFFFFF"> 
            <td id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> <input name="Submit2" type="button"  value="上传图片" /></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">图片大小：</td>
      <td class="border">宽： 
        <input name="imgwidth" type="text" id="link2" value="<?php echo $simgwidth?>" size="10">
        px <br>
        高： 
        <input name="imgheight" type="text" id="imgheight" value="<?php echo $simgheight?>" size="10">
        px </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"> <input name="action" type="hidden" id="action3" value="add"></td>
    </tr>
    <tr> 
      <td colspan="2" align="right" class="admintitle2">以下内容为收费广告所填写</td>
    </tr>
    <tr> 
      <td align="right" class="border">是否可抢占：</td>
      <td class="border"> <input type="radio" name="elite" value="1">
        不可抢占(收费广告选此项) 
        <input name="elite" type="radio" value="0" checked>
        可抢占</td>
    </tr>
    <tr> 
      <td align="right" class="border">广告主：</td>
      <td class="border"> <input name="username" type="text" id="username" size="25"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">广告期限：</td>
      <td class="border"> <input name="starttime" type="text" id="starttime" value="<?php echo date('Y-m-d')?>" size="10" onFocus="JTC.setday(this)">
        至 
        <input name="endtime" type="text" id="endtime" value="<?php echo date('Y-m-d',time()+60*60*24*365)?>" size="10" onFocus="JTC.setday(this)"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit22" value="提交"></td>
    </tr>
  </table>
</form>

</body>
</html>