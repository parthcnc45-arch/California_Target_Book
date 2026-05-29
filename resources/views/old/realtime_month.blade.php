
@php ($book_side_nav_active = 'finance')

@extends('layouts.book')

@section('title', 'FPPC / FEC Live Filings | California Target Book')

@section('content')
    <div class="container-fluid">
        <iframe src='/ctb-legacy/fec_fppc_live.php' width='100%' height='1280px'></iframe>
    </div>
@endsection


