@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', '{{id}} Viz Election Report | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        {{$id}} 12/08 Map Election Report
    </h2>
    <iframe src='/ctb-legacy/block_results_v5.php?id={{$id}}' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


@section('scripts')


@endsection


 
  

@section('styles')

<style>

   <link href="https://catargetbook.com/css/app.css" rel="stylesheet">


.ported {
    height: 100vh;
}

</style>


@endsection