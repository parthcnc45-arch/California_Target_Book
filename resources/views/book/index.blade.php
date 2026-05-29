@extends('layouts.bookNew')

@section('title', 'Online Target Book | California Target Book')

@section('bodyClasses', 'main-bg-gray')

@section('content')
        <div class="row">
            <div class="col-md-12 center-block fn">
                <header class="row">
                    @if (!empty($currentPoll))
                        <div class="col-md-12">
                            <div class="ctb-banner">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="upper">Target Book Insider Poll {{ $currentPoll->dateDisplay() }}</h5>
                                        <h3>{{ $currentPoll->title }}</h3>
                                        <p class="mb-n">
                                            See what other Target Book Subscribers think on current issues.
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="{{ route('book.current-poll') }}"
                                                class="btn btn-primary">
                                            Take The Poll
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="col-md-12">
                        <h1 class="text-center mb-lg">The California Target Book</h1>
                    </div> --}}

                </header>

                 <!-- Main Dashboard Container Start -->
                <section class="main-dashboard-box">
                    <div class="container">
                        <div class="row d-flex">
                            <div class="col-md-12">
                                <h2>California Target Book</h2>
                            </div>
                            <div class="row mx-3 d-flex">
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a href="/book" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/districts.svg" alt="kharkulla" />
                                            <div class="ctx-content mt-3">
                                                <h3>Home</h3>
                                                <p>Index page.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a href="{{ route('book.hotsheet') }}" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/icons/hotsheet.svg" alt="kharkulla" />
                                            <div class="ctx-content mt-3">
                                                <h3>Hot Sheets</h3>
                                                <p>Reporting and analysis of the late breaking California political developments.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                              
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('district')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/icons/california.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Districts</h3>
                                                <p>District-by-district coverage of California's Assembly, State Senate and Congressional seats.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('propositions')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/propositions.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Propositions</h3>
                                                <p>In-depth coverage of qualified and pending ballot initiatives, analysis, results by county and districts, finance summaries for committees supporting or opposing, archived advertisements.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a href="/book/e24_roster" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/candidates.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Candidates</h3>
                                                <p>Candidate directories by election cycle with separate entries for federal and state incumbents.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('finance')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/finance.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Finance</h3>
                                                <p>Finance reports for candidates and independent expenditure committees at both the state and federal levels.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('maps')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/maps.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Maps</h3>
                                                <p>Current and past district maps, lookup tools, overlapping districts, and interactive map viewers.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('elections')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/elections.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Elections</h3>
                                                <p>Local, County, and State election results by district or geographic area, archived statement of vote reports from 1912- present.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('stats')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/census-data.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Voter / Census Data</h3>
                                                <p>Voter registration statistics and census data.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a href="/book/dashboard" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/dashboard.svg" alt="kharkulla" />
                                            <div class="ctx-content mt-3">
                                                <h3>Dashboard</h3>
                                                <p>Recent campaign contributions, independent expenditures, propositions, open seat tracker, upcoming calendar of key election dates.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="card col-lg-3 col-md-4 mx-3">
                                    <a @click="openBookNav('search')" class="text-decoration-none fst-normal">
                                        <div class="ctb-content-box">
                                            <img src="img/search.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Search</h3>
                                                <p>Hot Sheets, district analysis, and candidate bio keyword search; FEC / FPPC multi-search (contributors, expenditures, committees, candidates).</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                {{-- <div class="col-lg-3 col-md-4">
                                    <a href="{{ route('old.new_districts') }}" class="text-decoration-none fst-normal" >
                                        <div class="ctb-content-box">
                                            <img src="img/redistricting.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Redistricting</h3>
                                                <p>District-by-district coverage of California's Assembly, State Senate and Congressional coverage of California's  seats.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3  col-md-4">
                                    <a href='/book/newsom_recall' class="text-decoration-none fst-normal" >
                                        <div class="ctb-content-box">
                                            <img src="img/recalls.svg" alt="" />
                                            <div class="ctx-content mt-3">
                                                <h3>Recalls</h3>
                                                <p>District-by-district coverage of California's Assembly, State Senate and Congressional coverage of California's  seats.</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>                                --}}
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    

@endsection

