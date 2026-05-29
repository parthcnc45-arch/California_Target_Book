@extends('old.hotsheet')

@section('title', 'Recend Candidates Panel | California Target Book')

@section('content')


<?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');

	global $role;

	use App\User;
	$role = Auth::user()->role;

	if(isset($_GET['id'])) {
		$cand_id = $_GET['id'];
	}

	$year = "2018";

	$candidates = Array($cand_id);

	if(!isset($cand_id)) {
		$candidates = populate_candidates();
	}	

	echo("<div id='parent'>");

	$i = 0;
	foreach($candidates as $cand_id) {
		$x = get_panel($cand_id);
		echo($x);
		$i++;
	}

	echo("</div>");



function populate_candidates() {

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM calaccess_raw_e18_comm ORDER BY id DESC LIMIT 10;
    ");

    $retval = Array();

    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	array_push($retval, $row['cand_id']);
    }

    return $retval;

}


function get_panel($cand_id) {
	global $year, $role;
    $text = fetch_bio($cand_id);

    $x = fetch_info($cand_id);

    $fourcode = $x['FOURCODE'];
    $cmte_id = $x['cmte_id'];
    $party = $x['party'];
    $name = $x['namf'] . " " . $x['naml'];


    
    if (!$text) {
        $text = $name;
    }

    $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
    foreach ($suffix as $s) {
        if (file_exists('img/candidates/' . $cand_id . $s)) {
            $add_img = "<a href='/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"/img/candidates/" . $cand_id . $s . "\" width='150px' style='border-radius: 10px; float: top; margin-bottom: 5px;'/></a>";
            break;
        } else {
            $add_img = "<a href='/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"/img/candidates/NO_IMAGE.jpg\" width='150px' style='border-radius: 10px; float: top; margin-bottom: 5px;'/></a>";
        }
    }

    if($role == "admin") {
	$add_img = "<div>$add_img<div style='z-index: 99; margin-top: -10px;'><a href='http://198.74.49.22/img_uploader.php?id=" . $cand_id . "' target='_blank'><img src='/img/edit_btn.png' height='15px' width='15px'></a></div></div>";
    }

    switch ($party) {
        case "REP":
            $class = 'repdiv';
            $display_party = "(R)";
            break;
        case "DEM":
            $class = 'demdiv';
            $display_party = "(D)";
            break;
        case "GRN":
            $class = 'grndiv';
            $display_party = "(Grn)";
            break;
        case "R":
            $class = 'repdiv';
            $display_party = "(R)";
            break;
        case "D":
            $class = 'demdiv';
            $display_party = "(D)";
            break;
        default:
            $class = 'inddiv';
            $display_party = "($party)";
            break;
    }

    $cand_links = Array();


    $y = get_cand_links($cand_id);

    $twitter_btn = '';

    if ($y['campaign']) {
        $tmp = "<a href='" . $y['campaign'] . "' target='_blank'>Campaign</a>";
        array_push($cand_links, $tmp);
    }

    if ($y['official']) {
        $tmp = "<a href='" . $y['official'] . "' target='_blank'>Official</a>";
        array_push($cand_links, $tmp);
    }

    if ($y['facebook']) {
        $tmp = "<a href='http://www.facebook.com/" . $y['facebook'] . "' target='_blank'>Facebook</a>";
        array_push($cand_links, $tmp);
    }

    if ($y['twitter']) {
        $tmp = "<a href='http://twitter.com/" . $y['twitter'] . "' target='_blank'>Twitter</a>";
        $twitter_btn = "<div style='margin-top: 5px'><a href='https://twitter.com/" . $y['twitter'] . "' class='twitter-follow-button' data-show-count='false'>Follow @" . $y['twitter'] . "</a></div>";
        array_push($cand_links, $tmp);
    }

    if ($y['linkedin']) {
        $tmp = "<a href='" . $y['linkedin'] . "' target='_blank'>Linkedin</a>";
        array_push($cand_links, $tmp);
    }

    if ($y['youtube']) {
        $tmp = "<a href='" . $y['youtube'] . "' target='_blank'>Youtube</a>";
        array_push($cand_links, $tmp);
    }

    if ($cand_id) {

        if (mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {
            $fppc_id = "<p align='center'><a href='http://classic.fec.gov/fecviewer/CandidateCommitteeDetail.do?&tabIndex=3&candidateCommitteeId=" . $cand_id . "' target='_blank'>FEC ID# $cand_id</a></p>";
        } else {
            $fppc_id = "<p align='center'><a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=" . $cand_id . "' target='_blank'>FPPC ID# $cand_id</a></p>";
        }
    }

    $l = 0;

    $link_draw = '';
    foreach ($cand_links as $l_value) {
        if ($l > 0) {
            $link_draw .= " | " . $l_value;
        } else {
            $link_draw .= $l_value;
        }
        $l++;
    }

    if ($add_img && $twitter_btn) {
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
			$edit_btn = "<span><a href='http://198.74.49.22/cand_editor.php?cand_id=" . $cand_id . "&juris=US' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
		} else {
			$edit_btn = "<span><a href='http://198.74.49.22/cand_editor.php?cand_id=" . $cand_id . "&juris=CA' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";		
		}
	} else {
		$edit_btn = '';
	}


    $cand_div = "<div class='row candidate-panel' style='margin-top: 10px;'> <!--BEGIN CANDIDATE DIV -->
					<div class='panel'> <!--BEGIN CANDIDATE PANEL -->

						<div class='col-lg-12 candidate-content'> <!--BEGIN CANDIDATE CONTENT -->

							<div class='row'> <!--BEGIN MAIN CONTENT ROW -->
								<span class='panel-candidate-header'>$name $display_party - $fourcode</span><span align='center' style='padding: 5px; opacity: 0.5;'>$edit_btn</span>
								<p class='$class' style='width: 100% !important; font-family: \"Bellefair\"; font-size: 1.4em; font-weight: bold; font-family: small-caps;' />

								<div class='col-sm-3'>
									$final_img
								</div>

								<div class='col-lg-9'>
									$text
								</div>

							</div> <!--END MAIN CONTENT ROW -->

							<div class='row'> <!--BEGIN LINKS ROW -->
								<div class='col-lg-12 text-center'>
									$link_draw
								</div>
							</div> <!--END LINKS ROW -->

							<div class='row'> <!--BEGIN FPPC/FEC ID ROW -->
								<div class='col-lg-12'>
									$fppc_id
								</div>
							</div> <!--END FPPC/FEC ID ROW -->";

$end_div = "			</div> <!--END CANDIDATE CONTENT -->
					</div> <!--END CANDIDATE PANEL -->
				</div> <!--END CANDIDATE DIV -->";

	$retval  = $cand_div . $end_div;
	return $retval;

}



function fetch_bio($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
              SELECT text FROM ctb_cand_bios WHERE cand_id = :id
	      ORDER BY date DESC
	      LIMIT 1
            ");

    $stmt->execute(['id' => $cand_id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['text'];
}




function fetch_info($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM calaccess_raw_e18_comm WHERE cand_id = :id;
    ");

    $stmt->execute(['id' => $cand_id]);

    $retval = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	$retval = $row;
    }

    return $retval;
}

function get_cand_links($cand_id)
{
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_cand_links WHERE cand_id = :id;
    ");

    $stmt->execute(['id' => $cand_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>

@endsection

@section('styles')

<style>

    .candidate-panel {
        background-color: #fcfcfc;
        -webkit-box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        -moz-box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        padding: 20px;
        width: 105%;
        max-width: 1190px;
        margin-right: 40px;
        margin-top: 20px;
    }

    .candidate-panel .candidate-content {
        line-height: 1.5;
        font-size: 1.1em;
        font-family: 'Lato';
        padding: 10px;
    }

    .panel-candidate-header {
        font-family: 'Lato';
        font-weight: bold;
        font-variant: small-caps;
        text-align: right;
        font-size: 1.5em;
	box-shadow: none;
    }

    .content-header {
        text-align: center;
        font-variant: small-caps;
    }

    .iframe-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%;

    }

    .iframe-container > * {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }

    #years > ul li {
        list-style: none;
        padding: 5px 15px;
        float: left;
        margin: 5px;
        border: 1px solid #ccc;
    }
    #years > ul li.tab-current {
        background: #ddd;
    }
    #years > ul li:hover {
        background: #eee;
    }

    .panel {
        background-color: #fcfcfc;
    }

    .no-border {
        box-shadow: none;
    }

    .tablesorter, table-responsive, .table-sm {
	font-family: 'PT Sans Narrow';
    }

#parent {
	margin-top: -100px;
}

#parent .candidate-panel {
    display:none;

    position: absolute;
	
}
/*
#parent div:first-child {
    display:block;
    width:800px;
    height:450px;
}
*/




</style>

@endsection

@section('scripts')

<script>

    function Divs() {
        var divs= $('#parent .candidate-panel'),
            now = divs.filter(':visible'),
            next = now.next().length ? now.next() : divs.first(),
            speed = 50;
    
        now.fadeOut(speed);
        next.fadeIn(speed);
    }
    
    $(function () {
        setInterval(Divs, 4000);
    });

</script>

@endsection