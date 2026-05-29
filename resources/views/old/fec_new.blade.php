

@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'FEC Filings - New | California Target Book')

@section('content')


    <div class='container-fluid'>
        <div class='row'>
            <div class='col-lg-12'>

                <?php


                setlocale(LC_COLLATE, "en_US");
                setlocale(LC_CTYPE, "en_US");
                set_time_limit(0);
                error_reporting(E_ALL);
                ini_set('display_errors', '1');

                $endjava = Array();

//                Util::require_ctb_api();

                $opts = array(
                    'http' => array(
                        'method' => "GET",
                        'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n"
                    )
                );

                $context = stream_context_create($opts);

                ini_set('memory_limit', '-1');
                $xml_raw = file_get_contents('http://efilingapps.fec.gov/rss/generate?preDefinedFilingType=ALL', false, $context);

                $xml = simplexml_load_string($xml_raw);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);

                $tablebody = Array();


                //var_dump($fedie);

                $i = 0;
                foreach ($array as $segment) {
                    //echo("<br>SEGMENT $i:<br>");
                    $j = 0;
                    foreach ($segment as $entry) {
                        if ($j == 3) {
                            $filings = $entry;
                        }
                        $j++;
                    }
                    $i++;
                }

                foreach ($filings as $filing) {
                    //$filer_name = ltrim($filing['title'], "New filing by ");
                    $filer_name = substr($filing['title'], 14);
                    $url = $filing['link'];

                    $regex = '~FormType:\s(.*?)\s~';
                    preg_match($regex, $filing['description'], $results);
                    $form_type = $results[1];

                    $regex = '~CoverageFrom:\s(.*?)\s~mis';
                    preg_match($regex, $filing['description'], $results);
                    $period_start = $results[1];

                    $regex = '~CoverageThrough:\s(.*?)\s~mis';
                    preg_match($regex, $filing['description'], $results);
                    $period_end = $results[1];

                    $regex = '~CommitteeId:\s(.*?)\s~';
                    preg_match($regex, $filing['description'], $results);
                    $filer_id = $results[1];

                    $regex = '~FilingId:\s(.*?)\s~';
                    preg_match($regex, $filing['description'], $results);
                    $filing_id = $results[1];

                    $regex = '~.\s(.*?)\s~';
                    preg_match($regex, $filing['pubDate'], $results);
                    $day = $results[1];

                    $regex = '~[0-9]\s(.*?)\s~';
                    preg_match($regex, $filing['pubDate'], $results);
                    $month = $results[1];
                    $month = dateadjust($month);

                    $regex = '~[a-z]\s(.*?)\s~';
                    preg_match($regex, $filing['pubDate'], $results);
                    $year = $results[1];

                    $regex = '~\s([0-9][0-9]:.*)\s~';
                    preg_match($regex, $filing['pubDate'], $results);
                    $time = $results[1];

                    $timestamp = $year . "-" . $month . "-" . $day . " ($time)";

                    $thistime = strtotime($year . "-" . $month . "-" . $day . " " . $time);
                    $timeago = humanTiming($thistime);


                    if ($period_start) {
                        $coverage = "From $period_start to $period_end";
                    } else {
                        $coverage = '';
                    }

                    if (!$filer_name && $filer_id) {
                        $filer_name = getfeccommitteename($filer_id);
                        if ($form_type == "F2N") {
                            $filer_name = "<span class='redme boldme' style='letter-spacing: 5px;'>****   NEW CANDIDATE FILING   ****</span>";
                        }
                    }

                    $thistype = longform($form_type);
                    $summary_link = "<a href='http://docquery.fec.gov/cgi-bin/forms/" . $filer_id . "/" . $filing_id . "' target='_blank'>Summary</a>";

                    $filing_link = "<a href='http://docquery.fec.gov/dcdev/posted/" . $filing_id . ".fec'>DOWNLOAD</a>";
                    $parser_link = "<a href='http://198.74.49.22/fedparser2.php?id=" . $filing_id . "'>$filing_id</a>";
                    $committee_link = "<a href='http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $filer_id . "' target='_blank'>$filer_id</a>";
                    //$committee_link = "<a href='https://www.fec.gov/data/committee/" . $filer_id . "/?tab=filings' target='_blank'>" . $filer_id . "</a>";

                    $all_lnk = "<a href='http://198.74.49.22/getfedfilings.php?id=$filer_id' target='_blank'>ALL</a>";

                    //echo("<br>$thistype FILING FROM $filer_name ($filer_id) - (FORM $form_type) $coverage - Filing #$filing_id <br>");
                    //var_dump($filing);

                    $tmp = "
		<tr title='$thistype'>
			<td>$timeago Ago</td>
			<td id='timestamp'>$timestamp</td>
			<td id='formtype'>$form_type</td>
			<td>$parser_link</td>
			<td>$summary_link</td>
			<td id='filing'>$filing_link</td>
			<td>$filer_name</td>
			<td>$period_start</td>
			<td>$period_end</td>
			<td>$committee_link</td>
			<td>$all_lnk</td>

		</tr>
	";

                    if (substr($form_type, -1) != "A") {
                        if (mb_substr($form_type, 0, 2) != "F8") {
                            array_push($tablebody, $tmp);
                        }
                    }
                }

                $thisid = "rss";

                $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

                array_push($endjava, $js);

                $tablehead = "
	<div class='newseg'>
		<table id='$thisid' class='table table-bordered table-hover tablesaw tablesaw-stack bordered tablesorter' data-tablesaw-mode='stack'>
			<thead>
				<tr>
					<th width='100px'>POSTED</th>
					<th width='150px'>LOGGED</th>
					<th>FORM</th>
					<th width='75px'>VIEW FILING</th>
					<th>SUMMARY</th>
					<th>DOWNLOAD</th>
					<th>FILER NAME</th>
					<th width='75px'>PERIOD START</th>
					<th width='65px'>PERIOD END</th>
					<th>FILER_ID</th>
					<th>ALL</th>

				</tr>
			</thead>
			<tbody>
";



                echo($tablehead);

                foreach ($tablebody as $entry) {
                    echo($entry);
                }
                echo("</tbody></table></div>");

                function humanTiming($time)
                {

                    $time = time() - $time; // to get the time since that moment
                    $time = ($time < 1) ? 1 : $time;
                    $tokens = array(
                        31536000 => 'year',
                        2592000 => 'month',
                        604800 => 'week',
                        86400 => 'day',
                        3600 => 'hour',
                        60 => 'minute',
                        1 => 'second'
                    );

                    foreach ($tokens as $unit => $text) {
                        if ($time < $unit) continue;
                        $numberOfUnits = floor($time / $unit);

                        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
                    }

                }

                function longform($form_type)
                {

                    if ($form_type != "F99") {

                        $regex = '~F([0-9].*?)[A-Z]~';
                        preg_match($regex, $form_type, $results);
                        $form_number = $results[1];

                        $regex = '~[0-9].*?([A-Z].*)~';
                        preg_match($regex, $form_type, $results);
                        $interval = $results[1];

                        if (mb_substr($interval, 0, 1) == "X") {
                            $form_type = "F" . $form_number . "X";
                        } elseif (mb_substr($interval, 0, 1) == "L") {
                            $form_type = "F" . $form_number . "L";
                        } else {
                            $form_type = "F" . $form_number;
                        }
                    }

                    switch ($form_type) {
                        case "F1":
                            $id = "Statement of Organization";
                            break;
                        case "F2":
                            $id = "Statement of Candidacy";
                            break;
                        case "F3":
                            $id = "Receipt/Disbursement";
                            break;
                        case "F3X":
                            $id = "Receipt/Disbursement from Non-Candidate Committees";
                            break;
                        case "F3L":
                            $id = "Receipts Bundled by Lobbyists";
                            break;
                        case "F6":
                            $id = "48-Hour Notice of Contributions/Loans Received";
                            break;
                        case "F8":
                            $id = "Debt Settlement Plan";
                            break;
                        case "F13":
                            $id = "Inaugural Committee Donation Report";
                            break;
                        case "F5":
                            $id = "Independent Expenditure Made/Contribution Received";
                            break;
                        case "F9":
                            $id = "24-Hour Notice of Disbursements for Electioneering Communications";
                            break;
                        case "F24":
                            $id = "24-Hour Notice of Contribution Made/Received";
                            break;
                        case "F99":
                            $id = "Miscellaneous Report";
                            break;
                        case "F4":
                            $id = "National Convention Committee Report";
                            break;
	 	        default:
			    $id = "Unknown";
			    break;
                    }

                    return $id;
                }

                function dateadjust($abbreviation)
                {
                    switch ($abbreviation) {
                        case "Jan":
                            $x = "01";
                            break;
                        case "Feb":
                            $x = "02";
                            break;
                        case "Mar":
                            $x = "03";
                            break;
                        case "Apr":
                            $x = "04";
                            break;
                        case "May":
                            $x = "05";
                            break;
                        case "Jun":
                            $x = "06";
                            break;
                        case "Jul":
                            $x = "07";
                            break;
                        case "Aug":
                            $x = "08";
                            break;
                        case "Sep":
                            $x = "09";
                            break;
                        case "Oct":
                            $x = "10";
                            break;
                        case "Nov":
                            $x = "11";
                            break;
                        case "Dec":
                            $x = "12";
                            break;
                    }

                    return $x;
                }

                /*
                if($msg) {
                    $to      = 'rpyers@gmail.com';
                    $subject = 'KEY RACE ALERT';
                    $message = $msg;
                    $headers = 'From: webmaster@10.0.1.3' . "\r\n" .
                        'Reply-To: webmaster@10.0.1.3' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $mail = mail($to, $subject, $message, $headers);
                        echo($message);

                }
                */


                ?>

            </div>
        </div>
    </div>


@endsection


@section("scripts")
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
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
    }

    .tablesaw td {
        padding-top: 0px;
        padding-bottom: 0px;
    }

</style>
@endsection
