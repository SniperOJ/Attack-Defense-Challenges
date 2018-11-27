<?php
include ("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value=="")
  {
    alert("请选择展会类型！");
	document.myform.bigclassid.focus();
	return false;
  }	 	  
if (document.myform.title.value==""){
    alert("展会名称不能为空！");
	document.myform.title.focus();
	return false;
  }
  if (document.myform.address.value==""){
    alert("展会地址不能为空！");
	document.myform.address.focus();
	return false;
  }
  if (document.myform.TimeStart.value==""){
    alert("展会开始时间不能为空！");
	document.myform.TimeStart.focus();
	return false;
  }
  if (document.myform.TimeEnd.value==""){
    alert("展会截止时间不能为空！");
	document.myform.TimeEnd.focus();
	return false;
  } 
}    
</script>
</head>
<body>
<?php
checkadminisdo("zh");
if (isset($_SESSION["zhclassid"])){
$szhclassid=$_SESSION["zhclassid"];
}else{
$szhclassid="";
}
?>
<div class="admintitle">发布展会信息</div>
<form action="zh_save.php?action=add" method="post" name="myform" target="_self" id="myform" onSubmit="return CheckForm();">        
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">所属类别：</td>
      <td class="border">   
        <?php
		$sql = "select * from zzcms_zhclass order by xuhao asc";
	    $rs=query($sql);
        $row=num_rows($rs);
		if (!$row){
			echo "请先添加栏目。";
		}else{
		?>
		<select name="bigclassid" id="bigclassid">
                <option value="" selected="selected">请选择类别</option>
                <?php
		while($row= fetch_array($rs)){
			?>
                <option value="<?php echo $row["bigclassid"]?>" <?php if ($row["bigclassid"]==$szhclassid) { echo "selected";}?>><?php echo $row["bigclassname"]?></option>
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
      <td width="100" align="right" class="border" >展会名称：</td>
      <td class="border" > <input name="title" type="text" id="title" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >会议地址：</td>
      <td class="border" > <input name="address" type="text" id="address" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td align="right" class="border" >会议时间：</td>
      <td class="border" > <input name="timestart" type="text" id="timestart" value="<?php echo date('Y-m-d H:i:s')?>" onFocus="JTC.setday(this)">
        至 
        <input name="timeend" type="text" id="timeend" value="<?php echo date('Y-m-d H:i:s')?>" onFocus="JTC.setday(this)"> 
      </td>
    </tr>
    <tr> 
      <td width="100" align="right" class="border" >展会内容：</td>
      <td class="border" > <textarea  name="content" id="content"></textarea>
	  	<script type="text/javascript">CKEDITOR.replace('content');	</script>
      </td>
    </tr>
    <tr> 
      <td align="right" class="border" >置顶值：</td>
      <td class="border" ><input name="elite" type="text" id="elite" value="0" size="10" maxlength="3">
        (0-255之间的数字，数值大的排在前面) </td>
    </tr>
    <tr> 
      <td align="right" class="border" >&nbsp;</td>
      <td class="border" ><input type="submit" name="Submit" value="发 布" ></td>
    </tr>
  </table>
      </form>
	  
</body>
</html>