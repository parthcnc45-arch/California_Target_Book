
<?php

global $role;
use App\User;
$role = Auth::user()->role;



function get_hot_sheet($pg)
{
    global $items_per_page, $role;
    if (!$items_per_page) {
        $items_per_page = 5;
    }

    $limit = '';
    if ($pg > 1) {
        $offset = ($pg - 1) * $items_per_page;
        $limit = " LIMIT $offset, $items_per_page";
    }

    $sql = "SELECT DISTINCT post_id,
              MAX(updated) AS updated, text, tags
              FROM (SELECT updated, post_id, tags, text, id FROM
                (SELECT updated, post_id, tags, text, id FROM ctb_hot_sheet".$limit.") A
                ORDER BY post_id DESC, updated DESC) B GROUP BY post_id ORDER BY post_id DESC";

   $sql = "SELECT * FROM ctb_hot_sheet $limit ORDER BY post_id DESC, updated DESC";

    $result = Util::get_ctb_conn()->query($sql);
    //echo($sql);
    $retval = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $post_id = $row['post_id'];
	    $this_post = $post_id;
            $year = mb_substr($post_id, 0, 4);
            $month = mb_substr($post_id, 4, 2);
            $day = mb_substr($post_id, 6, 2);

	    if($role == "admin") {
		$edit_btn = "<a href='http://198.74.49.22/hs_editor.php?id=" . $post_id . "' target='_blank'><img src='/img/edit_btn.png' height='20px' width='20px' style='opacity: 0.5;'></a>";
	    } else {
		$edit_btn = '';
	    }

            $post_date = $month . "-" . $day . "-" . $year . " Update";
	    if($this_post != $last_post) {
	            $retval .= "<hr />
        	        <div class='row'>
                	    <div class='col-lg-12 hs_entry panel m-n'>
                        	<h2>$post_date" . $edit_btn . "</h2>
                        	" . $row['text'] . "
	                    </div>
        	        </div>";
	    }
	    $last_post = $this_post;
        }
    }

    return $retval;

}


    if (isset($_GET['pg'])) {
        $pg = $_GET['pg'];
    } else {
        $pg = 1;
    }

    $hotsheet = get_hot_sheet($pg);

    // Extract <style> and <script> tags
    $doc = new DOMDocument();
    $doc->loadHTML($hotsheet);

    function removeElementsByTagName($tagName, $document) {
        $nodeList = $document->getElementsByTagName($tagName);
        $extracted = '';
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
            $node = $nodeList->item($nodeIdx);
            $extracted .= $node->textContent;
            $node->parentNode->removeChild($node);
        }
    }

    global $links, $styles, $scripts, $hotsheet;

    $links = removeElementsByTagName('link', $doc);
    $styles = removeElementsByTagName('style', $doc);
    $scripts = removeElementsByTagName('script', $doc);

    $hotsheet = $doc->saveHtml();
?>


@php ($book_side_nav_active = 'hotsheet')
@extends('layouts.book')


@section('title', 'Hotsheet | California Target Book')

@section('bodyClasses', 'main-bg-gray')

@section('content')

    <div id="hotsheet" class='container-fluid'>

		<div class='row'>

            <div class="col-lg-8 col-md-10 center-block fn">
                <h1 align='center' class='hs_head' style='margin-top: 15px; font-size: 3em;'>H o t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S h e e t</h1>
                <p align='center'><a href='/book/live_hub'>Live FPPC Candidate/Contribution/Independent Expenditure Filings</a></p>
                <?php
                global $hotsheet;

                echo $hotsheet;
                ?>

            </div>

		</div>
    </div>

@endsection

@section('styles')
    <?php
        global $links, $styles;
        echo $links;
        echo $styles;
    ?>

    <style>
	.hs_head {
		font-family: 'Bellefair';
		font-variant: small-caps;
	}

	.hs_entry {
		font-family: 'Lato';
		text-align: justify;
	}

	.hs_entry table {
		font-family: 'PT Sans Narrow';
		padding: 5px;
		text-align: right;
		min-width: 500px;
	}

@media screen and (max-width: 1024px) {
    .candidates_box {
        display: none !important;
    }
}

    </style>

<style>

    .candidate-panel .candidate-content {
        padding: 10px;
    }

    .panel-candidate-header {
        font-weight: bold;
        font-variant: small-caps;
        text-align: right;
        font-size: 1.5em;
        box-shadow: none;
    }

    .content-header {
        text-align: center;
        font-variant: small-caps;
    }

    .iframe-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%;

    }

    .iframe-container > * {
        display: block;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }

    #years > ul li {
        list-style: none;
        padding: 5px 15px;
        float: left;
        margin: 5px;
        border: 1px solid #ccc;
    }
    #years > ul li.tab-current {
        background: #ddd;
    }
    #years > ul li:hover {
        background: #eee;
    }

    .container > div > hr {
        margin: 64px auto;
    }
    .no-border {
        box-shadow: none;
    }

    #parent .candidate-panel {
       display: none;
    }

</style>

@endsection

@section('scripts')
    <?php
        global $scripts;
        echo $scripts;
    ?>


<script>

    function Divs() {
        var divs= $('#parent .candidate-panel'),
            now = divs.filter(':visible'),
            next = now.next().length ? now.next() : divs.first(),
            speed = 0;

        now.fadeOut(speed);
        next.fadeIn(speed);
    }

    $(function () {
        setInterval(Divs, 4000);
    });

</script>
@endsection
