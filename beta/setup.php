<!DOCTYPE html> 
<html> 
    <head> 
        <title>Setup</title> 
        <?php
        include('./includes/header.php');
        include './config/tokens.php';
        $ip = "127.0.0.1";
        $userip = $_SERVER['REMOTE_ADDR'];
        $base = $userip . ":" . $secureToken . ":" . $secretToken;
        $magichash = sha256($base);
        ?>

        <script type="text/javascript">
            function setCookie(c_name,value,exdays)
            {
                var exdate=new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                document.cookie=c_name + "=" + c_value;
            }
            function setup() {
                var rurl = "http://<?php echo $ip; ?>:1337/A=<?php echo $secureToken; ?>/B=0/C=setup/D=<?php echo $magichash ?>/END/";
                var resultd = "PLUGIN_ERROR";
                $.ajax({ async:false, url: rurl,
                    success: function(data){
                        resultd = data;
                    }
                });
                if(resultd=="PLUGIN_ERROR") {
                    alert('it seems like you don\'t have the lima plugin installed :(');
                } else if(resultd=="DENIED") {
                    alert('You didn\'t give us permission to install packages on your device, so we can\'t do that :(');
                } else {
                    setCookie("uniqueid", resultd, 3650);
                    alert('setup successfull!');
                    window.location = '<?php echo $_SERVER['HTTP_REFERER']; ?>';
                }
            }

        </script>
    </head> 
    <body> 

        <div data-role="page">

            <div data-role="header">
                <h1>Welcome</h1>
            </div><!-- /header -->

            <div data-role="content">	
                <h2>Setup</h2>
                <i>Before you can use Lima to install packages on your device, you need to setup a few things. Make sure the Lima plugin is installed on your device and then tap the setup button to finish the setup. </i>

                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="f"> 
                    <li><a href="javascript:setup();">Authorize device</a></li> 
                </ul> 
            </div><!-- /content -->
            <div data-role="footer" data-position="fixed">

            </div><!-- /footer -->
        </div><!-- /footer -->
    </div><!-- /page -->

</body>
</html>