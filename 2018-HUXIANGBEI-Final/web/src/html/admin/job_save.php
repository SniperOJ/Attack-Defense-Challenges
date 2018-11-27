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
$cpid=trim($_POST["cpid"]);
$bigclassid=trim($_POST["bigclassid"]);
$smallclassid = isset($_POST['smallclassid'])?$_POST['smallclassid']:'0';
$smallclassname="未指定小类";
if (isset($bigclassid)){
$rs = query("select * from zzcms_jobclass where classid='$bigclassid'"); 
$row= fetch_array($rs);
$bigclassname=$row["classname"];
}

if ($smallclassid !=0){
$rs = query("select * from zzcms_jobclass where classid='$smallclassid'"); 
$row= fetch_array($rs);
$smallclassname=$row["classname"];
}

$jobname=trim($_POST["jobname"]);
$sm=trim($_POST["sm"]);
$sendtime=$_POST["sendtime"];
$editor=trim($_POST["editor"]);
$oldeditor=trim($_POST["oldeditor"]);

if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}

query("update zzcms_job set bigclassid='$bigclassid',bigclassname='$bigclassname',smallclassid='$smallclassid',smallclassname='$smallclassname',jobname='$jobname',sm='$sm',sendtime='$sendtime' where id='$cpid'");
if ($editor<>$oldeditor) {
$rs=query("select comane,id from zzcms_user where username='".$editor."'");
$row = num_rows($rs);
if ($row){
$row = fetch_array($rs);
$userid=$row["id"];
$comane=$row["comane"];
}else{
$userid=0;
$comane="";
}
query("update zzcms_job set editor='$editor',userid='$userid',comane='$comane' where id='$cpid'");
}
query("update zzcms_job set passed='$passed' where id='$cpid'");
echo "<script>location.href='job_manage.php?keyword=".$_POST["editor"]."&page=".$_REQUEST["page"]."'</script>";
?>
</body>
</html>