@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2022 General Election - Federal Candidate Summary | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2022 General Election - Federal Candidate Summary
        <small class="sub block mt-sm">All States</small>
    </h2>
    <iframe src='/ctb-legacy/fec_g22_summary_w_actblue_condensed.php' width='100%' height='100%' class='ported'></iframe>
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