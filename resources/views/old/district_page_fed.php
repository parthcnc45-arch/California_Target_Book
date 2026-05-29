

<div class='container-fluid' >

    <div class='row' style='margin-top: 30px;'>

        <div class='col-lg-12'>
            <?php
            $x = drawreg($id);
            echo($x);
            ?>
        </div>
    </div>

    <hr />

    <div class='row'>
        <h3 align='center'>CENSUS DATA (2015 ACS 5-YEAR ESTIMATE)</h3>

        <?php

        $x = draw_demographics();

        echo("<div class='col-md-6'><h4>Population & Ethnic Statistics</h4><hr style='border: 2px solid red;'/>" . $x['population'] . "</div>");
        echo("<div class='col-md-6'><h4>Household Income</h4><hr style='border: 2px solid blue;'/>" . $x['income'] . "</div>");
        ?>

    </div>


    <div class='row'>

        <?php
        echo("<div class='col-md-4'><h4>Housing</h4><hr style='border: 2px solid green;' />" . $x['housing'] . "</div>");
        echo("<div class='col-md-4'><h4>Education</h4><hr style='border: 2px solid orange;'/>" . $x['education'] . "</div>");
        echo("<div class='col-md-4'><h4>Poverty Level</h4><hr style='border: 2px solid purple;'/>" . $x['poverty'] . "</div>");
        ?>
    </div>

    <hr />

    <div class='row'>
        <div class='col-lg-12'>
            <h3 align='center'>DISTRICT PROFILE</h3>

            <?php

            $x = get_district_profile($id);
            echo("<div style='font-size: 1.2em; padding: 50px;'>$x</div>");

            $state = mb_substr($id, 0, 2);

            $z = get_overlaps();


            echo($z['Counties']);
            echo($z['Cities']);
            echo($z['SD']);
            echo($z['AD']);
            echo($z['HD']);
            echo($z['CD']);
            echo($z['ZIP']);

            ?>
        </div>
    </div>

</div>

<?php

function get_turnout($fourcode)
{

    $x = getdisttype($fourcode);
    $type = $x['disttype'];
    $distno = $x['distno'];

    $elections = Array("p12", "g12", "p14", "g14", "p16", "g16");

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    foreach ($elections as $table) {
        $sql = "SELECT SUM(TOTREG) AS TOTREG, SUM(TOTVOTE) AS TOTVOTE, SUM(rTOTREG_R) AS rTOTREG_R, SUM(rREP) as REP, SUM(rDEM) as DEM, SUM(rDCL) AS NPP FROM ctb2016_$table WHERE $type = $distno";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totals[$table]['TURNOUT'] = makepct($row['TOTVOTE'], $row['TOTREG']);
                $totals[$table]['TOTREG'] = $row['TOTREG'];
                $totals[$table]['REP_NO'] = $row['REP'];
                $totals[$table]['DEM_NO'] = $row['DEM'];
                $totals[$table]['NPP_NO'] = $row['NPP'];
                $totals[$table]['REP_PCT'] = makepct($row['REP'], $row['rTOTREG_R']);
                $totals[$table]['DEM_PCT'] = makepct($row['DEM'], $row['rTOTREG_R']);
                $totals[$table]['NPP_PCT'] = makepct($row['NPP'], $row['rTOTREG_R']);
            }
        }
    }

    $x = $totals;

    foreach ($x as $key => $e) {

        $dem = str_replace("%", "", $e['DEM_PCT']);
        $rep = str_replace("%", "", $e['REP_PCT']);

        if ($dem > $rep) {
            $adv = "<span class='blueme boldme'>D +" . number_format(($dem - $rep), 2) . "</span>";
        } elseif ($rep > $dem) {
            $adv = "<span class='redme boldme'>R +" . number_format(($rep - $dem), 2) . "</span>";
        } else {
            $adv = "EVEN";
        }

        $tablebody .= "<tr>
						<td><span class='boldme' style='color: FireBrick;'>$key: </span></td>
						<td>" . $adv . "</td>
						<td><span class='boldme blueme'>DEM: " . number_format($e['DEM_NO']) . " (" . $e['DEM_PCT'] . ") </span></td>
						<td><span class='boldme redme'>REP: " . number_format($e['REP_NO']) . " (" . $e['REP_PCT'] . ") </span></td>
						<td><span class='boldme grayme'>NPP: " . number_format($e['NPP_NO']) . " (" . $e['NPP_PCT'] . ") </span></td>
						<td><span class='boldme'>TOTAL - " . number_format($e['TOTREG']) . "</span></td>
						<td><span class='itcme'> - TURNOUT: " . $e['TURNOUT'] . "</span></td>
					</tr>";
    }

    $retval = "<p align='center'><table id='turnout_table' width='100%' align='center' class='table-responsive'><tbody>$tablebody</tbody></table></p>";

    return $retval;

}

function draw_demographics()
{

    global $master_fourcode;
    $fourcode = $master_fourcode;
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

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
			FROM ctb2016_dp02 
			WHERE FOURCODE = '$fourcode'";
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
			FROM ctb2016_dp03
			WHERE FOURCODE = '$fourcode'";

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
			FROM ctb2016_dp04
			WHERE FOURCODE = '$fourcode'";

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
			FROM ctb2016_dp05
			WHERE FOURCODE = '$fourcode'";

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

function get_district_profile($id)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();

    if (mb_substr($id, 0, 2) == "CD") {
        $id = "CA" . mb_substr($id, 2, 2);
    }
    $sql = "SELECT text from ctb_dist_profile WHERE dist = '$id' ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function get_overlaps()
{
    global $master_fourcode;
    //global $state;
    $state = mb_substr($master_fourcode, 0, 2);
    //global $site_conn;
    $conn = Util::get_ctb_conn();
    $dist_type = mb_substr($master_fourcode, 0, 2);
    $dist_no = mb_substr($master_fourcode, 2, 2);
    $dist = "CD" . $dist_no;

    $retval = Array(
        'Cities' => Array(),
        'Counties' => Array(),
        'AD' => Array(),
        'HD' => Array(),
        'CD' => Array(),
        'SD' => Array(),
        'ZIP' => Array(),
    );

    /**/

    $stmt = Util::get_ctb_pdo()->prepare("
        SELECT * FROM ctb_dist_places
        WHERE state = :state && dist = :id
    ");

    $stmt->execute([
        'state' => $state,
        'id' => $dist
    ]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        error_log($row['place_type']);
        switch ($row['place_type']) {
            case 'City':
                array_push($retval['Cities'], $row['place']);
                break;

            case 'County':
                array_push($retval['Counties'], $row['place']);
                break;

            case 'AD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "AD" . checkaddzero($results[1]);
                array_push($retval['AD'], $this_fourcode);
                break;

            case 'HD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "HD" . checkaddzero($results[1]);
                array_push($retval['HD'], $this_fourcode);
                break;

            case 'SD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "SD" . checkaddzero($results[1]);
                array_push($retval['SD'], $this_fourcode);
                break;

            case 'CD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "CD" . checkaddzero($results[1]);
                array_push($retval['CD'], $this_fourcode);
                break;

            case 'ZIP':
                array_push($retval['ZIP'], $row['place']);
                break;
        }
    }

    $county_head = "
                        <div class='col-lg-4'> <!--BEGIN COUNTY-->
                          <h3>Counties</h3>";

    $city_head = "
                        <div class='col-lg-4'> <!--BEGIN CITY-->
                          <h3>Cities</h3>";

    $ads_head = "
                        <div class='col-lg-4'> <!--BEGIN AD-->
                          <h3>Assembly Districts</h3>";

    $sds_head = "
                        <div class='col-lg-4'> <!--BEGIN SD-->
                          <h3>State Senate Districts</h3>";

    $hds_head = "
                        <div class='col-lg-4'> <!--BEGIN HD-->
                            <h3>State House Districts</h3>";

    $cds_head = "
                        <div class='col-lg-4'> <!--BEGIN CD-->
                          <h3>Congressional Districts</h3>";

    $zip_head = "
                        <div class='col-lg-4'> <!--BEGIN ZIP-->
                          <h3>ZIP Codes</h3>";


    $end_div = "
                        </div> <!--END COUNTY/CITY/AD/HD/SD/CD/ZIP-->";

    //var_dump($retval);

    $z = Array(
        'Cities' => '',
        'Counties' => '',
        'AD' => '',
        'HD' => '',
        'CD' => '',
        'SD' => '',
        'ZIP' => '',
    );

    if ($retval['Counties']) {
        $items = join(', ', $retval['Counties']);
        $z['Counties'] = $county_head . $items . $end_div;
    }

    if ($retval['Cities']) {
        $items = join(', ', $retval['Cities']);
        $z['Cities'] = $city_head . $items . $end_div;
    }

    if ($retval['AD']) {
        $items = join(', ', $retval['AD']);
        $z['AD'] = $ads_head . $items . $end_div;
    }

    if ($retval['HD']) {
        $items = join(', ', $retval['HD']);
        $z['HD'] = $hds_head . $items . $end_div;
    }

    if ($retval['SD']) {
        $items = join(', ', $retval['SD']);
        $z['SD'] = $sds_head . $items . $end_div;
    }

    if ($retval['CD']) {
        $items = join(', ', $retval['CD']);
        $z['CD'] = $cds_head . $items . $end_div;
    }

    if ($retval['ZIP']) {
        $items = join(', ', $retval['ZIP']);
        $z['ZIP'] = $zip_head . $items . $end_div;
    }

    return $z;
}

