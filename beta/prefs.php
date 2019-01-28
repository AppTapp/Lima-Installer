<?php 
session_start();
$rand = rand(999999, 999999999);
$magichash = sha1(md5($rand));
//store le MagicHash to session so le installerz can getz itz
$_SESSION['MagicHash'] = $magichash;
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>Welcome</title> 
<?php 
include('./includes/header.php'); 
?>
</head> 
<body> 

<?php top("Preferences", false); ?>
	<h1>Preferences</h1>
	<i>Make it your own...</i>
	
	<?php listview(false, true); 
section("Sections","prefs_sections.php", true);
section("Software sources", "prefs_sources.php");
section("OTA installations","prefs_ota.php", true);
echo "</ul>";
foot();
?>
</body>
</html>

		