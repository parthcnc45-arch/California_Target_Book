<?php

global $vote_table_stored;

?>

<div class='container-fluid'>

    <div class='row'>
        <div class='col-xs-12'>
          <div class="panel">
              <?php

              global $fourcode;
              $x = draw_fec_vote_table($fourcode);

              echo($x['full']);

              $vote_table_stored['g12'] = $x['g12'];
              $vote_table_stored['g14'] = $x['g14'];
              $vote_table_stored['g16'] = $x['g16'];
	      $vote_table_stored['g18'] = $x['g18'];

              ?>

          </div>
        </div>
    </div>

    <div class='row'>
        <div class='col-xs-12' align='center'>
          <div class="panel">

            <h3>MAP</h3>
            <div class='iframe-container' align='center' style='margin-left: auto; margin-right: auto;'>
              <iframe src='/book/drawcd.php?id=<?= $fourcode ?>' width='800' height='600' align='center'></iframe>
            </div>
          </div>
        </div>

    </div>


</div>

<?php

function draw_fec_vote_table($fourcode)
{

    global $house_g12_table;
    global $house_g14_table;
    global $house_g16_table;
    global $house_g18_table;


    $x = getpres_results($fourcode);


    $hrc = number_format($x['CLINTON'], 1);
    $djt = number_format($x['TRUMP'], 1);
    $bho = number_format($x['OBAMA'], 1);
    $wmr = number_format($x['ROMNEY'], 1);

    $g18 = get_house_results($fourcode, '2018');
    $g16 = get_house_results($fourcode, '2016');
    $g14 = get_house_results($fourcode, '2014');
    $g12 = get_house_results($fourcode, '2012');

    $house_g12_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>House 2012</th>
							</tr>
						</thead>
						<tbody>";

    $house_g14_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>House 2014</th>
							</tr>
						</thead>
						<tbody>";


    $house_g16_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>House 2016</th>
							</tr>
						</thead>
						<tbody>";

    $house_g18_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>House 2018</th>
							</tr>
						</thead>
						<tbody>";


    $stored_g12_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='3'>House 2012</th>
							</tr>
						</thead>
						<tbody>";

    $stored_g14_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='3'>House 2014</th>
							</tr>
						</thead>
						<tbody>";


    $stored_g16_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='3'>House 2016</th>
							</tr>
						</thead>
						<tbody>";

    $stored_g18_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='3'>House 2018</th>
							</tr>
						</thead>
						<tbody>";



    $pres_g12_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>President 2012</th>
							</tr>
						</thead>
						<tbody>";

    $pres_g16_head = "<table class='bordered table table-sm table-responsive' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<thead>
							<tr>
								<th colspan='2'>President 2016</th>
							</tr>
						</thead>
						<tbody>";

    $table_end = "</tbody>
			</table>";

    if ($hrc > $djt) {
        $g16_pres_column = "<td id='blueColumn'><span class='winner'>Hillary Clinton (D)</span>
																<br>Donald Trump (R)</td>";
        $g16_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $hrc . "%</span><br>" . $djt . "%</td>";
    } else {
        $g16_pres_column = "<td id='blueColumn'><span class='winner'>Donald Trump (R)</span>
																<br>Hillary Clinton (D)</td>";
        $g16_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $djt . "%</span><br>" . $hrc . "%</td>";
    }


    if ($bho > $wmr) {
        $g12_pres_column = "<td id='blueColumn'><span class='winner'>Barack Obama (D-Inc)</span>
																<br>Mitt Romney (R)</td>";
        $g12_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $bho . "%</span><br>" . $wmr . "%</td>";
    } else {
        $g12_pres_column = "<td id='blueColumn'><span class='winner'>Mitt Romney (R)</span>
																<br>Barack Obama (D-Inc)</td>";
        $g12_pres_pct_column = "<td id='greyColumn'><span class='winner'>" . $wmr . "%</span><br>" . $bho . "%</td>";
    }

    $pres_table .= $g12_pres_column . $g12_pres_pct_column . $g16_pres_column . $g16_pres_pct_column . "</tr></tbody></table>";

    $pres_g12_table = $pres_g12_head . $g12_pres_column . $g12_pres_pct_column . "</tr>" . $table_end;
    $pres_g16_table = $pres_g16_head . $g16_pres_column . $g16_pres_pct_column . "</tr>" . $table_end;


    $g12_cand_column = "<td id='blueColumn'>";
    $g12_pct_column = "<td align='right' id='greyColumn'>";
    $g12_vote_column = "<td align='right' id='greyColumn'>";


    $g14_cand_column = "<td id='blueColumn'>";
    $g14_pct_column = "<td align='right' id='greyColumn'>";
    $g14_vote_column = "<td align='right' id='greyColumn'>";


    $g16_cand_column = "<td id='blueColumn'>";
    $g16_pct_column = "<td align='right' id='greyColumn'>";
    $g16_vote_column = "<td align='right' id='greyColumn'>";


    $g18_cand_column = "<td id='blueColumn'>";
    $g18_pct_column = "<td align='right' id='greyColumn'>";
    $g18_vote_column = "<td align='right' id='greyColumn'>";


    foreach ($g12 as $e) {
        $g12_total += $e['VOTES'];
    }

    foreach ($g14 as $e) {
        $g14_total += $e['VOTES'];
    }

    foreach ($g16 as $e) {
        $g16_total += $e['VOTES'];
    }

    foreach ($g18 as $e) {
        $g18_total += $e['VOTES'];
    }


    $i = 0;
    foreach ($g12 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g12_total);


        if ($i > 0) {
            $g12_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g12_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g12_pct_column .= "<br>$this_pct";
        } else {
            $g12_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        if ($i > 0) {
            $g12_vote_column .= "<br>" . number_format($e['VOTES']);
        } else {
            $g12_vote_column .= number_format($e['VOTES']);
        }

        $i++;
    }

    $i = 0;
    foreach ($g14 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g14_total);


        if ($i > 0) {
            $g14_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g14_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g14_pct_column .= "<br>$this_pct";
        } else {
            $g14_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        if ($i > 0) {
            $g14_vote_column .= "<br>" . number_format($e['VOTES']);
        } else {
            $g14_vote_column .= number_format($e['VOTES']);
        }

        $i++;
    }

    $i = 0;
    foreach ($g16 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g16_total);


        if ($i > 0) {
            $g16_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g16_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g16_pct_column .= "<br>$this_pct";
        } else {
            $g16_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        if ($i > 0) {
            $g16_vote_column .= "<br>" . number_format($e['VOTES']);
        } else {
            $g16_vote_column .= number_format($e['VOTES']);
        }

        $i++;
    }


    $i = 0;
    foreach ($g18 as $e) {

        $party = '';
        if ($e['NAMF']) {
            $candidate = $e['NAMF'] . " " . $e['NAML'];
        } else {
            $candidate = $e['NAML'];
        }

        if ($e['PARTY']) {
            $party = $e['PARTY'];
        }

        if ($e['INC']) {
            $party = $party . "-Inc";
            $cand_class = 'itcme';
        } else {
            $cand_class = '';
        }

        if ($party) {
            $party = " ($party)";
        }


        $this_pct = makepct($e['VOTES'], $g18_total);


        if ($i > 0) {
            $g18_cand_column .= "<br><span class='$cand_class'>" . $candidate . "</span>" . $party;
        } else {
            $g18_cand_column .= "<span class='winner $cand_class'>" . $candidate . $party . "</span>";
        }

        if ($i > 0) {
            $g18_pct_column .= "<br>$this_pct";
        } else {
            $g18_pct_column .= "<span class='winner $cand_class'>" . $this_pct . "</span>";
        }

        if ($i > 0) {
            $g18_vote_column .= "<br>" . number_format($e['VOTES']);
        } else {
            $g18_vote_column .= number_format($e['VOTES']);
        }

        $i++;
    }


    $house_g12_table = $house_g12_head . $g12_cand_column . $g12_pct_column . "</tr>" . $table_end;
    $house_g14_table = $house_g14_head . $g14_cand_column . $g14_pct_column . "</tr>" . $table_end;
    $house_g16_table = $house_g16_head . $g16_cand_column . $g16_pct_column . "</tr>" . $table_end;
    $house_g18_table = $house_g18_head . $g18_cand_column . $g18_pct_column . "</tr>" . $table_end;


    $stored_g12 = $stored_g12_head . $g12_cand_column . $g12_vote_column . $g12_pct_column . "</tr>" . $table_end;
    $stored_g14 = $stored_g14_head . $g14_cand_column . $g14_vote_column . $g14_pct_column . "</tr>" . $table_end;
    $stored_g16 = $stored_g16_head . $g16_cand_column . $g16_vote_column . $g16_pct_column . "</tr>" . $table_end;
    $stored_g18 = $stored_g18_head . $g18_cand_column . $g18_vote_column . $g18_pct_column . "</tr>" . $table_end;
 
    $full = "<div class='row'>
				<div class='col-sm-6 col-md-4'>
					$pres_g12_table
				</div>
				<div class='col-sm-6 col-md-4'>
					$pres_g16_table
				</div>

				<div class='col-sm-6 col-md-4'>
					$house_g12_table
				</div>
				<div class='col-sm-6 col-md-4'>
					$house_g14_table
				</div>
				<div class='col-sm-6 col-md-4'>
					$house_g16_table
				</div>
				<div class='col-sm-6 col-md-4'>
					$house_g18_table
				</div>

			</div>";

    $retval['full'] = $full;
    $retval['g12'] = $stored_g12;
    $retval['g14'] = $stored_g14;
    $retval['g16'] = $stored_g16;
    $retval['g18'] = $stored_g18;



    return $retval;

}

function get_house_results($fourcode, $year)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM nufec_election_results WHERE YEAR = $year && FOURCODE = '$fourcode' ORDER BY VOTES DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }

    return $retval;
}


function getpres_results($fourcode)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    return $retval;
}


function get_location_text($id)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();

    if (mb_substr($id, 0, 2) == "CD") {
        $id = "CA" . mb_substr($id, 2, 2);
    }
    $sql = "SELECT text FROM ctb_dist_loc WHERE dist = '$id' ORDER BY DATE DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}


function makeplainpercent($portion, $total)
{
    $x = ($portion / $total) * 100;

    return $x;
}


?>
