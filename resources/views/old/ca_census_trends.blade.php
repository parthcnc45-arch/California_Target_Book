
@php ($book_side_nav_active = 'stats')
@extends('layouts.book')

@section('title', 'U.S. Census Data - American Community Survey Trends by Location | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        U.S. Census Data - American Community Survey Trends by Location (2012 - 2018 Data)
        <small class="sub block mt-sm">2018 General Election</small>
    </h2>
    <iframe src='/ctb-legacy/census_trend_nav' width='100%' height='100%' class='ported'></iframe>
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