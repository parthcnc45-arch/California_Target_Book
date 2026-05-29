<?php

//include "/php/connections.php";
include "connections.php";

$racetotals = Array();

/*
        CCCCCCCCCCCCCTTTTTTTTTTTTTTTTTTTTTTTBBBBBBBBBBBBBBBBB
     CCC::::::::::::CT:::::::::::::::::::::TB::::::::::::::::B
   CC:::::::::::::::CT:::::::::::::::::::::TB::::::BBBBBB:::::B
  C:::::CCCCCCCC::::CT:::::TT:::::::TT:::::TBB:::::B     B:::::B
 C:::::C       CCCCCCTTTTTT  T:::::T  TTTTTT  B::::B     B:::::B
C:::::C                      T:::::T          B::::B     B:::::B
C:::::C                      T:::::T          B::::BBBBBB:::::B
C:::::C                      T:::::T          B:::::::::::::BB
C:::::C                      T:::::T          B::::BBBBBB:::::B
C:::::C                      T:::::T          B::::B     B:::::B
C:::::C                      T:::::T          B::::B     B:::::B
 C:::::C       CCCCCC        T:::::T          B::::B     B:::::B
  C:::::CCCCCCCC::::C      TT:::::::TT      BB:::::BBBBBB::::::B
   CC:::::::::::::::C      T:::::::::T      B:::::::::::::::::B
     CCC::::::::::::C      T:::::::::T      B::::::::::::::::B
        CCCCCCCCCCCCC      TTTTTTTTTTT      BBBBBBBBBBBBBBBBB
*/

//CALIFORNIA TARGET BOOK LINK RETRIEVAL FUNCTIONS

//RETURN CALIFORNIA TARGET BOOK WEBSITE COUNTY PAGE LINK BASED ON COUNTY NUMBER (i.e. 0 = Alameda, 1 = Alpine, 2 = Amador, etc.)
function getcountylink($value)
{
    $countylink = Array(
        "/book/county/ALAMEDA",
        "/book/county/ALPINE",
        "/book/county/AMADOR",
        "/book/county/BUTTE",
        "/book/county/CALAVERAS",
        "/book/county/COLUSA",
        "/book/county/CONTRA%20COSTA",
        "/book/county/DEL%20NORTE",
        "/book/county/EL%20DORADO",
        "/book/county/FRESNO",
        "/book/county/GLENN",
        "/book/county/HUMBOLDT",
        "/book/county/IMPERIAL",
        "/book/county/INYO",
        "/book/county/KERN",
        "/book/county/KINGS",
        "/book/county/LAKE",
        "/book/county/LASSEN",
        "/book/county/LOS ANGELES",
        "/book/county/MADERA",
        "/book/county/MARIN",
        "/book/county/MARIPOSA",
        "/book/county/MENDOCINO",
        "/book/county/MERCED",
        "/book/county/MODOC",
        "/book/county/MONO",
        "/book/county/MONTEREY",
        "/book/county/NAPA",
        "/book/county/NEVADA",
        "/book/county/ORANGE",
        "/book/county/PLACER",
        "/book/county/PLUMAS",
        "/book/county/RIVERSIDE",
        "/book/county/SACRAMENTO",
        "/book/county/SAN BENITO",
        "/book/county/SAN BERNARDINO",
        "/book/county/SAN DIEGO",
        "/book/county/SAN FRANCISCO",
        "/book/county/SAN JOAQUIN",
        "/book/county/SAN LUIS OBISPO",
        "/book/county/SAN MATEO",
        "/book/county/SANTA BARBARA",
        "/book/county/SANTA CLARA",
        "/book/county/SANTA CRUZ",
        "/book/county/SHASTA",
        "/book/county/SIERRA",
        "/book/county/SISKIYOU",
        "/book/county/SOLANO",
        "/book/county/SONOMA",
        "/book/county/STANISLAUS",
        "/book/county/SUTTER",
        "/book/county/TEHAMA",
        "/book/county/TRINITY",
        "/book/county/TULARE",
        "/book/county/TUOLUMNE",
        "/book/county/VENTURA",
        "/book/county/YOLO",
        "/book/county/YUBA"
    );
    $retval = $countylink[$value - 1];

    return $retval;
}


//GET TARGET BOOK WESBITE PAGE LINK BASED OFF OF FOURCODE
function getctblink($fourcode)
{

    $retval = "<a href='/book/district/$fourcode' target='_blank'>'";
    return $retval;
}

function distnav_all($baseurl)
{

    echo("<div class='newseg'>");

    $target = "target='loweriframe'";

    $i = 1;
    echo("<p align='center' class='boldme'>ASSEMBLY</p><p class='boldme' align='center'>");
    while ($i < 81) {
        $fourcode = "AD" . checkaddzero($i);
        echo("<a href='$baseurl$fourcode' $target>" . checkaddzero($i) . "</a>&nbsp;");
        $i++;
    }

    echo("</p><p align='center' class='boldme'>STATE SENATE</p><p class='boldme' align='center'>");
    $i = 1;
    while ($i < 41) {
        $fourcode = "SD" . checkaddzero($i);
        echo("<a href='$baseurl$fourcode' $target>" . checkaddzero($i) . "</a>&nbsp;");
        $i++;
    }

    echo("</p><p align='center' class='boldme'>CONGRESSIONAL DISTRICT</p><p class='boldme' align='center'>");
    $i = 1;
    while ($i < 54) {
        $fourcode = "CD" . checkaddzero($i);
        echo("<a href='$baseurl$fourcode' $target>" . checkaddzero($i) . "</a>&nbsp;");
        $i++;
    }

    echo("</p><p align='center' class='boldme'>COUNTY</p><p class='boldme' align='center'>");
    $i = 1;
    while ($i < 59) {
        $fourcode = "CO" . checkaddzero($i);
        echo("<a href='$baseurl$fourcode' $target>" . getcountyname($i) . "</a>&nbsp;�&nbsp;");
        $i++;
    }

    echo("<p><p align='center' class='boldme'>STATEWIDE</p><p class='boldme' align='center'><a href='" . $baseurl . "STW' $target>STATEWIDE</a>");
    echo("</p></div>");

    echo("<iframe width='100%' height='1280px' name='loweriframe'></iframe>");

}

/*

        CCCCCCCCCCCCC                  lllllll                AAA
     CCC::::::::::::C                  l:::::l               A:::A
   CC:::::::::::::::C                  l:::::l              A:::::A
  C:::::CCCCCCCC::::C                  l:::::l             A:::::::A
 C:::::C       CCCCCC  aaaaaaaaaaaaa    l::::l            A:::::::::A            cccccccccccccccc    cccccccccccccccc    eeeeeeeeeeee        ssssssssss       ssssssssss
C:::::C                a::::::::::::a   l::::l           A:::::A:::::A         cc:::::::::::::::c  cc:::::::::::::::c  ee::::::::::::ee    ss::::::::::s    ss::::::::::s
C:::::C                aaaaaaaaa:::::a  l::::l          A:::::A A:::::A       c:::::::::::::::::c c:::::::::::::::::c e::::::eeeee:::::eess:::::::::::::s ss:::::::::::::s
C:::::C                         a::::a  l::::l         A:::::A   A:::::A     c:::::::cccccc:::::cc:::::::cccccc:::::ce::::::e     e:::::es::::::ssss:::::ss::::::ssss:::::s
C:::::C                  aaaaaaa:::::a  l::::l        A:::::A     A:::::A    c::::::c     cccccccc::::::c     ccccccce:::::::eeeee::::::e s:::::s  ssssss  s:::::s  ssssss
C:::::C                aa::::::::::::a  l::::l       A:::::AAAAAAAAA:::::A   c:::::c             c:::::c             e:::::::::::::::::e    s::::::s         s::::::s
C:::::C               a::::aaaa::::::a  l::::l      A:::::::::::::::::::::A  c:::::c             c:::::c             e::::::eeeeeeeeeee        s::::::s         s::::::s
 C:::::C       CCCCCCa::::a    a:::::a  l::::l     A:::::AAAAAAAAAAAAA:::::A c::::::c     cccccccc::::::c     ccccccce:::::::e           ssssss   s:::::s ssssss   s:::::s
  C:::::CCCCCCCC::::Ca::::a    a:::::a l::::::l   A:::::A             A:::::Ac:::::::cccccc:::::cc:::::::cccccc:::::ce::::::::e          s:::::ssss::::::ss:::::ssss::::::s
   CC:::::::::::::::Ca:::::aaaa::::::a l::::::l  A:::::A               A:::::Ac:::::::::::::::::c c:::::::::::::::::c e::::::::eeeeeeee  s::::::::::::::s s::::::::::::::s
     CCC::::::::::::C a::::::::::aa:::al::::::l A:::::A                 A:::::Acc:::::::::::::::c  cc:::::::::::::::c  ee:::::::::::::e   s:::::::::::ss   s:::::::::::ss
        CCCCCCCCCCCCC  aaaaaaaaaa  aaaallllllllAAAAAAA                   AAAAAAA cccccccccccccccc    cccccccccccccccc    eeeeeeeeeeeeee    sssssssssss      sssssssssss



*/

//RETRIEVE COMMITTEE NAME FROM FILER ID

function getcommitteename($value)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $cx = check_crossref($value);
    if($cx) {
        $value = $cx;
    }
    $sql = "SELECT NAML from calaccess_raw_FILERNAME_CD WHERE FILER_ID = '" . $value . "' LIMIT 1";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['NAML'];
        }
    } else {
        $retval = "NOT AVAILABLE";
    }

    return $retval;
}

function check_crossref($committee)
    {
        global $calaccess_conn;
        $conn = Util::get_ctb_conn();
        $retval = FALSE;
        $sql = "SELECT FILER_ID FROM calaccess_raw_FILER_XREF_CD WHERE XREF_ID = '$committee' ORDER BY FILER_ID DESC LIMIT 1 ";
        //echo("<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILER_ID'];
            }
        }

        //echo($retval);
        return $retval;
    }

//RETRIEVE FILERNAME FROM A FILING ID

function getfilerinfo($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILING_ID = '$filing'";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['FILER_ID'] = $row['FILER_ID'];
        }
    }

    $sql = "SELECT * FROM calaccess_raw_FILERNAME_CD WHERE FILER_ID = '" . $tmp['FILER_ID'] . "' LIMIT 1";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['NAML'] = $row['NAML'];
            $tmp['NAMF'] = $row['NAMF'];
        }
    }

    return $tmp;
}

/*

FFFFFFFFFFFFFFFFFFFFFF    444444444          66666666        000000000
F::::::::::::::::::::F   4::::::::4         6::::::6       00:::::::::00
F::::::::::::::::::::F  4:::::::::4        6::::::6      00:::::::::::::00
FF::::::FFFFFFFFF::::F 4::::44::::4       6::::::6      0:::::::000:::::::0
  F:::::F       FFFFFF4::::4 4::::4      6::::::6       0::::::0   0::::::0
  F:::::F            4::::4  4::::4     6::::::6        0:::::0     0:::::0
  F::::::FFFFFFFFFF 4::::4   4::::4    6::::::6         0:::::0     0:::::0
  F:::::::::::::::F4::::444444::::444 6::::::::66666    0:::::0 000 0:::::0
  F:::::::::::::::F4::::::::::::::::46::::::::::::::66  0:::::0 000 0:::::0
  F::::::FFFFFFFFFF4444444444:::::4446::::::66666:::::6 0:::::0     0:::::0
  F:::::F                    4::::4  6:::::6     6:::::60:::::0     0:::::0
  F:::::F                    4::::4  6:::::6     6:::::60::::::0   0::::::0
FF:::::::FF                  4::::4  6::::::66666::::::60:::::::000:::::::0
F::::::::FF                44::::::44 66:::::::::::::66  00:::::::::::::00
F::::::::FF                4::::::::4   66:::::::::66      00:::::::::00
FFFFFFFFFFF                4444444444     666666666          000000000

*/


/*

function lookuplastf460($committee)
LOOKUP LAST F460 CAMPAIGN STATEMENT FOR A SPECIFIC COMMITTEE

RETURNS RESULT IN AN ASSOCIATIVE ARRAY
$retval['FILING_ID'] = Filing ID number of last F460
$retval['RPT_END']   = Reporting End Date from most recent F460

*/

function lookuplastf460($committee)
{
    if(!isset($committee)) return FALSE;
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = " . $committee . " && FORM_ID = 'F460' && PERIOD_ID > 0 ORDER BY RPT_END DESC, FILING_ID ASC LIMIT 1";
    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['RPT_START'] = $row['RPT_START'];
            $retval['RPT_END'] = $row['RPT_END'];
            $retval['FILING_ID'] = $row['FILING_ID'];
        }
    }

    return $retval;
}

/*

GET ALL F460s FOR A SPECIFIC COMMITTEE

*/

function getallf460($committee)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && PERIOD_ID > 0 ORDER BY RPT_END DESC, FILING_ID DESC, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($result->num_rows > 0 && $result !== FALSE) {
	$lastid = '';
        while ($row = $result->fetch_assoc()) {
            $thisid = $row['FILING_ID'];
            if ($thisid <> $lastid) {
                $tmp['RPT_START'] = $row['RPT_START'];
                $tmp['RPT_END'] = $row['RPT_END'];
                $tmp['FILING_ID'] = $row['FILING_ID'];
                $tmp['FILING_SEQUENCE'] = $row['FILING_SEQUENCE'];
                array_push($retval, $tmp);
            }
            $lastid = $row['FILING_ID'];
        }
    }
    return $retval;
}

/*RETRIEVE F460 SUMMARY INFORMATION FROM SPECIFIC FILING NUMBER

RETURNS RESULT IN AN ASSOCIATIVE ARRAY
$retval['RCPT']			= Receipts for this reporting period
$retval['YTD_RCPT']		= Year to date Receipts
$retval['EXPN']			= Expenditures for this reporting period
$retval['YTD_EXPN']		= Year to date Expenditures
$retval['COH_START']	= Cash on hand at start of reporting period
$retval['COH'];			= Cash on hand at end of reporting period
$retval['LOANS'];		= Total Loans
$retval['DEBTS'];		= Total Unpaid Bills (Including Loans)

*/


function getf460summary($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    //CONTRIBUTIONS THIS PERIOD
    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['RCPT'] = $row['AMOUNT_A'];

        }
    }
    //CONTRIBUTIONS THIS CALENDAR YEAR
    $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['YTD_RCPT'] = $row['AMOUNT_B'];
        }
    }
    //EXPENDITURES
    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['EXPN'] = $row['AMOUNT_A'];
        }
    }
    //YTD EXPENDITURES
    $sql = "SELECT AMOUNT_B from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['YTD_EXPN'] = $row['AMOUNT_B'];
        }
    }

    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '12' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['COH_START'] = $row['AMOUNT_A'];
        }
    }

    //ENDING CASH ON HAND
    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '16' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['COH'] = $row['AMOUNT_A'];
        }
    }

    //LOANS
    $sql = "SELECT AMOUNT_B FROM SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '2' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['LOANS'] = $row['AMOUNT_B'];
        }
    }
    //DEBTS
    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '19' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['DEBTS'] = $row['AMOUNT_A'];
        }
    }

    return $retval;
}

/*
function getf460a($filing)
RETRIEVES MONETARY CONTRIBUTION ENTRIES FROM A SPECIFIC F460 FILING AS AN ASSOCIATIVE ARRAY, PUSHES THEM INTO AN ARRAY
$x['AMOUNT']		= Contribution Amount
$x['CUM_YTD']		= Year to date cumulative contribution amount for this contributor
$x['CTRIB_NAMF']	= Contributor's First Name
$x['CTRIB_NAML']	= Contributor's Last Name
$x['RCPT_DATE']		= Date Contribution received
$x['CTRIB_CITY']	= Contributor's City
$x['CTRIB_ST']		= Contributor's State
$x['CTRIB_ZIP4']	= Contributor's ZIP Code
$x['CTRIB_EMP'] 	= Contributor's Employer
$x['CTRIB_OCC'] 	= Contributor's Occupation
$x['FILING_ID'] 	= Filing ID for this transaction
$x['CMTE_ID']		= Contributor's Committee ID, if applicable
*/

function getf460a($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $lasttran = '';
    $sql = "SELECT * FROM calaccess_raw_RCPT_CD WHERE FILING_ID = '" . $filing . "' && FORM_TYPE = 'A' GROUP BY TRAN_ID ORDER BY LINE_ITEM, AMEND_ID DESC ";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $thistran = $row['TRAN_ID'];
            if ($thistran == $lasttran) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['CUM_YTD'] = $row['CUM_YTD'];
                $tmp['CTRIB_NAMF'] = $row['CTRIB_NAMF'];
                $tmp['CTRIB_NAML'] = $row['CTRIB_NAML'];
                $tmp['RCPT_DATE'] = $row['RCPT_DATE'];
                $tmp['CTRIB_CITY'] = $row['CTRIB_CITY'];
                $tmp['CTRIB_ST'] = $row['CTRIB_ST'];
                $tmp['CTRIB_ZIP4'] = $row['CTRIB_ZIP4'];
                $tmp['CTRIB_EMP'] = $row['CTRIB_EMP'];
                $tmp['CTRIB_OCC'] = $row['CTRIB_OCC'];
                $tmp['FILING_ID'] = $row['FILING_ID'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                array_push($retval, $tmp);
            }
            $lasttran = $thistran;
        }
    }

    return $retval;
}

/*
function getf460c($filing)
RETRIEVES NON-MONETARY CONTRIBUTION ENTRIES FROM A SPECIFIC F460 FILING AS AN ASSOCIATIVE ARRAY, PUSHES THEM INTO AN ARRAY
$x['AMOUNT']		= Contribution Amount
$x['CUM_YTD']		= Year to date cumulative contribution amount for this contributor
$x['CTRIB_NAMF']	= Contributor's First Name
$x['CTRIB_NAML']	= Contributor's Last Name
$x['RCPT_DATE']		= Date Contribution received
$x['CTRIB_CITY']	= Contributor's City
$x['CTRIB_ST']		= Contributor's State
$x['CTRIB_ZIP4']	= Contributor's ZIP Code
$x['CTRIB_EMP'] 	= Contributor's Employer
$x['CTRIB_OCC'] 	= Contributor's Occupation
$x['CTRIB_DSCR']	= Description of Non-Monetary Contribution
$x['FILING_ID'] 	= Filing ID for this transaction
$x['CMTE_ID']		= Contributor's Committee ID, if applicable
*/

function getf460c($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM calaccess_raw_RCPT_CD WHERE FILING_ID = '" . $filing . "' && FORM_TYPE = 'C' ORDER BY LINE_ITEM, AMEND_ID DESC";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    $j = 0;
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $thistran = $row['TRAN_ID'];
            if ($thistran == $lasttran) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['CUM_YTD'] = $row['CUM_YTD'];
                $tmp['CTRIB_NAMF'] = $row['CTRIB_NAMF'];
                $tmp['CTRIB_NAML'] = $row['CTRIB_NAML'];
                $tmp['RCPT_DATE'] = $row['RCPT_DATE'];
                $tmp['CTRIB_CITY'] = $row['CTRIB_CITY'];
                $tmp['CTRIB_ST'] = $row['CTRIB_ST'];
                $tmp['CTRIB_ZIP4'] = $row['CTRIB_ZIP4'];
                $tmp['CTRIB_EMP'] = $row['CTRIB_EMP'];
                $tmp['CTRIB_OCC'] = $row['CTRIB_OCC'];
                $tmp['CTRIB_DSCR'] = $row['CTRIB_DSCR'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                $tmp['FILING_ID'] = $row['FILING_ID'];
                array_push($retval, $tmp);
            }
            $lasttran = $thistran;
        }
    }

    return $retval;
}

/*
function getf460e($filing)
RETRIEVES EXPENDITURE ENTRIES FROM A SPECIFIC F460 FILING AS AN ASSOCIATIVE ARRAY, PUSHES THEM INTO AN ARRAY
$x['AMOUNT']		= Contribution Amount
$x['PAYEE_NAMF']	= Payee's First Name
$x['PAYEE_NAML']	= Payee's Last Name
$x['EXPN_DATE']		= Date of Expenditure
$x['EXPN_DSCR']		= Description of Expenditure
$x['EXPN_CODE']		= Expenditure Code
$x['PAYEE_CITY']	= Payee's City
$x['PAYEE_ST']		= Payee's State
$x['PAYEE_ZIP4']	= Payee's ZIP Code
$x['CMTE_ID']		= Payee's Committee ID, if applicable
$x['FILING_ID']		= Filing ID for this transaction
*/

function getf460e($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = ArraY();
    $sql = "SELECT * FROM calaccess_raw_EXPN_CD WHERE FILING_ID = '" . $filing . "' && FORM_TYPE = 'E' ORDER BY PAYEE_NAML, PAYEE_NAMF, EXPN_DATE, LINE_ITEM, AMEND_ID DESC";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $thistran = $row['TRAN_ID'];
            if ($thistran == $lasttran) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['PAYEE_NAMF'] = $row['PAYEE_NAMF'];
                $tmp['PAYEE_NAML'] = $row['PAYEE_NAML'];
                $tmp['EXPN_DATE'] = $row['EXPN_DATE'];
                $tmp['EXPN_DSCR'] = $row['EXPN_DSCR'];
                $tmp['EXPN_CODE'] = $row['EXPN_CODE'];
                $tmp['PAYEE_CITY'] = $row['PAYEE_CITY'];
                $tmp['PAYEE_ST'] = $row['PAYEE_ST'];
                $tmp['PAYEE_ZIP4'] = $row['PAYEE_ZIP4'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                $tmp['FILING_ID'] = $row['FILING_ID'];
                array_push($retval, $tmp);
            }
            $lasttran = $thistran;
        }
    }

    return $retval;
}

/*

FFFFFFFFFFFFFFFFFFFFFF    444444444     999999999            66666666
F::::::::::::::::::::F   4::::::::4   99:::::::::99         6::::::6
F::::::::::::::::::::F  4:::::::::4 99:::::::::::::99      6::::::6
FF::::::FFFFFFFFF::::F 4::::44::::49::::::99999::::::9    6::::::6
  F:::::F       FFFFFF4::::4 4::::49:::::9     9:::::9   6::::::6
  F:::::F            4::::4  4::::49:::::9     9:::::9  6::::::6
  F::::::FFFFFFFFFF 4::::4   4::::4 9:::::99999::::::9 6::::::6
  F:::::::::::::::F4::::444444::::44499::::::::::::::96::::::::66666
  F:::::::::::::::F4::::::::::::::::4  99999::::::::96::::::::::::::66
  F::::::FFFFFFFFFF4444444444:::::444       9::::::9 6::::::66666:::::6
  F:::::F                    4::::4        9::::::9  6:::::6     6:::::6
  F:::::F                    4::::4       9::::::9   6:::::6     6:::::6
FF:::::::FF                  4::::4      9::::::9    6::::::66666::::::6
F::::::::FF                44::::::44   9::::::9      66:::::::::::::66
F::::::::FF                4::::::::4  9::::::9         66:::::::::66
FFFFFFFFFFF                4444444444 99999999            666666666

*/

/*
function lookupiecom($lastname, $fourcode)
Returns an array of all committees who have reported independent expenditure activity based on all F496 campaign disclosure forms matching a candidate's last name and the legislative district. Returns an array of Associative Arrays:
$x['FILER_NAML'] = Committee Name or Filer's Last Name
$x['FILER_NAMF'] = Filer's First Name
$x['FILER_ID'] = Filer's FPPC Committee ID
$x['CAND_NAMF'] = First Name of Candidate Supporting or Opposing
$x['CAND_NAML'] = Last Name of Candidate Supporting or Opposing
$x['SUP_OPP_CD'] = Type of expenditure (supporting/opposing)
$x['FILING_ID'] = Filing ID for this Independent Expenditure Filing

*/

function lookupiecom($lastname, $fourcode)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();

    $type = mb_substr($fourcode, 0, 2);                    //CHECK FIRST TWO CHARACTERS OF FOURCODE
    $thisdist = mb_substr($fourcode, 2, 2);
    switch ($type) {                                        //AND CHOOSE THE TYPE OF DISTRICT TO LOOK FOR IN THE FILING
        case "SD":
            $type = "SEN";
            break;
        case "AD":
            $type = "ASM";
            break;
        default:
            break;
    }


    if ($thisdist < 10) {
        $searchfor = $thisdist . "' OR DIST_NO = '" . mb_substr($thisdist, 1, 1);
    } else {
        $searchfor = $thisdist;
    }

    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE (DIST_NO = '" . $searchfor . "') && CAND_NAML like '%" . $lastname . "%' && FORM_TYPE = 'F496' && FILING_ID > '2000000' ORDER BY FILER_ID, FILING_ID DESC, AMEND_ID DESC";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);                        //QUERY SQL LOOKING FOR ALL F496 ENTRIES FOR SENATE OR ASSEMBLY CANDIDATES

    $rowcount = mysqli_num_rows($result);                    //WITH THE CURRENT CANDIDATE'S LAST NAME, ORDER BY INDIVIDUAL COMMITTEE, MOST RECENT FILINGS, AND AMENDED ID
    //echo("<br>SQL returns $rowcount rows for $lastname:<br>");
    //var_dump($result);

    if ($rowcount) {
        //echo("<br>Got rowcount, running stuff...<br>");
        while ($row = $result->fetch_assoc()) {
            $dist_num = $row['DIST_NO'];                //GET THE DISTRICT NUMBER FROM THE COVER PAGE
            if (strlen($dist_num) != 2) {                //AND DOUBLE CHECK IT WITH THE CURRENT DISTRICT
                $dist_num = checkaddzero($dist_num);    //NORMALIZING RESULT INTO A TWO CHARACTER SET
            }
            //echo("<br>Comparing dist $thisdist with $dist_num...<br>");
            if ($thisdist == $dist_num) {                //IF THE DISTRICT AND NAME ALL MATCH UP, WE'RE GOOD TO GO
                $thisfiler = $row['FILER_ID'];            //STORE THE CURRENT COMMITTEE ID
                //echo("<br>Comparing filer $thisfiler with $lastfiler...<br>");
                if ($thisfiler == $lastfiler) {            //IF WE'RE ON THE SAME FILER, PROCEED WITH ADDING THE FILINGS TO THE LIST
                    //DO NOTHING
                } else {
                    //echo("<br>Found new filer, pushing result into array...<br>");
                    $tmp['FILER_NAML'] = $row['FILER_NAML'];    //NEW FILER DETECTED, LOAD INFORMATION
                    $tmp['FILER_NAMF'] = $row['FILER_NAMF'];
                    $tmp['FILER_ID'] = $row['FILER_ID'];
                    $tmp['CAND_NAMF'] = $row['CAND_NAMF'];
                    $tmp['CAND_NAML'] = $row['CAND_NAML'];
                    $tmp['SUP_OPP_CD'] = $row['SUP_OPP_CD'];
                    $tmp['FILING_ID'] = $row['FILING_ID'];
                    array_push($retval, $tmp);
                }
                $lastfiler = $thisfiler;
            }//END DISTRICT VERIFICATION
        }//END WHILE ROW LOOP
    }//END IF ROWCOUNT
    //var_dump($retval);
    return $retval;
}

/*
function getallf496($filerid, $lastdate)
Retrieves an Array of all F496 filingsIDs from a specific filer after a certain date (in 'YYYY-MM-DD' format)

*/

function getallf496($filerid, $lastdate)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $f496_filings = Array();
    $tmp = Array();
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$filerid' && FORM_ID = 'F496' && RPT_DATE > '$lastdate' ORDER BY FILING_DATE DESC, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $thisfiling = $row['FILING_ID'];
            if ($thisfiling == $lastfiling) {
                //DO NOTHING
            } else {
                //$givento = getfilername($thisfiling);

                array_push($retval, $thisfiling);
            }

            $lastfiling = $thisfiling;
        }
    }

    return $retval;
}

/*

function lookupiefilings($lastname, $fourcode, $filer)
Retrieves all F496 Filings from a specific filer, matching by legsislative district and candidate's last name, returning the Filing IDs as an Array

*/

function lookupiefilings($lastname, $fourcode, $filer)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $type = mb_substr($fourcode, 0, 2);                    //CHECK FIRST TWO CHARACTERS OF FOURCODE
    $thisdist = mb_substr($fourcode, 2, 2);
    switch ($type) {                                        //AND CHOOSE THE TYPE OF DISTRICT TO LOOK FOR IN THE FILING
        case "SD":
            $type = "SEN";
            break;
        case "AD":
            $type = "ASM";
            break;
        default:
            break;
    }
    $f496_filings = Array();
    $tmp = Array();
    $committeeinfo = Array();
    $retval = Array();
    $lastfilingid = '';

    if ($thisdist < 10) {
        $searchfor = $thisdist . "' OR DIST_NO = '" . mb_substr($thisdist, 1, 1);
    } else {
        $searchfor = $thisdist;
    }

    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE (DIST_NO = '" . $searchfor . "') && CAND_NAML like '%" . $lastname . "%' && FORM_TYPE = 'F496' && FILER_ID = '$filer' && FILING_ID > '2000000' ORDER BY FILING_ID DESC, AMEND_ID DESC";
    //echo($sql);
    $result = $conn->query($sql);                        //QUERY SQL LOOKING FOR ALL F496 ENTRIES FOR SENATE OR ASSEMBLY CANDIDATES
    $rowcount = mysqli_num_rows($result);                    //WITH THE CURRENT CANDIDATE'S LAST NAME, ORDER BY INDIVIDUAL COMMITTEE, MOST RECENT FILINGS, AND AMENDED ID

    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $dist_num = $row['DIST_NO'];                //GET THE DISTRICT NUMBER FROM THE COVER PAGE
            if (strlen($dist_num) != 2) {                //AND DOUBLE CHECK IT WITH THE CURRENT DISTRICT
                $dist_num = checkaddzero($dist_num);    //NORMALIZING RESULT INTO A TWO CHARACTER SET
            }
            if ($thisdist == $dist_num) {                //IF THE DISTRICT AND NAME ALL MATCH UP, WE'RE GOOD TO GO
                $thisfilingid = $row['FILING_ID'];        //AND FILING ID FOR REFERENCE
                if ($thisfilingid == $lastfilingid) {//IF THIS IS AN AMENDED FILING, IGNORE PUTTING IT ON THE LIST
                    //DO NOTHING
                } else {
                    array_push($retval, $thisfilingid);
                    $lastfilingid = $thisfilingid;
                }//END SAME FILING ID VERIFICATION}
            }//END DISTRICT VERIFICATION
        }//END WHILE ROW LOOP
    }//END IF ROWCOUNT
    return $retval;
}

function gethighestamend($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID = '$filing' ORDER BY AMEND_ID DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['AMEND_ID'];
        }
    }

    return $retval;
}

/*

function getf496amt($filing)
Retrieves each transaction from a specific F496 Filing as an Associative Array, pushes each result into an array:
$x['AMOUNT'] = Indepedent Expenditure Amount
$x['EXPN_DSCR'] = Independent Expenditure Description
$x['EXP_DATE'] = Date of Independent Expenditure
$x['FILING_ID'] = Filing ID for this Independent Expenditure

*/

function getf496amt($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();

    $tmp = Array();
    $retval = Array();
    $result = Array();
    $highest = gethighestamend($filing);
    $sql = "SELECT * FROM calaccess_raw_S496_CD WHERE FILING_ID = '$filing' && AMEND_ID = '$highest' ORDER BY LINE_ITEM, AMEND_ID DESC";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        $lasttrans = '';
        while ($row = $result->fetch_assoc()) {
            $thistrans = $row['LINE_ITEM'];
            if (!$highestamend) {
                $highestamend = $row['AMEND_ID'];
            }
            if ($thistrans == $lasttrans || $row['AMEND_ID'] < $highestamend) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['EXPN_DSCR'] = $row['EXPN_DSCR'];
                $tmp['EXP_DATE'] = $row['EXP_DATE'];
                $tmp['FILING'] = $row['FILING_ID'];
                array_push($retval, $tmp);
            }
            $lasttrans = $thistrans;
        }
    }

    return $retval;
}

function getf496detail($filing)
{
    global $calaccess_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $sql = "SELECT CAND_NAML, JURIS_CD, DIST_NO, SUP_OPP_CD, BAL_NAME, BAL_JURIS, FILER_ID FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID = '$filing'";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CAND_NAML'] = $row['CAND_NAML'];
            $tmp['JURIS_CD'] = $row['JURIS_CD'];
            $tmp['DIST_NO'] = $row['DIST_NO'];
            $tmp['SUP_OPP_CD'] = $row['SUP_OPP_CD'];
            $tmp['BAL_NAME'] = $row['BAL_NAME'];
            $tmp['BAL_JURIS'] = $row['BAL_JURIS'];
            $tmp['FILER_ID'] = $row['FILER_ID'];

        }
    }

    return $tmp;
}

function loadf496($filerid, $lastdate)
{
    $filings = getallf496($filerid, $lastdate);
    $retval = getf496exp($filings);

    return $retval;
}

function getf496exp($filings)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();
    foreach ($filings as $filing) {
        $tmp = Array();
        $filing_number = $filing;
        $highest = gethighestamend($filing);
        $sql = "SELECT * FROM calaccess_raw_S496_CD WHERE FILING_ID = '$filing' && AMEND_ID = '$highest' GROUP BY TRAN_ID";
        $result = $conn->query($sql);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount) {
            while ($row = $result->fetch_assoc()) {
                $thisfiling = $filing;
                $tmp = getf496amt($filing_number);
                if ($thisfiling != $lastfiling) {
                    array_push($retval, $tmp);
                }
                $lastfiling = $thisfiling;
            }
        }
    }

    return $retval;
}

/*

FFFFFFFFFFFFFFFFFFFFFF    444444444     999999999     77777777777777777777
F::::::::::::::::::::F   4::::::::4   99:::::::::99   7::::::::::::::::::7
F::::::::::::::::::::F  4:::::::::4 99:::::::::::::99 7::::::::::::::::::7
FF::::::FFFFFFFFF::::F 4::::44::::49::::::99999::::::9777777777777:::::::7
  F:::::F       FFFFFF4::::4 4::::49:::::9     9:::::9           7::::::7
  F:::::F            4::::4  4::::49:::::9     9:::::9          7::::::7
  F::::::FFFFFFFFFF 4::::4   4::::4 9:::::99999::::::9         7::::::7
  F:::::::::::::::F4::::444444::::44499::::::::::::::9        7::::::7
  F:::::::::::::::F4::::::::::::::::4  99999::::::::9        7::::::7
  F::::::FFFFFFFFFF4444444444:::::444       9::::::9        7::::::7
  F:::::F                    4::::4        9::::::9        7::::::7
  F:::::F                    4::::4       9::::::9        7::::::7
FF:::::::FF                  4::::4      9::::::9        7::::::7
F::::::::FF                44::::::44   9::::::9        7::::::7
F::::::::FF                4::::::::4  9::::::9        7::::::7
FFFFFFFFFFF                4444444444 99999999        77777777

*/

/*
function getallf497($committee, $date)
Retrieves all F497 Late Contribution Filings reported by a candidate or committee's Filing ID after a certain date (in YYYY-MM-DD format), returns an Array of Filing IDs

*/

function getallf497($committee, $date)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $lastid = '';

    if ($committee != "NOT AVAILABLE") {
        $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '" . $committee . "' && FORM_ID = 'F497' && FILING_DATE > '" . $date . "' ORDER BY 'RPT_END' DESC,FILING_ID, FILING_SEQUENCE DESC";
        //echo("<br>$sql");
        $result = $conn->query($sql);
        $rowcount = mysqli_num_rows($result);
        if ($rowcount) {
            while ($row = $result->fetch_assoc()) {
                $thisid = $row['FILING_ID'];
                if ($thisid == $lastid) {
                } else {
                    array_push($retval, $row['FILING_ID']);
                    //echo("Pushing Filing #" . $row['FILING_ID'] . " from $committee onto array...<br>");

                }
                $lastid = $row['FILING_ID'];
            }
        }
    }

    return $retval;
}

/*

function getf497amt($filing, $date)
Retrieves all late contributions from an individual filing that occurred after a certain date (in YYYY-MM-DD format) as an Associative Array, pushes the results into an array:
$x['AMOUNT'] = Late Contribution Amount
$x['ENTY_NAMF'] = Contributor's First Name
$x['ENTY_NAML'] = Contributor's Last Name, or Committee Name
$x['CTRIB_DATE'] = Contribution Date
$x['ENTY_CITY'] = Contributor's City
$x['ENTY_ST'] = Contributor's State
$x['ENTY_ZIP4'] = Contributor's ZIP Code
$x['CTRIB_EMP'] = Contributor's Employer
$x['CTRIB_OCC'] = Contributor's Occupation
$x['CMTE_ID'] = Contributor's Committee ID, if applicable
$x['FILING'] = Filing ID for this Contribution


*/

function getf497amt($filing, $date)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $result = Array();
    $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FILING_ID = '$filing' && FORM_TYPE = 'F497P1' && CTRIB_DATE > '" . $date . "' ORDER BY TRAN_ID DESC, AMEND_ID DESC";
    //echo("<br>Retrieving amounts from Filing #$filing");
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        $lasttrans = '';
        while ($row = $result->fetch_assoc()) {
            $thistrans = $row['TRAN_ID'];
            if ($thistrans == $lasttrans) {
                //DO NOTHING
            } else {
                $tmp['AMOUNT'] = $row['AMOUNT'];
                $tmp['ENTY_NAMF'] = $row['ENTY_NAMF'];
                $tmp['ENTY_NAML'] = $row['ENTY_NAML'];
                $tmp['CTRIB_DATE'] = $row['CTRIB_DATE'];
                $tmp['ENTY_CITY'] = $row['ENTY_CITY'];
                $tmp['ENTY_ST'] = $row['ENTY_ST'];
                $tmp['ENTY_ZIP4'] = $row['ENTY_ZIP4'];
                $tmp['CTRIB_EMP'] = $row['CTRIB_EMP'];
                $tmp['CTRIB_OCC'] = $row['CTRIB_OCC'];
                $tmp['FILING'] = $row['FILING_ID'];
                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                array_push($retval, $tmp);
                //echo("<br>Pushing " . $tmp['AMOUNT'] . " onto Array...");
            }
            $lasttrans = $thistrans;
        }
    }

    return $retval;
}

/*

                                        bbbbbbbb           bbbbbbbb
LLLLLLLLLLL                             b::::::b           b::::::b
L:::::::::L                             b::::::b           b::::::b
L:::::::::L                             b::::::b           b::::::b
LL:::::::LL                              b:::::b            b:::::b
  L:::::L                  ooooooooooo   b:::::bbbbbbbbb    b:::::bbbbbbbbb yyyyyyy           yyyyyyy
  L:::::L                oo:::::::::::oo b::::::::::::::bb  b::::::::::::::bby:::::y         y:::::y
  L:::::L               o:::::::::::::::ob::::::::::::::::b b::::::::::::::::by:::::y       y:::::y
  L:::::L               o:::::ooooo:::::ob:::::bbbbb:::::::bb:::::bbbbb:::::::by:::::y     y:::::y
  L:::::L               o::::o     o::::ob:::::b    b::::::bb:::::b    b::::::b y:::::y   y:::::y
  L:::::L               o::::o     o::::ob:::::b     b:::::bb:::::b     b:::::b  y:::::y y:::::y
  L:::::L               o::::o     o::::ob:::::b     b:::::bb:::::b     b:::::b   y:::::y:::::y
  L:::::L         LLLLLLo::::o     o::::ob:::::b     b:::::bb:::::b     b:::::b    y:::::::::y
LL:::::::LLLLLLLLL:::::Lo:::::ooooo:::::ob:::::bbbbbb::::::bb:::::bbbbbb::::::b     y:::::::y
L::::::::::::::::::::::Lo:::::::::::::::ob::::::::::::::::b b::::::::::::::::b       y:::::y
L::::::::::::::::::::::L oo:::::::::::oo b:::::::::::::::b  b:::::::::::::::b       y:::::y
LLLLLLLLLLLLLLLLLLLLLLLL   ooooooooooo   bbbbbbbbbbbbbbbb   bbbbbbbbbbbbbbbb       y:::::y
                                                                                  y:::::y
                                                                                 y:::::y
                                                                                y:::::y
                                                                               y:::::y
                                                                              yyyyyyy

*/

function get_lemp($filing)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM calaccess_raw_lemp_cd WHERE FILING_ID = '" . $filing . "' ORDER BY CLI_NAML ASC, AMEND_ID DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['AGENCYLIST'] = $row['AGENCYLIST'];
            $tmp['CLI_CITY'] = $row['CLI_CITY'];
            $tmp['CLI_NAMF'] = $row['CLI_NAMF'];
            $tmp['CLI_NAML'] = $row['CLI_NAML'];
            $tmp['CLI_ZIP4'] = $row['CLI_ZIP4'];
            $tmp['CLIENT_ID'] = $row['CLIENT_ID'];
            $tmp['EFF_DATE'] = $row['EFF_DATE'];
            $tmp['CON_PERIOD'] = $row['CON_PERIOD'];
            $tmp['DESCRIP'] = $row['DESCRIP'];
            $tmp['FILING_ID'] = $row['FILING_ID'];

            $thisamendid = $row['AMEND_ID'];

            if ($thisamendid < $lastamendid) {
                //DO NOTHING
            } else {
                array_push($retval, $tmp);
            }
            $lastamendid = $thisamendid;
        }
    }

    return $retval;
}

function get_lexp($filing)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM calaccess_raw_lemp_cd WHERE FILING_ID = '" . $filing . "' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['AMOUNT'] = $row['AMOUNT'];
            $tmp['BENE_AMT'] = $row['BENE_AMT'];
            $tmp['BENE_NAME'] = $row['BENE_NAME'];
            $tmp['BENE_POSIT'] = $row['BENE_POSIT'];
            $tmp['EXPN_DATE'] = $row['EXPN_DATE'];
            $tmp['EXPN_DSCR	'] = $row['EXPN_DSCR'];
            $tmp['EFF_DATE'] = $row['EFF_DATE'];
            $tmp['CON_PERIOD'] = $row['CON_PERIOD'];
            $tmp['DESCRIP'] = $row['DESCRIP'];
            $tmp['FILING_ID'] = $row['FILING_ID'];

            $thisamendid = $row['AMEND_ID'];

            if ($thisamendid < $lastamendid) {
                //DO NOTHING
            } else {
                array_push($retval, $tmp);
            }
            $lastamendid = $thisamendid;
        }
    }

    return $retval;
}

function getleglobby($bill)
{
    $conn = Util::get_ctb_conn();
    $stripped_code = str_replace("-", " ", $bill);
    $tmp = explode(" ", $stripped_code);
    $src = $tmp[0];
    $num = $tmp[1];
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM `calaccess_raw_lpay_cd` WHERE LBY_ACTVTY like '%$src%' &&
	        (LBY_ACTVTY like '% $num %' OR
	         LBY_ACTVTY like '% $num;%' OR
	         LBY_ACTVTY like '% $num,%' OR
	         LBY_ACTVTY like '%$src$num ' OR
	         LBY_ACTVTY like '%$src$num,%' OR
	         LBY_ACTVTY like '%$src$num;')
			ORDER BY `EMPLR_NAML` ASC";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['FILING_ID'] = $row['FILING_ID'];
            $tmp['LBY_ACTVTY'] = $row['LBY_ACTVTY'];
            $tmp['EMPLR_NAML'] = strtoupper($row['EMPLR_NAML']);
            $tmp['FEES_AMT'] = $row['FEES_AMT'];
            $tmp['REIMB_AMT'] = $row['REIMB_AMT'];
            $tmp['ADVAN_AMT'] = $row['ADVAN_AMT'];
            $tmp['PER_TOTAL'] = $row['PER_TOTAL'];
            $tmp['CUM_TOTAL'] = $row['CUM_TOTAL'];
            $x = parselobby($bill, $row['LBY_ACTVTY']);
            if ($x) {
                array_push($retval, $tmp);
            }
        }
    }

    $sql = "SELECT * FROM `calaccess_raw_cvr_lobby_disclosure_cd` WHERE LBY_ACTVTY like '%$src%' &&
	        (LBY_ACTVTY like '% $num %' OR
	         LBY_ACTVTY like '% $num;%' OR
	         LBY_ACTVTY like '% $num,%' OR
	         LBY_ACTVTY like '%$src$num ' OR
	         LBY_ACTVTY like '%$src$num,%' OR
	         LBY_ACTVTY like '%$src$num;') && THRU_DATE > '2014-12-31'
			ORDER BY `FILER_NAML` ASC";
    //echo("<br> $sql <br>");
    $tmp = Array();
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['FILING_ID'] = $row['FILING_ID'];
            $tmp['LBY_ACTVTY'] = $row['LBY_ACTVTY'];
            $tmp['EMPLR_NAML'] = strtoupper($row['FILER_NAML']);
            $x = parselobby($bill, $row['LBY_ACTVTY']);
            //echo("Parsing " . $tmp['LBY_ACTVTY'] . "for $src $num...");
            if ($x) {
                //echo("Found Match, pushing onto array");
                array_push($retval, $tmp);
            }
        }
    }


    return $retval;
}

function parselobby($bill, $activity)
{
    $stripped_code = str_replace("-", " ", $bill);
    $tmp = explode(" ", $stripped_code);
    $src = $tmp[0];
    $num = $tmp[1];
    $retval = FALSE;

    //echo("<br>Verifying $src $num in activity described:<br>$activity");
    $firstletter = mb_substr($src, 0, 1);

    if ($firstletter == "A") {
        $regex = '~(AB.*' . $num . ')~';
        //echo("<br>Using  'A' regex $regex");
    } else {
        $regex = '~.*?(SB.*' . $num . ')~';
        //echo("<br>Using  'S' regex $regex");
    }

    preg_match($regex, $activity, $result);

    $filtered = $result[1];

    if ($firstletter == "A") {
        $regex_a1 = "~(AB.*?)S~";
        preg_match($regex_a1, $filtered, $result2);
        if ($result2[1]) {
            $filtered = $result2[1];
        }
    } else {
        $regex_s1 = '~(SB.*?)A~';
        preg_match($regex_s1, $filtered, $result2);
        if ($result2[1]) {
            $filtered = $result2[1];
        } else {
            $regex_s2 = '~(S.*)S~';
        }
    }

    $x = substr_count($filtered, $num);
    $permutations = Array(' ', ',', ';', '.');

    if ($x) {
        foreach ($permutations as $value) {
            $item = " " . $num;
            $item2 = " " . $num . $value;
            $item3 = $src . $num;
            $m = substr_count($filtered, $item3);
            $y = substr_count($filtered, $item);
            $z = substr_count($filtered, $item2);
            if ($y || $z || $m) {
                $retval = TRUE;
            }
        }
    }

    if ($retval) {
        //echo("<br>Found $src $num in $filtered");
    }

    return $retval;
}

/*

FFFFFFFFFFFFFFFFFFFFFFEEEEEEEEEEEEEEEEEEEEEE       CCCCCCCCCCCCC
F::::::::::::::::::::FE::::::::::::::::::::E    CCC::::::::::::C
F::::::::::::::::::::FE::::::::::::::::::::E  CC:::::::::::::::C
FF::::::FFFFFFFFF::::FEE::::::EEEEEEEEE::::E C:::::CCCCCCCC::::C
  F:::::F       FFFFFF  E:::::E       EEEEEEC:::::C       CCCCCC
  F:::::F               E:::::E            C:::::C
  F::::::FFFFFFFFFF     E::::::EEEEEEEEEE  C:::::C
  F:::::::::::::::F     E:::::::::::::::E  C:::::C
  F:::::::::::::::F     E:::::::::::::::E  C:::::C
  F::::::FFFFFFFFFF     E::::::EEEEEEEEEE  C:::::C
  F:::::F               E:::::E            C:::::C
  F:::::F               E:::::E       EEEEEEC:::::C       CCCCCC
FF:::::::FF           EE::::::EEEEEEEE:::::E C:::::CCCCCCCC::::C
F::::::::FF           E::::::::::::::::::::E  CC:::::::::::::::C
F::::::::FF           E::::::::::::::::::::E    CCC::::::::::::C
FFFFFFFFFFF           EEEEEEEEEEEEEEEEEEEEEE       CCCCCCCCCCCCC



*/

function getfeccand($committee)
{
    global $fec18_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM nufec18_ccl WHERE CMTE_ID = '$committee'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CAND_ID'] = $row['CAND_ID'];
            $x = $row['CAND_ID'];
        }
    }

    $sql = "SELECT * FROM nufec18_cn WHERE CAND_ID = '$x'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CAND_NAME'] = $row['CAND_NAME'];
            $tmp['PARTY'] = $row['CAND_PTY_AFFILIATION'];
            $tmp['CAND_OFFICE'] = $row['CAND_OFFICE'];
            $tmp['CAND_OFFICE_ST'] = $row['CAND_OFFICE_ST'];
            $tmp['CAND_OFFICE_DISTRICT'] = $row['CAND_OFFICE_DISTRICT'];
            $tmp['CAND_ICI'] = $row['CAND_ICI'];
        }
    }

    $retval = $tmp;

    return $retval;
}

function getfeccommitteename($committee)
{
    global $fec18_conn;
    $conn = Util::get_ctb_conn();
    $retval = '';
    $sql = "SELECT CMTE_NM FROM nufec18_cm WHERE CMTE_ID = '$committee'";
    $result = $conn->query($sql);
    if ($result->num_rows) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['CMTE_NM'];
        }
    }

    return $retval;
}

function getfecsum($candidate)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM nufec_weball WHERE CAND_ID = '$candidate'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['RECEIPTS'] = $row['TTL_RECEIPTS'];
            $tmp['EXPN'] = $row['TTL_DISB'];
            $tmp['COH_START'] = $row['COH_BOP'];
            $tmp['COH_END'] = $row['COH_COP'];
            $tmp['CAND_LOANS'] = $row['CAND_LOANS'];
            $tmp['OTH_LOANS'] = $row['OTHER_LOANS'];
            $tmp['CVG_END_DT'] = $row['CVG_END_DATE'];
            $tmp['DEBTS'] = $row['DEBTS_OWED_BY'];
            $year = mb_substr($row['CVG_END_DT'], 6, 4);
            $month = mb_substr($row['CVG_END_DT'], 0, 2);
            $day = mb_substr($row['CVG_END_DT'], 3, 2);
            $tmp['CVG_END_DT'] = $year . "-" . $month . "-" . $day;
        }
    }

    $retval = $tmp;

    return $retval;
}

function getfeccmtesum($cmte_id)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM nufec_webk WHERE CMTE_ID = '$cmte_id'";
    $result = $conn3->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['RECEIPTS'] = $row['TTL_RECEIPTS'];
            $tmp['EXPN'] = $row['TTL_DISB'];
            $tmp['COH_START'] = $row['COH_BOP'];
            $tmp['COH_END'] = $row['COH_COP'];
            $tmp['CAND_LOANS'] = $row['CAND_LOANS'];
            $tmp['OTH_LOANS'] = $row['OTHER_LOANS'];
            $tmp['CVG_END_DT'] = $row['CVG_END_DATE'];
            $tmp['DEBTS'] = $row['DEBTS_OWED_BY'];
            $year = mb_substr($row['CVG_END_DT'], 6, 4);
            $month = mb_substr($row['CVG_END_DT'], 0, 2);
            $day = mb_substr($row['CVG_END_DT'], 3, 2);
            $tmp['CVG_END_DT'] = $year . "-" . $month . "-" . $day;
        }
    }

    $retval = $tmp;

    return $retval;
}

function getfecoth($cmte_id)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $sql = "SELECT * FROM nufec_oth WHERE OTHER_ID = '$cmte_id' ORDER BY CMTE_ID, TRANSACTION_PGI DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $thiscmte = $row['CMTE_ID'];
            $cmte_nm = getfeccommitteename($thiscmte);
            $tmp['CMTE_ID'] = $row['CMTE_ID'];
            $tmp['CMTE_NM'] = $cmte_nm;
            $tmp['TRANSACTION_PGI'] = $row['TRANSACTION_PGI'];
            $tmp['IMAGE_NUM'] = $row['IMAGE_NUM'];
            $tmp['FILE_NUM'] = $row['FILE_NUM'];
            $tmp['TRANSACTION_AMT'] = $row['TRANSACTION_AMT'];

            $year = mb_substr($row['TRANSACTION_DT'], 4, 4);
            $month = mb_substr($row['TRANSACTION_DT'], 0, 2);
            $day = mb_substr($row['TRANSACTION_DT'], 2, 2);
            $tmp['TRANSACTION_DT'] = $year . "-" . $month . "-" . $day;
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function getfedconttocand($cmte_id)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $sql = "SELECT * FROM nufec_pas2 WHERE CMTE_ID = '$cmte_id'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $thiscand = $row['CAND_ID'];
            $x = getfedcandidatedetails($thiscand);
            $fourcode = $x['FOURCODE'];
            $cand_nm = $x['CAND_NM'];
            $party = $x['PARTY'];


            $tmp['FOURCODE'] = $fourcode;
            $tmp['PARTY'] = $party;
            $tmp['CAND_NM'] = $cand_nm;
            $tmp['CMTE_NM'] = $row['NAME'];
            $tmp['CMTE_ID'] = $row['OTHER_ID'];
            $tmp['TRANSACTION_PGI'] = $row['TRANSACTION_PGI'];
            $tmp['IMAGE_NUM'] = $row['IMAGE_NUM'];
            $tmp['FILE_NUM'] = $row['FILE_NUM'];
            $tmp['TRANSACTION_AMT'] = $row['TRANSACTION_AMT'];
            $tmp['CAND_ID'] = $thiscand;

            $year = mb_substr($row['TRANSACTION_DT'], 4, 4);
            $month = mb_substr($row['TRANSACTION_DT'], 0, 2);
            $day = mb_substr($row['TRANSACTION_DT'], 2, 2);
            $tmp['TRANSACTION_DT'] = $year . "-" . $month . "-" . $day;
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function getfedcandidatedetails($cand_id)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $sql = "SELECT * FROM nufec_cn WHERE CAND_ID = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $is_incumbent = $row['CAND_ICI'];
            $cand_status = $row['CAND_STATUS'];
            $cand_office = $row['CAND_OFFICE'];
            $cand_state = $row['CAND_OFFICE_ST'];
            $cand_dist = $row['CAND_OFFICE_DISTRICT'];
            $cand_name = $row['CAND_NAME'];
            $cand_party = $row['CAND_PTY_AFFILIATION'];

            if ($is_incumbent == "I") {
                $appendme = "-Inc";
            } else {
                $appendme = "";
            }

            if ($cand_office == "H") {
                $fourcode = $cand_state . $cand_dist;
            }

            if ($cand_office == "S") {
                $fourcode = $cand_state . "SN";
            }

            if ($cand_office == "P") {
                $fourcode = "PRES";
            }

            $retval['PARTY'] = $cand_party . $appendme;
            $retval['FOURCODE'] = $fourcode;
            $retval['CAND_NM'] = $cand_name;
            $retval['STATUS'] = $cand_status;
        }
    }

    return $retval;
}

function getfeccont($candidate)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    $sql = "SELECT * FROM nufec_indiv WHERE CMTE_ID = '$candidate' ORDER BY NAME ASC, TRANSACTION_PGI DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['MAX_PRIMARY'] = '';
            $tmp['MAX_GENERAL'] = '';
            $tmp['MAX_BOTH'] = '';

            $tmp['NAME'] = $row['NAME'];
            $tmp['CITY'] = $row['CITY'];
            $tmp['STATE'] = $row['STATE'];
            $tmp['ZIP'] = $row['ZIP_CODE'];
            $tmp['EMP'] = $row['EMPLOYER'];
            $tmp['OCC'] = $row['OCCUPATION'];
            $tmp['AMOUNT'] = $row['TRANSACTION_AMT'];
            $tmp['TRANSACTION_PGI'] = $row['TRANSACTION_PGI'];
            $tmp['MEMO_CD'] = $row['MEMO_CD'];
            $tmp['MEMO_TEXT'] = $row['MEMO_TEXT'];
            $tmp['RPT_TP'] = $row['RPT_TP'];
            $tmp['IMAGE_NUM'] = $row['IMAGE_NUM'];
            $tmp['FILE_NUM'] = $row['FILE_NUM'];
            $year = mb_substr($row['TRANSACTION_DT'], 4, 4);
            $month = mb_substr($row['TRANSACTION_DT'], 0, 2);
            $day = mb_substr($row['TRANSACTION_DT'], 2, 2);
            $donorname = $tmp['NAME'];


            $tmp['DATE'] = $year . "-" . $month . "-" . $day;

            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME FROM nufec_indiv WHERE NAME = '$donorname' && CMTE_ID = '$candidate' && TRANSACTION_PGI = 'P'";
            //echo($sql . "\n");
            $result2 = $conn->query($sql);
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $tmp['PRIMARY'] = $row['TOTAL'];
                }
            }

            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME FROM nufec_indiv WHERE NAME = '$donorname' && CMTE_ID = '$candidate' && TRANSACTION_PGI = 'G'";

            $result3 = $conn->query($sql);
            if ($result3->num_rows > 0) {
                while ($row = $result3->fetch_assoc()) {
                    $tmp['GENERAL'] = $row['TOTAL'];
                }
            }

            $flag = "";

            if ($tmp['PRIMARY'] > 2699) {
                $flag = "Maxed Primary (" . $tmp['PRIMARY'] . ") ";
                $tmp['MAX_PRIMARY'] = 1;
            }

            if ($tmp['GENERAL'] > 2699) {
                $flag .= " Maxed General (" . $tmp['GENERAL'] . ") ";
                $tmp['MAX_GENERAL'] = 1;
            }

            if ($tmp['MAX_PRIMARY'] && $tmp['MAX_GENERAL']) {
                $flag .= " Maxed Both (P: " . $tmp['PRIMARY'] . ", G: " . $tmp['GENERAL'] . ") ";
                $tmp['MAX_BOTH'] = 1;
            }

            //echo("<br>$flag<br>");

            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getfecpac($candidate)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    $sql = "SELECT * FROM nufec_pas2 WHERE OTHER_ID = '$candidate' ORDER BY NAME ASC, TRANSACTION_PGI DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CMTE_ID'] = $row['CMTE_ID'];
            $tmp['AMOUNT'] = $row['TRANSACTION_AMT'];
            $tmp['TRANSACTION_PGI'] = $row['TRANSACTION_PGI'];

            $year = mb_substr($row['TRANSACTION_DT'], 4, 4);
            $month = mb_substr($row['TRANSACTION_DT'], 0, 2);
            $day = mb_substr($row['TRANSACTION_DT'], 2, 2);


            $tmp['DATE'] = $year . "-" . $month . "-" . $day;
            $tmp['IMAGE_NUM'] = $row['IMAGE_NUM'];
            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getfecdonorsummary($committee)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    $sql = "SELECT * FROM nufec_indiv WHERE CMTE_ID = '$committee' GROUP BY NAME ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['MAX_PRIMARY'] = '';
            $tmp['MAX_GENERAL'] = '';
            $tmp['MAX_BOTH'] = '';

            $tmp['NAME'] = $row['NAME'];
            $tmp['CITY'] = $row['CITY'];
            $tmp['STATE'] = $row['STATE'];
            $tmp['ZIP'] = $row['ZIP_CODE'];
            $tmp['EMP'] = $row['EMPLOYER'];
            $tmp['OCC'] = $row['OCCUPATION'];
            $donorname = $tmp['NAME'];

            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME FROM nufec_indiv WHERE NAME = '$donorname' && CMTE_ID = '$committee' && TRANSACTION_PGI = 'P'";
            //echo($sql . "\n");
            $result2 = $conn->query($sql);
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $tmp['PRIMARY'] = $row['TOTAL'];
                }
            }

            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME FROM nufec_indiv WHERE NAME = '$donorname' && CMTE_ID = '$committee' && TRANSACTION_PGI = 'G'";

            $result3 = $conn->query($sql);
            if ($result3->num_rows > 0) {
                while ($row = $result3->fetch_assoc()) {
                    $tmp['GENERAL'] = $row['TOTAL'];
                }
            }

            $flag = "";

            if ($tmp['PRIMARY'] > 2699) {
                $flag = "Maxed Primary (" . $tmp['PRIMARY'] . ") ";
                $tmp['MAX_PRIMARY'] = 1;
            }

            if ($tmp['GENERAL'] > 2699) {
                $flag .= " Maxed General (" . $tmp['GENERAL'] . ") ";
                $tmp['MAX_GENERAL'] = 1;
            }

            if ($tmp['MAX_PRIMARY'] && $tmp['MAX_GENERAL']) {
                $flag .= " Maxed Both (P: " . $tmp['PRIMARY'] . ", G: " . $tmp['GENERAL'] . ") ";
                $tmp['MAX_BOTH'] = 1;
            }

            //echo("<br>$flag<br>");

            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getfecexp($candidate)
{
    global $conn3;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    $sql = "SELECT * FROM nufec_oppexp WHERE CMTE_ID = '$candidate'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['PAYEE'] = $row['NAME'];
            $tmp['CITY'] = $row['CITY'];
            $tmp['STATE'] = $row['STATE'];
            $tmp['AMOUNT'] = $row['TRANSACTION_AMT'];
            $tmp['TRANSACTION_PGI'] = $row['TRANSACTION_PGI'];
            $tmp['DESC'] = $row['PURPOSE'];
            $tmp['RPT_YR'] = $row['RPT_YR'];
            $tmp['RPT_TP'] = $row['RPT_TP'];
            $tmp['MEMO_CD'] = $row['MEMO_CD'];
            $tmp['MEMO_TEXT'] = $row['MEMO_TEXT'];

            $year = mb_substr($row['TRANSACTION_DT'], 6, 4);
            $month = mb_substr($row['TRANSACTION_DT'], 0, 2);
            $day = mb_substr($row['TRANSACTION_DT'], 3, 2);


            $tmp['DATE'] = $year . "-" . $month . "-" . $day;
            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getfecexpclasses($committee)
{
    global $conn3;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM nufec_oppexp WHERE CMTE_ID = '$committee' GROUP BY PURPOSE";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['DESC'] = $row['PURPOSE'];
            $purpose = $row['PURPOSE'];
            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, PURPOSE FROM nufec_oppexp WHERE CMTE_ID = '$committee' && PURPOSE = '$purpose'";
            $result2 = $conn->query($sql);
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $tmp['TOTAL'] = $row['TOTAL'];
                }
            }
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function getfecexpindtot($committee)
{
    global $conn3;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SET sql_mode = ''";
    $conn3->query($sql);
    $sql = "SELECT * FROM nufec_oppexp WHERE CMTE_ID = '$committee' GROUP BY NAME";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['NAME'] = $row['NAME'];
            $tmp['PURPOSE'] = $row['PURPOSE'];
            $name = $row['NAME'];
            $sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME FROM nufec_oppexp WHERE CMTE_ID = '$committee' && NAME = '$name'";
            $result2 = $conn->query($sql);
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $tmp['TOTAL'] = $row['TOTAL'];
                }
            }
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

/*

NNNNNNNN        NNNNNNNN                             tttt             ffffffffffffffff    iiii  lllllll
N:::::::N       N::::::N                          ttt:::t            f::::::::::::::::f  i::::i l:::::l
N::::::::N      N::::::N                          t:::::t           f::::::::::::::::::f  iiii  l:::::l
N:::::::::N     N::::::N                          t:::::t           f::::::fffffff:::::f        l:::::l
N::::::::::N    N::::::N    eeeeeeeeeeee    ttttttt:::::ttttttt     f:::::f       ffffffiiiiiii  l::::l     eeeeeeeeeeee
N:::::::::::N   N::::::N  ee::::::::::::ee  t:::::::::::::::::t     f:::::f             i:::::i  l::::l   ee::::::::::::ee
N:::::::N::::N  N::::::N e::::::eeeee:::::eet:::::::::::::::::t    f:::::::ffffff        i::::i  l::::l  e::::::eeeee:::::ee
N::::::N N::::N N::::::Ne::::::e     e:::::etttttt:::::::tttttt    f::::::::::::f        i::::i  l::::l e::::::e     e:::::e
N::::::N  N::::N:::::::Ne:::::::eeeee::::::e      t:::::t          f::::::::::::f        i::::i  l::::l e:::::::eeeee::::::e
N::::::N   N:::::::::::Ne:::::::::::::::::e       t:::::t          f:::::::ffffff        i::::i  l::::l e:::::::::::::::::e
N::::::N    N::::::::::Ne::::::eeeeeeeeeee        t:::::t           f:::::f              i::::i  l::::l e::::::eeeeeeeeeee
N::::::N     N:::::::::Ne:::::::e                 t:::::t    tttttt f:::::f              i::::i  l::::l e:::::::e
N::::::N      N::::::::Ne::::::::e                t::::::tttt:::::tf:::::::f            i::::::il::::::le::::::::e
N::::::N       N:::::::N e::::::::eeeeeeee        tt::::::::::::::tf:::::::f            i::::::il::::::l e::::::::eeeeeeee
N::::::N        N::::::N  ee:::::::::::::e          tt:::::::::::ttf:::::::f            i::::::il::::::l  ee:::::::::::::e
NNNNNNNN         NNNNNNN    eeeeeeeeeeeeee            ttttttttttt  fffffffff            iiiiiiiillllllll    eeeeeeeeeeeeee


*/

//RETURN LONG-FORM OF LOCALITY FROM NETFILE CODE

function locallookup($code)
{
    switch ($code) {
        case "COA":
            $retval = "County - Alameda";
            break;
        case "BCO":
            $retval = "County - Butte";
            break;
        case "CCC":
            $retval = "County - Contra Costa";
            break;
        case "CMAR":
            $retval = "County - Marin";
            break;
        case "MCE":
            $retval = "County - Monterey";
            break;
        case "NEV":
            $retval = "County - Nevada";
            break;
        case "COC":
            $retval = "County - Orange";
            break;
        case "PLA":
            $retval = "County - Placer";
            break;
        case "CTRIV":
            $retval = "County - Riverside";
            break;
        case "SCO":
            $retval = "County - Sacramento";
            break;
        case "SBD":
            $retval = "County - San Bernardino";
            break;
        case "SFO":
            $retval = "County - San Francisco";
            break;
        case "SJC":
            $retval = "County - San Joaquin";
            break;
        case "SLOCO":
            $retval = "County - San Luis Obispo";
            break;
        case "MAT":
            $retval = "County - San Mateo";
            break;
        case "SCC":
            $retval = "County - Santa Clara";
            break;
        case "SCCO":
            $retval = "County - Santa Cruz";
            break;
        case "CSHA":
            $retval = "County - Shasta";
            break;
        case "VCO":
            $retval = "County - Ventura County";
            break;
        case "ANA":
            $retval = "City - Anaheim";
            break;
        case "BRK":
            $retval = "City - Berkeley";
            break;
        case "COB":
            $retval = "City - Burbank";
            break;
        case "CCV":
            $retval = "City - Chula Vista";
            break;
        case "COF":
            $retval = "City - Fresno";
            break;
        case "GLD":
            $retval = "City - Glendale";
            break;
        case "CHB":
            $retval = "City - Huntington Beach";
            break;
        case "COI":
            $retval = "City - Irvine";
            break;
        case "CLF":
            $retval = "City - Lake Forest";
            break;
        case "MTV":
            $retval = "City - Mountain View";
            break;
        case "COAK":
            $retval = "City - Oakland";
            break;
        case "OCN":
            $retval = "City - Oceanside";
            break;
        case "CPA":
            $retval = "City - Palo Alto";
            break;
        case "PSDA":
            $retval = "City - Pasadena";
            break;
        case "COP":
            $retval = "City - Pleasanton";
            break;
        case "SAC":
            $retval = "City - Sacramento";
            break;
        case "CSBN":
            $retval = "City - San Bernardino";
            break;
        case "CSD":
            $retval = "City - San Diego";
            break;
        case "CSJ":
            $retval = "City - San Jose";
            break;
        case "CSA":
            $retval = "City - Santa Ana";
            break;
        case "CSB":
            $retval = "City - Santa Barbara";
            break;
        case "CSC":
            $retval = "City - Santa Clara";
            break;
        case "CSM":
            $retval = "City - Santa Monica";
            break;
        case "CSR":
            $retval = "City - Santa Rosa";
            break;
        case "STO":
            $retval = "City - Stockton";
            break;
        case "COS":
            $retval = "City - Sunnyvale";
            break;
        case "WEHO":
            $retval = "City - West Hollywood";
            break;
        case "WESTS":
            $retval = "City - West Sacramento";
            break;
        default:
            $retval = "Unknown";
            break;
    }

    return $retval;
}

/*

VVVVVVVV           VVVVVVVV                       tttt                                                RRRRRRRRRRRRRRRRR
V::::::V           V::::::V                    ttt:::t                                                R::::::::::::::::R
V::::::V           V::::::V                    t:::::t                                                R::::::RRRRRR:::::R
V::::::V           V::::::V                    t:::::t                                                RR:::::R     R:::::R
 V:::::V           V:::::V ooooooooooo   ttttttt:::::ttttttt        eeeeeeeeeeee    rrrrr   rrrrrrrrr   R::::R     R:::::R    eeeeeeeeeeee       ggggggggg   ggggg
  V:::::V         V:::::Voo:::::::::::oo t:::::::::::::::::t      ee::::::::::::ee  r::::rrr:::::::::r  R::::R     R:::::R  ee::::::::::::ee    g:::::::::ggg::::g
   V:::::V       V:::::Vo:::::::::::::::ot:::::::::::::::::t     e::::::eeeee:::::eer:::::::::::::::::r R::::RRRRRR:::::R  e::::::eeeee:::::ee g:::::::::::::::::g
    V:::::V     V:::::V o:::::ooooo:::::otttttt:::::::tttttt    e::::::e     e:::::err::::::rrrrr::::::rR:::::::::::::RR  e::::::e     e:::::eg::::::ggggg::::::gg
     V:::::V   V:::::V  o::::o     o::::o      t:::::t          e:::::::eeeee::::::e r:::::r     r:::::rR::::RRRRRR:::::R e:::::::eeeee::::::eg:::::g     g:::::g
      V:::::V V:::::V   o::::o     o::::o      t:::::t          e:::::::::::::::::e  r:::::r     rrrrrrrR::::R     R:::::Re:::::::::::::::::e g:::::g     g:::::g
       V:::::V:::::V    o::::o     o::::o      t:::::t          e::::::eeeeeeeeeee   r:::::r            R::::R     R:::::Re::::::eeeeeeeeeee  g:::::g     g:::::g
        V:::::::::V     o::::o     o::::o      t:::::t    tttttte:::::::e            r:::::r            R::::R     R:::::Re:::::::e           g::::::g    g:::::g
         V:::::::V      o:::::ooooo:::::o      t::::::tttt:::::te::::::::e           r:::::r          RR:::::R     R:::::Re::::::::e          g:::::::ggggg:::::g
          V:::::V       o:::::::::::::::o      tt::::::::::::::t e::::::::eeeeeeee   r:::::r          R::::::R     R:::::R e::::::::eeeeeeee   g::::::::::::::::g
           V:::V         oo:::::::::::oo         tt:::::::::::tt  ee:::::::::::::e   r:::::r          R::::::R     R:::::R  ee:::::::::::::e    gg::::::::::::::g
            VVV            ooooooooooo             ttttttttttt      eeeeeeeeeeeeee   rrrrrrr          RRRRRRRR     RRRRRRR    eeeeeeeeeeeeee      gggggggg::::::g
                                                                                                                                                          g:::::g
                                                                                                                                              gggggg      g:::::g
                                                                                                                                              g:::::gg   gg:::::g
                                                                                                                                               g::::::ggg:::::::g
                                                                                                                                                gg:::::::::::::g
                                                                                                                                                  ggg::::::ggg
                                                                                                                                                     gggggg


*/


/*

        CCCCCCCCCCCCC               AAA               LLLLLLLLLLL
     CCC::::::::::::C              A:::A              L:::::::::L
   CC:::::::::::::::C             A:::::A             L:::::::::L
  C:::::CCCCCCCC::::C            A:::::::A            LL:::::::LL
 C:::::C       CCCCCC           A:::::::::A             L:::::L                   eeeeeeeeeeee       ggggggggg   ggggg
C:::::C                        A:::::A:::::A            L:::::L                 ee::::::::::::ee    g:::::::::ggg::::g
C:::::C                       A:::::A A:::::A           L:::::L                e::::::eeeee:::::ee g:::::::::::::::::g
C:::::C                      A:::::A   A:::::A          L:::::L               e::::::e     e:::::eg::::::ggggg::::::gg
C:::::C                     A:::::A     A:::::A         L:::::L               e:::::::eeeee::::::eg:::::g     g:::::g
C:::::C                    A:::::AAAAAAAAA:::::A        L:::::L               e:::::::::::::::::e g:::::g     g:::::g
C:::::C                   A:::::::::::::::::::::A       L:::::L               e::::::eeeeeeeeeee  g:::::g     g:::::g
 C:::::C       CCCCCC    A:::::AAAAAAAAAAAAA:::::A      L:::::L         LLLLLLe:::::::e           g::::::g    g:::::g
  C:::::CCCCCCCC::::C   A:::::A             A:::::A   LL:::::::LLLLLLLLL:::::Le::::::::e          g:::::::ggggg:::::g
   CC:::::::::::::::C  A:::::A               A:::::A  L::::::::::::::::::::::L e::::::::eeeeeeee   g::::::::::::::::g
     CCC::::::::::::C A:::::A                 A:::::A L::::::::::::::::::::::L  ee:::::::::::::e    gg::::::::::::::g
        CCCCCCCCCCCCCAAAAAAA                   AAAAAAALLLLLLLLLLLLLLLLLLLLLLLL    eeeeeeeeeeeeee      gggggggg::::::g
                                                                                                              g:::::g
                                                                                                  gggggg      g:::::g
                                                                                                  g:::::gg   gg:::::g
                                                                                                   g::::::ggg:::::::g
                                                                                                    gg:::::::::::::g
                                                                                                      ggg::::::ggg
                                                                                                         gggggg


*/

function get_vote($bill)
{
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM (SELECT * FROM capublic_bill_detail_vote_tbl WHERE bill_id = '$bill' GROUP BY legislator_name, vote_date_time) A ORDER BY session_date DESC, location_code, motion_id, legislator_name";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['location_code'] = $row['location_code'];
            $tmp['legislator_name'] = $row['legislator_name'];
            $tmp['vote_date_time'] = $row['trans_update'];
            $tmp['vote_code'] = $row['vote_code'];
            $tmp['bill_id'] = $row['bill_id'];
            $tmp['session_date'] = $row['session_date'];
            $tmp['vote_date_seq'] = $row['vote_date_seq'];
            $tmp['motion_id'] = $row['motion_id'];
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function separate_votes($vote)
{
    $tmp = Array();
    $retval = Array();
    $i = 0;
    $lasttime = '';
    $lastplace = '';
    $lastseq = '';
    foreach ($vote as $value) {
        if ($value['session_date'] == $lasttime && $value['location_code'] == $lastplace && $value['motion_id'] == $lastmotion) {
        } else {
            array_push($retval, $tmp);
            $tmp = Array();
        }
        array_push($tmp, $value);
        $lasttime = $value['session_date'];
        $lastplace = $value['location_code'];
        $lastmotion = $value['motion_id'];
    }
    array_push($retval, $tmp);

    return $retval;
}

function get_shortform($bill_id)
{
    global $conn4;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * from capublic_index WHERE bill_id = '$bill_id' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['bill_code'] = $row['bill_code'];
            $retval['bill_desc'] = $row['bill_desc'];
            $retval['bill_author'] = $row['bill_author'];
            $retval['bill_status'] = $row['bill_status'];
        }
    }

    return $retval;
}

function get_location($code)
{
    global $conn4;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM capublic_location_code_tbl WHERE location_code like '%$code%'";
    //echo($sql);
    $result = $conn4->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['description'];
        }
    }

    return $retval;
}

function get_vote_class($value)
{
    $retval = '';

    if ($value['vote_code'] == "NOE") {
        $class = 'redme boldme';
    } elseif ($value['vote_code'] == "AYE") {
        $class = 'greenme boldme';
    } else {
        $class = 'blueme boldme';
    }

    return $class;
}

function get_legislator_party($name, $house)
{
    global $conn;
    $conn = Util::get_ctb_conn();
    $name = remove_accents($name);

    //echo("<br>AMERICANIZED NAME: $name");
    if ($house == "SENATE") {
        $twocode = "SD";
    } else {
        $twocode = "AD";
    }

    if (preg_match('/\s/', $name) > 0) {
        $first = get_first($name);
        $last = get_last($name);
        //echo("<br>T: $first LAST: $last");
        $sql = "SELECT * FROM ctb2016_rcandidates where lastname like '%$last%' && firstname like '%$first%' && rdist_id like '%$twocode%'";
    } else {
        $sql = "SELECT * FROM ctb2016_rcandidates WHERE lastname like '%$name%' && rdist_id like '%$twocode%'";
    }
    //echo("<br>$sql");

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['party'];
        }
    } else {
        //echo($name);
    }

    if (substr_count($name, "Hern") > 0 && $substwocode == 'AD') {
        //echo("FOUND MATCH!!!!!!!!");
        $retval = "DEM";
    } elseif (substr_count($name, "Donnell") > 0) {
        $retval = "DEM";
    } elseif (substr_count($name, "De Le") > 0) {
        $retval = "DEM";
    } elseif ($name == "Chang") {
        $retval = "REP";
    } elseif ($name == "Low") {
        $retval = "DEM";
    } elseif ($name == "Chau") {
        $retval = "DEM";
    } elseif ($name == "Jones") {
        $retval = "REP";
    } elseif ($name == "Jones-Sawyer") {
        $retval = "DEM";
    } elseif ($name == "Cervantes") {
        $retval = "DEM";
    } elseif ($name == "Chu") {
        $retval = "DEM";
    } elseif ($name == "Gonzalez Fletcher") {
        $retval = "DEM";
    } else {
        //DO NOTHING
    }

    return $retval;
}

function getbills()
{
    global $conn4;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    $sql = "SELECT * FROM capublic_index ORDER BY bill_id ASC";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['bill_id'] = $row['bill_id'];
            $tmp['bill_code'] = $row['bill_code'];
            $tmp['bill_desc'] = $row['bill_desc'];
            $tmp['bill_author'] = $row['bill_author'];
            $tmp['bill_status'] = $row['bill_status'];
            $tmp['bill_link'] = $row['bill_link'];
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function getvotehist($legislator)
{
    global $conn4;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();

    if ($legislator == "Gaines") {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name = 'Gaines'";
    } elseif ($legislator == "Low") {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name = 'Low'";
    } elseif ($legislator == "Jones") {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name = 'Jones'";
    } elseif ($legislator == "Allen") {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name = 'Allen'";
    } elseif ($legislator == "Stone") {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name = 'Stone'";
    } else {
        $sql = "SELECT * FROM capublic_bill_detail_vote_tbl WHERE legislator_name like '%$legislator%' ORDER BY vote_date_time DESC";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['location_code'] = $row['location_code'];
            $tmp['legislator_name'] = $row['legislator_name'];
            $tmp['vote_date_time'] = $row['vote_date_time'];
            $tmp['vote_code'] = $row['vote_code'];
            $tmp['bill_id'] = $row['bill_id'];
            $x = (getbillinfo($tmp['bill_id']));
            $tmp['bill_code'] = $x['bill_code'];
            $tmp['bill_desc'] = $x['bill_desc'];
            $tmp['bill_author'] = $x['bill_author'];
            $tmp['bill_status'] = $x['bill_status'];
            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getbillinfo($bill_id)
{
    global $conn4;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM capublic_index WHERE bill_id ='$bill_id' LIMIT 1";
    $result = $conn->query($sql);
    $tmp = Array();
    $retval = Array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['bill_desc'] = $row['bill_desc'];
            $tmp['bill_code'] = $row['bill_code'];
            $tmp['bill_author'] = $row['bill_author'];
            $tmp['bill_status'] = $row['bill_status'];
            $tmp['bill_link'] = $row['bill_link'];
        }
    }

    return $tmp;

}

/*

     OOOOOOOOO
   OO:::::::::OO
 OO:::::::::::::OO
O:::::::OOO:::::::O
O::::::O   O::::::Orrrrr   rrrrrrrrr      ggggggggg   ggggg
O:::::O     O:::::Or::::rrr:::::::::r    g:::::::::ggg::::g
O:::::O     O:::::Or:::::::::::::::::r  g:::::::::::::::::g
O:::::O     O:::::Orr::::::rrrrr::::::rg::::::ggggg::::::gg
O:::::O     O:::::O r:::::r     r:::::rg:::::g     g:::::g
O:::::O     O:::::O r:::::r     rrrrrrrg:::::g     g:::::g
O:::::O     O:::::O r:::::r            g:::::g     g:::::g
O::::::O   O::::::O r:::::r            g::::::g    g:::::g
O:::::::OOO:::::::O r:::::r            g:::::::ggggg:::::g
 OO:::::::::::::OO  r:::::r             g::::::::::::::::g
   OO:::::::::OO    r:::::r              gg::::::::::::::g
     OOOOOOOOO      rrrrrrr                gggggggg::::::g
                                                   g:::::g
                                       gggggg      g:::::g
                                       g:::::gg   gg:::::g
                                        g::::::ggg:::::::g
                                         gg:::::::::::::g
                                           ggg::::::ggg
                                              gggggg

*/

function getstateorgratings()
{
    global $conn;
    $conn = Util::get_ctb_conn();
    $tmp = Array();
    $retval = Array();
    $sql = "SELECT * FROM ctb2016_org ORDER BY LEGISLATOR ASC";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['DIST'] = $row['DIST'];
            $tmp['LEGISLATOR'] = $row['LEGISLATOR'];
            $tmp['PARTY'] = $row['PARTY'];
            $tmp['LCV'] = $row['LCV'];
            $tmp['LCVlife'] = $row['LCVlife'];
            $tmp['HJTA'] = $row['HJTA'];
            $tmp['SIERRA'] = $row['SIERRA'];
            $tmp['CTA'] = $row['CTA'];
            $tmp['PP'] = $row['PP'];
            $tmp['CCC'] = $row['CCC'];
            $tmp['LCC'] = $row['LCC'];
            $tmp['CMTA'] = $row['CMTA'];
            $tmp['NRA'] = $row['NRA'];
            $tmp['ACU'] = $row['ACU'];
            $tmp['AFLCIO'] = $row['AFLCIO'];
            $tmp['EQCA'] = $row['EQCA'];
            $tmp['CTAX'] = $row['CTAX'];
            $tmp['UDW'] = $row['UDW'];
            $tmp['CFC'] = $row['CFC'];
            $tmp['CFClife'] = $row['CFClife'];
            $tmp['HS'] = $row['HS'];
            $tmp['CRI'] = $row['CRI'];
            array_push($retval, $tmp);
        }
    }

    return ($retval);

}


/*

                                                                    dddddddd
        CCCCCCCCCCCCC                                               d::::::d               ///////   CCCCCCCCCCCCC                                 tttt
     CCC::::::::::::C                                               d::::::d              /:::::/ CCC::::::::::::C                              ttt:::t
   CC:::::::::::::::C                                               d::::::d             /:::::/CC:::::::::::::::C                              t:::::t
  C:::::CCCCCCCC::::C                                               d:::::d             /:::::/C:::::CCCCCCCC::::C                              t:::::t
 C:::::C       CCCCCC  aaaaaaaaaaaaa  nnnn  nnnnnnnn        ddddddddd:::::d            /:::::/C:::::C       CCCCCC   mmmmmmm    mmmmmmm   ttttttt:::::ttttttt        eeeeeeeeeeee
C:::::C                a::::::::::::a n:::nn::::::::nn    dd::::::::::::::d           /:::::/C:::::C               mm:::::::m  m:::::::mm t:::::::::::::::::t      ee::::::::::::ee
C:::::C                aaaaaaaaa:::::an::::::::::::::nn  d::::::::::::::::d          /:::::/ C:::::C              m::::::::::mm::::::::::mt:::::::::::::::::t     e::::::eeeee:::::ee
C:::::C                         a::::ann:::::::::::::::nd:::::::ddddd:::::d         /:::::/  C:::::C              m::::::::::::::::::::::mtttttt:::::::tttttt    e::::::e     e:::::e
C:::::C                  aaaaaaa:::::a  n:::::nnnn:::::nd::::::d    d:::::d        /:::::/   C:::::C              m:::::mmm::::::mmm:::::m      t:::::t          e:::::::eeeee::::::e
C:::::C                aa::::::::::::a  n::::n    n::::nd:::::d     d:::::d       /:::::/    C:::::C              m::::m   m::::m   m::::m      t:::::t          e:::::::::::::::::e
C:::::C               a::::aaaa::::::a  n::::n    n::::nd:::::d     d:::::d      /:::::/     C:::::C              m::::m   m::::m   m::::m      t:::::t          e::::::eeeeeeeeeee
 C:::::C       CCCCCCa::::a    a:::::a  n::::n    n::::nd:::::d     d:::::d     /:::::/       C:::::C       CCCCCCm::::m   m::::m   m::::m      t:::::t    tttttte:::::::e
  C:::::CCCCCCCC::::Ca::::a    a:::::a  n::::n    n::::nd::::::ddddd::::::dd   /:::::/         C:::::CCCCCCCC::::Cm::::m   m::::m   m::::m      t::::::tttt:::::te::::::::e
   CC:::::::::::::::Ca:::::aaaa::::::a  n::::n    n::::n d:::::::::::::::::d  /:::::/           CC:::::::::::::::Cm::::m   m::::m   m::::m      tt::::::::::::::t e::::::::eeeeeeee
     CCC::::::::::::C a::::::::::aa:::a n::::n    n::::n  d:::::::::ddd::::d /:::::/              CCC::::::::::::Cm::::m   m::::m   m::::m        tt:::::::::::tt  ee:::::::::::::e
        CCCCCCCCCCCCC  aaaaaaaaaa  aaaa nnnnnn    nnnnnn   ddddddddd   ddddd///////                  CCCCCCCCCCCCCmmmmmm   mmmmmm   mmmmmm          ttttttttttt      eeeeeeeeeeeeee

*/

/*
function getcandidates($fourcode)
Retrieves all candidates in the committee database by fourcode (CD01, SD25, AD15, etc) as an associative array, returns array of results
$x['CAND_ID'] = FPPC ID or FEC Candidate ID (H6CA12345, etc)
$x['COMM_ID'] = FPPC ID or FEC Committee ID (C00500000, etc)
$x['NAMF'] = Candidate's First Name
$x['NAML'] = Candidate's Last Name
$x['FULLNAME'] = Candidate's Full Name (merged first and last)
$x['RCANDIDATE_ID'] = Master rcandidate_id key
$x['PRIMARY_DT'] = Defaults to 2016-06-07 if nothing specified
*/

function getcandidates($fourcode)
{
    global $conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $tmp = Array();
    $sql = "SELECT * FROM calaccess_raw_cand_comm WHERE fourcode = '" . $fourcode . "' ORDER BY NAML";
    $result = $conn->query($sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount) {
        while ($row = $result->fetch_assoc()) {
            if ($row['CAND_ID']) {
                $tmp['CAND_ID'] = $row['CAND_ID'];
            } else {
                array_push($cand_id, "NOT AVAILABLE");
                $tmp['CAND_ID'] = "NOT AVAILABLE";
            }

            if ($row['COMM_ID']) {
                $tmp['COMM_ID'] = $row['COMM_ID'];
            } else {
                $tmp['COMM_ID'] = "NOT AVAILABLE";
            }

            if ($row['PRIMARY_DT']) {
                $tmp['PRIMARY_DT'] = $row['PRIMARY_DT'];
            } else {
                $tmp['PRIMARY_DT'] = "2016-06-07";
            }

            $tmp['NAMF'] = $row['NAMF'];
            $tmp['NAML'] = $row['NAML'];
            $tmp['FULLNAME'] = $tmp['NAMF'] . " " . $tmp['NAML'];
            $tmp['RCANDIDATE_ID'] = $row['rcandidate_id'];
            array_push($retval, $tmp);
        }

        return $retval;
    }
}

/*

function drawheadshot($id)
Returns the HTML for a Headshot of the candidate, complete with photo, social media links, biography, term limits, etc, based on the candidates rcandidate_id

*/


function drawheadshot($id)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT rcandidates.rcandidate_id, rcandidates.firstname, rcandidates.middlename, rcandidates.lastname, rcandidates.party, rcandidates.is_incumbent, rcandidates.img_name, rcandidates.rdist_id, rcandidates.status, rbios.longbio, rbios.shortbio FROM ctb2016_rcandidates, rbios WHERE rcandidates.rcandidate_id = rbios.rcandidate_id && rcandidates.rcandidate_id = '$id' ORDER BY lastname, firstname ASC";
    $result = $conn->query($sql);
    $class = '';
    $i = 1;
    $retval = "<section class='container padme2 jumbotron listall'><div class='cList' align='center'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {

                $linkarray = Array();
                $ltarray = Array();
                $linksall = '';


                $fourcode = $row['rdist_id'];
                if (strlen($fourcode) != 4) {
                    $fourcode = '';
                }

                $ctblink = getctblink($fourcode, $conn);

                $rcandidate_id = $row['rcandidate_id'];

                foreach ($ctblink as $value) {
                    $nuctblink = $value;
                }

                $status = $row['status'];
                $longbio = $row['longbio'];

                $imgsrc = 'img/' . $row['img_name'];

                $party = $row['party'];
                $name = $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename'];
                if (strlen($name) > 20) {
                    $nameclass = "smalltext";
                } else {
                    $nameclass = '';
                }

                $imglink = ''; //TODO:  ADD IMAGE LINK


                if ($party == "REP") {
                    $class = 'rep';
                    $displayparty = '(R';
                } elseif ($party == "DEM") {
                    $class = 'dem';
                    $displayparty = '(D';
                } else {
                    $class = 'oth';
                    $displayparty = '(' . $party;
                }

                if ($row['is_incumbent']) {
                    $partysuffix = '-Inc)';
                } else {
                    $partysuffix = ')';
                }

                $sql2 = "SELECT rlinks.link, rlinks.type from ctb2016_rlinks WHERE rlinks.rcandidate_id =" . $rcandidate_id;

                $result2 = $conn->query($sql2);

                $j = 1;

                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        if ($j <> 0) {
                            array_push($linkarray, $row['link']);
                            array_push($ltarray, $row['type']);
                        }
                        $j++;
                    }
                }

                $k = 0;
                foreach ($ltarray as $value) {
                    $link = '<a href="' . $linkarray[$k] . '" target="_blank" title="' . $value . '">';

                    switch ($value) {
                        case "FACEBOOK":
                            $icon = '<img src="img/icons/fb.png" class="socialIcon"></a>';
                            break;
                        case "TWITTER":
                            $icon = '<img src="img/icons/tw.png" class="socialIcon"></a>';
                            break;
                        case "LINKEDIN":
                            $icon = '<img src="img/icons/li.png" class="socialIcon"></a>';
                            break;
                        case "YOUTUBE":
                            $icon = '<img src="img/icons/yt.png" class="socialIcon"></a>';
                            break;
                        case "GOVT":
                            $icon = '<img src="img/icons/gov.png" class="socialIcon"></a>';
                            break;
                        case "PERSONAL":
                            $icon = '<img src="img/icons/pers.png" class="socialIcon"></a>';
                            break;
                        case "CAMPAIGN":
                            $icon = '<img src="img/icons/pers.png" class="socialIcon"></a>';
                            break;
                        case "BUSINESS":
                            $icon = '<img src="img/icons/gov.png" class="socialIcon"></a>';
                            break;
                        case "FILING":
                            $icon = '<img src="img/icons/gov.png" class="socialIcon"></a>';
                            break;
                    }

                    $linkrow = $link . $icon;

                    $linksall .= $linkrow;

                    $k++;
                }


                $entry = '
	<div class="candidate2 ' . $class . '">
		' . $nuctblink . $imglink . '<img src="' . $imgsrc . '" class="headshot"></a>
		<div class="social">' . $linksall . '</div>
		<div class="name ' . $nameclass . '" title="' . $longbio . '">' . $name . '</div>
		<div class="party">' . $displayparty . $partysuffix . '</div>
		<div class="district">' . $fourcode . '</div>
		<div class="status">' . $status . '</div>
	</div>';

                $retval .= $entry;
            }
            $i++;
        }
    } else {
        echo "0 results";
    }


    return $retval;
}

/*

EEEEEEEEEEEEEEEEEEEEEElllllll                                                  tttt            iiii
E::::::::::::::::::::El:::::l                                               ttt:::t           i::::i
E::::::::::::::::::::El:::::l                                               t:::::t            iiii
EE::::::EEEEEEEEE::::El:::::l                                               t:::::t
  E:::::E       EEEEEE l::::l     eeeeeeeeeeee        ccccccccccccccccttttttt:::::ttttttt    iiiiiii    ooooooooooo   nnnn  nnnnnnnn        ssssssssss
  E:::::E              l::::l   ee::::::::::::ee    cc:::::::::::::::ct:::::::::::::::::t    i:::::i  oo:::::::::::oo n:::nn::::::::nn    ss::::::::::s
  E::::::EEEEEEEEEE    l::::l  e::::::eeeee:::::ee c:::::::::::::::::ct:::::::::::::::::t     i::::i o:::::::::::::::on::::::::::::::nn ss:::::::::::::s
  E:::::::::::::::E    l::::l e::::::e     e:::::ec:::::::cccccc:::::ctttttt:::::::tttttt     i::::i o:::::ooooo:::::onn:::::::::::::::ns::::::ssss:::::s
  E:::::::::::::::E    l::::l e:::::::eeeee::::::ec::::::c     ccccccc      t:::::t           i::::i o::::o     o::::o  n:::::nnnn:::::n s:::::s  ssssss
  E::::::EEEEEEEEEE    l::::l e:::::::::::::::::e c:::::c                   t:::::t           i::::i o::::o     o::::o  n::::n    n::::n   s::::::s
  E:::::E              l::::l e::::::eeeeeeeeeee  c:::::c                   t:::::t           i::::i o::::o     o::::o  n::::n    n::::n      s::::::s
  E:::::E       EEEEEE l::::l e:::::::e           c::::::c     ccccccc      t:::::t    tttttt i::::i o::::o     o::::o  n::::n    n::::nssssss   s:::::s
EE::::::EEEEEEEE:::::El::::::le::::::::e          c:::::::cccccc:::::c      t::::::tttt:::::ti::::::io:::::ooooo:::::o  n::::n    n::::ns:::::ssss::::::s
E::::::::::::::::::::El::::::l e::::::::eeeeeeee   c:::::::::::::::::c      tt::::::::::::::ti::::::io:::::::::::::::o  n::::n    n::::ns::::::::::::::s
E::::::::::::::::::::El::::::l  ee:::::::::::::e    cc:::::::::::::::c        tt:::::::::::tti::::::i oo:::::::::::oo   n::::n    n::::n s:::::::::::ss
EEEEEEEEEEEEEEEEEEEEEEllllllll    eeeeeeeeeeeeee      cccccccccccccccc          ttttttttttt  iiiiiiii   ooooooooooo     nnnnnn    nnnnnn  sssssssssss

*/

//ROUTING FUNCTION


function getallreturns($fourcode, $report)
{

    global $ctb2016_conn;

    switch ($report) {
        case "veth":
            draweth($fourcode);
            break;
        case "vparty":
            drawage($fourcode);
            break;
        case "vdetail":
            drawallelectionresults($fourcode);
            break;
        default:
            drawallelectionresults($fourcode);
    }

    echo("</div>");

}

/*

               AAA                  GGGGGGGGGGGGGEEEEEEEEEEEEEEEEEEEEEE               ///////PPPPPPPPPPPPPPPPP        AAA               RRRRRRRRRRRRRRRRR   TTTTTTTTTTTTTTTTTTTTTTTYYYYYYY       YYYYYYY
              A:::A              GGG::::::::::::GE::::::::::::::::::::E              /:::::/ P::::::::::::::::P      A:::A              R::::::::::::::::R  T:::::::::::::::::::::TY:::::Y       Y:::::Y
             A:::::A           GG:::::::::::::::GE::::::::::::::::::::E             /:::::/  P::::::PPPPPP:::::P    A:::::A             R::::::RRRRRR:::::R T:::::::::::::::::::::TY:::::Y       Y:::::Y
            A:::::::A         G:::::GGGGGGGG::::GEE::::::EEEEEEEEE::::E            /:::::/   PP:::::P     P:::::P  A:::::::A            RR:::::R     R:::::RT:::::TT:::::::TT:::::TY::::::Y     Y::::::Y
           A:::::::::A       G:::::G       GGGGGG  E:::::E       EEEEEE           /:::::/      P::::P     P:::::P A:::::::::A             R::::R     R:::::RTTTTTT  T:::::T  TTTTTTYYY:::::Y   Y:::::YYY
          A:::::A:::::A     G:::::G                E:::::E                       /:::::/       P::::P     P:::::PA:::::A:::::A            R::::R     R:::::R        T:::::T           Y:::::Y Y:::::Y
         A:::::A A:::::A    G:::::G                E::::::EEEEEEEEEE            /:::::/        P::::PPPPPP:::::PA:::::A A:::::A           R::::RRRRRR:::::R         T:::::T            Y:::::Y:::::Y
        A:::::A   A:::::A   G:::::G    GGGGGGGGGG  E:::::::::::::::E           /:::::/         P:::::::::::::PPA:::::A   A:::::A          R:::::::::::::RR          T:::::T             Y:::::::::Y
       A:::::A     A:::::A  G:::::G    G::::::::G  E:::::::::::::::E          /:::::/          P::::PPPPPPPPP A:::::A     A:::::A         R::::RRRRRR:::::R         T:::::T              Y:::::::Y
      A:::::AAAAAAAAA:::::A G:::::G    GGGGG::::G  E::::::EEEEEEEEEE         /:::::/           P::::P        A:::::AAAAAAAAA:::::A        R::::R     R:::::R        T:::::T               Y:::::Y
     A:::::::::::::::::::::AG:::::G        G::::G  E:::::E                  /:::::/            P::::P       A:::::::::::::::::::::A       R::::R     R:::::R        T:::::T               Y:::::Y
    A:::::AAAAAAAAAAAAA:::::AG:::::G       G::::G  E:::::E       EEEEEE    /:::::/             P::::P      A:::::AAAAAAAAAAAAA:::::A      R::::R     R:::::R        T:::::T               Y:::::Y
   A:::::A             A:::::AG:::::GGGGGGGG::::GEE::::::EEEEEEEE:::::E   /:::::/            PP::::::PP   A:::::A             A:::::A   RR:::::R     R:::::R      TT:::::::TT             Y:::::Y
  A:::::A               A:::::AGG:::::::::::::::GE::::::::::::::::::::E  /:::::/             P::::::::P  A:::::A               A:::::A  R::::::R     R:::::R      T:::::::::T          YYYY:::::YYYY
 A:::::A                 A:::::A GGG::::::GGG:::GE::::::::::::::::::::E /:::::/              P::::::::P A:::::A                 A:::::A R::::::R     R:::::R      T:::::::::T          Y:::::::::::Y
AAAAAAA                   AAAAAAA   GGGGGG   GGGGEEEEEEEEEEEEEEEEEEEEEE///////               PPPPPPPPPPAAAAAAA                   AAAAAAARRRRRRRR     RRRRRRR      TTTTTTTTTTT          YYYYYYYYYYYYY

*/

function getpartytotals($fourcode, $election)
{
    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];
    $retval = Array();

    global $ctb2016_conn;
    $conn = $ctb2016_conn;

    if ($fourcode != ".STW") {
        $where = " WHERE $disttype = $distno";
    }

    $parties = Array("DEM", "REP", "DCL", "OTH");
    $ages = Array("UNK", "1824", "2534", "3544", "4554", "5564", "65PL");
    $sexes = Array("M", "F");

    foreach ($parties as $party) {
        foreach ($ages as $age) {
            $totalagev = 0;
            $totalager = 0;
            foreach ($sexes as $sex) {
                $header = $party . $sex . $age;
                $sql = "SELECT SUM($header) AS VOTED, SUM(r" . $header . ") AS REGISTERED FROM $election $where";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $retval[$header] = $row['VOTED'];
                        $retval["r$header"] = $row['REGISTERED'];
                        $totalagev += $row['VOTED'];
                        $totalager += $row['REGISTERED'];
                    }
                }
            }
            $temphead = $party . "T" . $age;
            $retval["r$temphead"] = $totalager;
            $retval[$temphead] = $totalagev;

        }
    }

    return $retval;
}

function getethnictotals($fourcode, $election)
{
    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];
    $retval = Array();

    global $ctb2016_conn;
    $conn = $ctb2016_conn;

    if ($fourcode != ".STW") {
        $where = " WHERE $disttype = $distno";
    }

    $parties = Array("DEM", "REP", "DCL", "OTH");
    $ethnicities = Array("HISP", "JEW", "KOR", "JPN", "CHI", "IND", "VIET", "FIL");

    foreach ($ethnicities as $ethnicity) {
        $totalethr = 0;
        $totalethv = 0;
        foreach ($parties as $party) {
            $header = $ethnicity . $party;
            $sql = "SELECT SUM($header) AS VOTED, SUM(r" . $header . ") AS REGISTERED FROM $election $where";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval[$header] = $row['VOTED'];
                    $retval["r$header"] = $row['REGISTERED'];
                    $totalethr += $row['REGISTERED'];
                    $totalethv += $row['VOTED'];
                    if ($ethnicity != "HISP" && $ethnicity != "JEW") {
                        $retval["ASN$party"] += $row['VOTED'];
                        $retval["rASN$party"] += $row['REGISTERED'];
                        $retval["rASNTOTREG"] += $row['REGISTERED'];

                    }
                }
            }
        }
        $temphead = $ethnicity . "TOT";
        $retval["r$temphead"] = $totalethr;
        $retval[$temphead] = $totalethv;

    }

    //var_dump($retval);
    return $retval;
}

function getregtotals($fourcode, $election)
{

    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];
    $retval = Array();

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    if ($fourcode != ".STW") {
        $where = " WHERE $disttype = $distno";
    }

    $sql = "SELECT SUM(rDEM) AS DEM, SUM(rREP) AS REP, SUM(rDCL) as NPP, SUM(rTOTREG_R) AS TOTAL FROM ctb2016_$election $where";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['REP'] = $row['REP'];
            $retval['DEM'] = $row['DEM'];
            $retval['NPP'] = $row['NPP'];
            $retval['TOT'] = $row['TOTAL'];
        }
    }

    return $retval;

}

function drawage($fourcode)
{

    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $dist = $x['distno'];
    $qdist = $disttype;
    $printdist = $disttype . $dist;
    $fourcode = makefour($qdist, $dist);

    if ($qdist == "county" && $dist < 999) {
        $printdist = getcountyname($dist) . " County";
    } elseif ($dist == 999) {
        $printdist = "Statewide Totals";
    } else {
        //do nothing
    }

    $divhead2 = Array("DEMOCRATIC PARTY", "REPUBLICAN PARTY", "NO PARTY PREFERENCE", "ALL OTHER PARTIES");
    $parties = Array("DEM", "REP", "DCL", "OTH");
    $elections = Array("p16", "g14", "p14", "g12", "p12");


    foreach ($elections as $value) {
        $qelec = $value;

        switch ($qelec) {
            case "p16":
                $printelec = "2016 Primary Election";
                break;
            case "g14":
                $printelec = "2014 General Election";
                break;
            case "p14":
                $printelec = "2014 Primary Election";
                break;
            case "g12":
                $printelec = "2012 General Election";
                break;
            case "p12":
                $printelec = "2012 Primary Election";
                break;
        }


        echo("<div class = 'electhead'><h1>" . $printdist . " - " . $printelec . "</h1></div>");


        $i = 0;

        foreach ($parties as $value) {

            //$x = plansexparty("AD40", "p12", "AGE", "1824", $conn);
            $x = plansexparty($fourcode, $qelec, "PARTY", $value);
            $results = getpartyresults($fourcode, $qelec, $x);
            $results[52] = $divhead2[$i];

            drawpartydiv($results);

            $i++;

        }
    }

}


function plansexparty($fourcode, $elec, $option, $main, $conn)
{       // Example input plansexparty("AD40", "p12", "AGE", $conn) -- USE "AGE" OR "PARTY" as the main head

    $agegrphead = Array("1824", "2534", "3544", "4554", "5564", "65PL");
    $partyhead = Array("DEM", "REP", "DCL", "OTH");
    $genderhead = Array("M", "F");
    $rprefix = "r";

    $mainhead = Array();
    $subhead = Array();

    $resultsall = Array();

    switch ($option) {                                        //CHECK FOR AGE OR PARTY OPTION
        case "AGE":                                            //BUILD HEADERS USING AGE AS MAIN CLASS, PARTY AS SUBCLASS
            $agegrp = $main;
            foreach ($partyhead as $party) {                //Then cycle through party preference
                foreach ($genderhead as $gender) {            //Then Retrieve Male & Female
                    $pushme = $party . $gender . $agegrp;   //build header columns
                    $rpushme = $rprefix . $pushme;
                    array_push($resultsall, $pushme);
                    array_push($resultsall, $rpushme);
                }
            }
            break;                                            //END AGE

        case "PARTY":                                        //BUILD HEADERS USING PARTY AS MAIN CLASS, AGE AS SUBCLASS
            $party = $main;
            foreach ($agegrphead as $agegrp) {                //Then cycle through party preference
                foreach ($genderhead as $gender) {            //Then Retrieve Male & Female
                    $pushme = $party . $gender . $agegrp;    //build header column
                    $rpushme = $rprefix . $pushme;
                    array_push($resultsall, $pushme);
                    array_push($resultsall, $rpushme);

                }
            }
            break;                                            //END PARTY
    }

    return $resultsall;
}


function getpartyresults($fourcode, $elec, $headerarray)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $x = "";
    $qdist = tophalf($fourcode);
    $dist = bothalf($fourcode);
    $qelec = $elec;
    $distsql = " WHERE " . $qdist . " = " . $dist;
    $arrayfinal = Array();

    foreach ($headerarray as $value) {
        $x .= "SUM(" . $value . ") AS " . $value . ",";
    }

    $x = trim($x, ",");

    //GET DISTRICT TOTALS INTO RESULTS 0 - 23;

    if ($elec != "q16") {
        $sql = "SELECT " . $x . " FROM ctb2016_" . $qelec . $distsql;
    } else {
        $sql = "SELECT " . $x . " FROM ctb2016_p16vote " . $distsql;
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($headerarray as $value) {
                $retval = $row["$value"];
                array_push($arrayfinal, $retval);
            }
        }
    } else {
        $retval = "error";
        array_push($arrayfinal, $retval);
    }

    if ($elec != "q16") {
        $sql = "SELECT " . $x . " FROM ctb2016_" . $qelec;
    } else {
        $sql = "SELECT " . $x . " FROM ctb2016_p16vote";
    }

    //GET STATEWIDE TOTALS INTO RESULTS 24-47

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            foreach ($headerarray as $value) {
                $retval = $row["$value"];
                array_push($arrayfinal, $retval);
            }
        }
    } else {
        $retval = "error";
        array_push($arrayfinal, $retval);
    }

    //GET DISTRICT TOTAL REGISTERED / VOTING ELECTORATE

    $sql = "SELECT SUM(TOTREG_R) AS VOTES, SUM(rTOTREG_R) AS REGISTERED FROM ctb2016_" . $qelec . $distsql;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($arrayfinal, $row["VOTES"]);
            array_push($arrayfinal, $row["REGISTERED"]);
        }
    } else {
        $retval = "error";
        array_push($arrayfinal, $retval);
    }

    //GET STATEWIDE TOTAL REGISTERED / VOTING ELECTORATE

    $sql = "SELECT SUM(TOTREG_R) AS VOTES, SUM(rTOTREG_R) AS REGISTERED FROM ctb2016_" . $qelec;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($arrayfinal, $row["VOTES"]);
            array_push($arrayfinal, $row["REGISTERED"]);
        }
    } else {
        $retval = "error";
        array_push($arrayfinal, $retval);
    }


    return $arrayfinal;
}

function drawpartydiv($x)
{

    //TABLE STRUCTURE: PARTY IN  MAIN HEADER, 16 COLUMNS FOR 1 WIDE COLUMN 1 DESCRIPTOR, 6 AGE GROUPS x 2 GENDERS, PLUS MALE TOTAL, FEMALE TOTAL, AND GRAND TOTAL COLUMNS
    /*
					DEM
								18-24		25-34		35-44		45-54		55-64		65+		TOTAL		TOTAL
								M	F		M	F		M	F		M	F		M	F		M	F	M	F
REGISTERED						12341234	12431234	12341234	12341234	12341234	1234123474137404	14817
REGISTERED ELECTORATE %			%	%		%	%		%	%		%	%		%	%		%	%	%	%		%
VOTING							12341234	12341234	12341234	12341234	12341234	1234123474047404	14808
VOTING ELECTORATE 				%	%		%	%		%	%		%	%		%	%		%	%	%	%	%	%
DISTRICT TURNOUT (BOTH GENDERS)	%			%			%			%			%			%		----	----	%
								%	%	%	%	%	%	%	%	%	%	%	%	%	%	----
STATE REGISTERED (BOTH GENDERS)	1234	1234	1234	1234	1234	1234	1234	1234	1234	1234	1234	1234	7404	7404	14808
								%	%	%	%	%	%	%	%	%	%	%	%
STATE VOTING (BOTH GENDERS)		1234	1234	1234	1234	1234	1342	1234	1344	1234	1342	1234	1342	7404	7838	15242
								%	%	%	%	%	%	%	%	%	%	%	%	%	%	%
STATE TURNOUT (BOTH GENDERS)	%		%		%		%		%		%		----	----	%
								%	%	%	%	%	%	%	%	%	%	%	%	%	%	----
*/

    $v1824m = $x[0];
    $r1824m = $x[1];
    $v1824f = $x[2];
    $r1824f = $x[3];

    $v2534m = $x[4];
    $r2534m = $x[5];
    $v2534f = $x[6];
    $r2534f = $x[7];

    $v3544m = $x[8];
    $r3544m = $x[9];
    $v3544f = $x[10];
    $r3544f = $x[11];

    $v4554m = $x[12];
    $r4554m = $x[13];
    $v4554f = $x[14];
    $r4554f = $x[15];

    $v5564m = $x[16];
    $r5564m = $x[17];
    $v5564f = $x[18];
    $r5564f = $x[19];

    $v65PLm = $x[20];
    $r65PLm = $x[21];
    $v65PLf = $x[22];
    $r65PLf = $x[23];


    $rdistmale = $r1824m + $r2534m + $r3544m + $r4554m + $r5564m + $r65PLm;
    $rdistfemale = $r1824f + $r2534f + $r3544f + $r4554f + $r5564f + $r65PLf;
    $rdisttotal = $rdistmale + $rdistfemale;
    $vdistmale = $v1824m + $v2534m + $v3544m + $v4554m + $v5564m + $v65PLm;
    $vdistfemale = $v1824f + $v2534f + $v3544f + $v4554f + $v5564f + $v65PLf;
    $vdisttotal = $vdistmale + $vdistfemale;

    $disttotalvot = $x[48];
    $disttotalreg = $x[49];

    $sttotalvot = $x[50];
    $sttotalreg = $x[51];


    $stv1824m = $x[24];
    $str1824m = $x[25];
    $stv1824f = $x[26];
    $str1824f = $x[27];

    $stv2534m = $x[28];
    $str2534m = $x[29];
    $stv2534f = $x[30];
    $str2534f = $x[31];

    $stv3544m = $x[32];
    $str3544m = $x[33];
    $stv3544f = $x[34];
    $str3544f = $x[35];

    $stv4554m = $x[36];
    $str4554m = $x[37];
    $stv4554f = $x[38];
    $str4554f = $x[39];

    $stv5564m = $x[40];
    $str5564m = $x[41];
    $stv5564f = $x[42];
    $str5564f = $x[43];

    $stv65PLm = $x[44];
    $str65PLm = $x[45];
    $stv65PLf = $x[46];
    $str65PLf = $x[47];

    $strdistmale = $str1824m + $str2534m + $str3544m + $str4554m + $str5564m + $str65PLm;
    $strdistfemale = $str1824f + $str2534f + $str3544f + $str4554f + $str5564f + $str65PLf;
    $strdisttotal = $strdistmale + $strdistfemale;
    $stvdistmale = $stv1824m + $stv2534m + $stv3544m + $stv4554m + $stv5564m + $stv65PLm;
    $stvdistfemale = $stv1824f + $stv2534f + $stv3544f + $stv4554f + $stv5564f + $stv65PLf;
    $stvdisttotal = $stvdistmale + $stvdistfemale;

    $empty = '&nbsp';
    $divhead = $x[52];


    $somehtml = '

	<div class = "rescon thickborder">

		<div class = "divhead"><h2>' . $divhead . '</h2></div>

		<div class = "tr subhead age noborder">

			<div class = "td tdcol1">&nbsp</div>
			<div class = "td age">18-24</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">25-34</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">35-44</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">45-54</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">55-64</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">65+</div>
			<div class = "td age percent">&nbsp</div>
			<div class = "td age">TOTAL</div>
			<div class = "td empty">&nbsp</div>
			<div class = "td age">TOTAL</div>

		</div>

		<div class = "tr subhead gender noborder">

			<div class = "td tdcol1">&nbsp</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td gender male">M</div>
			<div class = "td gender female">F</div>
			<div class = "td empty">&nbsp</div>

		</div>

		<hr></hr>

		<div class = "tr districtstart">

			<div class = "td tdcol1">TOTAL REGISTERED</div>
			<div class = "td gender male">' . $r1824m . '</div>
			<div class = "td gender female">' . $r1824f . '</div>
			<div class = "td gender male">' . $r2534m . '</div>
			<div class = "td gender female">' . $r2534f . '</div>
			<div class = "td gender male">' . $r3544m . '</div>
			<div class = "td gender female">' . $r3544f . '</div>
			<div class = "td gender male">' . $r4554m . '</div>
			<div class = "td gender female">' . $r4554f . '</div>
			<div class = "td gender male">' . $r5564m . '</div>
			<div class = "td gender female">' . $r5564f . '</div>
			<div class = "td gender male">' . $r65PLm . '</div>
			<div class = "td gender female">' . $r65PLf . '</div>
			<div class = "td gender male">' . $rdistmale . '</div>
			<div class = "td gender female">' . $rdistfemale . '</div>
			<div class = "td ">' . $rdisttotal . '</div>

		</div>

		<div class = "tr">

			<div class = "td tdcol1">% OF DISTRICT</div>
			<div class = "td gender male">' . calcpct($r1824m, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r1824f, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($r2534m, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r2534f, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($r3544m, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r3544f, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($r4554m, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r4554f, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($r5564m, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r5564f, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($r65PLm, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($r65PLf, $disttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($rdistmale, $disttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($rdistfemale, $disttotalreg) . '</div>
			<div class = "td ">' . calcpct($rdisttotal, $disttotalreg) . '</div>

		</div>

		<hr></hr>

		<div class = "tr">

			<div class = "td tdcol1">TOTAL VOTING</div>
			<div class = "td gender male">' . $v1824m . '</div>
			<div class = "td gender female">' . $v1824f . '</div>
			<div class = "td gender male">' . $v2534m . '</div>
			<div class = "td gender female">' . $v2534f . '</div>
			<div class = "td gender male">' . $v3544m . '</div>
			<div class = "td gender female">' . $v3544f . '</div>
			<div class = "td gender male">' . $v4554m . '</div>
			<div class = "td gender female">' . $v4554f . '</div>
			<div class = "td gender male">' . $v5564m . '</div>
			<div class = "td gender female">' . $v5564f . '</div>
			<div class = "td gender male">' . $v65PLm . '</div>
			<div class = "td gender female">' . $v65PLf . '</div>
			<div class = "td gender male">' . $vdistmale . '</div>
			<div class = "td gender female">' . $vdistfemale . '</div>
			<div class = "td ">' . $vdisttotal . '</div>

		</div>

		<div class = "tr">

			<div class = "td tdcol1">% OF DISTRICT</div>
			<div class = "td gender male">' . calcpct($v1824m, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v1824f, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($v2534m, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v2534f, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($v3544m, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v3544f, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($v4554m, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v4554f, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($v5564m, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v5564f, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($v65PLm, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($v65PLf, $disttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($vdistmale, $disttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($vdistfemale, $disttotalvot) . '</div>
			<div class = "td ">' . calcpct($vdisttotal, $disttotalvot) . '</div>

		</div>


		<hr></hr>

		<div class = "tr">

			<div class = "td tdcol1">TURNOUT %</div>
			<div class = "td gender male">' . calcpct($v1824m, $r1824m) . '</div>
			<div class = "td gender female">' . calcpct($v1824f, $r1824f) . '</div>
			<div class = "td gender male">' . calcpct($v2534m, $r2534m) . '</div>
			<div class = "td gender female">' . calcpct($v2534f, $r2534f) . '</div>
			<div class = "td gender male">' . calcpct($v3544m, $r3544m) . '</div>
			<div class = "td gender female">' . calcpct($v3544f, $r3544f) . '</div>
			<div class = "td gender male">' . calcpct($v4554m, $r4554m) . '</div>
			<div class = "td gender female">' . calcpct($v4554f, $r4554f) . '</div>
			<div class = "td gender male">' . calcpct($v5564m, $r5564m) . '</div>
			<div class = "td gender female">' . calcpct($v5564f, $r5564f) . '</div>
			<div class = "td gender male">' . calcpct($v65PLm, $r65PLm) . '</div>
			<div class = "td gender female">' . calcpct($v65PLf, $r65PLf) . '</div>
			<div class = "td gender male">' . calcpct($vdistmale, $rdistmale) . '</div>
			<div class = "td gender female">' . calcpct($vdistfemale, $rdistfemale) . '</div>
			<div class = "td ">' . calcpct($vdisttotal, $rdisttotal) . '</div>

		</div>

		<div class = "tr">

			<div class = "td tdcol1">TURNOUT % (TOT BOTH M & F)</div>
			<div class = "td gender male">' . calcpct($v1824m + $v1824f, $r1824m + $r1824f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($v2534m + $v2534f, $r2534m + $r2534f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($v3544m + $v3544f, $r3544m + $r3544f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($v4554m + $v4554f, $r4554m + $r4554f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($v5564m + $v5564f, $r5564m + $r5564f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($v65PLm + $v65PLf, $r65PLm + $r65PLf) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . $empty . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td ">' . calcpct($vdisttotal, $rdisttotal) . '</div>

		</div>

		<hr></hr>


		<div class = "tr statewidestart">

			<div class = "td tdcol1 boldme">STATEWIDE REGISTERED</div>
			<div class = "td gender male">' . $str1824m . '</div>
			<div class = "td gender female">' . $str1824f . '</div>
			<div class = "td gender male">' . $str2534m . '</div>
			<div class = "td gender female">' . $str2534f . '</div>
			<div class = "td gender male">' . $str3544m . '</div>
			<div class = "td gender female">' . $str3544f . '</div>
			<div class = "td gender male">' . $str4554m . '</div>
			<div class = "td gender female">' . $str4554f . '</div>
			<div class = "td gender male">' . $str5564m . '</div>
			<div class = "td gender female">' . $str5564f . '</div>
			<div class = "td gender male">' . $str65PLm . '</div>
			<div class = "td gender female">' . $str65PLf . '</div>
			<div class = "td gender male">' . $strdistmale . '</div>
			<div class = "td gender female">' . $strdistfemale . '</div>
			<div class = "td ">' . $strdisttotal . '</div>

		</div>

		<div class = "tr">

			<div class = "td tdcol1">TOTAL STATEWIDE %</div>
			<div class = "td gender male">' . calcpct($str1824m, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str1824f, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($str2534m, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str2534f, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($str3544m, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str3544f, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($str4554m, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str4554f, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($str5564m, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str5564f, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($str65PLm, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($str65PLf, $sttotalreg) . '</div>
			<div class = "td gender male">' . calcpct($strdistmale, $sttotalreg) . '</div>
			<div class = "td gender female">' . calcpct($strdistfemale, $sttotalreg) . '</div>
			<div class = "td ">' . calcpct($strdisttotal, $sttotalreg) . '</div>

		</div>

		<hr></hr>

		<div class = "tr">

			<div class = "td tdcol1 boldme">STATEWIDE VOTING</div>
			<div class = "td gender male">' . $stv1824m . '</div>
			<div class = "td gender female">' . $stv1824f . '</div>
			<div class = "td gender male">' . $stv2534m . '</div>
			<div class = "td gender female">' . $stv2534f . '</div>
			<div class = "td gender male">' . $stv3544m . '</div>
			<div class = "td gender female">' . $stv3544f . '</div>
			<div class = "td gender male">' . $stv4554m . '</div>
			<div class = "td gender female">' . $stv4554f . '</div>
			<div class = "td gender male">' . $stv5564m . '</div>
			<div class = "td gender female">' . $stv5564f . '</div>
			<div class = "td gender male">' . $stv65PLm . '</div>
			<div class = "td gender female">' . $stv65PLf . '</div>
			<div class = "td gender male">' . $stvdistmale . '</div>
			<div class = "td gender female">' . $stvdistfemale . '</div>
			<div class = "td ">' . $stvdisttotal . '</div>

		</div>

		<div class = "tr">

			<div class = "td tdcol1">TOTAL STATEWIDE %</div>
			<div class = "td gender male">' . calcpct($stv1824m, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv1824f, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stv2534m, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv2534f, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stv3544m, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv3544f, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stv4554m, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv4554f, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stv5564m, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv5564f, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stv65PLm, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stv65PLf, $sttotalvot) . '</div>
			<div class = "td gender male">' . calcpct($stvdistmale, $sttotalvot) . '</div>
			<div class = "td gender female">' . calcpct($stvdistfemale, $sttotalvot) . '</div>
			<div class = "td ">' . calcpct($stvdisttotal, $sttotalvot) . '</div>

		</div>

		<hr></hr>


		<div class = "tr">

			<div class = "td tdcol1 boldme">STATEWIDE TURNOUT %</div>
			<div class = "td gender male">' . calcpct($stv1824m, $str1824m) . '</div>
			<div class = "td gender female">' . calcpct($stv1824f, $str1824f) . '</div>
			<div class = "td gender male">' . calcpct($stv2534m, $str2534m) . '</div>
			<div class = "td gender female">' . calcpct($stv2534f, $str2534f) . '</div>
			<div class = "td gender male">' . calcpct($stv3544m, $str3544m) . '</div>
			<div class = "td gender female">' . calcpct($stv3544f, $str3544f) . '</div>
			<div class = "td gender male">' . calcpct($stv4554m, $str4554m) . '</div>
			<div class = "td gender female">' . calcpct($stv4554f, $str4554f) . '</div>
			<div class = "td gender male">' . calcpct($stv5564m, $str5564m) . '</div>
			<div class = "td gender female">' . calcpct($stv5564f, $str5564f) . '</div>
			<div class = "td gender male">' . calcpct($stv65PLm, $str65PLm) . '</div>
			<div class = "td gender female">' . calcpct($stv65PLf, $str65PLf) . '</div>
			<div class = "td gender male">' . calcpct($stvdistmale, $strdistmale) . '</div>
			<div class = "td gender female">' . calcpct($stvdistfemale, $strdistfemale) . '</div>
			<div class = "td ">' . calcpct($stvdisttotal, $strdisttotal) . '</div>

		</div>


		<div class = "tr">

			<div class = "td tdcol1">STATEWIDE TURNOUT % (M & F)</div>
			<div class = "td gender male">' . calcpct($stv1824m + $stv1824f, $str1824m + $str1824f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($stv2534m + $stv2534f, $str2534m + $str2534f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($stv3544m + $stv3544f, $str3544m + $str3544f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($stv4554m + $stv4554f, $str4554m + $str4554f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($stv5564m + $stv5564f, $str5564m + $str5564f) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . calcpct($stv65PLm + $stv65PLf, $str65PLm + $str65PLf) . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td gender male">' . $empty . '</div>
			<div class = "td gender female">' . $empty . '</div>
			<div class = "td ">' . calcpct($stvdisttotal, $strdisttotal) . '</div>

		</div>

	</div>

	';

    echo($somehtml);

}

/*
VVVVVVVV           VVVVVVVV     OOOOOOOOO     TTTTTTTTTTTTTTTTTTTTTTTEEEEEEEEEEEEEEEEEEEEEE     DDDDDDDDDDDDD      EEEEEEEEEEEEEEEEEEEEEETTTTTTTTTTTTTTTTTTTTTTT         AAA               IIIIIIIIIILLLLLLLLLLL
V::::::V           V::::::V   OO:::::::::OO   T:::::::::::::::::::::TE::::::::::::::::::::E     D::::::::::::DDD   E::::::::::::::::::::ET:::::::::::::::::::::T        A:::A              I::::::::IL:::::::::L
V::::::V           V::::::V OO:::::::::::::OO T:::::::::::::::::::::TE::::::::::::::::::::E     D:::::::::::::::DD E::::::::::::::::::::ET:::::::::::::::::::::T       A:::::A             I::::::::IL:::::::::L
V::::::V           V::::::VO:::::::OOO:::::::OT:::::TT:::::::TT:::::TEE::::::EEEEEEEEE::::E     DDD:::::DDDDD:::::DEE::::::EEEEEEEEE::::ET:::::TT:::::::TT:::::T      A:::::::A            II::::::IILL:::::::LL
 V:::::V           V:::::V O::::::O   O::::::OTTTTTT  T:::::T  TTTTTT  E:::::E       EEEEEE       D:::::D    D:::::D E:::::E       EEEEEETTTTTT  T:::::T  TTTTTT     A:::::::::A             I::::I    L:::::L
  V:::::V         V:::::V  O:::::O     O:::::O        T:::::T          E:::::E                    D:::::D     D:::::DE:::::E                     T:::::T            A:::::A:::::A            I::::I    L:::::L
   V:::::V       V:::::V   O:::::O     O:::::O        T:::::T          E::::::EEEEEEEEEE          D:::::D     D:::::DE::::::EEEEEEEEEE           T:::::T           A:::::A A:::::A           I::::I    L:::::L
    V:::::V     V:::::V    O:::::O     O:::::O        T:::::T          E:::::::::::::::E          D:::::D     D:::::DE:::::::::::::::E           T:::::T          A:::::A   A:::::A          I::::I    L:::::L
     V:::::V   V:::::V     O:::::O     O:::::O        T:::::T          E:::::::::::::::E          D:::::D     D:::::DE:::::::::::::::E           T:::::T         A:::::A     A:::::A         I::::I    L:::::L
      V:::::V V:::::V      O:::::O     O:::::O        T:::::T          E::::::EEEEEEEEEE          D:::::D     D:::::DE::::::EEEEEEEEEE           T:::::T        A:::::AAAAAAAAA:::::A        I::::I    L:::::L
       V:::::V:::::V       O:::::O     O:::::O        T:::::T          E:::::E                    D:::::D     D:::::DE:::::E                     T:::::T       A:::::::::::::::::::::A       I::::I    L:::::L
        V:::::::::V        O::::::O   O::::::O        T:::::T          E:::::E       EEEEEE       D:::::D    D:::::D E:::::E       EEEEEE        T:::::T      A:::::AAAAAAAAAAAAA:::::A      I::::I    L:::::L         LLLLLL
         V:::::::V         O:::::::OOO:::::::O      TT:::::::TT      EE::::::EEEEEEEE:::::E     DDD:::::DDDDD:::::DEE::::::EEEEEEEE:::::E      TT:::::::TT   A:::::A             A:::::A   II::::::IILL:::::::LLLLLLLLL:::::L
          V:::::V           OO:::::::::::::OO       T:::::::::T      E::::::::::::::::::::E     D:::::::::::::::DD E::::::::::::::::::::E      T:::::::::T  A:::::A               A:::::A  I::::::::IL::::::::::::::::::::::L
           V:::V              OO:::::::::OO         T:::::::::T      E::::::::::::::::::::E     D::::::::::::DDD   E::::::::::::::::::::E      T:::::::::T A:::::A                 A:::::A I::::::::IL::::::::::::::::::::::L
            VVV                 OOOOOOOOO           TTTTTTTTTTT      EEEEEEEEEEEEEEEEEEEEEE     DDDDDDDDDDDDD      EEEEEEEEEEEEEEEEEEEEEE      TTTTTTTTTTTAAAAAAA                   AAAAAAAIIIIIIIIIILLLLLLLLLLLLLLLLLLLLLLLL
            */


function drawallelectionresults($fourcode)
{
    $x = getdisttype($fourcode);
    $masterfourcode = $fourcode;
    $disttype = $x['disttype'];
    $dist = $x['distno'];
    $qdist = $disttype;

    if ($qdist == "county" && $dist < 999) {
        $printdist = getcountyname($dist) . " County";
    } elseif ($dist == 999) {
        $printdist = "Statewide Totals";
    } else {
        //do nothing
    }

    //POPULATE DIV AT TOP OF PAGE SHOWING PARTIAL SUB-DISTRICTS INCLUDED IN MAIN

    if ($dist != 999) {   // SO LONG AS IT'S NOT STATEWIDE

        $x = (parseoffices($qdist, $dist, "g12"));  //USING G12 AS IT'S THE MOST COMPLETE DATASET

        echo "<section id='inccontain'><div class='inccountycontain'>";

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = substr($value, -2);

            $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

            if ($y == "county") {
                $v = getcountyname($z);
                $cl = "<a href='" . getcountylink($z) . "'>" . $v . "</a>";
                if ($subdpct != 0) {
                    echo("<div class='inccounty'>" . $cl . " County (" . $subdpct . ")&nbsp</div>");
                }
            }
        }

        echo("</div>");

        $final = '';

        echo("<div class='incadcontain'>");

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = checkaddzero(substr($value, -2));


            $thisfourcode = makefour($y, $z);
            $final = getctblink($thisfourcode) . $thisfourcode . "</a>";

            $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

            if ($y == "addist") {
                //if ($subdpct != 0) {echo("<div class='incad'>AD" . checkaddzero($z) . " (" . $subdpct . ")&nbsp</div>");}
                if ($subdpct != 0) {
                    echo("<div class='incad'>" . $final . " (" . $subdpct . ")&nbsp</div>");
                }
            }

        }

        echo("</div>");

        echo("<div class='incsdcontain'>");

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = checkaddzero(substr($value, -2));


            $thisfourcode = makefour($y, $z);
            $final = getctblink($thisfourcode) . $thisfourcode . "</a>";

            $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

            if ($y == "sddist") {
                //if ($subdpct != 0) {echo("<div class='incad'>AD" . checkaddzero($z) . " (" . $subdpct . ")&nbsp</div>");}
                if ($subdpct != 0) {
                    echo("<div class='incad'>" . $final . " (" . $subdpct . ")&nbsp</div>");
                }
            }

        }

        echo("</div>");


        echo("<div class='inccdcontain'>");

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = checkaddzero(substr($value, -2));


            $thisfourcode = makefour($y, $z);
            $final = getctblink($thisfourcode) . $thisfourcode . "</a>";

            $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

            if ($y == "cddist") {
                //if ($subdpct != 0) {echo("<div class='incad'>AD" . checkaddzero($z) . " (" . $subdpct . ")&nbsp</div>");}
                if ($subdpct != 0) {
                    echo("<div class='incad'>" . $final . " (" . $subdpct . ")&nbsp</div>");
                }
            }

        }

        echo("</div>");

        echo("<div class='inccdcontain'>");

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = checkaddzero(substr($value, -2));


            $thisfourcode = makefour($y, $z);
            $final = getctblink($thisfourcode) . $thisfourcode . "</a>";

            $subdpct = getsubdistrictpercent($qdist, $dist, $y, $z);

            if ($y == "bedist") {
                //if ($subdpct != 0) {echo("<div class='incad'>AD" . checkaddzero($z) . " (" . $subdpct . ")&nbsp</div>");}
                if ($subdpct != 0) {
                    echo("<div class='incad'>" . $final . " (" . $subdpct . ")&nbsp</div>");
                }
            }

        }

        echo("</div>");

        echo("</section>");
    }


    //$masterfourcode = $fourcode;

    //BEGIN STATEWIDE RACE REPORT GENERATOR - 2014 GENERAL

    $elec = "g16";
    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2016 General</h1>");
    $offarray = Array("PRS", "USS", "P51", "P52", "P53", "P54", "P55", "P56", "P57", "P58", "P59", "P60", "P61", "P62", "P63", "P64", "P65", "P66", "P67");
    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }
    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");


    $elec = "p16";
    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2016 Primary</h1>");
    $offarray = Array("PRSDEM", "PRSREP", "PRSLIB", "PRSAIP", "PRSGRN", "USS", "P50");
    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }
    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");

    $elec = "g14";
    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2014 General</h1>");
    $offarray = Array("GOV", "LTG", "TRS", "ATG", "SOS", "INS", "CON", "BOE01", "BOE02", "BOE03", "BOE04", "P01", "P02", "P45", "P46", "P47", "P48");
    $disclaimer = getdisclaimer($elec, $qrep, $fourcode);
    if ($disclaimer != "") {
        echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
    }

    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }

    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");

    //2014 PRIMARY

    $elec = "p14";
    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2014 Primary</h1>");
    $offarray = Array("GOV", "LTG", "TRS", "ATG", "CON", "SOS", "INS", "P41", "P42");
    $disclaimer = getdisclaimer($elec, $qrep, $fourcode);
    if ($disclaimer != "") {
        echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
    }

    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }
    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");

    //2012 GENERAL

    $elec = "g12";

    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2012 General</h1>");
    $offarray = Array("PRS", "USS", "P30", "P31", "P32", "P33", "P34", "P35", "P36", "P37", "P38", "P39", "P40");
    $disclaimer = getdisclaimer($elec, $qrep, $fourcode);
    if ($disclaimer != "") {
        echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
    }

    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }
    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");

    //2012 PRIMARY

    $elec = "p12";

    echo("<div class='jumbotron'><h1 text-align='center'>" . $fourcode . " - 2012 Primary</h1>");
    $disclaimer = getdisclaimer($elec, $qrep, $fourcode);
    if ($disclaimer != "") {
        echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
    }

    $offarray = Array("PRSDEM", "PRSREP", "PRSGRN", "PRSLIB", "USS", "P28", "P29");


    foreach ($offarray as $value) {
        getrace($masterfourcode, $elec, $value);
    }

    retrieveallsubdistraces($masterfourcode, $elec);
    echo("</div>");


}

function getsum($fourcode, $elec, $col)
{



    $conn = Util::get_ctb_conn();

    $tmp = getdisttype($fourcode);

    $y = $tmp['distno'];
    $z = $tmp['disttype'];
    $x = strtoupper(mb_substr($z, 0, 2));  //  ASSIGN VALUES X = AD/CD/SD, Y = district number, Z = "addist", "cddist", "sddist"

    $retval = "";

    if ($y == 999) {
        $z = "ELECTION";
        $y = "'" . $elec . "'";
    }

    //echo("dist:" . $m);

    $sql = "SELECT SUM(" . $col . ") AS TOTAL FROM ctb2016_" . $elec . " WHERE " . $z . " = " . $y . ";";

    if (mb_substr($col, 0, 3) == "BOE") {
        $boedist = mb_substr($col, 4, 1);
        $party = mb_substr($col, 5, 3);
        $candnum = mb_substr($col, 8, 2);

        $sql = "SELECT SUM(BOE$party$candnum) AS TOTAL FROM ctb2016_" . $elec . " WHERE bedist = $boedist && $z = $y";
    }


    $result = $conn->query($sql);
    $i = p12check($elec);
    $i++;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $retval = $row["TOTAL"];
            }
            $i++;
        }
    } else {
        $retval = "0 results";
    }

    //echo("i:" . $i . " retval:" . $retval);
    return $retval;

}

/*

   SSSSSSSSSSSSSSS UUUUUUUU     UUUUUUUUBBBBBBBBBBBBBBBBB   DDDDDDDDDDDDD      IIIIIIIIII   SSSSSSSSSSSSSSS TTTTTTTTTTTTTTTTTTTTTTT
 SS:::::::::::::::SU::::::U     U::::::UB::::::::::::::::B  D::::::::::::DDD   I::::::::I SS:::::::::::::::ST:::::::::::::::::::::T
S:::::SSSSSS::::::SU::::::U     U::::::UB::::::BBBBBB:::::B D:::::::::::::::DD I::::::::IS:::::SSSSSS::::::ST:::::::::::::::::::::T
S:::::S     SSSSSSSUU:::::U     U:::::UUBB:::::B     B:::::BDDD:::::DDDDD:::::DII::::::IIS:::::S     SSSSSSST:::::TT:::::::TT:::::T
S:::::S             U:::::U     U:::::U   B::::B     B:::::B  D:::::D    D:::::D I::::I  S:::::S            TTTTTT  T:::::T  TTTTTT
S:::::S             U:::::D     D:::::U   B::::B     B:::::B  D:::::D     D:::::DI::::I  S:::::S                    T:::::T
 S::::SSSS          U:::::D     D:::::U   B::::BBBBBB:::::B   D:::::D     D:::::DI::::I   S::::SSSS                 T:::::T
  SS::::::SSSSS     U:::::D     D:::::U   B:::::::::::::BB    D:::::D     D:::::DI::::I    SS::::::SSSSS            T:::::T
    SSS::::::::SS   U:::::D     D:::::U   B::::BBBBBB:::::B   D:::::D     D:::::DI::::I      SSS::::::::SS          T:::::T
       SSSSSS::::S  U:::::D     D:::::U   B::::B     B:::::B  D:::::D     D:::::DI::::I         SSSSSS::::S         T:::::T
            S:::::S U:::::D     D:::::U   B::::B     B:::::B  D:::::D     D:::::DI::::I              S:::::S        T:::::T
            S:::::S U::::::U   U::::::U   B::::B     B:::::B  D:::::D    D:::::D I::::I              S:::::S        T:::::T
SSSSSSS     S:::::S U:::::::UUU:::::::U BB:::::BBBBBB::::::BDDD:::::DDDDD:::::DII::::::IISSSSSSS     S:::::S      TT:::::::TT
S::::::SSSSSS:::::S  UU:::::::::::::UU  B:::::::::::::::::B D:::::::::::::::DD I::::::::IS::::::SSSSSS:::::S      T:::::::::T
S:::::::::::::::SS     UU:::::::::UU    B::::::::::::::::B  D::::::::::::DDD   I::::::::IS:::::::::::::::SS       T:::::::::T
 SSSSSSSSSSSSSSS         UUUUUUUUU      BBBBBBBBBBBBBBBBB   DDDDDDDDDDDDD      IIIIIIIIII SSSSSSSSSSSSSSS         TTTTTTTTTTT

 */


function retrieveallsubdistraces($fourcode, $qelec)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    if (mb_substr($fourcode, 0, 3) == "BOE") {
        $qdist = "bedist";
        $dist = mb_substr($fourcode, 3, 1);
    } else {
        $qdist = tophalf($fourcode);
        $dist = bothalf($fourcode);
    }
    $option = "2010";


    //echo("mb_substr of qelec = " . mb_substr($qelec,1,2));

    if (mb_substr($qelec, 1, 2) < 12) {
        $option = "2000";
    } else {
        $option = "2010";
    }

    //echo("-Using Option " . $option);

    //echo("retrieving locals where qdist:$qdist and dist:$dist");

    $alllocals = retrievesubdistlist($qdist, $dist, $option, $conn);

    foreach ($alllocals as $value) {
        //echo("<br>LOOKATME:$value<br>");
        $qsubdist = tophalf($value);
        $subdist = bothalf($value);

        //echo("Populating div for " . $qsubdist . $subdist . "<br>");
        $divhead = gethead($value);
        $fourmain = makefour($qdist, $dist);
        $foursub = makefour($qsubdist, $subdist);
        //echo($value . "  ");
        $y = getracekeys($subdist, $qsubdist, $qelec, $conn);

        $racehead = Array();
        $racelongkey = Array();
        $racecandname = Array();
        $racevoteamount = Array();
        $racesubdtotal = Array();
        $offpct = Array();
        $votetotal = 0;

        foreach ($y as $value) {
            array_push($racehead, $value);
            //echo(" pushed " . $value . " onto racehead for " . $qelec . "election");
            $xkey = expandkey($value, $subdist);
            array_push($racelongkey, $xkey);
            $x = getnamefromkey($xkey, $qelec, $conn);
            //echo($value . " candidate name:" . $x);
            array_push($racecandname, $x);
        }

        foreach ($racelongkey as $value) {
            //echo("Fourmain:$fourmain Foursub:$foursub Value:$value Qelec:$qelec");
            $x = getvotebysubdist($fourmain, $foursub, $value, $qelec, $conn);
            array_push($racesubdtotal, $x);
            //echo("Vote for" . $value . " in CD04:" . $x . " in race for " . $fourmain);
            $z = $x;
            //echo("z: ". $z);
            $votetotal += $z;
        }

        foreach ($racesubdtotal as $value) {
            $x = calcpct($value, $votetotal);
            //echo("<br>" . $foursub . " is..." . $x);
            if ($x == 0 || $x == NULL) {
                $x = "";
            }

            array_push($offpct, $x);
        }

        $x = 0;

        if ($racesubdtotal) {
            echo("<div class='rescont'><p>" . $divhead . "</p>");

            foreach ($racehead as $value) {

                if (mb_substr($value, 0, 2) != "PR" || mb_substr($value, 0, 3) == "PRS") {
                    $party = mb_substr($value, 3, 3);
                }

                if (substr($racecandname[$x], -1) == "*") {
                    $party = $party . "-INC";
                }

                if ($offpct[$x]) {
                    echo("<div class='indresult'><div class='candidatename'>" . $racecandname[$x] . "</div><div class='candidateparty'>" . $party . "</div><div class='candidatevotes'>" . $racesubdtotal[$x] . "</div><div class = 'candidatepct'>" . $offpct[$x] . "</div></div>");
                }
                $x++;
            }

            echo("</div>");
        }

    }

}

function getsubdistrictpercent($qdist, $dist, $y, $x)
{  //EX ('addist' '5' 'cddist' '2' $conn)

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $retval = "";
    $sql = "SELECT SUM(TOTREG) AS TOTAL FROM ctb2016_g14 WHERE " . $qdist . " = " . $dist;    //GET MAIN DISTRICT TOTAL REGISTRATION FROM MOST RECENT ELECTION
    $result = $conn->query($sql);

    $i = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $totregmain = $row["TOTAL"];
            }
            $i++;
        }
    } else {
        //DO NOTHING
    }


    $sql = "SELECT SUM(TOTREG)AS TOTAL FROM ctb2016_g14 WHERE " . $qdist . " = " . $dist . " && " . $y . " = " . $x; // GET TOTAL REGISTRATION FROM OVERLAP OF MAIN DISTRICT AND SUBDISTRICT

    $result = $conn->query($sql);

    $i = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $totregsub = $row["TOTAL"];
            }
            $i++;
        }
    } else {
        //$retval = "0 results";
    }

    $retval = calcpct($totregsub, $totregmain);

    return $retval;

}

function retrievesubdistlist($qdist, $dist, $option)
{

    global $ctb2016_conn;

    $retval = Array();

    //echo("Using $option");

    if ($option != "2000") {
        $usedistfrom = "g12";
    } else {
        $usedistfrom = "g08";
    }

    //echo("Using $usedistfrom");


    if ($qdist == "county" && $dist < 999) {
        $printdist = getcountyname($dist) . " County";
    } elseif ($dist == 999) {
        $printdist = "Statewide Totals";
    } else {
        //do nothing
    }


    if ($dist != 999) {


        //echo("qdist:$qdist dist:$dist");

        $x = (parseoffices($qdist, $dist, $usedistfrom));

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = substr($value, -2);

            if ($y == "addist") {
                $tempvar = "AD" . checkaddzero($z);
                array_push($retval, $tempvar);
            }

        }

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = substr($value, -2);

            if ($y == "sddist") {
                $tempvar = "SD" . checkaddzero($z);
                array_push($retval, $tempvar);
            }

        }

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = substr($value, -2);

            if ($y == "cddist") {
                $tempvar = "CD" . checkaddzero($z);
                array_push($retval, $tempvar);
            }

        }

        foreach ($x as $value) {
            $y = mb_substr($value, 0, 6);
            $z = substr($value, -2);

            if ($y == "bedist") {
                $tempvar = "BOE" . substr($value, -1);
                array_push($retval, $tempvar);
            }

        }


    } else {
        $retval = "STAT";
    }

    return $retval;
}

/*

EEEEEEEEEEEEEEEEEEEEEETTTTTTTTTTTTTTTTTTTTTTTHHHHHHHHH     HHHHHHHHHNNNNNNNN        NNNNNNNNIIIIIIIIII      CCCCCCCCCCCCC
E::::::::::::::::::::ET:::::::::::::::::::::TH:::::::H     H:::::::HN:::::::N       N::::::NI::::::::I   CCC::::::::::::C
E::::::::::::::::::::ET:::::::::::::::::::::TH:::::::H     H:::::::HN::::::::N      N::::::NI::::::::I CC:::::::::::::::C
EE::::::EEEEEEEEE::::ET:::::TT:::::::TT:::::THH::::::H     H::::::HHN:::::::::N     N::::::NII::::::IIC:::::CCCCCCCC::::C
  E:::::E       EEEEEETTTTTT  T:::::T  TTTTTT  H:::::H     H:::::H  N::::::::::N    N::::::N  I::::I C:::::C       CCCCCC
  E:::::E                     T:::::T          H:::::H     H:::::H  N:::::::::::N   N::::::N  I::::IC:::::C
  E::::::EEEEEEEEEE           T:::::T          H::::::HHHHH::::::H  N:::::::N::::N  N::::::N  I::::IC:::::C
  E:::::::::::::::E           T:::::T          H:::::::::::::::::H  N::::::N N::::N N::::::N  I::::IC:::::C
  E:::::::::::::::E           T:::::T          H:::::::::::::::::H  N::::::N  N::::N:::::::N  I::::IC:::::C
  E::::::EEEEEEEEEE           T:::::T          H::::::HHHHH::::::H  N::::::N   N:::::::::::N  I::::IC:::::C
  E:::::E                     T:::::T          H:::::H     H:::::H  N::::::N    N::::::::::N  I::::IC:::::C
  E:::::E       EEEEEE        T:::::T          H:::::H     H:::::H  N::::::N     N:::::::::N  I::::I C:::::C       CCCCCC
EE::::::EEEEEEEE:::::E      TT:::::::TT      HH::::::H     H::::::HHN::::::N      N::::::::NII::::::IIC:::::CCCCCCCC::::C
E::::::::::::::::::::E      T:::::::::T      H:::::::H     H:::::::HN::::::N       N:::::::NI::::::::I CC:::::::::::::::C
E::::::::::::::::::::E      T:::::::::T      H:::::::H     H:::::::HN::::::N        N::::::NI::::::::I   CCC::::::::::::C
EEEEEEEEEEEEEEEEEEEEEE      TTTTTTTTTTT      HHHHHHHHH     HHHHHHHHHNNNNNNNN         NNNNNNNIIIIIIIIII      CCCCCCCCCCCCC

*/


function draweth($fourcode)
{

    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $dist = $x['distno'];
    $printdist = $disttype . $dist;
    $qdist = $disttype;

    if ($qdist == "county" && $dist < 999) {
        $printdist = getcountyname($dist) . " County";
    } elseif ($dist == 999) {
        $printdist = "Statewide Totals";
    } else {
        //do nothing
    }

    $electarr = Array("p16", "g14", "p14", "g12", "p12");
    $asianarr = Array("KOR", "JPN", "CHI", "IND", "VIET", "FIL");

    $otherarr = Array("HISP", "JEW");
    $asiantotal = Array();

    foreach ($electarr as $qelec) {

        switch ($qelec) {
            case "p16":
                $printelec = "2016 Primary Election";
                break;
            case "g14":
                $printelec = "2014 General Election";
                break;
            case "p14":
                $printelec = "2014 Primary Election";
                break;
            case "g12":
                $printelec = "2012 General Election";
                break;
            case "p12":
                $printelec = "2012 Primary Election";
                break;
        }

        echo("<div class = 'electhead'><h1>" . $fourcode . " - " . $printelec . "</h1></div>");

        $disclaimer = getdisclaimer($qelec, $qrep, $fourcode);
        if ($disclaimer != "") {
            echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
        }

        //GET ALL ASIAN SUBGROUPS

        $asianhead = Array("DEM", "REP", "DCL", "OTH", "TOT");
        $asiansreg = Array(0, 0, 0, 0, 0);
        $asiansvot = Array(0, 0, 0, 0, 0);
        $asiandreg = Array(0, 0, 0, 0, 0);
        $asiandvot = Array(0, 0, 0, 0, 0);

        foreach ($asianarr as $ethgrp) {

            $x = getethnicstats($fourcode, $qelec, $ethgrp);

            //KEEP RUNNING TOTAL OF STATEWIDE ASIAN

            $i = 0;
            $j = 0;
            $ptr = 12;

            foreach ($asianhead as $value) {
                $asiandreg[$j] = $asiandreg[$j] + $x[$i];
                $asiandvot[$j] = $asiandvot[$j] + $x[$i + 1];
                $asiansreg[$j] = $asiansreg[$j] + $x[$ptr + $i];
                $asiansvot[$j] = $asiansvot[$j] + $x[$ptr + $i + 1];
                $i = $i + 2;
                $j = $j + 1;
            }

            drawethnicdiv($x);


        }

        //WHEN FINISHED WITH INDIVIDUAL ASIAN SUBGROUPS, REPOPULATE LAST RESULT WITH TOTAL, 'ALL ASIAN' DIVHEAD

        $i = 0;
        $j = 0;
        $rptr = 12;

        $asianhead = Array("DEM", "REP", "DCL", "OTH", "TOT");
        foreach ($asianhead as $value) {
            //echo("R[" . $j . "]:" . $asiandreg[$j] . "V:" . $asiandvot[$j]);

            $x[$i] = $asiandreg[$j];
            $x[$i + 1] = $asiandvot[$j];

            $x[$ptr + $i] = $asiansreg[$j];
            $x[$ptr + $i + 1] = $asiansvot[$j];

            $i = $i + 2;
            $j++;
        }

        //var_dump($asiandreg);

        $x[30] = "TOTAL ASIAN";

        drawethnicdiv($x);

        foreach ($otherarr as $ethgrp) {

            $x = getethnicstats($fourcode, $qelec, $ethgrp);
            drawethnicdiv($x);

        }
    }
}

function getethnicstats($fourcode, $qelec, $option)
{  //EX: getethnicstats("SD04", "p12", "KOR", connection)
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $qdist = tophalf($fourcode);                              //
    $dist = bothalf($fourcode);                                  //RETURNS Array of ()
    $head = Array();
    $retval = Array();
    $regresult = Array();
    $votresult = Array();
    $r = "r";
    $totregeth = 0;
    $totvoteth = 0;

    $partyhead = Array("DEM", "REP", "DCL", "OTH");

    switch ($option) {
        case "KOR":
            $divhead = "KOREAN";
            break;
        case "JPN":
            $divhead = "JAPANESE";
            break;
        case "CHI":
            $divhead = "CHINESE";
            break;
        case "IND":
            $divhead = "EAST INDIAN";
            break;
        case "VIET":
            $divhead = "VIETNAMESE";
            break;
        case "FIL":
            $divhead = "FILIPINO";
            break;
        case "JEW":
            $divhead = "JEWISH";
            break;
        case "HISP":
            $divhead = "LATINO";
            break;
    }

    //GET ALL PARTY CLASSES OF ETHNIC GROUP FROM DISTRICT - RESULTS 0 - 7

    foreach ($partyhead as $party) {

        if ($qelec != "q16") {

            $sql = "SELECT SUM(" . $option . $party . ") AS VOTING, SUM(" . $r . $option . $party . ") AS REGISTERED FROM ctb2016_" . $qelec . " WHERE " . $qdist . " = " . $dist . "";

            //echo("sqlgetethnicstats:" . $sql);

            $result = $conn->query($sql);

            $i = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        array_push($retval, $row["REGISTERED"]);
                        array_push($retval, $row["VOTING"]);
                    }
                    $i++;
                }
            } else {
                $retval = "0 results";
            }
        } else {
            $sql = "SELECT SUM(" . $option . $party . ") AS REGISTERED FROM ctb2016_p16reg WHERE $qdist = $dist";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['REGISTERED']);
                }
            }
            $sql = "SELECT SUM(" . $option . $party . ") AS VOTING FROM ctb2016_p16vote WHERE $qdist = $dist";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['VOTING']);
                }
            }
        }
    }

    //PUSH DISTRICT ETHNIC TOTALS INTO RESULTS 8 - 9


    $rtot = $retval[0] + $retval[2] + $retval[4] + $retval[6];
    array_push($retval, $rtot);

    $vtot = $retval[1] + $retval[3] + $retval[5] + $retval[7];
    array_push($retval, $vtot);


    //GET OVERALL DISTRICT REGISTRATION TOTALS AND PUSH INTO RESULTS 10 - 11


    $sql = "SELECT SUM(TOTREG) AS REGISTERED, SUM(TOTVOTE) AS VOTING FROM ctb2016_" . $qelec . " WHERE " . $qdist . " = " . $dist;


    $result = $conn->query($sql);

    $i = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                array_push($retval, $row["REGISTERED"]);
                array_push($retval, $row["VOTING"]);
            }
            $i++;
        }
    } else {
        $retval = "0 results";
    }


    //GET STATEWIDE ETHNIC RESULTS BY PARTY, PUSH VALUES INTO RESULT 12 - 19


    foreach ($partyhead as $party) {

        if ($qelec != "q16") {
            $sql = "SELECT SUM(" . $option . $party . ") AS VOTING, SUM(" . $r . $option . $party . ") AS REGISTERED FROM ctb2016_" . $qelec;

            //echo("sqlgetethnicstats:" . $sql);

            $result = $conn->query($sql);

            $i = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        array_push($retval, $row["REGISTERED"]);
                        array_push($retval, $row["VOTING"]);
                        $totregeth += $row["REGISTERED"];
                        $totvoteth += $row["VOTING"];
                    }
                    $i++;
                }
            }
        } else {
            $sql = "SELECT SUM(" . $option . $party . ") AS REGISTERED FROM ctb2016_p16reg";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['REGISTERED']);
                    $totregeth += $row["REGISTERED"];
                }
            }
            $sql = "SELECT SUM(" . $option . $party . ") AS VOTING FROM ctb2016_p16vote";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['VOTING']);
                    $totvoteth += $row["VOTING"];
                }
            }
        }

    }

    //CALCULATE STATEWIDE ETHNIC TOTALS, PUSH INTO RESULTS 20,21

    array_push($retval, $totregeth);
    array_push($retval, $totvoteth);


    //RETRIEVE OVERALL DISTRICT TURNOUT FOR ENTIRE ELECTORATE BY PARTY AND PUSH INTO RESULTS 22 - 24 (Skipping 3rd parties, leave blank)


    $totregeth = 0;
    $totvoteth = 0;

    foreach ($partyhead as $party) {
        if ($qelec != "q16") {
            $sql = "SELECT SUM(" . $party . ") AS VOTING, SUM(" . $r . $party . ") AS REGISTERED FROM ctb2016_" . $qelec . " WHERE " . $qdist . " = " . $dist;

            //echo("sqlgetethnicstats:" . $sql);

            $result = $conn->query($sql);

            $i = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        array_push($retval, calcpct($row["VOTING"], $row["REGISTERED"]));
                        $totregeth += $row["REGISTERED"];
                        $totvoteth += $row["VOTING"];
                    }
                    $i++;
                }
            } else {
                //$retval = "0 results";
            }
        } else {
            $sql = "SELECT SUM(" . $party . ") AS REGISTERED FROM ctb2016_p16reg WHERE $qdist = $dist";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['REGISTERED']);
                    $totregeth += $row["REGISTERED"];
                }
            }
            $sql = "SELECT SUM(" . $party . ") AS VOTING FROM ctb2016_p16vote WHERE $qdist = $dist";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['VOTING']);
                    $totvoteth += $row["VOTING"];
                }
            }
        }

    }

    //PUSH TOTAL INTO RESULT 25

    array_push($retval, calcpct($totvoteth, $totregeth));

    //RETRIEVE OVERALL PARTY TURNOUT STATEWIDE AND PUSH INTO RESULTS 26 - 28 (No 3rd Parties, again, only REP, DEM, DCL)

    $totregeth = 0;
    $totvoteth = 0;

    foreach ($partyhead as $party) {
        if ($qelec != "q16") {
            $sql = "SELECT SUM(" . $party . ") AS VOTING, SUM(" . $r . $party . ") AS REGISTERED FROM ctb2016_" . $qelec;

            //echo("sqlgetethnicstats:" . $sql);

            $result = $conn->query($sql);

            $i = 1;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        array_push($retval, calcpct($row["VOTING"], $row["REGISTERED"]));
                        $totregeth += $row["REGISTERED"];
                        $totvoteth += $row["VOTING"];
                    }
                    $i++;
                }
            }
        } else {
            $sql = "SELECT SUM(" . $party . ") AS REGISTERED FROM ctb2016_p16reg";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['REGISTERED']);
                    $totregeth += $row["REGISTERED"];
                }
            }
            $sql = "SELECT SUM(" . $party . ") AS VOTING FROM ctb2016_p16vote";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($retval, $row['VOTING']);
                    $totvoteth += $row["VOTING"];
                }
            }
        }

    }

    //PUSH TOTAL INTO RESULT 29

    array_push($retval, calcpct($totvoteth, $totregeth));

    //PUSH LONG ETHNIC DESCRIPTION INTO RESULT 30

    array_push($retval, $divhead);

    return $retval;
}

function drawethnicdiv($x)
{
    $i = 0;

    $rarray = Array();
    $varray = Array();
    $rtotal = 0;
    $vtotal = 0;

    //echo("retrieved ethnic stats...looping...");

    $rdem = $x[0];
    $vdem = $x[1];
    $rrep = $x[2];
    $vrep = $x[3];
    $rdcl = $x[4];
    $vdcl = $x[5];
    $roth = $x[6];
    $voth = $x[7];

    $rtot = $x[8];
    $vtot = $x[9];

    $dreg = $x[10];
    $dvot = $x[11];

    $sethrd = $x[12];
    $sethrr = $x[14];
    $sethrdcl = $x[16];
    $sethroth = $x[18];


    $sethvd = $x[13];
    $sethvr = $x[15];
    $sethvdcl = $x[17];
    $sethvoth = $x[19];

    $sethrtot = $x[20];
    $sethvtot = $x[21];

    $distd = $x[22];
    $distr = $x[23];
    $distdcl = $x[24];

    $disttot = $x[25];

    $statdem = $x[26];
    $statrep = $x[27];
    $statdcl = $x[28];
    $stattot = $x[29];

    $divhead = $x[30];

    $sethd = calcpct($sethvd, $sethrd);
    $sethr = calcpct($sethvr, $sethrr);
    $sethdcl = calcpct($sethvdcl, $sethrdcl);
    $sethoth = calcpct($sethvoth, $sethroth);
    $sethtot = calcpct($sethvtot, $sethrtot);

    // . " - "
    $somehtml = '

<div class = "othcon thickborder">

	<div class = "divhead"><h2>' . $divhead . '</h2></div>


	<div class = "tr">
		<div class = "tdcol1">&nbsp</div>
		<div class = "td">DEM</div>
		<div class = "tdp">%</div>
		<div class = "td">REP</div>
		<div class = "tdp">%</div>
		<div class = "td">NPP</div>
		<div class = "tdp">%</div>
		<div class = "td">OTH</div>
		<div class = "tdp">%</div>
		<div class = "td">TOTAL</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">TOTAL REGISTERED</div>
		<div class = "td">' . $rdem . '</div>
		<div class = "tdp">' . calcpct($rdem, $rtot) . '</div>
		<div class = "td">' . $rrep . '</div>
		<div class = "tdp">' . calcpct($rrep, $rtot) . '</div>
		<div class = "td">' . $rdcl . '</div>
		<div class = "tdp">' . calcpct($rdcl, $rtot) . '</div>
		<div class = "td">' . $roth . '</div>
		<div class = "tdp">' . calcpct($roth, $rtot) . '</div>
		<div class = "td">' . $rtot . '</div>
	</div>

	<div class = "tr">
		<div class = "tdcol1">% OF DISTRICT</div>
		<div class = "td">' . calcpct($rdem, $dreg) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($rrep, $dreg) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($rdcl, $dreg) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($roth, $dreg) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($rtot, $dreg) . '</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">TOTAL VOTING</div>
		<div class = "td">' . $vdem . '</div>
		<div class = "tdp">' . calcpct($vdem, $vtot) . '</div>
		<div class = "td">' . $vrep . '</div>
		<div class = "tdp">' . calcpct($vrep, $vtot) . '</div>
		<div class = "td">' . $vdcl . '</div>
		<div class = "tdp">' . calcpct($vdcl, $vtot) . '</div>
		<div class = "td">' . $voth . '</div>
		<div class = "tdp">' . calcpct($voth, $vtot) . '</div>
		<div class = "td">' . $vtot . '</div>
	</div>

	<div class = "tr">
		<div class = "tdcol1">% OF DISTRICT</div>
		<div class = "td">' . calcpct($vdem, $dvot) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vrep, $dvot) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vdcl, $dvot) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($voth, $dvot) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vtot, $dvot) . '</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">' . $divhead . ' TURNOUT %</div>
		<div class = "td">' . calcpct($vdem, $rdem) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vrep, $rrep) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vdcl, $rdcl) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($voth, $roth) . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . calcpct($vtot, $rtot) . '</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">DISTRICT TURNOUT (ALL)</div>
		<div class = "td">' . $distd . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $distr . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $distdcl . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td"> -- </div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $disttot . '</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">STATEWIDE TURNOUT %</div>
		<div class = "td">' . $statdem . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $statrep . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $statdcl . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td"> -- </div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $stattot . '</div>
	</div>

	<hr class="spacer"></hr>

	<div class = "tr">
		<div class = "tdcol1">STATEWIDE ' . $divhead . ' REGISTERED</div>
		<div class = "td">' . $sethrd . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethrr . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethrdcl . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethroth . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethrtot . '</div>
	</div>

	<div class = "tr">
		<div class = "tdcol1">STATEWIDE ' . $divhead . ' VOTING</div>
		<div class = "td">' . $sethvd . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethvr . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethvdcl . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethvoth . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethvtot . '</div>
	</div>

	<div class = "tr">
		<div class = "tdcol1">STATEWIDE ' . $divhead . ' TURNOUT %</div>
		<div class = "td">' . $sethd . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethr . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethdcl . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethoth . '</div>
		<div class = "tdp"> -- </div>
		<div class = "td">' . $sethtot . '</div>
	</div>


</div>
';

    echo($somehtml);

}

function getallethnicities($fourcode, $election)
{
    global $ctb2016_conn;
    $asianarray = Array();
    $temparray = Array();

    $retval = Array();
    $ethnicities = Array("HISP", "JEW", "KOR", "JPN", "CHI", "IND", "VIET", "FIL");
    $parties = Array("DEM", "REP", "DCL", "OTH");

    foreach ($ethnicities as $ethnicity) {
        if ($temparray) {
            array_push($retval, $temparray);
            $temparray = Array();
        }

        foreach ($parties as $party) {
            $class = $ethnicity . $party;
            $x = getturnout($fourcode, $class, $election);
            $x['ETHNICITY'] = $ethnicity;
            $y = getturnout("STW", $class, $election);
            $x['STW_REGISTERED'] = $y['REGISTERED'];
            $x['STW_VOTED'] = $y['VOTED'];
            array_push($temparray, $x);
            if ($ethnicity != "HISP" && $ethnicity != "JEW") {
                $thisclass = "ASIAN" . $party;
                $asianarray[$thisclass]['REGISTERED'] += $x['REGISTERED'];
                $asianarray[$thisclass]['VOTED'] += $x['VOTED'];
                $asianarray[$thisclass]['CLASS'] = $thisclass;
                $asianarray[$thisclass]['STW_REGISTERED'] += $x['STW_REGISTERED'];
                $asianarray[$thisclass]['STW_VOTED'] += $x['STW_VOTED'];

            }
        }
    }
    array_push($retval, $temparray);
    $temparray = Array();

    foreach ($asianarray as $asianclass) {
        $tmp['CLASS'] = $asianclass['CLASS'];
        $tmp['VOTED'] = $asianclass['VOTED'];
        $tmp['REGISTERED'] = $asianclass['REGISTERED'];
        $tmp['STW_REGISTERED'] = $asianclass['STW_REGISTERED'];
        $tmp['STW_VOTED'] = $asianclass['STW_VOTED'];
        $tmp['ETHNICITY'] = "ASIAN";
        array_push($temparray, $tmp);
    }

    array_push($retval, $temparray);

    return $retval;

}


function getdisttype_old($fourcode)
{
    $type = mb_substr($fourcode, 0, 2);
    switch ($type) {
        case "CD":
            $retval = "cddist";
            break;
        case "BO":
            $retval = "bedist";
            break;
        case "SD":
            $retval = "sddist";
            break;
        case "AD":
            $retval = "addist";
            break;
        case "CO":
            $retval = "county";
            break;
    }

    return $retval;
}


function p12check($x)
{
    if ($x == "p12") {
        $i = 1;
    } else {
        $i = 0;
    }

    return $i;
}

/*

EEEEEEEEEEEEEEEEEEEEEELLLLLLLLLLL             EEEEEEEEEEEEEEEEEEEEEE       CCCCCCCCCCCCCHHHHHHHHH     HHHHHHHHHEEEEEEEEEEEEEEEEEEEEEE               AAA               DDDDDDDDDDDDD
E::::::::::::::::::::EL:::::::::L             E::::::::::::::::::::E    CCC::::::::::::CH:::::::H     H:::::::HE::::::::::::::::::::E              A:::A              D::::::::::::DDD
E::::::::::::::::::::EL:::::::::L             E::::::::::::::::::::E  CC:::::::::::::::CH:::::::H     H:::::::HE::::::::::::::::::::E             A:::::A             D:::::::::::::::DD
EE::::::EEEEEEEEE::::ELL:::::::LL             EE::::::EEEEEEEEE::::E C:::::CCCCCCCC::::CHH::::::H     H::::::HHEE::::::EEEEEEEEE::::E            A:::::::A            DDD:::::DDDDD:::::D
  E:::::E       EEEEEE  L:::::L                 E:::::E       EEEEEEC:::::C       CCCCCC  H:::::H     H:::::H    E:::::E       EEEEEE           A:::::::::A             D:::::D    D:::::D
  E:::::E               L:::::L                 E:::::E            C:::::C                H:::::H     H:::::H    E:::::E                       A:::::A:::::A            D:::::D     D:::::D
  E::::::EEEEEEEEEE     L:::::L                 E::::::EEEEEEEEEE  C:::::C                H::::::HHHHH::::::H    E::::::EEEEEEEEEE            A:::::A A:::::A           D:::::D     D:::::D
  E:::::::::::::::E     L:::::L                 E:::::::::::::::E  C:::::C                H:::::::::::::::::H    E:::::::::::::::E           A:::::A   A:::::A          D:::::D     D:::::D
  E:::::::::::::::E     L:::::L                 E:::::::::::::::E  C:::::C                H:::::::::::::::::H    E:::::::::::::::E          A:::::A     A:::::A         D:::::D     D:::::D
  E::::::EEEEEEEEEE     L:::::L                 E::::::EEEEEEEEEE  C:::::C                H::::::HHHHH::::::H    E::::::EEEEEEEEEE         A:::::AAAAAAAAA:::::A        D:::::D     D:::::D
  E:::::E               L:::::L                 E:::::E            C:::::C                H:::::H     H:::::H    E:::::E                  A:::::::::::::::::::::A       D:::::D     D:::::D
  E:::::E       EEEEEE  L:::::L         LLLLLL  E:::::E       EEEEEEC:::::C       CCCCCC  H:::::H     H:::::H    E:::::E       EEEEEE    A:::::AAAAAAAAAAAAA:::::A      D:::::D    D:::::D
EE::::::EEEEEEEE:::::ELL:::::::LLLLLLLLL:::::LEE::::::EEEEEEEE:::::E C:::::CCCCCCCC::::CHH::::::H     H::::::HHEE::::::EEEEEEEE:::::E   A:::::A             A:::::A   DDD:::::DDDDD:::::D
E::::::::::::::::::::EL::::::::::::::::::::::LE::::::::::::::::::::E  CC:::::::::::::::CH:::::::H     H:::::::HE::::::::::::::::::::E  A:::::A               A:::::A  D:::::::::::::::DD
E::::::::::::::::::::EL::::::::::::::::::::::LE::::::::::::::::::::E    CCC::::::::::::CH:::::::H     H:::::::HE::::::::::::::::::::E A:::::A                 A:::::A D::::::::::::DDD
EEEEEEEEEEEEEEEEEEEEEELLLLLLLLLLLLLLLLLLLLLLLLEEEEEEEEEEEEEEEEEEEEEE       CCCCCCCCCCCCCHHHHHHHHH     HHHHHHHHHEEEEEEEEEEEEEEEEEEEEEEAAAAAAA                   AAAAAAADDDDDDDDDDDDD

*/


function getrace($fourcode, $elec, $office)
{


    global $ctb2016_conn;
    $offres = array("");
    $offpct = array("");
    $offarr = array("");
    $offhead = array("");
    $divhead = array("");
    $x = 0;
    $y = 0;

    switch ($elec) {

        case "g08":

            switch ($office) {
                case "PRS":
                    $divhead = "PRESIDENT OF THE UNITED STATES";
                    $offarr = array("PRSDEM", "PRSREP", "PRSAIP", "PRSGRN", "PRSLIB", "PRSPAF");
                    $offhead = array("Barack Obama", "John McCain", "Alan Keyes", "Cynthia McKinney", "Bob Barr", "Ralph Nader");
                    break;
                case "P01":
                    $divhead = "PROP 1A - $9.95B HIGH SPEED RAIL BOND";
                    $offarr = array("PR_1A_Y", "PR_1A_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P02":
                    $divhead = "PROP 2 - REGULATION ON ANIMAL CONFINEMENT PRACTICES";
                    $offarr = array("PR_2_Y", "PR_2_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P03":
                    $divhead = "PROP 3 - $980M BOND FOR CHILDREN'S HOSPITALS";
                    $offarr = array("PR_3_Y", "PR_3_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P04":
                    $divhead = "PROP 4 - ABORTION WAITING PERIOD & PARENTAL NOTIFICATION";
                    $offarr = array("PR_4_Y", "PR_4_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P05":
                    $divhead = "PROP 5 - DRUG SENTENCING REFORM";
                    $offarr = array("PR_5_Y", "PR_5_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P06":
                    $divhead = "PROP 6 - INCREASE CRIME PREVENTION PROGRAMS, HARSHER PENALTIES";
                    $offarr = array("PR_6_Y", "PR_6_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P07":
                    $divhead = "PROP 7 - PROMOTE USE OF ALTERNATIVE FUELS";
                    $offarr = array("PR_7_Y", "PR_7_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P08":
                    $divhead = "PROP 8 - BAN SAME SEX MARRIAGE";
                    $offarr = array("PR_8_Y", "PR_8_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P09":
                    $divhead = "PROP 9 - LAW GOVERNING TREATMENT CRIME VICTIMS/PAROLE PROCEDURES";
                    $offarr = array("PR_9_Y", "PR_9_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P10":
                    $divhead = "PROP 10 - $5B BONDS FOR ALTERNATIVE FUELS";
                    $offarr = array("PR_10_Y", "PR_10_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P11":
                    $divhead = "PROP 11 - INDEPENDENT COMMISSION TO DRAW LEGISLATIVE DISTRICT BOUNDARIES";
                    $offarr = array("PR_11_Y", "PR_11_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P12":
                    $divhead = "PROP 12 - $900M IN BONDS FOR HOME, FARM PURCHASING ASSISTANCE FOR VETERANS";
                    $offarr = array("PR_12_Y", "PR_12_N");
                    $offhead = array("YES", "NO");
                    break;
            }
            break;

        case "p12":

            switch ($office) {
                case "PRSDEM":
                    $divhead = "DEMOCRATIC PRESIDENTIAL PRIMARY";
                    $offarr = array("PRSDEM01");
                    $offhead = Array("Barack Obama*");
                    break;
                case "PRSREP":
                    $divhead = "REPUBLICAN PRESIDENTIAL PRIMARY";
                    $offarr = array("PRSREP01", "PRSREP02", "PRSREP03", "PRSREP04", "PRSREP05", "PRSREP06");
                    $offhead = array("Fred Karger", "Newt Gingrich", "Mitt Romney", "Charles Roemer, III", "Rick Santorum", "Ron Paul");
                    break;
                case "PRSGRN":
                    $divhead = "GREEN PARTY PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSGRN01", "PRSGRN02", "PRSGRN03");
                    $offhead = Array("Kent Mesplay", "Jill Stein", "Roseanne Barr");
                    break;
                case "PRSLIB":
                    $divhead = "LIBERTARIAN PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSLIB01", "PRSLIB02", "PRSLIB03", "PRSLIB04", "PRSLIB05", "PRSLIB06", "PRSLIB07", "PRSLIB08", "PRSLIB09");
                    $offhead = Array("Scott Keller", "Barbara Waymire", "Gary Johnson", "Bill Still", "R.J. Harris", "Carl Person", "Roger Gary", "James Ogle", "Lee Wrights");
                    break;
                case "USS":
                    $divhead = "UNITED STATES SENATE";
                    $offarr = array("USSDEM01", "USSDEM02", "USSDEM03", "USSDEM04", "USSDEM05", "USSDEM06", "USSREP01", "USSREP02", "USSREP03", "USSREP04", "USSREP05", "USSREP06", "USSREP07", "USSREP08", "USSREP09", "USSREP10", "USSREP11", "USSREP12", "USSREP13", "USSREP14", "USSAIP01", "USSLIB01", "USSPAF01", "USSPAF02");
                    $offhead = array("Colleen Fernald", "Dianne Feinstein*", "David Levitt", "Nak Shah", "Diane Stewart", "Mike Strimling", "Robert Lauten", "Orly Taitz", "Donald Krampe", "Rick Williams", "Oscar Braun", "Dirk Konopik", "Nachum Shifren", "Greg Conlon", "Al Ramirez", "Rogelio T. Gloria", "Elizabeth Emken", "John Boruff", "Dan Hughes", "Dennis Jackson", "Don J. Grundmann", "Gail K. Lightfoot", "Marsha Feinland", "Kabiruddin Karim Ali");
                    break;
                case "P28":
                    $divhead = "PROP 28 - TERM LIMIT REFORM";
                    $offarr = array("PR_28_Y", "PR_28_N");
                    $offhead = array("YES", "NO");
                    break;
                case "P29":
                    $divhead = "PROP 29 - CIGARETTE TAX INCREASE";
                    $offarr = array("PR_29_Y", "PR_29_N");
                    $offhead = array("YES", "NO");
                    break;
            }
            break;


        case "g12":
            switch ($office) {
                case "P30":
                    $divhead = "PROP 30 - JERRY BROWN'S TAX INCREASE";
                    $offarr = array("PR_30_Y", "PR_30_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P31":
                    $divhead = "PROP 31 - MANDATE A 2-YEAR BUDGET CYCLE";
                    $offarr = array("PR_31_Y", "PR_31_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P32":
                    $divhead = "PROP 32 - UNION/CORPORATE CAMPAIGN FINANCE RESTRICTIONS";
                    $offarr = array("PR_32_Y", "PR_32_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P33":
                    $divhead = "PROP 33 - PERMIT AUTO INSURANCE PERSISTENCY DISCOUNTS";
                    $offarr = array("PR_33_Y", "PR_33_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P34":
                    $divhead = "PROP 34 - ELIMINATE DEATH PENALTY";
                    $offarr = array("PR_34_Y", "PR_34_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P35":
                    $divhead = "PROP 35 - INCREASE PENALTIES FOR HUMAN TRAFFICKING";
                    $offarr = array("PR_35_Y", "PR_35_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P36":
                    $divhead = "PROP 36 - MODIFICATION OF 3 STRIKES LAW";
                    $offarr = array("PR_36_Y", "PR_36_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P37":
                    $divhead = "PROP 37 - MANDATORY LABELING ON GMO FOOD";
                    $offarr = array("PR_37_Y", "PR_37_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P38":
                    $divhead = "PROP 38 - TAX INCREASE FOR EDUCATION";
                    $offarr = array("PR_38_Y", "PR_38_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P39":
                    $divhead = "PROP 39 - TAX INCREASE FOR MULTI-STATE BUSINESSES";
                    $offarr = array("PR_39_Y", "PR_39_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P40":
                    $divhead = "PROP 40 - REFERENDUM ON STATE REDISTRICTING PLAN";
                    $offarr = array("PR_40_Y", "PR_40_N");
                    $offhead = array("YES", "NO");
                    break;
                case "PRS":
                    $divhead = "PRESIDENT OF THE UNITED STATES";
                    $offarr = array("PRSDEM01", "PRSREP01", "PRSAIP01", "PRSGRN01", "PRSLIB01", "PRSPAF01");
                    $offhead = array("Barack Obama*", "Mitt Romney", "Thomas Hoefling", "Jill Stein", "Gary Johnson", "Roseanne Barr");
                    break;

                case "USS":
                    $divhead = "UNITED STATES SENATE";
                    $offarr = array("USSDEM01", "USSREP01");
                    $offhead = array("Dianne Feinstein*", "Elizabeth Emken");
                    break;
            }

            break;


        case "p14":

            switch ($office) {
                case "GOV":
                    $divhead = "GOVERNOR";
                    $offarr = array("GOVDEM01", "GOVDEM02", "GOVREP01", "GOVREP02", "GOVREP03", "GOVREP04", "GOVREP05", "GOVREP06", "GOVGRN01", "GOVPAF01", "GOVIND01", "GOVIND02", "GOVIND03", "GOVIND04", "GOVIND05");
                    $offhead = array("Akinyemi Agbede", "Edmund G. Brown*", "Glenn Champ", "Tim Donnelly", "Richard Aguirre", "Andrew Blount", "Neel Kashkari", "Alma Winston", "Luis Rodriguez", "Cindy Sheehan", "Robert Newman", "Rakesh Christian", "Bogdan Ambrozewicz", "Joe Leicht", "Janel Buycks");
                    break;
                case "LTG":
                    $divhead = "LT. GOVERNOR";
                    $offarr = array("LTGDEM01", "LTGDEM02", "LTGREP01", "LTGREP02", "LTGREP03", "LTGGRN01", "LTGPAF01", "LTGAME01");
                    $offhead = array("Eric Korevaar", "Gavin Newsom*", "George Yang", "David Fennell", "Ron Nehring", "Jena Goodman", "Amos Johnson", "Alan Reynolds");
                    break;
                case "ATG":
                    $divhead = "ATTORNEY GENERAL";
                    $offarr = array("ATGDEM01", "ATGREP01", "ATGREP02", "ATGREP03", "ATGREP04", "ATGLIB01", "ATGIND01");
                    $offhead = array("Kamala Harris*", "John Haggerty", "Phil Wyman", "David King", "Ronald Gold", "Jonathan Jaech", "Orly Taitz");
                    break;
                case "SOS":
                    $divhead = "SECRETARY OF STATE";
                    $offarr = array("SOSDEM01", "SOSDEM02", "SOSDEM03", "SOSDEM04", "SOSREP01", "SOSREP02", "SOSGRN01", "SOSIND01");
                    $offhead = array("Jeffrey Drobman", "Leland Yee", "Derek Cressman", "Alex Padilla", "Roy Allmond", "Pete Peterson", "David Curtis", "Dan Schnur");
                    break;
                case "TRS":
                    $divhead = "TREASURER";
                    $offarr = array("TRSDEM01", "TRSREP01", "TRSGRN01");
                    $offhead = array("John Chiang", "Greg Conlon", "Ellen Brown");
                    break;
                case "INS":
                    $divhead = "INSURANCE COMMISSIONER";
                    $offarr = array("INSDEM01", "INSREP01", "INSPAF01");
                    $offhead = array("Dave Jones*", "Ted Gaines", "Nathalie Hrizi");
                    break;
                case "CON":
                    $divhead = "CONTROLLER";
                    $offarr = array("CONDEM01", "CONDEM02", "CONDEM03", "CONREP01", "CONREP02", "CONGRN01");
                    $offhead = array("Betty Yee", "John Perez", "Tammy Blair", "David Evans", "Ashley Swearengin", "Laura Wells");
                    break;
                case "P41":
                    $divhead = "PROP 41 - VETERANS HOUSING BOND";
                    $offarr = array("PR_41_Y", "PR_41_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P42":
                    $divhead = "PROP 42 - LOCAL AGENCY PUBLIC RECORDS COMPLIANCE";
                    $offarr = array("PR_42_Y", "PR_42_N");
                    $offhead = array("YES", "NO");
                    break;
            }
            break;

        case "g14": {

            switch ($office) {
                case "P01":
                    $divhead = "PROP 1 - $7.2B WATER BOND";
                    $offarr = array("PR_1_Y", "PR_1_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P02":
                    $divhead = "PROP 2 - INCREASE SAVINGS IN RAINY DAY FUND";
                    $offarr = array("PR_2_Y", "PR_2_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P45":
                    $divhead = "PROP 45 - PUBLIC NOTICE FOR INSURANCE RATES";
                    $offarr = array("PR_45_Y", "PR_45_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P46":
                    $divhead = "PROP 46 - INCREASE CAP ON MEDICAL DAMAGES";
                    $offarr = array("PR_46_Y", "PR_46_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P47":
                    $divhead = "PROP 47 - CRIMINAL CODE REFORM";
                    $offarr = array("PR_47_Y", "PR_47_N");
                    $offhead = array("YES", "NO");
                    break;

                case "P48":
                    $divhead = "PROP 48 - RATIFICATION OF GAMING COMPACT";
                    $offarr = array("PR_48_Y", "PR_48_N");
                    $offhead = array("YES", "NO");
                    break;

                case "GOV":
                    $divhead = "GOVERNOR";
                    $offarr = array("GOVDEM01", "GOVREP01");
                    $offhead = array("Edmund G. Brown*", "Neel Kashkari");
                    break;

                case "LTG":
                    $divhead = "LT. GOVERNOR";
                    $offarr = array("LTGDEM01", "LTGREP01");
                    $offhead = array("Gavin Newsom", "Ron Nehring");
                    break;

                case "ATG":
                    $divhead = "ATTORNEY GENERAL";
                    $offarr = array("ATGDEM01", "ATGREP01");
                    $offhead = array("Kamala D. Harris*", "Ronald Gold");
                    break;

                case "SOS":
                    $divhead = "SECRETARY OF STATE";
                    $offarr = array("SOSDEM01", "SOSREP01");
                    $offhead = array("Alex Padilla", "Pete Peterson");
                    break;

                case "TRS":
                    $divhead = "TREASURER";
                    $offarr = array("TRSDEM01", "TRSREP01");
                    $offhead = array("John Chiang", "Greg Conlon");
                    break;

                case "CON":
                    $divhead = "CONTROLLER";
                    $offarr = array("CONDEM01", "CONREP01");
                    $offhead = array("Betty T. Yee", "Ashley Swearengin");
                    break;

                case "INS":
                    $divhead = "INSURANCE COMMISSIONER";
                    $offarr = array("INSDEM01", "INSREP01");
                    $offhead = array("Dave Jones*", "Ted Gaines");
                    break;

                case "BOE01":
                    $divhead = "BOARD OF EQUALIZATION - DISTRICT 1";
                    $offarr = array("BOE01DEM01", "BOE01REP01");
                    $offhead = array("Chris Parker", "George Runner*");
                    break;

                case "BOE02":
                    $divhead = "BOARD OF EQUALIZATION - DISTRICT 2";
                    $offarr = array("BOE02DEM01", "BOE02REP01");
                    $offhead = array("Fiona Ma", "James E. Theis");
                    break;

                case "BOE03":
                    $divhead = "BOARD OF EQUALIZATION - DISTRICT 3";
                    $offarr = array("BOE03DEM01", "BOE03REP01");
                    $offhead = array("Jerome E. Horton*", "G. Rick Marshall");
                    break;

                case "BOE04":
                    $divhead = "BOARD OF EQUALIZATION - DISTRICT 4";
                    $offarr = Array("BOE04DEM01", "BOE04REP01");
                    $offhead = Array("Nader Shahatit", "Diane L. Harkey");
                    break;

            }
        }
            break;

        case "g16": {
            switch ($office) {
                case "PRS":
                    $divhead = "PRESIDENT OF THE UNITED STATES";
                    $offarr = Array("PRSDEM01", "PRSREP01", "PRSLIB01", "PRSGRN01", "PRSPAF01");
                    $offhead = Array("Hillary Clinton", "Donald Trump", "Gary Johnson", "Jill Stein", "Gloria Estela La Riva");
                    break;
                case "USS":
                    $divhead = "UNITED STATES SENATE";
                    $offarr = Array("USSDEM01", "USSDEM02");
                    $offhead = Array("Kamala Harris", "Loretta Sanchez");
                    break;
                case "P51":
                    $divhead = "PROPOSITION 51 - K-12 & COMMUNITY COLLEGE CONSTRUCTION BOND";
                    $offarr = Array("PR_51_N", "PR_51_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P52":
                    $divhead = "PROPOSITION 52 - MEDI-CAL HOSPITAL FEE PROGRAM";
                    $offarr = Array("PR_52_N", "PR_52_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P53":
                    $divhead = "PROPOSITION 53 - VOTER APPROVAL OF REVENUE BONDS";
                    $offarr = Array("PR_53_N", "PR_53_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P54":
                    $divhead = "PROPOSITION 54 - LEGISLATIVE TRANSPARENCY ACT";
                    $offarr = Array("PR_54_N", "PR_54_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P55":
                    $divhead = "PROPOSITION 55 - PROP 30 TAX EXTENSION";
                    $offarr = Array("PR_55_N", "PR_55_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P56":
                    $divhead = "PROPOSITION 56 - CIGARETTE TAX";
                    $offarr = Array("PR_56_N", "PR_56_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P57":
                    $divhead = "PROPOSITION 57 - PAROLE REFORM/JUVENILE CRIME PROCEEDINGS";
                    $offarr = Array("PR_57_N", "PR_57_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P58":
                    $divhead = "PROPOSITION 58 - ENGLISH PROFICIENCY, MULTILINGUAL EDUCATION";
                    $offarr = Array("PR_58_N", "PR_58_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P59":
                    $divhead = "PROPOSITION 59 - CITIZENS UNITED ADVISORY QUESTION";
                    $offarr = Array("PR_59_N", "PR_59_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P60":
                    $divhead = "PROPOSITION 60 - ADULT FILM CONDOM REQUIREMENTS";
                    $offarr = Array("PR_60_N", "PR_60_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P61":
                    $divhead = "PROPOSITION 61 - PRESCRIPTION DRUG PRICE CONTROLS";
                    $offarr = Array("PR_61_N", "PR_61_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P62":
                    $divhead = "PROPOSITION 62 - DEATH PENALTY REPEAL";
                    $offarr = Array("PR_62_N", "PR_62_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P63":
                    $divhead = "PROPOSITION 63 - RESTRICTIONS ON FIREARMS AND AMMUNITION SALES";
                    $offarr = Array("PR_63_N", "PR_63_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P64":
                    $divhead = "PROPOSITION 64 - MARIJUANA LEGALIZATION";
                    $offarr = Array("PR_64_N", "PR_64_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P65":
                    $divhead = "PROPOSITION 65 - DIVERT PROCEEDS OF CARRYOUT BAG FEES FROM RETAILERS";
                    $offarr = Array("PR_65_N", "PR_66_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P66":
                    $divhead = "PROPOSITION 66 - STRENGTHEN/STREAMLINE DEATH PENALTY";
                    $offarr = Array("PR_66_N", "PR_66_Y");
                    $offhead = Array("NO", "YES");
                    break;
                case "P67":
                    $divhead = "PROPOSITION 67 - SINGLE-USE PLASTIC BAG BAN REFERENDUM";
                    $offarr = Array("PR_67_N", "PR_67_Y");
                    $offhead = Array("NO", "YES");
                    break;
            }
        }
            break;

        case "p16": {

            switch ($office) {

                case "PRSDEM":
                    $divhead = "DEMOCRATIC PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSDEM01", "PRSDEM02", "PRSDEM03", "PRSDEM04", "PRSDEM05", "PRSDEM06", "PRSDEM07");
                    $offhead = Array("Hillary Clinton", "Bernie Sanders", "Roque De La Fuente", "Henry Hewes", "Keith Judd", "Michael Steinberg", "Willie Wilson");
                    break;
                case "PRSREP":
                    $divhead = "REPUBLICAN PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSREP01", "PRSREP02", "PRSREP03", "PRSREP04", "PRSREP05");
                    $offhead = Array("Ben Carson", "Ted Cruz", "John Kasich", "Donald Trump", "Jim Gilmore");
                    break;
                case "PRSAIP":
                    $divhead = "AMERICAN INDEPENDENT PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSAIP01", "PRSAIP02", "PRSAIP03", "PRSAIP04", "PRSAIP05", "PRSAIP06", "PRSAIP07");
                    $offhead = Array("Alan Spears", "Arthur Harris", "J.R. Meyers", "James Hedges", "Robert Ornelas", "Thomas Hoefling", "Wiley Drake");
                    break;
                case "PRSGRN":
                    $divhead = "GREEN PARTY PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSGRN01", "PRSGRN02", "PRSGRN03", "PRSGRN04", "PRSGRN05");
                    $offhead = Array("Darryl Cherney", "William Kreml", "Kent Mesplay", "Jill Stein", "Sedinam Moyowasifsa-Curry");
                    break;
                case "PRSLIB":
                    $divhead = "LIBERTARIAN PRESIDENTIAL PRIMARY";
                    $offarr = Array("PRSLIB01", "PRSLIB02", "PRSLIB03", "PRSLIB04", "PRSLIB05", "PRSLIB06", "PRSLIB07", "PRSLIB08", "PRSLIB09", "PRSLIB10", "PRSLIB11", "PRSLIB12");
                    $offhead = Array("Gary Johnson", "John McAfee", "Marc Feldman", "Cecil Ince", "Steve Kerbel", "Darryl W. Perry", "Austin Petersen", "Derrick M. Reid", "Rhett White Feather Smith", "Joy Waymire", "John Hale", "Jack Robinson, Jr.");
                    break;
                case "USS":
                    $divhead = "UNITED STATES SENATE";
                    $offarr = Array("USSDEM01", "USSDEM02", "USSDEM03", "USSDEM04", "USSDEM05", "USSDEM06", "USSDEM07", "USSGRN01", "USSIND01", "USSIND02", "USSIND03",
                        "USSIND04", "USSIND05", "USSIND06", "USSIND07", "USSIND08", "USSIND09", "USSIND10", "USSIND11", "USSLIB01", "USSLIB02", "USSPAF01",
                        "USSREP01", "USSREP02", "USSREP03", "USSREP04", "USSREP05", "USSREP06", "USSREP07", "USSREP08", "USSREP09", "USSREP10", "USSREP11", "USSREP12");
                    $offhead = Array("President Cristina Grappo", "Herbert G. Peters", "Steve Stokes", "Loretta L. Sanchez", "Kamala D. Harris", "Massie Munroe", "Emory Rodgers",
                        "Pamela Elizondo", "Jason Kraus", "Paul Merritt", "Ling Ling Shi", "Tim Gildersleeve", "Don J. Grundmann", "Jason Hannaia", "Mike Beitks", "Eleanor Garcia",
                        "Clive Grey", "Gar Myers", "Scott Vineberg", "Gail Lightfoot", "Mark Matthew Herd", "John Thompson Parker", "George C. Yang", "Jerry J. Laws", "Jarrell Williams",
                        "Thomas G. Del Beccaro", "Karen Roseberry", "Don Krambe", "Duf Sundheim", "Greg Conlon", "Von Hougo", "Tom Palzer", "Phil Wyman", "Ron Unz");
                    break;
                case "P50":
                    $divhead = "PROPOSITION 50 - SUSPENDING LEGISLATORS";
                    $offarr = Array("PR_50_N", "PR_50_Y");
                    $offhead = Array("NO", "YES");
                    break;
            }
        }
            break;
    }

    $masterfourcode = $fourcode;

    foreach ($offarr as $value) {
        $x = getsum($masterfourcode, $elec, $value);
        $y += $x;
        array_push($offres, $x);
    }

    $x = 0;
    $pctvote = "";

    foreach ($offres as $value) {
        $pctvote = calcpct($value, $y);
        array_push($offpct, $pctvote);
        $x++;
    }

    $x = 0;


    //echo("<br>DUMPING $offres for $divhead<br>");
    if ($offres[1] || $offres[2]) {
        echo("<div class='rescont'><p>" . $divhead . "</p>");
        foreach ($offarr as $value) {
            if (mb_substr($value, 0, 2) != "PR" || mb_substr($value, 0, 3) == "PRS") {
                $party = mb_substr($value, 3, 3);
            }

            if (mb_substr($value, 0, 3) == "BOE") {
                $party = mb_substr($value, 5, 3);
            }

            if (substr($offhead[$x], -1) == "*") {
                $party = $party . "-INC";
            }

            echo("<div class='indresult'><div class='candidatename'>" . $offhead[$x] . "</div><div class='candidateparty'>" . $party . "</div><div class='candidatevotes'>" . $offres[$x + 1] . "</div><div class = 'candidatepct'>" . $offpct[$x + 2] . "</div></div>");
            $x++;
        }

        echo("</div>");
    }

}

function parseoffices($qdist, $dist, $elec)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $sqltemp = array();

    $sqltemp[0] = "SELECT county AS distnum FROM ctb2016_" . $elec . " WHERE " . $qdist . " = " . $dist . " GROUP BY county";
    $sqltemp[1] = "SELECT addist AS distnum FROM ctb2016_" . $elec . " WHERE " . $qdist . " = " . $dist . " GROUP BY addist";
    $sqltemp[2] = "SELECT cddist AS distnum FROM ctb2016_" . $elec . " WHERE " . $qdist . " = " . $dist . " GROUP BY cddist";
    $sqltemp[3] = "SELECT sddist AS distnum FROM ctb2016_" . $elec . " WHERE " . $qdist . " = " . $dist . " GROUP BY sddist";
    $sqltemp[4] = "SELECT bedist AS distnum FROM ctb2016_" . $elec . " WHERE " . $qdist . " = " . $dist . " GROUP BY bedist";

    $sqlhead = array("county", "addist", "cddist", "sddist", "bedist");
    $arraytemp = array();
    $arrayfinal = array();
    $i = 1;
    $j = 0;

    foreach ($sqltemp as $value) {
        //echo("value: " . $value);
        $result = $conn->query($value);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($i <> 0) {
                    $retval = $row["distnum"];
                    $x = (substr($value, -6));
                    $xx = $x . " = " . $retval;
                    array_push($arrayfinal, $xx);
                }
                $i++;
            }
        }
    }

    return $arrayfinal;

}


function getracekeys($x, $qdist, $elec)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    if (mb_substr($x, 0, 1) == "E") {
        $x = mb_substr($x, 1, 1);
    }

    $sql = "SELECT distkey FROM ctb2016_candidates where disttype = '" . $qdist . "' && distnum = " . $x . " && election = '" . $elec . "'";
    $retarray = Array();

    $result = $conn->query($sql);
    $i = 0;
    $retval = "";
    $i++;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $retval = $row["distkey"];
                array_push($retarray, $retval);
            }
            $i++;
        }
    } else {
        $retval = "0 results";
    }

    //echo("i:" . $i . " retval:" . $retval);
    return $retarray;

}


function getdisclaimer($qelec, $qrep, $fourcode)
{

    if ($qrep == "vdetail") {

        switch ($qelec) {
            case "p14":
                $disclaimer = "*Odd-numbered Senate Districts were not up for election in 2014 and will show blank results.";
                break;
            case "g14":
                $disclaimer = "*Odd-numbered Senate Districts were not up for election in 2014 and will show blank results.";
                break;
            case "p12":
                $disclaimer = "*Even-numbered Senate Districts were not up for election in 2012/2016 and will show blank results.";
                break;
            case "g12":
                $disclaimer = "*Even-numbered Senate Districts were not up for election in 2012/2016 and will show blank results.";
        }
    } else {

        switch ($qelec) {
            case "p14":
                $affected = Array("AD02", "AD04", "AD05", "AD11", "AD14", "SD02", "SD03", "SD08", "CD02", "CD03", "CD04", "CD08");
                foreach ($affected as $value) {
                    if ($value == $fourcode) {
                        $disclaimer = "Data shown for " . $fourcode . " should be regarded as having incomplete data due to the following counties failing to report their full data for this election:  Amador (21,200 registered voters), Del Norte (12,398 registered voters), Mono (5,802 registered voters), and Solano (201,728 registered voters).";
                    }
                }
                break;
            case "g14":
                $affected = Array("AD05", "SD08", "CD05");
                foreach ($affected as $value) {
                    if ($value == $fourcode) {
                        $disclaimer = "Data shown for " . $fourcode . " should be regarded as having incomplete data due to Tuolumne County (29,274 registered voters) failing to report its full data for this election.";
                    }
                }
                break;
            case "p12":
                $affected = Array("AD02", "SD02", "CD02");
                foreach ($affected as $value) {
                    if ($value == $fourcode) {
                        $disclaimer = "Data shown for " . $fourcode . " should be regarded as having incomplete data due to Del Norte County (11,815 registered voters) failing to report its full data for this election.";
                    }
                }
                break;
            case "g12":
                $disclaimer = "";

        }

    }

    //$disclaimer = $disclaimer . "<br>Data compiled by Rob Pyers exclusively for the California Target Book";

    return $disclaimer;
}

function getvotebysubdist($maindist, $subdist, $longkey, $qelec)
{

    global $ctb2016_conn;
     $conn = Util::get_ctb_conn();


    //echo("Main District: " . $maindist . " SubDistrict: " . $subdist . " LongKey:" . $longkey . " Election:" . $qelec);
    $shortkey = shortenkey($longkey);

    $qdistmain = tophalf($maindist);
    $distmain = bothalf($maindist);

    $qdistsub = tophalf($subdist);
    $distsub = bothalf($subdist);

    $sql = "SELECT SUM(" . $shortkey . ") AS TOTAL FROM ctb2016_" . $qelec . " WHERE " . $qdistmain . " = " . $distmain . " && " . $qdistsub . " = " . $distsub;

    //echo($sql);

    $result = $conn->query($sql);

    $i = 1;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $retval = $row["TOTAL"];
                //echo($retval . " ");
            }
            $i++;
        }
    } else {
        $retval = "0 results";
    }

    //echo("i:" . $i . " retval:" . $retval);
    return $retval;

    //$sql = "SELECT SUM(ASSDEM01) AS TOTAL FROM 'p12' WHERE addist = 1 && sddist = 1"

}


function expandkey($shortkey, $dist)
{
    $x = mb_substr($shortkey, 0, 3);
    $y = mb_substr($shortkey, 3, 5);

    if (strlen($dist) == 1) {
        $z = checkaddzero($dist);
    } else {
        $z = $dist;
    }

    $retval = $x . $z . $y;

    return $retval;
}

function shortenkey($x)
{
    //echo("Longkey:" .  $x);

    $z = mb_substr($x, 5, 5);
    $y = mb_substr($x, 0, 3);

    //echo("z:" . $z . " y:". $y);

    $result = $y . $z;

    // echo("Shortkey:" . $result);

    return $result;
}

function gethead($x)
{
    $z = mb_substr($x, 2, 2);
    $y = mb_substr($x, 0, 2);

    switch ($y) {
        case "AD":
            $retval = "CALIFORNIA ASSEMBLY - DISTRICT " . $z;
            break;
        case "CD":
            $retval = "UNITED STATES CONGRESS - DISTRICT " . $z;
            break;
        case "SD":
            $retval = "CALIFORNIA STATE SENATE - DISTRICT " . $z;
            break;
        case "BO":
            $retval = "BOARD OF EQUALIZATION - DISTRICT " . mb_substr($x, 3, 1);
            break;
        default:
            $retval = "NOTHING LISTED";
            break;
    }

    return $retval;
}

function getnamefromkey($race, $elec)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT name FROM ctb2016_candidates WHERE election = '" . $elec . "' && race = '" . $race . "'";
    $result = $conn->query($sql);
    $i = 0;
    $retval = "";
    $i++;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($i <> 0) {
                $retval = $row["name"];
            }
            $i++;
        }
    } else {
        $retval = "0 results";
    }

    //echo("i:" . $i . " retval:" . $retval);
    return $retval;
}


function tophalf($x)
{
    if (strlen($x) == 4) {
        $retval = mb_substr($x, 0, 2);
    } else {
        $retval = "county";
    }

    switch ($retval) {
        case "AD":
            $retval = "addist";
            break;
        case "SD":
            $retval = "sddist";
            break;
        case "CD":
            $retval = "cddist";
            break;
        case "BO":
            $retval = "bedist";
            break;
        case "CO":
            $retval = "county";
        default:
            $retval = "county";
            break;
    }

    return $retval;
}

function bothalf($x)
{
    if (strlen($x) == 4) {
        $retval = mb_substr($x, 2, 2);
    } else {
        $retval = "county";
    }

    return $retval;
}

function makefour($qdist, $dist)
{
    $tophalf = mb_substr(strtoupper($qdist), 0, 2);
    if (strlen($dist) != 2) {
        $bothalf = checkaddzero($dist);
    } else {
        $bothalf = $dist;
    }

    $retval = $tophalf . $bothalf;

    if (mb_substr($qdist, 0, 2) == "be") {
        $retval = "BOE" . stripzero($dist);
    }

    return $retval;
}


function calcpct($x, $y)
{
    return sprintf("%.2f%%", ($x / $y) * 100); //    CALCULATE PERCENTAGE OF TWO NUMBERS, RETURN RESULT ROUNDED TO TWO DECIMAL POINTS
}

function drawelection($x, $election)
{
    global $racetotals;

    $tablehead = "
		<div class='newseg' style='float: left; width: 400px;'>
			<table>
				<thead>
					<tr>
						<th>VOTES</th>
						<th>PCT</th>
						<th>NAME</th>
						<th>PARTY</th>
						<th>INCUMBENT</th>
					</tr>
				</thead>
				<tbody>

	";
    foreach ($x as $result) {

        $thisrace = $result['FOURCODE'];

        if ($thisrace != $lastrace && $lastrace) {
            $table .= "</tbody></table></div>$tablehead";
        } elseif (!$lastrace) {
            $table .= "<div class='newseg'>$tablehead";
        }
        $table .= "
					<tr>
						<td>" . $result['VOTES'] . "</td>
						<td>" . makepct($result['VOTES'], $racetotals[$election][$result['FOURCODE']]) . "</td>
						<td>" . $result['NAME'] . "</td>
						<td>" . $result['PARTY'] . "</td>
						<td>" . $result['INC'] . "</td>
					</tr>
		";

        $lastrace = $thisrace;
    }
    $closetable = "</tbody></table></div>";

    echo($tablehead . $table . $closetable);
}

function drawethnictable($x)
{

    $tablehead = "<div class='newseg'>
		<table class='bordered'>
			<thead>
				<tr>
					<th>ETHNICITY</th>
					<th>REG D</th>
					<th>VOTING D</th>
					<th>TURNOUT</th>
					<th>STW TURNOUT</th>
					<th>REG R</th>
					<th>VOTING R</th>
					<th>TURNOUT</th>
					<th>STW TURNOUT</th>
					<th>REG NPP</th>
					<th>VOTING NPP</th>
					<th>TURNOUT</th>
					<th>STW TURNOUT</th>
					<th>REG OTHER</th>
					<th>VOTING OTH</th>
					<th>TURNOUT</th>
					<th>STW TURNOUT</th>
					<th>TOTAL GRP REG</th>
					<th>TOTAL GRP VOTE</th>
					<th>TOTAL GRP TURNOUT</th>
				</tr>
			</thead>
			<tbody>
	";

    $i = 0;
    $table = '';
    foreach ($x as $ethnicgrp) {
        if ($i > 0) {
            $table .= "

		<td>" . $tempreg . "</td>
		<td>" . $tempvote . "</td>
		<td>" . makepct($tempvote, $tempreg) . "</td>
		</tr><tr><td>" . $ethnicgrp[0]['ETHNICITY'] . "</td>";
        } else {
            $table .= "<tr><td>" . $ethnicgrp[0]['ETHNICITY'] . "</td>";
        }
        $tempreg = 0;
        $tempvote = 0;
        foreach ($ethnicgrp as $entry) {
            $table .= "
			<td>" . $entry['REGISTERED'] . "</td>
			<td>" . $entry['VOTED'] . "</td>
			<td>" . makepct($entry['VOTED'], $entry['REGISTERED']) . "</td>
			<td>" . makepct($entry['STW_VOTED'], $entry['STW_REGISTERED']) . "</td>
		";
            $tempreg += $entry['REGISTERED'];
            $tempvote += $entry['VOTED'];

        }
        $i++;
    }

    $tableend = "

		<td>" . $tempreg . "</td>
		<td>" . $tempvote . "</td>
		<td>" . makepct($tempvote, $tempreg) . "</td>
		</tr>

</tbody></table></div>";

    echo($tablehead . $table . $tableend);

}

function getelection($fourcode, $election)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    global $racetotals;

    $electionresults = Array();

    $statewideraces = getstatewideheaders($election);
    $subdistricts = getsubdistricts($fourcode);

    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];

    foreach ($statewideraces as $race) {
        $sql = "SELECT SUM(" . $race['distkey'] . ") AS VOTES FROM ctb2016_$election WHERE $disttype = '$distno'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['VOTES'] = $row['VOTES'];
                $tmp['NAME'] = $race['name'];
                $tmp['PARTY'] = $race['party'];
                $tmp['INC'] = $race['is_incumbent'];
                $tmp['RACE'] = $race['race'];
                $tmp['FOURCODE'] = makestatewide($tmp['RACE']);
                $thisfourcode = $tmp['FOURCODE'];
                $racetotals[$election][$thisfourcode] += $tmp['VOTES'];
                array_push($electionresults, $tmp);
            }
        }
    }

    foreach ($subdistricts as $race) {
        $x = getsubdistrictvote($fourcode, $race['fourcode'], $election);
        foreach ($x as $result) {
            $tmp['VOTES'] = $result['VOTES'];
            $tmp['NAME'] = $result['NAME'];
            $tmp['PARTY'] = $result['PARTY'];
            $tmp['INC'] = $result['INC'];
            $tmp['RACE'] = $result['RACE'];
            $tmp['FOURCODE'] = $result['FOURCODE'];
            $thisfourcode = $tmp['FOURCODE'];
            $racetotals[$election][$thisfourcode] += $tmp['VOTES'];
            array_push($electionresults, $tmp);
        }
    }

    return $electionresults;
}

function getstatewideheaders($election)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $sql = "SELECT * FROM ctb2016_candidates WHERE election = '$election' && disttype = ''";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['race'] = $row['race'];
            if (mb_substr($row['distkey'], 0, 3) == "PR_" || $election == "p12") {
                $tmp['distkey'] = $row['race'];
            } else {
                $tmp['distkey'] = $row['distkey'];
            }
            $tmp['name'] = $row['name'];
            $tmp['party'] = $row['party'];
            $tmp['is_incumbent'] = $row['is_incumbent'];
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function stripzero($number)
{
    $number = ltrim($number, '0');
    $number = ltrim($number, 'E');

    return $number;
}

function getdisttype($fourcode)
{

    $retval = Array();
    $type = mb_substr($fourcode, 0, 2);
    switch ($type) {
        case "CD":
            $disttype = "cddist";
            break;
        case "BO":
            $disttype = "bedist";
            break;
        case "AD":
            $disttype = "addist";
            break;
        case "SD":
            $disttype = "sddist";
            break;
        case "CO":
            $disttype = "county";
            break;
        default:
            $disttype = '';
            break;
    }

    $no = mb_substr($fourcode, 2, 2);
    $no = stripzero($no);


    $retval['disttype'] = $disttype;
    $retval['distno'] = $no;

    return $retval;


}

function getsubdistricts($fourcode)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $x = getdisttype($fourcode);
    $basetype = $x['disttype'];
    $distno = $x['distno'];
    $elec = "g12";

    $sqltemp = array();
    $tmp = Array();
    $retval = Array();

    $sqltemp[0] = "SELECT county AS distnum FROM ctb2016_" . $elec . " WHERE " . $basetype . " = " . $distno . " GROUP BY county";
    $sqltemp[1] = "SELECT addist AS distnum FROM ctb2016_" . $elec . " WHERE " . $basetype . " = " . $distno . " GROUP BY addist";
    $sqltemp[2] = "SELECT cddist AS distnum FROM ctb2016_" . $elec . " WHERE " . $basetype . " = " . $distno . " GROUP BY cddist";
    $sqltemp[3] = "SELECT sddist AS distnum FROM ctb2016_" . $elec . " WHERE " . $basetype . " = " . $distno . " GROUP BY sddist";
    $sqltemp[4] = "SELECT bedist AS distnum FROM ctb2016_" . $elec . " WHERE " . $basetype . " = " . $distno . " GROUP BY bedist";

    foreach ($sqltemp as $sql) {
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['disttype'] = substr($sql, -6);
                $tmp['distno'] = $row['distnum'];
                $tmp['fourcode'] = makefourcode($tmp['disttype'], $tmp['distno']);
                array_push($retval, $tmp);
            }
        }
    }

    return $retval;
}

function makefourcode($disttype, $distno)
{
    switch ($disttype) {
        case "county":
            $retval = "CO" . checkaddzero($distno);
            break;
        case "cddist":
            $retval = "CD" . checkaddzero($distno);
            break;
        case "addist":
            $retval = "AD" . checkaddzero($distno);
            break;
        case "sddist":
            $retval = "SD" . checkaddzero($distno);
            break;
        case "bedist":
            $retval = "BOE" . stripzero($distno);
            break;
        default:
            $retval = "";
            break;
    }

    return $retval;
}

function get_first_number($str)
{
    preg_match_all('/\d+/', $str, $matches);
    $retval = $matches[0][0];

    return $retval;
}

function makestatewide($race)
{
    $firstthree = mb_substr($race, 0, 3);

    switch ($firstthree) {
        case "PRS":
            $retval = ".PRS";
            break;
        case "USS":
            $retval = ".SEN";
            break;
        case "ATG":
            $retval = ".ATG";
            break;
        case "BOE":
            $retval = "BOE" . mb_substr($race, 4, 1);
            break;
        case "CON":
            $retval = ".CON";
            break;
        case "GOV":
            $retval = ".GOV";
            break;
        case "INS":
            $retval = ".INS";
            break;
        case "LTG":
            $retval = ".LTG";
            break;
        case "SPI":
            $retval = ".SPI";
            break;
        case "SOS":
            $retval = ".SOS";
            break;
        case "TRS":
            $retval = ".TRS";
            break;
        default:
            $retval = '';
            break;
    }

    if (!$retval && $firstthree == "PR_") {
        //MAKE PROPOSITION
        $number = get_first_number($race);
        $number = checkaddzero($number);
        $retval = ".P" . $number;
    }

    return $retval;
}

function getsubdistrictvote($maindist, $subdist, $election)
{
    global $ctb2016_conn;
    $conn = $ctb2016_conn;
    $retval = Array();

    $x = getraceheaders($subdist, $election);
    $d1 = getdisttype($maindist);
    $d2 = getdisttype($subdist);

    $maintype = $d1['disttype'];
    $mainno = $d1['distno'];
    $subtype = $d2['disttype'];
    $subno = $d2['distno'];

    foreach ($x as $candidate) {
        $sql = "SELECT SUM(" . $candidate['distkey'] . ") AS VOTES FROM $election WHERE $maintype = '$mainno' && $subtype = '$subno'";
        $results = $conn->query($sql);
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                $tmp['VOTES'] = $row['VOTES'];
                $tmp['NAME'] = $candidate['name'];
                $tmp['PARTY'] = $candidate['party'];
                $tmp['INC'] = $candidate['is_incumbent'];
                $tmp['RACE'] = $candidate['race'];
                $tmp['FOURCODE'] = $candidate['fourcode'];
                array_push($retval, $tmp);
            }
        }
    }

    return $retval;


}

function getraceheaders($fourcode, $election)
{

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $x = getdisttype($fourcode);
    $disttype = $x['disttype'];
    $distno = $x['distno'];

    $sql = "SELECT * FROM ctb2016_candidates WHERE disttype = '$disttype' && distnum = '$distno' && election = '$election'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['distkey'] = $row['distkey'];
            $tmp['race'] = $row['race'];
            $tmp['name'] = $row['name'];
            $tmp['party'] = $row['party'];
            $tmp['is_incumbent'] = $row['is_incumbent'];
            $tmp['fourcode'] = $fourcode;
            array_push($retval, $tmp);
        }
    }

    return $retval;

}

function getturnout($fourcode, $class, $election)
{
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    if ($fourcode != "STW") {
        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];

        $sql = "SELECT SUM(r$class) AS REGISTERED, sum($class) AS VOTED FROM ctb2016_$election WHERE $disttype = '$distno'";
    } else {
        $sql = "SELECT SUM(r$class) AS REGISTERED, SUM($class) AS VOTED FROM ctb2016_$election";
    }

    //echo("<br>$sql</br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval['REGISTERED'] = $row['REGISTERED'];
            $retval['VOTED'] = $row['VOTED'];
            $retval['CLASS'] = $class;
            $retval['ELECTION'] = $election;
        }
    }

    return $retval;
}

function getallages($fourcode, $election)
{
    global $ctb2016_conn;
    $conn = $ctb2016_conn;
    $retval = Array();

    $ages = Array("UNK", "1824", "2534", "3544", "4554", "5564", "65PL");
    $sexes = Array("M", "F");
    $parties = Array("DEM", "REP", "DCL", "OTH");

    foreach ($parties as $party) {
        foreach ($ages as $agegroup) {
            foreach ($sexes as $sex) {
                $class = $party . $sex . $agegroup;
                $x = getturnout($fourcode, $class, $election);
                array_push($retval, $x);
            }
        }
    }

    return $retval;
}


/*

MMMMMMMM               MMMMMMMM  iiii
M:::::::M             M:::::::M i::::i
M::::::::M           M::::::::M  iiii
M:::::::::M         M:::::::::M
M::::::::::M       M::::::::::Miiiiiii     ssssssssss       cccccccccccccccc
M:::::::::::M     M:::::::::::Mi:::::i   ss::::::::::s    cc:::::::::::::::c
M:::::::M::::M   M::::M:::::::M i::::i ss:::::::::::::s  c:::::::::::::::::c
M::::::M M::::M M::::M M::::::M i::::i s::::::ssss:::::sc:::::::cccccc:::::c
M::::::M  M::::M::::M  M::::::M i::::i  s:::::s  ssssss c::::::c     ccccccc
M::::::M   M:::::::M   M::::::M i::::i    s::::::s      c:::::c
M::::::M    M:::::M    M::::::M i::::i       s::::::s   c:::::c
M::::::M     MMMMM     M::::::M i::::i ssssss   s:::::s c::::::c     ccccccc
M::::::M               M::::::Mi::::::is:::::ssss::::::sc:::::::cccccc:::::c
M::::::M               M::::::Mi::::::is::::::::::::::s  c:::::::::::::::::c
M::::::M               M::::::Mi::::::i s:::::::::::ss    cc:::::::::::::::c
MMMMMMMM               MMMMMMMMiiiiiiii  sssssssssss        cccccccccccccccc

*/


function get_first($string)
{
    $arr = explode(' ', trim($string));

    return ($arr[0]);
}

function get_last($string)
{
    $arr = explode(' ', trim($string));
    $retval = array_pop($arr);

    return $retval;
}

function seems_utf8($str)
{
    $length = strlen($str);
    for ($i = 0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80) $n = 0; # 0bbbbbbb
        elseif (($c & 0xE0) == 0xC0) $n = 1; # 110bbbbb
        elseif (($c & 0xF0) == 0xE0) $n = 2; # 1110bbbb
        elseif (($c & 0xF8) == 0xF0) $n = 3; # 11110bbb
        elseif (($c & 0xFC) == 0xF8) $n = 4; # 111110bb
        elseif (($c & 0xFE) == 0xFC) $n = 5; # 1111110b
        else return false; # Does not match any model
        for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                return false;
        }
    }

    return true;
}

function remove_accents($string)
{
    if (!preg_match('/[\x80-\xff]/', $string))
        return $string;

    if (seems_utf8($string)) {
        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
            // Euro Sign
            chr(226) . chr(130) . chr(172) => 'E',
            // GBP (Pound) Sign
            chr(194) . chr(163) => '');

        $string = strtr($string, $chars);
    } else {
        // Assume ISO-8859-1 if not UTF-8
        $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
            . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
            . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
            . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
            . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
            . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
            . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
            . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
            . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
            . chr(252) . chr(253) . chr(255);

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}

function getquarterinfo($date)
{
    $retval = Array();
    if ($date > "2015-01-00" && $date < "2015-04-01") {
        $retval['YEAR'] = "2015";
        $retval['QUARTER'] = "Q1";
    } elseif ($date > "2015-03-31" && $date < "2015-07-01") {
        $retval['YEAR'] = "2015";
        $retval['QUARTER'] = "Q2";
    } elseif ($date > "2015-06-30" && $date < "2015-10-01") {
        $retval['YEAR'] = "2015";
        $retval['QUARTER'] = "Q3";
    } elseif ($date > "2015-09-30" && $date < "2016-01-01") {
        $retval['YEAR'] = "2015";
        $retval['QUARTER'] = "Q4";
    } elseif ($date > "2016-01-00" && $date < "2016-04-01") {
        $retval['YEAR'] = "2016";
        $retval['QUARTER'] = "Q1";
    } elseif ($date > "2016-03-31" && $date < "2016-07-01") {
        $retval['YEAR'] = "2016";
        $retval['QUARTER'] = "Q2";
    } elseif ($date > "2016-06-30" && $date < "2016-10-01") {
        $retval['YEAR'] = "2016";
        $retval['QUARTER'] = "Q3";
    } else {
        $retval['YEAR'] = "2016";
        $retval['QUARTER'] = "Q4";
    }

    return $retval;
}

function checkaddzero($x)
{

    $x = preg_replace('/\s+/', '', $x);
    if ($x < 10 && strlen($x) == 1) {            // Add on a leading zero for Districts
        $addzero = "0" . $x;
    } else {
        $addzero = "" . $x;
    };

    return $addzero;
}

function getcountyname($x)
{
    $countyname = array("Alameda", "Alpine", "Amador", "Butte", "Calaveras", "Colusa", "Contra Costa", "Del Norte", "El Dorado", "Fresno", "Glenn", "Humboldt", "Imperial", "Inyo", "Kern", "Kings", "Lake", "Lassen", "Los Angeles", "Madera", "Marin", "Mariposa", "Mendocino", "Merced", "Modoc", "Mono", "Monterey", "Napa", "Nevada", "Orange", "Placer", "Plumas", "Riverside", "Sacramento", "San Benito", "San Bernardino", "San Diego", "San Francisco", "San Joaquin", "San Luis Obispo", "San Mateo", "Santa Barbara", "Santa Clara", "Santa Cruz", "Shasta", "Sierra", "Siskiyou", "Solano", "Sonoma", "Stanislaus", "Sutter", "Tehama", "Trinity", "Tulare", "Tuolumne", "Ventura", "Yolo", "Yuba");

    return $countyname[$x - 1];
}

function makepct($piece, $total)
{
    if($total) {
	    $pct = ($piece / $total) * 100;
	    return (number_format($pct, 2) . "%");
    } else {
	return 0;
    }

}

function fullnum($x)
{
    $tmp = $x * 100;
    $rm = $tmp % 100;
    if ($rm) {
        $rm = $tmp % 10;
        if ($rm) {
            //DO NOTHING
        } else {
            $value = "0";
        }

    } else {
        $value = ".00";
    }

    return $value;

}

?>
