<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<?php
if (isset($_REQUEST["action"])){
$action=$_REQUEST["action"];
}else{
$action="";
}
if ($action=="add") {
checkadminisdo("label");
$title=nostr(trim($_POST["title"]));
$title_old=trim($_POST["title_old"]);
if (substr($title,-3)!='css' and substr($title,-3)!='htm'){
showmsg('只能是htm或css这两种格式,模板名称：后面加上.htm或.css');
}
$start=stripfxg($_POST["start"]);//stripfxg如果有自动加反斜杠去反斜杠
$fp="../template/".siteskin."/".$title;
$f=fopen($fp,"w+");//fopen()的其它开关请参看相关函数
$isok=fputs($f,$start);
fclose($f);
if ($isok){
$title==$title_old ?$msg='修改成功':$msg='添加成功';
}else{
$msg="失败";
}
showmsg($msg,"?title=".$title);
}

if ($action=="del"){ 
checkadminisdo("label");
$f="../template/".siteskin."/".nostr(trim($_POST["title"]));
	if (file_exists($f)){
	unlink($f)?showmsg('删除成功',"?"):showmsg('失败');
	}else{
	showmsg('请选择要删除的模板');
	}
}
?>
<script language = "JavaScript">
function ConfirmDel(){
   if(confirm("确定要删除吗？一旦删除将不能恢复！"))
     return true;
   else
     return false;	 
}
function CheckForm(){
//创建正则表达式
var re=/^[0-9a-zA-Z_.]{1,20}$/; //只输入数字和字母的正则
if (document.myform.title.value==""){
    alert("模板名称不能为空！");
	document.myform.title.focus();
	return false;
  }
if(document.myform.title.value.search(re)==-1)  {
    alert("模板名称只能用字母，数字，_ 。且长度小于20个字符！");
	document.myform.title.focus();
	return false;
  }
if (document.myform.start.value==""){
    alert("模板内容不能为空！");
	document.myform.start.focus();
	return false;
  }
}  
</script>
</head>
<body>
<div class="admintitle">模板管理</div>
<form action="" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="100" align="right" class="border" >现有模板：</td>
      <td class="border" > 
<div class="boxlink">
<?php
$title="";
$fcontent="";
if (isset($_GET['title'])){
$title=$_GET['title'];
if (substr($title,-3)!='css' and substr($title,-3)!='htm'){
showmsg('只能是htm或css这两种格式');//防止直接输入php 文件地址显示PHP代码
}
}

$file="../template/".siteskin;
if (file_exists($file)==false){
WriteErrMsg($file.'模板文件不存在');
exit;
}
$dir = opendir("../template/".siteskin."");
while(($file = readdir($dir))!=false){
  if ($file!="." && $file!=".." && $file!='image' && $file!='label') { //不读取. ..
  		if ($title==$file){
  		echo "<li><a href='?title=".$file."' style='color:#000000;background-color:#FFFFFF'>".$file."</a></li>";
		}else{
		echo "<li><a href='?title=".$file."'>".$file."</a></li>";
		}
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。
  } 
}
closedir($dir);	
//读取现有标签中的内容
if ($title!=''){
$fp='../template/'.siteskin.'/'.$title;
$f=fopen($fp,'r');
$fcontent=fread($f,filesize($fp));
fclose($f);
} 
	   ?>
</div>
 </td>
    </tr>
    <tr> 
      <td align="right" class="border" >模板名称：</td>
      <td class="border" ><input name="title" type="text" id="title" value="<?php echo $title?>" size="50" maxlength="255">
      <input name="title_old" type="hidden" id="title_old" value="<?php echo $title?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >模板内容：</td>
      <td class="border" ><textarea name="start" cols="150" rows="28" id="start" class="bigtextarea"><?php echo $fcontent?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <input type="submit" name="Submit" value="提交" onClick="myform.action='?action=add'"> 
        <input type="submit" name="Submit2" value="删除选中" onClick="myform.action='?action=del';return ConfirmDel()" ></td>
    </tr>
  </table>
      </form>
  
</body>
</html>