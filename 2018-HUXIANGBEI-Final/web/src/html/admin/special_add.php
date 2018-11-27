<?php
include ("admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("special");
if (isset($_SESSION["zxclassid"])){
$szxclassid=$_SESSION["zxclassid"];
}else{
$szxclassid="";
}
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

function showlink(){
whichEl = eval("link");
if (whichEl.style.display == "none"){
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
<div class="admintitle">发布专题信息</div>
<form action="special_save.php?action=add" method="post" name="myform" id="myform" onSubmit="return CheckForm();">    
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="171" align="right" class="border" >所属类别：</td>
      <td width="1220" class="border" > 
        <?php

$sql = "select * from zzcms_specialclass where parentid<>0 order by xuhao asc";
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
	$sql = "select * from zzcms_specialclass where parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==@$_COOKIE["zxbigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="">不指定小类</option>
          <?php
if ($_COOKIE["zxbigclassid"]!=""){
$sql="select * from zzcms_zxclass where parentid=" .$_COOKIE["zxbigclassid"]." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
	?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==@$_COOKIE["zxsmallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
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
	$("#quote").load(encodeURI("/ajax/zttitlecheck_ajax.php?id="+$("#title").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script> 
        <input name="title" type="text" id="title" size="50" maxlength="255"> 
        <input type="checkbox" name="checkbox" value="checkbox" onClick="showlink()">
        外链新闻 
        <span id="quote"></span>		</td>
    </tr>
    <tr id="link" style="display:none"> 
      <td align="right" class="border" >链接地址：</td>
      <td class="border" ><input name="link" type="text" id="laiyuan3" size="50" maxlength="255">      </td>
    </tr>
    <tr id="trlaiyuan"> 
      <td align="right" class="border" >信息来源：</td>
      <td class="border" ><input name="laiyuan" type="text" id="laiyuan2" size="50" maxlength="50"></td>
    </tr>
    <tr id="trcontent"> 
      <td width="171" align="right" class="border" >内容：</td>
      <td class="border" ><textarea name="content" type="hidden" id="content"></textarea> 
        <script type="text/javascript">CKEDITOR.replace('content');	</script>      </td>
    </tr>
    <tr id="trseo">
      <td colspan="2" class="border2" >SEO设置</td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >关键词（keywords）</td>
      <td class="border" ><input name="keywords" type="text" id="keywords" size="50" maxlength="255"></td>
    </tr>
    <tr id="trdescription">
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="description" type="text" id="description" size="50" maxlength="255"></td>
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
    <tr id="trquanxian3"> 
      <td align="right" class="border" >浏览权限：</td>
      <td class="border" ><select name="groupid">
          <option value="0">全部用户</option>
          <?php
		  $rs=query("Select * from zzcms_usergroup ");
		  $row = num_rows($rs);
		  if ($row){
		  while($row = fetch_array($rs)){
		  echo "<option value='".$row["groupid"]."'>".$row["groupname"]."</option>";
		  }
		  }
	 ?>
        </select> <select name="jifen" id="jifen">
          <option value="0">请选择无权限用户是否可用积分查看</option>
          <option value="0">无权限用户不可用积分查看</option>
          <option value="10">付我10积分可查看</option>
          <option value="20">付我20积分可查看</option>
          <option value="30">付我30积分可查看</option>
          <option value="50">付我50积分可查看</option>
          <option value="100">付我100积分可查看</option>
          <option value="200">付我200积分可查看</option>
          <option value="500">付我500积分可查看</option>
          <option value="1000">付我1000积分可查看</option>
        </select> </td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <input type="submit" name="Submit" value="发 布" ></td>
    </tr>
  </table>
</form>	  
</body>
</html>