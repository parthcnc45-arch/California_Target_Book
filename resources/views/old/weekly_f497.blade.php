@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'Late Contributions Made/Received (Last 7 Days) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Late FPPC Contributions Made/Received
        <small class="sub block mt-sm">Last Seven Days</small>
    </h2>
    <iframe src='/ctb-legacy/weekly_f497.php' width='100%' height='100%' class='ported'></iframe>
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