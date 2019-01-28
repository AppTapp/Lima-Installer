<?php
require("../../config/dbinfo.php");
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("Database connection error"); 
mysql_select_db("lima_main");
$sql = "SELECT DISTINCT `email`,`name` FROM signups WHERE `icode`='NONE'";
$result = mysql_query($sql) or die(mysql_error());

if (!$result) {
    echo "DB Error\n";
    exit;
}
for ($i = 0; $i < mysql_num_rows($result); $i++) {
    $name = trim(mysql_result($result, $i, "name"));
    $email = trim(mysql_result($result, $i, "email"));
    $subject = "Lima Installer beta";
    $message="Hello $name,\nThanks for expressing your interest in Lima Installer. We\\'re currently slowly starting up the beta testing of Lima. As we carefully have to monitor Lima and eliminate bugs on the way we can\\'t have all the thousands of people who\\'ve signed up test Lima at once. That\\'s why we chose to invite people in batches. Monday we sent out the first batch of invites and we\\'re awaiting test results. If everything goes well, we\\'ll send out the 2nd batch of invites by the end of the week. The invites are sent out on a first-come, first-served basis. This means that those who\\'ve signed up first will get their invites first. We would like to thank you for your patience and hope you\\'ll be able to give Lima Installer a try soon!\n\nThe Lima Installer team";
    mysql_query("INSERT INTO  `lima_main`.`mail_queue` (`to` ,`subject` ,`message` ,`id` ,`statuscode`) VALUES ('$email',  '$subject',  '$message', NULL ,  '0')") or die(mysql_error());
    mysql_query("UPDATE `signups` SET `icode`='not' WHERE `email`='$email'") or die(mysql_error());
}
echo mysql_num_rows($result);
?>