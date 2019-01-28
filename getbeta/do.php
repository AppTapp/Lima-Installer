<?php
$mysql=true;
include('../beta/config/dbinfo.php');
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die(ise()); 
mysql_select_db("lima_main");
include('../beta/includes/security.php');
$req=str_replace("/getbeta/","",str_replace("/./","/", $_SERVER['REQUEST_URI']));
$ar=explode("/",$req);
$icode=escape($ar[0]);
$file=escape($ar[1]);
$udid=escape($_SERVER['HTTP_X_UNIQUE_ID']);
$userip = $_SERVER['REMOTE_ADDR'];
if(($file=="LimaService.deb" || $file=="Packages.bz2") && strlen($udid)==40 && strlen($icode)==8)
{
$query="SELECT * FROM  `beta_users` WHERE  `icode` = \"$icode\" ";
$result=mysql_query($query) or die(ise());
$storedudid = mysql_result($result,0,"udid");
if($udid != "" && $storedudid != "" && ($udid==$storedudid || $storedudid == "NONE"))
{
mysql_query("UPDATE  `lima_main`.`beta_users` SET  `udid` =  '$udid', `ip` =  '$userip' WHERE  `beta_users`.`icode` =  '$icode'") or die(ise());
//download file


header('Cache-control: private');
header('Content-Type: application/octet-stream');
//header('Content-Length: '.filesize($file));
header('Content-Disposition: filename='.$file);
$dl_file=$file;
if (file_exists($dl_file)) {
   

   flush();

   $file = fopen($dl_file, "r");

   while (!feof($file)) {

       print fread($file ,filesize($dl_file));

       flush();

       sleep(1);
   }

   fclose($file);
}

} else {
die(ad());
}
} else {
notfound();
echo "Add this repo in Cydia-";
}
function ise()
{
header('HTTP/1.1 500 Internal Server Error');
}
function ad()
{
header('HTTP/1.1 403 Access Denied');
}
function notfound() {
header("HTTP/1.1 404 Not Found");
}
?>