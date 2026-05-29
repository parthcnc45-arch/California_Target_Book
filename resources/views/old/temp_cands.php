<?php

Util::require_ctb_api();

$cands = populate_temp_cands($fourcode, $year);
$tmp_cand_divs[$year] = '';

if($cands) {  
    foreach($cands as $x) {
        $cand_div = get_temp_panel($x);
        $tmp_cand_divs[$year] .= $cand_div;
    }
}


?>
