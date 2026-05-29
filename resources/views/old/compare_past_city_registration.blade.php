@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'Compare Past City Voter Registration | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Voter Registration Trends
        <small class="sub block mt-sm">Compare Past City Voter Registration Data</small>
    </h2>
    <iframe src='/ctb-legacy/city_reg_nav.php' width='100%' height='100%' class='ported'></iframe>
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