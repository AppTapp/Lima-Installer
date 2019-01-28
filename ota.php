<?php
$mysql=true;
include('./beta/config/dbinfo.php');
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("database error"); 
mysql_select_db("lima_main");
include('./beta/include/security.php');
if($_GET['a']=="set") {
$otaticket=$rand = rand(99999, 999999);
echo $otaticket;

}
?>