@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FEC 48-Hour Contributions by Candidate | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FEC 48-Hour Contributions by Candidate
        <small class="sub block mt-sm">Campaign 2018</small>
    </h2>
    <iframe src='/ctb-legacy/fec_f6_by_candidate_total.php' width='100%' height='100%' class='ported'></iframe>
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