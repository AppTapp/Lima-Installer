<pre><?php
function advanced_version_compare($version1,$version2,$operator)
{
$version1=preg_replace('/\D/', '|',$version1);
$version2=preg_replace('/\D/', '|',$version2);
echo $version1."--".$version2;
$operator=str_replace("==","=",str_replace("<<","<=", str_replace(">>",">=",$operator)));
switch ($operator) 
{
case "=":
if($version1==$version2) {
return true;
} else {
return false;
}
break;
case ">=":
if($version1==$version2) {
return true;
} else {
$v1=explode("|",$version1);
$v2=explode("|",$version2);
for($i=0;$i<count($v1);$i++)
{
if($v1[i]<$v2[$i]) {
return true;
}
}
return false;
}
break;
case "<=":
if($version1==$version2) {
return true;
} else {
$v1=explode("|",$version1);
$v2=explode("|",$version2);
for($i=0;$i<count($v1);$i++)
{
if($v1[i]>$v2[$i]) {
return true;
}
}
return false;
}

break;
}
return false;
}
function GetAllDepends($pack) {
$dependsarray=array();
$package="limacache".escapeshellcmd($pack);
$data=shell_exec("apt-rdepends --show=DEPENDS --show=PREDEPENDS $package 2>&1");
$data = explode($package,$data);
$dependencies = explode("\n",$data[1]);
foreach($dependencies as $pack) {
$pack=str_replace("PreDepends:","",$pack);
$pack=str_replace("Depends:","",$pack);
$pack=str_replace("limacache","",$pack);
$pack=trim($pack);
if(strlen($pack)>1) {
$dependsarray[]=$pack;
}
}
$dependsarray=array_reverse(array_unique($dependsarray));
foreach($dependsarray as $dependency) 
{
$packagelist .= "$dependency,";
}
$packagelist=substr($packagelist,0,-1);
return $packagelist;
}

echo GetAllDepends("bash");

echo "\n\n\n";
if(advanced_version_compare("1.14.25.8", "1.1.6r1", ">=")==true)
{
echo "true";
} else {
echo "false";
}
?></pre>
