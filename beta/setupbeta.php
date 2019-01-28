<!DOCTYPE html> 
<html> 
	<head> 
	<title>Setup</title> 
<?php 
include('./includes/header.php'); 
include './config/tokens.php';
$ip="127.0.0.1";
$ip="localhost";
$userip = $_SERVER['REMOTE_ADDR'];
$base=$userip.":".$secureToken.":".$secretToken;
$magichash = hash("sha256",$base);
?>

<script type="text/javascript">
function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value;
}
function setup() {  
var icode=document.getElementById("icode").value;
var rurl = "http://<?php echo $ip; ?>:1337/A=<?php echo $secureToken; ?>/B="+icode+"/C=setup/D=<?php echo $magichash ?>/END/";
var resultd = "PLUGIN_ERROR";
$.ajax({ async:false, url: rurl,
success: function(data){
resultd = data;
}
});
if(resultd=="PLUGIN_ERROR") {
alert('it seems like you don\'t have the lima plugin installed, if it is installed please try rebooting your device.');
} else if(resultd=="WRONG_AUTH") {
alert("A security error occured, please try again.")
} else if(resultd=="DENIED") {
alert('You didn\'t give us permission to install packages on your device or you are not authorized to use Lima');
} else {
setCookie("uniqueid", resultd, 3650);
alert('setup successfull!');
window.location = 'index.php?uniqueid='+resultd;
}
}

</script>
</head> 
<body> 

<?php top("Setup"); ?>
	<h2>Setup</h2>
	<i>To use Lima you need to have the Lima plugin installed on your device, your beta invite email contains instructions on how to obtain the plugin. If the plugin is installed tap the "authorize device" button. Note that one invite can only authorize one device.</i>
	<input type="hidden" name="icode" id="icode" value="<?php echo $_GET['icode']; ?>" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset">
<?php
listview(false,true);
section("Authorize device","javascript:setup();");
echo "</ul>";
foot(true);
?> 

</body>
</html>