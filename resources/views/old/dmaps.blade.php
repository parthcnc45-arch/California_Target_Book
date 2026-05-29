@extends('layouts.bookNew')
@php ($book_side_nav_active = 'maps')

@section('title', 'District Map Browser (1992-2018 Boundaries) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        District Map Browser
        <small class="sub block mt-sm">1992 - 2018 Boundaries</small>
    </h2>
    <iframe src='/ctb-legacy/new_map_nav.php' width='100%' height='100%' class='ported'></iframe>
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