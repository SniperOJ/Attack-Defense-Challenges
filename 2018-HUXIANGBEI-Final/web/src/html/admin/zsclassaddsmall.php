<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function checkform()
{
  if (document.form1.classname.value=="")
  {
    alert("名称不能为空！");
    document.form1.classname.focus();
    return false;
  }
    if (document.form1.classzm.value=="")
  {
    alert("字母不能为空！");
    document.form1.classzm.focus();
    return false;
  }
 }  
</script>
</head>
<body>
<?php
$FoundErr=0;
$bigclassid=trim($_REQUEST["bigclassid"]);
if (@$_GET["action"]=="add"){
checkadminisdo("zsclass");
$classname=nostr(trim($_POST["classname"]));
$classzm=nostr(strtolower(trim($_POST["classzm"])));
$title=nostr(trim($_POST["title"]));
if ($title=="") {
$title=$classname;
}

$keyword=nostr(trim($_POST["keyword"]));
if ($keyword==""){
$keyword=$classname;
}

$discription=nostr(trim($_POST["discription"]));
if ($discription==""){
$discription=$classname;
}
	
	$sql="Select * From zzcms_zsclass Where parentid='" . $bigclassid . "' AND classname='" . $classname . "'";
	$rs=query($sql);
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg="<br><li>此大类中已经存在小类“" . $classname . "”！</li>";
		}

	$sql="Select * From zzcms_zsclass Where parentid='" . $bigclassid . "' AND classzm='" . $classzm . "'";
	$rs=query($sql);
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg= "<br><li>此大类中已经存在小类拼音“" . $classzm . "”！</li>";
	}
	
	if ($FoundErr==0){
		$sql="insert into zzcms_zsclass (parentid,classname,classzm,title,keyword,discription) values('$bigclassid','$classname','$classzm','$title','$keyword','$discription')";
		query($sql);
		echo "<script>location.href='zsclassmanage.php?#B".$bigclassid."'</script>";
		}
}			

if ($FoundErr==1) {
WriteErrMsg($ErrMsg);
}else{
?>
<form name="form1" method="post" action="?action=add" onSubmit="return checkform()"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">添加小类</td>
  </tr>
</table>
<script type="text/javascript" src="/js/jquery.js"></script>  
<script type="text/javascript" language="javascript">
$.ajaxSetup ({
cache: false //close AJAX cache
});
</script>
<script language="javascript">  
$(document).ready(function(){  
  $("#classname").change(function() { //jquery 中change()函数  
	$("#quote").load(encodeURI("/ajax/zsclass_ajax.php?id="+$("#classname").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  
</script> 
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="18%" align="right" class="border">所属大类</td>
      <td width="82%" class="border"> <select name="bigclassid">
          <?php
	$sql="Select * From zzcms_zsclass where parentid='A'";
	$rs=query($sql);
	
	while($row= fetch_array($rs)){
			if ($row['classzm']==$bigclassid){
			echo "<option value='".$row['classzm']."' selected>".$row['classname']."</option>";
			}else{
			echo "<option value='".$row['classzm']."'>".$row['classname']."</option>";
			}
		}
	?>
        </select></td>
    </tr>
    <tr class="tdbg"> 
      <td height="10" align="right" class="border">小类名称</td>
      <td class="border"> <input name="classname"  id="classname" type="text" size="60" maxlength="30"></td>
    </tr>
    <tr> 
      <td align="right" class="border"> 小类名称拼音</td>
      <td class="border"> 
	  <span id="quote">  
	  <input name="classzm" type="text" id="classzm" size="60" maxlength="30"> 
	  </span>  
      </td>
    </tr>
    <tr class="tdbg"> 
      <td colspan="2" class="border">SEO优化设置（如与大类名称相同，以下可以留空不填）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >标题（title）</td>
      <td class="border" ><input name="title" type="text" id="title"  size="60" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >关键词（keyword）</td>
      <td class="border" ><input name="keyword" type="text" id="keyword"  size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr> 
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="discription" type="text" id="discription"  value="" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr class="tdbg"> 
      <td height="22" class="border"> </td>
      <td height="22" class="border"> <input name="Action" type="hidden" id="Action3" value="Add"> 
        <input name="Add" type="submit" value=" 添 加 "> </td>
    </tr>
  </table>
 </form>
 <?php
 }
 ?>
</body>
</html>