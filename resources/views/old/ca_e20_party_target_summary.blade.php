
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA Campaign 2020 Party Spending in Targeted Races | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Party Spending in Targeted Races
        <small class="sub block mt-sm">2020 General Election</small>
    </h2>
    <iframe src='/ctb-legacy/alltargets_20_v2.php' width='100%' height='100%' class='ported'></iframe>
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