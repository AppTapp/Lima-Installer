<!DOCTYPE html> 
<html manifest="./appcache.php"> 
    <head> 
        <title>Search</title> 
        <?php
        $mysql = true;
        include('./includes/header.php');
        ?>
        <script>
function loadMore(num) {
var rurl = "<?php if(stristr($_SERVER['REQUEST_URI'],"https")) { echo "https"; } else { echo "http"; } ?>://www.limainstaller.com/beta/morepackages.php?t=search&q=<?php echo str_replace(" ", "%20", $_GET['s']); ?>&n=" + num;
var resulte = "failed to load";
document.getElementById("morebutton").innerHTML="loading...";
$.ajax({ async:false, url: rurl,
success: function(data){
resulte = data;
}
});
document.getElementById("packages").removeChild(document.getElementById("morebutton"));
document.getElementById("packages").innerHTML=document.getElementById("packages").innerHTML+resulte;
}
</script>
    </head> 
    <body> 
<?php top("Search"); ?>
<form class="ui-listview-filter ui-bar-c" role="search" method="GET" action="search.php">
<input name="s" placeholder="Search..." data-type="search" id="searchfield" class="ui-input-text ui-body-c"></form>	
<?php
listview(false,true,"suggestions");
echo "</ul></br>";
listview(false,false,"packages");
                    $searchterms = $_GET['s'];
                    $results=array();
                    if ($searchterms && ($searchterms != " ")) {
//initial search
                        $query = "SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE `Package` LIKE '$searchterms' union all SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE  `Name` LIKE  '%$searchterms%' UNION all SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE `Package` LIKE  '%$searchterms%' AND `Name` not LIKE  '%$searchterms%' LIMIT 0, 50";
                        $result = mysql_query($query) or die("db error (1)");
                        $num = mysql_numrows($result);
                        $i = 0;
                        while ($i < $num) {
                            $packdetails['name'] = mysql_result($result, $i, "Name");
                            $packdetails['package'] = mysql_result($result, $i, "Package");
                            $packdetails['description'] = mysql_result($result, $i, "Description");
                            $packdetails['paid'] = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
                            $results[]=$packdetails;
                            //package($name,"package.php?q=$package",$description);
                            $i++;
                        }
//second search
                        $query = "SELECT `Package`, `Name`, `Description`,`Filename` FROM  `packages` WHERE `MD5sum` LIKE  '%$searchterms%' OR `Description` LIKE  '% $searchterms %' OR `Author` LIKE  '%$searchterms%' LIMIT 0, 50";
                        $result = mysql_query($query) or die("db error (2)");
                        $num = mysql_numrows($result);
                        mysql_close();
                        $i = 0;
                        while ($i < $num) {
                            $packdetails['name'] = mysql_result($result, $i, "Name");
                            $packdetails['package'] = mysql_result($result, $i, "Package");
                            $packdetails['description'] = mysql_result($result, $i, "Description");
                            $packdetails['paid'] = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
                            $i++;
                        }
                       
                        for($i=0;$i<50;$i++)
                        {
                            $packdetails=$results[$i];
                            if($packdetails)
                            {
                           package($packdetails['name'],"package.php?q=".$packdetails['package'],$packdetails['description'],$packdetails['paid']);
                            } else {
                                //break;
                                $done = true;
                            }
                           
                        }
                        if(!$done)
                        {
                   package("More","javascript:loadMore(100)","Load more results",false,"morebutton");
                        }
                        }
                    
echo "</ul>";
foot();
                    ?>
        <script>
            $("#mainpage").on("pageshow", function(e) {
    console.log("Ready to bring the awesome.");
    var sugList = $("#suggestions");

    $("#searchfield").on("input", function(e) {
        var text = $(this).val();
        if(text.length < 1) {
            sugList.html("");
            sugList.listview("refresh");
        } else {
            $.get("morepackages.php?t=search&n=10", {q:text}, function(res) {
                
                sugList.html(res);
                //sugList.listview("refresh");
                //console.dir(res);
            });
        }
    });

});
            </script>
</body>
</html>