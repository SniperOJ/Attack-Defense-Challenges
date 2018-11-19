<?php
require_once("../duomiphp/common.php");
$name=$_REQUEST['name'];
$url=$_REQUEST['url'];
$name = Filtersearch(stripslashes($name));
$Shortcut = "[InternetShortcut]

URL={$url}

";
header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=".str_replace(" ","",$name).".url;"); 
echo $Shortcut;
?>