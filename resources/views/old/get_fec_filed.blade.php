@extends('layouts.iframe')

@section('title', 'FEC Filed | California Target Book')

@section('content')
    


    <?php

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();

    global $year, $fourcode;
    $year = $_GET['yr'];
    $fourcode = $_GET['id'];


    $thisid = "$fourcode_$filed_$year";
    $candidates = getfiledcandidates();


    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

    array_push($endjava, $js);


    $tablehead = "<div class='newseg'>
				<table id='$thisid' class='bordered tablesorter styledtable'>
					<thead>
						<tr>
							<th>CANDIDATE</th>
							<th>PARTY</th>
							<th>FEC ID</th>
						</tr>
					</thead>
					<tbody>";

    foreach ($candidates as $x) {
        $cand_lnk = "<a href='http://www.fec.gov/fecviewer/CandidateCommitteeDetail.do?&tabIndex=3&candidateCommitteeId=" . $x['CAND_ID'] . "' target='_blank'>" . $x['CAND_ID'] . "</a>";
        $bgclass = 'greybg';
        if ($x['PARTY'] == "DEM" || $x['PARTY'] == "D") {
            $bgclass = 'bluebg';
        }

        if ($x['PARTY'] == "REP" || $x['PARTY'] == "R") {
            $bgclass = 'redbg';
        }
        $tablebody .= "<tr class='$bgclass'>
						<td>" . $x['CAND_NM'] . "</td>
						<td>" . $x['PARTY'] . "</td>
						<td>$cand_lnk</td>
					</tr>
	";
    }

    echo($tablehead . $tablebody . "</tbody></table></div>");


    function getfiledcandidates()
    {
        global $fourcode;
        global $year;
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        $state = mb_substr($fourcode, 0, 2);
        $dist = mb_substr($fourcode, 2, 2);
        $retval = Array();

        switch ($year) {
            case "2018":
                $sql = "SELECT * FROM nufec_e18_fed_candidates WHERE FOURCODE = '$fourcode'";
                break;
            case "2016":
                $sql = "SELECT * FROM nufec_cn WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist ORDER BY CAND_PTY_AFFILIATION, CAND_NAME";
                break;
            case "2014":
                $sql = "SELECT * FROM nufec_cn_14 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist ORDER BY CAND_PTY_AFFILIATION, CAND_NAME";
                break;
            case "2012":
                $sql = "SELECT * FROM nufec_cn_12 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist ORDER BY CAND_PTY_AFFILIATION, CAND_NAME";
                break;
        }

        //echo($sql);

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($year != "2018") {
                    $tmp['CAND_NM'] = $row['CAND_NAME'];
                    $tmp['PARTY'] = $row['CAND_PTY_AFFILIATION'];
                    $tmp['CAND_ID'] = $row['CAND_ID'];
                } else {
                    $tmp['CAND_NM'] = $row['cand_nm'];
                    $tmp['PARTY'] = $row['party'];
                    $tmp['CAND_ID'] = $row['cand_id'];
                }
                array_push($retval, $tmp);
            }

        }

        //var_dump($retval);
        return $retval;
    }

    //include 'php/storgsearch.php';


    ?>


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

    .bluebg {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .redbg {
        background: #f0d4d4; /* Old browsers */
        background: -moz-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f0d4d4', endColorstr='#fefefe', GradientType=0); /* IE6-9 */
    }

    .greybg {
        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    .styledtable {
        font-family: 'PT Sans Narrow';
        font-weight: bold;
    }

    .styledtable a {
        font-weight: bold;
        color: DarkBlue;
    }
</style>
@endsection