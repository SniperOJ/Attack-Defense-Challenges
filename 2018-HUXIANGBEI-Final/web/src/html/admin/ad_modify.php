<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/timer.js"></script>
<script language="javascript" src="/js/gg.js"></script>
<script>
function isNumber(String){ 
var Letters = "1234567890-";   //可以自己增加可输入值
var i;
var c;
if(String.charAt(0)=='-')
return   false;
if( String.charAt(String.length - 1) == '-' )
return   false;
for( i = 0; i<String.length;i ++ )
{ 
c=String.charAt( i );
if(Letters.indexOf( c )< 0)
return  false;
}
return  true;
}
function  CheckNum(){ 
if(! isNumber(document.myform.imgwidth.value))   { 
alert("图片宽度必需为数字！");
document.myform.imgwidth.value="";
document.myform.imgwidth.focus();
return   false;
}
if(! isNumber(document.myform.imgheight.value))   { 
alert("图片高度必需为数字！");
document.myform.imgheight.value="";
document.myform.imgheight.focus();
return   false;
}
return   true;
}
</script>
</head>
<body>
<div class="admintitle">修改广告</div>
<?php
//checkadminisdo("adv");
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_ad where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="ad_save.php" method="post" name="myform" >
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="19%" align="right" class="border">所属类别：</td>
      <td width="81%" class="border"> 
       <?php
$sqln = "select * from zzcms_adclass where parentid<>'A' order by xuhao asc";
$rsn=query($sqln);
?>
        <script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($rown = fetch_array($rsn)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($rown["classname"])?>","<?php echo trim($rown["parentid"])?>","<?php echo trim($rown["classname"])?>");
        <?php
        $count = $count + 1;
       }
        ?>
onecount=<?php echo $count ?>;

function changelocation(locationid)
    {
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
    }</script> <select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sqln = "select * from zzcms_adclass where  parentid='A' order by xuhao asc";
    $rsn=query($sqln);
	while($rown = fetch_array($rsn)){
	?>
          <option value="<?php echo trim($rown["classname"])?>" <?php if ($rown["classname"]==$row["bigclassname"]) { echo "selected";}?>><?php echo trim($rown["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php

$sqln="select * from zzcms_adclass where parentid='" .$row["bigclassname"]."' order by xuhao asc";
$rsn=query($sqln);
while($rown = fetch_array($rsn)){
	?>
          <option value="<?php echo $rown["classname"]?>" <?php if ($rown["classname"]==$row["smallclassname"]) { echo "selected";}?>><?php echo $rown["classname"]?></option>
          <?php
			    }
		
				?>
        </select> 
		
		</td>
    </tr>
    <tr> 
      <td align="right" class="border">标题：</td>
      <td class="border"> <input name="title" type="text" id="title" value="<?php echo $row["title"]?>" size="50">
        标题颜色： 
        <select name="titlecolor" id="titlecolor">
          <option value=""  style="background-color:FFFFFF;color:#000000" >默认</option>
          <option value="red"  style="background-color:red;color:#FFFFFF" <?php if ($row["titlecolor"]=='red') {echo "selected";}?>>红色</option>
          <option value="green" style="background-color:green;color:#FFFFFF" <?php if ($row["titlecolor"]=="green") {echo "selected";}?>>绿色</option>
          <option value="blue" style="background-color:blue;color:#FFFFFF" <?php if ($row["titlecolor"]=="blue") {echo "selected";}?>>蓝色</option>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border">链接地址：</td>
      <td class="border"> <input name="link" type="text" id="link" value="<?php echo $row["link"]?>" size="50"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="newsid" type="hidden" id="newsid3" value="<?php echo $row["id"]?>"> 
        <input name="action" type="hidden" id="action3" value="modify"> <input name="page" type="hidden" id="action" value="<?php echo $page?>"> 
        <input type="submit" name="Submit2" value="提交"></td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><strong>以下内容为图片广告所填写</strong></td>
    </tr>
    <tr> 
      <td align="right" class="border">广告图片： 
        <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $row["img"]?>"> 
        <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>"></td>
      <td class="border"> 
	  <table width="120" height="120" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php?noshuiyin=1',400,300)"> 
              <?php
				 if ($row["img"]<>""){
						if (substr($row["img"],-3)=="swf"){
						$str=$str."<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='120' height='120'>";
						$str=$str."<param name='wmode' value='transparent'>";
						$str=$str."<param name='movie' value='".$row["img"]."' />";
						$str=$str."<param name='quality' value='high' />";
						$str=$str."<embed src='".$row["img"]."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='120'  height='120' wmode='transparent'></embed>";
						$str=$str."</object>";
						echo $str;
						}elseif (strpos("gif|jpg|png|bmp",substr($row["img"],-3))!==false ){
                    	echo "<img src='".$row["img"]."' width='120'  border='0'> ";
                    	}
					echo "点击可更换图片";	
					}else{
                     echo "<input name='Submit2' type='button'  value='上传图片'/>";
                    }	
				  ?>
            </td>
          </tr>
        </table>
        <input name='noimg[]' type='checkbox' id="noimg[]" value='1' />
        选中可改为文字广告</td>
    </tr>
    <tr> 
      <td align="right" class="border">图片大小：</td>
      <td class="border">宽： 
        <input name="imgwidth" type="text" id="link2" value="<?php echo $row["imgwidth"]?>" size="10" onBlur="CheckNum()">
        px (提示：如果宽设为0，前台以文字广告显示，鼠标放上后可显图片)<br>
        高： 
        <input name="imgheight" type="text" id="imgheight" value="<?php echo $row["imgheight"]?>" size="10" onBlur="CheckNum()">
        px </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"> </td>
    </tr>
    <tr> 
      <td colspan="2" class="admintitle2"><strong>以下内容为收费广告所填写</strong></td>
    </tr>
    <tr> 
      <td align="right" class="border">广告主：</td>
      <td class="border"> <input name="username" type="text" id="username" value="<?php echo $row["username"]?>" size="25"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">下一个占位的广告主：</td>
      <td class="border"> <input name="nextuser" type="text" id="nextuser" value="<?php echo $row["nextuser"]?>" size="25"></td>
    </tr>
    <tr> 
      <td align="right" class="border">是否可抢占：</td>
      <td class="border"> <input type="radio" name="elite" value="1" <?php if ($row["elite"]==1){ echo "checked";}?>>
        不可抢占(收费广告选此) 
        <input type="radio" name="elite" value="0" <?php if ($row["elite"]==0) { echo "checked";}?>>
        可抢占</td>
    </tr>
    <tr> 
      <td align="right" class="border">广告期限：</td>
      <td class="border"> <input name="starttime" type="text" id="starttime" value="<?php echo $row["starttime"]?>" size="10" onFocus="JTC.setday(this)">
        至 
        <input name="endtime" type="text" id="endtime" value="<?php echo $row["endtime"]?>" size="10"  onFocus="JTC.setday(this)"> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit3" value="提交"></td>
    </tr>
  </table>
</form>

</body>
</html>