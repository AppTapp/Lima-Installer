<pre><?php
$total="$";
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if (stristr($entry,".log")) {
            //echo "$entry\n";
$lines = file($entry);

foreach ($lines as $line_num => $file) {

$file=str_replace(" ","$",$file);
while(stristr($file,"$$")) {
$file=str_replace("$$","$",$file);
}
$file=str_replace("\r","\r @",$file);
if(stristr($file,"ii")) {
$s=explode("$",$file);
$total .= $s[1]."$";
}
}
      }
    }
    closedir($handle);
}

$lines = file('./dpkgl.log');

foreach ($lines as $line_num => $file) {

$file=str_replace(" ","$",$file);
while(stristr($file,"$$")) {
$file=str_replace("$$","$",$file);
}
$file=str_replace("\r","\r @",$file);
if(stristr($file,"ii")) {
$s=explode("$",$file);

$count=substr_count($total,"$".$s[1]."$");
if($count>15 && $count<18) {
echo $count."x  ".$s[1]."\n";
}
}
}
?></pre>