<?php
if(!isset($_SESSION)){session_start();} 
unset($_SESSION['admin']);
unset($_SESSION['pass']);
session_write_close();
echo "<script>location.href='../index.php'</script>";
?>