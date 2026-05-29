@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FPPC Major Donors | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FPPC Major Donors
    </h2>

	<p align='center'>BY YEAR<br>
		<a href='/ctb-legacy/fppc_major_donors.php?year=2023' target='lower'>2023</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2022' target='lower'>2022</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2021' target='lower'>2021</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2020' target='lower'>2020</a>
	</p>
	<p align='center'>

		<a href='/ctb-legacy/fppc_major_donors.php?year=2019' target='lower'>2019</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2018' target='lower'>2018</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2017' target='lower'>2017</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2016' target='lower'>2016</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2015' target='lower'>2015</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2014' target='lower'>2014</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2013' target='lower'>2013</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2012' target='lower'>2012</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2011' target='lower'>2011</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2010' target='lower'>2010</a>
	</p>
	<p align='center'>

		<a href='/ctb-legacy/fppc_major_donors.php?year=2009' target='lower'>2009</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2008' target='lower'>2008</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2007' target='lower'>2007</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2006' target='lower'>2006</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2005' target='lower'>2005</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2004' target='lower'>2004</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2003' target='lower'>2003</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2002' target='lower'>2002</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2001' target='lower'>2001</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fppc_major_donors.php?year=2000' target='lower'>2000</a>
	</p>

    <iframe name='lower' src='/ctb-legacy/fppc_major_donors.php?year=2023' target='lower' width='100%' height='100%' class='ported'></iframe>
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