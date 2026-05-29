@extends('layouts.iframe_old')

@section('title', 'Copyright | California Target Book')

@section('content')
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>


                <?php


                //error_reporting(E_ALL);
                //ini_set('display_errors', '1');
                $endjava = Array();
                $logger = Array();

                Util::set_errors();
                Util::require_ctb_api();

                $thisstate = $_GET['id'];

                $conn = Util::get_ctb_conn();

                $sql = "SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE_ST, CAND_OFFICE, CAND_OFFICE_DISTRICT, CAND_PCC, CAND_ICI FROM nufec_cn_14 WHERE CAND_ELECTION_YR = '2014' && CAND_OFFICE_ST = '$thisstate' ORDER BY CAND_OFFICE_ST, CAND_OFFICE, CAND_OFFICE_DISTRICT ASC";

                //echo $sql;

                //$thisid = $_GET["id"];
                //echo $thisid;

                echo("<div class='newseg'>");

                $result = $conn->query($sql);

                $i = 1;

                $thisid = "cmte";

                $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

                array_push($endjava, $js);


//                echo($tablehead);
                $drawentry = '';
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $c1find = FALSE;

                        $thisdist = $row['CAND_OFFICE_DISTRICT'];
                        $thiscmte = $row['CAND_PCC'];
                        $thisoffice = $row['CAND_OFFICE'];

                        if ($thisoffice == "H" && !$thisdist) {
                            $thisdist = "00";
                        }


                        $thisid = $state . $thisdist;

                        $tablehead = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
			<thead>
				<tr>
					<th>NAME</th>
					<th>PARTY</th>
					<th>RAISED</th>
					<th>SPENT</th>
					<th>COH END</th>
					<th>CAND LOANS</th>
					<th>END DT</th>
					<th>CMTE</th>
				</tr>
			</thead>
			<tbody>

		";

                        if ($row['CAND_ICI'] == "I") {
                            $status = "(" . $row['CAND_PTY_AFFILIATION'] . "-Inc)";
                            //$statclass = 'boldme';
                        } else {
                            $status = "(" . $row['CAND_PTY_AFFILIATION'] . ")";
                            //$statclass = '';
                        }

                        if ($row['CAND_PTY_AFFILIATION'] == "DEM") {
                            $partyclass = 'blueme';
                        } elseif ($row['CAND_PTY_AFFILIATION'] == "REP") {
                            $partyclass = 'redme';
                        } else {
                            $partyclass = 'grayme';
                        }

                        if ($thiscmte) {
                            $cmte_lnk = "<a href='http://www.calelections.com/fedcm.php?id=" . $row['CAND_PCC'] . "'>" . $row['CAND_PCC'] . "</a>";
                        } else {
                            $cmte_lnk = "NO COMMITTEE";
                        }

                        $lastfourcode = $thisstate . checkaddzero(($row['CAND_OFFICE_DISTRICT']) - 1);
                        if ($row['CAND_OFFICE'] == 'S') {
                            $lastfourcode = $thisstate . "SN";
                        }

                        if ($row['CAND_OFFICE'] == 'H') {
                            if ($thisdist != $lastdist || $thisdist == '') {
                                if ($lastdist) {
                                    $drawentry .= "</tbody></table>";
                                    if ($distietotal) {
                                        $drawentry .= "<h1>\$" . number_format($distietotal, 2) . " Total Independent Expenditures</h1>";

                                        $fourcode = $lastfourcode;
                                        if ($ie_cmte[$fourcode]['ps'] || $ie_cmte[$fourcode]['po']) {

                                            $distie .= "<div class='newseg'><p class='boldme'><b style='color: #4B57B1;'>Independent Expenditure Activity in Primary:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING - </b> \$" . number_format($ie_cmte[$fourcode]['p']) . "<br>";

                                            foreach ($ie_cmte[$fourcode]['ps'] as $cmte) {
                                                $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                                                $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme greenme'> in Support of </span> " . $cmte['cand'];
                                            }

                                            foreach ($ie_cmte[$fourcode]['po'] as $cmte) {
                                                $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id==" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                                                $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme redme'> in Opposition to </span> " . $cmte['cand'];
                                            }

                                            $distie .= "</div>";
                                        }

                                        if ($ie_cmte[$fourcode]['gs'] || $ie_cmte[$fourcode]['go']) {
                                            $distie .= "<div class='newseg'><p class='boldme'><b style='color: #4B57B1;'>Independent Expenditure Activity in General:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING - </b> \$" . number_format($ie_cmte[$fourcode]['g']) . "<br>";
                                            foreach ($ie_cmte[$fourcode]['gs'] as $cmte) {
                                                $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                                                $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme greenme'> in Support of </span> " . $cmte['cand'];

                                            }

                                            foreach ($ie_cmte[$fourcode]['go'] as $cmte) {
                                                $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                                                $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme redme'> in Opposition to </span> " . $cmte['cand'];

                                            }
                                            $distie .= "</div>";
                                        }


                                        $drawentry .= $distie;
                                        $distie = '';
                                        $distietotal = '';
                                    }
                                    $drawentry .= "</div>";
                                }
                                if (($thisdist == "0" || $thisdist == '') && !$runonce) {


                                    $drawentry .= "<div class='newseg'><h1>$thisstate House Seat</h1>";
                                    $fourcode = $thisstate . checkaddzero($row['CAND_OFFICE_DISTRICT']);
                                    if ($row['CAND_OFFICE_DISTRICT'] == "00" || $row['CAND_OFFICE_DISTRICT'] == '') {
                                        $fourcode = $thisstate . "00";
                                    }
                                    //$is_open = is_open();
                                    //$is_targeted = is_targeted();

                                    $drawentry .= $is_open . $is_targeted;

                                    $x = drawreg($fourcode);
                                    if ($x) {
                                        $drawentry .= $x;
                                    }
                                    $drawentry .= $tablehead;
                                    $runonce = TRUE;
                                } else {
                                    $drawentry .= "<div class='newseg'><h1>$thisstate" . checkaddzero($row['CAND_OFFICE_DISTRICT']) . "</h1>";
                                    $fourcode = $thisstate . checkaddzero($row['CAND_OFFICE_DISTRICT']);

                                    $is_open = is_open();
                                    $is_targeted = is_targeted();

                                    $drawentry .= $is_open . $is_targeted;
                                    $x = drawreg($fourcode);
                                    if ($x) {
                                        $drawentry .= $x;
                                    }
                                    $drawentry .= $tablehead;
                                }
                            }
                        } elseif ($row['CAND_OFFICE'] == 'S') {
                            if ($thisoffice != $lastoffice) {

                                $drawentry .= "</tbody></table>";
                                if ($distietotal) {
                                    $drawentry .= "<h1>\$" . number_format($distietotal, 2) . " Total Independent Expenditures</h1>";
                                    $drawentry .= $distie;
                                    $distie = '';
                                    $distietotal = '';
                                }

                                $drawentry .= "</div><div class='newseg'><h1>$thisstate Senate</h1>";
                                $fourcode = $thisstate . "SN";
                                $drawentry .= $tablehead;
                            }
                        }

                        $lastdist = $thisdist;
                        $lastoffice = $thisoffice;

                        if ($thiscmte) {
                            $getfeccandidateinfo = getfeccand18($thiscmte);
                            $thiscand = $getfeccandidateinfo['CAND_ID'];
                            $fedsummary = getfecsum18($thiscand);
                        } else {
                            $fedsummary = [];
                        }

                        if ($thisoffice == "S") {
                            //DO NOTHING
                        } else {
                            $fourcode = $thisstate . $thisdist;
                        }


                        /*
                               $toptwo = gettoptwo($fourcode);
                              // var_dump($toptwo);

                               foreach($toptwo as $candidate) {
                                    $thiscand_name = $row['CAND_NAME'];
                                    $searchfor = strtoupper($candidate['NAML']);

                                    //echo("<br>SEARCHING $thiscand_name for $searchfor");
                                    if(strpos($thiscand_name, $searchfor) !== FALSE) {
                                        $lookup = $searchfor;
                                        $c1find = TRUE;
                                        //echo("<br>MATCHED $thiscand_name with $searchfor");
                                    } else {
                                        if(!$c1find) {
                                            $c1find = FALSE;
                                        }
                                    }
                               }

                        */


                        /*
                                $thiscand_name = $row['CAND_NAME'];
                                $c1 = strtoupper($toptwo[0]['NAML']);
                                $c2 = strtoupper($toptwo[1]['NAML']);

                                if(strpos($thiscand_name, $c1) !== false) {
                                    $c1find = TRUE;
                                    $lookup = $toptwo[0]['NAML'];
                                } else {
                                    $c1find = FALSE;
                                }

                                if(strpos($thiscand_name, $c2) !== false) {
                                    $c2find = TRUE;
                                    $lookup = $toptwo[1]['NAML'];
                                } else {
                                    $c2find = FALSE;
                                }
                        */
                        // echo("<br>SEARCHING FOR $c1 ($c1find) and $c2 ($c2find) in entry: $thiscand_name");

                        $c1find = TRUE;

                        if ($c1find || $c2find) {
                            $statclass = 'boldme';
                            //echo("<br>FOUND ENTRY<br>");
                            $drawthis = TRUE;
                        } else {
                            $statclass = '';
                            $drawthis = FALSE;
                            $lastfourcode = $fourcode;
                            //continue;
                        }


                        if ($drawthis) {
                            $drawentry .= "
    				<tr class='$statclass $partyclass'>
    					<td>" . $row['CAND_NAME'] . "</td>
    					<td>" . $status . "</td>
    					<td>\$" . number_format($fedsummary['RECEIPTS'], 2, '.', ',') . "</td>
    					<td>\$" . number_format($fedsummary['EXPN'], 2, '.', ',') . "</td>
    					<td>\$" . number_format($fedsummary['COH_END'], 2, '.', ',') . "</td>
    					<td>\$" . number_format($fedsummary['CAND_LOANS'], 2, '.', ',') . "</td>
    					<td>" . $fedsummary['CVG_END_DT'] . "</td>
    					<td>$cmte_lnk</td>
    				<tr>
    		";
                        }

                        $namefield = $row['CAND_NAME'];

                        $regex = '~(.*?)\,~mis';
                        preg_match($regex, $namefield, $output);

                        $lookup = $output[1];

                        if ($drawthis) {
                            $ie = lookupthisie($fourcode, $lookup);
                        } else {
                            $ie = '';
                        }

                        if ($ie['CAND_TOTAL'] > 0) {
                            $tablebody = $ie['HTML'];
                            $primsupport = $ie['PRI_TOTAL_S'];
                            $primoppose = $ie['PRI_TOTAL_O'];
                            $gensupport = $ie['GEN_TOTAL_S'];
                            $genoppose = $ie['GEN_TOTAL_O'];
                            $totalcand = $ie['CAND_TOTAL'];
                            $distietotal += $totalcand;

                            $tablenum++;

                            $thisid = $fourcode . "-$tablenum";

                            $js = "$(document).ready(function() {
                $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
            });";

                            array_push($endjava, $js);
                            $tablehead = "<div class='newseg'>
                <table style='margin-top: 20px' id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack'>>
                    <thead>
                        <tr>
                            <th>ELECTION</th>
                            <th>COMMITTEE</th>
                            <th>AMOUNT</th>
                            <th>SUP/OPP</th>
                            <th>PURPOSE</th>
                            <th>PAYEE</th>
                            <th>DATE</th>
                            <th>FILING</th>
                        </tr>
                    </thead>
                    <tbody>
            ";

                            $distie .= "<div class='newseg'><h2 align='center'>Independent Expenditures Affecting $lookup: \$" . number_format($totalcand, 2) . "</h2>
                <p align='center'>PRIMARY: <span class='greenme boldme'>\$" . number_format($primsupport, 2) . "</span> in Support, <span class='redme boldme'>\$" . number_format($primoppose, 2) . "</span> in Opposition</p>
                <p align='center'>GENERAL: <span class='greenme boldme'>\$" . number_format($gensupport, 2) . "</span> in Support, <span class='redme boldme'>\$" . number_format($genoppose, 2) . "</span> in Opposition</p>
                <p align='center'>*Only Expenditures of $1,000 or Greater Listed Below</p></div>";


                            $distie .= $tablehead . $tablebody . "</tbody></table></div>";

                        }

                    }
                    $lastfourcode = $fourcode;
                    $i++;
                }


                if ($distietotal) {
                    $drawentry .= "</tbody></table>";
                    $drawentry .= "<h1>\$" . number_format($distietotal, 2) . " Total Independent Expenditures Affecting These Two Candidates</h1>";
                    if ($ie_cmte[$fourcode]['ps'] || $ie_cmte[$fourcode]['po']) {

                        $distie .= "<div class='newseg'><p class='boldme'><b style='color: #4B57B1;'>Independent Expenditure Activity in Primary:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING - </b> \$" . number_format($ie_cmte[$fourcode]['p']) . "<br>";

                        foreach ($ie_cmte[$fourcode]['ps'] as $cmte) {
                            $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                            $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme greenme'> in Support of </span> " . $cmte['cand'];
                        }

                        foreach ($ie_cmte[$fourcode]['po'] as $cmte) {
                            $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                            $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme redme'> in Opposition to </span> " . $cmte['cand'];
                        }

                        $distie .= "</div>";
                    }

                    if ($ie_cmte[$fourcode]['gs'] || $ie_cmte[$fourcode]['go']) {
                        $distie .= "<div class='newseg'><p class='boldme'><b style='color: #4B57B1;'>Independent Expenditure Activity in General:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING - </b> \$" . number_format($ie_cmte[$fourcode]['g']) . "<br>";
                        foreach ($ie_cmte[$fourcode]['gs'] as $cmte) {
                            $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                            $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme greenme'> in Support of </span> " . $cmte['cand'];

                        }

                        foreach ($ie_cmte[$fourcode]['go'] as $cmte) {
                            $committee_link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte['cmte_id'] . "' target='_blank'>" . $cmte['cmte_nm'] . "</a>";
                            $distie .= "<p class='boldme'>$committee_link spent \$" . number_format($cmte['amount']) . " <span class='boldme redme'> in Opposition to </span> " . $cmte['cand'];

                        }
                        $distie .= "</div>";
                    }
                    $drawentry .= $distie;
                    $distie = '';
                    $distietotal = '';
                }
                $drawentry .= "</div>";

                echo($drawentry);

                function getfecsum18($candidate)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $tmp = Array();
                    $retval = Array();
                    $sql = "SELECT * FROM nufec_weball_14 WHERE CAND_ID = '$candidate'";
                    //echo("<br>$sql");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['RECEIPTS'] = $row['TTL_RECEIPTS'];
                            $tmp['EXPN'] = $row['TTL_DISB'];
                            $tmp['COH_START'] = $row['COH_BOP'];
                            $tmp['COH_END'] = $row['COH_COP'];
                            $tmp['CAND_LOANS'] = $row['CAND_LOANS'];
                            $tmp['OTH_LOANS'] = $row['OTHER_LOANS'];
                            $tmp['CVG_END_DT'] = $row['CVG_END_DATE'];
                            $tmp['DEBTS'] = $row['DEBTS_OWED_BY'];
                            $year = mb_substr($row['CVG_END_DT'], 6, 4);
                            $month = mb_substr($row['CVG_END_DT'], 0, 2);
                            $day = mb_substr($row['CVG_END_DT'], 3, 2);
                            $tmp['CVG_END_DT'] = $year . "-" . $month . "-" . $day;
                        }
                    }

                    $retval = $tmp;

                    return $retval;
                }

                function getfeccand18($committee)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $tmp = Array();
                    $retval = Array();
                    $sql = "SELECT * FROM nufec_ccl_14 WHERE CMTE_ID = '$committee'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['CAND_ID'] = $row['CAND_ID'];
                            $x = $row['CAND_ID'];
                        }
                    }

                    $sql = "SELECT * FROM nufec_cn_14 WHERE CAND_ID = '$x'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['CAND_NAME'] = $row['CAND_NAME'];
                            $tmp['PARTY'] = $row['CAND_PTY_AFFILIATION'];
                            $tmp['CAND_OFFICE'] = $row['CAND_OFFICE'];
                            $tmp['CAND_OFFICE_ST'] = $row['CAND_OFFICE_ST'];
                            $tmp['CAND_OFFICE_DISTRICT'] = $row['CAND_OFFICE_DISTRICT'];
                            $tmp['CAND_ICI'] = $row['CAND_ICI'];
                        }
                    }

                    $retval = $tmp;

                    return $retval;
                }

                function is_targeted()
                {
                    global $fourcode;
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT targeted_by FROM nufec_e18_targets WHERE fourcode = '$fourcode'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $x = $row['targeted_by'];
                        }
                    }
                    if ($x == "DCCC") {
                        $retval = "<p align='center'><span class='boldme blueme'>2018 DCCC Target</span></p>";
                    }

                    if ($x == "NRCC") {
                        $retval = "<p align='center'><span class='boldme redme'>2018 NRCC Target</span></p>";
                    }

                    return $retval;
                }

                function is_open()
                {
                    global $fourcode;
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT * FROM nufec_e18_open WHERE fourcode = '$fourcode'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $incumbent = $row['incumbent'];
                            $party = $row['party'];
                            $reason = $row['reason'];
                        }
                    }

                    if ($reason) {
                        $retval = "<p align='center' style='font-family: \"Lato\"; font-size: 14pt;'><span class='boldme'>OPEN SEAT IN 2018<br>" . $incumbent . " (" . $party . ")" . " is " . $reason . "</span></p>";
                    } else {
                        $retval = '';
                    }

                    return $retval;
                }

                function lookupthisie($fourcode, $lastname)
                {
                    global $fec_conn;
                    global $ie_cmte;
                    global $logger;

                    if ($logger[$fourcode][$lastname]) {
                        return FALSE;
                    } else {
                        $logger[$fourcode][$lastname] = TRUE;
                    }

                    $conn = Util::get_ctb_conn();
                    $state = mb_substr($fourcode, 0, 2);
                    $dist = mb_substr($fourcode, 2, 2);
                    $retval = Array();


                    $sql = "SELECT *
            FROM  (SELECT * FROM (
                        SELECT DISTINCT tra_id, can_nam, spe_id, spe_nam, ele_typ, can_off, can_off_sta, can_off_dis, can_par_aff, exp_amo, exp_dat, sup_opp, pur, pay, file_num, amn_ind, ima_num, rec_dat
                        FROM nufec_ie_14
                        WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && can_off_dis = '$dist' && can_off = 'H'
                        ORDER BY file_num DESC
                    ) A
                    GROUP BY spe_nam, tra_id, pay, exp_dat, can_off_dis ) B

    ";
                    //echo("<br>$sql<br>") ;

                    /*    $sql = "SELECT * FROM (
                                    SELECT DISTINCT tra_id, can_nam, spe_id, spe_nam, ele_typ, can_off, can_off_sta, can_off_dis, can_par_aff, exp_amo, exp_dat, sup_opp, pur, pay, file_num, amn_ind, ima_num, rec_dat
                                    FROM ie
                                    WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && can_off_dis = '$dist'
                                    ORDER BY file_num DESC) A
                                GROUP BY spe_nam, tra_id
                        ";
                        //echo("<br>$sql</br>");
                        */

                    if ($dist == "SN") {
                        $sql = "SELECT * FROM nufec_ie_14
                WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && can_off = 'S'
                GROUP BY spe_nam, tra_id, exp_dat, can_off_sta
                ORDER BY file_num DESC";

                        $sql = "SELECT *
        FROM  (SELECT * FROM (
                    SELECT DISTINCT tra_id, can_nam, spe_id, spe_nam, ele_typ, can_off, can_off_sta, can_off_dis, can_par_aff, exp_amo, exp_dat, sup_opp, pur, pay, file_num, amn_ind, ima_num, rec_dat
                    FROM nufec_ie_14
                    WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && can_off = 'S'
                    ORDER BY file_num DESC
                ) A
                GROUP BY spe_nam, tra_id, pay, exp_dat, can_off_sta ) B

";
                        // echo("<br>$sql<br>");

                    }

                    $result = $conn->query($sql);

                    //echo("<br>$fourcode RESULT DUMP:<br>");
                    //var_dump($result);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $amount = $row['exp_amo'];
                            $amount = str_replace('$', '', $amount);
                            $amount = str_replace(',', '', $amount);

                            $cmte_nm = $row['spe_nam'];
                            $cmte_id = $row['spe_id'];
                            $election = $row['ele_typ'];
                            $support = $row['sup_opp'];
                            $purpose = $row['pur'];
                            $filing_id = $row['file_num'];
                            $date = $row['rec_dat'];
                            $payee = $row['pay'];
                            $filing_link = "<a href='http://198.74.49.22/fedparser.php?id=$filing_id' target='_blank'>$filing_id</a>";

                            if ($election == "G") {
                                $gentotal += $amount;
                                if ($support == "Support") {
                                    $gensupport += $amount;
                                    $ie_cmte[$fourcode]['gs'][$cmte_id]['cmte_nm'] = $cmte_nm;
                                    $ie_cmte[$fourcode]['gs'][$cmte_id]['cmte_id'] = $cmte_id;
                                    $ie_cmte[$fourcode]['gs'][$cmte_id]['amount'] += $amount;
                                    $ie_cmte[$fourcode]['gs'][$cmte_id]['cand'] = $lastname;
                                    $ie_cmte[$fourcode]['g'] += $amount;

                                } elseif ($support == "Oppose") {
                                    $genoppose += $amount;
                                    $ie_cmte[$fourcode]['go'][$cmte_id]['cmte_nm'] = $cmte_nm;
                                    $ie_cmte[$fourcode]['go'][$cmte_id]['cmte_id'] = $cmte_id;
                                    $ie_cmte[$fourcode]['go'][$cmte_id]['amount'] += $amount;
                                    $ie_cmte[$fourcode]['go'][$cmte_id]['cand'] = $lastname;
                                    $ie_cmte[$fourcode]['g'] += $amount;
                                }
                                $electionclass = '';

                            }

                            if ($election == "P") {
                                $primtotal += $amount;
                                if ($support == "Support") {
                                    $primsupport += $amount;
                                    $ie_cmte[$fourcode]['ps'][$cmte_id]['cmte_nm'] = $cmte_nm;
                                    $ie_cmte[$fourcode]['ps'][$cmte_id]['cmte_id'] = $cmte_id;
                                    $ie_cmte[$fourcode]['ps'][$cmte_id]['amount'] += $amount;
                                    $ie_cmte[$fourcode]['ps'][$cmte_id]['cand'] = $lastname;
                                    $ie_cmte[$fourcode]['p'] += $amount;
                                } elseif ($support == "Oppose") {
                                    $primoppose += $amount;
                                    $ie_cmte[$fourcode]['po'][$cmte_id]['cmte_nm'] = $cmte_nm;
                                    $ie_cmte[$fourcode]['po'][$cmte_id]['cmte_id'] = $cmte_id;
                                    $ie_cmte[$fourcode]['po'][$cmte_id]['amount'] += $amount;
                                    $ie_cmte[$fourcode]['po'][$cmte_id]['cand'] = $lastname;
                                    $ie_cmte[$fourcode]['p'] += $amount;
                                }
                                //$electionclass= 'itcme';
                            }

                            $link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte_id . "' target='_blank'>$cmte_nm</a>";

                            if ($amount >= 1000) {
                                $retval['HTML'] .= "
                    <tr class='$electionclass'>
                        <td>$election</td>
                        <td>$link</td>
                        <td align='right'>\$$amount</td>
                        <td>$support</td>
                        <td>$purpose</td>
                        <td>$payee</td>
                        <td>$date</td>
                        <td>$filing_link</td>
                    </tr>

                ";
                            }

                        }
                    }

                    $retval['CAND_TOTAL'] = $gentotal + $primtotal;
                    $retval['GEN_TOTAL_S'] = $gensupport;
                    $retval['GEN_TOTAL_O'] = $genoppose;
                    $retval['PRI_TOTAL_S'] = $primsupport;
                    $retval['PRI_TOTAL_O'] = $primoppose;

                    //echo("<br>RETURNING G + $gensupport, G - $genoppose, P + $primsupport, P - $primoppose");

                    return $retval;

                }

                function gettoptwo($fourcode)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $tmp = Array();
                    $retval = Array();

                    $sql = "SELECT * FROM nufec_cand_comm WHERE FOURCODE = '$fourcode'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['NAMF'] = $row['NAMF'];
                            $tmp['NAML'] = $row['NAML'];
                            $tmp['PARTY'] = $row['PARTY'];
                            $tmp['IS_INCUMBENT'] = $row['IS_INCUMBENT'];
                            $tmp['CMTE_ID'] = $row['CMTE_ID'];
                            array_push($retval, $tmp);
                        }
                    }

                    return $retval;
                }

                function drawreg($fourcode)
                {
                    global $fl_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT * FROM florida_state_reg WHERE FOURCODE = '$fourcode'";
                    //echo("<br>$sql<br>");
                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $dem = $row['DEM'];
                            $rep = $row['REP'];
                            $npp = $row['NPP'];
                            $tot = $row['TOT'];
                            $oth = $row['OTH'];
                        }
                    }

                    $dem_pct = makeplainpercent($dem, $tot);
                    $rep_pct = makeplainpercent($rep, $tot);

                    $dem_pct_draw = makepct($dem, $tot);
                    $rep_pct_draw = makepct($rep, $tot);
                    $npp_pct_draw = makepct($npp, $tot);
                    $oth_pct_draw = makepct($oth, $tot);

                    if ($dem_pct > $rep_pct) {
                        $advantage = "<span class='blueme boldme'>D +" . number_format(($dem_pct - $rep_pct), 2) . "%</span>";
                    }

                    if ($rep_pct > $dem_pct) {
                        $advantage = "<span class='redme boldme'>R +" . number_format(($rep_pct - $dem_pct), 2) . "%</span>";
                    }

                    $drawme = "
        <p class='boldme' align='center'>TOTAL VOTERS: " . number_format($tot) . "</p><p align='center'>$advantage</p><p align='center'><span class='blueme boldme'>DEM: $dem_pct_draw</span>&nbsp;--&nbsp;<span class='redme boldme'>REP: $rep_pct_draw</span>&nbsp;--&nbsp;NPP: $npp_pct_draw -- OTH: $oth_pct_draw</p>";

                    if (!$dem) {
                        $drawme = '';
                    }

                    $arr = Array("AL", "GA", "HI", "IL", "IN", "MI", "MN", "MS", "MO", "MT", "ND", "OH", "SC", "TN", "TX", "VT", "VA", "WA", "WI");
                    foreach ($arr as $entry) {
                        $thisstate = mb_substr($fourcode, 0, 2);
                        //echo("<br>COMPARING $thisstate with Array entry $entry");
                        if (mb_substr($fourcode, 0, 2) == $entry) {
                            $drawme = "<h2 class='boldme itcme' align='center'>This State Does Not Have Partisan Voter Registration</h2>";
                        }
                    }

                    $arr = Array("AR", "CT", "ID", "MA", "NE", "NH", "NC", "OK", "PA", "RI", "UT", "WV");
                    foreach ($arr as $entry) {
                        if (mb_substr($fourcode, 0, 2) == $entry) {
                            $drawme = "<h2 class='boldme itcme' align='center'>This State Fails to Provide its Partisan Registration by Congressional District</h2>";
                        }
                    }

                    return $drawme;

                }

                function makeplainpercent($portion, $total)
                {
                    $x = ($portion / $total) * 100;

                    return $x;
                }


                ?>
            </div>
        </div>
    </div>
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
