<!DOCTYPE html> 
<html> 
	<head> 
	<title>Available updates</title> 
<?php 
/*
 * 
 */
$mysql=true;
include('./includes/header.php'); 
include('./includes/cdhandler.php');

?>
<script type="text/javascript" src="device.php"></script>

</head> 
<body>
<form name="updates" id= "updates" action="updates.php" method="POST">
<input type="hidden" name="packages" id="packages" value="" />
</form>

<div data-role="page">

	<div data-role="header">
		<h1>Updates</h1>
	</div><!-- /header -->

	<div data-role="content">
<div class="content-primary">
<ul data-role="listview" data-filter="true">
<?php 
$packages=base64_decode($_POST['packages']);
if($packages) {
$list = "";
$packarray=explode(")$(",$packages);
foreach($packarray as $pack) {
$dat=explode("`,`",$pack);
$Package=$dat[0];
$Version=$dat[1];
$res=mysql_query("SELECT `Version`,`Name` FROM packages WHERE `Package`='$Package'");
if($res && mysql_num_rows($res)>0) {
if(mysql_result($res,0, "Version")==$Version)
{
//echo "true";
} else {
$Name=mysql_result($res,0,"Name");
$LVersion=mysql_result($res,0,"Version");
if(advanced_version_compare($Version, $Lversion, ">"))
{
package($Name,"package.php?q=$Package&upd=true","Current version: $Version Latest: $LVersion");
}
}
} else {
//echo "true";
}
}
} else { ?>
		<script type="text/javascript">
packlist = device("packlist");
if(packlist=="PLUGIN_ERROR") {
//document.getElementById("installbutton").href = "pluginhelp.php";
document.getElementById("installed").innerHTML = "Failed loading packages";
} else {
packages = window.btoa(packlist.substring(0, packlist.length-1).substring(2, packlist.length-2));
document.getElementById("packages").value=packages;
document.forms['updates'].submit();
}
</script>
<? } ?>
</ul>
<?php foot(); ?>

</body>
</html>