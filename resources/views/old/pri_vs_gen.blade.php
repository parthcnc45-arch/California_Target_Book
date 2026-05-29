
@extends('layouts.master')

@section('title', 'Primary vs General Election Performance | California Target Book')

@section('content')
    <div class="container">

        <?php //include('includes/loggedin_bar.php'); ?>

        <?php //include('includes/navbar.php'); ?>

        <?php

        Util::set_errors();
        Util::require_ctb_api();

        $districts = populate_the_districts();

        $elections = populate_elections();

        foreach ($elections as $election) {

            foreach ($districts as $fourcode) {

                //echo("<br>Getting Primary Vote Total from $fourcode - $election");

                echo("<br>GETTING PRIMARY VOTE TOTAL FOR $fourcode - $election");
                get_primary_vote_total($fourcode, $election);

                echo("<br>GETTING GENERAL VOTE TOTAL FOR $fourcode - $election");
                get_general_vote_total($fourcode, $election);


                echo("<br>POPULATING GENERAL, PRIMARY RESULTS");
                get_general_racekeys($fourcode, $election);

            }

        }

        $cand = Array();

        foreach ($cand_array as $naml => $e) {
            foreach ($e as $year => $d) {
                foreach ($d as $fourcode => $v) {

                    $p_elec = "p" . $year;
                    $g_elec = "g" . $year;

                    $primary_total = $vote_totals[$fourcode][$p_elec];
                    $general_total = $vote_totals[$fourcode][$g_elec];

                    $p_pct = number_format((($v['PRIMARY'] / $primary_total) * 100), 2);
                    $g_pct = number_format((($v['GENERAL'] / $general_total) * 100), 2);

                    $tmp['NAML'] = $naml;
                    $tmp['YEAR'] = $year;
                    $tmp['FOURCODE'] = $fourcode;
                    $tmp['PRIMARY_PCT'] = $p_pct;
                    $tmp['GENERAL_PCT'] = $g_pct;
                    $tmp['FULLNAME'] = $v['NAME'];

                    array_push($cand, $tmp);

                }
            }
        }


        foreach ($cand as $r) {

            if ($r['PRIMARY_PCT'] > 50 && $r['GENERAL_PCT'] < 50) {
                $thisclass = 'boldme';
            } else {
                $thisclass = '';
            }

            $tablebody .= "<tr class='$thisclass'>
							<td>" . $r['FULLNAME'] . "</td>
							<td>" . $r['YEAR'] . "</td>
							<td>" . $r['FOURCODE'] . "</td>
							<td>" . $r['PRIMARY_PCT'] . "</td>
							<td>" . $r['GENERAL_PCT'] . "<td>
						</tr>";
        }

        $tablehead = "<div class='newseg'>
					<table class='bordered tablesorter'>
						<thead>
							<tr>
								<th>NAME</th>
								<th>YEAR</th>
								<th>DISTRICT</th>
								<th>PRIMARY PCT</th>
								<th>GENERAL PCT</th>
							</tr>
						</thead>
						<tbody>";

        echo($tablehead . $tablebody . "</tbody></table></div>");


        //echo("<br>VOTE TOTAL DUMP:<br>");
        //var_dump($vote_totals);
        //echo("<br>CANDIDATE ARRAY DUMP:<br>");
        //var_dump($cand_array);

        function populate_the_districts()
        {
            $i = 1;
            $retval = Array();
            while ($i < 81) {
                $fourcode = "AD" . checkaddzero($i);
                array_push($retval, $fourcode);
                $i++;
            }

            $i = 1;
            while ($i < 41) {
                $fourcode = "SD" . checkaddzero($i);
                array_push($retval, $fourcode);
                $i++;
            }

            $i = 1;
            while ($i < 54) {
                $fourcode = "CD" . checkaddzero($i);
                array_push($retval, $fourcode);
                $i++;
            }

            $i = 1;
            while ($i < 5) {
                $fourcode = "BOE" . $i;
                array_push($retval, $fourcode);
                $i++;
            }

            return $retval;
        }

        function populate_elections()
        {
            $retval = Array("16", "14", "12");

            return $retval;
        }

        function get_general_racekeys($fourcode, $election)
        {
            global $site_conn;
            $conn = Util::get_ctb_conn();
            global $vote_totals;
            global $cand_array;
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $retval = Array();

            $sql = "SELECT race, name FROM ctb_ca_candidates WHERE disttype = '$disttype' && distnum = $distno && election = 'g$election'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

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

                    $g_elec = "g" . $election;

                    $racekey = $row['race'];
                    $g_votes = get_vote_from_racekey($racekey, $g_elec);
                    $p_votes = lookup_primary_vote($fourcode, $election, $naml);

                    //echo("<br>GOT $p_votes, $g_votes in the $election Primary and General for $naml, adding to Array<br>");

                    $cand_array[$naml][$election][$fourcode]['PRIMARY'] = $p_votes;
                    $cand_array[$naml][$election][$fourcode]['GENERAL'] = $g_votes;
                    $cand_array[$naml][$election][$fourcode]['NAME'] = $row['name'];


                }
            }
        }

        function lookup_primary_vote($fourcode, $election, $naml)
        {
            global $site_conn;
            $conn = Util::get_ctb_conn();
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $sql = "SELECT race FROM ctb_ca_candidates WHERE disttype = '$disttype' && distnum = $distno && election = 'p$election' && name LIKE '%$naml%'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $racekey = $row['race'];
                }
            }

            $sql = "SELECT SUM(votes) AS VOTES from ctb_county_results WHERE election = 'P$election' && racekey = '$racekey'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['VOTES'];
                }
            }

            return $retval;


        }

        function get_primary_vote_total($fourcode, $election)
        {

            global $site_conn;
            $conn = Util::get_ctb_conn();
            global $vote_totals;
            global $cand_array;
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $retval = Array();

            $sql = "SELECT race, name FROM ctb_ca_candidates WHERE disttype = '$disttype' && distnum = $distno && election = 'p$election'";
            //echo("<br>P-" . $sql);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $racekey = $row['race'];
                    $mod_election = "p" . $election;
                    $votes = get_vote_from_racekey($racekey, $mod_election);
                    $vote_totals[$fourcode][$mod_election] += $votes;
                }
            }
        }

        function get_general_vote_total($fourcode, $election)
        {

            global $site_conn;
            $conn = Util::get_ctb_conn();
            global $vote_totals;
            global $cand_array;
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $retval = Array();

            $sql = "SELECT race, name FROM ctb_ca_candidates WHERE disttype = '$disttype' && distnum = $distno && election = 'g$election'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $racekey = $row['race'];
                    $mod_election = "g" . $election;
                    $votes = get_vote_from_racekey($racekey, $mod_election);
                    $vote_totals[$fourcode][$mod_election] += $votes;
                }
            }
        }

        function get_primary_racekeys($fourcode, $election)
        {
            global $site_conn;
            $conn = Util::get_ctb_conn();
            global $vote_totals;
            global $cand_array;
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $retval = Array();

            $sql = "SELECT race, name FROM ctb_ca_candidates WHERE disttype = '$disttype' && distnum = $distno && election = 'p$election'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

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

                    $racekey = $row['race'];
                    $votes = get_vote_from_racekey($racekey, $election);

                    $vote_totals[$fourcode][$election] += $votes;


                }
            }

        }

        function get_vote_from_racekey($racekey, $election)
        {
            global $site_conn;
            $election = strtoupper($election);
            $conn = Util::get_ctb_conn();
            $sql = "SELECT SUM(votes) AS VOTES FROM ctb_county_results WHERE election = '$election' && racekey = '$racekey'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['VOTES'];
                }
            }

            return $retval;
        }


        ?>

    </div>
@endsection

