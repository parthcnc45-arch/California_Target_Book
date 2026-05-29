<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include "php/head.php" ?>


        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #map {
                height: 100%;
            }
        </style>

    </head>


    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <?php

        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        require_once 'php/ctb_api.php';


        setlocale(LC_COLLATE, "en_US");
        setlocale(LC_CTYPE, "en_US");
        set_time_limit(0);

        $id = $_GET['id'];

        $x = retrieve_image($id);

        if (key_exists('BIO', $x)) {
            $img_src = $x['IMG'];
            $bio_txt = $x['BIO'];
            echo("<div align='center' style='max-width: 1024px; padding: 25px;'>");
            //echo("<img src='$img_src' height='250px' style='border-radius: 15px;' />");
            echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");
            echo("</div>");
        }

        $endjava = Array();

        function retrieve_image($fourcode)
        {
            global $ctb2016_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT BIOGUIDE FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            $retval = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bioguide = $row['BIOGUIDE'];
                    $retval['IMG'] = "/img/congress/" . $bioguide . ".jpg";
                    $retval['BIO'] = retrieve_bio($bioguide);
                }
            }

            return $retval;
        }


        function retrieve_bio($id)
        {
            global $fec_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT bio FROM nufec_bios WHERE bioguide = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['bio'];
                }
            }

            return $retval;
        }


        /*


        //$assembly = file_get_contents('http://vote.sos.ca.gov/returns/state-assembly/district/all/', false, $context);
        //$senate = file_get_contents('http://vote.sos.ca.gov/returns/state-senate/district/all/', false, $context);
        //$congress = file_get_contents('http://vote.sos.ca.gov/returns/us-rep/district/all/', false, $context);
        //$props = file_get_contents('http://vote.sos.ca.gov/returns/ballot-measures/', false, $context);
        //$senate = file_get_contents('http://vote.sos.ca.gov/returns/us-senate/', false, $context);
        //$pres = file_get_contents('http://vote.sos.ca.gov/returns/president/', false, $context);


        $assembly = file_get_contents('ADS.html', false, $context);
        $senate = file_get_contents('SDS.html', false, $context);
        $congress = file_get_contents('CDS.html', false, $context);
        $props = file_get_contents('PROPS.html', false, $context);
        $ussenate = file_get_contents('USS.html', false, $context);
        $pres = file_get_contents('PRES.html', false, $context);





        $htmls = Array($assembly, $senate, $congress);

        foreach($htmls as $html) {
            $race = Array();

            $arr = explode("<div class=\"allCountyHeader\">", $html);
            //var_dump($arr);

            //$regex = '~(\<div class=\"allCountyHeader\">.*<div class=\"clear\"><\/div>)~mis';
            $regex = '<h2>.*?District ([0-9].*?)<.*?<\/h2>~mis';

            $cnt = 1;
            foreach($arr as $value) {
                if($cnt > 0) {
                    echo("<br>LOOP");
                    $race = Array();
                    $candidates = Array();
                    $tmp = Array();
                    $name = "";
                    //echo("INITIAL EXPLODED ARAY:<br>");
                    //echo(htmlspecialchars($value));

                    //CHECK RACE TYPE
                    if(strpos($value, 'assembly')) {
                        $disttype = "AD";
                    }

                    if(strpos($value, 'senate')) {
                        $disttype = "SD";
                    }

                    if(strpos($value, 'us-rep')) {
                        $disttype = "CD";
                    }

                    if(strpos($value, 'Lorena')) {
                        $disttype = "AD";
                    }

                    if(strpos($value, 'Atkins') && strpos($value, 'senate')) {
                        $disttype = "SD";
                    }

                    //FIND DISTRICT NUMBER
                    $regex = '~<h2>.*?District ([0-9].*?)<.*?<\/h2>~mis';
                    preg_match($regex, $value, $results);

                    $dist = checkaddzero($results[1]);
                    $fourcode = $disttype . $dist;
                    echo("<br>$fourcode");

                    $regex = '~#faq-reporting\">(.*?precincts)~mis';
                    preg_match($regex, $value, $results);
                    $progress = $results[1];
                    echo("<br>Extracted Progress Details: $progress<br>");

                    $arr2 = explode("<td class=\"candName\">", $value);

                    $i = 0;
                    $v = 0;
                    $totalvotes = 0;

                    foreach($arr2 as $value2) {

                        $race = Array();
                        //echo("<br>EXPLODED CANDIDATE ARRAY<Br>");
                        //echo(htmlspecialchars($value2));



                        $regex = '~(.*?)<~';
                        preg_match($regex, $value2, $results3);
                        $name = $results3[1];
                        $name = str_sanitize($name);

                        //$name = mysqli_real_escape_string($name);
                        //echo("<br>Extracted $name");

                        $regex = '~Party Preference: (.*?)\)~mis';
                        preg_match($regex, $value2, $results3);
                        $party = $results3[1];
                        //echo("<br>Extracted $party");

                        $regex = '~\"textRight\">(.*?)<~mis';
                        preg_match($regex, $value2, $results3);
                        $votes = $results3[1];
                        $votes = str_sanitize($votes);
                        //echo("<br>Extracted $votes Votes");

                        if($name <> "" && $i > 0) {
                            $tmp['NAME'] = $name;
                            $tmp['FOURCODE'] = $fourcode;
                            $tmp['PARTY'] = $party;
                            $tmp['VOTES'] = $votes;
                            $totalvotes += $tmp['VOTES'];

                            $race[$fourcode][$name]['NAME'] = $name;
                            $race[$fourcode][$name]['PARTY'] = $party;
                            $race[$fourcode][$name]['VOTES'] = $votes;
                            $race[$fourcode][$name]['FOURCODE'] = $fourcode;
                            $race[$fourcode][$name]['PROGRESS'] = $progress;
                        }

                        foreach($race as $district) {
                            uasort($district, votesort);
                            //$fourcode = $value['FOURCODE'];
                            $dbleader = leadercheck($fourcode);
                            $leadername = $dbleader['NAME'];
                            $leadervotes = $dbleader['VOTES'];

                            foreach($district as $value) {
                                echo("<br>" . $value['FOURCODE'] . " - " . $value['NAME'] . " (" . $value['PARTY'] . ") - " . $value['VOTES'] . " ($totalvotes total cast)");
                                resulthandler($value);
                            }

                        }

                        $i++;
                    }


                }
                $cnt++;
            }
        }


        $votes = Array();

        $arr = explode("<tbody>", $props);

        $allprops = $arr[1];

        $rows = explode("<tr ", $allprops);

        $i = 1;
        foreach($rows as $row) {
            echo("<br>");
            //echo(htmlspecialchars($row));

            $regex = '~textRight\"\>(.*?)\<~';
            preg_match($regex, $row, $results);
            $prop_no = (int)$results[1];
            if(!$prop_no) {
                $i++;
                continue;
            }

            $regex = '~bold\"\>(.*?)\<~';
            preg_match($regex, $row, $results);
            $prop_dscr = $results[1];

            $votearr = explode('votesProp">', $row);
            //var_dump($votearr);
            $rawyes = $votearr[1];
            $rawno = $votearr[2];

            $regex = '~(.*?)\<~';
            preg_match($regex, $rawyes, $results);
            $yes = str_sanitize($results[1]);

            preg_match($regex, $rawno, $results);
            $no = str_sanitize($results[1]);

            if($prop_no > 56 || $prop_no < 68) {
                var_dump($prop_no);
                $votes[$prop_no]['Y'] = $yes;
                $votes[$prop_no]['N'] = $no;
                $votes[$prop_no]['DSCR'] = $prop_dscr;
                $votes[$prop_no]['PROP'] = $prop_no;
            }




            echo("<br>Row #$i Prop #$prop_no: $prop_dscr VOTE DUMP: <br>");
            echo("<br>YES: <br>$yes<br>NO:<br>$no<br>");

            $i++;

        }

        //var_dump($votes);

        prophandler($votes);





        $regex = '~1.25em\"\>(.*?)\s\s~mis';
        preg_match($regex, $ussenate, $results);
        $updated = $results[1];

        $rawtable = explode("<table class=\"stateCountyCandResultsTbl\">", $ussenate);

        $rows = explode("<tr ", $rawtable[1]);

        $i = 1;
        foreach($rows as $row) {
            echo("<br>LINE $i<br>");
            if($i == 3) {
                $regex = '~Name\"\>(.*?)\<~';
                preg_match($regex, $row, $results);
                $cand1_nm = $results[1];
                $regex = '~Right\"\>(.*?)\<~';
                preg_match($regex, $row, $results);
                $cand1_vt = $results[1];

                $tmp['NAME'] = $cand1_nm;
                $tmp['PARTY'] = "DEM";
                $tmp['VOTES'] = str_sanitize($cand1_vt);
                $tmp['FOURCODE'] = ".SEN";
                $tmp['PROGRESS'] = $updated;
                resulthandler($tmp);
            }

            if($i == 4) {
                $regex = '~Name\"\>(.*?)\<~';
                preg_match($regex, $row, $results);
                $cand2_nm = $results[1];
                $regex = '~Right\"\>(.*?)\<~';
                preg_match($regex, $row, $results);
                $cand2_vt = $results[1];

                $tmp['NAME'] = $cand2_nm;
                $tmp['PARTY'] = "DEM";
                $tmp['VOTES'] = str_sanitize($cand2_vt);
                $tmp['FOURCODE'] = ".SEN";
                $tmp['PROGRESS'] = $updated;
                echo("<br>SENDING TO RESULT HANDLER WITH TMP: <br>");
                var_dump($tmp);
                resulthandler($tmp);
            }
            //echo(htmlspecialchars($row));
            $i++;
        }






        $rawtable = explode("<table class=\"stateCountyCandResultsTbl\">", $pres);

        //echo(htmlspecialchars($pres));

        $rows = explode("<tr ", $rawtable[1]);

        $i=1;

        foreach($rows as $row) {
            echo("<br>LINE $i<br>");
            echo(htmlspecialchars($row));

            $regex = '~Name\"\>(.*?)\<~';
            preg_match($regex, $row, $results);
            $tmp['NAME'] = $results[1];

            $regex = '~Right\"\>(.*?)\<~';
            preg_match($regex, $row, $results);
            $tmp['VOTES'] = str_sanitize($results[1]);

            $regex = '~Party: (.*?)\)~';
            preg_match($regex, $row, $results);
            $tmp['PARTY'] = $results[1];

            $tmp['FOURCODE'] = ".PRS";
            $tmp['PROGRESS'] =  $updated;

            if($tmp['NAME']) {
                resulthandler($tmp);
            }
            //echo("<br>EXTRACTED " . $tmp['NAME'] . " (" . $tmp['PARTY']  . ") WITH " . $tmp['VOTES'] . " Votes<br>");

            $i++;
        }

        if($msg) {
            $to      = 'rpyers@gmail.com';
            $subject = 'KEY RACE ALERT';
            $message = $msg;
            $headers = 'From: webmaster@10.0.1.3' . "\r\n" .
                'Reply-To: webmaster@10.0.1.3' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $mail = mail($to, $subject, $message, $headers);
                echo($message);

        }




        function str_sanitize($string) {
            $retval = str_replace("'", "", $string);
            $retval = str_replace("\"", "", $retval);
            $retval = str_replace(",", "", $retval);
            return $retval;
        }

        function votesort($a, $b) {

            if($a['VOTES'] < $b['VOTES']) {
                return 1;
            } elseif ($a['VOTES'] > $b['VOTES']) {
                return -1;
            }else {
                return 0;
            }
        }

        function resulthandler($value) {
            global $conn;
            global $totalvotes;
            global $msg;


            $name = $value['NAME'];
            $fourcode = $value['FOURCODE'];
            $party = $value['PARTY'];
            $votes = $value['VOTES'];
            $progress = $value['PROGRESS'];

            if($fourcode == ".USS") {
                echo("<br>Running namecheck with $name, $fourcode, $party, $votes, and $progress<br>");
            }

            $x = namecheck($name, $fourcode, $party, $votes, $progress);
            $leader = leadercheck($fourcode);

            if(!$leader) {
                initleader($name, $fourcode, $party, $votes, $progress);
            }

            if(!$x['VOTES']) {
                $x['VOTES'] = "0";
            }

            echo("<br>Comparing current votes of $votes with old total of " . $x['VOTES'] . " and $progress with old progress of " . $x['PROGRESS']);
            if($votes == $x['VOTES'] && $progress == $x['PROGRESS']) {
                //DO NOTHING
            } else {
                echo("<br>Firing Update for $name with $votes votes, using progress of $progress");
                updatevotes($name, $fourcode, $party, $votes, $progress);
            }

            if($votes > $leader['VOTES']) {
                updateleader($name, $fourcode, $party, $votes);
                if($name <> $leader['NAME']) {
                    $msg .= "\n$fourcode: $name has overtaken" . $leader['NAME'] . " with $progress reporting";
                }
            }

        }

        function prophandler($votes) {

            global $msg;

            $servername = "198.74.49.22";
            $username = "nufec";
            $password = "Mrw0mbat8";
            $dbname = "g16returns";

            $conn = new mysqli($servername, $username, $password, $dbname);

            $i = 51;

            while($i < 68) {
                $yes = $votes[$i]['Y'];
                $no = $votes[$i]['N'];
                $prop_no = $votes[$i]['PROP'];
                $dscr = $votes[$i]['DSCR'];
                $leadsnow = '';
                $leadsthen = '';

                if($yes > $no) {
                    $leadsnow = "yes";
                }

                if($no > $yes) {
                    $leadsnow = "no";
                }

                $sql = "SELECT * FROM props WHERE PROP_NO = '$i'";
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $oldyes = $row['Y'];
                        $oldno = $row['N'];
                    }
                } else {
                    $sql = "INSERT INTO props (PROP_NO, Y, N, DSCR)
                            VALUES ('$prop_no', '$yes', '$no', '$dscr')";
                    echo("<br>$sql<br>");
                    $conn->query($sql);
                    $i++;
                    continue;
                }

                if($oldyes <> $yes || $oldno <> $no) {
                    $sql =  "UPDATE props SET Y = '$yes', N = '$no' WHERE PROP_NO = '$prop_no'";
                    echo("<br>$sql");
                    $conn->query($sql);
                }

                if($oldyes > $oldno) {
                    $leadsthen = "yes";
                }

                if($oldno > $oldyes) {
                    $leadsthen = "no";
                }

                $total = $yes + $no;

                $yespct = makepct($yes, $total);
                $nopct = makepct($no, $total);



                if($leadsthen != $leadsnow) {
                    $msg .= "\nPROP $i UPDATE: The '$leadsnow' vote is now leading.  YES: $yespct NO: $nopct";
                }

                $i++;
            }
        }

        function namecheck($name, $fourcode, $party, $votes, $progress) {
            global $conn;
            echo("<br>Now in namecheck function with $name, $fourcode, $party, $votes, and $progress<Br>");
            $retval = Array();
            $sql = "SELECT * from candidates WHERE NAME = '$name'";
            echo($sql);
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $retval['FOURCODE'] = $row['FOURCODE'];
                    $retval['NAME'] = $row['NAME'];
                    $retval['VOTES'] = $row['VOTES'];
                    $retval['PARTY'] = $row['PARTY'];
                    $retval['PROGRESS'] = $row['PROGRESS'];
                }
            } else {
                $sql = "INSERT INTO candidates (FOURCODE, NAME, PARTY, VOTES, PROGRESS)
                        VALUES ('$fourcode', '$name', '$party', '$votes', '$progress')";
                $conn->query($sql);
                echo("<br>INSERTING USING<br>$sql<br>");
            }
            echo("<br>Executed namecheck, returning:<br>");
            var_dump($retval);
            return $retval;
        }

        function leadercheck($fourcode) {
            global $conn;
            $retval = Array();
            $sql = "SELECT * FROM leaderboard WHERE FOURCODE = '$fourcode'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $retval['FOURCODE'] = $row['FOURCODE'];
                    $retval['NAME'] = $row['NAME'];
                    $retval['VOTES'] = $row['VOTES'];
                    $retval['PARTY'] = $row['PARTY'];
                }

            }
            return $retval;
        }

        function initleader($name, $fourcode, $party, $votes) {
            global $conn;
            $sql = "INSERT INTO leaderboard (FOURCODE, NAME, PARTY, VOTES)
                    VALUES ('$fourcode', '$name', '$party', '$votes')
            ";
            $conn->query($sql);
        }

        function newleader($name, $fourcode, $party, $votes) {
            global $conn;
            $sql = "UPDATE leaderboard SET NAME = '$name', FOURCODE = '$fourcode', PARTY = '$party', VOTES = '$votes' WHERE FOURCODE = '$fourcode'";
            echo($sql);
            $conn->query($sql);
        }

        function updateleader($name, $fourcode, $party, $votes) {
            global $conn;
            $sql =  "UPDATE leaderboard SET NAME = '$name', FOURCODE = '$fourcode', PARTY = '$party', VOTES = '$votes' WHERE FOURCODE = '$fourcode'";
            $conn->query($sql);
        }

        function updatevotes($name, $fourcode, $party, $votes, $progress) {
            global $conn;
            $sql = "UPDATE candidates SET NAME = '$name', FOURCODE = '$fourcode', PARTY = '$party', VOTES = '$votes', PROGRESS = '$progress' WHERE NAME = '$name'";
            echo("<br>$sql");
            $conn->query($sql);

        }
        */

        ?>

    </body>


    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

<!--    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>-->

</html>

