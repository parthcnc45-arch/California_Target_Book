<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .container #map {
        width: 640px;
        height: 480px;
    }

    .gm-style-iw {
        height: 480px !important;
        width: 640px !important;
    }

    .newseg .stw {
        float: left;
        display: inline-block;
        margin: 5px;
        border: 2px solid black;
        padding: 5px;

    }
</style>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
ini_set('memory_limit', '1512M');

Util::set_errors();
Util::require_ctb_api();

setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");
set_time_limit(0);


$conn = Util::get_ctb_conn();

$precincts = Array();
$endjava = Array();
$candidate_array = Array();
$coordinates = Array();


$fourcode = $id;

if (!$fourcode) {
    $fourcode = $_GET['id'];
}

//$allfourcodes = getallfourcodes();

$allfourcodes = Array($fourcode);

foreach ($allfourcodes as $x) {
    $converted = convertfourcode($x);
    $tmp['fourcode'] = $x;
    $tmp['converted'] = $converted;
    array_push($precincts, $tmp);
}

$converted = convertfourcode($fourcode);


$distno = mb_substr($fourcode, 2, 2);
$converted_county = ($distno * 2) - 1;

$mainfourcode = $fourcode;


//echo("<br>CANDIDATE ARRAY:<br>");
//var_dump($candidate_array);

$i = 1;


//$precincts = get_g16_precincts($mainfourcode, $election);
//$precincts = get_null_precincts();


//echo("<br>PRECINCT DUMP:<br>");
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
    $srprec = $precinct['converted'];
    $fourcode = $precinct['fourcode'];

    $x = get_g16_precinct_polygons($srprec);

    if ($dumpmode) {
        echo("<br>DUMP OF PRECINCT POLGYONS:<br>");
        var_dump($x);
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


// $zoom = lookupzoom($fourcode);

global $boundaries;
$center = centercalc($boundaries);

$lat_max = $boundaries['lat_max'];
$lat_min = $boundaries['lat_min'];
$lng_max = $boundaries['lng_max'];
$lng_min = $boundaries['lng_min'];

//INITIALIZING PORTION OF JAVASCRIPT
$js = "
	  var polys = [];

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: $center

          mapTypeId: google.maps.MapTypeId.TERRAIN
        });
        var bounds = new google.maps.LatLngBounds();
        var loc1 = new google.maps.LatLng({ lat: $lat_max, lng: $lng_max });
        var loc2 = new google.maps.LatLng({ lat: $lat_min, lng: $lng_min });
        bounds.extend(loc1);
        bounds.extend(loc2);

        map.fitBounds(bounds); 

		var infowindow = new google.maps.InfoWindow({
			content: \"Blah\"
		});

		$(window).resize(function() {
			google.maps.event.trigger(map, 'resize');
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

    $srprec = $value['converted'];
    $fourcode = $value['fourcode'];
    $precinct = $srprec;

    $ad_candidates = '';
    $cd_candidates = '';
    $sd_candidates = '';

    $gov_candidates = '';
    $ltg_candidates = '';
    $atg_candidates = '';
    $sos_candidates = '';
    $trs_candidates = '';
    $con_candidates = '';
    $ins_candidates = '';
    $spi_candidates = '';

    $sen_candidates = '';

    $dpp_candidates = '';
    $rpp_candidates = '';

    $prs_candidates = '';

    $votes = Array();

    $ad_vote = 0;
    $sd_vote = 0;
    $cd_vote = 0;

    $gov_vote = 0;
    $ltg_vote = 0;
    $atg_vote = 0;
    $sos_vote = 0;
    $trs_vote = 0;
    $con_vote = 0;
    $ins_vote = 0;
    $spi_vote = 0;
    $sen_vote = 0;
    $dpp_vote = 0;
    $rpp_vote = 0;
    $prs_vote = 0;

    $num_ad_candidates = 0;
    $num_sd_candidates = 0;
    $num_cd_candidates = 0;

    $num_gov_candidates = 0;
    $num_ltg_candidates = 0;
    $num_atg_candidates = 0;
    $num_sos_candidates = 0;
    $num_trs_candidates = 0;
    $num_con_candidates = 0;
    $num_ins_candidates = 0;
    $num_spi_candidates = 0;
    $num_dpp_candidates = 0;
    $num_rpp_candidates = 0;
    $num_sen_candidates = 0;
    $num_prs_candidates = 0;

    $dem_sd = 0;
    $dem_ad = 0;
    $dem_cd = 0;

    $dem_gov = 0;
    $dem_ltg = 0;
    $dem_atg = 0;
    $dem_sos = 0;
    $dem_trs = 0;
    $dem_con = 0;
    $dem_ins = 0;
    $dem_spi = 0;
    $dem_dpp = 0;
    $dem_sen = 0;

    $rep_sd = 0;
    $rep_ad = 0;
    $rep_cd = 0;

    $rep_gov = 0;
    $rep_ltg = 0;
    $rep_atg = 0;
    $rep_sos = 0;
    $rep_trs = 0;
    $rep_con = 0;
    $rep_ins = 0;
    $rep_spi = 0;
    $rep_rpp = 0;
    $rep_sen = 0;

    $ind_sd = 0;
    $ind_cd = 0;
    $ind_ad = 0;


    //$dist = checkaddzero($i);
    //$fourcode = "AD$dist";


    //echo("...left routine with COLOR: $color");

    if (!$coordinates[$precinct]['COORDINATES'] && !$coordinates[$precinct]['POLYS']) {
        echo("<BR>NO COORDINATES!!!<br>");
        continue;
    }

    $color = lookupincumbent($fourcode);
    $targeted_by = istargeted($fourcode);
    if ($targeted_by == "DCCC") {
        $targeted_span = "<p align='center'><span class='blueme boldme itcme'>*On the DCCC's 2018 Target List</span></p>";
    } elseif ($targeted_by == "NRCC") {
        $targeted_span = "<p align='center'><span class='redme boldme itcme'>*On the NRCC's 2018 Target List</span></p>";
    } else {
        $targeted_span = '';
    }

    $incumbent = $stats[$fourcode]['incumbent'];
    $inc_vote = $stats[$fourcode]['inc_vote'];
    $opp_vote = $stats[$fourcode]['opp_vote'];
    $obama = $stats[$fourcode]['obama'];
    $clinton = $stats[$fourcode]['clinton'];
    $romney = $stats[$fourcode]['romney'];
    $trump = $stats[$fourcode]['trump'];
    $party = $stats[$fourcode]['party'];

    if ($clinton > $trump) {
        $g16_winner = "<span class='blueme boldme'>CLINTON +" . number_format(($clinton - $trump), 1) . "</span>";
        $g16 = "Clinton $clinton % / Trump $trump %";
    } else {
        $g16_winner = "<span class='redme boldme'>TRUMP +" . number_format(($trump - $clinton), 1) . "</span>";
        $g16 = "Trump $trump % / Clinton $clinton %";
    }

    if ($obama > $romney) {
        $g12_winner = "<span class='blueme boldme'>OBAMA +" . number_format(($obama - $romney), 1) . "</span>";
        $g12 = "Obama $obama % / Romney $romney %";
    } else {
        $g12_winner = "<span class='redme boldme'>ROMNEY +" . number_format(($romney - $obama), 1) . "</span>";
        $g12 = "Romney $romney % / Obama $obama %";
    }


    $container_start = "<div class='container;' style='display: inline-block;'>";
    $container_end = "</div>";


    $htmlhead = "<section class='newseg boldme'><h1 align='center'>$fourcode</h1><p align='center' class='boldme'>$incumbent ($party)</p><p align='center' class='boldme'>Last Re-Elected $inc_vote % / $opp_vote %<br>";
    $htmlhead .= $g16_winner . "<br>" . $g16 . "<br>" . $g12_winner . "<br>" . $g12 . $targeted_span . "</section>";


    //echo("...and populating HTML with <span style='color: \"$color;\"'>color $color</span>");

    $html = $container_start . $htmlhead . $container_end;

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


echo("<section class='container embed-responsive embed-responsive-4by3' style='display: inline-block; overflow: hidden;'>");
echo("<div id='map_canvas' class='embed-responsive-item' width='800px' height='600px'></div>");
echo("<div id='map' width='800px' height='600px'></div>");
echo("</section>");


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
    $conn = Util::get_ctb_conn();
    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];

    $year = mb_substr($election, 1, 2);
    if ($year < 12) {
        $use_districts = "g08";
    } else {
        $use_districts = "g14";
    }

    $sql = "SELECT * FROM ctb2016_$use_districts WHERE $disttype = '$distno' GROUP BY county, cddist, addist, sddist";
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
    $conn = Util::get_ctb_conn();


    //$election = 'p16';
    //$eyear = mb_substr($election, 1,2);
    //$esearch = "p" . $eyear;


    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];
    //$sql = "SELECT distkey, party, name, is_incumbent, disttype, CAST(distnum AS UNSIGNED) AS distnum FROM candidates where disttype='$disttype' && distnum='$distno' && election = '$election'";
    $sql = "SELECT * FROM ctb2016_candidates WHERE disttype = '$disttype' && (distnum = '$distno' || distnum = '" . checkaddzero($distno) . "') && election = '$election'";
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

function get_stats($precinct, $county)
{
    global $ctb2016_conn;
    global $election;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_g16_temp WHERE pct16 = '$precinct'";
    //echo("<br>STATS SQL:<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['addist']) {
                $retval['AD'] = $row['addist'];
                $retval['CD'] = $row['cddist'];
                $retval['SD'] = $row['sddist'];
            } else {
                $retval['AD'] = $row['ADDIST'];
                $retval['CD'] = $row['CDDIST'];
                $retval['SD'] = $row['SDDIST'];
            }
            $retval['TOTREG'] = $row['TOTREG'];
            $retval['TOTVOTE'] = $row['TOTVOTE'];
            $retval['ALL'] = $row;
        }
    }

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
    global $ctb2016_conn;
    global $election;
    global $converted_county;
    if ($converted_county < 100) {
        $county = "0" . $converted_county . "-";
    }

    if ($converted_county < 10) {
        $county = "00" . $converted_county . "-";
    }
    $x = checkaddzero($converted_county);
    $conn = Util::get_ctb_conn();


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


function get_g16_precinct_polygons($id)
{
    $conn = Util::get_ctb_conn();
    global $table;
    global $election;
    global $dist;

    $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM house_maps_house WHERE geoid = '$id'";

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


function get_precinct_polygons($srprec, $county)
{
    global $precincts_conn;
    $conn = Util::get_ctb_conn();
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

function parse_poly_strings($string)
{
    //echo("<br>PARSING STRING...<br>");
    //echo($string);
    global $centered;
    if (strpos($string, "MULTIPOLYGON") === FALSE) {

        $retval = '[';
        $initial = str_replace("(", "", $string);
        $initial = str_replace(")", "", $initial);
        $initial = str_replace("POLYGON", "", $initial);
        $initial = str_replace("MULTI", "", $initial);
        //echo("<br>STRIPPED CHARACTERS, STRING IS NOW:<br>$initial");
        $arr = explode(",", $initial);


        $first = '';
        foreach ($arr as $value) {
            $coordinates = explode(" ", $value);
            $lat = $coordinates[1];
            $lng = $coordinates[0];
            processboundaries($lat, $lng);
            //echo("<br>LAT: $lat LNG: $lng<br>");
            $retval .= "\n{lat: $lat, lng: $lng},";
            if (!$centered) {
                $centered = "{lat: $lat, lng: $lng},";
            }

        }
        $retval = rtrim($retval, ',');
        $retval .= "],";

        //echo("<br>RETURNING:<br>$retval<br>");
        return $retval;
    } else {

        $retval = Array();

        //echo("<br>FOUND MULTIPOLYGON STRING<br>");
        //echo($string);
        $dumpmode = TRUE;


        $initial = str_replace("MULTIPOLYGON(", "", $string);
        $arr = explode("((", $initial);
        $i = 0;
        foreach ($arr as $poly) {
            $tmp = "[";
            $poly = str_replace("(", "", $poly);
            $poly = str_replace(")", "", $poly);
            $points = explode(",", $poly);
            foreach ($points as $entry) {
                $coordinates = explode(" ", $entry);
                $lat = $coordinates[1];
                $lng = $coordinates[0];
                processboundaries($lat, $lng);
                if ($lat && $lng) {
                    $tmp .= "\n{lat: $lat, lng: $lng},";
                    if (!$centered) {
                        $centered = "{lat: $lat, lng: $lng},";
                    }
                }
            }
            $tmp = rtrim($tmp, ',');
            $tmp .= "],";
            if ($i > 0) {
                array_push($retval, $tmp);
            }


            $i++;

        }
        //$retval[$i] = rtrim($retval[$i], ',');
        //$retval .= "],";
        //$retval = str_replace("(),", "", $retval);
        //echo("<br>PARSED MULTIPOLYGON STRING RETURNS ARRAY VALUES:<br>");
        //var_dump($retval);
        return $retval;

    }

}

function processboundaries($lat, $lng)
{
    global $boundaries;

    if (!$boundaries['lat_max']) {
        $boundaries['lat_max'] = $lat;
    }

    if (!$boundaries['lat_min']) {
        $boundaries['lat_min'] = $lat;
    }

    if (!$boundaries['lng_max']) {
        $boundaries['lng_max'] = $lng;
    }

    if (!$boundaries['lng_min']) {
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
    $conn = Util::get_ctb_conn();
    $state = mb_substr($fourcode, 0, 2);
    $sql = "SELECT CODE FROM house_maps_codes WHERE STATE = '$state'";
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
    $conn = Util::get_ctb_conn();
    global $stats;
    $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
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
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT DIST FROM ctb2016_e18_fed GROUP BY DIST";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dist = $row['DIST'];
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
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM nufec_e18_targets WHERE fourcode = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['targeted_by'];
        }
    }

    return $retval;
}


?>




<?php

echo('<script>');
foreach ($endjava as $value) {
    echo($value);
}

echo('</script>');

?>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH018pbcVij9pf5O0p-fkMI457nBV-keQ&sensor=false&callback=initMap"></script>


