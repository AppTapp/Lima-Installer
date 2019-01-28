<?php
include("./config/dbinfo.php");
$hostname = '{enter-your-mail-host-here.com:993/imap/ssl}';
$username = 'USERNAME';
$password = 'PASSWORD';

/* try to connect */
$inbox = imap_open($hostname,$username,$password);


/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {
  
  /* for every email... */
  foreach($emails as $email_number) {
   $header=imap_header($inbox,$email_number);
$mails += 1;
if(($header->Answered) != "A" && ($header->Flagged) != "F")
{
$ua += 1;
}
}
}
$percanswered=round(100-($ua/$mails)*100);
$zomgpiestatus = "<font color=\"orange\">UNKNOWN</font>";
$fp = @fsockopen("23.29.127.179", 80, $errno, $errstr, 2);
if (!$fp) {
   $zomgpiestatus = "<font color=\"red\">OFFLINE</font>";
} else{ 
   $zomgpiestatus = "<font color=\"green\">ONLINE</font>";
}
$dbserverstatus = "<font color=\"orange\">UNKNOWN</font>";
$fpz=true;
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or ($fpz=false);
mysql_select_db("lima_main");
if (!$fpz) {
   $dbserverstatus = "<font color=\"red\">OFFLINE</font>";
   $LastReload="UNKNOWN";
} else{ 
   $dbserverstatus = "<font color=\"green\">ONLINE</font>";
   $result=mysql_query("SELECT `value` FROM `system` WHERE `property`='LastReload'");
   $LastReload=mysql_result($result,0);
}

?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>Status</title> 
<?php include('./includes/header.php'); ?>
</head> 
<body> 
<?php 
top("Network status");
listview(false,true);
info("Server 1","<font color=\"green\">ONLINE</font>");
info("Server 2",$zomgpiestatus);
info("Database Server",$dbserverstatus);
info("Server monitoring", "ENABLED");
info("Last data refresh",$LastReload);
info("Support emails processed",$percanswered."%");
echo "</ul>";
foot();
?>			

</body>
</html>

		
