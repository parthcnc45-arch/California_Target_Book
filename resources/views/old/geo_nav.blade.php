@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'Election Results/Voter Registration Data by Geographic Area (2006-Present) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Election Results/Voter Registration Data by Geographic Area
        <small class="sub block mt-sm">2006 - Present</small>
    </h2>
    <iframe src='/ctb-legacy/nugeo_nav.php' width='100%' height='100%' class='ported'></iframe>
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