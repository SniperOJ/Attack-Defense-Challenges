<?php
@session_start();
$_SESSION['AdminLogin'] = 1;
header("Location: ../index.php?s=Admin-Login"); 
?>