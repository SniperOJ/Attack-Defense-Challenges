<?php
if(!isset($_SESSION)){session_start();} 
include("../inc/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<link href="/template/<?php echo siteskin?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
$(function(){
$("#getcode_math").click(function(){
		$(this).attr("src",'/one/code_math.php?' + Math.random());
	});
});  


function check_truename(){
if (document.myform.truename.value !=""){
	 //创建正则表达式
    var re=/^[\u4e00-\u9fa5]{2,10}$/; //只输入汉字的正则
    if(document.myform.truename.value.search(re)==-1)
    {
	
	alert("联系人只能为汉字，字符介于2到10个。");
	document.myform.truename.value="";
	document.myform.truename.focus();
	}
}
}


function CheckForm(){
if (document.myform.title.value==""){
    alert("请输入问题！");
	document.myform.title.focus();
	return false;
  }
}
</SCRIPT>
</head>
<body>
<?php
include("../inc/top2.php");
echo sitetop();
?>
<div class="main">
<div class="pagebody">
<div class="titles">提问</div>
<div class="content">
<form action="?" method="post" name="myform" id="myform" onSubmit="return CheckForm();">      
  <table width="100%" border="0" cellpadding="8" cellspacing="1">
    <tr> 
      <td width="130" align="right" class="border2">类别 <font color="#FF0000">*</font></td>
      <td class="border2"><?php

$sql = "select * from zzcms_askclass where parentid<>0 order by xuhao asc";
$rs=query($sql);
?>
        <script language = "JavaScript" type="text/javascript">
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
        <select name="bigclassid"  onchange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类 </option>
          <?php
	$sql = "select * from zzcms_askclass where isshowforuser=1 and parentid=0 order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
		if ($row["classid"]==@$b){
	?>
          <option value="<?php echo trim($row["classid"])?>" selected="selected"><?php echo trim($row["classname"])?></option>
          <?php
		}elseif($row["classid"]==@$_SESSION["bigclassid"] && @$b==''){	
				?>
          <option value="<?php echo trim($row["classid"])?>" selected="selected"><?php echo trim($row["classname"])?></option>
          <?php 
		}else{
		?>
          <option value="<?php echo trim($row["classid"])?>"><?php echo trim($row["classname"])?></option>
          <?php 
		}
	}	
		?>
        </select>
        <select name="smallclassid">
          <option value="0">请选择小类 </option>
          <?php
if ($b!=''){//从index.php获取的大类值优先
$sql="select * from zzcms_askclass where parentid=".$b." order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
				?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$s) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php
	}
}elseif($_SESSION["bigclassid"]!=''){
$sql="select * from zzcms_askclass where parentid=" .@$_SESSION["bigclassid"]." order by xuhao asc";
$rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$_SESSION["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php 
	}
	}
	?>
        </select></td>
    </tr>
    <tr>
      <td align="right" class="border">问题 <font color="#FF0000">*</font></td>
      <td class="border"><input name="title" type="text" id="title" size="45" maxlength="45" value="<?php echo @$_POST['keyword']?>"/>      </td>
    </tr>
	<?php
	if (isset($_COOKIE["UserName"])){
	$sql="select * from zzcms_user where username='".$_COOKIE["UserName"]."'";
	$rs=query($sql);
	$row= fetch_array($rs);
	?>
	<?php }else{?>
	<?php 
	}
	?>
    <tr> 
    <td align="right" class="border2">内容：</td>      
    <td class="border2">
	<textarea name="content" id="content"></textarea> 
            <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script></td>
    </tr>
    <tr>
      <td align="right" class="border2">答案 <font color="#FF0000">*</font></td>
      <td class="border2"><script type="text/javascript">CKEDITOR.replace('content');</script>
        <input name="yzm" type="text" class="biaodan2" id="yzm" tabindex="10" value="" size="10" maxlength="50" style="width:60px"/>
        <img src="/one/code_math.php" align="absmiddle" id="getcode_math" title="看不清，点击换一张" /></td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"> 
        <input name="Submit" type="submit" class="buttons" value="发 布">
        <input name="action" type="hidden" id="action3" value="add"></td>
    </tr>
  </table>
</form>
<?php
if (isset($_POST["action"])){
checkyzm($_POST["yzm"]);

if (isset($_POST["bigclassid"])){
$bigclassid=trim($_POST["bigclassid"]);
}else{
$bigclassid=0;
}
$bigclassname="";
if ($bigclassid!=0){
$bigclassid=trim($_POST["bigclassid"]);
$rs = query("select * from zzcms_askclass where classid='$bigclassid'"); 
$row= fetch_array($rs);
$bigclassname=$row["classname"];
}

if (isset($_POST["smallclassid"])){
$smallclassid=trim($_POST["smallclassid"]);
}else{
$smallclassid=0;
}
$smallclassname="";
if ($smallclassid!=0){
$rs = query("select * from zzcms_askclass where classid='$smallclassid'"); 
$row= fetch_array($rs);
$smallclassname=$row["classname"];
}

$title=trim($_POST["title"]);
$content=str_replace("'","",stripfxg(trim($_POST["content"])));
$img=getimgincontent($content);

if ($title<>''){
$isok=query("Insert into zzcms_ask(bigclassid,bigclassname,smallclassid,smallclassname,title,content,img,jifen,editor,passed,sendtime) values('$bigclassid','$bigclassname','$smallclassid','$smallclassname','$title','$content','$img','0','未登陆用户',1,'".date('Y-m-d H:i:s')."')");  
}  
if ($isok){
echo showmsg('发布成功，审核后显示。');
}else{
echo showmsg('发布失败！');
}


}	
?>
</div>
</div>
</div>
<?php
include("../inc/bottom.php");
echo sitebottom();
?>
</body>
</html>