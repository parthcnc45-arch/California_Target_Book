
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA Campaign 2020 Finance Summary | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Legislative/Congressional Candidates Campaign Finance Summaries
        <small class="sub block mt-sm">2020 Election</small>
    </h2>
    <iframe src='/ctb-legacy/e20_finance_summary_v2.php' width='100%' height='100%' class='ported'></iframe>
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