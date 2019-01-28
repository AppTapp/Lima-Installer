<!DOCTYPE html> 
<html> 
    <head> 
        <title>Setup</title> 
        <?php
        include('./includes/header.php');
        ?>

        <script type="text/javascript">
function gotIp(ip)
{
    //search for devices
    splitip = ip.split('.');
    startrange = splitip[0] + "." + splitip[1] + "." + splitip[2] + ".";
    for(i=0; i<255;i++)
        {
            rurl= "http://" + startrange + i + ":1337/A=test/B=0/C=0/D=0/END/";
            $.ajax({ async:false, url: rurl,
                    success: function(data){
                        alert(i);
                    }
                });
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
<applet code="MyAddress.class" mayscript="true" width="0" height="0"><param name="status" value="" /><param name="call" value="gotIp" /></applet>
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
