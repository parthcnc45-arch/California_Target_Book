
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'FEC Filings - All | California Target Book')

@section('content')

<div class='container-fluid'>
  <iframe src="http://198.74.49.22/fec_rss.php" width="1280px" height="1280px"></iframe>
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