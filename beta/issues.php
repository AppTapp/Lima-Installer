<!DOCTYPE html> 
<html> 
    <head> 
        <title>Welcome</title> 
        <?php
        $mysql = false;
        include('./includes/header.php');
        ?>
    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>Welcome</h1>
            </div><!-- /header -->

            <div data-role="content">	
   <h2>Having trouble?</h2>
If you're having any issues with lima or have any general questions send an email to support@limainstaller.com
            </div>
            <div data-role="footer" data-position="fixed">
                <div data-role="navbar">
                    <ul>
                        <li><a href="index.php"  class="ui-btn-active">Home</a></li>
                        <li><a href="sections.php">Sections</a></li>
                        <li><a href="search.php">Search</a></li>
                        <li><a href="more.php">More</a></li>

                    </ul>

                </div><!-- /navbar -->
            </div><!-- /footer -->
        </div><!-- /page -->

    </body>
</html>