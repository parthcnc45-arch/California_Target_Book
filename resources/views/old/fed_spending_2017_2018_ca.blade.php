@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2017-2018 Campaign/IE Spending (California Races) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Campaign & Independent Expenditure Spending
        <small class="sub block mt-sm">2017 - 2018 Cycle</small>
    </h2>
    <iframe src='/ctb-legacy/fullfedspendca_18.php?id=CA' width='100%' height='100%' class='ported'></iframe>
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