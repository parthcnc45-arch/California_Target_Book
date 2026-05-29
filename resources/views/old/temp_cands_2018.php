<?php

Util::require_ctb_api();

global $role, $fourcode;
$endjava = Array();

use App\User;
$role = Auth::user()->role;



$cands = populate_temp_cands($fourcode);

if($cands) {

    echo("<p align='center'>CANDIDATES TAKING OUT PAPERS</p>");
}

foreach($cands as $x) {
    $cand_div = get_temp_panel($x);
    echo($cand_div);
}

function populate_temp_cands($fourcode) {
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb_e18_temp_cands WHERE dist = '$fourcode' && status != '0'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }
    return $retval;
}



function get_temp_panel($x) {
	global $role, $fourcode;
    $text = $x['text'];
    $party = $x['party'];
    $name = $x['name'];
    $img_id = $x['img_id'];

    
    if (!$text) {
        $text = $name;
    }

    $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
    foreach ($suffix as $s) {
        if (file_exists('img/candidates/' . $img_id . $s)) {
            $add_img = "<img src=\"/img/candidates/" . $img_id . $s . "\" width='150px' style='border-radius: 10px; float: top; margin-bottom: 5px;'/>";
            break;
        } else {
            $add_img = "<img src=\"/img/candidates/NO_IMAGE.jpg\" width='150px' style='border-radius: 10px; float: top; margin-bottom: 5px;'/>";
        }
    }

    if($role == "admin") {
	   $add_img = "<div>$add_img<div style='z-index: 99; margin-top: -10px;'><a href='http://198.74.49.22/img_uploader.php?id=" . $img_id . "' target='_blank'><img src='/img/edit_btn.png' height='15px' width='15px'></a></div></div>";
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
			$edit_btn = "<span><a href='http://198.74.49.22/tmp_cand_editor.php?id=" . $fourcode . "&cand_id=" . $img_id . "' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
		} else {
			$edit_btn = "<span><a href='http://198.74.49.22/tmp_cand_editor.php?id=" . $fourcode . "&cand_id=" . $img_id . "' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";		
		}
	} else {
		$edit_btn = '';
	}


    $cand_div = "<div class='row' style='margin-top: 10px;'> <!--BEGIN CANDIDATE DIV -->
					<div class='panel'> <!--BEGIN CANDIDATE PANEL -->

						<div class='col-lg-12 fn candidate-content'> <!--BEGIN CANDIDATE CONTENT -->

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

?>
