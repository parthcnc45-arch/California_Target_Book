@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'View Organizational Ratings | California Target Book')

@section('content')


    <div class="container mt-5">
        <h1>View Organizational Ratings</h1>
        <div class="form-group">
            <label for="chamber">Select Chamber</label>
            <select class="form-control" id="chamber" onchange="loadOrganizations()">
                <option value="">Select Chamber</option>
                <option value="State Assembly">State Assembly</option>
                <option value="State Senate">State Senate</option>
                <option value="U.S. House">U.S. House</option>
                <option value="U.S. Senate">U.S. Senate</option>
            </select>
        </div>
        <div class="form-group" id="organizationDiv" style="display: none;">
            <label for="organization">Select Organization</label>
            <select class="form-control" id="organization" onchange="loadYears()">
                <option value="">Select Organization</option>
            </select>
        </div>
        <div class="form-group" id="yearDiv" style="display: none;">
            <label for="year">Select Year</label>
            <select class="form-control" id="year" onchange="loadRatings()">
                <option value="">Select Year</option>
            </select>
        </div>
        <div id="results" style="display: none;">
            <h2>Ratings</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Organization</th>
                        <th>State</th>
                        <th>Office</th>
                        <th>District</th>
                        <th>Legislator</th>
                        <th>Party</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody id="ratingsTable">
                </tbody>
            </table>
        </div>
    </div>


@endsection


@section('scripts')

<script>

function loadOrganizations() {
    const chamber = $('#chamber').val();
    if (chamber) {
        $.ajax({
            url: 'org_db.php',
            type: 'GET',
            data: { chamber: chamber },
            success: function(response) {
                const organizations = JSON.parse(response);
                let options = '<option value="">Select Organization</option>';
                organizations.forEach(org => {
                    options += `<option value="${org.org}">${org.org}</option>`;
                });
                $('#organization').html(options);
                $('#organizationDiv').show();
            }
        });
    } else {
        $('#organizationDiv').hide();
        $('#yearDiv').hide();
        $('#results').hide();
    }
}

function loadYears() {
    const chamber = $('#chamber').val();
    const organization = $('#organization').val();
    if (organization) {
        $.ajax({
            url: 'org_db.php',
            type: 'GET',
            data: { chamber: chamber, org: organization },
            success: function(response) {
                const years = JSON.parse(response);
                let options = '<option value="">Select Year</option>';
                years.forEach(year => {
                    options += `<option value="${year}">${year}</option>`;
                });
                $('#year').html(options);
                $('#yearDiv').show();
            }
        });
    } else {
        $('#yearDiv').hide();
        $('#results').hide();
    }
}

function loadRatings() {
    const chamber = $('#chamber').val();
    const organization = $('#organization').val();
    const year = $('#year').val();
    if (year) {
        $.ajax({
            url: 'org_db.php',
            type: 'GET',
            data: { chamber: chamber, org: organization, year: year },
            success: function(response) {
                const ratings = JSON.parse(response);
                let tableRows = '';
                ratings.forEach(rating => {
                    tableRows += `
                        <tr>
                            <td>${rating.year}</td>
                            <td>${rating.org}</td>
                            <td>${rating.state}</td>
                            <td>${rating.office}</td>
                            <td>${rating.district}</td>
                            <td>${rating.name}</td>
                            <td>${rating.party}</td>
                            <td>${rating.rating}</td>
                        </tr>
                    `;
                });
                $('#ratingsTable').html(tableRows);
                $('#results').show();
            }
        });
    } else {
        $('#results').hide();
    }
}


</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection