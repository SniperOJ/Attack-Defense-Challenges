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
    if (document.form1.classzm.value=="" ){
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
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if ($action=="add"){
checkadminisdo("zsclass");
$classname=nostr(trim($_POST["classname"]));
$classzm=nostr(strtolower(trim($_POST["classzm"])));
$img=trim($_POST["img"]);
if (!isset($_POST["isshow"])){
$isshow=0;
}else{
$isshow=$_POST["isshow"];
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
		
		$sql="Select * From zzcms_zsclass Where classname='" .$classname. "'";
		$rs=query($sql);
		$row= num_rows($rs);//返回记录数
		if ($row){
		$FoundErr=1;
		$ErrMsg="<br><li>大类名“" . $classname . "”已经存在！</li>";
		
		}else{
		$sql="insert into zzcms_zsclass (parentid,classname,classzm,img,isshow,title,keyword,discription) values
		('A','$classname','$classzm','img','$isshow','$title','$keyword','$discription')";
		$isok=query($sql);
		$rs=query("select * from zzcms_zsclass where classname='".$classname."'");
		$row= fetch_array($rs);
		$bcid=$row["classid"];
				
query("CREATE TABLE `zzcms_dl_".$classzm."` (
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
if ($isok){$msg="成功";}else{$msg="失败";}
echo "<script>alert('".$msg."');location.href='zsclassaddbig.php'</script>";
//echo "<script>location.href='zsclassmanage.php?#B".$bcid."'<//script>";
}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{		
?>
<form name="form1" method="post" action="?action=add" onSubmit="return checkform()">
<div class="admintitle">添加大类</div>
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
      <td width="18%" align="right" class="border"> 大类名称</td>
      <td width="82%" class="border"> <input name="classname" id="classname" type="text" size="60" maxlength="30">      </td>
    </tr>
    <tr> 
      <td align="right" class="border"> 大类名称拼音</td>
      <td class="border">
<span id="quote">  
<input name="classzm" type="text" size="60" maxlength="30"> 
</span>      </td>
    </tr>
    <tr>
      <td align="right" class="border"> 大类名称前的图标地址</td>
      <td class="border">
        <input name="img" type="text" size="60" maxlength="50">
      </td>
    </tr>
    <tr> 
      <td align="right" class="border">是否显在首页显示该大类</td>
      <td width="82%" class="border"><input name="isshow" type="checkbox" id="isshow" value="1" checked>
        （选中为显示）</td>
    </tr>
    <tr> 
      <td height="11" colspan="2" class="border">SEO优化设置（如与大类名称相同，以下可以留空不填） </td>
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
    <tr> 
      <td height="11" class="border">&nbsp;</td>
      <td height="11" class="border"> 
        <input name="Add" type="submit" value=" 添 加 "></td>
    </tr>
  </table>
</form>
 <?php
 }
 ?>
</body>
</html>