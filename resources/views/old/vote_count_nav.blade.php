@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'Vote Count Over Time | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Vote Count Over Time (2018 Primary - Present)
        <small class="sub block mt-sm">2020 Cycle</small>
    </h2>
    <iframe src='/ctb-legacy/voteprogress_nav.php' width='100%' height='100%' class='ported'></iframe>
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