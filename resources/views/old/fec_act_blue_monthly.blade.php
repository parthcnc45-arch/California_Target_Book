
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'Federal ActBlue Filing Summaries | California Target Book')

@section('content')

<div class='container-fluid'>
    <iframe src='/ctb-legacy/actblue_fed_ca' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection

