@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'U.S. Census American Community Survey Demographic Changes (2012 to 2018) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        U.S. Census American Community Survey Demographic Changes
        <small class="sub block mt-sm">2012 to 2018</small>
    </h2>
    <iframe src='/ctb-legacy/acs_delta.html' width='100%' height='100%' class='ported'></iframe>
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