<?php
Header("content-type: application/x-javascript");
$ip="127.0.0.1";
//$ip="192.168.2.47";
if(!$_COOKIE["uniqueid"])
{
if($_GET['uniqueid'] != true) {
echo "window.location = 'setupbeta.php';\n";
} else {
$uniqueid = $_GET["uniqueid"];
include './config/tokens.php';

}
} else {
$uniqueid = $_COOKIE["uniqueid"];
include './config/tokens.php';
}
?>
var latestlima="OK_2.1";
var done=false;
function install(secureToken, ticketId)
{
//document.getElementById("status").innerHTML = "starting download";
var rurl = "http://<?php echo $ip; ?>:1337/A=" + secureToken + "/B=" + ticketId + "/C=ticket/D=install/END/";
var resulta = "PLUGIN_ERROR";
$.ajax({ async:true, url: rurl,
success: function(data){
resulta = data;
if (resulta != "PLUGIN_ERROR") {
done = true;
console.log("finished");
//getdlstatus(sizez);
}
}
});

}
function test() {
var rurl = "http://<?php echo $ip; ?>:1337/A=<?php echo $secureToken; ?>/B=<?php echo $uniqueid; ?>/C=test/D=0/END/";
var resultd = "PLUGIN_ERROR";
$.ajax({ async:false, url: rurl,
success: function(data){
resultd = data;
}
});
return resultd;
}
function device(command) {
var rurl = "http://<?php echo $ip; ?>:1337/A=<?php echo $secureToken; ?>/B=<?php echo $uniqueid; ?>/C=direct/D=" + command + "/END/";
var resultd = "PLUGIN_ERROR";
$.ajax({ async:false, url: rurl,
success: function(data){
resultd = data;
}
});
if(resultd=="NO_SETUP")
{
window.location='setupbeta.php';
} 
return resultd;
}
function getStatus() {
var rurl = "http://<?php echo $ip; ?>:1337/A=<?php echo $secureToken; ?>/B=<?php echo $uniqueid; ?>/C=direct/D=status/END/";
var resultd = "PLUGIN_ERROR";
$.ajax({ async:false, url: rurl,
success: function(data){
resultd = data;
}
});
//console.log(resultd);
return resultd;
}
function get(u) {
var rurl = "https://limainstaller.com/beta/" + u;
var resulte = "true";
$.ajax({ async:false, url: rurl,
success: function(data){
resulte = data;
}
});
return resulte;

}
if(test()!=latestlima)
{
window.location = 'plugin.php';
}