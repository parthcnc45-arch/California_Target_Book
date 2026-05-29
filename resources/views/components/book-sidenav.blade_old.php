
<ctb-book-side-nav inline-template
        ref="bookSideNav"
    current="<?php  
		ini_set('memory_limit', '2048M');
		if(!empty($book_side_nav_active)) {
			echo($book_side_nav_active);
		}
	    ?>
	   ">

    <aside class="side-nav">

        <nav class="navbar" id="book-chapters">
            <ul>
                <li>
                    <a href="{{ route('book.hotsheet') }}"
                        :class="{'active': current === 'hotsheet'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/hotsheet.svg') </div>
                        <span>Hot Sheet</span>
                    </a>
                </li>
                <li>
                    <a @click="setNav('district')"
                        :class="{'active': current === 'district'}">
                        <div class="icon i-2 i-red">@inline('/img/icons/gov.svg')</div>
                        <span>Districts</span>
                    </a>
                </li>

                <li>
                    <a @click="setNav('propositions')" :class="{'active': current === 'propositions'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/proposition.svg') </div>
                        <span>Propositions</span>
                    </a>
                </li>

                <li>
                    <a @click="setNav('candidates')" :class="{'active': current === 'candidates'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/candidate.svg') </div>
                        <span>Candidates</span> 
                    </a>
                </li>

                <li>

                    <a @click="setNav('stats')" :class="{'active': current === 'stats'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/census.svg') </div>
                        <span>Census Data</span>
                    </a>
                </li>

                <li>
                    <a @click="setNav('finance')" :class="{'active': current === 'finance'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/finance2.svg') </div>
                        <span>Finance</span>
                    </a>
                </li>
                <li>
                    <a @click="setNav('maps')" :class="{'active': current === 'maps'}">
                        <div class="icon i-2 i-red"> @inline('/img/icons/map.svg') </div>
                        <span>Maps</span>
                    </a>
                </li>
                <li>
                    <a @click="setNav('elections')" :class="{'active': current === 'elections'}">
                        <div class="icon i-2 i-red">@inline('/img/icons/election.svg')</div>
                        <span>Elections</span>
                    </a>
                </li>

                <li>
                    <a @click="setNav('redist')" :class="{'active': current === 'redist'}">
                        <div class="icon i-2 i-red">@inline('/img/icons/california.svg')</div>
                        <span>Redistricting</span>
                    </a>
                </li>

            </ul>

            <ul class="book-nav-extras hidden-xs navbar-nav hidden" :class="{visible: showExtras}" data-sm-options="{noMouseOver: true}">

                <li class="dropdown hidden-xs">
                    <a href="#" class="close-nav-icon dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">settings</i>
                    </a>
                    <ul class="dropdown-menu ctb-dropdown-menu settings-popup-menu">
                        <li>
                            <h5 class="upper text-red m-n">Settings</h5>
                        </li>
                        <li class="separator"></li>
                        <li>
                            <label>
                                <input type="checkbox" name="verbose_mode" v-model="verboseMode" />
                                Districts Verbose Mode
                            </label>
                        </li>
                    </ul>
                </li>

                <li class="hidden-xs">
                    <a href="#" v-if="showNav" @click="showNav = false">
                        <i class="material-icons">first_page</i>
                    </a>
                    <a href="#" v-if="!showNav" @click="showNav = true">
                        <i class="material-icons">last_page</i>
                    </a>
                </li>
            </ul>
        </nav>

        <div id="section-nav" :class="{ 'verbose-mode': verboseMode }">

            <ul class="mobile-options hidden visible-xs" data-sm-options="{noMouseOver: true}">
                <li>
                    <a @click="showNav = false"
                            id="mobile-close-nav"
                            class="hidden visible-xs">
                        <i class="material-icons">close</i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="close-nav-icon dropdown-toggle" data-toggle="dropdown">
                        <i class="material-icons">settings</i>
                    </a>
                    <ul class="dropdown-menu ctb-dropdown-menu settings-popup-menu">
                        <li>
                            <h5 class="upper text-red m-n">Settings</h5>
                        </li>
                        <li class="separator"></li>
                        <li>
                            <label>
                                <input type="checkbox" name="verbose_mode" v-model="verboseMode" />
                                Districts Verbose Mode
                            </label>
                        </li>
                    </ul>
                </li>
            </ul>

            <section id="district-nav"
                    :class="{'visible': show('district')}">

                <div class="section-head">
                    <h2>Districts</h2>
                </div>

                <ul>
                    @include('components.nav.dist_nav')
                </ul>

            </section>
            <section id="propositions-nav"
                    :class="{'visible': show('propositions')}">

                <div class="section-head">
                   <h2>Propositions</h2>
                </div>

                <ul>
                    @include('components.nav.prop_nav')
                </ul>
            </section>

            <section id="candidates-nav"
                    :class="{'visible': show('candidates')}">

                <div class="section-head">
                    <h2>Candidates</h2>
                </div>

                <ul>
                    @include('components.nav.candidates')
                </ul>
            </section>

            <section id="stats-nav"
                    :class="{'visible': show('stats')}">

                <div class="section-head">
                    <h2>Stats</h2>
                </div>

                <ul>
                    @include('components.nav.stats')
                </ul>
            </section>

            <section id="finance-nav"
                    :class="{'visible': show('finance')}">

                <div class="section-head">
                    <h2>Finance</h2>
                </div>

                <ul>
                    @include('components.nav.finance')
                </ul>
            </section>

            <section id="maps-nav"
                    :class="{'visible': show('maps')}">

                <div class="section-head">
                    <h2>Maps</h2>
                </div>

                <ul>
                    @include('components.nav.maps')
                </ul>
            </section>

            <section id="elections-nav"
                    :class="{'visible': show('elections')}">

                <div class="section-head">
                    <h2>Elections</h2>
                </div>

                <ul>
                    @include('components.nav.elections')
                </ul>
            </section>

            <section id="redist-nav"
                    :class="{'visible': show('redist')}">

                <div class="section-head">
                    <h2>Redistricting</h2>
                </div>

                <ul>
                    @include('components.nav.redist')
                </ul>
            </section>


        </div>

    </aside>

</ctb-book-side-nav>