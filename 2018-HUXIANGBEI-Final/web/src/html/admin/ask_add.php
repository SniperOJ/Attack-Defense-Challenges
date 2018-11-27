<?php
include ("admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("ask");
if (isset($_SESSION["askclassid"])){
$saskclassid=$_SESSION["askclassid"];
}else{
$saskclassid="";
}
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value=="")
  {
    alert("请选择大类别！");
	document.myform.bigclassid.focus();
	return false;
  } 
if (document.myform.title.value=="")
  {
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  }
  
//创建正则表达式
var re=/^[0-9]*$/;		
	if(document.myform.elite.value=="")
	{
		alert("请输入数值！");
		document.myform.elite.focus();
		return false;
	}
	if(document.myform.elite.value.search(re)==-1)  
	{
    alert("必须为正整数！");
	document.myform.elite.value="";
	document.myform.elite.focus();
	return false;
  	}
	
	if(document.myform.elite.value>127)  
	{
    alert("不得大于127");
	document.myform.elite.focus();
	return false;
  	}     
} 

function showlink()
{
whichEl = eval("link");
if (whichEl.style.display == "none")
{
eval("link.style.display=\"\";");
eval("trlaiyuan.style.display=\"none\";");
eval("trcontent.style.display=\"none\";");
eval("trseo.style.display=\"none\";");
eval("trkeywords.style.display=\"none\";");
eval("trkeywords.style.display=\"none\";");
eval("trdescription.style.display=\"none\";");
eval("trquanxian.style.display=\"none\";");
eval("trquanxian1.style.display=\"none\";");
eval("trquanxian2.style.display=\"none\";");
eval("trquanxian3.style.display=\"none\";");
}else{
eval("link.style.display=\"none\";");
eval("trlaiyuan.style.display=\"\";");
eval("trcontent.style.display=\"\";");
eval("trseo.style.display=\"\";");
eval("trkeywords.style.display=\"\";");
eval("trdescription.style.display=\"\";");
eval("trquanxian.style.display=\"\";");
eval("trquanxian1.style.display=\"\";");
eval("trquanxian2.style.display=\"\";");
eval("trquanxian3.style.display=\"\";");
}
}  
	</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">发布问答</td>
  </tr>
</table>
<form action="ask_save.php?action=add" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="171" align="right" class="border" >所属类别：</td>
      <td width="1220" class="border" > 
        <?php

$sql = "select * from zzcms_askclass where parentid<>0 order by xuhao asc";
$rs=query($sql);
?>
        <script language = "JavaScript" type="text/JavaScript">
var onecount;
subcat = new Array();
        <?php 
        $count = 0;
        while($row = fetch_array($rs)){
        ?>
subcat[<?php echo $count?>] = new Array("<?php echo trim($row["classname"])?>","<?php echo trim($row["parentid"])?>","<?php echo trim($row["classid"])?>");
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
    }</script> 
	<select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sql = "select * from zzcms_askclass where parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==@$_COOKIE["askbigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php
if ($_COOKIE["askbigclassid"]!=""){
$sql="select * from zzcms_askclass where parentid=" .$_COOKIE["askbigclassid"]." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
	?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==@$_COOKIE["asksmallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php
			    }
				}
				?>
        </select> </td>
    </tr>
    <tr> 
      <td width="171" align="right" class="border" >标题： </td>
      <td class="border" > 
	  			<script type="text/javascript" src="/js/jquery.js"></script>  
<script language="javascript">  
$(document).ready(function(){  
  $("#title").change(function() { //jquery 中change()函数  
	$("#quote").load(encodeURI("/ajax/asktitlecheck_ajax.php?id="+$("#title").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script> 
        <input name="title" type="text" id="title" size="50" maxlength="255"></td>
    </tr>
    <tr id="trcontent"> 
      <td width="171" align="right" class="border" >内容：</td>
      <td class="border" ><textarea name="content" type="hidden" id="content"></textarea> 
        <script type="text/javascript">CKEDITOR.replace('content');	</script>      </td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >封面图片：</td>
      <td class="border" ><input name="img" type="text" id="title2" size="50" maxlength="255" />
        （如果内容中有图片，这里可以留空，会自动获取内容中的第一张图片）</td>
    </tr>
    <tr id="trquanxian">
      <td colspan="2" class="border2" >属性设置</td>
    </tr>
    <tr id="trquanxian1"> 
      <td align="right" class="border" >审核：</td>
      <td class="border" ><input name="passed" type="checkbox" id="passed" value="1">
      （选中为通过审核）</td>
    </tr>
    <tr id="trquanxian2">
      <td align="right" class="border" >推荐值：</td>
      <td class="border" ><input name="elite" type="text" id="elite" value="0" size="4" maxlength="4">
(0-127之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <input type="submit" name="Submit" value="发 布" ></td>
    </tr>
  </table>
</form>	  
</body>
</html>