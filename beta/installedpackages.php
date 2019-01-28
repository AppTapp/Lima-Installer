<?php $uniqueid = $_COOKIE['uniqueid']; ?>
<!DOCTYPE html>
<html> 
    <head>
        <title>Installed Packages</title>
        <?php
        $mysql = false;
        include('./includes/header.php');
        ?>
        <script type="text/javascript" src="device.php"></script>
       
    </head>
    <?php
    top("Installed");
    listview(true, false, "installed");
    ?>

    <script type="text/javascript">
        packlist = device("packlist");
        if(packlist=="PLUGIN_ERROR") {
            //document.getElementById("installbutton").href = "pluginhelp.php";
            document.getElementById("installed").innerHTML = "Failed loading packages";
        } else {
            var packarray = packlist.substring(0, packlist.length-1).substring(2, packlist.length-2).split(")$(");
            packarray = packarray.sort();
            for(var pack in packarray) {
                packdetails = packarray[pack].split("`,`");
                if(packdetails[2]=="-") { 
                    packdetails[2]=packdetails[0];
                    namearray = packdetails[0].split(".");    
                    packdetails[2]=namearray[namearray.length-1]; 
                    packdetails[2]=packdetails[2].charAt(0).toUpperCase() + packdetails[2].slice(1);
                }
                document.write('<?php package("'+packdetails[2]+'", "package.php?q='+packdetails[0]+'", "'+packdetails[3]+'"); ?>');

            }
            
            
        }
    </script>

</ul>

<?php foot(); ?>

</body>
</html>