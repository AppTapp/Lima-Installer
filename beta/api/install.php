<html>
<head>
<meta content="minimum-scale=4, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
<?php include('./includes/header.php'); ?>
<script type="text/javascript" src="device.php"></script>
</head>

<body>
<!DOCTYPE html> 
<html> 
<head> 
<title>Lima - Package info</title> 
<?php include('../includes/header.php'); ?>
<script type="text/javascript" src="device.php"></script>

</head> 
<body> 

<div data-role="page">
<div data-role="header">
<a href="javascript:history.go(-1)">Cancel</a>
<h1>Installing</h1>
</div><!-- /header -->
<div data-role="content">
</br></br></br></br></br>
<center><div id="installstatus"><h5>Starting installation</h5></div></center>

</br></br><center><p><div id="status"></div></br></p><div id="installlog" data-role="collapsible"><h3>Installation log</h3></div></center>
</div></div>

<script>
function start() {
var i = 0;
<?php
$DlSizeArray = array();
function GetBetween($str, $str1, $str2) {
$arr1=explode($str1, $str);
$arr2=explode($str2, $arr1[1]);
return $arr2[0];
}
function con($stringz, $needlz) {
if(stristr($stringz, $needlz) !== false)  {
return true;
} else {
return false;
}
}

function GetDl($url) {
//echo "//".$url;
$url = str_replace("_all.deb", "_iphoneos-arm.deb" , $url);
$ch = curl_init();
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
curl_setopt ($ch, CURLOPT_USERAGENT, 'LimaInstaller');


// Only calling the head
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'
$content = curl_exec ($ch);
curl_close ($ch);
//echo "//".$content;
if(con($content, 'HTTP/1.1 200')) {
global $DlSizeArray;
$DlSizeArray[]=GetBetween($content, "Content-Length: ", "\r");
return $url;

} elseif(con($content, "Location: ")) {
return GetDl(GetBetween($content, "Location: ", "\r"));
} else {
return "error";
}
}

include("./config/dbinfo.php");
mysql_connect($db_host, $db_user, $db_pass) or die("database error"); 
 mysql_select_db("lima_main");
$Package = mysql_real_escape_string($_POST['Package']);
$query="SELECT * FROM  `packages` WHERE  `Package` = \"$Package\"";
$result=mysql_query($query) or die("db error");
//figure out which packages have to get installed
$AllDepends = mysql_result($result,0,"AllDepends");
$dependsArray = explode(", ", $AllDepends);
foreach($dependsArray as $dependency) {
if(stristr($_POST['installedpackages'], $dependency)  == false)
{
$InstallArray[] = $dependency;
}
}
$InstallArray[] = $Package;
foreach($InstallArray as $Packagez) {
//Get link for each package
if($Packagez != "") {
$result=mysql_query("SELECT `Filename`, `Source` FROM `packages` WHERE Package = \"$Packagez\" ") or die(mysql_error());
$Source = mysql_result($result,0,"Source");
$Filename = mysql_result($result,0,"Filename");
$linkarray[]= GetDl("http://".$Source.$Filename);
}
}
$i=0;
$javascript = "";

foreach($linkarray as $link) {
if($link !== "error") {
$p=$i + 1;
$numpacks = count($linkarray);
$javascript .= "i++;\ndocument.getElementById(\"installstatus\").innerHTML = \"<h5>Installing $p/$numpacks</h5>\";\n";
$javascript .= "install('$link', $DlSizeArray[$i]);\n";
$javascript .= "\n";
$i++;
} else {
//$javascript = "document.getElementById(\"status\").innerHTML = \"<h5>One or more packages is not available for download at the moment, please try again later.</h5>\";\n";
break;
}
}
echo $javascript;
?>
document.getElementById("installstatus").innerHTML = "<h5>Done!</h5>";
}
setTimeout(start, 1000);
</script>

</body>
</html>
