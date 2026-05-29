@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'Voter Turnout & Undervote in Previous Elections (2012 - 2016) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Voter Turnout & Undervote in Previous Elections
        <small class="sub block mt-sm">2012 - 2016</small>
    </h2>
    <iframe src='/ctb-legacy/undervote_nav.php' width='100%' height='100%' class='ported'></iframe>
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