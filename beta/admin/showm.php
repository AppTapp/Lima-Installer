<?php
function ReplaceImap($txt) {
  $carimap = array("=C3=A9", "=C3=A8", "=C3=AA", "=C3=AB", "=C3=A7", "=C3=A0", "=20", "=C3=80", "=C3=89");
  $carhtml = array("é", "è", "ê", "ë", "ç", "à", "&nbsp;", "À", "É");
  $txt = str_replace($carimap, $carhtml, $txt);

  return $txt;
}
$hostname = '{enter-your-mail-host-here.com:993/imap/ssl}';
$username = 'USERNAME';
$password = 'PASSWORD';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to mail: ' . imap_last_error());
$email_number=$_GET['n'];
if($_GET['done']=="true")
{
imap_setflag_full($inbox, $email_number, "\\Answered");
header('location: mail.php');
}
$header=imap_header($inbox,$email_number);

$message = imap_fetchbody($inbox, $email_number,1);
$message = imap_utf8($message);
$message = ReplaceImap($message);
$message =str_replace("=\r\n","\r\n",$message);
$from=$header->from;
$email=($from[0]->mailbox)."@".($from[0]->host);
$message=str_replace("= >","",$message);
$prettydate = date("jS F Y",$header->udate);
if(strtolower($_SERVER['PHP_AUTH_USER'])=="justin")
{
$signature = "Justin\nLima Installer Lead Developer";
} else {
$signature = "Alex\nLima Installer Team Representative";
}
$response = "\n--\n".$signature."\n\n"."on ".$prettydate." $email wrote: \n>".str_replace("\n","\n>",$message);
$message = nl2br($message);

$subject=$header->subject;
include('../includes/header.php'); ?>
<title>Lima support</title> 
<script>
function explain()
{
document.getElementById("message").innerHTML="Y U NOOOO be patient" + document.getElementById("message").innerHTML;
}
function register()
{
document.getElementById("message").innerHTML="If you have not already, signup at www.limainstaller.com/register.php in orde to get in line to test Lima.\n" + document.getElementById("message").innerHTML;
}

</script>
</head> 
<body>
    <?php
    top($subject);
    ?>
    <h2><?php echo $email; ?></h2>
    <i><?php echo $message; ?></i>
<h5>write a response:</h5>
<form name="mail" method="POST" action="sendmail.php">
<input type="hidden" name="email" value='<?php echo $email; ?>' />
<input type="hidden" name="subject" value='<?php echo $subject; ?>'/>
<input type="hidden" name="enumber" value='<?php echo $email_number; ?>'/>
<textarea id="message" name="message">
<?php
echo $response;

?></textarea></form>
    <?php
    listview(false,true);
section("Send!","javascript:document.forms['mail'].submit()");
section("explain y no invite","javascript:explain()"); 
section("send register link","javascript:register()");    
section("set answered","showm.php?done=true&n=$email_number");
    echo "</ul>";
    foot(true); 
    ?>
    
</body>
