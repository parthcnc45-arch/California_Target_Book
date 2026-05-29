@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2020 Campaign/IE Spending (All Races) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Campaign & Independent Expenditure Spending (Nationwide)
        <small class="sub block mt-sm">2020 Cycle</small>
    </h2>
    <iframe src='/ctb-legacy/fullfedspendca_20.php?state=ALL' width='100%' height='100%' class='ported'></iframe>
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