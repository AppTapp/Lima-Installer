<?php if($_GET['uniqueid'])
{
    $_COOKIE['uniqueid']=$_GET['uniqueid'];
}
?>
<html> 
    <head> 

        <title>Welcome</title> 
        <?php
        $mysql = false;
        include('./includes/header.php');
        ?>
    </head> 
    <body> 

        <?php 
        top("Welcome");
        bighead("Lima");
        infotext("The future, happening now...");
        listview(false, true);
        section("About Lima", "https://limainstaller.com/");
        section("My Lima", "javascript:alert('coming soon!')");
        section("Network status", "status.php");
        echo "</ul>";
        listview(false, true);
        section("What's new", "new.php");
        section("Report a problem", "mailto:support@limainstaller.com");
        section("Terms of Service", "license.php");
        section("Credits", "credits.php");
        echo "</ul>"; 
        foot();
        ?>
    </body>
</html>
