<?php
error_reporting(E_ERROR);
ob_start();
header("HTTP/1.1 301 Moved Permanently");

$url = 'forum.php?';

if(is_numeric($_GET['tid'])) {
	$url .= 'mod=viewthread&tid='.$_GET['tid'];
	if(is_numeric($_GET['page'])) {
		$url .= '&page='.$_GET['page'];
	}
}

header("location: $url");

?>