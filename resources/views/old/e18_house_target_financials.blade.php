@extends('layouts.master')

@section('title', 'Candidates/Campaign Finance Totals in 2018 Open/Targeted US House Races | California Target Book')





@section('content')

<div class='container' height='100%'>
    <p align='center'>Candidates/Campaign Finance Totals in 2018 Open/Targeted US House Races</p>
    <iframe src='/ctb-legacy/e18_house_target_financials.php' width='100%' height='100%' class='ported'></iframe>
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