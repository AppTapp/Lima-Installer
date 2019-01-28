<?php
die();
$mysql=true;
include('../includes/header.php');
$res=mysql_query("SELECT * FROM  `mail_queue` WHERE statuscode='1'");
for($i=0;$i<mysql_numrows($res);$i++)
{
    
  $message = mysql_result($res,$i,"message");
  $mes = explode("ller.com/getbeta/",$message);
  $mes = explode("\n",$mes[1]);
  $icode=$mes[0];
 $email = mysql_result($res,$i,"to");
 mysql_query("UPDATE `signups` SET `icode`='$icode' WHERE `email`='$email'");
}
?>
