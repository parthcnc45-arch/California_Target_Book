<div class="row mt-3">
    <div class="col-md-8 ps-0">
    <div class="ctb-rabban headingDiv">
        <h5>Hot Sheets</h5>
    </div>
    <form class="ctb-filter d-flex align-items-center gap-2" method="POST" action="{{ route('book.hotsheet.filterArticles') }}" id="filter-form">
        @csrf
        <div class="ctb-search-field">
            <input
            class="ctb-search w-100"
            type="text"
            id='searchQuery'
            placeholder="Search Hot Sheets"
            />
        </div>
        <div class="ctb-filters-btns d-flex justify-content-end align-items-center">
            <div class="ctb-search-field">
                <input
                class="ctb-input"
                type="date"
                id='dateField'
                />
            </div>
            <button type="button" id='applyFilter' class="p-2 ctb-input btn-default">Filter</button>

        </div>
    </form>
    <div id="loader" class="text-center mt-5 hidden">
        <ctb-loader></ctb-loader>
    </div>
    <div class="" id='articaleList'>
        @include('book.articaleList', [ 'other_articles' => get_hs_items($fourcode) ])
    </div>

    </div>
    @include('book.recentHotsheets' , [ 'favorite_article' => App\Book\Hotsheet::getFavoriteArticle() ])
</div>
<?php
    // function getCandidatesName($table) {
    //     Util::require_ctb_api();
    //     $conn = Util::get_ctb_conn();

    //     $sql = "SELECT naml, namf FROM $table ORDER BY naml LIMIT 50";
    //     $result = $conn->query($sql);

    //     $candidates = array();

    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             array_push($candidates, $row);
    //         }
    //     }
    //     return $candidates;
    // }
    function get_hs_items($fourcode) {
        return App\Book\Hotsheet::getArticleByForcode($fourcode);
    }
?>

<script>
$(document).ready(function () {
    $("#dateField").change(function () {
        if (!isValidDate(this.value)) {
            alert('Invalid date. Please enter a valid date in the format MM-DD-YYYY.');
            this.value = '';
        }
    });
});
    function isValidDate(dateString) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(dateString);
    }
</script>
