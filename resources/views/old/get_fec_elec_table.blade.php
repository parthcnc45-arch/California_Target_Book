
@extends('layouts.iframe')

@section('title', 'FEC Election | California Target Book')

@section('content')
    


    <?php

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();

    global $year, $fourcode, $vot_tot;
    $year = $_GET['yr'];
    $fourcode = $_GET['id'];
    $vot_tot = 0;


    $thisid = $fourcode . "_" . "House_Results_" . $year;

    $house = gethouseresults();

    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

    array_push($endjava, $js);


    $tablehead = "<div class='newseg'>
				<table id='$thisid' class='bordered tablesorter'>
					<thead>
						<tr>
							<th>CANDIDATE</th>
							<th>PARTY</th>
							<th>VOTES</th>
							<th>%</th>
						</tr>
					</thead>
					<tbody>";

    $i = 0;
    foreach ($house as $x) {

        $party = $x['PARTY'];
        $vote_num = $x['VOTES'];
        $vote_pct = makepct($vote_num, $vot_tot);
        if ($i == 0) {
            $row_class = 'winner';
        } else {
            $row_class = '';
        }

        if (substr($party, -3) == "Inc") {
            $row_class .= " itcme ";
        }

        if (mb_substr($party, 0, 2) == "D-") {
            $bg_class = "blueColumn";
        } elseif (mb_substr($party, 0, 2) == "R-") {
            $bg_class = "redbg";
        } else {
            $bg_class = "greyColumn";
        }

        if ($party == "R") {
            $bg_class = "redbg";
        }

        if ($party == "D") {
            $bg_class = "blueColumn";
        }


        $tablebody .= "<tr class='$row_class'>
						<td class='$bg_class'>" . $x['NAME'] . "</td>
						<td class='$bg_class'>" . $x['PARTY'] . "</td>
						<td class='greyColumn'>" . $vote_num . "</td>
						<td class='greyColumn'>" . $vote_pct . "%</td>
	";

        $i++;
    }

    echo($tablehead . $tablebody . "</tbody></table></div>");

    function gethouseresults()
    {
        global $fourcode;
        global $year;
        global $vot_tot;
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT * FROM nufec_election_results WHERE `YEAR` = $year && FOURCODE = '$fourcode' ORDER BY VOTES DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $x['NAME'] = $row['NAMF'] . " " . $row['NAML'];
                $x['VOTES'] = $row['VOTES'];
                $x['PARTY'] = $row['PARTY'];
                if ($row['INC'] == "Inc") {
                    $x['PARTY'] .= "-Inc";
                }
                $vot_tot += $row['VOTES'];
                array_push($retval, $x);
            }
        }

        return $retval;
    }

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
                $sql = "SELECT * FROM nufec_cn WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
                break;
            case "2014":
                $sql = "SELECT * FROM nufec_cn_14 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
                break;
            case "2012":
                $sql = "SELECT * FROM nufec_cn_12 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
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

    th {

        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        font-size: 1.4em;
        text-align: center;
    }

    .bordered td {
        font-family: 'Lato';
        padding: 5px;
        border: none;
        font-size: 1.2em;
    }

    .bordered th {
        font-family: 'Lato';
        text-align: center;
        font-size: 1.4em;
    }

    .greyColumn {

        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    .blueColumn {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .winner {
        font-weight: bold;
        font-variant: small-caps;
    }

    .redbg {
        background: #f0d4d4; /* Old browsers */
        background: -moz-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f0d4d4', endColorstr='#fefefe', GradientType=0); /* IE6-9 */
    }

</style>
@endsection