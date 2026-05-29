<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//Util::require_ctb_api();;

Util::set_errors();

$links = get_links($id);

// page type
$prev_type = $links['prev'];
$next_type = $links['next'];

$prev_code = $links['prev_code'];
$next_code = $links['next_code'];

$old_fourcodes = get_old_fourcode_index();
$old_fourcode = $old_fourcodes['new'][$id];
$new_fourcode = $old_fourcodes['old'][$id];
//echo("<br>OLD FOURCODE: $old_fourcode<br>");
$incumbent = get_incumbent($old_fourcode);

$is_open = is_open_fed($id);
$is_targeted = is_targeted_fed($id);


function get_links($fourcode)
{
    $x = Array(
        "AD01",
        "AD02",
        "AD03",
        "AD04",
        "AD05",
        "AD06",
        "AD07",
        "AD08",
        "AD09",
        "AD10",
        "AD11",
        "AD12",
        "AD13",
        "AD14",
        "AD15",
        "AD16",
        "AD17",
        "AD18",
        "AD19",
        "AD20",
        "AD21",
        "AD22",
        "AD23",
        "AD24",
        "AD25",
        "AD26",
        "AD27",
        "AD28",
        "AD29",
        "AD30",
        "AD31",
        "AD32",
        "AD33",
        "AD34",
        "AD35",
        "AD36",
        "AD37",
        "AD38",
        "AD39",
        "AD40",
        "AD41",
        "AD42",
        "AD43",
        "AD44",
        "AD45",
        "AD46",
        "AD47",
        "AD48",
        "AD49",
        "AD50",
        "AD51",
        "AD52",
        "AD53",
        "AD54",
        "AD55",
        "AD56",
        "AD57",
        "AD58",
        "AD59",
        "AD60",
        "AD61",
        "AD62",
        "AD63",
        "AD64",
        "AD65",
        "AD66",
        "AD67",
        "AD68",
        "AD69",
        "AD70",
        "AD71",
        "AD72",
        "AD73",
        "AD74",
        "AD75",
        "AD76",
        "AD77",
        "AD78",
        "AD79",
        "AD80",
        "SD01",
        "SD02",
        "SD03",
        "SD04",
        "SD05",
        "SD06",
        "SD07",
        "SD08",
        "SD09",
        "SD10",
        "SD11",
        "SD12",
        "SD13",
        "SD14",
        "SD15",
        "SD16",
        "SD17",
        "SD18",
        "SD19",
        "SD20",
        "SD21",
        "SD22",
        "SD23",
        "SD24",
        "SD25",
        "SD26",
        "SD27",
        "SD28",
        "SD29",
        "SD30",
        "SD31",
        "SD32",
        "SD33",
        "SD34",
        "SD35",
        "SD36",
        "SD37",
        "SD38",
        "SD39",
        "SD40",
        "CD01",
        "CD02",
        "CD03",
        "CD04",
        "CD05",
        "CD06",
        "CD07",
        "CD08",
        "CD09",
        "CD10",
        "CD11",
        "CD12",
        "CD13",
        "CD14",
        "CD15",
        "CD16",
        "CD17",
        "CD18",
        "CD19",
        "CD20",
        "CD21",
        "CD22",
        "CD23",
        "CD24",
        "CD25",
        "CD26",
        "CD27",
        "CD28",
        "CD29",
        "CD30",
        "CD31",
        "CD32",
        "CD33",
        "CD34",
        "CD35",
        "CD36",
        "CD37",
        "CD38",
        "CD39",
        "CD40",
        "CD41",
        "CD42",
        "CD43",
        "CD44",
        "CD45",
        "CD46",
        "CD47",
        "CD48",
        "CD49",
        "CD50",
        "CD51",
        "CD52",
        "CD53",
        "BOE1",
        "BOE2",
        "BOE3",
        "BOE4",
        "ALAMEDA",
        "ALPINE",
        "AMADOR",
        "BUTTE",
        "CALAVERAS",
        "COLUSA",
        "CONTRA COSTA",
        "DEL NORTE",
        "EL DORADO",
        "FRESNO",
        "GLENN",
        "HUMBOLDT",
        "IMPERIAL",
        "INYO",
        "KERN",
        "KINGS",
        "LAKE",
        "LASSEN",
        "LOS ANGELES",
        "MADERA",
        "MARIN",
        "MARIPOSA",
        "MENDOCINO",
        "MERCED",
        "MODOC",
        "MONO",
        "MONTEREY",
        "NAPA",
        "NEVADA",
        "ORANGE",
        "PLACER",
        "PLUMAS",
        "RIVERSIDE",
        "SACRAMENTO",
        "SAN BENITO",
        "SAN BERNARDINO",
        "SAN DIEGO",
        "SAN FRANCISCO",
        "SAN JOAQUIN",
        "SAN LUIS OBISPO",
        "SAN MATEO",
        "SANTA BARBARA",
        "SANTA CLARA",
        "SANTA CRUZ",
        "SHASTA",
        "SIERRA",
        "SISKIYOU",
        "SOLANO",
        "SONOMA",
        "STANISLAUS",
        "SUTTER",
        "TEHAMA",
        "TRINITY",
        "TULARE",
        "TUOLUMNE",
        "VENTURA",
        "YOLO",
        "YUBA",
        "AK00",
        "AL01",
        "AL02",
        "AL03",
        "AL04",
        "AL05",
        "AL06",
        "AL07",
        "AR01",
        "AR02",
        "AR03",
        "AR04",
        "AZ01",
        "AZ02",
        "AZ03",
        "AZ04",
        "AZ05",
        "AZ06",
        "AZ07",
        "AZ08",
        "AZ09",
        "CA01",
        "CA02",
        "CA03",
        "CA04",
        "CA05",
        "CA06",
        "CA07",
        "CA08",
        "CA09",
        "CA10",
        "CA11",
        "CA12",
        "CA13",
        "CA14",
        "CA15",
        "CA16",
        "CA17",
        "CA18",
        "CA19",
        "CA20",
        "CA21",
        "CA22",
        "CA23",
        "CA24",
        "CA25",
        "CA26",
        "CA27",
        "CA28",
        "CA29",
        "CA30",
        "CA31",
        "CA32",
        "CA33",
        "CA34",
        "CA35",
        "CA36",
        "CA37",
        "CA38",
        "CA39",
        "CA40",
        "CA41",
        "CA42",
        "CA43",
        "CA44",
        "CA45",
        "CA46",
        "CA47",
        "CA48",
        "CA49",
        "CA50",
        "CA51",
        "CA52",
        "CA53",
        "CO01",
        "CO02",
        "CO03",
        "CO04",
        "CO05",
        "CO06",
        "CO07",
        "CT01",
        "CT02",
        "CT03",
        "CT04",
        "CT05",
        "DE00",
        "FL01",
        "FL02",
        "FL03",
        "FL04",
        "FL05",
        "FL06",
        "FL07",
        "FL08",
        "FL09",
        "FL10",
        "FL11",
        "FL12",
        "FL13",
        "FL14",
        "FL15",
        "FL16",
        "FL17",
        "FL18",
        "FL19",
        "FL20",
        "FL21",
        "FL22",
        "FL23",
        "FL24",
        "FL25",
        "FL26",
        "FL27",
        "GA01",
        "GA02",
        "GA03",
        "GA04",
        "GA05",
        "GA06",
        "GA07",
        "GA08",
        "GA09",
        "GA10",
        "GA11",
        "GA12",
        "GA13",
        "GA14",
        "HI01",
        "HI02",
        "IA01",
        "IA02",
        "IA03",
        "IA04",
        "ID01",
        "ID02",
        "IL01",
        "IL02",
        "IL03",
        "IL04",
        "IL05",
        "IL06",
        "IL07",
        "IL08",
        "IL09",
        "IL10",
        "IL11",
        "IL12",
        "IL13",
        "IL14",
        "IL15",
        "IL16",
        "IL17",
        "IL18",
        "IN01",
        "IN02",
        "IN03",
        "IN04",
        "IN05",
        "IN06",
        "IN07",
        "IN08",
        "IN09",
        "KS01",
        "KS02",
        "KS03",
        "KS04",
        "KY01",
        "KY02",
        "KY03",
        "KY04",
        "KY05",
        "KY06",
        "LA01",
        "LA02",
        "LA03",
        "LA04",
        "LA05",
        "LA06",
        "MA01",
        "MA02",
        "MA03",
        "MA04",
        "MA05",
        "MA06",
        "MA07",
        "MA08",
        "MA09",
        "MD01",
        "MD02",
        "MD03",
        "MD04",
        "MD05",
        "MD06",
        "MD07",
        "MD08",
        "ME01",
        "ME02",
        "MI01",
        "MI02",
        "MI03",
        "MI04",
        "MI05",
        "MI06",
        "MI07",
        "MI08",
        "MI09",
        "MI10",
        "MI11",
        "MI12",
        "MI13",
        "MI14",
        "MN01",
        "MN02",
        "MN03",
        "MN04",
        "MN05",
        "MN06",
        "MN07",
        "MN08",
        "MO01",
        "MO02",
        "MO03",
        "MO04",
        "MO05",
        "MO06",
        "MO07",
        "MO08",
        "MS01",
        "MS02",
        "MS03",
        "MS04",
        "MT00",
        "NC01",
        "NC02",
        "NC03",
        "NC04",
        "NC05",
        "NC06",
        "NC07",
        "NC08",
        "NC09",
        "NC10",
        "NC11",
        "NC12",
        "NC13",
        "ND00",
        "NE01",
        "NE02",
        "NE03",
        "NH01",
        "NH02",
        "NJ01",
        "NJ02",
        "NJ03",
        "NJ04",
        "NJ05",
        "NJ06",
        "NJ07",
        "NJ08",
        "NJ09",
        "NJ10",
        "NJ11",
        "NJ12",
        "NM01",
        "NM02",
        "NM03",
        "NV01",
        "NV02",
        "NV03",
        "NV04",
        "NY01",
        "NY02",
        "NY03",
        "NY04",
        "NY05",
        "NY06",
        "NY07",
        "NY08",
        "NY09",
        "NY10",
        "NY11",
        "NY12",
        "NY13",
        "NY14",
        "NY15",
        "NY16",
        "NY17",
        "NY18",
        "NY19",
        "NY20",
        "NY21",
        "NY22",
        "NY23",
        "NY24",
        "NY25",
        "NY26",
        "NY27",
        "OH01",
        "OH02",
        "OH03",
        "OH04",
        "OH05",
        "OH06",
        "OH07",
        "OH08",
        "OH09",
        "OH10",
        "OH11",
        "OH12",
        "OH13",
        "OH14",
        "OH15",
        "OH16",
        "OK01",
        "OK02",
        "OK03",
        "OK04",
        "OK05",
        "OR01",
        "OR02",
        "OR03",
        "OR04",
        "OR05",
        "PA01",
        "PA02",
        "PA03",
        "PA04",
        "PA05",
        "PA06",
        "PA07",
        "PA08",
        "PA09",
        "PA10",
        "PA11",
        "PA12",
        "PA13",
        "PA14",
        "PA15",
        "PA16",
        "PA17",
        "PA18",
        "RI01",
        "RI02",
        "SC01",
        "SC02",
        "SC03",
        "SC04",
        "SC05",
        "SC06",
        "SC07",
        "SD00",
        "TN01",
        "TN02",
        "TN03",
        "TN04",
        "TN05",
        "TN06",
        "TN07",
        "TN08",
        "TN09",
        "TX01",
        "TX02",
        "TX03",
        "TX04",
        "TX05",
        "TX06",
        "TX07",
        "TX08",
        "TX09",
        "TX10",
        "TX11",
        "TX12",
        "TX13",
        "TX14",
        "TX15",
        "TX16",
        "TX17",
        "TX18",
        "TX19",
        "TX20",
        "TX21",
        "TX22",
        "TX23",
        "TX24",
        "TX25",
        "TX26",
        "TX27",
        "TX28",
        "TX29",
        "TX30",
        "TX31",
        "TX32",
        "TX33",
        "TX34",
        "TX35",
        "TX36",
        "UT01",
        "UT02",
        "UT03",
        "UT04",
        "VA01",
        "VA02",
        "VA03",
        "VA04",
        "VA05",
        "VA06",
        "VA07",
        "VA08",
        "VA09",
        "VA10",
        "VA11",
        "VT00",
        "WA01",
        "WA02",
        "WA03",
        "WA04",
        "WA05",
        "WA06",
        "WA07",
        "WA08",
        "WA09",
        "WA10",
        "WI01",
        "WI02",
        "WI03",
        "WI04",
        "WI05",
        "WI06",
        "WI07",
        "WI08",
        "WV01",
        "WV02",
        "WV03",
        "WY00",

    );


    $i = array_search($fourcode, $x);
    $p = $i - 1;
    $n = $i + 1;

    if ($i == 0) {
        $prev = $x[count($x) - 1];
    } else {
        $prev = $x[$i - 1];
    }
    if ($i === count($x) - 1) {
        $next = $x[0];
    } else {
        $next = $x[$i + 1];
    }

    $prev_type = get_page_from_offset($p);
    $next_type = get_page_from_offset($n);

    $links['prev'] = $prev_type;
    $links['next'] = $next_type;
    $links['prev_code'] = $prev;
    $links['next_code'] = $next;

    return $links;
}

function get_page_from_offset($number)
{
    if ($number < 177) {
        $retval = 'district';
    }

    if ($number > 176 && $number < 235) {
        $retval = 'county';
    }

    if ($number > 234 && $number < 670) {
        $retval = 'fed';
    }

    if ($number > 669) {
        $retval = 'district';
    }

    return $retval;
}

function get_incumbent($id)
{
    $conn = Util::get_ctb_conn();
    $term_limit='';
    $name='';
    $party='';

    $first_two = mb_substr($id, 0, 2);

    $cal_headers = Array("CD", "SD", "AD", "BO", ".A", ".G", ".C", ".S", ".T", ".I");
    $use_cal = in_array($first_two, $cal_headers);


    if ($use_cal) {
        $sql = "SELECT * FROM ctb2016_e22_incumbent WHERE DIST = '$id'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['LEGISLATOR'];
                $party = $row['PARTY'];
                $term_limit = $row['TERM_LIMIT'];
            }
        }

    } else {
        $sql = "SELECT * FROM ctb2016_e22_fed WHERE DIST = '$id'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['NAMF'] . " " . $row['NAML'];
                $party = $row['PARTY'];
            }
        }
    }

    $term_append='';
    if ($term_limit) {
        $term_append = "<br>TERM LIMIT: " . $term_limit;
    }

    $retval = "<h3 class='pull-left' align='center'>$name ($party)" . $term_append . "</h3>";

    if (!$name) {
        $retval = '';
    }

    return $retval;
}

function is_targeted_fed($fourcode)
{
    $conn = Util::get_ctb_conn();
    $sql = "SELECT targeted_by FROM nufec_e20_targets WHERE fourcode = '".$fourcode."';";
    $result = $conn->query($sql);

    $x = '';
    $retval = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $x = $row['targeted_by'];
        }
    }
    if ($x == "DCCC") {
        $retval = "<span class='boldme blueme'>2020 DCCC Target</span>";
    }


    if ($x == "NRCC") {
        $retval = "<span class='boldme redme'>2020 NRCC Target</span>";
    }

    return $retval;
}

function is_open_fed($fourcode)
{
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM nufec_e20_open WHERE fourcode = '".$fourcode."';";
    $result = $conn->query($sql);
    $reason = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $incumbent = $row['incumbent'];
            $party = $row['party'];
            $reason = $row['reason'];
        }
    }

    $retval = '';
    if ($reason) {
        $retval = "<div class='alert alert-info m-n' role='alert'><span class='boldme'>OPEN SEAT IN 2020</span><br/>" . $incumbent . " (" . $party . ")" . " is " . $reason . "</div> ";
    }

    return $retval;
}

function get_old_fourcode_index() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT fourcode, old_fourcode FROM ctb_redist_VIZ_1220_sum2";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$old_fourcode = $row['old_fourcode'];

			$index['old'][$old_fourcode] = $fourcode;
			$index['new'][$fourcode] = $old_fourcode;
		}
	}
	return $index;
}



?>


<div class="book-page-head row m-n">
    <div>
	<div class="m-n pull-left">
        	<h3 class="m-n pull-left">{{$id}} (OLD {{$old_fourcode}})</h3><br>
		<h6 class="m-n pull-left">Old {{$id}} is now {{$new_fourcode}}</h6>
	</div>
        <div class="dist-head-incumbent">
            <?= $incumbent ?>
            <?= $is_targeted ?>
        </div>
    </div>

    <div class="dist-arrows pull-right" style='display: none;'>
        <a href="{{ route('book.'.$prev_type, ['id' => $prev_code]) }}">
            <i class="fa fa-2x fa-arrow-circle-o-left" aria-hidden="true"></i>
            <span> {{$links['prev_code']}} </span>
        </a>
        <a href="{{ route('book.'.$next_type, ['id' => $next_code]) }}">
            <i class="fa fa-2x fa-arrow-circle-o-right" aria-hidden="true"></i>
            <span> {{$links['next_code']}} </span>
        </a>

    </div>

</div>

<div class="clear">
    <?= $is_open ?>
</div>
