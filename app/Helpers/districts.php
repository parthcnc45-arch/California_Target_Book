<?php 

function get_district_nav() {
    return \Cache::rememberForever('ctb.nav.dist', function() {
        return build_dist_nav();
    });
}

function build_dist_nav()
{
//    global $ctb_conn;
    // $conn = $GLOBALS['ctb_conn'];
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_e18_incumbent WHERE DIST LIKE 'AD%' ORDER BY DIST ASC";
    $result = $conn->query($sql);

    $listbody = '';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listbody .= "<li><a href='/book/district/" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
        }
    }
    $asm_nav = "<li><a href='#'>Assembly</a><ul class='dropdown-menu'>" .
        $listbody .
        "</ul></li>";

    $listbody = '';
    $sql = "SELECT * FROM ctb2016_e18_incumbent WHERE DIST LIKE 'SD%' ORDER BY DIST ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listbody .= "<li><a href='/book/district/" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
        }
    }
    $sen_nav = "<li><a href='#'>State Senate</a>
					<ul class='dropdown-menu'>" .
        $listbody .
        "</ul>
				</li>";
    $listbody = '';
    $sql = "SELECT * FROM ctb2016_e18_incumbent WHERE DIST LIKE 'CD%' ORDER BY DIST ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listbody .= "<li><a href='/book/district/" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
        }
    }
    $cng_nav = "<li><a href='#'>Congress (CA)</a>
					<ul class='dropdown-menu'>" .
        $listbody .
        "</ul>
				</li>";
    $listbody = '';
    $boe_nav = "<li><a href='#'>Board of Equalization</a>
					<ul class='dropdown-menu'>
						<li><a href='/book/district/BOE1'>BOE1 (R-Runner)</a></li>
						<li><a href='/book/district/BOE2'>BOE2 (D-Ma)</a></li>
						<li><a href='/book/district/BOE3'>BOE3 (D-Horton)</a></li>
						<li><a href='/book/district/BOE4'>BOE4 (R-Harkey)</a></li>
					</ul>
				</li>";
    $state_offc_nav = "<li><a href='#'>Constitutional Offices</a>
					<ul class='dropdown-menu'>
						<li><a href='/book/district/.GOV'>Governor (D-Brown)</a></li>
						<li><a href='/book/district/.LTG'>Lt. Governor (D-Newsom)</a></li>
						<li><a href='/book/district/.ATG'>Attorney General (D-Becerra)</a></li>
						<li><a href='/book/district/.SOS'>Secretary of State (D-Padilla)</a></li>
						<li><a href='/book/district/.TRS'>Treasurer (D-Chiang)</a></li>
						<li><a href='/book/district/.CON'>Controller (D-Yee)</a></li>
						<li><a href='/book/district/.INS'>Insurance Commissioner (D-Jones)</a></li>
						<li><a href='/book/district/.SPI'>Superintendent of Public Instruction (NOP-Torlakson)</a></li>
					</ul>
				</li>";
    $ca_sen_nav = "<li><a href='#'>U.S. Senate (CA)</a>
					<ul class='dropdown-menu'>
						<li><a href='/book/district/.SN1'>U.S. Senate 1 (D-Feinstein)</a></li>
						<li><a href='/book/district/.SN2'>U.S. Senate 2 (D-Harris)</a></li>
					</ul>
				</li>";


    $states_array = Array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");
    $house_nav = "<li><a href='#'>U.S. House of Representatives</a><ul class='dropdown-menu'>";

    foreach ($states_array as $st) {
        $long_state = convert_state2($st);

        $house_nav .= "<li><a href='#'>$long_state</a><ul class='dropdown-menu'>";
        $sql = "SELECT DIST, NAML, PARTY FROM ctb2016_e18_fed WHERE DIST LIKE '$st%' ORDER BY DIST ASC";
        //echo($sql) . "<br>";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $house_nav .= "<li><a href='/book/district-fed/" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['NAML'] . ")</a></li>";
            }
        }
        $house_nav .= "</ul></li>";
    }
    $house_nav .= "</ul></li>";
    $county_nav = get_county_nav();
    $retval = $asm_nav . $sen_nav . $cng_nav . $boe_nav . $state_offc_nav . $ca_sen_nav . $county_nav . $house_nav;

    return $retval;
}

function get_county_nav()
{
    $conversion_array = Array(
        "ALAMEDA" => "01",
        "ALPINE" => "02",
        "AMADOR" => "03",
        "BUTTE" => "04",
        "CALAVERAS" => "05",
        "COLUSA" => "06",
        "CONTRA COSTA" => "07",
        "DEL NORTE" => "08",
        "EL DORADO" => "09",
        "FRESNO" => "10",
        "GLENN" => "11",
        "HUMBOLDT" => "12",
        "IMPERIAL" => "13",
        "INYO" => "14",
        "KERN" => "15",
        "KINGS" => "16",
        "LAKE" => "17",
        "LASSEN" => "18",
        "LOS ANGELES" => "19",
        "MADERA" => "20",
        "MARIN" => "21",
        "MARIPOSA" => "22",
        "MENDOCINO" => "23",
        "MERCED" => "24",
        "MODOC" => "25",
        "MONO" => "26",
        "MONTEREY" => "27",
        "NAPA" => "28",
        "NEVADA" => "28",
        "ORANGE" => "30",
        "PLACER" => "31",
        "PLUMAS" => "32",
        "RIVERSIDE" => "33",
        "SACRAMENTO" => "34",
        "SAN BENITO" => "35",
        "SAN BERNARDINO" => "36",
        "SAN DIEGO" => "37",
        "SAN FRANCISCO" => "38",
        "SAN JOAQUIN" => "39",
        "SAN LUIS OBISPO" => "40",
        "SAN MATEO" => "41",
        "SANTA BARBARA" => "42",
        "SANTA CLARA" => "43",
        "SANTA CRUZ" => "44",
        "SHASTA" => "45",
        "SIERRA" => "46",
        "SISKIYOU" => "47",
        "SOLANO" => "48",
        "SONOMA" => "49",
        "STANISLAUS" => "50",
        "SUTTER" => "51",
        "TEHAMA" => "52",
        "TRINITY" => "53",
        "TULARE" => "54",
        "TUOLUMNE" => "55",
        "VENTURA" => "56",
        "YOLO" => "57",
        "YUBA" => "58"
    );
    $listbody = '';
    foreach ($conversion_array as $key => $value) {
        $listbody .= "<li><a href='/book/county/$key'>$key</a></li>";
    }
    $retval = "<li><a href='#'>Counties</a>
    				<ul class='dropdown-menu'>" .
        $listbody .
        "</ul>
    			</li>";

    return $retval;
}

function convert_state2($name, $to = 'abbrev')
{
    $states = array(
        array('name' => 'Alabama', 'abbrev' => 'AL'),
        array('name' => 'Alaska', 'abbrev' => 'AK'),
        array('name' => 'Arizona', 'abbrev' => 'AZ'),
        array('name' => 'Arkansas', 'abbrev' => 'AR'),
        array('name' => 'California', 'abbrev' => 'CA'),
        array('name' => 'Colorado', 'abbrev' => 'CO'),
        array('name' => 'Connecticut', 'abbrev' => 'CT'),
        array('name' => 'Delaware', 'abbrev' => 'DE'),
        array('name' => 'Florida', 'abbrev' => 'FL'),
        array('name' => 'Georgia', 'abbrev' => 'GA'),
        array('name' => 'Hawaii', 'abbrev' => 'HI'),
        array('name' => 'Idaho', 'abbrev' => 'ID'),
        array('name' => 'Illinois', 'abbrev' => 'IL'),
        array('name' => 'Indiana', 'abbrev' => 'IN'),
        array('name' => 'Iowa', 'abbrev' => 'IA'),
        array('name' => 'Kansas', 'abbrev' => 'KS'),
        array('name' => 'Kentucky', 'abbrev' => 'KY'),
        array('name' => 'Louisiana', 'abbrev' => 'LA'),
        array('name' => 'Maine', 'abbrev' => 'ME'),
        array('name' => 'Maryland', 'abbrev' => 'MD'),
        array('name' => 'Massachusetts', 'abbrev' => 'MA'),
        array('name' => 'Michigan', 'abbrev' => 'MI'),
        array('name' => 'Minnesota', 'abbrev' => 'MN'),
        array('name' => 'Mississippi', 'abbrev' => 'MS'),
        array('name' => 'Missouri', 'abbrev' => 'MO'),
        array('name' => 'Montana', 'abbrev' => 'MT'),
        array('name' => 'Nebraska', 'abbrev' => 'NE'),
        array('name' => 'Nevada', 'abbrev' => 'NV'),
        array('name' => 'New Hampshire', 'abbrev' => 'NH'),
        array('name' => 'New Jersey', 'abbrev' => 'NJ'),
        array('name' => 'New Mexico', 'abbrev' => 'NM'),
        array('name' => 'New York', 'abbrev' => 'NY'),
        array('name' => 'North Carolina', 'abbrev' => 'NC'),
        array('name' => 'North Dakota', 'abbrev' => 'ND'),
        array('name' => 'Ohio', 'abbrev' => 'OH'),
        array('name' => 'Oklahoma', 'abbrev' => 'OK'),
        array('name' => 'Oregon', 'abbrev' => 'OR'),
        array('name' => 'Pennsylvania', 'abbrev' => 'PA'),
        array('name' => 'Rhode Island', 'abbrev' => 'RI'),
        array('name' => 'South Carolina', 'abbrev' => 'SC'),
        array('name' => 'South Dakota', 'abbrev' => 'SD'),
        array('name' => 'Tennessee', 'abbrev' => 'TN'),
        array('name' => 'Texas', 'abbrev' => 'TX'),
        array('name' => 'Utah', 'abbrev' => 'UT'),
        array('name' => 'Vermont', 'abbrev' => 'VT'),
        array('name' => 'Virginia', 'abbrev' => 'VA'),
        array('name' => 'Washington', 'abbrev' => 'WA'),
        array('name' => 'West Virginia', 'abbrev' => 'WV'),
        array('name' => 'Wisconsin', 'abbrev' => 'WI'),
        array('name' => 'Wyoming', 'abbrev' => 'WY'),
    );
    foreach ($states as $state) {
        foreach ($state as $title => $value) {
            if (strtolower($value) == strtolower(trim($name))) {
                if ($to == 'name') {
                    $return = $state['abbrev'];
                } else {
                    $return = $state['name'];
                }
                break;
            }
        }
    }

    return $return;
}



function get_prop_nav()
{
    global $ctb_conn;
    $conn = $ctb_conn;
    $sql = "SELECT * FROM ctb_ca_props WHERE prop_no != '' && prop_session > 2003 ORDER BY prop_session, prop_no";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $election = $row['prop_session'] + 1;
            $prop_dscr = $row['prop_dscr'];
            $prop_no = $row['prop_no'];

            $prop_arr[$election][$prop_no] = $prop_dscr;
        }
    }

  $sql = "SELECT * FROM ctb_ca_props_pending WHERE prop_status > 0 ORDER BY prop_no";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $election = '2018';
      $prop_dscr = $row['prop_dscr'];
      $prop_no = $row['prop_no'];
      $prop_arr[$election][$prop_no] = $prop_dscr;
      $prop_id[$prop_no] = $row['prop_id'];
    }
  }

    $prop_nav = '';
    foreach ($prop_arr as $e_key => $e_arr) {
        if ($e_arr) {
            $prop_nav .= "<li><a href='#'>$e_key</a><ul class='dropdown-menu'>";

            foreach ($prop_arr[$e_key] as $prop_no => $prop_dscr) {
        	if($e_key == '2018') {
          		$url = '/book/pending_prop_page_b?id=' . $prop_id[$prop_no];
          		$prop_nav .= "<li><a href='$url'>" . $prop_no . " - " . $prop_dscr . "</a></li>";
        	} else {
          		$url = '/book/prop_page_b?prop=' . $prop_no . "&election=" . $e_key;
          		$prop_nav .= "<li><a href='$url'>PROP " . $prop_no . " - " . $prop_dscr . "</a></li>";          
        	}
            }

            $prop_nav .= "</ul>
						</li>";
        }

    }

    return $prop_nav;


}
