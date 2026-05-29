@extends('layouts.master')

@section('title', 'House Candidates | California Target Book')

@section('content')


    <?php

    Util::set_errors();
    Util::require_ctb_api();
    Util::include('php/rosterqs.php');

    $endjava = Array();

    global $year;
    $year = $_GET['yr'];

    populate_financials();


    switch ($year) {
        case "18":
            $table = "nufec18_cn";
            break;
        case "16":
            $table = "nufec_cn";
            break;
        case "14":
            $table = "nufec_cn_14";
            break;
        case "12":
            $table = "nufec_cn_12";
            break;
        case "10":
            $table = "nufec_cn_10";
            break;
        case "08":
            $table = "nufec_cn_08";
            break;
        case "06":
            $table = "nufec_cn_06";
            break;
    }

    $conn = Util::get_ctb_conn();

    $election = "20" . $year;

    $sql = "SELECT * FROM $table WHERE CAND_ELECTION_YR = '$election' ORDER BY CAND_OFFICE_ST, CAND_OFFICE_DISTRICT";

    //echo("<br>QUERYING $db with $sql");

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {


            $cand_id = $row['CAND_ID'];
            if ($row['CAND_OFFICE'] == "H") {
                $fourcode = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
            } elseif ($row['CAND_OFFICE'] == "S") {
                $fourcode = $row['CAND_OFFICE_ST'] . "SEN";
            } elseif ($row['CAND_OFFICE'] == "P") {
                continue;
            }

            if ($row['CAND_ICI'] == "I") {
                $role = "Incumbent";
            } elseif ($row['CAND_ICI'] == "C") {
                $role = "Challenger";
            } elseif ($row['CAND_ICI'] == "O") {
                $role = "Open Seat";
            }

            $raised = number_format($financials_arr[$election][$cand_id]['RAISED']);
            $spent = number_format($financials_arr[$election][$cand_id]['SPENT']);

            $fec_cand_lnk = "<a href='http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $row['CAND_ID'] . "' target='_blank'>" . $row['CAND_ID'] . "</a>";
            $fec_cmte_lnk = "<a href='http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $row['CAND_PCC'] . "' target='_blank'>" . $row['CAND_PCC'] . "</a>";
            $cand_addr = $row['CAND_CITY'] . ", " . $row['CAND_ST'] . " " . $row['CAND_ZIP'];

            $table_body .= "<tr class='rowsearch'>
							<td>" . $row['CAND_NAME'] . "</td>
							<td>" . $row['CAND_PTY_AFFILIATION'] . "</td>
							<td>" . $fourcode . "</td>
							<td>" . $role . "</td>
							<td>" . $cand_addr . "</td>
							<td align='right'>" . $raised . "</td>
							<td align='right'>" . $spent . "</td>
							<td>$fec_cand_lnk</td>
							<td>$fec_cmte_lnk</td>
						</tr>";

        }
    }

    $thisid = "fec_cands";

    $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

    //array_push($endjava, $js);

    $table_head = "<div class='newseg container' style='margin-top: 50px;'>
				<div class='row'>
					<div class='col-lg-12'>
						<table class='bordered tablesorter' id='$thisid'>
							<thead>
								<tr>
									<th>Candidate</th>
									<th>Party</th>
									<th>Race</th>
									<th>Role</th>
									<th>Addr</th>
									<th>Raised</th>
									<th>Spent</th>
									<th>FEC Candidate ID</th>
									<th>FEC Committee ID</th>
								</tr>
							</thead>
							<tbody>";

    echo($table_head . $table_body . "</tbody></table>");
    echo("</div></div></div>");

    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({
            headers: {
                5: {
                    sorter:'fancyNumber'
                },
                6: {
                    sorter:'fancyNumber'
                }
            }
        });
});

jQuery.tablesorter.addParser({
  id: \"fancyNumber\",
  is: function(s) {
    return /^[0-9]?[0-9,\.]*$/.test(s);
  },
  format: function(s) {
    return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
  },
  type: \"numeric\"
});

";

    array_push($endjava, $js);

    function populate_financials()
    {
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        global $financials_arr;
        global $party;

        $years = Array("2006", "2008", "2010", "2012", "2014", "2016");

        foreach ($years as $year) {

            $last_two = mb_substr($year, 2, 2);
            if ($year != "2016") {
                $table = "nufec_weball_" . $last_two;
            } else {
                $table = "nufec_weball";
            }

            $sql = "SELECT * FROM $table";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cand_id = $row['CAND_ID'];
                    $financials_arr[$year][$cand_id]['RAISED'] = $row['TTL_RECEIPTS'];
                    $financials_arr[$year][$cand_id]['SPENT'] = $row['TTL_DISB'];

                }
            }
        }

        global $fec18_conn;
        $conn = Util::get_ctb_conn();

        $year = "2018";
        $sql = "SELECT * FROM nufec18_weball";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cand_id = $row['CAND_ID'];
                $financials_arr[$year][$cand_id]['RAISED'] = $row['TTL_RECEIPTS'];
                $financials_arr[$year][$cand_id]['SPENT'] = $row['TTL_DISB'];

            }
        }

    }

    ?>


@endsection

@section('scripts')
    <Script>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </Script>
@endsection
