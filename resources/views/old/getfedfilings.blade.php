@extends('layouts.iframe')

@section('title', 'FED Filings | California Target Book')

@section('content')


    

    <?php

    ini_set('memory_limit', '512M');

    Util::set_errors();
    Util::require_ctb_api();

    $endjava = Array();

    $cmte_id = $_GET['id'];

    $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n"
        )
    );

    $context = stream_context_create($opts);

    $raw = file_get_contents('http://docquery.fec.gov/cgi-bin/forms/' . $cmte_id, false, $context);

    $rowarr = explode("<tr align='left'>", $raw);

    $entries = Array();

    $rowcnt = 0;
    foreach ($rowarr as $row) {

        $regex = '~\/\'\>(.*?)\<~mis';
        preg_match($regex, $row, $results);
        $formtype = $results[1];

        $amendtype = substr($formtype, -1);

        $form = rtrim($formtype, $amendtype);

        $regex = '~FEC-(.*?)\<~mis';
        preg_match($regex, $row, $results);
        $filing_id = $results[1];

        $regex = '~\>([0-9][0-9].*?)\<~mis';
        preg_match($regex, $row, $results);
        $date1 = $results[1];

        $regex = '~\>[0-9][0-9].*?\>([0-9][0-9].*?)\<~mis';
        preg_match($regex, $row, $results);
        $date2 = $results[1];

        $regex = '~\>[0-9][0-9].*?\>[0-9][0-9].*?\>([0-9][0-9].*?)\<~mis';
        preg_match($regex, $row, $results);
        $date3 = $results[1];

        if ($amendtype == "9") {
            $form = "F99";
            $amendtype = "N";
        }


        if ($date3) {
            $filing_date = $date3;
            $pd_start = $date1;
            $pd_end = $date2;
            $coverage = "Covering $date1 to $date2";
        } else {
            $filing_date = $date1;
            $coverage = "";
            $pd_start = '';
            $pd_end = '';
        }

        $regex = '~\<DD\>.*?\'left\'\>(.*?)\<~mis';
        preg_match($regex, $row, $results);
        $rpt_type = $results[1];


        $entries[$form][$filing_id]['FORM'] = $form;
        $entries[$form][$filing_id]['SEQUENCE'] = $amendtype;
        $entries[$form][$filing_id]['FILING_ID'] = $filing_id;
        $entries[$form][$filing_id]['FILING_DT'] = $filing_date;
        $entries[$form][$filing_id]['PD_START'] = $pd_start;
        $entries[$form][$filing_id]['PD_END'] = $pd_end;
        $entries[$form][$filing_id]['RPT_TYPE'] = $rpt_type;


    }


    $tableend = "</tbody></table>";

    $committee_name = getfeccommitteename($cmte_id);

    $cmte_lnk = "<a href='http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $cmte_id . "' target='_blank'>" . $committee_name . "</a>";
    $ie_lnk = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte_id . "' target='_blank'>IE DETAIL</a>";
    $cf_lnk = "<a href='http://198.74.49.22/fedcm.php?id=" . $cmte_id . "' target='_blank'>CONTRIBUTOR SUMMARY</a>";
    $headline = "<div class='newseg'><h1>$cmte_lnk</h1><p align='center'>$ie_lnk • $cf_lnk</p></div>";

    echo($headline);

    foreach ($entries as $type) {
        $ecount = 0;
        foreach ($type as $filing) {
            if ($ecount == 0) {
                if ($filing['FORM']) {
                    $thisid = $filing['FORM'];
                    if (!$thisid) {
                        $ecount++;
                        continue;
                    }
                    $verbose = getverbose($filing['FORM']);
                    $thisid = $filing['FORM'];

                    $js = "$(document).ready(function() {
				    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
				});";
                    array_push($endjava, $js);

                    echo("<div class='newseg'><h1>$verbose</h1>");
                    $tablehead = "
					<table id='$thisid' class='bordered tablesorter'>
						<thead>
							<tr>
								<th>FILING</th>
								<th>FEC LNK</th>
								<th>FILED</th>
								<th>NEW/AMEND</th>
								<th>REPORT</th>
								<th>PERIOD START</th>
								<th>PERIOD END</th>
							</tr>
						</thead>
				";
                    echo($tablehead);
                    $tablebody = '';
                }
            }

            if ($filing['SEQUENCE'] == "A") {
                $longseq = "AMENDED";
            }

            if ($filing['SEQUENCE'] == "N") {
                $longseq = "NEW";
            }

            if ($filing['SEQUENCE'] == "9") {
                $longseq = "N/A";
            }

            if ($filing['FILING_ID']) {
                $link = "<a href='http://198.74.49.22/fedparser.php?id=" . $filing['FILING_ID'] . "' target='_blank'>" . $filing['FILING_ID'] . "</a>";
                $feclink = "<a href='http://docquery.fec.gov/cgi-bin/forms/" . $cmte_id . "/" . $filing['FILING_ID'] . "' target='_blank'>LNK</a>";

                $tablebody .= "
						<tr>
							<td>$link</td>
							<td>$feclink</td>
							<td>" . $filing['FILING_DT'] . "</td>
							<td>$longseq</td>
							<td>" . $filing['RPT_TYPE'] . "</td>
							<td>" . $filing['PD_START'] . "</td>
							<td>" . $filing['PD_END'] . "</td>
						</tr>

			";
            }
            $ecount++;
        }

        if ($tablebody) {
            echo($tablebody . $tableend . "</div>");
        }
    }

    echo("$tableend </div>");

    function getverbose($type)
    {
        switch ($type) {
            case "F3":
                $retval = "CANDIDATE CAMPAIGN STATEMENT";
                break;
            case "F3X":
                $retval = "COMMITTEE CAMPAIGN STATEMENT";
                break;
            case "F3P":
                $retval = "PRESIDENTIAL CANDIDATE CAMPAIGN STATEMENT";
                break;
            case "F6":
                $retval = "LATE CONTRIBUTION REPORT";
                break;
            case "F24":
                $retval = "24/48 HOUR EXPENDITURE REPORT";
                break;
            case "F5":
                $retval = "INDEPENDENT EXPENDITURE REPORT";
                break;
            case "F99":
                $retval = "MISC REPORT TO FEC";
                break;
            case "F2":
                $retval = "STATEMENT OF CANDIDACY";
                break;
            case "F1":
                $retval = "STATEMENT OF ORGANIZATION";
                break;
            case "F":
                $retval = "MISC REPORT TO FEC";
                break;
            default:
                $retval = '';
                break;
        }

        return $retval;
    }

    ?>




@endsection

@section('scripts')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

@section('styles')
<style type="text/css">

    .box1800 {
        background-image: url(/ctb-legacy/img/ctb_dark.png);
        background-size: 100px 80px;
        background-position: right top;
        background-repeat: no-repeat;

    }

    .ignoreme {
        display: none;
    }

    .newseg h2 {
        padding-left: 0;
        padding-right: 0;
    }

</style>
@endsection