<?php
error_reporting(E_ERROR);
ob_start();
header("HTTP/1.1 301 Moved Permanently");

$url = 'forum.php?';

if(is_numeric($_GET['aid'])) {
	$url .= 'mod=attachment&aid='.$_GET['aid'];
}

header("location: $url");

?>