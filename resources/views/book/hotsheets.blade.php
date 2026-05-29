<?php
    Util::require_ctb_api();
    $conn = Util::get_ctb_conn();

    $sql = "SELECT naml, namf FROM ctb_cand_filed_v2 GROUP BY naml, namf ORDER BY naml, namf";
    $result = $conn->query($sql);

    $candidates = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($candidates, $row);
        }
    }
?>
@extends('layouts.bookNew')


@section('title', "Hotsheet | California Target Book")
@section('bodyClasses', "hotsheet")

@section('content')
<!-- new work starts here -->
<ul class="hot-breadcumb d-flex">
    <li><a href="{{ route('book') }}" class="text-decoration-none">California Target Book</a></li>
    <li class="active">Hot Sheets</li>
</ul>
  <div class="container-fluid pt-lg">
    <div class="row">
      <div class="col-md-8">
        <div class="ctb-rabban headingDiv">
          <h5>Hot Sheets</h5>
        </div>
        <form class="ctb-filter d-flex align-items-center gap-2" method="POST" action="{{ route('book.hotsheet.filterArticles') }}" id="filter-form">
          @csrf
          <!-- <div class="ctb-filter d-flex align-items-center"> -->
            <div class="ctb-search-field">
              <input
                class="ctb-search w-100"
                type="text"
                id='searchQuery'
                placeholder="Search Hot Sheets"
              />
            </div>
            <div class="ctb-filters-btns d-flex justify-content-end align-items-center">
                <select id='distType' class="ctb-input p-2">
                    <option value=''>District Type</option>
                    <option value='AD'>Assembly</option>
                    <option value='SD'>State Senate</option>
                    <option value='CD'>Congress</option>
                </select>
                <select id='districtField' class="ctb-input d-none p-2">
                    <option value=''>District</option>
                </select>

                <select id='condidateField' class="ctb-input p-2">
                    <option value=''>Select Candidate</option>
                    @for ($i=0 ; $i < count($candidates); $i++)
                        <option value={{ $candidates[$i]['naml']}}>{{ $candidates[$i]['naml'] .' '. $candidates[$i]['namf'] }}</option>
                    @endfor
                </select>
                {{-- <div class="ctb-search-field p-2"> --}}
                    <input
                    class="ctb-input"
                    type="date"
                    id='dateField'
                    />
                {{-- </div> --}}
              <button type="button" id='applyFilter' class="p-2 ctb-input btn-default">Filter</button>
            </div>
          <!-- </div> -->
        </form>
        <div id="loader" class="text-center mt-5 hidden">
            <ctb-loader></ctb-loader>
        </div>
        <div class="row" id='articaleList'>
          @include('book.articaleList')
        </div>
      </div>
      @include('book.recentHotsheets')
    </div>
  </div>
<!-- new works ends here -->
@endsection

@section('scripts')
<script>
    function toggleFavorite(event) {
        event.preventDefault();
    }
</script>
    @include('book.hsFilterJs')
    <script>gtag('set', { 'book_category': 'hotsheets' });</script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

@endsection
