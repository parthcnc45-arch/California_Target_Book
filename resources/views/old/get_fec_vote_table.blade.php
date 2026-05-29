@extends('layouts.iframe')

@section('title', 'FEC Votes | California Target Book')

@section('content')
    



    <?php

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();


    global $fourcode;
    $fourcode = $_GET['id'];


    $x = getpres_results($fourcode);


    $hrc = number_format($x['CLINTON'], 1);
    $djt = number_format($x['TRUMP'], 1);
    $bho = number_format($x['OBAMA'], 1);
    $wmr = number_format($x['ROMNEY'], 1);

    $g16 = get_house_results($fourcode, '2016');
    $g14 = get_house_results($fourcode, '2014');
    $g12 = get_house_results($fourcode, '2012');

    $house_table = "<table width='800px' class='bordered tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
				<tbody style='font-size: 12pt;'>
					<tr>
						<th colspan='2'>House 2012</th>
						<th colspan='2'>House 2014</th>
						<th colspan='2'>House 2016</th>
					</tr>

";

    $pres_table = "<table width='500px' class='bordered tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
				<tbody style='font-size: 12pt;'>
					<tr>
						<th colspan='2'>President 2012</th>
						<th colspan='2'>President 2016</th>
					</tr>
					<tr>

";

    if ($hrc > $djt) {
        $g16_pres_column = "<td id='blueColumn'><span class='winner'>Hillary Clinton (D)</span>
																<br>Donald Trump (R)</td>";
        $g16_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $hrc . "%</span><br>" . $djt . "%</td>";
    } else {
        $g16_pres_column = "<td id='blueColumn'><span class='winner'>Donald Trump (R)</span>
																<br>Hillary Clinton (D)</td>";
        $g16_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $djt . "%</span><br>" . $hrc . "%</td>";
    }


    if ($bho > $wmr) {
        $g12_pres_column = "<td id='blueColumn'><span class='winner'>Barack Obama (D-Inc)</span>
																<br>Mitt Romney (R)</td>";
        $g12_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $bho . "%</span><br>" . $wmr . "%</td>";
    } else {
        $g12_pres_column = "<td id='blueColumn'><span class='winner'>Mitt Romney (R)</span>
																<br>Barack Obama (D-Inc)</td>";
        $g12_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $wmr . "%</span><br>" . $bho . "%</td>";
    }

    $pres_table .= $g12_pres_column . $g12_pres_pct_column . $g16_pres_column . $g16_pres_pct_column . "</tr></tbody></table>";


    $g12_cand_column = "<td id='blueColumn'>";
    $g12_pct_column = "<td id='greColumn'>";


    $g14_cand_column = "<td id='blueColumn'>";
    $g14_pct_column = "<td id='greColumn'>";


    $g16_cand_column = "<td id='blueColumn'>";
    $g16_pct_column = "<td id='greColumn'>";

    foreach ($g12 as $e) {
        $g12_total += $e['VOTES'];
    }

    foreach ($g14 as $e) {
        $g14_total += $e['VOTES'];
    }

    foreach ($g16 as $e) {
        $g16_total += $e['VOTES'];
    }

    $i = 0;
    foreach ($g12 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g12_total);


        if ($i > 0) {
            $g12_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g12_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g12_pct_column .= "<br>$this_pct";
        } else {
            $g12_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        $i++;
    }

    $i = 0;
    foreach ($g14 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g14_total);


        if ($i > 0) {
            $g14_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g14_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g14_pct_column .= "<br>$this_pct";
        } else {
            $g14_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        $i++;
    }

    $i = 0;
    foreach ($g16 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g16_total);


        if ($i > 0) {
            $g16_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g16_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g16_pct_column .= "<br>$this_pct";
        } else {
            $g16_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        $i++;
    }


    $house_table .= "<tr>" . $g12_cand_column . $g12_pct_column . $g14_cand_column . $g14_pct_column . $g16_cand_column . $g16_pct_column . "</tr></tbody></table>";

    echo("<div align='center' width='800px'>");

    echo($house_table);
    echo($pres_table);

    echo("</div>");

    function get_house_results($fourcode, $year)
    {
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT * FROM nufec_election_results WHERE YEAR = $year && FOURCODE = '$fourcode' ORDER BY VOTES DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($retval, $row);
            }
        }

        return $retval;
    }


    function getpres_results($fourcode)
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

    //include 'php/storgsearch.php';


    ?>


@endsection

@section('scripts')
    <script type="text/javascript" src="/js/tablesaw.jquery.js"></script>
    <script type="text/javascript" src="/js/tablesaw-init.js"></script>

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

    #districtWrapper {
        box-shadow: 3px 3px 3px #999;
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