<style type="text/css">
    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        margin: 0px auto;
    }

    .tg td {
        font-family: Arial, sans-serif;
        font-size: 14px;
        padding: 0px 0px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
    }

    .tg th {
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        padding: 0px 19px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
    }

    .tg .tg-w6cq {
        font-family: Tahoma, Geneva, sans-serif !important;;
        background-color: #fd6868
    }

    .tg .tg-mfgs {
        font-family: Tahoma, Geneva, sans-serif !important;;
        background-color: #94d180
    }

    .tg .tg-w6cu {
        font-family: Tahoma, Geneva, sans-serif !important;;
        background-color: #BEBEB6
    }

    .tg .tg-w6cr {
        font-family: Tahoma, Geneva, sans-serif !important;;
        background-color: #8585E0
    }
    .tg .tg-reinf {
        font-family: Tahoma, Geneva, sans-serif !important;;
        background-color: #ad79ff
    }

    .tg .tg-gmhj {
        font-family: Tahoma, Geneva, sans-serif !important;;
        min-width: 70px
    }

    table, th, td {
        border: 1px solid black;
    }
</style>

<?php
$date = date_create();
?>

<script>
    var real_load_server_epoch = <?php echo date_timestamp_get($date).";";?>
    var fake_epoch = new Date();
    fake_epoch = ((fake_epoch.getTime() - fake_epoch.getMilliseconds()) / 1000);
    var epoch_offset = fake_epoch - real_load_server_epoch;

    function mission_secondsdate_timer_editon(seconds) {

        var numdays = Math.floor(seconds / 86400);
        var numhours = Math.floor((seconds % 86400) / 3600);
        var numminutes = Math.floor(((seconds % 86400) % 3600) / 60);
        var numseconds = ((seconds % 86400) % 3600) % 60;

        var lenght_s = numseconds.toString().length;
        var lenght_m = numminutes.toString().length;
        var lenght_h = numhours.toString().length;

        if (lenght_s == 1) {
            numseconds = "0" + numseconds;
        }
        if (lenght_m == 1) {
            numminutes = "0" + numminutes;
        }
        if (lenght_h == 1) {
            numhours = "0" + numhours;
        }

        if (numdays == 0 && numhours == 0 && numminutes == 0) {
            return " 00:00:" + numseconds + " hrs.";
        }
        if (numdays == 0 && numhours == 0) {
            return " 00:" + numminutes + ":" + numseconds + " hrs.";
        }

        if (numdays == 0) {
            return " " + numhours + ":" + numminutes + ":" + numseconds + " hrs.";
        } else {
            return numdays + " days " + numhours + ":" + numminutes + ":" + numseconds + " hrs.";
        }
    }
</script>

<!-- CSS GUI BEGINS -->
<center>
    <br><br>

    <?php
    /*-----------------------------------------
    This is the SHOW ALL MISSIONS function
    -----------------------------------------*/
    foreach ($all_user_villages_ids as $user_village_id) {
        $result = mysql_query("SELECT village FROM map WHERE village_id='$user_village_id'");
        while ($row = mysql_fetch_array($result)) {
            $villagename = $row['village'];
            echo "<h2>", $villagename, "</h2>";
        }

        $result = mysql_query("SELECT * FROM events WHERE village_id='$user_village_id' OR target_village='$user_village_id'") or die(mysql_error());
        $x = mysql_num_rows($result);

        while ($x > 0) {
            $x_subtract_one = $x - 1;
            $result = mysql_query("SELECT * FROM events WHERE  (village_id='$user_village_id' or target_village='$user_village_id') ORDER BY type DESC LIMIT $x_subtract_one,1 ") or die(mysql_error());

            while ($row = mysql_fetch_array($result)) {
                $mission_type = $row['type'];
                $mission_completed = $row['completed'];
                $mission_building = $row['building'];
                $mission_nextlevel = $row['nextlevel'];
                $mission_troop_type = $row['troop_type'];
                $mission_amount = $row['amount'];
                $mission_target = $row['target'];
                $mission_wood = $row['wood'];
                $mission_clay = $row['clay'];
                $mission_iron = $row['iron'];
                $mission_wheat = $row['wheat'];
                $mission_clubswinger = $row['clubswinger'];
                $mission_spearman = $row['spearman'];
                $mission_axeman = $row['axeman'];
                $mission_scouthorse = $row['scouthorse'];
                $mission_knighthorse = $row['knighthorse'];
                $mission_warhorse = $row['warhorse'];
                $mission_id = $row['id'];
                $mission_userid = $row['userid'];
                $mission_target_village = $row['target_village'];
                $mission_village_id = $row['village_id'];
                $mission_returning = $row['returning'];
                $mission_return_completed = $row['return_completed'];
            }

            $result = mysql_query("SELECT village FROM map WHERE village_id='$mission_village_id'");
            while ($row = mysql_fetch_array($result)) {
                $mission_villagename = $row['village'];
            }
            $result = mysql_query("SELECT village FROM map WHERE village_id='$mission_target_village'");
            while ($row = mysql_fetch_array($result)) {
                $mission_target_villagename = $row['village'];
            }
            $result = mysql_query("SELECT username FROM members WHERE id='$mission_target'");
            while ($row = mysql_fetch_array($result)) {
                $mission_target_player = $row['username'];
            }
            $result = mysql_query("SELECT username FROM members WHERE id='$mission_userid'");
            while ($row = mysql_fetch_array($result)) {
                $mission_player = $row['username'];
            }

        //SHOW ALL ATTACKS ECCEPT THE ONES THAT (target you AND are returning)
        if ($mission_type == "attack" and ($mission_village_id == $user_village_id or $mission_returning == 0)){
            if ($mission_returning == 0 and $mission_village_id != $user_village_id){
                ?>
                <br>
            <table class="tg" style="min-width: 330px; text-align: center;">
                <tr>
                    <th class="tg-w6cq" colspan="7">Incoming attack from <?php echo $mission_villagename; ?>
                        (<?php echo $mission_player; ?>)<br></th>
                </tr>
                <tr>
                    <td class="tg-gmhj"><br></td>
                    <td class="tg-gmhj">Clubs</td>
                    <td class="tg-gmhj">Spears</td>
                    <td class="tg-gmhj">Axes</td>
                    <td class="tg-gmhj">Scouts</td>
                    <td class="tg-gmhj">Knights</td>
                    <td class="tg-gmhj">Warhorses</td>
                </tr>
                <tr>
                    <td class="tg-gmhj">Troops</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                </tr>
                <tr>
                    <td class="tg-w6cu">Arrival</td>
                    <td class="tg-w6cu" colspan="6">

                        <?php if ($_SESSION["varadmin"] == 1) {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                        } else {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, "<br>";
                        } ?></td>
                </tr>
            </table><?php
            }elseif ($mission_returning == 0 and $mission_village_id == $user_village_id){?>
            <br>
            <table class="tg" style="min-width: 330px; text-align: center;">
                <tr>
                    <th class="tg-mfgs" colspan="7">Attack against <?php echo $mission_target_villagename; ?>
                        (<?php if (empty($mission_target_player)) {
                            echo "Unknown";
                        } else {
                            echo $mission_target_player;
                        } ?>)<br></th>
                </tr>
                <tr>
                    <td class="tg-gmhj"><br></td>
                    <td class="tg-gmhj">Clubs</td>
                    <td class="tg-gmhj">Spears</td>
                    <td class="tg-gmhj">Axes</td>
                    <td class="tg-gmhj">Scouts</td>
                    <td class="tg-gmhj">Knights</td>
                    <td class="tg-gmhj">Warhorses</td>
                </tr>
                <tr>
                    <td class="tg-gmhj">Troops</td>
                    <td class="tg-gmhj"><?php echo $mission_clubswinger; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_spearman; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_axeman; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_scouthorse; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_knighthorse; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_warhorse; ?></td>
                </tr>
                <tr>
                    <td class="tg-w6cu">Arrival</td>
                    <td class="tg-w6cu" colspan="6">
                        <?php if ($_SESSION["varadmin"] == 1) {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                        } else {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, "<br>";
                        } ?></td>
                </tr>
            </table><?php
            }elseif ($mission_returning == 1 and $mission_village_id == $user_village_id){?>
                <br>
                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-mfgs" colspan="7">Returning attack from <?php echo $mission_target_villagename; ?>
                            (<?php if (empty($mission_target_player)) {
                                echo "Unknown";
                            } else {
                                echo $mission_target_player;
                            } ?>)<br></th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Clubs</td>
                        <td class="tg-gmhj">Spears</td>
                        <td class="tg-gmhj">Axes</td>
                        <td class="tg-gmhj">Scouts</td>
                        <td class="tg-gmhj">Knights</td>
                        <td class="tg-gmhj">Warhorses</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Troops</td>
                        <td class="tg-gmhj"><?php echo $mission_clubswinger; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_spearman; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_axeman; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_scouthorse; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_knighthorse; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_warhorse; ?></td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="6">
                            <?php if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            } ?></td>
                    </tr>
                </table>
            <?php
            }
        }











        /*
         * REINFORCEMENTS
         * */
        if ($mission_type == "reinforce" and ($mission_village_id == $user_village_id or $mission_returning == 0)){
            if ($mission_village_id != $user_village_id){
                ?>
                <br>
            <table class="tg" style="min-width: 330px; text-align: center;">
                <tr>
                    <th class="tg-reinf" colspan="7">Incoming reinforce from <?php echo $mission_villagename; ?>
                        (<?php echo $mission_player; ?>)<br></th>
                </tr>
                <tr>
                    <td class="tg-gmhj"><br></td>
                    <td class="tg-gmhj">Clubs</td>
                    <td class="tg-gmhj">Spears</td>
                    <td class="tg-gmhj">Axes</td>
                    <td class="tg-gmhj">Scouts</td>
                    <td class="tg-gmhj">Knights</td>
                    <td class="tg-gmhj">Warhorses</td>
                </tr>
                <tr>
                    <td class="tg-gmhj">Troops</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                    <td class="tg-gmhj">?</td>
                </tr>
                <tr>
                    <td class="tg-w6cu">Arrival</td>
                    <td class="tg-w6cu" colspan="6">

                        <?php if ($_SESSION["varadmin"] == 1) {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                        } else {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, "<br>";
                        } ?></td>
                </tr>
            </table><?php
            }elseif ($mission_village_id == $user_village_id){?>
            <br>
            <table class="tg" style="min-width: 330px; text-align: center;">
                <tr>
                    <th class="tg-reinf" colspan="7">Reinforce to <?php echo $mission_target_villagename; ?>
                        (<?php if (empty($mission_target_player)) {
                            echo "Unknown";
                        } else {
                            echo $mission_target_player;
                        } ?>)<br></th>
                </tr>
                <tr>
                    <td class="tg-gmhj"><br></td>
                    <td class="tg-gmhj">Clubs</td>
                    <td class="tg-gmhj">Spears</td>
                    <td class="tg-gmhj">Axes</td>
                    <td class="tg-gmhj">Scouts</td>
                    <td class="tg-gmhj">Knights</td>
                    <td class="tg-gmhj">Warhorses</td>
                </tr>
                <tr>
                    <td class="tg-gmhj">Troops</td>
                    <td class="tg-gmhj"><?php echo $mission_clubswinger; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_spearman; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_axeman; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_scouthorse; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_knighthorse; ?></td>
                    <td class="tg-gmhj"><?php echo $mission_warhorse; ?></td>
                </tr>
                <tr>
                    <td class="tg-w6cu">Arrival</td>
                    <td class="tg-w6cu" colspan="6">
                        <?php if ($_SESSION["varadmin"] == 1) {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                        } else {
                            echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_completed, "<br>";
                        } ?></td>
                </tr>
            </table><?php
            }
        }








        /*
        RESOURCES
        */
        if ($mission_type == "sendres" and ($mission_village_id == $user_village_id or $mission_returning == 0)){
            if ($mission_returning == 0 and $mission_village_id != $user_village_id){ ?>

                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-w6cr" colspan="5">Incoming trade from <?php echo $mission_villagename; ?>
                            (<?php echo $mission_player; ?>)<br></th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Wood</td>
                        <td class="tg-gmhj">Clay</td>
                        <td class="tg-gmhj">Iron</td>
                        <td class="tg-gmhj">Wheat</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Amount</td>
                        <td class="tg-gmhj"><?php //echo $mission_wood;?>?
                        </td>
                        <td class="tg-gmhj"><?php //echo $mission_clay;?>?
                        </td>
                        <td class="tg-gmhj"><?php //echo $mission_iron;?>?
                        </td>
                        <td class="tg-gmhj"><?php //echo $mission_wheat;?>?
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="4">
                            <?php
                            if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            }?>
                        </td>
                    </tr>
                </table>
                <?php
            }elseif ($mission_returning == 0 and $mission_village_id == $user_village_id){
                ?>
                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-w6cr" colspan="5">Going shipment to <?php echo $mission_target_villagename; ?>
                            (<?php echo $mission_target_player; ?>)<br></th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Wood</td>
                        <td class="tg-gmhj">Clay</td>
                        <td class="tg-gmhj">Iron</td>
                        <td class="tg-gmhj">Wheat</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Amount</td>
                        <td class="tg-gmhj"><?php echo $mission_wood; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_clay; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_iron; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_wheat; ?></td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="4">
                            <?php
                            if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            }elseif ($mission_returning == 1 and $mission_village_id == $user_village_id){?>
                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-w6cr" colspan="5">Returning trade from <?php echo $mission_target_villagename; ?>
                        (<?php echo $mission_target_player; ?>)<br>
                        </th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Wood</td>
                        <td class="tg-gmhj">Clay</td>
                        <td class="tg-gmhj">Iron</td>
                        <td class="tg-gmhj">Wheat</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Amount</td>
                        <td class="tg-gmhj">-
                        </td>
                        <td class="tg-gmhj">-
                        </td>
                        <td class="tg-gmhj">-
                        </td>
                        <td class="tg-gmhj">-
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="4">
                            <?php
                            if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            <?php
            }
        }

      
        /*
        SETTLERS
        */
        if ($mission_type == "settle" and ($mission_village_id == $user_village_id or $mission_returning == 0)){
            if ($mission_returning == 0 and $mission_village_id == $user_village_id){
                ?>
                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-w6cr" colspan="5">Going settle to <?php echo $mission_target_villagename; ?>
                            (<?php echo $mission_target_player; ?>)<br></th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Wood</td>
                        <td class="tg-gmhj">Clay</td>
                        <td class="tg-gmhj">Iron</td>
                        <td class="tg-gmhj">Wheat</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Amount</td>
                        <td class="tg-gmhj"><?php echo $mission_wood; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_clay; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_iron; ?></td>
                        <td class="tg-gmhj"><?php echo $mission_wheat; ?></td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="4">
                            <?php
                            if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <?php
            }elseif ($mission_returning == 1 and $mission_village_id == $user_village_id){?>
                <table class="tg" style="min-width: 330px; text-align: center;">
                    <tr>
                        <th class="tg-w6cr" colspan="5">Returning settlers from <?php echo $mission_target_villagename; ?>
                        <br>
                        </th>
                    </tr>
                    <tr>
                        <td class="tg-gmhj"><br></td>
                        <td class="tg-gmhj">Wood</td>
                        <td class="tg-gmhj">Clay</td>
                        <td class="tg-gmhj">Iron</td>
                        <td class="tg-gmhj">Wheat</td>
                    </tr>
                    <tr>
                        <td class="tg-gmhj">Amount</td>
                        <td class="tg-gmhj"><?php echo $mission_wood;?>0
                        </td>
                        <td class="tg-gmhj"><?php echo $mission_clay;?>0
                        </td>
                        <td class="tg-gmhj"><?php echo $mission_iron;?>0
                        </td>
                        <td class="tg-gmhj"><?php echo $mission_wheat;?>0
                        </td>
                    </tr>
                    <tr>
                        <td class="tg-w6cu">Arrival</td>
                        <td class="tg-w6cu" colspan="4">
                            <?php
                            if ($_SESSION["varadmin"] == 1) {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, " <a href=executables/func_start.php?type=speedup&event_id=", $mission_id, ">Speed up</a>", "<br>";
                            } else {
                                echo "<b id=timer_id_mission_" . $mission_id . " name=timer_id_mission_" . $mission_id . ">Javascript Error</b>&nbsp;&nbsp;&nbsp;&nbsp;", " at: ", $mission_return_completed, "<br>";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            <?php
            }
        }

          
          

        if ($mission_returning == 1) {
            $mission_timer_stro_completed[$mission_id] = strtotime($mission_return_completed);
        } else {
            $mission_timer_stro_completed[$mission_id] = strtotime($mission_completed);
        }
        ?>
            <script>
                var epoch = new Date();
                epoch = ((epoch.getTime() - epoch.getMilliseconds()) / 1000) - epoch_offset;
                stro_completed = "<?php echo $mission_timer_stro_completed[$mission_id]; ?>";


                $(document).ready(function() {
                    timedown<?php echo $mission_id; ?>();
                });

                function timedown<?php echo $mission_id; ?> (stro_completed) {
                    var epoch = new Date();
                    var epoch = ((epoch.getTime() - epoch.getMilliseconds()) / 1000) - epoch_offset;
                    var element_id = "#timer_id_mission_<?php echo $mission_id; ?>";
                    stro_completed = "<?php echo $mission_timer_stro_completed[$mission_id]; ?>";
                    var timediff_epoch_stro_completed = stro_completed - epoch;
                    var value_output = mission_secondsdate_timer_editon(timediff_epoch_stro_completed);
                    $(element_id).text(value_output);
                    

                    if (timediff_epoch_stro_completed < 0 && stro_completed > 0) {
                        setTimeout("location.reload();", 2000);
                        $(element_id).text("Done");
                    } else {
                        setTimeout("timedown<?php echo $mission_id; ?>(stro_completed)", 1000)
                    }
                }
            </script>
            <?php
            $x--;
        }//END OF WHILE (EVENT)
    }//END OF FOREACH (VILLAGE)
    /*-----------------------------------------
    This is the end of the SHOW ALL MISSIONS function
    -----------------------------------------*/
    ?>