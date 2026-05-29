@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'Full Election Report by District (2002 - Present) | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Full Election Report by District (2002 - Present)
        <small class="sub block mt-sm">2002 - Present</small>
    </h2>
    <iframe src='/ctb-legacy/rpt_nav.php' width='100%' height='100%' class='ported'></iframe>
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