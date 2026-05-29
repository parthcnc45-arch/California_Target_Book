@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Census Block Group Maps/Data (2010 / 2018) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Census Block Group Maps/Data by Geographic Area
        <small class="sub block mt-sm">U.S. Census American Community Survey 5-Year Estimates, 2010 / 2018</small>
    </h2>
    <iframe src='/ctb-legacy/blockgroup_nav.php' width='100%' height='100%' class='ported'></iframe>
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