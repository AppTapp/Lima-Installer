<?php
include('header.php');
if(!$internal)
{
    die();
}
$blah="test";
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
$GLOBALS['blah']="magic";
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
if(con($content, 'HTTP/1.1 200')) {
//everything seems ok
return $url;

} elseif(con($content, "Location: ")) {
return GetDl(GetBetween($content, "Location: ", "\r"));
} else {
return "error";
}
}
echo $blah;
echo GetDl($_GET['p']);
echo $blah;
?>