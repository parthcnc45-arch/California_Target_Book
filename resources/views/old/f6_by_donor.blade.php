@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'Recent FEC 48-Hour Contributions | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Recent FEC 48-Hour Contributions
    </h2>
    <iframe src='/ctb-legacy/recent_f6.php' width='100%' height='100%' class='ported'></iframe>
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