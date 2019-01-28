<!DOCTYPE html> 
<html> 
	<head> 
	<title>Welcome</title> 
<?php 
$mysql=true;
include('./includes/header.php'); 
?>
</head> 
<body> 

<?php top("Support", true); ?>
<i>Having problems? Select everything on this list which applies for you</i>
<label><input type="checkbox" name="invtied"/>I've been invited to test Lima by email</label>
<label><input type="checkbox" name="invtied"/>I've installed the lima plugin from cydia</label>
<label><input type="checkbox" name="invtied"/>I succesfully was able to authorize my device for use with lima.</label>
<label><input type="checkbox" name="invtied"/>I am not intending to use lima for piracy.</label>

</body>
</html>