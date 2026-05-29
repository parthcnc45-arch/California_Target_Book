@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FPPC Top Lobbying Payments by Year | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FPPC Top Lobbying Payments by Year
        <small class="sub block mt-sm">2000 - Present</small>
    </h2>
    <iframe src='/ctb-legacy/fppc_lobby_pay_nav.php' width='100%' height='100%' class='ported'></iframe>
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