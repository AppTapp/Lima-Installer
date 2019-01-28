
<pre><?php
function GetBetween($str, $str1, $str2) {
$arr1=explode($str1, $str);
$arr2=explode($str2, $arr1[1]);
return $arr2[0];
}

$udid=strtolower($_GET['udid']);
// create a new cURL resource
$mysql=true;
include('./includes/header.php');
$Packagez = mysql_real_escape_string($_GET['p']);
$result=mysql_query("SELECT `Filename`, `Source` FROM `packages` WHERE Package = \"$Packagez\" ") or die(mysql_error());
$Source = mysql_result($result,0,"Source");
$Filename = mysql_result($result,0,"Filename");
$packageurl="http://".$Source.$Filename;
//echo $packageurl;
$ch = curl_init();
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $packageurl);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'X-Firmware: 4.2.1',
'X-Machine: iPod2,1',
'X-Unique-ID: '.$udid
    ));

curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); 
$content = curl_exec($ch);
curl_close ($ch);
//echo $content;
$url = GetBetween($content, "Location: ", "\r");
echo "<a href=\"$url\">$url</a>";

$ch = curl_init();
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "https://cydia.saurik.com/api/activation?package=".$Packagez);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'X-Firmware: 4.2.1',
'X-Machine: iPod2,1',
'X-Unique-ID: '.$udid,
'User-Agent: Mozilla/5.0 (iPod; CPU iPhone OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3 Cydia/1.1.6 CyF/675.00',
'X-Cydia-Cf: 675.00'
    ));

curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$content = curl_exec($ch);
curl_close ($ch);
echo $content;

?></pre>