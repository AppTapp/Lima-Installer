<!DOCTYPE html> 
<html manifest="./appcache.php"> 
<head> 
<?php 
$mysql=true;
include('./includes/header.php'); ?>
<title><?php echo $_GET['q']; ?></title> 

</head> 
<body> 
<?php 
top($_GET['q'],true); 
?>
<script>
function loadMore(num) {
var rurl = "<?php if(stristr($_SERVER['REQUEST_URI'],"https")) { echo "https"; } else { echo "http"; } ?>://www.limainstaller.com/beta/morepackages.php?q=<?php echo str_replace(" ", "%20", $_GET['q']); ?>&n=" + num;
var resulte = "failed to load";
document.getElementById("morebutton").innerHTML="loading...";
$.ajax({ async:false, url: rurl,
success: function(data){
resulte = data;
}
});
document.getElementById("packages").removeChild(document.getElementById("morebutton"));
document.getElementById("packages").innerHTML=document.getElementById("packages").innerHTML + resulte;
}
</script>
<?php
listview(true, false, "packages");
$section = $_GET['q'];
$query="SELECT Name, Package, Description, Filename FROM  `packages` WHERE  `Section` = \"$section\" ORDER BY `Name` ASC LIMIT 0, 50";
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
package("More","javascript:loadMore(50)","Load more packages",false,"morebutton");
echo "</ul>";
foot(); 
?>
</body>
</html>

		
		