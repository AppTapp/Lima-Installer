<?php
session_start();
if($_SESSION['theme']=="simple")
{ 
include('./templates/simple.php');
include('../templates/simple.php');
} elseif($_SESSION['theme']=="desktop")
{ 
include('./templates/desktop.php');
include('../templates/desktop.php');
} else {
include('./templates/mobile.php');
include('../templates/mobile.php');
}
?>
