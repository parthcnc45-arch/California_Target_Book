@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'CA Voter Registration & Past Results (All Cities/County Subdivisions) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Voter Registration Trends as of April 2018 & Past Results
        <small class="sub block mt-sm">All Cities/County Subdivisions</small>
    </h2>
    <iframe src='/ctb-legacy/city_and_county_past_all.php' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

</style>


@endsection