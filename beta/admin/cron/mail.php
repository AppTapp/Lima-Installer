<?php
require("/home/lima/public_html/beta/config/dbinfo.php");
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("Database connection error"); 
mysql_select_db("lima_main");
$res = mysql_query("SELECT * FROM `mail_queue` WHERE `statuscode`=0 LIMIT 0,10");
for($i=0;$i<10;$i++)
{
$email=mysql_result($res,$i,"to");
$subject=mysql_result($res,$i,"subject");
$message=mysql_result($res,$i,"message");
$id=mysql_result($res,$i,"id");
$from = "Lima Installer <services@limainstaller.com>";
$headers = "From:" . $from;
if($email && $subject && $message && $headers)
{
//echo $email."-".$message."-".$subject."</br>";
if(mail($email,$subject,$message,$headers)) {
mysql_query("UPDATE `mail_queue` SET `statuscode`=1 WHERE `id`=$id");
} else {
mysql_query("UPDATE `mail_queue` SET `statuscode`=2 WHERE `id`=$id");  
}
sleep(5);
}
}

?>
