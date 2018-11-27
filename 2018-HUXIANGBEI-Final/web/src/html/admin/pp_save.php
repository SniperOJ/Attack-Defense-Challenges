<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
<?php
checkadminisdo("pp");
$cpid=trim($_POST["cpid"]);
$bigclass=trim($_POST["bigclassid"]);
$smallclass=trim($_POST["smallclassid"]);
if ($smallclass=="") {
$smallclass=0;
}
$cpname=trim($_POST["cpname"]);

$sm=trim($_POST["sm"]);
$img=trim($_POST["img"]);

$sendtime=$_POST["sendtime"];
$editor=trim($_POST["editor"]);
$oldeditor=trim($_POST["oldeditor"]);


if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}

query("update zzcms_pp set bigclasszm='$bigclass',smallclasszm='$smallclass',ppname='$cpname',sm='$sm',img='$img',sendtime='$sendtime' where id='$cpid'");
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
query("update zzcms_pp set editor='$editor',userid='$userid',comane='$comane' where id='$cpid'");
}
query("update zzcms_pp set passed='$passed' where id='$cpid'");
echo "<script>location.href='pp_manage.php?keyword=".$_POST["editor"]."&page=".$_REQUEST["page"]."'</script>";
?>
</body>
</html>