
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA IE Filings (2018 Primary) | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Independent Expenditure Filings
        <small class="sub block mt-sm">2018 Primary</small>
    </h2>
    <iframe src='/ctb-legacy/ielist_p18.php' width='100%' height='100%' class='ported'></iframe>
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