<?php
function top($title, $back = false,$install=false) {
    if($back && !is_numeric($back)) $back=1;
if($install) $install="<a id=\"installbutton\" href=\"javascript:document.forms['installation'].submit()\">Install</a>";
    echo "<div data-role=\"page\" id=\"mainpage\"><div data-role=\"header\">";
    if ($back) {
        echo "<a href=\"javascript:history.go(-$back)\" class=\"ui-btn-left ui-btn ui-btn-corner-all ui-shadow ui-btn-hover-a ui-btn-up-a\" data-theme=\"a\"><span class=\"ui-btn-inner ui-btn-corner-all\"><span class=\"ui-btn-text\">Back</span></span></a>";
    }
    echo "<h1>$title</h1>$install</div><div data-role=\"content\">";
}

function package($name, $link, $description, $paid = false, $id="", $preparsed=false) {
    if ($paid) {
        $style = "style=\"color:#547c9b\"";
    }
    if($id != "")
    {
    $id= " id=\"$id\"";
    }
    if(!$preparsed)
    {
    echo "<li$id><a href=\"$link\" rel=\"external\" class=\"ui-link-inherit\"><h3 class=\"ui-li-heading\" $style>$name</h3><p class=\"ui-li-desc\">$description</p></a></li>";
    } else {
    echo "<li $id class=\"ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c\" data-theme=\"c\" data-corners=\"false\" data-shadow=\"false\" data-iconshadow=\"true\" data-icon=\"arrow-r\" data-iconpos=\"right\" data-wrapperels=\"div\"><div class=\"ui-btn-inner ui-li\"><div class=\"ui-btn-text\">
    <a class=\"ui-link-inherit\" href=\"$link\" rel=\"external\">
<h3 class=\"ui-li-heading\"$style>$name</h3><p class=\"ui-li-desc\">$description</p></a></div><span class=\"ui-icon ui-icon-arrow-r ui-icon-shadow\">&nbsp;</span></div></li>"; 
   
        
    }
    
}
function foot($nobar=false) {
echo "</div>";
if(!$nobar) {   if(stristr($_SERVER['REQUEST_URI'],"index.php")) { $index = " class=\"ui-btn-active\""; }
    if(stristr($_SERVER['REQUEST_URI'],"sections.php")) { $sections = " class=\"ui-btn-active\""; }
    if(stristr($_SERVER['REQUEST_URI'],"search.php")) { $search = " class=\"ui-btn-active\""; }
    if(stristr($_SERVER['REQUEST_URI'],"more.php")) { $more = " class=\"ui-btn-active\""; }
    echo "<div data-role=\"footer\" data-position=\"fixed\">
	  <div data-role=\"navbar\"><ul>
          <li><a href=\"index.php\"$index>Home</a></li>
          <li><a href=\"sections.php\"$sections>Sections</a></li>
	  <li><a rel=\"external\" href=\"search.php\"$search>Search</a></li>
	  <li><a href=\"more.php\"$more>More</a></li></ul></div></div>";
}
echo "</div>";
}
function listview($search, $inset, $id="")
{
    if($search) $search=" data-filter=\"true\"";
    if($inset)  $inset=" data-inset=\"true\"";
    if($id)     $id=" id=\"$id\""; 
    echo "<ul data-role=\"listview\"".$search.$inset.$id.">";
}
function section($name, $link, $external=false)
{
if($external) $external="rel=\"external\"";
    echo "<li><a href=\"$link\"$external>$name</a></li>"; 
}
function info($property,$value)
{
echo "<li>$property<span class=\"ui-li-count ui-btn-up-c ui-btn-corner-all\">$value</span></li>";
}
function infotext($text)
{
   echo "<i>$text</i>";
}
function bighead($text,$size=1)
{
    echo "<h$size>$text</h$size>";
}
?>
