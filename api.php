<?php
die("alert('Lima api is currently undergoing maintenance, try an install later.');");

include("./beta/config/dbinfo.php");
mysql_connect($db_host, $db_user, $db_pass) or die("database error"); 
$ip=$_SERVER['REMOTE_ADDR']; 
$uniqueid=mysql_real_escape_string($_GET['uniqueid']);
$packageList=mysql_real_escape_string($_GET['packageList']);
$action=mysql_real_escape_string($_GET['action']);
$Token=mysql_real_escape_string($_GET['securetoken']);
$secretToken= mysql_real_escape_string($_GET['secrettoken']);

mysql_select_db("lima_main");
$query="SELECT * FROM  `api` WHERE  `Token` = \"$Token\" AND `ip` = \"$ip\" AND `SecretToken` = \"$secretToken\"";
$result=mysql_query($query) or die("db error");
$name = mysql_result($result,0,"Name");
if($name) {
//valid access
$ticketid = rand(100000, 999999);
$expires = (date("m") * 31 * 24 * 60) + (date("d") * 24 * 60) + (date("H") * 60) + (date("i") * 1); 
//mysql_query("INSERT INTO  `lima_main`.`opentickets` (`ticketid` ,`udid` ,`packageList` ,`action` ,`securityToken` ,`expires`) VALUES ('$ticketid',  '$uniqueid',  '$packageList',  '$action',  '$Token',  '$expires');") or die(mysql_error());

//echo "install($Token, $ticketid);";
echo "alert('Lima api is currently undergoing maintenance, try an install later.');";
} else {
//script kiddies
echo "alert('api error: access denied');";
}




?>