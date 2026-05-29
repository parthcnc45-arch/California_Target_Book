@extends('layouts.book')
@php ($book_side_nav_active = 'maps')

@section('title', 'Precinct-Level Maps & Results | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Precinct-Level Maps & Results
        <small class="sub block mt-sm">Select Options</small>
    </h2>
    <iframe src='/ctb-legacy/precinct_nav.php' width='100%' height='100%' class='ported'></iframe>
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