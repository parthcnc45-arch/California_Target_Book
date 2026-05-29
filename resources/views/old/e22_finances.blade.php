@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2022 FPPC / FEC Finance Summaries | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2022 FPPC / FEC Finance Summaries
    </h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $total_raised, $total_spent, $dist_totals;
$enddraw = '';
$nav_draw = '';

$dists = populate_districts();
$fed_filed = populate_fed_filed();

$c_order = Array(
  ".GOV"  => "Governor",
  ".LTG"  => "Lt. Governor",
  ".SOS"  => "Secretary of State",
  ".ATG"  => "Attorney General",
  ".TRS"  => "Treasurer",
  ".CON"  => "Controller",
  ".INS"  => "Insurance Commissioner",
  ".SPI"  => "Superintendent of Public Instruction"
  );


$sections = Array(
    "CONSTITUTIONAL" => "Constitutional Offices",
    "ASSEMBLY"       => "State Assembly",
    "SENATE"         => "State Senate",
    "BOE"            => "State Board of Equalization",
    "CONGRESS"       => "US House",
    "US_SENATE"      => "US Senate",
    "ALL"            => "All",
    
);



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

/*
$js = "$(document).ready(function() {
        $('#lemp_table').tablesorter({ 
                headers: {
                1: {
                    sorter: 'fancyNumber'
                },
                    2: {
                    sorter: 'fancyNumber'
                },
                3: {
                    sorter: 'fancyNumber'
                }
                    } 
            });
    });";
array_push($endjava, $js);
*/

$count = 0;
foreach($sections as $section => $verbose) {
    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>local_atm</i>
                        $verbose
                    </a>
                  </li>";

    $enddraw .= "<section id='p$section' class='$active_class'> <!--BEGIN SECTION DIV-->";
    $enddraw .= "<div class='prop_div' align='center'> <!--BEGIN PROP DIV--> ";
    $enddraw .= "<h2>$verbose</h2>";

   if($section == "CONSTITUTIONAL") {

        foreach($c_order as $fourcode => $verbose2) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN CONSTITUTIONAL PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
          
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END CONSTITUTIONAL PANEL DIV -->";


        }
        $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END CONSTITUTITONAL SECTION-->";

   } elseif($section == "ASSEMBLY") {
      foreach($pages['ASSEMBLY'] as $fourcode => $ignore) {
	  $t = get_state($fourcode, $section);
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode - \$" . number_format($dist_totals[$fourcode]) . " Raised</p>";         
          $enddraw .= $t;
          $enddraw .= "</div> <!--END ASSEMBLY PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END ASSEMBLY SECTION-->";
  } elseif($section == "SENATE") {
      foreach($pages['SENATE'] as $fourcode => $ignore) {
	  $t = get_state($fourcode, $section);
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN SENATE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode - \$" . number_format($dist_totals[$fourcode]) . " Raised</p>";         
          $enddraw .= $t;
          $enddraw .= "</div> <!--END SENATE PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END SENATE SECTION-->";


  } elseif($section == "BOE") {
      foreach($pages['BOE'] as $fourcode => $ignore) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN BOE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END BOE PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END BOE SECTION-->";


  } elseif($section == "CONGRESS") {
      foreach($pages['CONGRESS'] as $fourcode => $ignore) {
          $t = get_fed($fourcode, $section);
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN US CONGRESS PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode - \$" . number_format($dist_totals[$fourcode]) . " Raised</p>";         
          $enddraw .= $t;
          $enddraw .= "</div> <!--END US CONGRESS PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END US CONGRESS SECTION-->";

  } elseif($section == "US_SENATE") {
	  $t = get_fed(".SN2", $section);

          $enddraw .= "<div class='panel justifyme'> <!--BEGIN US SENATE PANEL DIV -->
                        <p style = 'text-align: center !important;'>US SENATE - \$" . number_format($dist_totals['.SN2']) . " Raised</p>";         
          $enddraw .= $t;
          $enddraw .= "</div> <!--END US SENATE PANEL DIV -->";
          $enddraw .= "</div><!--END PROP DIV-->  
              </section><!--END BOE SECTION-->";          

  } elseif($section == "ALL") {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN ALL DIV -->
                        <p style = 'text-align: center !important;'>ALL</p>";         
          $enddraw .= "<div class='boxcontainer'>
  <div class='box1'>
    <div align='center' class='fixme'>
      <form action=''>
      <input type='text' name='search' value='' id='people_search' placeholder='Search By Candidate/Jurisdiction' title='Start typing to narrow results' autofocus />
        <br>
      </form>
    </div>
  </div>

  <div class='box2'>
  </div>
</div>";                        
          $enddraw .= get_all("ALL", $section);
          $enddraw .= "</div> <!--END US SENATE PANEL DIV -->";
          $enddraw .= "</div><!--END PROP DIV-->  
              </section><!--END BOE SECTION-->";  
  }        



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
	<p align='center'>RAISED BY STATE CANDIDATES: \$" . number_format($total_raised['STATE']) . " - SPENT BY STATE CANDIDATES: \$" . number_format($total_spent['STATE']) . "<br>
			  RAISED BY FEDERAL CANDIDATES: \$" . number_format($total_raised['FEDERAL']) . " - SPENT BY FEDERAL CANDIDATES: \$" . number_format($total_spent['FEDERAL']) . "</p>
	
        <!--BEGIN ENDDRAW-->

            $enddraw

       <!--END ENDDRAW-->

        </div> <!--END CONTENT WRAP -->
    
    </div> <!--END MAIN ROW-->
        
");

//$conn = Util::get_ctb_conn();


function populate_fed_filed() {
  $conn = Util::get_ctb_conn();
  $sql = "SELECT * FROM nufec_fed_candidates WHERE year = 2022 && fourcode LIKE 'CA%'";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $cand_id = $row['cand_id'];
      $filed = $row['filed'];
      $retval[$cand_id] = $filed;
    }
  }
  return $retval;
}

function get_all($dist, $section) {
  global $all_arr;
  $style = get_colors($section);
  $th_style = $style['head'];
  $colspan = $style['cols'];

  $retval = "<div>
    <table class='table table-hover table-responsive w-auto' align='center' v-ctb-table>
      <thead style='$th_style'>
        <tr>
          <th>OFFICE</th>
          <th>RACE</th>
          <th>CANDIDATE</th>
          <th>PARTY</th>
	  <th>CAND ID</th>
          <th class='rightme'>RCPT TOT</th>
          <th class='rightme'>CAND LOAN</th>
          <th class='rightme'>EXPN TOT</th>
          <th class='rightme'>LAST COH</th>
          <th class='rightme'>LAST RPT</th>
        </tr>
      </thead>
  $colspan
      <tbody>
      $all_arr
      </tbody>
    </table>
  </div>

  ";  
  return $retval;
}

function get_fed($dist, $section) {
  global $fed_filed, $total_raised, $total_spent, $all_arr, $dist_totals;
  $style = get_colors($section);
  $th_style = $style['head'];
  $colspan = $style['cols'];

  $retval = "<div>
    <table class='table table-hover table-responsive w-auto' align='center'>
      <thead style='$th_style'>
        <tr>
          <th>CANDIDATE</th>
          <th>DATE FILED</th>
          <th class='rightme'>RAISED THIS CYCLE</th>
          <th class='rightme'>SPENT THIS CYCLE</th>
          <th class='rightme'>ENDING $</th>
          <th class='rightme'>CAND. LOANS</th>
          <th class='rightme'>END DT</th>
        </tr>
      </thead>
  $colspan
      <tbody>

  ";
  $x = getstatecommittees($dist);

  foreach ($x as $committee) {
    $thiscmte = isset($committee['cand_id']) ? $committee['cand_id'] : '';
    $thiscand = isset($committee['namf']) && isset($committee['naml']) && isset($committee['party']) ? $committee['namf'] . " " . $committee['naml'] . " (" . $committee['party'] . ")" : '';
    $thiscmteid = isset($committee['cmte_id']) ? $committee['cmte_id'] : '';
    $thislink = "<a href='https://californiatargetbook.com/ctb-legacy/fec_cmte_report.php?id=$thiscmteid&cycle=2024' target='_blank'>$thiscand</a>";
    $fedsummary = get_fec_summary($thiscmte);
    if (empty($dist_totals[$dist])) {
        $dist_totals[$dist] = isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0;
    } else {
        $dist_totals[$dist] += isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0;
    }
    $retval .= "
        <tr>
          <td class='leftme'>$thislink</th>
          <td align='right'>" . (isset($fed_filed[$thiscmte]) ? $fed_filed[$thiscmte] : '') . "</td>
          <td align='right'>\$" . number_format(isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0) . "</td>
          <td align='right'>\$" . number_format(isset($fedsummary['EXPN']) ? $fedsummary['EXPN'] : 0) . "</td>
          <td align='right'>\$" . number_format(isset($fedsummary['COH_END']) ? $fedsummary['COH_END'] : 0) . "</td>
          <td align='right'>\$" . number_format(isset($fedsummary['CAND_LOANS']) ? $fedsummary['CAND_LOANS'] : 0) . "</td>
          <td align='right'>" . (isset($fedsummary['CVG_END_DT']) ? $fedsummary['CVG_END_DT'] : '') . "</td>
        <tr>
    ";

    $end_row = "<tr class='rowsearch'>
                  <td>$section</td>
                  <td>$dist</td>
                  <td>" . (isset($committee['naml']) && isset($committee['namf']) ? $committee['naml'] . ", " . $committee['namf'] : '') . "</td>
                  <td>" . (isset($committee['party']) ? $committee['party'] : '') . "</td>
		  <td>" . (isset($committee['cand_id']) ? $committee['cand_id'] : '') . "</td>
                  <td align='right'>\$" . number_format(isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0) . "</td>
                  <td align='right'>\$" . number_format(isset($fedsummary['CAND_LOANS']) ? $fedsummary['CAND_LOANS'] : 0) . "</td>
                  <td align='right'>\$" . number_format(isset($fedsummary['EXPN']) ? $fedsummary['EXPN'] : 0) . "</td>
                  <td align='right'>\$" . number_format(isset($fedsummary['COH_END']) ? $fedsummary['COH_END'] : 0) . "</td>
                  <td align='right'>" . (isset($fedsummary['CVG_END_DT']) ? $fedsummary['CVG_END_DT'] : '') . "</td>
                </tr>";

    $all_arr .= $end_row;

    $total_spent['FEDERAL'] = isset($total_spent['FEDERAL']) ? $total_spent['FEDERAL'] + (isset($fedsummary['EXPN']) ? $fedsummary['EXPN'] : 0) : (isset($fedsummary['EXPN']) ? $fedsummary['EXPN'] : 0);
    $total_raised['FEDERAL'] = isset($total_raised['FEDERAL']) ? $total_raised['FEDERAL'] + (isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0) : (isset($fedsummary['RECEIPTS']) ? $fedsummary['RECEIPTS'] : 0);
  }
  $retval .= "</tbody></table></div>";
  return $retval;

}

function get_fec_summary($candidate) {
  $conn = Util::get_ctb_conn();
  $tmp = Array();
  $retval = Array();
  $sql = "SELECT * FROM nufec_weball_22 WHERE CAND_ID = '$candidate'";
  //echo("<Br>$sql<br>");
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $tmp['RECEIPTS']    = $row['TTL_RECEIPTS'];
      $tmp['EXPN']      = $row['TTL_DISB'];
      $tmp['COH_START'] = $row['COH_BOP'];
      $tmp['COH_END']   = $row['COH_COP'];
      $tmp['CAND_LOANS']  = $row['CAND_LOANS'];
      $tmp['OTH_LOANS'] = $row['OTHER_LOANS'];
      $tmp['CVG_END_DT'] = $row['CVG_END_DT'];
      $tmp['DEBTS']    = $row['DEBTS_OWED_BY'];
      $year = mb_substr($row['CVG_END_DT'], 6, 4);
      $month = mb_substr($row['CVG_END_DT'], 0, 2);
      $day = mb_substr($row['CVG_END_DT'], 3,2);
      $tmp['CVG_END_DT'] = $year . "-" . $month . "-" . $day;
      }
  }

  $retval = $tmp;

  return $retval;
}


function get_colors($section) {
  switch($section) {
    case "ASSEMBLY":
      //DARK BLUE - ASSEMBLY
      $head = "#00334d";
      $columns = Array("#ffffff", "#e6f7ff", "#cceeff", "#b3e6ff", "#99ddff", "#80d4ff", "#66ccff", "#4dc3ff", "#f0f0f5");
      //$columns = Array("#ffffff", "#e6e6ff", "#ccccff", "#b3b3ff", "#9999ff", "#8080ff", "#6666ff", "#4d4dff", "#f0f0f5");
      break;
    case "SENATE":
      //DARK GREEN - STATE SENATE
      $head = "#133913";
      $columns = Array("#ffffff", "#ecf9ec", "#d9f2d9", "#c6ecc6", "#b3e6b3", "#9fdf9f", "#8cd98c", "#79d279", "#f0f0f5");
      break;
    case "CONSTITUTIONAL":
      //DARK PURPLE - CONSTITUTIONAL
      $head = "#330033";
      $columns = Array("#ffffff", "#ffe6ff", "#ffccff", "#ffb3ff", "#ff99ff", "#ff80ff", "#ff66ff", "#ff4dff", "#f0f0f5");
      break;
    case "BOE":
      //DARK BROWN - BOARD OF EQUALIZATION
      $head = "#4d3900";
      $columns = Array("#ffffff", "#fff9e6", "#fff2cc", "#ffecb3", "#ffe699", "#ffdf80", "#ffd966", "#ffd24d", "#f0f0f5");
      break;
    case "CONGRESS":
      //DARK RED - CONGRESS
      $head = "#4d0000";
      $columns = Array("#ffffff", "#ffffff", "#ffe6e6", "#ffb3b3", "#ff9999", "#ff8080", "#f0f0f5");
      break;
    case "US_SENATE":
      //ORANGE - US CSENATE
      $head = "#4d1f00";
      $columns = Array("#ffffff", "#ffffff", "#fff0e6", "#ffe0cc", "#ffd1b3", "#ffc299", "#f0f0f5");
      break;
    case "ALL":
      //DARK PURPLE
      $head = "#330033";
      $columns = Array("#ffffff", "#ffffff", "#ffffff", "#ffffff", "#ffffff", "#ffe6ff", "#ffccff", "#ffb3ff", "#ff99ff", "#f0f0f5");
      break;

    default:
      break;
      
  }
  $head_style = "background-color: $head; color: white !important; font-weight: bold;";
  $cols = "<colgroup>";
  foreach($columns as $color) {
    $cols .= "<col style='background-color: $color;'>";
  }
  $cols .= "</colgroup>";
  

  $retval['head'] = $head_style;
  $retval['cols'] = $cols;
  return $retval;
    

}

function get_state($dist, $section) {
  global $total_raised, $total_spent, $all_arr, $dist_totals;
  $style = get_colors($section);
  $th_style = isset($style['head']) ? $style['head'] : '';
  $colspan = isset($style['cols']) ? $style['cols'] : '';

  $retval = "<div class='table-responsive'>
    <table class='table table-hover w-auto' align='center'>
      <thead style='$th_style'>
        <tr>
          <th class='leftme'>CANDIDATE</th>
          <th class='rightme'>RAISED LAST</th>
          <th class='rightme'>SINCE</th>
          <th class='rightme'>LIFETIME RAISED</th>
          <th class='rightme'>LIFETIME SPENT</th>
          <th class='rightme'>LOANS</th>
          <th class='rightme'>DEBT</th>
          <th class='rightme'>CASH ON HAND</th>
          <th class='rightme'>PD END</th>
        </tr>
      </thead>
      <tbody>";

  $x = getstatecommittees($dist);

  foreach($x as $committee) {
    $thiscmte = isset($committee['cmte_id']) ? $committee['cmte_id'] : '';
    $thiscandid = isset($committee['cand_id']) ? $committee['cand_id'] : '';
    $thiscand = isset($committee['namf']) && isset($committee['naml']) && isset($committee['party']) ? $committee['namf'] . " " . $committee['naml'] . " (" . $committee['party'] . ")" : '';
    $lastdate = '';

    $last = getallf460redux($thiscmte);




    $lastsummary = '0.00';
    $y2015summary = '0.00';
    $totalraised = '0.00';
    $raisedthis = '0.00';
    $raised2015 = '0.00';
    $raisedsince = '0.00';
    $totalspent = '0.00';
    $spentthis = '0.00';
    $spent2015 = '0.00';
    $loans = '0.00';
    $unpaid = '0.00';
    $coh = '0.00';
    $raised_last  = '0.00';
    $raised_lifetime = '0.00';
    $spent_lifetime = '0.00';

    if(isset($last)) {
      if(isset($last['LAST_DATE'])) {
        $lastdate = $last['LAST_DATE'];
      } 

      $raised_last = isset($last['LAST_RCPT']) ? $last['LAST_RCPT'] : '0.00';
      $raised_lifetime = isset($last['LIFETIME_RCPT']) ? $last['LIFETIME_RCPT'] : '0.00';
      $spent_lifetime  = isset($last['LIFETIME_EXPN']) ? $last['LIFETIME_EXPN'] : '0.00';
      $loans = isset($last['LOANS']) ? $last['LOANS'] : '0.00';
      $unpaid = isset($last['DEBTS']) ? $last['DEBTS'] : '0.00';
      $coh = isset($last['COH']) ? $last['COH'] : '0.00';
    }
    $f497s = getf497filingssince($thiscmte, $lastdate);
    $raisedsince = getf497amounts($f497s, $lastdate);

    if($thiscmte) {
      $thislink = "<a href='/ctb-legacy/cmlocal2.php?id=$thiscmte' target='_blank'>$thiscand</a>";
      if(!$lastdate) {
        $lastdate = 'No Report Yet';
      }
    } else {
      $thislink = "<a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=$thiscandid' target='_blank'><em>$thiscand</em></a>";
      $lastdate = 'No Committee';
    }

    $totalraised = $raised_lifetime + $raisedsince;
    $totalspent = $spent_lifetime;

    if(empty($dist_totals[$dist])) {
      $dist_totals[$dist] = $totalraised;
    } else {
      $dist_totals[$dist] += $totalraised;
    }
    $retval .= "
        <tr>
          <td class='leftme'>$thislink</td>
          <td align='right'>\$" . number_format($raised_last) . "</td>
          <td align='right'>\$" . number_format($raisedsince) . "</td>
          <td align='right'>\$" . number_format($totalraised) . "</td>
          <td align='right'>\$" . number_format($totalspent) . "</td>
          <td align='right'>\$" . number_format($loans) . "</td>
          <td align='right'>\$" . number_format($unpaid) . "</td>
          <td align='right'>\$" . number_format($coh) . "</td>
          <td class='rightme'>$lastdate</td>
        </tr>
    ";

    $end_row = "<tr class='rowsearch'>
                  <td>$section</td>
                  <td>$dist</td>
                  <td>" . $committee['naml'] . ", " . $committee['namf'] . "</td>
                  <td>" . $committee['party'] . "</td>
                  <td>$thiscandid</td>
                  <td align='right'>\$" . number_format($totalraised) . "</td>
                  <td align='right'>\$" . number_format($loans) . "</td>
                  <td align='right'>\$" . number_format($totalspent) . "</td>
                  <td align='right'>\$" . number_format($coh) . "</td>
                  <td class='rightme'>$lastdate</td>
                </tr>";

    $all_arr .= $end_row;


    $total_spent['STATE'] = isset($total_spent['STATE']) ? $total_spent['STATE'] + $totalspent : $totalspent;
    $total_raised['STATE'] = isset($total_raised['STATE']) ? $total_raised['STATE'] + $totalraised : $totalraised;
  }
  $retval .= "</tbody></table></div>";
  return $retval;
}


function populate_districts() {
  global $pages;
  $conn = Util::get_ctb_conn();
  $retval = Array();
  $sql = "SELECT * FROM ctb_cand_filed_v2 WHERE year = '2022' GROUP BY fourcode ORDER BY fourcode";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $fourcode = $row['fourcode'];
      $id = $row['id'];

      array_push($retval, $row['fourcode']);

      if(mb_substr($fourcode, 0, 1) == ".") {
        if($fourcode == ".SN1" || $fourcode == ".SN2") {
          $pages['US_SENATE'][$fourcode][$id] = $row;
        } else {
          $pages['CONSTITUTIONAL'][$fourcode][$id] = $row;
        }
      } elseif(mb_substr($fourcode, 0, 3) == "BOE") {
        $pages['BOE'][$fourcode][$id] = $row;
      } elseif(mb_substr($fourcode, 0, 2) == "AD") {
        $pages['ASSEMBLY'][$fourcode][$id] = $row;
      } elseif(mb_substr($fourcode, 0, 2) == "SD") {
        $pages['SENATE'][$fourcode][$id] = $row;
      } elseif(mb_substr($fourcode, 0, 2) == "CD") {
        $pages['CONGRESS'][$fourcode][$id] = $row;
      }
    }
  }
  return $retval;
}

function getstatecommittees($dist) {
  $conn = Util::get_ctb_conn();
  $retval = Array();
  $tmp =  Array();
  $sql = "SELECT * FROM ctb_cand_filed_v2 WHERE (year = '2021' || year = '2022') && (type = 'P' || type = 'S') && fourcode = '$dist' && toptwo != 3 && hide != 1";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $tmp['namf'] = $row['namf'];
      $tmp['naml'] = $row['naml'];
      $tmp['cand_id'] = $row['cand_id'];
      $tmp['cmte_id'] = $row['cmte_id'];
      $tmp['party'] = $row['party'];
      if($row['is_inc']) {
        $tmp['party'] .= "-Inc";
      }
      array_push($retval, $tmp);
    }
  }
  return $retval;
}

function getallf460redux($committee) {

  $conn = Util::get_ctb_conn();
  $retval = Array();
  $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '0' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC";
  $result = $conn->query($sql);
  $last_end = '';
  $query = '';
  $last_report_date = '';
  $last_report_filing = '';
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $this_end = $row['RPT_END'];
      if(empty($last_report_date)) {
        $last_report_date = $this_end;
        $last_report_filing = $row['FILING_ID'];
        $retval['LAST_DATE'] = $last_report_date;
        $retval['LAST_FILING'] = $last_report_filing;
      }
      $tmp['FILING_ID'] = $row['FILING_ID'];
      $tmp['AMEND_ID']  = $row['FILING_SEQUENCE'];
      $tmp['RPT_END'] = $row['RPT_END'];
      if($this_end != $last_end) {
        $query .= " ( FILING_ID = " . $tmp['FILING_ID'] . " AND AMEND_ID = " . $tmp['AMEND_ID'] . " ) OR";
      }
      $last_end = $this_end;
    }
  }


  //RETRIEVE TOTALS
  $query = rtrim($query, ' OR');

  if(strlen($query) < 2) {
	return FALSE;
  }

  $sql = "SELECT AMOUNT_A, AMOUNT_B, AMEND_ID, LINE_ITEM, FILING_ID 
          FROM calaccess_raw_SMRY_CD 
          WHERE FORM_TYPE = 'F460' 
	  AND ( $query ) 
	  AND LINE_ITEM IN (5, 11, 16, 2, 19) 
	  ORDER BY FILING_ID DESC, 
	  LINE_ITEM";



  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $line_item = $row['LINE_ITEM'];

      switch($line_item) {
        case "5": //RCPT
          if($row['FILING_ID'] == $last_report_filing) {
            $retval['LAST_RCPT'] = $row['AMOUNT_A'];
          }
	  if(empty($retval['LIFETIME_RCPT'])) {
		$retval['LIFETIME_RCPT'] = $row['AMOUNT_A'];
	  } else {
               $retval['LIFETIME_RCPT'] += $row['AMOUNT_A'];
	  }
          break;
        case "11": //EXPN
	  if(empty($retval['LIFETIME_EXPN'])) {
		$retval['LIFETIME_EXPN'] = $row['AMOUNT_A'];
	  } else {
                $retval['LIFETIME_EXPN'] += $row['AMOUNT_A'];
	  }
          break;
        case "16": //COH
          if($row['FILING_ID'] == $last_report_filing) {
            $retval['COH'] = $row['AMOUNT_A'];
          }       
          break;
        case "2": //LOANS
	  if(empty($retval['LOANS'])) {
		$retval['LOANS'] = $row['AMOUNT_A'];
   	  } else {
		$retval['LOANS'] += $row['AMOUNT_A'];
	  }
          $retval['LOANS'] += $row['AMOUNT_A'];
          break;
        case "19": //DEBT
          if($row['FILING_ID'] == $last_report_filing) {
            $retval['DEBTS'] = $row['AMOUNT_A'];
          }         
          break;
        default:
          break;
      }

    }
  }
  //echo("<br>DUMP<br>");
  //var_dump($retval);
 

  return $retval;

}


function getf497filingssince($committee, $date) {
  $conn = Util::get_ctb_conn();
  $tmp = Array();
  $retval = Array();
  $lastfiling = '';
  $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && RPT_END > '$date' && FILING_TYPE <> '0' ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $thisfiling = $row['FILING_ID'];
      if($thisfiling == $lastfiling) {
        //DO NOTHING
      } else {
        $tmp['FILING_ID'] = $row['FILING_ID'];
        array_push($retval, $tmp);
      }
      $lastfiling = $thisfiling;
    }
  }
  return $retval;
}

function getf497amounts($filings, $lastdate) {
  $conn = Util::get_ctb_conn();
  $retval = 0;
  $highest = '';
  foreach($filings as $filing) {
    $sql = "SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE FROM calaccess_raw_S497_CD WHERE FILING_ID = '" . $filing['FILING_ID'] . "' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    $highest = '';
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if(!$highest) {
          $highest = $row['AMEND_ID'];
        }
        $thisamend = $row['AMEND_ID'];
        if($thisamend < $highest) {
          //DO NOTHING
        } else {
          if($row['CTRIB_DATE'] > $lastdate) {
            $retval += $row['AMOUNT'];
          }
        }
      }
    }
    //echo("<br>Retval is $retval after processing filing #" . $filing['FILING_ID'] . "<Br>");
  }

  return $retval;
}

function getsummary($filing) {
  $conn = Util::get_ctb_conn();

  $sql = "SELECT AMOUNT_A, AMOUNT_B, AMEND_ID, LINE_ITEM 
          FROM calaccess_raw_SMRY_CD 
          WHERE FILING_ID = '$filing' && REC_TYPE = 'SMRY' && (LINE_ITEM = 5 || LINE_ITEM = 11 || LINE_ITEM = 16 || LINE_ITEM = 2 || LINE_ITEM = 19) ORDER BY AMEND_ID DESC, LINE_ITEM";

  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $line_item = $row['LINE_ITEM'];

      switch($line_item) {
        case "5": //RCPT
          $retval['RCPT'] = $row['AMOUNT_A'];
          $retval['YTD_RCPT'] = $row['AMOUNT_B'];
          $retval['LIFETIME_RCPT'] += $row['AMOUNT_A'];
          break;
        case "11": //EXPN
          $retval['EXPN'] = $row['AMOUNT_A'];
          $retval['YTD_EXPN'] = $row['AMOUNT_B'];
          $retval['LIFETIME_EXPN'] += $row['AMOUNT_A'];
          break;
        case "16": //COH
          $retval['COH'] = $row['AMOUNT_A'];
          break;
        case "2": //LOANS
          $retval['LOANS'] = $row['AMOUNT_A'];
          break;
        case "19": //DEBT
          $retval['DEBTS'] = $row['AMOUNT_A'];
          break;
        default:
          break;
      }

    }
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

.rightme {
  text-align: right;
}

.leftme {
  text-align: left;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

th {
  color: white !important;
}

</style>


@endsection