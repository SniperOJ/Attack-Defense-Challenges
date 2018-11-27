<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("zx");
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
<div class="admintitle">修改资讯信息</div>
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
$rszx = query("select * from zzcms_zx where id='$id'"); 
$rowzx= fetch_array($rszx);
?>
<form action="zx_save.php?action=modify" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td width="12%" align="right" class="border">所属类别：</td>
      <td width="88%" class="border"> 
        <?php

$sql = "select * from zzcms_zxclass where parentid<>0 order by xuhao asc";
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
	$sql = "select * from zzcms_zxclass where  parentid=0 order by xuhao asc";
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

$sql="select * from zzcms_zxclass where parentid=" .$rowzx["bigclassid"]." order by xuhao asc";
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
    <tr id="link" style="display:"> 
      <td align="right" class="border" >链接地址：</td>
      <td class="border" ><input name="link" type="text" id="laiyuan3" value="<?php echo $rowzx["link"]?>" size="50" maxlength="255">      </td>
    </tr>
    <tr id="trlaiyuan"> 
      <td align="right" class="border" >信息来源：</td>
      <td class="border" > <input name="laiyuan" type="text" id="title2" value="<?php echo $rowzx["laiyuan"]?>" size="50" maxlength="50"></td>
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
      <td colspan="2" class="border2" >SEO</td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >关键词（keywords）</td>
      <td class="border" ><input name="keywords" type="text" id="title2" value="<?php echo $rowzx["keywords"]?>" size="50" maxlength="255"></td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="description" type="text" id="title2" value="<?php echo $rowzx["description"]?>" size="50" maxlength="255"></td>
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
      <td align="right" class="border" >浏览权限：</td>
      <td class="border" > <select name="groupid">
          <option value="0">全部用户</option>
          <?php
		  $rs=query("Select * from zzcms_usergroup ");
		  $row = num_rows($rs);
		  if ($row){
		  while($row = fetch_array($rs)){
		  	if ($rowzx["groupid"]== $row["groupid"]) {
		  	echo "<option value='".$row["groupid"]."' selected>".$row["groupname"]."</option>";
			}else{
			echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
			}
		  }
		  }
	 ?>
        </select> <select name="jifen" id="jifen">
          <option value="0">请选择无权限用户是否可用积分查看</option>
          <option value="0" <?php if ($rowzx["jifen"]==0) { echo "selected";}?>>无权限用户不可用积分查看</option>
          <option value="10" <?php if ($rowzx["jifen"]==10) { echo "selected";}?>>付我10积分可查看</option>
          <option value="20" <?php if ($rowzx["jifen"]==20) { echo "selected";}?>>付我20积分可查看</option>
          <option value="30" <?php if ($rowzx["jifen"]==30) { echo "selected";}?>>付我30积分可查看</option>
          <option value="50" <?php if ($rowzx["jifen"]==50) { echo "selected";}?>>付我50积分可查看</option>
          <option value="100" <?php if ($rowzx["jifen"]==100) { echo "selected";}?>>付我100积分可查看</option>
          <option value="200" <?php if ($rowzx["jifen"]==200) { echo "selected";}?>>付我200积分可查看</option>
          <option value="500" <?php if ($rowzx["jifen"]==500) { echo "selected";}?>>付我500积分可查看</option>
          <option value="1000" <?php if ($rowzx["jifen"]==1000) { echo "selected";}?>>付我1000积分可查看</option>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> <input type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
	  
</body>
</html>