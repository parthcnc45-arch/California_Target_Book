
@extends('layouts.master')

@section('title', 'Full Candidate Directory')

@section('content')
    <div class="container">

        <?php

        $endjava = Array();
        Util::require_ctb_api();

        $x = get_ca_candidates();
        $y = get_fed_candidates();

        foreach ($x as $cand) {
            $fullname = $cand['FULLNAME'];
            $year = $cand['ELECTION'];
            $party = $cand['PARTY'];
            $is_incumbent = $cand['IS_INCUMBENT'];
            $cand_id = $cand['CAND_ID'];
            $office = $cand['OFFICE'];

            if (!array_key_exists($fullname, $fullarr)) {
                $fullarr[$fullname] = [];
            }
            if (!array_key_exists($year, $fullarr[$fullname])) {
                $fullarr[$fullname][$year] = [];
            }
            if (!array_key_exists($office, $fullarr[$fullname][$year])) {
                $fullarr[$fullname][$year][$office] = [
                    'PARTY' => $party,
                    'IS_INCUMBENT' => $is_incumbent,
                    'CAND_ID' => $cand_id,
                ];
            }

        }

        foreach ($y as $cand => $o) {
            foreach ($o as $office => $y) {
                foreach ($y as $year => $v) {
                    $fullname = $cand;
                    $fullarr[$fullname][$year][$office]['PARTY'] = $v['CAND_PTY_AFFILIATION'];
                    if ($v['CAND_ICI'] == "I") {
                        $fullarr[$fullname][$year][$office]['IS_INCUMBENT'] = "INC";
                    }
                    $fullarr[$fullname][$year][$office]['CAND_ID'] = $v['CAND_ID'];
                }
            }
        }

        $thisid = "candidates";

        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

        array_push($endjava, $js);


        $tablehead = "<div class='newseg'>
				<table id='$thisid' class='bordered tablesorter'>
					<thead>
						<tr>
							<th>NAME</th>
							<th>PARTY</th>
							<th>INCUMBENT</th>
							<th>OFFICE</th>
							<th>YEAR</th>
							<th>CAND ID</th>
						</tr>
					</thead>
					<tbody>";

        $tablebody = '';
        foreach ($fullarr as $fullname => $v) {
            foreach ($v as $year => $o) {
                foreach ($o as $office => $r) {
                    $tablebody .= "<tr>
									<td>$fullname</td>
									<td>" . $r['PARTY'] . "</td>
									<td>" . $r['IS_INCUMBENT'] . "</td>
									<td>$office</td>
									<td>$year</td>
									<td>" . $r['CAND_ID'] . "</td>
								</tr>";
                }
            }


        }

        echo($tablehead . $tablebody . "</tbody></table></div>");

        function get_ca_candidates()
        {
            $conn = Util::get_ctb_conn();
            $retval = Array();
            $sql = "SELECT * FROM ctb_ca_candidates";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    if (mb_substr($row['race'], 0, 3) == "PR_") {
                        continue;
                    }


                    $tmpnm = $row['name'];

                    //echo("<br>STARTING WITH $tmpnm...");


                    $tmpnm = str_replace("Mc ", "Mc", $tmpnm);
                    $tmpnm = str_replace(",", "", $tmpnm);
                    $tmpnm = str_replace("Jr.", "", $tmpnm);
                    $tmpnm = str_replace("Sr.", "", $tmpnm);
                    $tmpnm = str_replace("III", "", $tmpnm);
                    $tmpnm = str_replace("II", "", $tmpnm);
                    $tmpnm = str_replace("*", "", $tmpnm);
                    $tmpnm = trim($tmpnm);

                    //echo("Processed to $tmpnm...");

                    $regex = '~.*\s(.*)~mis';
                    preg_match($regex, $tmpnm, $results);
                    $naml = $results[1];
                    //echo("Extracted Surname $naml...");

                    $regex = '~(.*)\s~mis';
                    preg_match($regex, $tmpnm, $results);
                    $namf = $results[1];
                    //echo("Extracted Given Name $namf...");

                    $findme = "Jr.";
                    $isjr = substr_count($row['name'], $findme);

                    $findme = "Sr.";
                    $issr = substr_count($row['name'], $findme);

                    $findme = "III";
                    $is3rd = substr_count($row['name'], $findme);

                    $findme = "II";
                    $is2nd = substr_count($row['name'], $findme);

                    if ($isjr) {
                        $naml .= ", Jr.";
                    }

                    if ($issr) {
                        $naml .= ", Sr.";
                    }

                    if ($is3rd) {
                        $naml .= ", III";
                    }

                    if ($is2nd) {
                        $naml .= ", II";
                    }

                    //echo("Final Surname $naml...");

                    $fullname = strtoupper($naml . ", " . $namf);

                    //echo("FULLNAME: $fullname");

                    $tmpoffice = mb_substr($row['race'], 0, 3);

                    switch ($tmpoffice) {
                        case "ASS":
                            $office = "AD" . checkaddzero($row['distnum']);
                            break;
                        case "SEN":
                            $office = "SD" . checkaddzero($row['distnum']);
                            break;
                        case "CNG":
                            $office = "CA" . checkaddzero($row['distnum']);
                            break;
                        case "BOE":
                            $office = "BOE" . $row['distnum'];
                            break;
                        default:
                            $office = $tmpoffice;
                            break;
                    }

                    $election = $row['election'];

                    $tmp['NAML'] = $naml;
                    $tmp['NAMF'] = $namf;
                    $tmp['FULLNAME'] = $fullname;
                    $tmp['OFFICE'] = $office;
                    $tmp['ELECTION'] = $election;
                    $tmp['CAND_ID'] = $row['cand_id'];
                    $tmp['PARTY'] = $row['party'];
                    $tmp['IS_INCUMBENT'] = $row['is_incumbent'];

                    array_push($retval, $tmp);

                }
            }

            return $retval;
        }

        function get_fed_candidates()
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT * FROM nufec_cn";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullname = $row['CAND_NAME'];
                    $party = $row['CAND_PTY_AFFILIATION'];
                    $ofc = $row['CAND_OFFICE'];
                    $year = $row['CAND_ELECTION_YR'];

                    switch ($ofc) {
                        case "H":
                            $office = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
                            break;
                        case "S":
                            $office = $row['CAND_OFFICE_ST'] . "SEN";
                            break;
                        case "P":
                            $office = "POTUS";
                            break;
                    }

                    $retval[$fullname][$office][$year] = $row;

                }
            }

            $sql = "SELECT * FROM cn_12";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullname = $row['CAND_NAME'];
                    $party = $row['CAND_PTY_AFFILIATION'];
                    $ofc = $row['CAND_OFFICE'];
                    $year = $row['CAND_ELECTION_YR'];

                    switch ($ofc) {
                        case "H":
                            $office = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
                            break;
                        case "S":
                            $office = $row['CAND_OFFICE_ST'] . "SEN";
                            break;
                        case "P":
                            $office = "POTUS";
                            break;
                    }

                    $retval[$fullname][$office][$year] = $row;

                }
            }


            $sql = "SELECT * FROM cn_14";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullname = $row['CAND_NAME'];
                    $party = $row['CAND_PTY_AFFILIATION'];
                    $ofc = $row['CAND_OFFICE'];
                    $year = $row['CAND_ELECTION_YR'];

                    switch ($ofc) {
                        case "H":
                            $office = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
                            break;
                        case "S":
                            $office = $row['CAND_OFFICE_ST'] . "SEN";
                            break;
                        case "P":
                            $office = "POTUS";
                            break;
                    }

                    $retval[$fullname][$office][$year] = $row;

                }
            }

            $sql = "SELECT * FROM e18_fed_candidates";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fullname = $row['cand_nm'];
                    $office = $row['fourcode'];
                    $party = $row['party'];
                    $year = "2018";

                    $retval[$fullname][$office][$year]['CAND_ID'] = $row['cand_id'];
                    $retval[$fullname][$office][$year]['CAND_PTY_AFFILIATION'] = $row['party'];

                }
            }

            return $retval;

        }

        ?>


    </div>
@endsection



@section('scripts')
    <script>gtag('set', { 'book_category': 'candidates' });</script>
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection


