

<?php
require('./beta/config/dbinfo.php');
mysql_connect($dbz_host, $dbz_user, $dbz_pass) or die("Database connection error"); 
mysql_select_db("lima_main");
require('./beta/includes/security.php');
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$name=$_POST['name']; 
$email=$_POST['email'];
//check captcha
if (empty($_POST['captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']) 
{
$error .= "<div class=\"alert alert-block alert-error fade in\">
            <button class=\"close\" data-dismiss=\"alert\">×</button>
            <h4 class=\"alert-heading\">Please enter the security code correctly</h4></div>";
} 
if(strlen($name)<1 || strlen($name)>20)
{
$error .= "<div class=\"alert alert-block alert-error fade in\">
            <button class=\"close\" data-dismiss=\"alert\">×</button>
            <h4 class=\"alert-heading\">Please enter a valid name!</h4></div>";

}
if(strlen($email)<1 || strlen($email)>40 || (!stristr($email, "@")) || (!stristr($email, ".")))
{
$error .= "<div class=\"alert alert-block alert-error fade in\">
            <button class=\"close\" data-dismiss=\"alert\">×</button>
            <h4 class=\"alert-heading\">Please enter a valid email!</h4></div>";

}
//check if email exists
$res=mysql_query("SELECT * FROM `signups` WHERE `email`='$email'");
if(mysql_num_rows($res) != 0)
{
$error .= "<div class=\"alert alert-block alert-error fade in\">
            <button class=\"close\" data-dismiss=\"alert\">×</button>
            <h4 class=\"alert-heading\">This email is registered already, no need to register again</h4></div>";

}
unset($_SESSION['captcha']);




if(!$error) {
//pop it into the database
$ip=$_SERVER['REMOTE_ADDR'];
$date= date("m.d.y");
mysql_query("INSERT INTO `signups`(`name`, `email`, `ip`, `date`, `icode`) VALUES ('$name','$email','$ip','$date','NONE')") or die(file_get_contents("403.shtml"));
$note .= "<div class=\"alert alert-info\">
            <strong>Success!</strong> You have requested an invite for the Lima beta
          </div>";
		  $email="";
		  $name="";
		  
		  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Lima is here!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
	  p.slightlybigger {font-size:13px;}
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

<body>
<div class="container">
<center><h1>Register to beta test Lima!</h1></center>
</br>
<?php echo $error; echo $note; ?>
<form class="form-horizontal" method="POST" action="register.php">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="name">Name</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $name; ?>">
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="email">Email</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="email" name="email" value="<?php echo $email; ?>">
			<p class="help-block">We don't spam! :)</p>
			  </div>
          </div>
		  <div class="control-group">
		  <img src="./captcha.php" id="captchaimg" />
            <label class="control-label" for="captcha">Security code</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="captcha" name="captcha">
            </div>
          </div>
         
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Request invite!</button>
          </div>
        </fieldset>
      </form>
	  </div>
	  <script>
	  var pic = document.getElementById("captchaimg");
	  pic.src="captcha.php";
	  pic.style="";
	  </script>
	  </body>
	  </html>