
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'FPPC Legislator Ballot Measure Committees  | California Target Book')





@section('content')

<div class='container-fluid' height='100%' width='100%'>
    <iframe src='/ctb-legacy/getbmsrcomm.php' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.full_width {
	width: 100vw !important;
}

</style>


@endsection