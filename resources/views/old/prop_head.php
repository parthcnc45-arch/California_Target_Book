
<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//Util::require_ctb_api();
$prop = $_GET['prop'];
$election = $_GET['election'];
$id = $_GET['id'];

$current = 'prop_page_b.php?prop=' . $prop . '&election=' . $election;
if(!$prop && $id) {
    $current = 'pending_prop_page_b.php?id=' . $id;
}

$links = get_prop_links($current);

$prev_url = $links['prev'];
$next_url = $links['next'];

$prev_code = $links['prev_code'];
$next_code = $links['next_code'];


$prev_div = "<div style='float: left; width: 30%;' align='left'>$prev_url
            <img width='50' style='padding-left: 20px;' align='left' height='50' alt='' src='/ctb-legacy/img/0-PREV.png' />
            <text style='text-align: left; line-height: 50px; font-family: \"Lato\"; font-size: 1.4em;'><strong style='padding-left: 20px;'>" . $links['prev_code'] . "</strong></text></div></a>";

$next_div = "<div style='float: right; width: 30%; text-align: right;'>$next_url
            <text style='text-align: right; line-height: 50px;font-family: \"Lato\"; font-size: 1.4em;'><strong style='padding-right: 20px;'>" . $links['next_code'] . "</strong></text>
            <img style='padding-right: 20px;'width='50' align='right' height='50' alt='' src='/ctb-legacy/img/0-NEXT.png' /></div></a>";



echo("<div class='jumbotron text-center sacto' height='400'>
  <h1 align='center'>PROPOSITION $prop</h1>
  $prev_div
  $next_div
</div>");           

function get_prop_links ($current) {

$prop_nav = Array(

//2005 SPECIAL ELECTIONS
"<a href='prop_page_b.php?prop=73&election=2006'>PROP 73",
"<a href='prop_page_b.php?prop=74&election=2006'>PROP 74",
"<a href='prop_page_b.php?prop=75&election=2006'>PROP 75",
"<a href='prop_page_b.php?prop=76&election=2006'>PROP 76",
"<a href='prop_page_b.php?prop=77&election=2006'>PROP 77",
"<a href='prop_page_b.php?prop=78&election=2006'>PROP 78",
"<a href='prop_page_b.php?prop=79&election=2006'>PROP 79",
"<a href='prop_page_b.php?prop=80&election=2006'>PROP 80",

//2006 PRIMARY
"<a href='prop_page_b.php?prop=81&election=2006'>PROP 81",
"<a href='prop_page_b.php?prop=82&election=2006'>PROP 82",

//2006 GENERAL
"<a href='prop_page_b.php?prop=1A&election=2006'>PROP 1A",
"<a href='prop_page_b.php?prop=1B&election=2006'>PROP 1B",
"<a href='prop_page_b.php?prop=1C&election=2006'>PROP 1C",
"<a href='prop_page_b.php?prop=1D&election=2006'>PROP 1D",
"<a href='prop_page_b.php?prop=1E&election=2006'>PROP 1E",
"<a href='prop_page_b.php?prop=83&election=2006'>PROP 83",
"<a href='prop_page_b.php?prop=84&election=2006'>PROP 84",
"<a href='prop_page_b.php?prop=85&election=2006'>PROP 85",
"<a href='prop_page_b.php?prop=86&election=2006'>PROP 86",
"<a href='prop_page_b.php?prop=87&election=2006'>PROP 87",
"<a href='prop_page_b.php?prop=88&election=2006'>PROP 88",
"<a href='prop_page_b.php?prop=89&election=2006'>PROP 89",
"<a href='prop_page_b.php?prop=90&election=2006'>PROP 90",

//2008 PRESIDENTIAL PRIMARY
"<a href='prop_page_b.php?prop=91&election=2008'>PROP 91",
"<a href='prop_page_b.php?prop=92&election=2008'>PROP 92",
"<a href='prop_page_b.php?prop=93&election=2008'>PROP 93",
"<a href='prop_page_b.php?prop=94&election=2008'>PROP 94",
"<a href='prop_page_b.php?prop=95&election=2008'>PROP 95",
"<a href='prop_page_b.php?prop=96&election=2008'>PROP 96",
"<a href='prop_page_b.php?prop=97&election=2008'>PROP 97",

//2008 JUNE PRIMARY
"<a href='prop_page_b.php?prop=98&election=2008'>PROP 98",
"<a href='prop_page_b.php?prop=99&election=2008'>PROP 99",

//2008 GENERAL
"<a href='prop_page_b.php?prop=1A&election=2008'>PROP 1A",
"<a href='prop_page_b.php?prop=2&election=2008'>PROP 2",
"<a href='prop_page_b.php?prop=3&election=2008'>PROP 3",
"<a href='prop_page_b.php?prop=4&election=2008'>PROP 4",
"<a href='prop_page_b.php?prop=5&election=2008'>PROP 5",
"<a href='prop_page_b.php?prop=6&election=2008'>PROP 6",
"<a href='prop_page_b.php?prop=7&election=2008'>PROP 7",
"<a href='prop_page_b.php?prop=8&election=2008'>PROP 8",
"<a href='prop_page_b.php?prop=9&election=2008'>PROP 9",
"<a href='prop_page_b.php?prop=10&election=2008'>PROP 10",
"<a href='prop_page_b.php?prop=11&election=2008'>PROP 11",
"<a href='prop_page_b.php?prop=12&election=2008'>PROP 12",

//2009 SPECIAL
"<a href='prop_page_b.php?prop=1A&election=2010'>PROP 1A",
"<a href='prop_page_b.php?prop=1B&election=2010'>PROP 1B",
"<a href='prop_page_b.php?prop=1C&election=2010'>PROP 1C",
"<a href='prop_page_b.php?prop=1D&election=2010'>PROP 1D",
"<a href='prop_page_b.php?prop=1E&election=2010'>PROP 1E",
"<a href='prop_page_b.php?prop=1F&election=2010'>PROP 1F",


//2010 PRIMARY
"<a href='prop_page_b.php?prop=13&election=2010'>PROP 13",
"<a href='prop_page_b.php?prop=14&election=2010'>PROP 14",
"<a href='prop_page_b.php?prop=15&election=2010'>PROP 15",
"<a href='prop_page_b.php?prop=16&election=2010'>PROP 16",
"<a href='prop_page_b.php?prop=17&election=2010'>PROP 17",

///2010 GENERAL
"<a href='prop_page_b.php?prop=19&election=2010'>PROP 19",
"<a href='prop_page_b.php?prop=20&election=2010'>PROP 20",
"<a href='prop_page_b.php?prop=21&election=2010'>PROP 21",
"<a href='prop_page_b.php?prop=22&election=2010'>PROP 22",
"<a href='prop_page_b.php?prop=23&election=2010'>PROP 23",
"<a href='prop_page_b.php?prop=24&election=2010'>PROP 24",
"<a href='prop_page_b.php?prop=25&election=2010'>PROP 25",
"<a href='prop_page_b.php?prop=26&election=2010'>PROP 26",
"<a href='prop_page_b.php?prop=27&election=2010'>PROP 27",

//2012 PRIMARY
"<a href='prop_page_b.php?prop=28&election=2012'>PROP 28",
"<a href='prop_page_b.php?prop=29&election=2012'>PROP 29",

//2012 GENERAL
"<a href='prop_page_b.php?prop=30&election=2012'>PROP 30",
"<a href='prop_page_b.php?prop=31&election=2012'>PROP 31",
"<a href='prop_page_b.php?prop=32&election=2012'>PROP 32",
"<a href='prop_page_b.php?prop=33&election=2012'>PROP 33",
"<a href='prop_page_b.php?prop=34&election=2012'>PROP 34",
"<a href='prop_page_b.php?prop=35&election=2012'>PROP 35",
"<a href='prop_page_b.php?prop=36&election=2012'>PROP 36",
"<a href='prop_page_b.php?prop=37&election=2012'>PROP 37",
"<a href='prop_page_b.php?prop=38&election=2012'>PROP 38",
"<a href='prop_page_b.php?prop=39&election=2012'>PROP 39",
"<a href='prop_page_b.php?prop=40&election=2012'>PROP 40",

//2014 PRIMARY
"<a href='prop_page_b.php?prop=41&election=2014'>PROP 41",
"<a href='prop_page_b.php?prop=42&election=2014'>PROP 42",

//2014 GENERAL
"<a href='prop_page_b.php?prop=1&election=2014'>PROP 1",
"<a href='prop_page_b.php?prop=2&election=2014'>PROP 2",
"<a href='prop_page_b.php?prop=45&election=2014'>PROP 45",
"<a href='prop_page_b.php?prop=46&election=2014'>PROP 46",
"<a href='prop_page_b.php?prop=47&election=2014'>PROP 47",
"<a href='prop_page_b.php?prop=48&election=2014'>PROP 48",

//2016 PRIMARY
"<a href='prop_page_b.php?prop=50&election=2016'>PROP 50",

//2016 GENERAL
"<a href='prop_page_b.php?prop=51&election=2016'>PROP 51",
"<a href='prop_page_b.php?prop=52&election=2016'>PROP 52",
"<a href='prop_page_b.php?prop=53&election=2016'>PROP 53",
"<a href='prop_page_b.php?prop=54&election=2016'>PROP 54",
"<a href='prop_page_b.php?prop=55&election=2016'>PROP 55",
"<a href='prop_page_b.php?prop=56&election=2016'>PROP 56",
"<a href='prop_page_b.php?prop=57&election=2016'>PROP 57",
"<a href='prop_page_b.php?prop=58&election=2016'>PROP 58",
"<a href='prop_page_b.php?prop=59&election=2016'>PROP 59",
"<a href='prop_page_b.php?prop=60&election=2016'>PROP 60",
"<a href='prop_page_b.php?prop=61&election=2016'>PROP 61",
"<a href='prop_page_b.php?prop=62&election=2016'>PROP 62",
"<a href='prop_page_b.php?prop=63&election=2016'>PROP 63",
"<a href='prop_page_b.php?prop=64&election=2016'>PROP 64",
"<a href='prop_page_b.php?prop=65&election=2016'>PROP 65",
"<a href='prop_page_b.php?prop=66&election=2016'>PROP 66",
"<a href='prop_page_b.php?prop=67&election=2016'>PROP 67",

//2018 PENDING

"<a href='pending_prop_page_b.php?id=1396282'>17-0002",
"<a href='pending_prop_page_b.php?id=1396334'>17-0003",
"<a href='pending_prop_page_b.php?id=1397561'>17-0004",
"<a href='pending_prop_page_b.php?id=1397817'>17-0005",
"<a href='pending_prop_page_b.php?id=1397973'>17-0006",
"<a href='pending_prop_page_b.php?id=1398766'>17-0007",
"<a href='pending_prop_page_b.php?id=1398767'>17-0008",
"<a href='pending_prop_page_b.php?id=1398969'>17-0009",
"<a href='pending_prop_page_b.php?id=1399109'>17-0010",
"<a href='pending_prop_page_b.php?id=1399235'>17-0011",
"<a href='pending_prop_page_b.php?id=1399245'>17-0012",
"<a href='pending_prop_page_b.php?id=1399247'>17-0013",
"<a href='pending_prop_page_b.php?id=1399587'>17-0014",
"<a href='pending_prop_page_b.php?id=1399590'>17-0015",
"<a href='pending_prop_page_b.php?id=1399694'>17-0016",
"<a href='pending_prop_page_b.php?id=1399712'>17-0017",
"<a href='pending_prop_page_b.php?id=1399762'>17-0018",
"<a href='pending_prop_page_b.php?id=1399763'>17-0019",
"<a href='pending_prop_page_b.php?id=1399796'>17-0020",
"<a href='pending_prop_page_b.php?id=1399797'>17-0021",
"<a href='pending_prop_page_b.php?id=1399853'>17-0022",
"<a href='pending_prop_page_b.php?id=1399854'>17-0023",
"<a href='pending_prop_page_b.php?id=1399916'>17-0024",
"<a href='pending_prop_page_b.php?id=1399947'>17-0025",
"<a href='pending_prop_page_b.php?id=1399988'>17-0026",
"<a href='pending_prop_page_b.php?id=1399855'>17-0040"

);

$i = 0;
foreach($prop_nav as $link) {
    if(strpos($link, $current)) {
        $offset = $i;
        break;
    }
    $i++;
}

$links['prev'] = $prop_nav[$offset - 1];
$links['next'] = $prop_nav[$offset + 1];

if(!$links['prev']) {
    $links['prev'] = "<a href='prop_page_b.php?prop=67&election=2016'>PROP 67";
}

if(!$links['next']) {
    $links['next'] = "<a href='prop_page_b.php?prop=73&election=2006'>PROP 73";
}

return $links;



}


?>