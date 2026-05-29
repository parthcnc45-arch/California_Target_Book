<?php

//POST-2020 REDISTRICTING VERSION

global $cached;
//$x = retrieve_info($cached['fourcode']);
$x = retrieve_info($old_fourcode);

$img_src = $x['IMG'];
$cand_id = $x['CAND_ID'];
?>

<div class='container-fluid'>

    <div class=" panel center-block fn">
        <div class='row'>

            <div class='col-md-6 row m-n'>
                <div class="col-md-12 col-sm-4 col-xs-12">
                    <img src="<?= 'https://californiatargetbook.com/'.$img_src ?>" width='200px' class="img-responsive img-thumbnail center-block-mobile mb-lg" />
                </div>
                <div class="col-md-12 col-sm-8 col-xs-12">
                    <h3 class="mt-n"><?= $x['INCUMBENT'] ?> (<?= $x['PARTY'] ?>)</h3>

                    <h4>Born: <?= $x['DOB'] ?? '' ?></h4>
                    <h4>Term <?=  $x['TERM_LIMIT'] ?? ''  ?></h4>

                    <p><?=  $x['BIO'] ?? ''  ?></p>
                </div>
            </div>


            <div class='col-md-6'>

                <div class="table table-striped org-table text-left">
                    <?= draw_org($cand_id);  ?>
                </div>

            </div>

        </div>


    </div>

    <?php
    $x = retrieve_social_media($cand_id);

    $fb = $x['facebook'] ?? '';
    $tw = $x['twitter'] ?? '';

    ?>
    <div class='col-sm-10 center-block fn row p-n'>
        <div class="row">


            <?php if ($fb) { ?>
                <div class='col-md-6'>
                    <div class="panel">
                        <h3>Facebook</h3>
                        <div id="fb-root" class="img-responsive ov-h"></div>
                        <div class="fb-page img-responsive ov-h center-block"
                            data-href="https://www.facebook.com/<?= $fb ?>"
                            data-tabs="timeline"
                            data-height="600px"
                            data-small-header="false"
                            data-adapt-container-width="true"
                            data-hide-cover="false"
                            data-show-facepile="true">

                            <blockquote cite="https://www.facebook.com/facebook"
                                class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/<?= $fb ?>"><?= $fb ?></a>
                            </blockquote>
                        </div>
                    </div>

                </div>
            <?php } ?>


            <?php if ($tw) { ?>
                <div class='col-md-6'>
                    <div class="panel">
                        <h3>Twitter</h3>

                        <a height='600'
                            style='zoom: 0.7;'
                            class='twitter-timeline img-responsive'
                            href="https://twitter.com/<?= $tw ?>">Tweets by <?= $tw ?></a>
                    </div>

                </div>
            <?php } ?>


        </div>
    </div>
</div>

<?php

/*

function retrieve_fed_org_ratings($fourcode)
{

    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;

        }
    }

    return $retval;
}

function retrieve_fed_org($fourcode)
{

    $x = retrieve_fed_org_ratings($fourcode);
    $org_draw = '';

    $orgs = Array("ORG_PPUNCH" => "Progressive Punch",
        "ORG_PPUNCH+" => "(Lifetime)",
        "ORG_ADA" => "Americans for Democratic Action",
        "ORG_ACLU" => "American Civil Liberties Union",
        "ORG_LCV" => "League of Conservation Voters",
        "ORG_LCV+" => "(Lifetime)",
        "ORG_PPACT" => "Planned Parenthood",
        "ORG_AFLCIO" => "AFL/CIO",
        "ORG_AFLCIO+" => "(Lifetime)",
        "ORG_TEAMSTERS" => "Teamsters",
        "ORG_UFCW" => "United Food and Commercial Workers",
        "ORG_AFSCME" => "American Federation of State, County, and Municipal Employees",
        "ORG_GOVTEMP" => "American Federation of Government Employees",
        "ORG_NEA" => "National Education Association",
        "ORG_COC" => "U.S. Chamber of Commerce",
        "ORG_COC+" => "(Lifetime)",
        "ORG_NAM" => "National Association of Manufacturers",
        "ORG_NFIB" => "National Federation of Independent Businesses",
        "ORG_NAPO" => "National Association of Police Organizations",
        "ORG_NRA" => "National Rifle Association",
        "ORG_FWORKS" => "FreedomWorks",
        "ORG_AFP" => "Americans for Prosperity",
        "ORG_CCAGW" => "Concerned Citizens Against Government Waste",
        "ORG_FRC" => "Family Research Council",
        "ORG_NUMBUSA" => "Numbers USA",
        "ORG_ACU" => "American Conservative Union",
        "ORG_ACU+" => "(Lifetime)"

    );

    $tablehead = "<table class='table-sm table-responsive'>
                        <thead>
                            <tr>
                                <th style='text-align: right;'>Organization</th>
                                <th style='text-align: right;'>Score</th>
                            </tr>
                        </thead>
                        <tbody>";

    foreach ($orgs as $key => $value) {
        if (isset($x[$key])) {
            $txt_class = '';

            if ($x[$key] <= 10) {
                $txt_class = 'redme';
            }

            if ($x[$key] >= 90) {
                $txt_class = 'greenme';
            }

            if ($x[$key] == 0) {
                $txt_class = 'redme boldme';
            }

            if ($x[$key] == 100) {
                $txt_class = 'greenme boldme';
            }

            $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . $x[$key] . "%</td></tr>";
        }
    }

    if (isset($org_draw)) {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }

    return $retval;

}

*/

function draw_org($cand_id) {
    $ratings = get_new_org($cand_id);
    $org_draw = '';
    $tablehead = "<table class='table-sm table-responsive'>
                    <thead>
                        <tr>
                            <th style='text-align: right;'>Organization</th>
                            <th style='text-align: right;'>Year</th>
                            <th style='text-align: right;'>Score</th>
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
                        <td align='right'>"  . $x['org'] . "</td>
                        <td align='right'>"  . $x['year'] . "</td>
                        <td align='right' class='$txt_class'>" . $x['rating'] . $add_pct . "</td>
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
    //var_dump($retval);
    return $retval;
}

/*

function draw_org($id)
{

    if (mb_substr($id, 0, 2) == "CD") {
        $fourcode = "CA" . mb_substr($id, 2, 2);
        $x = retrieve_fed_org($fourcode);

        return $x;
    } else {
        $x = retrieve_org_ratings($id);
    }
    $org_draw = '';

    $orgs = Array("LCV" => "League of Conservation Voters",
        "LCV+" => "(Lifetime)",
        "SIERRA" => "Sierra Club",
        "CEJA" => "California Environmental Justice Association",
        "CWA" => "Clean Water Action",
        "HS" => "Humane Society",
        "PP" => "Planned Parenthood",
        "CLF" => "California Labor Federation",
        "CLF+" => "(Lifetime)",
        "UDW" => "United Domestic Workers",
        "NASW" => "National Association of Social Workers",
        "CMTA" => "California Manufacturers & Technology Association",
        "CCC" => "California Chamber of Commerce",
        "NFIB" => "National Federation of Independent Businesses",
        "HJTA" => "Howard Jarvis Taxpayers' Association",
        "CTAX" => "California Taxpayers' Association",
        "ACU" => "American Conservative Union",
        "ACU+" => "(Lifetime)",
        "CRA" => "California Republican Assembly"
    );

    $tablehead = "<table class='table-sm table-responsive'>
                        <thead>
                            <tr>
                                <th style='text-align: right;'>Organization</th>
                                <th style='text-align: right;'>Score</th>
                            </tr>
                        </thead>
                        <tbody>";

    $org_draw = '';
    foreach ($orgs as $key => $value) {

        if (array_key_exists($key, $x)) {
            $txt_class = '';

            if ($x[$key] <= 10) {
                $txt_class = 'redme';
            } else if ($x[$key] >= 90) {
                $txt_class = 'greenme';
            } else if ($x[$key] == 0) {
                $txt_class = 'redme boldme';
            } else if ($x[$key] == 100) {
                $txt_class = 'greenme boldme';
            }


            if ($key == "CCC") {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . number_format($x[$key], 0) . "%</td></tr>";
            } else {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . $x[$key] . "%</td></tr>";
            }
        }
    }

    $retval = '';
    if ($org_draw) {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }

    return $retval;

}

*/

function retrieve_info($fourcode)
{
    $conn = Util::get_ctb_conn();

    global $cand_id;
    $sql = "SELECT * FROM ctb2016_e22_incumbent WHERE DIST = '$fourcode'";
    //echo("<br>SQL1<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['CAND_ID'];
            $cand_id = $id;
            $retval['PARTY'] = $row['PARTY'];
            $retval['INCUMBENT'] = $row['LEGISLATOR'];
            $retval['DOB'] = $row['DOB'];
            $retval['TERM_LIMIT'] = $row['TERM_LIMIT'];
            $retval['CAND_ID'] = $row['CAND_ID'];
        }
    }

    $types = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
    $retval['IMG'] = '';
    foreach ($types as $type) {
        $tmp_file = "img/candidates/" . $id . $type;
        if (file_exists($tmp_file)) {
            $retval['IMG'] = '/img/candidates/' . $id . $type;
            break;
        }
    }


    $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$id' ORDER BY id DESC LIMIT 1";
    //echo("<br>SQL2<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['BIO'] = $row['text'];
        }
    }

    //var_dump($retval);
    return $retval;
}

/*

function retrieve_org_ratings($fourcode)
{
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_org_2016_ca WHERE FOURCODE = '$fourcode'";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;

        }
    }

    return $retval;
}

*/


function retrieve_social_media($cand_id)
{
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * from ctb_cand_links WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    return $retval;
}

?>