<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="/js/timer.js"></script>
<script language = "JavaScript" src="/js/gg.js"></script>
<script type="text/javascript" src="/js/jquery.js"></script>  
<script type="text/javascript" language="javascript">
$.ajaxSetup ({
cache: false //close AJAX cache
});

$(document).ready(function(){  
  $("#name").change(function() { //jquery 中change()函数  
	$("#span_szm").load(encodeURI("../ajax/zsadd_ajax.php?id="+$("#name").val()));//jqueryajax中load()函数 加encodeURI，否则IE下无法识别中文参数 
  });  
});  

function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择产品类别！");
	document.myform.bigclassid.focus();
	return false;
  }
  if (document.myform.cpname.value==""){
    alert("产品名称不能为空！");
	document.myform.cpname.focus();
	return false;
  }
  if (document.myform.prouse.value==""){
    alert("产品特点不能为空！");
	document.myform.prouse.focus();
	return false;
  }
}
function doClick_E(o){
	 var id;
	 var e;
	 for(var i=1;i<=document.myform.bigclassid.length;i++){
	   id ="E"+i;
	   e = document.getElementById("E_con"+i);
	   if(id != o.id){
	   	 e.style.display = "none";		
	   }else{
		e.style.display = "block";
	   }
	 }
	   if(id==0){
		document.getElementById("E_con1").style.display = "block";
	   }
	 }
</script>  
</head>
<body>
<div class="admintitle">修改<?php echo channelzs?>信息</div>
<?php
checkadminisdo("zs");
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sql="select * from zzcms_main where id='$id'";
$rs=query($sql);
$row=fetch_array($rs);
?>
<form action="zs_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td align="right" class="border">产品名称 <font color="#FF0000">*</font></td>
      <td width="82%" class="border"> <input name="cpname" type="text" id="cpname" value="<?php echo $row["proname"]?>" size="45" maxlength="50">
	  <span id="span_szm">  <input name="szm" type="hidden" value="<?php echo $row["szm"]?>"  />
        </span>      </td>
    </tr>
    <tr> 
      <td width="18%" align="right" class="border"> 所属类别 <font color="#FF0000">*</font></td>
      <td class="border"> 
        
		<table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr> 
                  <td> <fieldset>
                    <legend>请选择所属大类</legend>
                    <?php
        $sqlB = "select * from zzcms_zsclass where parentid='A' order by xuhao asc";
		$rsB = query($sqlB,$conn); 
		$n=0;
		while($rowB= fetch_array($rsB)){
		$n ++;
		if ($row['bigclasszm']==$rowB['classzm']){
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' checked/><label for='E$n'>".$rowB['classname']."</label>";
		}else{
		echo "<input name='bigclassid' type='radio' id='E$n'  onclick='javascript:doClick_E(this);uncheckall()' value='".$rowB['classzm']."' /><label for='E$n'>".$rowB['classname']."</label>";
		}
		}
			?>
                    </fieldset></td>
                </tr>
                <tr> 
                  <td> 
                    <?php
$sqlB="select * from zzcms_zsclass where parentid='A' order by xuhao asc";
$rsB = query($sqlB,$conn); 
$n=0;
while($rowB= fetch_array($rsB)){
$n ++;
if ($row["bigclasszm"]==$rowB["classzm"]) {  
echo "<div id='E_con$n' style='display:block;'>";
}else{
echo "<div id='E_con$n' style='display:none;'>";
}
echo "<fieldset><legend>请选择所属小类</legend>";
$sqlS="select * from zzcms_zsclass where parentid='".$rowB['classzm']."' order by xuhao asc";
$rsS = query($sqlS,$conn); 
$nn=0;
while($rowS= fetch_array($rsS)){
if (zsclass_isradio=='Yes'){
	if ($row['smallclasszm']==$rowS['classzm']){
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS['classzm']."' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='radio' value='".$rowS['classzm']."' />";
	}
}else{
	if (strpos($row['smallclasszm'],$rowS['classzm'])!==false && $row['bigclasszm']==$rowB['classzm']){
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' checked/>";
	}else{
	echo "<input name='smallclassid[]' id='radio$nn$n' type='checkbox' value='".$rowS['classzm']."' />";
	}
}
echo "<label for='radio$nn$n'>".$rowS['classname']."</label>";
$nn ++;
if ($nn % 6==0) {echo "<br/>";}            
}
echo "</fieldset>";
echo "</div>";
}
?>                  </td>
                </tr>
              </table>		 </td>
    </tr>
	   <?php 
		  $rsn = query("select * from zzcms_zsclass_shuxing order by xuhao asc"); 
		$rown= num_rows($rsn);
		if ($rown){
		  ?>
          <tr>
            <td align="right" class="border" >属性</td>
            <td class="border" >
			<?php
        $n=0;
		while($rown= fetch_array($rsn)){
		$n ++;
		if ($row['shuxing']==$rown['bigclassid']){
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."' checked/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}else{
		echo "<input name='shuxing' type='radio' id='shuxing$n' value='".$rown['bigclassid']."'/><label for='shuxing$n'>".$rown['bigclassname']."</label>";
		}
		
	}
			?></td>
          </tr>
		    <?php 
		 }
		  ?>
    <tr> 
      <td align="right" class="border">产品特点<font color="#FF0000"> *</font></td>
      <td class="border"> <textarea name="prouse" cols="60" rows="3" id="prouse"><?php echo $row["prouse"]?></textarea>      </td>
    </tr>
    <?php
	if (shuxing_name!=''){
	$shuxing_name = explode("|",shuxing_name);
	$shuxing_value = explode("|||",$row["shuxing_value"]);
	for ($i=0; $i< count($shuxing_name);$i++){
	?>
	<tr>
      <td align="right" class="border" ><?php echo $shuxing_name[$i]?>：</td>
      <td class="border" ><input name="sx[]" type="text" value="<?php echo @$shuxing_value[$i]?>" size="45"></td>
    </tr>
	<?php
	}
	}
	?>
    <tr> 
      <td align="right" class="border">产品说明：</td>
      <td class="border"> 
	  <textarea name="sm" id="sm"><?php echo $row["sm"] ?></textarea> 
             <script type="text/javascript" src="/3/ckeditor/ckeditor.js"></script>
			  <script type="text/javascript">CKEDITOR.replace('sm');</script>	  </td>
    </tr>
    <tr> 
      <td align="right" class="border">图片地址： <input name="img" type="hidden" id="img" value="<?php echo $row["img"]?>" size="45"> </td>
      <td class="border"> <table height="140"  width="140" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
          <tr> 
            <td align="center" bgcolor="#FFFFFF" id="showimg" onClick="openwindow('/uploadimg_form.php',400,300)"> 
              <?php
				  if($row["img"]<>""){
				  echo "<img src='".$row["img"]."' border=0 width=120 /><br>点击可更换图片";
				  }else{
				  echo "<input name='Submit2' type='button'  value='上传图片'/>";
				  }
				  ?>            </td>
            
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td align="right" class="border">视频地址：</td>
      <td class="border"> <input name="flv" type="text" id="flv" value="<?php echo $row["flv"]?>" size="60"></td>
    </tr>
    <tr> 
      <td align="right" class="border">可提供的支持：</td>
      <td class="border"> <textarea name="zc" cols="60" rows="3" id="zc"><?php echo $row["zc"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">对<?php echo channeldl?>商的要求：</td>
      <td class="border"> <textarea name="yq" cols="60" rows="3" id="yq"><?php echo $row["yq"]?></textarea>      </td>
    </tr>
    <tr> 
      <td align="right" class="border">发布人：</td>
      <td class="border"><input name="editor" type="text" id="editor" value="<?php echo $row["editor"]?>" size="45"> 
        <input name="oldeditor" type="hidden" id="oldeditor" value="<?php echo $row["editor"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($row["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    <tr>
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit22" value="修 改"></td>
    </tr>
	 <tr> 
      <td colspan="2" class="userbar">SEO设置</td>
    </tr>
	
    <tr>
      <td align="right" class="border" >标题（title）</td>
      <td class="border" ><input name="title" type="text" id="title" value="<?php echo $row["title"] ?>" size="60" maxlength="255"></td>
    </tr>
    <tr>
      <td align="right" class="border" >关键词（keywords）</td>
      <td class="border" ><input name="keyword" type="text" id="keyword" value="<?php echo $row["keywords"] ?>" size="60" maxlength="255">
        (多个关键词以“,”隔开)</td>
    </tr>
    <tr>
      <td align="right" class="border" >描述（description）</td>
      <td class="border" ><input name="discription" type="text" id="discription" value="<?php echo $row["description"] ?>" size="60" maxlength="255">
        (适当出现关键词，最好是完整的句子)</td>
    </tr>
    <tr> 
      <td align="right" class="border">&nbsp;</td>
      <td class="border"><input type="submit" name="Submit2" value="修 改"></td>
    </tr>
    <tr> 
      <td colspan="2" class="userbar">排名（推荐）设置</td>
    </tr>
    <tr> 
      <td align="right" class="border">设为关键字排名产品</td>
      <td class="border"><input name="elite[]" type="checkbox" id="elite[]" value="1" <?php if ($row["elite"]==1) { echo "checked";}?>>
      （选中后生效）
        时间： 
        <input name="elitestarttime" type="text" value="<?php echo $row["elitestarttime"]?>" size="20" onFocus="JTC.setday(this)">
        至 
        <input name="eliteendtime" type="text" value="<?php echo $row["eliteendtime"]?>" size="20" onFocus="JTC.setday(this)">      </td>
    </tr>
    <tr> 
      <td align="right" class="border">搜索热门词：</td>
      <td class="border"><input name="tag" type="text" id="tag" value="<?php echo $row["tag"]?>" size="45">
        (多个词可用,隔开) </td>
    </tr>
    <tr> 
      <td align="center" class="border">&nbsp;</td>
      <td class="border"><input name="cpid" type="hidden" id="cpid" value="<?php echo $row["id"]?>"> 
        <input name="sendtime" type="hidden" id="sendtime" value="<?php echo $row["sendtime"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>"> 
        <input type="submit" name="Submit" value="修 改"></td>
    </tr>
  </table>
</form>

</body>
</html>