<!DOCTYPE html> 
<html> 
	<head> 
	<title>More</title> 
<?php 
include('./includes/header.php'); 
?>
</head> 
<body> 

<?php top("More", false); ?>
	<h1>More</h1>
	<i>There never is enough...</i>
	
	<?php listview(false, true); 
section("Installed Packages","installedpackages.php", true);
section("New packages", "newpackages.php");
section("Package updates","updates.php", true);
section("Lima status blog","http://cookie.limainstaller.com");
echo "</ul>";
foot();
?>
</body>
</html>

		