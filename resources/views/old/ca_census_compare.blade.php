@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'Compare CA Districts by Census Categories | California Target Book')

@section('content')

    <div class='container-fluid pt-lg' height='100%'>
        <h2>
            Compare Census Demographics by Legislative District
            <small class="sub block mt-sm">California</small>
        </h2>
        <iframe src='/ctb-legacy/census_nav2.php' width='100%' height='100%' class='ported '></iframe>
    </div>

@endsection


@section('scripts')


@endsection



@section('styles')

<style>

.ported  {
    height: 100vh;
}


</style>


@endsection