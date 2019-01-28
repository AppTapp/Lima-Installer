<?php
$salt = "Limaeet";
$res = '';
for ($i=0; $i < strlen($salt); $i++)
    {
        $res .= ord($salt[$i]);
    }
$salt=$res;
function bcdechex($dec) {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);

        if($remain == 0) {
            return dechex($last);
        } else {
            return bcdechex($remain).dechex($last);
        }
    }
function bchexdec($hex)
{
    $dec = 0;
    $len = strlen($hex);
    for ($i = 1; $i <= $len; $i++) {
        $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
    }
    return $dec;
}


function encrypt($string) {
$result='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $result .= bcdechex(ord($string[$i]));
    }
$result=strrev(bcdechex(bcmul(bchexdec($result), $GLOBALS["salt"])));
return $result;
} 
function decrypt($hash) {
$hash=bcdechex(bcdiv(bchexdec(strrev($hash)), $GLOBALS["salt"]));

 $result='';
    for ($i=0; $i < strlen($hash)-1; $i+=2)
    {
        $result .= chr(bchexdec($hash[$i].$hash[$i+1]));
    }
return $result;
}
/*
$tohash = $_POST['string'];
$todecrypt = $_POST['hash'];
$hash = encrypt($tohash);
if($hash != "0") {
//echo "encrypted string:  ";
//echo $hash;
}
echo "\n\n";
$string = decrypt($todecrypt);
if($string != "") {
//echo "decrypted string:  ";
//echo htmlentities($string);
}*/
?></pre>
