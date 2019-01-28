<?php
//DO NOT EDIT//

function GenerateURL($downloadlinksarray) {
$softwarestate = "beta"; //disable this as soon as beta testing is over
$finalurl = "https://limainstaller.com/$softwarestate/api/install.php";
foreach($downloadlinksarray as $link) {
$packages .= $link.",";
}
$html = '<form name="installation" action="'.$finalurl.'" method="POST"><input type="hidden" name="magichash" value="" /><input type="hidden" name="Packages" value="'.$packages.'" /></form>';
return $html;
}
//DO NOT EDIT//


//basic api usage
/* 

put this php script inside the body of your html page, doesn't matter where

<?php
$downloadlinks = array();
$downloadlinks[] = "http://example.com/package1.deb";
$downloadlinks[] = "http://example.com/packages2.deb";
echo GenerateURL($downloadlinks);
?> 

this will place a simple hidden form on your page, then put down an install button like this:
<a id="installbutton" href="javascript:document.forms['installation'].submit()">Install</a>

optional feature coming soon is to check if the user has the lima plugin installed

*/

?>