
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA Federal IE Filings (2024 Primary Election) | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Federal Independent Expenditure Filings
        <small class="sub block mt-sm">2024 Primary Election</small>
    </h2>
    <iframe src='/ctb-legacy/ctb_fec_ie_spend.php?cycle=2024&state=CA' width='100%' height='100%' class='ported'></iframe>
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