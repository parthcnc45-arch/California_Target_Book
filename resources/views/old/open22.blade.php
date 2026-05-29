@extends('layouts.book')
@section('title', 'Oepn Seats 2024 | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Open Seats 2024
    </h2>

<?php

$sections = Array(
    "OPEN"	 	      => "chair",
    "OPEN_FEDERAL"	 	      => "chair",
//    "PROPS"		      => "content_paste",
//    "CALENDAR"		  => "calendar_month",
//    "INCUMBENTS"	  => "person_outline",
//    "CANDIDATES" 	  => "follow_the_signs",
//    "CONTRIBUTIONS" => "attach_money",
//    "IE"		        => "local_atm",
);

$endjava = Array();

$js = " jQuery.tablesorter.addParser({
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

$count = 0;
foreach($sections as $section => $icon) {
    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>$icon</i>
                        $section
                    </a>
                  </li>";



    $enddraw .= "<section id='p$section' class='$active_class'> <!--BEGIN $section SECTION DIV-->";
    $enddraw .= "<div class='prop_div' align='center'> <!--BEGIN $section PROP DIV--> ";
    $enddraw .= "<h2>$section</h2>";

    $text = '';

    switch($section) {
      case "OPEN":
        $text = get_open();
        break;
      case "OPEN_FEDERAL":
	$text = get_open_federal();
	break;
      case "PROPS":
        $text = get_props();
        break;
      case "CALENDAR":
        $text = get_calendar();
        break;
      case "INCUMBENTS":
        $text = get_incumbents();
        break;
      case "CANDIDATES":
        $text = get_candidate_list();
        break;
      case "CONTRIBUTIONS":
        $text = get_contributions();
        break;
      case "IE":
        $text = get_ies();
        break;
    }

    $enddraw .= "<div class='panel justifyme'> <!--BEGIN $section PANEL DIV -->
                    <p style = 'text-align: justify !important;'>
                    $text
                    </p>
                  </div> <!--END $section PANEL DIV-->
                </div> <!--END $section PROP DIV--> 
                </section> <!--END $section SECTION -->";
}



echo("
        
        <div class='row'> <!--BEGIN MAIN ROW -->
            <div class='col-lg-10 center-block fn'> <!--BEGIN NAV DIV -->
                <nav class='clearfix page-nav'>
                    <ul class='clearfix'>
                        $nav_draw
                    </ul>
                </nav>
            </div> <!--END NAV DIV-->    

        <div class='content-wrap pt-xl'> <!--BEGIN CONTENT WRAP -->
        <!--BEGIN ENDDRAW-->

            $enddraw

       <!--END ENDDRAW-->

        </div> <!--END CONTENT WRAP -->
    
    </div> <!--END MAIN ROW-->
        
");



/*

FFFFFFFFFFFFFFFFFFFFFUUUUUUUU     UUUUUUUNNNNNNNN        NNNNNNNN       CCCCCCCCCCCCTTTTTTTTTTTTTTTTTTTTTTIIIIIIIIII    OOOOOOOOO    NNNNNNNN        NNNNNNNN  SSSSSSSSSSSSSSS 
F::::::::::::::::::::U::::::U     U::::::N:::::::N       N::::::N    CCC::::::::::::T:::::::::::::::::::::I::::::::I  OO:::::::::OO  N:::::::N       N::::::NSS:::::::::::::::S
F::::::::::::::::::::U::::::U     U::::::N::::::::N      N::::::N  CC:::::::::::::::T:::::::::::::::::::::I::::::::IOO:::::::::::::OON::::::::N      N::::::S:::::SSSSSS::::::S
FF::::::FFFFFFFFF::::UU:::::U     U:::::UN:::::::::N     N::::::N C:::::CCCCCCCC::::T:::::TT:::::::TT:::::II::::::IO:::::::OOO:::::::N:::::::::N     N::::::S:::::S     SSSSSSS
  F:::::F       FFFFFFU:::::U     U:::::UN::::::::::N    N::::::NC:::::C       CCCCCTTTTTT  T:::::T  TTTTTT I::::I O::::::O   O::::::N::::::::::N    N::::::S:::::S            
  F:::::F             U:::::D     D:::::UN:::::::::::N   N::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N:::::::::::N   N::::::S:::::S            
  F::::::FFFFFFFFFF   U:::::D     D:::::UN:::::::N::::N  N::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N:::::::N::::N  N::::::NS::::SSSS         
  F:::::::::::::::F   U:::::D     D:::::UN::::::N N::::N N::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N::::::N N::::N N::::::N SS::::::SSSSS    
  F:::::::::::::::F   U:::::D     D:::::UN::::::N  N::::N:::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N::::::N  N::::N:::::::N   SSS::::::::SS  
  F::::::FFFFFFFFFF   U:::::D     D:::::UN::::::N   N:::::::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N::::::N   N:::::::::::N      SSSSSS::::S 
  F:::::F             U:::::D     D:::::UN::::::N    N::::::::::C:::::C                     T:::::T         I::::I O:::::O     O:::::N::::::N    N::::::::::N           S:::::S
  F:::::F             U::::::U   U::::::UN::::::N     N:::::::::NC:::::C       CCCCCC       T:::::T         I::::I O::::::O   O::::::N::::::N     N:::::::::N           S:::::S
FF:::::::FF           U:::::::UUU:::::::UN::::::N      N::::::::N C:::::CCCCCCCC::::C     TT:::::::TT     II::::::IO:::::::OOO:::::::N::::::N      N::::::::SSSSSSS     S:::::S
F::::::::FF            UU:::::::::::::UU N::::::N       N:::::::N  CC:::::::::::::::C     T:::::::::T     I::::::::IOO:::::::::::::OON::::::N       N:::::::S::::::SSSSSS:::::S
F::::::::FF              UU:::::::::UU   N::::::N        N::::::N    CCC::::::::::::C     T:::::::::T     I::::::::I  OO:::::::::OO  N::::::N        N::::::S:::::::::::::::SS 
FFFFFFFFFFF                UUUUUUUUU     NNNNNNNN         NNNNNNN       CCCCCCCCCCCCC     TTTTTTTTTTT     IIIIIIIIII    OOOOOOOOO    NNNNNNNN         NNNNNNNSSSSSSSSSSSSSSS  

*/

function get_open() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT cycle, fourcode, incumbent, party, dscr, spec_pri, spec_gen, hide
          FROM ctb_open_seats
          WHERE hide != 1 && cycle = 2024
          ORDER BY fourcode";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $body .= "<tr>
                  <td><a href='/book/new/" . $row['fourcode'] . "' target='_blank'>" . $row['fourcode'] . "</a></td>
                  <td>" . $row['incumbent'] . " (" . $row['party']  . ")</td>
                  <td>" . $row['dscr'] . "</td>
                  <td>" . $row['spec_pri'] . "</td>
                  <td>" . $row['spec_gen'] . "</td>
                </tr>";

    }
  }
  $retval = "<p class='itcme'>*SD29's Josh Newman is running for re-election in SD37 due to the 2021 redistricting, and AD32's Vince Fong is a candidate for both AD32 and CD20</p>
		<table class='table-striped w-auto table-fit' v-ctb-table>
                <thead>
                  <tr>
                    <th>DISTRICT</th>
                    <th>INCUMBENT</th>
                    <th>REASON</th>
                    <th>SPECIAL PRI</th>
                    <th>SPECIAL GEN</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>";
  return $retval;              
}

function get_open_federal() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT fourcode, incumbent, party, reason
          FROM nufec_e24_open
          ORDER BY fourcode";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $fourcode = $row['fourcode'];
      if(mb_substr($fourcode, 2, 3) == "SEN") {
	$type = "S";
      } else {
	$type = "H";
      }
      $body[$type] .= "<tr>
                  <td><a href='/book/us/" . $row['fourcode'] . "' target='_blank'>" . $row['fourcode'] . "</a></td>
                  <td>" . $row['incumbent'] . " (" . $row['party']  . ")</td>
                  <td>" . $row['reason'] . "</td>
                </tr>";

    }
  }

  $retval = '';
  $t_verbose = Array(
	"S" => "U.S. Senate",
	"H" => "U.S. House of Representatives"
	);

  foreach($body as $type => $table_body) {
	$retval .= "<h3 align='center'>" . $t_verbose[$type] . "</h3>";
	$retval .= "<table class='table-striped w-auto table-fit' v-ctb-table>
                <thead>
                  <tr>
                    <th>DISTRICT</th>
                    <th>INCUMBENT</th>
                    <th>REASON</th>
                  </tr>
                </thead>
                <tbody>
                $table_body
                </tbody>
              </table>";
  }
  return $retval;              
}


function get_ies_fed() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT * FROM (
            SELECT can_id, can_nam, spe_id, spe_nam, ele_typ, can_off_sta, can_off_dis, can_off, exp_amo, agg_amo, sup_opp, pur, pay, file_num, prev_file_num, ie_id, rec_dat, STR_TO_DATE(exp_dat, '%d-%b-%y') AS exp_dat2, STR_TO_DATE(rec_dat, '%d-%b-%y') AS rec_dat2 
            FROM nufec_ie_22
          ) A
          WHERE rec_dat2 >= ( CURDATE() - INTERVAL 30 DAY ) && can_off_sta = 'CA'
          ORDER BY rec_dat2 DESC";

  $result = $conn->query($sql);
  $blacklist = Array(
      "C00667865"   => TRUE, //POLICE OFFICERS DEFENSE ALLIANCE
      "C00699801"   => TRUE, //VETERANS AID PAC
      "C00622472"   => TRUE, //ASSOCIATION FOR EMERGENCY RESPONDERS AND FIREFIGHTERS
      "C00759365"   => TRUE, //PATRIOTS FOR POLICE
      "C00681825"   => TRUE, //LAW ENFORCEMENT FOR A SAFER AMERICA
      "C00758953"   => TRUE, //THE AMERICAN FIREFIGHTERS INITIATIVE PAC
      "C00712885"   => TRUE, //AMERICAN VETERANS INITIATIVE
      "C00710178"   => TRUE, //HONORING AMERICAN LAW ENFORCEMENT

    );
  $arr = Array();
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $file_num = $row['file_num'];
      $id = $row['ie_id'];
      $arr[$file_num][$id] = $row;
      if($row['prev_file_num']) {
        $prev_filings[$row['prev_file_num']] = TRUE;
      }
    }
  }

  //echo("<br>BEFORE: ") . sizeof($arr) . " Entries.";

  foreach($prev_filings as $filing_id => $ignore) {
    unset($arr[$filing_id]);
  }

  //echo("<br>AFTER: ") . sizeof($arr) . " Entries.";

  foreach($arr as $filing_id => $transactions) {
    foreach($transactions as $tran_id => $t) {
      $cmte_id = $t['spe_id'];
      if($blacklist[$cmte_id]) {
        $skipped['count']++;
        $skipped['amt'] += $t['exp_amo'];
      } else {
        $fourcode = "CA";
        if($t['can_off'] == "H") {
          $fourcode .= $t['can_off_dis'];
        } elseif($t['can_off'] == "S") {
          $fourcode .= "SEN";
        } else {
          $fourcode = "POTUS";
        }
        $body .= "<tr>
                    <td>" . $filing_id . "</td>
                    <td>" . $t['rec_dat2'] . "</td>
                    <td>" . $t['spe_nam'] . "</td>
                    <td align='right'>" . number_format($t['exp_amo']) . "</td>
                    <td>" . $t['pur'] . "</td>
                    <td>" . $t['pay'] . "</td>
                    <td>" . $t['sup_opp'] . "</td>
                    <td>" . $t['can_nam'] . "</td>
                    <td>$fourcode</td>
                  </tr>";
      }
    }
  }


  $retval = "<h2 align='center'>IE FEDERAL</h2><p align='center'>* " . number_format($skipped['count']) . " Transactions totaling \$" . number_format($skipped['amt']) . " from charity telemarketing PACs falsely labeling their call center expenditures as political IEs have been omitted.</p>";
  $retval .= "<table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>FILING</th>
                    <th>DATE</th>
                    <th>COMMITTEE</th>
                    <th>AMOUNT</th>
                    <th>PURPOSE</th>
                    <th>VENDOR</th>
                    <th>SUP/OPP</th>
                    <th>CANDIDATE</th>
                    <th>DISTRICT</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>";
  return $retval;  

}

function get_props() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT prop_id, fppc_id, ballot_no, dscr, date_submitted, status, sigs_needed, sigs_deadline, sigs_submitted, sigs_verified, opp_cmte, sup_cmte, proponents
          FROM ctb_prop_board
          ORDER BY prop_id";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

      if(isset($row['sigs_submitted'])) {
        $submitted = number_format($row['sigs_submitted']);
      } else {
        $submitted = '';
      }

      if(isset($row['sigs_verified'])) {
        $verified = number_format($row['sigs_verified']);
      } else {
        $verified = '';
      }

      if($row['sup_cmte']) {
        $sup_lnk = "<a href='/ctb-legacy/cmlocal2.php?id=" . $row['sup_cmte'] . "' target='_blank'>" . $row['sup_cmte'] . "</a>";
      } else {
        $sup_lnk = '';
      }

      if($row['opp_cmte']) {
        $opp_lnk = "<a href='/ctb-legacy/cmlocal2.php?id=" . $row['opp_cmte'] . "' target='_blank'>" . $row['opp_cmte'] . "</a>";
      } else {
        $opp_lnk = '';
      }

      $body .= "<tr>
                  <td>" . $row['prop_id'] . "</td>
                  <td>" . $row['dscr'] . "</td>
                  <td>" . $row['date_submitted'] . "</td>
                  <td>" . $row['status'] . "</td>
                  <td align='right'>" . number_format($row['sigs_needed']) . "</td>
                  <td>" . $row['sigs_deadline'] . "</td>
                  <td align='right'>" . $submitted . "</td>
                  <td align='right'>" . $verified . "</td>
                  <td>" . $sup_lnk . "</td>
                  <td>" . $opp_lnk . "</td>
                  <td>" . $row['proponents'] . "</td>
                </tr>";
    }
  }
  $retval = "<table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>PROP</th>
                    <th>DESCRIPTION</th>
                    <th>SUBMITTED</th>
                    <th>STATUS</th>
                    <th class='rightme'>SIGS NEEDED</th>
                    <th>DEADLINE</th>
                    <th class='rightme'>SUBMITTED</th>
                    <th class='rightme'>VERIFIED</th>
                    <th>SUP</th>
                    <th>OPP</th>
                    <th>PROPONENTS</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>";
  return $retval;   

}

function get_incumbents() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT DIST, LEGISLATOR, CAND_ID, TERM_LIMIT 
          FROM ctb2016_e22_incumbent
          ORDER BY DIST";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $fourcode = $row['DIST'];
      if(mb_substr($fourcode, 0, 1) != ".") {
        $type = mb_substr($fourcode, 0, 2);
      } else {
        $type = "STW";
      }
      $inc_arr[$type][$fourcode] = $row['CAND_ID'];
      if($row['CAND_ID']) {
        $cand_arr[$row['CAND_ID']]['term_limit'] = $row['TERM_LIMIT'];
        $cand_arr[$row['CAND_ID']]['name'] = $row['LEGISLATOR'];
      }
    }
  }
  $sql = "SELECT dob, city, cand_id, party FROM ctb_cand_filed WHERE cycle = 2022";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $cand_id = $row['cand_id'];
      if($cand_arr[$cand_id]) {
        if(!$row['city']) {
          continue;
        }
        $cand_arr[$cand_id]['dob'] = $row['dob'];
        $cand_arr[$cand_id]['city'] = $row['city'];
        $cand_arr[$cand_id]['party'] = $row['party'];
      }
    }
  }

  $types = Array("SD", "AD", "CD", "STW");
  foreach($types as $type) {
    $table[$type] = "<table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>DISTRICT</th>
                    <th>INCUMBENT</th>
                    <th>PARTY</th>
                    <th>TERM LIMIT</th>
                    <th>RESIDENCE</th>
                    <th>DOB</th>
                  </tr>
                </thead>
                <tbody>";

    foreach($inc_arr[$type] as $fourcode => $cand_id) {
      $table[$type] .= "<tr>
                          <td>$fourcode</td>
                          <td>" . $cand_arr[$cand_id]['name'] . "</td>
                          <td>" . $cand_arr[$cand_id]['party'] . "</td>
                          <td>" . $cand_arr[$cand_id]['term_limit'] . "</td>
                          <td>" . $cand_arr[$cand_id]['city'] . "</td>
                          <td>" . $cand_arr[$cand_id]['dob'] . "</td>
                        </tr>";
    }
    $table[$type] .= "</tbody></table>";
  }

  foreach($types as $type) {
    $retval .= $table[$type];
  }
  return $retval;
}

function get_candidates() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT cycle, year, type, fourcode, naml, namf, cand_id, cmte_id, party, city 
          FROM ctb_cand_filed
          WHERE hide != 1 && year > 2021
          ORDER BY id DESC 
          LIMIT 50";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $filed_date = lookup_filed_date($row['cand_id']);
      if(mb_substr($row['cand_id'], 0, 1) != "1") {
          //USE FEC
        $cand_link = "<a href='https://www.fec.gov/data/candidate/" . $row['cand_id'] . "/?tab=filings' target='_blank'>" . $row['cand_id'] . "</a>";
        if($row['cmte_id']) {
          $cmte_link = "<a href='https://www.fec.gov/data/committee/" . $row['cmte_id'] . "/?tab=filings' target='_blank'>" . $row['cmte_id'] . "</a>";
        } else {
          $cmte_link = '';
        }
      } else {
          //USE FPPC
        $cand_link = "<a href='http://cal-access.sos.ca.gov/Misc/redirector.aspx?id=" . $row['cand_id'] . "' target='_blank'>" . $row['cand_id'] . "</a>";
        if($row['cmte_id']) {
          $cmte_link = "<a href='http://cal-access.sos.ca.gov/Misc/redirector.aspx?id=" . $row['cmte_id'] . "' target='_blank'>" . $row['cmte_id'] . "</a>";  
        } else {
          $cmte_link = "";
        }
        
      }
      $body .= "<tr>
                  <td><a href='/book/district/" . $row['fourcode'] . "' target='_blank'>" . $row['fourcode'] . "</a></td>
                  <td>" . $row['year'] . "</td>
                  <td>" . $row['naml'] . ", " . $row['namf'] . " (" . $row['party'] . ")</td>
                  <td>" . $cand_link . "</td>
                  <td>" . $cmte_link . "</td>
                  <td>" . $filed_date . "</td>
                </tr>";
    }
  }
  $retval = "<table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>DISTRICT</th>
                    <th>ELECTION YEAR</th>
                    <th>CANDIDATE</th>
                    <th>CAND ID</th>
                    <th>CMTE ID</th>
                    <th>DATE FILED</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>";
  return $retval;     
}

function get_candidate_list() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT text FROM ctb_analysis WHERE dist = 'CAND2022' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			return $row['text'];
		}
	}
}

function lookup_filed_date($cand_id) {
  $conn = Util::get_ctb_conn();
  $first = mb_substr($cand_id, 0, 1);
  if($first === "1") {
    //USE STATE
    $sql = "SELECT logged FROM ctb_fppc_filer_type WHERE filer_id = '$cand_id' ORDER BY logged DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        return mb_substr($row['logged'], 0, 10);
      }
    }
  } else {
    //USE FED
    $sql = "SELECT filed FROM nufec_fed_candidates WHERE cand_id = '$cand_id' ORDER BY filed DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        return $row['filed'];
      }
    }    
  }
}

function get_filing_info($filings) {
  $conn = Util::get_ctb_conn();
  foreach($filings as $filing_id => $amend_id) {
    $q .= " FILING_ID = '$filing_id' ||";
  }
  $q = substr($q, 0, -2);
  $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD 
          WHERE ( $q )";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $filing = $row['FILING_ID'];
      $retval[$filing] = $row;
    }
  }
  return $retval;
}

function get_ies_state() {

  $conn = Util::get_ctb_conn();
  $sql = "SELECT id, FILING_ID, AMEND_ID, LINE_ITEM, FORM_TYPE, EXPN_DSCR, EXP_DATE, AMOUNT 
          FROM calaccess_raw_S496_CD 
          WHERE EXP_DATE between date_sub(now(),INTERVAL 8 WEEK) and now() 
          ORDER BY FILING_ID, AMEND_ID DESC, LINE_ITEM";
  $result = $conn->query($sql);
  //echo("<br>$sql<br>");
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $filing = $row['FILING_ID'];
      $amend = $row['AMEND_ID'];
      $arr[$id] = $row;
      if(!isset($filings[$filing])) {
        $filings[$filing] = $amend;
      } else {
        continue;
      }
      
    }
  }


  $f = lookup_filing_filers($filings);
  //var_dump($f);
  //echo("<br>ARR DUMP<br>");
  //var_dump($arr);

  $info = get_filing_info($filings);
  //echo("<br>INFO DUMP<br>");
  //var_dump($info);
  

  foreach($arr as $id => $r) {
    $filing_id = $r['FILING_ID'];
    $amend_id = $r['AMEND_ID'];
    if($filings[$filing_id] != $amend_id) {
      //echo("<br>SKIPPING - BAD AMEND");
      continue;
    }

    $amt = $r['AMOUNT'];
    if($amt < 500) {
      //echo("<br>SKIPPING - SMALL AMOUNT");
      continue;
    }

    $this_filer_id = $f['filing_to_filer'][$filing_id];
    $this_filer_nm = $f['filernames'][$this_filer_id];

    $this_cand = $info[$filing_id]['CAND_NAML'];
    $this_juris = $info[$filing_id]['JURIS_DSCR'];
    $this_supopp = $info[$filing_id]['SUP_OPP_CD'];
    $this_dist = $info[$filing_id]['DIST_NO'];

    if($this_dist) {
      $this_juris = $this_juris . " - District $this_dist";
    }


    $link = "<a href='https://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";
    $link2 = "<a href='/ctb-legacy/cmlocal2.php?id=$this_filer_id'>$this_filer_nm</a>";

    $body .= "<tr>
                      <td>" . $link . "</td>
                      <td>" . $link2 . "</td>
                      <td align='right'>" . number_format($r['AMOUNT']) . "</td>
                      <td>" . $r['EXP_DATE'] . "</td>
                      <td>" . $r['EXPN_DSCR'] . "</td>
                      <td><$this_supopp/td>
                      <td>$this_cand</td>
                      <td>$this_juris</td>
                  </tr>";
  }

  $retval = "<h2>IE STATE</h2>
              <table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>FILING</th>
                    <th>COMMITTEE</th>
                    <th class='rightme'>AMOUNT</th>
                    <th>DATE</th>
                    <th>PURPOSE</th>
                    <th>SUP/OPP</th>
                    <th>CANDIDATE</th>
                    <th>OFFICE</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>

              ";
  return $retval;   

}


function get_contributions() {

  $conn = Util::get_ctb_conn();
  $sql = "SELECT id, FILING_ID, AMEND_ID, LINE_ITEM, FORM_TYPE, ENTY_NAML, ENTY_NAMF, ENTY_CITY, ENTY_ST, CTRIB_EMP, CTRIB_OCC, CTRIB_DATE, AMOUNT, CMTE_ID 
          FROM calaccess_raw_S497_CD 
          WHERE CTRIB_DATE between date_sub(now(),INTERVAL 4 WEEK) and now() 
          ORDER BY FILING_ID, AMEND_ID DESC, LINE_ITEM";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $filing = $row['FILING_ID'];
      $amend = $row['AMEND_ID'];
      $arr[$id] = $row;
      if(!isset($filings[$filing])) {
        $filings[$filing] = $amend;
      } else {
        continue;
      }
      
    }
  }
  $f = lookup_filing_filers($filings);
  

  foreach($arr as $id => $r) {
    $filing_id = $r['FILING_ID'];
    $amend_id = $r['AMEND_ID'];
    if($filings[$filing_id] != $amend_id) {
      continue;
    }

    $amt = $r['AMOUNT'];
    if($amt < 500) {
      continue;
    }

    $this_filer_id = $f['filing_to_filer'][$filing_id];
    $this_filer_nm = $f['filernames'][$this_filer_id];

    $this_form = $r['FORM_TYPE'];

    $ctrib_naml = $r['ENTY_NAML'];
    $ctrib_namf = $r['ENTY_NAMF'];

    $link = "<a href='https://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";


    if(!$ctrib_namf) {
      $ctrib_nm = $ctrib_naml;
    } else {
      $ctrib_nm = $ctrib_naml . ", " . $ctrib_namf;
    }
    $link2 = "<a href='/ctb-legacy/cmlocal2.php?id=$this_filer_id'>$this_filer_nm</a>";

    $ctrib_add = '';
    if($r['CTRIB_EMP']) {
      $ctrib_add = " (" . $r['CTRIB_OCC'] . ", " . $r['CTRIB_EMP'] . ")";
    }

    if($this_form == "F497P1") {
      //RECEIVED
      $body_r .= "<tr class='rowsearch'>
                      <td>" . $link . "</td>
                      <td>" . $link2 . "</td>
                      <td align='right'>" . number_format($r['AMOUNT']) . "</td>
                      <td>" . $ctrib_nm . $ctrib_add . "</td>
                      <td>" . $r['CTRIB_DATE'] . "</td>
                  </tr>";
    } else {
      //MADE
      $body_m .= "<tr class='rowsearch'>
                      <td>" . $link . "</td>
                      <td>" . $link2 . "</td>
                      <td align='right'>" . number_format($r['AMOUNT']) . "</td>
                      <td>" . $ctrib_nm . $ctrib_add . "</td>
                      <td>" . $r['CTRIB_DATE'] . "</td>
                  </tr>";      
    }
  }

    	$last = get_last_dl_time();

  $retval = "
<h6 align='center'>Cal-Access Database Updated " . $last['modified'] . "<br>" . $last['modified_elapsed'] . "</h6>
<div class='boxcontainer'>
	<div class='box1'>
		<div align='center' class='fixme'>
			<form action=''>
			<input type='text' name='search' value='' id='people_search' placeholder='Filter List...' title='Start typing to narrow results' autofocus />
				<br>
			</form>
		</div>
	</div>

	<div class='box2'>
	</div>
</div>
<br>
	    <h2>CONTRIBUTIONS RECEIVED</h2>
              <table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>FILING</th>
                    <th>RECIPIENT</th>
                    <th class='rightme'>AMOUNT</th>
                    <th>CONTRIBUTOR</th>
                    <th>DATE</th>
                  </tr>
                </thead>
                <tbody>
                $body_r
                </tbody>
              </table>

          <h2>CONTRIBUTIONS MADE</h2>
              <table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>FILING</th>
                    <th>CONTRIBUTOR</th>
                    <th class='rightme'>AMOUNT</th>
                    <th>RECIPIENT</th>
                    <th>DATE</th>
                  </tr>
                </thead>
                <tbody>
                $body_m
                </tbody>
              </table>

              ";
  return $retval;   

}

function lookup_filing_filers($filings) {
  $conn = Util::get_ctb_conn();
  $q = '';
  foreach($filings as $filing_id => $amend_id) {
    $q .= " (FILING_ID = $filing_id) ||";
  }
  $q = substr($q, 0, -2);
  $sql = "SELECT FILER_ID, FILING_ID 
          FROM calaccess_raw_FILER_FILINGS_CD
          WHERE ( $q )";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $filing_id = $row['FILING_ID'];
      $filer_id  = $row['FILER_ID'];
      $filer_index[$filer_id] = $filer_id;
      $filing_to_filer[$filing_id] = $filer_id;
    }
  }

  $q = '';
  foreach($filer_index as $filer_id => $ignore) {
    $q .= " ( FILER_ID = '$filer_id' ) ||";
  }
  $q = substr($q, 0, -2);
  $sql = "SELECT FILER_ID, NAML, NAMF, XREF_FILER_ID 
          FROM calaccess_raw_FILERNAME_CD 
          WHERE ( $q )
          GROUP BY FILER_ID";
  //echo("<br>$sql<br>");
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $filer = $row['FILER_ID'];
      $xref  = $row['XREF_FILER_ID'];
      $namf = $row['NAMF'];
      $naml = $row['NAML'];
      if(!$namf) {
        $name = $naml;
      } else {
        $name = $naml . ", " . $namf;
      }
      $filernames[$filer] = $name;
      $filernames[$xref] = $name;
    }

  }

  //echo("<br>FILERNAMES DUMP<br>");
  //var_dump($filernames);

  $retval['filernames'] = $filernames;
  $retval['filing_to_filer'] = $filing_to_filer;
  return $retval;
}

function get_ies() {
  $federal = get_ies_fed();
  $state = get_ies_state();
  $retval = $state . $federal;
  return $retval;

}

function get_calendar() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT date, category, event FROM ctb_calendar ORDER BY date";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $date = $row['date'];
      $days = days_until($date);
      if($days < 0) {
        continue;
      }
      $body .= "<tr>
                  <td>" . $row['date'] . "</td>
                  <td>" . $row['category'] . "</td>
                  <td>" . $row['event'] . "</td>
                  <td>" . $days . " Days Away</td>
                </tr>";
    }
  }

  $retval = "<table class='table-striped' v-ctb-table>
                <thead>
                  <tr>
                    <th>DATE</th>
                    <th>CATEGORY</th>
                    <th>EVENT</th>
                    <th>DAYS AWAY</th>
                  </tr>
                </thead>
                <tbody>
                $body
                </tbody>
              </table>";
  return $retval; 

}

function days_until($date) {
   $year = mb_substr($date, 0, 4);
   $month = mb_substr($date, 5, 2);
   $day = mb_substr($date, 8, 2);
   $cdate = mktime(0, 0, 0, $month, $day, $year);
   $today = time();
   //echo("<br>Checking $date, ");
   $difference = $cdate - $today;
   $retval = (floor($difference/60/60/24) + 1);
   //echo(" returning $retval");
   return $retval;

}

function get_last_dl_time() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT id, DATE_SUB(modified, INTERVAL 8 hour) AS modified, completed FROM snapshot_calaccess ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row;
			$modified = $row['modified'];
		}
	}

	//$timestamp = $year . "-" . $month . "-" . $day . " ($time)";

	$thistime = strtotime($modified);
	$timeago = humanTiming($thistime);

	$date = date('Y-m-d H:i:s');
	$elapsed = time_elapsed_string($modified);

	$retval['modified_elapsed'] = $elapsed;
	return $retval;

	
}

function time_sql2php($sqltime){
    return strtotime($sqltime . " GMT");
}
 

function time_sql2php_pdt($sqltime){
    return strtotime($sqltime . " PDT");
}
// Converts PHP time format to SQL Time Format
 
function time_php2sql($unixtime){
    return gmdate("Y-m-d H:i:s", $unixtime);
}

function time_elapsed_string($datetime, $full = true) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function humanTiming ($time) {

	//echo("<br>Converting $time...");

    $time = (time() - $time); // + 25200 to get the time since that moment
   // echo("Got $time...");
    $time = ($time<1)? 1 : $time;
    $tokens = array (
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
        //echo("Returning " . $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':''));
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}


?>  


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    foreach($endjava as $value) {
        echo($value);
    }

?>

</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.itcme {
	font-style: italic;
}

.rightme {
  text-align: right !important;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection