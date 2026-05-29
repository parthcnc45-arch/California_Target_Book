
@php ($book_side_nav_active = 'candidates')
@extends('layouts.book')

@section('title', '2020 Primary Ballot (All Races) | California Target Book')

@section('content')

<?php

global $extends;

$fourcodes = populate_fourcodes();

$e_dists = Array(
        "AD13",
	"AD25",
	"AD33",
	"AD37",
	"AD38",
	"AD57",
        "AD67",
        "AD78",
	"CD08",
	"CD50",
	"CD53"

	);

foreach($e_dists as $dist) {
	$extends[$dist] = " (Filing Extended to 12/11)";
}

echo("<div class='container-fluid text-center'>
			 <h2>California March 3rd, 2020 Candidate Filing Status</h2>
			 <h4 align='center'><i>Signatures-In-Lieu of Filing Fee Period 9/12 - 11/6</i><br><i>Nomination Period 11/11 - 12/6</i><br><i>Extension Period For Races w/no Incumbent 12/7-12/11</i><br><i>Notice to Candidates: 12/21</i><br><b>Certified List of Candidates: 12/26</b><br></h4>
			     ");

foreach($fourcodes as $fourcode) {
	$x = get_ballot($fourcode);
	$y = get_filed($fourcode);
	if(substr($fourcode, -1) == "+") {
		$display_fourcode = substr($fourcode, 0, -1);
		$add_special = " - Special Election Primary";
	} else {
		$display_fourcode = $fourcode;
		$add_special = '';
	}

	echo("<hr width='100vw;' />
			<div style='display: inline-block; clear: both; margin-left: auto; margin-right: auto; margin-top: 20px; padding: 20px;' align='center'>
				<h2 align='center'><a href='/book/district/$display_fourcode' target='_blank'>" . $display_fourcode . $add_special . "</a></h2>
				<div>
					$y
				</div>

				<div>
					$x
				</div>
			</div>");

	//echo($x);
}


echo("</div>");

function populate_fourcodes() {
	$stmt = Util::get_ctb_pdo()->prepare("
			SELECT fourcode FROM ctb_e20_ballots GROUP BY fourcode ORDER BY fourcode
		");
	$stmt->execute();
	$retval = Array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($retval, $row['fourcode']);
	}
	return $retval;
}

function get_filed($fourcode)
{

	global $extends;
    $table_body='';
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_p20_filing_status WHERE fourcode = :id ORDER BY party, naml
    ");
    $stmt->execute(['id' => $fourcode]);
    $abort = TRUE;
    $arr = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row);
        $abort = FALSE;
    }

    $table_head = "<h3 align='center'>Filing Log" . (isset($extends[$fourcode]) ? $extends[$fourcode] : '')  . "</h3>
    				<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
                    <p align='center'>
                    <table class='table table-striped table-responsive'  style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>PARTY</th>
                                <th>SIL ISSUE</th>
                                <th>SIL FILE</th>
                                <th>NOM ISSUE</th>
                                <th>NOM FILE</th>
                                <th>COUNTY</th>
                            </tr>
                        </thead>
                        <tbody>";

    foreach($arr as $x) {
        if(isset($x['namm'])) {
            $name = $x['namf'] . " " . $x['namm'] . " " . $x['naml'];
        } else {
            $name = $x['namf'] . " " . $x['naml'];
        }

				switch($x['party']) {
					case "R":
						$class = 'redme boldme';
						break;
					case "D":
						$class = 'blueme boldme';
						break;
					case "Grn":
						$class = 'greenme boldme';
						break;
					default:
						$class = '';
				}


        $county_url = get_county_registrar_url($x['county_filed']);
        $county_lnk = "<a href='$county_url' target='_blank'>" . $x['county_filed'] . "</a>";

        $table_body .= "<tr class='$class'>
                            <td>" . $name . "</td>
                            <td>" . $x['party'] . "</td>
                            <td>" . $x['sil_issue'] . "</td>
                            <td>" . $x['sil_file'] . "</td>
                            <td>" . $x['nom_issue'] . "</td>
                            <td>" . $x['nom_file'] . "</td>
                            <td>$county_lnk</td>
                        </tr>";
    }

    $retval = $table_head . $table_body . "</tbody></table></p></div>";


    if($abort) {
        return FALSE;
    } else {
        return $retval;
    }

}

function get_ballot($fourcode) {
	//return FALSE;
    $table_body=[];
    $retval='';
	$stmt = Util::get_ctb_pdo()->prepare("
			SELECT * FROM ctb_e20_ballots WHERE fourcode = :id ORDER BY elec_date, party, naml
		");
		$stmt->execute(['id' => $fourcode]);
		$abort = TRUE;
		$arr = Array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$key = $row['elec_type'];

			if(!isset($arr[$key])) {
				$arr[$key] = Array();
			}

			if($row['namm']) {
				$tmp['cand_nm'] = $row['namf'] . " " . $row['namm'] . " " . $row['naml'];
			} else {

				$tmp['cand_nm'] = $row['namf'] . " " . $row['naml'];
			}

			$tmp['website'] = $row['website'];
			$tmp['party'] = $row['party'];
			$tmp['cand_id'] = $row['cand_id'];
			$tmp['cmte_id'] = $row['cmte_id'];
			$tmp['ballot_dscr'] = $row['ballot_dscr'];
			$tmp['elec_date'] = $row['elec_date'];
			array_push($arr[$key], $tmp);
			$abort = FALSE;
		}





		$table_contain_head = "

								<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
									<p align='center'>";

		foreach($arr as $e => $value) {
			switch(mb_substr($e, 0, 1)) {
				case "s":
					$long_type = "Special Election Primary";
					break;
				case "r":
					$long_type = "Special Election Runoff";
					break;
				case "p":
					$long_type = "Primary Election";
					break;
				case "g":
					$long_type = "General Election";
					break;
				default:
					$long_type = "Unknown";
					break;
			}

			foreach($arr[$e] as $cand) {

				//echo("<br>CAND DUMP<br>");
				//var_dump($cand);

				switch($cand['party']) {
					case "R":
						$class = 'redme boldme';
						break;
					case "D":
						$class = 'blueme boldme';
						break;
					case "Grn":
						$class = 'greenme boldme';
						break;
					default:
						$class = '';
				}

				if($cand['website']) {
				     $name = "<a href='http://" . $cand['website'] . "' target='_blank'>" . $cand['cand_nm'] . "</a>";
				} else {
				     $name = $cand['cand_nm'];
				}


				$this_election = date('F j, Y', strtotime($cand['elec_date']));
                if (array_key_exists($e,$table_body)) {
                    $table_body[$e] .= "<tr class='$class'>
                                            <td>" . $name . "</td>
                                            <td>" . $cand['party'] . "</td>
                                            <td>" . $cand['ballot_dscr'] . "</td>
                                        </tr>";
                }else {
                    $table_body[$e] ="<tr class='$class'>
                                            <td>" . $name . "</td>
                                            <td>" . $cand['party'] . "</td>
                                            <td>" . $cand['ballot_dscr'] . "</td>
                                        </tr>";
                }

			}

			$table_head[$e] = "<h3>$long_type - $this_election</h3>
								<p></p>
								<p></p>
								<table class='table table-striped' v-ctb-table style='margin-left: auto !important; margin-right: auto !important; margin-top: 10px;' align='center'>
									<thead>
										<tr>
											<th>CANDIDATE NAME</th>
											<th>PARTY</th>
											<th>BALLOT DESCRIPTION</th>
										</tr>
									</thead>
									<tbody>";



			$table_end[$e] = "</tbody></table><p></p>";
		}

		$retval = $table_contain_head;
		foreach($table_head as $key => $value) {
			$retval .= $table_head[$key] . $table_body[$key] . $table_end[$e];

		}

		$retval .= "</p></div>";

		if($abort) {
			return FALSE;
		} else {
			return $retval;
		}

}

function get_county_registrar_url($county_name) {
    $retval='';
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_e20_county_watch WHERE county_nm LIKE :id
    ");
    $stmt->execute(['id' => $county_name]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval = $row['url'];
    }
    return $retval;
}

?>

@endsection

@section('styles')

<style>

.greenme {
   color: green;
}
</style>

@endsection
