
<ctb-head-nav inline-template>
    <div class="nav-container">

        <nav class="navbar navbar-inverse navbar-fixed-top no-select" role="navigation">
            @if(Auth::check() && Auth::user()->isAdmin())
                <div class="admin-nav hidden-xs">
                    <div class="container">
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

            @if(Session::get('message'))
                <div class="notice visible">
                    {{ Session::get('message') }}
                    <i class="fa fa-times close-notice"></i>
                </div>
            @endif


            <div class="main-nav">
                <div class="container">
                    <div class="navbar-header">
                        <a href="https://ctb.epicenterconsulting.net/" class="navbar-right">
                            <img class="pull-left" src="/img/ctb_logo.png" height='72'>
                            <h3>
                                <span><b>C</b>alifornia</span> <br/>
                                Target Book
                            </h3>
                        </a>
                        <button type="button" class="navbar-toggle collapsed"
                                @click="navCollapsed = !navCollapsed" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="nav-bg-overlay hidden"
                            :class="{'visible-xs': !navCollapsed}"
                            @click="navCollapsed = true">
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->

                    <div class="hidden-xs "  align='center'>
                        <div class="navbar-right">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="{{ route('home') }}">Home</a>
                                </li>

                                <li class="book">
                                    <a href="/book">
                                        Book
                                    </a>
                                </li>


                                <li>
                                    <a href='/editors'>About
                                        <b class="caret"></b>
                                    </a>
                                    <ul class='dropdown-menu'>
                                        <li>
                                            <a href='/editors'>About Us</a>
                                        </li>
                                        <li>
                                            <a href='/subscriber_list'>Partial List of Subscribers</a>
                                        </li>

                                        <li>
                                            <a href="#">Sample Pages
                                                <b class='caret'></b>
                                            </a>

                                            <ul class='dropdown-menu'>
                                                <li>
                                                    <a href='/sample_assembly'>Sample Assembly Page</a>
                                                </li>
                                                <li>
                                                    <a href='/sample_senate'>Sample State Senate Page</a>
                                                </li>
                                                <li>
                                                    <a href='/sample_congress'>Sample Congressional Page</a>
                                                </li>
                                                <li>
                                                    <a href='/sample_county_page'>Sample County Page</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                @auth
                                    <li>
                                        <a class="dropdown-toggle profile-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <div class="icon i-3 pull-left">
                                                @inline('/img/icons/profile.svg')
                                            </div>
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="profile-overview">
                                                <p>
                                            <span class="red">
                                                {{ @Auth::user()->first_name }}
                                                {{ @Auth::user()->last_name }}
                                            </span>
                                                    <br/>
                                                    <span class="gray"><?= @Auth::user()->email ?></span>
                                                </p>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="/account">Account</a>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="/logout">Logout</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endauth

                                @guest
                                    <li>
                                        <a href="{{ route('login') }}">Login</a>
                                    </li>
                                    <li>
                                        <a class="btn btn-primary btn-sm register-btn" href="{{ route('register') }}">Subscribe</a>
                                    </li>
                                @endguest

                            </ul>

                            {{--<div class="feedback-wrapper">--}}
                            {{--<a class="feedback" target="_blank" href="http://www.californiatargetbook.com/">--}}
                            {{--<i class="fa fa-info-circle mr-sm"></i>--}}
                            {{--<span>Visit The Old Site</span>--}}
                            {{--</a>--}}
                            {{--<a class="feedback" @click="showFeedbackModal = true">--}}
                            {{--<i class="fa fa-bullhorn mr-sm"></i>--}}
                            {{--<span>Give Us Feedback</span>--}}
                            {{--</a>--}}
                            {{--<feedback-modal v-if="showFeedbackModal"--}}
                            {{--@close="showFeedbackModal = false">--}}
                            {{--</feedback-modal>--}}
                            {{--</div>--}}
                        </div>

                    </div>


                    <div class="mobile-nav collapse navbar-collapse navbar-right hidden visible-xs" :class="{in: !navCollapsed}" id="navbar">
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
                                                {{ @Auth::user()->first_name }}
                                                {{ @Auth::user()->last_name }}
                                            </span>
                                            <br/>
                                            <small class="gray">{{@Auth::user()->email}}</small>
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
            </div>
        </nav>
    </div>

</ctb-head-nav>
