<?php
$mysql = false;
include('./includes/header.php');
if (!$internal) {
    die();
}

$filesize = "1";

function GetBetween($str, $str1, $str2) {
    $arr1 = explode($str1, $str);
    $arr2 = explode($str2, $arr1[1]);
    return $arr2[0];
}

function con($stringz, $needlz) {
    if (stristr($stringz, $needlz) !== false) {
        return true;
    } else {
        return false;
    }
}

function GetDl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_USERAGENT, 'LimaInstaller');


// Only calling the head
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADER, true); // header will be at output
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD'); // HTTP request is 'HEAD'
    $content = curl_exec($ch);
    curl_close($ch);
    if (con($content, 'HTTP/1.1 200')) {
        $GLOBALS['filesize'] = GetBetween($content, "Content-Length: ", "\r");
        return $url;
    } elseif (con($content, "Location: ")) {
        return GetDl(GetBetween($content, "Location: ", "\r"));
    } else {
        return "error";
    }
}

$url = GetDl($_GET['p']);
//echo $url;
//echo $filesize;
//exit();
if ($url == "error") {
    echo "error";
    exit();
}
$ip = "127.0.0.1";
$auth = "zomfgpie";
?>
<html>
    <head>
        <meta content="minimum-scale=4, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="device.php"></script>
    </head>

    <body>
        <div id="status">
            please wait
        </div>
        <script>
            function init() {
                install('<?php echo $url; ?>', <?php echo $filesize; ?>);

            }
            setTimeout(init, 1000);
        </script>
    </body>
</html>