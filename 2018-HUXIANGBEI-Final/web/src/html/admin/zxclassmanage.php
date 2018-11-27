<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<title></title>
<script language="JavaScript" src="/js/gg.js"></script>
<script language="JavaScript" src="/js/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">
function ConfirmDelBig(){
   if(confirm("确定要删除此大类吗？删除此大类同时将删除所包含的小类，并且不能恢复！"))
     return true;
   else
     return false;	 
}
function ConfirmDelSmall(){
   if(confirm("确定要删除此小类吗？一旦删除将不能恢复！"))
     return true;
   else
     return false;	 
}
function CheckForm(){  
if (document.form1.classname.value==""){
    alert("名称不能为空！");
	document.form1.classname.focus();
	return false;
  }
}
</script>
</head>
<body>
<?php
if (isset($_REQUEST['dowhat'])){
$dowhat=$_REQUEST['dowhat'];
}else{
$dowhat="";
}
switch ($dowhat){
case "addbigclass";
checkadminisdo("zxclass");
addbigclass();
break;
case "addsmallclass";
checkadminisdo("zxclass");
addsmallclass();
break;
case "modifybigclass";
checkadminisdo("zxclass");
modifybigclass();
break;
case "modifysmallclass";
checkadminisdo("zxclass");
modifysmallclass();
break;
default;
showclass();
}

function showclass(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if ($action=="px") {
checkadminisdo("zxclass");
$sql="Select * From zzcms_zxclass where parentid=0";
$rs=query($sql);
while ($row=fetch_array($rs)){
$xuhao=$_POST["xuhao".$row["classid"].""];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhao) == "" || is_numeric($xuhao) == false) {
	       $xuhao = 0;
	   }elseif ($xuhao < 0){
	       $xuhao = 0;
	   }else{
	       $xuhao = $xuhao;
	   }
query("update zzcms_zxclass set xuhao='$xuhao' where classid='".$row['classid']."'");

$sqln="Select * From zzcms_zxclass where parentid=".$row["classid"]."";
$rsn=query($sqln);
while ($rown=fetch_array($rsn)){
$xuhaos=$_POST["xuhaos".$rown["classid"].""];//表单名称是动态显示的，并于FORM里的名称相同。
	   if (trim($xuhaos) == "" || is_numeric($xuhaos) == false) {
	       $xuhaos = 0;
	   }elseif ($xuhaos < 0){
	       $xuhaos = 0;
	   }else{
	       $xuhaos = $xuhaos;
	   }
query("update zzcms_zxclass set xuhao='$xuhaos' where classid='".$rown['classid']."'");
}
}
}

if ($action=="delbig") {
checkadminisdo("zxclass");
$bigclassid=trim($_GET["bigclassid"]);
if ($bigclassid<>"") {
	query("delete from zzcms_zxclass where parentid=" . $bigclassid. "");
	query("delete from zzcms_zxclass where classid=" . $bigclassid. "");
}
//      
echo "<script>location.href='?'</script>";
}

if ($action=="delsmall") {
checkadminisdo("zxclass");
$smallclassid=trim($_GET["smallclassid"]);
if ($smallclassid<>"") {
	query("delete from zzcms_zxclass where classid=" . $smallclassid. "");
}
//      
echo "<script>location.href='?#B".$_REQUEST["bigclassid"]."'</script>";
}
?>
<div class="admintitle">资讯类别设置</div>
<div style="text-align:center"  class="border">
      <input name="submit3" type="submit" class="buttons" onClick="javascript:location.href='?dowhat=addbigclass'" value="添加大类">
</div>
<?php
$sql="Select * From zzcms_zxclass where parentid=0 order by xuhao";
$rs=query($sql);
$row=num_rows($rs);
if (!$row){
echo "暂无分类信息";
}else{
?>
<form name="form1" method="post" action="?action=px">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
    <tr> 
      <td width="20%" class="border" ><strong>类别名称</strong></td>
      <td width="20%" align="center" class="border" ><b>类别属性</b> </td>
      <td width="20%" align="center" class="border" ><strong>所用模板文件</strong></td>
      <td width="20%" class="border" ><strong>排序</strong></td>
      <td width="20%" class="border" ><strong>操作</strong></td>
    </tr>
    <?php while ($row=fetch_array($rs)){?>
    <tr bgcolor="#F1F1F1"> 
      <td style="font-weight:bold"><a name="B<?php echo $row["classid"]?>"></a><img src="image/icobig.gif" width="9" height="9"> 
        <?php echo $row["classname"]?></td>
      <td align="center" bgcolor="#f1f1f1" >用户在此类下发信息 [ 
        <?php if ($row["isshowforuser"]==1) { echo "允许";} else{ echo "<font color=red>不许</font>";}?>
        ]<br>
        在资讯版块显示此类 [ 
		<?php if ($row["isshowininfo"]==1) { echo "显示";} else{ echo "<font color=red>不显</font>";}?>
        
        ] </td>
      <td bgcolor="#f1f1f1" >
	  <?php
	   $skin=explode("|",$row["skin"]);
	  ?>
	  分类页模板：<a href="/template/<?php echo siteskin?>/<?php echo $skin[0]?>" target="_blank"><?php echo $skin[0]?></a><br>
	  列表页模板：<a href="/template/<?php echo siteskin?>/<?php echo $skin[1]?>" target="_blank"><?php echo @$skin[1]?></a>	
	  </td>
      <td > <input name="<?php echo "xuhao".$row["classid"]?>" type="text"  value="<?php echo $row["xuhao"]?>" size="4"> 
      <input type="submit" name="Submit" value="更新序号"></td>
      <td >[ <a href="?dowhat=modifybigclass&classid=<?php echo $row["classid"]?>">修改</a> 
        | <a href="?action=delbig&bigclassid=<?php echo $row["classid"]?>" onClick="return ConfirmDelBig();">删除</a> 
        | <a href="?dowhat=addsmallclass&bigclassid=<?php echo $row["classid"]?>">添加子栏目</a> 
        ] </td>
    </tr>
    <?php
		
	$n=0;
	$sqln="Select * From zzcms_zxclass Where parentid=" . $row["classid"] . " order by xuhao";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	if ($rown){
	while ($rown=fetch_array($rsn)){
	?>
    <tr class="bgcolor1" onMouseOver="fSetBg(this)" onMouseOut="fReBg(this)">  
      <td ><a name="S<?php echo $rown["classid"]?>"></a><img src="image/icosmall.gif" width="23" height="11"> 
        <?php echo $rown["classname"]?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input name="<?php echo "xuhaos".$rown["classid"]?>" type="text"  value="<?php echo $rown["xuhao"]?>" size="4"> 
        <input name="checked" type="submit" id="checked" value="更新序号"></td>
      <td>[ <a href="?dowhat=modifysmallclass&classid=<?php echo $rown["classid"]?>">修改</a> 
        | <a href="?action=delsmall&smallclassid=<?php echo $rown["classid"]?>&bigclassid=<?php echo $row["classid"]?>" onClick="return ConfirmDelSmall();">删除</a> 
        ] </td>
    </tr>
    <?php
		$n=$n+1;
		}
	 }
	}
	  ?>
  </table>
</form>
<?php
}
//	  
}

function addbigclass(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
$FoundErr=0;
$ErrMsg="";

if ($action=="add"){

for($i=0; $i<count($_POST['classname']);$i++){
	$classname=($_POST['classname'][$i]);

	if(!empty($_POST['isshowforuser'])){
	$isshowforuser=$_POST['isshowforuser'][$i];
	}else{
	$isshowforuser=0;
	}

	if(!empty($_POST['isshowininfo'])){
	$isshowininfo=$_POST['isshowininfo'][$i];
	}else{
	$isshowininfo=0;
	}

	if ($classname!=''){
	$sql="Select * From zzcms_zxclass Where classname='" . $classname . "'";
	$rs=query($sql);
	$row=num_rows($rs);
		if (!$row) {
		query("insert into zzcms_zxclass (classname,parentid,isshowforuser,isshowininfo)values('$classname',0,'$isshowforuser','$isshowininfo')");	
		}
	}
}	
$rsbcid=query("select classid from zzcms_zxclass where classname='".$classname."'");
$rowbcid=fetch_array($rsbcid);
$bcid=$rowbcid["classid"];
echo "<script>location.href='?#B".$bcid."'</script>";	
}
if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
?>
<div class="admintitle">添加大类</div>
<form name="form1" method="post" action="?dowhat=addbigclass" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="100%" class="border">
	  	  <script language="javascript">   
//动态增加表单元素。
function AddElement(){   
//得到需要被添加的html元素。
var TemO=document.getElementById("add");   
	if($.browser.msie) {
	var newInput = document.createElement("<input type='text' size='50' maxlength='50' name='classname[]' value='大类别名称'>");
	TemO.appendChild(newInput); 
	var newInput = document.createElement("<input name='isshowforuser[]' type='checkbox'  value='1' title='是否允许[用户]在此类下发布信息' checked>");
	TemO.appendChild(newInput);
	var newInput = document.createElement("<input name='isshowininfo[]' type='checkbox' value='1' title='是否在前台显示该类别' checked>");
	TemO.appendChild(newInput);    
	}else{
	var newInput = document.createElement("input");
	newInput.type = "text";
	newInput.name = "classname[]";
	newInput.size = "50";
	newInput.maxlength = "50";
	newInput.value = "大类别名称";
	TemO.appendChild(newInput);
	
	var newInput = document.createElement("input");
	newInput.type = "checkbox";
	newInput.name = "isshowforuser[]";
	newInput.title = "是否允许[用户]在此类下发布信息";
	newInput.value = "1";
	newInput.checked =true;
	TemO.appendChild(newInput);
	
	var newInput = document.createElement("input");
	newInput.type = "checkbox";
	newInput.name = "isshowininfo[]";
	newInput.title = "是否在前台显示该类别";
	newInput.value = "1";
	newInput.checked =true;
	TemO.appendChild(newInput);
	} 
var newline= document.createElement("hr"); 
TemO.appendChild(newline);   
}   
</script>
<div id="add">
	  <input name="classname[]" type="text" id="classname[]" size="50" maxlength="50"  value='大类别名称' >
	  <input name="isshowforuser[]" type="checkbox" id="isshowforuser" value="1" checked >
	  <label for='isshowforuser'>是否允许[用户]在此类下发布信息</label>
	  <input name="isshowininfo[]" type="checkbox" id="isshowininfo" value="1" checked>
	  <label for='isshowininfo'>是否在前台显示该类别</label><hr/>
	  </div>	  
	   <img src="image/icobigx.gif" width="23" height="11"> <a href="#" onClick='AddElement()'><img src='image/icobig.gif' border="0"> 添加新类别</a>
	  <input name="action" type="hidden" id="action" value="add"> 
        <input name="add" type="submit" value="提交">
	  </td>
    </tr>
  </table>
</form>
<?php
}
//
}

function addsmallclass(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
$bigclassid=trim($_REQUEST["bigclassid"]);
$FoundErr=0;
$ErrMsg="";

if ($action=="add") {
    for($i=0; $i<count($_POST['classname']);$i++){
    $classname=($_POST['classname'][$i]);
		if ($classname!=''){
		$sql="Select * From zzcms_zxclass Where parentid=" . $bigclassid . " AND classname='" . $classname . "'";
		$rs=query($sql);
		$row=num_rows($rs);
			if (!$row) {
			query("insert into zzcms_zxclass (parentid,classname)values('$bigclassid','$classname')");
			}
		}
	}	
    echo "<script>location.href='?#B".$bigclassid."'</script>";	
}
if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
?>

<div class="admintitle">添加小类</div>
<form name="form" method="post" action="?dowhat=addsmallclass" onSubmit="return CheckForm();">
  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="26%" align="right" class="border">所属大类：</td>
      <td width="74%" class="border"> 
        <?php
		$sqlb = "Select * From zzcms_zxclass where parentid=0";
	    $rsb=query($sqlb);
        $rowb=num_rows($rsb);
		if (!$rowb){
			echo "请先添加大类。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($rowb= fetch_array($rsb)){
			?>
                <option value="<?php echo $rowb["classid"]?>" <?php if ($rowb["classid"]==$bigclassid) { echo "selected";}?>><?php echo $rowb["classname"]?></option>
                <?php
		  }
		  ?>
        </select>
		<?php
		}
		?>		 </td>
    </tr>
    <tr class="tdbg"> 
      <td height="10" align="right" class="border">&nbsp;</td>
      <td class="border">
	  <script language="javascript">   
//动态增加表单元素。
function AddElement(){   
//得到需要被添加的html元素。
var TemO=document.getElementById("add");   
//var newInput = document.createElement("<input type='text' size='50' maxlength='50' name='classname[]' value='小类别名称'>");
	if($.browser.msie) {
	var newInput = document.createElement("<input type='text' size='50' maxlength='50' name='classname[]' value='小类别名称'>");
	}else{
	var newInput = document.createElement("input");
	newInput.type = "text";
	newInput.name = "classname[]";
	newInput.size = "50";
	newInput.maxlength = "50";
	newInput.value = "小类别名称";
	}
TemO.appendChild(newInput);     
var newline= document.createElement("hr"); 
TemO.appendChild(newline);   
}   
</script>
<div id="add">
	   <input name="classname[]" type="text" size="50" maxlength="50" value="小类别名称" style="margin:4px 0">
<hr/>
	  </div> 
	  <img src="image/icobigx.gif" width="23" height="11"> <a href="#" onClick='AddElement()'><img src='image/icobig.gif' border="0"> 添加新类别</a>	   
      <input name="action" type="hidden" id="action3" value="add">
      <input name="add2" type="submit" value="提交"></td>
    </tr>
  </table>
</form>
<?php
}
//
}

function modifybigclass(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_REQUEST['classid'])){
$classid=trim($_REQUEST['classid']);
}else{
$classid="";
}
$FoundErr=0;
$ErrMsg="";
if ($classid==""){
//
echo "<script>location.href='?'</script>";
}

if ($action=="modify"){
$classname=trim($_POST["classname"]);
$oldclassname=trim($_POST["oldclassname"]);
if(!empty($_POST['isshowforuser'])){
$isshowforuser=$_POST['isshowforuser'][0];
}else{
$isshowforuser=0;
}

if(!empty($_POST['isshowininfo'])){
$isshowininfo=$_POST['isshowininfo'][0];
}else{
$isshowininfo=0;
}

$title=trim($_POST["title"]);
if ($title=="") {
$title=$classname;
}

$keyword=trim($_POST["keyword"]);
if ($keyword=="") {
$keyword=$classname;
}

$discription=trim($_POST["discription"]);
if ($discription==""){
$discription=$classname;
}
$skin=$_POST["skin"][0]."|".$_POST["skin"][1];

	$sql="Select * from zzcms_zxclass where classid=" .$classid."";
	$rs=query($sql);
	$row=num_rows($rs);
	if (!$row){
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>此产品大类不存在！</li>";
	}
	
	if ($classname<>$oldclassname) {
	$sqln="Select * from zzcms_zxclass where parentid=0 and classname='".$classname."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	if ($rown){
	
		$FoundErr=1;
		$ErrMsg=$ErrMsg . "<li>此大类名称已存在！</li>";
	}
	}
		
	if ($FoundErr==0){
	query("update zzcms_zxclass set classname='$classname',isshowforuser='$isshowforuser',isshowininfo='$isshowininfo',title='$title',keyword='$keyword',discription='$discription',skin='$skin' where classid=" .$classid."");
	
		if ($classname<>$oldclassname) {//类名改变的情况下
			query("Update zzcms_zx set bigclassname='" . $classname . "'  where bigclassid=" . $classid . " ");	
		}	
		//
		echo "<script>location.href='?#B".$classid."'</script>";
	}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
$sql="Select * from zzcms_zxclass where classid=" .$classid."";
$rs=query($sql);
$row=fetch_array($rs);
?>
<div class="admintitle">修改大类</div>
<form name="form1" method="post" action="?dowhat=modifybigclass" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="322" align="right" class="border">大类ID：</td>
      <td class="border"><?php echo $row["classid"]?> <input name="classid" type="hidden" id="classid" value="<?php echo $row["classid"]?>">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">大类名称：</td>
      <td class="border"> <input name="classname" type="text" id="classname" value="<?php echo $row["classname"]?>" size="60" maxlength="30"> 
        <input name="oldclassname" type="hidden" id="oldclassname" value="<?php echo $row["classname"]?>" size="60" maxlength="30"></td>
    </tr>
    <tr class="tdbg"> 
      <td align="right" class="border">是否允许用户在此类下发布信息：</td>
      <td class="border"> 
          <input name="isshowforuser[]" type="checkbox" id="isshowforuser[]" value="1" <?php if ($row["isshowforuser"]==1) { echo "checked";}?>>
      （选中为允许） </td>
    </tr>
    <tr class="tdbg"> 
      <td align="right" class="border">是否在资讯版块显示该类别：</td>
      <td class="border"><input name="isshowininfo[]" type="checkbox" id="isshowininfo[]" value="1" <?php if ($row["isshowininfo"]==1) { echo "checked";}?>>
        （选中为显示） </td>
    </tr>
    <tr> 
      <td colspan="2" class="border">SEO优化设置（如与大类名称相同，以下可以留空不填）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >标题（title）：</td>
      <td class="border" ><input name="title" type="text" id="title" value="<?php echo $row["title"]?>" size="60" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >关键词（keyword）：</td>
      <td class="border" ><input name="keyword" type="text" id="keyword"  value="<?php echo $row["keyword"]?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr> 
      <td align="right" class="border" >描述（description）：</td>
      <td class="border" ><input name="discription" type="text" id="discription"  value="<?php echo $row["discription"]?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr id="trseo">
      <td colspan="2" class="border" >模板选择</td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >类别页模板文件</td>
      <td class="border" ><select name="skin[]" id="skin[]">
          <?php
$dir = opendir("../template/".siteskin);
$skin=explode("|",$row["skin"]);
while(($file = readdir($dir))!=false){
  //if ($file!="." && $file!=".." && $file!='test.txt' && $file!='template.zip') { //不读取. ..
   if ($file!="." && $file!=".." && strpos("zx_class",substr($file,0,8))!==false) { //不读取. ..
	?>
          <option value="<?php echo $file?>" <?php if ($skin[0]==$file){ echo  "selected";}?>><?php echo $file?></option>
          <?php
}
}
closedir($dir);
?>
      </select></td>
    </tr>
    <tr id="trkeywords">
      <td align="right" class="border" >列表页模板文件</td>
      <td class="border" ><select name="skin[]" id="skin[]">
          <?php
$dir = opendir("../template/".siteskin);
$skin=explode("|",$row["skin"]);
while(($file = readdir($dir))!=false){
  //if ($file!="." && $file!=".." && $file!='test.txt' && $file!='template.zip') { //不读取. ..
   if ($file!="." && $file!=".." && strpos("zx_list",substr($file,0,7))!==false) { //不读取. ..
	?>
          <option value="<?php echo $file?>" <?php if (@$skin[1]==$file){ echo  "selected";}?>><?php echo $file?></option>
          <?php
}
}
closedir($dir);
?>
      </select></td>
    </tr>
    <tr> 
      <td class="border">&nbsp;</td>
      <td class="border"> <input name="action" type="hidden" id="action" value="modify"> 
        <input name="save" type="submit" id="save" value=" 修 改 "> </td>
    </tr>
  </table>
</form>
<?php
}
//
}

function modifysmallclass(){
if (isset($_REQUEST['action'])){
$action=$_REQUEST['action'];
}else{
$action="";
}
if (isset($_REQUEST['classid'])){
$classid=trim($_REQUEST['classid']);
}else{
$classid="";
}
$FoundErr=0;
$ErrMsg="";
if ($classid==""){

echo "<script>location.href='?'</script>";
}

if ($action=="modify"){
$bigclassid=trim($_POST["bigclassid"]);
$oldbigclassid=trim($_POST["oldbigclassid"]);
$classname=trim($_POST["classname"]);
$oldclassname=trim($_POST["oldclassname"]);

$title=trim($_POST["title"]);
if ($title=="") {
$title=$classname;
}

$keyword=trim($_POST["keyword"]);
if ($keyword=="") {
$keyword=$classname;
}

$discription=trim($_POST["discription"]);
if ($discription==""){
$discription=$classname;
}
	$sql="Select * from zzcms_zxclass where classid=" .$classid."";
	$rs=query($sql);
	$row=num_rows($rs);
	if (!$row){
	$FoundErr=1;
	$ErrMsg=$ErrMsg . "<li>此小类不存在！</li>";
	}
	
	if ($classname<>$oldclassname || $bigclassid<>$oldbigclassid) {
	$sqln="Select * from zzcms_zxclass where parentid=".$bigclassid." and classname='".$classname."'";
	$rsn=query($sqln);
	$rown=num_rows($rsn);
	if ($rown){
		$FoundErr=1;
		$ErrMsg=$ErrMsg . "<li>此小类名称已存在！</li>";
	}
	}
	
	if ($FoundErr==0) {
	query("update zzcms_zxclass set parentid='$bigclassid',classname='$classname',title='$title',keyword='$keyword',discription='$discription' where  classid=" .$classid."");
			if ($bigclassid<>$oldbigclassid) {//小类别改变所属大类情况下
				query("Update zzcms_zx set bigclassid=" . $bigclassid . " where bigclassid=" . $oldbigclassid . " and smallclassid=" . $classid . " ");
				query("Update zzcms_zx set bigclassname=(select classname from zzcms_zxclass where classid=".$bigclassid.") where bigclassid=" . $bigclassid . " and smallclassid=" . $classid . " ");	
			}
			if ($classname<>$oldclassname) {//小类名改变的情况下
				query("Update zzcms_zx set smallclassname='" . $classname . "'  where bigclassid=" . $bigclassid . " and smallclassid=" . $classid . " ");
			}
			//
			echo "<script>location.href='?#S".$classid."'</script>";
	}
}

if ($FoundErr==1){
WriteErrMsg($ErrMsg);
}else{
$sql="Select * from zzcms_zxclass where classid=".$classid."";
$rs=query($sql);
$row=fetch_array($rs);
?>
<div class="admintitle">修改小类</div>
<form name="form1" method="post" action="?dowhat=modifysmallclass" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="327" height="22" align="right" class="border">所属大类：</td>
      <td class="border"> 
	    <?php
		$sqlb = "Select * From zzcms_zxclass where parentid=0";
	    $rsb=query($sqlb);
        $rowb=num_rows($rsb);
		if (!$rowb){
			echo "请先添加大类。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($rowb= fetch_array($rsb)){
			?>
                <option value="<?php echo $rowb["classid"]?>" <?php if ($rowb["classid"]==$row["parentid"]) { echo "selected";}?>><?php echo $rowb["classname"]?></option>
                <?php
		  }
		  ?>
        </select>
		<?php
		}
		?>    
	 
        <input name="oldbigclassid" type="hidden" id="oldbigclassid" value="<?php echo $row["parentid"]?>">      </td>
    </tr>
    <tr> 
      <td height="11" align="right" class="border">小类名称：</td>
      <td class="border"> <input name="classname" type="text" id="classname" value="<?php echo $row["classname"]?>" size="60" maxlength="30">
        <input name="oldclassname" type="hidden" id="oldclassname" value="<?php echo $row["classname"]?>"></td>
    </tr>
    <tr> 
      <td colspan="2" class="border">SEO优化设置（如与大类名称相同，以下可以留空不填）</td>
    </tr>
    <tr> 
      <td align="right" class="border" >标题（title）：</td>
      <td class="border" ><input name="title" type="text" id="title"  value="<?php echo $row["title"]?>" size="60" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >关键词（keyword）：</td>
      <td class="border" ><input name="keyword" type="text" id="keyword"  value="<?php echo $row["keyword"]?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr> 
      <td align="right" class="border" >描述（description）：</td>
      <td class="border" ><input name="discription" type="text" id="discription"  value="<?php echo $row["discription"]?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr> 
      <td height="22" class="border">&nbsp;</td>
      <td class="border"> <input name="classid" type="hidden" id="classid" value="<?php echo $row["classid"]?>">
        <input name="action" type="hidden" id="action4" value="modify"> 
        <input name="save" type="submit" id="save" value=" 修 改 "> </td>
    </tr>
  </table>
</form>
<?php
}
//
}
?>
</body>
</html>