<html>
<head>
<?php 
include('./includes/header.php');
?>
<script>
alert('testing Lima service step 1/2');
var rurl = "http://Marks-iPad.local:1337/A=<?php echo $secureToken; ?>/B=<?php echo $uniqueid; ?>/C=test/D=0/END/";
var resultd = "PLUGIN_ERROR";
$.ajax({ async:false, url: rurl,
success: function(data){
resultd=data;
}
});
if(resultd != "PLUGIN_ERROR") {
alert('testing Lima service step 2/2: Lima service is running, test result: ' + resultd);
} else {
alert('testing Lima service step 2/2: Lima service is NOT running');
}
</script>
</head>
</html>