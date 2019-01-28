<?php
include("./config/dbinfo.php");
include("./includes/theme.php");
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("true"); 
mysql_select_db("lima_main");
$mysql=true;
require('./includes/security.php');
$section=$_GET['q'];
$num=$_GET['n'];
if($_GET['t']=="search")
{
    $searchterms = $_GET['q'];
                    $results=array();
                    if ($searchterms && ($searchterms != " ")) {
//initial search
                        $query = "SELECT `Package`, `Name`, `Description`,`Filename` FROM  `packages` WHERE `Package` LIKE '$searchterms' union all SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE  `Name` LIKE  '%$searchterms%' UNION all SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE `Package` LIKE  '%$searchterms%' AND `Name` not LIKE  '%$searchterms%' LIMIT 0, $num";
                        $result = mysql_query($query) or die("db error");
                        $num = mysql_numrows($result);
                        $i = 0;
                        while ($i < $num) {
                            $packdetails['name'] = mysql_result($result, $i, "Name");
                            $packdetails['package'] = mysql_result($result, $i, "Package");
                            $packdetails['description'] = mysql_result($result, $i, "Description");
                            $packdetails['paid'] = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
                            $results[]=$packdetails;
                            $i++;
                        }
//second search
                        $query = "SELECT `Package`, `Name`, `Description`, `Filename` FROM  `packages` WHERE `MD5sum` LIKE  '%$searchterms%' OR `Description` LIKE  '% $searchterms %' OR `Author` LIKE  '%$searchterms%' LIMIT 0, $num";
                        $result = mysql_query($query) or die("db error");
                        $num = mysql_numrows($result);
                        mysql_close();
                        $i = 0;
                        while ($i < $num) {
                            $packdetails['name'] = mysql_result($result, $i, "Name");
                            $packdetails['package'] = mysql_result($result, $i, "Package");
                            $packdetails['description'] = mysql_result($result, $i, "Description");
                            $packdetails['paid'] = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
                            $results[]=$packdetails;
                            $i++;
                        }
                        if($num<50)
                        {
                            $nz=$num;
                        } else 
                        {
                            $nz=49;
                        }
                        for($i=($num-$nz);$i<$num;$i++)
                        {
                            $packdetails=$results[$i];
                            if($packdetails)
                            {
                           package($packdetails['name'],"package.php?q=".$packdetails['package'],$packdetails['description'],$packdetails['paid'],"",true);
                        } else {
                                break;
                                $done = true;
                            }
                           
                        }
                    }
                    $num +=50;
                    if(!$done && ($num<50))
                        {
                    package("More","javascript:loadMore($num)","Load more results",false,"morebutton",true);
                        }
} else {
$query="SELECT Name, Package, Description, Filename FROM  `packages` WHERE  `Section` = \"$section\" ORDER BY `Name` ASC LIMIT $num, 50";
$result=mysql_query($query) or die();

$numz=mysql_numrows($result);

mysql_close();



$i=0;
while ($i < $numz) {

$name =  mysql_result($result,$i,"Name");
$package = mysql_result($result,$i,"Package");
$description = mysql_result($result,$i,"Description");
$paid = stristr(mysql_result($result,$i,"Filename"), "cydiastore");
package($name,"package.php?q=$package",$description,$paid,"", true);
$i++;
}
if($i==50)
{
package("More","javascript:loadMore(".($num+50).")","Load more packages",false,"morebutton",true);
}
}
?>
