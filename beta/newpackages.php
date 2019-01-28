<!DOCTYPE html> 
<html> 
<head> 
<?php 
$mysql=true;
include('./includes/header.php'); ?>
<title>new packages</title> 
</head> 
<body> 

<?php 
top("New stuff", true); 
listview(true,false);
$result=mysql_query("SELECT `value` FROM `system` WHERE `property`='LastReload'");
$LastReload=mysql_result($result,0);
$query="SELECT Name, Package, Description, Filename FROM  `packages` WHERE  `Date` = '$LastReload' ORDER BY `Name` ASC LIMIT 0, 60";
$result=mysql_query($query) or die("db error");

$num=mysql_numrows($result);

mysql_close();



$i=0;
while ($i < $num) {

$name =  mysql_result($result,$i,"Name");
$package = mysql_result($result,$i,"Package");
$description = mysql_result($result,$i,"Description");
$paid = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
package($name,"package.php?q=$package",$description,$paid);
$i++;
}
echo "</ul>";
foot();
?>
</body>
</html>

		
		