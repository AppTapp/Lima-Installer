<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<?php
session_start();
$internal=false;
if($mysql) 
{
    //connect to sql database
 include("./config/dbinfo.php");
 include("../config/dbinfo.php");
 mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("Database connection error"); 
 mysql_select_db("lima_main");
}
require('security.php');
//include('./includes/security.php');
if(($_SESSION['o']!=true && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone")) && (!stristr($_SERVER['HTTP_USER_AGENT'], "iPad")) && (!stristr($_SERVER['HTTP_USER_AGENT'], "iPod")) && (stristr($_SERVER['REQUEST_URI'], "/admin")==false)) {
}
echo '<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />';
if($_SESSION['theme']=="simple")
{ 
include('./templates/simple.php');
include('../templates/simple.php');
echo "<link rel=\"stylesheet\" href=\"http://snippetspace.com/iwebkit/demo/css/style.css\" />";
} else if($_SESSION['theme']=="desktop")
{ 
include('./templates/desktop.php');
include('../templates/desktop.php');
echo "<link rel=\"stylesheet\" href=\"./css/desktop.css\" />";
echo "<script src=\"./js/bootstrap.js\"></script>";
} else {
include('./templates/mobile.php');
include('../templates/mobile.php');
?>
<link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
<script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
<?php

}
if(!$secure) {
die("lima could not display this page for security reasons");

} 
?>