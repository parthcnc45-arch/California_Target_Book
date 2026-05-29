<div class='container-fluid'>

    <!-- <section id="ctb-main-container-sec"> -->
        <div class="ctb-main-container">
            <?php include(Util::$view_root.'incumbent_info.php') ?>
            <div class="row mt-5 commite_cols">
                <div class="col p-0">
                    <div class="ctb-rabban headingDiv">
                        <h5>Committee Assignments</h5>
                    </div>
                    <div class="cbt-assignments-box">
                        <table class="table table-assignments">
                            <thead>
                            <tr>
                                <th>2023 Session</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Assembly Budget</td>
                            </tr>
                            <tr>
                                <td>
                                Assembly Budget Subcommittee No. 2 on Education Finance
                                </td>
                            </tr>
                            <tr>
                                <td>Assembly Budget</td>
                            </tr>
                            <tr>
                                <td>
                                Assembly Budget Subcommittee No. 2 on Education Finance
                                </td>
                            </tr>
                            <tr>
                                <td>Assembly Budget</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col">
                    <div class="ctb-rabban headingDiv">
                        <h5>Leadership Positions</h5>
                    </div>
                    <?php $leaderships=retrieve_leadership($cand_id);?>
                    <?php foreach ($leaderships as $key => $leadership): ?>
                        <div class="cbt-positions-box">
                            <table class="table table-positions">
                                <thead>
                                <tr>
                                    <th> <?=$leadership["session"];?> Session</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> <?=$leadership["position"];?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach;?>
                    <?php if(!count($leaderships)){?>
                        <h4 class='p4'>No data availabile</h4>
                    <?php }?>
                </div>
                <div class="col p-0">
                    <div class="ctb-rabban headingDiv">
                        <h5>Works</h5>
                    </div>
                    <div class="cbt-works-box">
                        <?= draw_org($cand_id);  ?>
                    </div>
                </div>
            </div>
        </div>
    <!-- </section> -->

</div>

<?php


function draw_org($cand_id) {
    $ratings = get_new_org($cand_id);
    $org_draw = '';
    $tablehead = "<table class='table-responsive table-works'>
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>Year</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                        <tbody>";
    foreach($ratings as $x) {
        $txt_class = '';
        if($x['rating'] <= 10) {
            $txt_class = 'redme';
        }

        if($x['rating'] >= 90) {
            $txt_class = 'greenme';
        }
        if($x['rating'] == 0 || $x['rating'] == "F") {
            $txt_class = 'redme boldme';
        }
        if($x['rating'] == "100" || $x['rating'] == "A" || $x['rating'] == "A+") {
            $txt_class = 'greenme boldme';
        }

        if($x['rating'] == "A" || $x['rating'] == "B" || $x['rating'] == "C" || $x['rating'] == "D" || $x['rating'] == "F") {
            $add_pct = '';
        } else {
            $add_pct = "%";
        }
        $org_draw .= "<tr>
                        <td>"  . $x['org'] . "</td>
                        <td>"  . $x['year'] . "</td>
                        <td class='$txt_class'>" . $x['rating'] . $add_pct . "</td>
                    </tr>";
    }

    if(isset($org_draw))  {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }
    return $retval;
}

function get_new_org($cand_id) {
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $last_org = '';
    $sql = "SELECT * FROM ctb_new_org_ratings WHERE cand_id = '$cand_id' ORDER BY org, year DESC";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this_org = $row['org'];
            $tmp['org'] = $row['org'];
            $tmp['year'] = $row['year'];
            $tmp['rating'] = $row['rating'];
            $tmp['rating'] = str_replace("%", "", $tmp['rating']);

            if($this_org == $last_org) {
                //DO NOTHING
            } else {
                array_push($retval, $tmp);
            }
            $last_org = $this_org;
        }
    }
    return $retval;
}




function retrieve_leadership($cand_id)
{
    $conn = Util::get_ctb_conn();
    $retval=[];
    $sql = "SELECT * from ctb_caleg_leadership WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        array_push($retval,$result->fetch_assoc());
    }
    return $retval;
}

?>
