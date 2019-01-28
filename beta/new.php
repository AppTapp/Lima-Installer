<!DOCTYPE html> 
<html> 
	<head> 
	<title>What's new</title> 
<?php 
$mysql=false;
include('./includes/header.php'); 
?>
</head> 
<body> 

<?php top("What's new", true); ?>
<p>New in this version of Lima:
<ul>
<li>Search as you type</li>
<li>New improved dependency/conflict handeling system</li>
<li>New device authorization process</li>
<li>Plugin is now ready for over the air installations</li>
</ul></p>
</br>
<p>Bug fixes:
<ul>
<li>Search now loads 50 results at a time instead of all results which was causing crashes.</li>
<li>Package updates now correctly shows updates</li>
<li>Multiple dependency/conflict handling fixes</li>
<li>Multiple gui bugs got fixed</li>
</ul></p>
</br>
<p>Coming soon in Lima:
<ul>
<li>Choose which sections to enable</li>
<li>Over the air installations</li>
<li>Custom themes</li>
<li>Choose custom software sources/repositories</li>
<li>Multiple other user preferences</i>
</ul></p>
<i>note: this is not a full list of changes</i>
</body>
</html>