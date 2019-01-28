<?php
$hostname = '{your-mail-host-here.com:993/imap/ssl}';
$username = 'USERNAME';
$password = 'PASSWORD';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to mail: ' . imap_last_error());
$email_number=$_POST['enumber'];
$email=$_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];
$from = "Lima Support <support@limainstaller.com>";
$headers = "From:" . $from;
if($_POST['message'])
{
mail($email,$subject,$message,$headers) or die("send fail");
imap_setflag_full($inbox, $email_number, "\\Answered");
header('location: mail.php');
echo "Mail Sent to $email";
//mark answered

}
?>
