<!DOCTYPE html> 
<html manifest="./appcache.php"> 
    <head> 
        <title>Lima - Remove</title> 
        <?php
        $mysql = true;
        include('./includes/header.php');
        session_start();
        include('./includes/crypto.php');
        include('./config/tokens.php');
        $uniqueid = strtoupper($_COOKIE["uniqueid"]);
        $realmagichash = $_SESSION['MagicHash'];
        $magichash = $_POST['magichash'];
        if ($magichash != $realmagichash || $magichash == "" || $realmagichash == "") {
//keep le script kiddies out
            die("how about no?");
        }
        $installedpackages = base64_decode($_POST['installedpackages']);
        $installedarray = explode(")$(", $installedpackages);
        $installedversions = array();
        foreach ($installedarray as $pack) {
            $details = explode("`,`", $pack);
            $installedversions[$details[0]] = $details[1];
        }
        $Package = $_POST['Package'];
//check if the user isn't doing stupid things
        $query = "SELECT `Package`, `Name` FROM  `packages` WHERE  `AllDepends` LIKE  '%$Package%'";
        $result = mysql_query($query) or die("db error");
        $numdependpacks = 0;
        while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
            if ($installedversions[$row[0]]) {
                $log .= $row[1] . "(" . $row[0] . ")</br>";
                $numdependpacks+=1;
            }
        }
        ?>
        <script type="text/javascript" src="device.php"></script>

    </head> 
    <body> 
        <?php
        top("Remove package", 2);
        if ($numdependpacks == 0) {
            $ticketid = rand(100000, 999999);
            $packageList = $_POST['Package'];
            $expires = (date("m") * 31 * 24 * 60) + (date("d") * 24 * 60) + (date("H") * 60) + (date("i") * 1);
            mysql_query("INSERT INTO  `lima_main`.`opentickets` (`ticketid` ,`udid` ,`packageList` ,`action` ,`securityToken` ,`expires`) VALUES ('$ticketid',  '$uniqueid',  '$packageList',  'remove',  '$secureToken',  '$expires');") or die(ErrorMessage(mysql_error()));
            ?>
            </br></br></br></br></br>
        <center><div id="installstatus"><h4>Removing package(s)</h4></div></center>
        <script>
            function wait() {
                if(done == true)
                {
                    document.getElementById("installstatus").innerHTML = "<h4>The package(s) have been removed.<?php if ($respring) {
            echo "</br><a href=\\\"javascript:device('respring')\\\">Respring now!</a>";
        } ?></h4>";
                    
                }  else {
                    setTimeout(wait,50);
                }  
            }
            function start() {
                install('<?php echo $secureToken; ?>','<?php echo $ticketid; ?>');

                    wait();
                
            }
            setTimeout(start, 1000);
        </script>
<?php
} else {
    echo "You have $numdependpacks packages installed which directly or indirectly depend on this package, therefore you can't remove it.";
    ?>
        <div id="installlog" data-role="collapsible"><h3>View packages</h3>
            <h6><?php echo $log; ?></h6>
        </div></div></div>
    <? } ?>
</body>
</html>