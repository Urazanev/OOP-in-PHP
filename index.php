<?php include 'autoloader.php'; ?>  //     
<h2>Lunární kalendář 2016 online</h2>
<div>
    /*  Get data from form  */
    <form  method="post" name="form1">
        <table class="result_tab" border="0" cellspacing="3" cellpadding="3">
            <tr>
                <th>&nbsp;</th> 
            </tr>      
            <tr>
                <th rowspan="11">&nbsp;</th>  
                <th><span class="form1">Den </span>
                </th>
                <th><select name="dd">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<option value='$i'";
                            if ($i == date('j')) {
                                echo "selected";
                            }
                            echo ">$i";
                        }
                        ?>
                    </select></th>
                <th><span class="form1">Čas</span>
                    <select name="chas">
                        <?php
                        for ($i = 0; $i <= 23; $i++) {
                            echo "<option value='$i'";
                            if ($i == date('G')) {
                                echo "selected";
                            }
                            echo ">$i";
                        }
                        ?>  
                    </select></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>  
            </tr>
            <tr>
                <th><span class="form1">Mesic   </span></th>
                <th><select name="mm">
                        <?php
                        $arr_month = [1 => 'Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'];
                        for ($i = 1; $i <= 12; $i++) {
                            echo "<option value='$arr_month[$i]'";
                            if ($i == date('n')) {
                                echo "selected";
                            }
                            echo ">$arr_month[$i]";
                        }
                        ?>          
                    </select></th>
                <th><span class="form1">Min</span>
                    <select name="min">
                        <?php
                        for ($i = 0; $i <= 59; $i++) {
                            echo "<option value='$i'";
                            if ($i == date('i')) {
                                echo "selected";
                            }
                            echo">$i";
                        }
                        ?>  
                    </select></th>
            </tr>
            <tr>
                <th><span class="form1">Rok </span></th>
                <th><select name="yy">
                        <?php
                        for ($i = 1970; $i <= 2032; $i++) {
                            echo "<option value='$i'";
                            if ($i == date('Y')) {
                                echo "selected";
                            }
                            echo ">$i";
                        }
                        ?>  
                    </select></th> 
                <th>&nbsp;</th>
                <th><input name="button" type="submit" value="Vypočítat Lunární den"/></th>
            </tr>
    </form>

    <?php
    if (!empty($_POST)) {                       // if exist some data from form1 
        for ($i = 1; $i <= 12; $i++) {
            if ($arr_month[$i] == $_POST["mm"])
                $mes = $i;
        }
        $need_date = mktime($_POST["chas"], $_POST["min"], 0, $mes, $_POST["dd"], $_POST["yy"]); // Compose date to calculate moon day  
    }
    else {                                      //we use current date&time 
        $need_date = time();
    }
    $moon = new MoonPhase($need_date);          // create object $moon         
    $ilumination = floor($moon->illumination() * 100);  // get moon illumination
    $zodiac1 = $moon->moonzodiac();                     // get moon zodiac
    $zodiac = $moon->sunzodiac();                       // get sun zodiac
    $age1 = round($moon->age(), 2);                     // get moon age
    $age_days = floor($age1);
    $age_hours = round(($age1 - floor($age1)) * 24);    // get moon age in hours
    $stage = $moon->phase() < 0.5 ? 'dorůstá' : 'couvá'; // get moon phase
    $phase_name = $moon->phase_name();
    $distance = round($moon->distance(), 2);            // get distance
    ?>

    /*  Moon day details table  */

    <table border="1">
        <tr>
            <td rowspan="3" colspan="2"><img src=http://airden.eu/images\lunar\moon<?= $age_days ?>.png /></td>
            <td colspan="2"><h2><?= $age_days ?> lunární den</h2></td> 
        </tr>
        <tr>
            <td colspan="2"><h3><?= date('d.m.Y G:i \u\t\c P', $need_date) ?></h3></td> 
        </tr>
        <tr>
            <td td align="center" colspan="2"><?= $phase_name ?>, Měsíc <?= $stage ?></td>    
        </tr>
        <tr>
            <td rowspan="2" colspan="2"><h3>Osvětlení <?= $ilumination ?> %</h3></td>
            <td>Měsíční znamení:</td>
            <td><?= $zodiac1 ?></td>
        </tr>
        <tr>

            <td>Vzdálenost od země:</td>
            <td><?= $distance ?> km</td>
        </tr>
        <tr>

        </tr>
    </table>