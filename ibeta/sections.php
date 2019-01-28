<!DOCTYPE html> 
<html manifest="./appcache.php"> 
    <head> 
        <title>Sections</title> 
        <?php
        $mysql = true;
        include('./includes/header.php');
        ?>

    </head> 
    <body> 

<?php
top("Sections");
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
listview(true,false);
//Sections module for Lima
//3-5-2011 Justin
$sql = "SELECT DISTINCT Section FROM packages ORDER BY Section ASC ";
$result = mysql_query($sql) or die("db error");
while ($row = mysql_fetch_row($result)) {
section($row[0],"packages.php?q={$row[0]}");
}

echo "</ul>";
foot();
?>
</body>
</html>


