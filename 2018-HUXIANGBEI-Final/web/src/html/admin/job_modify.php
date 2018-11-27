<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("job");
?>
<script language="javascript" src="/js/timer.js"></script>
</head>
<body>
<script language = "JavaScript">
function CheckForm(){
if (document.myform.bigclassid.value==""){
    alert("请选择类别！");
	document.myform.bigclassid.focus();
	return false;
}
if (document.myform.jobname.value==""){
    alert("名称不能为空！");
	document.myform.jobname.focus();
	return false;
}
}
</script>   
<div class="admintitle">修改招聘信息</div>
<form action="job_save.php" method="post" name="myform" id="myform" onSubmit="return CheckForm();">
<?php
$id=$_REQUEST["id"];
if ($id<>"") {
checkid($id);
}else{
$id=0;
}
$sqlzs="select * from zzcms_job where id='$id'";
$rszs=query($sqlzs);
$rowzs=fetch_array($rszs);
?>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr> 
      <td width="18%" align="right" class="border"> 类别 <font color="#FF0000">*</font></td>
      <td width="82%" class="border"> 
        <?php
$sql = "select * from zzcms_jobclass where parentid<>'0' order by xuhao asc";
$rs=query($sql);
?>
        <script language = "JavaScript" type="text/JavaScript">
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

function changelocation(locationid)
    {
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
    }</script> <select name="bigclassid" onChange="changelocation(document.myform.bigclassid.options[document.myform.bigclassid.selectedIndex].value)" size="1">
          <option value="" selected="selected">请选择大类别</option>
          <?php
	$sql = "select * from zzcms_jobclass where  parentid='0' order by xuhao asc";
    $rs=query($sql);
	while($row = fetch_array($rs)){
	?>
          <option value="<?php echo trim($row["classid"])?>" <?php if ($row["classid"]==$rowzs["bigclassid"]) { echo "selected";}?>><?php echo trim($row["classname"])?></option>
          <?php
				}
				?>
        </select> <select name="smallclassid">
          <option value="0">不指定小类</option>
          <?php
$sql="select * from zzcms_jobclass where parentid='" .$rowzs["bigclassid"]."' order by xuhao asc";
$rs=query($sql);
while($row = fetch_array($rs)){
?>
          <option value="<?php echo $row["classid"]?>" <?php if ($row["classid"]==$rowzs["smallclassid"]) { echo "selected";}?>><?php echo $row["classname"]?></option>
          <?php 
}
?>
        </select> </td>
    </tr>
    <tr>
      <td align="right" class="border">职位<font color="#FF0000">*</font></td>
      <td class="border"><input name="jobname" type="text" id="cpname" value="<?php echo $rowzs["jobname"]?>" size="45"></td>
    </tr>
	 
    <tr> 
      <td align="right" class="border">说明：</td>
      <td class="border"> <textarea name="sm" cols="60" rows="3" id="sm"><?php echo $rowzs["sm"]?></textarea></td>
    </tr>
    <tr> 
      <td align="right" class="border">发布人：</td>
      <td class="border"><input name="editor" type="text" id="editor" value="<?php echo $rowzs["editor"]?>" size="45"> 
        <input name="oldeditor" type="hidden" id="oldeditor" value="<?php echo $rowzs["editor"]?>"></td>
    </tr>
    <tr> 
      <td align="right" class="border">审核：</td>
      <td class="border"><input name="passed[]" type="checkbox" id="passed[]" value="1"  <?php if ($rowzs["passed"]==1) { echo "checked";}?>>
        （选中为通过审核） </td>
    </tr>
    
    <tr> 
      <td align="center" class="border">&nbsp;</td>
      <td class="border"><input name="cpid" type="hidden" id="cpid" value="<?php echo $rowzs["id"]?>"> 
        <input name="sendtime" type="hidden" id="sendtime" value="<?php echo $rowzs["sendtime"]?>"> 
        <input name="page" type="hidden" id="page" value="<?php echo $_GET["page"]?>"> 
        <input type="submit" name="Submit" value="修 改"></td>
    </tr>
  </table>
</form>

</body>
</html>