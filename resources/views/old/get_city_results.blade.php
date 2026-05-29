<?php

    if (isset($_GET['id'])) {
        $city = $_GET['id'];
    } else {
        $city = '';
    }

?>
@extends('layouts.master_headless')

@section('title', "City Election Results - $city")

@section('content')

    <div class='container' style='width: 100vw;'>
        <div class='row'>
            <div class='col-lg-12'>

                <?php

                Util::set_errors();

                //error_reporting(E_ALL);
                //ini_set('display_errors', '1');
                setlocale(LC_COLLATE, "en_US");
                setlocale(LC_CTYPE, "en_US");
                $endjava = Array();

                $city = $_GET['id'];

                $x = get_election_results($city);
                //var_dump($x);

                foreach ($x as $r) {
                    $date = $r['DATE'];
                    $naml = $r['NAML'];
                    $namf = $r['NAMF'];
                    $designation = $r['DESIGNATION'];
                    if ($r['IS_INCUMBENT']) {
                        $is_incumbent = " (Inc)";
                    } else {
                        $is_incumbent = "";
                    }

                    $thisterm = $r['TERM'];

                    if ($r['TERM'] == "Short") {
                        $short_add = " <span class='itcme'>(Special/Recall)</span>";
                    } else {
                        $short_add = '';
                    }

                    $thisoffice = $r['OFFICE'];
                    $thisseat = $r['SEAT'];
                    $thiselection = $date;

                    if ($thisseat === "0") {
                        $displayseat = "";
                    } else {
                        $displayseat = " " . $thisseat;
                    }

                    $votes = $r['VOTE_CAND'];
                    $total = $r['VOTE_TOT'];
                    if ($r['ELECTED'] == "Yes") {
                        $outcome = "&#10003;";
                    } elseif ($r['ELECTED'] == "Runoff") {
                        $outcome = "&#10141;";
                    } else {
                        $outcome = '';
                    }


                    if ($thiselection != $lastelection) {

                        $year = mb_substr($thiselection, 0, 4);
                        $month = mb_substr($thiselection, 5, 2);
                        $day = mb_substr($thiselection, 8, 2);

                        $display_election = longify($month) . " " . $day . ", $year Election";


                        $html .= "</tbody></table></div>";
                        $html .= "<div width='100%' style='clear: both;'><hr /></div>";
                        $html .= "<h2 align='center'>$display_election</h2>";
                        $html .= "<div class='float_table'>";
                        $html .= "<p class='boldme'>" . $thisoffice . $displayseat . $short_add . "</p>";
                        $html .= "<table width='600px'>
					<tbody>
						<tr>
							<td>" . $namf . " " . $naml . $is_incumbent . "</td>
							<td>" . $designation . "</td>
							<td>" . number_format($votes) . "</td>
							<td>" . number_format((($r['VOTE_PCT']) * 100), 2) . "%</td>
							<td>" . $outcome . "</td>
						</tr>
							";

                    } elseif ($thisoffice == $lastoffice && $thisseat == $lastseat && $thisterm == $lastterm) {
                        //DO NOTHING
                        $html .= "		<tr>
							<td>" . $namf . " " . $naml . $is_incumbent . "</td>
							<td>" . $designation . "</td>
							<td>" . number_format($votes) . "</td>
							<td>" . number_format((($r['VOTE_PCT']) * 100), 2) . "%</td>
							<td>" . $outcome . "</td>
						</tr>";
                    } else {
                        $html .= "</tbody></table></div>";
                        $html .= "<div class='float_table'>";
                        $html .= "<p class='boldme'>" . $thisoffice . $displayseat . $short_add . "</p>";
                        $html .= "<table width='600px'>
					<tbody>
						<tr>
							<td>" . $namf . " " . $naml . $is_incumbent . "</td>
							<td>" . $designation . "</td>
							<td>" . number_format($votes) . "</td>
							<td>" . number_format((($r['VOTE_PCT']) * 100), 2) . "%</td>
							<td>" . $outcome . "</td>
						</tr>
							";

                    }


                    $lastoffice = $thisoffice;
                    $lastseat = $thisseat;
                    $lastelection = $date;
                    $lastterm = $thisterm;
                }

                echo($html);

                function get_election_results($city)
                {
                    global $ctb2016_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM ctb2016_city_vote_hist WHERE CITY = '$city' ORDER BY DATE DESC, OFFICE, SEAT DESC, VOTE_PCT DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($retval, $row);
                        }
                    }

                    return $retval;
                }

                function longify($month)
                {
                    switch ($month) {
                        case "01":
                            $retval = "January";
                            break;
                        case "02":
                            $retval = "February";
                            break;
                        case "03":
                            $retval = "March";
                            break;
                        case "04":
                            $retval = "April";
                            break;
                        case "05":
                            $retval = "May";
                            break;
                        case "06":
                            $retval = "June";
                            break;
                        case "07":
                            $retval = "July";
                            break;
                        case "08":
                            $retval = "August";
                            break;
                        case "09":
                            $retval = "September";
                            break;
                        case "10":
                            $retval = "October";
                            break;
                        case "11":
                            $retval = "November";
                            break;
                        case "12":
                            $retval = "December";
                            break;
                    }

                    return $retval;
                }


                ?>

            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

@section('styles')
<style>

    body {
        background-color: white;
        font-family: 'Lato';
        font-size: 1em;
    }

    .dropshadow {
        -webkit-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        -moz-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
    }

    table {
        margin-left: auto;
        margin-right: auto;
        font-family: 'PT Sans Narrow';
        font-size: 1.5em;
    }

    .supeclass {
        max-width: 500px;
        float: left;
        margin: 10px;
    }

    .supeclear {
        clear: both;
    }

    .float_table {
        float: left;
        margin: 20px;
        font-size: 1em;
    }

    #districtanalyses th {
        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    th {

        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        color: white;

    }

    #districtWrapper td {

        font-family: 'Lato';
        padding: 5px;
    }

    #greyColumn {

        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    #blueColumn {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .winner {
        font-weight: bold;
        font-variant: small-caps;
    }
</style>
@endsection
