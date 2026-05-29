<?php
/*
multi_search.php

This PHP script takes a JSON input string that contains the following recognized parameters

@scope (fec, fppc, netfile, ctb)
@search_type (contributor, vendor, treasurer, cand_nm, cmte_nm, cmte_list, dns)
@county
@city
@zip
@name
@start
@end 
@cmte_id

then queries the appropriate database, returning the results in a $response variable that is JSON encoded and echoed back

{"scope":"fec","type":"contributor","name":"1","city":"2","state":"3","zip":"4"}{"scope":"fec","type":"contributor","name":"1","city":"2","state":"3","zip":"4"}
*/

global $response;

require_once('php/ctb_api.php');
ini_set('memory_limit', '4048M');
set_time_limit(0);

$json_str = $_GET['q'] ?? '';
$json_str = str_replace("formData=", "", $json_str);
$json_str = urldecode($json_str);
$arr = json_decode($json_str, true) ?? [];

switch ($arr['scope'] ?? '') {
    case "fec":
        fec_search($arr);
        break;
    case "fppc":
        fppc_search($arr);
        break;
    case "netfile":
        netfile_search($arr);
        break;
    case "ctb":
        ctb_search($arr);
        break;
}

$response['json_input'] = $json_str;
$json = json_encode($response);
$compressed_json = gzencode($json);

// Set appropriate headers for compressed response
header('Content-Encoding: gzip');
header('Content-Length: ' . strlen($compressed_json));
header('Content-type: application/json');

// Output the compressed JSON response
echo $compressed_json;

function fec_search(array $arr): void {
    global $response;
    switch ($arr['type'] ?? '') {
        case "contributor":
            fec_contributor($arr);
            break;
        case "vendor":
            fec_vendor($arr);
            break;
        case "treasurer":
            fec_treasurer($arr);
            break;
    }
    $response['scope'] = "fec";
}

function fec_contributor(array $arr): void {
    global $response;
    $response['type'] = "contributor";
    $conn = Util::get_ctb_conn();

    $q_city = "";
    $q_state = "";
    $q_zip = "";

    if (!empty($arr['city'] ?? '')) {
        $q_city = " && CITY LIKE \"" . $arr['city'] . "\" ";
    }

    if (!empty($arr['state'] ?? '')) {
        $q_state = " && STATE = \"" . $arr['state'] . "\" ";
    }

    if (!empty($arr['zip'] ?? '')) {
        $q_zip = ' && ZIP_CODE LIKE \"' . mb_substr($arr['zip'], 0, 5) . "%\" ";
    }

    $query = '';
    if (!empty($arr['name'] ?? '')) {
        $response['search_name'] = $arr['name'];
        $tmp = explode(" ", $arr['name']);
        if (isset($tmp[1])) {
            $i = 0;
            foreach ($tmp as $x) {
                $x = mysqli_escape_string($conn, $x);
                if ($i == 0) {
                    $query = "+$x*";
                } else {
                    $query .= " +$x* ";
                }
                $i++;
            }
        } else {
            $query = " +" . $arr['name'] . "*";
        }
    }

    $years = ["26", "24", "22", "20", "18", "16", "14", "12"];
    $transactions = [];
    foreach ($years as $year) {
        $table = "nufec_indiv_" . $year;
        $sql = "SELECT CMTE_ID, TRANSACTION_PGI, TRAN_ID, NAME, CITY, STATE, ZIP_CODE, EMPLOYER, OCCUPATION, TRANSACTION_DT, TRANSACTION_AMT, FILE_NUM, IMAGE_NUM
            FROM $table
            WHERE MATCH ( NAME ) AGAINST ( \"$query\" IN BOOLEAN MODE) $q_city $q_state $q_zip";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
                $cmte_id = $row['CMTE_ID'];
                $amt = $row['TRANSACTION_AMT'];
                $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
                $response['cmte_totals'][$cmte_id] = ($response['cmte_totals'][$cmte_id] ?? 0) + $amt;
                $response['cycle_total'][$year] = ($response['cycle_total'][$year] ?? 0) + $amt;
                $cmte_arr[$cmte_id] = $cmte_id;
            }
        }
    }

    foreach ($years as $year) {
        $q = '';
        if (isset($cmte_arr) && sizeof($cmte_arr) < 1) {
            continue;
        }
        $table = "nufec_cm_" . $year;
        foreach ($cmte_arr as $cmte_id => $ignore) {
            $q .= " CMTE_ID = '$cmte_id' ||";
        }
        $q = substr($q, 0, -2);
        $sql = "SELECT CMTE_ID, CMTE_NM FROM $table WHERE ( $q )";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cmte_id = $row['CMTE_ID'];
                $cmte_nm = $row['CMTE_NM'];
                $response['committees'][$cmte_id] = $cmte_nm;
                unset($cmte_arr[$cmte_id]);
            }
        }
    }
    $response['transactions'] = $transactions;
}

function fec_vendor(array $arr): void {
    global $response;
    $conn = Util::get_ctb_conn();
    $transactions = [];
    $response['type'] = "vendor";

    $name = $arr['name'] ?? '';
    $response['search_name'] = $name;

    $use_first = false;
    $years = ["26", "24", "22", "20", "18", "16", "14", "12"];

    foreach ($years as $year) {
        $table = "nufec_oppexp_" . $year;
        $cm_table = "nufec_cm_" . $year;
        $c1 = $table . ".CMTE_ID";
        $c2 = $cm_table . ".CMTE_ID";
        $query = '';

        if (!empty($name)) {
            $tmp = explode(" ", $name);
            if (isset($tmp[1])) {
                $i = 0;
                foreach ($tmp as $x) {
                    if ($i == 0 && strlen($x) < 2) {
                        $use_first = true;
                    }
                    $x = mysqli_escape_string($conn, $x);
                    if ($i == 0) {
                        $query = "+$x*";
                    } else {
                        $query .= " +$x* ";
                    }
                    $i++;
                }
            } else {
                $query = " +$name*";
            }
        }

        $local_query = '';
        if (!empty($arr['city'] ?? '')) {
            $local_query .= " && CITY LIKE '{$arr['city']}%' ";
        }
        if (!empty($arr['state'] ?? '')) {
            $local_query .= " && STATE = '{$arr['state']}'";
        }
        if (!empty($arr['zip'] ?? '')) {
            $local_query .= " && ZIP_CODE LIKE '" . mb_substr($arr['zip'], 0, 5) . "%' ";
        }

        $add_like = '';
        if ($use_first) {
            $add_like = " && NAME LIKE \"$name%\" ";
        }

        $sql = "SELECT TRANSACTION_AMT, TRAN_ID, TRANSACTION_DT, NAME, PURPOSE, FILE_NUM, CITY, STATE, ZIP_CODE, $c1, CMTE_NM, TRANSACTION_PGI, MEMO_CD, MEMO_TEXT, IMAGE_NUM
            FROM $table
            INNER JOIN $cm_table
            ON $c1 = $c2
            WHERE MATCH ( NAME ) AGAINST ( '\"$query\"' IN BOOLEAN MODE) $local_query $add_like";

        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this_cmte = $row['CMTE_ID'];
                $cmte_nm = $row['CMTE_NM'];
                $response['committees'][$this_cmte] = $cmte_nm;
                $amt = $row['TRANSACTION_AMT'];
                $response['cmte_totals'][$this_cmte] = ($response['cmte_totals'][$this_cmte] ?? 0) + $amt;
                $response['year_totals'][$year] = ($response['year_totals'][$year] ?? 0) + $amt;
                $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
                $transactions[] = $row;
            }
        }
    }

    $response['transactions'] = $transactions;
}

function fppc_search(array $arr): void {
    global $response;
    switch ($arr['type'] ?? '') {
        case "contributor":
            fppc_contributor($arr);
            break;
        case "vendor":
            fppc_vendor($arr);
            break;
        case "committee":
            fppc_filer($arr);
            break;
    }
    $response['scope'] = "fppc";
}

function fppc_contributor(array $arr): void {
    global $response;
    $conn = Util::get_ctb_conn();

    $name = $arr['name'] ?? '';
    $city = $arr['city'] ?? '';
    $state = $arr['state'] ?? '';
    $zip = $arr['zip'] ?? '';

    $response['search_name'] = $name;
    $response['type'] = "contributor";

    $filtered = '';
    $query = '';
    $q2 = '';

    $tmp = explode(" ", $name);
    foreach ($tmp as $x) {
        if (strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
            //DO NOTHING
        } else {
            $filtered .= " " . $x;
            $query .= "$x ";
            $q2 .= " NAME LIKE '%" . $x . "%' &&";
        }
    }

    $q2 = substr($q2, 0, -2);

    $local_query = '';
    if ($city) {
        $local_query .= " && CTRIB_CITY LIKE '$city%' ";
    }
    if ($state) {
        $local_query .= " && CTRIB_ST = '$state'";
    }
    if ($zip) {
        $local_query .= " && CTRIB_ZIP4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
    }

    $sql = "SELECT * FROM (
                SELECT *, CONCAT(CTRIB_NAMF, \" \", CTRIB_NAML) AS NAME
                FROM calaccess_raw_RCPT_CD
                WHERE MATCH (CTRIB_NAMF, CTRIB_NAML) AGAINST ( '$query' IN BOOLEAN MODE)
            ) A
            WHERE $q2 $local_query    
            ORDER BY FILING_ID, TRAN_ID, AMEND_ID DESC";

    $result = $conn->query($sql);
    $end_sql = $sql;
    $transactions = [];
    $transactions_all = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions_all[] = $row;
            $filing_id = $row['FILING_ID'];
            $amend_id = $row['AMEND_ID'];
            $filing_index[$filing_id] = $amend_id;
        }
    }

    $q = '';
    foreach ($filing_index as $filing_id => $ignore) {
        $q .= " FILING_ID = '$filing_id' ||";
    }
    $q = substr($q, 0, -2);
    $sql = "SELECT FILER_ID, FILING_ID FROM calaccess_raw_FILER_FILINGS_CD WHERE ( $q )";
    $end_sql .= "\n" . $sql;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filer_id = $row['FILER_ID'];
            $filing_id = $row['FILING_ID'];
            $filer_index[$filer_id] = true;
            $filing_index[$filing_id] = $filer_id;
        }
    }

    $q = '';
    foreach ($filer_index as $filer_id => $ignore) {
        $q .= " (FILER_ID = '$filer_id' || XREF_FILER_ID = '$filer_id') ||";
    }
    $q = substr($q, 0, -2);
    $sql = "SELECT XREF_FILER_ID, FILER_ID, NAML FROM calaccess_raw_FILERNAME_CD WHERE ( $q )";
    $end_sql .= "\n" . $sql;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filer_id = $row['FILER_ID'];
            $xref_id = $row['XREF_FILER_ID'];
            $filername_index[$filer_id] = $row['NAML'];
            $filername_index[$xref_id] = $row['NAML'];
        }
    }

    foreach ($transactions_all as $key => $t) {
        $filing_id = $t['FILING_ID'];
        $filer_id = $filing_index[$filing_id] ?? 0;
        $filer_nm = $filername_index[$filer_id] ?? '';
        $amt = $t['AMOUNT'];
        $rcpt_date = $t['RCPT_DATE'];
        $tran_id = $t['TRAN_ID'];
        $t['FILER_ID'] = $filer_id;
        $t['FILER_NM'] = $filer_nm;

        if (!isset($transaction_index[$filer_id][$rcpt_date][$tran_id])) {
            if ($filer_id == 0) {
                continue;
            }
            $transactions[] = $t;
            $transaction_index[$filer_id][$rcpt_date][$tran_id] = true;
            $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
            $response['cmte_totals'][$filer_id] = ($response['cmte_totals'][$filer_id] ?? 0) + $amt;
            $response['committees'][$filer_id] = $filer_nm;
        }
    }

    $response['transactions'] = $transactions;
}

function fppc_vendor(array $arr): void {
    global $response;
    $conn = Util::get_ctb_conn();

    $name = $arr['name'] ?? '';
    $city = $arr['city'] ?? '';
    $state = $arr['state'] ?? '';
    $zip = $arr['zip'] ?? '';

    $response['search_name'] = $name;
    $response['type'] = 'vendor';

    $filtered = '';
    $query = '';
    $q2 = '';

    $tmp = explode(" ", $name);
    foreach ($tmp as $x) {
        if (strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
            //DO NOTHING
        } else {
            $filtered .= " " . $x;
            $query .= "$x ";
            $q2 .= " NAME LIKE '%" . $x . "%' &&";
        }
    }

    $q2 = substr($q2, 0, -2);

    $local_query = '';
    if ($city) {
        $local_query .= " && PAYEE_CITY LIKE '$city%' ";
    }
    if ($state) {
        $local_query .= " && PAYEE_ST = '$state'";
    }
    if ($zip) {
        $local_query .= " && PAYEE_ZIP4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
    }

    $sql = "SELECT * FROM (
                SELECT *, CONCAT(PAYEE_NAMF, \" \", PAYEE_NAML) AS NAME
                FROM calaccess_raw_EXPN_CD
                WHERE MATCH (PAYEE_NAMF, PAYEE_NAML) AGAINST ( '$query' IN BOOLEAN MODE)
            ) A
            WHERE $q2 $local_query
            ORDER BY FILING_ID, TRAN_ID, AMEND_ID DESC";

    $result = $conn->query($sql);
    $end_sql = $sql;
    $transactions = [];
    $transactions_all = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions_all[] = $row;
            $filing_id = $row['FILING_ID'];
            $amend_id = $row['AMEND_ID'];
            $filing_index[$filing_id] = $amend_id;
        }
    }

    $q = '';
    foreach ($filing_index as $filing_id => $ignore) {
        $q .= " FILING_ID = '$filing_id' ||";
    }
    $q = substr($q, 0, -2);
    $sql = "SELECT FILER_ID, FILING_ID FROM calaccess_raw_FILER_FILINGS_CD WHERE ( $q )";
    $end_sql .= "\n" . $sql;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filer_id = $row['FILER_ID'];
            $filing_id = $row['FILING_ID'];
            $filer_index[$filer_id] = true;
            $filing_index[$filing_id] = $filer_id;
        }
    }

    $q = '';
    foreach ($filer_index as $filer_id => $ignore) {
        $q .= " (FILER_ID = '$filer_id' || XREF_FILER_ID = '$filer_id') ||";
    }
    $q = substr($q, 0, -2);
    $sql = "SELECT XREF_FILER_ID, FILER_ID, NAML FROM calaccess_raw_FILERNAME_CD WHERE ( $q )";
    $end_sql .= "\n" . $sql;
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $filer_id = $row['FILER_ID'];
            $xref_id = $row['XREF_FILER_ID'];
            $filername_index[$filer_id] = $row['NAML'];
            $filername_index[$xref_id] = $row['NAML'];
        }
    }

    foreach ($transactions_all as $key => $t) {
        $filing_id = $t['FILING_ID'];
        $filer_id = $filing_index[$filing_id] ?? 0;
        $filer_nm = $filername_index[$filer_id] ?? '';
        $amt = $t['AMOUNT'];
        $date = $t['EXPN_DATE'];
        $tran_id = $t['TRAN_ID'];

        if (!isset($transaction_index[$filer_id][$date][$tran_id])) {
            if ($filer_id == 0) {
                continue;
            }
            $transactions[] = $t;
            $transaction_index[$filer_id][$date][$tran_id] = true;
            $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
            $response['cmte_totals'][$filer_id] = ($response['cmte_totals'][$filer_id] ?? 0) + $amt;
            $response['committees'][$filer_id] = $filer_nm;
        }
    }

    $response['transactions'] = $transactions;
}

function netfile_search(array $arr): void {
    global $response;
    switch ($arr['type'] ?? '') {
        case "contributor":
            netfile_contributor($arr);
            break;
        case "vendor":
            netfile_vendor($arr);
            break;
        case "committee":
            netfile_committee($arr);
            break;
    }
    $response['scope'] = 'netfile';
}

function netfile_contributor(array $arr): void {
    global $response;
    $conn = Util::get_ctb_conn();
    $response['type'] = "contributor";

    $name = $arr['name'] ?? '';
    $response['search_name'] = $name;

    $tmp = explode(" ", $name);
    $city = $arr['city'] ?? '';
    $state = $arr['state'] ?? '';
    $zip = $arr['zip'] ?? '';

    $loc_index = [];
    $sql = "SELECT * FROM netfile_locations";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aid = $row['aid'];
            if ($row['juris'] == "city") {
                $loc_index[$aid] = $row['verbose'] . " (" . $row['juris'] . ")";
            } else {
                $loc_index[$aid] = $row['verbose'] . " County";
            }
        }
    }

    $filtered = '';
    $query = '';
    $q2 = '';
    foreach ($tmp as $x) {
        if (strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
            //DO NOTHING
        } else {
            $filtered .= " " . $x;
            $query .= "$x ";
            $q2 .= " NAME LIKE '%" . $x . "%' &&";
        }
    }

    $q2 = substr($q2, 0, -2);

    $local_query = '';
    if ($city) {
        $local_query .= " && Tran_City LIKE '$city%' ";
    }
    if ($state) {
        $local_query .= " && Tran_State = '$state'";
    }
    if ($zip) {
        $local_query .= " && Tran_Zip4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
    }

    $sql = "SELECT * FROM (
                SELECT *, CONCAT(Tran_NamF, \" \", Tran_NamL) AS NAME, Tran_Amt1
                FROM netfile_contributions
                WHERE MATCH (Tran_NamF, Tran_NamL) AGAINST ( '$query' IN BOOLEAN MODE) && (Form_Type = 'A' || Form_Type = 'C')
            ) A
            WHERE $q2 $local_query
            ORDER BY Filer_NamL, Thru_Date, Report_Num DESC";

    $transactions_all = [];
    $transactions = [];
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aid = $row['LOCATION'] ?? '';
            $verbose = $loc_index[$aid] ?? '';
            $row['verbose'] = $verbose;
            $transactions_all[] = $row;
        }
    }

    foreach ($transactions_all as $t) {
        $tran_dt = $t['Tran_Date'] ?? '';
        $filer_naml = $t['Filer_NamL'] ?? '';
        $tran_id = $t['Tran_ID'] ?? '';
        $filer_id = $t['Filer_ID'] ?? '';
        if (!isset($transaction_index[$filer_naml][$tran_dt][$tran_id])) {
            $amt = $t['Tran_Amt1'] ?? 0;
            $transactions[] = $t;
            $transaction_index[$filer_naml][$tran_dt][$tran_id] = true;
            $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
            $response['cmte_totals'][$filer_id] = ($response['cmte_totals'][$filer_id] ?? 0) + $amt;
            $response['committees'][$filer_id] = $filer_naml;
        }
    }

    $response['transactions'] = $transactions;
}

function netfile_vendor(array $arr): void {
    global $response;
    $conn = Util::get_ctb_conn();
    $response['type'] = "vendor";

    $name = $arr['name'] ?? '';
    $response['search_name'] = $name;

    $tmp = explode(" ", $name);
    $city = $arr['city'] ?? '';
    $state = $arr['state'] ?? '';
    $zip = $arr['zip'] ?? '';

    $loc_index = [];
    $sql = "SELECT * FROM netfile_locations";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aid = $row['aid'];
            if ($row['juris'] == "city") {
                $loc_index[$aid] = $row['verbose'] . " (" . $row['juris'] . ")";
            } else {
                $loc_index[$aid] = $row['verbose'] . " County";
            }
        }
    }

    $filtered = '';
    $query = '';
    $q2 = '';
    foreach ($tmp as $x) {
        if (strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
            //DO NOTHING
        } else {
            $filtered .= " " . $x;
            $query .= "$x ";
            $q2 .= " NAME LIKE '%" . $x . "%' &&";
        }
    }

    $q2 = substr($q2, 0, -2);

    $local_query = '';
    if ($city) {
        $local_query .= " && Payee_City LIKE '$city%' ";
    }
    if ($state) {
        $local_query .= " && Payee_State = '$state'";
    }
    if ($zip) {
        $local_query .= " && Payee_Zip4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
    }

    $sql = "SELECT * FROM (
                SELECT *, CONCAT(Payee_NamF, \" \", Payee_NamL) AS NAME
                FROM netfile_expenditures
                WHERE MATCH (Payee_NamF, Payee_NamL) AGAINST ( '$query' IN BOOLEAN MODE)
            ) A
            WHERE $q2 $local_query";

    $transactions_all = [];
    $transactions = [];
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aid = $row['LOCATION'] ?? '';
            $verbose = $loc_index[$aid] ?? '';
            $row['verbose'] = $verbose;
            $transactions_all[] = $row;
        }
    }

    foreach ($transactions_all as $t) {
        $tran_dt = $t['Expn_Date'] ?? '';
        $filer_naml = $t['Filer_NamL'] ?? '';
        $filer_id = $t['Filer_ID'] ?? '';
        $tran_id = $t['Tran_ID'] ?? '';
        if (!isset($transaction_index[$filer_naml][$tran_dt][$tran_id])) {
            $amt = $t['Amount'] ?? 0;
            $transactions[] = $t;
            $transaction_index[$filer_naml][$tran_dt][$tran_id] = true;
            $response['grand_total'] = ($response['grand_total'] ?? 0) + $amt;
            $response['cmte_totals'][$filer_id] = ($response['cmte_totals'][$filer_id] ?? 0) + $amt;
            $response['committees'][$filer_id] = $filer_naml;
        }
    }

    $response['transactions'] = $transactions;
}

function ctb_search(array $arr): void {
    global $response;
    // Implementation for ctb_search
}
?>