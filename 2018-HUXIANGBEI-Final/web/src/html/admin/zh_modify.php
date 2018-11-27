<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择展会类型！");
	document.myform.bigclassid.focus();
	return false;
  }	 	  
if (document.myform.title.value==""){
    alert("展会名称不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.timestart.value==""){
    alert("展会开始时间不能为空！");
	document.myform.timestart.focus();
	return false;
  }
  if (document.myform.timeend.value=="") {
    alert("展会截止时间不能为空！");
	document.myform.timeend.focus();
	return false;
  } 
}    
</script>
</head>
<body>
<?php
checkadminisdo("zh");
$id=$_REQUEST["id"];
if ($id<>""){
checkid($id);
}else{
$id=0;
}
?>
<div class="admintitle">修改展会信息</div>
<?php
$sql="select * from zzcms_zh where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="zh_save.php?action=modify" method="post" name="myform"  id="myform" onSubmit="return CheckForm();">
        
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">所属类别：</td>
      <td class="border"> 
	   <?php
		$sqln = "select * from zzcms_zhclass order by xuhao asc";
	    $rsn=query($sqln);
        $rown=num_rows($rsn);
		if (!$rown){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($rown= fetch_array($rsn)){
			?>
                <option value="<?php echo $rown["bigclassid"]?>" <?php if ($rown["bigclassid"]==$row["bigclassid"]) { echo "selected";}?>><?php echo $rown["bigclassname"]?></option>
                <?php
		  }
		  ?>
              </select>
		<?php
		}
		?> 
       </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">展会名称：</td>
      <td class="border"> <input name="title" type="text" id="title22" value="<?php echo $row["title"]?>" size="50" maxlength="255"></td>
    </tr>
    <tr> 
      <td align="right" class="border">会议地址：</td>
      <td class="border"><input name="address" type="text" id="address2" value="<?php echo $row["address"]?>" size="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border">会议时间：</td>
      <td class="border"> <input name="timestart" type="text" id="timestart" value="<?php echo $row["timestart"]?>" onFocus="JTC.setday(this)">
        至 
        <input name="timeend" type="text" id="timeend" value="<?php echo $row["timeend"]?>" onFocus="JTC.setday(this)"> 
      </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border">展会内容：</td>
      <td class="border"><textarea name="content" id="content" ><?php echo $row["content"]?></textarea> 
       	<script type="text/javascript">CKEDITOR.replace('content');	</script>
        <input name="id" type="hidden" id="id" value="<?php echo $row["id"]?>">
        <input name="page" type="hidden" id="page3" value="<?php echo $_REQUEST["page"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed" type="checkbox" id="passed" value="1" <?php if ($row["passed"]==1){ echo "checked";}?>>
        （选中为通过审核）</td>
    </tr>
    <tr> 
      <td align="right" class="border">置顶值：</td>
      <td class="border"> <input name="elite" type="text" id="url" value="<?php echo $row["elite"]?>" maxlength="3">
        (0-255之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input name="Submit" type="submit" id="Submit" value="修 改" ></td>
    </tr>
  </table>
      </form>
	  
</body>
</html>