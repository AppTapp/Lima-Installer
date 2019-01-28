<html>
<?php 
        $mysql=false;
        include('./includes/header.php'); 
        if(!$internal)
        {
            die();
        }
?>
<head>
<script type="text/javascript" src="device.php"></script>
<script>
function execz(cmdz)
{
document.write(device(cmdz));
    
    
}
</script>
</head>
<body>
<?php top("Package info", true,true); ?>
<pre><?php echo "install".preg_replace('/\s+/', '',$_POST['installedpackages']); ?></pre>
<form name="installation" id= "installation" action="deviceactions.php" method="POST">
<input type="hidden" name="magichash" value="<?php echo $magichash; ?>" />
<input type="hidden" name="Package" value="<?php echo $Package; ?>" />
<input type="hidden" name="installedpackages" id="installedpackages" value="" />
</form>
<a href="javascript:execz('udid')">udid</a></br>
<a href="javascript:execz('otaconfig')">OTA</a></br>
<a href="javascript:execz('packlist')">package list</a></br>
<a href="javascript:alert(test())">status</a></br>
<script type="text/javascript">
packlist = device("packlist");
if(packlist=="PLUGIN_ERROR") {
document.getElementById("installbutton").href = "setupbeta.php";
document.getElementById("installbutton").innerHTML = "No plugin";
} else if(packlist.indexOf("<?php echo $_GET['q']; ?>") != -1) {
  var update=<?php if($_GET['upd']!="true") { echo "false"; } else { echo "true"; } ?>;
    
document.getElementById("installedpackages").value = packlist;
} else {
document.getElementById("installedpackages").value = packlist;
}
</script>
</body>
</html>