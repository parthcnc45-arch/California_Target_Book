@extends('layouts.master')

@section('title', 'US House 2018 Targeted Races - Candidates Filed/Past Results | California Target Book')





@section('content')

<div class='container full_width' height='100%' width='100vw'>
  <iframe src="http://198.74.49.22/targets_candidates.php" width="1024px" height="1280px"></iframe>
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