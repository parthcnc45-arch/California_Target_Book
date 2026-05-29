@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FPPC 2023 Lobbying Totals | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FPPC 2023 Lobbying Totals
    </h2>

<?php

$sections = Array(
    "EMPLOYERS" => "groups",
    "FIRMS" => "local_atm" 
);

$endjava = Array();

$js = " jQuery.tablesorter.addParser({
      id: \"fancyNumber\",
      is: function(s) {
        return /^[0-9]?[0-9,\.]*$/.test(s);
      },
      format: function(s) {
        return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
      },
      type: \"numeric\"
    });

";
array_push($endjava, $js);

$js = "$(document).ready(function() {
        $('#lemp_table').tablesorter({ 
                headers: {
                1: {
                    sorter: 'fancyNumber'
                },
                    2: {
                    sorter: 'fancyNumber'
                },
                3: {
                    sorter: 'fancyNumber'
                },
                4: {
                    sorter: 'fancyNumber'
                }, 
                5: {
                    sorter: 'fancyNumber'
                } 
                    } 
            });
    });";
array_push($endjava, $js);

$js = "$(document).ready(function() {
        $('#lfirm_table').tablesorter({ 
                headers: {
                1: {
                    sorter: 'fancyNumber'
                },
                2: {
                    sorter: 'fancyNumber'
                },
                3: {
                    sorter: 'fancyNumber'
                },
                4: {
                    sorter: 'fancyNumber'
                },
                5: {
                    sorter: 'fancyNumber'
                }


                    } 
            });
    });";
array_push($endjava, $js);


$nav_draw = '';
$enddraw = '';


$count = 0;
foreach($sections as $section => $icon) {
    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>$icon</i>
                        $section
                    </a>
                  </li>";



    $enddraw .= "<section id='p$section' class='$active_class'> <!--BEGIN SECTION DIV-->";
    $enddraw .= "<div class='prop_div' align='center'> <!--BEGIN PROP DIV--> ";
    $enddraw .= "<h2>$section</h2>";

   if($section == "EMPLOYERS") {

    $text = get_lobby_table_emp();

        $enddraw .= "<div class='panel justifyme'> <!--BEGIN EMPLOYERS PANEL DIV -->
                    <p style = 'text-align: justify !important;'>";
	$enddraw .= "<p>Employers (Grand Total in Dollars: Total Payments to In-House Employee Lobbyists + Total Payments to Lobbying Firms + Total Activity Expenses 			+ Total Other Payments to Influence)</p>";
        $enddraw .= $text;
        $enddraw .= "</p>
                     </div> <!--END EMPLOYERS PANEL DIV-->
                </div> <!--END EMPLOYERS PROP DIV--> 
                </section> <!--END EMPLOYERS SECTION -->";

   } elseif($section == "FIRMS") {

    $text = get_lobby_table_firm();
        $enddraw .= "<div class='panel justifyme'> <!--BEGIN FIRMS PANEL DIV --> 
                    <p style = 'text-align: justify !important;'>";
	$enddraw .= "<p>Firms (Grand Total in Dollars of Total Payments Received)</p>";
        $enddraw .= $text;
        $enddraw .= "</p>
                     </div>  <!--END FIRMS PANEL DIV -->
                </div>  <!--END FIRMS PROP DIV -->
                </section> <!-- END FIRMS SECTION -->";  
   }
}



echo("
        
        <div class='row'> <!--BEGIN MAIN ROW -->
            <div class='col-lg-10 center-block fn'> <!--BEGIN NAV DIV -->
                <nav class='clearfix page-nav'>
                    <ul class='clearfix'>
                        $nav_draw
                    </ul>
                </nav>
            </div> <!--END NAV DIV-->    

        <div class='content-wrap pt-xl'> <!--BEGIN CONTENT WRAP -->
        <!--BEGIN ENDDRAW-->

            $enddraw

       <!--END ENDDRAW-->

        </div> <!--END CONTENT WRAP -->
    
    </div> <!--END MAIN ROW-->
        
");


/*

FFFFFFFFFFFFFFFFFFFFFFIIIIIIIIIIRRRRRRRRRRRRRRRRR   MMMMMMMM               MMMMMMMM
F::::::::::::::::::::FI::::::::IR::::::::::::::::R  M:::::::M             M:::::::M
F::::::::::::::::::::FI::::::::IR::::::RRRRRR:::::R M::::::::M           M::::::::M
FF::::::FFFFFFFFF::::FII::::::IIRR:::::R     R:::::RM:::::::::M         M:::::::::M
  F:::::F       FFFFFF  I::::I    R::::R     R:::::RM::::::::::M       M::::::::::M
  F:::::F               I::::I    R::::R     R:::::RM:::::::::::M     M:::::::::::M
  F::::::FFFFFFFFFF     I::::I    R::::RRRRRR:::::R M:::::::M::::M   M::::M:::::::M
  F:::::::::::::::F     I::::I    R:::::::::::::RR  M::::::M M::::M M::::M M::::::M
  F:::::::::::::::F     I::::I    R::::RRRRRR:::::R M::::::M  M::::M::::M  M::::::M
  F::::::FFFFFFFFFF     I::::I    R::::R     R:::::RM::::::M   M:::::::M   M::::::M
  F:::::F               I::::I    R::::R     R:::::RM::::::M    M:::::M    M::::::M
  F:::::F               I::::I    R::::R     R:::::RM::::::M     MMMMM     M::::::M
FF:::::::FF           II::::::IIRR:::::R     R:::::RM::::::M               M::::::M
F::::::::FF           I::::::::IR::::::R     R:::::RM::::::M               M::::::M
F::::::::FF           I::::::::IR::::::R     R:::::RM::::::M               M::::::M
FFFFFFFFFFF           IIIIIIIIIIRRRRRRRR     RRRRRRRMMMMMMMM               MMMMMMMM


*/

function get_lobby_table_firm() {
	$x = file_get_contents('uploaded/lobbyfirm2023.html');
	return $x;
}

/*

EEEEEEEEEEEEEEEEEEEEEEMMMMMMMM               MMMMMMMMPPPPPPPPPPPPPPPPP   LLLLLLLLLLL                  OOOOOOOOO     YYYYYYY       YYYYYYYEEEEEEEEEEEEEEEEEEEEEERRRRRRRRRRRRRRRRR   
E::::::::::::::::::::EM:::::::M             M:::::::MP::::::::::::::::P  L:::::::::L                OO:::::::::OO   Y:::::Y       Y:::::YE::::::::::::::::::::ER::::::::::::::::R  
E::::::::::::::::::::EM::::::::M           M::::::::MP::::::PPPPPP:::::P L:::::::::L              OO:::::::::::::OO Y:::::Y       Y:::::YE::::::::::::::::::::ER::::::RRRRRR:::::R 
EE::::::EEEEEEEEE::::EM:::::::::M         M:::::::::MPP:::::P     P:::::PLL:::::::LL             O:::::::OOO:::::::OY::::::Y     Y::::::YEE::::::EEEEEEEEE::::ERR:::::R     R:::::R
  E:::::E       EEEEEEM::::::::::M       M::::::::::M  P::::P     P:::::P  L:::::L               O::::::O   O::::::OYYY:::::Y   Y:::::YYY  E:::::E       EEEEEE  R::::R     R:::::R
  E:::::E             M:::::::::::M     M:::::::::::M  P::::P     P:::::P  L:::::L               O:::::O     O:::::O   Y:::::Y Y:::::Y     E:::::E               R::::R     R:::::R
  E::::::EEEEEEEEEE   M:::::::M::::M   M::::M:::::::M  P::::PPPPPP:::::P   L:::::L               O:::::O     O:::::O    Y:::::Y:::::Y      E::::::EEEEEEEEEE     R::::RRRRRR:::::R 
  E:::::::::::::::E   M::::::M M::::M M::::M M::::::M  P:::::::::::::PP    L:::::L               O:::::O     O:::::O     Y:::::::::Y       E:::::::::::::::E     R:::::::::::::RR  
  E:::::::::::::::E   M::::::M  M::::M::::M  M::::::M  P::::PPPPPPPPP      L:::::L               O:::::O     O:::::O      Y:::::::Y        E:::::::::::::::E     R::::RRRRRR:::::R 
  E::::::EEEEEEEEEE   M::::::M   M:::::::M   M::::::M  P::::P              L:::::L               O:::::O     O:::::O       Y:::::Y         E::::::EEEEEEEEEE     R::::R     R:::::R
  E:::::E             M::::::M    M:::::M    M::::::M  P::::P              L:::::L               O:::::O     O:::::O       Y:::::Y         E:::::E               R::::R     R:::::R
  E:::::E       EEEEEEM::::::M     MMMMM     M::::::M  P::::P              L:::::L         LLLLLLO::::::O   O::::::O       Y:::::Y         E:::::E       EEEEEE  R::::R     R:::::R
EE::::::EEEEEEEE:::::EM::::::M               M::::::MPP::::::PP          LL:::::::LLLLLLLLL:::::LO:::::::OOO:::::::O       Y:::::Y       EE::::::EEEEEEEE:::::ERR:::::R     R:::::R
E::::::::::::::::::::EM::::::M               M::::::MP::::::::P          L::::::::::::::::::::::L OO:::::::::::::OO     YYYY:::::YYYY    E::::::::::::::::::::ER::::::R     R:::::R
E::::::::::::::::::::EM::::::M               M::::::MP::::::::P          L::::::::::::::::::::::L   OO:::::::::OO       Y:::::::::::Y    E::::::::::::::::::::ER::::::R     R:::::R
EEEEEEEEEEEEEEEEEEEEEEMMMMMMMM               MMMMMMMMPPPPPPPPPP          LLLLLLLLLLLLLLLLLLLLLLLL     OOOOOOOOO         YYYYYYYYYYYYY    EEEEEEEEEEEEEEEEEEEEEERRRRRRRR     RRRRRRR
                                                                                                                                                                                   
                                                                                                                                                                                   

*/

function get_lobby_table_emp() {
	$x = file_get_contents('uploaded/lobbyemp2023.html');
	return $x;

}

?>  


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    foreach($endjava as $value) {
        echo($value);
    }

?>

</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

th {
  color: white !important;
}

</style>


@endsection