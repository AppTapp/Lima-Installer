<?php
session_start();
$_SESSION['theme']=$_GET['set'];
$_SESSION['o']=$_GET['o'];
header('location: index.php');
?>
