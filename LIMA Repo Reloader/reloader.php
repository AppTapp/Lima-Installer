<?php
error_reporting(E_ALL ^ E_NOTICE);
function con($stringz, $needlz) {
if(stristr($stringz, $needlz) !== false)  {
return true;
} else {
return false;
}
}

function GetAllDepends($pack) { 
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
$package=str_replace("net.howett.pincrush", "pincrush", $package);
$package=str_replace("killall", "shell-cmds", $package);
$packagelist .= $package.", ";
}
}
return $packagelist; 
}

function GetRealSource($file) {
$file=str_replace("127.0.0.1_LIMAZ_bigboss_._Packages", "apt.thebigboss.org/repofiles/cydia/", $file);
$file=str_replace("127.0.0.1_LIMAZ_saurik_._Packages", "apt.saurik.com/cydia-3.7/", $file);
$file=str_replace("127.0.0.1_LIMAZ_modmyi_._Packages", "apt.modmyi.com/", $file);
return $file;
}
$exec=true;
$db_host = 'DB_HOST';
$db_user = 'DB_USER';
$db_pass = 'DB_PASS';
mysql_connect($db_host, $db_user, $db_pass) or die(mysql_error()); 
mysql_select_db("lima_main") or die(mysql_error()); 
echo "connected :D\n";
$handle = opendir('/var/lib/apt/lists'); 
while (false !== ($file = readdir($handle))){ 
  if($file != 'lock' && $file != 'partial' && $file != '.' && $file != '..'){ 
    $handlez = @fopen("/var/lib/apt/lists/$file", "r");
	if ($handlez) {
    while (($data = fgets($handlez, 4096)) !== false) {
	//now $data is one line of the file
	
	if($data=="\n") {
	//data is end of package, time to add it to the database
	//dfg get dependencies and conflicts
	$Date = date("m.d.y");
	$Source = GetRealSource($file); //TODO: fix this
	$AllDepends = GetAllDepends($Package);
$numpacks +=1;
if (($numpacks-$oldpacks) == 500) {
$oldpacks = $numpacks;
echo $numpacks."\n";
mysql_query("UPDATE  `lima_main`.`system` SET  `value` =  '$numpacks' WHERE  `system`.`property` =  'ReloadProgress'");
}

//echo $numpacks."\n";
$check=mysql_query("SELECT `Version` FROM `packages` WHERE `Package`='$Package'");
if(!$check || mysql_num_rows($check)==0) {
//echo  "SELECT `Version` FROM `packages` WHERE  `Package`='$Package'";
$query="INSERT INTO  `packages` (
`Package` ,
`Source` ,
`Version` ,
`Section` ,
`Maintainer` ,
`AllDepends` ,
`Conflicts` ,
`Filename` ,
`Size` ,
`Installed-Size` ,
`MD5sum` ,
`Compatibility` ,
`Description` ,
`Name` ,
`Author` ,
`Website` ,
`Depiction` ,
`Date`
)
VALUES (
'$Package',  '$Source',  '$Version',  '$Section',  '$Maintainer',  '$AllDepends',  '$Conflicts',  '$Filename',  '$Size',  '$InstalledSize',  '$MD5sum',  '$Compatibility',  '$Description',  '$Name',  '$Author', '$Website',  '$Depiction',  CURDATE()
);";
} else {
//echo $check;
if(mysql_result($check, 0, "Version")!=$Version) 
{
//package needs update
$query="UPDATE `packages` SET `Source`='$Source',`Version`='$Version',`Section`='$Section',`Maintainer`='$Maintainer',`AllDepends`='$AllDepends',`Conflicts`='$Conflicts',`Filename`='$Filename',`Size`='$Size',`Installed-Size`='$InstalledSize',`MD5sum`='$MD5sum',`Compatibility`='$Compatibility',`Description`='$Description',`Name`='$Name',`Author`='$Author',`Website`='$Website',`Depiction`='$Depiction' WHERE `Package`='$Package'";
} else {
$exec=false;
}
}
if($exec) {mysql_query($query) or die(mysql_error()); }
$exec=true;
$Author="";
$Website="";
$Depiction="";
$Description="";
$MD5sum="";
$Size="";
$InstalledSize="";
$Name="";
$Maintainer="";
	} else {
	//get data ready for database
	$data = str_replace("limacache", "", $data);
	$data = str_replace("\r","",$data);
	$data = str_replace("\n","",$data);
	$data = mysql_real_escape_string($data);
	//extract the package information
	if(con($data, "Package: ")) {
	$Package = str_replace("Package: ", "", $data);
if($Name=="") { $Name=$Package; }	
} elseif(con($data, "Version: ")) {
	$Version = str_replace("Version: ", "", $data);
	} elseif(con($data, "Section: ")) {
	$Section = str_replace("Section: ", "", $data);
        $Section = str_replace("_", "", $Section);
	} elseif(con($data, "Maintainer: ")) {
	$Maintainer = str_replace("Maintainer: ", "", $data);
	} elseif(con($data, "Filename: ")) {
	$Filename = str_replace("Filename: ", "", $data);
	} elseif(con($data, "Size: ") && !con($data, "Installed-Size: ")) {
	$Size = trim(str_replace("Size: ", "", $data));
	} elseif(con($data, "Installed-Size: ")) {
	$InstalledSize = trim(str_replace("Installed-Size: ", "", $data));
	} elseif(con($data, "MD5sum")) {
	$MD5sum = str_replace("MD5sum: ", "", $data);
	} elseif(con($data, "Description: ")) {
	$Description = str_replace("Description: ", "", $data);
	} elseif(con($data, "Name: ")) {
	$Name = str_replace("Name: ", "", $data);
	} elseif(con($data, "Author: ")) {
	$Author = str_replace("Author: ", "", $data);
	} elseif(con($data, "HomePage: ") || con($data, "Website: ")) {
	$Website = str_replace("Homepage: ", "", $data);
	$Website = str_replace("Website: ", "", $Website);
	} elseif(con($data, "Depiction: ")) {
	$Depiction = str_replace("Depiction: ", "", $data);
	} elseif(con($data, "Conflicts: ")) {
	$Conflicts = str_replace("Conflicts: ", "", $data);
	} 
	
	
	}
	}
   }
   fclose($handlez);
  } 
}
echo $numpackages;
mysql_query("UPDATE `system` SET `value`=CURDATE() WHERE `property`='LastReload'");
?>
