<?php
global $state, $cached;
$state = "CA";
?>

<div class='container-fluid'>

    <div class='row mb-xl'>
        <div class='col-lg-12'>
            <div class="panel">
                <?= drawreg2($cached['fourcode']); ?>
            </div>
        </div>
    </div>

    <div class='row mb-xl'>

        <div class='col-lg-12'>
            <div class="panel">
                <h3>Past Registration/Turnout</h3>

                <?= $cached['past_reg']; ?>
            </div>

        </div>

    </div>


    <div class='row mb-xl'>
        <div class="col-md-12">
            <div class="panel row m-n">
                <h3>Census Data (2019 ACS 5-Year Estimate)</h3>

                <?php
                    $x = draw_demographics($cached['fourcode']);
                ?>
                <div class='col-sm-6'>
                    <h4>Population & Ethnic Statistics</h4>
                    <hr class="blue"/>
                    <?= $x['population']??'' ?>
                </div>
                <div class='col-sm-6'>
                    <h4>Household Income</h4>
                    <hr class="green"/>
                    <?= $x['income']??'' ?>
                </div>
            </div>

        </div>

    </div>


    <div class='row mb-xl'>
        <div class='col-sm-4'>
            <div class="panel">
                <h4>Housing</h4>
                <hr class="green"/>
                <?= $x['housing']??'' ?>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class="panel">
                <h4>Education</h4>
                <hr class="blue"/>
                <?= $x['education']??'' ?>
            </div>
        </div>
        <div class='col-sm-4'>
            <div class="panel">
                <h4>Poverty Level</h4>
                <hr class="red"/>
                <?= $x['poverty']??'' ?>
            </div>
        </div>
    </div>

    <div class='row mb-xl'>
        <div class='col-lg-12'>
            <div class="panel">
                <h3>District Profile</h3>
                <?php
                    $x = get_district_profile($cached['fourcode']);
                    $z = get_overlaps($id);
                ?>

                <div><?= $x ?></div>
                <div class="row">
                    <?= $z['Counties']; ?>
                    <?= $z['Cities']; ?>
                    <?= $z['SD']; ?>

                </div>
                <div class="row">
                    <?= $z['AD']; ?>
                    <?= $z['HD']; ?>
                    <?= $z['CD']; ?>
                    <?= $z['ZIP']; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php

function get_turnout()
{
    global $fourcode;
    $x = getdisttype($fourcode);
    $type = $x['disttype'];
    $distno = $x['distno'];

    $elections = Array("p12", "g12", "p14", "g14", "p16", "g16");

//    $conn = Util::get_ctb_conn();
    $conn = Util::get_ctb_pdo();

    foreach ($elections as $table) {
        $table = 'ctb2016_'.$table;

        $stmt = $conn->prepare("
            SELECT
              SUM(TOTREG) AS TOTREG,
              SUM(TOTVOTE) AS TOTVOTE,
              SUM(rTOTREG_R) AS rTOTREG_R,
              SUM(rREP) AS REP,
              SUM(rDEM) AS DEM,
              SUM(rDCL) AS NPP
              FROM $table WHERE $type = :distno;
        ");

        $stmt->execute(['distno' => $distno]);
        $row = $stmt->fetch();
        $totals[$table]['TURNOUT'] = makepct($row['TOTVOTE'], $row['TOTREG']);
        $totals[$table]['TOTREG'] = $row['TOTREG'];
        $totals[$table]['REP_NO'] = $row['REP'];
        $totals[$table]['DEM_NO'] = $row['DEM'];
        $totals[$table]['NPP_NO'] = $row['NPP'];
        $totals[$table]['REP_PCT'] = makepct($row['REP'], $row['rTOTREG_R']);
        $totals[$table]['DEM_PCT'] = makepct($row['DEM'], $row['rTOTREG_R']);
        $totals[$table]['NPP_PCT'] = makepct($row['NPP'], $row['rTOTREG_R']);
    }

    $x = $totals;

    $tablebody = '';
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

    return "<p align='center'><table id='turnout_table' width='100%' align='center' class='table-responsive'><tbody>$tablebody</tbody></table></p>";

}

function draw_demographics() {
    global $fourcode;

    $first_two = mb_substr($fourcode, 0, 2);
    switch($first_two) {
	case "AD":
		$dz = ltrim(mb_substr($fourcode, 2, 2), "0");
		$q = "Assembly District " . $dz;
		break;
	case "SD":
		$dz = ltrim(mb_substr($fourcode, 2, 2), "0");
		$q = "State Senate District " . $dz;
		break;
	case "CD":
		$dz = ltrim(mb_substr($fourcode, 2, 2), "0");
		$q = "Congressional District " . $dz . " (116th Congress), California";
	default:
		return FALSE;
		break;
    }


    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM census_acs_data
	    WHERE YEAR = 2019 && NAME LIKE '%$q%'";

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dp = $row['dp_table'];
            $cd[$dp] = $row;
        }
    }

    /*

    2019 ACS KEYS

    DP02
    K0001 - Total Households
    K0002 - Family Households
    K0068 - Bachelor's Degree or Higher
    K0066 - Graduate Degree

    DP03
    K0062 - Median Household Income
    K0063 - Mean Household income
    K0088 - Per Capita Income
    K0099 - No Health Insurance
    K0128 - Below Poverty Level

    DP04
    K0046 - Owner Occupied
    K0047 - Renter Occupied
    K0089 - Median Value
    K0134 - Median Rent

    DP05
    K0001 - Total Population
    K0077 - Non-Hispanic White
    K0071 - Hispanic
    K0078 - Black
    K0080 - Asian

    */


    $population = "<p>
        <em>Total Population: " . number_format($cd['DP05']['K0001E']) . "</em>

       <br>White: "  . number_format($cd['DP05']['K0077E']) . " (" . $cd['DP05']['K0077PE'] . "%)
       <br>Latino: " . number_format($cd['DP05']['K0071E']) . " (" . $cd['DP05']['K0071PE'] . "%)
       <br>Black: "  . number_format($cd['DP05']['K0078E']) . " (" . $cd['DP05']['K0078PE'] . "%)
       <br>Asian: "  . number_format($cd['DP05']['K0080E']) . " (" . $cd['DP05']['K0080PE'] . "%)
       </p>";

    $hshld_tot = $cd['DP02']['K0001E'];
    $hshld_fam = $cd['DP02']['K0002E'];
    $hshld_fam_pct = $cd['DP02']['K0002PE'];
    $hshld_nfm_pct = 100 - $hshld_fam_pct;
    $hshld_nfm = number_format($hshld_tot - $hshld_fam);

    $median_income = $cd['DP03']['K0062E'];
    if($median_income == "250") {
        $median_income = "250,000+";
    } else {
        $median_income = number_format($cd['DP03']['K0062E']);
    }

    $median_value = $cd['DP04']['K0089E'];
    if($median_value == "2") {
        $median_value = "2,000,000+";
    } else {
        $median_value = number_format($median_value);
    }

    $income = "<p>
     <em>Total Households: "        . number_format($hshld_tot) . "</em><br>
     Family Households: "       . number_format($cd['DP02']['K0002E'])    . " (" . $cd['DP02']['K0002PE'] . "%),
     Non-Family Households: "   . $hshld_nfm    . " (" . number_format($hshld_nfm_pct)  . "%)

     <br>Median Household Income: \$"   . $median_income . "
     <br>Mean Household Income: \$"     . number_format($cd['DP03']['K0063E']) . "
     <br>Per-Capita Income: \$"         . number_format($cd['DP03']['K0088E']) . "
     </p>";


    $housing = "<p>
    Owner Occupied: "   . number_format($cd['DP04']['K0046E']) . " ("     . $cd['DP04']['K0046PE'] . "%)<br>
    Median Value: \$"   . $median_value . "<br>
    Renter Occupied: "  . number_format($cd['DP04']['K0047E']) . " ("     . $cd['DP04']['K0047PE'] . "%)<br>
    Median Rent: \$"    . number_format($cd['DP04']['K0134E']) .
    "</p>";


    $education = "<p>
    Bachelor's Degree or Higher: "  . number_format($cd['DP02']['K0068E']) . " (" . $cd['DP02']['K0068PE'] . "%)<br>
    Graduate Degree: "              . number_format($cd['DP02']['K0066E']) . " (" . $cd['DP02']['K0066PE'] . "%)
    </p>";

    $poverty = "<p>
    Population Below Poverty Level: "                                                       . $cd['DP03']['K0128PE'] . "%<br>
    Population Without Health Insurance: "  . number_format($cd['DP03']['K0099E']) . " ("   . $cd['DP03']['K0099PE'] . "%)
    </p>";


    $retval['population']   = $population;
    $retval['income']       = $income;
    $retval['housing']      = $housing;
    $retval['education']    = $education;
    $retval['poverty']      = $poverty;

    return $retval;

}



function get_district_profile()
{
    global $fourcode;
    $id = $fourcode;

    if (mb_substr($id, 0, 2) == "CD") {
        $id = "CA" . mb_substr($id, 2, 2);
    }

    $stmt = Util::get_ctb_pdo()->prepare(
        "SELECT text from ctb_dist_profile WHERE dist = :id ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute(['id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['text'];
}

function get_overlaps()
{
    global $fourcode;
    $id = $fourcode;
    global $state;

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
        'id' => $id
    ]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch ($row['place_type']) {
            case 'City':
                $url = "<a href='/book/city/" . $row['place'] . "' target='_blank'>" . $row['place'] . "</a>";
                array_push($retval['Cities'], $url);
                break;

            case 'County':
                $url = "<a href='/book/county/" . $row['place'] . "' target='_blank'>" . $row['place'] . "</a>";
                array_push($retval['Counties'], $url);
                break;

            case 'AD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "AD" . checkaddzero($results[1]);
                $url = "<a href='/book/district/" . $this_fourcode . "' target='_blank'>" . $this_fourcode . "</a>";
                array_push($retval['AD'], $url);
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
                $url = "<a href='/book/district/" . $this_fourcode . "' target='_blank'>" . $this_fourcode . "</a>";
                array_push($retval['SD'], $url);
                break;

            case 'CD':
                $raw = $row['place'];
                $regex = "~\-(.*)~mis";
                preg_match($regex, $raw, $results);
                $this_fourcode = "CD" . checkaddzero($results[1]);
                $url = "<a href='/book/district/" . $this_fourcode . "' target='_blank'>" . $this_fourcode . "</a>";
                array_push($retval['CD'], $url);
                break;

            case 'ZIP':
                array_push($retval['ZIP'], $row['place']);
                break;
        }
    }




    /**/
   /*
    $sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'City'";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval['Cities'], $row['place']);
        }
    }*/

    /*$sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'County'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval['Counties'], $row['place']);
        }
    }

    $sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'AD'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $raw = $row['place'];
            $regex = "~\-(.*)~mis";
            preg_match($regex, $raw, $results);
            $this_fourcode = "AD" . checkaddzero($results[1]);
            array_push($retval['AD'], $this_fourcode);
        }
    }*/
/*
    $sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'HD'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $raw = $row['place'];
            $regex = "~\-(.*)~mis";
            preg_match($regex, $raw, $results);
            $this_fourcode = "HD" . checkaddzero($results[1]);
            array_push($retval['HD'], $this_fourcode);
        }
    }

    $sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'SD'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $raw = $row['place'];
            $regex = "~\-(.*)~mis";
            preg_match($regex, $raw, $results);
            $this_fourcode = "SD" . checkaddzero($results[1]);
            array_push($retval['SD'], $this_fourcode);
        }
    }

    $sql = "SELECT * FROM ctb_distcplaces WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'CD'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $raw = $row['place'];
            $regex = "~\-(.*)~mis";
            preg_match($regex, $raw, $results);
            $this_fourcode = "CD" . checkaddzero($results[1]);
            array_push($retval['CD'], $this_fourcode);
        }
    }

    $sql = "SELECT * FROM ctb_dist_places WHERE state = '$state' && dist = '$adjusted_dist' && place_type = 'ZIP'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval['ZIP'], $row['place']);
        }
    }*/

    $county_head = "
						<div class='col-lg-4'>
						<h3>Counties</h2>";

    $city_head = "
						<div class='col-lg-4'>
						<h3>Cities</h2>";

    $ads_head = "
						<div class='col-lg-4'>
						<h3>Assembly Districts</h2>";

    $sds_head = "
						<div class='col-lg-4'>
						<h3>State Senate Districts</h2>";

    $cds_head = "
						<div class='col-lg-4'>
						<h3>Congressional Districts</h2>";

    $zip_head = "
						<div class='col-lg-4'>
						<h3>ZIP Codes</h2>";


    $end_div = "</div>";

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
        $z['HD'] = $ads_head . $items . $end_div;
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

function drawreg2()
{
    global $fourcode;

    $conn = Util::get_ctb_pdo();
    $stmt = $conn->prepare(
        "SELECT * FROM ctb2016_sos_all WHERE DIST = :fourcode ORDER BY RPT_DATE DESC LIMIT 1"
    );
    $stmt->execute(['fourcode' => $fourcode]);
    $row = $stmt->fetch();

    $dem = $row['DEM'];
    $rep = $row['REP'];
    $npp = $row['NPP'];
    $tot = $row['TOT'];
    $oth = $row['OTH'];

    $rpt_date = nicedate2($row['RPT_DATE']);


    $dem_pct = makeplainpercent2($dem, $tot);
    $rep_pct = makeplainpercent2($rep, $tot);

    $dem_pct_draw = makepct($dem, $tot);
    $rep_pct_draw = makepct($rep, $tot);
    $npp_pct_draw = makepct($npp, $tot);
    $oth_pct_draw = makepct($oth, $tot);

    if ($dem_pct > $rep_pct) {
        $advantage = "<span class='blueme boldme'>D +" . number_format(($dem_pct - $rep_pct), 2) . "%</span>";
    }

    if ($rep_pct > $dem_pct) {
        $advantage = "<span class='redme boldme'>R +" . number_format(($rep_pct - $dem_pct), 2) . "%</span>";
    }

        $drawme = "<p class='boldme' align='center'>REGISTRATION REPORT DATE: $rpt_date<br>TOTAL VOTERS: " . number_format($tot) . "</p>
	<p align='center'>$advantage</p>
	<p align='center'><span class='blueme boldme'>DEM: $dem_pct_draw (" . number_format($dem) . ")</span>
	    &nbsp;--&nbsp;<span class='redme boldme'>REP: $rep_pct_draw (" . number_format($rep) . ")</span>
	    &nbsp;--&nbsp;NPP: $npp_pct_draw (" . number_format($npp) . ") -- OTH: $oth_pct_draw (" . number_format($oth) . ")
	</p>";

    //echo("<br>DRAWING: <br>$drawme");

    return $drawme;

}

function makeplainpercent2($portion, $total)
{
    return ($portion / $total) * 100;
}

function nicedate2($str) {
	$year = mb_substr($str, 0, 4);
	$month = mb_substr($str, 5, 2);
	$day   = mb_substr($str, 8, 2);

	switch($month) {
		case "01":
			$m = "January";
			break;
		case "02":
			$m = "February";
			break;
		case "03":
			$m = "March";
			break;
		case "04":
			$m = "April";
			break;
		case "05":
			$m = "May";
			break;
		case "06":
			$m = "June";
			break;
		case "07":
			$m = "July";
			break;
		case "08":
			$m = "August";
			break;
		case "09":
			$m = "September";
			break;
		case "10":
			$m = "October";
			break;
		case "11":
			$m = "November";
			break;
		case "12":
			$m = "December";
			break;

	}
	$retval = $m . " " . $day . ", " . $year;
	return $retval;

}


?>
