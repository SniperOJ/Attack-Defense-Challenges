<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("ask");
?>
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择大类别！");
	document.myform.bigclassid.focus();
	return false;
  } 	  
if (document.myform.title.value==""){
    alert("标题不能为空！");
	document.myform.title.focus();
	return false;
  }  
//创建正则表达式
var re=/^[0-9]*$/;		
	if(document.myform.elite.value==""){
		alert("请输入数值！");
		document.myform.elite.focus();
		return false;
	}
	if(document.myform.elite.value.search(re)==-1)  {
    alert("必须为正整数！");
	document.myform.elite.value="";
	document.myform.elite.focus();
	return false;
  	}
	if(document.myform.elite.value>127)  {
    alert("不得大于127");
	document.myform.elite.focus();
	return false;
  	}  
}    
function doChange(objText, pic){
	if (!pic) return;
	var str = objText.value;
	var arr = str.split("|");
	pic.length=0;
	for (var i=0; i<arr.length; i++){
		pic.options[i] = new Option(arr[i], arr[i]);
	}
} 
</script>
</head>
<body>
<div class="admintitle">修改问答信息</div>
<?php
if (isset($_GET["page"])){
$page=$_GET["page"];
}else{
$page=1;
}
$id=$_REQUEST["id"];
if ($id=="" || is_numeric($id)==false){
showmsg('参数有误！相关信息不存在。');
}
$rszx = query("select * from zzcms_ask where id='$id'"); 
$rowzx= fetch_array($rszx);
?>
<form action="ask_save.php?action=modify" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td width="12%" align="right" class="border">所属类别：</td>
      <td width="88%" class="border"> 
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
    }</script> <select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sql = "select * from zzcms_askclass where  parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==$rowzx["bigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php

$sql="select * from zzcms_askclass where parentid=" .$rowzx["bigclassid"]." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
	?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$rowzx["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php
			    }
		
				?>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border">标题：</td>
      <td class="border"> 
        <input name="title" type="text" id="title2" value="<?php echo $rowzx["title"]?>" size="50" maxlength="255">      </td>
    </tr>
    <tr id="trcontent"> 
      <td width="12%" align="right" class="border">内容：</td>
      <td class="border"> <textarea name="content" id="content" ><?php echo $rowzx["content"]?></textarea> 
        <script type="text/javascript">CKEDITOR.replace('content');	</script> 
        <input name="id" type="hidden" id="id" value="<?php echo $rowzx["id"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $page?>"> </td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >封面图片：</td>
      <td class="border" ><input name="img" type="text" id="title2" value="<?php echo $rowzx["img"]?>" size="50" maxlength="255">
      （如果内容中有图片，这里可以留空，会自动获取内容中的第一张图片）</td>
    </tr>
    <tr id="trkeywords">
      <td colspan="2" class="border2" >属性设置</td>
    </tr>
    <tr>
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($rowzx["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr> 
      <td align="right" class="border">推荐值：</td>
      <td class="border"> <input name="elite" type="text" id="elite" value="<?php echo $rowzx["elite"]?>" size="4" maxlength="3">
        (0-127之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
	  
</body>
</html>