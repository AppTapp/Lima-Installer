<?php
setcookie ("uniqueid", "", 1);
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>Setup</title> 
<?php 
include('./includes/header.php'); 
?>

</head> 
<body> 
    <?php top("Setup"); ?>
	<h2>Setup</h2>
	<i>To use Lima you need to have the latest version of the Lima service installed on your device. If you have previously installed the Lima service on your device you need to update the Lima service in Cydia, otherwise install the Lima service using the instructions in your Beta invitation email. In the future you'll be able to update Lima directly from here, but the version of Lima which you are running doesn't support self updating.</i>
            <?php
listview(false,true);
section("Go to Cydia","cydia://com.lima.service");
echo "</ul>";
foot(true);
?> 
</body>
</html>