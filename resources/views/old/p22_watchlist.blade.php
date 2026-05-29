@extends('layouts.book')
@php ($book_side_nav_active = 'maps')

@section('title', '2022 Candidate Watchlist | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2022 Candidate Watchlist
        <!--<small class="sub block mt-sm">With Voter Registration Statistics & Past Officeholders</small>-->
    </h2>
    <iframe src='/ctb-legacy/e22_watchlist.php' width='100%' height='100%' class='ported'></iframe>
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