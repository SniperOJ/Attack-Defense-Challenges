<?php
include ("admin.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
checkadminisdo("baojia");
if (isset($_POST["page"])){
$page=$_POST["page"];
}else{
$page=1;
}
if (isset($_POST["dlid"])){
$id=$_POST["dlid"];
}else{
$id=0;
}
$classid=$_POST["classid"];
$cp=$_POST["cp"];
$province=$_POST["province"];
$city=$_POST["city"];
$xiancheng=$_POST["xiancheng"];
$price=$_POST["price"];
$danwei=$_POST["danwei"];
$companyname=$_POST["companyname"];
$truename=$_POST["truename"];
$tel=$_POST["tel"];
$email=$_POST["email"];
$address=$_POST["address"];
if(!empty($_POST['passed'])){
$passed=$_POST['passed'][0];
}else{
$passed=0;
}
if ($_POST["action"]=="add"){
	if ($cp<>'' && $truename<>'' && $tel<>''){
	$addok=query("Insert into zzcms_baojia(classzm,cp,province,city,xiancheng,price,danwei,companyname,truename,tel,address,email,sendtime) 		values('$classid','$cp','$province','$city','$xiancheng','$price','$danwei','$companyname','$truename','$tel','$address','$email','".date('Y-m-d H:i:s')."')") ; 
	}
}elseif ($_POST["action"]=="modify"){

$oldprovince=trim($_POST["oldprovince"]);
if ($province=='请选择省份'){
$province=$oldprovince;
}
$addok=query("update zzcms_baojia set classzm='$classid',cp='$cp',province='$province',city='$city',xiancheng='$xiancheng',price='$price',danwei='$danwei',companyname='$companyname',truename='$truename',tel='$tel',address='$address',email='$email',sendtime='".date('Y-m-d H:i:s')."',passed='$passed' where id='$id'");
}
if ($addok){
echo "<script>location.href='baojia_manage.php?page=".$_REQUEST["page"]."'</script>";
}		
?>
</body>
</html>