<?php
session_start();
$uniqueid = strtoupper($_COOKIE["uniqueid"]);
$realmagichash = $_SESSION['MagicHash'];
$magichash = $_POST['magichash'];
if ($magichash != $realmagichash || $magichash == "" || $realmagichash == "") {
//die($magichash."---".$realmagichash);    
die("<script>window.location='https://limainstaller.com/beta/index.php';</script>");
}
$_SESSION['MagicHash'] = "";
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title>Lima - Install</title> 
        <?php
        global $error;
        $mysql = true;
        include('./includes/header.php');
        include('./includes/crypto.php');
        include('./config/tokens.php');
        include('./includes/cdhandler.php');

        function GetDl($url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
            $content = curl_exec($ch);
            curl_close($ch);


            if (con($content, 'HTTP/1.1 200')) {
                global $DlSizeArray;
                $DlSizeArray[] = GetBetween($content, "Content-Length: ", "\r");
                return $url;
            } elseif (con($content, "Location: ")) {
                return GetDl(GetBetween($content, "Location: ", "\r"));
            } else {
                $log = "installpackage: " . escape($content) . " - " . escape($url);
                $ip = $_SERVER['REMOTE_ADDR'];
                mysql_query("INSERT INTO `lima_main`.`errors` (`log`, `ip`, `date`) VALUES ('$log', '$ip', CURDATE());");
                return "error";
            }
        }

        $installedpackages = base64_decode($_POST['installedpackages']);
        $installedarray = explode(")$(", $installedpackages);
        $installedversions = array();
        $InstallList = array();
        $installedconflicts = array();
        foreach ($installedarray as $pack) {
            $details = explode("`,`", $pack);
            $installedversions[$details[0]] = $details[1];
            if ($details[4] != "-") {
                foreach (explode(",", $details[4]) as $conflict) {
                    $installedconflicts[] = $conflict;
                }
            }
        }
        $Package = $_POST['Package'];
        $result = mysql_query("SELECT * FROM  `packages` WHERE  `Package` = \"$Package\"") or die("A database error occured, please try again later");
        if (mysql_result($result, 0, "Package")) {
            $Name = mysql_result($result, 0, "Name");
if(mysql_result($result, 0, "Section")=="Tweaks") $respring=true;
//CHECK DEPENDENCIES//
            $AllDepends = mysql_result($result, 0, "AllDepends");
if(stristr($AllDepends,"mobilesubstrate")) $respring=true;

            foreach (explode(",", $AllDepends) as $Dependency) {
                if (isinstalled($Dependency, $installedversions) == false) {
                    if (stristr($Dependency, "(")) {
                        $p = explode(" ", $Dependency);
                        $Dependency = $p[0];
                    }
                    $InstallList[] = $Dependency;
                }
                $InstallList=  array_unique($InstallList);
            }
            //END CHECK DEPENDENCIES//
            //CHECK CONFLICTS//
            //first check if any of the installe packages conflicts with it
            foreach ($installedconflicts as $Conflict) {
                if (isinstalled($Conflict, array($Package => mysql_result($result, 0, "Version")))) {
                    $error .= "$Conflict conflicts with the package you're trying to install";
                }
            }
            //next check if any of the conflicts are installed
            foreach (explode(mysql_result($result, 0, "Conflicts")) as $Conflict) {
                if (isinstalled($Conflict, $installedversions)) {
                    $error .= "$Conflict conflicts with the package you're trying to install";
                }
            }
            //END CHECK CONFLICTS//
            //GET DOWNLOAD LINKS//
            if (!$error) {
                $result = mysql_query("SELECT * FROM `sources`");
                $SourceURLs = array();
                for ($i = 0; $i < mysql_num_rows($result); $i++) {
                    $url = mysql_result($result, $i, "url");
                    $Source = mysql_result($result, $i, "source");
                    $SourceURLs[$Source] = $url;
                }
                $InstallList[] = $Package;
                foreach ($InstallList as $pack) {
                if($pack=="mobilesubstrate")
                {
                $respring=true;
                }
                    if ($pack) {
                        $res = mysql_query("SELECT * FROM `packages` WHERE `Package`='$pack'");
                        if (!mysql_result($res, 0, "Source")) {
                            if($pack == "firmware") {
                                    $error = "This package is not compatible with your firmware";
                                } elseif(stristr($pack, "gsc.")) {
                                    $error = "This package is not compatible with your device";
                                } else {
                                    $error = "couldn't locate $pack";
                                } 
                       
                            
                        } else {
                            $Links[] = GetDl($SourceURLs[mysql_result($res, 0, "Source")] . mysql_result($res, 0, "Filename"));
                           
                            if ($Links[count($Links)-1] == "error") {
                                $error .= "couldn't locate $pack";
                            }
                        }
                }
                    
                }

                //END GET DOWNLOAD LINKS//
                $packageList = implode(",", array_reverse($Links)); //BOOM!
                $ticketid = rand(100000, 999999);
                $expires = (date("m") * 31 * 24 * 60) + (date("d") * 24 * 60) + (date("H") * 60) + (date("i") * 1);
                mysql_query("INSERT INTO  `lima_main`.`opentickets` (`ticketid` ,`udid` ,`packageList` ,`action` ,`securityToken` ,`expires`) VALUES ('$ticketid',  '$uniqueid',  '$packageList',  'install',  '$secureToken',  '$expires');") or die(ErrorMessage(mysql_error()));
            }
        } else {
            $error = "Couldn't find the package you're trying to install";
        }
        ?>
        <script type="text/javascript" src="device.php"></script>
        <script>
            function setPercentage(perc) {
if(perc>100)
{
perc=100;
}
                var wid = Math.round(perc);
                document.getElementById("installprog").style.width=wid+"%";
            }
        </script>
        <style>
            .loader {
                -moz-border-radius: 7px;
                -webkit-border-radius: 7px;
                border-radius: 7px;
                -moz-box-shadow: 0px 0px 7px #000000;
                -webkit-box-shadow: 0px 0px 7px #000000;
                box-shadow: 0px 0px 7px #000000;
                width: 100%;
                height: 15px;

            }
            .loaderinside {
                -moz-border-radius: 7px;
                -webkit-border-radius: 7px;
                border-radius: 7px;

                background-image: -moz-linear-gradient(top, #547c9b, #76aedb);
                background-image: -ms-linear-gradient(top, #547c9b, #76aedb);
                background-image: -o-linear-gradient(top, #547c9b, #76aedb);
                background-image: -webkit-gradient(linear, center top, center bottom, from(#547c9b), to(#76aedb));
                background-image: -webkit-linear-gradient(top, #547c9b, #76aedb);
                background-image: linear-gradient(top, #547c9b, #76aedb);
                width: 0%;
                height: 15px;
                position:relative;
                top:0px;
                left: 0px;
            }
        </style>
    </head> 
    <body> 

<?php top("Installing", 2); ?>
        <br></br><br></br><br>
    <center><div id="installstatus"></div></center>
<?php echo $error; ?>
    <br></br><p><div id="statuz"> <div class="loader">
            <div id="installprog" class="loaderinside">
            </div></div><center></div></br></center>
</div></div>
<? if (!$error) { ?>
    <script>
        var dlsizes = new Array(0<?php
    foreach ($DlSizeArray as $size) {
        echo "," . $size;
    }
    ?>);
        function start() {
            install('<?php echo $secureToken; ?>','<?php echo $ticketid; ?>');

            dlprogresschecker=setInterval(function() {
                if(done==false)
                {
                    status=getStatus();
                    stat=status.split("$");
                                            
                        
                    s=stat[0];
                    percentage=(stat[1]/dlsizes[s])*100;
                    if(percentage==100)
                    { 
                          
                        document.getElementById("installstatus").innerHTML = "<h4>Installing package "+stat[0]+"/"+(dlsizes.length-1)+"</h4>";
                        setPercentage(100);     
                    }else {
                        document.getElementById("installstatus").innerHTML = "<h4>Downloading package "+stat[0]+"/"+(dlsizes.length-1)+"</h4>";
                        setPercentage(percentage);   
                    }
                        
                } else {
                    clearInterval(dlprogresschecker); 
                    document.getElementById("installstatus").innerHTML = "<h4>Installation complete!<?php
    if ($respring) {
        echo "<br></br><a href=\\\"javascript:device('respring')\\\">Respring now!</a>";
    }
    ?></h4>";
                    
                }
                                            
            }, 500);
        }
        setTimeout(start, 1000);
    </script>
<? } ?>
</body>
</html>
