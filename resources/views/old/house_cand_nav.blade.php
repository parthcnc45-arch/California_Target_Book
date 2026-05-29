
@extends('layouts.book')
@php ($book_side_nav_active = 'candidates')

@section('title', 'Candidate Directory - FEC 2006-2018')

@section('content')

    <ctb-house-cand-directory inline-template>
        <div>
            <div class="book-page-head row m-n">
                <h2>Candidate Directory - FEC 2006-2018</h2>
            </div>

            <div class='container-fluid pt-lg'>

                <div class="form-group">
                    <h4>Election</h4>
                    <div class="radio-tabs" v-ctb-radio-tabs>
                        <label for="e2018" class="active">
                            <input id="e2018" v-model="year" type='radio' name='election' :value='2018' checked>
                            2018
                        </label>
                        <label for="e2016">
                            <input id="e2016" v-model="year" type='radio' name='election' :value='2016'>
                            2016
                        </label>
                        <label for="e2014">
                            <input id="e2014" v-model="year" type='radio' name='election' :value='2014'>
                            2014
                        </label>
                        <label for="e2012">
                            <input id="e2012" v-model="year" type='radio' name='election' :value='2012'>
                            2012
                        </label>
                        <label for="e2010">
                            <input id="e2010" v-model="year" type='radio' name='election' :value='2010'>
                            2010
                        </label>
                        <label for="e2008">
                            <input id="e2008" v-model="year" type='radio' name='election' :value='2008'>
                            2008
                        </label>
                        <label for="e2006">
                            <input id="e2006" v-model="year" type='radio' name='election' :value='2006'>
                            2006
                        </label>
                    </div>

                    <div class="row mt-md">
                        <div class="form-group col-sm-6 col-md-4 col-lg-3">
                            <input type="text"
                                    v-model="query"
                                    ref="candidateSearch"
                                    name="search"
                                    placeholder="Search..."
                                    class="form-control" />
                        </div>
                        <div class="col-xs-2">
                            <ctb-loader v-if="isLoading"></ctb-loader>
                        </div>
                    </div>
                </div>

                <div class="row mt-md">
                    <table class="table table-striped col-xs-12" v-ctb-table="tableSettings">
                        <thead>
                        <tr>
                            <th>Candidate</th>
                            <th>Party</th>
                            <th>Race</th>
                            <th>Role</th>
                            <th>Addr</th>
                            <th>Raised</th>
                            <th>Spent</th>
                            <th>FEC Candidate ID</th>
                            <th>FEC Committee ID</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>



        </div>
    </ctb-house-cand-directory>


@endsection


@section('scripts')
    <script>gtag('set', { 'book_category': 'candidates' });</script>
@endsection
