
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('voterRegistration')">
        Voter Registration Trends
        <div v-show="subMenus.stats !== 'voterRegistration'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.stats === 'voterRegistration'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.stats === 'voterRegistration'" class="dropdown-menu">
	<li>
		<h6>Voter Registration Trends</h6>
	</li>

        <li>
            <a href="/book/compare_past_legislative_registration">
                By District (2012 - Present) - Summary
            </a>
        </li>

        <li>
            <a href="/book/compare_past_legislative_registration_detailed">
                By District (2012 - Present) - Detail
            </a>
        </li>


        <li>
            <a href="/book/compare_past_city_registration">
                By City/County Subdivisions (2008 - Present)
            </a>
        </li>

	<li>
	    <a href='/book/past_county'>
		1948-Present County Voter Registration
	    </a>
	</li>


	<li>
		<h6>Current Registration & Past Results</h6>
	</li>
	<li>
	    <a href='/book/city_and_county_past_all'>
		All Cities/County Subdivisions
	    </a>
	</li>
	<li>
	    <a href='/book/city_past_all'>
		All Cities (Summary)
	    </a>
	</li>

	<li>
	    <a href='/book/county_past_all'>
		All Counties
	    </a>
	</li>


	<li>
		<h6>City-Level Voter Registration Trends</h1>
	</li>

	<li>
	    <a href='/book/cityreg_past_all'>
		November 2012 - Present
	    </a>
	</li>
    </ul>
</li>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
            @click="setSubMenu('census')">
        US Census Data
        <div v-show="subMenus.stats !== 'census'" class="material-icons pull-right">expand_more</div>
        <div v-show="subMenus.stats === 'census'" class="material-icons pull-right">expand_less</div>
    </a>
    <ul v-show="subMenus.stats === 'census'" class="dropdown-menu">
	<li>
	    <a href="/book/pl94_2020">
		2020 U.S. Census Summary Data
	    </a>
        <li>


	<li>
	    <a href="/book/ca_census_trends">
		U.S. Census Data Trends by Location (2012 - 2018)
	    </a>
        <li>
            <a href="/book/ca_census_compare">
                By CA Legislative District
            </a>
        </li>
        <li>
            <a href="/book/us_census_compare">
                By US Congressional District
            </a>
        </li>
    </ul>
</li>

