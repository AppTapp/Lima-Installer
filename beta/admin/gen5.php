<!DOCTYPE html> 
<html> 
    <head> 
        <title>Invites</title> 
<?php
$mysql=true;
include('../includes/header.php');

?>
    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>Invites</h1>
            </div><!-- /header -->

            <div data-role="content">	
                <i>5 invites generated, enjoy :D</i>
                </br>
                <textarea name="icodes" id="icodes"><?php
for($i=0;$i<5;$i++) {
$icode=rand(9999999,99999999);
mysql_query("INSERT INTO  `lima_main`.`beta_users` (`icode` ,`udid`,`ip`) VALUES ('$icode',  'NONE',  'NONE')") or die("error ".mysql_error());
echo "Cydia repo: http://limainstaller.com/getbeta/$icode\n";
echo "Setup URL: https://beta.limainstaller.com/setupbeta.php?icode=$icode\n\n";
}
?>
          </textarea>
            </div><!-- /content -->
            
        </div><!-- /footer -->
    </div><!-- /page -->

</body>
</html>




