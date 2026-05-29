<?php

global $endjava, $cmte_id, $hdr;
$endjava = Array();
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;


?>



@php ($book_side_nav_active = 'finance')

@extends('layouts.book')

@section('title', 'FPPC Independent Expenditures | California Target Book')

@section('content')



<div class="container mt-5">
  <h1>FPPC Independent Expenditures (by Election / Cycle / Date Range)</h1>
  <form id="reportForm">
    <div class="mb-3">
      <label class="control-label">Choose Option:</label>
      <div class="radio">
        <label><input type="radio" name="option" value="election" id="electionRadio">Election</label>
      </div>
      <div class="radio">
        <label><input type="radio" name="option" value="cycle" id="cycleRadio">Cycle</label>
      </div>
      <div class="radio">
        <label><input type="radio" name="option" value="date" id="dateRadio">Date Range</label>
      </div>
    </div>    
    <div id="electionDropdown" class="mb-3 d-none">
      <label class="controllabel">Election Type:</label>
      <select class="form-scontrol" id="electionType">
        <?php 
        	for ($year = 2012; $year <= 2024; $year += 2) { 
        		$short_year = mb_substr($year, 2, 2);
        		echo("<option value='p$short_year'>$year Primary Election</option>
        			  <option value='g$short_year'>$year General Election</option>");
        	}
        ?>
      </select>
    </div>
    
    <div id="cycleDropdown" class="mb-3 d-none">
      <label class="control-label">Select Year:</label>
      <select class="form-control" id="cycleYear">
        <?php for ($year = 2012; $year <= 2024; $year += 2) { ?>
          <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php } ?>
      </select>
    </div>
    
    <div id="dateRangeInputs" class="mb-3 d-none">
      <label class="control-label">Start Date:</label>
      <input type="date" class="form-control" id="startDate">
      <label class="control-label mt-3">End Date:</label>
      <input type="date" class="form-control" id="endDate">
    </div>
    
    <button type="button" class="btn btn-primary" id="generateReportBtn">Generate Report</button>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="reportModalLabel">Report</h4>
      </div>
      <div class="modal-body">
        <iframe id="reportFrame" src="/ctb-legacy/loading_spinner.php"></iframe>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')


<script>
  $(document).ready(function () {
    $('#electionDropdown, #cycleDropdown, #dateRangeInputs').addClass('hidden');

    $('#reportForm input[type="radio"]').change(function () {
      if ($('#electionRadio').is(':checked')) {
        $('#electionDropdown').removeClass('hidden');
        $('#cycleDropdown, #dateRangeInputs').addClass('hidden');
      } else if ($('#cycleRadio').is(':checked')) {
        $('#cycleDropdown').removeClass('hidden');
        $('#electionDropdown, #dateRangeInputs').addClass('hidden');
      } else if ($('#dateRadio').is(':checked')) {
        $('#dateRangeInputs').removeClass('hidden');
        $('#electionDropdown, #cycleDropdown').addClass('hidden');
      }
    });

    $('#generateReportBtn').click(function () {
      var url = 'https://californiatargetbook.com/ctb-legacy/ielist_multi.php';
      if ($('#electionRadio').is(':checked')) {
        var electionType = $('#electionType').val();
        url += '?election=' + electionType + $('#cycleYear').val();
      } else if ($('#cycleRadio').is(':checked')) {
        url += '?cycle=' + $('#cycleYear').val();
      } else if ($('#dateRadio').is(':checked')) {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        url += '?start=' + startDate + '&end=' + endDate;
      }
      $('#reportFrame').attr('src', url);
      $('#reportModal').modal('show');
    });

    $('#reportModal').on('shown.bs.modal', function () {
      var modalBodyHeight = $('.modal-body').height();
      $('#reportFrame').css('height', modalBodyHeight);
    });


    $('#reportModal').on('hidden.bs.modal', function () {
      $('#reportFrame').attr('src', '/ctb-legacy/loading_spinner.php');
    });
  });
</script>

@endsection

@section('styles')

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.css"/>


  <style>
    .modal-dialog {
      max-width: 90vw;
      min-width: 90vw;
      max-height: 90vh;
      min-height: 90vh;
    }

    #reportFrame {
      width: 100%;
      height: 100%;
      min-height: 800px;
      border: none;
    }    
  </style>

@endsection


