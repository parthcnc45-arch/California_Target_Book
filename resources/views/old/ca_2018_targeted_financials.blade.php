@extends('layouts.master')

@section('title', 'CA 2018 Targeted Races Financials | California Target Book')





@section('content')

<div class='container full_width' height='100%' width='100vw'>
  <iframe src="http://198.74.49.22/getall18_targeted.php" width="1280px" height="1280px"></iframe>
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