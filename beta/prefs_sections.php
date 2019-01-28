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
$mysql=true;
include('./includes/header.php'); 
?>
</head> 
<body> 

<?php top("Preferences", true); ?>
	<i>Select the sections you want enabled</i>
        <br></br>
        <form>
  <?php
  $sql = "SELECT DISTINCT Section FROM packages ORDER BY Section ASC ";
$result = mysql_query($sql) or die("db error");
while ($row = mysql_fetch_row($result)) {
echo "<label><input type=\"checkbox\" name=\"".$row[0]."\" checked=\"yes\"/>".$row[0]."</label>";
}
foot();
?>
        </form>
</body>
</html>