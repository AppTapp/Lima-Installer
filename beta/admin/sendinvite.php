<?php
$mysql=true;
include('../includes/header.php');
if($_GET['s']=="true")
{
$email=$_GET['e'];
$query="SELECT * FROM  `signups` WHERE  `email` = \"$email\"";
$result=mysql_query($query) or die("db error");
$name =  mysql_result($result,0,"name");
$ip = mysql_result($result,0,"ip");
$icode=rand(9999999,99999999);
mysql_query("UPDATE `signups` SET `icode`='$icode' WHERE `email`='$email'");
mysql_query("INSERT INTO  `lima_main`.`beta_users` (`icode` ,`udid`,`ip`) VALUES ('$icode',  'NONE',  'NONE')") or die("error ".mysql_error());
$subject = "Lima Installer beta";
$message = "Hello there $name, \nA while ago you signed up to beta test Lima, we now have a spot available for you to test Lima. This email contains instructions on how to set it up. Please note that you can only install and activate Lima on one device during beta stages.\n\nIn order to use Lima you must have the Lima Service installed, please follow the following instructions in order to setup your device for Lima:\n1. Open Cydia and tap on the Sources tab.\n\n2. Add the source http://limainstaller.com/getbeta/$icode\n\n3. Once added, install the Lima Service from the source.\n\n4. After installed open safari and go to the URL: https://limainstaller.com//beta/setupbeta.php?icode=$icode\n\n5. Tap \"Authorize Device\"\n\n6. Your device is now setup for Lima, Enjoy :D .\n\nVisit: http://beta.limainstaller.com to begin using Lima\n\n\nNote:\n\nAs Lima is still in beta, it is recommended that you take care when using the service and understand there may be bugs. If you find any bugs, please report them to support@limainstaller.com\n\nHappy installing!\nThe Lima Team\n";

$from = "Lima Installer <services@limainstaller.com>";
$headers = "From:" . $from;
mail($email,$subject,$message,$headers);
echo "Mail Sent to $email";
}
    
$sql = "SELECT * FROM signups";
$result = mysql_query($sql) or die(mysql_error());

if (!$result) {
    echo "DB Error, could not list sections\n";
    exit;
}
echo "<table>";
$emails=array();
$ppl=0;
$bloggers=0;
while ($row = mysql_fetch_row($result)) {
    $name=$row[0];
    $who=$row[2];
    $email=$row[3];
    $ip=$row[6];
    $icode=$row[8];
    if(!in_array($email,$emails) && ($icode=="NONE" || $icode=="not"))
    {
    echo "<tr><td>$name</td><td>$who</td><td>$email</td><td>$ip</td><td><a rel=\"external\" href=\"sendinvite.php?s=true&e=$email\">Invite!</a></td></tr>";
    $ppl++;
if($ppl==250)
{
echo "<tr><td>1st batch</td><td>======</td><td>==========</td><td>======</td><td>======</td></tr>";
}
if($ppl==750)
{
echo "<tr><td>2nd batch</td><td>======</td><td>==========</td><td>======</td><td>======</td></tr>";
}
    if(strstr(strtolower($who),"blog"))
    {
    $bloggers++;
    }
$emails[]=$email;
    }
}
echo "</table>";
echo "</br>invites to send: $ppl, $bloggers bloggers";

?>