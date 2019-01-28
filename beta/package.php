<?php
session_start();
$uniqueid=$_COOKIE['uniqueid'];
if(!$uniqueid)
{
    header('location: setupbeta.php');
}
$rand = rand(999999, 999999999);
$magichash = sha1(md5($rand));
//store le MagicHash to session so le installerz can getz itz
$_SESSION['MagicHash'] = $magichash;
?>
<!DOCTYPE html> 
<html manifest="./appcache.php"> 
<head> 
<title>Lima - Package info</title> 

<?php
$mysql=true;
include('./includes/header.php'); 

$Package = $_GET['q'];
$notsystem=false;
if(!stristr($Package, "gsc."))
{
$notsystem=true;    
$query="SELECT * FROM  `packages` WHERE  `Package` = \"$Package\" ORDER BY `Name` ASC";
$result=mysql_query($query) or die("db error");
mysql_close();

//load all package that need to get installed into an array
$i=0;
$Name =  mysql_result($result,$i,"Name");
$AllDepends = mysql_result($result,$i,"AllDepends");
$FileName = mysql_result($result,$i,"Filename");
$Source = mysql_result($result,$i,"Source");
$Author = mysql_result($result,$i,"Author");
$Description = mysql_result($result,$i,"Description");
$Section = mysql_result($result,$i,"Section");
$Size = mysql_result($result,$i,"Size");
$Website = str_replace("homepage: ", "", mysql_result($result,$i,"Website"));
//make teh MagicHash :P
$paid = stristr($FileName, "cydiastore");
if(stristr($Source,"bigboss"))
{
$Source="Bigboss";
} elseif(stristr($Source,"modmyi"))
{
$Source="ModMyi";
} elseif(stristr($Source,"saurik"))
{
$Source="Saurik";
} else{
$Source="Unknown";
}
} else {
$Name=$Package;
$Description="System component, can not be modified.";
$Author = "Apple";
$Section="None";
$Size=0;    
$Source="Apple";
}
?>

<script type="text/javascript" src="device.php?uniqueid=<?php echo $uniqueid; ?>"></script>

<script language="JavaScript" type="text/javascript">
<!--
function framebreakout()
{
if (top.location != location) {
top.location.href = document.location.href ;
}
}
//-->
</script>

</head> 
<body onload="framebreakout()"> 
<?php if($notsystem && (!$paid)) { ?>
<form name="installation" id= "installation" action="installpackage.php" method="POST">
<input type="hidden" name="magichash" value="<?php echo $magichash; ?>" />
<input type="hidden" name="Package" value="<?php echo $Package; ?>" />
<input type="hidden" name="installedpackages" id="installedpackages" value="" />
</form>
<? } ?>
<?php top("Package info", true, ($notsystem && (!$paid)));
?>
<!-- show some package info -->
<h2><?php echo $Name; if($paid) { echo " (paid)"; } ?></h2>
<i>by <?php echo $Author ?></i>
<hr>
<p><?php echo $Description ?></p>
<?php
listview(false,true);
section("More info",$Website);
info("Section: ",$Section);
info("Size: ","$Size kB");
info("Source: ","$Source");
if($notsystem && (!$paid)) {
?>
</ul>
<!-- end package info -->
<script type="text/javascript">
packlist = device("packlist");
if(packlist=="PLUGIN_ERROR" || packlist=="") {
document.getElementById("installbutton").href = "setupbeta.php";
document.getElementById("installbutton").innerHTML = "No plugin";
} else if(packlist.indexOf("<?php echo "(".$_GET['q']."`"; ?>") != -1) {
  var update=<?php if($_GET['upd']!="true") { echo "false"; } else { echo "true"; } ?>;
    if(update != true) {
document.getElementById("installation").action = "removepackage.php";
document.getElementById("installbutton").innerHTML = "Remove";
    } else {
        document.getElementById("installbutton").innerHTML = "Update";    
    }
}
document.getElementById("installedpackages").value = window.btoa(packlist.substring(0, packlist.length-1).substring(2, packlist.length-2));
</script>
<? } ?>
</div></div>
</body>