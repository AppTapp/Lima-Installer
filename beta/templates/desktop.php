<?php

function top($title, $back = false, $install = false) {
    if ($install) {
        $install = "<div class=\"btn-group pull-right\">
            <a class=\"btn dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
              <i class=\"icon-user\"></i> Install to...
              <span class=\"caret\"></span>
            </a>
            <ul class=\"dropdown-menu\">
              <li><a href=\"javascript:document.forms['installation'].submit()\">Test iPhone</a></li>
              <li class=\"divider\"></li>
              <li><a href=\"#\">Justin's iPod</a></li>
            </ul>
          </div>";
    }

    if (stristr($_SERVER['REQUEST_URI'], "index.php")) {
        $index = " class=\"active\"";
    }
    if (stristr($_SERVER['REQUEST_URI'], "sections.php")) {
        $sections = " class=\"active\"";
    }
    if (stristr($_SERVER['REQUEST_URI'], "search.php")) {
        $search = " class=\"active\"";
    }
    if (stristr($_SERVER['REQUEST_URI'], "more.php")) {
        $more = " class=\"active\"";
    }
    if ($back) {
        //$back = "<div class=\"btn-group pull-left\"><button onclick=\"history.go(-1)\" class=\"btn\">Back</button></div>";
    }

    echo "<div class=\"navbar navbar-fixed-top\">
      <div class=\"navbar-inner\">
        <div class=\"container\">
          <a class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
          </a>
          <a class=\"brand\" href=\"#\">$title</a>$install
          <div class=\"nav-collapse\">
    <ul id=\"itembar\" class=\"nav\">
      <li$index><a href=\"index.php\">Home</a></li><li$sections><a href=\"sections.php\">Sections</a></li><li$search><a href=\"search.php\">Search</a></li><li$more><a href=\"more.php\">More</a></li>
    </ul>      
    </div>
        </div>
      </div>
    </div><div class=\"container\"></br></br></br>";
}

function package($name, $link, $description, $paid = false, $id = "") {
    if ($paid) {
       $paid=" (paid)";
    }
    if ($id != "") {
        $id = " id=\"$id\"";
    }
   echo "<div$id><a href=\"$link\"><div class=\"span3\"><div class=\"well\">$name$paid</br></a><i>" . substr($description, 0, 50) . "...</i></div></div></div>";
}

function foot($nobar = false) {
    echo "</div>";
    echo "</div></div>";
}

function listview($search, $inset, $id = "") {
    if ($id)
        $id = " id=\"$id\"";
    echo "<div $id>";
}

function section($name, $link, $external = false) {
    echo "<a href=\"$link\"><div class=\"span3\"><div class=\"well\">$name</div></div></a>";
}

function info($property, $value) {
    echo "<div class=\"span3\"><div class=\"well\"><b>$property</b><dd>$value</dd></div></div>";
}

function infotext($text) {
    //echo "<dd><i>$text</i></dd>";
}

function bighead($text, $size = 1) {
    // echo "<span class=\"graytitle\"><dd><h$size>$text</h$size></dd></span>";
}

?>
