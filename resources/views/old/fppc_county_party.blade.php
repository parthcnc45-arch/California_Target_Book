
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'FPPC County Party Committees  | California Target Book')





@section('content')

<div class='container-fluid'>
    <iframe src='/ctb-legacy/getallcounty_22?since=2022-06-30' width='100%' height='100%' class='ported'></iframe>
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