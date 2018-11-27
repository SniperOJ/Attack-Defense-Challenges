<?php
include("admin.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="border px14">
<?php
checkadminisdo("siteconfig");
$dir="../html/".siteskin."/dl";
del_dirandfile($dir);	
?>
</div>
</body>
</html>