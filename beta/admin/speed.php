<!DOCTYPE html> 
<html manifest="../appcache.php"> 
<head> 
<?php 
function packagez($name, $link, $description, $paid = false, $id="", $preparsed=false) {
    if ($paid) {
        $style = "style=\"color:#547c9b\"";
    }
    if($id != "")
    {
    $id= " id=\"$id\"";
    }
    if(!$preparsed)
    {
 
    } else {
   
        
    }
    
}
$mysql=true;
include('../includes/header.php'); ?>
<title>Dry run</title> 
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
</head> 
<body> 
<?php 
top("dry run",true); 
listview(false, true, "packages");
$section = "tweaks";
info("Listing",$section);
$query="SELECT Name, Package, Description, Filename FROM  `packages` WHERE  `Section` = \"$section\" ORDER BY `Name` ASC LIMIT 0, 50";
$time = microtime(true);


$result=mysql_query($query) or die("db error");
$timez=(microtime(true) - $time);
info("query time",$timez."s");
$num=mysql_numrows($result);
mysql_close();
$i=0;
while ($i < $num) {
$name =  mysql_result($result,$i,"Name");
$package = mysql_result($result,$i,"Package");
$description = mysql_result($result,$i,"Description");
$paid = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
packagez($name,"package.php?q=$package",$description,$paid);
$i++;
}
packagez("More","javascript:loadMore(50)","Load more packages",false,"morebutton");
info("php time",(microtime(true) - $time-$timez)."s");
echo "</ul>";
foot(); 
?>
</body>
</html>

		
		