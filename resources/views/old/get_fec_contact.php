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

        $x = retrieve_info($id);


        $website = "<p><b>Website</b>: <a href='" . $x['WEBSITE'] . "' target='_blank'>" . $x['WEBSITE'] . "</a><br/>";
        $office = "<b>Office</b>: " . $x['OFFICE'] . "<br/>";
        $phone = "<b>Phone</b>: " . $x['PHONE'] . "</p>";


        echo("<div align='center' style='font-family: \"PT Sans Narrow\";'>");
        echo($website . $office . $phone);
        echo("</div>");

        $endjava = Array();

        function retrieve_info($fourcode)
        {
            global $ctb2016_conn;
            $conn = $ctb2016_conn;
            $sql = "SELECT * FROM e18_fed WHERE DIST = '$fourcode'";
            //echo($sql);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval['WEBSITE'] = $row['WEBSITE'];
                    $retval['OFFICE'] = $row['OFFICE'];
                    $retval['PHONE'] = $row['PHONE'];


                }
            }

            return $retval;
        }


        ?>

    </body>


    <?php include "php/scripts.php" ?>

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>

</html>

