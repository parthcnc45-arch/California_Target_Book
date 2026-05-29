<!DOCTYPE html>
<html lang="en">

    <head>


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
          $(function () {
            $("#tabs").tabs();
          });

          $(function () {
            $("#years").tabs();
          });
        </script>


        <script>
          function resizeIframe(obj) {
            obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
          }

          function closeiframe(type) {
            removeiframes();
            var link = "/img/spinner.gif";
            var iframe = document.createElement('iframe');
            iframe.frameBorder = 0;
            iframe.width = "1024pxpx";
            iframe.height = "3800px";
            iframe.id = "hiddeniframe";
            iframe.name = "content";
            iframe.setAttribute("src", link);
            iframe.setAttribute("background-color", "white");
            document.getElementById("hiddendiv").appendChild(iframe);
            return false;
          }

          function removeiframes() {
            var iframes = document.querySelectorAll('iframe');
            for (var i = 0; i < iframes.length; i++) {
              iframes[i].parentNode.removeChild(iframes[i]);
            }
          }

          function valForm(form, fourcode) {

            var type, datavisappend, electionappend, e1, e2, URL, error = '';
            var URL = 'housevote_bydist.php?id=' + fourcode;


            if (error) {
              alert(URL);
              alert(error);
              return false;
            } else {
              closeiframe();


              var link = "/img/spinner.gif";
              alert(URL);
              window.content.location.href = link;
              document.getElementById("hiddendiv").style["display"] = "inline-block";
              window.content.location.href = URL;
              return false;
            }


          }


        </script>

        <style>

            body {
                background-color: white;
            }

            .dropshadow {
                -webkit-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
                -moz-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
                box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
            }

            input.button {
                background: #dedede;
                background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
                background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
                background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
                background-image: -o-linear-gradient(top, #dedede, #787878) !important;
                background-image: linear-gradient(to bottom, #dedede, #787878) !important;
                -webkit-border-radius: 28 !important;
                -moz-border-radius: 28 !important;
                border-radius: 28px !important;
                -webkit-box-shadow: 0px 1px 3px #666666 !important;
                -moz-box-shadow: 0px 1px 3px #666666 !important;
                box-shadow: 2px 2px 3px #666666 !important;
                font-family: 'Lato' !important;
                font-weight: normal !important;
                color: white !important;
                font-size: 16px !important;
                border: solid black 2px !important;
                width: 28% !important;
                margin: 0px auto !important;
                margin-right: 10px !important;
                margin-top: 0px !important;
                height: 40px !important;
                text-decoration: none !important;
                text-shadow: 1px 2px black !important;
            }

            input.button:hover {
                background: #3cb0fd !important;
                background-image: -webkit-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
                background-image: -moz-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
                background-image: -ms-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
                background-image: -o-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
                background-image: linear-gradient(to bottom, #3cb0fd, #0a3b5c) !important;
                text-decoration: none !important;
                color: white;
            }

            input.close {
                background: #3498db !important;
                display: inline;
                background: #dedede;
                background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
                background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
                background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
                background-image: -o-linear-gradient(top, #dedede, #787878) !important;
                background-image: linear-gradient(to bottom, #dedede, #787878) !important;
                -webkit-border-radius: 28 !important;
                -moz-border-radius: 28 !important;
                border-radius: 28px !important;
                -webkit-box-shadow: 0px 1px 3px #666666 !important;
                -moz-box-shadow: 0px 1px 3px #666666 !important;
                box-shadow: 0px 1px 3px #666666 !important;
                font-family: 'Lato' !important;
                font-weight: normal !important;
                color: white !important;
                font-size: 14px !important;
                border: solid black 2px !important;
                width: 10% !important;
                margin: 0px auto !important;
                margin-right: 0px !important;
                margin-top: 0px !important;
                height: 40px !important;
                text-decoration: none !important;
                text-shadow: 1px 2px black !important;
            }

            input.close:hover {
                background: #fc3c3c !important;
                background-image: -webkit-linear-gradient(top, #fc3c3c, #73001d) !important;
                background-image: -moz-linear-gradient(top, #fc3c3c, #73001d) !important;
                background-image: -ms-linear-gradient(top, #fc3c3c, #73001d) !important;
                background-image: -o-linear-gradient(top, #fc3c3c, #73001d) !important;
                background-image: linear-gradient(to bottom, #fc3c3c, #73001d) !important;
                text-decoration: none !important;
                color: white;
                scale: 1.1;
            }

            input.campaign {
                max-width: 600px !important;
            }

            #btmclose {
                display: none;
            }

            #btmclose2 {
                display: none;

            }

            #welcomeDiv {
                display: none;
            }

            #welcomeDiv2 {
                display: none;
            }

            .analysis {
                line-height: 170%;
                font-family: 'Lato';
                font-size: 1.1em;
                padding: 5%;
                text-align: justify;
                margin-left: auto;
                margin-right: auto;
            }

            .analysis strong, b {
                font-weight: bold;
                color: blue;
            }

            .analysis img {
                border-radius: 15px;
                float: left;
                max-width: 150px;
                padding: 5px;
            }

            .campaignHead {
                font-size: 2.0em;
                font-weight: bold;
                color: FireBrick;
                text-align: center;
                font-family: 'Lato';
                font-variant: small-caps;
            }

            .campaignSubHead {
                font-size: 1.5em;
                font-weight: bold;
                color: black;
                text-align: center;
                font-family: 'Lato';
                font-variant: small-caps;
            }

            iframe {
                border: none;
            }

        </style>


    </head>

    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <?php

        require_once 'php/ctb_api.php';

        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');
        setlocale(LC_COLLATE, "en_US");
        setlocale(LC_CTYPE, "en_US");
        $endjava = Array();

        $js = '  $( function() {
    $( "#tabs" ).tabs();
  });

  $( function() {
    $( "#years" ).tabs();
  });
';

        //array_push($endjava, $js);


        $fourcode = $_GET['id'];
        getstats();

        $links = get_links($fourcode);

        $x = retrieve_image($fourcode);

        $img_src = $x['IMG'];
        $bio_txt = $x['BIO'];
        $name = $x['NAME'];
        $party = $x['PARTY'];

        $incumbent_div = "<div style='float: left;'>
					<p align='center' class='campaignSubHead'>Incumbent</p>
					<img src='$img_src' width='150px' style='border-radius: 15px;' />
					<p style='font-size: 1.6em; font-family: \"Lato\"; font-weight: bold; font-variant: small-caps;'>$name ($party)</p>
				  </div>";


        $prev_url = '/ctb-legacy/get_ctb_page_t.php?id=' . $links['prev'];
        $next_url = '/ctb-legacy/get_ctb_page_t.php?id=' . $links['next'];

        //echo("<br>$prev_url<br>$next_url<br>");


        $prev_div = "<div style='float: left; width: 30%;' align='left'><a href='$prev_url'>
			<img width='50' style='padding-left: 20px;' align='left' height='50' alt='' src='img/0-PREV.png' />
			<text style='text-align: left; line-height: 50px; font-family: \"Lato\"; font-size: 1.4em;'><strong style='padding-left: 20px;'>" . $links['prev'] . "</strong></text></div></a>";

        $next_div = "<div style='float: right; width: 30%; text-align: right;'><a href='$next_url'>
			<text style='text-align: right; line-height: 50px;font-family: \"Lato\"; font-size: 1.4em;'><strong style='padding-right: 20px;'>" . $links['next'] . "</strong></text>
			<img style='padding-right: 20px;'width='50' align='right' height='50' alt='' src='img/0-NEXT.png' /></div></a>";


        $long_fourcode = "<p align='center' style='float: left; text-align: center !important; font-weight: bold; font-variant: small-caps; font-family: \"Lato\";' height='50px'>" . get_long_string($fourcode) . "</p>";

        $nav_div = "<div style='max-width: 800px !important;'>" . $prev_div . $long_fourcode . $next_div . "</div>";

        $lb = "<div width='100%' style='clear: both;'></div>";

        $adjusted = str_replace("CA", "CD", $fourcode);
        //echo("<br>$fourcode adjusted to $adjusted");


        $map = "<div style='float: left'><iframe src='get_cal_map.php?id=$adjusted' width='700px' height='520px' scrolling='no' onload='resizeIframe(this)'></iframe></div>";


        if (mb_substr($adjusted, 0, 2) != "CD") {
            $bio_txt = get_cal_incumbent_bio($fourcode);
            $bio = "<div class='analysis' style='width: 100%'>" . $bio_txt . "</div>";
            $social = "<iframe src='/ctb-legacy/get_cal_socialmedia.php?id=$fourcode' width='1090px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $org = "<iframe src='/ctb-legacy/get_cal_org.php?id=$fourcode' width='800px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";

            $e18_summary = "<iframe style='clear: both; width: 100vw;' src='/ctb-legacy/draw_ca_dist.php?id=$fourcode&year=2018'  frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e16_summary = "<iframe style='clear: both; width: 100vw;' src='/ctb-legacy/draw_ca_dist.php?id=$fourcode&year=2016'  frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e14_summary = "<iframe style='clear: both; width: 100vw;' src='/ctb-legacy/draw_ca_dist.php?id=$fourcode&year=2014'  frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e12_summary = "<iframe style='clear: both; width: 100vw;' src='/ctb-legacy/draw_ca_dist.php?id=$fourcode&year=2012'  frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";

            $e18_ies = '';
            $e16_ies = '';
            $e14_ies = '';
            $e12_ies = '';

            $e18_analysis = '';
            $e16_analysis = '';
            $e14_analysis = '';
            $e12_analysis = '';


        } else {
            $bio_txt = get_cal_incumbent_bio($adjusted);
            $bio = "<div class='analysis' style='width: 80vw;'>" . $bio_txt . "</div>";
            $social = "<iframe style='float: left; min-height: 600px; margin-top: 50px;' src='/ctb-legacy/get_fec_socialmedia.php?id=$fourcode' width='1090px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $org = "<iframe src='/ctb-legacy/get_fec_org.php?id=$fourcode' style='float: left' width='800px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";

            $e18_summary = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_financials.php?id=$fourcode&yr=2018&type=P' align='center' width='100%' height='400px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e18_ies = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_ies.php?id=$fourcode&yr=2018' width='100%' height='600px' frameborder='0' onload='resizeIframe(this)'></iframe>";
            $e18_analysis = get_fec_analysis('2018');

            $e16_votes = "<iframe src='/ctb-legacy/get_fec_elec_table.php?id=$fourcode&yr=2016' width='100%' height='200px' align='center' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e16_summary = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_financials.php?id=$fourcode&yr=2016&type=P' align='center' width='100%' height='400px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e16_ies = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_ies.php?id=$fourcode&yr=2016' width='1024px' height='600px' frameborder='0' onload='resizeIframe(this)'></iframe>";
            $e16_analysis = get_fec_analysis('2016');


            $e14_votes = "<iframe src='/ctb-legacy/get_fec_elec_table.php?id=$fourcode&yr=2014' width='100%' height='200px' align='center' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e14_summary = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_financials.php?id=$fourcode&yr=2014&type=P' align='center' width='100%' height='400px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e14_ies = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_ies.php?id=$fourcode&yr=2014' width='100%' height='600px' frameborder='0' onload='resizeIframe(this)'></iframe>";
            $e14_analysis = get_fec_analysis('2014');

            $e12_votes = "<iframe src='/ctb-legacy/get_fec_elec_table.php?id=$fourcode&yr=2012' width='100%' height='200px' align='center' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e12_summary = "<iframe style='clear: both;' src='/ctb-legacy/get_fec_financials.php?id=$fourcode&yr=2012&type=P' align='center' width='100%' height='400px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $e12_ies = "<iframe style='clear: both;'  src='/ctb-legacy/get_fec_ies.php?id=$fourcode&yr=2012' width='100%' height='600px' frameborder='0' onload='resizeIframe(this)'></iframe>";
            $e12_analysis = get_fec_analysis('2012');

            $e18_cand = "<iframe src='get_fec_candidates.php?id=" . $fourcode . "' width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";


        }


        $location = get_dist_location($fourcode);
        $profile = get_dist_profile($fourcode);

        $location_div = "<div style='width: 450px; display: block;' class='location_div'>$location</div>";
        $overlaps = "<iframe style='clear: both;' src='get_cal_contains.php?id=$adjusted' width='450px; height='400px' scrolling='no' onload='resizeIframe(this)'></iframe>";

        $loc_overlap = "<div style='float: left'><p class='campaignSubHead'>Location</p>" . $location_div . $overlaps . "</div>";


        $profile_div = "<div style='display: inline-block;' width='100%' class='profile_div'><p>$profile</p></div>";


        $tab_head = "<div id='tabs' style='width: 100%;'>
<ul>
	<li><a href='#District'>District</a></li>
	<li><a href='#Incumbent'>Incumbent</a></li>
	<li><a href='#Campaigns'>Campaigns</a></li>
	<li><a href='#Precincts'>Precincts</a></li>
</ul>";


        //echo("<div class='container' style='display: inline-block; max-width: 1280px'>");
        //echo("<section style='-webkit-transform:scale(0.8);-moz-transform-scale(0.8); width: 110%; margin-left: -10%; margin-top: -5%;'>");
        echo($nav_div);


        echo($lb);


        echo($tab_head);

        echo("<div id='District'>");

        echo($incumbent_div);
        echo($map);
        echo($loc_overlap);
        echo($profile_div);
        echo("</div>");

        echo("<div id='Incumbent'>");
        //echo("<p>INCUMBENT INFORMATION HERE</p>");
        echo($bio);
        echo($org);
        echo($social);
        echo("</div>");

        echo("<div id='Campaigns'>");

        $year_head = "<div id='years'>
	<ul>
	<li><a href='#e2018'>2018</a></li>
	<li><a href='#e2016'>2016</a></li>
	<li><a href='#e2014'>2014</a></li>
	<li><a href='#e2012'>2012</a></li>
</ul>";
        echo($year_head);

        echo("<div id='e2018'>");
        echo("<p class='campaignHead'>Campaign 2018</p>");
        echo($e18_analysis);
        echo($e18_summary);
        echo($e18_cand);
        echo($e18_ies);
        echo("</div>");

        echo("<div id='e2016'>");
        echo("<p class='campaignHead'>Campaign 2016</p>");
        echo($e16_votes);
        echo($e16_analysis);
        echo($e16_summary);
        echo($e16_ies);
        echo("</div>");

        echo("<div id='e2014'>");
        echo("<p class='campaignHead'>Campaign 2014</p>");
        echo($e14_votes);
        echo($e14_analysis);
        echo($e14_summary);
        echo($e14_ies);
        echo("</div>");

        echo("<div id='e2012'>");
        echo("<p class='campaignHead'>Campaign 2012</p>");
        echo($e12_votes);
        echo($e12_analysis);
        echo($e12_summary);
        echo($e12_ies);
        echo("</div>");

        echo("</div>"); //END YEARS DIV

        echo("<div id='Precincts'>");
        echo("<p>PRECINCTS STUFF</p>");
        echo("</div>");

        echo("</div>"); //END TABS DIV
        //echo("</section>");
        //echo("</div>");
        /*
        $draw = "<div id='tabs'>
          <ul>
            <li><a href='#tabs-1'>Nunc tincidunt</a></li>
            <li><a href='#tabs-2'>Proin dolor</a></li>
            <li><a href='#tabs-3'>Aenean lacinia</a></li>
          </ul>
          <div id='tabs-1'>
            <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
          </div>
          <div id='tabs-2'>
            <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
          </div>
          <div id='tabs-3'>
            <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
            <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
          </div>
        </div>";


        echo($draw);

        */

        function get_cal_incumbent_bio($fourcode)
        {
            global $site_conn;
            $conn = $site_conn;
            $incumbent_id = get_cal_incumbent($fourcode);
            //echo("<br>RETRIEVED INCUMBENT ID: $incumbent_id FOR $fourcode<br>");
            $bio = get_cal_bio($incumbent_id);

            //echo("<br>RETRIEVED<br>$bio<br>");
            return $bio;
        }

        function get_cal_bio($cand_id)
        {
            global $site_conn;
            $conn = $site_conn;
            $sql = "SELECT text FROM cand_bios WHERE cand_id = '$cand_id' ORDER BY date DESC, id DESC LIMIT 1";
            //echo("<Br>$sql");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function get_cal_incumbent($fourcode)
        {
            global $ctb2016_conn;
            $conn = $ctb2016_conn;
            $sql = "SELECT CAND_ID FROM e18_incumbent WHERE DIST = '$fourcode'";
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['CAND_ID'];
                }
            }

            return $retval;
        }


        function get_fec_analysis($year)
        {
            global $site_conn;
            $conn = $site_conn;
            global $fourcode;
            $sql = "SELECT text from analysis WHERE dist = '$fourcode' && year = '$year' ORDER BY date DESC, id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function is_targeted()
        {
            global $fourcode;
            global $fec_conn;
            $conn = $fec_conn;
            $sql = "SELECT targeted_by FROM e18_targets WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $x = $row['targeted_by'];
                }
            }
            if ($x == "DCCC") {
                $retval = "<span class='boldme blueme'>2018 DCCC Target</span>";
            }

            if ($x == "NRCC") {
                $retval = "<span class='boldme redme'>2018 NRCC Target</span>";
            }

            return $retval;
        }

        function getstats()
        {
            global $incumbent;
            global $hrc;
            global $djt;
            global $bho;
            global $wmr;
            global $party;
            global $fourcode;
            global $ctb2016_conn;
            $conn = $ctb2016_conn;

            $sql = "SELECT * FROM e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $incumbent = $row['NAMF'] . " " . $row['NAML'];
                    $party = $row['PARTY'];
                    $hrc = $row['CLINTON'];
                    $djt = $row['TRUMP'];
                    $bho = $row['OBAMA'];
                    $wmr = $row['ROMNEY'];
                }
            }
        }

        function get_links($fourcode)
        {
            $x = Array(
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
                "WY00"

            );

            $i = 0;
            foreach ($x as $dist) {
                if ($dist == $fourcode) {
                    $prev = $x[$i - 1];
                    $next = $x[$i + 1];
                    break;
                }
                $i++;
            }
            if (!$prev) {
                $prev = "WY00";
            }

            if (!$next) {
                $next = "AK00";
            }

            $links['prev'] = $prev;
            $links['next'] = $next;

            return $links;
        }

        function get_long_string($fourcode)
        {
            $state = mb_substr($fourcode, 0, 2);
            $dist = mb_substr($fourcode, 2, 2);

            $long_state = convert_state($state);
            $long_dist = convert_district($dist);

            return $long_state . "<br>" . $long_dist . " Congressional District";
        }

        function convert_district($dist)
        {
            $longform = Array(
                "00" => "At Large",
                "01" => "First",
                "02" => "Second",
                "03" => "Third",
                "04" => "Fourth",
                "05" => "Fifth",
                "06" => "Sixth",
                "07" => "Seventh",
                "08" => "Eighth",
                "09" => "Ninth",
                "10" => "Tenth",
                "11" => "Eleventh",
                "12" => "Twelfth",
                "13" => "Thirteenth",
                "14" => "Fourteenth",
                "15" => "Fifteenth",
                "16" => "Sixteenth",
                "17" => "Seventeenth",
                "18" => "Eighteenth",
                "19" => "Nineteenth",
                "20" => "Twentieth",
                "21" => "Twenty-First",
                "22" => "Twenty-Second",
                "23" => "Twenty-Third",
                "24" => "Twenty-Fourth",
                "25" => "Twenty-Fifth",
                "26" => "Twenty-Sixth",
                "27" => "Twenty-Seventh",
                "28" => "Twenty-Eighth",
                "29" => "Twenty-Ninth",
                "30" => "Thirtieth",
                "31" => "Thirty-First",
                "32" => "Thirty-Second",
                "33" => "Thirty-Third",
                "34" => "Thirty-Fourth",
                "35" => "Thirty-Fifth",
                "36" => "Thirty-Sixth",
                "37" => "Thirty-Seventh",
                "38" => "Thirty-Eighth",
                "39" => "Thirty-Ninth",
                "40" => "Fortieth",
                "41" => "Forty-First",
                "42" => "Forty-Second",
                "43" => "Forty-Third",
                "44" => "Forty-Fourth",
                "45" => "Forty-Fifth",
                "46" => "Forty-Sixth",
                "47" => "Forty-Seventh",
                "48" => "Forty-Eighth",
                "49" => "Forty-Ninth",
                "50" => "Fiftieth",
                "51" => "Fifty-First",
                "52" => "Fifty-Second",
                "53" => "Fifty-Third",

            );

            return $longform[$dist];
        }

        function convert_state($name, $to = 'abbrev')
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
                array('name' => 'Alberta', 'abbrev' => 'AB'),
                array('name' => 'British Columbia', 'abbrev' => 'BC'),
                array('name' => 'Manitoba', 'abbrev' => 'MB'),
                array('name' => 'New Brunswick', 'abbrev' => 'NB'),
                array('name' => 'Newfoundland', 'abbrev' => 'NL'),
                array('name' => 'Northwest Territories', 'abbrev' => 'NT'),
                array('name' => 'Nova Scotia', 'abbrev' => 'NS'),
                array('name' => 'Nunavut', 'abbrev' => 'NU'),
                array('name' => 'Ontario', 'abbrev' => 'ON'),
                array('name' => 'Prince Edward Island', 'abbrev' => 'PE'),
                array('name' => 'Quebec', 'abbrev' => 'QC'),
                array('name' => 'Saskatchewan', 'abbrev' => 'SK'),
                array('name' => 'Yukon Territory', 'abbrev' => 'YT')
            );

            $return = false;
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


        //echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");

        function retrieve_image($fourcode)
        {
            global $ctb2016_conn;
            $conn = $ctb2016_conn;
            $sql = "SELECT BIOGUIDE, NAML, NAMF, PARTY FROM e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bioguide = $row['BIOGUIDE'];
                    $name = $row['NAMF'] . " " . $row['NAML'];
                    $party = $row['PARTY'];
                }
            }
            $img_url = "/img/congress/" . $bioguide . ".jpg";
            $bio_txt = retrieve_bio($bioguide);

            $retval['IMG'] = $img_url;
            $retval['BIO'] = $bio_txt;
            $retval['NAME'] = $name;
            $retval['PARTY'] = $party;

            return $retval;
        }

        function get_dist_location($fourcode)
        {
            global $site_conn;
            $conn = $site_conn;
            $sql = "SELECT text from dist_loc WHERE dist = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function get_dist_profile($fourcode)
        {
            global $site_conn;
            $conn = $site_conn;
            $sql = "SELECT text from dist_profile WHERE dist='$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function retrieve_bio($id)
        {
            global $fec_conn;
            $conn = $fec_conn;
            $sql = "SELECT bio FROM bios WHERE bioguide = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['bio'];
                }
            }

            return $retval;
        }

        function drawreg($fourcode)
        {

            if (mb_substr($fourcode, 0, 2) == "CA") {
                global $ctb2016_conn;
                $conn = $ctb2016_conn;
                $dist = mb_substr($fourcode, 2, 2);
                $adjusted = "CD" . $dist;
                $sql = "SELECT * FROM sos_oct16 WHERE DIST = '$adjusted'";
            } else {
                global $fl_conn;
                $conn = $fl_conn;
                $sql = "SELECT * FROM state_reg WHERE FOURCODE = '$fourcode'";
            }

            //echo("<br>$sql<br>");
            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $dem = $row['DEM'];
                    $rep = $row['REP'];
                    $npp = $row['NPP'];
                    $tot = $row['TOT'];
                    $oth = $row['OTH'];
                }
            }

            $dem_pct = makeplainpercent($dem, $tot);
            $rep_pct = makeplainpercent($rep, $tot);

            $dem_pct_draw = makepct($dem, $tot);
            $rep_pct_draw = makepct($rep, $tot);
            $npp_pct_draw = makepct($npp, $tot);
            $oth_pct_draw = makepct($oth, $tot);

            if ($dem_pct > $rep_pct) {
                $advantage = "<span class='blueme boldme'>D +" . number_format(($dem_pct - $rep_pct), 2) . "%</span>";
            }

            if ($rep_pct > $dem_pct) {
                $advantage = "<span class='redme boldme'>R +" . number_format(($rep_pct - $dem_pct), 2) . "%</span>";
            }

            $drawme = "
        <p class='boldme' align='center'>TOTAL VOTERS: " . number_format($tot) . "</p><p align='center'>$advantage</p><p align='center'><span class='blueme boldme'>DEM: $dem_pct_draw</span>&nbsp;--&nbsp;<span class='redme boldme'>REP: $rep_pct_draw</span>&nbsp;--&nbsp;NPP: $npp_pct_draw -- OTH: $oth_pct_draw</p>";

            if (!$dem) {
                $drawme = '';
            }

            $arr = Array("AL", "GA", "HI", "IL", "IN", "MI", "MN", "MS", "MO", "MT", "ND", "OH", "SC", "TN", "TX", "VT", "VA", "WA", "WI");
            foreach ($arr as $entry) {
                $thisstate = mb_substr($fourcode, 0, 2);
                //echo("<br>COMPARING $thisstate with Array entry $entry");
                if (mb_substr($fourcode, 0, 2) == $entry) {
                    $drawme = "<h2 class='' align='center'>This State Does Not Have Partisan Voter Registration</h2>";
                }
            }

            $arr = Array("AR", "CT", "ID", "MA", "NE", "NH", "NC", "OK", "PA", "RI", "UT", "WV");
            foreach ($arr as $entry) {
                if (mb_substr($fourcode, 0, 2) == $entry) {
                    $drawme = "<h2 class='' align='center'>This State Fails to Provide its Partisan Registration by Congressional District</h2>";
                }
            }

            return $drawme;

        }

        function makeplainpercent($portion, $total)
        {
            $x = ($portion / $total) * 100;

            return $x;
        }

        function getanalysis($fourcode, $year)
        {
            global $fec_conn;
            $conn = $fec_conn;
            $sql = "SELECT text FROM analysis WHERE fourcode = '$fourcode' && year = $year";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        ?>

    </body>


    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

</html>
