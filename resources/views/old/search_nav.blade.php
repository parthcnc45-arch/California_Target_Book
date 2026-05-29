@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FEC / FPPC Search | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FEC / FPPC Search
        <small class="sub block mt-sm">FEC (2011 - 2020) / FPPC (2000 - 2020)</small>
    </h2>
    <iframe src='/ctb-legacy/search_nav_test.php' width='100%' height='100%' class='ported'></iframe>
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