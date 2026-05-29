@extends('layouts.book')
@php ($book_side_nav_active = 'maps')

@section('title', 'Final Maps Interactive Viewer | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Final Maps Interactive Viewer
    </h2>
    <iframe src='/ctb-legacy/draft_map_viewer_1220.php' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection



@section('scripts')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@endsection


 
  

@section('styles')

<style>

   <link href="https://catargetbook.com/css/app.css" rel="stylesheet">


.ported {
    height: 100vh;
}

</style>


@endsection