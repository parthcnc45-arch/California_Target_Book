<?php

Util::set_errors();

$county = $_GET['id'];

?>
@extends('layouts.iframe')

@section('title', "County Election Results - $county")

@section('content')

    <div class='container' style='width: 100vw;'>
        <div class='row'>
            <div class='col-lg-12'>

                <?php

                Util::require_ctb_api();

                //error_reporting(E_ALL);
                //ini_set('display_errors', '1');
                setlocale(LC_COLLATE, "en_US");
                setlocale(LC_CTYPE, "en_US");
                $endjava = Array();

                $county = $_GET['id'];

                $x = get_election_results($county);
                krsort($x);
                //var_dump($x);

                foreach ($x as $elec => $tm) {
                    foreach ($tm as $r) {
                        $date = $elec;
                        $naml = $r['NAML'];
                        $namf = $r['NAMF'];
                        $city = $r['CITY'];
                        if (!$city) {
                            $city = strtoupper($county);
                        }
                        $thiscity = $city;
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
                            $html .= "<p class='boldme'>$city-" . $thisoffice . $displayseat . $short_add . "</p>";
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

                        } elseif ($thisoffice == $lastoffice && $thisseat == $lastseat && $thiscity == $lastcity && $thisterm == $lastterm) {
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
                            $html .= "<p class='boldme'>$city-" . $thisoffice . $displayseat . $short_add . "</p>";
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
                        $lastcity = $thiscity;
                        $lastterm = $thisterm;
                    }
                }

                echo($html);


                function get_election_results($county)
                {
                    global $ctb2016_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM ctb2016_city_vote_hist WHERE COUNTY = '$county' ORDER BY DATE DESC, CITY, OFFICE, SEAT, VOTE_PCT DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $election = $row['DATE'];

                            if (!$tmp[$election]) {
                                $tmp[$election] = Array();
                            }


                            array_push($tmp[$election], $row);
                        }
                    }

                    $sql = "SELECT * FROM ctb2016_county_vote_hist WHERE COUNTY = '$county' ORDER BY DATE DESC, OFFICE, SEAT, VOTE_PCT DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $election = $row['DATE'];

                            if (!$tmp[$election]) {
                                $tmp[$election] = Array();
                            }


                            array_push($tmp[$election], $row);
                        }
                    }

                    $sql = "SELECT * FROM ctb2016_school_vote_hist WHERE COUNTY = '$county' ORDER BY DATE DESC, OFFICE, SEAT, VOTE_PCT DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $election = $row['DATE'];

                            if (!$tmp[$election]) {
                                $tmp[$election] = Array();
                            }


                            array_push($tmp[$election], $row);
                        }
                    }


                    return $tmp;
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

    .float_table {
        float: left;
        margin: 20px;
    }

</style>
@endsection
