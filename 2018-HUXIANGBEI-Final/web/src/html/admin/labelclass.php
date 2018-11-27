<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<title></title>
<?php
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if (isset($_REQUEST['classname'])){
$classname=$_REQUEST['classname'];
}else{
$classname="";
}

if ($action=="add") {
checkadminisdo("label");//可查看不可修改
$title=nostr(trim($_POST["title"]));
$title_old=trim($_POST["title_old"]);
$startnumber=trim($_POST["startnumber"]);
$numbers=trim($_POST["numbers"]);
$row=trim($_POST["row"]);
$start=stripfxg($_POST["start"]);
$mids=stripfxg($_POST["mids"]);
$ends=stripfxg($_POST["ends"]);

$f="../template/".siteskin."/label/".$classname."/".$title.".txt";
$fp=fopen($f,"w+");//fopen()的其它开关请参看相关函数
$str=$title . "|||" .$startnumber. "|||"  . $numbers . "|||" . $row . "|||" . $start . "|||" . $mids . "|||" . $ends;
fputs($fp,$str);
fclose($fp);
$title==$title_old ?$msg='修改成功':$msg='添加成功';
echo "<script>alert('".$msg."');location.href='?classname=".$classname."&labelname=".$title.".txt'</script>";
}

if ($action=="del") {
checkadminisdo("label");//可查看不可修改
$f="../template/".siteskin."/label/".$classname."/".nostr(trim($_POST["title"])).".txt";
	if (file_exists($f)){
	unlink($f);
	}else{
	echo "<script>alert('请选择要删除的标签');history.back()</script>";
	}	
}
?>
<script language = "JavaScript">
function CheckForm(){
var re=/^[0-9a-zA-Z_]{1,20}$/; //只输入数字和字母的正则
if (document.myform.title.value==""){
    alert("标签名称不能为空！");
	document.myform.title.focus();
	return false;
  }
if(document.myform.title.value.search(re)==-1)  {
    alert("标签名称只能用字母，数字，_ 。且长度小于20个字符！");
	document.myform.title.focus();
	return false;
  }      
//定义正则表达式部分
var strP=/^\d+$/;
if(!strP.test(document.myform.numbers.value)) {
alert("只能填数字！"); 
document.myform.numbers.focus(); 
return false; 
} 

if(!strP.test(document.myform.row.value)) {
alert("只能填数字！"); 
document.myform.row.focus(); 
return false; 
} 
}  
</script>
</head>
<body>
<div class="admintitle"><?php echo  $classname?>标签添加</div>
<form action="" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="150" align="right" class="border" >现有标签：</td>
      <td class="border" > 
	  <div class="boxlink">
        <?php
$labelname="";
if (isset($_GET['labelname'])){
$labelname=$_GET['labelname'];
if (substr($labelname,-3)!='txt'){
showmsg('只能是txt这种格式');//防止直接输入php 文件地址显示PHP代码
}
}

if (file_exists("../template/".siteskin."/label/".$classname."")==false){
echo '文件不存在';
}else{			
$dir = opendir("../template/".siteskin."/label/".$classname."");
while(($file = readdir($dir))!=false){
	if ($file!="." && $file!="..") { //不读取. ..
    //$f = explode('.', $file);//用$f[0]可只取文件名不取后缀。
		if ($labelname==$file){
  		echo "<li><a href='?classname=".$classname."&labelname=".$file."' style='color:#000000;background-color:#FFFFFF'>".$file."</a></li>";
		}else{
		echo "<li><a href='?classname=".$classname."&labelname=".$file."'>".$file."</a></li>";
		}
	} 
}
closedir($dir);
}
//读取现有标签中的内容
if ($labelname!=''){
$fp="../template/".siteskin."/label/".$classname."/".$labelname;
$f=fopen($fp,"r+");
$fcontent="";
while (!feof($f))
{
    $fcontent=$fcontent.fgets($f);
}
fclose($f);
$fcontent=removeBOM($fcontent);//去除BOM信息，使修改时不用再重写标签名
$f=explode("|||",$fcontent) ;
$title=$f[0];
$startnumber=$f[1];
$numbers=$f[2];
$row=$f[3];
$start=$f[4];
$mids=$f[5];
$ends=$f[6];	
}else{
$title="";
$startnumber=0;
$numbers="";
$row="";
$start="";
$mids="";
$ends="";
} 
	   ?>
	   </div>
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >标签名称：</td>
      <td class="border" >
<input name="title" type="text" id="title" value="<?php echo $title?>" size="50" maxlength="255">
<input name="title_old" type="hidden" id="title_old" value="<?php echo $title?>" size="50" maxlength="255">      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >调用条数：</td>
      <td class="border" >从第
        <input name="startnumber" type="text" id="startnumber"  value="<?php echo $startnumber?>" size="5" maxlength="50">
        条开始，调用
        <input name="numbers" type="text"  value="<?php echo $numbers?>" size="5" maxlength="50">
        条 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >列数：</td>
      <td class="border" > <input name="row" type="text" id="row" value="<?php echo $row?>" size="5" maxlength="50">
        （分几列显示）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（开始）：</td>
      <td class="border" ><textarea name="start" cols="100" rows="6" id="start" style="width:100%"><?php echo $start?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（循环）：</td>
      <td class="border" ><textarea name="mids" cols="100" rows="6" id="mids" style="width:100%"><?php echo $mids?></textarea> 
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >解释模板（结束）：</td>
      <td class="border" ><textarea name="ends" cols="100" rows="6" id="ends" style="width:100%"><?php echo $ends?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" > <input type="submit" name="Submit" value="添加/修改" onClick="myform.action='?action=add&classname=<?php echo $classname?>'"> 
        <input type="submit" name="Submit2" value="删除选中的标签" onClick="myform.action='?action=del&classname=<?php echo $classname?>'"> 
      </td>
    </tr>
  </table>
      </form>
</body>
</html>