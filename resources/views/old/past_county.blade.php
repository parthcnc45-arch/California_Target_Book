@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'Party Registration & General Election Voter Turnout by County, 1952-2018 | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Party Registration & General Election Voter Turnout by County
        <small class="sub block mt-sm">1952 - 2018</small>
    </h2>
    <iframe src='/ctb-legacy/countyreg_hist.php' width='100%' height='100%' class='ported'></iframe>
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