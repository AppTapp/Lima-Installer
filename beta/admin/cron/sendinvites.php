<table><?php
require("../../config/dbinfo.php");
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("Database connection error"); 
mysql_select_db("lima_main");


//echo "<hr>";
   //$name = trim(mysql_result($result, $i, "name"));
   // $email = trim(mysql_result($result, $i, "email"));

$result2=mysql_query("SELECT * FROM `signups` WHERE (
 `icode` =  'NONE'
OR  `icode` =  'not'
)
AND  `name` !=  'SUSPEND'");

for ($k = 0; $k < mysql_num_rows($result2); $k++) {
$icode=rand(9999999,99999999);
$codes = $codes +1;
$email = trim(mysql_result($result2, $k, "email"));
$name = trim(mysql_result($result2, $k, "name"));
echo "$name $email $icode</br>";
//echo "<tr><td>$ip</td><td>$email</td><td>$icode</td><td>    $name</td></tr>";


mysql_query("UPDATE `signups` SET `icode`='$icode' WHERE `email`='$email'");
mysql_query("INSERT INTO  `lima_main`.`beta_users` (`icode` ,`udid`,`ip`) VALUES ('$icode',  'NONE',  '$ip')");
$subject = "Lima Installer beta";
$message = "Hello there $name, \nA while ago you signed up to beta test Lima, we now have a spot available for you to test Lima. This email contains instructions on how to set it up. Please note that you can only install and activate Lima on one device during beta stages.\n\nIn order to use Lima you must have the Lima Service installed, please follow the following instructions in order to setup your device for Lima:\n1. Open Cydia and tap on the Sources tab.\n\n2. Add the source http://limainstaller.com/getbeta/$icode\n\n3. Once added, install the Lima Service from the source.\n\n4. After it\'s installed open safari and go to the URL: http://limainstaller.com/beta/setupbeta.php\n\n5. Tap \"Authorize Device\"\n\n6. Your device is now setup for Lima, Enjoy :D .\n\nVisit: http://limainstaller.com/beta to begin using Lima\n\n\nNote:\n\nAs Lima is still in beta, it is recommended that you take care when using the service and understand that there may be bugs. If you find any bugs, please report them to support@limainstaller.com\n\nHappy installing!\nThe Lima Team\n";

  
mysql_query("INSERT INTO  `lima_main`.`mail_queue` (`to` ,`subject` ,`message` ,`id` ,`statuscode`) VALUES ('$email',  '$subject',  '$message', NULL ,  '0')") or die(mysql_error());
   // mysql_query("UPDATE `signups` SET `icode`='$icode' WHERE `email`='$email'") or die(mysql_error());

}


?></table>
<?php echo $codes; ?>