
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA Campaign 2022 Finance Summary | California Target Book')

@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        CA Legislative/Congressional Candidates Campaign Finance Summaries
        <small class="sub block mt-sm">2022 Election</small>
    </h2>
    <iframe src='/ctb-legacy/e22_finance_summary.php' width='100%' height='100%' class='ported'></iframe>
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