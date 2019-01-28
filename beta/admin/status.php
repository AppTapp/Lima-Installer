<?php
include("../config/dbinfo.php");
$zomgpiestatus = "<font color=\"orange\">UNKNOWN</font>";
$fp = @fsockopen("cookie.limainstaller.com", 80, $errno, $errstr, 2);
if (!$fp) {
   $zomgpiestatus = "<font color=\"red\">OFFLINE</font>";
} else{ 
   $zomgpiestatus = "<font color=\"green\">ONLINE</font>";
}
$dbserverstatus = "<font color=\"orange\">UNKNOWN</font>";
$fpz=true;
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or ($fpz=false);
mysql_select_db("lima_main");
if (!$fpz) {
   $dbserverstatus = "<font color=\"red\">OFFLINE</font>";
   $LastReload="UNKNOWN";
} else{ 
   $dbserverstatus = "<font color=\"green\">ONLINE</font>";
   $result=mysql_query("SELECT `value` FROM `system` WHERE `property`='LastReload'");
   $LastReload=mysql_result($result,0);
   $result=mysql_query("SELECT `value` FROM `system` WHERE `property`='ReloadProgress'");
   $reloadprog=mysql_result($result,0);
   $result=mysql_query("SELECT * FROM `packages`");
   $numpacks=mysql_num_rows($result);
   $result=mysql_query("SELECT * FROM `opentickets`");
   $opentickets=mysql_num_rows($result);
   $prog=round(($reloadprog/$numpacks)*100); 

}
$activations=mysql_num_rows(mysql_query("SELECT * FROM `beta_users` WHERE `udid` != 'NONE'"));
$emailqueue=mysql_num_rows(mysql_query("SELECT *  FROM `mail_queue` WHERE `statuscode` != 1"));
?>
<!DOCTYPE html> 
<html> 
	<head> 
	<title>Status</title> 
<?php include('../includes/header.php'); ?>
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
                width: <?php echo $prog; ?>%;
                height: 15px;
                position:relative;
                top:0px;
                left: 0px;
            }
        </style>
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1>Network status</h1>
	</div><!-- /header -->

	<div data-role="content">	
	
	
	<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="f"> 

				<li>Server 1 <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><font color="green">ONLINE</font></span</a></li>				
		        <li>Server 2 <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $zomgpiestatus ?></span</a></li> 
				<li>Database Server <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $dbserverstatus ?></span</a></li> 
				<li>Session logging <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><font color="green">ENABLED</font></span</a></li> 
				<li>HTTPS <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><font color="green">AVAILABLE</font></span</a></li> 
				<li>Last data refresh <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $LastReload; ?></span</a></li>
<li>Open install tickets <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $opentickets; ?></span</a></li>     
<li>Packages in database <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $numpacks; ?></span</a></li> 
<li>reload Progress <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $reloadprog; ?></span</a></li>
<li>beta activations <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $activations; ?></span</a></li> 
 <li>mail queue <span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?php echo $emailqueue; ?></span</a></li> 
				
			</ul> 
            </br>
            <center><?php echo $prog; ?>% reloaded</center></br>
            <div class="loader">
                        <div id="installprog" class="loaderinside">
                        </div></div></div><!-- /content -->

</div><!-- /page -->

</body>
</html>

		