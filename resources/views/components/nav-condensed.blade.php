{{-- <ctb-head-nav inline-template>
    <div class="nav-container">
        @if (Auth::check() && Auth::user()->isAdmin())
            <div class="admin-nav hidden-xs">
                <div class="container-fluid">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <i class="material-icons" aria-hidden="true">lock</i>
                            <span class="hidden-xs">California Target Book Admin</span>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right m-n">
                        <li>
                            <a href="/ctb-admin">Go To Admin Dashboard</a>
                        </li>
                    </ul>
                </div>

            </div>
        @endif

        @if (Session::get('message'))
            <div class="notice visible">
                {{ Session::get('message') }}
                <i class="fa fa-times close-notice"></i>
            </div>
        @endif


            <nav class="navbar navbar-static-top navbar-condensed" role="navigation">

                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="navbar-left">
                            <a href="/" class="brand">
                                <img class="pull-left" src="/img/ctb_logo.png" height="46">
                                <h3>
                                    <span><b>C</b>alifornia</span> Target Book
                                </h3>
                            </a>

                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                                    @click="navCollapsed = !navCollapsed" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                        </div>
                    </div>

                    @if (Session::has('trial_end'))
                    <div class="trial-alert">
                        <div class="alert alert-warning">
                            <i class="material-icons mr-sm">warning</i>
                            Your trial period ends on {{ Session::get('trial_end') }}.
                            <a href="{{ route('auth.account.renew') }}">Click here</a>
                            to renew.
                        </div>
                    </div>
                    @elseif(Session::has('cycle_end'))
                        <div class="trial-alert">
                            <div class="alert alert-warning">
                                <i class="material-icons mr-sm">warning</i>
                                Your subscription ends on {{ Session::get('cycle_end') }}.
                                <a href="{{ route('auth.account.renew') }}">Click here</a>
                                to renew.
                            </div>
                        </div>
                    @endif

                    <div class="nav-bg-overlay hidden"
                            :class="{'visible-xs': !navCollapsed}"
                            @click="navCollapsed = true">
                    </div>

                    <div class="collapse navbar-collapse navbar-right" :class="{in: !navCollapsed}" align='center' id="navbar">
                        <ul class="nav navbar-nav" data-sm-options="{noMouseOver: true}">
                            <li>
                                <a class="hidden visible-xs" href="/ctb-admin">
                                    <div class="nav-icon">
                                        <i class="material-icons">lock</i>
                                    </div>
                                    <div>Go To Admin Dashboard</div>
                                </a>
                            </li>
                            <li>
                                <a class="ctb-tooltip-container" href="{{ route('home') }}">
                                    <div class="nav-icon">
                                        <i class="material-icons">home</i>
                                    </div>
                                    <div class="ctb-tooltip hidden-xs">Home</div>
                                    <div class="hidden visible-xs">Home</div>
                                </a>
                            </li>

                            <li>
                                <a class="ctb-tooltip-container" href="/book">
                                    <div class="nav-icon">
                                        <i class="material-icons">book</i>
                                    </div>
                                    <div class="ctb-tooltip hidden-xs">Target Book</div>
                                    <div class="hidden visible-xs">Target Book</div>
                                </a>
                            </li>

                            <li>
                                <a class="ctb-tooltip-container" @click="showFeedbackModal = true">
                                    <div class="nav-icon">
                                        <i class="material-icons">feedback</i>
                                    </div>
                                    <div class="ctb-tooltip hidden-xs"> Give Us Feedback </div>
                                    <div class="hidden visible-xs">Give Us Feedback</div>
                                </a>
                                <feedback-modal v-if="showFeedbackModal" @close="showFeedbackModal = false"></feedback-modal>
                            </li>


                            <li class="dropdown">
                                <a class="ctb-tooltip-container dropdown-toggle" data-toggle="dropdown">
                                    <div class="nav-icon">
                                        <i class="material-icons">more_vert</i>
                                    </div>

                                    <div class="ctb-tooltip hidden-xs"> More </div>
                                    <div class="hidden visible-xs">
                                        More
                                        <div class="caret pull-right mt-n"></div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu ctb-dropdown-menu">
                                    <li>
                                        <a href='/editors'>About Us</a>
                                    </li>
                                    <li>
                                        <a href='/subscriber_list'>Partial List of Subscribers</a>
                                    </li>
                                </ul>
                            </li>


                            <li class="dropdown account">
                                <a class="ctb-tooltip-container dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                        aria-haspopup="true" aria-expanded="false">
                                    <div class="nav-icon">
                                        <i class="material-icons">account_circle</i>
                                    </div>

                                    <div class="ctb-tooltip hidden-xs"> Account </div>
                                    <div class="hidden visible-xs">
                                        Account
                                        <div class="caret pull-right mt-n"></div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu ctb-dropdown-menu">
                                    <li class="profile-overview">
                                        <a href="/account">
                                        <span class="red">
                                            {{ Auth::user()->first_name }}
                                            {{ Auth::user()->last_name }}
                                        </span>
                                            <br/>
                                            <small class="gray">{{Auth::user()->email}}</small>
                                        </a>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>


                    </div>

                </div>
            </nav>
    </div>



</ctb-head-nav> --}}

<section class="dashboard-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar">
                    <div class="container-fluid">
                        <a href="{{ route('home') }}" class="navbar-brand">
                            <img src="{{ url('img/logo.svg') }}" alt="Logo" class="d-inline" />
                            <h3 class="d-inline logo-txt"><span style="color: #D00B0B;">California</span> <span
                                    style="color: #174F7F;"> Target Book</span></h3>
                        </a>
                        <div class="d-flex gap-4 align-items-center" role="search">
                            {{-- <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <buttclass= class="btn btn-outline-success" type="submit">Search</buttclass="img-fluid"on> --> --}}
                            <img src="{{ url('img/notification.png') }}" class="img-fluid" alt="Notification Icon"
                                style="width: 20px; height: 20px;" />
                            {{-- <img src="img/profile-img.png" alt="Profile Image" /> --}}
                            <div class="btn-group">
                                <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  {{-- <img src="img/profile-img.png" alt="Profile Image" /> --}}
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="/account"><span class="red">  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                        </span> <br> <small class="gray">{{Auth::user()->email}}</small></a>
                                    </li>
                                  <li role="separator" class="divider"></li>
                                  <li><a class="dropdown-item" href="/logout">Logout</a></li>
                                </ul>
                              </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>
