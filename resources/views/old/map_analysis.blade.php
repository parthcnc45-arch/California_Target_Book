@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Map Analysis Post Archive | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>Map Analysis Post Archive</h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

use App\User;
$role = Auth::user()->role;

$posts = get_posts();

$enddraw  = "<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<div class='panel'>
					$posts
				</div>
			</div>
		</div>
	     </div>";

echo($enddraw);

function get_posts() {
    $conn = Util::get_ctb_conn();  
    $sql = "SELECT text, post_id FROM ctb_hot_sheet WHERE text LIKE '%VIZSEARCH%' ORDER BY updated DESC";
    $result = $conn->query($sql);
    $retval = "<ul>";
    if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$post_id = $row['post_id'];
		if(!isset($posts[$post_id])) {
			$posts[$post_id] = $row['text'];
		}
	}
    }
    foreach($posts as $post_id => $text) {
	$regex = '~category\=\'(.*?)\'~mis';
	preg_match($regex, $text, $results);
	$category = $results[1];

	$regex = '~label\=\'(.*?)\'~mis';
	preg_match($regex, $text, $results);
	$headline = $results[1];

	$retval .= "<li>
			<a href='/book/hotsheet/$post_id' target='_blank'><span class='bold'>$category - $headline (Posted $post_id)</span></a>
		    </li>";

	
    }
    $retval .= "</ul>";
    return $retval;
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

.rightme {
  text-align: right;
}

.leftme {
  text-align: left;
}

.redme {
  color: red;
}

.blueme {
  color: blue;
}

.boldme {
  font-weight: bold;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection