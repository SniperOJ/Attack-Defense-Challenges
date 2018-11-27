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
$classid=trim($_REQUEST["classid"]);
if(@$_REQUEST["action"]=="modify"){
checkadminisdo("zsclass");
$bigclassid=trim($_POST["bigclassid"]);
$oldbigclassid=trim($_POST["oldbigclassid"]);
$classname=nostr(trim($_POST["classname"]));
$oldclassname=trim($_POST["oldclassname"]);
$classzm=nostr(strtolower(trim($_POST["classzm"])));
$oldclasszm=trim($_POST["oldclasszm"]);

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

if ($classid==""){
	
echo "<script>location.href='zsclassmanage.php'</script>";
}
		
	if ($classname<>$oldclassname || $bigclassid<>$oldbigclassid ){
		$rs=query("Select * from zzcms_zsclass where parentid='".$bigclassid."' and classname='".$classname."'");
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg="<li>此小类名称已存在！</li>";
		}
	}
	
	if ($classzm<>$oldclasszm || $bigclassid<>$oldbigclassid ){
		
		$rs=query("Select * from zzcms_zsclass where parentid='".$bigclassid."' and classzm='".$classzm."'");
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
			$ErrMsg="<li>此小类名拼音已存在！</li>";
		}
	}		
		
	if ($FoundErr==0) {
		query("update zzcms_zsclass set parentid='$bigclassid',classname='$classname',classzm='$classzm',title='$title',keyword='$keyword',discription='$discription' where classid='$classid'");
			if ($bigclassid<>$oldbigclassid){
				query("Update zzcms_main set bigclasszm='" . $bigclassid . "' where bigclasszm='" . $oldbigclassid . "' and smallclasszm='" . $classzm . "' ");	
			}
			if ($classzm<>$oldclasszm ){
			query("update zzcms_main set smallclasszm='".$classzm."' where smallclasszm='".$oldclasszm."' and bigclasszm='" . $bigclassid . "' " );
			}
			
			echo "<script>location.href='zsclassmanage.php?#S".$classid."'</script>";
	}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
$rs=query("Select * from zzcms_zsclass where classid='".$classid."'");
$row= fetch_array($rs);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">修改小类</td>
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
<form name="form1" method="post" action="?action=modify" onSubmit="return checkform()">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="252" height="22" align="right" class="border">所属大类</td>
      <td width="1163" class="border"> <select name="bigclassid" id="bigclassid">
          <?php
	$rsb=query("Select * From zzcms_zsclass where parentid='A'");
	while($rowb= fetch_array($rsb)){
			if ($rowb["classzm"]==$row["parentid"]){
				echo "<option value=". $rowb['classzm'] ." selected>" . $rowb['classname']."</option>";
			}else{
				echo "<option value=". $rowb['classzm'] . ">" .$rowb['classname'] . "</option>";
			}
		}
	?>
        </select> <input name="oldbigclassid" type="hidden" id="oldbigclassid" value="<?php echo $row["parentid"]?>"> 
      </td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">小类名称</td>
      <td class="border"> <input name="classname" type="text" id="classname" value="<?php echo $row["classname"]?>" size="60" maxlength="30"> 
        <input name="oldclassname" type="hidden" id="oldclassname" value="<?php echo $row["classname"]?>"></td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">小类名称拼音</td>
      <td class="border">
	   <span id="quote"> 
	    <input name="classzm" type="text" id="classzm" value="<?php echo $row["classzm"]?>" size="60" maxlength="30"> 
		 </span> 
        <input name="oldclasszm" type="hidden" id="oldclasszm" value="<?php echo $row["classzm"]?>"></td>
    </tr>
    <tr> 
      <td colspan="2" class="border">SEO优化设置（如与大类名称相同，以下可以留空不填）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >标题（title）</td>
      <td class="border" ><input name="title" type="text" id="title"  value="<?php echo $row["title"]?>" size="60" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >关键词（keyword）</td>
      <td class="border" ><input name="keyword" type="text" id="keyword"  value="<?php echo $row["keyword"]?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr> 
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="discription" type="text" id="discription"  value="<?php echo $row["discription"]?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr> 
      <td height="22" class="border">&nbsp;</td>
      <td class="border"> <input name="classid" type="hidden" id="classid" value="<?php echo $row["classid"]?>"> 
        <input name="action" type="hidden"  value="modify"> <input name="Save" type="submit" id="save" value=" 修 改 "> 
      </td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>