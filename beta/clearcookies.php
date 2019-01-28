<?php
if($_GET['MagicHash']==$_SESSION['MagicHash']) {
$_SESSION['MagicHash']="";
$_COOKIE["uniqueid"]="";
setcookie("uniqueid", "", time()-(60*60*24*365));
session_start();
session_destroy();
echo "everything cleared, redo setup to use Lima again.";
}
?>