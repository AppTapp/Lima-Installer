<?php
function top($title, $back = false,$install=false) {
if($install) $install="<div id=\"rightbutton\"><a id=\"installbutton\" href=\"javascript:document.forms['installation'].submit()\">Install</a></div>";
    echo "<div id=\"topbar\">";
    if ($back) {
        echo "<div id=\"leftbutton\"><a href=\"javascript:history.go(-1)\" class=\"noeffect\">Back</a></div>";
    }
    echo " <div id=\"title\">$title</div>$install</div><div id=\"content\">";
}

function package($name, $link, $description, $paid = false, $id="") {
    if ($paid) {
        $style = "style=\"color:#0000FF\"";
    }
    if($id != "")
    {
    $id= " id=\"$id\"";
    }
echo "<li class=\"menu\"$id><a href=\"$link\"><span class=\"name\"$style>$name</span><span class=\"arrow\"></span></a></li>";
}
function foot($nobar=false) {
echo "</div>";
if(!$nobar) {   if(stristr($_SERVER['REQUEST_URI'],"index.php")) { $index = " id=\"pressed\""; }
    if(stristr($_SERVER['REQUEST_URI'],"sections.php")) { $sections = " id=\"pressed\""; }
    if(stristr($_SERVER['REQUEST_URI'],"search.php")) { $search = " id=\"pressed\""; }
    if(stristr($_SERVER['REQUEST_URI'],"more.php")) { $more = " id=\"pressed\""; }
echo "<div id=\"tributton\"> <div class=\"links\"> <a href=\"index.php\"$index>Home</a><a href=\"sections.php\"$sections>Sections</a><a href=\"search.php\"$search>search</a></div> </div>";
    echo "<div id=\"tributton\"> <div class=\"links\"> <a href=\"more.php\">More</a><a href=\"updates.php\">Updates</a><a href=\"installedpackage.php\">Installed</a></div> </div>";

}
echo "</div>";
}
function listview($search, $inset, $id="")
{
    if($id)     $id=" id=\"$id\""; 
    echo "<ul class=\"pageitem\"$id>";
}
function section($name, $link, $external=false)
{
echo "<li class=\"menu\"><a href=\"$link\"><span class=\"name\">$name</span><span class=\"arrow\"></span></a></li>";
}
function info($property,$value)
{
echo "<li class=\"menu\"><span class=\"name\">$property</span><span class=\"comment\">$value</span></li>";
}
function infotext($text)
{
   echo "<dd><i>$text</i></dd>";
}
function bighead($text,$size=1)
{
    echo "<span class=\"graytitle\"><dd><h$size>$text</h$size></dd></span>";
}
?>
