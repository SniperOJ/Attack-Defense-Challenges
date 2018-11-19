<?php
error_reporting(E_ERROR);
ob_start();
header("HTTP/1.1 301 Moved Permanently");

$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$ptid = isset($_GET['ptid']) ? intval($_GET['ptid']) : 0;
$goto = isset($_GET['goto']) ? $_GET['goto'] : '';

$url = 'forum.php?mod=redirect&goto='."$goto&ptid=$ptid&pid=$pid";

header("location: $url");
?>