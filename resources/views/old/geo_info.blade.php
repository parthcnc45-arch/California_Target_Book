@extends('layouts.book')
@php ($book_side_nav_active = 'maps')

@section('title', 'Lookup County/City/District Information by Location | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Lookup County/City/District Information by Location
    </h2>
    <iframe src='/ctb-legacy/gmap_lookup.php' width='100%' height='100%' class='ported'></iframe>
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