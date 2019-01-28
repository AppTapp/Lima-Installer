<!DOCTYPE html> 
<html> 
<head> 
<?php 
include('../includes/header.php'); ?>
<title>Lima support</title> 
</head>    
<?php
top("Unanswered mails");
listview(true,false);
$hostname = '{your-mail-host-here.com:993/imap/ssl}';
$username = 'USERNAME';
$password = 'PASSOWRD';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to mail: ' . imap_last_error());


/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {
  
  /* begin output var */
  $output = '';
  
  /* put the newest emails on top */
  rsort($emails);
  
  /* for every email... */
  foreach($emails as $email_number) {
   $header=imap_header($inbox,$email_number);
if(($header->Answered) != "A" && ($header->Flagged) != "F")
{
$message = imap_fetchbody($inbox, $email_number, 1);
$message = imap_utf8($message);
$subject=$header->subject;
$link="showm.php?n=$email_number";
package($subject,$link,$message);
}
  }
  
} 
echo "</ul>";
foot(true)
/* close the connection */
?></body></html>
