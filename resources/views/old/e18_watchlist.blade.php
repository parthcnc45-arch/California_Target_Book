@php ($book_side_nav_active = 'candidates')

@extends('layouts.book')

@section('title', '2018 Watchlist | California Target Book')

@section('content')

<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$endjava = Array();

Util::require_ctb_api();

$x = populate_watch();
?>

<div class="container-fluid pt-lg">
    <div class='jumbo' align='center' width='100%'>
        <div class='contain_me' align='center'>
            <div class='active'><h1 align='center'>ACTIVE</h1><div class='result_box' align='center'>{!! $x['active'] !!}</div></div>
            <div class='inactive'><h1 align='center'>NO DATA YET</h1><div class='result_box' align='center'>{!! $x['inactive'] !!}</div></div>
        </div>
    </div>
    <div class="mt-xl">
        @php( include Util::$view_root.'p18_filing_status.php' )
    </div>
</div>

<?php

function populate_watch() {
	global $site_conn;
	$conn = Util::get_ctb_conn();
    $retval['active']='';
    $retval['inactive']='';
	$sql = "SELECT * FROM ctb_e18_county_watch WHERE status = '1' ORDER BY county_nm ASC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['active'] .= " •  <a href='" . $row['url'] . "' target='_blank'>" . $row['county_nm'] . " </a>";
		}
	}
	$sql = "SELECT * FROM ctb_e18_county_watch WHERE status IS NULL ORDER BY county_nm ASC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['inactive'] .= " •  <a href='" . $row['url'] . "' target='_blank'>" . $row['county_nm'] . " </a>";
		}
	}
	return $retval;
}

?>



@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'candidates' });</script>
@endsection
