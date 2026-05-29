<?php

Util::require_ctb_api();
//require_once('php/ctb_api.php');

set_time_limit(0);
ini_set('max_execution_time', 180); //3 minutes

$q = $_REQUEST['q'];
//$q = str_replace("+", " ", $q);

//echo("\nLooking up $q");

if($q !== "") {
	if(strlen($q) > 3) {
		populate($q);
	}
}

function populate($q) {
 	$conn = Util::get_ctb_conn();
 	//global $master_conn;
 	//$conn = $master_conn;
 	$conn -> set_charset("utf8");
 	$search_term = $q;
 	$arr = explode(" ", $q);
 	$kw = '';

 	foreach($arr as $w) {
 		$w = trim($w);
 		if(strlen($w) > 1) {
 			$kw .= "+\"$w\" ";
 		}
 	}

 	$keyword = $kw;
	$keyword = $q;

	$sql = "SELECT table_name, cand_id, post_id, analysis_id, text, MAX(id) AS max_id, dist, year, logged
				FROM (
				  SELECT 'ctb_cand_bios' AS table_name, cand_id, NULL AS post_id, NULL AS analysis_id, ctb_cand_bios.text, ctb_cand_bios.id, NULL as dist, NULL as year, date AS logged 
				  FROM ctb_cand_bios
				  WHERE MATCH(ctb_cand_bios.text) AGAINST (\"'$keyword'\" IN BOOLEAN MODE)
				  UNION ALL
				  SELECT 'ctb_hot_sheet' AS table_name, NULL AS cand_id, post_id, NULL AS analysis_id, ctb_hot_sheet.text, ctb_hot_sheet.id, NULL AS dist, NULL as year, updated AS logged 
				  FROM ctb_hot_sheet
				  WHERE MATCH(ctb_hot_sheet.text) AGAINST (\"'$keyword'\" IN BOOLEAN MODE)
				  UNION ALL
				  SELECT 'ctb_analysis' AS table_name, NULL AS cand_id, NULL AS post_id, CONCAT_WS('-', dist, year) AS analysis_id, ctb_analysis.text, ctb_analysis.id, dist, year, date AS logged 
				  FROM ctb_analysis
				  WHERE MATCH(ctb_analysis.text) AGAINST (\"'$keyword'\" IN BOOLEAN MODE)
				  UNION ALL
				  SELECT 'tcontent' AS table_name, lastUpdateBy AS cand_id, LEFT(lastUpdate, 7) as post_id, Title AS analysis_id, tcontent.Body AS text, TContent_ID AS id, Title AS dist, NULL as year, lastUpdate AS logged
				  FROM tcontent
				  WHERE MATCH(tcontent.Body) AGAINST (\"'$keyword'\" IN BOOLEAN MODE)
				  LIMIT 2000
				) AS all_entries
				GROUP BY table_name, cand_id, post_id, analysis_id
				ORDER BY logged DESC, max_id DESC;

			";
	$result = $conn->query($sql);
	//echo("$sql\n");

	if($result->num_rows > 0) {
		$i = 0;
		
		while($row = $result->fetch_assoc()) {
			$text = strip_tags($row['text']);


			$search_position = stripos($text, $q);

			if ($search_position !== false) {
			    $context_start = max(0, $search_position - 100);
			    $context_end = min(strlen($text), $search_position + strlen($search_term) + 100);
			    $matched_result = substr($text, $context_start, $context_end - $context_start);

			    // Highlight the matched result in red
			    $matched_result = str_ireplace($search_term, '<span style="color: red;"><b>' . strtoupper($search_term) . '</b></span>', $matched_result);

			    $context = $matched_result;
			} else {
			    // No match found
			    $context = FALSE;
			    continue;
			}
			$i++;
			switch($row['table_name']) {
				case "ctb_cand_bios":
					$header = "CANDIDATE - <a href='https://californiatargetbook.com/book/candidate/" . $row['cand_id'] . "' target='_blank'>" . $row['cand_id'] . "</a> - " . $row['logged'];
					$context = str_ireplace($search_term, '<span style="color: red;"><b>' . strtoupper($search_term) . '</b></span>', $text);
					break;
				case "ctb_hot_sheet":
					$header = "HOT SHEET - <a href='https://californiatargetbook.com/book/hotsheet/" . $row['post_id'] . "' target='_blank'>" . $row['logged'] . "</a>";
					break;
				case "ctb_analysis":
					$dist = $row['dist'];
					if($row['year'] < 2022) {
						$use = "old";
					} else {
						$use = "new";
					}
					if(strlen($dist) == 4 && mb_substr($dist, 0, 2) == "CA") {
						$dist = "CD" . mb_substr($row['dist'], 2, 2);
					}

					$header = "ANALYSIS - " . "<a href='https://californiatargetbook.com/book/$use/" . $dist . "' target='_blank'>" . $dist . "-" . $row['year'] . "</a> - " . $row['logged'];
					if(mb_substr($dist, 0,1) == "1" || mb_substr($dist, 0, 1) == "2") {
						$header = "ANALYSIS - " . "<a href='https://californiatargetbook.com/book/propositions/" . $dist . "' target='_blank'>" . $dist . "-" . $row['year'] . "</a> - " . $row['logged'];
					}
					if(mb_substr($dist, 0, 4) == "RECA") {
						$header = "ANALYSIS - " . "<a href='https://californiatargetbook.com/book/newsom_recall' target='_blank'>2021 Gavin Newsom Recall</a>";

					}
					break;
				case "tcontent":
					$author = $row['cand_id'];
					$post_id = $row['post_id'];
					$header = "LEGACY SITE - <a href='https://californiatargetbook.com/ctb-legacy/ctb_get_legacy.php?id=" . $row['max_id'] . "' target='_blank'>" . $row['dist'] . "</a> - Updated by " . $row['cand_id'] . " on " . $row['logged'];
					break;
			}
			$results[$i] = $row;
			//$results[$i]['context'] = $row['context'];
			//$results[$i]['id'] = $row['id'];
			$results[$i]['context'] = $context;
			$results[$i]['header'] = $header;
			$results[$i]['table_id']  = $row['max_id'];
			$results[$i]['id'] = $i;
			if($context == FALSE) {
				unset($results[$i]);
			}


		}
	}
	//echo("$sql\n");
	//var_dump($results);
	$json = json_encode($results);
	//echo($json);
	header('Content-type: application/json');
	echo($json);

}

?>
