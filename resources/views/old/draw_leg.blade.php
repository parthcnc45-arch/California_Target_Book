<!DOCTYPE html>
<html lang="en">


    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        width: 100%;
      }

      #map-canvas {
        height: 1200px;
        width: 1200px;
      }


    .newseg .stw {
        float: left;
        display: inline-block;
        margin: 5px;
        border: 2px solid black;
        padding: 5px;

    }      

    .narrow {
        font-family: 'PT Sans Narrow';
    }
    </style>


    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

       <link href="/css/ctb.css" rel="stylesheet">



       <?php

        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');

        global $conn, $zoom, $boundaries, $coordinates;
        ini_set('memory_limit', '1512M');

        Util::require_ctb_api();
        $conn = Util::get_ctb_conn();


        setlocale(LC_COLLATE, "en_US");
        setlocale(LC_CTYPE, "en_US");
        set_time_limit(0);

	$use_supe = FALSE;
	$use_city = FALSE;
	$use_county = FALSE;

	$district = '';
	$ogr = '';
	$county = '';
	$sub = '';
	$city = '';
	$year = '';

	if(!empty($_GET['id'])) {
	     $district = $_GET['id'];
	} 

	if(!empty($_GET['year'])) {
	     $year = $_GET['year'];
	} 
	
	if(!empty($_GET['ogr'])) {
	     $ogr = $_GET['ogr'];
	} 


	if(!empty($_GET['county'])) {
	     $county = $_GET['county'];
	} 

	if(!empty($_GET['sub'])) {
	     $sub = $_GET['sub'];
	} 

	if(!empty($_GET['city'])) {
	     $city = $_GET['city'];
	} 
	

        if ($county && !$sub) {
            $use_county_total = TRUE;
        }

        if ($county && $county != "ALL") {
            $district = get_county_fourcode(strtoupper($county));
        }

        if ($county == "ALL") {
            $district = "ALL_CO";
        }

        if($city) {
            $use_city = TRUE;
        }

//        supe_dists
        $precincts = Array();
        $endjava = Array();
        $candidate_array = Array();
        $coordinates = Array();

        if ($ogr) {
            $precincts = Array($ogr);
        } elseif ($sub) {
            $precincts = get_county_ids($district, $sub);
            $use_supe = TRUE;
        } elseif($use_city) {
            $precincts = get_city_precincts($city);
        } else {
            $precincts = get_leg_ids($district, $year);
        }


        //echo("<br>CANDIDATE ARRAY:<br>");
        //var_dump($candidate_array);

        $i = 1;

        //echo("<br>USING DISTRICT $district -- PRECINCT DUMP:<br>");
        //var_dump($precincts);


        /*





        MMMMMMMM               MMMMMMMM                                        SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCC
        M:::::::M             M:::::::M                                      SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::C
        M::::::::M           M::::::::M                                     S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::C
        M:::::::::M         M:::::::::M                                     S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::C
        M::::::::::M       M::::::::::M  aaaaaaaaaaaaa  ppppp   ppppppppp   S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC
        M:::::::::::M     M:::::::::::M  a::::::::::::a p::::ppp:::::::::p  S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C
        M:::::::M::::M   M::::M:::::::M  aaaaaaaaa:::::ap:::::::::::::::::p  S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C
        M::::::M M::::M M::::M M::::::M           a::::app::::::ppppp::::::p  SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C
        M::::::M  M::::M::::M  M::::::M    aaaaaaa:::::a p:::::p     p:::::p    SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C
        M::::::M   M:::::::M   M::::::M  aa::::::::::::a p:::::p     p:::::p       SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
        M::::::M    M:::::M    M::::::M a::::aaaa::::::a p:::::p     p:::::p            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
        M::::::M     MMMMM     M::::::Ma::::a    a:::::a p:::::p    p::::::p            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC
        M::::::M               M::::::Ma::::a    a:::::a p:::::ppppp:::::::pSSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::C
        M::::::M               M::::::Ma:::::aaaa::::::a p::::::::::::::::p S::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::C
        M::::::M               M::::::M a::::::::::aa:::ap::::::::::::::pp  S:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::C
        MMMMMMMM               MMMMMMMM  aaaaaaaaaa  aaaap::::::pppppppp     SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCC
                                                         p:::::p
                                                         p:::::p
                                                        p:::::::p
                                                        p:::::::p
                                                        p:::::::p
                                                        ppppppppp

        */

        foreach ($precincts as $precinct) {

            $dumpmode = FALSE;
            $srprec = $precinct;

            if (!$use_supe && !$use_city) {
                $x = get_g16_precinct_polygons($srprec);
            } elseif ($use_city) {
                $x = get_city_polygons($srprec);
            } else {
                $x = get_supe_polygons($srprec);
            }

            if ($dumpmode) {
                //echo("<br>DUMP OF PRECINCT POLGYONS:<br>");
                //var_dump($x);
            }
            if (!$x) {

                if ($dumpmode) {
                    echo("<br>NO COORDINATES<bt> for $srprec in County $county<br>");
                }
                continue;
            }
            //$stats = get_stats($srprec, $county);

            if ($dumpmode) {
                echo("<br>STATS DUMP:<br>");
                var_dump($stats);
            }

            $polys = parse_poly_strings($x);

            if ($dumpmode) {
                echo("<br>PARSED RESULTS DUMP:<br>");
                var_dump($polys);
            }

            if (is_array($polys)) {
                $coordinates[$srprec]['POLYS'] = $polys;
            } else {
                $coordinates[$srprec]['COORDINATES'] = $polys;
                $coordinates[$srprec]['COORDINATES'] = rtrim($coordinates[$srprec]['COORDINATES'], ',');
            }

        }


        //echo("<br>parsed:<br>$coordinates");


        //$zoom = lookupzoom($fourcode);

        $center = centercalc($boundaries);

        //INITIALIZING PORTION OF JAVASCRIPT
        $js = "
	  var polys = [];

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: $zoom,
          center: $center

          mapTypeId: google.maps.MapTypeId.TERRAIN
        });

		var infowindow = new google.maps.InfoWindow({
			content: \"Blah\"
		});
		

";

        array_push($endjava, $js);


        /*


        MMMMMMMM               MMMMMMMM                                        SSSSSSSSSSSSSSS      tttt                                    tttt
        M:::::::M             M:::::::M                                      SS:::::::::::::::S  ttt:::t                                 ttt:::t
        M::::::::M           M::::::::M                                     S:::::SSSSSS::::::S  t:::::t                                 t:::::t
        M:::::::::M         M:::::::::M                                     S:::::S     SSSSSSS  t:::::t                                 t:::::t
        M::::::::::M       M::::::::::M  aaaaaaaaaaaaa  ppppp   ppppppppp   S:::::S        ttttttt:::::ttttttt      aaaaaaaaaaaaa  ttttttt:::::ttttttt        ssssssssss
        M:::::::::::M     M:::::::::::M  a::::::::::::a p::::ppp:::::::::p  S:::::S        t:::::::::::::::::t      a::::::::::::a t:::::::::::::::::t      ss::::::::::s
        M:::::::M::::M   M::::M:::::::M  aaaaaaaaa:::::ap:::::::::::::::::p  S::::SSSS     t:::::::::::::::::t      aaaaaaaaa:::::at:::::::::::::::::t    ss:::::::::::::s
        M::::::M M::::M M::::M M::::::M           a::::app::::::ppppp::::::p  SS::::::SSSSStttttt:::::::tttttt               a::::atttttt:::::::tttttt    s::::::ssss:::::s
        M::::::M  M::::M::::M  M::::::M    aaaaaaa:::::a p:::::p     p:::::p    SSS::::::::SS    t:::::t              aaaaaaa:::::a      t:::::t           s:::::s  ssssss
        M::::::M   M:::::::M   M::::::M  aa::::::::::::a p:::::p     p:::::p       SSSSSS::::S   t:::::t            aa::::::::::::a      t:::::t             s::::::s
        M::::::M    M:::::M    M::::::M a::::aaaa::::::a p:::::p     p:::::p            S:::::S  t:::::t           a::::aaaa::::::a      t:::::t                s::::::s
        M::::::M     MMMMM     M::::::Ma::::a    a:::::a p:::::p    p::::::p            S:::::S  t:::::t    tttttta::::a    a:::::a      t:::::t    ttttttssssss   s:::::s
        M::::::M               M::::::Ma::::a    a:::::a p:::::ppppp:::::::pSSSSSSS     S:::::S  t::::::tttt:::::ta::::a    a:::::a      t::::::tttt:::::ts:::::ssss::::::s
        M::::::M               M::::::Ma:::::aaaa::::::a p::::::::::::::::p S::::::SSSSSS:::::S  tt::::::::::::::ta:::::aaaa::::::a      tt::::::::::::::ts::::::::::::::s
        M::::::M               M::::::M a::::::::::aa:::ap::::::::::::::pp  S:::::::::::::::SS     tt:::::::::::tt a::::::::::aa:::a       tt:::::::::::tt s:::::::::::ss
        MMMMMMMM               MMMMMMMM  aaaaaaaaaa  aaaap::::::pppppppp     SSSSSSSSSSSSSSS         ttttttttttt    aaaaaaaaaa  aaaa         ttttttttttt    sssssssssss
                                                         p:::::p
                                                         p:::::p
                                                        p:::::::p
                                                        p:::::::p
                                                        p:::::::p
                                                        ppppppppp



        */


        $i = 1;
        //LOOP THROUGH ALL THE ZIP CODES AND DRAW INDIVIDUAL SEGMENTS


        foreach ($precincts as $value) {

            $srprec = $value;
            $precinct = $srprec;


            if (empty($coordinates[$precinct]['COORDINATES']) && empty($coordinates[$precinct]['POLYS'])) {
                //echo("<BR>NO COORDINATES!!!<br>");
                continue;
            }


            if (!$use_supe) {
                $s = get_stats($precinct);
                $fourcode = $s['fourcode'];
                $color = get_district_color($fourcode);
            } else {
                //echo("<br>PRECINCT: $precinct");
                $s = get_supe_stats($precinct);
                $this_county = $s['county_nm'];
                $this_dist = $s['county_dist'];
                $color = $supe_color[$this_county][$this_dist];

                //echo("<br>GOT COLOR $color<br>");
            }

            $popupinfo = $s['popupinfo'];

            $container_start = "<div style='display: inline-block;'>";
            $container_end = "</div>";

            $long_fourcode = $fourcode;

            if (mb_substr($fourcode, 0, 2) == "CO") {
                $long_fourcode = get_long_county(mb_substr($fourcode, 2, 2)) . " COUNTY";
                $use_county = TRUE;
            }

            $htmlhead = "<p align='center' style='font-size: 1.5em; font-weight: bold; font-variant: small-caps;'>$long_fourcode</p><p>$popupinfo</p>";


            //echo("...and populating HTML with <span style='color: \"$color;\"'>color $color</span>");

            $html = $container_start . $htmlhead . $container_end;

            if ($use_county && !$sub) {
                $color = get_county_color($fourcode);
            }
            //$html = $htmlhead;
            //$html = $htmlhead"<p align='center'>CD47</p>";

            if ($coordinates[$precinct]['POLYS']) {
                //echo("<br>GOT $precinct ($fourcode) PRECINCT POLYGONS ARRAY<br>");
                foreach ($coordinates[$precinct]['POLYS'] as $polygons) {
                    //echo("...MULTIPOLYGON");


                    $js = "
				polys[$i] = new google.maps.Polygon({
					html: \"$html\",
					fillColor: \"$color\",
					strokeColor: \"$color\",
					strokeWeight: 2,
					paths: " . $polygons . "
				});
				
				polys[$i].setMap(map);


				polys[$i].addListener('click', showArrays);

			";
                    array_push($endjava, $js);
                    $i++;

                }
            } else {
                //echo("<br>GOT $precinct ($fourcode) PRECINCT POLYGONS<br>");
                $js = "
			polys[$i] = new google.maps.Polygon({
				html: \"$html\",
				fillColor: \"$color\",
				strokeColor: \"$color\",
				strokeWeight: 2,				
				paths: " . $coordinates[$precinct]['COORDINATES'] . "
			});
			
			polys[$i].setMap(map);


			polys[$i].addListener('click', showArrays);

		";
                array_push($endjava, $js);
                $i++;
            }
        }


        $js = "

	  function showArrays(event) {
	  	html = this.html;
	  	var contentString = html;

  		infowindow.setContent(contentString);
  		infowindow.setPosition(event.latLng);
  		infowindow.open(map);
	  	
	  }

}";
        array_push($endjava, $js);

        //echo("<div id='container' style='display: inline-block;' align='center'>");
        echo("<div id='map_canvas'></div>");
        echo("<div id='map'></div>");
        //echo("</div>");



        /*


             OOOOOOOOO                                                                  lllllll
           OO:::::::::OO                                                                l:::::l
         OO:::::::::::::OO                                                              l:::::l
        O:::::::OOO:::::::O                                                             l:::::l
        O::::::O   O::::::Ovvvvvvv           vvvvvvv eeeeeeeeeeee    rrrrr   rrrrrrrrr   l::::l   aaaaaaaaaaaaa  ppppp   ppppppppp       ssssssssss
        O:::::O     O:::::O v:::::v         v:::::vee::::::::::::ee  r::::rrr:::::::::r  l::::l   a::::::::::::a p::::ppp:::::::::p    ss::::::::::s
        O:::::O     O:::::O  v:::::v       v:::::ve::::::eeeee:::::eer:::::::::::::::::r l::::l   aaaaaaaaa:::::ap:::::::::::::::::p ss:::::::::::::s
        O:::::O     O:::::O   v:::::v     v:::::ve::::::e     e:::::err::::::rrrrr::::::rl::::l            a::::app::::::ppppp::::::ps::::::ssss:::::s
        O:::::O     O:::::O    v:::::v   v:::::v e:::::::eeeee::::::e r:::::r     r:::::rl::::l     aaaaaaa:::::a p:::::p     p:::::p s:::::s  ssssss
        O:::::O     O:::::O     v:::::v v:::::v  e:::::::::::::::::e  r:::::r     rrrrrrrl::::l   aa::::::::::::a p:::::p     p:::::p   s::::::s
        O:::::O     O:::::O      v:::::v:::::v   e::::::eeeeeeeeeee   r:::::r            l::::l  a::::aaaa::::::a p:::::p     p:::::p      s::::::s
        O::::::O   O::::::O       v:::::::::v    e:::::::e            r:::::r            l::::l a::::a    a:::::a p:::::p    p::::::pssssss   s:::::s
        O:::::::OOO:::::::O        v:::::::v     e::::::::e           r:::::r           l::::::la::::a    a:::::a p:::::ppppp:::::::ps:::::ssss::::::s
         OO:::::::::::::OO          v:::::v       e::::::::eeeeeeee   r:::::r           l::::::la:::::aaaa::::::a p::::::::::::::::p s::::::::::::::s
           OO:::::::::OO             v:::v         ee:::::::::::::e   r:::::r           l::::::l a::::::::::aa:::ap::::::::::::::pp   s:::::::::::ss
             OOOOOOOOO                vvv            eeeeeeeeeeeeee   rrrrrrr           llllllll  aaaaaaaaaa  aaaap::::::pppppppp      sssssssssss
                                                                                                                  p:::::p
                                                                                                                  p:::::p
                                                                                                                 p:::::::p
                                                                                                                 p:::::::p
                                                                                                                 p:::::::p
                                                                                                                 ppppppppp


        */


        function get_overlaps($fourcode)
        {
            global $ctb2016_conn;

            global $election;
            //$election = 'g14';
            $conn = $ctb2016_conn;
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];

            $year = mb_substr($election, 1, 2);
            if ($year < 12) {
                $use_districts = "g08";
            } else {
                $use_districts = "g14";
            }

            $sql = "SELECT * FROM $use_districts WHERE $disttype = '$distno' GROUP BY county, cddist, addist, sddist";
            //echo("<br>OVERLAPS SQL:<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['addist']) {
                        $ad = "AD" . checkaddzero($row['addist']);
                        $sd = "SD" . checkaddzero($row['sddist']);
                        $cd = "CD" . checkaddzero($row['cddist']);
                        $boe = "BOE" . $row['bedist'];
                        $co = "CO" . checkaddzero($row['county']);
                        $retval[$co] = $row['county'];
                    } else {
                        $ad = "AD" . checkaddzero($row['ADDIST']);
                        $sd = "SD" . checkaddzero($row['SDDIST']);
                        $cd = "CD" . checkaddzero($row['CDDIST']);
                        $boe = "BOE" . $row['BEDIST'];
                        $co = "CO" . checkaddzero($row['COUNTY']);
                        $retval[$co] = $row['COUNTY'];
                    }

                    $retval[$ad] = $ad;
                    $retval[$sd] = $sd;
                    $retval[$cd] = $cd;
                    $retval[$boe] = $boe;
                }
            }

            return $retval;
        }

        /*

                CCCCCCCCCCCCC                 lllllll
             CCC::::::::::::C                 l:::::l
           CC:::::::::::::::C                 l:::::l
          C:::::CCCCCCCC::::C                 l:::::l
         C:::::C       CCCCCC   ooooooooooo    l::::l    ooooooooooo   rrrrr   rrrrrrrrr       ssssssssss
        C:::::C               oo:::::::::::oo  l::::l  oo:::::::::::oo r::::rrr:::::::::r    ss::::::::::s
        C:::::C              o:::::::::::::::o l::::l o:::::::::::::::or:::::::::::::::::r ss:::::::::::::s
        C:::::C              o:::::ooooo:::::o l::::l o:::::ooooo:::::orr::::::rrrrr::::::rs::::::ssss:::::s
        C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r     r:::::r s:::::s  ssssss
        C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r     rrrrrrr   s::::::s
        C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r                  s::::::s
         C:::::C       CCCCCCo::::o     o::::o l::::l o::::o     o::::o r:::::r            ssssss   s:::::s
          C:::::CCCCCCCC::::Co:::::ooooo:::::ol::::::lo:::::ooooo:::::o r:::::r            s:::::ssss::::::s
           CC:::::::::::::::Co:::::::::::::::ol::::::lo:::::::::::::::o r:::::r            s::::::::::::::s
             CCC::::::::::::C oo:::::::::::oo l::::::l oo:::::::::::oo  r:::::r             s:::::::::::ss
                CCCCCCCCCCCCC   ooooooooooo   llllllll   ooooooooooo    rrrrrrr              sssssssssss


        */

        function get_district_color($fourcode)
        {
            global $colors;
	    $retval = '';

            if (!empty($colors[$fourcode]['D']) && !empty($colors[$fourcode]['R'])) {
                $retval = "#FF00FF";
            } elseif (!empty($colors[$fourcode]['D']) && empty($colors[$fourcode]['R'])) {
                $retval = "#0000FF";
            } elseif (!empty($colors[$fourcode]['R']) && empty($colors[$fourcode]['D'])) {
                $retval = "#FF0000";
            }

            return $retval;
        }

        function get_county_color($fourcode)
        {
            global $county_color;

            $d = $county_color[$fourcode]['D'];
            $r = $county_color[$fourcode]['R'];

            if ($d > $r) {
                $retval = get_blue(3);
            } elseif ($r > $d) {
                $retval = get_red(3);
            } else {
                $retval = "FF00FF";
            }

            return $retval;
        }

        function get_color($offset)
        {
            $colors = Array(
                "#FF0000", //RED
                "#0000FF", //BLUE
                "#00FF00", //GREEN
                "#FFFF00", //YELLOW
                "#FF00FF", //PURPLE
                "#00FFFF", //LT BLUE
                "#FFA800", //ORANGE
                "#770000", //DARK RED
                "#001677", //DARK BLUE
                "#116700", //DARK GREEN
                "#8E9631", //DARK YELLOW
                "#B0B0FF", //LIGHTEST BLUE
                "#6F0000",  //DARKEST RED
                "#8080FF", //
                "#FFB0B0", //LIGHTEST RED
                "#9F0000", //
                "#CF0000", //
                "#4040FF", //
                "#0000CF", //
                "#FF4040", //
                "#00009F", //
                "#FF8080", //
                "#00006F" //DARKEST BLUE
            );

            return $colors[$offset];
        }

        function get_red($offset)
        {
            $colors = Array(
                "#FFB0B0", //LIGHTEST
                "#FF8080", //
                "#FF4040", //
                "#FF0000", //MIDDLE
                "#CF0000", //
                "#9F0000", //
                "#6F0000"  //DARKEST
            );

            return $colors[$offset];
        }

        function get_blue($offset)
        {
            $colors = Array(
                "#B0B0FF", //LIGHTEST
                "#8080FF", //
                "#4040FF", //
                "#0000FF", //MIDDLE
                "#0000CF", //
                "#00009F", //
                "#00006F"  //DARKEST
            );

            return $colors[$offset];
        }

        function get_ethnic_heatmap($pct)
        {

            if ($pct < 100) {
                $retval = "#820000"; //DARKEST RED
            }

            if ($pct < 90) {
                $retval = "#B60000"; //DARK RED
            }

            if ($pct < 80) {
                $retval = "#FF0000"; //BRIGHT RED
            }

            if ($pct < 70) {
                $retval = "#FF6000"; //RED/ORANGE
            }

            if ($pct < 60) {
                $retval = "#FF9000"; //ORANGE
            }

            if ($pct < 50) {
                $retval = "#FFC000"; //MUSTARD
            }

            if ($pct < 40) {
                $retval = "#FFF000"; //YELLOW
            }

            if ($pct < 30) {
                $retval = "#D0FF00"; //YELLOW/GREEN
            }

            if ($pct < 20) {
                $retval = "#A0FF00"; // LIGHT GREEN
            }

            if ($pct < 15) {
                $retval = "#40FF00"; //GREEN
            }

            if ($pct < 10) {
                $retval = "#00FFBA"; //LIGHT BLUE/GREEN
            }

            if ($pct < 5) {
                $retval = "#00FFF6"; //ICE BLUE
            }

            return $retval;

        }

        function get_population_heatmap($reg)
        {

            if ($reg >= 3000) {
                $retval = "#820000"; //DARKEST RED
            }

            if ($reg < 3000) {
                $retval = "#B60000"; //DARK RED
            }

            if ($reg < 2000) {
                $retval = "#FF0000"; //BRIGHT RED
            }

            if ($reg < 1000) {
                $retval = "#FF6000"; //RED/ORANGE
            }

            if ($reg < 750) {
                $retval = "#FF9000"; //ORANGE
            }

            if ($reg < 500) {
                $retval = "#FFC000"; //MUSTARD
            }

            if ($reg < 400) {
                $retval = "#FFF000"; //YELLOW
            }

            if ($reg < 300) {
                $retval = "#D0FF00"; //YELLOW/GREEN
            }

            if ($reg < 200) {
                $retval = "#A0FF00"; // LIGHT GREEN
            }

            if ($reg < 100) {
                $retval = "#40FF00"; //GREEN
            }

            if ($reg < 50) {
                $retval = "#00FFBA"; //LIGHT BLUE/GREEN
            }

            if ($reg < 25) {
                $retval = "#00FFF6"; //ICE BLUE
            }

            return $retval;


        }


        /*

                                                                            dddddddd
                CCCCCCCCCCCCC                                               d::::::d
             CCC::::::::::::C                                               d::::::d
           CC:::::::::::::::C                                               d::::::d
          C:::::CCCCCCCC::::C                                               d:::::d
         C:::::C       CCCCCC  aaaaaaaaaaaaa  nnnn  nnnnnnnn        ddddddddd:::::d     ssssssssss
        C:::::C                a::::::::::::a n:::nn::::::::nn    dd::::::::::::::d   ss::::::::::s
        C:::::C                aaaaaaaaa:::::an::::::::::::::nn  d::::::::::::::::d ss:::::::::::::s
        C:::::C                         a::::ann:::::::::::::::nd:::::::ddddd:::::d s::::::ssss:::::s
        C:::::C                  aaaaaaa:::::a  n:::::nnnn:::::nd::::::d    d:::::d  s:::::s  ssssss
        C:::::C                aa::::::::::::a  n::::n    n::::nd:::::d     d:::::d    s::::::s
        C:::::C               a::::aaaa::::::a  n::::n    n::::nd:::::d     d:::::d       s::::::s
         C:::::C       CCCCCCa::::a    a:::::a  n::::n    n::::nd:::::d     d:::::d ssssss   s:::::s
          C:::::CCCCCCCC::::Ca::::a    a:::::a  n::::n    n::::nd::::::ddddd::::::dds:::::ssss::::::s
           CC:::::::::::::::Ca:::::aaaa::::::a  n::::n    n::::n d:::::::::::::::::ds::::::::::::::s
             CCC::::::::::::C a::::::::::aa:::a n::::n    n::::n  d:::::::::ddd::::d s:::::::::::ss
                CCCCCCCCCCCCC  aaaaaaaaaa  aaaa nnnnnn    nnnnnn   ddddddddd   ddddd  sssssssssss

                */


        function get_candidates($fourcode)
        {
            global $ctb2016_conn;
            global $candidate_array;
            global $election;
            $conn = $ctb2016_conn;


            //$election = 'p16';
            //$eyear = mb_substr($election, 1,2);
            //$esearch = "p" . $eyear;


            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            //$sql = "SELECT distkey, party, name, is_incumbent, disttype, CAST(distnum AS UNSIGNED) AS distnum FROM candidates where disttype='$disttype' && distnum='$distno' && election = '$election'";
            $sql = "SELECT * FROM candidates WHERE disttype = '$disttype' && (distnum = '$distno' || distnum = '" . checkaddzero($distno) . "') && election = '$election'";
            //echo("<br>$fourcode<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $distkey = $row['distkey'];
                    $party = $row['party'];
                    $name = $row['name'];
                    $is_incumbent = $row['is_incumbent'];

                    $race = mb_substr($distkey, 0, 3);

                    if ($race == "CNG" || $race == "SEN" || $race == "ASS") {
                        $fourcode = $fourcode;
                    } else {
                        if ($race == "GOV" || $race == "LTG" || $race == "SPI" || $race == "SOS" || $race == "ATG" || $race == "TRS" || $race == "CON" || $race == "PRS" || $race == "INS" || $race == "USS") {
                            //echo("<br>GOT $race");
                            $fourcode = "." . $race;
                        } else {
                            $string = $row['race'];
                            $regex = "~PR_(.*?)_~";
                            preg_match($regex, $string, $results);
                            $prop_no = $results[1];
                            $position = substr($string, -1);
                            $fourcode = "PR" . $prop_no . $position;
                            //$fourcode = "PROP";
                        }
                    }
                    $candidate_array[$fourcode][$distkey]['RACE'] = $row['race'];
                    $candidate_array[$fourcode][$distkey]['DISTKEY'] = $distkey;
                    $candidate_array[$fourcode][$distkey]['PARTY'] = $party;
                    $candidate_array[$fourcode][$distkey]['INCUMBENT'] = $is_incumbent;
                    $candidate_array[$fourcode][$distkey]['NAME'] = $name;


                }
            }
        }

        function totalsort($a, $b)
        {

            if ($a['AMOUNT'] < $b['AMOUNT']) {
                return 1;
            } elseif ($a['AMOUNT'] > $b['AMOUNT']) {
                return -1;
            } else {
                return 0;
            }
        }

        function votesort($a, $b)
        {

            if ($a['PRECVOT'] < $b['PRECVOT']) {
                return 1;
            } elseif ($a['PRECVOT'] > $b['PRECVOT']) {
                return -1;
            } else {
                return 0;
            }
        }

        /*

           SSSSSSSSSSSSSSS      tttt                                    tttt
         SS:::::::::::::::S  ttt:::t                                 ttt:::t
        S:::::SSSSSS::::::S  t:::::t                                 t:::::t
        S:::::S     SSSSSSS  t:::::t                                 t:::::t
        S:::::S        ttttttt:::::ttttttt      aaaaaaaaaaaaa  ttttttt:::::ttttttt
        S:::::S        t:::::::::::::::::t      a::::::::::::a t:::::::::::::::::t
         S::::SSSS     t:::::::::::::::::t      aaaaaaaaa:::::at:::::::::::::::::t
          SS::::::SSSSStttttt:::::::tttttt               a::::atttttt:::::::tttttt
            SSS::::::::SS    t:::::t              aaaaaaa:::::a      t:::::t
               SSSSSS::::S   t:::::t            aa::::::::::::a      t:::::t
                    S:::::S  t:::::t           a::::aaaa::::::a      t:::::t
                    S:::::S  t:::::t    tttttta::::a    a:::::a      t:::::t    tttttt
        SSSSSSS     S:::::S  t::::::tttt:::::ta::::a    a:::::a      t::::::tttt:::::t
        S::::::SSSSSS:::::S  tt::::::::::::::ta:::::aaaa::::::a      tt::::::::::::::t
        S:::::::::::::::SS     tt:::::::::::tt a::::::::::aa:::a       tt:::::::::::tt
         SSSSSSSSSSSSSSS         ttttttttttt    aaaaaaaaaa  aaaa         ttttttttttt

        */

        function get_supe_stats($ogr_fid)
        {
            global $conn;
            $conn = $conn;
            global $supe_color;
            $sql = "SELECT county_nm, district FROM supe_dist WHERE OGR_FID = $ogr_fid";
            //echo("<br>RUNNING SUPE STATS<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $county_nm = $row['county_nm'] . " County";
                    $retval['county_nm'] = $row['county_nm'];
                    $sc = $retval['county_nm'];
                    $dist = "Supervisorial District " . $row['district'];
                    $retval['county_dist'] = $row['district'];
                    $sd = $retval['county_dist'];
                }
            }

            global $ctb2016_conn;
            $conn = $ctb2016_conn;

            $sql = "SELECT NAMF, NAML, TERM_LIMIT FROM ca_county_incumbents WHERE COUNTY = '$sc' && DIST = $sd";
            //echo($sql);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = $row['NAMF'] . " " . $row['NAML'];
                    if ($row['TERM_LIMIT']) {
                        $name .= "<br>TERM LIMIT: " . $row['TERM_LIMIT'];
                    }
                }
            }

            $sql = "SELECT * FROM vote_hist WHERE COUNTY ='$county_nm' && SUBDIVISION = '$dist'";
            //echo("<br>QUERYING VOTE HIST USING<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $g12_prstot = $row['G12_PRSDEM'] + $row['G12_PRSREP'] + $row['G12_PRSAIP'] + $row['G12_PRSGRN'] + $row['G12_PRSLIB'] + $row['G12_PRSPAF'];
                    $g16_prstot = $row['G16_PRSDEM'] + $row['G16_PRSREP'] + $row['G16_PRSGRN'] + $row['G16_PRSLIB'] + $row['G16_PRSPAF'];
                    $g14_govtot = $row['G14_GOVDEM'] + $row['G14_GOVREP'];
                    $g12_usstot = $row['G12_USSDEM'] + $row['G12_USSREP'];
                    $reg_tot = $row['O17_TOT'];
                    $reg_dem = $row['O17_DEM'];
                    $reg_rep = $row['O17_REP'];
                    $reg_npp = $row['O17_NPP'];

                    $g12_prsrep = number_format((($row['G12_PRSREP'] / $g12_prstot) * 100), 2);
                    $g12_prsdem = number_format((($row['G12_PRSDEM'] / $g12_prstot) * 100), 2);

                    $g16_prsrep = number_format((($row['G16_PRSREP'] / $g16_prstot) * 100), 2);
                    $g16_prsdem = number_format((($row['G16_PRSDEM'] / $g16_prstot) * 100), 2);

                    $g14_govdem = number_format((($row['G14_GOVDEM'] / $g14_govtot) * 100), 2);
                    $g14_govrep = number_format((($row['G14_GOVREP'] / $g14_govtot) * 100), 2);

                    $g12_ussdem = number_format((($row['G12_USSDEM'] / $g12_usstot) * 100), 2);
                    $g12_ussrep = number_format((($row['G12_USSREP'] / $g12_usstot) * 100), 2);

                    $d_reg_pct = number_format((($reg_dem / $reg_tot) * 100), 2);
                    $r_reg_pct = number_format((($reg_rep / $reg_tot) * 100), 2);
                    $n_reg_pct = number_format((($reg_npp / $reg_tot) * 100), 2);

                    $reg_adv = return_advantage("D", "R", $d_reg_pct, $r_reg_pct);
                    $g12_prs_adv = return_advantage("OBAMA", "ROMNEY", $g12_prsdem, $g12_prsrep);
                    $g16_prs_adv = return_advantage("CLINTON", "TRUMP", $g16_prsdem, $g16_prsrep);
                    $g14_gov_adv = return_advantage("BROWN", "KASHKARI", $g14_govdem, $g14_govrep);
                    $g12_uss_adv = return_advantage("FEINSTEIN", "EMKEN", $g12_ussdem, $g12_ussrep);
                    $county_lnk = "<a href='http://198.74.49.22/get_county_page_t.php?id=$sc' target='_blank'>$county_nm</a>";

                    $reg_table = "<p align='center' style='font-size: 1.5em; font-weight: bold;'>$county_lnk - $dist<br></p>";
                    $reg_table .= "<p align='center' style='font-size: 1.1em; font-weight: bold;'>$name<br><br>" . number_format($reg_tot) . " Registered Voters</p><table><tbody><tr><td class='blueme boldme'>DEM: " . number_format($reg_dem) . " ($d_reg_pct%)</td><td class='redme boldme'>REP: " . number_format($reg_rep) . " ($r_reg_pct%)</td><td class='grayme boldme'>NPP: " . number_format($reg_npp) . " ($n_reg_pct%)</td></tr></tbody></table><p align='center'>$reg_adv</p>";
                    $vote_table = "<table style='font-size: 0.8em; border: 2px solid black;'><tr align='center' style='font-weight: bold'><td colspan='3'>PRES '12</td><td colspan='3'>PRES '16</td><td colspan='3'>GOV '14</td><td colspan='3'>US SENATE '12</td></tr>";
                    $vote_table .= "<tr><td>OBAMA (D-Inc)</td><td>" . number_format($row['G12_PRSDEM']) . "</td><td>$g12_prsdem%</td><td>CLINTON (D)</td><td>" . number_format($row['G16_PRSDEM']) . "</td><td>$g16_prsdem%</td>";
                    $vote_table .= "<td>BROWN (D-Inc)</td><td>" . number_format($row['G14_GOVDEM']) . "</td><td>$g14_govdem%</td><td>FEINSTEIN (D-Inc)</td><td>" . number_format($row['G12_USSDEM']) . "</td><td>$g12_ussdem%</td></tr>";
                    $vote_table .= "<tr><td>ROMNEY (R)</td><td>" . number_format($row['G12_PRSREP']) . "</td><td>$g12_prsrep%</td><td>TRUMP (R)</td><td>" . number_format($row['G16_PRSREP']) . "</td><td>$g16_prsrep%</td>";
                    $vote_table .= "<td>KASHKARI (R)</td><td>" . number_format($row['G14_GOVREP']) . "</td><td>$g14_govrep%</td><td>EMKEN (R)</td><td>" . number_format($row['G12_USSREP']) . "</td><td>$g12_ussrep%</td></tr>";
                    $vote_table .= "<tr height='10px;'></tr>";
                    $vote_table .= "<tr align='center' style='border: none;'><td colspan='3'>$g12_prs_adv</td><td colspan='3'>$g16_prs_adv</td><td colspan='3'>$g14_gov_adv</td><td colspan='3'>$g12_uss_adv</td></tr></tbody></table>";

                    $retval['popupinfo'] = $reg_table . $vote_table;

                    if ($d_reg_pct > $r_reg_pct) {
                        $supe_color[$sc][$sd] = get_blue(3);
                    } elseif ($r_reg_pct > $d_reg_pct) {
                        $supe_color[$sc][$sd] = get_red(3);
                    } else {
                        $supe_color[$sc][$sd] == "#FF00FF";
                    }

                    //cho($retval['popupinfo']);

                }
            }

            return $retval;


        }

        function get_city_precincts($city) 
        {
            $conn = Util::get_ctb_conn();
            $retval = Array();
            $sql = "SELECT OGR_FID FROM cal_cities_ca_cities WHERE name = '$city'";
            //echo($sql);
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $dist = $row['OGR_FID'];
                    array_push($retval, $dist);
                }
            }
            return $retval;
        }        

        function return_advantage($dem_name, $gop_name, $dem_pct, $gop_pct)
        {
            if ($dem_pct > $gop_pct) {
                $diff = number_format(($dem_pct - $gop_pct), 2);
                if ($diff < 10) {
                    $diff = " " . $diff;
                }
                $retval = "<span class='blueme boldme'>$dem_name +" . $diff . "%</span>";
            } elseif ($gop_pct > $dem_pct) {
                $diff = number_format(($gop_pct - $dem_pct), 2);
                if ($diff < 10) {
                    $diff = " " . $diff;
                }
                $retval = "<span class='redme boldme'>$gop_name +" . $diff . "%</span>";
            } else {
                $retval = "<span class='boldme'>EVEN</span>";
            }

            return $retval;
        }


        function get_stats($precinct)
        {
            $conn = Util::get_ctb_conn();
            global $year;
            global $colors;
            global $regtable;

            if (!$year) {
                $year = 2010;
            }

            switch ($year) {
                case "1990":
                    $start = 1992;
                    $end = 2002;
                    break;
                case "2000":
                    $start = 2002;
                    $end = 2012;
                    break;
                case "2010":
                    $start = 2012;
                    $end = 2022;
                    break;
            }

            $sql = "SELECT fourcode FROM supe_dists_ca_legislative WHERE OGR_FID = '$precinct'";
            //echo("<br>STATS SQL:<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval['fourcode'] = $row['fourcode'];
                }
            }

            $fourcode = $retval['fourcode'];

            if (empty($regtable[$fourcode])) {
                $regtable[$fourcode] = get_reg_table($fourcode);
            }

	    $tbody = '';
            $sql = "SELECT * FROM ctb2016_caleg_past_officeholders WHERE dist = '" . $retval['fourcode'] . "' ORDER BY YR_END DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['PARTY'] == "R") {
                        $rowclass = "redme";

                    } elseif ($row['PARTY'] == "D") {
                        $rowclass = "blueme";
                    } else {
                        $rowclass = '';
                    }

                    if ($row['YR_START'] >= $start && $row['YR_END'] <= $end) {
                        $boldclass = 'boldme';
                    } else {
                        $boldclass = '';
                    }

                    if ($row['YR_END'] > $start && $row['YR_END'] <= $end) {
                        $boldclass = 'boldme';
                    }

                    if ($row['YR_START'] >= $start && $row['YR_START'] < $end) {
                        $boldclass = 'boldme';
                    }

                    if ($row['YR_START'] < $start && $row['YR_END'] > $end) {
                        $boldclass = 'boldme';
                    }

		   if ($boldclass) {
		    if (!isset($colors[$fourcode])) {
		        $colors[$fourcode] = ['R' => 0, 'D' => 0];
		    }
		
		    if ($row['PARTY'] == "R") {
		        $colors[$fourcode]['R']++;
		    } elseif ($row['PARTY'] == "D") {
		        $colors[$fourcode]['D']++;
		    }
		  }

                    $name = $row['NAMF'] . " " . $row['NAML'];

                    if ($boldclass) {
                        populate_total($fourcode, $row['PARTY'], $row['YR_START'], $row['YR_END'], $name);
                    }

                    $tbody .= "<tr class='$boldclass'><td class='$rowclass'>" . $name . " (" . $row['PARTY'] . ")</td><td>" . $row['YR_START'] . " - " . $row['YR_END'] . "</td></tr>";
                }
            }

            $retval['popupinfo'] = $regtable[$fourcode] . "<hr /><table><tbody>" . $tbody . "</tbody></table>";

            return $retval;
        }

        /*

                GGGGGGGGGGGGG                             tttt             SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCC
             GGG::::::::::::G                          ttt:::t           SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::C
           GG:::::::::::::::G                          t:::::t          S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::C
          G:::::GGGGGGGG::::G                          t:::::t          S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::C
         G:::::G       GGGGGG    eeeeeeeeeeee    ttttttt:::::ttttttt    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC
        G:::::G                ee::::::::::::ee  t:::::::::::::::::t    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C
        G:::::G               e::::::eeeee:::::eet:::::::::::::::::t     S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C
        G:::::G    GGGGGGGGGGe::::::e     e:::::etttttt:::::::tttttt      SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C
        G:::::G    G::::::::Ge:::::::eeeee::::::e      t:::::t              SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C
        G:::::G    GGGGG::::Ge:::::::::::::::::e       t:::::t                 SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
        G:::::G        G::::Ge::::::eeeeeeeeeee        t:::::t                      S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
         G:::::G       G::::Ge:::::::e                 t:::::t    tttttt            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC
          G:::::GGGGGGGG::::Ge::::::::e                t::::::tttt:::::tSSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::C
           GG:::::::::::::::G e::::::::eeeeeeee        tt::::::::::::::tS::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::C
             GGG::::::GGG:::G  ee:::::::::::::e          tt:::::::::::ttS:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::C
                GGGGGG   GGGG    eeeeeeeeeeeeee            ttttttttttt   SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCC

        */

        function get_reg_table($fourcode)
        {
            global $ctb2016_conn;
            global $county_color;
            global $district;
            global $year;
            global $omni;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT * FROM ctb2016_dist_reg_hist WHERE FOURCODE = '$fourcode'";
	    $census_table = '';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $y = $row;
                }
            }

            switch ($year) {
                case "1990":
                    $hdrs = Array("G92", "G94", "G96", "G98", "G00");
                    break;
                case "2000":
                    $hdrs = Array("G02", "G04", "G06", "G08", "G10");
                    break;
                case "2010":
                    $hdrs = Array("G12", "G14", "G16");
                    break;
            }

	    $use_county = FALSE;	   
            if ($district == "ALL_CO" || mb_substr($fourcode, 0, 2) == "CO") {
                $hdrs = Array("G92", "G94", "G96", "G98", "G00", "G02", "G04", "G06", "G08", "G10", "G12", "G14", "G16");
                $use_county = TRUE;
            }

            if ($use_county) {
                //POPULATE THE CENSUS TABLE
                $n = mb_substr($fourcode, 2, 2);
                $county_nm = get_long_county($n);
                $sql = "SELECT * FROM ctb2016_ca_county_census_stats WHERE COUNTY = '$county_nm'";
                //echo($sql);
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $x = $row;
                    }
                }


                $e_years = Array("1980", "1990", "2000", "2010");
                $grps = Array("POP", "WHT", "BLK", "JAP", "CHI", "FIL", "KOR", "EIN", "VIET", "LAT");
		$census_body = '';

                $census_head = "<hr /><table style='font-size: 0.85em; font-weight: bold;' class='narrow'><thead><tr><th>YR</th><th>POP</th><th>WHT</th><th>%</th><th>LAT</th><th>%</th><th>BLK</th><th>%</th><th>ASN</th><th>%</th><th>JPN</th><th>%</th><th>CHI</th><th>%</th><th>FIL</th><th>%</th><th>KOR</th><th>%</th><th>E. IND</th><th>%</th><th>VIET</th><th>%</th></tr></thead><tbody>";

                foreach ($e_years as $yy) {
                    //echo("<br>$yy<br>");
                    $tot_hdr = "POP_" . $yy;
                    $wht_hdr = "WHT_" . $yy;
                    $blk_hdr = "BLK_" . $yy;
                    $jap_hdr = "JAP_" . $yy;
                    $chi_hdr = "CHI_" . $yy;
                    $fil_hdr = "FIL_" . $yy;
                    $kor_hdr = "KOR_" . $yy;
                    $ein_hdr = "EIN_" . $yy;
                    $viet_hdr = "VIET_" . $yy;
                    $lat_hdr = "LAT_" . $yy;

                    $total = $x[$tot_hdr];
                    $white = $x[$wht_hdr];
                    $black = $x[$blk_hdr];
                    $jap = $x[$jap_hdr];
                    $chi = $x[$chi_hdr];
                    $fil = $x[$fil_hdr];
                    $kor = $x[$kor_hdr];
                    $ein = $x[$ein_hdr];
                    $viet = $x[$viet_hdr];
                    $lat = $x[$lat_hdr];
                    $asian = $jap + $chi + $fil + $kor + $ein + $viet;


                    $census_body .= "<tr>";
                    $census_body .= "<td>$yy</td><td>" . number_format($total) . "</td><td>" . number_format($white) . "</td><td>" . number_format((($white / $total) * 100), 2) . "</td><td>" . number_format($lat) . "</td><td>" . number_format((($lat / $total) * 100), 2) . "</td><td>" . number_format($black) . "</td>";
                    $census_body .= "<td>" . number_format((($black / $total) * 100), 2) . "</td><td>" . number_format($asian) . "</td><td>" . number_format((($asian / $total) * 100), 2) . "</td><td>" . number_format($jap) . "</td><td>" . number_format((($jap / $total) * 100), 2) . "</td><td>" . number_format($chi) . "</td>";
                    $census_body .= "<td>" . number_format((($chi / $total) * 100), 2) . "</td><td>" . number_format($fil) . "</td><td>" . number_format((($fil / $total) * 100), 2) . "</td><td>" . number_format($kor) . "</td><td>" . number_format((($kor / $total) * 100), 2) . "</td><td>" . number_format($ein) . "</td>";
                    $census_body .= "<td>" . number_format((($ein / $total) * 100), 2) . "</td><td>" . number_format($viet) . "</td><td>" . number_format((($viet / $total) * 100), 2) . "</td>";
                    $census_body .= "</tr>";


                }

                $census_table = $census_head . $census_body . "</tbody></table>";


            }

	    $tbody = '';

            foreach ($hdrs as $election) {
                $rep = $election . "_REP";
                $dem = $election . "_DEM";
                $npp = $election . "_NPP";

                $rep_pct = number_format(($y[$rep] * 100), 2);
                $dem_pct = number_format(($y[$dem] * 100), 2);
                $npp_pct = number_format(($y[$npp] * 100), 2);

                $omni[$fourcode][$election]['DEM'] = $dem_pct;
                $omni[$fourcode][$election]['REP'] = $rep_pct;
                $omni[$fourcode][$election]['NPP'] = $npp_pct;

                $adv = calculate_advantage($dem_pct, $rep_pct);

                if ($election == "G16" && $use_county = TRUE) {
                    $county_color[$fourcode]['D'] = $dem_pct;
                    $county_color[$fourcode]['R'] = $rep_pct;
                }

                $tbody .= "<tr><td class='boldme'>$election: </td><td class='blueme boldme'>DEM: $dem_pct%</td><td class='redme boldme'>REP: $rep_pct%</td><td class='grayme boldme'>NPP: $npp_pct%</td><td>$adv</td></tr>";
            }

            $reg_table = "<table><tbody>$tbody</tbody></table>" . $census_table;

            return $reg_table;
        }

        function populate_total($fourcode, $party, $start, $end, $name)
        {
            global $year;
            global $omni;
            switch ($year) {
                case "1990":
                    $hdrs = Array("G92" => 1992,
                        "G94" => 1994,
                        "G96" => 1996,
                        "G98" => 1998,
                        "G00" => 2000);
                    break;
                case "2000":
                    $hdrs = Array("G02" => 2002,
                        "G04" => 2004,
                        "G06" => 2006,
                        "G08" => 2008,
                        "G10" => 2010);
                    break;
                case "2010":
                    $hdrs = Array("G12" => 2012,
                        "G14" => 2014,
                        "G16" => 2016);
                    break;

            }

            foreach ($hdrs as $key => $value) {
                if ($value >= $start && $value < $end) {
                    $omni[$fourcode][$key]['PARTY'] = $party;
                    $omni[$fourcode][$key]['NAME'] = $name;
                }
            }


        }

        function calculate_advantage($d, $r)
        {
            if ($d > $r) {
                $retval = "<span class='blueme boldme'>D +" . number_format(($d - $r), 2) . "</span>";
            } elseif ($r > $d) {
                $retval = "<span class='redme boldme'>R +" . number_format(($r - $d), 2) . "</span>";
            } else {
                $retval = "<span class='boldme'>EVEN</span>";
            }

            return $retval;
        }

        function get_precincts($fourcode)
        {
            global $ctb2016_conn;
            global $election;
            $conn = Util::get_ctb_conn();

            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];

            $retval = Array();


            $sql = "SELECT srprec, county FROM ctb2016_$election WHERE $disttype = '$distno'";
            //echo("<br>RETRIEVING PRECINCTS USING<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp['srprec'] = $row['srprec'];
                    $tmp['county'] = $row['county'];
                    array_push($retval, $tmp);
                }
            }
            //echo("<br>RETURNING:<br>");
            //var_dump($retval);
            return $retval;
        }

        function get_g16_precincts($fourcode)
        {
            $conn = Util::get_ctb_conn();
            global $election;
            global $converted_county;
            if ($converted_county < 100) {
                $county = "0" . $converted_county . "-";
            }

            if ($converted_county < 10) {
                $county = "00" . $converted_county . "-";
            }
            $x = checkaddzero($converted_county);
            $conn = $ctb2016_conn;


            $retval = Array();


            $sql = "SELECT * FROM ctb2016_g16_temp WHERE pct16 LIKE '$county%'";
            //echo("<br>RETRIEVING PRECINCTS USING<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp['srprec'] = $row['pct16'];
                    $tmp['county'] = $row['county'];
                    array_push($retval, $tmp);
                }
            }
            //echo("<br>RETURNING:<br>");
            //var_dump($retval);
            return $retval;
        }

        function get_null_precincts()
        {
            global $ctb2016_conn;
            global $election;
            global $converted_county;
            global $fourcode;
            if ($converted_county < 100) {
                $county = "0" . $converted_county . "-";
            }

            if ($converted_county < 10) {
                $county = "00" . $converted_county . "-";
            }
            $x = checkaddzero($converted_county);
            $conn = Util::get_ctb_conn();


            $retval = Array();


            $sql = "SELECT * FROM ctb2016_g16_temp WHERE pct16 = '$fourcode'";
            echo("<br>RETRIEVING PRECINCTS USING<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp['srprec'] = $row['pct16'];
                    $tmp['county'] = $row['county'];
                    array_push($retval, $tmp);
                }
            }
            //echo("<br>RETURNING:<br>");
            //var_dump($retval);
            return $retval;
        }

        /*

           SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCCPPPPPPPPPPPPPPPPP                   lllllll
         SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::CP::::::::::::::::P                  l:::::l
        S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::CP::::::PPPPPP:::::P                 l:::::l
        S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::CPP:::::P     P:::::P                l:::::l
        S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC  P::::P     P:::::P  ooooooooooo    l::::lyyyyyyy           yyyyyyy
        S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C                P::::P     P:::::Poo:::::::::::oo  l::::l y:::::y         y:::::y
         S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C                P::::PPPPPP:::::Po:::::::::::::::o l::::l  y:::::y       y:::::y
          SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C                P:::::::::::::PP o:::::ooooo:::::o l::::l   y:::::y     y:::::y
            SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C                P::::PPPPPPPPP   o::::o     o::::o l::::l    y:::::y   y:::::y
               SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C                P::::P           o::::o     o::::o l::::l     y:::::y y:::::y
                    S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C                P::::P           o::::o     o::::o l::::l      y:::::y:::::y
                    S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC  P::::P           o::::o     o::::o l::::l       y:::::::::y
        SSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::CPP::::::PP         o:::::ooooo:::::ol::::::l       y:::::::y
        S::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::CP::::::::P         o:::::::::::::::ol::::::l        y:::::y
        S:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::CP::::::::P          oo:::::::::::oo l::::::l       y:::::y
         SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCCPPPPPPPPPP            ooooooooooo   llllllll      y:::::y
                                                                                                                                                             y:::::y
                                                                                                                                                            y:::::y
                                                                                                                                                           y:::::y
                                                                                                                                                          y:::::y
                                                                                                                                                         yyyyyyy



        */


        function get_county_ids($district, $sub)
        {
            global $conn;
            $conn = Util::get_ctb_conn();
            $retval = Array();

            if ($district == "ALL_CO" && $sub == "ALL") {
                $sql = "SELECT OGR_FID FROM supe_dists_supe_dist WHERE district != ''";
            } elseif (mb_substr($district, 0, 2) == "CO" && $sub == "ALL") {
                $n = mb_substr($district, 2, 2);
                $county_nm = get_long_county($n);
                $sql = "SELECT OGR_FID FROM supe_dists_supe_dist WHERE district != '' && county_nm = '$county_nm'";
            } else {
                $n = mb_substr($district, 2, 2);
                $county_nm = get_long_county($n);
                $sql = "SELECT OGR_FID FROM supe_dists_supe_dist WHERE district = '$sub' && county_nm = '$county_nm'";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['OGR_FID']);
                }
            }

            return $retval;


        }

        function get_leg_ids($district, $year)
        {
            $retval = Array();
            $conn = Util::get_ctb_conn();

            if (!$year && mb_substr($district, 0, 2) != "CO") {
                $year = "2010";
            }

            if ($district == "ALL_AD") {
                $sql = "SELECT OGR_FID FROM supe_dists_ca_legislative WHERE year = '$year' && fourcode LIKE 'AD%'";
            } elseif ($district == "ALL_SD") {
                $sql = "SELECT OGR_FID FROM supe_dists_ca_legislative WHERE year = '$year' && fourcode LIKE 'SD%'";
            } elseif ($district == "ALL_CD") {
                $sql = "SELECT OGR_FID FROM supe_dists_ca_legislative WHERE year = '$year' && fourcode LIKE 'CD%'";
            } elseif ($district == "ALL_CO") {
                $sql = "SELECT OGR_FID FROM supe_dists_ca_legislative WHERE fourcode LIKE 'CO%'";
            } else {
                $sql = "SELECT OGR_FID FROM supe_dists_ca_legislative WHERE year = '$year' && fourcode = '$district'";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['OGR_FID']);
                }
            }

            return $retval;
        }


        function get_g16_precinct_polygons($id)
        {
            global $conn;
            $conn = Util::get_ctb_conn();
            global $table;
            global $election;
            global $dist;

            $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM supe_dists_ca_legislative WHERE OGR_FID = '$id'";

            global $dumpmode;
            if ($dumpmode) {
                echo("<br>SQL POLY QUERY FOR PRECINCT $srprec<br>$sql<br>");
            }
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['SHAPE'];
                }
            }
            if ($dumpmode) {
                echo("<br>Returning: $retval</br>");
            }

            return $retval;
        }

        function get_supe_polygons($id)
        {
            global $conn;
            $conn = Util::get_ctb_conn();
            global $table;
            global $election;
            global $dist;

            $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM supe_dists_supe_dist WHERE OGR_FID = '$id'";

            global $dumpmode;
            if ($dumpmode) {
                echo("<br>SQL POLY QUERY FOR PRECINCT $srprec<br>$sql<br>");
            }
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['SHAPE'];
                }
            }
            if ($dumpmode) {
                echo("<br>Returning: $retval</br>");
            }

            return $retval;
        }

        function get_city_polygons($id)
        {
            global $conn;
            $conn = Util::get_ctb_conn();
            global $table;
            global $election;
            global $dist;
	    global $dumpmode;

            $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM cal_cities_ca_cities WHERE OGR_FID = '$id'";

            if($dumpmode) {
                echo("<br>SQL POLY QUERY FOR PRECINCT $srprec<br>$sql<br>");
            }
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $retval = $row['SHAPE'];
                }
            }
            if($dumpmode) {
                echo("<br>Returning: $retval</br>");
            }
            return $retval;
        }

        function get_precinct_polygons($srprec, $county)
        {
            global $precincts_conn;
            $$conn = Util::get_ctb_conn();
            global $table;
            global $election;
            global $dist;
            if (mb_substr($dist, 0, 1) == "0") {
                $dist = mb_substr($dist, 1, 1);
            }

            if (preg_match("/[a-z]/i", $srprec)) {
                $has_alpha = TRUE;
            }

            if (preg_match("~\-~", $srprec)) {
                $has_alpha = TRUE;
            }

            $numcheck = (int)$srprec;
            if (!$has_alpha) {
                $srprec = $numcheck;
                $sql = "SELECT CAST(SRPREC AS UNSIGNED) AS SRPREC,  ST_AsText(SHAPE) AS SHAPE FROM precincts_precincts WHERE SRPREC = $srprec && COUNTY = '$county' && ELECTION = '$election'";
            } else {
                $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM precincts_precincts WHERE SRPREC = '$srprec' && COUNTY = '$county' && ELECTION = '$election'";
            }

            global $dumpmode;
            if ($dumpmode) {
                echo("<br>SQL POLY QUERY FOR PRECINCT $srprec<br>$sql<br>");
            }

            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['SHAPE'];
                }
            }
            if ($dumpmode) {
                echo("<br>Returning: $retval</br>");
            }

            return $retval;
        }


        /*


        PPPPPPPPPPPPPPPPP                                                                         PPPPPPPPPPPPPPPPP                   lllllll
        P::::::::::::::::P                                                                        P::::::::::::::::P                  l:::::l
        P::::::PPPPPP:::::P                                                                       P::::::PPPPPP:::::P                 l:::::l
        PP:::::P     P:::::P                                                                      PP:::::P     P:::::P                l:::::l
          P::::P     P:::::Paaaaaaaaaaaaa  rrrrr   rrrrrrrrr       ssssssssss       eeeeeeeeeeee    P::::P     P:::::P  ooooooooooo    l::::lyyyyyyy           yyyyyyy
          P::::P     P:::::Pa::::::::::::a r::::rrr:::::::::r    ss::::::::::s    ee::::::::::::ee  P::::P     P:::::Poo:::::::::::oo  l::::l y:::::y         y:::::y
          P::::PPPPPP:::::P aaaaaaaaa:::::ar:::::::::::::::::r ss:::::::::::::s  e::::::eeeee:::::eeP::::PPPPPP:::::Po:::::::::::::::o l::::l  y:::::y       y:::::y
          P:::::::::::::PP           a::::arr::::::rrrrr::::::rs::::::ssss:::::se::::::e     e:::::eP:::::::::::::PP o:::::ooooo:::::o l::::l   y:::::y     y:::::y
          P::::PPPPPPPPP      aaaaaaa:::::a r:::::r     r:::::r s:::::s  ssssss e:::::::eeeee::::::eP::::PPPPPPPPP   o::::o     o::::o l::::l    y:::::y   y:::::y
          P::::P            aa::::::::::::a r:::::r     rrrrrrr   s::::::s      e:::::::::::::::::e P::::P           o::::o     o::::o l::::l     y:::::y y:::::y
          P::::P           a::::aaaa::::::a r:::::r                  s::::::s   e::::::eeeeeeeeeee  P::::P           o::::o     o::::o l::::l      y:::::y:::::y
          P::::P          a::::a    a:::::a r:::::r            ssssss   s:::::s e:::::::e           P::::P           o::::o     o::::o l::::l       y:::::::::y
        PP::::::PP        a::::a    a:::::a r:::::r            s:::::ssss::::::se::::::::e        PP::::::PP         o:::::ooooo:::::ol::::::l       y:::::::y
        P::::::::P        a:::::aaaa::::::a r:::::r            s::::::::::::::s  e::::::::eeeeeeeeP::::::::P         o:::::::::::::::ol::::::l        y:::::y
        P::::::::P         a::::::::::aa:::ar:::::r             s:::::::::::ss    ee:::::::::::::eP::::::::P          oo:::::::::::oo l::::::l       y:::::y
        PPPPPPPPPP          aaaaaaaaaa  aaaarrrrrrr              sssssssssss        eeeeeeeeeeeeeePPPPPPPPPP            ooooooooooo   llllllll      y:::::y
                                                                                                                                                   y:::::y
                                                                                                                                                  y:::::y
                                                                                                                                                 y:::::y
                                                                                                                                                y:::::y
                                                                                                                                               yyyyyyy



        */

function parse_poly_strings($string) {
	global $centered;
	$retval = Array();

	$regex = '~\(([0-9]|\-.*?)\)~mis';
	preg_match_all($regex, $string, $results);

	foreach($results[1] as $k => $r) {
		$pairs = explode(",", $r);
		$tmp = "[";
		foreach($pairs as $kk => $p) {
			$coordinates = explode(" ", $p);
			$lat = $coordinates[1];
			$lng = $coordinates[0];
			processboundaries($lat, $lng);
			$tmp .= "\n{lat: $lat, lng: $lng},";
		}
		$tmp = rtrim($tmp, ',');
		$tmp .= "],";
		array_push($retval, $tmp);
	}
	return $retval;
}
        function processboundaries($lat, $lng)
        {
            global $boundaries;

            if (empty($boundaries['lat_max'])) {
                $boundaries['lat_max'] = $lat;
            }

            if (empty($boundaries['lat_min'])) {
                $boundaries['lat_min'] = $lat;
            }

            if (empty($boundaries['lng_max'])) {
                $boundaries['lng_max'] = $lng;
            }

            if (empty($boundaries['lng_min'])) {
                $boundaries['lng_min'] = $lng;
            }

            if ($lng < $boundaries['lng_min']) {
                $boundaries['lng_min'] = $lng;
            }

            if ($lng > $boundaries['lng_max']) {
                $boundaries['lng_max'] = $lng;
            }

            if ($lat < $boundaries['lat_min']) {
                $boundaries['lat_min'] = $lat;
            }

            if ($lat > $boundaries['lat_max']) {
                $boundaries['lat_max'] = $lat;
            }
        }

        function centercalc($boundaries)
        {

            global $zoom;
            global $fourcode;

            //var_dump($boundaries);
            $lat_max = $boundaries['lat_max'];
            $lat_min = $boundaries['lat_min'];
            $lng_max = $boundaries['lng_max'];
            $lng_min = $boundaries['lng_min'];

            $lat_size = $lat_max - $lat_min;
            $lng_size = $lng_max - $lng_min;

            $lat_center = $lat_min + ($lat_size / 2);
            $lng_center = $lng_min + ($lng_size / 2);

            $size = $lat_size * $lng_size;

            //echo("<br>GOX LAT_MAX $lat_max LAT_MIN $lat_min LNG_MAX $lng_max LNG_MIN $lng_min<br>CENTER CALCULATED AT LAT $lat_center LNG $lng_center<br>");
            //echo("<br>SIZE: " . $size . "<br>");


            if ($size > 7000) {
                $zoom = 3;
            }

            if ($size < 7000) {
                $zoom = 3;
            }

            if ($size < 100) {
                $zoom = 7;
            }

            if ($size < 20) {
                $zoom = 7;
            }

            if ($size < 10) {
                $zoom = 8;
            }

            if ($size < 5) {
                $zoom = 8;
            }

            if ($size < .3) {
                $zoom = 9;
            }

            if ($size < .2) {
                $zoom = 10;
            }

            if ($size < .15) {
                $zoom = 11;
            }

            $retval = "{lat: $lat_center, lng: $lng_center},";

            if ($fourcode == "AK00") {
                $retval = "{lat: 64.714378, lng: -151.121811},";
                $zoom = 3;
            }

            //echo("<br>RETURNING ZOOM OF $zoom<br>");
            return $retval;
        }

        function convertfourcode($fourcode)
        {
            global $conn;
            $conn = $conn;
            $state = mb_substr($fourcode, 0, 2);
            $sql = "SELECT geoid FROM county WHERE geoid = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $code = $row['CODE'];
                }
            }
            $retval = checkaddzero($code) . mb_substr($fourcode, 2, 2);

            return $retval;
        }

        function lookupincumbent($fourcode)
        {
            global $ctb2016_conn;
            $conn = $ctb2016_conn;
            global $stats;
            $sql = "SELECT * FROM e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $party = $row['PARTY'];
                    $stats[$fourcode]['incumbent'] = $row['NAMF'] . " " . $row['NAML'];
                    $stats[$fourcode]['inc_vote'] = $row['INCUMBENT'];
                    $stats[$fourcode]['opp_vote'] = $row['CHALLENGER'];
                    $stats[$fourcode]['obama'] = $row['OBAMA'];
                    $stats[$fourcode]['clinton'] = $row['CLINTON'];
                    $stats[$fourcode]['romney'] = $row['ROMNEY'];
                    $stats[$fourcode]['trump'] = $row['TRUMP'];
                    $stats[$fourcode]['party'] = $row['PARTY'];
                }
            }

            if ($party == "R") {
                $color = get_red(3);
            } elseif ($party == "D") {
                $color = get_blue(3);
            }


            return $color;
        }

        function getallfourcodes()
        {
            global $site_conn;
            $conn = $site_conn;
            $retval = Array();
            $sql = "SELECT geoid FROM mtal WHERE total > 1 GROUP BY geoid";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dist = $row['geoid'];
                    array_push($retval, $dist);
                }
            }

            return $retval;
        }

        function lookupzoom($fourcode)
        {
            $state = mb_substr($fourcode, 0, 2);
            $bigzoom = 3;
            $midzoom = 5;
            $regzoom = 8;
            switch ($state) {
                case "AK":
                    $retval = $bigzoom;
                    break;
                case "MT":
                    $retval = $midzoom;
                    break;
                case "DE":
                    $retval = $midzoom;
                    break;
                case "WY":
                    $retval = $midzoom;
                    break;
                default:
                    $retval = 6;
            }

            return $retval;
        }

        function istargeted($fourcode)
        {
            global $fec_conn;
            $conn = $fec_conn;
            $sql = "SELECT * FROM e18_targets WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['targeted_by'];
                }
            }

            return $retval;
        }

        function get_long_county($n)
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
                "NEVADA" => "29",
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

            foreach ($conversion_array as $k => $v) {
                if ($v == $n) {
                    return $k;
                }
            }

        }

        function get_county_fourcode($name)
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
                "NEVADA" => "29",
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


            $retval = "CO" . $conversion_array[$name];

            return $retval;
        }

        ?>


  
       

    <script type="text/javascript">

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>



    </script>

     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH018pbcVij9pf5O0p-fkMI457nBV-keQ&sensor=false&callback=initMap"></script>
    

    </body>

</html>
    



