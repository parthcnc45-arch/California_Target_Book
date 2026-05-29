<?php


//CAL-ACCESS DATABASE
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "calaccess_raw";

$calaccess_conn = new mysqli($servername, $username, $password, $dbname);


//FEC DATABASE
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "nufec";

$fec_conn = new mysqli($servername, $username, $password, $dbname);

//US COUNTY MAPS 
$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "us_counties";

$countymap_conn = new mysqli($servername, $username, $password, $dbname);


//TARGET BOOK WEBSITE CONNECTION
$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "ctb";

$site_conn = new mysqli($servername, $username, $password, $dbname);

//FEC 2018 DATABASE
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "nufec18";

$fec18_conn = new mysqli($servername, $username, $password, $dbname);

//NETFILE DATABASE
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "netfile";

$netfile_conn = new mysqli($servername, $username, $password, $dbname);


//P16 RETURNS
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "p16returns";
$p16_conn = new mysqli($servername, $username, $password, $dbname);

if ($p16_conn->connect_error) {
    die("p16 Connection failed: " . $p16_conn->connect_error);
} else {
    //echo("p16 Connected...");
}

//G16 RETURNS
$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "g16returns";
$g16_conn = new mysqli($servername, $username, $password, $dbname);


//PRECINCT GEOGRAPHY
$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "precincts";
$precincts_conn = new mysqli($servername, $username, $password, $dbname);

//CALACCESS SCRAPE DATA, COUNTS, PROCESSED FILINGS
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "elections";

$scrape_conn = new mysqli($servername, $username, $password, $dbname);

if ($scrape_conn->connect_error) {
    die("Scrape Connection failed: " . $scrape_conn->connect_error);
} else {
    //echo("Scrape Connected...");
}

//ELECTION DATA SETS, VOTER REGISTRATION, CANDIDATE INFORMATION, CENSUS DATA, ORG RATINGS, CTB LINKS
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "ctb2016";

$ctb2016_conn = new mysqli($servername, $username, $password, $dbname);

if ($ctb2016_conn->connect_error) {
    die("ctb2016 Connection failed: " . $ctb2016_conn->connect_error);
} else {
    //echo("ctb2016 Connected...");
}

//ZIP CODE SHAPE FILES
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "zcta";

$zip_conn = new mysqli($servername, $username, $password, $dbname);

//LEGISLATION, VOTING RECORDS 
$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "capublic";

$caleg_conn = new mysqli($servername, $username, $password, $dbname);

//CALIFORNIA DISTRICT SHAPEFILES

$servername = "198.74.49.22";
$username = "calaccess";
$password = "Mrw0mbat8";
$dbname = "caldist";

$caldist_conn = new mysqli($servername, $username, $password, $dbname);

//FLORIDA

$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "florida";

$fl_conn = new mysqli($servername, $username, $password, $dbname);


?>