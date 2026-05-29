
    <?php

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();

    global $fourcode;
    $fourcode = $id ?? $_GET['id'];


    $x = draw_demographics();

    ?>

    <div class='row'>
        <h3 align='center'>CENSUS DATA (2015 ACS 5-YEAR ESTIMATE)</h3>

        <?php

        echo("<div class='col-md-6'><h4>Population & Ethnic Statistics</h4><hr class='red' />" . $x['population'] . "</div>");
        echo("<div class='col-md-6'><h4>Household Income</h4><hr class='blue' />" . $x['income'] . "</div>");
        ?>

    </div>


    <div class='row'>

        <?php
        echo("<div class='col-md-4'><h4>Housing</h4><hr class='green' />" . $x['housing'] . "</div>");
        echo("<div class='col-md-4'><h4>Education</h4><hr class='yellow' />" . $x['education'] . "</div>");
        echo("<div class='col-md-4'><h4>Poverty Level</h4><hr class='midnight' />" . $x['poverty'] . "</div>");
        ?>
    </div>

    <hr />

    <?php


    //include 'php/storgsearch.php';

    function draw_demographics()
    {
        global $fourcode;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();

        Debugbar::info($fourcode);

        /*

        Family Households		HC01_VC04 (HC03_VC04)
        Non-Family Households	HC01_VC12 (HC03_VC12)

        Bachelor's or higher	HC01_VC96 (HC03_VC96)
        Graduate degree			HC01_VC92 (HC03_VC92)



        */

        $sql = "SELECT HC01_VC04, HC03_VC04,
				   HC01_VC12, HC03_VC12,
				   HC01_VC96, HC03_VC96,
				   HC01_VC92, HC03_VC92
			FROM ctb2016_dp02_city
			WHERE `GEO.displaylabel` = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dp02 = $row;
            }
        }

        /*

            Median Household Income HC01_VC85
            Mean Household Income   HC01_VC86
            Per Capita Income		HC01_VC118
            No Health Insurance		HC01_VC138 (HC03_VC138)
            % Below Poverty Level 	HC01_VC171 (HC03_VC171)

        */

        $sql = "SELECT HC01_VC85,
				   HC01_VC86,
				   HC01_VC118,
				   HC01_VC138, HC03_VC138,
				   HC01_VC171, HC03_VC171
			FROM ctb2016_dp03_city
			WHERE `GEO.displaylabel` = '$fourcode'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dp03 = $row;
            }
        }

        /*


            Owner Occupied		HC01_VC65 (HC03_VC65)
            Renter Occupied		HC01_VC66 (HC03_VC66)
            Median Value		HC01_VC128
            Median Rent			HC01_VC191

        */

        $sql = "SELECT HC01_VC65, HC03_VC65,
				   HC01_VC66, HC03_VC66,
				   HC01_VC128,
				   HC01_VC191
			FROM ctb2016_dp04_city
			WHERE `GEO.displaylabel` = '$fourcode'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dp04 = $row;
            }
        }

        /*

            Total Population #	HC01_VC03

            White #				HC01_VC94 (HC03_VC94) %
            Af-Am #				HC01_VC95 (HC03_VC95) %
            Latino #			HC01_VC88 (HC03_VC88) %
            Asian #				HC01_VC97 (HC03_VC97) %

        */

        $sql = "SELECT HC01_VC03,
				   HC01_VC94, HC03_VC94,
				   HC01_VC95, HC03_VC95,
				   HC01_VC88, HC03_VC88,
				   HC01_VC97, HC03_VC97
			FROM ctb2016_dp05_city
			WHERE `GEO.displaylabel` = '$fourcode'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dp05 = $row;
            }
        }

        $population = "<p><em>Total Population: " . number_format($dp05['HC01_VC03']) . "</em>
				   <br>White: " . number_format($dp05['HC01_VC94']) . " (" . $dp05['HC03_VC94'] . "%)
				   <br>Latino: " . number_format($dp05['HC01_VC88']) . " (" . $dp05['HC03_VC88'] . "%)
				   <br>African-American: " . number_format($dp05['HC01_VC95']) . " (" . $dp05['HC03_VC95'] . "%)
				   <br>Asian: " . number_format($dp05['HC01_VC97']) . " (" . $dp05['HC03_VC97'] . "%)</p>";

        $income = "<p>Family Households: " . number_format($dp02['HC01_VC04']) . " (" . $dp02['HC03_VC04'] . "%), Non-Family Households: " . number_format($dp02['HC01_VC12']) . " (" . $dp02['HC03_VC12'] . "%)
			   <br>Median Household Income: \$" . number_format($dp03['HC01_VC85']) . "
			   <br>Mean Household Income: \$" . number_format($dp03['HC01_VC86']) . "
			   <br>Per-Capita Income: \$" . number_format($dp03['HC01_VC118']) . "</p>";

        $housing = "<p>Owner Occupied: " . number_format($dp04['HC01_VC65']) . " (" . $dp04['HC03_VC65'] . "%)
 				<br>Median Value: \$" . number_format($dp04['HC01_VC128']) .
            "<br>Renter Occupied: " . number_format($dp04['HC01_VC66']) . " (" . $dp04['HC03_VC66'] . "%)
 				<br>Median Rent: \$" . number_format($dp04['HC01_VC191']) . "</p>";

        $education = "<p>Bachelor's Degree or Higher: " . $dp02['HC03_VC96'] . "%
 				 <br>Graduate Degree: " . number_format($dp02['HC01_VC92']) . " (" . $dp02['HC03_VC92'] . "%)</p>";

        $poverty = "<p>Population Below Poverty Level: " . $dp03['HC03_VC171'] . "%
				<br>Population Without Health Insurance: " . number_format($dp03['HC01_VC138']) . " (" . $dp03['HC03_VC138'] . "%)</p>";


        $retval['population'] = $population;
        $retval['income'] = $income;
        $retval['housing'] = $housing;
        $retval['education'] = $education;
        $retval['poverty'] = $poverty;

        return $retval;


    }

    ?>


