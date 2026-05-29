@extends('layouts.master')

@section('title', 'FEC Census Detail | California Target Book')

@section('content')

<?php

Util::set_errors();
Util::require_ctb_api();


global $fourcode;
$fourcode = $_GET['id'];

loaddp05($fourcode);
loaddp04($fourcode);
loaddp03($fourcode);
loaddp02($fourcode);

function loaddp02($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $dp02results = Array();
    $dp02longhead = Array();
    $dp02shorthead = Array();
    $dp02sqlstring = "";
    $parseme = Array();

    $sql = "SELECT * FROM ctb2016_dp02_codes";

    $result = $conn->query($sql);

    //echo($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        array_push($dp02longhead, $row["long"]);
        array_push($dp02shorthead, $row["short"]);
        if ($i == 0) {
            $dp02sqlstring = $row["short"];
        } else {
            $dp02sqlstring .= ", " . $row["short"];
        }

        $i++;
    }

    //$sql = "$sql = "SELECT " . $dp04sqlstring . " FROM dp04 WHERE FOURCODE = '" . $fourcode . "'";
    $sql = "SELECT * FROM ctb2016_dp02 WHERE FOURCODE = '" . $fourcode . "'";

    //echo($sql) . "<br>";

    //var_dump($dp02longhead);

    echo("<br>");


    $result = $conn->query($sql);

    $i = 0;

    $resultrow = "";
    $lasttime = "";

    while ($row = $result->fetch_assoc()) {
        foreach ($dp02shorthead as $value) {
            $x = mb_substr($value, 0, 4);

            if ($x == "HC01") {
                $resultrow = substr($dp02longhead[$i], 9) . " ZqZ " . $row[$value];
            } elseif ($x == "HC03") {
                $resultrow .= "  -- " . $row[$value] . "";
                array_push($parseme, $resultrow);
                //echo($resultrow);

            } else {
                //				echo("Hi!");
            }

            $i++;
        }


        foreach ($parseme as $value) {
            //echo($value);
            $arr = explode("ZqZ", $value, 2);
            $current = $arr[0];
            $data = $arr[1];
            $arr2 = explode(" - ", $current);
            $seg1 = $arr2[0];
            $seg2 = $arr2[1];
            $seg3 = $arr2[2];
            $seg4 = $arr2[3];
            $seg5 = $arr2[4];
            $thistime = $seg1;

            if ($thistime <> $lasttime) {
                $lasttime = $thistime;
                echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
            }

            //$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';

            if ($seg5 != "") {
                echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
            } elseif ($seg4 != "") {
                echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
            } elseif ($seg3 != "") {
                echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
            } elseif ($seg2 != "") {
                echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
            } else {
                echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
            }


            //echo($output);

            //echo($seg1) . "<br>";
            //echo($seg2) . "<br>";
            //echo($seg3) . "<br>";
        }

        echo "<div>";


    }


}

function loaddp03($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $dp03results = Array();
    $dp03longhead = Array();
    $dp03shorthead = Array();
    $dp03sqlstring = "";
    $parseme = Array();

    $sql = "SELECT * FROM ctb2016_dp03_codes";

    $result = $conn->query($sql);

    //echo($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        array_push($dp03longhead, $row["long"]);
        array_push($dp03shorthead, $row["short"]);
        if ($i == 0) {
            $dp03sqlstring = $row["short"];
        } else {
            $dp03sqlstring .= ", " . $row["short"];
        }

        $i++;
    }

    $dp03sqlstring = cleanup_fields($dp03sqlstring);

    //            $sql = "SELECT " . $dp03sqlstring . " FROM dp03 WHERE FOURCODE = '" . $fourcode . "'";
    $sql = "SELECT * FROM ctb2016_dp03 WHERE FOURCODE = '" . $fourcode . "'";


    //echo($sql) . "<br>";

    //var_dump($dp03longhead);

    echo("<br>");


    $result = $conn->query($sql);

    $i = 0;

    $resultrow = "";

    while ($row = $result->fetch_assoc()) {
        foreach ($dp03shorthead as $value) {
            $x = mb_substr($value, 0, 4);

            if ($x == "HC01") {
                $resultrow = substr($dp03longhead[$i], 9) . " ZqZ " . $row[$value];
            } elseif ($x == "HC03") {
                $resultrow .= "  -- " . $row[$value] . "";
                array_push($parseme, $resultrow);
                //echo($resultrow);

            } else {
                //				echo("Hi!");
            }

            $i++;
        }


        foreach ($parseme as $value) {
            //echo($value);
            $arr = explode("ZqZ", $value, 2);
            $current = $arr[0];
            $data = $arr[1];
            $arr2 = explode(" - ", $current);
            $seg1 = $arr2[0];
            $seg2 = $arr2[1];
            $seg3 = $arr2[2];
            $seg4 = $arr2[3];
            $seg5 = $arr2[4];
            $thistime = $seg1;

            if ($thistime <> $lasttime) {
                $lasttime = $thistime;
                echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
            }

            //$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';


            if ($seg5 != "") {
                echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
            } elseif ($seg4 != "") {
                echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
            } elseif ($seg3 != "") {
                echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
            } elseif ($seg2 != "") {
                echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
            } else {
                echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
            }

            //echo($seg1) . "<br>";
            //echo($seg2) . "<br>";
            //echo($seg3) . "<br>";
        }

        echo "<div>";


    }


}

function loaddp04($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $dp04results = Array();
    $dp04longhead = Array();
    $dp04shorthead = Array();
    $dp04sqlstring = "";
    $parseme = Array();

    $sql = "SELECT * FROM ctb2016_dp04_codes";

    $result = $conn->query($sql);

    //echo($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        array_push($dp04longhead, $row["long"]);
        array_push($dp04shorthead, $row["short"]);
        if ($i == 0) {
            $dp04sqlstring = $row["short"];
        } else {
            $dp04sqlstring .= ", " . $row["short"];
        }

        $i++;
    }

    $dp04sqlstring = cleanup_fields($dp04sqlstring);

    //            $sql = "SELECT " . $dp04sqlstring . " FROM dp04 WHERE FOURCODE = '" . $fourcode . "'";
    $sql = "SELECT * FROM ctb2016_dp04 WHERE FOURCODE = '" . $fourcode . "'";

    //echo($sql) . "<br>";

    //var_dump($dp04longhead);

    echo("<br>");


    $result = $conn->query($sql);

    $i = 0;

    $resultrow = "";

    while ($row = $result->fetch_assoc()) {
        foreach ($dp04shorthead as $value) {
            $x = mb_substr($value, 0, 4);

            if ($x == "HC01") {
                $resultrow = substr($dp04longhead[$i], 9) . " ZqZ " . $row[$value];
            } elseif ($x == "HC03") {
                $resultrow .= "  -- " . $row[$value] . "";
                array_push($parseme, $resultrow);
                //echo($resultrow);

            } else {
                //				echo("Hi!");
            }

            $i++;
        }


        foreach ($parseme as $value) {
            //echo($value);
            $arr = explode("ZqZ", $value, 2);
            $current = $arr[0];
            $data = $arr[1];
            $arr2 = explode(" - ", $current);
            $seg1 = $arr2[0];
            $seg2 = $arr2[1];
            $seg3 = $arr2[2];
            $seg4 = $arr2[3];
            $seg5 = $arr2[4];
            $thistime = $seg1;

            if ($thistime <> $lasttime) {
                $lasttime = $thistime;
                echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
            }

            //$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';


            if ($seg5 != "") {
                echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
            } elseif ($seg4 != "") {
                echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
            } elseif ($seg3 != "") {
                echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
            } elseif ($seg2 != "") {
                echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
            } else {
                echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
            }
        }

        echo "<div>";


    }


}

function loaddp05($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $dp05results = Array();
    $dp05longhead = Array();
    $dp05shorthead = Array();
    $dp05sqlstring = "";
    $parseme = Array();

    $sql = "SELECT * FROM ctb2016_dp05_codes";

    $result = $conn->query($sql);

    //echo($sql);

    $i = 0;

    while ($row = $result->fetch_assoc()) {
        array_push($dp05longhead, $row["long"]);
        array_push($dp05shorthead, $row["short"]);
        if ($i == 0) {
            $dp05sqlstring = $row["short"];
        } else {
            $dp05sqlstring .= ", " . $row["short"];
        }

        $i++;
    }

    $dp05sqlstring = cleanup_fields($dp05sqlstring);

    $sql = "SELECT * FROM ctb2016_dp05 WHERE FOURCODE = '" . $fourcode . "'";

    //echo($sql) . "<br>";

    //var_dump($dp05longhead);

    echo("<br>");


    $result = $conn->query($sql);

    $i = 0;

    $resultrow = "";

    while ($row = $result->fetch_assoc()) {
        foreach ($dp05shorthead as $value) {
            $x = mb_substr($value, 0, 4);

            if ($x == "HC01") {
                $resultrow = substr($dp05longhead[$i], 9) . " ZqZ " . $row[$value];
            } elseif ($x == "HC03") {
                $resultrow .= "  -- " . $row[$value] . "";
                array_push($parseme, $resultrow);
                //echo($resultrow);

            } else {
                //				echo("Hi!");
            }

            $i++;
        }


        foreach ($parseme as $value) {
            //echo($value);
            $arr = explode("ZqZ", $value, 2);
            $current = $arr[0];
            $data = $arr[1];
            $arr2 = explode(" - ", $current);
            $seg1 = $arr2[0];
            $seg2 = $arr2[1];
            $seg3 = $arr2[2];
            $seg4 = $arr2[3];
            $seg5 = $arr2[4];
            $thistime = $seg1;

            if ($thistime <> $lasttime) {
                $lasttime = $thistime;
                echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
            }

            //$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';


            if ($seg5 != "") {
                echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
            } elseif ($seg4 != "") {
                echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
            } elseif ($seg3 != "") {
                echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
            } elseif ($seg2 != "") {
                echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
            } else {
                echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
            }
        }

        echo "<div>";


    }


}

function cleanup_fields($dp05sqlstring)
{

    $dp05sqlstring = str_replace("rdist_id", "FOURCODE", $dp05sqlstring);
    $dp05sqlstring = str_replace("GEOid,", "", $dp05sqlstring);
    $dp05sqlstring = str_replace("GEOid2,", "", $dp05sqlstring);
    $dp05sqlstring = str_replace("GEOdisplay,", "", $dp05sqlstring);

    return $dp05sqlstring;
}


?>


@endsection

@section('scripts')
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

