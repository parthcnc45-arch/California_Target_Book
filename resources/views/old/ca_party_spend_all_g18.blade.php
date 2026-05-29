
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'State/County Party Spending in Targeted Races (2018 General) | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        State/County Party Spending in Targeted Races (2018 General)
        <small class="sub block mt-sm">2018 General Election</small>
    </h2>
    <iframe src='/ctb-legacy/alltargets_18.php?since=2018-06-30' width='100%' height='100%' class='ported'></iframe>
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