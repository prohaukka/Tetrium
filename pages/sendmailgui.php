<?php
include "includes/databasedetails.php";

?>


<html>
<head>
    <link rel="stylesheet" href="style/tetriumstyle.css" type="text/css" media="screen, projection"/>
    <title>Send Mail</title>
</head>
<body onfocus="onfocus()" onblur="onblur()">
<?php
//include database login and update resources
include "executables/start_logic.php";
?>

<!-- CSS GUI BEGINS -->
<center>
    <div id="wrapper">

        <!-- HEADER -->
        <?php include("includes/tetriumheader.php") ?>
        <!-- HEADER -->

        <div id="middle">
            <div id="container">
                <div id="content">


                    <br><br><br>

                    <!-----------------------------------------
                    This is the MESSAGE function
                    ----------------------------------------->
                    <form name=mail action=executables/func_start.php id=mail method=POST>
                        Receiver: <textarea rows=1 cols=40 id=receiver name=receiver></textarea><br>
                        Subject: <textarea rows=1 cols=40 id=subject name=subject></textarea><br>
                        Message: <textarea rows=20 cols=50 id=message name=message></textarea><br>
                        <input type="hidden" value="send_mail">
                        <input type=submit value=Send>
                    </form>


                    <!-----------------------------------------
                    This is the end of the MESSAGE function
                    ----------------------------------------->
                    <br>
                    <br>
                    <div id="uppgrades"><!-- #uppgrades -->
                        <?php
                        include "includes/buildingtimer.php";
                        ?>
                    </div><!-- #uppgrades -->


                </div><!-- #content-->
            </div><!-- #container-->

            <!-- SIDEBARS AND FOOTER -->

            <?php $map2 = true;
            include("includes/tetriumsidebarsandfooter.php");
            ?>
            <!-- SIDEBARS AND FOOTER -->

        </div><!-- #wrapper -->
</center>

<?php include("includes/tetriumjavascript.php"); ?>

</body>
</html>