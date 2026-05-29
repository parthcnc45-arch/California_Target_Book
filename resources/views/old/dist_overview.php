<?php
global $lookup, $cached;
$lookup = Array();

?>
<div>

    <div class="">

        <div class='row'>
            <div class="col-md-12">
                <div class="panel row vote-tables">
                    <?= get_vote_tables($cached['fourcode']); ?>
                </div>
            </div>

        </div>

        <?php
            $map_link = getmaplink($cached['fourcode']);
            $loc_text = get_location_text($cached['fourcode']);
            $overlaps = $cached['overlaps']??'';

            if (!empty($map_link)):
        ?>
        <div class='row'>
            <div class="col-md-12">
                <div class="panel row">
                    <div class='col-lg-6'>
                        <h3>Map</h3>
                        <div class='iframe-container'>
                            <iframe src="<?= $map_link ?>" width='640' height='480'></iframe>
                        </div>
                    </div>
                    <div class='col-lg-6'>
                        <div class="row">
                            <?php if (!empty($loc_text)): ?>
                            <div class="col-lg-12">
                                <h3>Location</h3>
                                <?= $loc_text ?>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($overlaps)): ?>
                            <div class="col-lg-12 overlaps">
                                <h3>Overlaps</h3>
                                <?= $overlaps ?>
                            </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel row">

                    <h3>Registration</h3>
		    <a href='/ctb-legacy/sos_reg_graph?id=<?php echo($cached['fourcode']) ?>' target='_blank'>View Registration History Report</a>

                    <?= drawreg($cached['fourcode']) ?>
                    <?php include(Util::$view_root.'dist_electorate.php') ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php


function votesort($a, $b)
{

    if ($a['votes'] < $b['votes']) {
        return 1;
    } elseif ($a['votes'] > $b['votes']) {
        return -1;
    } else {
        return 0;
    }
}

function get_location_text($id)
{
    $conn = Util::get_ctb_conn();

    if (mb_substr($id, 0, 2) == "CD") {
        $id = "CA" . mb_substr($id, 2, 2);
    }
    $sql = "SELECT text FROM ctb_dist_loc WHERE dist = '$id' ORDER BY DATE DESC LIMIT 1";
    $result = $conn->query($sql);
    $retval=[];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function getmaplink($fourcode)
{
    $conn = Util::get_ctb_conn();
    $sql = "SELECT URL FROM ctb2016_gmaps WHERE FOURCODE = '$fourcode'";
    $result = $conn->query($sql);
    $retval=[];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['URL'];
        }
    }

    return $retval;
}

function get_contains($id)
{

    global $fourcode;

    $tmp = getdisttype($id);
    $qdist = $tmp['disttype'];
    $dist = $tmp['distno'];
    $x = (parseoffices($qdist, $dist, "g12"));  //USING G12 AS IT'S THE MOST COMPLETE DATASET




    $endcounty = '';
    foreach ($x as $value) {
        $y = mb_substr($value, 0, 6);
        $z = substr($value, -2);

        $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

        if ($y == "county") {
            $v = getcountyname($z);
            $cl = "<a href='" . getcountylink($z) . "'>" . $v . "</a>";
            if ($subdpct != 0) {
                $endcounty .= "$cl County ($subdpct) ";
            }
        }
    }


    $endassembly = '';
    foreach ($x as $value) {
        $y = mb_substr($value, 0, 6);
        $z = checkaddzero(substr($value, -2));
        $thisfourcode = makefour($y, $z);
        $final = getctblink($thisfourcode) . $thisfourcode . "</a>";
        $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);
        if ($y == "addist") {
            if ($subdpct != 0 && $thisfourcode != $fourcode) {
                $endassembly .= "$final ($subdpct) ";
            }
        }
    }

    $endsenate = '';
    foreach ($x as $value) {
        $y = mb_substr($value, 0, 6);
        $z = checkaddzero(substr($value, -2));
        $thisfourcode = makefour($y, $z);
        $final = getctblink($thisfourcode) . $thisfourcode . "</a>";
        $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);
        if ($y == "sddist") {
            if ($subdpct != 0 && $thisfourcode != $fourcode) {
                $endsenate .= "$final ($subdpct) ";
            }
        }
    }

    $endhouse = '';
    foreach ($x as $value) {
        $y = mb_substr($value, 0, 6);
        $z = checkaddzero(substr($value, -2));
        $thisfourcode = makefour($y, $z);
        $final = getctblink($thisfourcode) . $thisfourcode . "</a>";
        $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);
        if ($y == "cddist") {
            if ($subdpct != 0 && $thisfourcode != $fourcode) {
                $endhouse .= "$final ($subdpct) ";
            }
        }
    }


    $endboe = '';
    foreach ($x as $value) {
        $y = mb_substr($value, 0, 6);
        $z = checkaddzero(substr($value, -2));
        $thisfourcode = makefour($y, $z);
        $final = getctblink($thisfourcode) . $thisfourcode . "</a>";
        $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);
        if ($y == "bedist") {
            if ($subdpct != 0 && $thisfourcode != $fourcode) {
                $endboe .= "$final ($subdpct) ";
            }
        }
    }


    return "<p>$endcounty</p><p>$endassembly</p><p>$endsenate</p><p>$endhouse</p></p>$endboe</p>";
}

function get_vote_tables($id)
{
    //    global $lookup;
    global $cached;
    if(mb_substr($id, 0, 1) != "." && mb_substr($id, 0, 3) != "BOE") {
	echo($cached['vote_table']??'');
	$null = '';
	return $null;
   }

    $x = getdisttype($id);

    $disttype = $x['disttype'];
    $distno = $x['distno'];


    $type = mb_substr($id, 0, 2);
    //
    //    get_pres_headers();
    //    get_gov_headers();
    //    get_uss_headers();
    //
    //
    //    switch ($type) {
    //        case "AD":
    //            get_assembly_headers();
    //            break;
    //        case "SD":
    //            get_senate_headers();
    //            break;
    //        case "CD":
    //            get_house_headers();
    //            break;
    //    }

    $lookup = \Cache::rememberForever("ctb.$id.votelookup", function () use($disttype, $distno) {
        return headers($disttype, $distno);
    });
    $totals = \Cache::rememberForever("ctb.$id.votehistory", function () use (&$lookup, $disttype, $distno) {

        $totals = Array();

        foreach ($lookup as $election => $office) {
            if (!array_key_exists($election, $totals)) {
                $totals[$election] = Array();
            }

            foreach ($office as $k => $cand) {
                $this_race = $k;
                if (!array_key_exists($this_race, $totals[$election])) {
                    $totals[$election][$this_race] = 0;
                }

                foreach ($cand as $key => $x) {
                    $distkey = $x['distkey'];


                    try {
                        \CTBDB::table("ctb2016_$election")
                            ->select(\DB::raw("SUM($distkey) AS votes"))
                            ->when(!empty($disttype), function ($q) use ($disttype, $distno) {
                                return $q->where($disttype, $distno);
                            })
                            ->get()
                            ->each(function($row) use(&$totals, &$lookup, $election, $this_race, $key) {
                                $lookup[$election][$this_race][$key]['votes'] = (int) $row->votes;
                                $totals[$election][$this_race] += (int) $row->votes;
                            });

                    } catch (Exception $e) { /* sum column not found, so skip */ }

                    // try {
                    //     $stmt = Util::get_ctb_pdo()->prepare("
                    //         SELECT SUM(" . $x['distkey'] . ") AS VOTES FROM ctb2016_" . $election . " WHERE $disttype = $distno
                    //     ");

                    //     if ($stmt->execute()) {
                    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //             $lookup[$election][$this_race][$key]['votes'] = $row['VOTES'];
                    //             $totals[$election][$this_race] += $row['VOTES'];

                    //         }
                    //     }
                    // } catch (Exception $e) {
                    //     /* sum column not found, so skip */
                    // }
                }
            }
        }

        return $totals;
    });


    foreach ($lookup as $election => $office) {
        foreach ($office as $k => $cand) {
            $this_race = $k;
            try {
                uasort($cand, 'votesort');
            } catch (Exception $e) {
                continue;
            }

            $i = 0;
            $tablebody = '';
            foreach ($cand as $key => $x) {
                if ($i > 1) {
                    continue;
                }

                $winnerClass = '';
                if ($i === 0) { // first iteration
                    // first is winner because the candidates were sorted
                    $winnerParty = strtolower($x['party']);
                    $winnerClass = $winnerParty;
                    $x['is_winner'] = true;
                }

                $inc_append = '';
                if ($x['is_incumbent']) {
                    $inc_append = "-Inc";
                }

                $tablebody .= "<tr>
									<td class='$winnerClass'>" . $x['name'] . " (" . $x['party'] . $inc_append . ")</td>
									<td class='greyColumn' align='right'>" . number_format($x['votes']) . "</td>
									<td class='greyColumn'>" . number_format((($x['votes'] / $totals[$election][$this_race]) * 100), 2) . "%</td>
								</tr>";
                $i++;
            }

            $tablehead = "<div class='col-lg-4 col-md-6 col-sm-6'>
                    <table id='voteTable' class='table table-sm table-responsive $winnerParty-table' style='font-size: 0.75em;'>
                        <thead class='thead-inverse'>
                            <tr>
                                <th colspan='3' style='text-align: center;'>" . $this_race . " - $election</th>
                            </tr>
                        </thead>
                        <tbody>";


            echo($tablehead . $tablebody . "</tbody></table></div>");
        }
    }

    //var_dump($lookup);

}


function headers($disttype, $distnum)
{
    $lookup = [];

    $race_types = [
        'PRS' => 'President', // president
        'GOV' => 'Governor', // Governor
        'USS' => 'US Senate', // US senate
        'ASS' => 'Assembly District', // Assembly
        'CNG' => 'Congressional District', // Congressional districts
        'SEN' => 'Senate District', // Senate districts
    ];

    \CTBDB::table('ctb_ca_candidates')
        ->whereNotNull('distkey')
        ->whereIn('election', ['g12', 'g14', 'g16'])
        ->where(function ($query) use ($disttype, $distnum) {
            return $query
                ->when(empty($disttype), function ($q) {
                    return $q->whereNull('disttype');
                }, function ($q) use ($disttype, $distnum) {
                    return $q->whereNull('distnum')
                        ->orWhere([
                            ['disttype', $disttype],
                            ['distnum', $distnum],
                        ]);
                });
        })
        ->orderBy('election')
        ->get()
        ->each(function ($row) use (&$lookup, &$race_types) {

            $race = $race_types[ substr($row->race, 0, 3) ];

            if (empty($race)) return;

            $election = $row->election;

            if (empty($lookup[$election])) $lookup[$election] = [];
            if (empty($lookup[$election][$race])) $lookup[$election][$race] = [];

            array_push($lookup[$election][$race], (array) $row);
        });


    // $stmt = Util::get_ctb_pdo()->prepare("
    //   SELECT * FROM `ctb_ca_candidates`
    //   WHERE (election = 'g12' || election = 'g14' || election = 'g16')
    // ");

    // $lookup = [];

    // if ($stmt->execute()) {
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $race_types = [
    //             'PRS' => 'President', // president
    //             'GOV' => 'Governor', // Governor
    //             'USS' => 'US Senate', // US senate
    //             'ASS' => 'Assembly Districts', // Assembly
    //             'CNG' => 'Congressional Districts', // Congressional districts
    //             'SEN' => 'Senate Districts', // Senate districts
    //         ];

    //         foreach (array_keys($race_types) as $r) {
    //             if (strpos($row['race'], $r) === 0) {
    //                 $race = $race_types[$r];
    //                 break;
    //             }
    //         }
    //         if (!isset($race)) continue;

    //         $election = $row['election'];

    //         if (empty($lookup[$election])) $lookup[$election] = [];
    //         if (empty($lookup[$election][$race])) $lookup[$election][$race] = [];

    //         array_push($lookup[$election][$race], $row);
    //     }
    // }




    return $lookup;
}

function drawreg()
{
    global $fourcode;

    $conn = Util::get_ctb_pdo();
    $stmt = $conn->prepare(
        "SELECT * FROM ctb2016_sos_all WHERE DIST = :fourcode ORDER BY RPT_DATE DESC LIMIT 1"
    );
    $stmt->execute(['fourcode' => $fourcode]);
    $row = $stmt->fetch();

    $dem = $row['DEM']??1;
    $rep = $row['REP']??1;
    $npp = $row['NPP']??1;
    $tot = $row['TOT']??1;
    $oth = $row['OTH']??1;

    $rpt_date = nicedate($row['RPT_DATE']??'');

    $dem_pct = makeplainpercent($dem, $tot);
    $rep_pct = makeplainpercent($rep, $tot);

    $dem_pct_draw = makepct($dem, $tot);
    $rep_pct_draw = makepct($rep, $tot);
    $npp_pct_draw = makepct($npp, $tot);
    $oth_pct_draw = makepct($oth, $tot);
    $advantage='';
    if ($dem_pct > $rep_pct) {
        $advantage = "<span class='blueme boldme'>D +" . number_format(($dem_pct - $rep_pct), 2) . "%</span>";
    }

    if ($rep_pct > $dem_pct) {
        $advantage = "<span class='redme boldme'>R +" . number_format(($rep_pct - $dem_pct), 2) . "%</span>";
    }

    $drawme = "<p class='boldme' align='center'>REGISTRATION REPORT DATE: $rpt_date<br>TOTAL VOTERS: " . number_format($tot) . "</p>
	<p align='center'>$advantage</p>
	<p align='center'><span class='blueme boldme'>DEM: $dem_pct_draw (" . number_format($dem) . ")</span>
	    &nbsp;--&nbsp;<span class='redme boldme'>REP: $rep_pct_draw (" . number_format($rep) . ")</span>
	    &nbsp;--&nbsp;NPP: $npp_pct_draw (" . number_format($npp) . ") -- OTH: $oth_pct_draw (" . number_format($oth) . ")
	</p>";

    //echo("<br>DRAWING: <br>$drawme");

    return $drawme;

}

function makeplainpercent($portion, $total)
{
    return ($portion / $total) * 100;
}

function nicedate($str) {
	$year = mb_substr($str, 0, 4);
	$month = mb_substr($str, 5, 2);
	$day   = mb_substr($str, 8, 2);
	$m   = '';

	switch($month) {
		case "01":
			$m = "January";
			break;
		case "02":
			$m = "February";
			break;
		case "03":
			$m = "March";
			break;
		case "04":
			$m = "April";
			break;
		case "05":
			$m = "May";
			break;
		case "06":
			$m = "June";
			break;
		case "07":
			$m = "July";
			break;
		case "08":
			$m = "August";
			break;
		case "09":
			$m = "September";
			break;
		case "10":
			$m = "October";
			break;
		case "11":
			$m = "November";
			break;
		case "12":
			$m = "December";
			break;

	}
	$retval = $m . " " . $day . ", " . $year;
	return $retval;

}


?>
