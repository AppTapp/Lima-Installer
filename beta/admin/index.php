<!DOCTYPE html> 
<html> 
    <head> 
        <title>Welcome</title> 
        <?php 
        $mysql=false;
        include('../includes/header.php'); 
        ?>
    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>Monkey district</h1>
            </div><!-- /header -->

            <div data-role="content">	
                <h1>Lima admin</h1>
                <i>Hello there server monkeys, Lima administrator or random hacker.</i>
                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="f"> 
              
                    <li><a href="sendinvite.php" rel="external">Send out invites</a></li> 
                    <li><a href="error.php" rel="external">Decode error log</a></li> 
                    <li><a href="status.php">Network status</a></li> 
                     <li><a href="status.php">Reloading data status</a></li> 
                     <li><a href="mail.php">Support</a></li> 
                 <li><a href="gen5.php" rel="external">Generate 5 invite codes</a></li> 
                </ul> 
          
            </div><!-- /content -->
            
        </div><!-- /footer -->
    </div><!-- /page -->

</body>
</html>

