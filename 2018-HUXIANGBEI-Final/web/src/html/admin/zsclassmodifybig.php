<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
function checkform(){
  if (document.form1.classname.value==""){
    alert("名称不能为空！");
    document.form1.classname.focus();
    return false;
  }
    if (document.form1.classzm.value==""){
    alert("字母不能为空！");
    document.form1.classzm.focus();
    return false;
  }
if (document.form1.classzm.value=="a" || document.form1.classzm.value=="A"){
    alert("字母不能为a！");
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
if (@$_REQUEST["action"]=="modify"){
checkadminisdo("zsclass");
$classname=nostr(trim($_POST["classname"]));
$oldclassname=trim($_POST["oldclassname"]);
$classzm=nostr(strtolower(trim($_POST["classzm"])));
$oldclasszm=trim($_POST["oldclasszm"]);
$img=trim($_POST["img"]);
$isshow=$_POST["isshow"];
if ($isshow==""){
$isshow=0;
}
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
	if ($classname<>$oldclassname){
	$sql="Select * from zzcms_zsclass where parentid='A' and classname='".$classname."' and classid !=" .$classid." ";
	$rs=query($sql);
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg="<li>此大类名称已存在！</li>";
		}
	}
	
	if ($classzm<>$oldclasszm) {
	$sql="Select * from zzcms_zsclass where parentid='A' and classzm='".$classzm."' and classid != " .$classid." ";
	$rs=query($sql);
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg="<li>此大类名拼音已存在！</li>";
		}
	}
		
	if ($FoundErr==0) {
	query("update zzcms_zsclass set classname='$classname',classzm='$classzm',img='$img',
	isshow='$isshow',title='$title',keyword='$keyword',discription='$discription' where classid='$classid'");
		
		if ($classzm<>$oldclasszm){
		query("update zzcms_main set bigclasszm='".$classzm."' where bigclasszm='".$oldclasszm."'");
		query("update zzcms_dl set classzm='".$classzm."' where classzm='".$oldclasszm."'");
		query("update zzcms_zsclass set parentid='".$classzm."' where parentid='".$oldclasszm."'");
		query("RENAME TABLE `zzcms_dl_".$oldclasszm."` TO `zzcms_dl_".$classzm."`");
		}
		
/*query("CREATE TABLE `zzcms_dl_".$classzm."` (
  `id` int(11) NOT NULL auto_increment,
  `dlid` int(11) default '0',
  `cpid` int(11) default '0',
  `cp` varchar(255) default NULL,
  `province` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `xiancheng` varchar(50) default NULL,
  `content` varchar(1000) default NULL,
  `company` varchar(255) default NULL,
  `companyname` varchar(255) default NULL,
  `dlsname` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `tel` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `editor` varchar(255) default NULL,
  `saver` varchar(255) default NULL,
  `savergroupid` int(11) default '0',
  `ip` varchar(255) default NULL,
  `sendtime` datetime default NULL,
  `hit` int(11) default '0',
  `looked` tinyint(4) default '0',
  `passed` tinyint(4) default '0',
  `del` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8");
query("ALTER TABLE  `zzcms_dl_".$classzm."` ADD INDEX (  `province` ,  `city` ,  `xiancheng` )") ;
*/	
		echo "<script>location.href='zsclassmanage.php?#B".$classzm."'</script>";
	}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
$rs=query("Select * from zzcms_zsclass where classid='" .$classid."'");
$row= fetch_array($rs);
?>
<form name="form1" method="post" action="?action=modify" onSubmit="return checkform()">
<div class="admintitle">修改大类</div>
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
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="255" align="right" class="border">大类ID</td>
      <td width="1160" class="border"><?php echo $row["classid"]?> <input name="classid" type="hidden" id="classid" value="<?php echo $row["classid"]?>">      </td>
    </tr>
    <tr> 
      <td width="255" align="right" class="border">大类名称</td>
      <td class="border"> <input name="classname" type="text" id="classname" value="<?php echo $row["classname"]?>" size="60" maxlength="30"> 
        <input name="oldclassname" type="hidden" id="oldclassname" value="<?php echo $row["classname"]?>" size="60" maxlength="30"></td>
    </tr>
    <tr> 
      <td align="right" class="border">大类名称拼音</td>
      <td class="border"> 
	  <span id="quote"> 
	  <input name="classzm" type="text" id="classzm" value="<?php echo $row["classzm"]?>" size="60" maxlength="30"> 
	  </span> 
        <input name="oldclasszm" type="hidden" id="oldclasszm" value="<?php echo $row["classzm"]?>" size="60" maxlength="30"></td>
    </tr>
    <tr>
      <td align="right" class="border">大类名称前的图标地址</td>
      <td class="border">
        <input name="img" type="text" id="img" value="<?php echo $row["img"]?>" size="60" maxlength="50">
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">是否显在首页显示该大类</td>
      <td width="1160" class="border"><input name="isshow" type="checkbox" id="isshow" value="1" <?php if ($row["isshow"]==1) { echo"checked";}?>>
        （选中为显示）</td>
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
      <td class="border">&nbsp;</td>
      <td class="border"> <input name="action" type="hidden" id="action" value="modify"> 
        <input name="Save" type="submit" id="Save" value=" 修 改 "> </td>
    </tr>
  </table>
</form>
<?php
}
?>
</body>
</html>