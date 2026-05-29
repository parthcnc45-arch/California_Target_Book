@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FPPC IE Reports | California Target Book')


@section('content')

<div class="container mt-5">
  <h1>State IE Reports</h1>
  <form id="reportForm">
    <div class="mb-3">
      <label class="form-label">Choose Option:</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="option" value="election" id="electionRadio">
        <label class="form-check-label" for="electionRadio">Election</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="option" value="cycle" id="cycleRadio">
        <label class="form-check-label" for="cycleRadio">Cycle</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="option" value="date" id="dateRadio">
        <label class="form-check-label" for="dateRadio">Date Range</label>
      </div>
    </div>
    
    <div id="electionDropdown" class="mb-3 d-none">
      <label class="form-label">Election Type:</label>
      <select class="form-select" id="electionType">
        <?php 
		$endjava = [];
        	for ($year = 2012; $year <= 2024; $year += 2) { 
        		$short_year = mb_substr($year, 2, 2);
        		echo("<option value='p$short_year'>$year Primary Election</option>
        			  <option value='g$short_year'>$year General Election</option>");
        	}
        ?>
      </select>
    </div>
    
    <div id="cycleDropdown" class="mb-3 d-none">
      <label class="form-label">Select Year:</label>
      <select class="form-select" id="cycleYear">
        <?php for ($year = 2012; $year <= 2024; $year += 2) { ?>
          <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php } ?>
      </select>
    </div>
    
    <div id="dateRangeInputs" class="mb-3 d-none">
      <label class="form-label">Start Date:</label>
      <input type="date" class="form-control" id="startDate">
      <label class="form-label mt-3">End Date:</label>
      <input type="date" class="form-control" id="endDate">
    </div>
    
    <button type="button" class="btn btn-primary" id="generateReportBtn">Generate Report</button>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel">Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="reportFrame" src=""></iframe>
      </div>
    </div>
  </div>
</div>


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    foreach($endjava as $value) {
        echo($value);
    }

?>

</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const electionDropdown = document.getElementById('electionDropdown');
    const cycleDropdown = document.getElementById('cycleDropdown');
    const dateRangeInputs = document.getElementById('dateRangeInputs');

    const reportForm = document.getElementById('reportForm');
    const generateReportBtn = document.getElementById('generateReportBtn');
    const reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
    const reportFrame = document.getElementById('reportFrame');

    reportForm.addEventListener('change', function () {
      if (document.getElementById('electionRadio').checked) {
        electionDropdown.classList.remove('d-none');
        cycleDropdown.classList.add('d-none');
        dateRangeInputs.classList.add('d-none');
      } else if (document.getElementById('cycleRadio').checked) {
        electionDropdown.classList.add('d-none');
        cycleDropdown.classList.remove('d-none');
        dateRangeInputs.classList.add('d-none');
      } else if (document.getElementById('dateRadio').checked) {
        electionDropdown.classList.add('d-none');
        cycleDropdown.classList.add('d-none');
        dateRangeInputs.classList.remove('d-none');
      }
    });

    generateReportBtn.addEventListener('click', function () {
      let url = 'https://californiatargetbook.com/ctb-legacy/ielist_multi.php';
      if (document.getElementById('electionRadio').checked) {
        const electionType = document.getElementById('electionType').value;
        url += `?election=${electionType}${document.getElementById('cycleYear').value}`;
      } else if (document.getElementById('cycleRadio').checked) {
        url += `?cycle=${document.getElementById('cycleYear').value}`;
      } else if (document.getElementById('dateRadio').checked) {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        url += `?start=${startDate}&end=${endDate}`;
      }
      reportFrame.src = url;
      reportModal.show();
    });

    reportModal.addEventListener('shown.bs.modal', function () {
      const modalBodyHeight = reportModal.querySelector('.modal-body').offsetHeight;
      reportFrame.style.height = `${modalBodyHeight}px`;
      console.log(reportFrame.style.height);
    });
  });
</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}


</style>


@endsection