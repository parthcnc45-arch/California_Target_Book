

<div class='container-fluid no-border'>
    <ul class="text-center nav nav-tabs mb-3">
        <?php
            global $cached, $ie;
            $x = lookup_election_years($fourcode);
        $ie = load_ies($x, $fourcode);
        $active = TRUE;
            foreach($x['years'] as $year) {
        if($active) {
            $class = 'active';
            $active = FALSE;
        } else {
            $class = '';
        }
                echo("<li class='nav-item $class'><a class='nav-link' data-toggle='pill' href='#tab-campaign-" . $year . "'>Election $year</a></li>&nbsp;&nbsp;");              
            }
        ?>
     </ul> 
      <br />
      <div class='tab-content'>
    
            <?php
        
                $active = TRUE;
                foreach ($x['years'] as $year) {
                    
                    if($active) {
                        echo("<div class='tab-pane fade in active' id='tab-campaign-$year'>");
                        $active = FALSE;
                    } else {
                        echo("<div class='tab-pane fade' id='tab-campaign-$year'>");
                    }
                    include(Util::$view_root.'draw_ca_election_test_b20.php');
            $ads = check_ads($fourcode, $year);
            $ad_nav = '';
            $ad_pill = '';
            $ie_nav = '';
            $ie_pill = '';
        $res_nav = '';
        $res_pill = '';
        $p_draw = '';
        $g_draw = '';

            if(!empty($ie[$year])) {
              if($ie[$year]['ie_totals']['grand_total'] > 0) {
                 $ie_nav = "<li class='nav-item'>
                         <a class='nav-link' data-toggle='pill' href='#pills-ies-" . $year . "'><span>IEs</span></a>
                    </li>";
                 $ie_draw = draw_ie_panel($ie[$year], $fourcode, $year);
                 $ie_pill = "<div class='tab-pane fade' id='pills-ies-" . $year . "'>" .
                        $ie_draw . 
                    "</div>";
              }
            }

        if(!empty($sov_table_draw[$year])) {
        $res_nav = "<li class='nav-item'>
                <a class='nav-link' data-toggle='pill' href='#pills-res-" . $year . "'><span>Results</span></a>
                </li>";
        if(!empty($sov_table_draw[$year]['p'])) {
            $p_draw = "<div class='headingDiv'>
                    <h5>$year Primary Election Results</h5><br>" . 
                    $sov_table_draw[$year]['p'] . 
                   "</div>";
        }
        if(!empty($sov_table_draw[$year]['g'])) {
            $g_draw = "<br><div class='headingDiv'>
                    <h5>$year General Election Results</h5><br>" . 
                    $sov_table_draw[$year]['g'] . 
                   "</div>";
        }
        $res_pill = "<div class='tab-pane fade' id='pills-res-" . $year . "'>" . 
                $p_draw .
                $g_draw .
                 "</div>";
        }


            if($ads) {
            $ad_nav = "<li class='nav-item'>
                    <a class='nav-link' data-toggle='pill' href='#pills-ads-" . $year . "'><span>Ads</span></a>
                   </li>";
            $ad_all = draw_ad_panel($fourcode, $year);
            $ad_pill = "<div class='tab-pane fade' id='pills-ads-" . $year . "'>" . 
                    $ad_all['html'] . 
                   "</div>";
                        
            }

            $si_nav = '';
            $si_pill = '';
            $cf_nav = '';
                $cf_pill = '';
            $cb_nav = '';
            $cb_pill = '';
            
            if(!empty($intention_table)) {
            $si_nav = "<li class='nav-item active'>
                                      <a class='nav-link' data-toggle='pill' href='#pills-si-$year'><span>FPPC/FEC FILED</span></a>
                                    </li>";
            $si_pill = "<div class='tab-pane active' id='pills-si-$year'>
                    $intention_table
                    </div>";
            }

            if(!empty($candidates_filed_panel[$year])) {
            $cf_nav = "<li class='nav-item'>
                                      <a class='nav-link' data-toggle='pill' href='#pills-cf-$year'><span>PAPERS</span></a>
                                    </li>";
            $cf_pill = "<div class='tab-pane' id='pills-cf-$year'>" . 
                    $candidates_filed_panel[$year] . "              
                    </div>";

            }

            if(!empty($candidates_on_ballot[$year])) {
            $cb_nav = "<li class='nav-item'>
                                      <a class='nav-link' data-toggle='pill' href='#pills-cb-$year'><span>PRI BALLOT</span></a>
                                    </li>";
            $cb_pill = "<div class='tab-pane' id='pills-cb-$year'>" . 
                    $candidates_on_ballot[$year] . "                
                    </div>";

            }

            $cand_pill_panel = "     <div class='row'>
                          <div class='col-md-12 pe-0'>
                                                <div class='h-100 ctb-district-state-senate-container  bg-white p-3 ctb-border-radius'>
                                                    <h3>CANDIDATE FILING STATUS</h3>
                                                    <div class='ctb-district-state-senate general-pill-tab'>
                                                        <ul class='nav nav-pills mb-3 bg-white pt-2 ctb-inline-tab  ctb-border-radius' id='pills-tab'>
                               $si_nav
                               $cf_nav
                               $cb_nav
                            </ul>
                            <div class='tab-content' id='pills-tabContent'>
                               $si_pill
                               $cf_pill
                               $cb_pill
                            </div>
                            </div>
                         </div>
                           </div>
                          </div>";    


                    echo'
                        <ul class="nav nav-tabs mb-3" id="pills-tab">
                            <li class="nav-item active">
                                <a class="nav-link" data-toggle="pill" href="#pills-analysis-' . $year . '"><span>Analysis</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#pills-financials-' . $year . '"><span>Financials</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#pills-candidates-' . $year . '"><span>Candidates</span></a>
                            </li>' . 
                $ad_nav . 
                $ie_nav .
        $res_nav .
            '</ul>

                        <div class="tab-content tab-' . $year . '">
                            <div class="tab-pane fade active in" id="pills-analysis-' . $year . '" >
                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                    <div class="analysis-simple bg-white p-4 ctb-border-radius">
                                        <p class="mb-0" align="justify">'.
                                            $analysis .$this_endorsement.
                                        '</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-financials-' . $year . '" >
                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                    <div class="analysis-simple bg-white p-4 ctb-border-radius">
                                        <p class="mb-0">'.
                                            $financials.
                                        '</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-candidates-' . $year . '" >' . 
                $cand_pill_panel;


                    

                    echo'<div class="row condidates_row">';
                    foreach ($cdivs as $c) {
                        if (isset($c['is_inc'])) {
                            echo($c['div_start']);
                            if (isset($c['cmte_id'])) {
                                $lookup_cmte = $c['cmte_id'];
                                Util::include('get_cmte_cont.php', ['lookup_cmte' => $lookup_cmte]);
                            }
                            echo($end_div);
                        }
                    }

                    foreach ($cdivs as $c) {
                        if (!isset($c['is_inc'])) {
                            echo($c['div_start']);
                            if (isset($c['cmte_id'])) {
                                $lookup_cmte = $c['cmte_id'];
                                Util::include('get_cmte_cont.php', ['lookup_cmte' => $lookup_cmte]);
                            }
                            echo($end_div);
                        }
                    }
            if(!empty($tmp_cand_divs[$year])) {
                echo($tmp_cand_divs[$year]);
            }
                    echo"</div> <!--END CANDIDATE ROW -->
                        </div> <!--END CANDIATE DIV -->
             $ad_pill
             $ie_pill
         $res_pill
                        </div> <!--END PILL CONTENT -->

                        </div> <!--END ELECTION YEAR DIVS -->


            <div class='modal fade modal-1200' id='ie_modal' tabindex='-1' role='dialog' aria-labelledby='mlabel' aria-hidden='true' width='90vw'>
                <div class='modal-dialog modal-1200'>
                    <div class='modal-content'>
                        <div class='modal-header modal-1200'>
                            <p align='right'><button type='button' class='close close-btn' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        </div>
                        <div class='modal-body modal-1200'>
                            <h4 class='modal-title' id='mlabel'>IE Detail Report</h4>
                            <iframe id='iframe_modal' src='/ctb-legacy/loading_spinner.php' class='modal-1200' height='1024' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation' allowtransparency='true'></iframe>
                        </div>
                            <div class='modal-footer'>
                                       <button type='button' id='modal-close-1' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


"; //END CANDIDATE ROW, CANDIDATE DIV, END PILL CONTENT, END ELECTION YEAR DIVS
             
                }
        
            ?>
    </div> <!--CLOSE CONTENT -->
</div> <!--CLOSE CONTAINER -->


<?php

function lookup_si($fourcode, $year) {
    $conn = Util::get_ctb_conn();

    $use_fppc = TRUE;
    $use_fec = FALSE;

    if(mb_substr($fourcode, 0, 2) == "AD") {
        $converted = "ASSEMBLY DISTRICT " . mb_substr($fourcode, 2, 2);
    } elseif(mb_substr($fourcode, 0, 2) == "SD") {
        $converted = "STATE SENATE DISTRICT " . mb_substr($fourcode, 2, 2);
    } elseif(mb_substr($fourcode, 0, 3) == "BOE") {
        $converted = "MEMBER BOARD OF EQUALIZATION DISTRICT 0" . mb_substr($fourcode, 3, 1);
    } elseif(mb_substr($fourcode, 0, 1) == ".") {
        switch($fourcode) {
            case ".GOV":
                $converted = "GOVERNOR";
                break;
            case ".LTG":
                $converted = "LIEUTENANT GOVERNOR";
                break;
            case ".SOS":
                $converted = "SECRETARY OF STATE";
                break;
            case ".ATG":
                $converted = "ATTORNEY GENERAL";
                break;
            case ".TRS":
                $converted = "TREASURER";
                break;
            case ".CON":
                $converted = "CONTROLLER";
                break;
            case ".INS":
                $converted = "INSURANCE COMMISSIONER";
                break;
            case ".SPI":
                $converted = "SUPERINTENDENT OF PUBLIC INSTRUCTION";
                break;
            default:
                $use_fec = TRUE;
                $use_fppc = FALSE;
                break;
        }
    } elseif(mb_substr($fourcode, 0, 2) == "CD") {
        $use_fec = TRUE;
        $use_fppc = FALSE;
    }



    if($use_fppc === TRUE) {
        $fppc_table_head = "<p align='center'>FPPC STATEMENTS OF INTENTION</p>
                            <table class='table-striped table-hover' v-ctb-table>
                                <thead>
                                    <tr>
                                        <th>CANDIDATE</th>
                                        <th>PARTY</th>
                                        <th>FPPC ID</th>
                                        <th>MORE</th>
                                        <th>DATE LOGGED</th>
                                    </tr>
                                </thead>
                                <tbody>";
        $sql = "SELECT cand_nm, cand_id, office, party, year, logged FROM ctb_fppc_si WHERE office = '$converted' && year = '$year' ORDER BY party, cand_nm ";

        $result = $conn->query($sql);
    $fppc_table_body = '';
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cand_id = $row['cand_id'];

                $lobby_lnk  = "<a href='https://cal-access.sos.ca.gov/Lobbying/Employers/Detail.aspx?id=$cand_id' target='_blank'>Info</a>";
                $cand_lnk   = "<a href='https://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=$cand_id' target='_blank'>$cand_id</a>";


                $fppc_table_body .= "<tr>
                                    <td>" . $row['cand_nm'] . "</td>
                                    <td>" . $row['party'] . "</td>
                                    <td>" . $cand_lnk . "</td>
                                    <td>" . $lobby_lnk . "</td>
                                    <td>" . mb_substr($row['logged'], 0, 10) . "</td>
                                </tr>";
            }
        }

        $retval = $fppc_table_head . $fppc_table_body . "</tbody></table>";
        return $retval;
    } else {
        if($fourcode == ".SN1" || $fourcode == ".SN2") {
            $lookup = "CASEN";
        } elseif(mb_substr($fourcode, 0, 2) == "CD") {
            $lookup = "CA" . mb_substr($fourcode, 2, 2);
        } else {
            $lookup = $fourcode;
        }
        $blacklist = populate_blacklist();

        $sql = "SELECT cycle, year, cand_id, cand_nm, fourcode, party, ici, cmte_id, filed FROM nufec_fed_candidates WHERE fourcode = '$lookup' && cycle = '$year' ORDER BY party, cand_nm";
        $fec_table_head = "<p align='center'>FEC STATEMENTS OF CANDIDACY</p>
                            <table class='table-striped table-hover' v-ctb-table>
                                <thead>
                                    <tr>
                                        <th>CANDIDATE</th>
                                        <th>PARTY</th>
                                        <th>FEC CAND ID</th>
                                        <th>FEC CMTE ID</th>
                                        <th>DATE FILED</th>
                                    </tr>
                                </thead>
                                <tbody>";
        $result = $conn->query($sql);
    $fec_table_body = '';
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cand_id = $row['cand_id'];
                if(array_key_exists($cand_id, $blacklist) && $blacklist[$cand_id]) {
                    continue;
                }

                $cand_lnk = "<a href='https://www.fec.gov/data/candidate/" . $row['cand_id'] . "/?tab=filings' target='_blank'>" . $row['cand_id'] . "</a>";
                if($row['cmte_id']) {
                    $cmte_lnk = "<a href='https://www.fec.gov/data/committee/" . $row['cmte_id'] . "/?tab=filings' target='_blank'>" . $row['cmte_id'] . "</a>";
                } else {
                    $cmte_lnk = '';
                }
                $fec_table_body .= "<tr>
                                        <td>" . $row['cand_nm'] . "</td>
                                        <td>" . $row['party'] . "</td>
                                        <td>" . $cand_lnk . "</td>
                                        <td>" . $cmte_lnk . "</td>
                                        <td>" . $row['filed'] . "</td>
                                    </tr>";
            }
        }

        $retval = $fec_table_head . $fec_table_body . "</tbody></table>";
        return $retval;
    }
    return FALSE;

}

function populate_blacklist() {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT cand_nm, fourcode, cand_id FROM nufec_blacklist";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cand_id = $row['cand_id'];
            $retval[$cand_id] = TRUE;
        }
    }
    return $retval;
}

function lookup_election_years($id) {

    $years = Array();
    $statewide_race = FALSE;
    if(mb_substr($id, 0, 2) == "CD") {
        $adjusted_fourcode = "CA" . mb_substr($id, 2, 2);
    } else {
        $adjusted_fourcode = $id;
    }

    if(mb_substr($id, 0, 1) == "." || mb_substr($id, 0, 3) == "BOE") {
        $statewide_race = TRUE;
    } else {
         $conn = Util::get_ctb_conn();
         $sql = "SELECT year FROM ctb_analysis WHERE dist = '$adjusted_fourcode' && year > 2021 && id > 4715 GROUP BY year ORDER BY year DESC ";
         $result = $conn->query($sql);
         if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($years, $row['year']);
            }
         }
    }


    if($statewide_race) {
        $race = mb_substr($id, 1, 3);

        switch($race) {
            case "SN1":
                $years = Array("2024", "2018", "2012");
                break;
            case "SN2":
                $years = Array("2022", "2016", "2010");
                break;
            default:
                $years = Array("2026", "2022", "2018", "2014", "2010", "2006");
                break;
        }
    }

    $tmp['li'] = '';
    $tmp['years'] = $years;

    foreach($years as $year) {
        $tmp['li'] .= "<li><a class='nav-link' href='#tab-campaign-$year'><span>Election $year</span></a></li>
                      ";
    }

    return $tmp;


}

function get_cand_links($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_cand_links WHERE cand_id = :id;
    ");

    $stmt->execute(['id' => $cand_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function lookup_cand_name_18($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT namf, naml, party FROM calaccess_raw_e18_comm WHERE cand_id = :id;
    ");

    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval['cand_nm'] = $row['namf'] . " " . $row['naml'];
        $retval['party'] = $row['party'];
    }

    return $retval;
}

function lookup_cand_name_20($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT namf, naml, party FROM calaccess_raw_e20_comm WHERE cand_id = :id;
    ");


    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval['cand_nm'] = $row['namf'] . " " . $row['naml'];
        $retval['party'] = $row['party'];
    }

    return $retval;
}



function lookup_cand_name_22($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT namf, naml, party FROM calaccess_raw_e22_comm WHERE cand_id = :id;
    ");


    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval['cand_nm'] = $row['namf'] . " " . $row['naml'];
        $retval['party'] = $row['party'];
    }

    return $retval;
}

function lookup_cand_name_24($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT namf, naml, party FROM calaccess_raw_e24_comm WHERE cand_id = :id;
    ");


    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval['cand_nm'] = $row['namf'] . " " . $row['naml'];
        $retval['party'] = $row['party'];
    }

    return $retval;
}

function lookup_cand_name_new($cand_id, $year)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT namf, naml, party, dob, city FROM ctb_cand_filed_v2 WHERE cand_id = :id && cycle = :cycle;
    ");


    $stmt->execute([
        'id' => $cand_id,
        'cycle' => $year
    ]);


    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval['cand_nm'] = $row['namf'] . " " . $row['naml'];
        $retval['party'] = $row['party'];
    $retval['dob'] = $row['dob'];
    $retval['city'] = $row['city'];
    }

    return $retval;
}



function getsummaryBackup($filing)
{


    $conn = Util::get_ctb_conn();
    $retval = Array();

    if(!isset($filing)) {
    return FALSE;
    }

    //CONTRIBUTIONS THIS PERIOD
    // $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' ORDER BY AMEND_ID DESC LIMIT 1";
    // $result = $conn->query($sql);

    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = ? AND REC_TYPE = ? AND LINE_ITEM = ? ORDER BY AMEND_ID DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $filing, $recType, $lineItem);

    // Assign values to parameters
    $filing = $filing;
    $recType = 'SMRY';
    $lineItem = '5';

    $stmt->execute();
    $result = $stmt->get_result();

    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['RCPT'] = $row['AMOUNT_A'];
            }
        }
    }
    //CONTRIBUTIONS THIS CALENDAR YEAR
    // $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' ORDER BY AMEND_ID DESC LIMIT 1";
    // $result = $conn->query($sql);
    $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = ? AND REC_TYPE = ? AND LINE_ITEM = ? ORDER BY AMEND_ID DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $filing, $recType, $lineItem);

    // Assign values to parameters
    $filing = $filing;
    $recType = 'SMRY';
    $lineItem = '5';

    $stmt->execute();
    $result = $stmt->get_result();

    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['YTD_RCPT'] = $row['AMOUNT_B'];
            }
        }
    }
    //EXPENDITURES
    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['EXPN'] = $row['AMOUNT_A'];
            }
        }
    }
    //YTD EXPENDITURES
    $sql = "SELECT AMOUNT_B from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['YTD_EXPN'] = $row['AMOUNT_B'];
            }
        }
    }
    //CASH ON HAND
    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '16' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['COH'] = $row['AMOUNT_A'];
            }
        }
    }
    //LOANS
    $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '2' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['LOANS'] = $row['AMOUNT_B'];
            }
        }
    }
    //DEBTS
    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '19' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if(!is_bool($result)) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['DEBTS'] = $row['AMOUNT_A'];
            }
        }
    }

    return $retval;
}

function getSummary($filing)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();

    if (!isset($filing)) {
        return FALSE;
    }

    $sql = "SELECT AMOUNT_A, AMOUNT_B, LINE_ITEM FROM calaccess_raw_SMRY_CD WHERE FILING_ID = ? AND REC_TYPE = 'SMRY' AND LINE_ITEM IN ('5', '11', '16', '2', '19') ORDER BY LINE_ITEM, AMEND_ID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $filing);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!is_bool($result)) {
        while ($row = $result->fetch_assoc()) {
            $lineItem = $row['LINE_ITEM'];
            if ($lineItem === '5') {
                $retval['RCPT'] = $row['AMOUNT_A'];
                $retval['YTD_RCPT'] = $row['AMOUNT_B'];
            } elseif ($lineItem === '11') {
                $retval['EXPN'] = $row['AMOUNT_A'];
                $retval['YTD_EXPN'] = $row['AMOUNT_B'];
            } elseif ($lineItem === '16') {
                $retval['COH'] = $row['AMOUNT_A'];
            } elseif ($lineItem === '2') {
                $retval['LOANS'] = $row['AMOUNT_B'];
            } elseif ($lineItem === '19') {
                $retval['DEBTS'] = $row['AMOUNT_A'];
            }
        }
    }

    return $retval;
}



function get_final_filing($cmte_id, $year)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT FILING_ID FROM calaccess_raw_FILER_FILINGS_CD
      WHERE FILER_ID = :id
        && RPT_END LIKE :year
        && PERIOD_ID != ''
        && FORM_ID = 'F460'
      ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1
    ");

    $stmt->execute([
        'id' => $cmte_id,
        'year' => $year . '%'
    ]);

    $x = $stmt->fetch(PDO::FETCH_ASSOC);
    if(isset($x['FILING_ID'])) {
        return $x['FILING_ID'];
    } else {
    return FALSE;
    }
}

function get_filing_years($cmte_id)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT RPT_START, RPT_END FROM calaccess_raw_FILER_FILINGS_CD
      WHERE FILER_ID = :id && FORM_ID = 'F460'
    ");

    $stmt->execute(['id' => $cmte_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $year = mb_substr($row['RPT_END'], 0, 4);
        if (!array_key_exists($year, $retval)) {
            $retval[$year] = Array();
        }
        $retval[$year]['YEAR'] = $year;
    }

    return $retval;
}

function getf497filingssince($committee, $date)
{

    if(!$date) {
    $date = "2000-01-01";
    }
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM calaccess_raw_FILER_FILINGS_CD
      WHERE FILER_ID = :id
        && RPT_END > :date
        && FILING_TYPE <> '0'
      ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC
    ");

    $stmt->execute([
        'id' => $committee,
        'date' => $date,
    ]);

    $tmp = Array();
    $retval = Array();
    $lastfiling = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $thisfiling = $row['FILING_ID'];
        if ($thisfiling != $lastfiling) {
            $tmp['FILING_ID'] = $row['FILING_ID'];

            array_push($retval, $tmp);
        }
        $lastfiling = $thisfiling;
    }

    return $retval;
}

function getf497amounts($filings, $lastdate)
{/*
    $ids = [];
    foreach ($filings as $filing) {
        $f = $filing['FILING_ID'];
        array_push($ids, "FILING_ID = $f");
    }
    $filing_id_query = implode(' | ', $ids);

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE
      FROM calaccess_raw_S497_CD
      WHERE (".$filing_id_query.")
        && FORM_TYPE = 'F497P1'
      ORDER BY LINE_ITEM ASC, AMEND_ID DESC
    ");

    $stmt->execute();

    $retval = 0;
    $highest = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $thisamend = $row['AMEND_ID'];
        if ($thisamend >= $highest) {
            if ($row['CTRIB_DATE'] > $lastdate) {
                $retval += $row['AMOUNT'];
            }
        }
    }*/


    $conn = Util::get_ctb_conn();
    $retval = 0;
    $highest = 0;
    foreach ($filings as $filing) {
        $sql = "SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE FROM calaccess_raw_S497_CD WHERE FILING_ID = '" . $filing['FILING_ID'] . "' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
        //echo("<br>$sql<br>");
        $result = $conn->query($sql);
        $highest = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!$highest) {
                    $highest = $row['AMEND_ID'];
                }
                $thisamend = $row['AMEND_ID'];
                if ($thisamend < $highest) {
                    //DO NOTHING
                } else {
                    if ($row['CTRIB_DATE'] > $lastdate) {
                        $retval += $row['AMOUNT'];
                    }
                }
            }
        }
        //echo("<br>Retval is $retval after processing filing #" . $filing['FILING_ID'] . "<Br>");
    }

    return $retval;
}

function yearsort2($a, $b)
{

    if ($a['YEAR'] < $b['YEAR']) {
        return -1;
    } elseif ($a['YEAR'] > $b['YEAR']) {
        return 1;
    } else {
        return 0;
    }
}

function fetch_name($cand_id, $year)
{

    //echo("<br>Looking up $cand_id, ");
    $first = mb_substr($cand_id, 0, 1);
    if ($first != "H" && $first != "S") {
        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT NAMF, NAML FROM calaccess_raw_FILERNAME_CD
          WHERE FILER_ID = :id
          LIMIT 1
        ");

        $stmt->execute(['id' => $cand_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            return $row['NAMF'] . " " . $row['NAML'];
        }else{
            return $row;
        }


    } elseif($year > 2020) {
            $stmt = Util::get_ctb_pdo()->prepare("
              SELECT namf, naml FROM ctb_cand_filed_v2
              WHERE cand_id = :id LIMIT 1
            ");

            $stmt->execute(['id' => $cand_id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row)) {
                return $row['namf'] . " " . $row['naml'];
            }else{
                return $row;
            }
    } else {

        if ($year > "2017") {

        $short = mb_substr($year, 2, 2);

        $this_table = "calaccess_raw_e" . $short . "_comm";

            $stmt = Util::get_ctb_pdo()->prepare("
              SELECT namf, naml FROM $this_table
              WHERE cand_id = :id LIMIT 1
            ");

            $stmt->execute(['id' => $cand_id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row)) {
                return $row['namf'] . " " . $row['naml'];
            }else{
                return $row;
            }


        } else {
            $stmt = Util::get_ctb_pdo()->prepare("
              SELECT name FROM ctb_ca_candidates
              WHERE cand_id = :id LIMIT 1
            ");

            $stmt->execute(['id' => $cand_id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['name'];
            if (is_array($row)) {
                return $row['name'];
            }else{
                return $row;
            }
        }
    }

}

function fetch_bio($cand_id)
{
    $row=[];
    $stmt = Util::get_ctb_pdo()->prepare("
              SELECT text FROM ctb_cand_bios WHERE cand_id = :id
          ORDER BY date DESC
          LIMIT 1
            ");

    $stmt->execute(['id' => $cand_id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $retval= is_array($row)?$row['text']:$row;
    return $retval;
}

function fetch_party($cand_id, $year)
{

    $short_year = mb_substr($year, 2, 2);

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT party, is_incumbent FROM ctb_ca_candidates
      WHERE cand_id = :id && (election = :p || election = :g) LIMIT 1
    ");

    $stmt->execute([
        'id' => $cand_id,
        'p' => 'p'.$short_year, // primary
        'g' => 'g'.$short_year, // general
    ]);

    $x = $stmt->fetchAll();

    $retval['party'] = $x[0]['party'];
    $retval['is_incumbent'] = $x[0]['is_incumbent'];

    return $retval;

}

function votesort2($a, $b)
{

    if ($a['votes'] < $b['votes']) {
        return 1;
    } elseif ($a['votes'] > $b['votes']) {
        return -1;
    } else {
        return 0;
    }
}

function get_votes($cand_id, $year)
{
    global $fourcode;

    if($cand_id == "1377646" && $year == 2020 && $fourcode == "SD01") {
    return FALSE;
    }

    $short_year = mb_substr($year, 2, 2);
    $g = "G" . $short_year;
    $p = "P" . $short_year;


    $racekey_p = get_race_key($cand_id, $p);
    $racekey_g = get_race_key($cand_id, $g);


    $p_votes = 0;
    $g_votes = 0;

    if ($racekey_p) {
        $stmt = Util::get_ctb_pdo()->prepare("
              SELECT SUM(votes) AS votes
              FROM ctb_county_results
              WHERE election = :elec && racekey = :key
        ");

        $stmt->execute([
            'elec' => $p,
            'key' => $racekey_p,
        ]);

        $p_votes = $stmt->fetch(PDO::FETCH_ASSOC)['votes'];
    }

    if ($racekey_g) {
        $stmt = Util::get_ctb_pdo()->prepare("
              SELECT SUM(votes) AS votes
              FROM ctb_county_results
              WHERE election = :elec && racekey = :key
        ");

        $stmt->execute([
            'elec' => $g,
            'key' => $racekey_g,
        ]);

        $g_votes = $stmt->fetch(PDO::FETCH_ASSOC)['votes'];
    }


    return [
        'p' => $p_votes,
        'g' => $g_votes
    ];

}

function get_race_key($cand_id, $election)
{
    $stmt = Util::get_ctb_pdo()->prepare("
        SELECT race from ctb_ca_candidates
        WHERE cand_id = :id && election = :elec
    ");

    $stmt->execute([
        'id' => $cand_id,
        'elec' => strtolower($election)
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['race'] ?? '';
}

function lookup_cand_name($cand_id, $year)
{
    $shortyear = mb_substr($year, 2, 2);


    $stmt = Util::get_ctb_pdo()->prepare("
        SELECT name AS cand_nm, party FROM ctb_ca_candidates
        WHERE cand_id = :id && (election = :p || election = :g)
    ");


    $stmt->execute([
        'id' => $cand_id,
        'p' => 'p'.$shortyear,
        'g' => 'g'.$shortyear,
    ]);



    $x = $stmt->fetch(PDO::FETCH_ASSOC);

    $tmp['cand_nm'] = $x['cand_nm'];
    $tmp['party'] = $x['party'];
    //var_dump($tmp);
    return $tmp;
}

function get_committees($election)
{
    global $fourcode;
    global $year;

    //echo("<br>LOOKING UP COMMITTEES<br>");
    if ($year > 2011) {
        $stmt = Util::get_ctb_pdo()->prepare("
            SELECT * FROM calaccess_raw_hcand_comm
            WHERE FOURCODE = :code && ELECTION = :elec
        ");

        $stmt->execute([
            'code' => $fourcode,
            'elec' => $election,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $retval = Array();
        array_push($retval, [
            'cmte_id' => $row['CMTE_ID'],
            'cmte_nm' => $row['CMTE_NAME'],
        ]);

        return $retval;

    } else {

        global $candidates;
        //echo("<br>LOOKING UP PRE-2012 CANDIDATES");
        foreach ($candidates as $cand_id) {
            $stmt = Util::get_ctb_pdo()->prepare("
                SELECT cmte_id, cmte_nm FROM ctb_ca_ccl
                WHERE cand_id = :id && cmte_nm LIKE :yr
            ");

            $stmt->execute([
                'id' => $cand_id,
                'yr' => "%$year%"
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($row)) {
                array_push($retval, $row);
            } else {
                $stmt = Util::get_ctb_pdo()->prepare("
                    SELECT cmte_id, cmte_nm FROM ctb_ca_ccl
                    WHERE cand_id = '$cand_id'
                      && (status LIKE :s1 || status LIKE :s2)
                ");

                $stmt->execute([
                    'id' => $cand_id,
                    's1' => "TERMINATED%".$year,
                    's2' => "TERMINATED%".($year+1)
                ]);

                array_push($retval, $stmt->fetch(PDO::FETCH_ASSOC));

            }

        }

        return $retval;
    }
}


function get_cand_bio($cand_id)
{
    global $fourcode;

    if (mb_substr($fourcode, 0, 2) == "CA" || mb_substr($fourcode, 0, 2) == "CD") {
        $juris = "US";
    } else {
        $juris = "CA";
    }


    $stmt = Util::get_ctb_pdo()->prepare("
        SELECT text FROM ctb_cand_bios
        WHERE cand_id = :id && juris = :juris
    ORDER BY date DESC
    LIMIT 1
    ");

    $stmt->execute([
        'id' => $cand_id,
        'juris' => $juris,
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC)['text'];

}

function get_candidates($year)
{
    global $fourcode;
    $juris = "CA";
    $shortyear = mb_substr($year, 2, 2);
    $first_two = mb_substr($fourcode, 0, 2);
    if(mb_substr($fourcode, 0, 1) == ".") {
        $statewide_race = TRUE;
        $office = mb_substr($fourcode, 1, 3);
    }

    $retval = Array();

    if(mb_substr($fourcode, 0, 3) == "BOE") {
        $dist = "0" . mb_substr($fourcode, 3, 1);
        $stmt = Util::get_ctb_pdo()->prepare("
            SELECT cand_id FROM ctb_ca_candidates
            WHERE race LIKE 'BOE" . $dist . "%'
              && (election = :g || election = :p)
            GROUP BY cand_id
        ");
        $stmt->execute([
            'g' => 'g' . $shortyear,
            'p' => 'p' . $shortyear,
        ]);

    } elseif ($first_two == "CD" || $first_two == "AD" || $first_two == "SD") {

        $stmt = Util::get_ctb_pdo()->prepare("
            SELECT cand_id FROM ctb_dist_cands
            WHERE dist = :dist
              && juris = :juris
              && code != ''
              && (election = :g || election = :p)
            GROUP BY cand_id
        ");


        $stmt->execute([
            'dist' => $fourcode,
            'juris' => $juris,
            'g' => 'g' . $shortyear,
            'p' => 'p' . $shortyear,
        ]);

    } elseif ($statewide_race) {
        switch($office) {
            case "SN1":
                $off_type = "USS";
                break;
            case "SN2":
                $off_type = "USS";
                break;
            default:
                $off_type = $office;
                break;
        }

        $stmt = Util::get_ctb_pdo()->prepare("
            SELECT cand_id FROM ctb_ca_candidates
            WHERE race LIKE '" . $off_type . "%'
              && (election = :g || election = :p)
            GROUP BY cand_id
        ");
        $stmt->execute([
            'g' => 'g' . $shortyear,
            'p' => 'p' . $shortyear,
        ]);

    }


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if($row['cand_id']) {
            array_push($retval, $row['cand_id']);
        }
        //echo("<br>$year - $off_type - " . $row['cand_id']);
    }

    //echo("<br>Looking up $year candidates for district $fourcode ($office), returning:<br>");
    //var_dump($retval);

    return $retval;
}


function get_analysis($year)
{
    global $fourcode;

    $this_fourcode = $fourcode;

    if (mb_substr($fourcode, 0, 2) == "CA" || mb_substr($fourcode, 0, 2) == "CD") {
        $juris = "US";
        $this_fourcode = str_replace("CD", "CA", $fourcode);
    } else {
        $juris = "CA";
    }

    $stmt = Util::get_ctb_pdo()->prepare("
        SELECT * FROM ctb_analysis
        WHERE dist = :dist && juris = :juris && year = :year && id > 4715
    ORDER BY date DESC
    LIMIT 1
    ");

    $stmt->execute([
        'dist' => $this_fourcode,
        'juris' => $juris,
        'year' => $year
    ]);

    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($res['text'])) {
    return $res['text'];
    } else {
    return '';
    }
}

function getlastf460($committee)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT FILING_ID, RPT_END FROM calaccess_raw_FILER_FILINGS_CD
      WHERE FILER_ID = :committee
        && FORM_ID = 'F460'
        && FILING_TYPE <> '0'
      ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1
    ");

    $stmt->execute(['committee' => $committee]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_full_committee_name($cmte_id)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT NAMF, NAML FROM calaccess_raw_FILERNAME_CD
      WHERE FILER_ID = :committee LIMIT 1
    ");

    $stmt->execute(['committee' => $cmte_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (is_array($row)) {
        return $row['NAMF'] . " " . $row['NAML'];
    }else{
        return $row;
    }
}

function get_candidate_image_sm($cand_id)
{
    //echo("<br>LOOKING UP $cand_id<br>");
    $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");

    foreach ($suffix as $s) {
        //$result = File::exists( '/img/candidates/' . $cand_id . $s);
        //var_dump($result);
    // "<img src='/img/candidates/" . $cand_id . $x . "' width='75px' class='img-responsive img-thumbnail' />";

        if (file_exists('img/candidates/' . $cand_id . $s)) {
            $add_img = "<a href='/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"/img/candidates/" . $cand_id . $s . "\" width='75px' class='img-responsive img-thumbnail' /></a>";
            //echo("GOT MATCH with $cand_id" . $s);
            break;
        } else {
            $add_img = "<a href='/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"/img/candidates/NO_IMAGE.jpg\" height='75px' style='border-radius: 5px;'/></a>";
        }
    }

    return $add_img;
}


function get_financials($year)
{
    global $fourcode;

    $modifier = '';
    $lastdate = '';

    switch ($year) {
        case "2006":
            $table = "hcand_comm";
            $key = 'CMTE_ID';
            $modifier = " && ELECTION = 'p06'";
            break;
        case "2008":
            $table = "hcand_comm";
            $key = 'CMTE_ID';
            $modifier = " && ELECTION = 'p08'";
            break;
        case "2010":
            $table = "hcand_comm";
            $key = 'CMTE_ID';
            $modifier = " && ELECTION = 'p10'";
            break;
        case "2012":
            $table = "hcand_comm";
            $key = 'CMTE_ID';
            $modifier = " && ELECTION = 'p12'";
            break;
        case "2014":
            $table = "hcand_comm";
            $key = 'CMTE_ID';
            $modifier = " && ELECTION = 'p14'";
            break;
        case "2016":
            $table = "cand_comm";
            $key = 'COMM_ID';
            break;
        case "2018":
            $table = "e18_comm";
            $key = 'cmte_id';
            break;
    case "2020":
        $table = "e20_comm";
        $key = 'cmte_id';
        break;
    case "2022":
        $table = "e22_comm";
        $key = 'cmte_id';
        break;
    case "2024":
        $table = "e24_comm";
        $key = 'cmte_id';
        break;
    case "2026":
        $key = 'cmte_id';
        break;
    default:
        return FALSE;
    }

    //18 schem FOURCODE cand_id , cmte_id
    //16 schem FOURCODE CAND_ID, COMM_ID
    //12,14 FOURCODE CMTE_ID


    $retval = "
        <table class='table table-bordered table-hover tablesaw tablesaw-stack bordered tablesorter' data-tablesaw-mode='stack' v-ctb-table>
            <thead>
                <tr>
                    <th>CMTE</th>
                    <th>RAISED LAST</th>
                    <th>SINCE</th>
                    <th>LIFETIME RAISED</th>
                                    <th>SPENT LAST</th>
                    <th>LIFETIME SPENT</th>
                    <th>CASH ON HAND</th>
                    <th>PERIOD ENDING</th>

                </tr>
            </thead>
            <tbody>

    ";

    if ($year > 2020) {

        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT $key AS cmte_id FROM ctb_cand_filed_v2
          WHERE FOURCODE = :code && cycle = $year
        ");
        $stmt->execute(['code' => $fourcode]);
        $x = Array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($x, $row['cmte_id']);
        }


    } elseif ($year > 2005) {
        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT $key AS cmte_id FROM calaccess_raw_$table
          WHERE FOURCODE = :code $modifier
        ");
        $stmt->execute(['code' => $fourcode]);


        $x = Array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $thiscmte = $row['cmte_id'];
//            $x[$thiscmte]['cmte_id'] = $row['cmte_id'];
//            $x[$thiscmte] = $row['cmte_id'];
            array_push($x, $row['cmte_id']);
        }

        /*$result = Util::get_ctb_conn()
            ->query("SELECT $key AS calaccess_raw_cmte_id FROM $table WHERE FOURCODE = '$fourcode' $modifier");


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $thiscmte = $row['cmte_id'];
                $x[$thiscmte]['cmte_id'] = $row['cmte_id'];
            }
        }*/

    } else {

        global $candidates;
        //echo("<br>LOOKING UP PRE-2012 CANDIDATES");
        foreach ($candidates as $cand_id) {
            $stmt = Util::get_ctb_pdo()->prepare("
              SELECT cmte_id, cmte_nm FROM ctb_ca_ccl
              WHERE cand_id = :id
                && cmte_nm LIKE '%$year%'
                && cmte_nm NOT LIKE '%Officeholder%'
            ");
            $stmt->execute(['id' => $cand_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!isset($row)) {
                $y1 = $year;
                $y2 = $year + 1;

                $stmt = Util::get_ctb_pdo()->prepare("
                  SELECT cmte_id, cmte_nm FROM ctb_ca_ccl
                  WHERE cand_id = :id
                  && (status LIKE 'TERMINATED%'
                    && (status LIKE '%$y1%' || status LIKE '%$y2%')
                    )
                ");
                $stmt->execute(['id' => $cand_id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

            }
            $thiscmte = $row['cmte_id'];
            $x[$thiscmte]['cmte_id'] = $row['cmte_id'];

        }
    }

    //echo("<br>RETRIEVEING COMMITTEES<br>SQL: $sql<br>");


    //echo("<br>GOT<br>");
    //var_dump($x);

    foreach ($x as $committee) {

        $raisedsince = 0;
        $lifetime_raised = 0;
        $lifetime_spent = 0;

//        $thiscmte = $committee['cmte_id'];
        $thiscmte = $committee;
        if (!$thiscmte) {
            continue;
        }
        //echo("<br>LOOKING UP $thiscmte");
        if ($thiscmte) {
            $thiscmte_nm = get_full_committee_name($thiscmte);
            $thiscand = $thiscmte_nm;
            //echo("<br>GOT $thiscmte_nm");
        }

        $years = get_filing_years($thiscmte);
        uasort($years, 'yearsort2');

        $key_filings = Array();
        foreach ($years as $key => $value) {
            $thisyear = $key;
            //echo("<br>RETRIEVING FINAL FILING FROM $thiscmte_nm FOR YEAR $key");
            //$key_filings[$filing] = get_final_filing($thiscmte, $thisyear);
            $filing = get_final_filing($thiscmte, $thisyear);
            $key_filings[$filing] = $filing;
        }


        foreach ($key_filings as $key => $value) {
            //echo("<br>RETRIEVING SUMMARY FOR $thiscmte_nm FROM FILING $value");
            $z = getsummary($value);

            if (array_key_exists('YTD_RCPT', $z)) {
                $lifetime_raised += $z['YTD_RCPT'];
            }
            if (array_key_exists('YTD_EXPN', $z)) {
                $lifetime_spent += $z['YTD_EXPN'];
            }
        }

    $last = [];
    if(isset($thiscmte)) {
            $last = getlastf460($thiscmte) ?? '';
    }

    if(isset($last['FILING_ID'])) {
            $lastdate = $last['RPT_END'] ?? '';
            $lastsummary = getsummary($last['FILING_ID']) ?? '';
    }

        $f497s = getf497filingssince($thiscmte, $lastdate) ?? '';
        $raisedsince = getf497amounts($f497s, $lastdate) ?? '';

        $totalraised = $lifetime_raised + $raisedsince;
        $cmte_lnk = "<a href='/ctb-legacy/cmlocal2.php?id=$thiscmte' target='_blank'>$thiscand</a>";

        //echo("<br>$thiscand GETTING SUMMARY OF totalraised $totalraised FROM raised2015: $raised2015 + raisedthis: $raisedthis + raisedsince: $raisedsince<br>");
        $retval .= "
                <tr>
                    <td>$cmte_lnk</td>
                    <td>\$" . number_format(@$lastsummary['RCPT']) . "</td>
                    <td>\$" . number_format(@$raisedsince) . "</td>
                    <td>\$" . number_format(@$totalraised)  . "</td>
                    <td>\$" . number_format(@$lastsummary['EXPN']) . "</td>
                    <td>\$" . number_format(@$lifetime_spent) . "</td>
                    <td>\$" . number_format(@$lastsummary['COH'])  . "</td>
                                        <td>$lastdate</td>

                </tr>
        ";

    }
    $retval .= "</tbody></table>";

    return $retval;

}

function get_county_registrar_url($county_name, $thisyear) {

    switch($thisyear) {
        case 2018:
            $tablename = "ctb_e18_county_watch";
            break;
        case 2020:
            $tablename = "ctb_e20_county_watch";
            break;
        case 2022:
            $tablename = "ctb_e22_county_watch";
            break;
        default:
            return FALSE;
    }

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM $tablename WHERE county_nm LIKE :id
    ");
    $stmt->execute(['id' => $county_name]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval = $row['url'];
    }
    return $retval;
}

function get_ballot($fourcode, $year) {
    switch($year) {
        case "2018":
            $table = "ctb_e18_ballots";
            break;
        case "2020":
            $table = "ctb_e20_ballots";
            break;
        case "2022":
            $table = "ctb_e22_ballots";
            break;
        case "2024":
            $table = "ctb_e24_ballots";
            break;

        default:
            return FALSE;
    }
    $stmt = Util::get_ctb_pdo()->prepare("
            SELECT * FROM $table WHERE fourcode = :id ORDER BY elec_date, party, naml
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
                case "k":
                    $long_type = "Recall Election";
                    break;
                default:
                    $long_type = "Unknown";
                    break;
            }

            foreach($arr[$e] as $cand) {

                //echo("<br>CAND DUMP<br>");
                //var_dump($cand);
                if(!isset($table_body[$e])) {
                    $table_body[$e] = '';
                }

                switch($cand['party']) {
                    case "R":
                        $class = 'redme boldme';
                        break;
                    case "D":
                        $class = 'boldme text-primary';
                        break;
                    case "Grn":
                        $class = 'greenme boldme';
                        break;
                    default:
                        $class = '';
                }

                if(isset($cand['website'])) {
                     $name = "<a href='http://" . $cand['website'] . "' target='_blank'>" . $cand['cand_nm'] . "</a>";
                } else {
                     $name = $cand['cand_nm'];
                }

                $this_election = date('F j, Y', strtotime($cand['elec_date']));
                $table_body[$e] .= "<tr class='$class'>
                                        <td>" . $name . "</td>
                                        <td>" . $cand['party'] . "</td>
                                        <td>" . $cand['ballot_dscr'] . "</td>
                                    </tr>";

            }

            $table_head[$e] = "<h3>$long_type - $this_election</h3>
                                <p></p>
                                <p></p>
                                <table style='margin-left: auto !important; margin-right: auto !important; margin-top: 10px;' align='center'>
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

function get_filed($fourcode, $thisyear)
{



    switch($thisyear) {
        case 2018:
            $tablename = "ctb_p18_filing_status";
            break;
        case 2020:
            $tablename = "ctb_p20_filing_status";
            break;
    case 2022:
        $tablename = "ctb_p22_filing_status";
        break;
    case 2024:
        $tablename = "ctb_p24_filing_status";
        break;
        default:

            return FALSE;
    }

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM $tablename WHERE fourcode = :id ORDER BY party, naml
    ");
    $stmt->execute(['id' => $fourcode]);
    $abort = TRUE;
    $arr = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row);
        $abort = FALSE;
    }



    $table_head = "<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
                    <p align='center'>
                    <table style='margin-left: auto !important; margin-right: auto !important;' align='center'>
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
    $table_body = '';
    foreach($arr as $x) {
        if(isset($x['namm'])) {
            $name = $x['namf'] . " " . $x['namm'] . " " . $x['naml'];
        } else {
            $name = $x['namf'] . " " . $x['naml'];
        }

        $county_url = get_county_registrar_url($x['county_filed'], $thisyear);
        $county_lnk = "<a href='$county_url' target='_blank'>" . $x['county_filed'] . "</a>";

        $table_body .= "<tr>
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

function get_new_candidates($fourcode, $year)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT cand_id FROM ctb_cand_filed_v2 WHERE FOURCODE = :id  && hide <> 1 && type != 'K' && cycle = $year && year != '2021' ORDER BY party, cand_id
    ");
    $stmt->execute(['id' => $fourcode]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($retval, $row['cand_id']);
    }



    return $retval;
}


function get_2022_candidates($fourcode)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT cand_id FROM ctb_cand_filed_v2 WHERE FOURCODE = :id  && hide <> 1 ORDER BY party, cand_id
    ");
    $stmt->execute(['id' => $fourcode]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($retval, $row['cand_id']);
    }



    return $retval;
}

function get_2024_candidates($fourcode)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT cand_id FROM calaccess_raw_e24_comm WHERE FOURCODE = :id  && hide <> 1 ORDER BY party, cand_id
    ");
    $stmt->execute(['id' => $fourcode]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($retval, $row['cand_id']);
    }



    return $retval;
}


function get_2018_candidates($fourcode)
{

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT cand_id FROM calaccess_raw_e18_comm WHERE FOURCODE = :id  && hide <> 1 ORDER BY party, cand_id
    ");
    $stmt->execute(['id' => $fourcode]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($retval, $row['cand_id']);
    }



    return $retval;
}

function get_2020_candidates($fourcode)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT cand_id FROM calaccess_raw_e20_comm WHERE FOURCODE = :id && hide <> 1 ORDER BY party, cand_id
    ");
    $stmt->execute(['id' => $fourcode]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($retval, $row['cand_id']);
    }

    return $retval;
}

function get_all_fec($adjusted_fourcode, $year)
{
    $retval = Array();
    $candidates = get_fec_filed_candidates($adjusted_fourcode, $year);

    foreach ($candidates as $x) {
        $cand_id = $x['CAND_ID'];
        $y = get_fec_financials($cand_id, $adjusted_fourcode, $year);
        $y['CAND_NM'] = $x['CAND_NM'];
        $y['PARTY'] = $x['PARTY'];
        $y['CAND_ID'] = $cand_id;
        array_push($retval, $y);

    }

    return $retval;
}

function get_fec_filed_candidates($adjusted_fourcode, $year)
{
    $fourcode = $adjusted_fourcode;

    $state = mb_substr($fourcode, 0, 2);
    $dist = mb_substr($fourcode, 2, 2);
    $use_sen='';
   if(mb_substr($adjusted_fourcode, 2, 3) == "SEN") {
    $use_sen = TRUE;
   }


    if ($year === '20018') {
        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT * FROM nufec_e18_fed_candidates WHERE FOURCODE = :id
        ");

    if($use_sen) {

      $stmt = Util::get_ctb_pdo()->prepare("
        SELECT * FROM nufec18_cn WHERE CAND_OFFICE = 'S' && CAND_OFFICE_ST = :st && CAND_ELECTION_YR = :year ORDER BY CAND_PTY_AFFILIATION, CAND_NAME
       ");
      $stmt->execute([
             'st' => $state,
             'year' => $year
          ]);
    } else {
            $stmt->execute(['id' => $fourcode]);
        }
    } else {
    $short_year = $year - 2000;

    $table = "nufec_cn_" . $short_year;


    if(!$use_sen) {
            $stmt = Util::get_ctb_pdo()->prepare("
              SELECT * FROM $table
              WHERE CAND_ELECTION_YR = :yr
                && CAND_OFFICE_ST = :state
                && CAND_OFFICE_DISTRICT = :dist
              ORDER BY CAND_PTY_AFFILIATION, CAND_NAME
            ");
            $stmt->execute([
                'yr' => $year,
                'state' => $state,
                'dist' => $dist
            ]);
    } else {
      $stmt = Util::get_ctb_pdo()->prepare("
        SELECT * FROM $table WHERE CAND_OFFICE = 'S' && CAND_OFFICE_ST = :st && CAND_ELECTION_YR = :year ORDER BY CAND_PTY_AFFILIATION, CAND_NAME
       ");
      $stmt->execute([
             'st' => $state,
             'year' => $year
          ]);
    }
    }

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tmp = Array();
        if ($year != "2018" || $use_sen) {
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


    return $retval;
}

function get_fec_financials($cand_id, $adjusted_fourcode, $year)
{
    //global $year;
    //global $fourcode;
    //global $fec_conn;
    //$conn = $fec_conn;
    $x=[];
    $short_year = $year - 2000;
    $table = "nufec_weball_" . $short_year;

        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT * FROM $table
          WHERE CAND_ID = :id
          ORDER BY CAND_PTY_AFFILIATION, CAND_NAME
        ");
        $stmt->execute([
            'id' => $cand_id,
        ]);

   //echo("<br>SELECT * FROM $prefix" . "weball" . $suffix . " WHERE CAND_ID")
   // $sql = "SELECT * FROM weball" . $suffix . " WHERE CAND_ID = '$cand_id'";
    //$result = $conn->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $x['RCPT'] = $row['TTL_RECEIPTS'];
            $x['COH_START'] = $row['COH_BOP'];
            $x['COH_END'] = $row['COH_COP'];
            $x['EXPN'] = $row['TTL_DISB'];
            $x['DEBTS'] = $row['DEBTS_OWED_BY'];
            $x['CAND_NM'] = $row['CAND_NAME'];
            $x['PARTY'] = $row['CAND_PTY_AFFILIATION'];
            $x['LOANS'] = $row['CAND_LOANS'];
            $x['END_DATE'] = $row['CVG_END_DT'];
        }


    return $x;
}

function get_fec_committee_link($cand_id, $year)
{

    $short_year = $year - 2000;
    $table = "nufec_cn_$short_year";
    
        $stmt = Util::get_ctb_pdo()->prepare("
          SELECT CAND_PCC FROM $table
          WHERE CAND_ID = :id
        ");
        $stmt->execute([
            'id' => $cand_id,
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cmte_id = $row['CAND_PCC'];
            $url = "<a href='/book/fec_f3/" . $cmte_id . "' target='_blank'>$cmte_id</a>";
        }

    //echo("Returns CMTE_ID = $cmte_id");
    $retval['url'] = $url;
    $retval['cmte_id'] = $cmte_id;
    return $retval;
}


function has_late($cmte_id, $end_date) {

     $conn = Util::get_ctb_conn();
     $sql = "SELECT SUM(amt) AS amt FROM nufec_f6_log WHERE cmte_id = '$cmte_id' && transaction_dt > '$end_date'";
     $result=$conn->query($sql);
     if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $amt = $row['amt'];
    }
    $retval = "<a href='https://californiatargetbook.com/ctb-legacy/fec_f6_detail.php?id=$cmte_id&dt=$end_date' target='_blank'>" . number_format($amt) . "</a>";
     }
     if($amt > 0) {
    return $retval;
     } else {
        return FALSE;
     }

}


function get_fed_since($cmte, $end_date) {

    $conn = Util::get_ctb_conn();
    if(!$cmte) {
        return FALSE;
    }
    if(!$end_date) {
        $end_date = "12/31/2017";
    }

    $year = mb_substr($end_date, 6, 4);
    $month = mb_substr($end_date, 0, 2);
    $day = mb_substr($end_date, 3, 2);
    $adjusted_date = $year . $month . $day;


    if($end_date == "12/31/2017") {
        $sql = "SELECT SUM(amt) as amt FROM ctb_actblue_summary WHERE cmte_id = '$cmte' && year > 2017";
    } else {
        $x = has_late($cmte, $adjusted_date);
        if($x) {
            return $x;
        } else {
            $sql = "SELECT SUM(amt) AS amt FROM ctb_actblue_summary WHERE cmte_id = '$cmte' && (year >= '$year' && month > $month)";
        }
    }


    //echo("<br>$sql");

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $retval = number_format($row['amt']);
        }
    }
    return $retval;

}


function draw_fec_financial_table($adjusted_fourcode, $year)
{
    global $endjava;
    $fourcode = $adjusted_fourcode;


    $financials = get_all_fec($adjusted_fourcode, $year);

    //var_dump($financials);


    $thisid = $fourcode . "_Financials_" . $year . "_" . isset($election);

    $js = "$(document).ready(function() {
        $('#" . $thisid . "').tablesorter({
                headers: {
                    2: {
                        sorter:'fancyNumber'
                    },
                    3: {
                        sorter:'fancyNumber'
                    },
                    4: {
                        sorter:'fancyNumber'
                    },
                    5: {
                        sorter:'fancyNumber'
                    },
                    6: {
                        sorter:'fancyNumber'
                    }
                }
            });
    });

    jQuery.tablesorter.addParser({
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


    $tablehead = "<div class='newseg'>
                    <table id='$thisid' class='table table-bordered table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
                        <thead>
                            <tr>
                                <th>CANDIDATE</th>
                                <th>PARTY</th>
                                <th>BEGINNING $</th>
                                <th>RECEIPTS</th>
                                <th>SPENT</th>
                                <th>ENDING $</th>
                                <th>DEBT</th>
                                <th>LOANS</th>
                                <th>END DATE</th>
                                <th>SINCE</th>
                                <th>CMTE</th>
                            </tr>
                        </thead>
                        <tbody>";

    $tablebody = '';
    foreach ($financials as $x) {
    $cand_id = $x['CAND_ID'];

    $blacklist = Array(
    "H2CA01193" => TRUE,
    "H2CA01201" => TRUE,
    );

    if(!empty($blacklist[$cand_id])) {
        continue;
    }

        $cand_lnk = "<a href='https://www.fec.gov/data/candidate/" . $x['CAND_ID'] . "/?tab=filings' target='_blank'>" . $x['CAND_NM'] . "</a>";
        $cmte_lnk = get_fec_committee_link($x['CAND_ID'], $year);
    if(!empty($cmte_lnk['cmte_id'])) {
        $cmte_id = $cmte_lnk['cmte_id'];
        $cmte_url = "<a href='/book/fec_f3/$cmte_id' target='_blank'>$cmte_id</a>";
    } else {
        $cmte_url = '';
    }

    if(!empty($cmte_lnk['cmte_id']) && !empty($x['END_DATE'])) {
        $since = get_fed_since($cmte_lnk['cmte_id'], $x['END_DATE']);   
    } else {
        $since = '';
    }
    
        $bgclass = '';
        if ($x['PARTY'] == "DEM" || $x['PARTY'] == "D") {
            $bgclass = 'bluebg';
        }

        if ($x['PARTY'] == "REP" || $x['PARTY'] == "R") {
            $bgclass = 'redbg';
        }
        $xArray=[
            'PARTY'=>$x['PARTY']??'',
            'COH_START'=>$x['COH_START']??0,
            'RCPT'=>$x['RCPT']??0,
            'EXPN'=>$x['EXPN']??0,
            'COH_END'=>$x['COH_END']??0,
            'DEBTS'=>$x['DEBTS']??0,
            'LOANS'=>$x['LOANS']??0,
            'END_DATE'=>$x['END_DATE']??'',
        ];
        $tablebody .= "<tr>
                            <td>$cand_lnk</td>
                            <td align='right'>" . $xArray['PARTY'] . "</td>
                            <td align='right'>" . number_format($xArray['COH_START']) . "</td>
                            <td align='right'>" . number_format($xArray['RCPT']) . "</td>
                            <td align='right'>" . number_format($xArray['EXPN']) . "</td>
                            <td align='right'>" . number_format($xArray['COH_END']) . "</td>
                            <td align='right'>" . number_format($xArray['DEBTS']) . "</td>
                                        <td align='right'>" . number_format($xArray['LOANS']) . "</td>
                            <td align='right'>" . $xArray['END_DATE'] . "</td>
                            <td align='right'>" . $since . "</td>
                            <td align='right'>" . $cmte_url . "</td>
                        </tr>
        ";
    }

    $retval = $tablehead . $tablebody . "</tbody></table></div>";

    return $retval;

}

function identify_committee($cand_id, $year, $id)
{
    $conn = Util::get_ctb_conn();

    $type = mb_substr($id, 0, 2);
    $search_for='';
    switch ($type) {
        case "AD":
            $search_for = "ASSEMBLY";
            break;
        case "SD":
            $search_for = "SENATE";
            break;
        case "BO":
            $search_for = "EQUALIZATION";
            break;
        case "CD":
            $use_fed = TRUE;
            break;
        default:
            return FALSE;
            break;
    }

    if(mb_substr($id, 0, 1) == ".") {
        $type = mb_substr($id, 1, 3);
        switch($type) {
            case "TRS":
                $search_for = "TREASURER";
                break;
            case "SOS":
                $search_for = "SECRETARY";
                break;
            case "LTG":
                $search_for = "GOVERNOR";
                break;
            case "GOV":
                $search_for = "GOVERNOR";
                break;
            case "INS":
                $search_for = "INSURANCE";
                break;
            case "SPI":
                $search_for = "INSTRUCTION";
                break;
            case "CON":
                $search_for = "CONTROLLER";
                break;
            case "SN1":
                $use_fed = TRUE;
                break;
            case "SN2":
                $use_fed = TRUE;
                break;
        }

    }

    if ($id == "AD51" && $year = "2018") {
        $year = "2017";
    }

    $sql = "SELECT cmte_id FROM ctb_ca_ccl WHERE cand_id = '$cand_id' && cmte_nm LIKE '%$year%' && cmte_nm LIKE '%$search_for%'";
    //echo("<br>$sql");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            return $row['cmte_id'];
        }
    }

    return FALSE;

}

function getfed($cmte_id)
{
    global $conn;
    global $enddraw;

    $x = array($cmte_id);
    foreach ($x as $committee) {
        $allcommittees = Array();
        $committeelist = Array();
        $total = 0;
        $thiscmte = $committee['COMM_ID'];
        $thiscand = $committee['NAMF'] . " " . $committee['NAML'];
        $fedpacs = getfecpac($thiscmte);
        $i = 0;
        foreach ($fedpacs as $pac) {
            $committee = getfeccommitteename($pac['CMTE_ID']);
            $cmte_lnk = "<a href='http://www.fec.gov/fecviewer/CandidateCommitteeDetail.do?candidateCommitteeId=" . $pac['CMTE_ID'] . "&tabIndex=1' target='blank'>" . abbreviate($committee) . "</a>";
            array_push($allcommittees, $cmte_lnk);
            $total += $pac['AMOUNT'];
        }
        $committeelist = array_unique($allcommittees);


        $i = 0;
        //echo("<br><b>$thiscand</b><br>");
        if ($total == 0) {
            $enddraw .= "<p>$thiscand has not received any contributions from committees this cycle.</p>";
        } else {
            $enddraw .= "<p>$thiscand has received a total of \$" . number_format($total) . " this cycle from ";
            foreach ($committeelist as $committeelink) {
                if ($i <> 0) {
                    $enddraw .= ", ";
                }
                //$retval .= $committeelink;
                $enddraw .= $committeelink;

                $i++;
            }
            $enddraw .= "<p>";
        }
    }
    //$retval .= "</tbody></table></div>";

    //$retval .= "</p></div>";

    return $retval;

}


function getstate($cmte)
{

    if(!isset($cmte)) return FALSE;

    $f460s = getallf460($cmte);
    $lastf460 = [];
    // $lastf460 = lookuplastf460($cmte);
    $lastdate = $lastf460['RPT_END'] ?? '';
    $f497s = getf497filingssince($cmte, $lastdate) ?? '';
    global $org_array;

    $total = 0;
    $allcommittees = Array();

    foreach ($f460s as $filing) {
        $thisfiling = $filing['FILING_ID'];
        $transactions = getf460org($thisfiling);

        foreach ($transactions as $transaction) {
            $total += $transaction['AMOUNT'];

            $ctrib_nm = abbreviate($transaction['CTRIB_NAME']);
            $ctrib_cmte = $transaction['CMTE_ID'];
            $ctrib_amt = $transaction['AMOUNT'];

            $org_arr[$ctrib_cmte]['cmte_id'] = $ctrib_cmte;
            $org_arr[$ctrib_cmte]['ctrib_nm'] = $ctrib_nm;
            @$org_arr[$ctrib_cmte]['ctrib_amt'] += $ctrib_amt;
        }
    }

    foreach ($f497s as $filing) {
        $thisfiling = $filing['FILING_ID'];
        $transactions = getf497org($thisfiling);
        foreach ($transactions as $transaction) {
            $total += $transaction['AMOUNT'];

            $ctrib_nm = abbreviate($transaction['CTRIB_NAME']);
            $ctrib_cmte = $transaction['CMTE_ID'];
            $ctrib_amt = $transaction['AMOUNT'];

            $org_arr[$ctrib_cmte]['cmte_id'] = $ctrib_cmte;
            $org_arr[$ctrib_cmte]['ctrib_nm'] = $ctrib_nm;
            @$org_arr[$ctrib_cmte]['ctrib_amt'] += $ctrib_amt;
            $cmte_lnk = "<a href='http://cal-access.ss.ca.gov/Campaign/Committees/Detail.aspx?id=" . $transaction['CMTE_ID'] . "' target='_blank'>" . abbreviate($transaction['CTRIB_NAME']) . "</a>";
        }
    }

    if(isset($org_arr)) {
        uasort($org_arr, 'ctrib_sort');
            $list = "<br>$" . number_format($total) . " Received From Committees<br><br>";
            $table_body = '';

            foreach ($org_arr as $c) {
                  $list .= "<br>\$" . number_format($c['ctrib_amt']) . "  - <a href='http://cal-access.ss.ca.gov/Campaign/Committees/Detail.aspx?id=" . $c['cmte_id'] . "' target='_blank'>" . $c['ctrib_nm'] . "</a>";
              $table_body .= "<tr>
                            <td align='right'>\$" . number_format($c['ctrib_amt']) . "</td>
                            <td align='left'><a href='http://cal-access.ss.ca.gov/Campaign/Committees/Detail.aspx?id=" . $c['cmte_id'] . "' target='_blank'>" . $c['ctrib_nm'] . "</a></td>
                            <td align='right'><a href='/ctb-legacy/cmlocal2.php?id=" . $c['cmte_id'] . "' target='_blank'>" . $c['cmte_id'] . "</a></td>
                        </tr>";

            }

            $retval['table_body'] = $table_body;
    }
    $retval['total'] = "\$" . number_format($total) ?? '';

    return $retval;

}

function ctrib_sort($a, $b)
{

    if ($a['ctrib_amt'] < $b['ctrib_amt']) {
        return 1;
    } elseif ($a['ctrib_amt'] > $b['ctrib_amt']) {
        return -1;
    } else {
        return 0;
    }
}

function getf460org($filing)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();
    $sql = "SELECT * FROM calaccess_raw_RCPT_CD WHERE FILING_ID = '$filing' && CMTE_ID <> '' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!isset($highest)) {
                $highest = $row['AMEND_ID'];
            }

            if ($row['AMEND_ID'] < $highest) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                $tmp['RCPT_DATE'] = $row['RCPT_DATE'];
                $tmp['FILING_ID'] = $row['FILING_ID'];

                if ($row['CTRIB_NAMF']) {
                    $tmp['CTRIB_NAME'] = $row['CTRIB_NAMF'] . " " . $row['CTRIB_NAML'];
                } else {
                    $tmp['CTRIB_NAME'] = $row['CTRIB_NAML'];
                }

                array_push($retval, $tmp);
            }
        }
    }

    return $retval;
}

function getf497org($filing)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();
    $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FILING_ID = '$filing' && CMTE_ID <> '' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM, AMEND_ID DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!isset($highest)) {
                $highest = $row['AMEND_ID'];
            }

            if ($row['AMEND_ID'] < $highest) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                $tmp['RCPT_DATE'] = $row['CTRIB_DATE'];
                $tmp['FILING_ID'] = $row['FILING_ID'];

                if (@$row['CTRIB_NAMF']) {
                    $tmp['CTRIB_NAME'] = $row['ENTY_NAMF'] . " " . $row['ENTY_NAML'];
                } else {
                    $tmp['CTRIB_NAME'] = $row['ENTY_NAML'];
                }

                array_push($retval, $tmp);
            }
        }
    }

    return $retval;
}

function get_2018_dem_endorse($fourcode) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_e18_dem_endorse WHERE fourcode = '$fourcode'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }
    return $retval;
}

function get_party_endorsements($fourcode, $year) {

    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb_party_endorsements WHERE fourcode = '$fourcode' && election_year = '$year'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
        $party = $row['party'];
            $retval[$party] = $row;
        }
    }
    return $retval;


}


function abbreviate($string)
{

    $result = str_replace("Small Contributor Committee", "SCC", $string);
    $result = str_replace("California", "CA", $result);
    $result = str_replace("Association", "Assn", $result);
    $result = str_replace("Professional", "Prof", $result);
    $result = str_replace("Entertainment", "Ent", $result);
    $result = str_replace("Committee", "Cmte", $result);
    $result = str_replace("Federal", "Fed", $result);
    $result = str_replace("Independent", "Ind", $result);
    $result = str_replace("Government", "Govt", $result);
    $result = str_replace("'", "", $result);
    $result = str_replace("POLITICAL ACTION COMMITTEE", "PAC", $result);
    $result = str_replace("ASSOCIATION", "ASSN", $result);
    $result = str_replace("CALIFORNIA", "CA", $result);
    $result = str_replace("NATIONAL", "NATL", $result);
    $result = str_replace("COMMITTEE", "CMTE", $result);
    $result = str_replace("GOVERNMENT", "GOVT", $result);
    $result = str_replace("CORPORATION", "CORP", $result);
    $result = str_replace("COMPANY", "CO", $result);

    //var_dump($result);
    return $result;

}

function get_live_election($fourcode, $election_year) {
    global $total_registered;
    $race_html = '';
    $x = get_live_results($fourcode, $election_year);
    $y = get_live_registration($fourcode, $election_year);

    $precincts_tot = $x['888']['current']['cand_nm'];
    $precincts_in = $x['888']['current']['votes'];
    $precincts_last = $x['888']['previous']['votes'];
    $precincts_change = $precincts_in - $precincts_last;

    $votes_in = $x['999']['current']['votes'];
    $votes_last = $x['999']['previous']['votes'];
    $votes_change = $votes_in - $votes_last;
    $turnout = number_format((($votes_in / $total_registered) * 100), 2);

    $race_html = "<div class='table-striped race-div col-lg-12 special_result' align='center'>";

    $race_html .="<h1 align='center'>$fourcode</h1>$y<p align='center'>$precincts_in of $precincts_tot precincts in ($precincts_change added)</p><p align='center'>" . number_format($votes_in) . " votes cast ($votes_change added)<br>$turnout% Voter Turnout</p>";

    unset($x['999']);
    unset($x['888']);

    uasort($x, "previoussort");
    $i = 1;
    foreach($x as $key => $value) {
        $x[$key]['previous']['rank'] = $i;
        $i++;
    }

    uasort($x, "currentsort");
    $i = 1;
    foreach($x as $key => $value) {
        $x[$key]['current']['rank'] = $i;
        $i++;
    }

    $table_head = "<table align='center' style='margin-left: auto; margin-right: auto;'>
                        <thead>
                            <tr>
                                <th></th>
                                <th>NAME</th>
                                <th>PARTY</th>
                                <th class='rightme'>VOTES</th>
                                <th class='centerme'>&Delta;</th>
                                <th class='centerme'>%</th>
                                <th>Rank</th>
                                <th>Last</th>
                                <th>Votes Behind</th>
                            </tr>
                        </thead>
                        <tbody>";
    $table_body = '';

    foreach($x as $key => $v)   {

        $img = get_live_image_url($key);

        if($last_votes) {
            $votes_behind = $v['current']['votes'] - $last_votes;
        } else {
            $votes_behind = '';
        }

        $designation = get_live_designation($key, $election_year);

        switch($v['current']['party']) {
            case "R":
                $class = 'redme';
                break;
            case "D":
                $class = 'blueme';
                break;
            case "Grn":
                $class = 'greenme';
                break;
            default:
                $class = '';
        }

        $vote_diff = $v['current']['votes'] - $v['previous']['votes'];
        if($vote_diff > 0) {
            $sign = "+";
        } elseif($vote_diff < 0) {
            $sign = "-";
        } else {
            $sign = "";
        }
        $table_body .= "<tr>
                            <td>$img</td>
                            <td class='$class'>" . $v['current']['cand_nm'] . "<br><em>$designation</em></td>
                            <td class='$class centerme'>" . $v['current']['party'] . "</td>
                            <td align='right'>" . number_format($v['current']['votes']) . "</td>
                            <td align='right'>$sign" . number_format($vote_diff) . "</td>
                            <td align='right'>" . number_format((($v['current']['votes'] / $votes_in) * 100), 2) . "%</td>
                            <td align='center'>" . $v['current']['rank']  . "</td>
                            <td align='center'>" . $v['previous']['rank'] . "</td>
                            <td align='right'>" . number_format($votes_behind) . "</td>
                        </tr>";
        $last_votes = $v['current']['votes'];

    }

    $race_html .= $table_head . $table_body . "</tbody></table></div>";

    return $race_html;

}

function get_live_image_url($cand_id) {
    $arr = Array(".png", ".jpg", ".jpeg", ".bmp", ".gif");
    foreach($arr as $x) {
        if(file_exists("img/candidates/" . $cand_id . $x)) {
            $retval = "<img src='/img/candidates/" . $cand_id . $x . "' width='75px' class='img-responsive img-thumbnail' />";
            return $retval;
        }
    }
}

function get_live_designation($cand_id, $election_year) {
    $conn = Util::get_ctb_conn();
    switch($election_year) {
        case "2018":
            $table = "ctb_e18_ballots";
            break;
        case "2020":
            $table = "ctb_e20_ballots";
            break;
    }
    $sql = "SELECT ballot_dscr FROM $table WHERE cand_id = '$cand_id' ORDER BY elec_date ASC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['ballot_dscr'];
        }
    }
}

function currentsort($a, $b) {

    if($a['current']['votes'] < $b['current']['votes']) {
        return 1;
    } elseif ($a['current']['votes'] < $b['current']['votes']) {
        return -1;
    }else {
        return 0;
    }
}

function previoussort($a, $b) {

    if($a['previous']['votes'] < $b['previous']['votes']) {
        return 1;
    } elseif ($a['previous']['votes'] < $b['previous']['votes']) {
        return -1;
    }else {
        return 0;
    }
}

function get_live_registration($fourcode, $election_year) {
    global $total_registered;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_sos_all WHERE DIST = '$fourcode' && RPT_DATE LIKE '$election_year%' ORDER BY RPT_DATE DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $x = $row;
        }
    }

    $d = $x['DEM'];
    $r = $x['REP'];
    $npp = $x['NPP'];
    $tot = $x['TOT'];
    $total_registered = $tot;
    $rpt_date = $x['RPT_DATE'];

    $r_pct = number_format((($r / $tot) * 100), 2);
    $d_pct = number_format((($d / $tot) * 100), 2);
    $npp_pct = number_format((($npp / $tot) * 100), 2);

    if($d_pct > $r_pct) {
        $diff = $d_pct - $r_pct;
        $adv = "<span class='blueme boldme'>D +$diff%</span>";
    } elseif($r_pct > $d_pct) {
        $diff = $r_pct - $d_pct;
        $adv = "<span class='redme boldme'>R +$diff</span>";
    } else {
        $adv = "EVEN";
    }

    $retval = "<p align='center'>" . number_format($tot) . " Registered Voters ($rpt_date)<br>
                <span class='blueme boldme'>D: " . number_format($d) . " ($d_pct%)  </span>|  <span class='redme boldme'>R: " . number_format($r) . " ($r_pct%)  </span>|  NPP: " . number_format($npp) . " ($npp_pct%)<br>
                <br />$adv</p>";
    return $retval;
}

function get_live_results($fourcode, $election_year) {
    $conn = Util::get_ctb_conn();
    switch($election_year) {
        case "2018":
            $table = "ctb_g18_results_state";
            break;
        case "2020":
            $table = "ctb_g20_results_state";
            break;
    }

    $candidates = get_live_candidates($fourcode, $election_year);
    foreach($candidates as $cand_id) {
        $sql = "SELECT * FROM $table WHERE cand_id = '$cand_id' && fourcode = '$fourcode' ORDER BY updated DESC LIMIT 2";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $i = 1;
            while($row = $result->fetch_assoc()) {
                if($i == 1) {
                    $retval[$cand_id]['current'] = $row;
                } else {
                    $retval[$cand_id]['previous'] = $row;
                }
                $i++;
            }
        }
    }
    return $retval;
}

function get_live_candidates($fourcode, $election_year) {
    $conn = Util::get_ctb_conn();

    switch($election_year) {
        case "2018":
            $table = "ctb_g18_results_state";
            break;
        case "2020":
            $table = "ctb_g20_results_state";
            break;
    }


    $sql = "SELECT cand_id FROM $table WHERE fourcode = '$fourcode' GROUP BY cand_id";
    $retval = Array();
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($retval, $row['cand_id']);
        }
    }
    return $retval;
}

function check_ads($fourcode, $year) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_ads_e18 WHERE fourcode = '$fourcode' && year = '$year' ORDER BY candidate, buyer";
    $got_ads = FALSE;
    $result=$conn->query($sql);
    if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
         $got_ads = TRUE;
    }
    }
    return $got_ads;
}

function draw_ad_panel($fourcode, $year) {
    $conn = Util::get_ctb_conn();
    $first_vid_url = '';
    $vid_list = '';
    $ads = get_vids($fourcode, $year);

    $i = 0;
    foreach($ads as $x) {
    if($x['provider'] == "youtube") {
        $regex = '~watch\?v\=(.*)~mis';
        preg_match($regex, $x['url'], $results);
        if($i == 0) {
            $class ='active';
        } else {
            $class = '';
        }
        if($results[1]) {
            switch($x['position']) {
            case "support":
                $position = "<span class='greenme'> +";
                break;
            case "oppose":
                $position = "<span class='redme'> -";
                break;
            default:
                $position = "<span>";
                break;
            }
            $vid_list .= "<div class='vid-item' onClick=\"document.getElementById('vid_frame').src='https://www.youtube.com/embed/" . $results[1] . "'\">
                   <div class='thumb'>
                        <img src='https://img.youtube.com/vi/" . $results[1] . "/0.jpg'>
                   </div>
                   <div class='desc'>
                    <p class='caption'>" . $x['name'] . " (" . $position . " " . $x['candidate'] . ")</span><br>" . $x['type'] . " ad From " . $x['buyer'] . "</p>
                   </div>
                  </div>";
        }
        if($i == 0) {
            $first_vid_url = 'https://www.youtube.com/embed/' . $results[1];
        }
    }
    $i++;
    }
    if(!isset($vid_list)) {
    $vid_list = "<div class='vid-item'>
            <div class='desc'>NO ADS FOUND</div>
             </div>";
    }
    $retval['vid_list'] = $vid_list;
    $retval['first_url'] = $first_vid_url;
    $retval['html'] = "
        <div class='container'>
            <div class='row panel'>
                     <!-- THE YOUTUBE PLAYER -->
                 <h2 align='center'>$year $fourcode Campaign Ads</h2>
             <div class='vid-container'>
                 <iframe id='vid_frame' src='$first_vid_url' frameborder='0' width='560' height='315' allowfullscreen></iframe>
             </div>
             <div class='vid-list-container'>
                 <div class='vid-list'>
                $vid_list
                  </div>
             </div>
                 <!-- LEFT AND RIGHT ARROWS -->
                         <div class='arrows'>
                     <div class='arrow-left'><i class='fa fa-chevron-left fa-lg'></i></div>
                     <div class='arrow-right'><i class='fa fa-chevron-right fa-lg'></i></div>
                 </div>
             </div>
          </div>
              ";


    return $retval;
}



function populate_temp_cands($fourcode, $this_year) {
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb_temp_cands WHERE dist = '$fourcode' && status != '0' && year = '$this_year' ORDER BY party";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }
    return $retval;
}



function get_temp_panel($x) {
    global $role, $fourcode, $year;
    $text = $x['text'];
    $party = $x['party'];
    $name = $x['name'];
    $img_id = $x['img_id'];
    $this_year = $x['year'];
    $fppc_id='';
    $link_draw='';


    if (!isset($text)) {
        $text = $name;
    }

    $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
    foreach ($suffix as $s) {
        if (file_exists('img/candidates/' . $img_id . $s)) {
            $add_img = "<img src=\"/img/candidates/" . $img_id . $s . "\" class='client-image img-fluid'/>";
            break;
        } else {
            $add_img = "<img src=\"/img/candidates/NO_IMAGE.jpg\" class='client-image img-fluid'/>";
        }
    }

    if($role == "admin") {
       $add_img = "<div>$add_img<div style='z-index: 99; margin-top: -10px;'><a href='http://198.74.49.22/img_uploader.php?id=" . $img_id . "' target='_blank'><img src='/img/edit_btn.png' height='15px' width='15px'></a></div></div>";
    }

    $flag_url = "FlagWhite.jpg";
    switch ($party) {
        case "REP":
            $class = 'repdiv';
            $display_party = "(R)";
            $flag_url = "FlagRed.jpg";
            break;
        case "DEM":
            $class = 'demdiv';
            $display_party = "(D)";
            $flag_url = "FlagBlue.jpg";
            break;
        case "GRN":
            $class = 'grndiv';
            $display_party = "(Grn)";
            break;
        case "R":
            $class = 'repdiv';
            $display_party = "(R)";
            $flag_url = "FlagRed.jpg";
            break;
        case "D":
            $class = 'demdiv';
            $display_party = "(D)";
            $flag_url = "FlagBlue.jpg";
            break;
        default:
            $class = 'inddiv';
            $display_party = "($party)";
            break;
    }



    if (isset($add_img) && isset($twitter_btn)) {
        $final_img = "<div width='150' align='center' style='display: inline-block; float: left;'>" . $add_img . $twitter_btn . "</div>";
    } else {
        $final_img = $add_img;
    }

    /*

        $cand_div = "<div class='whitebg canddiv $class'><p style='float: left'>" . $final_img . $text . "</p>
                <p style='clear: both;' align='center'>$link_draw</p>
                $fppc_id
                </div>
        ";

        */

    //echo("<br>IDENTIFYING $cand_id candidate's committee for the year $year and district $fourcode ");
    //$cand_cmte = identify_committee($cand_id, $year, $fourcode);
    //var_dump($cand_cmte);


    if($role == "admin") {
        if(mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {
            $edit_btn = "<span><a href='http://198.74.49.22/tmp_cand_editor.php?id=" . $fourcode . "&cand_id=" . $img_id . "&year=" . $this_year . "' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
        } else {
            $edit_btn = "<span><a href='http://198.74.49.22/tmp_cand_editor.php?id=" . $fourcode . "&cand_id=" . $img_id . "&year=" . $this_year . "' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
        }
    } else {
        $edit_btn = '';
    }


    $cand_div = "<div class='mt-3 col-md-6 d-flex align-items-stretch'> <!--BEGIN TEMP CANDIDATE DIV -->
                    <div class='analysis-condidates bg-white pb-4 ctb-border-radius'>
                        <div class='ctb-analysis-profile-img'>
                            <img src='/img/$flag_url' alt='Banner Img' width='100%'>
                        </div>
                         <div class='d-flex justify-content-between align-items-center p-3'>
                            <div>
                                <div width='150' align='center' style='display: inline-block; float: left;'>
                                    <div>
                                            $add_img
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='ctb-analysis-profile-des px-3'>
                            <div>
                                <h2>$name $display_party
                                $edit_btn
                                </h2>
                                <p></p>
                                $text
                            </div>
                        </div>
                    </div>
                </div>";

    return $cand_div;

}

function get_vids($fourcode, $year) {
    //global $master_conn;
    //$conn = $master_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb_ads_e18 WHERE fourcode = '$fourcode' && provider='youtube' && year = '$year' ORDER BY candidate, position";

    $result = $conn->query($sql);
    $retval = Array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }
    return $retval;
}

function load_ies($years, $fourcode) {
    $conn = Util::get_ctb_conn();
    $retval = [];
    if(mb_substr($fourcode, 0, 2) == "CD") {
        $this_fourcode = "CA" . mb_substr($fourcode, 2, 2);
    } elseif(mb_substr($fourcode, 0, 3) == ".SN") {
        $this_fourcode = "CASEN";
    } else {
        $this_fourcode = $fourcode;
    }

    foreach($years['years']  as $year) {
        if($year < 2024) {
            $sql = "SELECT * FROM ctb_cached_json_ie WHERE year = '$year' && fourcode = '$this_fourcode'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $retval[$year] = json_decode($row['json'], TRUE);
                }
            }
        } else {
            $url = "http://198.74.49.22/draw_ie_json.php?id=$this_fourcode&cycle=$year";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($curl);
            curl_close($curl);

            $json = $data;
            $arr = json_decode($json, true);
            $retval[$year] = $arr;
        }
    }
    return $retval;
}

function draw_ie_panel($arr, $fourcode, $cycle) {
    global $endjava;

    $adjusted_fourcode = $fourcode;
    if(mb_substr($fourcode, 0, 2) == "CD") {
        $adjusted_fourcode = "CA" . mb_substr($fourcode, 2, 2);
    }
    if(mb_substr($fourcode, 0, 3) == ".SN") {
        $adjusted_fourcode = "CASEN";
    }

    $ie_totals      = draw_ie_total($arr);
    $cand_totals    = draw_cand_ie_totals($arr);
    $cmte_totals    = draw_cmte_ie_totals($arr);
    $detail_view    = draw_all_ie_transactions($arr);

    $retval = "<div class='headingDiv'>
                    <h5>Independent Expenditure Totals</h5>
               </div>
               <div class='row'>
                    $ie_totals
               </div>
               
                
                <div class='headingDiv'>
                    <h5>Candidate Totals</h5>
                </div>
                <br>
                <div class='row'>
                    $cand_totals
                </div>                    
               
                <div class='headingDiv'>
                    <h5>Committee Totals</h5>
        </div>
                <div class='row'>
                     $cmte_totals
                </div>                    

                <div class='headingDiv'>
                    <h5>All Transactions</h5>
        </div>
                <div class='row'>
                     $detail_view
                </div>                    
               
               <p align='center'>
                <button id='button_ie_" . $cycle . "' type='button' class='btn btn-primary' data-toggle='modal' data-target='#ie_modal'>
                View IE Detail Report
                </button>
           </p>

               ";

    $js = "
            $(document).ready(function () {
               $('#button_ie_" . $cycle . "').click(function() {
                     
                        var viewportHeight = $(window).height();
                        var newHeight = viewportHeight * 0.9;
                        $('#iframe_modal').height(newHeight);

                    $('#iframe_modal').attr('src', '/ctb-legacy/draw_ie.php?id=$adjusted_fourcode&cycle=$cycle');
                });
            });

    ";
    array_push($endjava, $js);

    return $retval;

}

function draw_ie_total($arr) {
    $x = $arr['ie_totals'];
    $grand_total = $x['grand_total'];
    unset($x['grand_total']);
    $enddraw = "<h2 align='center'>\$" . number_format($grand_total) . "</h2>
                <div class='row' align='center'>";
    $col_size = 12 / sizeof($x);                
    foreach($x as $type => $amt) {
        $enddraw .= "<div class='col-lg-$col_size'>
                        <div class='card card-yellow'>
                            <div class='card-head'>
                                <h4 align='center'>" . strtoupper($type) . "</h4>
                            </div>
                            <div class='card-body'>
                                <h4 align='center'>\$" . number_format($amt) . "</h4>
                            </div>
                        </div>
                    </div>";
    }
    $enddraw .= "</div>";
    return $enddraw;

}

function draw_cand_ie_totals($arr) {
    $cands = $arr['ie_cand_totals'];
    $enddraw = "<div class='row' align='center'>";
    foreach($cands as $last_nm => $x) {
        $enddraw .= "<div class='col-lg-4 d-flex align-items-stretch'>
                        <div class='card w-auto wide-card'>
                            <div class='card-head'>
                                <h4 align='center'>$last_nm</h4>
                            </div>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='col-lg-6'>";
        if(!empty($x['support_total'])) {
            $enddraw .= "<h5 class='text-success' align='center'>\$" . number_format($x['support_total']) . "<br>Support</h5>
                         <table class='w-auto table table-responsive'>
                            <tbody>";
            foreach($x as $k => $v) {
                if(mb_substr($k, 0, 7) == "support" && $k != "support_total") {
                    $type = substr($k, -1);
                    $enddraw .= "<tr>
                                    <td>$type</td>
                                    <td align='right'>\$" . number_format($v) . "</td>
                                </tr>";
                }
            }
            $enddraw .= "</tbody></table>
                        ";
        }                                
        $enddraw .= "</div>";
        $enddraw .= "<div class='col-lg-6'>";
        if(!empty($x['oppose_total'])) {
            $enddraw .= "<h5 align='center' class='text-danger'>\$" . number_format($x['oppose_total']) . "<br>Oppose</h5>
                         <table class='w-auto table table-responsive'>
                            <tbody>";
            foreach($x as $k => $v) {
                if(mb_substr($k, 0, 6) == "oppose" && $k != "oppose_total") {
                    $type = substr($k, -1);
                    $enddraw .= "<tr>
                                    <td>$type</td>
                                    <td align='right'>\$" . number_format($v) . "</td>
                                </tr>";
                }
            }
            $enddraw .= "</tbody></table>";
        }
        $enddraw .= "</div> <!--END OPPOSE -->
                    </div> <!--END SUPPORT/OPPOSE ROW -->
                </div> <!--END CARD BODY-->
            </div> <!--END CARD -->
        </div> <!--END FLEX COL-->
        ";
        
    }
    $enddraw .= "</div>";
    return $enddraw;
}

function draw_cmte_ie_totals($arr) {
    $cmtes = $arr['ie_cmte_summary'];
    $enddraw = "<div class='row' align='center'>
                <br>
                <div class='col-lg-12'>
                <table align='center' class='w-auto table-striped'>
                    <thead>
                        <tr>
                            <th>CMTE</th>
                            <th>PRIMARY</th>
                            <th>GENERAL</th>
                            <th>OTHER</th>
                            <th>SUPPORT</th>
                            <th>OPPOSE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>";
    foreach($cmtes as $x) {
        $enddraw .= "<tr>
                        <td>" . $x['cmte_lnk'] . "</td>
                        <td align='right'>\$" . (number_format($x['primary']) ?? '0') . "</td>
                        <td align='right'>\$" . (number_format($x['general']) ?? '0') . "</td>
                        <td align='right'>\$" . (number_format($x['other']) ?? '0') . "</td>
                        <td>" . (($x['cands_supported']) ?? '') . "</td>
                        <td>" . (($x['cands_opposed']) ?? '') . "</td>
                        <td align='right'>\$" . (number_format($x['grand_total']) ?? '0') . "</td>
                    </tr>";
    }
    $enddraw .= "</tbody>
                </table>
                </div>
                </div>";
    return $enddraw;                    

}

function draw_all_ie_transactions($arr) {
    //ie_transactions (fourcode, filing_id, filing_lnk, cmte_nm, cmte_id, cmte_lnk, exp_date, exp_amt, vendor, dscr, transaction_id, election_type, sup_opp, cand_nm, rec_date, rec_type), KEYNAME = cmte_id, [i]

    $transactions = $arr['ie_transactions'];
    $enddraw = "<div class='row' align='center'>
                    <br>
                    <div class='col-lg-12'>
                    <table align='center' class='w-auto table-striped small'>
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>FILING</th>
                                <th>FILER</th>
                                <th>AMOUNT</th>
                                <th>PAYEE</th>
                                <th>DSCR</th>
                                <th>ELECTION</th>
                                <th>SUP/OPP</th>
                                <th>CANDIDATE</th>
                            </tr>
                        </thead>
                        <tbody>";
    foreach($transactions as $cmte_id => $xx) {
        foreach($xx as $x) {
            $enddraw .= "<tr>
                            <td>" . $x['exp_date'] . "</td>
                            <td>" . $x['filing_lnk'] . "</td>
                            <td>" . $x['cmte_lnk'] . "</td>
                            <td align='right'>\$" . number_Format($x['exp_amt']) . "</td>
                            <td>" . $x['vendor'] . "</td>
                            <td>" . $x['dscr'] . "</td>
                            <td>" . $x['election_type'] . "</td>
                            <td>" . $x['sup_opp'] . "</td>
                            <td>" . $x['cand_nm'] . "</td>
                        </tr>";
        }                            
    }
    $enddraw .= "</tbody>
                </table>
                </div>
            </div>";
    return $enddraw;
}
?>
