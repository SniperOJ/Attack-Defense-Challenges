<?php
include("admin.php");
if (isset($_GET['tablename'])){
$_SESSION['tablename']=$_GET['tablename'];
}
if ($_SESSION['tablename']==''){
showmsg('请选择类别');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" src="/js/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig(){
   if(confirm("确定要删除此类吗？"))
     return true;
   else
     return false;	 
}
function CheckForm(){  
if (document.form1.bigclassname.value==""){
    alert("名称不能为空！");
	document.form1.bigclassname.focus();
	return false;
  }
}
</script>
</head>
<body>
<?php
checkadminisdo("userclass");
if (isset($_REQUEST['dowhat'])){
$dowhat=$_REQUEST['dowhat'];
}else{
$dowhat="";
}
switch ($dowhat){
case "addtag";
addtag();
break;
case "modifytag";
modifytag();
break;
default;
showtag();
}
function showtag(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if ($action=="px") {
$sql="Select * From ".$_SESSION['tablename']."";
$rs=query($sql);
while ($row=fetch_array($rs)){
$xuhao=$_POST["xuhao".$row["bigclassid"].""];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhao) == "" || is_numeric($xuhao) == false) {
	       $xuhao = 0;
	   }elseif ($xuhao < 0){
	       $xuhao = 0;
	   }else{
	       $xuhao = $xuhao;
	   }
query("update ".$_SESSION['tablename']." set xuhao='$xuhao' where bigclassid=".$row['bigclassid']."");
}
}
if ($action=="del"){
checkadminisdo("siteconfig");
$bigclassid=trim($_REQUEST["bigclassid"]);
if ($bigclassid<>""){
	$sql="delete from ".$_SESSION['tablename']." where bigclassid=" .$bigclassid. " ";
	query($sql);
}    
echo "<script>location.href='?'</script>";
}
?>
<div class="admintitle">类别管理</div> 
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="center" class="border">
      <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='?dowhat=addtag'" value="添加">
      </td>
  </tr>
</table>
	<?php
	$sql="Select * From ".$_SESSION['tablename']." order by xuhao asc";
	$rs=query($sql);
	$row=num_rows($rs);
	if (!$row){
	echo "暂无信息";
	}else{
?>
      <form name="form1" method="post" action="?action=px">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="1" >
    <tr> 
      <td width="20%" class="border">ID</td>
      <td width="20%" class="border">类别</td>
      <td width="20%" class="border">排序</td>
      <td width="20%" height="25" class="border">操作选项</td>
    </tr>
    <?php
	while ($row=fetch_array($rs)){
?>
     <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
      <td><?php echo $row["bigclassid"]?><a name="B<?php echo $row["bigclassid"]?>"></a></td>
      <td><?php echo $row["bigclassname"]?></td>
      <td><input name="<?php echo "xuhao".$row["bigclassid"]?>" type="text" id="<?php echo "xuhao".$row["bigclassid"]?>" value="<?php echo $row["xuhao"]?>" size="4" maxlength="4"> 
       <input type="submit" name="Submit" value="更新序号"></td>
      <td class="docolor"> <a href="?dowhat=modifytag&bigclassid=<?php echo $row["bigclassid"]?>">修改名称</a> 
        | <a href="?action=del&bigclassid=<?php echo $row["bigclassid"]?>" onClick="return ConfirmDelBig();">删除</a></td>
    </tr>
    <?php
	}
	?>
  </table>
	  </form>
<?php
}
}

function addtag(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}

if ($action=="add"){
    for($i=0; $i<count($_POST['bigclassname']);$i++){
    $bigclassname=($_POST['bigclassname'][$i]);
		if ($bigclassname!=''){
		$sql="select * from ".$_SESSION['tablename']." where bigclassname='" . $bigclassname . "'";
		$rs=query($sql);
		$row=num_rows($rs);
			if (!$row) {
			query("insert into ".$_SESSION['tablename']." (bigclassname)VALUES('$bigclassname') ");
			}
		}
	}	
    echo "<script>location.href='?'</script>";		
}else{	
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">添加类别</td>
  </tr>
</table>
<form name="form1" method="post" action="?dowhat=addtag" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td width="70%">
<script language="javascript">   
//动态增加表单元素。
function AddElement(){   
//得到需要被添加的html元素。
var TemO=document.getElementById("add");   
//var newInput = document.createElement("<input type='text' size='50'maxlength='50' name='bigclassname[]' id='bigclassname[]' value='类别名称'>");
if($.browser.msie) {
	var newInput = document.createElement("<input type='text' size='50' maxlength='50' name='bigclassname[]' id='bigclassname[]' value='类别名称'>");
	}else{
	var newInput = document.createElement("input");
	newInput.type = "text";
	newInput.name = "bigclassname[]";
	newInput.id = "bigclassname[]";
	newInput.size = "50";
	newInput.maxlength = "50";
	newInput.value = "类别名称";
	}
TemO.appendChild(newInput);     
var newline= document.createElement("hr"); 
TemO.appendChild(newline);   
}   
</script>
	<div id="add">
	  <input name="bigclassname[]" type="text" id="bigclassname[]" value="类别名称" size="50" maxlength="50">
	  <hr>
	  </div>	  </td>
    </tr>
    <tr> 
      <td> <img src="image/icobigx.gif" width="23" height="11">
        <a href="#" onClick='AddElement()'><img src='image/icobig.gif' border="0"> 添加新类别</a>
        <input name="add" type="submit" value="提交">
        <input name="action" type="hidden" id="action" value="add">
        </td>
    </tr>
  </table>
</form>
<?php
}
}

function modifytag(){
$action = isset($_REQUEST['action']) ? $_REQUEST['action']:''; 
$bigclassid = isset($_REQUEST['bigclassid']) ? $_REQUEST['bigclassid']:''; 
$bigclassname = isset($_POST['bigclassname']) ? trim($_POST['bigclassname']):''; 
$oldbigclassname = isset($_POST['oldbigclassname'])?trim($_POST['oldbigclassname']):''; 

if ($bigclassid==""){
echo "<script>location.href='?'</script>";
}

if ($action=="modify"){
	$sql="Select * from ".$_SESSION['tablename']." where bigclassid=" . $bigclassid."";
	$rs=query($sql);
	$row=num_rows($rs);
	if (!$row){
		$FoundErr==1;
		$ErrMsg="<li>不存在！</li>";
		WriteErrMsg($ErrMsg);
	}else{
	query("update ".$_SESSION['tablename']." set bigclassname='$bigclassname' where bigclassid=". $bigclassid." ");
	if ($_SESSION['tablename']=='zzcms_adclass' && $bigclassname!=$oldbigclassname){
	query("update zzcms_ad set bigclassname='$bigclassname' where bigclassname='$oldbigclassname' ");
	}
	
	}	
	echo "<script>location.href='?#B".$bigclassid."'</script>";
}else{
$sql="Select * from ".$_SESSION['tablename']." where bigclassid=".$bigclassid."";
$rs=query($sql);
$row=fetch_array($rs);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="admintitle">修改类别</td>
  </tr>
</table>
<form name="form1" method="post" action="?dowhat=modifytag" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="border">
    <tr> 
      <td width="30%" align="right">类别名称：</td>
      <td width="70%"> <input name="bigclassname" type="text" id="bigclassname" value="<?php echo $row["bigclassname"]?>" size="50" maxlength="50">
      <input name="oldbigclassname" type="hidden" id="oldbigclassname" value="<?php echo $row["bigclassname"]?>" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="bigclassid" type="hidden" id="bigclassid" value="<?php echo $row["bigclassid"]?>"> 
        <input name="action" type="hidden" id="action" value="modify"> <input name="save" type="submit" id="save" value=" 修改 "> 
      </td>
    </tr>
  </table>
</form>
<?php
}
}
?>
</body>
</html>