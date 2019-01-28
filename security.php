<?
// This File Was Created By: 4rCt1cF1r3
// Its Supposed To Escape All The $_POST's And $_GET's
// Or Escape A Certain Stirng...


// Escape All
// $method: "get" for $_GET, "post" for $_POST, "both" for $_GET and $_POST
// Set $return to true to return the escaped string


function escapeall($method="both", $return=false) {
	$mVal = Array();
	if($method == "get" || $method == "both") {
		foreach ($_GET As $IdentG => $Value) {
			$_GET[$IdentG] = escape($Value);
			if($return) $mVal[$IdentG] = escape($Value);
		}
	}
	if($method == "post" || $method == "both") {
		foreach ($_POST As $IdentP => $Value) {
			$_POST[$IdentP] = escape($Value);
			if($return) $mVal[$IdentP] = escape($Value);
		}
	}
	if($return) return $mVal;
}
// Escape All Alternate
// $method: "get" for $_GET, "post" for $_POST, "both" for $_GET and $_POST
// Set $return to true to return the escaped string
function escapealla($method="both", $cmd="escape", $return=false) {
	$mVal = Array();
	if($method == "get" || $method == "both") {
		foreach ($_GET As $IdentG => $Value) {
			$_GET[$IdentG] = call_user_func_array($cmd, Array($Value));
			if($return) $mVal[$IdentG] = call_user_func_array($cmd, Array($Value));
		}
	}
	if($method == "post" || $method == "both") {
		foreach ($_POST As $IdentP => $Value) {
			$_POST[$IdentP] = call_user_func_array($cmd, Array($Value));
			if($return) $mVal[$IdentP] = call_user_func_array($cmd, Array($Value));
		}
	}
	if($return) return $mVal;
}

// Escape All $_GET
// Set $return to true to return the escaped string(s)
function escapeallget($return=false) {
	$mVal = Array();
	foreach ($_GET As $IdentG => $Value) {
		$_GET[$IdentG] = escape($Value);
		if($return) $mVal[$IdentG] = escape($Value);
	}
	if($return) return $mVal;
}

// Escape Specified
// $Input Is What U Want Escaped
// Set $Retrun To True To Return Var, False To Just Set The Var
function escape($Input, $Return=true) {
	$Output = strip_tags($Input);
	$Output = stripslashes($Output);
	$Output = mysql_real_escape_string($Output);
	$Output = eregi_replace("`", "", $Output);
	return $Output;
}

// Escape Specified Alternate
// $Input Is What U Want Escaped
// Set $Retrun To True To Return Var, False To Just Set The Var
function escapea($Input, $Return=true) {
	$Output = strip_tags($Input);
	//$Output = stripslashes($Output);
	$Output = mysql_real_escape_string($Output);
	$Output = eregi_replace("`", "", $Output);
	return $Output;
}


// Escape All Specified Array
// Set $return to true to return the escaped string(s)
function escapeallr($Input, $return=false) {
	$mVal = Array();
	foreach ($Input As $Ident => $Value) {
		$Input[$Ident] = escape($Value);
		if($return) $mVal[$Ident] = escape($Value);
	}
	if($return) return $mVal;
}
escapeall();
?>