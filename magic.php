<?php
$mysql=true;
include('./beta/config/dbinfo.php');
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("database error"); 
mysql_select_db("lima_main");
include('./beta/include/security.php');

if($_GET['a']=="setup") {
$magichash = $_GET['magichash'];
$secureToken = $_GET['securetoken'];
$query="SELECT * FROM  `api` WHERE  `Token` = \"$secureToken\" ";
$result=mysql_query($query) or die("db error");
$name = mysql_result($result,0,"Name");
$secretToken = mysql_result($result,0,"secretToken");
$userip = $_SERVER['REMOTE_ADDR'];
$base=$userip.":".$secureToken.":".$secretToken;

$realmagichash = hash('sha256',$base);
if(($realmagichash == $magichash)) {
//beta stages, check if user is invited
$icode=$_GET['icode'];
$udid=substr($_GET['udid'], 0, 40);
$query="SELECT * FROM  `beta_users` WHERE  `icode` = \"$icode\" OR (`udid`=\"$udid\" AND `udid` != \"NONE\") ";
$result=mysql_query($query) or die("db error");
$storedudid = mysql_result($result,0,"udid");
if($udid != "" && $storedudid != "" && ($udid==$storedudid || $storedudid == "NONE"))
{
//echo "UPDATE  `lima_main`.`beta_users` SET  `udid` =  '$udid', `ip` =  '$userip' WHERE  `beta_users`.`icode` =  '$icode'";
mysql_query("UPDATE  `lima_main`.`beta_users` SET  `udid` =  '$udid', `ip` =  '$userip' WHERE  `beta_users`.`icode` =  '$icode'");
echo "[SECURE]:".$name;
} else {
echo "NO_BETA_FOR_YOU";
}
} else {
echo "WRONG_AUTH";
}
} else {
//http://limainstaller.com/magic.php?st=test&ti=hello
$secureToken = mysql_real_escape_string(trim($_GET['st']));
$ticketId = mysql_real_escape_string(trim($_GET['ti']));
$udid = strtoupper(mysql_real_escape_string(trim($_GET['u'])));
$result=mysql_query("SELECT `action`, `packageList` FROM `opentickets` WHERE udid = \"$udid\" and ticketid = \"$ticketId\" and securityToken = \"$secureToken\" ") or die(mysql_error());
$action = mysql_result($result,0,"action");
$packageList = mysql_result($result,0,"packageList");
//echo "install:hello,test";
echo $action."\$".$packageList;
}
?>