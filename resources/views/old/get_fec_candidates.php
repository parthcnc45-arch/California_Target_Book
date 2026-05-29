



<?php

Util::set_errors();
Util::require_ctb_api();


$enddraw = '';

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");
$endjava = Array();


//$fourcode = $_GET['id'];

$candidates = populate_candidates($year);
//var_dump($candidates);


foreach ($candidates as $x) {
    $links = Array();
    $cand_id = $x['CAND_ID'];
    $cand_nm = $x['CAND_NAME'];
    $cand_cmte = $x['CAND_PCC'];
    $party = $x['CAND_PTY_AFFILIATION'];
    $y = get_cand_links($cand_id);

    $img_type = Array(".bmp", ".png", ".jpg", ".jpeg", ".gif");
    $img_src = '';
    foreach ($img_type as $suffix) {
        if (file_exists("img/candidates/$cand_id" . $suffix)) {
            $img_src = "/img/candidates/$cand_id" . $suffix;
            break;
        }
    }

    $twitter_btn = '';


    switch ($party) {
        case "DEM":
            $div_class = 'demdiv';
            break;
        case "REP":
            $div_class = 'repdiv';
            break;
        case "GRN":
            $div_class = 'grndiv';
            break;
        default:
            $div_class = 'inddiv';
            break;
    }

    if ($y['campaign']) {
        $url = "<a href='" . $x['campaign'] . "' target='_blank'>$cand_nm ($party)</a>";
    } elseif ($y['official']) {
        $url = "<a href='" . $y['official'] . "' target='_blank'>$cand_nm ($party)</a>";
    } elseif ($y['linkedin']) {
        $url = "<a href='" . $y['linkedin'] . "' target='_blank'>$cand_nm ($party)</a>";
    } elseif ($y['facebook']) {
        $url = "<a href='http://www.facebook.com/" . $y['facebook'] . "' target='_blank'>$cand_nm ($party)</a>";
    } elseif ($x['twitter']) {
        $url = "<a href='http://twitter.com/" . $y['twitter'] . "' target='_blank'>$cand_nm ($party)</a>";

    } else {
        $url = "<span class='itcme'>$cand_nm ($party)</span>";
    }

    if ($y['campaign']) {
        $tmp = "<a href='" . $y['campaign'] . "' target='_blank'>Campaign</a>";
        array_push($links, $tmp);
    }

    if ($y['official']) {
        $tmp = "<a href='" . $y['official'] . "' target='_blank'>Official</a>";
        array_push($links, $tmp);
    }

    if ($y['facebook']) {
        $tmp = "<a href='http://www.facebook.com/" . $y['facebook'] . "' target='_blank'>Facebook</a>";
        array_push($links, $tmp);
    }

    if ($y['twitter']) {
        $tmp = "<a href='http://twitter.com/" . $y['twitter'] . "' target='_blank'>Twitter</a>";
        $twitter_btn = "<div style='margin-top: 5px'><a href='https://twitter.com/" . $y['twitter'] . "' class='twitter-follow-button' data-show-count='false'>Follow @" . $y['twitter'] . "</a></div>";
        array_push($links, $tmp);
    }

    if ($y['linkedin']) {
        $tmp = "<a href='" . $y['linkedin'] . "' target='_blank'>Linkedin</a>";
        array_push($links, $tmp);
    }

    if ($y['youtube']) {
        $tmp = "<a href='" . $y['youtube'] . "' target='_blank'>Youtube</a>";
        array_push($links, $tmp);
    }

    if ($cand_id) {
        $fec_id = "<p align='center'><a href='http://classic.fec.gov/fecviewer/CandidateCommitteeDetail.do?&tabIndex=3&candidateCommitteeId=" . $cand_id . "' target='_blank'>FEC ID# $cand_id</a></p>";
    }

    $l = 0;

    $link_draw = '';
    foreach ($links as $link) {
        if ($l > 0) {
            $link_draw .= "<span>  |  " . $link . "</span>";
        } else {
            $link_draw .= "<span>$link</span>";
        }
        $l++;
    }

    $cand_link_row = "<p align='center'>$link_draw</p>";

    if ($x['CAND_ICI'] == "I") {
        $party .= "-Inc";
    }

    if ($img_src && $twitter_btn) {
        $img = "<div width='150' align='center' style='display: inline-block; float: left;'><img src='$img_src' alt='' style='float: top; border-radius: 10px; margin-bottom: 5px;' width='150px' align='center' />$twitter_btn</div>";
    } elseif ($img_src) {
        $img = "<img src='$img_src' alt='' style='float: left; border-radius: 10px;' width='150px' />";
    } else {
        $img = "<img src='../candidates/NO_IMAGE.jpg' alt='' style='float: left; border-radius: 10px;' width='150px' />";
    }

    $bio = $x['bio'];


    $cand_div = "<div class='row candidate-panel' style='margin-top: 10px;'> <!--BEGIN CANDIDATE DIV -->
					<div class='panel'> <!--BEGIN CANDIDATE PANEL -->

						<div class='col-lg-12 candidate-content'> <!--BEGIN CANDIDATE CONTENT -->

							<div class='row'> <!--BEGIN MAIN CONTENT ROW -->
								<h2 style='padding-left: 15px;'>$cand_nm ($party)</h2>
								<hr class='$div_class' />

								<div class='col-sm-3'>
									$img
								</div>

								<div class='col-lg-9'>
									$bio
								</div>

							</div> <!--END MAIN CONTENT ROW -->

							<div class='row'> <!--BEGIN LINKS ROW -->
								<div class='col-lg-12 text-center links-row'>
									$cand_link_row
								</div>
							</div> <!--END LINKS ROW -->

							<div class='row'> <!--BEGIN FPPC/FEC ID ROW -->
								<div class='col-lg-12'>
									$fec_id
								</div>
							</div> <!--END FPPC/FEC ID ROW -->

						</div> <!--END CANDIDATE CONTENT -->
					</div> <!--END CANDIDATE PANEL -->
				</div> <!--END CANDIDATE DIV -->";

    $enddraw .= $cand_div;

}

echo($enddraw);






