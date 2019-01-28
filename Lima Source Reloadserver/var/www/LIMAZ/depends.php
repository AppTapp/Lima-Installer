
<pre><?php function GetAllDepends($pack) { 
$package="limacache".escapeshellcmd($pack); 
$pie=shell_exec("apt-rdepends --show=DEPENDS --show=PREDEPENDS $package 2>&1"); 
$brokenpie=explode(" Done", $pie); $depconfarray=explode("\n", 
$brokenpie[2]); foreach($depconfarray as $depconf) { 
$brokenpie=explode(" Depends: ", $depconf); $brokenpie=explode(" ", 
str_replace("limacache", "", $brokenpie[1])); 
$dependsarray[]=$brokenpie[0];
}
$dependsarray=array_unique($dependsarray); foreach($dependsarray as 
$package) { 
if($package != "") {
$packagelist .= $package.", ";
}
}
return $packagelist; 
}
echo GetAllDepends($_GET['p']); ?></pre>
 
