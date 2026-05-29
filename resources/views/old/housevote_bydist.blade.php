
@extends('layouts.master')

@section('title', 'House Vote By Dist | California Target Book')

@section('content')

    

    <?php

    Util::set_errors();
    Util::require_ctb_api();

    global $fourcode;
    $fourcode = $_GET['id'];

    $x = getallinfo($fourcode);

    $alias = $x['ALIAS'];

    $leg_fullname = $x['NAMF'] . " " . $x['NAML'];
    $party = $x['PARTY'];

    echo("<h1>$fourcode</br>$leg_fullname ($party)</h1>");

    $highestroll = gethighestrollnumber();

    $thisid = "votes";

    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

    array_push($endjava, $js);


    $brokewithtot = 0;
    $tablehead = "<div class='newseg'>
				<table id='$thisid' class='table table-bordered table-hover tablesaw tablesaw-stack bordered tablesorter' data-tablesaw-mode='stack'>
					<thead>
						<tr>
							<th>ROLL</th>
							<th>DETAIL</th>
							<th>DATE</th>
							<th>BILL</th>
							<th>TYPE</th>
							<th>VOTE</th>
							<th>STATUS</th>
							<th>Y_TOT</th>
							<th>Y_GOP</th>
							<th>Y_DEM</th>
							<th>N_TOT</th>
							<th>N_GOP</th>
							<th>N_DEM</th>
							<th>MAJ/MIN</th>
							<th>W/PARTY</th>
						</tr>
					</thead>
					<tbody>
";

    //echo("<br>Getting results for legislator $alias<br>");

    $voteslogged = 1;

    while ($i <= $highestroll) {
        $x = getfedbillsummary($i);

        $date = $x['vote_date'];
        if (!$date) {
            $i++;
            continue;
        }
        $bill_id = $x['bill_id'];
        $type = $x['type'];
        $url = $x['url'];
        $result = $x['vote_result'];
        $dscr = $x['description'];
        $vote = getfedlegislatorvote($i);

        $y_tot = $x['totyea'];
        $n_tot = $x['totnoe'];

        $y_gop = $x['gopyea'];
        $y_dem = $x['demyea'];

        $n_gop = $x['gopnoe'];
        $n_dem = $x['demnoe'];

        if ($y_dem > $n_dem) {
            $mostdem = 2;
        } else {
            $mostdem = 1;
        }

        if ($y_gop > $n_gop) {
            $mostgop = 2;
        } else {
            $mostgop = 1;
        }


        $bill_lnk = "<a href='$url' target='_blank'>$bill_id</a>";
        $detail_lnk = "<a href='http://198.74.49.22/housevote_bybill.php?id=$i' target='_blank'>?</a>";
        $legcode = 0;

        switch ($vote) {
            case "Aye":
                $legislator_voted = "<span class='greenme boldme'>AYE</span>";
                $legcode = 2;
                $voteslogged++;
                break;
            case "No":
                $legislator_voted = "<span class='redme boldme'>NO</span>";
                $legcode = 1;
                $voteslogged++;
                break;
            case "Not Voting":
                $legislator_voted = "<span class='grayme'>Didn't Vote</span>";
                $legcode = 0;
                break;
            case "Present":
                $legislator_voted = "<span class='blueme boldme'>Present</span>";
                $legcode = 99;
                $voteslogged++;
                break;
            case "Nay":
                $legislator_voted = "<span class='redme boldme'>NO</span>";
                $legcode = 1;
                $voteslogged++;
                break;
            case "Yea":
                $legislator_voted = "<span class='greenme boldme'>AYE</span>";
                $legcode = 2;
                $voteslogged++;
                break;
            case "Ryan (WI)":
                $legislator_voted = "<span class='greenme boldme'>$vote</span>";
                $legcode = 2;
                break;
            default:
                $legislator_voted = "";
                $legcode = 0;
                break;
        }

        switch ($result) {
            case "P":
                $status = "<span class='greenme boldme'>PASSED</span>";
                $resultcode = 2;
                break;
            case "F":
                $status = "<span class='redme boldme'>FAILED</span>";
                $resultcode = 1;
                break;
            case "A":
                $status = "<span class='blueme boldme'>AMENDED</span>";
                $resultcode = 2;
                break;
            default:
                $status = "";
                $resultcode = 0;
                break;
        }

        if ($i == 2) {
            $resultcode = 2;
        }

        if (!$legislator_voted) {
            $legislator_voted = $vote;
        }

        if ($legcode == 2) {
            $legaye++;
        }

        if ($legcode == 1) {
            $legnoe++;
        }

        if ($legcode == 0) {
            $legnv++;
        }

        if ($legcode == $resultcode && $legcode != 99) {
            $withmajority++;
            $legside = "<span class='boldme'>IN MAJORITY</span>";
        } elseif ($legcode != 0 && $legcode != 99) {
            $withminority++;
            $legside = "<span class='redme boldme'>IN MINORITY</span>";
        } else {
            $legside = "";
        }

        if ($legcode == 99 && $i == 1) {
            $withmajority++;
            $withminority--;
        }

        if ($party == "D") {
            if (($legcode == 1 && $mostdem == 2) || ($legcode == 2 && $mostdem == 1)) {
                if ($i != 2) {
                    $brokewith = "<span class='boldme'>BROKE W/PARTY</span>";
                    $brokewithtot++;
                }
            } else {
                $brokewith = '';
            }
        }

        if ($party == "R") {
            if (($legcode == 1 && $mostgop == 2) || ($legcode == 2 && $mostgop == 1)) {
                if ($i != 2) {
                    $brokewith = "<span class='boldme'>BROKE W/PARTY</span>";
                    $brokewithtot++;
                }
            } else {
                $brokewith = '';
            }
        }

        $rollnumber = $i;

        $adjusted = $rollnumber;

        if ($rollnumber < 10) {
            $adjusted = "00" . $rollnumber;
        } elseif ($rollnumber < 100) {
            $adjusted = "0" . $rollnumber;
        }

        $adjusted_url = "http://clerk.house.gov/evs/2017/roll$adjusted.xml";
        $roll_lnk = "<a href='$adjusted_url'>$adjusted</a>";

        $tablebody .= "
				<tr title='$dscr'>
					<td>$roll_lnk</td>
					<td>$detail_lnk</td>
					<td>$date</td>
					<td>$bill_lnk</td>
					<td>$type</td>
					<td>$legislator_voted</td>
					<td>$status</td>
					<td class='boldme'>$y_tot</td>
					<td class='redme'>$y_gop</td>
					<td class='blueme'>$y_dem</td>
					<td class='boldme'>$n_tot</td>
					<td class='redme'>$n_gop</td>
					<td class='blueme'>$n_dem</td>
					<td>$legside</td>
					<td>$brokewith</td>
				</tr>
	";
        $i++;
    }

    echo($tablehead . $tablebody . "</tbody></table></div>");

    echo("<div class='newseg'>");
    echo("<p>TOTAL ROLL CALL VOTES: $highestroll<br>LEGISLATOR VOTED: $voteslogged (" . makepct($voteslogged, $highestroll) . ")
	  <br><span class='greenme boldme'>YES</span>: $legaye <span class='redme boldme'>NO</span>: $legnoe <span class='grayme itcme boldme'>No Vote</span>: $legnv
	  <br>SIDED WITH MAJORITY: $withmajority (" . makepct($withmajority, $voteslogged) . ")<br>SIDED WITH MINORITY: $withminority (" . makepct($withminority, $voteslogged) . ")
	  <br>BROKE W/MAJORITY OF PARTY $brokewithtot Times</p>");

    function getfedlegislatorvote($rollnumber)
    {
        global $alias;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT vote FROM ctb2016_fedvote_2017 WHERE legislator = \"$alias\" && rollnumber = $rollnumber";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['vote'];
            }
        }

        return $retval;
    }


    function gethighestrollnumber()
    {
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT rollnumber from ctb2016_fedsummary_2017 ORDER BY rollnumber DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['rollnumber'];
            }
        }

        return $retval;
    }


    function getfedbillsummary($rollnumber)
    {
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_fedsummary_2017 WHERE rollnumber = $rollnumber";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }

    function getalias($fourcode)
    {
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT ALIAS from ctb2016_e18_fed WHERE DIST = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['ALIAS'];
            }
        }

        return $retval;
    }

    function getallinfo($fourcode)
    {
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }


    ?>

@endsection

@section('scripts')

<script type="text/javascript" src="js/tablesaw.jquery.js"></script>
<script type="text/javascript" src="js/tablesaw-init.js"></script>
@endsection

@section('styles')
<style>

    .tablesaw {
        font-family: 'PT Sans Narrow';
        padding: 0px;
    }

</style>
@endsection