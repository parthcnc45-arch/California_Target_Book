@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'G22 Targeted Races - Federal')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2022 General Election - Federal Targeted Races
        <small class="sub block mt-sm">All States</small>
    </h2>
    <iframe src='/ctb-legacy/fec_target_tables_condensed.php?election=G&finance=Y' width='100%' height='100%' class='ported'></iframe>
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