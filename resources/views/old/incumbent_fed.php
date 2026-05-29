


<div class='container-fluid'>

    <div class='row'>
      <div class="panel row">
        <div class='col-sm-3'>
            <?php
            global $master_fourcode;
	   $x = $info;

            $img_src = $x['IMG'];
            $cand_id = $x['CAND_ID'];
	   $dob = $x['dob'];

            //echo("<img src='$img_src' width='250px' class='img-thumbnail' />");

            //echo("<h3>" . $x['INCUMBENT'] . " (" . $x['PARTY'] . ")</h3>");

            if (!empty($x['TERM_LIMIT'])) {
                echo("<h4>Term Limit: " . $x['TERM_LIMIT'] . "</h4>");
            }
	   echo($inc_span);
            echo("<h4 align='center'>DOB: $dob</h4>");
	   echo($office_span);
	   //echo("<h4>OFFICE: " . $x['OFFICE'] . "<br>PH: " . $x['PHONE'] . "<br>WEBSITE: <a href='" . $x['WEBSITE'] . "' target='_blank'>" . $x['WEBSITE'] . "</a></h4>");


            ?>
        </div>

        <div class='col-md-5'>
            <?php


	   
            echo("<p class='lead text-justify'>" . $x['BIO'] . "</p>");
            echo($inc_cmte_assignments);

            ?>

        </div>

        <div class='col-md-4'>
          <?= draw_org($cand_id) ?>
        </div>


      </div>


    </div>

    <div class='row'>

        <div class='col-md-6'>
          <div class="panel">
            <p align='center'>FACEBOOK</p>

              <?php

              $x = retrieve_social_media($cand_id);
   

              $fb = $x['facebook'] ?? '';
              $tw = $x['twitter'] ?? '';


              if ($fb) {

                  echo("

			<div id=\"fb-root\"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=180464472033211\";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

				");

                  echo("<div class=\"fb-page\" data-href=\"https://www.facebook.com/" . $fb . "\" data-tabs=\"timeline\" data-width=\"500px\" data-height=\"600px\" data-small-header=\"false\" data-adapt-container-width=\"true\" data-hide-cover=\"false\" data-show-facepile=\"true\"><blockquote cite=\"https://www.facebook.com/facebook\" class=\"fb-xfbml-parse-ignore\"><a href=\"https://www.facebook.com/" . $fb . "\">$fb</a></blockquote></div>");

              }

              ?>


          </div>

        </div>

        <div class='col-md-6'>
          <div class="panel">
            <p align='center'>TWITTER</p>

              <?php

              if ($tw) {

                  echo("

			 <a height='600' width='500' style='zoom: 0.7;' class='twitter-timeline' href='https://twitter.com/" . $tw . "'>Tweets by " . $tw . "</a> <script async src='//platform.twitter.com/widgets.js' charset='utf-8'></script>

				");

              }

              ?>


          </div>
        </div>

    </div>

    <div class='row'>
        <div class='col-lg-12'>
            <!--<h3>Votes Cast This Session</h3>-->

            <?php //include 'housevote_bydist.php';

            $census_js = "
					<script type='text/javascript'>
					function showCensusDiv(z) {

						var url = 'housevote_bydist.php?id=$id';

						if(z == 1) {
							document.getElementById('censusDiv').style.display = 'block';
							document.getElementById('btmClose').style.display = 'block';
							document.getElementById('censusHidden').src = url;
						} else {
							document.getElementById('censusDiv').style.display = 'none';
							document.getElementById('btmClose').style.display = 'none';
							document.getElementById('censusHidden').src = '/img/spinner.gif';
						}
					   
					}
					</script>";

            //global $endjava;
            //array_push($endjava, $census_js);

            $census_detail_div = "
					<p><input class=\"button campaign\" name=\"answer\" value=\"Votes Cast This Session\" onclick=\"showCensusDiv(1)\" title=\"Votes Cast This Session\" width=\"80%\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" /></p>
					<p></p>
					<p></p>
					<p></p>
					<p></p>
					<p></p>
					<div id=\"censusDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"censusHidden\" width='100%' height='1200'></iframe></div>
					<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\"  width='20%' /></p>";

            //echo($census_detail_div);

            ?>

        </div>


    </div>

</div>

<?php

//echo("<div id='Incumbent'>");
//echo("<p>INCUMBENT INFORMATION HERE</p>");
//echo($bio);
//echo($org);
//echo($social);
//echo("</div>");

//NEW FED ORG RATINGS

function draw_org($cand_id) {
    $ratings = get_new_org($cand_id);
    $org_draw = '';
    $tablehead = "<table class='table-striped table-sm table-responsive'>
                    <thead>
                        <tr>
                            <th class='leftme'>Organization</th>
                            <th class='rightme'>Year</th>
                            <th class='rightme'>Score</th>
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
                        <td align='left'>"  . $x['org'] . "</td>
                        <td align='right'>"  . $x['year'] . "</td>
                        <td align='right' class='$txt_class'>" . $x['rating'] . $add_pct . "</td>
                    </tr>";
    }

    if($org_draw)  {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }
    return $retval;
}

function get_new_org($cand_id) {
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb_new_org_ratings WHERE cand_id = '$cand_id' ORDER BY org, year DESC";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    $last_org = '';
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



//OLD FED ORG RATINGS

/*
function retrieve_fed_org_ratings($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_e20_fed WHERE DIST = '$fourcode'";
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
								<th class='leftme'>Organization</th>
								<th class='rightme'>Score</th>
							</tr>
						</thead>
						<tbody>";

    $org_draw = '';
    foreach ($orgs as $key => $value) {
        if ($x[$key] != NULL) {
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

    if ($org_draw) {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }

    return $retval;

}


function draw_org($id)
{

    $x = retrieve_fed_org($id);

    return $x;

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


    foreach ($orgs as $key => $value) {
        if ($x[$key] != NULL) {
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

            if ($key == "CCC") {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . number_format($x[$key], 0) . "%</td></tr>";
            } else {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . $x[$key] . "%</td></tr>";

            }
        }
    }

    if ($org_draw) {
        $retval = $tablehead . $org_draw . "</tbody></table>";
    } else {
        $retval = "<p>No Scorecard for this Legislator Yet</p>";
    }

    return $retval;

}

*/


function retrieve_org_ratings($fourcode)
{
    global $ctb2016_conn;
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

function retrieve_social_media($cand_id)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $retval = [];
    $sql = "SELECT twitter, facebook FROM ctb_cand_links WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    //var_dump($retval);
    return $retval;
}
